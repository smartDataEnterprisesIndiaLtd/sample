<?php 
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'));

echo $form->create('Offer',array('action'=>'delete_offer/',$offer_id,'method'=>'POST','name'=>'frmOffer','id'=>'frmOffer'));

?>
<!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->
<!--Tbs Cnt start-->
<section class="tab-content padding0">
<!--My Offers Start-->
<section class="offers">                	
	<section class="gr_grd brd-tp0">
	<h4 class="bl-cl">My Offers</h4>
	<!--<div class="loader-img"><img src="images/loader.gif" width="22" height="22" alt="" /></div>-->
	</section>
	<!--Row1 Start-->
	<div class="row-sec">
	
	<h4 class="font14 choiceful">Delete My Offer</h4>
		<?php 
			if ($session->check('Message.flash')){ ?>
			<div class="messageBlock"><?php echo $session->flash();?></div>
	
		<?php }?>
	<!--Products Start-->
	<?php if(is_array($offers_details)  &&  !empty($offer_id) ) { ?>
	<div class="prod">
		<!--Order Products Widget Start-->
		<div class="order-products-widget">
		<div class="order-product-image">
			<?php
			$product_id=$offers_details['Product']['id'];
			$prodDetails = $this->Common->getProductMainDetails($product_id);
				if(!empty($prodDetails['Product']['product_image'])){
					$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'];
					
					if(file_exists($product_image)){
						echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'],array('alt'=>"")),'/'.$this->Common->getProductUrl($product_id).'/categories/productdetail/'.$product_id,array('escape'=>false));
					}else{
						echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($product_id).'/categories/productdetail/'.$product_id,array('escape'=>false));
					}
				}else{
					echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($product_id).'/categories/productdetail/'.$product_id,array('escape'=>false));
				}?>
		</div>
		<!--Order Product Content Start-->
		<div class="order-product-content">
			<!--Order Product Information Start-->
			<div class="order-pro-info">
			<p class="font11">Withdraw your offer before the seller responds.</p>
			<p class="toppadd">
				<b class="font14">Item: </b>
				<?php echo $offers_details['Product']['product_name'];?>
			</p>
			<p>
				<b class="font14">Seller: </b>
				<?php echo $offers_details['Seller']['business_display_name'];?>
			</p>
			</div>
			<!--Order Product Information Closed-->
		</div>
		<!--Order Product Content Closed-->                        
		<div class="clear"></div>
		
		<!--Seller Offer Start-->
		<div class="seller-offers">
			<ul>
			<li class="boldr">I want to pay:
				<span class="diff-blu">
					<?php echo CURRENCY_SYMBOL,$offers_details['Offer']['offer_price'];?>
				</span>
			</li>
			<li class="boldr">How many would you like to buy?:
				<span class="diff-blu">
					<?php echo $offers_details['Offer']['quantity'];?>
				</span>
			</li>
			<li class="boldr">
			Expires on: <span class="redcolor">
			<?php
				$current_date = $offers_details['Offer']['created']; // current date
				echo $expiry_date = date('d/m/Y', strtotime(date("Y-m-d", strtotime($current_date)) . " +2 day"));
		
				$offer_value = ($offers_details['Offer']['offer_price'] *$offers_details['Offer']['quantity']);
		 
		?>
		
		</span>
			<span style="margin-left:15px;">Offer value: </span>
				<?php echo CURRENCY_SYMBOL,number_format($offer_value, 2, '.', '');?>
				<span id="total_offer_price_id"></span>
				
			</li>
				<li class="margin-top">
					<?php echo $form->hidden('Offer.id',array('value'=>$offer_id,'type'=>'text','label'=>false,'class'=>'textfield','div'=>false));?>
					<?php echo $form->submit('Delete',array('class'=>'orangbtn','div'=>false));?>
					<!--<input type="button" value="Delete" class="orangbtn" />-->
				</li>

			</ul>
		</div>
		<!--Seller Offer Closed-->
		
		</div>
		<!--Order Products Widget Closed-->
		
	</div>
	<!--Products Closed-->
	<?php }?>
	
	</div>
</section>
<!--My Offers Closed-->

</section>
<!--Tbs Cnt closed-->

<?php echo $form->end(); ?>