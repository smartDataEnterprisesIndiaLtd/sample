<?php //echo $javascript->link(array('jquery-1.3.2.min'), false);
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');

echo $form->create('',array('action'=>'penalty/'.$seller_id, 'method'=>'POST','name'=>'frmPaymentPenalty','id'=>'frmPaymentPenalty', 'enctype'=>'multipart/form-data' ));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td class="adminGridHeading heading"  height="25px" align="right"></td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
				<tr height="20px">
					<td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="error_msg">*</span> Reason :</td>
					<td>
						<?php  echo $form->input('PaymentPenalty.reason',array('autocomplete'=>'off','type'=>'text', 'size'=>'20','maxlength'=>'200', 'label'=>false,'div'=>false,'class'=>'textbox-l'));?>
					</td>
				</tr>
				
				<tr>
					<td align="right" valign="top"><span class="error_msg">*</span> Date :</td>
					<td>
						<?php  echo $form->input('PaymentPenalty.from_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20', 'value'=>date('Y-m-d'), 'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));  //echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].OrderItemStartDate,'dd-mm-yyyy',this)"));?>
					</td>
				</tr>
				
				<tr>
					<td align="right" valign="top"><span class="error_msg">*</span> Fees :</td>
					<td>
						<?php  echo $form->input('PaymentPenalty.fees',array('autocomplete'=>'off','type'=>'text', 'size'=>'20','maxlength'=>'10', 'label'=>false,'div'=>false,'class'=>'textbox-l'));?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="left">
					<?php 
					echo $form->button('Add Penalty',array('type'=>'submit','class'=>'btn_53','div'=>false));
					?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $form->end(); ?>