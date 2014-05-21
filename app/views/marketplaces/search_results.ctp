<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
/*if(!isset($search_word)){
	$search_word = "";
}*/
?>
<style>
.float-left div{padding-top:0px}
</style>
<div class="mid-content">
	<?php // display session error message
	if($session->check('Message.flash')){ ?>
		<div  class="messageBlock"><?php echo $session->flash();?></div>
	<?php } ?>
	<!--Blue Head Box Start-->
	<div class="blue-head-bx">
		<h5 class="bl-bg-head">Add a Product</h5>
		<!--White box Start-->
		<div class="wt-bx-widget">
			<!--Form Widget Start-->
			<div class="form-widget">
				<ul>
					<li><p class="pdng newpdng">The product you are adding may already exist on Choiceful. Search our catalogue for the product you want to sell and save yourself some time.</p>
					</li>
					<li>
						<?php echo $form->create('Marketplace',array('action'=>'search_results','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace')); ?>
						<div class="gray-bar"><strong>Find it on Choiceful.com:</strong>
							
							<?php echo $form->input('Marketplace.search_product_name',array('class'=>'form-textfield bigger-input','label'=>false,'div'=>false,'error'=>false, 'value'=>$search_word));?>
							<?php echo $form->submit('',array('alt'=>'Search','type'=>'image','src'=>SITE_URL.'/img/go-grn-btn.gif','border'=>'0', "value"=>"search",'class'=>'v-align-middle','div'=>false)); ?>
						</div>
						<?php  echo $form->end();?>
						<p class="marketplace-links-sec">
							Still can't find it?
							<?php echo $html->link('Create a new product listing here',"/marketplaces/create_product_step1",array('escape'=>false,'class'=>'underline-link'));?>
							<?php //echo $html->link('Create a new product listing here',"/marketplaces/upload_listing",array('escape'=>false,'class'=>'underline-link'));?>
							<?php //echo $html->link('<strong>Bulk Listing for Volume Sellers</strong>',"/marketplaces/upload_listing",array('escape'=>false,'class'=>'underline-link'));?><!--&nbsp; |&nbsp;-->
							<?php //echo $html->link('<strong>Create Manual Listing for Manufacturers and Publishers</strong>',"/marketplaces/create_product_step1",array('escape'=>false,'class'=>'underline-link'));?>
						</p>
					</li>
				</ul>
			</div>
			<!--Form Widget Closed-->
		</div>
		<!--White box Start-->
	</div>
	<!--Blue Head Box Closed-->
</div>
<div id="listing"><?php echo $this->element('marketplace/search_results');?></div>