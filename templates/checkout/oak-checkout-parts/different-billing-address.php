<?php
if (!defined('ABSPATH')) {
	exit;
}

use PluginizeLab\OakFoodMultiStepCheckout\Helpers;
?>
<div class="different-shipping-address">
    <div class="different-shipping-common-box">
        <div class="address-fields-group adres-details-group">
            <div class="form-row">
                <label for="shipping_postcode"><?php echo esc_html__('Postal Code', 'oak-food-multi-step-checkout'); ?></label>
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text oak-required-field shipping_postcode" name="shipping_postcode" id="shipping_postcode" value="<?php echo esc_attr(Helpers::get_wc_session_value_by_key('shipping_postcode', 'shipping_postcode')); ?>">
                </span>
                <span class="error-message"></span>
            </div>
            <div class="form-row">
                <label for="shipping_house_no"><?php echo esc_html__('House No.', 'oak-food-multi-step-checkout'); ?></label> <span class="woocommerce-input-wrapper">
                <input type="text" class="input-text oak-required-field shipping_house_no" name="shipping_house_no" id="shipping_house_no" value="<?php echo esc_attr(Helpers::get_wc_session_value_by_key('shipping_house_no', 'shipping_house_no')); ?>">
                </span>
                <span class="error-message"></span>
            </div>

            <div class="form-row">
                <label for="shipping_street_address"><?php echo esc_html__('Streed Add', 'oak-food-multi-step-checkout'); ?></label>
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text new_ oak-required-field shipping_street_address" name="shipping_street_address" id="shipping_street_address" value="<?php echo esc_attr(Helpers::get_wc_session_value_by_key('shipping_street_address', 'shipping_address_1')); ?>">
                </span>
                <span class="error-message"></span>
            </div>

            <div class="form-row billing-address-wrap">
                <label for="shipping_address_1"><?php echo esc_html__('Address', 'oak-food-multi-step-checkout'); ?></label>
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text shipping_address_1" name="shipping_address_1" id="shipping_address_1" value="<?php echo esc_attr(Helpers::get_wc_session_value_by_key('shipping_address_1', 'shipping_address_2')); ?>">
                </span>
                <span class="error-message"></span>
            </div>
        </div>
        <div class="woocommerce-billing-fields__field-wrapper name-filed">
            <div class="form-row form-row-first">
                <label for="shipping_first_name" class="common-labell"><?php echo esc_html__('First Name', 'oak-food-multi-step-checkout'); ?></label>
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text oak-required-field common-inputt shipping_first_name" name="shipping_first_name" id="shipping_first_name" placeholder="First name here" value="<?php echo esc_attr(Helpers::get_wc_session_value_by_key('shipping_first_name', 'shipping_first_name')); ?>">
                </span>
                <span class="error-message"></span>
            </div>
            <div class="form-row form-row-last">
                <label for="shipping_last_name" class="common-labell"><?php echo esc_html__('Last Name', 'oak-food-multi-step-checkout'); ?></label>
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text oak-required-field common-inputt shipping_last_name" name="shipping_last_name" id="shipping_last_name" placeholder="Last name here" value="<?php echo esc_attr(Helpers::get_wc_session_value_by_key('shipping_last_name', 'shipping_last_name')); ?>">
                </span>
                <span class="error-message"></span>
            </div>
        </div>
        <div class="delivery-time-fields delivery-time-area">
            <div class="form-row form-row-first">
                <label for="shipping_delivery_date"><?php echo esc_html__('Delivery Date', 'oak-food-multi-step-checkout'); ?></label>
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text oak-required-field shipping_delivery_date" name="shipping_delivery_date" id="shipping_delivery_date" value="<?php echo esc_attr(Helpers::get_wc_session_value_by_key('shipping_delivery_date', 'shipping_delivery_date')); ?>">
                </span>
                <span class="error-message"></span>
            </div>
            <div class="form-row form-row-last">
                <label for="shipping_delivery_time"><?php echo esc_html__('Delivery Time', 'oak-food-multi-step-checkout'); ?></label>
                <span class="woocommerce-input-wrapper common-inputt">
                    <select name="shipping_delivery_time" id="shipping_delivery_time" class="common-inputt shipping_delivery_time">
                        <?php foreach (Helpers::get_delivery_times() as $key => $value) { ?>
                            <option value="<?php echo esc_attr($key); ?>" <?php echo Helpers::get_wc_session_value_by_key('shipping_delivery_time', 'shipping_delivery_time') === $key ? 'selected' : ''; ?>><?php echo esc_html($value); ?></option>
                        <?php } ?>
                    </select>
                </span>
            </div>
        </div>
        <div class="woocommerce-billing-fields__field-wrapper name-filed">
            <div class="form-row form-row-last">
                <label for="shipping_phone" class="common-labell"><?php echo esc_html__('Phone Number', 'oak-food-multi-step-checkout'); ?></label>
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text oak-required-field common-inputt shipping_phone" name="shipping_phone" id="shipping_phone" placeholder="" value="<?php echo esc_attr(Helpers::get_wc_session_value_by_key('shipping_phone', 'shipping_phone')); ?>">
                </span>
                <span class="error-message"></span>
            </div>
        </div>
    </div>
    <div class="example-address">
        <div class="form-row form-row-wide">
            <label><?php echo esc_html__('Delivery Address', 'oak-food-multi-step-checkout'); ?></label>
            <span class="woocommerce-input-wrapper">
                <p class="delivery-address-inf1"><?php echo esc_html__('Example Address 125, city name, 465NZ Steenbergen', 'oak-food-multi-step-checkout'); ?></p>
            </span>
        </div>
    </div>
</div>