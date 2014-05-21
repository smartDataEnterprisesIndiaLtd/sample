<?php
/**
 *
 * AdminuserPermission.php
 *
 */
class AdminuserPermission extends AppModel {
    var $name = 'AdminuserPermission';
    var $assocs = array(
		'Permission' => array(
		'type' => 'belongsTo',
		'className' => 'Permission',
		)
	);
}
?>