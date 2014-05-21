<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),'');?>
<style type="text/css">
.error-message {
float:none;
}
</style>
<!--Content Start-->
<!--Main Content Starts--->

             <section class="maincont nopadd">
                <section class="prdctboxdetal">
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
		     
                    <h4 class="diff-blu">Checkout Choiceful: Swift, Simple & Secure</h4>
                    <h4 class="orng-clr"><span class="gray-color">Step 1 of
                    <?php 
                    		if(!empty($from_giftcertificate))
					echo "3";
				else
					echo "5";

			?>
			
                    </span> Sign in</h4>
                    <!---->
                    <p class="lgtgray applprdct">Please sign in using your e-mail address and existing Choiceful password, then click on the Sign In button </p>
                    <!---->
                    <?php echo $form->create("Checkout", array('action'=>'step1/'.$from_giftcertificate,'default' => true,'name'=>'frmCheckout'));?>
                    <ul class="signinlist">
                       <li>What's your e-mail address?</li>
                       <li>
			<?php
				 if(!empty($errors['emailaddress'])){
					 $errorEmail='error_message_box';
				 }else{                                                  
					 $errorEmail='';
				 }
			 ?>
			<?php echo $form->input('User.emailaddress',array('size'=>'30','class'=>$errorEmail,'maxlength'=>'50','label'=>false,'error'=>false,'div'=>false));?>
                       </li>
                       <li>Do you have a Choiceful.com password?</li>
                       <li class="margin-top">
                       <?php
                       		$options=array('1'=>'<label> No, I am a new customer</label>','0'=>'<label> Yes, I have a password</label>');
				$attributes=array('separator'=>'<li class="margin-top">','legend'=>false,'label'=>false,'onClick'=>'setFocustoPassword(this.value);');
				echo $form->radio('User.customer',$options,$attributes);
			?>
			</li>
                       <li class="margin-top">
			
                       <?php echo $form->input('User.password1',array('maxlength'=>'30' , 'type'=>'password', 'style' => 'width:73%; padding:6px 5px; border:1px solid #cecece; margin:6px 0;' , 'onClick'=>'setFocustoYes()', 'label'=>false,'div'=>false));?>
                       </li>
                       <li class="margin-top">
                       		<?php echo $form->button('Sign In',  array('type'=>'submit', 'class' => 'signinbtnwhyt') );?>
                       </li>
                       
                       <li class="applprdct toppadd">
                       <p><?php echo $html->link("Forgotten your password?",array("controller"=>"users","action"=>"forgotpassword"),array('escape'=>false));?>
                       </li>
                    </ul>
                    <?php echo $form->end();?>
                </section>
             </section>
          <!--Main Content End--->
          <!--Navigation Starts-->
             <nav class="nav">
                      <ul class="maincategory yellowlist">
                         <?php echo $this->element('mobile/nav_footer');?>
                      </ul>
                    </nav>              
          <!--Navigation End-->
<!--Content Closed-->
<script type="text/javascript">
function setFocustoPassword(value_field){
	if(value_field == 0){
		jQuery('#UserPassword1').focus();
	}
}
function setFocustoYes(value_field){
		jQuery('#UserCustomer0').attr("checked", "checked");
}
</script>