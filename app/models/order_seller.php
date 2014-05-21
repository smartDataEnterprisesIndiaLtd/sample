<?php
/**
* OrderSeller Model class
*/
class OrderSeller extends AppModel {
	var $name = 'OrderSeller';
	var $assocs = array(
		'Order' => array(
			'type' => 'belongsTo',
			'className' => 'Order',
			'fields'=>array('id','user_id','created'),
			'foreignKey' => 'order_id',
		),
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'seller_id',
		),
		'SellerSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'seller_id',
			'fields'=>array('firstname','lastname','email')
		),
		//Add for business_display_name on 14-feb-2013
		'Seller' => array(
			'type' => 'belongsTo',
			'className' => 'Seller',
			'conditions' => array('Seller.user_id = OrderSeller.seller_id'),
			'foreignKey' => false,
			'fields'=>array('business_display_name')
		),
	);

	var $validate = array(
		'shipping_date' => array(
			'rule' => 'notEmpty',
			'message' => "Enter shipping date"
		),
		'shipping_carrier' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Select carrier',
				'last' => true,
			),
			'otherCarrier' => array(
				'rule' => array('otherCarrier','other_carrier'),
				'message' => "Enter your carrier name"
			),
		),
		'shipping_service' => array(
			'rule' => 'notEmpty',
			'message' => "Enter shipping service"
		),
// 		'trackingId' => array(
// 			'rule' => 'notEmpty',
// 			'message' => "Enter trackind id"
// 		),
		'cancel_reason' => array(
			'rule' => 'notEmpty',
			'message' => "Select reason to cancel this order"
		),
		'seller_note' => array(
			'rule' => 'notEmpty',
			'message' => "No comments have been saved"
		),
		'reason_id' => array(
			'rule' => 'notEmpty',
			'message' => "Please select a reason"
		),
		'amount' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Enter refund amount',
				'last' => true,
			),
		'decimal' => array(
				'rule' => array('decimal', 2),
				'message' => "Enter only number with 2 decimal value",
			),
			'vaild_amount' => array(
				'rule' => array('vaild_amount','up_to_refund'),
			),
		),
	);

	
	function otherCarrier($field_post = null,$next_field = null){
		if(!empty($field_post["shipping_carrier"])){
			if($field_post["shipping_carrier"] == 8 || $field_post["shipping_carrier"] == 9){
				if(empty($this->data['OrderSeller']['other_carrier'])){
					return false;
				} else{
					return true;
				}
			} else {
				return true;
			}
		}
	}
	
	function vaild_amount($field = null,$up_to_refund = null){
		
		
		if(!empty($this->data)){
		
		$negval = substr($this->data['OrderSeller']['amount'], 0, 1);
		
		if(isset($negval) && $negval=='-' )
		{
		return "negative value";	
		}
	
		if($field['amount'] <= $this->data['OrderSeller'][$up_to_refund]){
				
				return true;
			} else {
			
				return "Invalid refund value";
			}	
		}	
		
	}
	
	
	/*function vaild_amount($field = null,$up_to_refund = null){
		if(!empty($field['amount'])){
			$up_array = explode('.',$this->data['OrderSeller'][$up_to_refund]);
			//pr($up_array);
			if(!empty($up_array[1])){
				$points = substr($up_array[1],0,2);
				$up_array[1] = substr($up_array[1],0,2);
			} else {
				$points = '00';
			}
			$this->data['OrderSeller'][$up_to_refund] = $up_array[0].'.'.$points;
		//pr($field);pr($this->data['OrderSeller'][$up_to_refund]);
			if($field['amount'] <= $this->data['OrderSeller'][$up_to_refund]){
				//echo 'ff';
				return true;
			} else{
				//echo 'no';
				return "Refund value should be less than or equal to the maximum amount";
			}
		}
	}*/
	
}
?>