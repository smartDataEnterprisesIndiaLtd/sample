<?php
echo $form->create('Seller',array('action'=>'update_business_info','method'=>'POST','name'=>'frmSeller2','id'=>'frmSeller2'));?>
<h2 class="font14">Business Information 
	<a href="#" class="blkgradbtn">
		<?php $options1=array(
			"url"=>"/sellers/update_business_info","before"=>"",
			"update"=>"business-info",
			"indicator"=>"plsLoaderID",
			'loading'=>"Element.show('plsLoaderID')",
			"complete"=>"Element.hide('plsLoaderID')",
			"class" =>"btn_blk-bg-link",
			"type"=>"Submit",
			"id"=>"testid1",
			"div"=>false
		);?><?php echo $ajax->submit('Change',$options1);?>
	</a></h2>
	
	<ul class="change">
		
		<?php
		if ($session->check('Message.flash')){ ?>
			<li><div class="messageBlock"><?php echo $session->flash();?></div></li>
		<?php }
		if(!empty($errors)){
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
			<li><div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div></li>
		<?php } ?>

		<li>
			<label>Business Display Name:</label>
			<p>
				<?php
					if(!empty($errors['business_display_name'])){
						$errorBusiness='txtfld error_message_box';
					}else{
						$errorBusiness='txtfld';
					}
				?>
				<?php echo $form->input('Seller.business_display_name',array('class'=>$errorBusiness,'maxlength'=>'30','label'=>false,'error'=>false,'div'=>false)); ?>
			</p>
		</li>
		<li><p class="orng-clr"><strong>Business Address</strong></p>
			<label class="pad-tp">Address Line 1:</label>
			<p>
				<?php
					if(!empty($errors['address1'])){
						$errorAddress1='txtfld error_message_box';
					}else{
						$errorAddress1='txtfld';
					}
				?>
				<?php echo $form->input('Seller.address1',array('class'=>$errorAddress1,'maxlength'=>'30','label'=>false,'error'=>false,'div'=>false));?>
			</p>
		</li>
		<li>
			<label>Address Line 2: <span class="gray-color fnt-wgt-nrml">(Optional)</span></label>
				<p>
					<?php echo $form->input('Seller.address2',array('class'=>'txtfld','maxlength'=>'30','label'=>false,'div'=>false));?>
				</p>
		</li>
		<li>
			<label>Town/City:</label>
			<p>
				<?php
					if(!empty($errors['city'])){
						$errorCity='txtfld error_message_box';
					}else{
						$errorCity='txtfld';
					}
				?>
				<?php echo $form->input('Seller.city',array('class'=>$errorCity,'label'=>false,'error'=>false,'div'=>false));?>
			</p>
		</li>
    	<li>
			<label>State/County:</label>
			<p>
					<?php
						if(!empty($errors['state'])){
							$errorState='slct error_message_box';
						}else{
							$errorState='slct';
						}
						echo $form->hidden('stateclassSelect', array('value'=>$errorState,'id'=>'textclassSelectId'));
					?>
					<?php
						if(!empty($errors['state'])){
							$errorState='txtfld error_message_box';
						}else{
							$errorState='txtfld';
						}
						echo $form->hidden('stateclass', array('value'=>$errorState,'id'=>'textclassNameId'));
					?>
				<input type="hidden" name="userStateFieldName" id="userStateFieldName" value="Seller.state">
				<?php
				if(isset($this->data['Seller']['state'])){
					$this->data['Seller']['state'] = $this->data['Seller']['state'];
				}else{
					$this->data['Seller']['state'] = '';
				}
				 echo $form->hidden('Address.selected_state', array('value'=>$this->data['Seller']['state'] ));?>
                                 
				 <div class="account-setting-fields-field" id="userStateTextSelect_div">
				 <?php echo $form->input('Seller.state',array('class'=>$errorState,'maxlength'=>'30','label'=>false, 'error'=>false,'div'=>false));
				?>
			</p>
		</li>
		<li>
			<label>Postcode:</label>
				<p>
					<?php
						if(!empty($errors['postcode'])){
							$errorPostcode='txtfld error_message_box';
						}else{
							$errorPostcode='txtfld';
						}
					?>
					<?php echo $form->input('Seller.postcode',array('class'=>$errorPostcode,'label'=>false,'error'=>false,'div'=>false));?>
				</p>
		</li>
		<li>
			<label>Country:</label>
			<p>
				<?php
					if(!empty($errors['country_id'])){
						$errorCountry='slct error_message_box';
					}else{
						$errorCountry='slct';
					}
				?>
				<?php echo $form->select('Seller.country_id',$countries,null,array('onchange'=>'displayState();', 'type'=>'select','class'=>$errorCountry,'label'=>false,'div'=>false,'size'=>1),'-- Select --');?>
				<?php echo $form->hidden('Seller.address_id',array('type'=>'text','class'=>'texfld','maxlength'=>'30','label'=>false,'div'=>false));?>
			</p>
		</li>
	</ul>
<?php echo $form->end();?>
<script defer="defer" type="text/javascript" language="javascript">
var countryId = jQuery("#SellerCountryId").val();
if(countryId >0){
 displayState();
}
</script>