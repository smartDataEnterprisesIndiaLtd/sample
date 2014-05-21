<?php
 $this->Html->addCrumb('Website Settings', 'javascript:void(0)');
     $this->Html->addCrumb('Settings', 'javascript:void(0)');
 //echo $javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
<?php echo $form->create('Setting',array('action'=>'index','method'=>'POST','name'=>'frmSetting','id'=>'frmSetting'));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
<tr>
<td valign="top">
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr class="adminBoxHeading reportListingHeading">
	<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
	<td class="adminGridHeading"></td>
</tr>
<tr>
<td colspan="2">
	<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
		<tr height="20px">
			<td class="error_msg" colspan="4" align="left"><!--Fields marked with an asterisk (*) are required.--></td>
		</tr>
		<?php
		if(!empty($all_settings)) {
		foreach($all_settings as $field_name=>$type) {

			if($field_name == 'id' || $field_name =='currency_name'){ } else {
			
			$fld_clean_name = ucfirst(str_replace('_',' ',$field_name));
			?>
		<tr>
			<td align="right" width="20%"><!--<span class="error_msg">*</span>--> <?php echo $fld_clean_name; ?> :</td>
			<td>
				<?php
				
				if( $field_name == 'website_home_location'){ // for website home location display the country list 
					echo $form->select('Setting.'.$field_name, $destinationCuntries, null, array('type'=>'select','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1), 'Select location country');
					echo $form->error('Setting.'.$field_name);
				}else{
					echo $form->input('Setting.'.$field_name,array('size'=>'30','class'=>'textbox-s','label'=>false,'div'=>false));
				}
				?>
				
				<?php
				if(strtoupper($fld_clean_name) == 'TAX'){
					echo "%";
				}?>
			</td>
		</tr>
		<?php } } }?>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td >&nbsp;</td>
			<td >
			<?php echo $form->submit('Submit',array('type'=>'submit','class'=>'btn_53','div'=>false));?>
			</td><td>&nbsp;</td>
		</tr>
	</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<?php 
echo $form->end();
?>