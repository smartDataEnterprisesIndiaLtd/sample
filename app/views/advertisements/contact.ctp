<?php echo $javascript->link(array('jquery')); ?>
<script>
var err_msg_alert = '<?php echo $errors ?>';
if((err_msg_alert != '') && (jQuery("#fancybox-content",parent.document).height() == 325))
{
	jQuery("#fancybox-content",parent.document).height(jQuery("#fancybox-content",parent.document).height()+60);
}
</script>

<style>
.advertisement_mail_failed { color: red!important;  font-family: Arial,Helvetica,sans-serif!important;font-size: 12px!important;padding: 12px 42px!important; font-weight: normal!important;}
.secure-content{background:url(<?php echo SITE_URL;?>/img/secure-icon.png) no-repeat; padding-left:28px;}
</style>
<?php 
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $form->create('Advertisement',array('action'=>'contact','method'=>'POST','name'=>'frmAdvertisement','id'=>'frmAdvertisement'));
?>
<ul class="pop-con-list" style="margin-right:10px">
	<?php 
	if ($session->check('Message.flash')){ ?>
	<div >
		<div class="messageBlock"><?php echo $session->flash();?></div>
	</div>
	<?php }
	?>
	<?php
	if(!empty($errors)){
		$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
	?>
		<div class="error_msg_box"> 
			<?php echo $error_meaasge;?>
		</div>
	<?php }?>
	<li>
        	<h4 class="orange-color-text">Advertise with Choiceful.com</h4>
		<p class="gr-colr">Please fill out the form below. Fields marked red are required.</p>
	</li>
	<li>
		<ul class="ad-form-widget">
			<li><label class="red-color-text">Company</label>
				<?php
				if($form->error('Advertisement.company')) {
					$errorCompany = 'textfield small-width-input error_message_box';
				}else {
					$errorCompany = 'textfield small-width-input';
				} ?>
				<?php echo $form->input('Advertisement.company',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>$errorCompany,'error'=>false,'div'=>false));?>
			</li>
			<li>
				<label  class="red-color-text">Contact Name</label>
				<?php
				if($form->error('Advertisement.contact_name')) {
					$errorContactName = 'textfield small-width-input error_message_box';
				}else {
					$errorContactName = 'textfield small-width-input';
				} ?>
				<?php echo $form->input('Advertisement.contact_name',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>$errorContactName,'error'=>false,'div'=>false));?>
			</li>
			<li>
				<label>Website</label>          	
				<?php echo $form->input('Advertisement.website',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield small-width-input','div'=>false));?>
			</li>
			<li>
				<label>Product/Service</label>          	
				<?php echo $form->input('Advertisement.product_service',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield small-width-input','div'=>false));?>
			</li>
			<li>
				<label class="red-color-text">Email</label>
				<?php
				if($form->error('Advertisement.email')) {
					$errorEmail = 'textfield small-width-input error_message_box';
				}else {
					$errorEmail = 'textfield small-width-input';
				} ?>
				<?php echo $form->input('Advertisement.email',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>$errorEmail,'error'=>false,'div'=>false));?>
			</li>
			<li>
				<label>Phone</label>          	
				<?php echo $form->input('Advertisement.phone',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield small-width-input','div'=>false));?>
			</li>
			<li><label>Brief description of your company and campaign
				<span class="gr-colr line-brk">(Maximum 500 characters)</span></label>
<!-- 				<textarea name="textarea" class="textfield small-width-input" cols="45" rows="4"> -->
				<?php echo $form->input('Advertisement.description',array('size'=>'30','label'=>false,'class'=>'textfield small-width-input','rows'=>'5','cols'=>'70','style'=>'width:200px','div'=>false,'maxlength'=>500,'showremain'=>'limit')); ?></textarea>
				<!--br><span class="gr-colr line-brk" style="float:left">Ramaining characters: </span><span class="gr-colr line-brk" id="limit">500</span-->
			</li>
			<li>
				<div class="secure-content" style="float:left">
					<p><strong>You are in a secure environment</strong></p>
					<p class="gr-colr">Learn more about our
					<?php //echo $html->link("privacy policy",array("controller"=>"pages","action"=>"view",'privacy-policy'),array('escape'=>false,'class'=>"underline-link"));?>
					<?php echo $html->link('privacy policy','javascript:void(0)',array('escape'=>false,'onClick'=>'golink(\'/pages/view/privacy-policy\');'));?>
					
					</p>
				</div>
				<div class="blue-button-widget float-right" style="padding-right:2px;"><?php echo $form->button('Send Email',array('type'=>'submit','class'=>'blue-btn','div'=>false));?></div></li>
		</ul>
	</li>
</ul>
<?php
echo $form->end();
?>