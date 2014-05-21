<?php
echo $javascript->link(array('jquery-1.3.2.min'), false);
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
?>
<?php echo $form->create('Reports',array('action'=>'marketplace','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));?>
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
					if(!empty($earningSellers)){?>
						<tr>
							<td  width="5%" class="adminGridHeading" align="center" style="padding-right:0px">Position</td>
							<td  width="30%" class="adminGridHeading" align="left">Seller Name</td>
							<td  width="40%" class="adminGridHeading" align="left">Business Display Name</td>
							<td class="adminGridHeading" align="right" >Amount <?php echo CURRENCY_SYMBOL; ?></td>
						</tr>
						<?php
						$class= 'rowClassEven';
						foreach ($allSellerProducts as $key=>$allSellerProducts) {
							$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
							$seller_id = $allSellerProducts['ProductSeller']['seller_id'];
							$sellerInfo = $this->Common->getsellerInfo($seller_id);?>
							<tr class="<?php echo $class?>">
								<td align="center"><b><?php echo $key+1; ?></td>
								<td><b><?php echo $sellerInfo['User']['firstname']." ".$sellerInfo['User']['lastname']; ?></td>
								<td><b><?php echo $sellerInfo['Seller']['business_display_name']; ?></td>
								<td align="right" style="padding-right:10px">
									
								<?php echo $allSellerProducts[0]['total_product'];?></td>
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
					<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
					<?php
					if(!empty($earningSellers)){?>
						<tr>
							<td  width="5%" class="adminGridHeading" align="center" style="padding-right:0px">Position</td>
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
								<td align="center"><b><?php echo $key+1; ?></td>
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