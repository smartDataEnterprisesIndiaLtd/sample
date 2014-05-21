<?php

if(count($statesArray) > 0){ // selection box
    echo $form->select($stateFieldName,$statesArray, $selectedValue, array('type'=>'select','class'=>'select','label'=>false,'div'=>false,'size'=>1),'Select...');
   
}else{ // text box
   echo $form->input($stateFieldName,array('value'=>$selectedValue, 'maxlength'=>'100','class'=>'form-textfield','label'=>false,'div'=>false));
							
}


?>