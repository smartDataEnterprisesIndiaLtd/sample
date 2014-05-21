<?php ?>
<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="adminBox">
		<tr>
			<td  align="left" width="20%" >Form: <?php echo  $sDateTime; ?> To: <?php echo $eDateTime ?></td>
		</tr>
</table>
<?php if(isset($allVisitDepartment) && is_array($allVisitDepartment) && count($allVisitDepartment) > 0){?>
	<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		<tr>
			<td align="left" class="adminGridHeading" width="30%" >Department Name </td>
			<td class="adminGridHeading" align="center" width="30%" >Number of Visits </td>
		</tr>
		<?php
			$class= 'rowClassEven';
		foreach ($allVisitDepartment as $allVisitDepartment) {
			$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		?>
		<tr class="<?php echo $class?>">
			<td align="left"><?php  echo $html->link($allVisitDepartment['Department']['name'],array('controller'=>'reports','action'=>'admin_most_viewed_category/'.$allVisitDepartment['DepartmentVisit']['department_id']),array('escape'=>false));?></td>
			<td align="center"><strong><?php  echo $allVisitDepartment['0']['total_visits'];?></strong></td>
		</tr>
		<?php }?>
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
</td></tr></table>