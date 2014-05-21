<?php //$javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
<?php
	echo $form->create('Affiliate',array('action'=>'edit/'.$id,'method'=>'POST','name'=>'frmAffiliate','id'=>'frmAffiliate'));
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
								<div class="errorlogin_msg" id="jsErrors">
									<?php //echo $this->element('errors'); ?>
								</div> 
							</td>
						</tr>-->
						<tr>
							<td align="right" ><span class="error_msg">*</span> Title : </td>
							<td >
								<?php echo $form->input('Affiliate.title',array('size'=>'40','maxlenght'=>'50','class'=>'textbox-m','label'=>false,'div'=>false));?>
							</td>
						</tr>
						<tr>
							<td align="right" valign="top" >Description : </td>
							<td><?php echo $this->data['Affiliate']['content']; ?>
								<?php echo $form->textarea('Affiliate.content',array('rows'=>'25','cols'=>'54'));
								echo $fck->load('Affiliate/content');?></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<?php
								echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
								<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/affiliates/')"));?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
		</table>
	
<?php
echo $form->hidden("Affiliate.id",array("value"=>$id));
echo $form->end();
//echo $validation->rules('Affiliate',array('formId'=>'frmAffiliate'));
?>