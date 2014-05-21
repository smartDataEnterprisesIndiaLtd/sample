<?php
$this->Html->addCrumb('Reports & Statistics', '/admin/reports/financial_accounting');
	$this->Html->addCrumb('Most Questions/Answer Product', 'javascript:void(0)');

$javascript->link(array( 'jquery_paging' ,'jquery.tablesorter'), false);
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
echo $javascript->link('lib/prototype');
$url = array(	
	'keyword' =>$productFor	
	);
$optionspaging = array('url'=>$url,'update'=>'listing');
$paginator->options($optionspaging);
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
					<td height="25" class="reportListingHeading">Search most question/answer of a product</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("Reports",array("action"=>"product_question","method"=>"Post", "id"=>"frmProduct_question", "name"=>"frmProduct_question"));?>

									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" style="width:70px; white-space: nowrap;">Search For: </td>
											<td width="11%">
												<?php
												       echo $form->select('ProductQuestion.productFor',$options,$productFor,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Status--');
												?>
											</td>
											<td align="left" style="width:80px; white-space: nowrap;">Number of records: </td>
											<td width=11%">
												<?php echo $form->select('ProductQuestion.productRecord',$showArr,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Status--'); ?>
											</td>
											<td>
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
					<td >					
						<table   align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
							<tr>
								<td colspan="2" id = 'listing'>
									
									<!--- Start list table-->
									<?php if($productFor == "question"){?>
											<?php if(isset($ProductQuestion) && is_array($ProductQuestion) && count($ProductQuestion) > 0){?>
												<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
													<tr>
														<td align="left" class="adminGridHeading" width="30%" >Product Name </td>
														<td class="adminGridHeading" align="center" width="30%" >Number of questions </td>
													</tr>
													<?php
														$class= 'rowClassEven';
													foreach ($ProductQuestion as $ProductQuestion) {
														$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
													?>
													<tr class="<?php echo $class?>">
														<td align="left"><?php echo $ProductQuestion['Product']['product_name'];?></td>
														<td align="center"><strong><?php  echo $ProductQuestion['0']['total_question'];?></strong></td>
													</tr>
													<?php }?>
													<tr>
														<td colspan="2"> <?php
																/************** paging box ************/
																echo $this->element('admin/paging_box');
																?>
																
														</td>
													</tr>
													
												</table>
											<?php }else{ ?>
												<table width="100%" cellpadding="2" cellspacing="0" border="0" class="borderTable">
													<tbody>
														<tr> 
															<td align="center">No record found</td>
														</tr>
													</tbody>
												</table>
											<?php } ?>
											</td></tr>
										</table>
									<?php }else{?>
									
									<?php if(isset($ProductAnswer) && is_array($ProductAnswer) && count($ProductAnswer) > 0){?>
												<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
													<tr>
														<td align="left" class="adminGridHeading" width="30%" >Product Name </td>
														<td class="adminGridHeading" align="center" width="30%" >Number of answer </td>
													</tr>
													<?php
														$class= 'rowClassEven';
													foreach ($ProductAnswer as $ProductAnswer) {
														$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
													?>
													<tr class="<?php echo $class?>">
														<td align="left"><?php echo $ProductAnswer['Product']['product_name'];?></td>
														<td align="center"><strong><?php  echo $ProductAnswer['0']['total_answer'];?></strong></td>
													</tr>
													<?php }?>
													<tr>
														<td colspan="2"> <?php
																/************** paging box ************/
																echo $this->element('admin/paging_box');
																?>
																
														</td>
													</tr>
													
												</table>
											<?php }else{ ?>
												<table width="100%" cellpadding="2" cellspacing="0" border="0" class="borderTable">
													<tbody>
														<tr> 
															<td align="center">No record found</td>
														</tr>
													</tbody>
												</table>
											<?php } ?>
											</td></tr>
										</table>
									<?php }?>
									<!-- End List Table-->
										
										
								</td>
							</tr>
						</table>
						 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				
			</table>
		</td>		
	</tr>

</table>