<?php
$this->Html->addCrumb('Website Pages', '/admin/faqs');
if(!empty($id)){
$this->Html->addCrumb('Update content page', 'javascript:void(0)');
}else{
$this->Html->addCrumb('Add content page', 'javascript:void(0)');	
}

//$javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
<?php  echo $form->create('Page',array('action'=>'add/'.$id,'method'=>'POST','name'=>'frmPages','id'=>'frmPages'));
       echo $javascript->link('fckeditor');
?>	
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td height="25" align="right"> 
		</td>
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
				</tr><!--
				<tr>
				<td colspan="2">
					<div id="jsErrors"></div>
				</td>
				</tr>-->
				<tr>
					<td align="right" width="15%"><span class="error_msg">*</span> Title : </td>
					<td>
						<?php //echo $form->input('Page.title',array('size'=>'50','class'=>'textbox-m','label'=>false,'div'=>false));?>
						<?php 
							echo $form->textarea('Page.title',array('rows'=>'15','cols'=>'54')); 
							echo $fck->load('Page/title'); 
							echo $form->error('Page.title',array('class'=>'error_msg'));
						?>
					</td>
				</tr>
				<tr>
					<td align="right" width="15%"><span class="error_msg">*</span> Page code : </td>
					<td><?php echo $form->input('Page.pagecode',array('class'=>'textbox-m','label'=>false,'div'=>false));?>
					</td>
				</tr>
				<tr>
					<td align="right" width="15%"><span class="error_msg"></span> Page group: </td>
					<td><?php //echo $form->input('Page.pagegroup',array('size'=>'50','class'=>'textbox-m','label'=>false,'div'=>false));?>
					<?php echo $form->select('Page.pagegroup',array('account'=>'account','ordering'=>'ordering','delivery'=>'delivery','returns'=>'returns','marketplace'=>'marketplace','offer'=>'offer','certificate'=>'certificate','policy'=>'policy'),null,array('class'=>'textbox-s', 'type'=>'select'),'-- Select Page Group--'); ?>
					<?php echo $form->error('Page.pagegroup'); ?>
								</td>
				</tr>
				<tr>
					<td align="right" width="15%">Description : </td>
					<td>
				</tr>
				<tr>
					<td></td>
					<td align="left">
					<!--Fckeditor content starts from here-->
						<?php 
							echo $form->textarea('Page.description',array('rows'=>'15','cols'=>'54')); 
							echo $fck->load('Page/description'); 
							echo $form->error('Page.description',array('class'=>'error_msg'));
						?>
					</td>
				</tr>
				<tr>
					<td align="right" width="15" valign="top">Meta title : </td>
					<td align="left"><?php echo $form->input('Page.meta_title',array('class'=>'textbox','cols'=>'50','rows'=>'4','label'=>false,'div'=>false));?></td>
				</tr>
				<tr>
					<td align="right" width="15%" valign="top">Meta description : </td>
					<td align="left"><?php echo $form->input('Page.meta_description',array('class'=>'textbox','cols'=>'50','rows'=>'4','label'=>false,'div'=>false));?></td>
				</tr>
				<tr>
					<td align="right" width="15%" valign="top">Meta keyword : </td>
					<td align="left"><?php echo $form->input('Page.meta_keyword',array('class'=>'textbox','cols'=>'50','rows'=>'4','label'=>false,'div'=>false));?></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="center"></td>
<td align="left">
						<?php 
						if(empty($this->data['Page']['id']))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";

						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/pages')"));?>
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
echo $form->end();
//echo $validation->rules('Page',array('formId'=>'frmPages'));
?>
