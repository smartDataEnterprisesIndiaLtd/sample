<?php ?>
<tr>	
	<td align="right" width="20%"><span class="error_msg">*</span> Suitable For :</td>
	<td>
		<?php echo $form->input('ProductDetail.suitable_for',array('maxlength'=>'2000', 'class'=>'textbox-m','label'=>false,'div'=>false));?>
		
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg"></span> How to Use :</td>
	<td>
		<?php echo $form->input('ProductDetail.how_to_use',array('maxlength'=>'2000','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg">*</span> Hazards & Cautions :</td>
	<td>
		<?php echo $form->input('ProductDetail.hazard_caution',array('maxlength'=>'2000','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>

<tr>
	<td align="right"><span class="error_msg">*</span> Precautions :</td>
	<td>
	<?php echo $form->input('ProductDetail.precautions',array('maxlength'=>'2000','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right" ><span class="error_msg">*</span> Ingredients :</td>
	<td>
	<?php echo $form->input('ProductDetail.ingredients',array('maxlength'=>'2000','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
