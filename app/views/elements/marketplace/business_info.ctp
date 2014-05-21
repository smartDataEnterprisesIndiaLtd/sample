<?php
if ($session->check('Message.flash')){ ?>
	<div class="messageBlock"><?php echo $session->flash();?></div>
<?php }
?>
<div class="account-setting">
	<!--Gray Back heading Start-->
	<div class="gray-bg-heading">
		<ul>
			<li class="head"><strong>Business Information</strong></li>
			<li class="closed-link"><?php echo $ajax->link('Change','', array('update' => 'business-info', 'url' => '/sellers/update_business_info/','class'=>'blk-bg-link', 'style'=>'font-weight: bold;',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading()",), null,false);?></li>
		</ul>
	</div>
	
	<!--Gray Back heading Closed-->
	<!--Account Setting Fields Start-->
	<div class="account-setting-fields">
		<!--Account Setting Fields Rows Start-->
		<ul class="account-setting-fields-rows">
			<li>
				<div class="account-setting-fields-label">Business Display Name:</div>
				<div class="account-setting-fields-field"><?php echo $this->data['Seller']['business_display_name']; ?></div>
			</li>
			<li>
				<div class="account-setting-fields-label">Business Address:</div>
				<div class="account-setting-fields-field"><?php echo $this->data['Seller']['address1']; ?>,
				<?php echo $this->data['Seller']['address2']; ?>  
				<span class="padding-left"><?php echo $this->data['Seller']['city']; ?></span>
				<span class="padding-left"><?php echo $this->data['Seller']['state']; ?></span> 
				<span class="padding-left"><?php echo $this->data['Seller']['postcode']; ?></span>  
				<span class="padding-left"><?php echo $this->data['Country']['country_name']; ?>
				</span></div>
			</li>
		</ul>
		<!--Account Setting Fields Rows Closed-->
	</div>
	<!--Account Setting Fields Closed-->
</div>