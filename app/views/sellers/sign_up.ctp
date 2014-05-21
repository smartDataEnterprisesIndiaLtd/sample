<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
$user_signed = $this->Session->read('User');

?>
<script language="JavaScript">	
// function to provide the state dropdown

function displayState(){
	//alert('Hello');
	var countryId = jQuery("#SellerCountryId").val();
	var stateFieldName = jQuery("#userStateFieldName").val();
	var selectedStateValue = jQuery("#AddressSelectedState").val();
	if(countryId == ''){
		countryId = '0';
	}
        if(selectedStateValue == ''){
		selectedStateValue = '1';
	}
	//var selectclassName = 'select';
	//var textclassName = 'form-textfield';
	var textclassName = jQuery("#AddressStatetext").val();
	var selectclassName = jQuery("#AddressStateselect").val();
	
            var url = SITE_URL+'totalajax/DisplayStateBox/'+countryId+'/'+stateFieldName+'/'+selectedStateValue+'/'+selectclassName+'/'+textclassName;
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
</script>

<!--mid Content Start-->
<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading", 'width'=>'20', 'height'=>'20'));?></div>
<div id="sign-up">
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
					if($errors['email'] == "This email address is already registered, please sign in to upgrade to a seller account"){
						$error_meaasge = $errors['email'];
					}
				?>
					<div class="error_msg_box"> 
						<?php echo $error_meaasge;?>
					</div>
			<?php }?>
			
			<!--Top Section Closed-->
			<h5 class="gray-heading smalr-fnt">You Personal Information</h5>
			<!--Form Widget Start-->
			<?php echo $form->create('Seller',array('action'=>'sign_up','method'=>'POST','name'=>'frmSeller','id'=>'frmSeller'));?>
			<div class="form-widget">
				<ul>
					<li><p class="pdng">Tell us about yourself so that we may communicate with you. We will send all make me an offer&trade;, sales and instant messages to your email address. This information will not be disclosed.</p></li>
					<li>
						<label><span class="star">*</span> Title :</label>
						<div class="form-field-widget">
						<?php 
						if(!empty($errors['title'])){
								$errorTitle='select error_message_box';
							}else{
								$errorTitle='select';
							}
						echo $form->select('Seller.title',$title,null,array('type'=>'select','class'=>$errorTitle,'label'=>false,'div'=>false, 'error'=>false,'size'=>1),'Select');
						?>
						</div>
					</li>
					<li>
						<label><span class="star">*</span> First Name :</label>
						<div class="form-field-widget">
						<?php 
						if(!empty($errors['firstname'])){
								$errorFirstname='form-textfield error_message_box';
							}else{
								$errorFirstname='form-textfield';
							}
						echo $form->input('Seller.firstname',array('size'=>'30','class'=>$errorFirstname,'maxlength'=>'30','label'=>false,'error'=>false,'div'=>false));?>
						</div>
					<!--</li>-->
					<!--<li>-->
						<?php echo $form->hidden('Seller.user_id',array('type'=>'text','label'=>false,'div'=>false));?>
					</li>
					<li>
						<label><span class="star">*</span> Last Name :</label>
						<div class="form-field-widget">
						<?php
						if(!empty($errors['lastname'])){
								$errorLastname='form-textfield error_message_box';
							}else{
								$errorLastname='form-textfield';
							}
						echo $form->input('Seller.lastname',array('size'=>'30','class'=>$errorLastname,'label'=>false,'error'=>false,'maxlength'=>'30','div'=>false));?>
						</div>
					</li>
					<?php if(empty($user_signed)){ ?>
					<li>
						<label><span class="star">*</span> Email :</label>
						<div class="form-field-widget">
						<?php
						if(!empty($errors['email'])){
								$errorEmail ='form-textfield error_message_box';
							}else{
								$errorEmail ='form-textfield';
							}
						echo $form->input('Seller.email',array('size'=>'30','class'=>$errorEmail,'label'=>false,'error'=>false,'maxlength'=>'50','div'=>false));?>
						</div>
						</li>
					<li>
						<label><span class="star">*</span> Password :</label>
						<div class="form-field-widget">
						<?php
						if(!empty($errors['password'])){
								$errorPassword='form-textfield error_message_box';
							}else{
								$errorPassword='form-textfield';
							}
						echo $form->input('Seller.password',array('size'=>'30','class'=>$errorPassword,'label'=>false,'error'=>false,'maxlength'=>'30','div'=>false));?>
						</div>
						<span class="instructions-line line-break">Password should be at least 6 characters long. For enhanced security please add numbers and special characters (e.g. @).</span>
					</li>
					<li>
						<label><span class="star">*</span> Type it again :</label>
						<div class="form-field-widget">
						<?php
						if(!empty($errors['confirmpassword'])){
								$errorConfirmpassword ='form-textfield error_message_box';
							}else{
								$errorConfirmpassword ='form-textfield';
							}
						echo $form->input('Seller.confirmpassword',array('size'=>'30','class'=>$errorConfirmpassword,'maxlength'=>'30','label'=>false,'error'=>false,'type'=>'password','div'=>false));?>
						</div>
					</li>
					<?php } else{
						echo $form->hidden('Seller.email',array('size'=>'30','class'=>'form-textfield','label'=>false,'maxlength'=>'50','div'=>false));
					}?>
					<li>If you contact us by telephone we will verify your details using the security question below:</li>
					<li>
						<label><span class="star">*</span>Secret Question :</label>
						<div class="form-field-widget">
						<?php
						if(!empty($errors['secret_question'])){
								$errorSecret ='select error_message_box';
							}else{
								$errorSecret ='select';
							}
						echo $form->select('Seller.secret_question',$security_questions,null,array('type'=>'select','class'=>$errorSecret,'label'=>false,'div'=>false,'size'=>1),'Select');
						?>
						</div>                           
					</li>
					<li>
						<label><span class="star">*</span>Answer :</label>
						<div class="form-field-widget">
						<?php
							if(!empty($errors['secret_answer'])){
								$errorSecret_answer ='form-textfield error_message_box';
							}else{
								$errorSecret_answer ='form-textfield';
							}
							echo $form->input('Seller.secret_answer',array('size'=>'30','class'=>$errorSecret_answer,'maxlength'=>'30','label'=>false,'error'=>false,'div'=>false));?>
						</div>
					</li>
					<li><label>&nbsp;</label>
					<?php $options=array(
						"url"=>"/sellers/sign_up","before"=>"",
						"update"=>"sign-up",
						"indicator"=>"plsLoaderID",
						'loading'=>"showloading()",
						"complete"=>"hideloading()",
						"class" =>"",
						"type"=>"Submit",
						"id"=>"testid",
					);?>
					<?php //echo $ajax->submit('yellow-btn.png',$options);?>
				<?php echo $form->button('',array('type'=>'submit','div'=>false,'class'=>'yellow-continue'));?></li>
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
<!---<div class="footer-breadcrumb-widget sellers-signup">
	 <?php
		echo "<div class='crumb_text_break'><strong>You are here:</strong>";
		echo $html->link($html->image('/img/star_c.png', array("alt"=>"Choiceful.com",'class'=>'star_c')),'/',array('escape'=>false));
		echo " </div><div class='crumb_img_break'> > " ;

$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
$this->Html->addCrumb('Create a Marketplace Account - Personal Information', '');

echo $this->Html->getCrumbs(' > ' , '');
echo "</div>" ;
?>
</div> -->

</div>