<?php
echo $javascript->link('selectAllCheckbox'); 
$add_url_string="/keyword:".$keyword."/searchin:".$fieldname;
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
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td colspan = "2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
			<?php if(isset($refunded_orders) && is_array($refunded_orders) && count($refunded_orders) > 0){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
					<?php
					echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
					echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
					?>
					<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
						<tr>
							<td width="100%" colspan="6" style="text-align:right">
							<?php //echo "Total Redunded Order : " .$totalRefundedOrders;?>
							<?php echo "Total Returned Orders: " .$this->Paginator->counter(array('format' => __('%count%', true)));?>
							</td>
						</tr>
						<tr>
							<td  align="center" width="100%" colspan="6">
							<?php
							/************** paging box ************/
							echo $this->element('admin/paging_box');
							?>
							</td>
						</tr>
						<tr>
							<td class="adminGridHeading" width="20%"  align="center">
								<?php echo $paginator->sort('Date/Time of Order', 'Order.created'); ?>
								<?php if($paginator->sortKey() == 'Order.created'){ echo $image; } ?>
							</td>
							<td align="center" class="adminGridHeading" width="20%" >
								<?php echo $paginator->sort('Order ID', 'Order.order_number'); ?>
								<?php if($paginator->sortKey() == 'Order.order_number'){ echo $image; } ?>
							</td>
							<td class="adminGridHeading" width="20%" >
								<?php //echo $paginator->sort('Sellers Name', 'SellerSummary.firstname'); ?>
								<?php //if($paginator->sortKey() == 'SellerSummary.firstname'){  echo ' '.$image; }?>
								<?php echo $paginator->sort('Sellers Name', 'Seller.business_display_name'); ?>
								<?php if($paginator->sortKey() == 'Seller.business_display_name'){  echo ' '.$image; }?>
							</td>
							<td class="adminGridHeading" width="20%" >
								<?php echo $paginator->sort('Customers Name', 'UserSummary.firstname'); ?>
								<?php if($paginator->sortKey() == 'UserSummary.firstname'){ echo ' '.$image; }?>
							</td>
							<td class="adminGridHeading" align="center" width="10%" >
								<?php echo $paginator->sort('Refunded Amount', 'OrderRefund.amount'); ?>
								<?php if($paginator->sortKey() == 'OrderRefund.amount'){ echo ' '.$image; }?>
							</td>
							<td class="adminGridHeading" align="center" width="16%" >
								<?php echo $paginator->sort('Refunded Date', 'OrderRefund.created'); ?>
								<?php if($paginator->sortKey() == 'OrderRefund.created'){ echo ' '.$image; }?>
							</td>
						</tr>
						<?php
						$class= 'rowClassEven';
						foreach ($refunded_orders as $refunded_order) {
						$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';?>
						<tr class="<?php echo $class; ?>" >
							<td align="center">
								<?php if(!empty($refunded_order['Order']['created'])) echo date(DATE_TIME_FORMAT,strtotime($refunded_order['Order']['created'])); ?>
							</td>
							<td align="center">
							<?php if(!empty($refunded_order['Order']['order_number'])) echo $html->link($refunded_order['Order']['order_number'],'/admin/orders/order_detail/'.$refunded_order['Order']['id'],array('escape'=>false)); ?>
							</td>
							<td >
							<?php if(!empty($refunded_order['Seller']['business_display_name'])) echo $refunded_order['Seller']['business_display_name']; ?>
							<?php //if(!empty($refunded_order['SellerSummary']['lastname'])) echo $refunded_order['SellerSummary']['lastname']; ?>
							</td>
							<td >
								<?php if(!empty($refunded_order['UserSummary']['firstname'])) echo $refunded_order['UserSummary']['firstname']; ?> <?php if(!empty($refunded_order['UserSummary']['lastname'])) echo $refunded_order['UserSummary']['lastname']; ?>
							</td>
							<td align="center">
							<?php if(!empty($refunded_order[0]['total_refunded_amount'])) echo CURRENCY_SYMBOL.$format->money($refunded_order[0]['total_refunded_amount'],2); ?>
							</td>
							<td align="center">
							<?php if(!empty($refunded_order['OrderRefund']['created'])) echo date('d-m-Y H:i:s',strtotime($refunded_order['OrderRefund']['created'])); ?>
							</td>
						</tr>
						<?php }?>
						<tr>
							<td  align="center" width="100%" colspan="6">
							<?php
							/************** paging box ************/
							echo $this->element('admin/paging_box');
							?>
							</td>
						</tr>
					</table>
					</td>
				</tr>
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
</table>