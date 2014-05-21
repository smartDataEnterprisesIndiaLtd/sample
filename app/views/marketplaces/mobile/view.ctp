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

		
		<?php
			if($pagecode != 'help'){
				echo @$this->data['Page']['description'];
			}
		?>
			      <!--Content Section Starts-->

		<!----> 
		<section class="helpmenu"> 
		<!---->
		<?php if($pass_value != 'contact-us'){ ?>
			<a href="#" class="gototop">Go back to the top</a>
		<?php }?>
	</section>
</section>
<!--Main Content End--->
