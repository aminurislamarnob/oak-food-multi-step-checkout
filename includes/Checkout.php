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

		// Handle checkout first step.
		add_action( 'wp_ajax_handle_checkout_step', array( $this, 'handle_checkout_first_step' ) );
		add_action( 'wp_ajax_nopriv_handle_checkout_step', array( $this, 'handle_checkout_first_step' ) );

		// Handle checkout delivery step.
		add_action( 'wp_ajax_handle_checkout_delivery_step', array( $this, 'handle_checkout_delivery_step' ) );
		add_action( 'wp_ajax_nopriv_handle_checkout_delivery_step', array( $this, 'handle_checkout_delivery_step' ) );
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
		$checkout_file = 'checkout/form-checkout.php';

		if ( str_contains( $template, $checkout_file ) ) {
			$template = OAK_FOOD_MULTI_STEP_CHECKOUT_TEMPLATE_DIR . '/' . $checkout_file;
			return $template;
		}
		return $template;
	}

	/**
	 * Handle form submission of first step
	 *
	 * @return void
	 */
	public function handle_checkout_first_step() {
		// Verify nonce for security.
		if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'oak-ajax-nonce' ) ) {
			wp_send_json_error( 'Nonce verification failed' );
		}

		// Handle email validation and other processing.
		$email = sanitize_email( $_POST['email'] );

		if ( empty( $email ) || ! is_email( $email ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'woocommerce' ) ) );
		}

		// Manage WooCommerce session.
		if ( ! WC()->session->has_session() ) {
			WC()->session->set_customer_session_cookie( true );
		}

		WC()->session->set( 'oak_billing_email', $email );
		WC()->session->set( 'is_validate_oak_first_step', 'yes' );

		// Return success response.
		$response_data = array(
			'success' => true,
			'message' => 'Email successfully validated and processed.',
		);
		wp_send_json_success( $response_data );
		wp_die();
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
}
