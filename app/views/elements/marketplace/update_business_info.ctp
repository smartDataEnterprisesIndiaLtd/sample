<?php
if ($session->check('Message.flash')){ ?>
	<div class="messageBlock"><?php echo $session->flash();?></div>
<?php }
if(!empty($errors)){
		$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
	?>
	<div class="error_msg_box"> 
		<?php echo $error_meaasge;?>
	</div>
<?php }
	echo $form->create('Seller',array('action'=>'update_business_info','method'=>'POST','name'=>'frmSeller2','id'=>'frmSeller2'));?>
<div class="account-setting">
	<!--Gray Back heading Start-->
	<div class="gray-bg-heading">
		<ul>
			<li class="head"><strong>Business Information</strong></li>
			<li class="closed-link">
				<?php $options1=array(
					"url"=>"/sellers/update_business_info","before"=>"",
					"update"=>"business-info",
					"indicator"=>"plsLoaderID",
					'loading'=>"showloading()",
					"complete"=>"hideloading()",
					"class" =>"btn_blk-bg-link",
					"style" =>"cursor: pointer",
					"type"=>"Submit",
					"id"=>"testid1",
					"div"=>false
				);?><?php echo $ajax->submit('Submit',$options1);?>
			</li>
		</ul>
	</div>
	<!--Gray Back heading Closed-->
	<!--Account Setting Fields Start-->
	<div class="account-setting-fields">
		<!--Account Setting Fields Rows Start-->
		<ul class="account-setting-fields-rows">
			<li>
				<div class="account-setting-fields-label"><label><span class="star">*</span>Display Name:</label></div>
				<div class="account-setting-fields-field"><div>
					<?php
						if(!empty($errors['business_display_name'])){
							$errorBusiness='form-textfield error_message_box';
						}else{
							$errorBusiness='form-textfield';
						}
					?>
					<?php echo $form->input('Seller.business_display_name',array('size'=>'30','class'=>$errorBusiness,'maxlength'=>'30','label'=>false,'div'=>false,'error'=>false,'style'=>'padding-top:0px')); ?>
				</div></div>
			</li>
			<li>
				<div class="account-setting-fields-label"><label><span class="star">*</span> Address Line 1:</label></div>
				<div class="account-setting-fields-field">
				<?php
					if(!empty($errors['address1'])){
						$errorAddress1='form-textfield error_message_box';
					}else{
						$errorAddress1='form-textfield';
					}
				?>
				<?php echo $form->input('Seller.address1',array('size'=>'30','class'=>$errorAddress1,'maxlength'=>'30','label'=>false,'div'=>false,'error'=>false,'style'=>'padding-top:0px'));?></div>
			</li>
			<li>
				<div class="account-setting-fields-label"><label> Address Line 2:</label></div>
				<div class="account-setting-fields-field"><?php echo $form->input('Seller.address2',array('size'=>'30','class'=>'form-textfield','maxlength'=>'30','label'=>false,'div'=>false,'style'=>'padding-top:0px'));?></div>
			</li>
			<li>
				<div class="account-setting-fields-label"><label><span class="star">*</span> Town/City :</label></div>
				<div class="account-setting-fields-field">
				<?php
					if(!empty($errors['city'])){
						$errorCity='form-textfield error_message_box';
					}else{
						$errorCity='form-textfield';
					}
				?>
				<?php echo $form->input('Seller.city',array('size'=>'30','class'=>$errorCity, 'maxlength'=>'30','label'=>false,'div'=>false,'error'=>false,'style'=>'padding-top:0px'));?></div>
			</li>
			<li>
				<div class="account-setting-fields-label"><label><span class="star">*</span>Postal Code:</label></div>
				<div class="account-setting-fields-field">
				<?php
					if(!empty($errors['city'])){
						$errorPostcode='form-textfield error_message_box';
					}else{
						$errorPostcode='form-textfield';
					}
				?>
				<?php echo $form->input('Seller.postcode',array('size'=>'30','class'=>$errorPostcode,'maxlength'=>'10','label'=>false,'div'=>false,'style'=>'padding-top:0px','error'=>false));?></div>
			</li>
			<li>
				<div class="account-setting-fields-label"><label><span class="star">*</span> Country:</label></div>
				<div class="account-setting-fields-field">
				<?php
					if(!empty($errors['country_id'])){
						$errorCountry='select error_message_box';
					}else{
						$errorCountry='select';
					}
				?>
				<?php echo $form->select('Seller.country_id',$countries,null,array('onchange'=>	'displayState();', 'type'=>'select','class'=>$errorCountry,'style'=>'padding-top:0px','label'=>false,'div'=>false,'size'=>1),'-- Select --');
				//echo $form->error('Seller.country_id'); ?><?php echo $form->hidden('Seller.address_id',array('type'=>'text','size'=>'30','class'=>'form-textfield','maxlength'=>'30','label'=>false,'div'=>false,'style'=>'padding-top:0px'));?></div>
			</li>
			<li>
				<div class="account-setting-fields-label"><label><span class="star">*</span> State/county :</label></div>
				<input type="hidden" name="userStateFieldName" id="userStateFieldName" value="Seller.state">
				<?php
				if(isset($this->data['Seller']['state'])){
					$this->data['Seller']['state'] = $this->data['Seller']['state'];
				}else{
					$this->data['Seller']['state'] = '';
				}
				 echo $form->hidden('Address.selected_state', array('value'=>$this->data['Seller']['state'] ));?>
                                 
				<div class="account-setting-fields-field" >
					<?php
						if(!empty($errors['state'])){
							$errorState='select error_message_box';
						}else{
							$errorState='select';
						}
						echo $form->hidden('stateclassSelect', array('value'=>$errorState,'id'=>'textclassSelectId'));
					?>
					<?php
						if(!empty($errors['state'])){
							$errorState='form-textfield error_message_box';
						}else{
							$errorState='form-textfield';
						}
						echo $form->hidden('stateclass', array('value'=>$errorState,'id'=>'textclassNameId'));
					?>
				<span id="userStateTextSelect_div">
					<?php echo $form->input('Seller.state',array('size'=>'30','class'=>'form-textfield', 'error'=>false,'label'=>false,'div'=>false,'style'=>'padding-top:0px'));?>
				</span>
					<div class="error-message"><?php
						if(!empty($errors['state'])){
							//echo $errors['state'];
						}?>
					</div>
				</div>
				
				<div >
				 <?php
				 // echo $form->hidden('Seller.state',array('size'=>'30','class'=>'form-textfield','label'=>false,'div'=>false,'style'=>'padding-top:0px'));
				?>
				 </div>
				 
			</li>
			
		</ul>
		<!--Account Setting Fields Rows Closed-->
	</div>
	<!--Account Setting Fields Closed-->
</div>
<?php echo $form->end();?>
<script type="text/javascript" language="javascript">
var countryId = jQuery("#SellerCountryId").val();
if(countryId >0){
 displayState();
}
</script>