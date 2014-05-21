<?php
/**
* Address Model class
*/
class Address extends AppModel {
	var $name = 'Address';
	var $assocs = array(
		'Country' => array(
			'type' => 'belongsTo',
			'className' => 'Country',
			'foreignKey' => 'country_id',
		)
	);
	var $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter title",
				'last' => true,
			),
		),
		'add_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter full name",
				'last' => true,
			),
		),
		'add_firstname' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter first name",
				'last' => true,
			),
		),
		'add_lastname' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter surname",
				'last' => true,
			),
		),
		'add_address1' => array(
			'rule' => 'notEmpty',
			'message' => "Enter address line1",
		),
		'add_city' => array(
			'rule' => 'notEmpty',
			'message' => "Enter town/city"
		),
		
		'add_postcode' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter postcode",
				'last' => true,
			),
			'vaild_postcode' => array(
				'rule' => array('vaild_postcode'),
				'message' => "Please enter vaild post code"
			),
		),
		'country_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Select country',
				'last' => true,
			),
			'vaild_country' => array(
				'rule' => array('vaild_country'),
				'message' => "Select country"
			),
		),
		'add_state' => array(
			'rule' => 'notEmpty',
			'message' => "Enter state/county"
		),
		'add_phone' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter phone number",
				'last' => true,
			),
			'vaild_ph' => array(
				'rule' => array('vaild_ph'),
				'message' => "Please enter vaild phone number"
			),
		)
	);
	function vaild_ph($field_phone = null){
		if(!empty($field_phone["add_phone"])){
			if(preg_match("/^[0-9 ]+$/", $field_phone["add_phone"]) === 0)
				return false;
			else 
				return true;
		}
	}
	function vaild_postcode($field_post = null){
		if(!empty($field_post["add_postcode"])){
			if(preg_match("/^[a-zA-Z0-9 ]+$/", $field_post["add_postcode"]) === 0)
				return false;
			else
				return true;
		}
	}
	function getprimary_add($user_id = null,$fields = null){
		$primary_add = $this->find('first',array('conditions'=>array('Address.user_id'=>$user_id,'Address.primary_address'=>'1'),'fields'=>$fields));
		return $primary_add;
	}
	function vaild_country($field_country = null){
		if(!empty($field_country["country_id"])){
			if($field_country["country_id"] == 7)
				return false;
			else 
				return true;
		}
	}

// 	function beforeSave(){
// 	
// 		$this->data = Sanitize::clean($this->data);
// 
// 		$this->set($this->data);
// 		return true;
// 	}
}
?>