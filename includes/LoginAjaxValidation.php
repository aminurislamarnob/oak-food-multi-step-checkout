<?php

namespace PluginizeLab\OakFoodMultiStepCheckout;

class LoginAjaxValidation {
	/**
	 * The constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_nopriv_custom_checkout_login', array( $this, 'custom_ajax_checkout_login' ) );
	}

	/**
	 * Handle checkout login validation by ajax
	 *
	 * @return void
	 */
	public function custom_ajax_checkout_login() {
		check_ajax_referer( 'oak-ajax-nonce', 'nonce' );

		$username = sanitize_text_field( $_POST['username'] );
		$password = sanitize_text_field( $_POST['password'] );

		$user = wp_signon(
			array(
				'user_login'    => $username,
				'user_password' => $password,
				'remember'      => true,
			),
			is_ssl()
		);

		if ( is_wp_error( $user ) ) {
			wp_send_json_error(
				array(
					'message' => $user->get_error_message(),
				)
			);
		} else {
			wp_send_json_success();
		}
	}
}
