<?php
	$this->Html->addCrumb('Product Management', '/admin/products');
	$this->Html->addCrumb('Upload Products', 'javascript:void(0)');


//echo $javascript->link(array('jquery-1.3.2.min'), false);
echo $form->create('Product',array('action'=>'admin_bulk_upload', 'method'=>'POST','name'=>'frmProduct','id'=>'frmProduct', 'enctype'=>'multipart/form-data' ));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td class="adminGridHeading heading"  height="25px" align="right"><?php echo $html->link('Upload Categories','/admin/products/bulk_upload_categories',array('escape'=>false));?> | <?php echo $html->link('Move images','/admin/products/upload_images',array('escape'=>false));?></td>
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
								<td colspan="2">Download sample templates for:</td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><?php echo $html->link('Books','/products/download_sample_template/products_books_bulk_upload.csv',array('escape'=>false));?></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><?php echo $html->link('Music','/products/download_sample_template/products_music_bulk_upload.csv',array('escape'=>false));?></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><?php echo $html->link('Movies','/products/download_sample_template/products_movies_bulk_upload.csv',array('escape'=>false));?></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><?php echo $html->link('Games','/products/download_sample_template/products_games_bulk_upload.csv',array('escape'=>false));?></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><?php echo $html->link('Electronics','/products/download_sample_template/products_electronics_bulk_upload.csv',array('escape'=>false));?></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><?php echo $html->link('Office & Computing','/products/download_sample_template/products_office_and_computing_bulk_upload.csv',array('escape'=>false));?></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><?php echo $html->link('Mobile','/products/download_sample_template/products_mobile_bulk_upload.csv',array('escape'=>false));?></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><?php echo $html->link('Home & Garden','/products/download_sample_template/products_homeandgarden_bulk_upload.csv',array('escape'=>false));?></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><?php echo $html->link('Health & Beauty','/products/download_sample_template/products_health_and_beauty_bulk_upload.csv',array('escape'=>false));?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr height="20px">
					<td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="error_msg">*</span> Department :</td>
					<td>
						<?php echo $form->select('Product.department_id',$departments,null,array('class'=>'textbox', 'type'=>'select'),'-- Select --'); ?>
						<?php echo $form->error('Product.department_id'); ?>
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="error_msg">*</span> Upload Listing :</td>
					<td>
						<?php echo $form->input('Product.sample_bulk_data',array('class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'type' => 'file'));?>
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