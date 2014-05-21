<?php
/**
 * Name:ChoicefulFavorite Model
 * this model interacts with static_pages table of the database
 *
 **/

class Blog extends AppModel{
	var $name = 'Blog';
	var $locale = 'en_us';
	var $actsAs = array('Containable','Sluggable'=>array('title_field' => 'title','slug_field' => 'slug','separator' => '-'));
	var $hasMany = array(
			'BlogComment' => array(
			'className' => 'BlogComment',
			'foreignKey'    => 'blog_id',
			'dependent' => true
				),
			'BlogSearchtag' => array(
			'className' => 'BlogSearchtag',
			'foreignKey'    => 'blog_id',
			'dependent' => true
				),
			'Blogimage' => array(
			'className' => 'Blogimage',
			'foreignKey'    => 'blog_id',
			'dependent' => true
				)
			);
	// server side validations
	var $validate = array(
		'title' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter title',
				'last' => true,
			),
		),
		'publisher_name' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter publisher name',
				'last' => true,
			),
		),
		'description' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter description',
				'last' => true,
			),
		),
		'photo' => array(
			/*'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please upload blog image',
				'last' => true,
			),*/
			'Image_type'=>array(
				'rule' => array('ValidatePicture','picture'),
				'message' => 'Blog article image is invalid',
				'last'=>true
			),
			'Image_size'=>array(
				'rule' => array('ValidatePictureSize','picture'),
				'message' => 'Blog article image size exceeded the limit. you can upload image of upto 2Mb size'
			)
		),
		'blog_searchtag' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter blog search tags',
				'last' => true,
			),
		),
		'meta_title' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter meta title',
				'last' => true,
			),
		),
		'meta_description' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter meta description',
				'last' => true,
			),
		),
		
		'meta_keyword' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter meta keyword',
				'last' => true,
			),
		)
	);

	/** validation for pictures for image type **/
	function ValidatePictureSize($picture){
		$picture=current($picture);
		if(!empty($picture)){
			$picture_size=$picture['size'];
			$max_limit=Configure::read('maxfilesize');
			if($picture_size < $max_limit)
					return true;
				else
					return false;
		}
	}
	/** validation for pictures for image type **/
	function ValidatePicture($picture){
		$picture=current($picture);
		if(!empty($picture['name'])){
			$array=array('jpeg','.jpg','.gif','.png');
			$pictureType=substr($picture['name'],strlen($picture['name'])-4);
			if(in_array(strtolower($pictureType),$array))
				return true;
			else
				return false;
		}else {return true;}

	}
	
	
	
	
/* ************** */
}
?>