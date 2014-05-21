<?php ?>
<tr>
	<td align="right" width="20%"><span class="error_msg"></span> Starring :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.star_name',array('maxlength'=>'2000','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>	
	<td align="right"><span class="error_msg"></span> Directed By :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.directedby',array('maxlength'=>'2000','class'=>'textbox-m','label'=>false,'div'=>false));?>
		
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg">*</span> Format :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.format',array('maxlength'=>'2000','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg"></span> Number of Discs :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.number_of_disk',array('maxlength'=>'20','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg">*</span> Rated :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.rated',array('maxlength'=>'2000','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg">*</span> Language :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.language',array('maxlength'=>'2000','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg">*</span> Studio :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.studio',array('maxlength'=>'2000','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg"></span> Release Date :</td>
	<td align="left">
	<?php
	 echo $form->input('ProductDetail.release_date',array(/*'autocomplete'=>'off',*/'type'=>'text','maxlength'=>'15','label'=>false,'div'=>false,'class'=>'textbox-s'));
	// echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].ProductDetailReleaseDate,'mm-dd-yyyy',this)"));
	 ?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg"></span> Run Time :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.run_time',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>


 