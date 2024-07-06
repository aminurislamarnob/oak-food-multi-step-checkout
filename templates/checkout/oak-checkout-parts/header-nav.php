<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use PluginizeLab\OakFoodMultiStepCheckout\Helpers;
?>
<!-- common header start -->
<div class="common-header-wrap">
	<div class="txt delivery-step-btn <?php echo ! Helpers::is_pm_visible() ? 'active' : ''; ?>">
		<h5><?php echo esc_html__( 'Delivery', 'oak-food-multi-step-checkout' ); ?></h5>
		<hr>
	</div>
	<div class="txt fact-step-btn">
		<h5><?php echo esc_html__( 'Facts', 'oak-food-multi-step-checkout' ); ?></h5>
		<hr>
	</div>
	<div class="txt pm-step-btn <?php echo Helpers::is_pm_visible() ? 'active' : ''; ?>">
		<h5><?php echo esc_html__( 'Payment Method', 'oak-food-multi-step-checkout' ); ?></h5>
		<hr>
	</div>
</div>