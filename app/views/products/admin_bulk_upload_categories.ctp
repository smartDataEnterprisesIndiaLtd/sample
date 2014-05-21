<?php echo $javascript->link(array('jquery-1.3.2.min'), false);
echo $form->create('Product',array('action'=>'admin_bulk_upload_categories', 'method'=>'POST','name'=>'frmProduct','id'=>'frmProduct', 'enctype'=>'multipart/form-data' ));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td class="adminGridHeading heading"  height="25px" align="right">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
				<tr>
					<td  align="right" width="20%"></td>
					<td align="left" width="40%"></td>
					<td rowspan="7">
						<table class="" border="0" cellpadding="2" cellspacing="2" width="100%">
							<tr>
								<td colspan="2"><?php echo $html->link('Upload product categories','/products/download_sample_template/products_categories.csv',array('escape'=>false));?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr height="20px">
					<td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="error_msg">*</span> Upload Listing :</td>
					<td>
						<?php echo $form->input('Product.sample_bulk_data_category',array('class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'type' => 'file'));?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="left">
					<?php 
					echo $form->button('Upload Listing',array('type'=>'submit','class'=>'btn_53','div'=>false));
					?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $form->end(); ?>