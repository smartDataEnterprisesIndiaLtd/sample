<?php
/**
* Seller Model class
*/
class Seller extends AppModel {
	var $name = 'Seller';
	var $assocs = array(
		'Country' => array(
			'type' => 'belongsTo',
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'fields'=>array('Country.id','Country.country_name'),
		),
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'SellerPayment' => array(
			'type' => 'hasMany',
			'className' => 'SellerPayment',
			'foreignKey' => 'seller_id',
		),
		'OrderItem' => array(
			'type' => 'hasMany',
			'className' => 'OrderItem',
			'foreignKey' => 'seller_id',
		),
		'ProductSeller' => array(
			'type' => 'belongsTo',
			'className' => 'ProductSeller',
			'foreignKey' => false,
			'conditions' => array('Seller.user_id  = ProductSeller.seller_id')
		),
		'Address' => array(
			'type' => 'belongsTo',
			'className' => 'Address',
			'foreignKey' => false,
			'conditions' => array('Seller.user_id  = Address.user_id')
		)
	);
	var $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => "Select a title"
		),
		'firstname' => array(
			'rule' => 'notEmpty',
			'message' => "Enter first name"
		),
		'lastname' => array(
			'rule' => 'notEmpty',
			'message' => "Enter last name"
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
			'isUserUniqueemail' => array(
				'rule' => 'isUserUniqueemail',
				'message' => "This email address is already registered, please sign in to upgrade to a seller account"
			)
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter password",
				'last' => true
			),
			'minLength' => array(
				'rule' => array('minLength', 6),
				'message' => "Password must be at least 6 characters long"
			)
		),
		'confirmpassword' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Enter confirm password',
				'last' => true,
			),
			'checknewconfirmpassword' => array(
				'rule' => array('checknewconfirmpassword','password'),
				'message' => "Password and confirm password don't match",
				'last'=>true
			)
		),
		'newpassword' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter password",
				'last' => true
			),
			'minLength' => array(
				'rule' => array('minLength', 6),
				'message' => "Password must be at least 6 characters long"
			)
		),
		'newconfirmpassword' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Enter confirm password',
				'last' => true,
			),
			'checknewconfirmpassword' => array(
				'rule' => array('checknewconfirmpassword','newpassword'),
				'message' => "New Password and confirm password don't match",
				'last'=>true
			)
		),
		'address1' => array(
			'rule' => 'notEmpty',
			'message' => "Enter address line 1"
		),
		'city' => array(
			'rule' => 'notEmpty',
			'message' => "Enter town/city"
		),
		'postcode' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Enter postcode',
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
		'state' => array(
			'rule' => 'notEmpty',
			'message' => "Enter state"
		),
		'phone' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Enter phone number',
				'last' => true,
			),
			'vaild_ph' => array(
				'rule' => array('vaild_ph'),
				'message' => "Please enter vaild phone number"
			),
		),
		'terms_conditions' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'last' => true
			),
			'checked' => array(
				'rule' => array('terms_checked'),
				'message' => "Please read terms and conditions and put them checked"
			),
		),
		'secret_question' => array(
			'rule' => 'notEmpty',
			'message' => "Select secret question"
		),
		'secret_answer' => array(
			'rule' => 'notEmpty',
			'message' => "Enter secret answer"
		),
		'business_name' => array(
			'rule' => 'notEmpty',
			'message' => "Enter business name"
		),
		'business_display_name' => array(
			'rule' => 'notEmpty',
			'message' => "Enter display name"
		),
		'business_display_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter display name",
				'last' => true
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => "This business display name is already in use by another seller on Choiceful.com, please enter a different name"
			)
		),
		'service_email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter service email address",
				'last' => true
			),
			'ruleName2' => array(
				'rule' => array('email'),
				'message' => "Enter valid service email address"
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => "This email is already in use please try again with another email"
			)
		),
		'threshold_order_value' => array(
			/*
			 REF H #1686
			 'ordervalue' => array(
				'rule' => array('ordervalue','free_delivery'),
				'message' => "Enter threshold order value",
			),*/
			'decimal' => array(
				'rule' => array('decimal', 2),
				'message' => "Enter only number with 2 decimal value",
			)
		),
		/*'sortcode1' =>  array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter proper bank sort code",
			),
			
		),
		'sortcode2' =>  array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter proper bank sort code",
			),
		),*/
		'sortcode3' =>  array(
			/*'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter proper bank sort code",
			),*/
			'empty_sortcode' => array(
				'rule' => array('empty_sortcode'),
				'message' => "Enter bank sort code",
				'last' => true,
			),
			'number_only_sc3' => array(
				'rule' => 'number_only_sc3',
				'message' => "Enter only number",
			),
			/*'numeric' => array(
				'rule' => 'numeric',
				'message' => "Enter only number",
			),*/
			/*'vaild_sortcode' => array(
				'rule' => array('vaild_sortcode'),
				'message' => "Please enter vaild sort code"
			),*/
		),
		'bank_ac_number' =>  array(
			/*'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter bank account number",
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => "Enter only number",
			),*/
			'number_only' => array(
				'rule' => array('number_only'),
				'message' => "Enter only number",
				'last' => true,
			),
			'empty_acc_number' => array(
				'rule' => array('empty_acc_number'),
				'message' => "Enter bank account number",
				'last' => true,
			),
		),
		'retype_bank_account_number' =>  array(
			'empty_retypebank_acc' => array(
				'rule' => array('empty_retypebank_acc'),
				'message' => "Re-type bank account number",
				'last' => true,
			),
			'confirm_retypebank_acc' => array(
				'rule' => array('confirm_retypebank_acc'),
				//'rule' => array('confirm_retypebank_acc'),
				'message' => "This does not match with your bank account number please check and try again",
				'last' => true,
			),
		),
		'account_holder_name' =>  array(
			/*'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter bank account holder name",
			),*/
			'empty_account_holder_name' => array(
				'rule' => array('empty_account_holder_name'),
				'message' => "Enter bank account holder name",
				'last' => true,
			),	
		),
		'paypal_account_mail' =>  array(
			'empty_acc_paypal' => array(
				'rule' => array('empty_acc_paypal'),
				'message' => "Enter paypal email address",
				'last' => true,
			),
		),
		'deposit_1' =>  array(
			'empty_deposit' => array(
				'rule' => 'notEmpty',
				'message' => "Enter deposit 1 value",
			),
			'check_numeric' => array(
				'rule' => 'numeric',
				'message' => "Enter numeric value",
			),
			'check_zero_deposit1' => array(
				'rule' => 'check_zero_deposit1',
				'message' => "Enter valid value",
			)
		),
		'deposit_2' =>  array(
			'empty_deposit' => array(
				'rule' => 'notEmpty',
				'message' => "Enter numeric value",
			),
			'check_numeric' => array(
				'rule' => 'numeric',
				'message' => "Enter deposit 1 value",
			),
			'check_zero_deposit2' => array(
				'rule' => 'check_zero_deposit2',
				'message' => "Enter valid value",
			)
		),
		'gift_service' =>array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Select gift service",
			),
		)
	);

	function isUserUnique($field = null){
		App::import('Model','User');
		$this->User = &new User;
		$user_existed = $this->User->find('first',array('conditions'=>array('User.email'=>$field['email'])));
		if(!empty($user_existed)){
			return false;
		} else {
			return true;
		}
	}

	
	function checknewconfirmpassword($field = null,$second_field = null){
// 		pr($field);pr($second_field); die;
		if(!empty($this->data['Seller'][$second_field])){
			if(!empty($field)){
				foreach($field as $field_check){
					if($field_check != $this->data['Seller'][$second_field]){
						return false;
					}else{
						return true;
					}
				}
			} else{
				return true;
			}
		} else{
			return true;
		}
		
	}
	
	function ordervalue($field = null,$value = null){
//  pr($this->data['Seller'][$value]);pr($field); 
		if(!empty($this->data['Seller'][$value])){
			if((empty($field['threshold_order_value'])) || ($field['threshold_order_value'] == '0') || ($field['threshold_order_value'] == '0.00') || ($field['threshold_order_value'] == '0.0')){
				
				return false;
			} else{
				return true;
			}
		}else{
			return true;
		}
	}

	function isUserUniqueemail(){
		if(!empty($this->data['Seller']['user_id'])){
			return true;
		} else{
			App::import('Model','User');
			$this->User = &new User;
			$ext_user = $this->User->find('first',array('conditions'=>array('User.email'=>$this->data['Seller']['email']),'fields'=>array('User.id')));
			if(!empty($ext_user)){
				return false;
			} else{
				return true;
			}
		}
	}

	function vaild_ph($field_phone = null){
		if(!empty($field_phone["phone"])){
			if(preg_match("/^[0-9 ]+$/", $field_phone["phone"]) === 0)
				return false;
			else 
				return true;
		}
	}
	function check_zero_deposit1($field_deposit = null){  
			if($field_deposit["deposit_1"] == "0.00" || strlen($field_deposit["deposit_1"]) > 5){
				
				return false;
			} else { 
				return true;
			}
		}
	function check_zero_deposit2($field_deposit = null){  
		if($field_deposit["deposit_2"] == "0.00" || strlen($field_deposit["deposit_2"]) > 5){
			
			return false;
		} else { 
			return true;
		}
	}
	function vaild_postcode($field_post = null){
		if(!empty($field_post["postcode"])){
			if(preg_match("/^[a-zA-Z0-9 ]+$/", $field_post["postcode"]) === 0)
				return false;
			else
				return true;
		}
	}
	function vaild_country($field_country = null){
		if(!empty($field_country["country_id"])){
			if($field_country["country_id"] == 7)
				return false;
			else 
				return true;
		}
	}


	function empty_sortcode($field_rracc = null){
		$sort1 = $this->data['Seller']['sortcode1'];
		$sort2 = $this->data['Seller']['sortcode2'];
		$sort3 = $this->data['Seller']['sortcode3'];
		$paypal = $this->data['Seller']['paypal_account_mail'];
			
		if((empty($sort1) || empty($sort2) || empty($sort3)) && empty($paypal) ){
			return false;
		}else if(!empty($paypal) && empty($sort1) && empty($sort2) && empty($sort3)){
			return true;
		}else{
			$is_vaild_sort = $this->vaild_sortcode();
			if(empty($is_vaild_sort)){
				return 'Enter valid sort code';
			} else{
				return true;
			} 
		}
	}

	function vaild_sortcode($field_phone = null){ 
		if(!empty($this->data['Seller']["sortcode1"]) && !empty($this->data['Seller']["sortcode2"]) && !empty($this->data['Seller']["sortcode3"])){
			// check for numbers only
			$a=preg_match("/^[0-9]+$/", $this->data['Seller']["sortcode1"]);
			$b=preg_match("/^[0-9]+$/", $this->data['Seller']["sortcode2"]);
			$c=preg_match("/^[0-9]+$/", $this->data['Seller']["sortcode3"]);

			if($a && $b && $c){
				//check sort code count
				if(strlen($this->data['Seller']["sortcode1"])<=4 && strlen($this->data['Seller']["sortcode2"])<=4 && strlen($this->data['Seller']["sortcode3"])<=4){ 
					return true;
				}else{
					//return 'Please enter vaild sort code';
					return false;
				}
			}else{ 
				//return 'Please enter vaild sort code';
				return false;
			}
		}
	}

	function empty_retypebank_acc($field_rracc = null){
			
		if(!empty($this->data['Seller']["bank_ac_number"])){
			if(empty($this->data['Seller']["retype_bank_account_number"])){
				return false;
			} else {
				return true;
			}
		}else{
			return true;
		}
	}

	function confirm_retypebank_acc($field = null){
		if(!empty($this->data['Seller']['retype_bank_account_number'])){
			if($this->data['Seller']["bank_ac_number"]==$this->data['Seller']["retype_bank_account_number"]){
				return true;
			}else{
				return false;
			}
		} else{
			return true;
		} //return true;
		
	}

	function empty_acc_number($field = null){
		if(empty($this->data['Seller']['bank_ac_number']) && empty($this->data['Seller']['paypal_account_mail'])){
			return false;
		}else if(!empty($this->data['Seller']['paypal_account_mail']) && empty($this->data['Seller']['bank_ac_number'])){
			return true;
		}else{
			return true;
		}
	}
	
	function number_only($field = null){
		if(empty($this->data['Seller']['paypal_account_mail'])){
			if(is_numeric($this->data['Seller']['bank_ac_number']) && $this->data['Seller']['bank_ac_number']!=0 ){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
	function number_only_sc3($field = null){
		if(empty($this->data['Seller']['paypal_account_mail'])){
			if(is_numeric($this->data['Seller']['sortcode3']) && $this->data['Seller']['bank_ac_number']!=0 ){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}

	function empty_account_holder_name($field = null){ 
	
		if(!empty($this->data['Seller']['validation'])){
			$name = $this->data['Seller']['account_holder_name'];
			$paypal = $this->data['Seller']['paypal_account_mail'];
				
			if(empty($name) && empty($paypal)){
				return false;
			} else if(!empty($name) && is_numeric($name)) {
				return false;
			} else if(!empty($name) && empty($paypal)) {
				return true;
			} else if(empty($name) && !empty($paypal)) {
				return true;
			}else{
				return true;
			}
		} else{
			return true;
		}
	}

	function empty_acc_paypal($field = null){
		
		$is_vaild_email = 0;
		if(!empty($this->data['Seller']['validation'])){
			$sort1 = $this->data['Seller']['sortcode1'];
			$sort2 = $this->data['Seller']['sortcode2'];
			$sort3 = $this->data['Seller']['sortcode3'];
			$acc_number = $this->data['Seller']['bank_ac_number'];
			$name = $this->data['Seller']['account_holder_name'];
			$paypal = $this->data['Seller']['paypal_account_mail'];
				
			if(empty($acc_number) && empty($paypal)){
				return false;
			} else if(!empty($acc_number) && !empty($sort1) && !empty($sort2) && !empty($sort3) && !empty($name) && empty($paypal)) {
				return true;
			//} else if(!empty($acc_number) && !empty($sort1) && !empty($sort2) && !empty($sort3) && !empty($name) && !empty($paypal)) {
			} else if((!empty($acc_number) || !empty($sort1) || !empty($sort2) || !empty($sort3) || !empty($name)) && (!empty($paypal))) {	
				return 'Please enter either bank account details or Paypal account details';
			} else if(empty($acc_number) && empty($sort1) && empty($sort2) && empty($sort3) && empty($name) && !empty($paypal)) {
				$is_vaild_email = $this->valid_email($paypal);
				if(empty($is_vaild_email)){
					return 'Enter valid paypal email address';
				} else{
					return true;
				}
			}else{
				return true;
			}
		} else{
			return true;
		}
	}




	function valid_email($email_address = null){
		
		$email_address = trim($email_address);
		if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email_address)) {
			$flag = 1;
		}
		else {
			$flag = 0;
		}
		
		if($flag == 1){
			return true;
		}
		else{
			return false;
		}
	}

	function empty_deposit($field = null){ pr($this->data); exit;
		if(!empty($this->data['Seller']['validation'])){
			if(!empty($field)){
				foreach($field as $f){
					if(empty($f)){
						return false;
					} else{
						return true;
					}
				}
			} else{
				return true;
			}
		} else{
			return true;
		}
		
	}
}
?>