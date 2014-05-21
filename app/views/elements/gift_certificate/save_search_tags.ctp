<?php echo $form->create('Product',array('action'=>'add_certificate_searchtags','method'=>'POST','name'=>'frmProduct','id'=>'frmProduct'));
	if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock">
			<?php echo $session->flash();?>
		</div>
	<?php } ?>
	<strong>Add a Search tag for this:</strong>
	<?php echo $form->input('Searchtag.certificatesearchtag',array('class'=>'form-textfield bigger-input','label'=>false,'div'=>false));?> <span class="smalr-fnt gray">Separate multiple tags with commas.</span> <?php echo $html->link('Save Changes','javascript::void(0)',array('class'=>"underline-link",'onClick'=>'save_certtificate_searchtags()'));?>
<?php echo $form->end();?>