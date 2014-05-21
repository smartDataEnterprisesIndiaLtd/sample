<?php ?>
<tr>
	<td align="right" width="20%"><span class="error_msg">*</span> Artist :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.artist_name',array('maxlength'=>'80','size'=>30,'class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>	
	<td align="right"><span class="error_msg">*</span> Label :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.label',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
		
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg">*</span> Format :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.format',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg">*</span> Rated :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.rated',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg"></span> Number of Discs :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.number_of_disk',array('maxlength'=>'20','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>

<tr>
	<td align="right"><span class="error_msg"></span> Track List :</td>
	<td align="left">
		<?php echo $form->input('ProductDetail.track_list',array('id'=>'ProductDetailTrackList', 'rows'=>'10','cols'=>'24','label'=>false)); 
			echo $fck->load('ProductDetail/trackList'); ?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg"></span> Release Date :</td>
	<td align="left"> 
	<?php
	 echo $form->input('ProductDetail.release_date',array(/*'autocomplete'=>'off',*/'type'=>'text','maxlength'=>'15','label'=>false,'div'=>false,'class'=>'textbox-s',/*'readonly'=>'readonly'*/));
	//echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].ProductDetailReleaseDate,'mm-dd-yyyy',this)"));
	 ?>
	 <?php //echo $form->input('ProductDetail.release_date',array('maxlength'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>

