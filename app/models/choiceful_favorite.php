<?php
/**
 * Name:ChoicefulFavorite Model
 * this model interacts with static_pages table of the database
 *
 **/

class ChoicefulFavorite extends AppModel{
	var $name = 'ChoicefulFavorite';
	var $locale = 'en_us';
	// server side validations
	var $validate = array(
		'title' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter title',
				'last' => true,
			),
		),
		'photo' => array(
			'Image_type'=>array(
				'rule' => array('ValidatePicture','picture'),
				'message' => 'Choiceful favorites image is invalid',
				'last'=>true
			),
			'Image_size'=>array(
				'rule' => array('ValidatePictureSize','picture'),
				'message' => 'Choiceful favorites image size exceeded the limit. you can upload image of upto 2Mb size'
			)
		),
		'favorite_url' => array(
// 			'checkurl'=>array(
// 				'rule' => array('checkurl'),
// 				'message' => 'Please enter vaild url (http://abc.com)'
// 			)
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter url',
				'last' => true,
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
	
	
	function checkurl($field = null){
		if(!empty($field['favorite_url'])){
			$str_length = strlen($field['favorite_url']);
			if($str_length > 4){
				$first_chars = substr($field['favorite_url'],0,4);
				if($first_chars == 'http'){
					$new_url = substr($field['favorite_url'],8,$str_length);
				} else{
					$new_url = $field['favorite_url'];
				}
			} else{
				$new_url = $field['favorite_url'];
			}
			$url = $new_url;
			if (preg_match ("/^[a-z0-9][a-z0-9\-]+[a-z0-9](\.[a-z]{2,4})+$/i", $url)) {
				return true;
			} else {
				return false;
			}

		}else{
			return true;
		}
	}
	
/* ************** */
}
?>