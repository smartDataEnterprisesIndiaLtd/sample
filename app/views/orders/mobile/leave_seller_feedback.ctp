<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'), false);?>
<style>
.seller-feedback-address {  width:145px;}
.order-list-details_r { margin-left:200px; }
.order-list-details_l { width:200px; }
.row {
    padding: 4px 0;
}
</style>
<!--mid Content Start-->
 <!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->
<!--Tbs Cnt start-->
<section class="tab-content">

<script>var cnt = 1;</script>
<?php if(!empty($buyer_orders)){
		$i=0;
	//pr($buyer_orders);
		foreach($buyer_orders AS $key=>$val){
			echo $html->link('','#',array('escape'=>false,'name'=>base64_encode('item_'.$val['OrderItem']['id'])));
			$countryId= $val['Order']['shipping_country']; ?>
			
			<a href="#<?php echo $val['OrderItem']['id'];?>" id="<?php echo $val['OrderItem']['id'];?>" name = "<?php echo $val['OrderItem']['id'];?>" ></a>
			
			<?php if($i==0)
					$class="row";
				else
					$class="row border-top-dashed";
			?>
			<!--Row1 Start-->
			<div class="<?php echo $class;?>">
				<!--Products Start-->
				<!-- ajax block starts-->
					<?php if(!empty($val['Feedback']['id'])){
						$this->set('val',$val); ?>
						<div id="feedback_<?php echo $val['OrderItem']['id'];?>">
						<?php echo $this->element('mobile/orders/display_feedback');?>
						</div>
					<?php } else { ?>
						<div id="feedback_<?php echo $val['OrderItem']['id'];?>">
							<?php $this->set('itemVal',$val);
							echo $this->element('mobile/orders/feedback'); ?></div>
					<?php } ?>
				<!-- ajax block closed-->
			
			</div>
			<!--Row1 Closed-->
		<?php  $i++; }
	} else{ ?>
	<div class="order-list-details_l" style="width:100%;">
		<ul class="order-info">
		<li><p class="no-list">There are currently no orders on file.</p></li>
		</ul>
	</div>
	<?php } ?>	
</section>
<!--Tbs Cnt closed-->
<!--mid Content Closed-->
<?php if(!empty($active_order_item_id)){ ?>
<script>
var active_order_item_id = '<?php echo $active_order_item_id;?>';

jQuery('#OrderFeedback'+active_order_item_id).focus();
</script><?php 
}?>