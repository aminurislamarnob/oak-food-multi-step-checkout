<div class="oak-order-review">
	<h3 class="oak-order-review-heading"><?php echo esc_html__( 'Your order', 'oak-food-multi-step-checkout' ); ?></h3>
	<?php do_action( 'oak_woocommerce_checkout_order_review_table' ); ?>
</div>
<div class="payment-methods-logo payment-logo-2">
	<a href="#">
		<img src="<?php echo esc_attr( pluginizelab_oak_food_multi_step_checkout()->get_asset( 'frontend/images/paypal.png' ) ); ?>" alt="<?php echo esc_html__( 'Paypal', 'oak-food-multi-step-checkout' ); ?>">
	</a>
	<a href="#">
		<img src="<?php echo esc_attr( pluginizelab_oak_food_multi_step_checkout()->get_asset( 'frontend/images/stripe.png' ) ); ?>" alt="<?php echo esc_html__( 'Stripe', 'oak-food-multi-step-checkout' ); ?>">
	</a>
	<a href="#">
		<img src="<?php echo esc_attr( pluginizelab_oak_food_multi_step_checkout()->get_asset( 'frontend/images/ideal.png' ) ); ?>" alt="<?php echo esc_html__( 'iDeal', 'oak-food-multi-step-checkout' ); ?>">
	</a>
</div>