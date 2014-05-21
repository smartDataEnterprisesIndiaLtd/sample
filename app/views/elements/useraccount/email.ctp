<?php 
if ($session->check('Message.flash')){ ?>
	<div id="emailContainer"><div class="messageBlock" style="margin:0px"><?php echo $session->flash();?></div></div>
<?php }
?>

<ul>
	<li>
		<label style="width:110px;padding-top:5px">Email Address:</label>
		<div class="form-field-widget">
			<?php echo $this->data['User']['email']; ?>
			<?php echo $ajax->link($html->image("edit-btn-blk.gif" ,array('alt'=>"Edit" ,'style'=>'margin-top:1px;')),'', array('escape'=>false,'update' => 'email', 'url' => '/users/update_email/','class'=>'',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading('email')"), null,false);?>
		</div>
	</li>
</ul>
