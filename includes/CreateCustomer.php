<?php

namespace PluginizeLab\OakFoodMultiStepCheckout;

class CreateCustomer extends \WC_Checkout {
	public function create_customer_on_checkout( $posted_data ) {
		$this->process_customer( $posted_data );
	}
}
