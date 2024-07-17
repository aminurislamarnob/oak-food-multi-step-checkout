<?php
/**
 * Plugin Name: Oak Food Multi Step Checkout
 * Plugin URI:  https://giopio.com/
 * Description: Multi Step Checkout Plugin For Oak Food Website
 * Version: 1.0.1
 * Author: Jakarea Parvez
 * Author URI: https://giopio.com/
 * Text Domain: oak-food-multi-step-checkout
 * WC requires at least: 5.0.0
 * Domain Path: /languages/
 * License: GPL2
 * Requires Plugins: woocommerce
 */
use PluginizeLab\OakFoodMultiStepCheckout\OakFoodMultiStepCheckout;

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'OAK_FOOD_MULTI_STEP_CHECKOUT_FILE' ) ) {
	define( 'OAK_FOOD_MULTI_STEP_CHECKOUT_FILE', __FILE__ );
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Load Oak_Food_Multi_Step_Checkout Plugin when all plugins loaded
 *
 * @return \PluginizeLab\OakFoodMultiStepCheckout\OakFoodMultiStepCheckout
 */
function pluginizelab_oak_food_multi_step_checkout() {
	return OakFoodMultiStepCheckout::init();
}

// Lets Go....
pluginizelab_oak_food_multi_step_checkout();
