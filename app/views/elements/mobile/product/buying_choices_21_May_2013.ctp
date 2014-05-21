<?php 
	$this->Paginator->options(array(
	'update' => '#abc',
	'evalScripts' => true,
	'url'=>array('controller'=>'categories', 'action'=>'get_allsellers_product',$product_id,$conditions),
	));


	$logg_user_id_bc =0;
	$logg_user_id_bc = $this->Session->read('User.id');
	$this->set('logg_user_id_bc',$logg_user_id_bc);

	if(!empty($logg_user_id_bc)) {
			
		$offer_widthbc  = 423;
		$offer_heightbc = 220;
	} else{
			
		$offer_widthbc = 560;
		$offer_heightbc = 195;
	}
?>

<?php
if(!empty($all_sellers)){
?>
<style language="text/css">
	.pagingli {
	border-top:1px solid #DADADA;
	padding-top:5px;
	padding-right:5px;
	text-align:right;
	}
</style>

<!---->
	<?php $prcpount = 1;
		$total_sellers = count($all_sellers);
		foreach($all_sellers as $index_id=>$seller) {
			if($index_id == ($total_sellers-1))
				$style = "border-bottom:0px";
			else
				$style= '';
			?>
			<?php
				$ex_flag = 0;
				$pr_price = $seller['ProductSeller']['price'];
				if(!empty($seller['Seller']['free_delivery'])){
					if($pr_price >= $seller['Seller']['threshold_order_value']){
						$delivery_charges = 0;
					} else{
						$delivery_charges = $seller['ProductSeller']['standard_delivery_price'];
					}
				} else{
					$delivery_charges = $seller['ProductSeller']['standard_delivery_price'];
				}
				?>
				<?php if($index_id == 0)
					$prclass = 'lrgr-fnt';
				else
					$prclass = ''; 
					
	### Seller information ########
	  $sellerId       = $seller['Seller']['user_id'];
	  $SellerInfo     = $common->getsellerInfo($sellerId);
	  $sellerName     = $SellerInfo['Seller']['business_display_name'];
	  $gift_service   = $SellerInfo['Seller']['gift_service'];
	  $free_delivery  = $SellerInfo['Seller']['free_delivery'];
	  $threshold_order_value  = $SellerInfo['Seller']['threshold_order_value'];
			?>
			
			<spna id="make_offers"><span>
			
			<ul class="buying-choices pro-details">
			<li style="<?php echo $style;?>">
				<p>
					<span class="price <?php echo $prclass;?>">
						<strong>
							<?php echo CURRENCY_SYMBOL.$format->money($seller['ProductSeller']['price'],2);?>
						</strong>
					</span>
					
					<span class="gray">+ <?php if(!empty($delivery_charges)) echo $format->money($delivery_charges,2).' delivery'; else echo 'Free Delivery';?>
					</span>
					&nbsp;&nbsp;
					<b class="font11">Condition: 
						<?php if(!empty($seller['ProductSeller']['condition_id'])) { echo $product_condition_array[$seller['ProductSeller']['condition_id']]; } else echo '-'; ?>
					</b>
				</p>
				
				<p>
					<span><strong>Seller</strong></span> 
					<span class="bigger-font rate">
						<strong>
						<?php 
							$seller_name=str_replace(' ','-',html_entity_decode($seller['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
							echo $html->link($seller['Seller']['business_display_name'],'/sellers/'.$seller_name.'/summary/'.$seller['Seller']['user_id'].'/'.$product_details['Product']['id'],array('escape'=>false,'class'=>'bigger-font rate')); 
						?>
						</strong>
					</span>&nbsp;&nbsp;
					<?php 
						$common->sellerPositivePercentage($seller['Seller']['positive_percentage']);
					?>
					<!--<a href="#">99% over the past 12 months</a>-->
				</p>
				
				<p class="green-color larger-font margin-tp">
					<?php if(!empty($seller['ProductSeller']['quantity'])) { ?>
						<strong>In Stock</strong>
					<?php } ?>
					&nbsp;&nbsp;
						<?php $seller_name=str_replace(' ','-',html_entity_decode($sellerName, ENT_NOQUOTES, 'UTF-8'));
						echo $html->link('Visit seller\'s store','/sellers/'.$seller_name.'/summary/'.$sellerId.'/'.$product_details['Product']['id'],array('escape'=>false,'class'=>'class="font11')); ?>
				</p>
				
				<p class="font11">
					Eligible for 
						<span class="price"><strong>
						<?php echo $html->link('<font color="C10000">Free Delivery</font>','/sellers/choiceful.com-store/'.$sellerId,array('class'=>"underline-link",'escape'=>false));?>
						</strong></span>
						 with this seller 
						 <?php echo $html->image("free-del.png" ,array('width'=>"26",'height'=>"12", 'alt'=>"",'class'=>'v-align-middle', 'escape'=>false )); ?>
				</p>
				
				<!--<p class="font11">
					Eligible for 
					<span class="drkred"><b>Free Delivery</b>
					</span> with this seller 
					<img src="<?php //echo SITE_URL;?>img/mobile/free-del.png" width="26" height="12" alt="" />
				</p>-->
				
				<?php  if($gift_service == 1) { ?>
					<p class="giftzotns">
					<?php echo $html->image('mobile/gift-icon.gif', array('alt'=>''));?>
					<?php echo $html->link('Gifts options available',array('controller'=>'pages','action'=>'view','gift-wrappind'),array('escape'=>false,'class'=>'underline-link'));?>
					</p>
				<?php  } ?>
				    
				<!--<p class="giftzotns">
					
					<img src="<?php //echo SITE_URL;?>img/mobile/gift-icon.gif" alt="" />
				</p>-->
				
				
				<p class="margin-tp font11">
					<b>Comments:</b>
					<?php echo $seller['ProductSeller']['notes'];?>
				</p>
				
				<?php if(!Empty($seller['ProductSeller']['dispatch_country'])) {?>
					<p class="font11"><b>Shipping from: </b><?php echo @$countries[$seller['ProductSeller']['dispatch_country']];?> </p><?php }?>
						
				<p class="margin-top">
					<?php if(!empty($seller['ProductSeller']['quantity']) && $seller['ProductSeller']['quantity'] >0) {
						echo $html->link('<input type="button" value="Add To Basket" class="adallbskt" />',"javascript:void(0)",array('escape'=>false,'class'=>'grn-btn','onClick'=>'addToBasket('.$product_id.',1,'.$pr_price.','.$seller['ProductSeller']['seller_id'].','.$seller['ProductSeller']['condition_id'].')'));
					} else {
						
					}?>
					<?php 
						$offerSerialize['p_id']  = $product_id;
						$offerSerialize['s_id']  = $seller['ProductSeller']['seller_id'];
						$offerSerialize['c_id']  = $seller['ProductSeller']['condition_id'];
						$offerSerialize['type']  = 'S';
						$encodeOfferData = base64_encode(serialize($offerSerialize));
					?>
					<?php //echo $encodeOfferData;?>
					<input type="button" onclick="add_offers('<?php echo $encodeOfferData;?>')" value="Make me an offer" class="ornggradbtn" />
				</p>
			</li>
			</ul>
			<!---->
			
		<?php } ?>
		
<?php 	} else { ?><span class="red-color"><?php
	if($conditions == '1-4'){
		echo 'New - Not Available';
	} else if($conditions == '2-3-5-6-7'){
		echo 'Used - Not Available';
	} else {
		echo 'Not Available';
	}?> </span><?php 
}?>



<script type="text/javascript">
jQuery(document).ready(function(){

jQuery('#pagingli span a').click(function(){
	var ajax_url= jQuery(this).attr('href');
	jQuery.ajax({
		url: ajax_url,
		success: function(msg){
		jQuery('div#abc').html(msg);
  	}
	});
	return false;
	
	});
});
</script>


<?php /* start For Make me offer*/?>
<script type="text/javascript">
var SITE_URL = "<?php echo SITE_URL; ?>";

 // function to like to dislike in giftcertificate
function add_offers(encodeOfferData){
	var postUrl = SITE_URL+'offers/add/'+encodeOfferData;
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#tab2').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
</script>
