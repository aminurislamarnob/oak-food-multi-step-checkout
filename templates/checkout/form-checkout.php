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
	<div class="common-header-wrap">
		<div class="txt active">
			<h5>Delivery</h5>
			<hr>
		</div>
		<div class="txt">
			<h5>Facts</h5>
			<hr>
		</div>
		<div class="txt">
			<h5>Payment Method</h5>
			<hr>
		</div>
	</div>
	<!-- common header end -->
	<div class="main-grid">
		<div class="left-sidee">
			<div class="oak-delivery-fields-wrapper">
				<div class="oak-delivery-fields">
					<h3 class="common-subtitle">Delivery</h3>
					<div class="common-box">
						<div class="form-row form-row-wide">
							<input type="radio" name="delivery_type" id="delivery_type" checked>
							<label for="delivery_type delivery-txt"><?php echo esc_html__( 'Delivery (home or to aother address)', 'oak-food-multi-step-checkout' ); ?></label>
						</div>
						<div class="address-fields-group adres-details-group">
							<div class="form-row">
								<label for="billing_postcode"><?php echo esc_html__( 'Postal Code', 'oak-food-multi-step-checkout' ); ?></label>
								<span class="woocommerce-input-wrapper">
									<input type="text" class="input-text postcode oak-required-field" name="billing_postcode" id="billing_postcode" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'postcode' ) ); ?>">
								</span>
								<span class="error-message"></span>
							</div>
							<div class="form-row">
								<label for="billing_house_no"><?php echo esc_html__( 'House No.', 'oak-food-multi-step-checkout' ); ?></label>
								<span class="woocommerce-input-wrapper">
									<input type="text" class="input-text oak-required-field house_no" name="billing_house_no" id="billing_house_no" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'billing_house_no' ) ); ?>">
								</span>
								<span class="error-message"></span>
							</div>
							<div class="form-row">
								<label for="billing_address_1"><?php echo esc_html__( 'Add', 'oak-food-multi-step-checkout' ); ?></label>
								<span class="woocommerce-input-wrapper">
									<input type="text" class="input-text oak-required-field billing_address" name="billing_address_1" id="billing_address_1" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'billing_address' ) ); ?>">
								</span>
								<span class="error-message"></span>
							</div>
						</div>
						<div class="example-address">
							<div class="form-row form-row-wide">
								<label><?php echo esc_html__( 'Delivery Address', 'oak-food-multi-step-checkout' ); ?></label>
								<span class="woocommerce-input-wrapper">
									<p><?php echo esc_html__( 'Example Address 125, city name, 465NZ Steenbergen', 'oak-food-multi-step-checkout' ); ?></p>
								</span>
								<span class="error-message"></span>
							</div>
						</div>
						<div class="delivery-time-fields delivery-time-area">
							<div class="form-row form-row-first">
								<label for="delivery_date"><?php echo esc_html__( 'Delivery Date', 'oak-food-multi-step-checkout' ); ?></label>
								<span class="woocommerce-input-wrapper">
									<input type="date" class="input-text oak-required-field" name="delivery_date" id="delivery_date" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'delivery_date' ) ); ?>">
								</span>
								<span class="error-message"></span>
							</div>
							<div class="form-row form-row-last">
								<label for="delivery_time"><?php echo esc_html__( 'Delivery Time', 'oak-food-multi-step-checkout' ); ?></label>
								<span class="woocommerce-input-wrapper common-inputt">
									<select name="delivery_time" id="delivery_time" class="common-inputt">
										<option value="Between 08:00 and 22:00">Between 08:00 and 22:00</option>
										<option value="Between 09:00 and 12:00">Between 09:00 and 12:00</option>
									</select>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="multi-step-buttons">
					<a class="button prev-btn" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M10 19L3 12M3 12L10 5M3 12L21 12" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
						<?php echo esc_html__( 'Back To Shopping Cart', 'oak-food-multi-step-checkout' ); ?></a>
					<button id="delivery-step-next-btn" class="button next-btn"><?php echo esc_html__( 'Next', 'oak-food-multi-step-checkout' ); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</button>
				</div>
			</div>

			<div class="oak-facts-section-wrapper">
				<div class="oak-facts-fields">
					<h3 class="common-subtitle">Facts</h3>
					<div class="common-box">
						<div class="form-row form-row-wide oak-facts-email-row">
							<label for="fact_email" class="common-labell">
								<?php echo esc_html__( 'Your Email Address', 'oak-food-multi-step-checkout' ); ?>
							</label>
							<span class="woocommerce-input-wrapper">
								<input type="email" class="input-text common-inputt" name="oak_billing_email" id="fact_email" placeholder="<?php echo esc_attr( 'Email' ); ?>" value="<?php echo esc_attr( Helpers::get_loggedin_user_email() ); ?>">
							</span>
						</div>
						<div class="oak-checkout-login-form">
							<?php do_action( 'oak_woocommerce_checkout_login', $checkout ); ?>
						</div>
						<div class="woocommerce-billing-fields__field-wrapper name-filed">
							<div class="form-row form-row-first">
								<label for="first_name" class="common-labell">First Name</label>
								<span class="woocommerce-input-wrapper">
									<input type="text" class="input-text oak-required-field common-inputt" name="first_name" id="first_name" placeholder="name here" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'first_name' ) ); ?>">
								</span>
								<span class="error-message"></span>
							</div>
							<div class="form-row form-row-last">
								<label for="last_name" class="common-labell">Last Name</label>
								<span class="woocommerce-input-wrapper">
									<input type="text" class="input-text oak-required-field common-inputt" name="last_name" id="last_name" placeholder="name here" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'last_name' ) ); ?>">
								</span>
								<span class="error-message"></span>
							</div>
						</div>
						<div class="woocommerce-billing-fields__field-wrapper name-filed">
							<div class="form-row form-row-first">
								<label for="phone" class="common-labell">Phone Number</label>
								<span class="woocommerce-input-wrapper">
									<input type="text" class="input-text oak-required-field common-inputt" name="phone" id="phone" placeholder="" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'phone' ) ); ?>">
								</span>
								<span class="error-message"></span>
							</div>
							<div class="form-row form-row-last">
								<label for="fact_delivery_time" class="common-labell"><?php echo esc_html__( 'Delivery Time', 'oak-food-multi-step-checkout' ); ?></label>
								<span class="woocommerce-input-wrapper">
									<select name="delivery_time" id="fact_delivery_time common-inputt">
										<option value="Between 08:00 and 22:00">Between 08:00 and 22:00</option>
										<option value="Between 09:00 and 12:00">Between 09:00 and 12:00</option>
									</select>
								</span>
							</div>
						</div>
						<div class="example-address">
							<div class="form-row form-row-wide">
								<label><?php echo esc_html__( 'Delivery Address', 'oak-food-multi-step-checkout' ); ?></label>
								<span class="woocommerce-input-wrapper">
									<p><?php echo esc_html__( 'Example Address 125, city name, 465NZ Steenbergen', 'oak-food-multi-step-checkout' ); ?></p>
								</span>
							</div>
						</div>
						<div class="different-billing-address">
							<div class="form-row form-row-wide">
								<input type="checkbox" name="different_billing_address" id="different_billing_address">
								<label for="different_billing_address"><?php echo esc_html__( 'Differnet Billing Address (invoice is sent by email)', 'oak-food-multi-step-checkout' ); ?></label>
							</div>
						</div>
						<div class="white-box">
							<div class="create-account-hints">
								<p class="">Create an account immediately by providing a password and take advantage of the benefits:</p>
								<ul>
									<li>
										<img src="<?php echo plugins_url( 'assets/check.svg', __DIR__ ); ?>" alt="C">
										Save for gifts and discounts
									</li>
									<li><img src="<?php echo plugins_url( 'assets/check.svg', __DIR__ ); ?>" alt="C">
									Order faster</li>
									<li><img src="<?php echo plugins_url( 'assets/check.svg', __DIR__ ); ?>" alt="C">
									View order history</li>
									<li><img src="<?php echo plugins_url( 'assets/check.svg', __DIR__ ); ?>" alt="C">Follow Favorites</li>
									<li><img src="<?php echo plugins_url( 'assets/check.svg', __DIR__ ); ?>" alt="C">Post Reviews</li>
								</ul>
							</div>

							<p class="form-row">
								<label for="custom_password" class="common-labell">Choose a Password</label>
								<span class="woocommerce-input-wrapper password-input">
									<input type="password" class="input-text common-inputt" name="custom_password" id="custom_password" placeholder="Password">
								</span>
							</p>
							<p class="common-para" style="text-align: left!important;">This form is protected by reCaptcha, the Google Privacy <br> Policy and Terms of Service apply.</p>
						</div>
					</div>
				</div>
				<div class="multi-step-buttons">
					<button id="facts-step-prev-btn" class="button prev-btn">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M10 19L3 12M3 12L10 5M3 12L21 12" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
						<?php echo esc_html__( 'Previous Step', 'oak-food-multi-step-checkout' ); ?></button>
					<button id="facts-step-next-btn" class="button next-btn"><?php echo esc_html__( 'Next', 'oak-food-multi-step-checkout' ); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</button>
				</div>
			</div>

			<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

				<h3 class="common-subtitle">Payment Method</h3>

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
				</div>

				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

			</form>
		</div>
		<div class="right-sidee">
			<div class="oak-order-review">
				<h3 class="oak-order-review-heading"><?php echo esc_html__( 'Your order', 'oak-food-multi-step-checkout' ); ?></h3>
				<?php do_action( 'oak_woocommerce_checkout_order_review_table' ); ?>
			</div>
			<div class="payment-methods-logo payment-logo-2">
				<a href="#">
					<img src="<?php echo plugins_url( 'assets/paypal.png', __DIR__ ); ?>" alt="aa">
				</a>
				<a href="#">
					<img src="<?php echo plugins_url( 'assets/stripe.png', __DIR__ ); ?>" alt="aa">
				</a>
				<a href="#">
					<img src="<?php echo plugins_url( 'assets/ideal.png', __DIR__ ); ?>" alt="aa">
				</a>
			</div>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
