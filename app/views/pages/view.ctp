<?php 
$pass_value = $this->params['pass'][0];
$array_check = array('help-topics','contact-us');
if(in_array($pass_value,$array_check)){
	$class = '';
}else{
	$class="content-list";
}

?>
<!--mid Content Start-->
<div class="mid-content">
	<?php
	if ($session->check('Message.flash')){ ?>
		<?php echo $session->flash();?>
	<?php } ?>
	<?php if(!empty($errors)){?>
		<div class="error_msg_box"> 
			Please add some information in the mandatory fields highlighted red below.
		</div>
	<?php }?>
	<?php
	if($this->params['pass'][0] == 'contact-us'){
		$classheading = 'h1-head-black';
	}else{
		$classheading = 'h1-head';
	}?>
	<h2 class="<?php echo $classheading;?> "><?php echo @$this->data['Page']['title'];?></h2>
	<div class="inner-content">
		<?php if($pass_value != 'contact-us'){ ?>
			<div class="errorlogin_msg" id="jsErrors">
				<?php echo $this->element('errors'); ?>
			</div>
		<?php }?>
		<div class="<?php echo $class;?>" style="text-align:justify">
		<?php if($pass_value == 'contact-us'){ ?>
			<?php echo $this->element('contact_form');?>
		<?php } ?>
		
		<?php	echo @$this->data['Page']['description'];?>
		
		</div>
		
	</div>
	<?php
	$groups_heading = array('ordering'=>'Ordering',
	'delivery'=>'Dispatch and Delivery',
	'returns'=>'Returns and Refunds',
	'marketplace'=>'Choiceful Marketplace',
	'offer'=>'Make me an Offer<sup>TM</sup>',
	'account'=>'Manage Your Account',
	'certificate'=>'Gift Certificates',
	'policy'=>'Choiceful.com Policies');
	if(!in_array($pass_value,$array_check)){ ?>
		<?php if(!empty($this->data['Page']['pagegroup'])) {?>
		<h3 class="h3-head-pad"><?php echo @$groups_heading[$this->data['Page']['pagegroup']];?></h3><?php }?>
		<?php if(!empty($list_all_links)){ ?>
			<ul class="help-links">
			<?php foreach($list_all_links as $list_index=>$list_link){ ?>
				<li><?php echo $html->link(strip_tags($list_link),"/pages/view/".$list_index,array('escape'=>false));?></li>
			<?php }
		}?>
	<?php }
	if($pass_value == 'contact-us'){ ?>
		<?php echo $this->element('contact_image');?>
	<?php } ?>
</div>
<!--mid Content Closed-->

<script>
	function subject(parent_id){
		var emailto = $("#ContactusSubjectEmailTo :selected").text();
		$("#UpdateTo").html(emailto);
		if(parent_id != ''){
		jQuery('#plsLoaderID').show();
		jQuery('#fancybox-overlay-header').show();
		jQuery.ajax({
			type: "POST",
			url: "<?php echo SITE_URL;?>/pages/contactform/"+parent_id,
			data:"parent_id="+parent_id,
			beforeSend: function(){ jQuery("#ajaxLoader").show(); },complete: function(){ jQuery("#ajaxLoader").hide(); },
			success: function(data){
				jQuery("#UpdateDiv").html(data);
				jQuery('#plsLoaderID').hide();
				jQuery('#fancybox-overlay-header').hide();
			},
			async: true
			});
		}
		
	}	
		
    	jQuery('#ShowHide').click(function() {
    		
		jQuery('#UpdateEmail').addClass('hide').removeClass('show');
		jQuery('#emailbox').addClass('show').removeClass('hide');
		
		});
    	jQuery('#UpdateDivId').click(function() {
    	
    		var userId= parseInt(jQuery('#UserId').val());
    		
    		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    		var userEmail= jQuery('#UserEmail').val();
		if(!emailReg.test(userEmail)) {
			$("#UserEmail").css("background-color","#FFE5E5");
			return true;
        	}else{
			
			jQuery.ajax({			
			type: "POST",
			url: "<?php echo SITE_URL;?>/pages/change_email/"+userId+"/"+userEmail,
			//data:"userId="+userId,
			beforeSend: function(){ jQuery("#ajaxLoader").show(); },complete: function(){ jQuery("#ajaxLoader").hide(); },
			success: function(data){
				jQuery("#UpdateEmail").html(data);
				return false;
			},
			async: true
			});
			$("#error_message").html('');
			jQuery('#UpdateEmail').addClass('show').removeClass('hide');
			jQuery('#emailbox').addClass('hide').removeClass('show');	
			jQuery('#showEmail').html(userEmail);
		}
		
	});
	
</script>
