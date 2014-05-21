<?php
/**
* Product Model class
*/
class Product extends AppModel {

	var $name = 'Product';
	var $assocs = array(
		'ProductDetail' => array(
			'type' => 'hasOne',
			'className' => 'ProductDetail',
			'dependent' => true,
		),
		'ProductCategory' => array(
			'type' => 'hasMany',
			'className' => 'ProductCategory',
			'dependent' => true,
		),
		'ProductSeller' => array(
			'type' => 'hasMany',
			'className' => 'ProductSeller',
			'dependent' => true,
		),
		'ProductSiteuser' => array(
			'type' => 'hasMany',
			'className' => 'ProductSiteuser',
			'dependent' => true,
		),
		'ProductSearchtag' => array(
			'type' => 'hasMany',
			'className' => 'ProductSearchtag',
			'dependent' => true,
		),
		'Productimage' => array(
			'type' => 'hasMany',
			'className' => 'Productimage',
			'dependent' => true,
		),
		'ProductQuestion' => array(
			'type' => 'hasMany',
			'className' => 'ProductQuestion',
			'order'=>'ProductQuestion.id DESC',
			'dependent' => true,
		),
		'ProductRating' => array(
			'type' => 'hasMany',
			'className' => 'ProductRating',
			'dependent' => true,
		),
		'Brand' => array(
			'type' => 'belongsTo',
			'className' => 'Brand',
		),
		'Color' => array(
			'type' => 'belongsTo',
			'className' => 'Color',
		),
		'Department' => array(
			'type' => 'belongsTo',
			'className' => 'Department',
			//'foreignKey' =>'id'
		),
	);
	var $validate = array(
		'department_id' => array(
			'rule' => 'notEmpty',
			'message' => "Select department name",
			),
		'category_id' => array(
			'rule' => 'notEmpty',
			'message' => "Select category",
			),
		'product_name' => array(
			'rule' => 'notEmpty',
			'message' => "Enter product name",
		),
		'condition' => array(
			'rule' => 'notEmpty',
			'message' => "Select product condition",
		),
		/*'brand_id' => array(
			'rule' => 'notEmpty',
			'message' => "Select brand name",
		),*/
		'brand_name' => array(
			'rule' => 'notEmpty',
			'message' => "Enter brand name",
		),
		'model_number' => array(
			'rule' => 'notEmpty',
			'message' => "Enter model number",
		),
		'barcode' => array(
			'rule' => 'notEmpty',
			'message' => "Enter barcode number",
		),
		'product_rrp' => array(
			'pr_rrp'=>array(
				'rule' => 'pr_rrp',
				'message' => "Enter product price (RRP)",
			)
		),
		'status' => array(
			'rule' => 'notEmpty',
 			'message' => 'Select status'
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
		'reason' => array(
			'rule' => 'notEmpty',
			'message' => "Enter your reason"
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
/* ************************************************** */	
	
/** ***********************************************************************
	@function	:	generateQuickCode
	@description	:	to generate the product quick code on the basis of product id and department id
	@params		:	NULL
	@created	:	15 Nov 2010
	@credated by	:	kulvinder Singh
	**/
	function generateQuickCode( $prodId = null,$depId = null) {
		$ArrDepartShortCode = array('1'=>'BO','2'=>'MU','3'=>'MV','4'=>'GA','5'=>'EL','6'=>'OF','7'=>'MO','8'=>'HO','9'=>'HE' );
		
		$preFix1 = 'QC';
		
		if( isset($ArrDepartShortCode[$depId]) ){
			$preFix2 = $ArrDepartShortCode[$depId];
		}else{
			$preFix2 = '00';	
		}
		$product_id_len = strlen( trim($prodId) );
		switch($product_id_len):
			case '1':
				$preFix3 = '00000'.$prodId;
				break;
			case '2':
				$preFix3 = '0000'.$prodId;
				break;
			case '3':
				$preFix3 = '000'.$prodId;
				break;
			case '4':
				$preFix3 = '00'.$prodId;
				break;
			case '5':
				$preFix3 = '0'.$prodId;
				break;
			case '6':
				$preFix3 = $prodId;
				break;
			default:
				$preFix3 = $prodId;
				break;
				
		endswitch; // end switch
		
		$finalQuickCode = '';
		$finalQuickCode = $preFix1.$preFix2.$preFix3;
		return $finalQuickCode;
	}

	function pr_rrp($rrp_field = null){
		if($rrp_field['product_rrp'] > 0){
			return true;
		} else {
			return false;
		}
	}

/* ************************************************** */
}
?>