<?php  $this->Html->addCrumb('Promotions', '/admin/certificates');

	$this->Html->addCrumb('View', 'javascript:void(0)');
 ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
	<td class="adminGridHeading heading" >
		<?php echo $list_title; ?>
	</td>
		<td class="adminGridHeading heading"  height="25px" align="right">
		<?php echo $html->link('Back','/admin/advertisements/');    ?>
	</td>
	</tr>
	<tr>
	<td colspan="2">
		<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
		<tr height="15">
			<td width="1%"></td>
			<td width="20%" align="right"></td>
			<td width="3%" align="left"></td>
			<td align="left"></td>
		</tr> 
		<tr>
			<td></td>
			<td align="right" valign="top">Label</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $this->data['Advertisement']['bannerlabel'];   ?></td>
		</tr>
		<tr>
			<td></td>
			<td align="right" valign="top">Url</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $this->data['Advertisement']['bannerurl'];   ?></td>
		</tr>
		<tr>
			<td></td>
			<td align="right" valign="top">Advertisement</td>
			<td align="left" valign="top">:</td>
			<td align="left">
		<?php 
		if(!empty($this->data['Advertisement']['banner_image'])){
			
			$imagePath =WWW_ROOT.PATH_ADVERTISEMENTS.$this->data['Advertisement']['banner_image'];
			$arrImageDim = $format->custom_image_dimentions($imagePath, 350, 350);
			if(file_exists($imagePath)){
				echo $html->image('/'.PATH_ADVERTISEMENTS.$this->data['Advertisement']['banner_image'], array('width'=>$arrImageDim['width'])); 		
			}else{
				echo $html->image('/img/no_image.jpeg'); 		
			}
		}
		?></td>
		</tr>
			<tr>
			<td></td>
			<td align="right" valign="top">Created on</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $format->date_format($this->data['Advertisement']['created']);
			?></td>
		</tr>
			<tr>
			<td></td>
			<td align="right" valign="top">Modified on</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $format->date_format($this->data['Advertisement']['modified']);   ?></td>
		</tr>
			
		<tr height="15">
			<td colspan="4">&nbsp;</td>
		</tr>
		
		</table>
	</td>
	</tr>
</table>