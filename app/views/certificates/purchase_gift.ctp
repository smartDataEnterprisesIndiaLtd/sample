<?php 
echo $javascript->link('functions');
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $javascript->link('lib/prototype');
e($html->script('jquery-1.4.3.min',false));
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
$this->data['Certificate']['Recipient'] = 'example:joe@example.com';
$logg_user_id =0;
$logg_user_id = $this->Session->read('User.id');

$this->set('logg_user_id',$logg_user_id);
if(!empty($logg_user_id)) {
	$fancy_width = 362;
	$fancy_height = 350;
	$fancy_feedback_width = 362;
} else{
	$fancy_width = 560;
	$fancy_height = 165;
	$fancy_feedback_width = 560;
}
if(!empty($logg_user_id)) {
	$fancy_report_width = 362;
	$fancy_report_height = 220;
} else{
	$fancy_report_width = 560;
	$fancy_report_height = 165;
}
?>
<style>
.small-width {
float:left;
margin-right:5px;
}
.form-textfield {
margin-right:5px;
float:left;
}
</style>
<script language="JavaScript">
	jQuery(document).ready(function()  { // for writing a review
		jQuery("#write_review").fancybox({
			'autoScale' : true,
			'centerOnScroll':true,
			'width' : <?php echo $fancy_width; ?>,
			//'height' : <?php echo $fancy_height; ?>,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
		 // for writing a review
		jQuery("#email_friend").fancybox({
			'autoScale' : true,
			'centerOnScroll':true,
			'width' : 410,
			//'height' : 320,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
				//parent.location.reload(true);;
			},
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
		 // for make me an offer
		jQuery("#make_me_an_offer").fancybox( {
			'autoScale' : true,
			'centerOnScroll':true,
			'width' : <?php echo $fancy_width; ?>,
			//'height' : <?php echo $fancy_height; ?>,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
				//parent.location.reload(true);;
			},
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
		jQuery("a.thisreport").fancybox({
			'autoScale' : true,
			'centerOnScroll':true,
			'width' : <?php echo $fancy_report_width;?>,
			//'height' : <?php echo $fancy_report_height;?>,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
		jQuery("a.ansque").fancybox({
			'autoScale' : true,
			'centerOnScroll':true,
			'width' : <?php echo $fancy_report_width;?>,
			//'height' : 290,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
				parent.location.reload(true);;
			},
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height()+30);
			});
			}
		});
		jQuery("a.large-image").fancybox({
			'autoScale' : true,
			'centerOnScroll':true,
			'width' : 600,
			'height' : 670,
			'padding':0,
			'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
		});
		
		jQuery("a.feedback-popup").fancybox({
			'autoScale' : true,
			'centerOnScroll': true,
			'width' : <?php echo $fancy_feedback_width;?>,
			//'height' : 203,
			'padding':0,'overlayColor':'#000000',
			'centerOnScroll': true,
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'title':false,
			'autoDimensions': false,
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
	});
</script>
<div class="right-widget margn-left">
	<?php echo $this->element('navigations/right_add');?>
</div>
<div class="mid-content pro-mid-content">
	

	
	<?php
		if(!empty($errors)){	
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
			<div class="error_msg_box" style="overflow: hidden;"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }?>

	<h2 class="orange-col-head h2-head">The Gift of Choice</h2>
	<!--Product Preview Widget Start-->
	<div class="inner-content">
		<p>Give your loved ones exactly whatever they want; with millions of products to browse through we're sure to have something offer</p>
		<!--Form Section Start-->
				
		<div class="frm-wdgt overflow-h">
			<div class="float-left"><?php echo $html->image("gift-cert-img.jpg",array('width'=>"88",'height'=>"120", 'alt'=>"" )); ?></div>
			<?php echo $form->create('Certificate',array('action'=>'purchase_gift','method'=>'POST','name'=>'frmCertificate','id'=>'frmCertificate'));?>
			<div class="form-sec">
				<h4 class="margin-bottom">E-mail gift certificate details</h4>
				<p>Fill out the information below to create and e-mail a gift certificate</p>
						
				<ul class="form-widget">
					<li>
						<label class="sml-width-label"><span class="star-mand">*</span>Enter Amount:</label>
						<div class="form-field-widget">
						<?php if(!empty($errors['amount'])){
								$errorAmount='form-textfield small-width error_message_box';
							}else{
								$errorAmount='form-textfield small-width';
							}
						?>
						<?php echo $form->input('Certificate.amount',array('class'=>$errorAmount,'onkeyup'=>'javascript: if( isNaN(this.value) ){ this.value=""; }','maxlength'=>'9','label'=>false, 'error'=>false, 'div'=>false,'onChange'=>'fixPriceDecimals(this.id,this.value)'));?>  <span class="smalr-fnt">(up to £500.00)</span></div>
					</li>
					<li>
						<label class="sml-width-label"><span class="star-mand">*</span>Quantity:</label>
						<div class="form-field-widget">
						<?php if(!empty($errors['amount'])){
								$errorQuantity='form-textfield small-width error_message_box';
							}else{
								$errorQuantity='form-textfield small-width';
							}
						?>
						<?php echo $form->input('Certificate.quantity',array('class'=>$errorQuantity,'onkeyup'=>'javascript: if( isNaN(this.value) ){ this.value=""; }','maxlength'=>'9','label'=>false,'error'=>false,'div'=>false,'onChange'=>'fixQuantityDecimals(this.id,this.value)'));?>  <span class="smalr-fnt">(per recipient)</span></div>
					</li>
					<li>
						<label class="sml-width-label"><span class="star-mand">*</span>Recipient E-mail:</label>
						<div class="form-field-widget">
						<?php if(!empty($errors['amount'])){
							$errorRecipient='form-textfield error_message_box';
						}else{
							$errorRecipient='form-textfield';
						}
						?>
						<?php echo $form->input('Certificate.recipient',array('class'=>$errorRecipient,'maxlength'=>'100','label'=>false,'error'=>false,'div'=>false,'onBlur'=>'changeEmailField();','onClick'=>'changeEmailField();'));?>
						</div>
					</li>
					<li>
						<label class="sml-width-label">To:</label>
						<div class="form-field-widget"><?php echo $form->input('Certificate.to',array('class'=>'form-textfield','maxlength'=>'100','label'=>false,'div'=>false));?></div>
					</li>
					<li>
						<label class="sml-width-label">From:</label>
						<div class="form-field-widget"><?php echo $form->input('Certificate.from',array('class'=>'form-textfield','maxlength'=>'100','label'=>false,'div'=>false));?></div>
					</li>
					<li>
						<label class="sml-width-label">Message:</label>
						<div class="form-field-widget">
							<p class="pdrt6"><?php echo $form->input('Certificate.message',array('class'=>'textfield fullwidth','label'=>false,'div'=>false,'rows'=>5,'cols'=>50,'showremain'=>'limitOne','maxLength'=>300));?></p>
						</div>
					</li>
					<li>
						<label class="sml-width-label">&nbsp;</label>
						<div style="color:#7C7C7C;font-size:10px">Remaining characters : 
						<span id ="limitOne"><?php if(!empty($this->data)){
							if(!empty($this->data['Certificate']['message'])) {
								$remain = 300 - strlen($this->data['Certificate']['message']);
								echo $remain;
							} else {
								echo '300';
							} 
						} else { 
							echo '300'; } ?></span></div>
					</li>
					<li>
						<label class="sml-width-label"> </label>
						<div class="form-field-widget">
							<!--Button Start-->
							<div class="button-widget right_buttonsec">
								<?php echo $form->submit('Checkout',array('type'=>'submit','class'=>'orange-btn','div'=>false)); ?>
							</div>
							<!--Button Closed-->
							<!--secure environment Start-->							
							<div class="secure-content secr_envrment">
								<strong>You are in a secure environment</strong>
								<p class="gray smalr-fnt">Learn more about our
								<?php echo $html->link('privacy policy','/pages/view/privacy-policy',array('escape'=>false));?>
								</p>
							</div>
							<!--secure environment Closed-->	
							
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!--Form Section Closed-->
		<?php echo $form->end();?>
	</div>
	<!--Product Preview Widget Closed-->
	<?php if(!empty($detail_info)) { ?>
	<!--Technical Details Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>Terms & Conditions</span></h4>
			<div class="tec-details">
				<?php echo $detail_info;?>
			</div>
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Technical Details Closed-->
	<?php }?>
	<?php
	echo $this->element('gift_certificate/search_tags'); ?>
	
	<!--Rate This Item Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>Rate This Item</span></h4>
			<div class="rate-this-item" id="avg_rate">
				<?php echo $this->element('gift_certificate/save_rating'); ?>
			</div>
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Rate This Item Closed-->
	<?php //$this->set('product_details',$product_details);
	echo $this->element('gift_certificate/reviews');
	echo $this->element('gift_certificate/question_answers');?>
	<!--Customers Viewing This Page May Be Interested in These Sponsored Links Start-->
	
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<!--<h4 class="mid-gr-head blue-color"><span>Customers Viewing This Page May Be Interested in These Sponsored Links</span></h4>-->
			<div class="tec-details">
				<!--- <div class="recent-history-section inc-border">
				<div class="ad300x250">
					<p>
						<script type="text/javascript"><!--
						google_ad_client = "pub-7745761219242437";
						/* 300x250, created 17/05/11 */
						google_ad_slot = "4673952244";
						google_ad_width = 300;
						google_ad_height = 250;
						//-
						</script>
						<script type="text/javascript"
						src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
					</p>
					<p align="center">Advertisement |
					<?php
						if(!empty($logg_user_id))
							$ad_feedback_link = '/products/ad_feedback/'.$product_details['Product']['quick_code'];
						else
							$ad_feedback_link = '/users/sign_in/';
						?>
					<?php echo $html->link('Ad feedback',$ad_feedback_link,array('escape'=>false, 'class'=>'gray underline-link feedback-popup'));?>
					<a class="gray underline-link" href="#"></a></p>
				</div>
				 </div> --->
				<div class="smalr-fnt margin-top">
					<p><?php echo $html->link('<strong>Email a friend about this product!</strong>','/certificates/email_friend',array('id'=>'email_friend','escape'=>false,'class'=>'diff-blue-color'));?></p>
					<p>Seen a mistake on this page? 
					<?php 
					if(!empty($logg_user_id))
						$link_tell_admin = '/certificates/tell_admin';
					else
						$link_tell_admin = '/users/sign_in/';

					echo $html->link('<strong>Tell us about it!</strong>',$link_tell_admin,array('id'=>'email_friend','escape'=>false,'class'=>'diff-blue-color thisreport'));?></p>
					<p><?php echo $html->link('<strong>back to top</strong>','#top',array('escape'=>false,'class'=>'diff-blue-color'));?></p>
				</div>
			</div>
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Customers Viewing This Page May Be Interested in These Sponsored Links Closed-->
	<!--Recent History Widget Start-->
	<div class="margin-bottom-none ad-widget_product_"  style="border-bottom:1px solid #C1C1C1;">
		<!--Recent History Start-->
		<div class="recent-history">
			<h4><strong>Your Recent History</strong></h4>
			<ul class="smalr-fnt ur_rec_his">
				<?php
				if(!empty($myRecentProducts)){
					$i=0;
				foreach ($myRecentProducts as $product){
					if($product['product_image'] == 'no_image.gif' || $product['product_image'] == 'no_image.jpeg'){
						$image_path = '/img/no_image.jpeg';
					} else{
						$image_path = '/'.PATH_PRODUCT.'small/img_50_'.$product['product_image'];
					}
					$i++;
					if($i > 6){ // ahow only 5 items
						continue;
					}
					echo '<li><span class="rec_his_img">';
					//echo $html->image($image_path,array('width'=>"20",'height'=>"20", 'alt'=>""));
					echo $html->link($html->image($image_path,array('width'=>"20",'height'=>"20",'alt'=>$product['product_name'],'title'=>$product['product_name'] )), "/".$this->Common->getProductUrl($product['id'])."/categories/productdetail/".$product['id'],array( 'escape'=>false));?>
					</span>
					<span class="rec_his_des">
					<?php
					//echo $html->link($format->formatString($product['product_name'],25, '..'),"/".$this->Common->getProductUrl($product['id'])."/categories/productdetail/".$product['id'],array('escape'=>false,'class'=>'underline-link'));
					echo $html->link($product['product_name'],"/".$this->Common->getProductUrl($product['id'])."/categories/productdetail/".$product['id'],array('escape'=>false,'class'=>'underline-link'));
					echo '</li></span>';
				}
				}  else{ ?>
				<li style="color:#666">No products viewed</li>
				<?php } ?>
			</ul>
		</div>
		<!--Recent History Closed-->
		<!--Recent History Product List Start-->
		<?php echo $this->element('/gift_certificate/countinue_shopping_fh');?>
		<!--Recent History Product List Closed-->
	</div>
	<!--Recent History Widget Closed-->
</div>

<script type="text/javascript">
function openwindow(linkurl) {
	window.open(linkurl,"mywindow","menubar=0,scrollbar=1,resizable=1,width=600,height=600");
}
function change_star(starid,text_flag){
	var id = starid;
	if(text_flag != 1){
		if(id == 1){
			jQuery('#ratetext').text('I hate it');
		} else if(id == 2){
			jQuery('#ratetext').text("I don't like it");
		} else if(id == 3){
			jQuery('#ratetext').text("It's ok");
		} else if(id == 4){
			jQuery('#ratetext').text("I like it");
		} else if(id == 5){
			jQuery('#ratetext').text("I love it");
		} else{
			jQuery('#ratetext').text("Unrated");
		}
	}
	for(var i=1; i <= id; i++){
		jQuery('#s_'+i).attr('src', SITE_URL+'/img/blue-star.png');
	}
}

function change_toblstar(starid,text_flag,saved_stars){
	var id = starid;
	if(text_flag != 1){
		jQuery('#ratetext').text("Rate it");
		for(var i=1; i <= id; i++){
			jQuery('#s_'+i).attr('src', SITE_URL+'/img/bl-start.png');
		}
	} else{
		for(var i=1; i <= saved_stars; i++){
			jQuery('#s_'+i).attr('src', SITE_URL+'/img/blue-star.png');
		}
		for(var j=i; j <= id; j++){
			jQuery('#s_'+j).attr('src', SITE_URL+'/img/bl-start.png');
		}
	}
}

function save_rating(stars){
	var postUrl = SITE_URL+'certificates/save_rating/'+stars;
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#avg_rate').html(msg);
	}
	});
}

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
</script>