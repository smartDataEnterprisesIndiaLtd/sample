<?php
$seller_id = $this->Session->read('User.id');
$msg_flg = 0;
echo $form->create('Order',array('action'=>'contact_sellers','method'=>'POST','name'=>'frmAddMessage_'.$itemVal['id'],'id'=>'frmAddMessage_'.$itemVal['id'])); ?>
<div class="row-wid overflow-h">
	<!--Comment Widget Left Start-->
	<?php if ($session->check('Message.flash')){?>
	<li><?php echo $session->flash();?></li>
	<?php } ?>
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
                <div class="left-text pad-tp">Reasons for returning (optional)</div>
                    <div class="rt-con">Quantity:
		    <?php
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
		    ?>
		    
		    
		     <?php $options = array_combine(range(1,$remaining_dispatched_items),range(1,$remaining_dispatched_items));?>
		     <?php echo $form->input('Order.quantity'.$itemVal['id'],array('options'=>$options,'class'=>'select', 'type'=>'select','empty'=>'Select','default'=>'','label'=>false,'div'=>'')); ?>
                     </div>
                </li>
                <li>
                  <p class="pad-rt2"><?php echo $form->input("Order.message",array('style'=>'height:90px; padding:0px;', "label"=>false,"div"=>false,'rows'=>5,'maxlength'=>500, 'cols'=>30, 'class'=>'textfield full-width')); ?></p>
                </li>
                <li>
			<?php
		echo $form->hidden('Item.seller_id1',array('value'=>$itemVal['seller_id']));
		echo $form->hidden('Item.id',array('value'=>$itemVal['id']));
		?>

			<?php echo $form->hidden('Order.to_user_id',array('label'=>false,'div'=>false, 'value'=>$itemVal['seller_id']));?>
			<?php //$new_options = $options.'_'.$itemVal['id'];
				$options = array(
				"url"=>"/orders/add_msg","before"=>"",
				"update"=>"msg_".$itemVal['id'],
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"grnggradbtn margin-none",
				"type"=>"Submit",
				"id"=>"message".$itemVal['id'],
			);?>
			<?php //echo $ajax->submit('Change Name',$options);?>
			<?php echo $ajax->submit('Confirm Return Request',$options);?>
		</li>
              </ul>
              <!--Confirm Request Closed-->
	      
</div>

<!--Previous Message Start-->
<div class="previous-message-widget">
	<!--Message Start-->
	<h4 class="yellow-heading sml-fnt">Previous Messages</h4>
	<ul class="previous-message-sec">
		<?php 
		if(!empty($itemVal['Message'])){ 
		foreach($itemVal['Message'] AS $mKey=>$mVal){
			if($mVal['from_user_id'] == -1 && $mVal['to_user_id'] != $this->Session->read('User.id')){

			} else{
		?>
			<?php if($mVal['msg_from'] == 'B'){ // msg from buyer to seller ?>
			<li><strong>Your message to <?php echo $itemVal['seller_name']; ?> on <?php echo date("d F Y", strtotime($mVal['created'])); ?></strong></li>
			<?php }else if($mVal['msg_from'] == 'A') {?>
			<li><strong>Message from choiceful.com  on <?php echo date("d F Y", strtotime($mVal['created'])); ?></strong></li>
			<?php } else {?>
			<li><strong>Message from <?php echo $itemVal['seller_name']; ?> on <?php echo date("d F Y", strtotime($mVal['created'])); ?></strong></li>
			<?php }?>
			<li>Re: Order number <?php echo $itemVal['order_id'];?>, Item: <?php echo $itemVal['product_name'];?></li>
			<li class="message1">
				<p><?php echo wordwrap($mVal['message'], 80, "\n"); ?></p>
			</li>
		<?php } }
		}else{ ?>
			<li><strong>No previous message found</strong></li>
		<?php } ?>
	</ul>
	
</div>
<!--Previous Message Closed-->
<div class="clear"></div>
<?php echo $form->end(); ?>