<script type="text/javascript" language="javascript">	
jQuery(document).ready(function(){
	// displayState();
	
});
</script>

<?php echo $form->create('Setting',array('action'=>'add_delivery_destination','method'=>'POST','name'=>'frmUser','id'=>'frmUser'));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
<tr>
<td valign="top">
<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0">
<tr class="adminBoxHeading reportListingHeadsfdsfsaing">
	<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
	<td class="adminGridHeading heading"  height="25px" align="right">
		
	</td>
</tr>
<tr>
	<td colspan="2">
		<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
			<tr height="2">
				<td width="20%" align="right"></td>
				<td width="" align="left"></td>
			</tr>
			<tr height="20px">
				<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
			</tr>

			<tr>
				<td align="right" valign="top"><span class="error_msg">*</span> Dispatch Country :</td>
				<td>
				 <?php echo $form->select('DeliveryDestination.country_from',$countries,null,array('escape'=>false, 'type'=>'select','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1) ,'Select Country..' ); 
				echo $form->error('DeliveryDestination.country_from'); ?>
				</td>
				
			</tr>
			<tr>
				<td align="right" valign="top"><span class="error_msg">*</span> Destination Country :</td>
				<td>
				 <?php echo $form->select('DeliveryDestination.country_to',$countries,null,array('escape'=>false, 'type'=>'select','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1) ,'Select Country..' ); 
				echo $form->error('DeliveryDestination.country_to'); ?>
				</td>
				
			</tr>
			<tr>
				<td align="right" valign="top"><span class="error_msg">*</span> Standard Dispatch Time :</td>
				<td>
					<?php echo $form->input('DeliveryDestination.sd_dispatch',array('class'=>'textbox-s','label'=>false,'div'=>false));?>
				</td>
			</tr>
			   <tr>
				<td align="right" valign="top"><span class="error_msg">*</span> Expedited Dispatch Time :</td>
				<td>
					<?php echo $form->input('DeliveryDestination.ex_dispatch',array('class'=>'textbox-s','label'=>false,'div'=>false));?>
				</td>
			</tr>
			    <tr>
				<td align="right" valign="top"><span class="error_msg">*</span> Standard Delivery Time :</td>
				<td>
					<?php echo $form->input('DeliveryDestination.sd_delivery',array('class'=>'textbox-s','label'=>false,'div'=>false));?>
				</td>
			</tr>
			     <tr>
				<td align="right" valign="top"><span class="error_msg">*</span> Expedited Delivery Time :</td>
				<td>
					<?php echo $form->input('DeliveryDestination.ex_delivery',array('class'=>'textbox-s','label'=>false,'div'=>false));?>
				</td>
			</tr>
			
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td>&nbsp;</td>
				<td align="left">
				<?php if(!empty($this->data['DeliveryDestination']['id'])) {
					echo $form->button('Update',array('type'=>'submit','class'=>'btn_53','div'=>false));
				} else {
					echo $form->button('Add',array('type'=>'submit','class'=>'btn_53','div'=>false));
				}?>
				<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/settings/delivery_destination')"));?>
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>
</td>
</tr>
</table>
<?php 
echo $form->input('DeliveryDestination.id');

echo $form->end();

?>
