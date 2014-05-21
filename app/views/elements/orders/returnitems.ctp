<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('.saveBtn').click(function(){
		var txtBoxId = jQuery(this).attr('txtId');
		if(jQuery(txtBoxId).val() != "")
		{
			//jQuery('#frmOrder').submit();
			jQuery(".saveBtn").attr("disabled", "true");
		}
	});
});
</script>

<?php
$this->data['Order']['quantity'.$itemVal['id']] = 1;
if ($session->check('Message.flash')){ ?>
	<div id="err_msg<?php echo $itemVal['id'];?>"><div  class="messageBlock"><?php echo $session->flash();?></div></div>
	<?php $this->data['Order']['quantity'.$itemVal['id']] = '';?>
<?php }
?>
<div class="order-product-image">
	<?php
	if(!empty($itemVal['Product']['product_image'])){
		$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$itemVal['Product']['product_image'];
		if(file_exists($product_image)){
			echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$itemVal['Product']['product_image'],array('alt'=>"")),'/'.$this->Common->getProductUrl($itemVal['product_id']).'/categories/productdetail/'.$itemVal['product_id'],array('escape'=>false));
		}else{
			echo $html->link($html->image('/img/no_image_75.jpg',array('alt'=>"", 'height'=>'75', 'width'=>'75')),'/'.$this->Common->getProductUrl($itemVal['product_id']).'/categories/productdetail/'.$itemVal['product_id'],array('escape'=>false));
		}
	}else{
		echo $html->link($html->image('/img/no_image_75.jpg',array('alt'=>"", 'height'=>'75', 'width'=>'75')),'/'.$this->Common->getProductUrl($itemVal['product_id']).'/categories/productdetail/'.$itemVal['product_id'],array('escape'=>false));
	}?>
</div>

<!--Order Product Content Start-->
<div class="order-product-content">
	<!--Order Product Information Start-->
	<div class="order-pro-info">
		<p><?php if(!empty($itemVal['product_name'])) echo $itemVal['product_name']; else echo '-'; ?></p>
		<p><span class="gray">Seller:</span> <?php echo $html->link($itemVal['seller_name'],'/sellers/summary/'.$itemVal['seller_id'].'/'.$itemVal['product_id'].'/'.$itemVal['condition_id'],array('escape'=>false,'class'=>'underline-link')); ?></p><?php //pr($defaultItem);?>
		<p class="pad-tp-btm"><?php
			App::import('Model','DispatchedItem');
			$this->DispatchedItem = &new DispatchedItem;
			App::import('Model','OrderReturn');
			$this->OrderReturn = &new OrderReturn;
				
			$sumdispatched_item = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.order_item_id'=>$itemVal['id']),'fields'=>array('SUM(DispatchedItem.quantity) as total_dispatched')));
				
			if(!empty($sumdispatched_item[0][0]['total_dispatched'])){
				$sumdispatched_item = $sumdispatched_item[0][0]['total_dispatched'];
			} else{
				$sumdispatched_item = 0;
			}
			$sumreturned_item = $this->OrderReturn->find('all',array('conditions'=>array('OrderReturn.order_item_id'=>$itemVal['id']),'fields'=>array('SUM(OrderReturn.quantity) as total_returned')));
			if(!empty($sumreturned_item[0][0]['total_returned'])){
				$sumreturned_item = $sumreturned_item[0][0]['total_returned'];
			} else{
				$sumreturned_item = 0;
			}
				
			$remaining_dispatched_items =0;
			$remaining_dispatched_items = $sumdispatched_item-$sumreturned_item;
				
			if($remaining_dispatched_items > 0){
				echo $form->checkbox('Order.return'.$itemVal['id'],array('onClick'=>'showdiv('.$itemVal['id'].')','class'=>'checkbox')); ?> Return this item?
			<?php } else {
				echo "<span style='color:#76923C; padding-top:5px'>Your return request has been submitted. Please await further instructions by email.</span>";
			}?>
		</p>
	</div>
	<!--Order Product Information Closed-->
</div>
<!--Order Product Content Closed-->
<div class="clear"></div>
<!--Comment Widget Start-->
<?php 
if((!empty($remaining_dispatched_items) && ($remaining_dispatched_items > 0 ))) { ?>
<div class="comment-widget overflow-h" id="returnThis<?php echo $itemVal['id'];?>" style="display:none">
<?php echo $form->create('Order',array('action'=>'returnitem','method'=>'POST','name'=>'f'.$itemVal['id'],'id'=>'frmAddFeedback_'.$itemVal['id'])); ?>
	<!--Row Start-->
	<div class="row-wid overflow-h">
		<!--Comment Widget Left Start-->
		<div class="comment-widget-left">
		<ul>
			<li>
				<div class="quantity-pro">Quantity <?php //echo $form->input('Order.quantity'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','label'=>false,'div'=>false)); ?><?php echo $form->select('Order.quantity'.$itemVal['id'],array_combine(range(1,$remaining_dispatched_items),range(1,$remaining_dispatched_items)),$this->data['Order']['quantity'.$itemVal['id']],array('class'=>'form-textfield sel-smal-width', 'type'=>'select')); ?></div>
				<div class="reason">Reason for returning? Comments</div>
			</li>
		</ul>
		</div>

		<!--Comment Widget Right Closed-->
	</div>
	<!--Row Closed-->
	<!--Row Start-->
	<div class="row-wid overflow-h">
		<!--Comment Widget Left Start-->
		<div class="comment-widget-left">
			<ul>
				<li>
					<?php echo $form->input("Order.feedback".$itemVal['id'],array('style'=>'width:99%; height:90px; padding:0px;', "label"=>false,"div"=>false,'rows'=>5,'cols'=>45, 'class'=>'form-textfield')); ?>
				</li>
			</ul>
		</div>
		<!--Comment Widget Right Closed-->
		<!--Comment Widget Right Start-->
		<div class="comment-widget-right">
			<ul>
				<li>
					<div class="comment-ins-height margin-top20"/>
				</li>
				<li>
					<?php
					$options = array(
						"url"=>"/orders/returnitem/".$itemVal['id'],"before"=>"",
						"update"=>"updateItem".$itemVal['id'],
						"indicator"=>"plsLoaderID",
						'loading'=>"showloading()",
						"complete"=>"hideloading()",
						"class" =>"saveBtn",
						"txtId" =>"OrderFeedback".$itemVal['id'],
						"type"=>"Submit",
						"id"=>"return".$itemVal['id'],
					);
					echo $ajax->submit('submit-btn-gray.gif',$options);?>
				</li>
			</ul>
		</div>
		<!--Comment Widget Right Closed-->
	</div>
	<!--Row Closed-->
<?php

echo $form->hidden('Order.id'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['order_id']));

echo $form->hidden('Order.item_id'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['id']));
echo $form->hidden('item_id'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['id']));
echo $form->hidden('Order.price'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['price']));

echo $form->hidden('Order.item_name'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['product_name']));

echo $form->hidden('Order.delivery_method'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['delivery_method']));

echo $form->hidden('Order.seller_id'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['seller_id']));


?>
<!--Comment Widget Closed-->
<?php echo $form->end(); ?>
</div>
<script language="JavaScript">
var clickedId = 0;

<?php 
if((!empty($defaultItem)) && (is_numeric($defaultItem))) { ?>
	var clickedId = <?php echo $itemVal['id'];?>;
	jQuery(document).ready(function(){
	if(clickedId!=0){
		jQuery('#OrderReturn'+clickedId).click();
		showdiv(clickedId);
	}
	});
<?php }?>

</script>
<?php }?>