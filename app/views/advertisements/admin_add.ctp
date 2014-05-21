<?php

$this->Html->addCrumb('Promotions', '/admin/certificates');
if(!empty($id)){
	$this->Html->addCrumb('Update Advertisement', 'javascript:void(0)');
}else{
	$this->Html->addCrumb('Add Advertisement', 'javascript:void(0)');
}


?>
<?php echo  $form->create('Advertisement',array('action'=>'add','method'=>'POST','name'=>'frmAdvertisement','id'=>'frmAdvertisement','enctype'=>'multipart/form-data'));?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" class="adminBox">
<tr class="adminBoxHeading reportListingHeading">
	<td class="adminGridHeading heading" ><?php echo $listTitle; ?></td>
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
				<td align="right" width="15%"><span class="error_msg">*</span> Name: 
				</td><td>
					<?php echo $form->input('Advertisement.bannerlabel',array('size'=>'60','class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>80));?>
				</td>
			</tr>
			<tr>
				<td align="right" width="15%"><span class="error_msg">*</span> Url : 
				</td><td>
					<?php echo $form->input('Advertisement.bannerurl',array('size'=>'60','class'=>'textbox-l','label'=>false,'div'=>false,'maxlength'=>80));?>
					<?php echo $form->hidden('Advertisement.id',array('class'=>'textbox','label'=>false,'div'=>false));?>
				</td>
			</tr>
			<?php
			//pr($this->data);
			if(!empty($this->data['Advertisement']['banner_image'])){ 
			?>
			<tr>
				<td align="right" width="15%" valign="top"></td>
				<td>
				<?php
					# display current image preview 
					$imagePath = WWW_ROOT.PATH_ADVERTISEMENTS.$this->data['Advertisement']['banner_image'];
					if(file_exists($imagePath)){
						$arrImageDim = $format->custom_image_dimentions($imagePath, 350, 350);
					?>
					<fieldset style="border:0px;">
					 <legend>Current Image Preview</legend>
						<?php echo $html->image('/'.PATH_ADVERTISEMENTS.$this->data['Advertisement']['banner_image'], array('width'=>$arrImageDim['width'],'style'=>'border: 1px dashed #666666; padding:5px; background-color:#EFEBE7;')); ?>
					</fieldset>
				<?php } ?>
					
				</td>
			</tr>
			<?php  } ?>
			<tr>
				<td align="right" width="15%"> Upload Image : 
				</td><td>
				<?php	 echo $form->input('Advertisement.photo',array('class'=>'textbox','label'=>false,'div'=>false,'type' => 'file'));?>
				</td>
			</tr>
			<tr>
				<td >&nbsp;</td>
				<td >Note:&nbsp;Best Image Size for Right Side Banner is 168X123.<br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Best Image Size for Centeral Banner is 889X140.
				</td>
			</tr>
			<tr>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
			</tr>
			<tr>
				<td align="center"></td>
				<td align="left">
					<?php 
					if(empty($this->data['Advertisement']['id']))
						$submit_buttton="Add";
					else
						$submit_buttton="Update";

					echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
					<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/advertisements')"));?>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
</table>

<?php
if( !empty($id) ) { 
echo $form->hidden('Advertisement.banner_image',array('class'=>'textbox','label'=>false,'div'=>false));
}
echo $form->end();
//echo $validation->rules('Advertisement',array('formId'=>'frmAdvertisement'));
?>