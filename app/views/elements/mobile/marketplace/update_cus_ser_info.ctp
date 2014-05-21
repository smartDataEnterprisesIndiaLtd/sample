<script defer="defer" type="text/javascript" src="/js/lib/prototype.js"></script>
<?php //echo $javascript->link('lib/prototype',true);
echo $form->create('Seller',array('action'=>'update_customer_info','method'=>'POST','name'=>'frmSeller2','id'=>'frmSeller2'));?>

	<h2 class="font13">Customer Service Information 
		<a href="javascript:void(0);" class="blkgradbtn">
			
			<?php $options=array(
					"url"=>"/sellers/update_customer_info","before"=>"",
					"update"=>"cus-info",
					"indicator"=>"plsLoaderID",
					'loading'=>"Element.show('plsLoaderID')",
					"complete"=>"Element.hide('plsLoaderID')",
					"class" =>"btn_blk-bg-link",
					"type"=>"Submit",
					"id"=>"custinfo",
					"div"=>false
				); echo $ajax->submit('Change',$options);?>
		</a>
	</h2>
	<ul class="change">
	
		<?php
		if ($session->check('Message.flash')){ ?>
			<li>
				<div class="messageBlock"><?php echo $session->flash();?></div>
			</li>
		<?php }?>
	
		
		
		<li>
			<label>Customer Service Email:</label>
			<p>
				<?php echo $form->input('Seller.service_email',array('size'=>'30','class'=>'txtfld','maxlength'=>'30','label'=>false,'div'=>false)); ?>
				
				<!--<input type="text" name="textfield2" value="customer.service@hotmail.com" class="" />-->
			</p>
		</li>
		<li>
			<label>Contact Phone Number:</label>
			<p>
				<?php echo $form->input('Seller.phone',array('size'=>'30','class'=>'txtfld','maxlength'=>'30','label'=>false,'div'=>false));?><?php echo $form->hidden('Seller.address_id',array('size'=>'30','class'=>'form-textfield','maxlength'=>'30','label'=>false,'div'=>false,'style'=>'padding-top:0px'));?>
				
				<!--<input type="text" name="textfield2" value="0870 123 4567" class="txtfld" />-->
			</p>
		</li>
	</ul>
<?php echo $form->end();?>