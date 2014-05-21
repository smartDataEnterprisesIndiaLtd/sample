<?php

$this->Html->addCrumb('Promotions', '/admin/certificates');
if(!empty($id)){
	$this->Html->addCrumb('Update Coupon', 'javascript:void(0)');
}else{
	$this->Html->addCrumb('Add Coupon', 'javascript:void(0)');
}
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');

echo $form->create('Coupon',array('action'=>'add/'.$id,'method'=>'POST','name'=>'frmCoupon','id'=>'frmCoupon'));
echo $javascript->link('fckeditor');
?>	
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td height="25" align="right"> 
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="adminBox">
				<tr height="20px">
					<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<tr>
					<td align="right" width="20%"><span class="error_msg">*</span> Coupon Name</td><td style="width:5px" valign="top"> : </td>
					<td>
						<?php echo $form->input('Coupon.name',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
					</td>
				</tr>
				<tr>
					<td align="right" width="20%" valign="top">Code</td><td style="width:5px" valign="top"> : </td>
					<td>
						<?php echo $form->input('Coupon.discount_code',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false,'readonly'=>'readonly'));?>
					</td>
				</tr>
				<tr>
					<td align="right" width="20%"><span class="error_msg">*</span> Tax Class</td><td style="width:5px" valign="top"> : </td>
					<td>
						<?php echo $form->select('Coupon.taxclass',array('1'=>'Yes','0'=>'No'),null,array('type'=>'select','class'=>'textbox-s ','label'=>false,'div'=>false,'size'=>1),'--Select--'); echo $form->error('Coupon.taxclass'); ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" width="20%" ><span class="error_msg">*</span> Discount Options</td><td style="width:5px" valign="top"> : </td>
					<td>
						<table width ="100%" border="0"><tr><td width="22%">
						<?php
						$options=array('1'=>' Specific Amount Off </td><td>'.$form->input('Coupon.specific_amount_off',array('size'=>'30','class'=>'textbox-s','label'=>false,'div'=>false,'onChange'=>'cpnAmtOff("CouponDiscountOption1",this.value)')).'</td></tr><tr><td>','2'=>' Percent Off </td><td>'.$form->input('Coupon.percent_off',array('size'=>'30','class'=>'textbox-s','label'=>false,'div'=>false,'onChange'=>'cpnAmtOff("CouponDiscountOption2",this.value)')).' %</td></tr><tr><td colspan=\'2\'>','3'=> ' Free Shipping ( Shipping not charged if checked. )</td></tr></table>');
						$attributes=array('legend'=>false,'label'=>false,'class'=>'','onClick'=>'changeRestrictions(this.value)');
						echo $form->radio('Coupon.discount_option',$options,$attributes); echo $form->error('Coupon.discount_option');?>
						<span id="discount-option"></span>
					</td>
				</tr>
				<tr class="adminGridHeading heading">
					<td colspan="3"><strong>Expiration Options</strong></td>
				</tr>
				<tr>
					<td align="right" width="25%"><span class="error_msg">*</span> Number Of Times Coupon <br>Can Be Used</td><td style="width:5px" valign="top"> : </td>
					<td><?php echo $form->input('Coupon.used_times',array('size'=>'30','class'=>'textbox-s','label'=>false,'div'=>false));?><span style="font-size:10px">(0 (Zero) means unlimited)</span><?php echo $form->hidden('Coupon.id',array('size'=>'30','class'=>'textbox-s','label'=>false,'div'=>false));?>
					</td>
				</tr>
				<tr>
					<td align="right" width="20%" valign="top"><span class="error_msg">*</span> Expires On</td><td style="width:5px" valign="top"> : </td>
					<td>
						<?php
						echo $form->input('Coupon.expiry_date',array('autocomplete'=>'off','type'=>'text','size'=>'15','label'=>false,'div'=>false,'class'=>'textbox-s','readonly'=>'readonly'));
						echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].CouponExpiryDate,'dd/mm/yyyy',this)"));
						?>
					</td>
				</tr>
				<tr class="adminGridHeading heading">
					<td colspan="3"><strong>Use Restrictions</strong></td>
				</tr>
				<tr>
					<td align="right" width="20%" valign="top"><span class="error_msg">*</span> Customer use limit</td><td style="width:5px" valign="top"> : </td>
					<td>
						<table width ="100%" border="0"><tr><td>
						<?php
						$options=array('0'=>' Unlimited </td></tr><tr><td>','1'=>' Once per customer</td></tr></table>');
						$attributes=array('legend'=>false,'label'=>false,'class'=>'');
						echo $form->radio('Coupon.cust_use_limit',$options,$attributes); echo $form->error('Coupon.cust_use_limit'); ?>
					</td>
				</tr>
				<tr>
					<td align="right" width="20%" valign="top"><span class="error_msg">*</span> Order limit</td><td style="width:5px" valign="top"> : </td>
					<td>
						<table width ="100%" border="0"><tr><td colspan="2">
						<?php
						$options=array('1'=>' No Limit </td></tr><tr><td width="40%">','2'=>' Valid on orders over this amount</td><td> '.$form->input('Coupon.orderlimit_amount',array('size'=>'30','class'=>'textbox-s','onChange'=>'orderLimit(this.value);','label'=>false,'div'=>false)).'</td></tr></table>');
						$attributes=array('legend'=>false,'label'=>false,'class'=>'');
						echo $form->radio('Coupon.order_limit',$options,$attributes); echo $form->error('Coupon.order_limit'); ?>
					</td>
				</tr>
				<tr id="restrictions">
					<?php //if(!empty($id)) {
						if(!empty($this->data['Coupon']['discount_option'])) {
							if($this->data['Coupon']['discount_option'] == 3) {
							} else{
								echo $this->element('admin/restictions');
							}
						} else{
							echo $this->element('admin/restictions');
						}
					/*} else {
						echo $this->element('admin/restictions');
					}*/ ?>
				</tr>
				<tr id="restrictions1">
					<?php //if(!empty($id)) {
						if(!empty($this->data['Coupon']['discount_option'])) {
							if($this->data['Coupon']['discount_option'] == 3) {
							} else{
								echo $this->element('admin/restictions1');
							}
						} else{
							echo $this->element('admin/restictions1');
						}
					/*} else {
						echo $this->element('admin/restictions1');
					}*/ ?>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="center"></td><td style="width:5px"></td>
					<td align="left">
						<?php
							
						if(empty($id))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";
						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));
						echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/coupons')"));?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>
<?php
echo $form->end();
?>

<script type="text/javascript">
	<?php if(!empty($this->data['Coupon']['discount_option'])) { 
		
		?>
		var res_val = <?php echo $this->data['Coupon']['discount_option'];?>;
		if(res_val != '' || res_val != 0){
			
			changeRestrictions(res_val);
		}
	<?php } ?>
	
	function changeRestrictions(valu){

		if(valu == 3){
			jQuery('#restrictions').hide();
			jQuery('#restrictions1').hide();
		} else {
			
			jQuery('#restrictions').show();
			jQuery('#restrictions1').show();
		}
	}

	function orderLimit(orderLimitAmount){
		if(orderLimitAmount != ''){
			jQuery('#CouponOrderLimit2').attr("checked","checked");
		} else{
			jQuery('#CouponOrderLimit1').attr("checked","checked");
		}
	}

	function cpnAmtOff(radioid,valueIs){

		if(radioid != ''){
			if(valueIs != '')
				jQuery('#'+radioid).attr("checked","checked");
			else
				jQuery('#CouponDiscountOption3').attr("checked","checked");
		}/* else{
			jQuery('#CouponDiscountOption3').attr("checked","checked");
		}*/
	}
</script>