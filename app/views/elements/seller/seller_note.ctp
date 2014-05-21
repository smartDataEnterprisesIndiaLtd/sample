<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);?>
<?php echo $form->create('Seller',array('action'=>'add_sellernote','method'=>'POST','name'=>'frmSeller','id'=>'frmSeller'));?>
<!--Seller Note Start-->
<style>
	.dimmer {
		position: fixed;
	}
</style>
<div class="seller-note">
	<ul>
		<li><strong>Seller Notes</strong> Not visible to buyer</li>
		<li>
			<?php
			if(!empty($errors['seller_note'])){
				//$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
				$error_meaasge="No comments have been saved";
			?>
			<div class="error_msg_box" style="width:79.1%;"> 
				<?php echo $error_meaasge;?>
			</div>	
		</li>
		<li>
			
			<?php }
				if(!empty($errors['seller_note'])){
					$errorSellerNote='form-textfield extra-big error_message_box';
				}else{
					$errorSellerNote='form-textfield extra-big';
				}
			echo $form->textarea("OrderSeller.seller_note",array("label"=>false,"div"=>false,'rows'=>5,'maxlength'=>500, 'cols'=>45, 'showremain'=>"limitOne", 'class'=>$errorSellerNote)); ?><?php //echo $form->error('OrderSeller.note'); ?>
			<p class="pad-tp smalr-fnt">Max. 500 characters, no HTML Remaining characters: <span id ="limitOne"><?php if(!empty($this->data)){
					if(!empty($this->data['OrderSeller']['seller_note'])) {
						$remain = 500 - strlen($this->data['OrderSeller']['seller_note']);
						echo $remain;
					} else {
						echo '500';
					} 
				} else {
					echo '500'; } ?></span>
			</p>
		</li>
		<li>
			<?php echo $form->input("OrderSeller.id");
			$options=array(
				"url"=>"/sellers/add_sellernote",
				"update"=>"seller_note",
				"indicator"=>"plsLoaderID1",
				'loading'=>"showloading()",
				"complete"=>"hideloading()",
				"class" =>"blk-bg-input-small",
				"type"=>"Submit",
				"id"=>"myNote",
				'style'=>'float:left;margin-left:0px'
			);
			echo $ajax->submit('Submit',$options);
			?>
			<?php if(!empty($errors)){
				//echo '<div class="error-message" style="padding-left:66px; padding-top:2px;">'.$errors['seller_note'].'</div>';
			}?>
			
			<?php if(!empty($saved_msg)){
				echo '<div class="saved_msg">Saved</div>';
			}?>
		</li>
	</ul>
</div>
<!--Seller Note Closed-->
<?php echo $form->end(); ?>