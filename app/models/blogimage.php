<?php
/**
 *
* Productimage Model class
*/
class Blogimage extends AppModel {
	var $name = 'Blogimage';
	var $assocs = array(
		'Blog' => array(
			'type' => 'belongsTo',
			'className' => 'Blog',
			'foreignKey' => 'blog_id',
		)
	);
}
?>