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
	<?php // display session error message
		if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock"><?php echo $session->flash();?></div>
	<?php } ?>
	<section class="gr_grd brd-tp0">
	<h4 class="orng-clr">Review Listing Details</h4>
	</section>
	
	<!--mid Content Start-->
	<div class="mid-content">
	<!--Product Listings Widget Start-->
	<div class="products-listings-widget">
		<!--Row1 Start-->
		<div class="pro-listing-row">
		<div class="pro-img">
			<?php
				if($product_details['Product']['product_image'] == 'no_image.gif' || $product_details['Product']['product_image'] == 'no_image.jpeg'){
					$image_path = 'no_image.jpeg';
				} else{
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$product_details['Product']['product_image'];
					if(!file_exists($image_path) ){
						$image_path = 'no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$product_details['Product']['product_image'];
					}
				}
				echo $html->link($html->image($image_path, array('alt'=>"",'width'=>'79','height'=>'69')),'/'.$this->Common->getProductUrl($product_details['Product']['id']).'/categories/productdetail/'.$product_details['Product']['id'],array('escape'=>false,));
				?>
		</div>
		<div class="product-details-widget">
		<h4 class="lstprdctname">
			<?php echo $html->link($product_details['Product']['product_name'],'/'.$this->Common->getProductUrl($product_details['Product']['id']).'/categories/productdetail/'.$product_details['Product']['id'],array('escape'=>false,'class'=>'underline-link'));?>.
		</h4>
			<p class="lgtgray">
				<strong>Model # 
					<?php echo $product_details['Product']['model_number'];?>
				</strong>
			</p>
			<p class="lgtgray">
				<strong>QuickCode: 
					<?php echo $product_details['Product']['quick_code'];?>
				</strong>
			</p>
			<p class="lgtgray">
				<strong>Number of Sellers: 
					<?php echo $product_sellers_count; ?>
				</strong>
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
		<li><p>Please review your listing details; click '<a href="javascript:history.go(-1)">Back</a>' to return to the previous screens and make any changes. You will be able to update these details later if necessary.</p>
		</li>
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
					<div class="listing-row-right">
						<strong>
							<?php
							$country_array = $common->getcountries();
							echo $country_array[$data['ProductSeller']['dispatch_country']];?>
						</strong>
					</div>
				</li>
				
				<li>
					<div class="listing-row-left orange-col"><strong>Quantity</strong></div>
					<div class="listing-row-right">
						<strong>
							<?php echo $data['ProductSeller']['quantity']; ?>
						</strong>
					</div>
				</li>
				</ul>
			</div>
			
			<div class="listing-row border-bottom">
				<ul>
				<li>
					<div class="listing-row-left orange-col"><strong>Offer Price</strong></div>
					<div class="listing-row-right">
						<?php echo CURRENCY_SYMBOL.' '.$format->money($data['ProductSeller']['price'],2); ?>
					</div>
				</li>
				
				<li>
					<div class="listing-row-left orange-col"><strong>Standard Delivery Price</strong></div>
					<div class="listing-row-right"><?php echo CURRENCY_SYMBOL.' '.$format->money($data['ProductSeller']['standard_delivery_price'],2); ?></div>
				</li>
				</ul>
			</div>
				
			<div class="listing-row">
				<ul>
				<li>
					<div class="listing-row-left orange-col"><strong>Expendited Delivery</strong></div>
					<div class="listing-row-right">
						<strong>
							<?php echo($data['ProductSeller']['express_delivery'] == 1)?('Enabled'):('Disabled'); ?>
						</strong>
					</div>
				</li>
				
				<li>
					<div class="listing-row-left orange-col">
						<strong>
							Minimum Price
						</strong>
					</div>
					<div class="listing-row-right">
						<strong>
							<?php echo($data['ProductSeller']['minimum_price_disabled'] == 1)?('Disabled'):('Enabled'); ?>
						</strong>
					</div>
				</li>
				</ul>
			</div>
			</li>
			</ul>
		</li>
		<li>
			<div class="gray-ins-widget">
				<strong>Clicking 'Confirm' to complete this process commits you to agree to the terms of our
					<?php echo $html->link('Agreement', '/pages/view/marketplace-user-agreement', array('class'=>'diff-blu', 'target'=>'_blank' ));?>
				</strong>
			</div>
		</li>
		</ul>  
	</div>
	<!--Form Widget Closed-->
	
	<!--For Going Back To Previous Page-->
	<section class="backbtnbox">
		<?php echo $form->submit('Confirm',array('type'=>'submit','div'=>false,'class'=>'grenbtn'));?>
		
		<!--<input type="button" value="Confirm" class="grenbtn"/>--></section>
	<!--For Going Back To Previous End-->  
	<?php echo $form->end();?>
</div>
<!--mid Content Closed-->
</section>
<!--Manage Listings Closed-->

</section>
<!--Tbs Cnt closed-->
