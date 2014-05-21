<?php 
//echo $javascript->link(array('jquery-1.3.2.min'), false);
?>
<?php echo $form->create('Seller',array('action'=>'upload_bulk_listing/'.$id, 'method'=>'POST','name'=>'frmUploadListing','id'=>'frmUploadListing', 'enctype'=>'multipart/form-data' ));
echo $form->hidden('ProductSeller.seller_id', array('value'=>$id));
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
       
        <tr height="20px">
                <td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td>
        </tr>
      
	
	<tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Upload Listing :</td>
                <td>
                        <?php echo $form->input('ProductSeller.sample_bulk_data',array('class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'type' => 'file'));?>
                </td>
                
        </tr>
       
        <tr>
                <td colspan="2">&nbsp;</td></tr>
        <tr>
                <td>&nbsp;</td>
                <td align="left">
                <?php 
                 echo $form->button('Upload Listing',array('type'=>'submit','class'=>'btn_53','div'=>false));
		 ?>
                </td>
        </tr>
	</table>
	</td>
	</tr>
</table>


<?php 

echo $form->end();
// echo $validation->rules(array('ProductSeller'),array('formId'=>'frmUploadListing'));
?>



