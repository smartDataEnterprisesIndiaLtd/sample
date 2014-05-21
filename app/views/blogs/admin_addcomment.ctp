<?php $javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); 
echo $javascript->link(array('behaviour.js','textarea_maxlen'));?>
<?php echo  $form->create('Blog',array('action'=>'addcomment/'.$blog_id,'method'=>'POST','name'=>'frmBlog','id'=>'frmBlogComment','enctype'=>'multipart/form-data'));
 //echo $javascript->link('fckeditor');
 echo $form->hidden('BlogComment.blog_id',array('class'=>'textbox','label'=>false,'div'=>false,'value'=>$blog_id));
 if( !empty($id) ) { 
	echo $form->hidden('BlogComment.id',array('class'=>'textbox','label'=>false,'div'=>false));
}
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td height="25" align="right"> 
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellspacing="1" cellpadding="3" > 
				<tr height="20px" colspan="2">
					<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				
				<tr>
					<td align="right"><span class="error_msg">*</span>Name: 
					</td><td>
						<?php echo $form->input('BlogComment.name',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
					</td>
				</tr>
				
				<tr>
					<td align="right"><span class="error_msg">*</span> Comment: 
					</td><td>
					
					<?php echo $form->input('BlogComment.comment',array('class'=>'textbox','cols'=>'50','rows'=>'4','showremain'=>'limitOne','label'=>false,'div'=>false,'maxlength'=>1000));?>
					
					<span id ="limitOne">1000</span> characters left.
						
					</td>
				</tr>
				
				<tr>
					<td align="center"></td>
					<td align="left">
						<?php 
						if(empty($this->data['BlogComment']['id']))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";

						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/blogs/reviewcomments/".$blog_id."')"));?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php

echo $form->end();

?>