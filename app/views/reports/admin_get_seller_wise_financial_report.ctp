<?php $javascript->link(array('jquery-1.3.2.min', 'jquery_paging' ,'jquery.tablesorter'), false);
//echo $html->css('tablesorter');
?>

<script type="text/javascript" language="javascript">
jQuery(document).ready(function(){
	
	jQuery("#myTable").tablesorter();
	
	 
});
</script>

<style>
th.header { 
   /* background-image: url(/img/admin-arrow-bottom.gif);    */ 
    cursor: pointer; 
    font-weight: bold; 
    background-repeat: no-repeat; 
    background-position: center right; 
    padding-left: 20px;  padding-right:10px;
    border-right: 1px solid #dad9c7; 
    margin-left: -1px; 
}

.bold-data td {  font-size:12px; font-weight:bold; background-color:#DFDFDF; }
th.headerSortUp {   	background-image: url(../img/admin-arrow-bottom.gif); }
th.headerSortDown {    background-image: url(../img/admin-arrow-top.gif);} 

	
</style>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
<tr>
	<td class="adminGridHeading heading" align="left">Marketplace Seller Sales for <?php echo date('d-F-Y', strtotime($saleDate) );?></td>
	<td class="adminGridHeading" height="25px" align="right">
	</td>
</tr>
<tr>
	<td valign="top" colspan="2" align="center">
		<table width="99%" cellpadding="2" cellspacing="1"  border="0">
		<tr>
		       <td align="left" class="linkcolor"><h4>Summary Report </h4>&nbsp; </td>
		       <td align="right"></td>
		</tr>
		</table>
	</td>
</tr>
<tr><td valign="top" colspan="2" align="center">&nbsp;</td></tr>
<tr>
	<td valign="top" colspan="2" align="center">
	<?php
		if(isset($sellerWiseDataArr) && is_array($sellerWiseDataArr) && count($sellerWiseDataArr) > 0){
	 ?>
			
			<table width="99%" cellpadding="2" cellspacing="1"  border="0"  id="myTable" class="tablesorter">
			  <thead>
				<tr>
				<th class="adminGridHeading header" align="left" width="15%">Seller</th>
				<th class="adminGridHeading header" align="center" width="10%">Orders</th>
				<th class="adminGridHeading header" align="center" width="10%">Gross Revenues </th>
				<th class="adminGridHeading header" align="center" width="10%">Refund Value  </th>
				<th class="adminGridHeading header" align="center" width="10%">Net Revenues </th>
				<th class="adminGridHeading header" align="center" width="13%">Balance </th>
				<th class="adminGridHeading header" align="center" width="14%">Marketplace Fees </th>
				<th class="adminGridHeading header" align="center" width="13%">Deposit Value </th>
			    </tr>
			</thead> 
			<tbody> 
			<?php
			 $class= 'rowClassEven';
			   
			 $totalSOrder  = $totalSRevenue = $totalSRefund = $totalSNetRevenue = 0;	
			 $totalSBalance  = $totalSMFees =  $totalSDeposit  = 0;
			   foreach ($sellerWiseDataArr as $id=>$sData) {
			       $class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
				//pr($sData);
			       
			?>
			    <tr class="<?php echo $class; ?>" >
				<td  align="left" ><?php echo $html->link($sData['seller_name'],'/sellers/summary/'.$sData['seller_id'],array('escape'=>false));?>&nbsp;</td>
				<td  align="center" ><?php echo $sData['total_orders'];?>&nbsp;</td>
				<td  align="center" ><?php echo CURRENCY_SYMBOL.$format->money($sData['gross_revenue'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo CURRENCY_SYMBOL.$format->money($sData['refund_amount'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo CURRENCY_SYMBOL.$format->money($sData['net_revenue'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo CURRENCY_SYMBOL.$format->money($sData['balance'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo CURRENCY_SYMBOL.$format->money($sData['marketplace_fees'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo CURRENCY_SYMBOL.$format->money($sData['deposit_amount'],2);?>&nbsp;</td>
			    </tr>

			     <?php
				$totalSOrder 	+= $sData['total_orders'];
				$totalSRevenue	+= $sData['gross_revenue'];
				$totalSRefund 	+= $sData['refund_amount'];
				$totalSNetRevenue	+= $sData['net_revenue'];
				$totalSBalance 	+= $sData['balance'];
				$totalSMFees 	+= $sData['marketplace_fees'];
				$totalSDeposit 	+= $sData['deposit_amount'];
			     } ?>
			 
			   </tbody>
			    
			</table>
			<table width="99%" cellpadding="2" cellspacing="1"  border="0" class="bold-data" >
			     <tr >
				<td  align="left"   width="15%"> &nbsp;</td>
				<td  align="center" width="10%"><?php echo $totalSOrder;?>&nbsp;</td>
				<td  align="center" width="10%" ><?php echo number_format($totalSRevenue,2);?>&nbsp;</td>
				<td  align="center" width="10%" ><?php echo number_format($totalSRefund,2);?>&nbsp;</td>
				<td  align="center" width="10%" ><?php echo number_format($totalSNetRevenue,2);?>&nbsp;</td>
				<td  align="center"  width="13%"><?php echo number_format($totalSBalance,2);?>&nbsp;</td>
				<td  align="center"  width="14%"><?php echo number_format($totalSMFees,2);?>&nbsp;</td>
				<td  align="center" width="13%" ><?php echo number_format($totalSDeposit,2);?>&nbsp;</td>
			    </tr>
			</table>
			
			<?php  }else{ ?>
			<table width="100%" cellpadding="2" cellspacing="0" border="0" class="adminBox">
			    <tr>
				<td align="center">No record found</td>
			    </tr>
			</table>
			<?php  } ?>
	</td>
</tr>

<tr><td valign="top" colspan="2" align="center">&nbsp;</td></tr>

</table>	

