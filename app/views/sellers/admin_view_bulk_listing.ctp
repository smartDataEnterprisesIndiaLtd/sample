<?php
$this->Html->addCrumb('Seller Management', ' ');
$this->Html->addCrumb('Manage Seller\'s Volume Listings', 'javascript:void(0)');
$paginator->options(array('update'=>'pagging'));
$url = array(
	'keyword' =>$keyword,
	'searchin' => $fieldname,
	);

$paginator->options(array('url' => $url));
?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $title_for_layout;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			&nbsp; &nbsp;
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Search </td>
				</tr>
				<tr>
				<td>
				<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
					<tr>
						<td>
							<?php echo $form->create("Seller",array("action"=>"view_bulk_listing","method"=>"Post", "id"=>"frmViewBulkListing", "name"=>"frmViewBulkListing"));?>
								
							<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0" class="keywordtbl_search">
								<tr>
									<td align="left" width="60%">
										<div class="keyword_widget">
											<label>Keyword :</label>
											<div class="field_widget">
												<p class="pdrt2"><?php echo $form->input('Search.keyword',array('size'=>'53','class'=>'textbox','label'=>false,'div'=>false,'maxlength'=>'53','value'=>$keyword));?></p>
											</div>
									</div>
								</td>
									<td width="40%" class="select_input">
										<?php echo $form->select('Search.searchin',$options,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Field--'); ?>
									
										<?php echo $form->submit('Search',array('alt'=>'Next','width'=>'38','height'=>'31','border'=>'0', "value"=>"search",'class'=>'btn_53'))?>
									</td>
								</tr>
							</table>
							<?php echo $form->end();?>
						</td>
					</tr>
				</table>
				</td>
				</tr>
			</table>
		</td>
		
	<tr><td colspan="2">&nbsp;</td></tr>
 	<tr>
		<td colspan="2" valign="top" id="pagging">
				
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
						
					<td  id='listing'>
						<?php  echo $this->element('admin/volumeseller_listing');	?>
					</td>
							
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="legends">
						<b>Legends:</b>
						<?php echo $html->image('b_drop.png',array('border'=>0,'alt'=>'Delete','title'=>'Delete')); ?>&nbsp;Delete&nbsp;
					</td>
				</tr>
				<!-- Legends -->
				<!-- Notes -->
				<tr>
					<td class="legends">
						<b>Note:</b>&nbsp;Please enter QCID in Column A, with header QCID, replace country name by country id with header <?php 
								echo $html->link('DISPATCH COUNTRY','/admin/sellers/dispatch_country_list',array('escape'=>false,'target'=>'blank'));
							?> in Column E, in downloaded CSV file to upload&nbsp;
					</td>
				</tr>
			</table>
		</td>		
	</tr>

</table>
