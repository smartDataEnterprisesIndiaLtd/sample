<script type="text/javascript">

jQuery(document).ready(function(){
   
	jQuery('#OrderBillingState').change(function() {
	     if(jQuery('#OrderShippingSame').attr('checked') == true){
		SetShippingData();
		displayState('S');
		SetShippingData();
		
		}	
	})
});
</script>

<?php

//echo 'kkkk' ;
 //$stateFieldName
//pr($statesArray);
if(count($statesArray) > 0){ // selection box
    echo $form->select($stateFieldName,$statesArray, $selectedValue, array('type'=>'select','class'=>'select','label'=>false,'div'=>false,'size'=>1),'Select...');
   
}else{ // text box
   echo $form->input($stateFieldName,array('value'=>$selectedValue, 'onkeyup'=>'PutThisDataInShippingAsWell(this.value,7)', 'maxlength'=>'100','class'=>'form-textfield','label'=>false,'div'=>false));
							
}


?>