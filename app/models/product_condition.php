<?php
/**
 *
 * ProductCondition.php
 *
 */

class ProductCondition extends AppModel {
    var $name = 'ProductCondition';
    
    
    /* @function	:	getProductConditions
	@description	:	get a list of all product confitions
	@params		:	NULL
	@created	:	Nov 22 2010
	@credated by	:	kulvinder
	**/
	function getProductConditions($conditionId= null) {
		// get Department array
		if( !empty($conditionId) ){
		       $product_condition_array = $this->find('first', array('order' =>array('ProductCondition.name ASC'), 'condition'=> array('ProductCondition.id='.$conditionId )  ) );
		}else{
		       $product_condition_array = $this->find('list');
		}
		return $product_condition_array;
	}
}
?>