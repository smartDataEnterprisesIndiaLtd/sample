<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
?>
<!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab')?>
<!--Tbs Closed-->
<!--Tbs Cnt start-->
<section class="tab-content padding0">
<!--Manage Listings Start-->
<section class="offers">
	<section class="gr_grd brd-tp0">
	<h4 class="orange-col-head">Add a Product Listing</h4>
	</section>
	<!--Row1 Start-->
	<div class="row-sec">
	<p style="padding:0 0 8px;">The product you are adding may already exist on Choiceful. Search our catalogue for the product you want to sell and save yourself some time.</p>
	
	<!--Search Results Start-->
		<div class="overflow-h">
		<?php // display session error message
		if ($session->check('Message.flash')){ ?>
			<div  class="messageBlock"><?php echo $session->flash();?></div>
		<?php } ?>
		
		<div class="gry-clr-br">
			<?php echo $form->create('Marketplace',array('action'=>'search_product','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace')); ?>
			<ul>
			<li><strong>Find it on Choiceful.com</strong>
				<?php echo $form->input('Marketplace.search_product_name',array('class'=>'input les-width','label'=>false,'div'=>false,'error'=>false));?>
				
				<?php echo $form->submit('Go',array('class'=>'grngradbtn','div'=>false)); ?>
			</li>
			</ul>
			<?php echo $form->end();?>
		</div>
		<!--Search Widget Closed-->
		</div>
		<!--Search Results Closed-->
		
		<div id="listing"><?php echo $this->element('mobile/marketplace/search_results');?></div>
	</div>
	<!--Row1 Closed-->		
	
	
</section>
<!--Manage Listings Closed-->