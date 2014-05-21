<?php 
if ($session->check('Message.flash')){ ?>
	<div id="nameContainer"><div class="messageBlock" style="margin:0px"><?php echo $session->flash();?></div></div>
	
<?php }
?><!--<li>
<label style="width:110px">Name:</label>
<div class="form-field-widget">
	<?php //echo $form->input('User.firstname',array('size'=>'30','class'=>'form-textfield','maxlength'=>'30','label'=>false,'div'=>false,'error'=>false,'readonly'=>'readonly'));?>
	
		<?php //echo $ajax->submit('Edit',$options);?>
		<?php //echo $ajax->link($html->image("edit-btn-blk.gif" ,array('alt'=>"Edit" ,'style'=>'margin-top:1px;')),'', array('escape'=>false,'update' => 'name', 'url' => '/users/update_name/','class'=>'',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')"), null,false);?>
	
</div>
</li>-->

<ul>
	<li>
		<label style="width:110px;padding-top:5px">Name:</label>
		<div class="form-field-widget">
			<?php echo $this->data['User']['firstname']; ?>
			<?php echo $ajax->link($html->image("edit-btn-blk.gif" ,array('alt'=>"Edit" ,'style'=>'margin-top:1px;')),'', array('escape'=>false,'update' => 'name', 'url' => '/users/update_name/','class'=>'',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading('name')"), null,false);?>
		</div>
	</li>
</ul>

