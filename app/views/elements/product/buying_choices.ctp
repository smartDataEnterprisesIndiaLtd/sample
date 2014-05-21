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

<script language="JavaScript">

	jQuery(document).ready(function()  { // for writing a review	
		jQuery("a.make-me-offer-link-buyingchoices").fancybox({
			//'autoScale' : false,
			'autoDimensions': false,
			'titlePosition': 'inside',
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : <?php echo $offer_widthbc; ?>,
			'height' : <?php echo $offer_heightbc; ?>,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			},
			'onClosed': function() {
				//parent.location.reload(true);;
			}
		});
	});
</script>
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
<ul class="buying-choices">
	<?php $prcpount = 1;
	$total_sellers = count($all_sellers);

	foreach($all_sellers as $index_id=>$seller) {
		if($index_id == ($total_sellers-1))
			$style = "border-bottom:0px";
		else
			$style= '';
		?>
		<li style="<?php echo $style;?>">
		<div class="width220">
		<?php
		$ex_flag = 0;
		$pr_price = $seller['ProductSeller']['price'];
		if($seller['Seller']['free_delivery'] == '1'){
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
			$prclass = ''; ?>
		<p><span class="price <?php echo $prclass;?>"><b><?php echo CURRENCY_SYMBOL.$format->money($seller['ProductSeller']['price'],2);?></b></span> <span class="gray">+ <?php if(!empty($delivery_charges)) echo $format->money($delivery_charges,2); else echo 'Free '; /*if(!empty($ex_flag)) { echo ' express ';}*/?> Delivery</span></p>
		<p><span><strong>Seller</strong></span> <span class="bigger-font rate"><strong><?php 
		$seller_name=str_replace(array(' ','&'),array('-','and'),html_entity_decode($seller['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
		echo $html->link($seller['Seller']['business_display_name'],'/sellers/'.$seller_name.'/summary/'.$seller['Seller']['user_id'].'/'.$product_details['Product']['id'],array('escape'=>false,'class'=>'bigger-font rate')); ?> </strong></span></p>
		<?php $text_delivery = 0;
		if(empty($seller['ProductSeller']['express_delivery'])){
			if(!empty($seller['Seller']['free_delivery'])){
				if($seller['Seller']['threshold_order_value'] <= $seller['ProductSeller']['price']){ ?>
					<p>Eligible for <span class="price">Free Delivery</span> with this seller <?php echo $html->image("free-del.png",array('width'=>"26",'height'=>"12", 'alt'=>"" )); ?></p>
				<?php }
			}
		} ?>
		<?php if(!empty($seller['ProductSeller']['quantity'])) { ?>
			<p class="green-color larger-font margin-tp"><strong>In Stock</strong></p>
		<?php } ?>
		<p class="margin-tp"><strong>Condition: <?php if(!empty($seller['ProductSeller']['condition_id'])) { echo $product_condition_array[$seller['ProductSeller']['condition_id']]; } else echo '-'; ?></strong></p>
		<?php if(!empty($seller['ProductSeller']['notes'])) { ?>
		<p class="margin-tp"><strong>Comments:</strong>
		<?php echo ucfirst($seller['ProductSeller']['notes']);?></p>
		<?php }?>
		<?php if(!Empty($seller['ProductSeller']['dispatch_country'])) {?>
		<p>Shipping from: <?php echo @$countries[$seller['ProductSeller']['dispatch_country']];?> (<?php echo $html->link('What\'s this?',"/pages/view/delivery-destinations",array('escape'=>false,'class'=>'underline-link'));?>)</p><?php }?>
		<p>	<?php  //$common->sellerAvgrate($seller['Seller']['avg_full_star'],$seller['Seller']['avg_half_star'],$seller['Seller']['avg_rating'],$seller['Seller']['pr_seller_id'],$seller['Seller']['pr_id']);
				$common->sellerAvgrateCount($seller['Seller']['avg_full_star'],$seller['Seller']['avg_half_star'],$seller['Seller']['count_rating'],$seller['Seller']['pr_seller_id'],$seller['Seller']['pr_id']);
			?>
		</p>
		<p class="bigger-font">
		<?php 
		$common->sellerPositivePercentage($seller['Seller']['positive_percentage']);?></p></div>
		<p class="margin-top bttns_sec"><?php if(!empty($seller['ProductSeller']['quantity']) && $seller['ProductSeller']['quantity'] >0) {
			echo $html->link('<span>Add to Basket</span>',"javascript:void(0)",array('escape'=>false,'class'=>'grn-btn float-left','onClick'=>'addToBasket('.$product_id.',1,'.$pr_price.','.$seller['ProductSeller']['seller_id'].','.$seller['ProductSeller']['condition_id'].')'));
		} else {

		}?> <?php 
		$offerSerialize['p_id']  = $product_id;
		$offerSerialize['s_id']  = $seller['ProductSeller']['seller_id'];
		$offerSerialize['c_id']  = $seller['ProductSeller']['condition_id'];
		$offerSerialize['type']  = 'S';
		$encodeOfferData = base64_encode(serialize($offerSerialize));
		echo $html->link('<span>Make me an Offer</span>',"/offers/add/".$encodeOfferData,array('escape'=>false,'class'=>'ornge-btn make-me-offer-link-buyingchoices'));
		?></p>
	<?php } ?></li>
	<?php if($this->Paginator->numbers()){
		?>
	<li class="pagingli" style="border-bottom:0px;margin-top:5px;padding:5px 0 0; height: 26px" id="pagingli">
		<span style="float: right">
		<?php echo $this->Paginator->prev('Prev',array('escape'=>false,'tag' => 'span','class'=>'active'));?>
		<?php echo $this->Paginator->numbers(array('separator'=>'','tag' => 'span')); ?>
		<?php echo $this->Paginator->next('Next',array('escape'=>false,'tag' => 'span','class'=>'active'));?>
		</span>
		
	</li>
	<?php } ?>
	<!--<li class="pagingli" style="border-bottom:0px;margin-top:5px;padding:5px 0 0;" id="pagingli"><?php echo $this->Paginator->numbers();?> </li> -->
</ul>
<?php } else { ?><span class="red-color"><?php
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