<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use PluginizeLab\OakFoodMultiStepCheckout\Helpers;
?>
<!-- common header start -->
<div class="common-header-wrap">
	<div class="txt delivery-step-btn <?php echo ! Helpers::is_pm_visible() ? 'active' : ''; ?>">
		<h5>Delivery</h5>
		<hr>
	</div>
	<div class="txt fact-step-btn">
		<h5>Facts</h5>
		<hr>
	</div>
	<div class="txt pm-step-btn <?php echo Helpers::is_pm_visible() ? 'active' : ''; ?>">
		<h5>Payment Method</h5>
		<hr>
	</div>
</div>