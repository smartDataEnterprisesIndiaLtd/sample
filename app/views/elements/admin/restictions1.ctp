<td align="right" width="20%"> Products that are on sale</td>
<td style="width:5px" valign="top"> : </td>
<td><?php echo $form->select('Coupon.product_onsale',array('1'=>'Apply','0'=>'Do not apply'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select--'); ?>
</td>