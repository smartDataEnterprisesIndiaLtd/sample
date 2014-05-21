<?php echo $javascript->link(array('formvalidation'), false); ?>

<?php echo $form->create('',array('action'=>'addurl','method'=>'POST','name'=>'frmChangeurl','id'=>'frmChangeurl'));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td valign="top">
			<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0">
				 <tr class="adminBoxHeading reportListingHeading">
						<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
						<td class="adminGridHeading" align="right">
						</td>
			       </tr>
				<tr>
					<td colspan="2">
						<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
							
							<tr height="20px">
									<td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td>
							</tr>
							<tr>
								<td colspan="2">
									<div id="jsErrors"></div>
								</td>
							</tr>
							<tr>
								<td valign="top" align="right" width="20%"><span class="error_msg">* </span>Current Url : </td>
								<td>
									<?php  echo $form->input('ChangeUrl.current_url',array('size'=>'50','maxlength'=>'200','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
							</tr>
							<tr>
								<td valign="top" align="right"><span class="error_msg">* </span>Change Url : </td>
								<td>
									<?php echo $form->input('ChangeUrl.change_url',array('size'=>'50','maxlength'=>'200','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
								
							</tr>	
							<tr>
								<td align="center">&nbsp;</td>
								<td align="left">
								<?php if(!empty($this->data['ChangeUrl']['id'])) {
									echo $form->button('Update',array('type'=>'submit','class'=>'btn_53','div'=>false));
								} else {
									echo $form->button('Add',array('type'=>'submit','class'=>'btn_53','div'=>false));
								}?>
								</td><td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php 
echo $form->input('ChangeUrl.id');
echo $form->end();
?>