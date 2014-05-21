<?php
$this->Html->addCrumb('Departments / Categories Management', '/admin/departments/home');
$this->Html->addCrumb('Update Department Details', 'javascript:void(0)');

//$javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
<?php echo  $form->create('Department',array('action'=>'add','method'=>'POST','name'=>'frmDepartment','id'=>'frmDepartment'));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
	<tr>
		<td valign="top">
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr class="adminBoxHeading reportListingHeading">
					<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
					<td height="25" align="right"> 
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%" border="0" cellspacing="2" cellpadding="2"> 
							<tr height="20px" colspan="2">
								<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
							</tr>
							<!--<tr>
								<td colspan="2">
									<div class="errorlogin_msg" id="jsErrors">
										<?php // echo $this->element('errors'); ?>
								</div>
								</td>
							</tr>-->
							
							<tr>
								<td align="right" width="20%"> <span class="error_msg">*</span> Name:</td>
								<td align="left">
									<?php echo $form->input('Department.name',array('size'=>'20','class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?>
									
								</td>
							</tr>
							<tr>
								<td></td>
								<td align="left">(Department name should not be more than 20 characters.)&nbsp;</td>
							</tr>
							<tr>
								<td align="right"> <span class="error_msg"></span> Meta Title:</td>
								<td align="left">
									<?php echo $form->input('Department.meta_title',array('cols'=>'40','rows'=>'1','class'=>'textbox-l','label'=>false,'div'=>false));?>
								</td>
							</tr>
							<tr>
								<td align="right"> <span class="error_msg"></span> Meta Keywords:</td>
								<td align="left">
									<?php echo $form->input('Department.meta_keywords',array('cols'=>'50','rows'=>'4','class'=>'textbox-l','label'=>false,'div'=>false));?>
								</td>
							</tr>
							<tr>
								<td align="right"> <span class="error_msg"></span> Meta Description:</td>
								<td align="left">
									<?php echo $form->input('Department.meta_description',array('cols'=>'50','rows'=>'4','class'=>'textbox-l','label'=>false,'div'=>false));?>
								</td>
							</tr>
							<tr>
								<td align="center"></td>
								<td align="left">
									<?php 
									if(empty($this->data['Department']['id']))
										$submit_buttton="Add";
									else
										$submit_buttton="Update";
			
									echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
									<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/departments')"));?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
echo $form->end();
//echo $validation->rules('Department',array('formId'=>'frmDepartment'));
?>