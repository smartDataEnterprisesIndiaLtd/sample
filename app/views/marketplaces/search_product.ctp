<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);

?>
<style>
.float-left div{padding-top:0px}
</style>
<!--mid Content Start-->
<div class="mid-content pad-rt-none">
	<?php // display session error message
	if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock"><?php echo $session->flash();?></div>
	<?php } ?>
	<!--Setting Tabs Widget Start
	<?php echo $this->element('marketplace/breadcrum');?> -->
	<div class="row-widget">
		<?php echo $this->element('navigations/seller_heading_bar'); ?>
		<!--Tabs Content Start-->
		<div class="tabs-content">
			<!--Choice Headding Start-->
			<h2 class="choice_headding choiceful">Add a Product Listing</h2>
			<!--Choice Headding Closed-->
			<!--Discription Start-->
			<div class="inner-content">
				<p>The products you are adding may already exist on Choiceful. Search our catalogue for the product you want to sell and save yourself some time.</p>
			</div>
			
			
			<!--Discription Closed-->
		</div>
		<!--Tabs Content Closed-->
	</div>
	<!--Setting Tabs Widget Closed-->
</div>
<!--mid Content Closed-->
<!--Bottom Search Start-->
<div class="bottom-search padding-bottom">
	<?php echo $form->create('Marketplace',array('action'=>'search_product','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace')); ?>
	<div class="gray-bar"><strong>Find it on Choiceful.com:</strong> 
		<?php echo $form->input('Marketplace.search_product_name',array('class'=>'form-textfield bigger-input','label'=>false,'div'=>false,'error'=>false,'value'=>$search_word));?>
		<?php echo $form->submit('go-grn-btn.gif',array('alt'=>'Search','type'=>'image','border'=>'0', "value"=>"search",'class'=>'v-align-middle','div'=>false)); ?>
	</div>
	<?php echo $form->end();?>
	<?php if(empty($products)){ ?>
	<p class="marketplace-links-sec">
		<!--Still can't find it?-->
		<?php //echo $html->link('Create a new product listing here',"/marketplaces/upload_listing",array('escape'=>false,'class'=>'underline-link'));?>
	
	<?php echo $html->link('<strong>Bulk Listing for Volume Sellers</strong>',"/marketplaces/upload_listing",array('escape'=>false,'class'=>'underline-link'));?>&nbsp; |&nbsp;
	<?php echo $html->link('<strong>Create Manual Listing for Manufacturers and Publishers</strong>',"/marketplaces/create_product_step1",array('escape'=>false,'class'=>'underline-link'));?></p>
	<?php } ?>
	<div id="listing"><?php echo $this->element('marketplace/search_results');?></div>
</div>
<!--Bottom Search Closed-->