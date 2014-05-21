<?php
if($paginator->sortDir() == 'asc'){
	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>''));
}
else if($paginator->sortDir() == 'desc'){
	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>''));
}
else{
	$image = '';
}
?>
<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
	<?php if(!empty($seller_payment_info)){
	?>
	<tr>
		<td class="adminGridHeading" align="left" width="20%">
			<?php echo $paginator->sort('Date', 'PaymentReport.created');?>
			<?php if($paginator->sortKey() == 'PaymentReport.created'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="left">
			Account Number
		</td>
		<td align="center" class="adminGridHeading" width="10%">
			Report
		</td>
	</tr>
	<?php
	
	$class= 'rowClassEven';
	foreach ($seller_payment_info as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		?>
		<tr class="<?php echo $class?>">
			<td align="left" >
				<?php 
				if(!empty($row['PaymentReport']['created'])){
					echo date(DATE_FORMAT,strtotime($row['PaymentReport']['created']));
				} else { echo '-';}
				?>
			</td>
 			<td align="left">
				<?php 
				if(!empty($row['PaymentReport']['account_info'])){
					echo $row['PaymentReport']['account_info'];
				} else { echo '-';}?>
			</td>
			<td align="center">
				<?php echo $html->link('Report','/sellers/download_paymentreport_files/'.$row['PaymentReport']['report_name'],array('escape'=>false));?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr>
	<td colspan="7" style="padding-left:7px;" ></td>
		<?php
		/************** paging box ************/
		echo $this->element('admin/paging_box');
		?>
	</tr>

	<?php } else {?>
		<tr>
			<td colspan="4" align="center">No record found</td>
		</tr>
	<?php } ?>
</table>