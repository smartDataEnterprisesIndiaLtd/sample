<?php  $this->Html->addCrumb('Promotions', '/admin/certificates');

	$this->Html->addCrumb('View choiceful favorite ', 'javascript:void(0)');
 ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" class="adminBox">
	<tr class="adminBoxHeading reportListingHeading">
	<td class="adminGridHeading heading" height="25px" align="left">
		<?php echo $list_title; ?>
	</td>
	<td class="adminGridHeading heading" height="25px" align="right">
		<?php echo $html->link('Back','/admin/choiceful_favorites/');    ?>
	</td>
	</tr>
	<tr>
	<td colspan="2">
		<table  border="0" cellpadding="2" cellspacing="2" width="100%">
		<tr height="15">
			<td width="1%"></td>
			<td width="20%" align="right"></td>
			<td width="3%" align="left"></td>
			<td align="left"></td>
		</tr> 
		<tr>
			<td></td>
			<td align="right" valign="top">Title</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $this->data['ChoicefulFavorite']['title'];   ?></td>
		</tr>
		<tr>
			<td></td>
			<td align="right" valign="top">Url</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $this->data['ChoicefulFavorite']['favorite_url'];   ?></td>
		</tr>
		<tr>
			<td></td>
			<td align="right" valign="top">Image</td>
			<td align="left" valign="top">:</td>
			<td align="left">
				
		<?php 
		if(!empty($this->data['ChoicefulFavorite']['image'])){
			
			$imagePath =WWW_ROOT.PATH_CHOICEFUL_FAVORITES.$this->data['ChoicefulFavorite']['image'];
			
			if(file_exists($imagePath)){
				$arrImageDim = $format->custom_image_dimentions($imagePath, 200, 200);
				echo $html->image('/'.PATH_CHOICEFUL_FAVORITES.$this->data['ChoicefulFavorite']['image'], array('width'=>$arrImageDim['width'])); 		
			}else{
				echo $html->image('/img/no_image.jpeg'); 		
			}
		}
		?>		
		</td>
		</tr>
			<tr>
			<td></td>
			<td align="right" valign="top">Created on</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $format->date_format($this->data['ChoicefulFavorite']['created']);
			?></td>
		</tr>
			<tr>
			<td></td>
			<td align="right" valign="top">Modified on</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $format->date_format($this->data['ChoicefulFavorite']['modified']);   ?></td>
		</tr>
		<tr height="15">
			<td colspan="4">&nbsp;</td>
		</tr>
		
		</table>
	</td>
	</tr>
</table>