<?php
/**
* ProductSeller Model class
*/
class ProductSeller extends AppModel {
	var $name = 'ProductSeller';
	var $assocs = array(
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
		),
		'ProductCondition' => array(
			'type' => 'belongsTo',
			'className' => 'ProductCondition',
			'foreignKey' => 'condition_id',
		),
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'seller_id',
		),
		'DispatchCountry' => array(
			'type' => 'belongsTo',
			'className' => 'DispatchCountry',
			'foreignKey' => 'dispatch_country',
		),
		'UserSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'seller_id',
			'fields'=>array('id', 'title')
		),
		'ProductVisit' => array(
			'type' => 'belongsTo',
			'className' => 'ProductVisit',
			'foreignKey' => false,
			'conditions' => 'ProductVisit.product_id = ProductSeller.product_id',
		)
	);
	var $validate = array(
		
		'condition_id' => array(
			'notEmpty'=>array(
				'rule' => 'notEmpty',
				'message' => "Enter condition",
				'last' => true
			),
			'vaildcondition'=>array(
				'rule' => 'vaildcondition',
				'message' => "Product with this condition already exists in your listings",
			),
		),
		'seller_id' => array(
			'rule' => 'notEmpty',
			'message' => "Select Seller"
		)
		
		 ,
		'barcode' => array(
			'rule' => 'notEmpty',
			'message' => "Enter barcode number",
		),
		'price' => array(
			'notEmpty'=>array(
				'rule' => 'notEmpty',
				'message' => "Enter price",
				'last' => true
			),
			'positiveValue'=>array(
				'rule' => 'positiveValue',
				'message' => "Price should be a positive number",
			),
		),
		'quantity' => array(
 			'notEmpty'=>array(
 				'rule' => 'notEmpty',
 				'message' => "Enter quantity",
 				'last' => true
 			),
			'positivequantityValue'=>array(
				'rule' => 'positivequantityValue',
				'message' => "Quantity should be a positive number",
			),
		),
		'standard_delivery_price' => array(
 			'notEmpty'=>array(
 				'rule' => 'notEmpty',
				'message' => "Enter standard delivery price",
 				'last' => true
			),
 			'positiveValue'=>array(
 				'rule' => 'positiveValue',
 				'message' => "Quantity should be a positive number",
 			),
			//'rule' => array('validateSDPrice'),
		),
		'dispatch_country' => array(
			'rule' => 'notEmpty',
			'message' => "Select dispatch country"
		),		
		'minimum_price' => array(
			'rule' => array('validateMinPrice'),
			//'message' => "Enter express delivery price",
			//'last'=>true
		),
		'express_delivery_price' => array(
			'rule' => array('validateEDPrice'),
			//'message' => "Enter express delivery price",
			//'last'=>true
		)
		
		
	);
	
	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		$parameters = compact('conditions', 'recursive');
		if (isset($extra['group'])) {
			$parameters['fields'] = $extra['group'];
			if (is_string($parameters['fields'])) {
				// pagination with single GROUP BY field
				if (substr($parameters['fields'], 0, 9) != 'DISTINCT ') {
					$parameters['fields'] = 'DISTINCT ' . $parameters['fields'];
				}
				unset($extra['group']);
				$count = $this->find('count', array_merge($parameters, $extra));
			} else {
				// resort to inefficient method for multiple GROUP BY fields
				$count = $this->find('count', array_merge($parameters, $extra));
				$count = $this->getAffectedRows();
			}
		} else {
			// regular pagination
			$count = $this->find('count', array_merge($parameters, $extra));
		}
		return $count;
	}
	
	
	//  validate ed price  entry if enabled by seller
	function validateEDPrice($field = Null){
		if(isset($this->data['ProductSeller']['express_delivery'])) {
			if(($this->data['ProductSeller']['express_delivery'] == '0') || ($this->data['ProductSeller']['express_delivery'] == '')){
				return true;
			} else{
				if(!empty($this->data['ProductSeller']['express_delivery_price'])){
					if($this->data['ProductSeller']['express_delivery_price'] < 0){
						return 'Express delivery price should be positive';
					} else
						return true;
				}else{
					return "Enter express delivery price";
				}
			}
		} else{
			return true;
		}
	}
	
	//  validate ed price  entry if enabled by seller
	function validateSDPrice($field = Null){
		if(isset($this->data['ProductSeller']['standard_delivery_price'])) {
			if(($this->data['ProductSeller']['standard_delivery_price'] == '0') || ($this->data['ProductSeller']['standard_delivery_price'] == '')){
				return true;
			} else{
				if(!empty($this->data['ProductSeller']['standard_delivery_price'])){
					if($this->data['ProductSeller']['standard_delivery_price'] < 0){
						return 'Standard delivery price should be positive';
					} else
						return true;
				}else{
					return "Standard express delivery price";
				}
			}
		} else{
			return true;
		}
	}
	//  validate validateMinPrice  entry if enabled by seller
	function validateMinPrice($field = Null){
		//PR($this->data['ProductSeller']);
		if(isset($this->data['ProductSeller']['minimum_price_disabled'])){
			if(($this->data['ProductSeller']['minimum_price_disabled'] == '1')){
			//if(($this->data['ProductSeller']['minimum_price_disabled'] == '0')){
				return true;
			} else{
				
				if(!empty($this->data['ProductSeller']['minimum_price'])){
					if($this->data['ProductSeller']['minimum_price'] <= 0){
						return 'Minimum price should be a positive number';
					}elseif($this->data['ProductSeller']['minimum_price'] > $this->data['ProductSeller']['price']){
					return "Please note that minimum price value should be lower than your price";
				}else
						return true;
				}else{
					return "Enter minimum price";
				}
			}
		} else{
			return true;
		}
	}


	function positiveValue($field = null){
// pr($field);
		$value = '';
		if(!empty($field)){
			foreach($field as $field_name)
				$value = $field_name;
		}
		if($value < 0){
			return false;
		} else
			return true;

	}

	function positivequantityValue($field = null){
// pr($field);
		$value = '';
		if(!empty($field)){
			foreach($field as $field_name)
				$value = $field_name;
		}
		if($value < 0){
			return false;
		} else{
			return true;
		}

	}

	function vaildcondition($condition = null){	
	 $userid=$_SESSION['User']['id'];
		$al_exists = $this->find('first',array( 'conditions'=>array('ProductSeller.seller_id'=>$userid,'ProductSeller.condition_id'=>$this->data['ProductSeller']['condition_id'],'ProductSeller.product_id'=>@$this->data['ProductSeller']['product_id'])));
		if(!empty($al_exists)){
			return false;
		} else {
			return true;
		}
	}
}
?>