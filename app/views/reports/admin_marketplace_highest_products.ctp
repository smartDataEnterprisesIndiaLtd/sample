<?php
$this->Html->addCrumb('Reports & Statistics', '/admin/reports/financial_accounting');
	$this->Html->addCrumb('Marketplace Highest Products', 'javascript:void(0)');
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
?>
<?php
if($paginator->sortDir() == 'asc'){
	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>'','div'=>false));
}
else if($paginator->sortDir() == 'desc'){
	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>'','div'=>false));
}
else{
	$image = '';
}
?>
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
	<td>
		<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
			<tr>
				<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
				<td class="adminGridHeading" height="25px" align="right">
				</td>
			</tr>
			
			<tr><td colspan="2">
				<table align="center" width="99%" border="0" cellpadding="0" cellspacing="4" valign="top">
				
					<tr>
						<td colspan="2"><h3>Highest number of product's marketplace sellers Information : </h3></td>
					</tr>
					<?php
					$sellerInfo = $this->Common->getsellerInfo($seller_products[0]['ProductSeller']['seller_id']);
					if( count($sellerInfo) > 0 ){?>
					<tr>
						<td  width="25%" align="left"><b>Name : </b></td>
						<td align="left"><b><?php echo $sellerInfo['User']['firstname']." ".$sellerInfo['User']['lastname'];	?></b></td>
						</tr>
						<tr>
						<td   align="left"><b>Business Display Name : </b></td>
						<td align="left"><b><?php echo $sellerInfo['Seller']['business_display_name'];	?></b></td>
					</tr>
					<?php  } ?>
					<tr>
						<td   align="left"><b>Number of products:</b></td>
						<td align="left"><hb><?php echo $seller_products[0][0]['total_products']; ?></b></td>
					</tr>
				</table>
			</td></tr>
		</table>
	</td>
</tr>
<tr><td> &nbsp;</td></tr>

<tr>
	<td>
		<table   align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
			<tr>
				<td>
					<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
					<?php
					if(is_array($allSellerProducts) && count($allSellerProducts>0)){?>
						<tr>
							<!--td  width="25%" class="adminGridHeading" align="left">
								 <?php //echo $paginator->sort('Seller Name', 'VReport.firstname'); ?>
								  <?php //if($paginator->sortKey() == 'VReport.firstname'){     echo $image; }
								?>
							</td-->
							<td  width="18%" class="adminGridHeading" align="left">
								<?php echo $paginator->sort('Business Display Name', 'VReport.business_display_name'); ?>
								  <?php if($paginator->sortKey() == 'VReport.business_display_name'){     echo $image; }
								?>
							</td>
							<td width="11%" class="adminGridHeading" align="center" >
								<?php echo $paginator->sort('Number of Products', 'VReport.totalproduct'); ?>
								  <?php if($paginator->sortKey() == 'VReport.totalproduct'){     echo $image; }
								?>
							</td>
							<!--td width="15%" class="adminGridHeading" align="right" >
								<?php //echo $paginator->sort('Total Rating', 'VReport.totalrating'); ?>
								  <?php //if($paginator->sortKey() == 'VReport.totalrating'){     echo $image; }
								?>
							</td-->
							<td width="13%" class="adminGridHeading" align="center" >Total Rating (%)</td>
							<td width="13%" class="adminGridHeading" align="center" >Refunded Orders (%)</td>
							<td width="13%" class="adminGridHeading" align="center" >Late Shipped Rates (%)</td>
							<td width="15%" class="adminGridHeading" align="center" >Pre-shipped Cancel Rates (%)</td>
							<td  width="11%" class="adminGridHeading" align="center" >Total Orders</td>
							<td  width="8%" class="adminGridHeading" align="center" >Feedbacks</td>
						</tr>
						<?php
						$class= 'rowClassEven';
						foreach ($allSellerProducts as $SellerProducts) {?>
							<tr class="<?php echo $class?>">
								<!--td><b><?php //echo $SellerProducts['VReport']['firstname']." ".$SellerProducts['VReport']['lastname'];?></td-->
								<td><b><?php
									$seller_name=str_replace(array(' ','&'),array('-','and'),html_entity_decode($SellerProducts['VReport']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
									echo $html->link($SellerProducts['VReport']['business_display_name'],'/sellers/'.$seller_name.'/summary/'.$SellerProducts['VReport']['user_id'],array('escape'=>false,'class'=>'bigger-font rate'));
									?>
								</td>
								<td align="right" style="padding-right:10px"><?php echo $SellerProducts['VReport']['totalproduct'];?></td>
								<td align="right" style="padding-right:10px">
									<?php //echo number_format($SellerProducts['VReport']['totalrating'], 2, '.', '');
									if(!empty($totalRating[$SellerProducts['VReport']['user_id']])){
											echo $totalRating[$SellerProducts['VReport']['user_id']];
										}else{
											echo '0.00';	
										}
									?>
								</td>
								<td align="right" style="padding-right:10px">
									<?php
										if(!empty($refundRate[$SellerProducts['VReport']['user_id']])){
											echo $refundRate[$SellerProducts['VReport']['user_id']];
										}else{
											echo '0.00';	
										}
										?>
									</td>
								<td align="right" style="padding-right:10px">
									<?php
										if(!empty($shippedRates[$SellerProducts['VReport']['user_id']])){
											echo $shippedRates[$SellerProducts['VReport']['user_id']];
										}else{
											echo '0.00';	
										}
									?></td>
								<td align="right" style="padding-right:10px">
									<?php
										if(!empty($cancelRates[$SellerProducts['VReport']['user_id']])){
											echo $cancelRates[$SellerProducts['VReport']['user_id']];
										}else{
											echo '0.00';	
										}
									?>
								</td>
									
								<td align="right" style="padding-right:10px">
									<?php
										if(!empty($orderSeller[$SellerProducts['VReport']['user_id']])){
											echo $html->link(count($orderSeller[$SellerProducts['VReport']['user_id']]),'/admin/orders/index/seller/'.$SellerProducts['VReport']['user_id']);
											//echo count($orderSeller[$SellerProducts['VReport']['user_id']]);
										}else{
											echo '0';	
										}
									?>
								</td>
								
								<td align="right" style="padding-right:10px">
									<?php
										if(!empty($orderSellerFeedback[$SellerProducts['VReport']['user_id']])){
											echo $html->link(count($orderSellerFeedback[$SellerProducts['VReport']['user_id']]),'/sellers/feedback/'.$SellerProducts['VReport']['user_id'],array('target'=>'_blank'));
										}else{
											echo '0';	
										}
									?>
								</td>
							</tr>
						<?php }?>
						<tr>
							<td colspan="8"> <?php
								/************** paging box ************/
								echo $this->element('admin/paging_box');
								?>
								</td>
						</tr>
					<?php } else {?>
						<tr>
							<td colspan="8" align="center">No record found</td>
						</tr>
					<?php } ?>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>