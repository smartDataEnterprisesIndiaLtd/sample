<?php
$this->Html->addCrumb('Product Management', '/admin/products');
$this->Html->addCrumb('Product Brands', 'javascript:void(0)');
$url = array(
	'keyword' =>$keyword,
	'searchin' => $fieldname,
	);
//$paginator->options(array('url' => $url));
?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" height="25px" align="right">
		<?php echo $html->link('<span>Download Now</span>',array("controller"=>"brands","action"=>"export") , array('escape'=>false,'class'=>'wt_btn','title'=>'Download Now') ); ?>
		
		<?php echo $html->link('<span>Add New Brand</span>',array("controller"=>"brands","action"=>"add") , array('escape'=>false,'class'=>'wt_btn','title'=>'Add New Brand') ); ?>	
		</td>
	</tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Search Brand</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("Brands",array("action"=>"index","method"=>"Post", "id"=>"frmSearchBrand", "name"=>"frmSearchBrand"));?>
	
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
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
 	<tr>
		<td colspan="2" valign="top" id="pagging">
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table   align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
							<tr>
								<td colspan="2" >
									<?php echo $this->element('admin/brands_listing');?>
								</td>
							</tr>
							<tr><td height="10"></td></tr>
							<tr>
								<td class="legends">
									<b>Legends:</b>
									<?php echo $html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')) ?>&nbsp;Edit&nbsp;
									<?php echo $html->image('b_drop.png',array('border'=>0,'alt'=>'Delete','title'=>'Delete')); ?>&nbsp;Delete&nbsp;
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>

</table>
