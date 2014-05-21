<?php
$this->Html->addCrumb('Reports & Statistics', '/admin/reports/financial_accounting');
	$this->Html->addCrumb('Most Viewed Products', 'javascript:void(0)');
	
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
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Search most viewed products</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("Reports",array("action"=>"most_viewed_products","method"=>"Post", "id"=>"frmMostViewedDepartments", "name"=>"frmMostViewedDepartments"));?>
<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
			<tr>
				<td align="left" width="9%">Date From: </td>
				<td width="37%">
					<?php
					
					/*if(isset($this->params['pass'][3]) && !empty($this->params['pass'][3]))
					{
					$startDate = $this->params['pass'][3];	
					}
					
					if(isset($this->params['pass'][4]) && !empty($this->params['pass'][4]))
					{
					$endDate = $this->params['pass'][4];	
					}
					*/
					echo $form->input('ProductsVisit.start_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));
					       echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].ProductsVisitStartDate,'dd-mm-yyyy',this)"));
					?>
				</td>
				<td align="left" width="9%">Date To: </td>
				<td width="37%">
					<?php echo $form->input('ProductsVisit.end_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20' ,'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly')); 									
					      echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].ProductsVisitEndDate,'dd-mm-yyyy',this)")); ?>
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
														<td  align="left" width="20%" style="text-align:right" >Total Number of Records: <?php echo $this->Paginator->counter(array('format' => __('%count%', true)));?></td>
													</tr>
											</table>
											<?php if(isset($visitProduct) && is_array($visitProduct) && count($visitProduct) > 0){?>
												<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
													<tr>
														<td align="left" class="adminGridHeading" width="20%" >
															<?php echo $paginator->sort('Product Name', 'Product.product_name'); ?>
															<?php if($paginator->sortKey() == 'Product.product_name'){ echo $image; } ?>
														</td>
														<td align="center" class="adminGridHeading" width="10%" >
															<?php echo $paginator->sort('Product Id', 'Product.id'); ?>
															<?php if($paginator->sortKey() == 'Product.id'){ echo $image; } ?>
														</td>
														<td align="center" class="adminGridHeading" width="10%" >
															<?php echo $paginator->sort('Quick Code', 'Product.quick_code'); ?>
															<?php if($paginator->sortKey() == 'Product.quick_code'){ echo $image; } ?>
														</td>
														<td class="adminGridHeading" align="center" width="20%" >Number of visits</td>
													</tr>
													<?php
														$class= 'rowClassEven';
													foreach ($visitProduct as $visitProduct) {
														$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
													?>
													<tr class="<?php echo $class?>">
														<td align="left"><?php echo $html->link($visitProduct['Product']['product_name'],'/'.$this->Common->getProductUrl($visitProduct['Product']['id']).'/categories/productdetail/'.$visitProduct['Product']['id'],array('escape'=>false,'target'=>'_blank'));?></td>
														<td align="center"><?php echo $html->link($visitProduct['Product']['id'],'/'.$this->Common->getProductUrl($visitProduct['Product']['id']).'/categories/productdetail/'.$visitProduct['Product']['id'],array('escape'=>false,'target'=>'_blank'));?></td>
														<td align="center"><?php  echo $visitProduct['Product']['quick_code'];?></td>
														<td align="center"><strong><?php  echo $visitProduct['0']['total_visits'];?></strong></td>
													</tr>
													<?php }?>
													<tr>
														<td colspan="4"> <?php
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