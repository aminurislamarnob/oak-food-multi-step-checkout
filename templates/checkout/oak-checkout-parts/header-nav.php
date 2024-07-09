<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use PluginizeLab\OakFoodMultiStepCheckout\Helpers;
?>
<!-- common header start -->
<div class="common-header-wrap">
	<div class="txt delivery-step-btn <?php echo ! Helpers::is_pm_visible() ? 'active' : 'passed-step'; ?>">
		<h5>
			<?php echo esc_html__( 'Delivery', 'oak-food-multi-step-checkout' ); ?>
			<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
				<path d="M6.25 16.25L11.25 21.25L23.75 8.75" stroke="#36B37E" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</h5>
		<hr>
	</div>
	<div class="txt fact-step-btn <?php echo Helpers::is_pm_visible() ? 'passed-step' : ''; ?>">
		<h5>
			<?php echo esc_html__( 'Facts', 'oak-food-multi-step-checkout' ); ?>
			<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
				<path d="M6.25 16.25L11.25 21.25L23.75 8.75" stroke="#36B37E" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</h5>
		<hr>
	</div>
	<div class="txt pm-step-btn <?php echo Helpers::is_pm_visible() ? 'active' : ''; ?>">
		<h5>
			<?php echo esc_html__( 'Payment Method', 'oak-food-multi-step-checkout' ); ?>
			<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
				<path d="M6.25 16.25L11.25 21.25L23.75 8.75" stroke="#36B37E" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</h5>
		<hr>
	</div>
</div>