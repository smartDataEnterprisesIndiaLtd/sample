<?php 
// $action = $this->params['action'];
// $action_array = array('my_account','manage_offers','accepted_offers','rejected_offers' );
$user_logged_in = $this->Session->read('User');
?>
<!--Right Widget Start-->
<div class="right-widget">
	<?php if(!empty($user_logged_in) ){?>
	<?php
		echo $this->element('navigations/message');
		echo $this->element('navigations/choiceful_services');
		echo $this->element('navigations/help');
		
	}else{
		echo $this->element('navigations/help');
		echo $this->element('navigations/business');
		echo $this->element('navigations/secure_shopping');
		
	}
	?>
</div>
	<!--Right Widget Closed-->
	
