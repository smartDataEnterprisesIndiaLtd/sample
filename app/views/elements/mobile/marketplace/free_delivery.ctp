<?php //echo $javascript->link('lib/prototype',true);?>

<!--Free Delivery Option Start-->
	<?php echo $form->create('Seller',array('action'=>'save_freedelivery','method'=>'POST','name'=>'frmSeller2','id'=>'frmSeller2'));?>
	<h2 class="font14">Free Delivery Option <a href="#" class="blkgradbtn">
			<?php $options2=array(
				"url"=>"/sellers/save_freedelivery","before"=>"",
				"update"=>"free-delivery",
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"btn_blk-bg-link",
				"type"=>"Submit",
				"id"=>"testid2",
				"div"=>false
			);?>
			<?php echo $ajax->submit('Change',$options2);?>
		</a></h2>
		
		<ul class="change">
			<?php
			if ($session->check('Message.flash')){ ?>
				<li><div class="messageBlock"><?php echo $session->flash();?></div></li>
			<?php } ?>
			<?php
			if(!empty($errors)){
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
					<li><div class="error_msg_box"> 
						<?php echo $error_meaasge;?>
					</div></li>
			<?php }?>
			
			<li>Offer a free delivery threshold to improve your average order values.</li> 
			<li>
			
				<?php
					$options_delivery=array('0'=>' <span class="wdth100"><strong>Disabled</strong></span>
					<span class="wdth100">','1'=>' <strong>Enabled</strong></span>');
					$attributes_delivery=array('legend'=>false,'label'=>false,'class'=>'adio v-align-middle');
					echo $form->radio('Seller.free_delivery',$options_delivery,$attributes_delivery);
				?>
			</li>
			<li>
				<span class="font16 v-algn-mid"><strong>&pound;</strong></span>
				<?php
					if(!empty($errors['threshold_order_value'])){
						$errorThreshold='input lowr-wdth error_message_box';
					}else{
						$errorThreshold='input lowr-wdth';
					}
				?>
				<?php echo $form->input('Seller.threshold_order_value',array('size'=>'30','class'=>$errorThreshold,'maxlength'=>'30','label'=>false,'div'=>false,'error'=>false)); ?>
				
				<span class="mrgn-lft">e.g.35.00</span>
			</li>
		</ul>
	<?php echo $form->end();?>
	
<!--Free Delivery Option Closed-->