<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use PluginizeLab\OakFoodMultiStepCheckout\Helpers;

do_action( 'woocommerce_before_checkout_form', $checkout );



// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<div class="checkout-delivery-step">
	<!-- common header start -->
	<?php require pluginizelab_oak_food_multi_step_checkout()->get_template( 'checkout/oak-checkout-parts/header-nav.php' ); ?>
	<!-- common header end -->
	<div class="main-grid">
		<div class="left-sidee">
			<?php
				require pluginizelab_oak_food_multi_step_checkout()->get_template( 'checkout/oak-checkout-parts/delivery-step.php' );
				require pluginizelab_oak_food_multi_step_checkout()->get_template( 'checkout/oak-checkout-parts/facts-step.php' );
			?>

			<form name="checkout" method="post" class="checkout woocommerce-checkout <?php echo Helpers::is_pm_visible() ? 'oak-d-block' : ''; ?>" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

				<?php if ( $checkout->get_checkout_fields() ) : ?>

					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<div class="col2-set" id="customer_details">
						<div class="col-1">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>

						<div class="col-2">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					</div>

					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

				<?php endif; ?>

				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

				<h3 id="order_review_heading"><?php esc_html_e( 'Payment Method', 'woocommerce' ); ?></h3>

				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					<div class="multi-step-buttons">
						<a id="pm-step-prev-btn" class="button prev-btn" href="#">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path d="M10 19L3 12M3 12L10 5M3 12L21 12" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
							<?php echo esc_html__( 'Previous Step', 'oak-food-multi-step-checkout' ); ?>
						</a>
					</div>
				</div>

				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

			</form>
		</div>
		<div class="right-sidee">
			<?php require pluginizelab_oak_food_multi_step_checkout()->get_template( 'checkout/oak-checkout-parts/right-side.php' ); ?>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
