<?php
$this->Html->addCrumb('Reports & Statistics', '/admin/reports/financial_accounting');
	$this->Html->addCrumb('Most Reviewed Products', 'javascript:void(0)');

$javascript->link(array('jquery_paging' ,'jquery.tablesorter'), false);
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
echo $javascript->link('lib/prototype');
?>
<?php
$key = $paginator->sortKey();
if(!empty($key)) {
	if($paginator->sortDir() == 'asc'){
		$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>'','div'=>false));
	} else if($paginator->sortDir() == 'desc'){
		$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>'','div'=>false));
	} else{
		$image = '';
	}
} else{
	$image ='';
}
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
 			<!--<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Search most viewed Categories</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php //echo $form->create("Reports",array("action"=>"most_viewed_category","method"=>"Post", "id"=>"frmMostViewedCategory", "name"=>"frmMostViewedDepartments"));?>

									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" width="9%">Date Form: </td>
											<td width="37%">
												<?php
												       //echo $form->input('CategoryVisit.dept_id',array('autocomplete'=>'off','type'=>'hidden', 'value'=>$dept_id, 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));
												      // if($parent_id){
														//echo $form->input('CategoryVisit.parent_id',array('autocomplete'=>'off','type'=>'hidden', 'value'=>$parent_id, 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));
												      // }
												      // echo $form->input('CategoryVisit.start_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));
												      // echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].CategoryVisitStartDate,'dd-mm-yyyy',this)"));
												?>
											</td>
											<td align="left" width="9%">Date To: </td>
											<td width="37%">
												<?php //echo $form->input('CategoryVisit.end_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20' ,'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly')); 									
												      //echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].CategoryVisitEndDate,'dd-mm-yyyy',this)")); ?>
											</td>
											<td>
												<?php //echo $form->submit('Search',array('alt'=>'Next','width'=>'38','height'=>'31','border'=>'0', "value"=>"search",'class'=>'btn_53'))?>
											</td>
										</tr>
									</table>
									<?php //echo $form->end();?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>-->
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
											<?php if(isset($ProductReviewed) && is_array($ProductReviewed) && count($ProductReviewed) > 0){?>
												<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
													<tr>
														<td align="left" class="adminGridHeading" width="20%" >
															<?php echo $paginator->sort('Product Name', 'Product.product_name'); ?>
															<?php if($paginator->sortKey() == 'Product.product_name'){ echo $image; } ?>
															</td>
														<td class="adminGridHeading" align="center" width="10%" >
															<?php echo $paginator->sort('Product Id', 'Product.id'); ?>
															<?php if($paginator->sortKey() == 'Product.id'){ echo $image; } ?>
														</td>
														<td class="adminGridHeading" align="center" width="10%" >
															<?php echo $paginator->sort('Quick Code', 'Product.quick_code'); ?>
															<?php if($paginator->sortKey() == 'Product.quick_code'){ echo $image; } ?>
														</td>
														<td class="adminGridHeading" align="center" width="20%" >Number of Reviews </td>
													</tr>
													<?php
														$class= 'rowClassEven';
													foreach ($ProductReviewed as $ProductReviewed) {
														$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
													?>
													<tr class="<?php echo $class?>">
														<td align="left"><?php echo $html->link($ProductReviewed['Product']['product_name'],'/'.$this->Common->getProductUrl($ProductReviewed['Product']['id']).'/categories/productdetail/'.$ProductReviewed['Product']['id'],array('escape'=>false,'target'=>'_blank'));?></td>
														<td align="center"><?php echo $ProductReviewed['Product']['id'];?></td>
														<td align="center"><?php echo $ProductReviewed['Product']['quick_code'];?></td>
														<td align="center"><strong><?php  echo $ProductReviewed['0']['total_review'];?></strong></td>
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