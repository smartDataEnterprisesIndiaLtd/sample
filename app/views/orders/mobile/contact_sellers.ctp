<?php
echo $javascript->link('lib/prototype');
e($html->script('jquery-1.4.3.min',false));
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
?>
<!--mid Content Start-->
<!--Tabs Start-->
	<?php echo $this->element('mobile/orders/tab');?>
	<!--Tbs Closed-->
<!--Tbs Cnt start-->
<section class="tab-content">
<!--Row1 Start-->
	<?php if(!empty($buyer_orders)){
		$i=0;
		foreach($buyer_orders AS $key=>$val){ //pr($val);
			$countryId= $val['Order']['shipping_country']; 
 		if($i==0)
			$class="row";
		else
			$class="row border-top-dashed";
	?>
	<div class="<?php echo $class?>">
	<!--cancel item start-->
		<ul class="csl-list">
			<li><h4 class="diff-blu">Contact Seller</h4></li>
			<?php foreach($val['OrderItem']	AS $itemKey => $itemVal){
				echo $html->link('','#',array('escape'=>false,'name'=>base64_encode('item_'.$itemVal['id']))); ?>
				<li class="row">
				<p><span class="font14">
					<strong>Item:</strong></span>
					<?php echo $itemVal['product_name']; ?>
				</p>
				<p class="margin">
					<span class="font14"><strong>Seller:</strong></span>
					<a href="/sellers/summary/<?php echo $itemVal['seller_id']."/".$itemVal['product_id']."/".$itemVal['condition_id']; ?>" class="underline-link"><?php echo $itemVal['seller_name']; ?></a>
				</p>
				</li>
				<li class="overflow-h">
				<div class="phone-pic pad-tp">
				<?php echo $html->image('mobile/phone.png',array('alt'=>"",'width'=>'20','height'=>'27'));?>
				</div>
				<div class="cntc_no">
					<p>Telephone Customer Service: 
						<strong>
							<?php if(!empty($itemVal['phone_number'])) echo $itemVal['phone_number'];?>
						</strong>
					</p>
					<p class="font11">Lines are open during normal business hours.</p>
				</div>
				</li>
				
				<span id="msg_<?php echo $itemVal['id'];?>">
					<?php $this->set('itemVal',$itemVal);?>
					<?php echo $this->element('mobile/orders/msg');?>
				</span>
			<?php } ?>
		</ul>
		
		<!--cancel item closed-->                	
	</div>
	<!--Row1 Closed-->
	<?php 
	$i++;
	}
	}else{ ?>
		<div class="order-list-details_l">
			<ul class="order-info">
			<li><p class="no-list">There are currently no orders on file.</p></li>
			</ul>
		</div>
	<?php } ?>
	
</section>
 <!--Tbs Cnt closed-->
<!--mid Content Closed-->
