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
											<?php if(isset($lateShipmentRatesArr) && is_array($lateShipmentRatesArr) && count($lateShipmentRatesArr) > 0){?>
												<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
													<tr>
														<td align="left" class="adminGridHeading" width="30%" >Seller Name </td>
														<td class="adminGridHeading" align="center" width="30%" >Late shipped rates</td>
													</tr>
													<?php
														$class= 'rowClassEven';
														foreach ($lateShipmentRatesArr as $lateShipmentRatesArr) {
														$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
														
													?>
													<tr class="<?php echo $class?>">
														<td align="left"><?php $sellerInfo = $this->Common->getSellerInfo($lateShipmentRatesArr['seller_id']);
																echo $sellerInfo['Seller']['business_display_name'];	
																
																
															?></td>
														<td align="center"><strong><?php $rates=$lateShipmentRatesArr['lateship_rate'];
																		echo round($rates, 2);
														?></strong></td>
													</tr>
													<?php }?>
													<tr>
														<td colspan="2"> <?php
																/************** paging box ************/
																//echo $this->element('admin/paging_box');
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