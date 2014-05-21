<style>
.messageBlock {
    margin: 0px 0;
}
/*.row-widget {
    padding: 0px 0;
}*/
.flashError {
     margin-top: 0px;
}
.message {
    margin-top: 0px;
}
</style>
<?php
if ($session->check('Message.flash')){ ?>
	<div class="messageBlock"><?php echo $session->flash();?></div>
<?php }
?>
<div class="account-setting">
	
	<!--Gray Back heading Start-->
	<div class="gray-bg-heading">
		<ul>
			<li class="head"><strong>Customer Service Contact Information</strong></li>
			<li class="closed-link"><?php echo $ajax->link('Change','', array('update' => 'cus-info', 'url' => '/sellers/update_customer_info/','class'=>'blk-bg-link bold_this_link', 'style'=>'font-weight: bold;',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading()",), null,false);?></li>
		</ul>
	</div>
	<!--Gray Back heading Closed-->
	
	<!--Account Setting Fields Start-->
	<div class="account-setting-fields">
		<!--Account Setting Fields Rows Start-->
		<ul class="account-setting-fields-rows">
			<li>
				<div class="account-setting-fields-label">Customer Service Email:</div>
				<div class="account-setting-fields-field"><?php echo $this->data['Seller']['service_email'];?></div>
			</li>
			<li>
				<div class="account-setting-fields-label">Contact Phone Number:</div>
				<div class="account-setting-fields-field"><?php echo $this->data['Seller']['phone'];?></div>
			</li>
			<li>
				<div class="account-setting-fields-label" style="margin-top:4px;">Seller Display Image:</div>
				<div class="account-setting-fields-field" style="float:none;overflow:hidden;">
					<div id="upload-image">
					<?php echo $this->element('/marketplace/upload_image'); ?>
				</div>
					
			</li>
		</ul>
		<!--Account Setting Fields Rows Closed-->
	</div>
	<!--Account Setting Fields Closed-->
</div>