<?php
$user_id =$this->Session->read('User.id');
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
	foreach($buyer_orders AS $key=>$val){
	$countryId = $val['Order']['shipping_country'];
	if($i==0)
	$class = "row";
	else
	$class = "row border-top-dashed";
	?>
	<div class="<?php echo $class?>">
		<ul class="order-info">
		<li>
			<p><span class="gray">Order Placed:</span></p>
			<h2 class="font20"><?php echo date("j F Y", strtotime($val['Order']['created'])); ?></h2>
		</li>
		<li>
			<p>
				<span class="gray">Order Number:</span>
				<?php echo $val['Order']['order_number']; ?>
			</p>
			<p>
				<span class="gray">Recipient:</span>
				<?php echo ucwords($val['Order']['shipping_firstname']." ".$val['Order']['shipping_lastname']); ?>
			</p>
			
			<p><span class="gray">Delivery Address:</span></p>
			<p>
				<?php echo $val['Order']['shipping_address1']." ".$val['Order']['shipping_address2']; ?>
			</p>
			<p>
				<?php echo $val['Order']['shipping_city']; ?>
			</p>
			<p>
				<?php echo $countryArr[$countryId];?>
			</p>
			<p>
				<?php echo $val['Order']['shipping_postal_code']; ?>
			</p>
		</li>
		<li class="bottom-line">
			<p>
				<span class="gray">Order Total:</span>
			 	<span class="rd_clr">
			 		<strong>
			 			<?php echo CURRENCY_SYMBOL.$format->money($val['Order']['order_total_cost'],2); ?>
			 		</strong>
			 	</span>
			</p>
			<p class="print-sec">
				<?php $this->set('val',$val);
				echo $this->element('mobile/orders/print_purchaseorder_slip');
				?>
			</p>
			<div class="clear"></div>
		</li>
		</ul>
		
		<!--Products Start-->
		<div class="prod">
			<!--Order Products Widget Start-->
			<?php foreach($val['OrderItem']	AS $itemKey => $itemVal){ ?>
				<div class="order-products-widget">
				
					<div class="order-product-image">
						<?php
						$prodDetails = $this->Common->getProductMainDetails($itemVal['product_id']);
						if(!empty($prodDetails['Product']['product_image'])){
							$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'];
							if(file_exists($product_image)){
								echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'],array('alt'=>"")),'/'.$this->Common->getProductUrl($itemVal['product_id']).'/categories/productdetail/'.$itemVal['product_id'],array('escape'=>false));
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($itemVal['product_id']).'/categories/productdetail/'.$itemVal['product_id'],array('escape'=>false));
							}
						}else{
							echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($itemVal['product_id']).'/categories/productdetail/'.$itemVal['product_id'],array('escape'=>false));
						}?>
						
					</div>
					<!--Order Product Content Start-->
					<div class="order-product-content">
					<!--Order Product Information Start-->
					<div class="order-pro-info">
						<h2 class="choiceful font20">Dispatched</h2>
						<p><?php echo $itemVal['product_name']; ?></p>
						<p><span class="gray">Delivery Estimate:</span>
						 <strong>
						 	<?php if(!empty($itemVal['estimated_delivery_date'])) echo date('d F Y', strtotime($itemVal['estimated_delivery_date'])); ?>
						 </strong>
						</p>
						
						<p>
							<span class="gray">Seller:</span> 
							<?php 
							echo $html->link($itemVal['seller_name'],'/sellers/summary/'.$itemVal['seller_id'].'/'.$itemVal['product_id'],array('escape'=>false,'class'=>'underline-link'));?>
						</p>
					</div>
					<!--Order Product Information Closed-->
					</div>
					<!--Order Product Content Closed-->
					<div class="clear"></div>
					
					<!--Buttons Start-->
					<div class="buttons-widget">
					<ul class="overflow-h">
						<li>
							<?php 
							$linkmain_str = '/orders/track_your_order/'.$itemVal['seller_id'].'/'.$itemVal['id'].'/'.$itemVal['product_id'].'/'.$itemVal['product_name'].'/'.$itemVal['seller_name'];
							
							echo $html->link($this->Form->submit('Tracking Information', array('type'=>'button','class'=>'bluggradbtn width145','div'=>false,'escape'=>false)),$linkmain_str,array('escape'=>false));?>
							
						</li>
						<?php if($itemVal['total_returned'] < $itemVal['total_dispatched']) { ?>
						<li>
							<?php echo $html->link($this->Form->submit('Return Items', array('type'=>'button','class'=>'grnggradbtn width145','div'=>false,'escape'=>false)),"/orders/return_items/".base64_encode($itemVal['id'])."/".$itemVal['id'],array('escape'=>false));?>
						</li>
						<?php } ?>
						<li>
							<?php 
							
							echo $html->link($this->Form->submit('Leave Seller Feedback', array('type'=>'button','class'=>'grnggradbtn width145','div'=>false,'escape'=>false)),"/orders/leave_seller_feedback/".base64_encode($itemVal['id'])."/#".base64_encode("item_".$itemVal['id']),array('escape'=>false));?>
						</li>
						<li>
							<?php 
							//$link_file_claim = '/orders/file_a_claim/'.$itemVal['seller_id'].'/'.$itemVal['id'].'/'.$itemVal['product_id'].'/'.urlencode($itemVal['product_name']).'/'.urlencode($itemVal['seller_name']);
							$link_file_claim = '/orders/file_a_claim/'.$itemVal['seller_id'].'/'.$itemVal['id'].'/'.$itemVal['product_id'];
							
							echo $html->link($this->Form->submit('File a Claim', array('type'=>'button','class'=>'grnggradbtn width145','div'=>false,'escape'=>false)),$link_file_claim,array('escape'=>false));?>
						</li>
						<li>
							<?php echo $html->link($this->Form->submit('Contact Seller', array('type'=>'button','class'=>'grnggradbtn width145','div'=>false,'escape'=>false)),"/orders/contact_sellers/#".base64_encode("item_".$itemVal['id']),array('escape'=>false));?>
						</li>
					</ul>
					</div>
					<!--Buttons Closed-->
			
				</div>
			<!--Order Products Widget Closed-->
		<?php }?>
		

		</div>
		<!--Products Closed-->
		
		</div>
		
<?php $i++; ?>

<?php } }else{ ?>	
		<div class="row">
			<ul class="order-info">
			<li><p class="rd_clr">There are currently no orders on file.</p></li>
			</ul>
		</div>
			
<?php } ?>
	<!--Row1 Closed-->
	
	
	
</section>
<!--Tbs Cnt closed-->
<!--mid Content Closed-->