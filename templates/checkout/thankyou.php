<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order checkout-success">
	<div class="success-order-check">
		<img src="<?php echo esc_attr( pluginizelab_oak_food_multi_step_checkout()->get_asset( 'frontend/images/success-check.svg' ) ); ?>" alt="<?php echo esc_attr__( 'Thank You', 'oak-food-multi-step-checkout' ); ?>">
	</div>
	<h3><?php echo esc_html__( 'Thank you for your order', 'oak-food-multi-step-checkout' ); ?></h3>
	<p><?php echo esc_html__( 'Successfully completed over 200 large-scale projects for clients in Bangladesh including a significant number of SaaS companies, thriving startups, and educational establishments.', 'oak-food-multi-step-checkout' ); ?></p>
	<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="button next-btn"><?php echo esc_html__( 'Continue Shopping', 'oak-food-multi-step-checkout' ); ?>
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
			<path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
		</svg>
	</a>
</div>
