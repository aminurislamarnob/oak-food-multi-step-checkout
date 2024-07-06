<div class="oak-order-review">
	<h3 class="oak-order-review-heading"><?php echo esc_html__( 'Your order', 'oak-food-multi-step-checkout' ); ?></h3>
	<?php do_action( 'oak_woocommerce_checkout_order_review_table' ); ?>
</div>
<div class="payment-methods-logo payment-logo-2">
	<a href="#">
		<img src="<?php echo OAK_FOOD_MULTI_STEP_CHECKOUT_PLUGIN_ASSET . '/frontend/images/paypal.png'; ?>" alt="aa">
	</a>
	<a href="#">
		<img src="<?php echo OAK_FOOD_MULTI_STEP_CHECKOUT_PLUGIN_ASSET . '/frontend/images/stripe.png'; ?>" alt="aa">
	</a>
	<a href="#">
		<img src="<?php echo OAK_FOOD_MULTI_STEP_CHECKOUT_PLUGIN_ASSET . '/frontend/images/ideal.png'; ?>" alt="aa">
	</a>
</div>