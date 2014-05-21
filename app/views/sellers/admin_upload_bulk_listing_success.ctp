<?php 
	//echo $javascript->link(array('jquery-1.3.2.min'), false);
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td class="adminGridHeading heading"  height="25px" align="right"></td>
	</tr>

	<tr>
	<td colspan="2">
		<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
		<tr height="2">
			<td  align="right" width="20%"></td>
			<td align="left"></td>
		</tr>
		<tr>
			<td colspan="2" class="bgGreentext">Volume seller's product listing has been uploaded succesfully.</td>
		</tr>
		<?php
		if( is_array($uploadStatus)  &&  count($uploadStatus) >0)  { ?>
		<tr>
			<td height="10px">Total Listed Items :&nbsp;</td>
			<td><?php echo $uploadStatus['all_products'];?>&nbsp;</td>
		</tr>
		<tr>
			<td >Items Uploaded :&nbsp;</td>
			<td><?php echo $uploadStatus['uploaded_products'];?>&nbsp;</td>
		</tr>
		<tr>
			<td >Items Not Uploaded :&nbsp;</td>
			<td><?php echo $uploadStatus['notuploaded_products'];?>&nbsp;</td>
		</tr>
		<?php
		}
		
		if( !empty($errorFileName) ){
		$filePath= WWW_ROOT."files/error_files/";
		$errorFile = $filePath.$errorFileName;
		
		if( file_exists($errorFile) )  {
			?>
		<tr>
			<td colspan="2" class="error_msg">Few products of listing are not uploaded. Please download the not uploaded products file and try again.</td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo $html->link('Click here to download the error file','/admin/sellers/download_error_file/'.$errorFileName, array('class'=>'', 'escape'=>false))?>
		
		</td>
		</tr>
		<?php }  }?>
		
		<tr>
			<td colspan="2" height="20"></td>
			
		</tr>
		
		<tr>
			<td colspan="2"> <?php echo $html->link("Go Back",'/admin/sellers/view_bulk_listing/'.$errorFileName, array('class'=>'', 'escape'=>false))?></td>
			
		</tr>
		</table>
	</td>
	</tr>
</table>
