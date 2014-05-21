<script>
/*jQuery(document).ready(function()  {
	//alert('<?php //echo $focusItemId;?>');
	jQuery('#OrderFeedback<?php //echo $focusItemId;?>').focus();
});*/
</script>
<?php
$seller_id = $this->Session->read('User.id');
$msg_flg = 0;
echo $form->create('Order',array('action'=>'contact_sellers','method'=>'POST','name'=>'frmAddMessage_'.$itemVal['id'],'id'=>'frmAddMessage_'.$itemVal['id'])); ?>


<?php
	App::import('Model','DispatchedItem');
	$this->DispatchedItem = &new DispatchedItem;
	App::import('Model','OrderReturn');
	$this->OrderReturn = &new OrderReturn;
		
	$sumdispatched_item = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.order_item_id'=>$itemVal['id']),'fields'=>array('SUM(DispatchedItem.quantity) as total_dispatched')));
		
	if(!empty($sumdispatched_item[0][0]['total_dispatched'])){
		$sumdispatched_item = $sumdispatched_item[0][0]['total_dispatched'];
	}else{
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
    ?>
<?php
if($remaining_dispatched_items > 0){
?>
<div class="row-wid overflow-h">
	<!--Comment Widget Left Start-->
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
				}
			?>
		</div>                        
		<!--Order Product Content Start-->
		<div class="order-product-content">                           
			<!--Order Product Information Start-->
			<div class="order-pro-info pad-tp">
			  <p><?php if(!empty($itemVal['product_name'])) echo $itemVal['product_name']; else echo '-'; ?></p>
			  <p><span class="gray">Seller:</span> <?php echo $html->link($itemVal['seller_name'],'/sellers/summary/'.$itemVal['seller_id'].'/'.$itemVal['product_id'].'/'.$itemVal['condition_id'],array('escape'=>false)); ?></p> 
			</div>
			<!--Order Product Information Closed-->
		</div>
		<!--Order Product Content Closed-->
		
	<!--Comment Widget Right Closed-->
	<!--Confirm Request Start-->
              <ul class="confirm-request">
              	<li>
                <div class="left-text pad-tp">Reasons for returning</div>
                    <div class="rt-con">Quantity
		     <?php $options_select = array_combine(range(1,$remaining_dispatched_items),range(1,$remaining_dispatched_items));?>
		     <?php echo $form->input('Order.quantity'.$itemVal['id'],array('options'=>$options_select,'class'=>'select', 'type'=>'select','empty'=>'Select','default'=>max($options_select),'label'=>false,'div'=>'')); ?>
                     </div>
                </li>
                <li>
                  <p class="pad-rt2">
			<?php echo $form->input("Order.feedback".$itemVal['id'],array("label"=>false,"div"=>false,'rows'=>5,'cols'=>30, 'maxlength'=>500, 'class'=>'textfield full-width')); ?>
		  </p>
                </li>
                <li>
			<?php
			$options = array(
				"url"=>"/orders/returnitem/".$itemVal['id'],"before"=>"",
				"update"=>"updateItem".$itemVal['id'],
				"indicator"=>"plsLoaderID",
				'loading'=>"showloading()",
				"complete"=>"hideloading()",
				"class" =>"grnggradbtn margin-none",
				"txtId" =>"OrderFeedback".$itemVal['id'],
				"type"=>"Submit",
				"id"=>"return".$itemVal['id'],
			);
			echo $ajax->submit('Confirm Return Request',$options);?>
			
		</li>
              </ul>
              <!--Confirm Request Closed-->
	      
</div>

<?php

echo $form->hidden('Order.id'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['order_id']));

echo $form->hidden('Order.item_id'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['id']));
echo $form->hidden('item_id'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['id']));
echo $form->hidden('Order.price'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['price']));

echo $form->hidden('Order.item_name'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['product_name']));

echo $form->hidden('Order.delivery_method'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['delivery_method']));

echo $form->hidden('Order.seller_id'.$itemVal['id'],array('class'=>'form-textfield v-smal-width','value'=>$itemVal['seller_id']));

?>
<div class="clear"></div>
<?php echo $form->end(); ?>


<?php }else{?>
	<div class="row-wid overflow-h">
		<?php echo "<span style='color:#76923C; padding-top:5px'>Your return request has been submitted. Please await further instructions by email.</span>";?>
	</div>

<?php }?>



<script defer="defer" language="JavaScript">
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