<?php
$this->Html->addCrumb('Seller Management', ' ');
$this->Html->addCrumb('Manage Payment Reports', 'javascript:void(0)');
$paginator->options(array('update'=>'pagging'));

//echo $javascript->link(array('jquery-1.3.2.min'), false);
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
$showArr = array();
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $title_for_layout;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			<?php echo $html->link("Back",array("controller"=>"sellers","action"=>"admin")); ?>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Search Reports</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td colspan="2">
									<?php echo $form->create('Seller',array("action"=>"payment_summary/$seller_id", "id"=>"frmSeller", "name"=>"frmSeller"));?>

									<table cellspacing="1" cellpadding="1" align="left" border="0">
										<tr>
											<td align="left">From : </td>
											<td>
												<?php echo $form->input('Search.start_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox','onFocus'=>"displayCalendar(document.forms[0].SearchStartDate,'dd/mm/yyyy',this)"));?> &nbsp;<?php
												echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].SearchStartDate,'dd/mm/yyyy',this)")); ?>
											</td>
											<td align="left">To : </td>
											<td>
												<?php echo $form->input('Search.end_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20' ,'label'=>false,'div'=>false,'class'=>'textbox','onFocus'=>"displayCalendar(document.forms[0].SearchEndDate,'dd/mm/yyyy',this)"));?> &nbsp;<?php
													echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].SearchEndDate,'dd/mm/yyyy',this)"));?>
											</td>
											<td style="padding-left:20px;">
												<?php echo $form->submit('Search',array('alt'=>'Next','width'=>'38','height'=>'31','border'=>'0', "value"=>"search",'class'=>'btn_53'))?>
											</td>
										</tr>
									</table>
									<?php echo $form->end();?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php if(!empty($seller_info)) {?>
	<tr><td colspan="2">&nbsp;</td></tr><tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Seller Information</td><td class="reportListingHeading" width="25%"> <?php echo $html->link('Add a penalty','/admin/sellers/penalty/'.$seller_id,array('escape'=>false)); ?> &nbsp; &nbsp; <?php echo $html->link('Upload Report','/admin/sellers/upload_paymentsummary',array('escape'=>false)); ?>
				</tr>
				<tr>
					<td colspan ="2">
						<table width="100%" cellspacing="0" cellpadding="0" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<table width="100%" cellspacing="3" cellpadding="3" align="center" border="0" style="background:#F1F1F1;margin-top:10px">
										<tr>
											<td align="left" width ="10%">Seller Name : </td>
											<td width="15%">
												<?php echo @$seller_info['User']['title'].' '.@$seller_info['User']['firstname'].' '.@$seller_info['User']['lastname'];?>
											</td>
											<td align="left" width = "15%">Business Display Name : </td>
											<td>
												<?php echo @$seller_info['Seller']['business_display_name']; ?>
											</td>
										</tr>
										<tr>
											<td align="left">Seller Account : </td>
											<td >
												<?php
												if(!empty($seller_info['Seller']['bank_account_number']) ){
													echo ucwords(@$seller_info['Seller']['bank_account_number']);
												}else{
													echo ucwords(@$seller_info['Seller']['paypal_account_mail']);
												}
												?>
											</td>
											<td align="left" > </td>
											<td >
												
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
	<tr><td colspan="2">&nbsp;</td></tr>
	<?php }?>
 	<tr>
		<td colspan="2" valign="top" id="pagging">

			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td >					
						<table   align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
							<tr>
								<td colspan="2" id = 'listing'>
									<?php echo $this->element('admin/paymentreports_listing');?>
								</td>
							</tr>
						</table>
						 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<!-- Legends -->
			</table>
		</td>		
	</tr>

</table>
