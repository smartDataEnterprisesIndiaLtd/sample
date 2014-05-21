<?php //$javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
<?php echo  $form->create('special_products',array('action'=>'addproduct/'.$special_department_id,'method'=>'POST','name'=>'frmSpecialProduct','id'=>'frmSpecialProduct'));?>

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
				<td align="right" width="20%"><span class="error_msg">*</span> Product Quick Code: 
				</td><td>
					<?php echo $form->input('SpecialProduct.quick_code',array('size'=>'20','class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?>
				</td>
			</tr>
			
			<tr>
				<td align="center"></td>
				<td align="left">
					<?php 
					echo $form->button("Submit",array('type'=>'submit','class'=>'btn_53','div'=>false));
					echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/special_products/viewdepartment')"));?>
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
echo $form->hidden("SpecialProduct.special_department_id",array("value"=>$special_department_id));
//echo $form->hidden("SpecialProduct.id",array("value"=>$id));
echo $form->end();

//echo $validation->rules('SpecialProduct',array('formId'=>'frmSpecialProduct'));
?>