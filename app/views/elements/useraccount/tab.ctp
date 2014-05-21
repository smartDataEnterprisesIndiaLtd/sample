<?php
$controller = $this->params['controller'];
$action = $this->params['action'];
$class = '';
?>
<!--Tabs Widget Start-->
<div class="tabs-widget">
	<ul>
		<li>
		<?php if($controller == 'users' && $action == 'my_account'){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php echo $html->link("Personal Details", array("controller"=>"users","action"=>"my_account"),array('class'=>$class,'id'=>"homes"),null, false); ?>
		</li>
		<li>
		<?php if($controller == 'users' && $action == 'manage_addresses'){
			$class = 'active';

		} else{
			$class = '';
		}?>
		<?php echo $html->link("Manage Addresses", array("controller"=>"users","action"=>"manage_addresses"),array('class'=>$class,'id'=>"homes"),null, false); ?></li>
		<li>
		<?php
			$tab_name = 'Add New';
		if($controller == 'users' && $action == 'add_address'){
			$class = 'active';
			if(!empty($this->data)){
				if(!empty($this->data['Address']['id'])){
					$tab_name = 'Update';
				}
			}
			
		} else{
			$class = '';
		}?>
		<?php echo $html->link($tab_name." Address", array("controller"=>"users","action"=>"add_address"),array('class'=>$class,'id'=>"homes"),null, false); ?></li>
		<li>
		<?php if($controller == 'users' && $action == 'email_alerts'){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php echo $html->link("E-Mail &amp; Alerts", array("controller"=>"users","action"=>"email_alerts"),array('escape'=>false,'class'=>$class,'id'=>"homes"),null, false); ?></li>
		<li>
		<?php if($controller == 'users' && $action == 'events_calendar'){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php echo $html->link("Events Calendar", array("controller"=>"users","action"=>"events_calendar"),array('class'=>$class,'id'=>"homes"),null, false); ?></li>
	</ul>
</div>
<!--Tabs Widget Closed-->