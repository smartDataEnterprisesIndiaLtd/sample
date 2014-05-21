<?php
/**
 *
* DeleteZip Model class
*/
class DeleteZip extends AppModel {
	var $name = 'DeleteZip';
        var $validate = array(
		'name' => array(
					'rule' => 'isUnique',
					'message' => "This name already exists"
					//'on' => 'create',
				)
		);
}
?>