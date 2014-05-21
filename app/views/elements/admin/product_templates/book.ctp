<?php ?>
<tr>
	<td align="right" width="20%"><span class="error_msg">*</span> Author :</td>
	<td>
		<?php echo $form->input('ProductDetail.author_name',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>	
	<td align="right"><span class="error_msg">*</span> Publisher :</td>
	<td>
		<?php echo $form->input('ProductDetail.publisher',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
		
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg"></span> Language :</td>
	<td>
		<?php echo $form->input('ProductDetail.language',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg">*</span> ISBN :</td>
	<td>
		<?php echo $form->input('ProductDetail.product_isbn',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg">*</span> Format :</td>
	<td>
		<?php echo $form->input('ProductDetail.format',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg"></span> Pages :</td>
	<td>
		<?php echo $form->input('ProductDetail.pages',array('maxlength'=>'80','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg"></span> Publisher Review :</td>
	<td>
		<?php echo $form->input('ProductDetail.publisher_review',array('id'=>'ProductDetailPublisherReview', 'rows'=>'10','cols'=>'24','label'=>false)); 
			echo $fck->load('ProductDetail/publisherReview'); ?>
	</td>
</tr>
<tr>
	<td align="right"><span class="error_msg"></span> Year Published :</td>
	<td>
		<?php echo $form->input('ProductDetail.year_published',array('maxlength'=>'20','class'=>'textbox-m','label'=>false,'div'=>false));?>
	</td>
</tr>
