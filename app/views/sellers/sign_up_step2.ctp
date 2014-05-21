<?php $user_signed = $this->Session->read('User'); ?>
<!--mid Content Start-->
<div class="mid-content">
	
	
	<!--Blue Head Box Start-->
	<div class="blue-head-bx">
		<h5 class="bl-bg-head">Join Choiceful Marketplace</h5>
		<div class="wt-bx-widget">
			<!--Top Section Start-->
			<div class="top-sec">
				<ul>
					<?php if(empty($user_signed)){?>
						<?php $url_reffer = $this->params['url']['url'];?>
						<li>Already have an account? <?php if(empty($user_signed)){ echo $html->link("<strong>Sign-in</strong>",'/users/login/'.base64_encode($url_reffer),array('class'=>'underline-link','escape'=>false)); } else { echo $html->link("<strong>Sign-in</strong>",'/sellers/choiceful-marketplace-sign-up',array('class'=>'underline-link','escape'=>false));}?> here</li>
					<?php }?>
					<li class="join-alert"><strong>You are in a secure environment</strong></li>
				</ul>
				<div class="cl-widget"></div>
			</div>
			<?php
			if ($session->check('Message.flash')){ ?>
				<div class="messageBlock">
					<?php echo $session->flash();?>
				</div>
			<?php } ?>
			<?php
				if(!empty($errors)){
					$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
				?>
					<div class="error_msg_box"> 
						<?php echo $error_meaasge;?>
					</div>
			<?php }?>
			<!--Top Section Closed-->
			<h5 class="gray-heading smalr-fnt">Your Company</h5>
			<!--Form Widget Start-->
			<?php echo $form->create('Seller',array('action'=>'sign_up_step2','method'=>'POST','name'=>'frmSeller','id'=>'frmSeller'));?>
			<div class="form-widget">
				<ul>
					<li><p class="pdng">This information is not disclosed.</p></li>
					<li>
						<label><span class="star">*</span> Business Name :</label>
						<div class="form-field-widget">
						<?php
						if(!empty($errors['business_name'])){
								$errorBusinessName ='form-textfield error_message_box';
							}else{
								$errorBusinessName ='form-textfield';
							}
						echo $form->input('Seller.business_name',array('size'=>'30','class'=>$errorBusinessName,'maxlength'=>'30','label'=>false,'error'=>false,'div'=>false));?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> Address Line 1 :</label>
						<div class="form-field-widget">
						<?php
						if(!empty($errors['address1'])){
								$errorAddress1 ='form-textfield error_message_box';
							}else{
								$errorAddress1 ='form-textfield';
							}
						echo $form->input('Seller.address1',array('size'=>'30','class'=>$errorAddress1,'maxlength'=>'30','label'=>false,'error'=>false,'div'=>false));?>
						<span class="instructions-line line-break">House name number and Street, PO Box, C/O</span>
						</div>
					</li>
					<li>
						<label>Address Line 2 :</label>
						<div class="form-field-widget">
						<?php
							if(!empty($errors['address2'])){
								$errorAddress2 ='form-textfield error_message_box';
							}else{
								$errorAddress2 ='form-textfield';
							}
						echo $form->input('Seller.address2',array('size'=>'30','class'=>$errorAddress2,'maxlength'=>'30','label'=>false,'div'=>false,'error'=>false));?>
						<span class="instructions-line line-break">Optional</span>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> Town/City :</label>
						<div class="form-field-widget">
						<?php
							if(!empty($errors['city'])){
								$errorCity ='form-textfield error_message_box';
							}else{
								$errorCity ='form-textfield';
							}
						echo $form->input('Seller.city',array('size'=>'30','class'=>$errorCity,'label'=>false,'error'=>false,'div'=>false));?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span>Postcode/Zip :</label>
						<div class="form-field-widget">
						<?php
							if(!empty($errors['postcode'])){
								$errorPostcode ='form-textfield error_message_box';
							}else{
								$errorPostcode ='form-textfield';
							}
						echo $form->input('Seller.postcode',array('size'=>'30','class'=>$errorPostcode,'label'=>false,'error'=>false,'div'=>false));?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> Country :</label>
						<div class="form-field-widget">
						<?php
							if(!empty($errors['country_id'])){
								$errorCountryId ='select error_message_box';
							}else{
								$errorCountryId ='select';
							}
						echo $form->select('Seller.country_id',$countries,null,array('onchange'=>'displayState();','type'=>'select','class'=>$errorCountryId,'label'=>false,'div'=>false,'size'=>1),'-- Select --');
						?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span>State/country :</label>
						<input type="hidden" name="userStateFieldName" id="userStateFieldName" value="Seller.state">
						<?php
						if(isset($this->data['Seller']['state'])){
						$this->data['Seller']['state'] = $this->data['Seller']['state'];
						}else{
						$this->data['Seller']['state'] = '';
						}
						
						if(!empty($errors['state'])){
								$errorStateText ='form-textfield error_message_box';
							}else{
								$errorStateText ='form-textfield';
							}
						echo $form->hidden('Address.statetext', array('value'=>$errorStateText));
						if(!empty($errors['state'])){
								$errorStateSelect ='select error_message_box';
							}else{
								$errorStateSelect ='select';
							}
						
						echo $form->hidden('Address.stateselect', array('value'=>$errorStateSelect));
						echo $form->hidden('Address.selected_state', array('value'=>$this->data['Seller']['state'] ));
						?>
						
						<div class="form-field-widget" id="userStateTextSelect_div"><?php echo $form->input('Seller.state',array('size'=>'30','class'=>$errorStateText,'label'=>false,'div'=>false,'error'=>false,'style'=>'padding-top:0px'));?></div>
					</li>
					
					<li class="margin-top"><label>&nbsp;</label>
						<?php $options_sub2=array(
							"url"=>"/sellers/sign_up_step2","before"=>"",
							"update"=>"sign-up",
							
							"indicator"=>"plsLoaderID",
							'loading'=>"showloading()",
							"complete"=>"hideloading()",
							"class" =>"continue_sel_reg",
							"type"=>"Submit",
							"id"=>"testid2",
							"div"=>false
						);?>
						<?php
						echo $html->link($html->image("blue-back-btn.gif" ,array('alt'=>"",'div'=>false )), '/sellers/sign_up/',array('update' => 'sign-up','escape'=>false),null,FALSE);?>
						<?php
						 echo $form->button('',array('type'=>'submit','div'=>false,'class'=>'yellow-continue','style'=>'height:32px;'));
						
						//echo $ajax->link($html->image("blue-back-btn.gif" ,array('alt'=>"",'div'=>false )), '/sellers/sign_up/',               array('update' => 'sign-up','escape'=>false),null,FALSE);?> <?php //echo $ajax->submit('yellow-btn.png',$options_sub2);?>
					</li>
				</ul>
			</div>
			<!--Form Widget Closed-->
			
			<?php echo $form->end();?>
		</div>
		<!--White box Start-->
	</div>
	<!--Blue Head Box Closed-->
</div>
<!--mid Content Closed-->

<!--breadcrumbs starts here-->
<!---- <div class="footer-breadcrumb-widget sellers-signup">
	 <?php
	        echo "<div class='crumb_text_break'><strong>You are here:</strong>";
		echo $html->link($html->image('/img/star_c.png', array("alt"=>"Choiceful.com",'class'=>'star_c')),'/',array('escape'=>false));
		echo " </div><div class='crumb_img_break'> > " ;

$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
$this->Html->addCrumb('Create a Marketplace Account - Business Information', '');

echo $this->Html->getCrumbs(' > ' , '');
echo "</div>" ;
?>
</div> ---->
<!--ends-->

<script type="text/javascript" language="javascript">
var countryId = jQuery("#SellerCountryId").val();
if(countryId >0){
 displayState();
}
</script>