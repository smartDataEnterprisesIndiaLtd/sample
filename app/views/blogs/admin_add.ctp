<?php //$javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
<?php echo  $form->create('Blog',array('action'=>'add','method'=>'POST','name'=>'frmBlog','id'=>'frmBlog','enctype'=>'multipart/form-data'));
echo $javascript->link(array('lib/prototype'),false);
echo  $javascript->link('uploadblogmultiplephoto');
echo $javascript->link('fckeditor');
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
				</tr><!--
				<tr>
					<td colspan="2">
						<div class="errorlogin_msg" id="jsErrors">
							<?php //echo $this->element('errors'); ?>
					</div>
					</td>
				</tr>-->
				<tr>
					<td align="right"><span class="error_msg">*</span> Title: 
					</td><td>
					
					<?php echo $form->input('Blog.title',array('class'=>'textbox','cols'=>'34','rows'=>'4','label'=>false,'div'=>false,'maxlength'=>""));?>
						
					</td>
				</tr>
				
				<tr>
					<td align="right"><span class="error_msg">*</span> Publisher Name: 
					</td><td>
						<?php echo $form->input('Blog.publisher_name',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>80));?>
					</td>
				</tr>
				
				<tr>
					<td align="right"><span class="error_msg">*</span> Blog Content: 
					</td><td>
					
					<?php 
							echo $form->textarea('Blog.description',array('rows'=>'10','cols'=>'54')); 
							echo $fck->load('Blog/description'); 
							echo $form->error('Blog.description',array('class'=>'error_msg'));
						?>
					<?php //echo $form->input('Blog.description',array('class'=>'textbox','cols'=>'50','rows'=>'4','label'=>false,'div'=>false));?>
						
					</td>
				</tr>
				
				
				<tr>
					<td align="right" width="15%" valign="top"> <span class="error_msg">*</span> Search Tags : </td>
					<td align="left"><?php echo $form->input('Blog.blog_searchtag',array('class'=>'textbox','cols'=>'50','rows'=>'4','label'=>false,'div'=>false));?></td>
				</tr>
				
				<?php
			
			if(!empty($this->data['Blog']['image'])){ 
			?>
			<tr>
				<td align="right" width="15%" valign="top"></td>
				<td>
				<?php
					# display current image preview 
					$imagePath = WWW_ROOT.PATH_CHOICEFUL_BLOGS."small/img_75_".$this->data['Blog']['image'];
					if(file_exists($imagePath)){
						$arrImageDim = $format->custom_image_dimentions($imagePath, 150, 35);
					?>
					<fieldset style="border:0px;">
					 <legend>Current Image Preview</legend>
						<?php echo $html->image('/'.PATH_CHOICEFUL_BLOGS."small/img_75_".$this->data['Blog']['image'], array('width'=>$arrImageDim['width'],'style'=>'border: 1px dashed #666666; padding:5px; background-color:#EFEBE7;')); ?>
						
					<?php echo ' '.$html->link("Remove","/blogs/delete_image/".$this->data['Blog']['id'],array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this image?');",'style'=>'margin-left:10px;')); ?>	
					</fieldset>
				<?php } ?>
					
				</td>
			</tr>
			<?php  } ?>
				<tr>
					<td align="right"><span class="error_msg">*</span> Upload Picture : </td>
					<td  align="left">
						<?php echo $form->input('Blog.photo',array('class'=>'textbox-m','label'=>false,'div'=>false,'type' => 'file'));?>
					</td>
				</tr>
				<tr>
					<td align="right"></td>
					<td  align="left">
						Note:* Please upload  image of (JPG,JPEG,GIF) type  of size 150 X 35 .
					</td>
				</tr>
				
				<?php
				
				if(!empty($this->data['Blogimage'])){
		?>
		<tr>
			<td colspan="2" align="left">
				<div style="width:720px;overflow-x: scroll; border:1px dashed;">
					<table width="100%" border="0"  cellpadding="0" cellspacing="0" >
						<tr> 
						<?php 
						foreach($this->data['Blogimage'] as $product_image){
						if(!empty($product_image)){
						?>
							<td  valign="top"  >
							<table width="100%" border="0"  cellpadding="0" cellspacing="0" >
								<tr>
								<td  valign="top" align="center" height="80" style="padding:5px;">
					  <?php
					  $imagePath1 = WWW_ROOT.PATH_CHOICEFUL_BLOGS."small/img_75_".$product_image['image'];
					  if(file_exists($imagePath1)){
					  echo $html->image('/'.PATH_CHOICEFUL_BLOGS."small/img_75_".$product_image['image'], array('style'=>'border: 1px dashed #666666; padding:5px; background-color:#EFEBE7;'));
					  }  
					  ?>
							</td></tr>
							<tr><td valign="baseline" align="center"><?php echo ' '.$html->link("Remove","/blogs/delete_blog_image/".$product_image['id'],array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this image?');")); ?></td>
							</tr>
							</table>
							</td>
						
						<?php }
						}?>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<?php }?>
		
			<tr>
				<td align="right" valign="top">Multiple images :</td>
				<td align="left"><?php
				//echo $form->input('Product.photom.0',array('class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'type' => 'file','id'=>'ProductPhotoIdm_0'));
				echo "<div id='moreSoftware'></div>";
				echo "<br><div id='moreSoftwareLink'>";
				echo $form->button('Add more image',array('onclick'=>'return addSoftwareInput()','type'=>'button','value'=>'Add More Photo'));
				echo "</div>";?>
			</tr>
				
				<tr>
					<td align="right"><span class="error_msg"></span> Embed video : </td>
					<td  align="left">
						<?php echo $form->input('Blog.blog_video',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
					
					</td>
				</tr>
				<tr>
					<td align="right"></td>
					<td  align="left">
						Note:* Please Enter the Youtube video Url like (https://www.youtube.com/watch?v=VIDEOID) Or<br/>
				Vimeo video URL like (http://vimeo.com/VIDEOID)		
					</td>
				</tr>
				
				
				<tr>
					<td align="right" width="15" valign="top"><span class="error_msg">*</span> Meta Title : </td>
					<td align="left"><?php echo $form->input('Blog.meta_title',array('class'=>'textbox','cols'=>'50','rows'=>'4','label'=>false,'div'=>false));?></td>
				</tr>
				<tr>
					<td align="right" width="15%" valign="top"><span class="error_msg">*</span> Meta Description : </td>
					<td align="left"><?php echo $form->input('Blog.meta_description',array('class'=>'textbox','cols'=>'50','rows'=>'4','label'=>false,'div'=>false));?></td>
				</tr>
				<tr>
					<td align="right" width="15%" valign="top"> <span class="error_msg">*</span> Meta Keyword : </td>
					<td align="left"><?php echo $form->input('Blog.meta_keyword',array('class'=>'textbox','cols'=>'50','rows'=>'4','label'=>false,'div'=>false));?></td>
				</tr>
				
				
				<tr>
					<td align="center"></td>
					<td align="left">
						<?php 
						if(empty($this->data['Blog']['id']))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";

						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/blogs')"));?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php
if( !empty($id) ) { 
	echo $form->hidden('Blog.image',array('class'=>'textbox','label'=>false,'div'=>false));
	echo $form->hidden('Blog.id',array('class'=>'textbox','label'=>false,'div'=>false));
}
echo $form->end();
//echo $validation->rules('Blog',array('formId'=>'frmBlog'));
?>