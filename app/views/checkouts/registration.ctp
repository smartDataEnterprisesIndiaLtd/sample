<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);  ?>

<style>
.form-textfield { float:left; }
.error-message { float:none; }
.form-textfield{ margin-right:5px; }
</style>
<script type="text/javascript" language="javascript">	

	jQuery(document).ready( function(){
		jQuery('#UserCountryId').change(function() {
			displayState();
		})
	});
	
// function to provide the state dropdown
function displayState(){
	var countryId = jQuery("#UserCountryId").val();
	var stateFieldName = jQuery("#userStateFieldName").val();
	var selectedStateValue = jQuery("#AddressSelectedState").val();
	if(countryId == ''){
		countryId = '0';
	}
	if(selectedStateValue == ''){
		selectedStateValue = '1';
	}
	var selectclassName = 'select';
	var textclassName = jQuery('#AddressStateerror').val();
	//var textclassName = 'form-textfield';
	if(countryId != ''){
		var url =  SITE_URL+'totalajax/DisplayStateBox/'+countryId+'/'+stateFieldName+'/'+selectedStateValue+'/'+selectclassName+'/'+textclassName;
		//alert(url);
		jQuery('#plsLoaderID').show();
		jQuery('#fancybox-overlay-header').show();
		jQuery.ajax({
			cache:false,
			async:false,
			type: "GET",
			url:url,
			success: function(msg){
				jQuery('#userStateTextSelect_div').html(msg);
				jQuery('#plsLoaderID').hide();
				jQuery('#fancybox-overlay-header').hide();
			}
		});
	}
}
</script>


<!--Content Start-->
<div id="checkout-content">
<?php
		if ($session->check('Message.flash')){ ?>
		<div class="messageBlock">
			<?php echo $session->flash();?>
			
		</div>
		<?php } ?>
		
		<?php
		
		if(!empty($errors)){
			if(count($errors)==1 && !empty($errors['terms_conditions'])){
				$error_meaasge=$errors['terms_conditions'];
			}else{
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			}
			?>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }?>
	<!--Left Content Start-->
	<?php echo $this->element('checkout/left'); // include left side bar ?>
	<!--Left Content Closed-->
	<!--Right Content Start-->
	<div class="checkout-right-content1">
		
		<!--Form Left Widget Start-->
		<div class="form-checkout-widget wider-width-580">
                	<h4 class="gray margin-bottom">Welcome to our Express Registration</h4>
			<?php echo $form->create("Checkout", array('action'=>'registration/'.$from_giftcertificate,'default' => true,'name'=>'frmCheckout'));?>
			<!--Form Widget Start-->
			<div class="form-widget">
				<ul>
					<li>
						<label><span class="star">*</span> Title :</label>
						<div class="form-field-widget">
							<?php
								if(!empty($errors['title'])){
									$errorTitle='select error_message_box';
								}else{
									$errorTitle='select';
								}
							echo $form->select('User.title',$title,null,array('type'=>'select','class'=>$errorTitle,'label'=>false,'div'=>false,'size'=>1,'style'=>"float:left;margin-right:5px"),'Select');
							//echo $form->error('User.title');?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> First Name:</label>
						<div class="form-field-widget">
							<?php if(!empty($errors['firstname'])){
									$errorFirst='form-textfield error_message_box';
								}else{
									$errorFirst='form-textfield';
								}
							?>
							<?php echo $form->input('User.firstname',array('size'=>'30','class'=>$errorFirst,'maxlength'=>'30','error'=>false,'label'=>false,'div'=>false));?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> Last Name:</label>
						<div class="form-field-widget">
							<?php if(!empty($errors['lastname'])){
									$errorLast='form-textfield error_message_box';
								}else{
									$errorLast='form-textfield';
								}
							?>
							<?php echo $form->input('User.lastname',array('size'=>'30','class'=>$errorLast,'label'=>false,'maxlength'=>'30','error'=>false,'div'=>false));?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> Email :</label>
						<div class="form-field-widget" id="ShowEmailEditField" style="display:none;">
							<?php echo $form->input('User.email',array('size'=>'30','class'=>'form-textfield','label'=>false,'maxlength'=>'50','div'=>false));?>
						</div>
						
						<div class="form-field-widget" id="HideEmailField" style="display:block;">
						<ul class="li-pad-none">
						<li class="float-left"><?php echo $this->data['User']['email'] ;?></li>
						<li class="float-left"><img src="<?php echo SITE_URL; ?>/img/checkout/change-btn.gif" name="button2" value=" " class="v-align-middle" alt="Change this email address" onclick="document.getElementById('ShowEmailEditField').style.display='';document.getElementById('HideEmailField').style.display='none';" /></li>
						</ul>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> Password :</label>
						<div class="form-field-widget">
							<?php if(!empty($errors['newpassword'])){
									$errorNew='form-textfield error_message_box';
								}else{
									$errorNew='form-textfield';
								}
							?>
							<?php echo $form->input('User.newpassword',array('size'=>'30','class'=>$errorNew,'error'=>false,'type'=>'password','label'=>false,'maxlength'=>'30','div'=>false));?>
							<span class="instructions-line line-break gray">Password should be at least 6 characters long. For enhanced security please add numbers and special characters (e.g. @).</span>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> Please type your password again :</label>
						<div class="form-field-widget">
							<?php if(!empty($errors['newconfirmpassword'])){
									$errorNewconfirm='form-textfield error_message_box';
								}else{
									$errorNewconfirm='form-textfield';
								}
							?>
							<?php echo $form->input('User.newconfirmpassword',array('size'=>'30','class'=>$errorNewconfirm,'error'=>false,'type'=>'password','maxlength'=>'30','label'=>false,'div'=>false));?>
						</div>
					</li>
					<li style="padding-left: 155px;"><span class="instructions-line gray">Please enter the address to which your payment (debit/credit) card is registered to  below. Your order could be delayed if this address does not match to that which is held by your banking authority.</span></li>
					<li>
						<label><span class="star">*</span> Address Line 1:</label>
						<div class="form-field-widget">
							
							<?php if(!empty($errors['address1'])){
									$errorAddress1='form-textfield error_message_box';
								}else{
									$errorAddress1='form-textfield';
								}
							?>
							<?php echo $form->input('User.address1',array('size'=>'30','class'=>$errorAddress1,'maxlength'=>'30','label'=>false,'error'=>false,'div'=>false));?>
							<span class="instructions-line line-break gray">Company name/House name number and Street, PO Box, C/O</span>
						</div>
					</li>
					<li>
						<label>Address Line 2:</label>
						<div class="form-field-widget">
							<?php if(!empty($errors['address2'])){
									$errorAddress2='form-textfield error_message_box';
								}else{
									$errorAddress2='form-textfield';
								}
							?>
							<?php echo $form->input('User.address2',array('size'=>'30','maxlength'=>'30','class'=>$errorAddress2,'error'=>false,'label'=>false,'div'=>false));?>
							<span class="instructions-line line-break gray">Optional</span>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> Town/City:</label>
						<div class="form-field-widget">
							<?php if(!empty($errors['city'])){
									$errorCity='form-textfield error_message_box';
								}else{
									$errorCity='form-textfield';
								}
							?>
							<?php echo $form->input('User.city',array('size'=>'30','maxlength'=>'30','class'=>$errorCity,'error'=>false,'label'=>false,'div'=>false));?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> Postcode:</label>
						<div class="form-field-widget">
							<?php if(!empty($errors['postcode'])){
									$errorPostcode='form-textfield error_message_box';
								}else{
									$errorPostcode='form-textfield';
								}
							?>
							<?php echo $form->input('User.postcode',array('size'=>'30','maxlength'=>'30','class'=>$errorPostcode,'label'=>false,'error'=>false,'div'=>false));?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> Country:</label>
						<div class="form-field-widget">
							<?php if(!empty($errors['country_id'])){
									$errorCountry='form-textfield error_message_box';
								}else{
									$errorCountry='form-textfield';
								}
							?>
							<?php echo $form->select('User.country_id',$countries,null,array('type'=>'select','class'=>$errorCountry,'label'=>false,'error'=>false,'div'=>false,'size'=>1,'style'=>"float:left;margin-right:5px"),'Select');
							//echo $form->error('User.country_id');
							//$options = array('url' => '/totalajax/GetStatesForCheckoutRegistration','update' => 'state_div');
							//echo $ajax->observeField('UserCountryId', $options);
						?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> State/county:</label>
						<input type="hidden" name="userStateFieldName" id="userStateFieldName" value="User.state">
						<?php
						if(isset($this->data['User']['state'])){
							$this->data['User']['state'] = $this->data['User']['state'];
						}else{
							$this->data['User']['state'] = '';
						}
						echo $form->hidden('Address.selected_state', array('value'=>$this->data['User']['state'] ));
						
						if(!empty($errors['state'])){
							$errorState='form-textfield error_message_box';
						}else{
							$errorState='form-textfield';
						}
						
						echo $form->hidden('Address.stateerror', array('value'=>$errorState));
						?>
							
						<div class="form-field-widget" >
							<span id="userStateTextSelect_div" >
							<?php if(!empty($errors['state'])){
									$errorState='form-textfield error_message_box';
								}else{
									$errorState='form-textfield';
								}
							?>
							<?php echo $form->input('User.state',array('size'=>'30','maxlength'=>'30','class'=>$errorState,'label'=>false,'error'=>false,'div'=>false));?>
							</span>
							<?php //echo $form->error('User.state');?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> Phone Number:</label>
						<div class="form-field-widget">
							<?php if(!empty($errors['phone'])){
									$errorPhone='form-textfield error_message_box';
								}else{
									$errorPhone='form-textfield';
								}
							?>
							<?php echo $form->input('User.phone',array('size'=>'30','maxlength'=>'30','class'=>$errorPhone,'label'=>false,'error'=>false,'div'=>false));?>
						</div>
					</li>
					<li>
						<span class="instructions-line gray line-break">
							Choiceful.com respects your privacy and takes comprehensive measures to safeguard your personal and business information. We will not share your credentials and business data with any 3rd parties under any circumstances. By clicking on the Continue button you agree to our Privacy Policy. Please note you can amend your account details at any time by logging in to your Choiceful.com account. Please take a few moments to review our
							<?php echo $html->link("privacy policy",array("controller"=>"pages","action"=>"view",'privacy-policy'),array('escape'=>false,'class'=>"underline-link"));?>.
						</span>
					</li>
					
					<!--li>
						<span class="instructions-line gray line-break">
							As a Choiceful.com customer we will send you emails such as our e-newsletter, as well as catalogues and promotions through the post notifying you of relevent offers. If you do not wish to recieve such communictions, please use the  edit communication options in the My Account section. You can amend your preferences at any time by logging in to your Choiceful.com account. Please take a few moments to review the addintional preferences below and amends as necessary.
						</span>
					</li>
					<li>
						<?php //echo $form->checkbox("User.contact_phone",array("class"=>"checkbox","label"=>false,"div"=>false)); ?>
						<strong>Contact by telephone</strong>
						<span class="instructions-line gray line-break">Ensure this box remains ticket if you'd like to be notified of revevant offers over the phone by one of our sales team.</span>
					</li>
					<li>
						<?php //echo $form->checkbox("User.contact_partner",array("class"=>"checkbox","label"=>false,"div"=>false)); ?>
						<strong>Contact by partners</strong>
						<span class="instructions-line gray line-break">From time to time we would like to send you some information from carefully selected partners about discounts, products and services, which we think you'll be interested in. Ensure this box remains ticked if you'd like to receive these.</span>
					</li-->
					<li>
						<?php echo $form->checkbox("User.terms_conditions",array("class"=>"checkbox","label"=>false,"div"=>false)); ?>
						<strong>Please confirm that you have read our <?php echo $html->link("terms &amp; conditions",array("controller"=>"pages","action"=>"view",'conditions-of-use'),array('escape'=>false,'class'=>"underline-link"));
						//echo $form->error('User.terms_conditions'); ?></strong>
					</li>
					<li>
						<div class="float-left margin-top">
						<?php if(!empty($from_giftcertificate)) {
							echo $html->link($html->image("checkout/back-btn.gif" ,array('alt'=>"" )), '/checkouts/step1/1', array('escape'=>false) );
						} else {
							echo $html->link($html->image("checkout/back-btn.gif" ,array('alt'=>"" )), '/checkouts/step1', array('escape'=>false) );
						}?>
						<?php  ?>
						</div>
						<div class="float-right"><?php echo $html->link($html->image("checkout/continue-checkout-btn.png" ,array('alt'=>"" )), 'javascript:void(0)', array('escape'=>false,"onclick"=>"document.frmCheckout.submit()") );?><!-- input type="image" src="/img/checkout/continue-checkout-btn.png" name="submit" value=" " / --></div>
					</li>
				</ul>
			</div>
			<!--Form Widget Closed-->
			<?php echo $form->end(); ?>
		</div>
		<!--Form Left Widget Start-->
	</div>
	<!--Right Content Closed-->
</div>
<!--Content Closed-->
<script type="text/javascript" language="javascript">	
displayState();
</script>