<?php
/**
 * Name:Advertisement Model
 * this model interacts with static_pages table of the database
 *
 **/

class Advertisement extends AppModel{
	var $name = 'Advertisement';
	var $locale = 'en_us';
	// server side validations
	var $validate = array(
		'bannerlabel' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter banner name',
				'last' => true,
			),
		),
		'photo' => array(
			'Image_type'=>array(
				'rule' => array('ValidatePicture','picture'),
				'message' => 'Logo image is invalid',
				'last'=>true
			),
			'Image_size'=>array(
				'rule' => array('ValidatePictureSize','picture'),
				'message' => 'Logo image size exceeded the limit. you can upload image of upto 2Mb size'
			)
		),
		'bannerurl' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter url',
				'last' => true,
			),
			'url' => array(
				'rule' => array('url', true),
				'message' => 'Please enter vaild url (http://abc.com)',
			)
		),
		'company' => array(
			'rule' => 'notEmpty',
			'message' => 'Please enter company'
		),
		'contact_name' => array(
			'rule' => 'notEmpty',
			'message' => 'Please enter contact name'
		),
		'email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter email address",
				'last' => true
			),
			'ruleName2' => array(
				'rule' => array('email'),
				'message' => "Enter valid email address"
			),
		),
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
	
	
	/** function to get a list of all active choiceful favorites **/
	function getAdvertisementsList(){		
		  $data = $this->find('all', array('fields' => array(
							'Advertisement.id',
							'Advertisement.bannerurl',
							'Advertisement.bannerlabel',
							'Advertisement.banner_image',
							'Advertisement.status'),
						   'order' => array(
							'Advertisement.id' => 'ASC'),
				 ));
		  return $data ;
	}
}
?>