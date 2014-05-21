<?php

$this->Html->addCrumb('Website Pages', ' ');
if(!empty($id)){
$this->Html->addCrumb('Update question', 'javascript:void(0)');
}else{
$this->Html->addCrumb('Add question', 'javascript:void(0)');	
}
//$javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
<?php  echo $form->create('Faq',array('action'=>'add/'.$id,'method'=>'POST','name'=>'frmFaqs','id'=>'frmFaqs'));
	echo $javascript->link('fckeditor');
?>	
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
						<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
						<td class="adminGridHeading"></td>
			       </tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="adminBox">
				<!--<tr>
					<td colspan="2">
						<div class="errorlogin_msg">
							<?php //echo $this->element('errors'); ?>
						</div> 
					</td>
				</tr>-->
				
				<tr height="20px">
					<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<!--<tr>
				<td colspan="2">
					<div id="jsErrors"></div>
				</td>
				</tr>-->
				<tr>
					<td valign="top" align="right"><span class="error_msg">*</span>Question : </td>
					<td>
						<?php echo $form->textarea("Faq.question",array("label"=>false,"div"=>false, 'class'=>'textbox-m','size'=>50, 'cols'=>80)); ?>
						<?php echo $form->error('Faq.question'); ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right"><span class="error_msg">*</span>Type : </td>
					<td>
						<?php echo $form->select('Faq.faq_category_id',$categories,null,array('type'=>'select','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1),'Select question type'); ?>
						<?php echo $form->error('Faq.faq_category_id'); ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">Answer : </td>
					<td   align="left">
						<?php 
						echo $form->textarea("Faq.answer",array('class'=>'textbox-m',"label"=>false,"div"=>false,"id"=>"FaqAnswer"));
						echo $fck->load('Faq/answer','Default'); ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="center"></td>
<td align="left">
						<?php 
						if(empty($this->data['Faq']['id']))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";

						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/faqs/')"));?>
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
echo $form->hidden("Faq.id",array("value"=>$id));
echo $form->end();
//echo $validation->rules('Faq',array('formId'=>'frmFaqs'));
?>