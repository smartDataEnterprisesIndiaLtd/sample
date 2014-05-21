<?php 
echo $form->create('Offer',array('action'=>'update_offer_status/'.$offer_id.'/'.$offer_status,'method'=>'POST','name'=>'frmOffer','id'=>'frmOffer'));

if($offer_status == 2){
    $button_text = "Reject Offer";
}else{
    $button_text = "Accept offer";
}?>
<!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->
<!--Tbs Cnt start-->
<section class="tab-content padding0">
<!--My Offers Start-->
<section class="offers">                	
	<section class="gr_grd brd-tp0">
	<h4 class="bl-cl">My Offers</h4>
	</section>
	
	<!--Row1 Start-->
	<div class="row-sec">
		<?php 
		if ($session->check('Message.flash')){ ?>
			<div class="messageBlock"><?php echo $session->flash();?></div>
		<?php }
		?>
	<h4 class="font14 choiceful"><?php echo $button_text;?></h4>
	<!--Products Start-->
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
			<p class="font11">
				<?php  if($offer_status == 2) { ?>
				<b>Reject an offer.</b>
				<?php }else{ ?>
				<b>Accept an offer.</b>The buyer has up to 48 hours to purchase at the offer price.</b>
				<?php } ?>
			</p>
			
			<p class="toppadd"><b class="font14">Item: </b><?php echo $offers_details['Product']['product_name'];?></p>
			</div>
			<!--Order Product Information Closed-->
		</div>
		<!--Order Product Content Closed-->                        
		<div class="clear"></div>
		
		<!--Seller Offer Start-->
		<div class="seller-offers">
			<ul>
			<li class="boldr">I'd like to pay: 
				<span class="bl-clr">
					<?php echo CURRENCY_SYMBOL,$offers_details['Offer']['offer_price'];?>
				</span>
			</li>
			
			<li class="boldr line-margin-top">I will be buying :
				<span class="bl-clr">
					<?php echo $offers_details['Offer']['quantity'];?>
				</span>
			</li>
			
			<li>Thank you for considering my offer.</li>
			<?php  if($offer_status == 2) { ?>
			<li class="boldr margin-top">
				<?php
						$current_date = $offers_details['Offer']['created']; // current date
						$expiry_date = date('d/m/Y', strtotime(date("Y-m-d", strtotime($current_date)) . " +2 day"));
			
						$offer_value = ($offers_details['Offer']['offer_price'] *$offers_details['Offer']['quantity']);
			
				?>
				Expires on:
				<span class="redcolor">
					<?php echo $expiry_date;?>
				</span>
				<span style="margin-left:15px;">Offer value: </span>
				<?php echo CURRENCY_SYMBOL,number_format($offer_value,2,'.', '');?>
			</li>
			<?php }?>
			
			<li class="font11 margin-top"><b>What happens next:</b>
			    <?php  if($offer_status == 2) { ?>
				we contact the buyer on your behalf to notify that you have rejected their offer price
			    <?php }else{?>
				we contact the buyer on your behalf to notify that they can purchase at the offer price. Please allow up to 48 hours for the purchase to be made. 
			    <?php }?>
			</li>
				<li class="margin-top">
				<?php
					echo $form->hidden('Offer.id',array('value'=>$offer_id,'type'=>'text','label'=>false,'div'=>false));
					echo $form->hidden('Offer.offer_status',array('value'=>$offer_status,'type'=>'text','label'=>false,'div'=>false));
				?>
				<?php  	if($offer_status == 2) { 
					    $butclass = "orangbtn margin-top";
					}else{
					    $butclass = "grenbtn margin-top";
					}
				?>
				<input type="submit" class="<?php echo $butclass?>" value="<?=$button_text?>"></li>
         
			</ul>
		</div>
		<!--Seller Offer Closed-->
		
		</div>
		<!--Order Products Widget Closed-->
		
	</div>
	<!--Products Closed-->
	</div>
</section>
<!--My Offers Closed-->

</section>
<!--Tbs Cnt closed-->