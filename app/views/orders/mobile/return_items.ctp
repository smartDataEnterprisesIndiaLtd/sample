<?php
echo $javascript->link('lib/prototype');
e($html->script('jquery-1.4.3.min',false));
//e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
//e($html->script('fancybox/jquery.easing-1.3.pack'));
//e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
//echo $html->css('jquery.fancybox-1.3.4');
?>
<script>

jQuery(document).ready(function()  {
	setTimeout(function(){
		jQuery('#OrderFeedback<?php echo $focusItemId;?>').focus();
	},0);
	
	//jQuery('#OrderFeedback<?php //echo $focusItemId;?>').focus();
});

</script>
<style type="text/css">
.order-product-image {
padding-top:0px;
}.v-smal-width {
width:30px;
padding:0px;
}
.row {margin-top:8px;}
</style>
<!--mid Content Start-->
<!--Tabs Start-->
<section class="tabs-widget">
<?php echo $this->element('mobile/orders/tab');?>
</section>
<!--Tbs Closed-->
<!--Tbs Cnt start-->
<section class="tab-content">
<!--Row1 Start-->
<?php if(!empty($buyer_orders)){ ?>
	<div class="row pad-btm0">
	<?php $i=0;?>
	<?php foreach($buyer_orders AS $key=>$val){
		if(!empty($val['Order']['shipping_country'])) 
			$countryId = $val['Order']['shipping_country']; 
			else $countryId =0; 
	?>
		<!--Products Start-->
		<?php if($i==0)
		$class = "";
		else
		$class = "row border-top-dashed";
		?>
		<div class="prod <?php echo $class;?>">
			<!--Order Products Widget Start-->
			<div class="order-products-widget pd-top-none">
			 <ul class="order-info">                            	
				<li><p class="grn-clr font11">Please select a quantity to return and provide a reason.</p></li>
				<li class="pad-tp">
					<p>
						<span class="gray">Order Number:</span>
						<?php if(!empty($val['Order']['order_number'])) echo $val['Order']['order_number']; ?>
					</p>
				</li>
				</ul>
			</div>
			<!--Order Products Widget Closed-->	
				<?php if(!empty($val['Items'])){ ?>
					<?php foreach($val['Items'] AS $itemKey => $itemVal){ ?>
					<!--Order Products Widget Start-->
					<div class="order-products-widget pd-top-none">
					<!--a href="#OI<?php //echo $itemVal['OrderItem']['id'];?>" id="OI<?php //echo $itemVal['OrderItem']['id'];?>" name = "OI<?php //echo $itemVal['OrderItem']['id'];?>" ></a-->
					<div style="padding-top:0px;" class="order-products-widget" id="updateItem<?php echo $itemVal['OrderItem']['id'];?>">
					<?php $itemVal['OrderItem']['Product'] = $itemVal['Product'];
						$this->set('itemVal',$itemVal['OrderItem']);
						if(!empty($itemVal['OrderReturn'])){
							$defaultItem = 'returned';
						} else{
							$defaultItem = 0;
						}
						$this->set('defaultItem',$defaultItem);
						echo $this->element('mobile/orders/returnitems');
					?>
						
					<!--Order Product Content Closed-->
					<div class="clear"></div>
					
					<?php } ?>
					</div>
					<!--Order List details Right Closed-->
					<?php }?>
	
	</div>
		<!--Products Closed-->
	<?php $i++; }?>
		
	</div>
	<!--Row1 Closed-->
	
<?php } else{ ?>
<div class="order-list-details_l">
	<ul class="order-info">
		<li><p class="no-list">There are currently no orders on file.</p></li>
	</ul>
</div>
<?php } ?>	
</section>
<!--Tbs Cnt closed-->
<!--mid Content Closed-->
<!--mid Content Closed-->
<script language="JavaScript">
<?php if(empty($prev_item_id)) $prev_item_id = 0;?>
var itemId = <?php echo $prev_item_id; ?>;
if(itemId > 0){
	jQuery('#OrderReturn'+itemId).attr('checked',true);
	showdiv(itemId);
}
function showdiv(id){
	var checkedValue = jQuery('#OrderReturn'+id).attr('checked');

	if(checkedValue != ''){
 		jQuery('#returnThis'+id).css('display','block');
		jQuery('#err_msg'+id).css('display','block');
	} else{
 		jQuery('#returnThis'+id).css('display','none');
		jQuery('#err_msg'+id).css('display','none');
	}
// 	jQuery('#OrderFeedback'+id).focus();
}

</script>