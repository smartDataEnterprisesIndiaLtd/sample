<?php
echo $form->select('Product.brand_id',$all_brand_array,$added_brand_id,array('class'=>'textbox-m', 'type'=>'select'),'Select Brand'); 
echo $form->error('Product.brand_id'); ?>