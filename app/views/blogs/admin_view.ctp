<?php ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" class="adminBox">
	<tr class="adminBoxHeading reportListingHeading">
	<td class="adminGridHeading heading" height="25px" align="left">
		<?php echo $list_title; ?>
	</td>
	<td class="adminGridHeading heading" height="25px" align="right">
		<?php echo $html->link('Back','/admin/blogs/');    ?>
	</td>
	</tr>
	<tr>
	<td colspan="2">
		<table  border="0" cellpadding="2" cellspacing="2" width="100%">
		<tr height="15">
			<td width="1%"></td>
			<td width="20%" align="left"></td>
			<td width="3%" align="left"></td>
			<td align="left"></td>
		</tr> 
		<tr>
			<td></td>
			<td align="left" valign="top">Title</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $this->data['Blog']['title'];   ?></td>
		</tr>
		
		<tr>
			<td></td>
			<td align="left" valign="top">Publisher Name</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $this->data['Blog']['publisher_name'];   ?></td>
		</tr>
		<tr>
			<td></td>
			<td align="left" valign="top">Blog Content</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $this->data['Blog']['description'];   ?></td>
		</tr>
		
		<tr>
			<td></td>
			<td align="left" valign="top">Image</td>
			<td align="left" valign="top">:</td>
			<td align="left">
				
		<?php 
		if(!empty($this->data['Blog']['image'])){
			
			$imagePath =WWW_ROOT.PATH_CHOICEFUL_BLOGS."small/img_75_".$this->data['Blog']['image'];
			
			if(file_exists($imagePath)){
				$arrImageDim = $format->custom_image_dimentions($imagePath, 77, 77);
				echo $html->image('/'.PATH_CHOICEFUL_BLOGS."small/img_75_".$this->data['Blog']['image'], array('width'=>$arrImageDim['width'])); 		
			}else{
				echo $html->image('/img/no_image.jpeg'); 		
			}
		}
		?>		
		</td>
		</tr>
		
		<tr>
			<td></td>
			<td align="left" valign="top">Embeded Video</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php if (isset($this->data['Blog']['blog_video']) && !empty($this->data['Blog']['blog_video'])) echo $this->data['Blog']['blog_video'];?></td>
		</tr>
		
		
		
		<tr>
			<td></td>
			<td align="left" valign="top">Meta Title</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $this->data['Blog']['meta_title'];   ?></td>
		</tr>
		
		<tr>
			<td></td>
			<td align="left" valign="top">Meta Description</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $this->data['Blog']['meta_description'];   ?></td>
		</tr>
		
		<tr>
			<td></td>
			<td align="left" valign="top"> Meta Keywords</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $this->data['Blog']['meta_keyword'];   ?></td>
		</tr>
			<tr>
			<td></td>
			<td align="left" valign="top">Created on</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $format->date_format($this->data['Blog']['created']);
			?></td>
		</tr>
			<tr>
			<td></td>
			<td align="left" valign="top">Modified on</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $format->date_format($this->data['Blog']['modified']);   ?></td>
		</tr>
		<tr height="15">
			<td colspan="4">&nbsp;</td>
		</tr>
		
		</table>
	</td>
	</tr>
</table>