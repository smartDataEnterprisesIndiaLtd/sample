<?php
echo $form->select('Product.category_id', $topCategoryArray, $selected_id,array('class'=>$selectclassName, 'type'=>'select'),'Choose your category');
//echo '<div class="error-message" id="categorymissingerror" style="display:none;" >Select category name</div>';


?>