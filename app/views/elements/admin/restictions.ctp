<td align="right" width="20%" valign="top"> Catalog limit</td><td style="width:5px" valign="top"> : </td>
<td>
	<table width ="100%" border="0"><tr><td colspan="2">
	<?php
	$options=array('1'=>' Any Product </td></tr><tr><td width=\'30%\'>','2'=>' This Product Code only</td><td>'.$form->input('Coupon.product_code',array('size'=>'30','class'=>'textbox-s','label'=>false,'div'=>false)).'</td></tr><tr><td>','3'=>' This Department Only</td><td>'.$form->select('Coupon.department_id',$departments,null,array('type'=>'select','class'=>'textbox-s','label'=>false,'div'=>false,'size'=>1),'--Select--').$form->error('Coupon.department_id').'</td></tr></table>');
	$attributes=array('legend'=>false,'label'=>false,'class'=>'');
	echo $form->radio('Coupon.catalog_limit',$options,$attributes); echo $form->error('Coupon.catalog_limit'); ?>
</td> 