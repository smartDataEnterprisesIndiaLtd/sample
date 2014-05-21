<?php
class BlogSearchtag extends AppModel {
	var $name = 'BlogSearchtag';
	var $actsAs = array('Containable');
	
	 var $belongsTo = array(
				'Blog' => array(
				   'className'    => 'Blog',
				   'foreignKey'    => 'blog_id',
				)
			);

}
?>