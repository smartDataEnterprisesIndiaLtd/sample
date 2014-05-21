<?php //$javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
   
</style>
<?php echo  $form->create('Category',array('action'=>'add/'.$department_id.'/'.$parent_id.'/','method'=>'POST','name'=>'frmCategory','id'=>'frmCategory','enctype'=>'multipart/form-data'));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
		<td class="adminGridHeading heading" width="60%"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			
		<?php echo $html->link('Back','/admin/categories/index/'.$department_id.'/'.$parent_id)?>&nbsp;
		</td>
	</tr>
<tr>
	<td colspan="2">
		<table width="100%" border="0" cellspacing="2" cellpadding="2" class="adminBox"> 
			<tr height="20px" colspan="2">
				<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
			</tr>
			<!--<tr>
				<td colspan="2">
					<div class="errorlogin_msg" id="jsErrors">
						<?php //echo $this->element('errors'); ?>
				</div>
				</td>
			</tr>-->
			<tr>
				<td align="right"><span class="error_msg">*</span> Category Name:
				</td>
				
				<td>		
					<table  border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
					<td align="left" width="75%" id="brand_selection_box">
					
					<?php echo $form->input('Category.cat_name',array('size'=>'30','maxlength'=>40,'class'=>'textbox-m','label'=>false,'div'=>false));?>
					</td>
					<?php if(base64_decode($department_id) == 8){?>
					<td align="left" width="3%">
					<?php $checkbox = '';
						if($this->data['Category']['gd_category']=='1'){
							$checkbox = true;
						}else{
							$checkbox = false;
						}
					
					?>
					<?php echo $form->checkbox('Category.gd_category',array("checked"=>$checkbox,'style'=>array('border:0'))); ?>
					</td>
					<td>Goodwinsdirect category</td>
					<?php }?>
					</table>
				</td>

			</tr>
			<?php
			if(!empty($this->data['Category']['cat_image'])){?>
			<tr>
				<td></td>
				<td>
					<?php
					# display current image preview 
					$imagePath = WWW_ROOT.PATH_CATEGORY.$this->data['Category']['cat_image'];
					if(file_exists($imagePath)){
						$arrImageDim = $format->custom_image_dimentions($imagePath, 300, 200);
					?>
					<fieldset style="border:0px;">
					 <legend>Current Image Preview</legend>
						<?php echo $html->image('/'.PATH_CATEGORY.$this->data['Category']['cat_image'], array('width'=>$arrImageDim['width'],'style'=>'border: 1px dashed #666666; padding:5px; background-color:#EFEBE7;')); ?>
					</fieldset>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
			
			<tr>
				<td align="right">Upload Image:</td>
				<td>
				<?php
				echo $form->input('Category.photo',array('class'=>'textbox-m','label'=>false,'div'=>false,'error'=>false,'type' => 'file'));?>
				</td>
			</tr>
			<tr>
				<td align="right">Status:</td>
				<td>
				<?php
				echo $form->select('Category.status',array('1'=>'Active','0'=>'Inactive'), null, array('class'=> 'textbox', 'div'=>false,'label'=>false), 'Select Status');?>
				</td>
			</tr>
			<tr>
				<td align="right"> <span class="error_msg"></span> Meta Title:</td>
				<td align="left">
					<?php echo $form->input('Category.meta_title',array('cols'=>'40','rows'=>'1','class'=>'textbox-l','label'=>false,'div'=>false));?>
				</td>
			</tr>
			<tr>
				<td align="right"> <span class="error_msg"></span> Meta Keywords:</td>
				<td align="left">
					<?php echo $form->input('Category.meta_keywords',array('cols'=>'50','rows'=>'4','class'=>'textbox-l','label'=>false,'div'=>false));?>
				</td>
			</tr>
				<tr>
				<td align="right"> <span class="error_msg"></span> Meta Description:</td>
				<td align="left">
					<?php echo $form->input('Category.meta_description',array('cols'=>'50','rows'=>'4','class'=>'textbox-l','label'=>false,'div'=>false));?>
				</td>
			</tr>
			<tr>
				<td align="right">Category Rank:
				</td><td>
					<?php echo $form->input('Category.cat_rank',array('size'=>'10','maxlength'=>10,'class'=>'textbox-s','label'=>false,'div'=>false));?>
					
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="center"></td>
				<td align="left">
					<?php 
					if(empty($this->data['Category']['id']))
						$submit_buttton="Add";
					else
						$submit_buttton="Update";

					echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
					<?php //echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/categories/index/'.$cat_id)"));?>
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>

<?php
if( !empty($id) ){ 
echo $form->hidden('Category.cat_image',array('class'=>'textbox','label'=>false,'div'=>false));
}
echo $form->end();
//echo $validation->rules('Category',array('formId'=>'frmCategory'));
?>