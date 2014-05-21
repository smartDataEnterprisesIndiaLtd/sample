<?php ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td valign="top">
			<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0">
				<tr class="adminBoxHeading reportListingHeading">
						<td class="adminGridHeading heading"><?php echo $title_for_layout; ?> for <?php echo ucwords($adminuser['Adminuser']['firstname'])." ".ucwords($adminuser['Adminuser']['lastname']);?></td>
						<td class="adminGridHeading"></td>
			       </tr>
				
				<tr>
					<td colspan="2">
						<table class="adminBox" border="0" cellpadding="2" cellspacing="2"  width="100%">
							<tr height="2">
								<td width="1%" ></td>
							</tr>
							<tr>
								<td >
									<div class="errorlogin_msg" id="jsErrors">
										<?php echo $this->element('errors'); ?>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php echo $this->element("admin/admin_access");?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php 
echo $form->input('Adminuser.id');
echo $form->end();
echo $validation->rules(array('Adminuser'),array('formId'=>'frmAdminuser'));
?>