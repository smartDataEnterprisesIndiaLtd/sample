<?php
$this->Html->addCrumb('Reports & Statistics', '/admin/reports/financial_accounting');
	$this->Html->addCrumb('Total Sales', 'javascript:void(0)'); 
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
?>
<?php echo $form->create('Certificate',array('action'=>'total_sales','method'=>'POST','name'=>'frmUser','id'=>'frmUser'));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td>
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
				<tr>
					<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
					<td class="adminGridHeading" height="25px" align="right"></td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0" class="adminBox">
							<tr><td colspan="4">&nbsp;</td></tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td align="center" width="30%">
									<?php echo $form->select('Certificate.month', $month_arr, null, array('type'=>'select','class'=>'textbox-l','label'=>false,'div'=>false,'size'=>1), '-- Month--');?>
										<br>
										<?php echo $form->error('Certificate.month'); ?>
								</td>
								<td valign="top" width="30%">
									<?php echo $form->select('Certificate.year', $year_arr, date("Y"), array('type'=>'select','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1), '-- Year --');?>
										<br>
										<?php echo $form->error('Certificate.year'); ?>
								</td>
								<td valign="top" align="left">
									<?php echo $form->submit('Submit',array('type'=>'submit','class'=>'btn_53','div'=>false)); ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" class="adminBox">
				<?php if(!empty($total_sales)){?>
				<tr>
					<td  width="20%" class="adminGridHeading" align="left"></td>
					<td class="adminGridHeading" align="left" ></td>
				</tr>
				<?php
				$class= 'rowClassEven';
				foreach ($total_sales as $month=>$amount) {
					$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven'; ?>
				<tr class="<?php echo $class?>" style="line-height:20px;">
					<td style="padding-left:5px">
						<b><?php echo $month; ?></b>
					</td>
					<td>
						<?php echo CURRENCY_SYMBOL.' '.$format->money($amount,2); ?>
					</td>
				</tr>
				<?php } ?>
				<?php } else {?>
				<tr>
					<td colspan="2" align="center">No record found</td>
				</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
</table>
<?php echo $form->end();?>