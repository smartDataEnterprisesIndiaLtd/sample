<?php 
echo $form->create('Message',array('action'=>'get_message','method'=>'GET','name'=>'frmGetMessage','id'=>'frmGetMessage'));
?>
<div class="left-content-widget">
<!--Inbox Start-->
	<div class="row" id="inbox" name="inbox">
		<?php echo $this->element('message/inbox');?>
	</div>
	<!--Inbox Closed-->
</div>
<?php 	echo $form->end();?>