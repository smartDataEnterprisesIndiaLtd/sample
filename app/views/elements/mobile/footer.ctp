<?php 
$user_session = $this->Session->read('User');
?>
<!--Footer Start-->
             <footer id="foo" class="margin-top">
                <section class="signin">Already a customer?
                <?php 
		if(!empty($user_session)){?>
		<?php echo $html->link('Logout',array('controller'=>'users','action'=>'logout'),null);?>
		<?php }else{?>
		<?php echo $html->link('Sign in',array('controller'=>'users','action'=>'sign-in'),array('escape'=>false));?>
		 <?php }?>
                </section>
		<section class="termsncons"><?php echo $html->link('Contact Customer Care',array('controller'=>'pages','action'=>'view','contact-us'),array('escape'=>false));?> | <?php echo $html->link('Terms &amp; Conditions',array('controller'=>'pages','action'=>'view','terms-and-conditions'),array('escape'=>false));?> | <?php echo $html->link('Privacy Policy',array('controller'=>'pages','action'=>'view','privacy-policy'),array('escape'=>false));?>
		</section>
		<section>Current location: <?php echo $html->link('United Kingdom',array('controller'=>'homes','action'=>'international-websites'),null);?></section>
		<section>&copy;<?php echo date('Y');?> Choiceful.com. All Rights Reserved.</section>
             </footer>
<!--Footer Closed-->