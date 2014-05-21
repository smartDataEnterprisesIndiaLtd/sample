<?php 
$this->Html->addCrumb('Reports & Statistics', '/admin/reports/financial_accounting');
	$this->Html->addCrumb(' Inventory', 'javascript:void(0)'); ?>
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" height="20px" align="right"><?php //$total_inventory; ?>
		</td>
	</tr>
	<tr><td colspan="2">
		<table align="center" width="99%" border="0" cellpadding="0" cellspacing="4" valign="top">
		<tr>
			<td   align="left" colspan="2"><h3>Total Number of Products on website :
			<?php echo $total_active_products+$total_inactive_products;?></h3></td>
		</tr>
		<tr>
			<td width="15%" align="left"><b>Active  : </b></td>
			<td align="left"><b><?php echo $total_active_products;?></b></td>
		</tr>
		<tr>
			<td   align="left"><b>Inactive : </b></td>
			<td align="left"><b><?php echo $total_inactive_products ;?></b></td>
		</tr>
		</table>
	</td></tr>
</table>
</td></tr>
<tr><td> &nbsp;</td></tr>
<tr><td>
<?php 
if(isset($departments) && is_array($departments) && count($departments) > 0){?>
	<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		<tr>
			<td align="left" class="adminGridHeading" width="30%" >Department Name </td>
			<td class="adminGridHeading" align="center" width="30%" >Number of Products </td>
		</tr>
		<?php
			$class= 'rowClassEven';
		foreach ($departments as $department) {
			$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		?>
		<tr class="<?php echo $class?>">
			<td align="left"><?php echo $html->link(@$department['name'],'/admin/reports/inventory_category/'.@$department['id'],array('escape'=>false));  ?></td>
			<td align="center"><strong><?php   echo $department['products'];  ?>	</strong></td>
		</tr>
		<?php }?>
	</table>
<?php }else{ ?>
	<table width="100%" cellpadding="2" cellspacing="0" border="0" class="adminBox">
		<tr>
			<td align="center">No record found</td>
		</tr>
	</table>
<?php } ?>
</td></tr></table>