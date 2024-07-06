<?php

namespace PluginizeLab\OakFoodMultiStepCheckout;

class Helpers {
	/**
	 * Get user email address from wc session or loggedin user
	 *
	 * @return string
	 */
	public static function get_loggedin_user_email() {
		// If session email is not found or session doesn't exist, check if user is logged in.
		if ( is_user_logged_in() ) {
			$user_id   = get_current_user_id();
			$user_info = get_userdata( $user_id );
			return $user_info->user_email;
		}

		// Check if WooCommerce session exists and has email.
		if ( WC()->session->has_session() ) {
			$oak_billing_email = WC()->session->get( 'billing_email' );

			if ( $oak_billing_email ) {
				return $oak_billing_email;
			}
		}

		return '';
	}

	/**
	 * Get wc session saved value by key
	 *
	 * @param string $key session key name.
	 * @return string
	 */
	public static function get_wc_session_value_by_key( $key ) {
		if ( WC()->session->has_session() ) {
			$value = WC()->session->get( $key );

			if ( $value ) {
				return $value;
			} else {
				return '';
			}
		}
		return '';
	}

	/**
	 * Check is payment method section is visible or not
	 *
	 * @return boolean
	 */
	public static function is_pm_visible() {
		if ( WC()->session->has_session() ) {
			$is_fact_step_validated = WC()->session->get( 'is_validate_oak_fact_step' );
			if ( is_user_logged_in() && 'yes' === $is_fact_step_validated ) {
				return true;
			}
		}
		return false;
	}
}
