<?php $this->Html->addCrumb('Reports & Statistics', '/admin/reports/financial_accounting');
	$this->Html->addCrumb('Total Outstanding', 'javascript:void(0)');  ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
<tr>
<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
<td class="adminGridHeading" height="25px" align="right">
</td>
</tr>
<tr>
<td colspan="2">
<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
<tr >
<td height="20"></td>
</tr>
<tr>
<td>
<table width="100%" cellspacing="1" cellpadding="2"  align="center" border="0">
	<tr>
		<td>
		<table width="100%" cellspacing ="1" cellpadding = "3" border = "0">
			<tr class="rowClassEven">
				<td width="20%" align="left" class="heading-text">Total sales  </td>
				<td align="left" class="heading-text-16">: <?php echo CURRENCY_SYMBOL.' '.$format->money($total_sales_amount,2); ?></td>
			</tr>
			<tr class="rowClassOdd">
				<td  align="left" class="heading-text">Total credited </td>
				<td align="left" class="heading-text-16">: <?php echo CURRENCY_SYMBOL.' '.$format->money($total_credited_amount,2); ?>
				</td>
			</tr>
			<tr class="rowClassEven">
				<td  align="left" class="heading-text">Total consumed </td>
				<td align="left" class="heading-text-16">: <?php echo CURRENCY_SYMBOL.' '.$format->money($total_used_amount,2); ?>
				</td>
			</tr>
			<tr class="rowClassOdd">
				<td  align="left" class="heading-text">Total out standing </td>
				<td align="left" class="heading-text-16">: <?php echo CURRENCY_SYMBOL.' '.$format->money(($total_sales_amount - $total_used_amount),2); ?>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>