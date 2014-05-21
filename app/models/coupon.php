<?php
/**
* Coupon Model class
*/
class Coupon extends AppModel {
	var $name = 'Coupon';
	var $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter discount coupon name",
				'last' => true
			),
		),
		'discount_code' => array(
			'isUniqueCode' => array(
				'rule' => 'isUniqueCode',
				'message' => "This coupon code already exists",
				'last' => true,
			),
			'vaild_code' => array(
				'rule' => 'vaild_code',
				'message' => "In coupon code use only alphabets and numbers",
			)
		),
		'discount_option' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Select discount option",
				'last' => true
			),
		),
		'cust_use_limit' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Select customer use limit",
				'last' => true
			),
		),
		'order_limit' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Select oreder limit",
				'last' => true
			),
		),
		'catalog_limit' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Select catalog limit",
				'last' => true
			),
		),
		'specific_amount_off' => array(
			'discnt_specificAmount' => array(
				'rule' => 'discnt_specificAmount',
			),
		),
		'taxclass' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Select tax class",
				'last' => true
			),
		),
		'percent_off' => array(
			'discnt_percentOff' => array(
				'rule' => 'discnt_percentOff'
			),
		),
		'product_code' => array(
			'productCode' => array(
				'rule' => 'productCode',
				'last' => true
			),
			'proCode_existed' => array(
				'rule' => 'proCode_existed',
				'message' => "This product code is not vaild",
			)
		),
		'department_id' => array(
			'departmentId' => array(
				'rule' => 'departmentId',
			),
		),
		'expiry_date' => array(
			'rule' => 'notEmpty',
			'message' => "Enter expiry date of coupon",
		),
		'used_times' => array(
			'emptyCheck' => array(
				'rule' => 'emptyCheck',
				'message' => "Enter zero or any numeric value",
				'last' => true
			),
		),
		'orderlimt_amount' => array(
			'orderlimtAmount' => array(
				'rule' => 'orderlimtAmount',
			),
		),
	);

	function numbers_only($field = null){
		if(preg_match("/^[0-9]+$/", $field["used_times"]) === 0)
				return false;
			else
				return true;
	}

	
	function discnt_specificAmount($field = null){
		if(!empty($this->data['Coupon']["discount_option"])){
			if($this->data['Coupon']["discount_option"] == 1){
				if(!empty($field['specific_amount_off'])){
						return true;
				} else {
					$msg = 'Please enter specific amount for discount option';
					return $msg;
				}
			} else{
				return true;
			}
		} else{
				return true;
			}
	}
	
	function discnt_percentOff($field = null){
		if(!empty($this->data['Coupon']["discount_option"])){
			if($this->data['Coupon']["discount_option"] == 2){
				if(!empty($field['percent_off'])){
						return true;
				} else {
					$msg = 'Please enter amount for percent off';
					return $msg;
				}
			} else{
				return true;
			}
		} else{
				return true;
			}
	}

	function orderlimtAmount($field = null){
		if(!empty($this->data['Coupon']["order_limit"])){
			if($this->data['Coupon']["order_limit"] == 2){
				if(!empty($field['orderlimt_amount'])){
						return true;
				} else {
					$msg = 'Please enter valid on orders amount';
					return $msg;
				}
			} else{
				return true;
			}
		} else{
				return true;
			}
	}

	function productCode($field = null) {
		
		if($this->data['Coupon']["catalog_limit"] == 2){
			if(!empty($field['product_code'])){
					return true;
			} else {
				$msg = 'Please enter product code';
				return $msg;
			}
		} else{
			return true;
		}
	}

	function departmentId($field = null) {
		if(!empty($this->data['Coupon']['catalog_limit'])){
			if($this->data['Coupon']['catalog_limit'] == 1){
				return true;
			} else{
				if($this->data['Coupon']['catalog_limit'] == 3){
					if(!empty($field['department_id'])){
							return true;
					} else {
						$msg = 'Please select a department';
						return $msg;
					}
				} else{
					return true;
				}
			}
		}
	}


	function proCode_existed($field = null) {
		if(!empty($field['product_code'])){
			App::import('Model','Product');
			$this->Product = &new Product;
			$isProduct = $this->Product->find('first',array('conditions'=>array('Product.quick_code'=>$field['product_code']))); 
			if(empty($isProduct)){
				return false;
			} else {
				return true;
			}
		} else{
			return true;
		}
	}

	function isUniqueCode($field = null){
		if(!empty($field['discount_code'])){
			if(empty($this->data['Coupon']['id'])){
				$isexisted_code = $this->find('all',array('conditions'=>array('Coupon.discount_code'=>$field['discount_code'])));
				if(!empty($isexisted_code)){
					return false;
				} else{
					return true;
				}
			} else{
				return true;
			}
		} else{
			return true;
		}
	}

	function vaild_code($field = null){
		if(!empty($field['discount_code'])){
			if(preg_match("/^[a-zA-Z0-9]+$/", $field["discount_code"]) === 0)
				return false;
			else
				return true;
		} else{
			return true;
		}
	}

	function emptyCheck($field = null){
		if($field['used_times'] == ''){
			return false;
		} else {
			$number_flag = $this->numbers_only($field);
			if(!empty($number_flag))
				return true;
			else
				return false;
		}
	}
}
?>