<?php

namespace PluginizeLab\OakFoodMultiStepCheckout;

class Checkout {
	/**
	 * The constructor.
	 */
	public function __construct() {
		add_filter( 'woocommerce_locate_template', array( $this, 'override_checkout_templates' ), 10, 3 );
		add_action( 'oak_woocommerce_checkout_order_review_table', 'woocommerce_order_review', 10 );
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
		add_action( 'oak_woocommerce_checkout_login', 'woocommerce_checkout_login_form', 10 );
		add_filter( 'woocommerce_checkout_fields', array( $this, 'remove_checkout_fields' ) );
		remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );

		// Handle checkout delivery step.
		add_action( 'wp_ajax_handle_checkout_delivery_step', array( $this, 'handle_checkout_delivery_step' ) );
		add_action( 'wp_ajax_nopriv_handle_checkout_delivery_step', array( $this, 'handle_checkout_delivery_step' ) );

		// Handle checkout delivery step.
		add_action( 'wp_ajax_handle_checkout_fact_step', array( $this, 'handle_checkout_fact_step' ) );
		add_action( 'wp_ajax_nopriv_handle_checkout_fact_step', array( $this, 'handle_checkout_fact_step' ) );

		add_action( 'woocommerce_checkout_create_order', array( $this, 'save_custom_info_on_order_create' ), 10, 2 );
		add_action( 'woocommerce_checkout_order_processed', array( $this, 'remove_custom_session_key_after_order_created' ) );

		// Change place order button text.
		add_filter( 'woocommerce_order_button_text', array( $this, 'change_woocommerce_order_button_text' ), 100 );
	}

	/**
	 * Override checkout templates
	 *
	 * @param String $template
	 * @param String $template_name
	 * @param String $template_path
	 * @return void
	 */
	public function override_checkout_templates( $template, $template_name, $template_path ) {

		// Override form-checkout file.
		$checkout_file = 'checkout/form-checkout.php';

		if ( str_contains( $template, $checkout_file ) ) {
			$template = OAK_FOOD_MULTI_STEP_CHECKOUT_TEMPLATE_DIR . '/' . $checkout_file;
			return $template;
		}

		// Override form-login file.
		$checkout_login_file = 'checkout/form-login.php';

		if ( str_contains( $template, $checkout_login_file ) ) {
			$template = OAK_FOOD_MULTI_STEP_CHECKOUT_TEMPLATE_DIR . '/' . $checkout_login_file;
			return $template;
		}

		return $template;
	}

	public function remove_checkout_fields( $fields ) {
		// List of fields to remove.
		$fields_to_remove = array(
			'billing_first_name',
			'billing_last_name',
			'billing_country',
			'billing_address_1',
			'billing_address_2',
			'billing_company',
			'billing_postcode',
			'billing_city',
			'billing_state', // Or 'billing_province', depending on your setup.
			'billing_phone',
			'billing_email',
		);

		// Loop through each field and unset it.
		foreach ( $fields_to_remove as $field ) {
			if ( isset( $fields['billing'][ $field ] ) ) {
				unset( $fields['billing'][ $field ] );
			}
		}

		unset( $fields['order']['order_comments'] ); // Removes order notes field

		// Make sure password field is not required
		$fields['account']['account_password']['required'] = false;

		return $fields;
	}

	/**
	 * Handle form submission of delivery step
	 *
	 * @return void
	 */
	public function handle_checkout_delivery_step() {
		// Verify nonce for security.
		if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'oak-ajax-nonce' ) ) {
			wp_send_json_error( 'Nonce verification failed' );
		}

		$delivery_type    = sanitize_text_field( $_POST['delivery_type'] );
		$postcode         = sanitize_text_field( $_POST['postcode'] );
		$billing_house_no = sanitize_text_field( $_POST['billing_house_no'] );
		$billing_address  = sanitize_text_field( $_POST['billing_address'] );
		$delivery_date    = sanitize_text_field( $_POST['delivery_date'] );
		$delivery_time    = sanitize_text_field( $_POST['delivery_time'] );

		if ( empty( $delivery_type ) ) {
			wp_send_json_error( array( 'message' => __( 'Please select delivery type.', 'woocommerce' ) ) );
		}

		if ( empty( $postcode ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter your postcode.', 'woocommerce' ) ) );
		}

		if ( empty( $billing_house_no ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter your House no.', 'woocommerce' ) ) );
		}

		if ( empty( $billing_address ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter your address.', 'woocommerce' ) ) );
		}

		if ( empty( $delivery_date ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter delivery address.', 'woocommerce' ) ) );
		}

		// Manage WooCommerce session.
		if ( ! WC()->session->has_session() ) {
			WC()->session->set_customer_session_cookie( true );
		}

		WC()->session->set( 'delivery_type', $delivery_type );
		WC()->session->set( 'postcode', $postcode );
		WC()->session->set( 'billing_house_no', $billing_house_no );
		WC()->session->set( 'billing_address', $billing_address );
		WC()->session->set( 'delivery_date', $delivery_date );
		WC()->session->set( 'delivery_time', $delivery_time );
		WC()->session->set( 'is_validate_oak_delivery_step', 'yes' );

		// Return success response.
		$response_data = array(
			'success' => true,
			'message' => 'Delivery address successfully validated and processed.',
		);
		wp_send_json_success( $response_data );
		wp_die();
	}

	/**
	 * Handle form submission of fact step
	 *
	 * @return void
	 */
	public function handle_checkout_fact_step() {
		// Verify nonce for security.
		if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'oak-ajax-nonce' ) ) {
			wp_send_json_error( 'Nonce verification failed' );
		}

		$fact_email                = sanitize_text_field( $_POST['fact_email'] );
		$first_name                = sanitize_text_field( $_POST['first_name'] );
		$last_name                 = sanitize_text_field( $_POST['last_name'] );
		$phone                     = sanitize_text_field( $_POST['phone'] );
		$fact_delivery_time        = sanitize_text_field( $_POST['fact_delivery_time'] );
		$custom_password           = sanitize_text_field( $_POST['custom_password'] );
		$different_billing_address = isset( $_POST['different_billing_address'] ) ? sanitize_text_field( $_POST['different_billing_address'] ) : '';

		if ( empty( $fact_email ) || ! is_email( $fact_email ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter email address.', 'woocommerce' ) ) );
		}

		if ( empty( $first_name ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter your first name.', 'woocommerce' ) ) );
		}

		if ( empty( $last_name ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter your last name', 'woocommerce' ) ) );
		}

		if ( empty( $phone ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter your phone number.', 'woocommerce' ) ) );
		}

		if ( ! is_user_logged_in() && empty( $custom_password ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter an account password.', 'woocommerce' ) ) );
		}

		// Manage WooCommerce session.
		if ( ! WC()->session->has_session() ) {
			WC()->session->set_customer_session_cookie( true );
		}

		WC()->session->set( 'billing_email', $fact_email );
		WC()->session->set( 'first_name', $first_name );
		WC()->session->set( 'last_name', $last_name );
		WC()->session->set( 'phone', $phone );
		WC()->session->set( 'delivery_time', $fact_delivery_time );
		WC()->session->set( 'custom_password', $custom_password );
		WC()->session->set( 'different_billing_address', $different_billing_address );
		WC()->session->set( 'is_validate_oak_fact_step', 'yes' );

		$posted_data = array(
			'account_username'   => $fact_email,
			'account_password'   => $custom_password,
			'billing_email'      => $fact_email,
			'billing_first_name' => $first_name,
			'billing_last_name'  => $last_name,
			'createaccount'      => 'yes',
		);

		if ( ! is_user_logged_in() ) {
			$create_customer = new CreateCustomer();
			$create_customer->create_customer_on_checkout( $posted_data );
		}

		// Return success response.
		$response_data = array(
			'success'                => true,
			'is_need_to_page_reload' => WC()->session->get( 'reload_checkout' ),
			'message'                => 'Facts successfully validated and processed.',
		);
		wp_send_json_success( $response_data );
		wp_die();
	}

	/**
	 * Save order info
	 *
	 * @param [type] $order
	 * @param [type] $data
	 * @return void
	 */
	public function save_custom_info_on_order_create( $order, $data ) {
		// Retrieve custom data from session.
		$billing_email             = WC()->session->get( 'billing_email' );
		$postcode                  = WC()->session->get( 'postcode' );
		$billing_address           = WC()->session->get( 'billing_address' );
		$first_name                = WC()->session->get( 'first_name' );
		$last_name                 = WC()->session->get( 'last_name' );
		$phone                     = WC()->session->get( 'phone' );
		$delivery_type             = WC()->session->get( 'delivery_type' );
		$billing_house_no          = WC()->session->get( 'billing_house_no' );
		$delivery_date             = WC()->session->get( 'delivery_date' );
		$delivery_time             = WC()->session->get( 'delivery_time' );
		$custom_password           = WC()->session->get( 'custom_password' );
		$different_billing_address = WC()->session->get( 'different_billing_address' );

		if ( ! empty( $billing_email ) ) {
			$order->set_billing_email( $billing_email );
		}

		if ( ! empty( $postcode ) ) {
			$order->set_billing_postcode( $postcode );
		}

		if ( ! empty( $billing_address ) ) {
			$order->set_billing_address_1( $billing_address );
		}

		if ( ! empty( $first_name ) ) {
			$order->set_billing_first_name( $first_name );
		}

		if ( ! empty( $last_name ) ) {
			$order->set_billing_last_name( $last_name );
		}

		if ( ! empty( $phone ) ) {
			$order->set_billing_phone( $phone );
		}

		if ( ! empty( $delivery_type ) ) {
			$order->update_meta_data( 'delivery_type', sanitize_text_field( $delivery_type ) );
		}

		if ( ! empty( $billing_house_no ) ) {
			$order->update_meta_data( 'billing_house_no', sanitize_text_field( $billing_house_no ) );
		}

		if ( ! empty( $delivery_date ) ) {
			$order->update_meta_data( 'delivery_date', sanitize_text_field( $delivery_date ) );
		}

		if ( ! empty( $delivery_time ) ) {
			$order->update_meta_data( 'delivery_time', sanitize_text_field( $delivery_time ) );
		}

		if ( ! empty( $different_billing_address ) ) {
			$order->update_meta_data( 'different_billing_address', sanitize_text_field( $different_billing_address ) );
		}
	}

	/**
	 * Remove steps validation key from WC session.
	 *
	 * @return void
	 */
	public function remove_custom_session_key_after_order_created() {
		if ( class_exists( 'WC_Session' ) ) {
			unset( WC()->session->is_validate_oak_fact_step );
			unset( WC()->session->is_validate_oak_delivery_step );
		}
	}

	/**
	 * Change placeorder button text.
	 *
	 * @return void
	 */
	public function change_woocommerce_order_button_text() {
		return esc_html__( 'Pay', 'oak-food-multi-step-checkout' );
	}
}
