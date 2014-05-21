<?php
echo $form->select('Product.color_id',$all_color_array,$added_color_id,array('class'=>'textbox-m', 'type'=>'select'),'Select Color'); 
echo $form->error('Product.color_id'); ?>