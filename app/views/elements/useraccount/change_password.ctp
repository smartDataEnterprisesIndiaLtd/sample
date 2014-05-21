<?php 
if ($session->check('Message.flash')){ ?>
	<div id="passContainer"><div class="messageBlock" style="margin:0px"><?php echo $session->flash();?></div></div>
<?php }
?>
<ul>
	<li id="passwordDisplay" style="">
		<label style="width:110px">Password :</label>
		<div class="form-field-widget">
			**********
			
				<?php echo $ajax->link($html->image("edit-btn-blk.gif" ,array('alt'=>"Edit" ,'style'=>'margin-top:1px;')),'', array('escape'=>false,'update' => 'changepassword', 'url' => '/users/update_password/','class'=>'',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading('password')"), null,false);?>
			
		</div>
	</li>
</ul>