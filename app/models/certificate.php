<?php
/**
* Gift Model class
*/
class Certificate extends AppModel {
	var $name = 'Certificate';
	var $assocs = array(
		'Giftbalance' => array(
			'type' => 'belongsTo',
			'className' => 'Giftbalance',
			'foreignKey' => false,
			'conditions' => array('Certificate.code  = Giftbalance.gift_code')
		),
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => false,
			'conditions' => array('Giftbalance.user_id  = User.id')
		),
		/*'Order' => array(
			'type' => 'belongsTo',
			'className' => 'Order',
			'foreignKey' => false,
			'conditions' => array('Giftbalance.user_id  = Order.user_id')
		),*/
		);
	var $validate = array(
		'amount' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter amount",
				'last' => true,
			),
			'vaildamount' => array(
				'rule' => 'vaildamount',
				'message' => "Amount should not be more than 500",
			),
		),
		'quantity' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter quantity",
				'last' => true
			),
			'vaildqty' => array(
				'rule' => 'vaildQty',
				'message' => 'Quantity should be grater than zero(0)',
			),
		),
		'review_type' => array(
			'rule' => 'notEmpty',
			'message' => "Enter review type"
		),
		'comments' => array(
			'rule' => 'notEmpty',
			'message' => "Enter comments"
		),
		'reason' => array(
			'rule' => 'notEmpty',
			'message' => "Enter reason"
		),
		'recipient' => array(
			'valid_multiple_email'=>array(
				'rule' => 'valid_multiple_email',
				//'message' => ''
			)
		),
		'gift_code' => array(
			'rule' => 'notEmpty',
			'message' => "Enter gift certificate code from your email"
		),
		'recipient_name' => array(
			'rule' => 'notEmpty',
			'message' => "Enter recipient name"
		),
		'recipient_email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter recipient email",
				'last' => true
			),
			'ruleName2' => array(
				'rule' => array('email'),
				'message' => "Enter valid recipient email"
			),
		),
		'your_name' => array(
			'rule' => 'notEmpty',
			'message' => "Enter your name"
		),
		'your_email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter your email",
				'last' => true
			),
			'ruleName2' => array(
				'rule' => array('email'),
				'message' => "Enter valid your email"
			),
		),
	);


	function valid_multiple_email($multiple_email = null){
		$flag = 0;
		//pr($multiple_email['recipient']); die;
// 		if(strpos($multiple_email['recipient'],',')){
// 			$email_addresses = explode(',',$multiple_email['recipient']);
// 		} else{
// 			$email_addresses = $multiple_email;
// 		}
		$email_addresses = $multiple_email;
		if(!empty($email_addresses['recipient'])){
			$email_addresses = explode(',',$email_addresses['recipient']);
			foreach($email_addresses as $email_address){
				$email_addre111ss = trim($email_address);
				if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email_addre111ss)) {
					$flag = 1;
				} else {
					$flag = 0;
				}
			}
			if($flag == 1){
				return true;
			} else{
				return 'Please enter vaild email addresses for all recipients and all should be comma separated';
			}
		} else{
			return 'Enter recipients email address';
		}
	}

	function vaildamount($field = null){
		
		if(!empty($field['amount'])){
			if($field['amount'] > 0 && $field['amount'] <= 500){
				return true;
			} else{
				return false;
			}
		} else{
			return false;
		}
	}

	function vaildQty($field = null){
		if(!empty($field['quantity'])){
			if($field['quantity']>0){
				return true;
			} else{
				return false;
			}
		} else{
			return false;
		}
	}
}
?>