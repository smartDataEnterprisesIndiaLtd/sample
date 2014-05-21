<?php
$dep_temp_code_arry = array();
$dep_temp_code_arry[1] = 'book';
$dep_temp_code_arry[2] = 'music';
$dep_temp_code_arry[3] = 'movie';
$dep_temp_code_arry[4] = 'game';
//$dep_temp_code_arry[5] = 'electronic';
//$dep_temp_code_arry[6] = 'office_computing';
//$dep_temp_code_arry[7] = 'mobile';
//$dep_temp_code_arry[8] = 'home_garden';
$dep_temp_code_arry[5] = 'common';
$dep_temp_code_arry[6] = 'common';
$dep_temp_code_arry[7] = 'common';
$dep_temp_code_arry[8] = 'common';
$dep_temp_code_arry[9] = 'health_beauty';

if( isset($dep_temp_code_arry[$department_id]) ){
	$department_temp_code =  $dep_temp_code_arry[$department_id];
	echo $this->element('admin/product_templates/'.$department_temp_code);
}else{
	echo "";
}
	
	
	
?>
