<?php //echo $form->create('Product',array('action'=>'add_searchtags','method'=>'POST','name'=>'frmProduct','id'=>'frmProduct'));
	if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock">
			<?php echo $session->flash();?>
		</div>
	<?php } ?>
	<strong>Add a Search tag for this product:</strong>
	<?php echo $form->input('Searchtag.searchtag'.$review_pro_id,array('class'=>'form-textfield bigger-input','maxlength'=>'500','label'=>false,'div'=>false));?> <span class="smalr-fnt gray">Separate multiple tags with commas.</span> <?php echo $html->link('Save Changes','javascript::void(0)',array('class'=>"underline-link",'onClick'=>'save_searchtags('.$review_pro_id.','.$pro_id.')'));?>
<?php //echo $form->end();?>
<script type="text/javascript">
jQuery(document).ready(function() {
	if(jQuery('#flashMessage').hasClass('flashError')){
		jQuery('#SearchtagSearchtag<?php echo $review_pro_id;?>').removeClass('form-textfield bigger-input').addClass('form-textfield bigger-input error_message_box');
	}else{
		jQuery('#SearchtagSearchtag<?php echo $review_pro_id;?>').removeClass('form-textfield bigger-input').addClass('form-textfield bigger-input');
	}
});
</script>