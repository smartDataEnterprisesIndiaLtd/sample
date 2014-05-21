<?php $user_signed = $this->Session->read('User');?>
<style>
.float-left div{padding-top:0px}
</style>
<div class="mid-content">
	
	<!--Blue Head Box Start-->
	<div class="blue-head-bx">
		<h5 class="bl-bg-head">Join Choiceful Marketplace</h5>
		<!--White box Start-->
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
			<h5 class="gray-heading smalr-fnt">Customer Service Contact Information</h5>
			<!--Form Widget Start-->
			<?php //echo $form->create('Seller',array('action'=>'sign_up_step3','method'=>'POST','name'=>'frmSeller','id'=>'frmSeller'));?>
			<?php echo $form->create('Seller',array('action'=>'sign_up_step3','method'=>'POST','name'=>'frmSeller3','id'=>'frmSeller3'));?>
			<div class="form-widget">
				<ul>
					<li><p class="pdng">Customer Service details are visible to customers only once an order is placed. You might choose to enter a different email address to that provided as your account email for handling customer service related enquires, if not please enter the same email address.</p>
					</li>
					<li>
						<div class="float-left"><label><span class="star">*</span>Customer Service Email :</label>
						<?php
						if(!empty($errors['service_email'])){
								$errorServiceEmail ='form-textfield smallr-width error_message_box';
							}else{
								$errorServiceEmail ='form-textfield smallr-width';
							}
						echo $form->input('Seller.service_email',array('size'=>'30','class'=>$errorServiceEmail,'maxlength'=>'30','label'=>false,'error'=>false,'div'=>true));?></div>
						<div class="float-left"><label><span class="star">*</span>Contact Phone Number :</label>
						<?php
						if(!empty($errors['phone'])){
								$errorPhone ='form-textfield smallr-width error_message_box';
							}else{
								$errorPhone ='form-textfield smallr-width';
							}
						echo $form->input('Seller.phone',array('size'=>'30','class'=>$errorPhone,'maxlength'=>'30','label'=>false,'error'=>false,'div'=>true)); ?></div>
					</li>
		
					<li class="margin-top"><h5 class="gray-heading smalr-fnt">Customer Service Contact Information</h5></li>
					<li><p class="pdng">Enter your business display name, visible to all on Choiceful.com.</p>
					</li>
					<li>
						<div class="float-left">
							<label><span class="star">*</span>Display Name :</label>
							<?php
							if(!empty($errors['business_display_name'])){
								$errorBusiness ='form-textfield smallr-width error_message_box';
							}else{
								$errorBusiness ='form-textfield smallr-width';
							}
							echo $form->input('Seller.business_display_name',array('size'=>'30','class'=>$errorBusiness,'maxlength'=>'30','label'=>false,'error'=>false,'div'=>true)); ?>
						</div>
					</li>
					<li class="margin-top"><h5 class="gray-heading smalr-fnt">Free Delivery Threshold <span class="gray">[Optional]</span></h5>
					</li>
					<li><p class="pdng">Boost sales by offering free standard delivery when customers spend over a threshold order value.</p></li>
					<li><span class="side-pad">
						<?php
						$options=array('0'=>' <strong>Disabled</strong></span><span class="side-pad">','1'=>' <strong>Enabled</strong></span>');
						$attributes=array('legend'=>false,'label'=>false,'value'=>'0');
						echo $form->radio('Seller.free_delivery',$options,$attributes);
						?>
						<span class="side-pad"><strong>Enter order value: <span class="larger-fnt"> &pound;</span></strong>
						
						<?php
						if(!empty($errors['threshold_order_value'])){
								$errorThreshold ='form-textfield small-width error_message_box';
							}else{
								$errorThreshold ='form-textfield small-width';
							}
						echo $form->input('Seller.threshold_order_value',array('size'=>'30','class'=>$errorThreshold,'maxlength'=>'30','label'=>false,'div'=>false,'error'=>false,'style'=>'float: none;')); ?> e.g. 35.00
						
						</span>
						
					</li>
					<li class="margin-top"><h5 class="gray-heading smalr-fnt">Gift Options <span class="gray">[Optional]</span></h5>
					</li>
					<li><p class="pdng">Gift options include gift-wrapping services and gift messages, if enabled customers can choose to select this during checkout. Details will be sent along with the order confirmation email. Gift-wrapping and messages are an additional 95p per item. <?php echo $html->link("Click here",'/pages/view/gift-options',array('class'=>'underline-link','escape'=>false))?> to find out more.</p>
					</li>
					<li><span class="side-pad">
						<?php
						$options_gift=array('0'=>' <strong>Disabled</strong></span><span class="side-pad">','1'=>' <strong>Enabled</strong></span>');
						$attributes_gift=array('legend'=>false,'label'=>false);
						echo $form->radio('Seller.gift_service',$options_gift,$attributes_gift);
						?>
					</li>
					<li class="margin-top">
						<?php $options_sub3=array(
							"url"=>"/sellers/sign_up_step3","before"=>"",
							"update"=>"sign-up",
							"indicator"=>"plsLoaderID",
							'loading'=>"showloading()",
							"complete"=>"hideloading()",
							"class" =>"continue_sel_reg",
							"type"=>"Submit",
							"id"=>"testid3",
							"div"=>false
						);
// $html->image("blue-back-btn.gif" ,array('alt'=>"",'div'=>false )); ?>
						<?php
						 echo $html->link($html->image("blue-back-btn.gif" ,array('alt'=>"",'div'=>false )), '/sellers/sign_up_step2/',array('update' => 'sign-up','escape'=>false),null,FALSE);?>
						
						<?php
						
						echo $form->button('',array('type'=>'submit','div'=>false,'class'=>'yellow-continue','style'=>'height:32px;'));
						
						//echo $ajax->link($html->image("blue-back-btn.gif" ,array('alt'=>"",'div'=>false )), '/sellers/sign_up_step2/',array('update' => 'sign-up','escape'=>false),null,FALSE);?> <?php //echo $ajax->submit('yellow-btn.png',$options_sub3);?>
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
<!--- <div class="footer-breadcrumb-widget sellers-signup">
	 <?php
	        echo "<div class='crumb_text_break'><strong>You are here:</strong>";
		echo $html->link($html->image('/img/star_c.png', array("alt"=>"Choiceful.com",'class'=>'star_c')),'/',array('escape'=>false));
		echo " </div><div class='crumb_img_break'> > " ;

$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
$this->Html->addCrumb('Create a Marketplace Account - Seller Account Settings', '');

echo $this->Html->getCrumbs(' > ' , '');
echo "</div>" ;
?>
</div> --->