<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use PluginizeLab\OakFoodMultiStepCheckout\Helpers;
?>
<div class="oak-facts-section-wrapper">
	<div class="oak-facts-fields">
		<h3 class="common-subtitle"><?php echo esc_html__( 'Facts', 'oak-food-multi-step-checkout' ); ?></h3>
		<div class="woocommerce-notices-wrapper"></div>
		<div class="common-box">
			<div class="form-row form-row-wide oak-facts-email-row">
				<label for="fact_email" class="common-labell">
					<?php echo esc_html__( 'Your Email Address', 'oak-food-multi-step-checkout' ); ?>
				</label>
				<span class="woocommerce-input-wrapper">
					<input type="email" class="input-text oak-required-field common-inputt" name="oak_billing_email" id="fact_email" placeholder="<?php echo esc_attr( 'Email' ); ?>" value="<?php echo esc_attr( Helpers::get_loggedin_user_email() ); ?>">
				</span>
				<span class="error-message"></span>
			</div>
			<div class="oak-checkout-login-form">
				<?php do_action( 'oak_woocommerce_checkout_login', $checkout ); ?>
			</div>
			<div class="woocommerce-billing-fields__field-wrapper name-filed">
				<div class="form-row form-row-first">
					<label for="first_name" class="common-labell"><?php echo esc_html__( 'First Name', 'oak-food-multi-step-checkout' ); ?></label>
					<span class="woocommerce-input-wrapper">
						<input type="text" class="input-text oak-required-field common-inputt" name="first_name" id="first_name" placeholder="First name here" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'first_name' ) ); ?>">
					</span>
					<span class="error-message"></span>
				</div>
				<div class="form-row form-row-last">
					<label for="last_name" class="common-labell"><?php echo esc_html__( 'Last Name', 'oak-food-multi-step-checkout' ); ?></label>
					<span class="woocommerce-input-wrapper">
						<input type="text" class="input-text oak-required-field common-inputt" name="last_name" id="last_name" placeholder="Last name here" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'last_name' ) ); ?>">
					</span>
					<span class="error-message"></span>
				</div>
			</div>
			<div class="woocommerce-billing-fields__field-wrapper name-filed">
				<div class="form-row form-row-first">
					<label for="phone" class="common-labell"><?php echo esc_html__( 'Phone Number', 'oak-food-multi-step-checkout' ); ?></label>
					<span class="woocommerce-input-wrapper">
						<input type="text" class="input-text oak-required-field common-inputt" name="phone" id="phone" placeholder="" value="<?php echo esc_attr( Helpers::get_wc_session_value_by_key( 'phone' ) ); ?>">
					</span>
					<span class="error-message"></span>
				</div>
				<div class="form-row form-row-last">
					<label for="fact_delivery_time" class="common-labell"><?php echo esc_html__( 'Delivery Time', 'oak-food-multi-step-checkout' ); ?></label>
					<span class="woocommerce-input-wrapper">
						<select name="delivery_time" id="fact_delivery_time" class="common-inputt">
							<?php foreach ( Helpers::get_delivery_times() as $key => $value ) { ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php echo Helpers::get_wc_session_value_by_key( 'delivery_time' ) === $key ? 'selected' : ''; ?>><?php echo esc_html( $value ); ?></option>
							<?php } ?>
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
			<?php if ( ! is_user_logged_in() ) { ?>
			<div class="white-box">
				<div class="create-account-hints">
					<p><?php echo esc_html__( 'Create an account immediately by providing a password and take advantage of the benefits:', 'oak-food-multi-step-checkout' ); ?></p>
					<ul>
						<li>
							<img src="<?php echo esc_attr( pluginizelab_oak_food_multi_step_checkout()->get_asset( 'frontend/images/check.svg' ) ); ?>" alt="C">
							<?php echo esc_html__( 'Save for gifts and discounts', 'oak-food-multi-step-checkout' ); ?>
						</li>
						<li>
							<img src="<?php echo esc_attr( pluginizelab_oak_food_multi_step_checkout()->get_asset( 'frontend/images/check.svg' ) ); ?>" alt="<?php echo esc_attr__( 'Order faster', 'oak-food-multi-step-checkout' ); ?>">
							<?php echo esc_html__( 'Order faster', 'oak-food-multi-step-checkout' ); ?>
						</li>
						<li>
							<img src="<?php echo esc_attr( pluginizelab_oak_food_multi_step_checkout()->get_asset( 'frontend/images/check.svg' ) ); ?>" alt="<?php echo esc_attr__( 'View order history', 'oak-food-multi-step-checkout' ); ?>">
							<?php echo esc_html__( 'View order history', 'oak-food-multi-step-checkout' ); ?>
						</li>
						<li>
							<img src="<?php echo esc_attr( pluginizelab_oak_food_multi_step_checkout()->get_asset( 'frontend/images/check.svg' ) ); ?>" alt="<?php echo esc_attr__( 'Follow Favorites', 'oak-food-multi-step-checkout' ); ?>">
							<?php echo esc_html__( 'Follow Favorites', 'oak-food-multi-step-checkout' ); ?>
						</li>
						<li>
							<img src="<?php echo esc_attr( pluginizelab_oak_food_multi_step_checkout()->get_asset( 'frontend/images/check.svg' ) ); ?>" alt="<?php echo esc_attr__( 'Post Reviews', 'oak-food-multi-step-checkout' ); ?>">
							<?php echo esc_html__( 'Post Reviews', 'oak-food-multi-step-checkout' ); ?>
						</li>
					</ul>
				</div>

				<p class="form-row">
					<label for="custom_password" class="common-labell"><?php echo esc_html__( 'Choose a Password', 'oak-food-multi-step-checkout' ); ?></label>
					<span class="woocommerce-input-wrapper password-input">
						<input type="password" class="input-text common-inputt" name="custom_password" id="custom_password" placeholder="<?php echo esc_attr__( 'Enter Password', 'oak-food-multi-step-checkout' ); ?>">
					</span>
				</p>
				<p class="common-para" style="text-align: left!important;"><?php echo esc_html__( 'This form is protected by reCaptcha, the Google Privacy <br> Policy and Terms of Service apply.', 'oak-food-multi-step-checkout' ); ?></p>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="multi-step-buttons">
		<button id="facts-step-prev-btn" class="button prev-btn">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M10 19L3 12M3 12L10 5M3 12L21 12" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
			<?php echo esc_html__( 'Previous Step', 'oak-food-multi-step-checkout' ); ?>
		</button>
		<button id="facts-step-next-btn" class="button next-btn"><?php echo esc_html__( 'Next', 'oak-food-multi-step-checkout' ); ?>
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
		</button>
	</div>
</div>