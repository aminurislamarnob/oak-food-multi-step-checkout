<?php

namespace PluginizeLab\OakFoodMultiStepCheckout;

class Checkout {
    /**
     * The constructor.
     */
    public function __construct() {
        add_filter('woocommerce_locate_template', [$this, 'override_checkout_templates'], 10, 3);
        remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

        //Handle checkout first step
        add_action('wp_ajax_handle_checkout_step', [$this, 'handle_checkout_first_step']);
        add_action('wp_ajax_nopriv_handle_checkout_step', [$this, 'handle_checkout_first_step']);
    }

    /**
     * Override checkout templates
     *
     * @param String $template
     * @param String $template_name
     * @param String $template_path
     * @return void
     */
    public function override_checkout_templates($template, $template_name, $template_path){
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
        // Verify nonce for security
        if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'oak-ajax-nonce')) {
            wp_send_json_error('Nonce verification failed');
        }
    
        // Handle email validation and other processing
        $email = sanitize_email($_POST['email']);
    
        if (empty($email) || !is_email($email)) {
            wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'woocommerce' ) ) );
        }

        if ( ! WC()->session->has_session() ) {
            WC()->session->set_customer_session_cookie( true );
        }

        // Store custom field value in session
        WC()->session->set( 'oak_billing_email', $email );
    
        // You can perform additional processing here, such as saving the email to session or database
    
        // Return success response
        // Your processing logic
        $response_data = array(
            'success' => true,
            'message' => 'Email successfully validated and processed.',
        );
        wp_send_json_success( $response_data );
        // wp_send_json_success('Email successfully validated and processed.');
        wp_die();
    }
}