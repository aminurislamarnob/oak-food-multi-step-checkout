<?php

namespace PluginizeLab\OakFoodMultiStepCheckout;

class Helpers {
    public static function get_loggedin_user_email() {
        // Check if WooCommerce session exists and has email
        if ( WC()->session->has_session() ) {
            $oak_billing_email = WC()->session->get( 'oak_billing_email' );
            
            if ( $oak_billing_email ) {
                return $oak_billing_email;
            }
        }

        // If session email is not found or session doesn't exist, check if user is logged in
        if ( is_user_logged_in() ) {
            // Get current user ID
            $user_id = get_current_user_id();

            // Get user data
            $user_info = get_userdata( $user_id );

            // Return user email
            return $user_info->user_email;
        }

        // Return empty string if neither session email nor logged-in user email is found
        return '';
    }
    
}