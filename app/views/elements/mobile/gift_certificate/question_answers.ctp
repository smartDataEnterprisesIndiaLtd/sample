<?php ?>
<!--Questions &amp; Answers Start-->
<style type="text/css">
.dimmer{
	position:fixed;
	left:45%;
	top:55%;
}
</style>
<!--Reviews Start-->
<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>

<div class="tec-details" id="askqueid">
	<ul style="padding-top:10px;">
		<li class="revwhead orange-col-head boldr applprdct">
			Q&amp;A
			<?php echo $html->link('Ask a question','javascript:void(0)',array('escape'=>false,'onclick'=>'askAqusetion()','class'=>'underline-link ansque'));?>
		</li>
	</ul>
	<?php if(!empty($questions)) { ?>
	<ul class="faq-sec">
		<?php foreach($questions as $que){?>
			<li>
				<p>
					<span class="drkred font13"><strong>Q</strong></span>
					<?php echo $que['CertificateQuestion']['question'];?>
					<?php
						//$ans_question_link = '/certificates/answer_question/'.$que['CertificateQuestion']['id']; ?>
						<?php echo $html->link('Answer Question','javascript:void(0)',array('escape'=>false,'onclick'=>'getAnswer('.$que['CertificateQuestion']['id'].')','class'=>'font11 underline-link'));
					?>
				</p>
				<?php if(!empty($que['CertificateAnswer'])){?>
					<?php foreach($que['CertificateAnswer'] as $answer) {
						$this->set('ans_id',$answer['id']); ?>
					<p>
						
						<span class="drkred pad-rt larger-font"><strong>A</strong></span>
						<?php echo $answer['answer']; ?>
						<?php echo $html->image("smiley.png",array('width'=>"10",'height'=>"9", 'alt'=>"" ,'class'=>'img')); ?>
					</p>
					
					<span id = <?php echo "voteans_".$answer['id'];?>>
						<?php echo $this->element('mobile/gift_certificate/vote_ans');?>
					</span>
					
				<?php }}?>
					
				<!--<p class="reviewer-count">
					<span class="gray">0 People found this helpful. Did you?</span>
					<a href="#"><strong>Yes</strong></a> | <a href="#"><strong>No</strong></a>
				</p>-->
			</li>
 			
		<?php }?>
	</ul>
	<?php }?>
</div>
<!--Questions &amp; Answers Closed-->
<script defer="defer" type="text/javascript">
var SITE_URL = "<?php echo SITE_URL; ?>";
 // function to like to dislike in giftcertificate
function askAqusetion(){
	var postUrl = SITE_URL+'certificates/add_question';
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#askqueid').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
function getAnswer(que_id){
	var postUrl = SITE_URL+'certificates/answer_question/'+que_id;
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#askqueid').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
</script>