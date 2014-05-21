<?php
$controller = $this->params['controller'];
$action = $this->params['action'];
$class = '';
?>

 <!--Tabs Widget Start-->
<div class="tabs-widget">
	<ul>
		<li>
		<?php if($controller == 'orders' && $action == 'view_open_orders'){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php echo $html->link("View Open Order", array("controller"=>"orders","action"=>"view_open_orders"),array('class'=>$class,'id'=>""),null, false); ?>
		</li>
		<li>
		<?php if($controller == 'orders' && $action == 'order_history'){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php echo $html->link("Order History", array("controller"=>"orders","action"=>"order_history"),array('class'=>$class,'id'=>""),null, false); ?>
		</li>
		<li>
		<?php if($controller == 'orders' && $action == 'return_items'){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php echo $html->link("Return Items", array("controller"=>"orders","action"=>"return_items"),array('class'=>$class,'id'=>""),null, false); ?>
		</li>
		<li>
		<?php if($controller == 'orders' && $action == 'contact_sellers'){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php echo $html->link("Contact Sellers", array("controller"=>"orders","action"=>"contact_sellers"),array('class'=>$class,'id'=>"homes"),null, false); ?>
		</li>
		<li>
		<?php if($controller == 'orders' && $action == 'leave_seller_feedback'){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php echo $html->link("Leave Seller Feedback", array("controller"=>"orders","action"=>"leave_seller_feedback"),array('class'=>$class,'id'=>""),null, false); ?>
		</li>
	</ul>
</div>
<!--Tabs Widget Closed-->