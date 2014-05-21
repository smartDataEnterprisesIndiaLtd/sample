<?php ?>
<style>
.error-message {
	line-height:18px;
}
</style>
<!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab')?>
<!--Tbs Closed-->
	<!--Tbs Cnt start-->
<?php echo $form->create('Order',array('action'=>'file_a_claim/'.$seller_id.'/'.$order_item_id.'/'.$prod_id,'method'=>'POST','name'=>'frmVerify','id'=>'frmVerify')); ?>
	<section class="tab-content">
	<?php if ($session->check('Message.flash')) { ?>
	<li><div  class="messageBlock"><?php echo $session->flash();?></div></li>
	<?php } ?>
	<!--Row1 Start-->
	<div class="row pad-btm0">
		<!--cancel item start-->
		<ul class="csl-list">
			<li><h4 class="green-color">File a Claim</h4></li>
			<?php if(!empty($errors)){?>
				<li>
					<div class="error_msg_box"> 
						Please complete the mandatory fields highlighted below.
					</div>
				</li>
			<?php }?>
			<li><p class="choiceful font11">Contact Choiceful.com to file a claim against a seller.</p></li>
			<li><p><span class="bl-clr"><strong>
			<?php echo $html->link('Click here to read our 100% Buyer Protection Guarantee.',array('controller'=>'pages','action'=>'view','buy-confidence-guarantee'),array('escape'=>false,'class'=>'bl-clr text-decoration-none'));?>
			</strong></span></p></li>
			<li>
			<p><span class="font14"><strong>Item: </strong></span><?php echo $prod_name; ?></p>
			<p class="margin"><span class="font14"><strong>Seller:</strong></span>
				<?php
					$seller_name_url=str_replace(array(' ', '&'), array('-','and'),html_entity_decode($seller_name, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link($seller_name,'/sellers/'.$seller_name_url.'/summary/'.$orderItem['seller_id'].'/'.$orderItem['product_id'].'/'.$orderItem['condition_id'],array('escape'=>false,'class'=>'underline-link'));
					
				?>
				<?php //echo $seller_name; ?>
			</p>
			</li>
			<li class="select-reason"><strong>Select a reason:</strong> 
				<?php 
				if(($form->error('Order.reason'))){
					$errorClass='textfield error_message_box';
				}else{
					$errorClass='textfield';
				}
				echo $form->select('Order.reason',$claim_reason,$selected_reason,array('class'=>$errorClass, 'type'=>'select','style'=>'margin-right:5px; width:199px;'),'Choose a reason'); ?>
				<?php if(!($form->error('Order.reason')))
				?>
			</li>
			<li class="margin">Please provide as much detail as possible</li>
			<li>
			<p><strong>Comments:</strong></p>
			<p class="margin pad-rt2">
				<?php if(($form->error('Order.comment'))){
						$errorClass='full-width textfield error_message_box';
					}else{
						$errorClass='full-width textfield';
					}
					echo $form->input("Order.comment",array("label"=>false,"div"=>false,'rows'=>5,'maxlength'=>'', 'cols'=>30, 'class'=>$errorClass ,'error'=>false)); ?>
					
			</p>
			
			</li>
			<li><p class="font11"><strong>What happens next:</strong> we contact the seller on your behalf to resolve the issues raised. Please allow up to 7 days for us to respond to your claim. Read our helpful article on <?php echo $html->link('How to File a Claim','/pages/view/filing-a-claim-against-a-seller',array('escape'=>false));?> for more information.</p></li>
			<li class="margin-top">
			<?php
			echo $form->hidden('Order.seller_id',array('class'=>'textbox','label'=>'', 'value'=>$seller_id, 'div'=>false));
			echo $form->hidden('Order.prod_id',array('class'=>'textbox','label'=>'', 'value'=>$prod_id, 'div'=>false));
			echo $form->hidden('Order.item_id',array('class'=>'textbox','label'=>'', 'value'=>$order_item_id, 'div'=>false));
			
			echo $form->hidden('Order.prod_name',array('class'=>'textbox','label'=>'', 'value'=>$prod_name, 'div'=>false));
			echo $form->hidden('Order.seller_name',array('class'=>'textbox','label'=>'', 'value'=>$seller_name, 'div'=>false));
			?>
			<?php echo $form->button('Submit',array('type'=>'submit','class'=>'grnggradbtn margin-none','div'=>false));?>
		</ul>
		<!--cancel item closed-->                	
	</div>
	<!--Row1 Closed-->
	
</section>
<?php echo $form->end();?>
<!--Tbs Cnt closed-->