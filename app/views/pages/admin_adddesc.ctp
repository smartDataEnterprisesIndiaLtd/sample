<?php
$this->Html->addCrumb('Website Pages', '/admin/faqs');
if(!empty($id)){
$this->Html->addCrumb('Edit Footer Description', 'javascript:void(0)');
}else{
$this->Html->addCrumb('Add Footer Description', 'javascript:void(0)');	
}


//$javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
<?php  echo $form->create('Pages',array('action'=>'adddesc/'.$id,'method'=>'POST','name'=>'frmFooterDescriptions','id'=>'frmFooterDescriptions','enctype' => 'multipart/form-data'));
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
				
				
				<tr height="20px">
					<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<!--<tr>
				<td colspan="2">
					<div id="jsErrors"></div>
				</td>
				</tr>-->
                                
                                <tr>
					<td valign="top" align="right" width="125">Title : </td>
				
                                        <td>
						<?php $selectedPage = isset($this->data['FooterDescription']['page_id'])?$this->data['FooterDescription']['page_id']:'';?>
						<?php
						
						if(!empty($id)){
						echo $form->input('',array('type'=>'text','style'=>'border:none !important;','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1,'value'=>$page_name[$selectedPage],'readonly'=>true ));
						echo $form->hidden('FooterDescription.page_id',array('type'=>'text')); 
						}else{?>
						
						<?php echo $form->select('FooterDescription.page_id',$page_name,$selectedPage,array('type'=>'select', 'style'=>'margin:0px; padding:0px;','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1 ),'Select Page'); ?>
						<?php echo $form->error('FooterDescription.page_id'); ?>
						<?php } ?>
					</td>
                                       
				</tr>
				
                                <tr>
					<td valign="top" align="right"><span class="error_msg">*</span> Footer Description : </td>
					<td   align="left">
						<?php
                                                echo $form->textarea('FooterDescription.desc',array('rows'=>'15','cols'=>'54')); 
							echo $fck->load('FooterDescription/desc'); 
							echo $form->error('FooterDescription.desc',array('class'=>'error_msg'));
						
                                               // echo $form->textarea("FooterDescription.desc",array('class'=>'textbox-m',"label"=>false,"div"=>false,"id"=>"FooterDescriptionAnswer"));
						?>
					</td>
				</tr>
                               
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="center"></td>
                                        <td align="left">
						<?php 
						if(empty($this->data['FooterDescription']['id']))
							$submit_buttton="Add";
						else
							$submit_buttton="Save";

						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/pages/footerdes')"));?>
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
echo $form->hidden("FooterDescription.id",array("value"=>$id));
echo $form->end();
//echo $validation->rules('FooterDescription',array('formId'=>'frmFooterDescriptions'));
?>
