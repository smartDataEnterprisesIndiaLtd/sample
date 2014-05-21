<?php 
$this->data['Certificate']['Recipient'] = 'example:joe@example.com';
$logg_user_id =0;
$logg_user_id = $this->Session->read('User.id');
?>
<style>
.error-message {
	text-align:center;
}
</style>

<!--Main Content Starts--->
<section class="maincont nopadd">
<!--Product Detail Box Starts-->
	<section class="prdctboxdetal">
	<!--Product Preview Widget Start-->
	<div class="product-preview-widget">
	<h4 class="orange-col-head boldr">The Gift of Choice</h4>
	<p class="margin-top">Give your loved ones exactly whatever they want; with millions of products to browse through we're sure to have something on offer</p>
	</div>
	<!--Product Preview Widget Closed-->
	<!--jQuery Tabz Starts-->
		<section class="jqtabz">
		<!--Product Description Starts-->
			<ul class="tabs">
			<li><a href="#tab1">Create Gift Certificate</a></li>
			<li><a href="#tab2">Terms</a></li>
			<li><a href="#tab3">Reviews/Q&amp;A</a></li>
			</ul>
		<!---->
			<div class="tab_container">
			<div id="tab1" class="tab_content"> 
			<!--Content--> 
				<!--Form Section Start-->
					<?php
						if(!empty($errors)){	
								$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
							?>
							<div class="error_msg_box" style="overflow: hidden;"> 
								<?php echo $error_meaasge;?>
							</div>
					<?php }?>
				<?php echo $form->create('Certificate',array('action'=>'purchase_gift','method'=>'POST','name'=>'frmCertificate','id'=>'frmCertificate'));?>
				<section class="productdescptn">
				<ul class="choicegift">
					<li><label>*Enter Amount:</label>
						<?php if(!empty($errors['amount'])){
								$errorAmount='smalltxtbx error_message_box';
							}else{
								$errorAmount='smalltxtbx';
							}
						?>
						<?php echo $form->input('Certificate.amount',array('class'=>$errorAmount,'maxLength'=>5,'label'=>false,'div'=>false,'error'=>false,'onChange'=>'fixPriceDecimalsMobile(this.id,this.value)'));?>
					<span>(up to &pound;500) </span>					
					</li>
					<li><label>*Quantity:</label>
						<?php if(!empty($errors['quantity'])){
								$errorQuantity='smalltxtbx error_message_box';
							}else{
								$errorQuantity='smalltxtbx';
							}
						?>
						<?php echo $form->input('Certificate.quantity',array('class'=>$errorQuantity,'label'=>false,'div'=>false,'error'=>false,'onkeyup'=> 'javascript: if(isNaN(this.value)){ this.value = "" }'));?>
					<span>(per recipient)</span>
					</li>
					<li><label>*Recipient E-Mail:</label>
						<?php if(!empty($errors['recipient'])){
							$errorRecipient='gray error_message_box';
						}else{
							$errorRecipient='gray';
						}
						?>
						<?php echo $form->input('Certificate.recipient',array('class'=>$errorRecipient,'label'=>false,'div'=>false,'error'=>false,'onBlur'=>'changeEmailField();','onClick'=>'changeEmailField();'));?>
					</li>
					<li><label>To:</label>
						<?php echo $form->input('Certificate.to',array('class'=>'form-textfield','label'=>false,'div'=>false));?>
					</li>
					<li><label>From:</label>
						<?php echo $form->input('Certificate.from',array('class'=>'form-textfield','label'=>false,'div'=>false));?></li>
					<li><label>Message:</label>
						<?php echo $form->input('Certificate.message',array('class'=>'textfield','label'=>false,'style'=>'border: 1px solid #7F9DB9','div'=>false,'rows'=>5,'cols'=>50,'showremain'=>'limitOne','maxLength'=>300));?>
					</li>
					<li><label>&nbsp;</label>
						<?php echo $form->submit('Clear Form',array('type'=>'button','class'=>'ornggradbtn','div'=>false,'onClick'=>'clearValues();'));?>
						<?php echo $form->submit('Checkout',array('type'=>'submit','class'=>'ornggradbtn','div'=>false)); ?>
					</li>
				</ul>
			</section>
			<!--Form Section Closed-->
			<?php echo $form->end();?>
		</div>
		
		
		<div id="tab2" class="tab_content"> 
		<!--Content--> 
		<section class="productdescptn termsgfts">
		<?php echo $detail_info;?>
		</section> 
		</div>
		<div id="tab3" class="tab_content"> 
		<!-- Review Start-->
			<?php echo $this->element('mobile/gift_certificate/reviews');?>
		<!-- Review End-->
		
		<!-- Start question and answers-->
			<?php echo $this->element('mobile/gift_certificate/question_answers');?>
		<!--End question and answers -->
		</div>
		
		
		
	</div>
	<!--Product Description End-->
	</section>
<!--jQuery Tabz End-->
	</section>
<!--Product Detail Box Starts-->
<script>
function changeEmailField(){
	var emails = jQuery('#CertificateRecipient').val();
	if(emails == 'example:joe@example.com'){
		jQuery('#CertificateRecipient').val('');
	} else if(emails == ''){
		jQuery('#CertificateRecipient').val('example:joe@example.com');
	} else{

	}
}

var emails = jQuery('#CertificateRecipient').val();
if(emails == ''){
	jQuery('#CertificateRecipient').val('example:joe@example.com');
}

function clearValues(){
	jQuery('#CertificateAmount').val('');
	jQuery('#CertificateQuantity').val('');
	jQuery('#CertificateRecipient').val('example:joe@example.com');
	jQuery('#CertificateTo').val('');
	jQuery('#CertificateFrom').val('');
	jQuery('#CertificateMessage').val('');
}
//For Mobile only
function fixPriceDecimalsMobile(id,valu){
	var price = valu;
	if(isNaN(price)){
		jQuery('#'+id).val('');
	}
	if(price > 0){
		var num = new Number(price);
		var roundedprice = num.toFixed(2);
	}
	jQuery('#'+id).val(roundedprice);
}
</script>