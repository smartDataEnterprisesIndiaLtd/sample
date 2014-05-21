<?php
$this->Html->addCrumb('Order Management', '/admin/orders');
	$this->Html->addCrumb('Manage Order Claims', 'javascript:void(0)');
$url = array(
	'keyword' =>$keyword,
	'searchin' => $fieldname,
	);
//$paginator->options(array('url' => $url));
// pr($claims);
?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" height="25px" align="right"></td>
	</tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Search returns</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("OrderReturn",array("action"=>"claims","method"=>"Post", "id"=>"frmSearchClaims", "name"=>"frmSearchClaims"));?>

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
									<?php echo $this->element('admin/claims_listing');?>
								</td>
							</tr>
							<tr><td height="10"></td></tr>
							<tr><td>
								<table border="0" cellspacing ="2" cellpadding="2" width="100%">
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Replied(Buyer and Seller):</b></td>
										<td align="left"><div class="bggreen" style="width:50px">&nbsp;</div></td>
									</tr>
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Replied(Seller):</b></td>
										<td align="left"><div class="bgsky" style="width:50px">&nbsp;</div></td>
									</tr>
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Replied(Buyer):</b></td>
										<td align="left"><div class="bgred"  style="width:50px">&nbsp;</div></td>
									</tr>
								</table>
							</td></tr>
							
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>

</table>