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
<div class="enter-email-step">
	<h1><?php echo esc_html__( 'Checkout', 'oak-food-multi-step-checkout' ); ?></h1>
	<div class="form-row form-row-wide">
		<label for="oak_billing_email" class="">
			<?php echo esc_html__( 'Enter your email address to complete your order.', 'oak-food-multi-step-checkout' ); ?><abbr class="required" title="required">*</abbr>
		</label>
		<span class="woocommerce-input-wrapper">
			<input type="email" class="input-text " name="oak_billing_email" id="oak_billing_email" placeholder="<?php echo esc_attr( 'Your Email *' ); ?>" value="<?php echo esc_attr( Helpers::get_loggedin_user_email() ); ?>">
		</span>
	</div>
	<button id="checkout-first-step-btn" class="button next-btn"><?php echo esc_html__( 'Next Page', 'oak-food-multi-step-checkout' ); ?></button>
</div>
<div class="checkout-delivery-step">
	<div class="col2-set">
		<div class="col-1">
			<div class="oak-delivery-fields-wrapper">
				<div class="oak-delivery-fields">
					<div class="form-row form-row-wide">
						<input type="radio" name="delivery_type" id="delivery_type" checked>
						<label for="delivery_type"><?php echo esc_html__( 'Delivery (home or to aother address)', 'oak-food-multi-step-checkout' ); ?></label>
					</div>
					<div class="address-fields-group">
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
					<div class="delivery-time-fields">
						<div class="form-row form-row-first">
							<label for="delivery_date"><?php echo esc_html__( 'Delivery Date', 'oak-food-multi-step-checkout' ); ?></label>
							<span class="woocommerce-input-wrapper">
								<input type="date" class="input-text oak-required-field" name="delivery_date" id="delivery_date" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'delivery_date' ) ); ?>">
							</span>
							<span class="error-message"></span>
						</div>
						<div class="form-row form-row-last">
							<label for="delivery_time"><?php echo esc_html__( 'Delivery Time', 'oak-food-multi-step-checkout' ); ?></label>
							<span class="woocommerce-input-wrapper">
								<select name="delivery_time" id="delivery_time">
									<option value="Between 08:00 and 22:00">Between 08:00 and 22:00</option>
									<option value="Between 09:00 and 12:00">Between 09:00 and 12:00</option>
								</select>
							</span>
						</div>
					</div>
				</div>
				<div class="multi-step-buttons">
					<a class="button prev-btn" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php echo esc_html__( 'Back To Shopping Cart', 'oak-food-multi-step-checkout' ); ?></a>
					<button id="delivery-step-next-btn" class="button next-btn"><?php echo esc_html__( 'Next', 'oak-food-multi-step-checkout' ); ?></button>
				</div>
			</div>
			<div class="oak-facts-section-wrapper">
				<div class="oak-facts-fields">
					<div class="form-row form-row-wide oak-facts-email-row">
						<label for="fact_email" class="">
							<?php echo esc_html__( 'Your Email Address', 'oak-food-multi-step-checkout' ); ?>
						</label>
						<span class="woocommerce-input-wrapper">
							<input type="email" class="input-text " name="oak_billing_email" id="fact_email" placeholder="<?php echo esc_attr( 'Email' ); ?>" value="<?php echo esc_attr( Helpers::get_loggedin_user_email() ); ?>">
						</span>
					</div>
					<div class="oak-checkout-login-form">
						<?php do_action( 'oak_woocommerce_checkout_login', $checkout ); ?>
					</div>
					<div class="woocommerce-billing-fields__field-wrapper">
						<div class="form-row form-row-first">
							<label for="first_name" class="">First Name</label>
							<span class="woocommerce-input-wrapper">
								<input type="text" class="input-text oak-required-field" name="first_name" id="first_name" placeholder="name here" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'first_name' ) ); ?>">
							</span>
							<span class="error-message"></span>
						</div>
						<div class="form-row form-row-last">
							<label for="last_name" class="">Last Name</label>
							<span class="woocommerce-input-wrapper">
								<input type="text" class="input-text oak-required-field" name="last_name" id="last_name" placeholder="name here" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'last_name' ) ); ?>">
							</span>
							<span class="error-message"></span>
						</div>
					</div>
					<div class="woocommerce-billing-fields__field-wrapper">
						<div class="form-row form-row-first">
							<label for="phone" class="">Phone Number</label>
							<span class="woocommerce-input-wrapper">
								<input type="text" class="input-text oak-required-field" name="phone" id="phone" placeholder="" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'phone' ) ); ?>">
							</span>
							<span class="error-message"></span>
						</div>
						<div class="form-row form-row-last">
							<label for="fact_delivery_time"><?php echo esc_html__( 'Delivery Time', 'oak-food-multi-step-checkout' ); ?></label>
							<span class="woocommerce-input-wrapper">
								<select name="delivery_time" id="fact_delivery_time">
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
					<div class="create-account-hints">
						<p>Create an account immediately by providing a password and take advantage of the benefits:</p>
						<ul>
							<li>Save for gifts and discounts</li>
							<li>Order faster</li>
							<li>View order history</li>
							<li>Follow Favorites</li>
							<li>Post Reviews</li>
						</ul>
					</div>
					<p class="form-row">
						<label for="custom_password" class="">Choose a Password</label>
						<span class="woocommerce-input-wrapper password-input">
							<input type="password" class="input-text" name="custom_password" id="custom_password" placeholder="Password">
						</span>
					</p>
				</div>
				<div class="multi-step-buttons">
					<button id="facts-step-prev-btn" class="button prev-btn"><?php echo esc_html__( 'Previous Step', 'oak-food-multi-step-checkout' ); ?></button>
					<button id="facts-step-next-btn" class="button next-btn"><?php echo esc_html__( 'Next', 'oak-food-multi-step-checkout' ); ?></button>
				</div>
			</div>
			<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
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
		<div class="col-2">
			<div class="oak-order-review">
				<h3 class="oak-order-review-heading"><?php echo esc_html__( 'Your order', 'oak-food-multi-step-checkout' ); ?></h3>
				<?php do_action( 'oak_woocommerce_checkout_order_review_table' ); ?>
			</div>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
