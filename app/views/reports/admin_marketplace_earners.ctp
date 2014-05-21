<?php
$this->Html->addCrumb('Reports & Statistics', '/admin/reports/financial_accounting');
	$this->Html->addCrumb('Marketplace Earners', 'javascript:void(0)'); 
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
?>
<?php echo $form->create('Reports',array('action'=>'marketplace_earners','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));?>
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
	<td>
		<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
			<tr>
				<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
				<td class="adminGridHeading" height="25px" align="right">
				</td>
			</tr>			
		</table>
	</td>
</tr>
<tr><td> &nbsp;</td></tr>
<tr>
	<td>
		<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
			<tr class="adminBoxHeading">
				<td height="25" class="reportListingHeading">Search Highest Earning Sellers:</td>
			</tr>
			<tr>
				<td>
					
					<table width="100%" cellspacing="4" cellpadding="2" align="left" border="0" class="adminBox">
						<tr>
							<td width="15%" align="right">Start Date:</td>
							<td align="left" width="25%"><?php
							echo $form->input('Search.start_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-m','readonly'=>'readonly'));
							echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].SearchStartDate,'yyyy-mm-dd',this)"));
							?></td>
							<td width="15%" align="right">End Date:</td>
							<td align="left" width="25%"><?php
							echo $form->input('Search.end_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20' ,'label'=>false,'div'=>false,'class'=>'textbox-m','readonly'=>'readonly'));
							echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].SearchEndDate,'yyyy-mm-dd',this)"));
							?></td>
							<td  align="left"><?php echo $form->submit('Search',array('alt'=>'Next','width'=>'38','height'=>'31','border'=>'0', "value"=>"search",'class'=>'btn_53'))?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr><td> &nbsp;</td></tr>
<tr>
	<td>
		<table   align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
			<tr>
				<td>
				<?php if(!empty($sDateTime) && !empty($eDateTime)){ ?>
				<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="adminBox">
					<tr>
						<td  align="left" width="20%" >Form: <?php echo  $sDateTime; ?> To: <?php echo $eDateTime ?></td>
					</tr>
				</table>
				<?php }?>
					<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
					<?php
					if(!empty($earningSellers)){?>
						<tr>
							<!--<td  width="5%" class="adminGridHeading" align="center" style="padding-right:0px">Position</td>-->
							<td  width="30%" class="adminGridHeading" align="left">Seller Name</td>
							<td  width="40%" class="adminGridHeading" align="left">Business Display Name</td>
							<td class="adminGridHeading" align="right" >Amount <?php echo CURRENCY_SYMBOL; ?></td>
						</tr>
						<?php
						$class= 'rowClassEven';
						foreach ($earningSellers as $key=>$sellerData) {
							$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
							$seller_id = $sellerData['order_items']['seller_id'];
							$sellerInfo = $this->Common->getsellerInfo($seller_id);?>
							<tr class="<?php echo $class?>">
								<!--<td align="center"><b><?php //echo $key+1; ?></td>-->
								<td><b><?php echo $sellerInfo['User']['firstname']." ".$sellerInfo['User']['lastname']; ?></td>
								<td><b><?php echo $sellerInfo['Seller']['business_display_name']; ?></td>
								<td align="right" style="padding-right:10px">
								<?php
								
								$netEarning = $sellerData[0]['earning']- $sellersCancels[$seller_id];
								echo $format->money($netEarning,2);
								unset($netEarning);
								?></td>
							</tr>
						<?php }
					} else {?>
						<tr>
							<td colspan="4" align="center">No record found</td>
						</tr>
					<?php } ?>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>
<?php echo $form->end();?>