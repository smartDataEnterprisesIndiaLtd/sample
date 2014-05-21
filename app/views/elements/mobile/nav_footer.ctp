<?php $user_session = $this->Session->read('User');?>
		<li>
		<?php echo $html->link("Gift Certificates","/certificates/buy-choiceful-gift-certificates-the-gift-of-choice",array('escape'=>false,'class'=>'yellowcatlist'));?>
		</li>
		<?php 
		if(!empty($user_session)){?>
		<li class="blu-color">
		<?php echo $html->link('Account Settings',array('controller'=>'users','action'=>'my_account'),array('escape'=>false,'class'=>'yellowcatlist'));?>
		</li>
		<?php }else{?>
		<li><?php echo $html->link('Sign In',array('controller'=>'orders','action'=>'view_open_orders'),array('escape'=>false,'class'=>'yellowcatlist')); ?></li>
		<?php }?>
		<li>
			<?php echo $html->link('Delivery',array('controller'=>'pages','action'=>'view/delivery-rates'),array('escape'=>false,'class'=>'yellowcatlist'));?>
		</li>
		<li><?php echo $html->link("Mobile Marketplace","/marketplaces/manage_listing",array('escape'=>false,'class'=>'yellowcatlist'));?></li>
		
		<li class="brdrbttm"><?php echo $html->link("Choiceful.com Full Site",SITE_URL.'?fullsite=go',array('escape'=>false,'class'=>'yellowcatlist'));?></li>