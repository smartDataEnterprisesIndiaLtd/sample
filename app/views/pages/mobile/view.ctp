<?php 
$pass_value = $this->params['pass'][0];
$array_check = array('help-topics','contact-us');
if(in_array($pass_value,$array_check)){
	$class = '';
}else{
	$class="content-list";
}

App::import('Model','Page');
$this->Page = & new Page();
App::import('Model','FaqCategory');
$this->FaqCategory = & new FaqCategory();
?>
<style>
ol li{
list-style-type: decimal;
margin-left: 20px;
padding-left: 0px;
background: none;
}
</style>
<!--Main Content Starts--->
<section class="maincont nopadd">
<!--Steps Starts--> 
	<ul class="steps <?php if($pagecode == 'help'){?>stepshelp<?php }?>">
	<li><a href="<?php echo SITE_URL;?>">Mobile Shopping</a></li>
	<?php if($pagecode != 'help'){?>
	<li><?php echo $html->link('Help',"/pages/view/help",array('class'=>'underline-link'));?></li>
	<li><a href="#" class="chcflplcs"><?php echo @$this->data['Page']['title'];?></a></li>
	<?php }else{?>
	<li><a href="#" class="chcflplcs">Help</a></li>
	<?php }?>
	</ul>
<!--Steps Starts-->
<!--Content Section Starts-->
	<section class="nwcustmrguide">
	<?php
	if ($session->check('Message.flash')){ ?>
		<div class="messageBlock">
			<?php echo $session->flash();?>
		</div>
	<?php } ?>
	
		<?php if($pass_value == 'contact-us'){ ?>
			<?php echo $this->element('mobile/contact_form');?>
		<?php } ?>
		
		<?php
			if($pagecode != 'help'){
				echo @$this->data['Page']['description'];
			}else{?>
			      <!--Content Section Starts-->
                   <section class="mobylspng">
                      <b>Welcome to Choiceful.com</b><br />
			Select a help topic for more information.
                           <!----->
                           <section class="helpmenu">
                             <h4 class="orng-clr"><strong>Ordering</strong></h4>
			     
                              <ul>
                                <?php
					$ordering_id_str = '';
					$pages_ordering = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'ordering' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
					if(!empty($pages_ordering)){
					foreach($pages_ordering as $order_page){ ?>
						<li><?php echo $html->link(strip_tags($order_page['Page']['title']),"/pages/view/".$order_page['Page']['pagecode'],array('escape'=>false));?></li>
						<?php if(empty($ordering_id_str))
							$ordering_id_str = $order_page['Page']['id'];
						else
							$ordering_id_str = $ordering_id_str.','.$order_page['Page']['id'];
					} }
				?>
                              </ul>
			      
                           </section>
                           <!----> 
                           <section class="helpmenu">
                             <h4 class="orng-clr"><strong>Dispatch and Delivery</strong></h4>
                              <ul>
                                <?php
					$delivery_id_str = '';
					$pages_delivery = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'delivery' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
					if(!empty($pages_delivery)){
					foreach($pages_delivery as $paged){ ?>
						<li><?php echo $html->link(strip_tags($paged['Page']['title']),"/pages/view/".$paged['Page']['pagecode'],array('escape'=>false));?></li>
						<?php if(empty($delivery_id_str))
							$delivery_id_str = $paged['Page']['id'];
						else
							$delivery_id_str = $delivery_id_str.','.$paged['Page']['id'];
					} }
				?>
                              </ul>
                           </section>
                           <!----> 
                           <section class="helpmenu"> 
                              <h4 class="orng-clr"><strong>Returns and Refunds</strong></h4>
                                 <ul>
					<?php
						$returns_id_str = '';
						$pages_return = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'returns'),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
						if(!empty($pages_return)){
						foreach($pages_return as $pager){ ?>
							<li><?php echo $html->link(strip_tags($pager['Page']['title']),"/pages/view/".$pager['Page']['pagecode'],array('escape'=>false));?></li>
							<?php if(empty($return_id_str))
								$return_id_str = $pager['Page']['id'];
							else
								$return_id_str = $return_id_str.','.$pager['Page']['id'];
						} }
					?>
                                </ul>
                          </section>
                           <!----> 
                           <section class="helpmenu"> 
                              <h4 class="orng-clr"><strong>Choiceful Marketplace</strong></h4>
                                 <ul>
					<?php
						$marketplace_id_str = '';
						$pages_marketplace = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'marketplace'),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
						if(!empty($pages_marketplace)){
						foreach($pages_marketplace as $pagemp){ ?>
							<?php if($pagemp['Page']['id']==94){?>
							<li><?php echo $html->link(strip_tags($pagemp['Page']['title']),array('controller'=>'sellers','action'=>'sign_up'),array('escape'=>false));?></li>
							<?php }else{?>
							<li><?php echo $html->link(strip_tags($pagemp['Page']['title']),"/pages/view/".$pagemp['Page']['pagecode'],array('escape'=>false));?></li>
							<?php }?>
							<?php if(empty($marketplace_id_str))
								$marketplace_id_str = $pagemp['Page']['id'];
							else
								$marketplace_id_str = $marketplace_id_str.','.$pagemp['Page']['id'];
						} }
					?>
				<li><?php echo $html->link('Marketplace Buying FAQs','/faqs/view/9',array('escape'=>false));?></li>
				<li><?php echo $html->link('Marketplace Selling FAQs','/faqs/view/10',array('escape'=>false));?></li>
                                </ul>
                          </section> 
                           <!----> 
                           <section class="helpmenu"> 
                              <h4 class="orng-clr"><strong>Make me an Offer<sup>TM</sup></strong></h4>
                                 <ul>
                                    <?php
					$offer_id_str = '';
					$pages_offer = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'offer' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
					if(!empty($pages_offer)){
					foreach($pages_offer as $pageoffer){ ?>
						<li><?php echo $html->link(strip_tags($pageoffer['Page']['title']),"/pages/view/".$pageoffer['Page']['pagecode'],array('escape'=>false));?></li>
						<?php if(empty($offer_id_str))
							$offer_id_str = $pageoffer['Page']['id'];
						else
							$offer_id_str = $offer_id_str.','.$pageoffer['Page']['id'];
					} }
				   ?>
                                </ul>
                          </section>
                           <!----> 
                           <section class="helpmenu"> 
                              <h4 class="orng-clr"><strong>Manage Your Account</strong></h4>
                                 <ul>
				<?php
                                   $account_id_str = '';
					$pages_account = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'account' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
					if(!empty($pages_account)){
					foreach($pages_account as $pageaccount){ ?>
						<li><?php echo $html->link(strip_tags($pageaccount['Page']['title']),"/pages/view/".$pageaccount['Page']['pagecode'],array('escape'=>false));?></li>
						<?php if(empty($account_id_str))
							$account_id_str = $pageaccount['Page']['id'];
						else
							$account_id_str = $account_id_str.','.$pageaccount['Page']['id'];
					} }?>
                                </ul>
                          </section>
                           <!----> 
                           <section class="helpmenu"> 
                              <h4 class="orng-clr"><strong>Gift Certificates</strong></h4>
                                <ul>
                                <?php
					$certificate_id_str = '';
					$pages_certificate = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'certificate' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
					if(!empty($pages_certificate)){
					foreach($pages_certificate as $pagecertificate){ ?>
						<li><?php echo $html->link(strip_tags($pagecertificate['Page']['title']),"/pages/view/".$pagecertificate['Page']['pagecode'],array('escape'=>false));?></li>
						<?php if(empty($certificate_id_str))
							$certificate_id_str = $pagecertificate['Page']['id'];
						else
							$certificate_id_str = $certificate_id_str.','.$pagecertificate['Page']['id'];
					} }
				?>
                                </ul>
                          </section>
                           <!---->
			   <?php 
				$allfaq_categories = $this->FaqCategory->find('list',array('conditions'=>array('FaqCategory.title != "Affiliates Q & A"'),'fields'=>array('id','title')));
				if(!empty($allfaq_categories)){
			   ?>
                           <section class="helpmenu"> 
                              <h4 class="orng-clr"><strong>FAQs</strong></h4>
                                 <ul>
					<?php foreach($allfaq_categories as $faq_cat_id =>$faq_cat){?>
						<li><?php echo $html->link($faq_cat,'/faqs/view/'.$faq_cat_id,array('escape'=>false));?></li>
					<?php }?>
                                </ul>
                          </section>
			   <!--FAQs Closed-->
			  <?php }?>
                           <!----> 
                           <section class="helpmenu"> 
                              <h4 class="orng-clr"><strong>Choiceful.com Policies</strong></h4>
                                 <ul>
                                    <?php
					$policy_id_str = '';
					$pages_policy = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'policy' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
					if(!empty($pages_policy)){
					foreach($pages_policy as $pagepolicy){ ?>
						<li><?php echo $html->link(strip_tags($pagepolicy['Page']['title']),"/pages/view/".$pagepolicy['Page']['pagecode'],array('escape'=>false));?></li>
						<?php if(empty($policy_id_str))
							$policy_id_str = $pagepolicy['Page']['id'];
						else
							$policy_id_str = $policy_id_str.','.$pagepolicy['Page']['id'];
					} }
				    ?>
                                </ul>
                          </section>
                           <!---->
                           <p class="toppadd">Get support by email (<b>account required</b>)</p>
                           <p><?php echo $html->link('<input type="button" value="Contact Us" class="lgtgreenbtn" />',array('controller'=>'pages','action'=>'view','contact-us'),array('escape'=>false));?></p>
                         
		<?php	}
		?>
		<!----> 
		<section class="helpmenu"> 
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
		<h4 class="orng-clr"><?php echo @$groups_heading[$this->data['Page']['pagegroup']];?></h4><?php }?>
		<?php if(!empty($list_all_links)){ ?>
			<ul class="help-links">
			<?php foreach($list_all_links as $list_index=>$list_link){ ?>
				<li><?php echo $html->link(strip_tags($list_link),"/pages/view/".$list_index,array('escape'=>false));?></li>
			<?php }
		}?>
	<?php }?>
	
		<!---->
		<?php if($pass_value != 'contact-us'){ ?>
			<a href="#" class="gototop">Go back to the top</a>
		<?php }?>
	</section>
</section>
<!--Main Content End--->


<script>
	function subject(parent_id){
		var emailto = $("#ContactusSubjectEmailTo :selected").text();
		$("#UpdateTo").html(emailto);
		if(parent_id != ''){
		// var ajaxLoader = "<img src='/Beta/img/loading.gif' alt='loading...' />";
		jQuery.ajax({
			type: "POST",
			url: "<?php echo SITE_URL;?>pages/contactform/"+parent_id,
			data:"parent_id="+parent_id,
			beforeSend: function(){ jQuery("#plsLoaderID").show(); },complete: function(){ jQuery("#plsLoaderID").hide(); },
			success: function(data){
				jQuery("#UpdateDiv").html(data);
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
			//url: "<?php //echo SITE_URL;?>/pages/change_email/"+userId+"/"+userEmail,
			//data:"userId="+userId,
			beforeSend: function(){ jQuery("#plsLoaderID").show(); },complete: function(){ jQuery("#plsLoaderID").hide(); },
// 			success: function(data){
// 				jQuery("#UpdateEmail").html(data);
// 				return false;
// 			},
// 			async: true
			});
			$("#error_message").html('');
			jQuery('#UpdateEmail').addClass('show').removeClass('hide');
			jQuery('#emailbox').addClass('hide').removeClass('show');	
			jQuery('#showEmail').html(userEmail);
		}
		
	});
	
</script>
