<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
<tr>
	<td class="adminGridHeading heading" align="left"><?php echo date('F Y', strtotime($start_date) );?></td>
	<td class="adminGridHeading" height="25px" align="right">
	</td>
</tr>
<tr>
	<td valign="top" colspan="2" align="center">
		<table width="99%" cellpadding="2" cellspacing="1"  border="0">
		<tr>
		       <td align="left">Summary from <span class="linkcolor"><?php echo $start_date;?></span> to <span class="linkcolor"><?php echo $end_date;?></span> </td>
		       <td align="right"><a href="javascript:void(0)" onclick="hideReportData();" >Click here to close X</a></td>
		</tr>
		</table>
	</td>
</tr>
<tr><td valign="top" colspan="2" align="center">&nbsp;</td></tr>

<tr>
	<td valign="top" colspan="2" align="center">
	
		
		<?php
			if(isset($arrDaysData) && is_array($arrDaysData) && count($arrDaysData) > 0){
		 ?>
			<input type="hidden" id="selected_month" value="<?php echo $selected_month; ?>" >
			<input type="hidden" id="selected_year" value="<?php echo $selected_year; ?>" >
			<input type="hidden" id="total_month_days" value="<?php echo  $monthDays;?>" >
				<table width="99%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
			    <tr>
				<td class="adminGridHeading" align="left" width="12%">Date Day</td>
				<td class="adminGridHeading" align="center" width="11%">Payment by Credit/Debit Card (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="11%">Payment by Paypal (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="11%">Payment by Google Checkout (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="11%">Payment by Gift Certificates (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="11%">Discount Coupon Used (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="11%">Pre Shipped Cancel (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="11%">Fraudulent (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="11%">Abandoned Sales (<?php echo CURRENCY_SYMBOL; ?>)</td>
			    </tr>
			<?php
			   $class= 'rowClassEven';
			   
			 $totalSage  = 	$totalPaypal =	$totalGoogle =	$totalGift = $totalCoupon = 0;	
			 $totalFraud  = $totalAbond = $totalPreShipped = 0;
			
			
			   foreach ($arrDaysData as $day=>$dData) {
			       $class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			       
			?>
			    <tr class="<?php echo $class?>" id="row_<?php echo $day."_".$dData['month']."_".$dData['year']; ?>">
				<td  align="center" >
				     <div style="float:left; text-align:left;"><b><?php echo $day."-".$dData['Month']; ?></b></div>
				     <div style="float:right; text-align:right; cursor:pointer;" id="<?php echo $day."_".$dData['month']."_".$dData['year']; ?>" onclick="displaySellerWiseData(this.id)">
				     <?php echo $html->image('plus-icon-img.png',array('alt'=>'')); ?>					
					</div>
				</td>
				<td  align="center" ><?php echo number_format($dData['sage_payment'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($dData['paypal_payment'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($dData['google_payment'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($dData['gift_payment'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($dData['coupon_payment'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($dData['pre_shipped_payment'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($dData['fraud_payment'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($dData['abandened_payment'],2);?>&nbsp;</td>
			    </tr>
			     <?php
				$totalSage 	+= $dData['sage_payment'];
				$totalPaypal	+= $dData['paypal_payment'];
				$totalGoogle 	+= $dData['google_payment'];
				$totalGift 	+= $dData['gift_payment'];
				$totalCoupon 	+= $dData['coupon_payment'];
				$totalPreShipped += $dData['pre_shipped_payment'];
				$totalFraud 	+= $dData['fraud_payment'];
				$totalAbond 	+= $dData['abandened_payment'];
			     } ?>
			   <tr >
				<td  align="center" > &nbsp;</td>
				<td  align="center" ><?php echo number_format($totalSage,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalPaypal,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalGoogle,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalGift,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalCoupon,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalPreShipped,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalFraud,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalAbond,2);?>&nbsp;</td>
			    </tr>
			<!--  <tr>-->
			<!--	<td align="left" colspan="8" class="gr-colr smlr-fnt">-->
			<!--	<i>-->
			<!--	* Denotes Pre-Shipped Cancellation values are here only for your information purposes as they have already been removed from the sales totals.<br>-->
			<!--	~ Denotes Fraudulent values are here only for your information purposes as they have already been removed from the sales totals.<br>-->
			<!--	^ Denotes Abandoned Sales are here only for your information purposes as they have already been removed from the sales totals.-->
			<!--	</i></td>-->
			<!--    </tr>-->
			    
			</table>
			<?php }else{ ?>
			<table width="100%" cellpadding="2" cellspacing="0" border="0" class="adminBox">
			    <tr>
				<td align="center">No record found</td>
			    </tr>
			</table>
			<?php } ?>
	</td>
</tr>



<tr><td valign="top" colspan="2" align="center">&nbsp;</td></tr>
<tr>
	<td valign="top" colspan="2" align="center" id="sellerwise_reportdisplay_id"></td>
</tr>
</table>	

