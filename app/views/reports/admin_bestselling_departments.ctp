<?php
$this->Html->addCrumb('Reports & Statistics', '/admin/reports/financial_accounting');
	$this->Html->addCrumb('Bestselling Products By Department', 'javascript:void(0)');

$javascript->link(array('jquery_paging' ,'jquery.tablesorter'), false);
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
echo $javascript->link('lib/prototype');
$dates=strtotime($sDateTime).'~'.strtotime($eDateTime);
$url = array(	
	'keyword' =>$dates	
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
					<td height="25" class="reportListingHeading">Search Bestselling Departments</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("Reports",array("action"=>"bestselling_departments","method"=>"Post", "id"=>"frmMostBestsellingProduct", "name"=>"frmMostBestsellingProduct"));?>
									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" style="width:50px; white-space: nowrap;">Date Form: </td>
											<td width="37%">
												<?php  echo $form->input('OrderItem.start_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));
												       echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].OrderItemStartDate,'dd-mm-yyyy',this)"));
												?>
											</td>
											<td align="left" style="width:50px; white-space: nowrap;">Date To: </td>
											<td width="37%">
												<?php echo $form->input('OrderItem.end_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20' ,'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly')); 									
												      echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].OrderItemEndDate,'dd-mm-yyyy',this)")); ?>
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
										<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="adminBox">
													<tr>
														<td  align="left" width="20%" >Form: <?php echo  $sDateTime; ?> To: <?php echo $eDateTime ?></td>
													</tr>
											</table>
											<?php if(isset($bestSellingProduct) && is_array($bestSellingProduct) && count($bestSellingProduct) > 0){?>
												<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
													<tr>
														<td align="left" class="adminGridHeading" width="30%" >Department Name </td>
														<td class="adminGridHeading" align="center" width="30%" >Number of product sold</td>
													</tr>
													<?php
														$class= 'rowClassEven';
													foreach ($bestSellingProduct as $bestSellingProduct) {
														$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
													?>
													<tr class="<?php echo $class?>">
														<td align="left">
															<?php $department_name=$this->Common->getDepartmentsName($bestSellingProduct['Product']['department_id']);
																echo $department_name[0]['Department']['name'];
															
															?>
														</td>
														<td align="center"><strong><?php  echo $bestSellingProduct['0']['total_quantity'];?></strong></td>
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
