<?php $javascript->link(array('jquery-1.3.2.min'), false); ?>
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
	$this->Html->addCrumb(@$dept_info['Department']['name'],'/admin/nventory_category/'.$dept_info['Department']['id']);
	if(!Empty($finalArr)){
		foreach($finalArr as $cate_id => $crum_element){
			$this->Html->addCrumb($crum_element,'/admin/reports/inventory_category/'.$department_id.'/'.$cate_id);
		}
	}
	echo $this->Html->getCrumbs();
?>
</td></tr>
<tr><td> &nbsp;</td></tr>
<tr><td>
<?php 
if(isset($all_cate) && is_array($all_cate) && count($all_cate) > 0) { ?>
	<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		<tr>
			<td align="left" class="adminGridHeading" width="30%" >Acategory Name </td>
			<td class="adminGridHeading" align="center" width="30%" >Number of Products </td>
		</tr>
		<?php
			$class= 'rowClassEven';
		foreach ($all_cate as $cate) {
			$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		?>
		<tr class="<?php echo $class?>">
			<?php 
				$is_sub_cates = 0;
				$is_sub_cates = $common->getSubCategories($cate['Category']['id']);
			?>
			<td align="left"><?php if(!empty($is_sub_cates)) { echo $html->link($cate['Category']['cat_name'],'/admin/reports/inventory_category/'.$cate['Category']['department_id'].'/'.$cate['Category']['id']);} else { echo $cate['Category']['cat_name']; } ?></td>
			<td align="center"><strong><?php   echo $cate['Category']['pr_count'];  ?></strong></td>
		</tr>
		<?php } ?>
	</table>
<?php } else { ?>
	<table width="100%" cellpadding="2" cellspacing="0" border="0" class="adminBox">
		<tr>
			<td align="center">No record found</td>
		</tr>
	</table>
<?php } ?>
</td></tr></table>