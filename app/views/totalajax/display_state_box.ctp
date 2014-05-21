<?php    
    if(count($statesArray) > 0){ // selection box
    	if(!Empty($errors)){
		$errorstate='select error_message_box';
	}else{
		$errorstate='select';
	}
       echo $form->select($stateFieldName,$statesArray, $selectedValue, array('class'=>$selectclassName.' '.$errorstate, 'type'=>'select','error' =>false),'Select State'); 
    }else{ // text box
      echo $form->input($stateFieldName,array('value'=>$selectedValue, 'class'=>$textclassName,'maxlength'=>'100','label'=>false,'div'=>false,'error'=>false));
    }

//echo $form->error('User.state');
if(!empty($errors['add_state']))
	//echo '<div class="error-message">'.$errors['add_state'].'</div>'; 
?>