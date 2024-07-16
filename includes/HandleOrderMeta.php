<?php

namespace PluginizeLab\OakFoodMultiStepCheckout;

class HandleOrderMeta {
	/**
	 * The constructor.
	 */
	public function __construct() {
		add_action( 'woocommerce_admin_order_data_after_billing_address', array( $this, 'display_custom_order_meta_in_admin_order_details' ), 10, 1 );
		add_action( 'woocommerce_admin_order_data_after_shipping_address', array( $this, 'get_custom_shipping_order_meta' ), 10, 1 );
		add_action( 'woocommerce_order_details_after_customer_address', array( $this, 'display_custom_order_meta_in_my_account_order_details' ), 10, 2 );
		add_filter('woocommerce_order_needs_shipping_address', '__return_true');

	}

	/**
	 * Show custom order meta on admin order details page
	 *
	 * @param object $order
	 * @return void
	 */
	public function display_custom_order_meta_in_admin_order_details( $order ) {
		$this->get_custom_order_meta( $order );
	}

	/**
	 * Show custom order meta on customer my account order details page
	 *
	 * @param string $address_type
	 * @param object $order
	 * @return void
	 */
	public function display_custom_order_meta_in_my_account_order_details( $address_type, $order ) {
		if('billing' === $address_type){
			$this->get_custom_order_meta( $order );
		}else{
			$this->get_custom_shipping_order_meta($order);
		}
	}

	/**
	 * Function to show custom order meta
	 *
	 * @param object $order
	 * @return void
	 */
	public function get_custom_order_meta( $order ) {
		$billing_house_no = $order->get_meta( 'billing_house_no' );
		if ( $billing_house_no ) {
			echo '<p><strong>' . __( 'House No.', 'oak-food-multi-step-checkout' ) . ':</strong> ' . esc_html( $billing_house_no ) . '</p>';
		}

		$delivery_date = $order->get_meta( 'delivery_date' );
		if ( $delivery_date ) {
			echo '<p><strong>' . __( 'Delivery Date', 'oak-food-multi-step-checkout' ) . ':</strong> ' . esc_html( $delivery_date ) . '</p>';
		}

		$delivery_time = $order->get_meta( 'delivery_time' );
		if ( $delivery_time ) {
			echo '<p><strong>' . __( 'Delivery Time', 'oak-food-multi-step-checkout' ) . ':</strong> ' . esc_html( $delivery_time ) . '</p>';
		}
	}

	/**
	 * Function to show custom shipping order meta
	 *
	 * @param object $order
	 * @return void
	 */
	public function get_custom_shipping_order_meta( $order ) {
		$shipping_house_no = $order->get_meta( 'shipping_house_no' );
		if ( $shipping_house_no ) {
			echo '<p><strong>' . __( 'House No.', 'oak-food-multi-step-checkout' ) . ':</strong> ' . esc_html( $shipping_house_no ) . '</p>';
		}

		$shipping_delivery_date = $order->get_meta( 'shipping_delivery_date' );
		if ( $shipping_delivery_date ) {
			echo '<p><strong>' . __( 'Delivery Date', 'oak-food-multi-step-checkout' ) . ':</strong> ' . esc_html( $shipping_delivery_date ) . '</p>';
		}

		$shipping_delivery_time = $order->get_meta( 'shipping_delivery_time' );
		if ( $shipping_delivery_time ) {
			echo '<p><strong>' . __( 'Delivery Time', 'oak-food-multi-step-checkout' ) . ':</strong> ' . esc_html( $shipping_delivery_time ) . '</p>';
		}
	}
}
