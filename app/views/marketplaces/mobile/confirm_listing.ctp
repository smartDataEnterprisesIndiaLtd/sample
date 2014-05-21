<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
//pr($data);
?>
<style>
.pro-img{width: 90px;}
</style>
<!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->
<!--Tbs Cnt start-->
<section class="tab-content padding0">
<!--Manage Listings Start-->
<section class="offers">                	
	<section class="gr_grd brd-tp0">
	<h4 class="orange-col-head"> Listing Confirmation</h4>
	</section>
	
	<?php // display session error message
		if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock"><?php echo $session->flash();?></div>
	<?php } ?>
	
	<!--mid Content Start-->
	<div class="mid-content">
	<!--Product Listings Widget Start-->
	<div class="products-listings-widget">
		<!--Row1 Start-->
		<div class="pro-listing-row">
		<div class="pro-img">
			<?php
				if($product_details['Product']['product_image'] == 'no_image.gif' || $product_details['Product']['product_image'] == 'no_image.jpeg'){
					$image_path = '/img/no_image.jpeg';
				} else{
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$product_details['Product']['product_image'];
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$product_details['Product']['product_image'];
					}
				}
				echo $html->link($html->image($image_path, array('alt'=>"",'width'=>'79','height'=>'69')),'/'.$this->Common->getProductUrl($product_details['Product']['id']).'/categories/productdetail/'.$product_details['Product']['id'],array('escape'=>false,));
			?>
		</div>
		<div class="product-details-widget">
			<h4 class="lstprdctname">
			<?php echo $html->link($product_details['Product']['product_name'],'/'.$this->Common->getProductUrl($product_details['Product']['id']).'/categories/productdetail/'.$product_details['Product']['id'],array('escape'=>false,'class'=>'underline-link'));?>
			</h4>
			<p class="lgtgray"><strong>Model # <?php echo $product_details['Product']['model_number'];?></strong></p>
			<p class="lgtgray">
				<strong>QuickCode: 
					<?php echo $product_details['Product']['quick_code'];?>
				</strong>
			</p>
			<p class="lgtgray">
				<strong>Number of Sellers: <?php echo $product_sellers_count;?></strong>
			</p>
		</div>
		<div class="clear"></div>
		</div>
		<!--Row1 Closed-->
	</div>
	<!--Product Listings Widget Closed-->
	
	<!--Form Widget Start-->
	<?php echo $form->create('Marketplace',array('action'=>'review_listing','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));
    	echo $form->hidden('FormData.confirm', array('value'=>'yes'));
	?>
	<div class="form-widget row-sec">
		<ul>
		<li><p>Please review your listing details; You will be able to update these details later if necessary.</p></li>
		<li>
			<ul class="listing-left">
			<li class="pad-none">
			<div class="listing-row border-bottom">
				<ul>
				<li>
					<div class="listing-row-left orange-col"><strong>Condition</strong></div>
					<div class="listing-row-right">
						<strong>
							<?php echo $product_condition_array[$data['ProductSeller']['condition_id']];?>
						</strong>
					</div>
				</li>
				
				<li>
					<div class="listing-row-left orange-col"><strong>Dispatched from country</strong></div>
					<div class="listing-row-right"><strong><?php
						$country_array = $common->getcountries();
						echo $country_array[$data['ProductSeller']['dispatch_country']];?></strong></strong></div>
				</li>
				
				<li>
					<div class="listing-row-left orange-col"><strong>Quantity</strong></div>
					<div class="listing-row-right"><strong><?php echo $data['ProductSeller']['quantity']; ?></strong></div>
				</li>
				</ul>
			</div>
			
			<div class="listing-row border-bottom">
				<ul>
				<li>
					<div class="listing-row-left orange-col"><strong>Offer Price</strong></div>
					<div class="listing-row-right"><?php echo CURRENCY_SYMBOL;?> <?php echo $data['ProductSeller']['price']; ?></div>
				</li>
				
				<li>
					<div class="listing-row-left orange-col"><strong>Standard Delivery Price</strong></div>
					<div class="listing-row-right"><?php echo CURRENCY_SYMBOL;?> <?php echo $data['ProductSeller']['standard_delivery_price']; ?></div>
				</li>
				</ul>
			</div>
				
			<div class="listing-row">
				<ul>
				<li>
					<div class="listing-row-left orange-col"><strong>Expendited Delivery</strong></div>
					<div class="listing-row-right"><strong><?php echo($data['ProductSeller']['express_delivery'] == 1)?('Enabled'):('Disabled'); ?></strong></strong></div>
				</li>
				
				<li>
					<div class="listing-row-left orange-col"><strong>Minimum Price</strong></div>
					<div class="listing-row-right"><strong><?php echo($data['ProductSeller']['minimum_price_disabled'] == 1)?('Disabled'):('Enabled'); ?></strong></div>
				</li>
				</ul>
			</div>
			</li>
			</ul>
		</li>
		<li>
		<div class="yellow-box">
			<div class="cnfirm-img">
				<?php //echo $html->image('mobile/confirm-icon.png', 	array('width'=>'12','height'=>'12','alt'=>'Confirm'));?>
				<img width="12" height="12" alt="" src="<?php echo SITE_URL;?>img/confirm-icon.png">
			</div>
			<div class="cnfirm-content"><p>Your Listing has been successfully added</p>
			<p>
				<?php echo $html->link('Manage my Listings', '/marketplaces/manage_listing', array('class'=>'underline-link', 'alt'=>'', 'div'=>false,'escape'=>false) );?> <span style="color:#000;">or</span>
				<?php echo $html->link('Add Another Listings', '/marketplaces/search_product', array('class'=>'underline-link', 'alt'=>'', 'div'=>false,'escape'=>false) );?>
				<!--<a class="underline-link" href="#">Mange my Listings or Add Another Listings</a>--></p>
			</div>
			</div>
		</li>
		</ul>  
		</div>
	<!--Form Widget Closed-->
	<?php echo $form->end(); ?>
	
	

</div>
<!--mid Content Closed-->
</section>
<!--Manage Listings Closed-->

</section>
<!--Tbs Cnt closed-->