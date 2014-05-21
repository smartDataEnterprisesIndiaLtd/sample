<?php
$controller = $this->params['controller'];
$action = $this->params['action'];
$class = '';
?>
 <!--Tabs Widget Start-->
<section class="tabs-widget">
<ul>
	<li>
		<?php if($controller == 'orders' && $action == 'view_open_orders' || $controller == 'orders' && $action == 'cancel'){
			$class = 'active';
		} else{
			$class = '';
		}?>
		
		<?php echo $html->link('Open <span class="ln-brk">Orders</span>', array("controller"=>"orders","action"=>"view_open_orders"),array('escape'=>false,'class'=>$class,'id'=>""),null, false); ?>
	</li>
	
	<li>
		<?php if(($controller == 'orders' && $action == 'order_history') || ($controller == 'orders' && $action == 'return_items') || ($controller == 'orders' && $action == 'leave_seller_feedback') || ($controller == 'orders' && $action == 'file_a_claim')|| ($controller == 'orders' && $action == 'contact_sellers')){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php echo $html->link('Order <span class="ln-brk">History</span>', array("controller"=>"orders","action"=>"order_history"),array('escape'=>false,'class'=>$class,'id'=>""),null, false); ?>
	</li>
	<li class="wider" style="width:18%">
		<?php if(($controller == 'offers' && $action == 'manage_offers') || ($controller == 'offers' && $action == 'update_offer_status') || ($controller == 'offers' && $action == 'edit') || ($controller == 'offers' && $action == 'delete_offer')){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php //echo $html->link("My Offers", array("controller"=>"offers","action"=>"manage_offers"),array('class'=>$class,'id'=>""),null, false); ?>
		<?php echo $html->link('My <span class="ln-brk">Offers</span>', array("controller"=>"offers","action"=>"manage_offers"),array('escape'=>false,'class'=>$class,'id'=>""),null, false); ?>
	</li>
	
	<li class="wider">
		<?php if($controller == 'certificates' && $action == 'gift_balance'){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php echo $html->link('Gift <span class="ln-brk">Certificates</span>', array("controller"=>"certificates","action"=>"gift_balance"),array('escape'=>false , 'class'=>$class,'id'=>"homes"),null, false); ?>
	</li>
	
	<li class="wider single orng-link">
		<?php if(($controller == 'marketplaces' && $action == 'manage_listing') || ($controller == 'sellers' && $action == 'orders') || ($controller == 'marketplaces' && $action == 'sales_report') || ($controller == 'sellers' && $action == 'my_account') || ($controller == 'marketplaces' && $action == 'search_product') || ($controller == 'marketplaces' && $action == 'create_listing')|| ($controller == 'marketplaces' && $action == 'review_listing')  || ($controller == 'marketplaces' && $action == 'confirm_listing')|| ($controller == 'sellers' && $action == 'sign-up') || ($controller == 'users' && $action == 'my_account') || ($controller == 'sellers' && $action == 'order_details') ){
			$class = 'active';
		} else{
			$class = '';
		}?>
		<?php 
		echo $html->link("Marketplace", array("controller"=>"marketplaces","action"=>"manage_listing"),array('class'=>'border-none '.$class,'id'=>""),null, false); ?>
	</li>
</ul>
</section>
<!--Tabs Widget Closed-->