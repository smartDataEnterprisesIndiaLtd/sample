<?php
//pr($ArrAllDepartments);
echo  $form->create('special_products',array('action'=>'editdepartment/'.$id,'method'=>'POST','name'=>'frmSpecialProduct','id'=>'frmSpecialProduct'));?>

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
				<td align="right" width="20%"><span class="error_msg">*</span> Department: 
				</td><td>
					<?php echo $form->select('SpecialDepartment.department_id',$ArrAllDepartments , null, array('size'=>'1','class'=>'textbox-m','label'=>false,'div'=>false), 'Select Product Type');
					echo $form->error('SpecialDepartment.department_id'); ?>
				</td>
			</tr>
			
			<tr>
				<td align="center"></td>
				<td align="left">
					<?php 
					echo $form->button("Submit",array('type'=>'submit','class'=>'btn_53','div'=>false));
					echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/SpecialProducts')"));?>
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
echo $form->hidden("SpecialDepartment.id",array("value"=>$id));
echo $form->end();
//echo $validation->rules('SpecialProduct',array('formId'=>'frmSpecialProduct'));
?>