<?php

$this->Html->addCrumb('Promotions', '/admin/certificates');
if(!empty($id)){
	$this->Html->addCrumb('Update Choiceful Favorite', 'javascript:void(0)');
}else{
	$this->Html->addCrumb('Add Choiceful Favorite', 'javascript:void(0)');
}

?>
<?php echo  $form->create('ChoicefulFavorite',array('action'=>'add','method'=>'POST','name'=>'frmChoicefulFavorite','id'=>'frmChoicefulFavorite','enctype'=>'multipart/form-data'));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td height="25" align="right"> 
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellspacing="1" cellpadding="3" > 
				<tr height="20px" colspan="2">
					<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr><!--
				<tr>
					<td colspan="2">
						<div class="errorlogin_msg" id="jsErrors">
							<?php //echo $this->element('errors'); ?>
					</div>
					</td>
				</tr>-->
				<tr>
					<td align="right"><span class="error_msg">*</span> Title: 
					</td><td>
						<?php echo $form->input('ChoicefulFavorite.title',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>80));?>
					</td>
				</tr>
				<tr>
					<td align="right"><span class="error_msg"></span> Url :
					</td><td>
						<?php echo $form->input('ChoicefulFavorite.favorite_url',array('size'=>'50','class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>80));?><?php echo $form->hidden('ChoicefulFavorite.id',array('size'=>'30','class'=>'textbox','label'=>false,'div'=>false,'maxlength'=>80));?>
					</td>
				</tr>
				<?php
			
			if(!empty($this->data['ChoicefulFavorite']['image'])){ 
			?>
			<tr>
				<td align="right" width="15%" valign="top"></td>
				<td>
				<?php
					# display current image preview 
					$imagePath = WWW_ROOT.PATH_CHOICEFUL_FAVORITES.$this->data['ChoicefulFavorite']['image'];
					if(file_exists($imagePath)){
						$arrImageDim = $format->custom_image_dimentions($imagePath, 150, 35);
					?>
					<fieldset style="border:0px;">
					 <legend>Current Image Preview</legend>
						<?php echo $html->image('/'.PATH_CHOICEFUL_FAVORITES.$this->data['ChoicefulFavorite']['image'], array('width'=>$arrImageDim['width'],'style'=>'border: 1px dashed #666666; padding:5px; background-color:#EFEBE7;')); ?>
					</fieldset>
				<?php } ?>
					
				</td>
			</tr>
			<?php  } ?>
				<tr>
					<td align="right"><span class="error_msg"></span> Upload Image : </td>
					<td  align="left">
						<?php echo $form->input('ChoicefulFavorite.photo',array('class'=>'textbox-m','label'=>false,'div'=>false,'type' => 'file'));?>
					</td>
				</tr>
				<tr>
					<td align="right"></td>
					<td  align="left">
						Note:* Please upload  image of (JPG,JPEG,GIF) type  of size 150 X 35 .
					</td>
				</tr>
				
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="center"></td>
					<td align="left">
						<?php 
						if(empty($this->data['ChoicefulFavorite']['id']))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";

						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/choiceful_favorites')"));?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php
if( !empty($id) ) { 
	echo $form->hidden('ChoicefulFavorite.image',array('class'=>'textbox','label'=>false,'div'=>false));
}
echo $form->end();
//echo $validation->rules('ChoicefulFavorite',array('formId'=>'frmChoicefulFavorite'));
?>