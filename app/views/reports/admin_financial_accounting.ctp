<?php
$this->Html->addCrumb('Reports & Statistics', '/admin/reports/financial_accounting');
	$this->Html->addCrumb('Financial and Management Acconting Reports', 'javascript:void(0)');

$javascript->link(array('jquery_paging' ,'jquery.tablesorter'), false);
?>
<style>
  .month-highlight { background:#C3EAF8; }
  .day-highlight { background:#FFFFCD; }
  </style>

<script type="text/javascript" language="javascript">

var plusImage = SITE_URL+'img/plus-icon-img.png';
var minusImage = SITE_URL+'img/minus-icon-img.png';

jQuery(document).ready(function(){
	jQuery('#ReportYear').change(function() {
		jQuery("form:first").submit();
	})
	 
});

///////////////////////////////////////////////////
/***
 * function to change the class and  plus minus image 
 */
function changeMonthTableImage(sMonthYear){
	
	var sYear =  jQuery('#ReportYear').val();
	for(var i=1; i <= 12; i++){
		var divId = i+'_'+sYear;
		var rowId = '#row_'+divId;
		if(divId == sMonthYear){
			continue;
		}
		//jQuery('#'+divId).html('<img src="/img/plus-icon-img.png">');
		jQuery('#'+divId).html('<img src='+plusImage+'>');
		
		if(jQuery(rowId).hasClass("month-highlight")){
			jQuery(rowId).removeClass("month-highlight")
		}
		
	}
	if(sMonthYear != ''){ 
		var rowId = '#row_'+sMonthYear;
		jQuery(rowId).toggleClass("month-highlight");
		
		 var exImage = jQuery('#'+sMonthYear).html();
		  var minusFound = exImage.search('minus');
	    // alert(result);
		if(minusFound > 0){
			jQuery('#'+sMonthYear).html('<img src='+plusImage+'>');
			hideReportData();
		 }else{
			jQuery('#'+sMonthYear).html('<img src='+minusImage+'>');
		 }
	}
}
///////////////////////////////////////////////////
/***
 * function to change the class and  plus minus image 
 */
function changeDayTableImage(sMonthYearYear){
	
	var mDays =  jQuery('#total_month_days').val();
	var month =  jQuery('#selected_month').val();
	var sYear =  jQuery('#ReportYear').val();

	for(var i=1; i <= mDays; i++){
		var divId = i+'_'+month+'_'+sYear;
		var rowId = '#row_'+divId;
		if(divId == sMonthYearYear){
			continue;
		}
		jQuery('#'+divId).html('<img src='+plusImage+'>');
		if(jQuery(rowId).hasClass("day-highlight")){
			jQuery(rowId).removeClass("day-highlight")
		}
		
	}
	
	if(sMonthYearYear != ''){ 
		var rowId = '#row_'+sMonthYearYear;
		jQuery(rowId).toggleClass("day-highlight");
		 var exImage = jQuery('#'+sMonthYearYear).html();
		 var minusFound = exImage.search('minus');
	    // alert(result);
		if(minusFound > 0){
			jQuery('#'+sMonthYearYear).html('<img src='+plusImage+'>');
			
		 }else{
			jQuery('#'+sMonthYearYear).html('<img src='+minusImage+'>');
		 }
	}
	
	
}
///////////////////////////////////////////////////
function displayDayWiseData(sMonthYear){
  
	var sYear =  jQuery('#ReportYear').val();
	var rowId = '#row_'+sMonthYear;
	//alert(rowId);
	// change the image of the plus to mius or minus to plus 
	 changeMonthTableImage(sMonthYear);
	// var exImage = jQuery('#'+sMonthYear).html();
	var exImage = jQuery('#'+sMonthYear).html();
	var minusFound = exImage.search('minus');
	// alert(result);
	 if(minusFound > 0){ 
	//// if( exImage == '<img src="/img/minus-icon-img.png">' || exImage == '<IMG src="/img/minus-icon-img.png">'){
		var url = SITE_URL+'admin/reports/getDateWiseFinancialReport/'+sMonthYear;
		//alert(url);
		jQuery('#preloader').show();
		jQuery.ajax({
			cache: false,
			async:false,
			type: "GET",
			url:url,
			success: function(msg){
				jQuery('#daywise_reportdisplay_id').html(msg);
				jQuery('#preloader').hide();
				
			}
		});
	}
	
}

///////////////////////////////////////////////////
/**
 * Dispplay the seller wise data fro a particular day
 *
 */
function displaySellerWiseData(sDayMonthYear){
	
	var sYear =  jQuery('#ReportYear').val();
	
	changeDayTableImage(sDayMonthYear);
	
	var exImage = jQuery('#'+sDayMonthYear).html();
	var minusFound = exImage.search('minus');
	if( minusFound > 0){
		var url = SITE_URL+'admin/reports/getSellerWiseFinancialReport/'+sDayMonthYear;
		//alert(url);
		jQuery('#preloader').show();
		jQuery.ajax({
			cache: false,
			async:false,
			type: "GET",
			url:url,
			success: function(msg){
				jQuery('#sellerwise_reportdisplay_id').html(msg);
				jQuery('#preloader').hide();
				
			}
		});
	 }
}
///////////////////////////////////////////////////


function hideReportData(){
	changeMonthTableImage('');
	jQuery('#daywise_reportdisplay_id').html('');
	jQuery('#sellerwise_reportdisplay_id').html('');
}

</script>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
	<?php echo $form->create("Report",array("action"=>"financial_accounting","method"=>"Post", "id"=>"frmReportForm", "name"=>"frmReportForm"));?>
<tr>
	<td class="adminGridHeading heading">Order For the Year <?php echo $Year;?></td>
	<td class="adminGridHeading" height="25px" align="right">
	<?php  echo $form->select('Report.year', $yearArray, $Year, array('type'=>'select','label'=>false,'div'=>false,'size'=>1,'style'=>"width:100px;"), '-- Year --'); 	?>
	</td>
</tr>
<tr>
	<td valign="top" colspan="2" align="center">
		<table width="99%" cellpadding="2" cellspacing="1"  border="0">
			 <tr>
				<td  align="left" class="linkcolor"><h4>Financial and Management Accounting Reports</h4></td>
			 </tr>
			 <tr>
				<td  align="left">Summary from <span class="linkcolor">01-Jan-<?php echo $Year;?></span> to <span class="linkcolor">31-Dec-<?php echo $Year;?></span> </td>
			 </tr>
		</table>
	</td>
</tr>
<tr><td valign="top" colspan="2" align="center">&nbsp;</td></tr>
<?php echo $form->end();?>
 <tr>
	<td valign="top" colspan="2" align="center">
	
		<?php
			if(isset($arrMonData) && is_array($arrMonData) && count($arrMonData) > 0){
		 ?>
			<table width="99%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
			    <tr>
				<td class="adminGridHeading" align="left" width="10%">Months</td>
				<td class="adminGridHeading" align="center" width="8%">Orders</td>
				<td class="adminGridHeading" align="center" width="10%">Gross Revenues (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="10%">Refund Value (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="10%">Net Revenues (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="13%">Marketplace Fees (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="14%">Discount Vouchers (<?php echo CURRENCY_SYMBOL; ?>)</td>
				<td class="adminGridHeading" align="center" width="13%">Gift Certificates (<?php echo CURRENCY_SYMBOL; ?>)</td>
			    </tr>
			<?php
			$totalOrders =  $totalRevenue =  $totalRefund = $totalMFees= 0;
			$totalNetRevenue = $totalDiscount = $totalGCRevenue = 0;
			
			   $class= 'rowClassEven';
			   foreach ($arrMonData as $mon=>$mData) {
			       $class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			?>
			    <tr class="<?php echo $class?>" id="row_<?php echo $mon."_".$mData['year']; ?>">
				<td  align="center" >
					<div style="float:left; text-align:left;"><b><?php echo $mData['month'];?></b></div>
				     <div style="float:right; text-align:right; cursor:pointer;" id="<?php echo $mon."_".$mData['year']; ?>" onclick="displayDayWiseData(this.id)">
				     <!--<img src="/img/plus-icon-img.png">-->
				      <?php echo $html->image('plus-icon-img.png',array('alt'=>'')); ?>
				      
				      </div>
				</td>
				<td  align="center" ><?php echo $mData['total_orders'];?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($mData['gross_revenue'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($mData['refund_value'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($mData['net_revenue'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($mData['marketplace_fees'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($mData['discount_vouchers'],2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($mData['gc_revenue'],2);?>&nbsp;</td>
			    </tr>
			     <?php
				$totalOrders 	+= $mData['total_orders'];
				$totalRevenue	+= $mData['gross_revenue'];
				$totalRefund 	+= $mData['refund_value'];
				$totalMFees 	+= $mData['marketplace_fees'];
				$totalNetRevenue	+= $mData['net_revenue'];
				$totalDiscount 	+= $mData['discount_vouchers'];
				$totalGCRevenue 	+= $mData['gc_revenue'];
			     } ?>
			   <tr >
				<td  align="center" > &nbsp;</td>
				<td  align="center" ><?php echo $totalOrders;?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalRevenue,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalRefund,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalNetRevenue,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalMFees,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalDiscount,2);?>&nbsp;</td>
				<td  align="center" ><?php echo number_format($totalGCRevenue,2);?>&nbsp;</td>
			    </tr>
			<!--   <tr>-->
			<!--	<td align="left" colspan="8"><i>* denotes that refund values do not include insurance values.</i></td>-->
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

<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td valign="top" colspan="2" align="center" id="daywise_reportdisplay_id"></td>
</tr>

<!-- Legends -->
</table>

