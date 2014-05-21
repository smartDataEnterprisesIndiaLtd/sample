<?php ?>
<tr>
	<td align="right" width="20%"><span class="error_msg">*</span> Platform :</td>
	<td>
		<?php echo $form->input('ProductDetail.plateform',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>	
	<td align="right"><span class="error_msg">*</span> Rated :</td>
	<td>
		<?php echo $form->input('ProductDetail.rated',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
		
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg"></span> Release Date :</td>
	<td>
		<?php
			echo $form->input('ProductDetail.release_date',array(/*'autocomplete'=>'off',*/'type'=>'text','maxlength'=>'15','label'=>false,'div'=>false,'class'=>'textbox-s'));
			//echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].ProductDetailReleaseDate,'yyyy-mm-dd',this)"));
		?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg">*</span> Region :</td>
	<td>
		<?php echo $form->input('ProductDetail.region',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right">Media Storage Capacity :</td>
	<td>
		<?php echo $form->input('ProductDetail.media_storage_capacity',array('maxlength'=>'100','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
