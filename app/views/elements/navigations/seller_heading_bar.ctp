<?php 
$action = $this->params['action'];
$manage_listing_array = array('manage_listing' ,'upload_listing','create_product_step1','create_product_step2',
			      'create_product_step3','search_product' ) ;
?>
<div class="tabs-widget">
	<ul>
		<li><?php 
			if( in_array($action , $manage_listing_array)){
				$tab_class = 'active';
			} else{
				$tab_class = '';
			}
		echo $html->link('Manage Listing',"/marketplaces/manage_listing",array('escape'=>false,'title'=>'','class'=>$tab_class));?></li>
		<li><?php
			if($controller="sellers" && ($action == 'orders' || $action == 'order_details' || $action == 'ship_order' || $action == 'cancel_order' || $action == 'refund_order')){
				$tab_class = 'active';
			} else{
				$tab_class = '';
			}
		echo $html->link('View Orders',"/sellers/orders",array('escape'=>false,'class'=>$tab_class));?></li>
		<li><?php 
			if($action == 'sellers'){
				$tab_class = 'active';
			} else{
				$tab_class = '';
			}
		echo $html->link('Buyer Communication',"/messages/sellers",array('escape'=>false,'title'=>'','class'=>$tab_class));?></li>
		<li><?php 
			if($action == 'sales_report'){
				$tab_class = 'active';
			} else{
				$tab_class = '';
			}
		echo $html->link('Sales Reports',"/marketplaces/sales_report/",array('escape'=>false,'class'=>$tab_class));?></li>
		<li><?php 
			if($action == 'payment_settings' || $action == 'deposit' || $action == 'payment_summary'){
				$tab_class = 'active';
			} else{
				$tab_class = '';
			}
		echo $html->link('Payment Settings',"/sellers/payment_settings",array('escape'=>false,'title'=>'','class'=>$tab_class));?></li>
		<li><?php 
			if($action == 'my_account'){
				$tab_class = 'active';
			} else{
				$tab_class = '';
			}
		echo $html->link('Account Settings',"/sellers/my_account",array('escape'=>false,'title'=>'','class'=>$tab_class));?></li>
	</ul>
</div>