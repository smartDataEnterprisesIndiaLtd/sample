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


<style language="text/css">
	.pagingli {
	border-top:1px solid #DADADA;
	padding-top:5px;
	padding-right:5px;
	text-align:right;
	}
	.larger-fnt {
	color:#0033AC;
	}
	
.buying-choices li img {
    vertical-align: middle;
}
</style>

<!---->
<section class="productdescptn">
                                 <!--Seller BreadCumb Starts-->
                                    <ul class="sellrbrdcrmb">
                                      <li>All</li>
                                      <li>
                                      
					<script tyle="text/javascript">
					function isSelectedObjective(productId,condition){
					if(productId != '' && condition != ''){
							jQuery.ajax({
								type: "POST",
								url: "/categories/get_allsellers_product/"+productId+"/"+condition,
								data:"productId="+productId,
								beforeSend: function() {
										
									jQuery("#abc").hide();
										
									jQuery("#plsLoaderID1").show();
										
									},
										
								complete: function() {
										
									jQuery("#abc").show();
										
									jQuery("#plsLoaderID1").hide();
										
									},
								success: function(data){
								jQuery("#abc").html(data);
								},
										
								//async: true
							});
						}
					}
					</script>
                                      <?php 
                                     $conditon="'1-4'";
                                     echo  $html->link('New  Only','javascript:void(0)',array('escape'=>false,'class'=>'underline-link','onclick'=>'isSelectedObjective('.$product_details['Product']['id'].','.$conditon.')'));
                                      ?>
                                      </li>
                                      <li>
                                      
					<?php 
				     $conditon1="'2-3-5-6-7'";
                                     echo  $html->link('Used Only','javascript:void(0)',array('escape'=>false,'class'=>'underline-link','onclick'=>'isSelectedObjective('.$product_details['Product']['id'].','.$conditon1.')'));?>
					</li>
					<li>
					<?php 
				     $conditon1="'1-2-3-4-5-6-7'";
                                     echo  $html->link('Lowest Price','javascript:void(0)',array('escape'=>false,'class'=>'underline-link','onclick'=>'isSelectedObjective('.$product_details['Product']['id'].','.$conditon1.')'));
					?>
					</li>
                                    </ul>
                                 <!--Seller BreadCumb End-->
                                <?php $this->set('product_id',$product_details['Product']['id']);?>
					
					
					
<?php
if(!empty($all_sellers)){
?>
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
				
				<?php if(!empty($seller['ProductSeller']['quantity'])) { ?>
					<p class="green-color larger-font margin-tp">
						<strong>In Stock</strong>
					</p>
					<?php }else{
						echo '<p class="redcolor">Sorry, temporarily out of stock</p>';	
				}?>
				
				<p>
					<span><strong>Seller</strong></span> 
					<span class="bigger-font rate">
						<strong>
						<?php 
							$seller_name=str_replace(array(' ','&'),array('-','and'),html_entity_decode($seller['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
							echo $html->link($seller['Seller']['business_display_name'],'/sellers/'.$seller_name.'/summary/'.$seller['Seller']['user_id'].'/'.$product_details['Product']['id'],array('escape'=>false,'class'=>'bigger-font rate')); 
						?>
						</strong>
					</span>&nbsp;
					
					<p>
					<div class="proselrating">
					<?php   $common->sellerAvgrateCountMobile($seller['Seller']['avg_full_star'],$seller['Seller']['avg_half_star'],$seller['Seller']['count_rating'],$seller['Seller']['pr_seller_id'],$seller['Seller']['pr_id']);?>
					<?php
						if($seller['Seller']['count_rating'] == '0.0'){
							echo '<a href="'.SITE_URL.'sellers/summary/'.$seller['Seller']['user_id'].'/'.$product_details['Product']['id'].'" class="underline-link">I\'m new - no ratings available</a></span>';
						}else{?>
								<a href="<?php echo SITE_URL?>sellers/summary/<?php echo $seller['Seller']['user_id']?>/<?php echo $product_details['Product']['id']?>" class="underline-link">
								<?php $common->sellerPositivePercentageMobile($seller['Seller']['positive_percentage']);?>
								</a>
							
						<?php }?>
					</div>
					</p>
					<!--<a href="#">99% over the past 12 months</a>-->
				</p>
					
					<?php 
					if(!empty($seller['Seller']['free_delivery'])){
					if($seller['Seller']['threshold_order_value'] <= $seller['ProductSeller']['price']){ ?>
						<p class="font11">
						Eligible for 
							<span class="price"><strong>
							<?php echo $html->link('<font color="C10000">Free Delivery</font>','/sellers/choiceful.com-store/'.$sellerId,array('class'=>"underline-link",'escape'=>false));?>
							</strong></span>
							with this seller 
							<?php echo $html->image("free-del.png" ,array('width'=>"26",'height'=>"12", 'alt'=>"",'class'=>'v-align-middle', 'escape'=>false )); ?>
							
						</p>
					<?php }}?>
				
				<!--<p class="font11">
					Eligible for 
					<span class="drkred"><b>Free Delivery</b>
					</span> with this seller 
					<img src="<?php //echo SITE_URL;?>img/mobile/free-del.png" width="26" height="12" alt="" />
				</p>-->
				
				<?php  if($gift_service == 1) { ?>
					<p class="giftzotns">
					<?php echo $html->image('mobile/gift-icon.gif', array('alt'=>''));?>
					<?php
						echo 'Gift options available';
						//echo $html->link('Gifts options available',array('controller'=>'pages','action'=>'view','gift-wrappind'),array('escape'=>false,'class'=>'underline-link'));
					?>
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
					<p class="font11"><b>Shipped from: </b><?php echo @$countries[$seller['ProductSeller']['dispatch_country']];?> </p><?php }?>
						
				<p class="margin-top">
					<?php if(!empty($seller['ProductSeller']['quantity']) && $seller['ProductSeller']['quantity'] >0) {
						echo $html->link('<input type="button" value="Add To Basket" class="adallbskt" />',"javascript:void(0)",array('escape'=>false,'class'=>'grn-btn','onClick'=>'addToBasket('.$product_id.',1,'.$pr_price.','.$seller['ProductSeller']['seller_id'].','.$seller['ProductSeller']['condition_id'].')'));
					} else {
						//echo '<p class="redcolor">Sorry, temporarily out of stock</p>';
					}?>
					<?php 
						$offerSerialize['p_id']  = $product_id;
						$offerSerialize['s_id']  = $seller['ProductSeller']['seller_id'];
						$offerSerialize['c_id']  = $seller['ProductSeller']['condition_id'];
						$offerSerialize['type']  = 'S';
						$encodeOfferData = base64_encode(serialize($offerSerialize));
					?>
					<?php //echo $encodeOfferData;?>
					<?php if(!empty($seller['ProductSeller']['quantity']) && $seller['ProductSeller']['quantity'] >0) {?>
						<input type="button" onclick="add_offers('<?php echo $encodeOfferData;?>')" value="Make me an offer" class="ornggradbtn" />
					<?php }else{?>
						<input type="button" onclick="add_offers('<?php echo $encodeOfferData;?>')" value="Make me an offer" class="ornggradbtn" style="margin-left:0;" />
					<?php }?>
				</p>
			</li>
			
			</ul>
			<!---->
			
		<?php } ?>
		
		
		<p class="sellmor mrktplcsllr">Are you a marketplace seller?
				<?php echo $html->link('(Find out more)',array('controller'=>'pages','action'=>'view','what-is-choiceful'),array('escape'=>false,'class'=>'smalr-fnt underline-link'));?>
		</p>
		<p>
			<?php
				echo $html->link('<input type="button" value="Sell yours here" class="bluegradbtn margin-top" />',"/marketplaces/create_listing/".$product_details['Product']['id'],array('escape'=>false));
			?>
		</p>
		
		<?php if($this->Paginator->numbers()){?>
		<div class="paging centerpg">
		<span id="pagingli">
		<ul class="pgwdgt">
			<?php
			 echo $paginator->prev('Prev',array('tag' => 'li','class'=>"homeLink"));
			 echo $paginator->numbers(array('tag' => 'li','separator' =>'' ,'modulus' => '2','escape'=>false));
			 echo $paginator->next('Next',array('tag' => 'li','class'=>"homeLink"));
			?>
		</ul>
		</span>
		
		<?php } ?>
	</div>
		
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

jQuery('#pagingli ul li a').click(function(){
	var ajax_url= jQuery(this).attr('href');
	jQuery.ajax({
		url: ajax_url,
		success: function(msg){
		jQuery('.productdescptn').html(msg);
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