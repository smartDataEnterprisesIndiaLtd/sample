<?php ?>
<style>
.error-message {
	line-height:18px;
}
</style>
<?php
echo $form->create('Order',array('action'=>"cancel/".$this->data['CancelOrder']['order_item_id'].'/'.$this->data['CancelOrder']['order_id'].'/'.$this->data['CancelOrder']['seller_id'].'/'.$this->data['CancelOrder']['product_id'],'method'=>'POST','name'=>'frmOrder','id'=>'frmOrder'));
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
?>

<!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->

 <!--Tbs Cnt start-->
<section class="tab-content">
<!--Row1 Start-->
<div class="row pd-btm-none">
	<ul class="order-info">
	<?php 
	if ($session->check('Message.flash')){ ?>
		<li>
			<div class="messageBlock">
				<?php echo $session->flash();?>
			</div>
		</li>
	<?php }	?>
	<?php
		if(!empty($errors)){
			$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
		?>
		<li>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
		</li>
	<?php }?>
	
	<li><p class="redcolor font11">Remove items from orders not yet dispatched.</p></li>
	<li>
		<p><span class="gray">Order Number:</span> <?php echo $order_number;?></p>
	</li>
	</ul>
	
	<!--Products Start-->
	<div class="prod">
		<!--Order Products Widget Start-->
		<div class="order-products-widget padding5">
		<div class="order-product-image">
			<?php
			$prodDetails = $this->Common->getProductMainDetails($product_id);
				if(!empty($prodDetails['Product']['product_image'])){
					$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'];
					
					if(file_exists($product_image)){
						echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'],array('alt'=>"")),'/'.$this->Common->getProductUrl($product_id).'/categories/productdetail/'.$product_id,array('escape'=>false));
					}else{
						echo $html->image('no_image_75.jpg',array('alt'=>""));
					}
				}else{
					echo $html->image('no_image_75.jpg',array('alt'=>""));
				}?>
		</div>
		<!--Order Product Content Start-->
		<div class="order-product-content">
		<!--Order Product Information Start-->
		<div class="order-pro-info">
			<p><?php echo $pro_name; ?></p>
			<p><span class="gray">Seller:</span>
			 
			 <!--<a href="#" class="underline-link">Phones 4U</a>-->
			<?php if(!empty($item_seller_info)){ ?>
				<?php foreach($item_seller_info as $itemKey => $itemVal){ 
					$seller_name_url=str_replace(' ','-',html_entity_decode($itemVal['seller_name'], ENT_NOQUOTES, 'UTF-8'));
					echo $html->link($itemVal['seller_name'],'/sellers/'.$seller_name_url.'/summary/'.$itemVal['seller_id'].'/'.$itemVal['product_id'].'/'.$itemVal['condition_id'],array('escape'=>false,'class'=>'underline-link'));
				
				}
			}
			?>
			 </p>
		</div>
		<!--Order Product Information Closed-->
		</div>
		<!--Order Product Content Closed-->
		<div class="clear"></div>
	</div>
	<!--Order Products Widget Closed-->
	
	<!--cancel item start-->
	<ul class="csl-list">
		<li>
			<p>
				<span class="bl-clr">
					<strong>Cancelled items are refunded in full.</strong>
				</span>
			</p>
		</li>
		<li class="select-reason margin-top">
			<strong>Select a reason:</strong> 
		<?php
			
			if(!empty($errors['reason'])){
				$errorReason='select textfield error_message_box';
			}else{
				$errorReason='select textfield';
			}
			echo $form->select('CancelOrder.reason',$reasons,null,array('class'=>$errorReason,'type'=>'select'),'Choose a reason'); ?><?php if(!($form->error('CancelOrder.reason')))
		?>
		</li>
		<li class="margin-top"><p><strong>Comments (optional):</strong> <span class="gray font11">(Maximum 500 characters)</span></p>
		<p class="margin pad-rt2">
			<?php echo $form->input('CancelOrder.comment',array('size'=>'30','label'=>false,'class'=>'full-width textfield','rows'=>'5','cols'=>'30','maxlength'=>'500','div'=>false,'showremain'=>"limitOne",'error'=>false));
			echo $form->hidden('CancelOrder.order_item_id',array('type'=>'text'));
			echo $form->hidden('CancelOrder.order_id',array('type'=>'text'));
			echo $form->hidden('CancelOrder.seller_id',array('type'=>'text'));
			echo $form->hidden('CancelOrder.product_id',array('type'=>'text'));?>
		<!--<textarea rows="5" cols="30" class="full-width textfield" name="textarea"></textarea>--></p>
		</li>
		<li class="chrac-left">
		<?php echo $form->submit('',array('type'=>'image','src'=>SITE_URL.'/img/cancel-item-btn.png','class'=>'','div'=>false));?>
			<span>Remaining characters :
				<strong id ="limitOne"><?php if(!empty($this->data)){
					if(!empty($this->data['Order']['comment'])) { 
						
						$remain = 500 - strlen($this->data['Order']['comment']);
						echo $remain;
					} else {
						echo '500'; 
					} 
				} else { 
					echo '500'; } ?></strong></span>
			<?php if(!($form->error('CancelOrder.comment')))
						echo '<br>'; else echo $form->error('CancelOrder.comment');?>
		</li>
	</ul>
	<!--cancel item closed-->
	
	</div>
	<!--Products Closed-->
	
	</div>
	<!--Row1 Closed-->
</section>
<!--Tbs Cnt closed-->
<?php
echo $form->end();
?>