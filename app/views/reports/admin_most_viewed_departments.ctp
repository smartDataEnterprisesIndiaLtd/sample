<?php
$this->Html->addCrumb('Reports & Statistics', '/admin/reports/financial_accounting');
	$this->Html->addCrumb('Most Viewed Departments', 'javascript:void(0)'); 

$javascript->link(array( 'jquery_paging' ,'jquery.tablesorter'), false);
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
echo $javascript->link('lib/prototype');
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
					<td height="25" class="reportListingHeading">Search most viewed departments</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("Reports",array("action"=>"most_viewed_departments","method"=>"Post", "id"=>"frmMostViewedDepartments", "name"=>"frmMostViewedDepartments"));?>
									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" style="white-space: nowrap; width: 70px;">Date Form: </td>
											<td width="37%">
												<?php  echo $form->input('DepartmentVisit.start_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));
												       echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].DepartmentVisitStartDate,'dd-mm-yyyy',this)"));
												?>
											</td>
											<td align="left" style="white-space: nowrap; width: 60px;">Date To: </td>
											<td width="37%">
												<?php echo $form->input('DepartmentVisit.end_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20' ,'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly')); 									
												      echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].DepartmentVisitEndDate,'dd-mm-yyyy',this)")); ?>
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
									<?php echo $this->element('admin/mostviewed_departments_listing');	?>
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
