<?php //$javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
<?php
$this->Html->addCrumb('Product Management', ' ');
if(!empty($id)){
$this->Html->addCrumb('Edit', 'javascript:void(0)');
}else{
$this->Html->addCrumb('Add', 'javascript:void(0)');
}
echo  $form->create('Brand',array('action'=>'add/'.$id,'method'=>'POST','name'=>'frmBrand','id'=>'frmBrand'));?>

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
				<td align="right" width="15%"><span class="error_msg">*</span>Name: 
				</td>
				<td>
					<table  border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
					<td align="left" width="75%" id="brand_selection_box">
					
					<?php echo $form->input('Brand.name',array('size'=>'20','class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>40));?>
					</td>
					<td align="left" width="3%">
					<?php $checkbox = '';
						if($this->data['Brand']['gd_brand']=='1'){
							$checkbox = true;
						}else{
							$checkbox = false;
						}
					
					?>
					<?php echo $form->checkbox('Brand.gd_brand',array("checked"=>$checkbox,'style'=>array('border:0'))); ?>
					</td>
					<td>Goodwinsdirect Brand</td>
					</table>
				</td>
			</tr>
			
			<tr>
				<td align="center"></td>
				<td align="left">
					<?php 
					echo $form->button("Submit",array('type'=>'submit','class'=>'btn_53','div'=>false));
					echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/brands')"));?>
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
echo $form->hidden("Brand.id",array("value"=>$id));
echo $form->end();
//echo $validation->rules('Brand',array('formId'=>'frmBrand'));
?>