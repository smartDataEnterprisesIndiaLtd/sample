<?php $javascript->link(array('jquery-1.3.2.min', 'jquery_paging' ,'jquery.tablesorter'), false);
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
					<td height="25" class="reportListingHeading">Search most viewed Categories</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("Reports",array("action"=>"most_viewed_category","method"=>"Post", "id"=>"frmMostViewedCategory", "name"=>"frmMostViewedDepartments"));?>

									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" width="9%">Date Form: </td>
											<td width="37%">
												<?php
												       echo $form->input('CategoryVisit.dept_id',array('autocomplete'=>'off','type'=>'hidden', 'value'=>$dept_id, 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));
												       if($parent_id){
														echo $form->input('CategoryVisit.parent_id',array('autocomplete'=>'off','type'=>'hidden', 'value'=>$parent_id, 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));
												       }
												       echo $form->input('CategoryVisit.start_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));
												       echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].CategoryVisitStartDate,'dd-mm-yyyy',this)"));
												?>
											</td>
											<td align="left" width="9%">Date To: </td>
											<td width="37%">
												<?php echo $form->input('CategoryVisit.end_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20' ,'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly')); 									
												      echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].CategoryVisitEndDate,'dd-mm-yyyy',this)")); ?>
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
													<tr>
														<td align="left">
															<?php
															$strLink = '';
																$outerlink =SITE_URL."admin/reports/most_viewed_departments/".$dept_id."";
																	$strLink ='<a href="'.$outerlink.'" >' .$strDepName. '</a>';	
																	$strLink .=' &raquo; ';
																	$html->addCrumb($strDepName,$outerlink);
																	if( is_array($finalArr) ){
																		$totalCount=count($finalArr);
																		foreach($finalArr as $key=>$value){
																			$html->addCrumb($value,SITE_URL."admin/reports/most_viewed_category/".$dept_id."/".$key."");
																			
																		}
																		
																	}
																echo $html->getCrumbs(' &raquo; ','');
															?>
															
															
															
														</td>
													</tr>
											</table>
											<?php if(isset($visitCategory) && is_array($visitCategory) && count($visitCategory) > 0){?>
												<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
													<tr>
														<td align="left" class="adminGridHeading" width="30%" >Category Name </td>
														<td class="adminGridHeading" align="center" width="30%" >Number of visit </td>
													</tr>
													<?php
														$class= 'rowClassEven';
													foreach ($visitCategory as $visitCategory) {
														$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
													?>
													<tr class="<?php echo $class?>">
													
														<?php $is_sub =0; 
														 $is_sub = $common->getVisitedSubCategories($visitCategory['CategoryVisit']['category_id']);?>
														 <?php if($is_sub){?>
															<td align="left"><?php echo $html->link($visitCategory['Category']['cat_name'],array('controller'=>'reports','action'=>'admin_most_viewed_category/'.$dept_id.'/'.$visitCategory['CategoryVisit']['category_id']),array('escape'=>false));?></td>
														<?php }else{?>
															<td align="left"><?php echo $visitCategory['Category']['cat_name'];?></td>
														<?php }?>
														
														<td align="center"><strong><?php  echo $visitCategory['0']['total_visits'];?></strong></td>
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