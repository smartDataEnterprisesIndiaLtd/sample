<?php 
class CommonComponent extends Object
{
	var $components = array('Session','Email');
	/** 
	@function: get_user_billing_info
	@description: get_user_billing_info
	@Created by: Kulvinder
	@Modify:  21 Jan 2011 
	*/
	function get_user_billing_info($user_id){
	    # import user Db
	    App::import('Model','User');
	    $this->User = & new User();
	    $query  = " select User.id,User.title, User.firstname,User.lastname,Address.add_address1,
	    Address.add_address2, Address.add_postcode, Address.add_city,Address.add_state, Address.country_id, Address.add_phone from users User ";
	    $query .= " inner join addresses Address ON  (Address.user_id = User.id )  ";
	    $query .= " where User.id = ".(int)$user_id." AND Address.primary_address = '1' ";
	    $userBillingData = $this->User->query($query);
	   //pr($userBillingData);
	    if( is_array($userBillingData)  && count($userBillingData) > 0){ 
	       return $userBillingData[0];
	    }else{
	       return '';
	    }
	}
	
	
	
	// get countries List as a dropdown 
	function getcountries() {
		// import the country DB
		$country = array();
		App::import("Model","Country");
		$this->Country=& new Country();
		$country =  $this->Country->find('list', array('conditions'=>array('Country.status'=>'1'), 'fields'=>array('Country.id','Country.country_name')));
		return $country;
	}

	// get getDispatchCountries
	function getDispatchCountryList() {
		// import the country DB
		$disCountries = array();
		App::import("Model","DispatchCountry");
		$this->DispatchCountry = &new DispatchCountry();
		$disCountries =  $this->DispatchCountry->find('list',array('fields'=>array('DispatchCountry.id','DispatchCountry.name')));
		return $disCountries;
	}

	// get carriers List as a dropdown 
	function getcarriers() {
		// import the country DB
		$carriers = array();
		App::import("Model","Carrier");
		$this->Carrier = &new Carrier();
		$carriers =  $this->Carrier->find('list',array('conditions'=>array('Carrier.status'=>'1'),'fields'=>array('Carrier.id','Carrier.title'),'order' => 'Carrier.id ASC'));
		return $carriers;
	}

	// get cancel reasons List as a dropdown for seller
	function getcancel_reasons() {
		// import the country DB
		$carriers = array();
		App::import("Model","Reason");
		$this->Reason = &new Reason();
		$reasons =  $this->Reason->find('list',array('conditions'=>array('Reason.status'=>'1'),'fields'=>array('Reason.id','Reason.title')));
		return $reasons;
	}

	// get cancel reasons List as a dropdown for seller
	function getcancel_reasons_buyer() {
		// import the country DB
		$carriers = array();
		App::import("Model","Reason");
		$this->Reason = &new Reason();
		$reasons =  $this->Reason->find('list',array('conditions'=>array('Reason.status'=>'0'),'fields'=>array('Reason.id','Reason.title')));
		return $reasons;
	}

	// get refund reasons List as a dropdown for seller
	function getrefund_reasons_seller() {
		// import the country DB
		$carriers = array();
		App::import("Model","Reason");
		$this->Reason = &new Reason();
		$reasons =  $this->Reason->find('list',array('conditions'=>array('Reason.status'=>'2'),'fields'=>array('Reason.id','Reason.title')));
		return $reasons;
	}
	
	// get country codes List as a dropdown 
	function getCountryCodes() {
		// import the country DB
		$countryCode = array();
		App::import("Model","Country");
		$this->Country=& new Country();
		$countryCode =  $this->Country->find('list', array('conditions'=>array('Country.status'=>'1'), 'fields'=>array('Country.id','Country.country_code')));
		return $countryCode;
	}
	
	/** 
	@function:		get_titles
	@description		to make a list of titles for given them in a dropdown
	@Created by: 		
	@params		
	@Modify:		NULL
	@Created Date:		jan 19, 2011
	*/
	function get_titles(){
		$titles = array(
			'Mr' => 'Mr',
			'Mrs' => 'Mrs',
			'Miss' => 'Miss',
			'Ms' => 'Ms',
			'Dr' => 'Dr'
		);
		return $titles;
	}
	
	/** 
	@function:		conditions_array
	@Modify:		NULL
	@Created Date:		jan 19, 2011
	*/
	function get_new_used_conditions(){
		$conditions = array(
			'1' => 'New',
			'2' => 'Used',
			'3' => 'Used',
			'4' => 'New',
			'5' => 'Used',
			'6' => 'Used',
			'7' => 'Used'
		);
		return $conditions;
	}
	
	
	
	
	// get getconditions List  
	function getconditions() {
		App::import("Model","ProductCondition");
		$this->ProductCondition=& new ProductCondition();
		$condArr = array();
		$condArr =  $this->ProductCondition->find('list');
		return $condArr;
	}
	
	
	
	// get product sellers count 
	function getproductsellercount($product_id) {
		App::import("Model","ProductSeller");
		$ProductSeller=  new ProductSeller();
		$countSellers =  $ProductSeller->find('count' , array('conditions'=> array('ProductSeller.product_id'=>$product_id ) ) );
		return $countSellers;
	}
	
	
	// get product sellers count 
	function getProductSellerIds($product_id) {
		App::import("Model","ProductSeller");
		$ProductSeller=  new ProductSeller();
		$Sellers =  $ProductSeller->find('list' , array('conditions'=> array('ProductSeller.product_id'=>$product_id , 'ProductSeller.listing_status' => '1' ),'fields'=> array('ProductSeller.id','ProductSeller.seller_id') ) );
		
		//pr($Sellers); exit;
		return $Sellers;
	}
	
	
	// get product sellers details 
	function getProductSellerData($product_id, $seller_id, $condition_id =null) {
		$prodSellerInfo = array();
		if(empty($product_id) && is_null($seller_id)  ){
			return $prodSellerInfo;
		}
		App::import('Model','ProductSeller');
		$this->ProductSeller = & new ProductSeller();
		if(!empty($condition_id) ){
			$prodSellerInfo =  $this->ProductSeller->find('first', array(
				'conditions'=>array('ProductSeller.product_id'=>$product_id , 'ProductSeller.seller_id'=>$seller_id ,'ProductSeller.condition_id'=>$condition_id  ),
				'fields'=>array('ProductSeller.quantity','ProductSeller.standard_delivery_price', 'ProductSeller.dispatch_country',
						'ProductSeller.express_delivery','ProductSeller.express_delivery_price', 'ProductSeller.notes','ProductSeller.reference_code' )
				));
		}else{ 
			$prodSellerInfo =  $this->ProductSeller->find('first', array(
				'conditions'=>array('ProductSeller.product_id'=>$product_id , 'ProductSeller.seller_id'=>$seller_id  ),
				'fields'=>array('ProductSeller.quantity','ProductSeller.standard_delivery_price','ProductSeller.dispatch_country',
						'ProductSeller.reference_code','ProductSeller.express_delivery','ProductSeller.express_delivery_price' , 'ProductSeller.reference_code')
				));
		}
		 return $prodSellerInfo;
	}
	
	

	
	// get departments List  
	function getdepartments() {
		App::import("Model","Department");
		$this->Department=& new Department();
		$departmentsArr = array();
		$departmentsArr =  $this->Department->find('list', array('conditions'=>array('Department.status'=>'1'), 'fields'=>array('Department.id','Department.name')));
		return $departmentsArr;
	}
	
	function getTopCategories($department_id){
		App::import('Model', 'Category');
		$Category = & new Category();
		//$conditions = array('Category.department_id ='.$department_id.' AND parent_id = 0 AND status=1' );
		 $depart_cat_array = $Category->find('list', array('conditions'=>  array('Category.department_id'=> $department_id,'Category.parent_id' => '0', 'Category.status'=>'1' ), 
			'fields'=>array('Category.id', 'Category.cat_name'),
			'order' => 'Category.cat_name ASC'
		) );
		
		return $depart_cat_array;
	}
	
	// get sellers List  
	function getsellers() {
		App::import("Model","User");
		$this->User=& new User();
		$sellersArr = array();
		$sellersArr =  $this->User->find('all', array(
			'conditions'=>array('User.user_type'=>'1'),
			'fields'=>array('User.id','User.firstname', 'User.lastname'),
			'order'=>'User.firstname'  )
			);
		if(is_array($sellersArr)){
			foreach($sellersArr as $seller){
				if(!empty($seller['User']['firstname']) ){
					$seller_array[$seller['User']['id']] = $seller['User']['firstname']." ". $seller['User']['lastname'];
				}
			}
		}
	    return $seller_array;
	}
	
	
	
	// get EmailTemplate List
	// get a list of templates on the basis of Id
	function getEmailTemplate($id = null) {
		if( empty($id) || is_null($id) ){
			return false;
		}
		App::import('Model','EmailTemplate');
		$this->EmailTemplate = & new EmailTemplate();
		$template = $this->EmailTemplate->find('first',array(
			'conditions'=>array("EmailTemplate.id" => $id),
			'fields' =>array( 'EmailTemplate.description','EmailTemplate.subject','EmailTemplate.from_email')));
		return $template;
	}
	
	
	
	// get getUserMailInfo 
	// user information to mail
	function getUserMailInfo($id = null) {
		if( empty($id) || is_null($id) ){
			return false;
		}
		App::import('Model','User');
		$this->User = & new User();
		$userArr  = $this->User->find('first',array(
			'conditions'=>array("User.id"=>$id),
			'fields' =>array( 'User.firstname','User.lastname','User.email')));
		return $userArr;
	}
	
	// get getbrands List  
	function getbrands() {
		App::import('Model','Brand');
		$this->Brand = & new Brand();
		$brandsArr = array();
		$brandsArr =  $this->Brand->find('list', array('order'=>array('Brand.name ASC') ));
		return $brandsArr;
	}	
	// get getBrandIdByName List  
	function getBrandIdByName($brand_name) {
		$brand_name = trim($brand_name);
		App::import('Model','Brand');
		$this->Brand = & new Brand();
		$brandsArr = array();
		$queryStr = "select id from brands where UCASE(name) = '".strtoupper($brand_name)."' ";
		$brandsArr =  $this->Brand->query($queryStr);
		if(count($brandsArr) > 0  ){
			return $brandsArr[0]['brands']['id'];
		} else {
			return 0;
		}
	}
	
	/**************************
	function to get product id from product quick code
	**/
	function getProductIdfromQuickCode($quickCode){
		if(!empty($quickCode)){
			App::import('Model', 'Product');
			$this->Product = &new Product;
			$prodArr   = $this->Product->find('first' , array(
			'conditions' => array('Product.quick_code' => trim($quickCode) ),
			'fields' => array('Product.id')
			));
			if(!empty($prodArr)  &&  count($prodArr) > 0  ) {
				if($prodArr['Product']['id'] == ''){
					return false;
				} else {
					return $prodArr['Product']['id'];
				}
			} else {
				return false;
			}
		} else{
			return false;
		}
	}
	
	#
	#function to get product quick code from product ids
	#@ created : kulvinder
	#@created :04-02-2011
	#
	function getProductQuickCode($productIds){
		App::import('Model', 'Product');
		$this->Product = &new Product;
		
		$productCodes = array();
		$dataArray   = $this->Product->find('all' ,array(
		'conditions' => array('Product.id IN('.$productIds.')' ),
		'fields' => array('Product.quick_code')
		));
		if(!empty($dataArray) ){
		    foreach($dataArray as $data){
			$productCodes[] = $data['Product']['quick_code'];
		    }
		}
		return array_unique($productCodes);
	}
	
	#
	#function to get product department ids  from product ids
	#@ created : kulvinder
	#@created :04-02-2011
	#
	function getProductDepartments($productIds){
		App::import('Model', 'Product');
		$this->Product = &new Product;
		
		$productDepartments = array();
		$dataArray   = $this->Product->find('all' ,array(
		'conditions' => array('Product.id IN('.$productIds.')' ),
		'fields' => array('Product.department_id')
		));
		if(!empty($dataArray) ){
		    foreach($dataArray as $data){
			$productDepartments[] = $data['Product']['department_id'];
		    }
		}
		return array_unique($productDepartments);
	}
	
	
	
	/**
	* @Date: 
	* @Method : validEmailId
	* @Purpose: Validate email Id if filled
	* @Param:  $value
	* @Return: boolean
	**/
	function validEmailId($value = null)
	{
		$v1 = trim($value);
		if($v1 != "" && !eregi("^[\'+\\./0-9A-Z^_\`a-z{|}~\-]+@[a-zA-Z0-9_\-]+(\.[a-zA-Z0-9_\-]+){1,3}$",$v1)){
			return false; 
		}
		return true;
	}


	

	// return an array of files in directory else false if none found
	function get_files($directory, $pattern = false) {
		if(!isset($directory) OR is_dir($directory) == false ) return false;
		$returnval = array();
		if(false != ($handle = opendir($directory))) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if($pattern != false) {
						if(preg_match("$pattern", $file) > 0 ) {
						$returnval[] = $file;
						}
					}else{
						$returnval[] = $file;
					}
				}
			}
		}
		closedir($handle);
		return $returnval;
	}
	

        /** 
	@function: get_basket_listing
	@description: get_basket_listing
	@Created by: Kulvinder
	@Modify:  12 JAn 2010 
	*/
	function get_basket_listing(){
		# import basket Db
		App::import('Model','Basket');
		$this->Basket = & new Basket();
		$logg_user_id = $this->Session->read('User.id');
		$session_id = session_id();
		$query  = " select Basket.id,Basket.offer_id,Basket.product_id, Basket.qty,Basket.price,Basket.seller_id,Basket.condition_id,Basket.giftwrap,Basket.giftwrap_cost,Basket.giftwrap_message,
		Basket.delivery_method, Basket.delivery_cost,Basket.exp_delivery_cost, Basket.standard_delivery_date,Basket.express_delivery_date, Basket.estimated_dispatch_date, Product.product_name,Product.quick_code,Product.product_image from baskets Basket inner join products Product ON (Product.id= Basket.product_id)";
		$query .= " where Basket.session_id = '".$session_id."' AND Basket.seller_id != 0    order by Basket.id asc";
		$cartData = $this->Basket->query($query);
		// */
		return $cartData;
	}
	
	
	 /** 
	@function: getDeliveryCharges
	@description: get delivery charges for a product
	@Created by: Kulvinder
	@Modify:  13 March 2011  
	*/
	function getDeliveryCharges($product_id = null, $seller_id = null, $condition_id = null) {
		if(empty($product_id) && is_null($seller_id)  ){
			 return false;
		}
		App::import('Model','ProductSeller');
		$this->ProductSeller = & new ProductSeller();
		
		$prodSellerInfo =  $this->ProductSeller->find('first', array(
				'conditions'=>array('ProductSeller.product_id'=>$product_id , 'ProductSeller.seller_id'=>$seller_id , 'ProductSeller.condition_id'=>$condition_id ),
				'fields'=>array('ProductSeller.standard_delivery_price')
				));
		if(is_array($prodSellerInfo)){
			return $prodSellerInfo['ProductSeller']['standard_delivery_price'];
		}else{
			return 0;
		}
	}
	
	
	
	
	
	
	/**
	 *
	 * descxription used to genrate unique code
	 *
	 *
	 **/
	function generate_code(){
		$date_time = 'smartdata'.time();
		$str_date_time = md5(strtotime($date_time));

		for($i=0; $i < strlen($str_date_time); $i++){
			$date_timeArr[$i] = $str_date_time[$i];
		}
		$rand_str = '';
		for($j=0; $j < 15; $j++){
			$rand_char = array_rand($date_timeArr);
			$rand_str = $rand_str.$date_timeArr[$rand_char];
			
		}
		$rand_str = strtoupper($rand_str);
		return $rand_str;
	}

	/**
	 *
	 * descriptin to generate the random number
	 *
	 *
	 **/
	function randomNumber($length)
	{
	    $random= "";
	    srand((double)microtime()*1000000);
	    
	    $data  = "Ab123IJ89256RS562WX48Z";
	    $data .= "aBCd15896absd8452en123opq45rs67uv89wx85z";
	    $data .= "0FGH45OP89";
	    
	    for($i = 0; $i < $length; $i++)
	    {
		$random .= substr($data, (rand()%(strlen($data))), 1);
	    }
	
	    return $random;
	} 

	
	function get_site_settings(){
		App::import("Model","Setting");
		$this->Setting = & new Setting();
		$settings = $this->Setting->find('first');
		return $settings;
	}
	
	
	
	/** 
	@function: getProductSellers
	@Created by: Kulvinder
	@Modify:  11 JAn 2010 
	*/
	function getProductSellers($product_id = null) {
		$prodSellers = array();
		if(empty($product_id) && is_null($product_id)  ){
			return $prodSellers;
		}
		App::import('Model','ProductSeller');
		$this->ProductSeller = & new ProductSeller();
		//$this->ProductSeller->expects( array('Seller') );
		$prodSellers =  $this->ProductSeller->find('first', array(
		    'conditions'=>array('ProductSeller.product_id'=>$product_id  ),
		    'fields'=>array('ProductSeller.quantity','ProductSeller.seller_id','ProductSeller.condition_id',
		    'ProductSeller.standard_delivery_price','ProductSeller.notes',
		    'ProductSeller.express_delivery','ProductSeller.express_delivery_price')
		    ));
		// return $prodSellers;
		return $prodSellers;
	}
	
	
	/** 
	@function : checkUniquecode
	@description : to check uniqueness from a given table
	@params : NULL
	@created : Jan 28, 2010
	@credated by : Ramanpreet Pal Kaur
	**/
	function checkUniquecode($code = null,$model = null) {
		App::import('Model', $model);
		$this->$model = &new $model();
		if(!empty($model)){
			$iscode_existed = $this->$model->find('all',array('conditions'=>array($model.'.code'=>$code) ) );
			if(!empty($iscode_existed) ) {
				$autocode1 = $this->Common->generate_code();
				$return_autocode = $this->checkUniquecode($autocode1);
			}
			$returncode = $code;
			return $returncode;
		}
	}
	
	function getCharmonth($monthnum = null){
		if($monthnum == 1)
			$month = 'January';
		else if($monthnum == 2)
			$month = 'February';
		else if($monthnum == 3)
			$month = 'March';
		else if($monthnum == 4)
			$month = 'April';
		else if($monthnum == 5)
			$month = 'May';
		else if($monthnum == 6)
			$month = 'June';
		else if($monthnum == 7)
			$month = 'July';
		else if($monthnum == 8)
			$month = 'August';
		else if($monthnum == 9)
			$month = 'September';
		else if($monthnum == 10)
			$month = 'October';
		else if($monthnum == 11)
			$month = 'November';
		else if($monthnum == 12)
			$month = 'December';
		else
			$month = 'Undefined';
		return $month;
	}
	
	/** 
	@function : getSellerInfo
	@description : to get information of seller
	@params : seller_id
	@created : 11 Feb, 2011
	@credated by :Kulvinder
	**/
 	function getSellerInfo($seller_id = null) {
	    if(empty($seller_id) ){
		return '';
	    }
	    # import database
	    App::import('Model','Seller');
	    $this->Seller = & new Seller();
	    $SellerDetails  = $this->Seller->find('first',array(
	      'conditions'=>array("Seller.user_id"=>$seller_id),
	     'fields' =>array( 'Seller.business_name','Seller.business_display_name','Seller.service_email', 'Seller.free_delivery', 'Seller.threshold_order_value')));
	    return $SellerDetails;
 

 	}



	/** 
	@function: getallsellers_product
	@description : to get all seller for a given condition of a product
	@params : product_id,$conditions
	@created : 02 Feb, 2011
	@credated by :Ramanpreet Pal Kaur
	*/
	function getallsellers_product($product_id = null,$conditions= null) {
		$allSellers = array();
		if(empty($product_id) && is_null($product_id) ){
		} else{
			App::import('Model','ProductSeller');
			$this->ProductSeller = & new ProductSeller();

// 			$this->ProductSeller->expects(array('User'));
	
			

// 			$prodSellers =  $this->ProductSeller->find('all', array('conditions'=>array('ProductSeller.product_id'=>$product_id,'ProductSeller.condition_id IN ('.$conditions.')'),'fields'=>array('ProductSeller.id','ProductSeller.quantity','ProductSeller.seller_id','ProductSeller.condition_id','ProductSeller.standard_delivery_price','ProductSeller.notes','ProductSeller.express_delivery','ProductSeller.express_delivery_price','ProductSeller.price'),'order'=>array('ProductSeller.price')));

			$this->paginate = array(
				'limit' => 1,
				'conditions' => array('ProductSeller.product_id'=>$product_id,'ProductSeller.condition_id IN ('.$conditions.')'),
				'order' => array(
					'ProductSeller.price' => 'ASC'
				),
				'fields' => array(
					'ProductSeller.id',
					'ProductSeller.quantity',
					'ProductSeller.seller_id',
					'ProductSeller.condition_id',
					'ProductSeller.standard_delivery_price',
					'ProductSeller.notes',
					'ProductSeller.express_delivery',
					'ProductSeller.express_delivery_price',
					'ProductSeller.price'
				)
			);
			$prodSellers = $this->paginate('ProductSeller');



			if(!empty($prodSellers)){
				App::import('Model','User');
				$this->User = & new User();
				$this->User->expects(array('Seller'));
				$i = 0;
				foreach($prodSellers as $prodSeller){
					$sellerinfo =  $this->User->find('first', array('conditions'=>array('User.id'=>$product_id),'fields'=>array('User.id','User.title','User.firstname','User.lastname','Seller.id','Seller.user_id','Seller.free_delivery','Seller.threshold_order_value')));
					$prodSellers[$i]['User'] = $sellerinfo['User'];
					$prodSellers[$i]['Seller'] = $sellerinfo['Seller'];
					$i = $i+1;
				}
			}
		}

		return $prodSellers;
	}


	function get_filterTime(){
		$filter_time = array('1d'=>'Last 24 Hours','3d'=>'Last 3 Days','7d'=>'Last 7 Days','15d'=>'Last 15 Days','30d'=>'Last 30 Days','3m'=>'Last 3 Months','6m'=>'Last 6 Months','1m'=>'last 12 Months','ALL'=>'All Time');
		return $filter_time;
	}

	/** 
	@function: positivePercentFeedback
	@description: to get positive pecentage feedbacks for seller
	@Created by: Ramanpreet Pal Kaur
	@params	
	@Created Date: Jan 24, 2011
	*/
	function positivePercentFeedback($seller_id = null,$product_id = null){
		$current_date = date('Y-m-d');
		$current_year = date('Y');
		$current_month = date('m');
		$current_day = date('d');
		$before_year = $current_year-1;
		$before_year_date = $before_year.'-'.$current_month.'-'.$current_day;
			
		App::import('Model','Feedback');
		$this->Feedback = &new Feedback;
		
		$totallastyear_rating = 0;
		
		$conditions_str = '';
// 		if(!empty($product_id)){
// 			$conditions_str = 'Feedback.seller_id = '.$seller_id.' AND Feedback.product_id = '.$product_id;
// 		} else{
			//$conditions_str = 'Feedback.seller_id = '.$seller_id;
// 		}
			
		$conditions_str = 'Feedback.seller_id = '.$seller_id;
		//$totallastyear_rating = $this->Feedback->find('count',array('conditions'=>array($conditions_str,'Feedback.created >= "'.$before_year_date.'"')));
		$totallastyear_rating = $this->Feedback->find('all',array('fields'=>array('sum(Feedback.rating) as total_rating'),'conditions'=>array($conditions_str,'Feedback.created >= "'.$before_year_date.'"')));
		$totallastyear_rating = $totallastyear_rating[0][0]['total_rating'];
		
		if(empty($totallastyear_rating)){
			$before_year_date = ($before_year-1).'-'.$current_month.'-'.$current_day;
			$totallastyear_rating = $this->Feedback->find('count',array('conditions'=>array($conditions_str,'Feedback.created >= "'.$before_year_date.'"')));
		}			
		//$totalpos_lastyear_rating = $this->Feedback->find('count',array('conditions'=>array($conditions_str,'Feedback.created >= "'.$before_year_date.'"','(Feedback.rating = 4 OR Feedback.rating = 5)')));
		$totalpos_lastyear_rating = $this->Feedback->find('count',array('conditions'=>array($conditions_str,'Feedback.created >= "'.$before_year_date.'"')));
		if(!empty($totallastyear_rating)) {
			$positive_percentage = round($totallastyear_rating/($totalpos_lastyear_rating * 5) * 100, 2);
			//$positive_percentage = round((($totalpos_lastyear_rating*5)/$totallastyear_rating)* 100,2);
		} else{
			$positive_percentage = 0;
		}
		return $positive_percentage;
	}

	/** 
	@function: avgSellerRating
	@description: to get average seller rating
	@Created by: Ramanpreet Pal Kaur
	@params	
	@Created Date: Jan 24, 2011
	*/
	function avgSellerRating($seller_id = null,$product_id = null){
		$avg_half_star = 0;$avg_full_star = 0;
		App::import('Model','Feedback');
		$this->Feedback = &new Feedback;


		$conditions_str = '';
		if(!empty($product_id)){
			$conditions_str = 'Feedback.seller_id = '.$seller_id.' AND Feedback.product_id = '.$product_id;
		} else{
			$conditions_str = 'Feedback.seller_id = '.$seller_id;
		}


		$count_rating = $this->Feedback->find('count',array('conditions'=>array($conditions_str)));
		
		$decimal_val = 0;
		$total_avg_rating = $this->Feedback->find('all',array('conditions'=>array($conditions_str),'fields'=>array('Avg(rating) as avg_rating')));
		$avg_rate_array = array();
		$total_avg_rating[0][0]['avg_rating'] = round($total_avg_rating[0][0]['avg_rating'],1);
		if(!empty($total_avg_rating[0][0]['avg_rating'])){
			$avg_rate_array = explode('.',$total_avg_rating[0][0]['avg_rating']);
			if(count($avg_rate_array) >0){
				//pr($avg_rate_array);
				if(!empty($avg_rate_array[1])){
					if($avg_rate_array[1] < 5){
						$avg_half_star = 0;
						$decimal_val = 0;
					}else{
						$avg_half_star = 1;
						$decimal_val = 5;
					}
				} else{
					$avg_half_star = 0;
					$decimal_val = 0;
				}
			}
			$avg_full_star = floor($total_avg_rating[0][0]['avg_rating']);
			$total_avg_rating = round($total_avg_rating[0][0]['avg_rating']);
		}
		$avgrating['value'] = $avg_full_star.'.'.$decimal_val;
		$avgrating['avg_half_star'] = $avg_half_star;
		$avgrating['avg_full_star'] = $avg_full_star;
		$avgrating['count_total_rating'] = $count_rating;
		return $avgrating;
	}

	/** 
	@function : check_userOrder
	@description : to validate that a given order is belonged to that given user or not
	@params : 
	@Modify : 
	@Created Date : Mar 6,2011
	@Created By : Ramanpreet Pal Kaur
	*/
	function check_userOrder($order_id = null,$user_id = null){
		App::import('Model','Order');
		$this->Order = & new Order();
		$is_loggedin_uesrsOrder = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_id,'Order.user_id'=>$user_id,'Order.deleted'=>'0'),'fields'=>array('Order.id')));

		if(empty($is_loggedin_uesrsOrder)){
			return false;
		} else{
			return true;
		}
	}


	/** 
	@function : setMinimumPriceNewProduct
	@description : to set minimum price of a product when a new seller add that product in his list
	@params : 
	@Modify : 
	@Created Date : Mar 11,2011
	@Created By : Ramanpreet Pal Kaur
	*/
	function setMinimumPriceProductNewSeller($product_id = null,$condition = null){

		App::import('Model','Product');
		$this->Product = & new Product();

		$minPriceData  = $this->getProductMinimumPrice($product_id, $condition);

		if($condition == 'NEW'){
			$this->data['Product']['minimum_price_value'] = $minPriceData['price'];
			$this->data['Product']['minimum_price_seller'] = $minPriceData['seller_id'];
			$this->data['Product']['new_condition_id'] = $minPriceData['condition_id'];
		} else if($condition = 'USED'){
			$this->data['Product']['minimum_price_used'] = $minPriceData['price'];
			$this->data['Product']['minimum_price_used_seller'] = $minPriceData['seller_id'];
			$this->data['Product']['used_condition_id'] = $minPriceData['condition_id'];
		}
		$this->data['Product']['id'] = $product_id;
		$this->Product->set($this->data);
		$this->Product->save($this->data);
	}


	/**
	@function : setProductMinimumPrice 
	@description : update product minimum price for  product
	@Created by : kulvinder singh
	@Modify : NULL
	*/	
	function getProductMinimumPrice($product_id = null, $condition = null ) {
		if(empty($product_id) && is_null($product_id)  ){
		     return false;
		}
		
		if(empty($condition)){
		     $strCondition = " 1,4 "; // for new products 
		}else{
		    if(strtoupper($condition) == "USED"){
			$strCondition = " 2,3,5,6,7 "; // for used products
		    }else{
			 $strCondition = " 1,4 "; // for new products 
		    }
		}
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		
		$priceQuery = "  select condition_id, price,(price+standard_delivery_price) as total_price,minimum_price,standard_delivery_price, seller_id from product_sellers AS ProductSeller ";
		$priceQuery .= " where product_id = '".$product_id."' AND listing_status = '1' AND  condition_id IN ($strCondition) ";
		$priceQuery .= " order by total_price ASC limit 1 ";

		$leastTotalPriceArr  = $this->ProductSeller->query($priceQuery);

		# price existes for this  product
		if(count($leastTotalPriceArr)  > 0){ // price existes for thsi product
			$minpriceQuery = " select condition_id, price,minimum_price,standard_delivery_price, seller_id from product_sellers AS ProductSeller ";
			$minpriceQuery .= " where product_id = '".$product_id."' AND listing_status = '1' AND minimum_price != '0.00' AND minimum_price_disabled = '0' AND  condition_id IN ($strCondition) order by minimum_price limit 1";
			$leastMinPriceArr  = $this->ProductSeller->query($minpriceQuery);
			if(count($leastMinPriceArr) > 0){ // min price sellers exists for this product
				
				$lpSeller  =  (int)$leastTotalPriceArr[0]['ProductSeller']['seller_id'];
				$lmpSeller =  (int)$leastMinPriceArr[0]['ProductSeller']['seller_id'];
				$leastPrice    = $leastTotalPriceArr[0][0]['total_price'];
				$leastMinPrice = $leastMinPriceArr[0]['ProductSeller']['minimum_price'];
				
				# if other seller exists for this product offering the low price then set this with less 0.01 amount 
				if( ($leastMinPrice < $leastPrice) && ( $lpSeller != $lmpSeller ) ){
					$offerPrice = $leastPrice - 0.01;
					$dataArr['price']        = $offerPrice - $leastMinPriceArr[0]['ProductSeller']['standard_delivery_price'] ;
					$dataArr['seller_id']    = $leastMinPriceArr[0]['ProductSeller']['seller_id'];
					$dataArr['condition_id'] = $leastMinPriceArr[0]['ProductSeller']['condition_id'];
				
				}else{
					$dataArr['price']        = $leastTotalPriceArr[0]['ProductSeller']['price'];
					$dataArr['seller_id']    = $leastTotalPriceArr[0]['ProductSeller']['seller_id'];
					$dataArr['condition_id'] = $leastTotalPriceArr[0]['ProductSeller']['condition_id'];
				}
				
			}else{ // no min price found and set the least price seller data for product
				$dataArr['price']        = $leastTotalPriceArr[0]['ProductSeller']['price'];
				$dataArr['seller_id']    = $leastTotalPriceArr[0]['ProductSeller']['seller_id'];
				$dataArr['condition_id'] = $leastTotalPriceArr[0]['ProductSeller']['condition_id'];
			}
			
		}else{
			return false;
		}
		 return $dataArr;
	}
	
	function get_ordercertificate($order_certi_id = null){
		$data_certificate = array();
		App::import('Model','OrderCertificate');
		$this->OrderCertificate = new OrderCertificate();
		if(!empty($order_certi_id))
			$data_certificate = $this->OrderCertificate->find('first',array('conditions'=>array('OrderCertificate.id'=>$order_certi_id)));
		return $data_certificate;
	}

	function fh_call(){
		$ws_location='http://82.165.37.158:9180/fredhopper-ws/services/FASWebService?wsdl';
		//Create a new soap client
		$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
	}
	
	/** 
	@function:	 adminBreadcrumb	
	@description	create breadcrumb for category page	in admin side
	@Created by: 	kulvinder Singh	
	@params		deaprtment id , category id 
	@Modify:		NULL
	@Created Date:		
	*/
	function adminCategoryBreadcrumb($department_id , $cat_id = null){
		App::import('Model','Department');
		$this->Department = &new Department;
		$departArr  = $this->Department->find('first' , array(
			'conditions' => array('Department.id' => $department_id),
			'fields' => array('Department.name', 'Department.id')
			));
		if(is_null($cat_id) ){
			$strLink = $departArr['Department']['name'];
			$finalArr='';
		}else{
			$finalArr  = $this->getParentCategoryArray($cat_id);
		}
		return $finalArr;
	}
	
	/********************************************** */
	/** 
	@function:	 getParentCategory	
	@description	get list of all parent category ids 
	@Created by: 	kulvinder Singh	
	@params		category id 
	@Modify:		NULL
	@Created Date:		21-10-2010
	*/
	function getParentCategory($cat_id = null){
		static $strIds ;
		static $strCatNames ;
		App::import('Model','Category');
		$this->Category = &new Category;
		
		//$arrValues = array();
		$catArr  = $this->Category->find('first' , array(
			'conditions' => array('Category.id' => $cat_id),
			'fields' => array('Category.cat_name', 'Category.id','Category.department_id','Category.parent_id')
			));
		
		$strIds = $strIds."#".$catArr['Category']['id'];
		$strCatNames = $strCatNames."#".$catArr['Category']['cat_name'];
		
		if($catArr['Category']['parent_id'] != 0 ){
			$this->getParentCategory($catArr['Category']['parent_id']);
		}
		$strIds = ltrim($strIds, '#');
		$strCatNames = ltrim($strCatNames, '#');
		$arrValues['ids']  = $strIds;
		$arrValues['name'] = $strCatNames;
		return $arrValues;
	}
	
	
	/********************************************** */
	/** 
	@function:	 getParentCategoryArray	
	@description	get list of all parent category array 
	@Created by: 	kulvinder Singh	
	@params		category id 
	@Modify:		NULL
	@Created Date:		17 NOv 2010
	*/
	function getParentCategoryArray($cat_id = null){		
		$strCategory = $this->getParentCategory($cat_id);
		//pr($strCategory);
		$strCatIdsArr = array();
		$strCatNameArr = array();
		$strCatIdsArr = explode("#" ,$strCategory['ids'] );
		$strCatIdsArr = array_reverse($strCatIdsArr);
		$strCatNameArr = explode("#" ,$strCategory['name'] );
		$strCatNameArr = array_reverse($strCatNameArr);
		$finalArr = array_combine($strCatIdsArr ,$strCatNameArr);
		return $finalArr;
	}
	
	
	/********************************************** */
	/** 
	@function:	 sendEmailAlert	
	@description	get list of all parent category array 
	@Created by: 	nakul kumar
	@params		user_id 
	@Modify:	NULL
	@Created Date:	22 Aug 2011
	*/
	function sendEmailAlert($to_id = null){
		if(empty($to_id)){
			return false;
		}
		
		App::import('Model','User');
		$this->User = new User;
		$user_email=$this->User->find('first' , array(
						'conditions' => array('User.id' => $to_id),
						'fields' => array('User.id' , 'User.Email')
					      ));
		$user_email_id = $user_email['User']['Email'];
			
		/** Send email after send messages **/
			$this->Email->smtpOptions = array(
				'host' => Configure::read('host'),
				'username' =>Configure::read('username'),
				'password' => Configure::read('password'),
				'timeout' => Configure::read('timeout')
			);
			
			$this->Email->replyTo=Configure::read('replytoEmail');
			$this->Email->sendAs= 'html';
			//$this->Email->sendAs= 'both';
			$link=Configure::read('siteUrl');
			/******import emailTemplate Model and get template****/
			
			App::import('Model','EmailTemplate');
			$this->EmailTemplate = new EmailTemplate;
			/**
			table: email_templates
			id: 28
			description: ad feedback mail format for admin
			*/
			$template = $this->getEmailTemplate(15);
						
			$data = $template['EmailTemplate']['description'];
			
			$this->Email->from = $template['EmailTemplate']['from_email'];
			$this->Email->subject = $template['EmailTemplate']['subject'];
			
			//$user_email_id='testing.sdei@gmail.com';
			$this->Email->to = $user_email_id;
									
			/******import emailTemplate Model and get template****/
			//$this->Email->template='commanEmailTemplate';
			//$this->Email->message=$data;
			if($this->Email->send($data)){
				return true;
			}else{
				return false;
			}
	}
	
/*
	@function: getProductUrl
	@description: To pass in Url conversion Product name+Brand Name+ProductModelNumber
	@Created by: Nakul Kumar
	@Modify:  24 Oct 2011 
	*/	
	function getProductUrl($id = null) {
		App::import('Model','Product');
		$this->Product = & new Product();
		$this->Product->expects(array('Brand'));
		$ProductUrlData = $this->Product->find('first',array('conditions'=>array(
				'Product.id'=> $id ),
				'fields'=> array('Product.id ','Product.product_name ','Product.model_number' , 'Product.brand_id' , 'Brand.name')
				));
		if(count($ProductUrlData) > 0  ){
				$productName = $ProductUrlData['Product']['product_name'].'-'.$ProductUrlData['Brand']['name'].'-'.$ProductUrlData['Product']['model_number'];				
				//return str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($productName, ENT_NOQUOTES, 'UTF-8'));
				$productName = strtolower($productName);
				return str_replace(array('   ','  ',' ',' / ','/','&quot;','&','---','--'), array('-','-','-','-','','"','and','-','-'),$productName);

			} else {
				return 0;
		}
	}
	
	/*
	@function: GetProductBySelerId
	@description: use in admin Panel for show the total number of product SellerID
	@Created by: Nakul Kumar
	@Modify:  19 Oct 2012 / 05 JUL 2013 on use remove form admin list replace by instock/Outstock
	
	*/
	function totalnoProductSeller(){
		App::import("Model","ProductSeller");
		$ProductSeller =  new ProductSeller();
		$SellersProducts =  $ProductSeller->find('all' ,
			array('conditions'=> array('ProductSeller.listing_status' => '1'),
			'fields'=> array('ProductSeller.seller_id','count(ProductSeller.id) as tProduct',),
			'group' => array('ProductSeller.seller_id')
			));
		foreach($SellersProducts as $SellersProduct){
			$SellersTotalProductes[$SellersProduct['ProductSeller']['seller_id']] = $SellersProduct[0]['tProduct'];
		}
		return $SellersTotalProductes;
	}
	
	function inSotckProductSeller(){
		App::import("Model","ProductSeller");
		$ProductSeller =  new ProductSeller();
		$SellersProducts =  $ProductSeller->find('all' ,
			array('conditions'=> array('ProductSeller.listing_status' => '1','ProductSeller.quantity > 0'),
			'fields'=> array('ProductSeller.seller_id','count(ProductSeller.id) as tProduct',),
			'group' => array('ProductSeller.seller_id')
			));
		foreach($SellersProducts as $SellersProduct){
			$inStockSellerProductes[$SellersProduct['ProductSeller']['seller_id']] = $SellersProduct[0]['tProduct'];
		}
		return $inStockSellerProductes;
	}
	function outSotckProductSeller(){
		App::import("Model","ProductSeller");
		$ProductSeller =  new ProductSeller();
		$SellersProductsOut =  $ProductSeller->find('all' ,
			array('conditions'=> array('ProductSeller.listing_status' => '1','ProductSeller.quantity <= 0'),
			'fields'=> array('ProductSeller.seller_id','count(ProductSeller.id) as outProduct',),
			'group' => array('ProductSeller.seller_id')
			));
		foreach($SellersProductsOut as $SellersProductOut){
			$outStockSellerProductes[$SellersProductOut['ProductSeller']['seller_id']] = $SellersProductOut[0]['outProduct'];
		}
		return $outStockSellerProductes;
	}
	
	/*
	@function: getSellerModifyProduct
	@description: use in admin Panel for get user Last Login date
	@Created by: Nakul Kumar
	@created on :  05 07 2013
	*/
	function sellerLastModifyProduct($seller_id = null){
		App::import("Model","ProductSeller");
		$ProductSeller =  new ProductSeller();
		$SellerLastModify =  $ProductSeller->find('first' ,
			array(
			'conditions'=> array('ProductSeller.seller_id' => $seller_id),	
			'fields'=> array('ProductSeller.modified'),
			'order'=> array('ProductSeller.modified DESC'),
			));
		return $lastModified = $SellerLastModify['ProductSeller']['modified'];
	}
	
	/*
	@function: getUserLastLogin
	@description: use in admin Panel for get user Last Login date
	@Created by: Nakul Kumar
	@created on :  05 07 2013
	*/
	function getUserLastLogin($user_id = null){
		App::import("Model","UserLog");
		$UserLog =  new UserLog();
		$UserLastLogin =  $UserLog->find('first' ,
			array(
			'conditions'=> array('UserLog.user_id' => $user_id),	
			'fields'=> array('MAX(UserLog.login_time) as login_times'),
			));
		
		return $lastLoginTime = $UserLastLogin['0']['login_times'];
	}
	
	/*
	@function: currencyEnter
	@description: Used to converty currency £ and \n\r for enter.
	@Created by: Nakul kumar
	@Modify:  08 Nov 2012
	*/	
	function currencyEnter($str) {
		$returnStr = iconv("UTF-8", "ISO-8859-1//TRANSLIT", nl2br(htmlentities(__($str,true))));
		return $returnStr;
	}
	
	/*
	@function: lastMsgBuyer
	@description: Used to Get last message id from message table.
	@Created by: Nakul kumar
	@Modify:  26 Feb 2013
	*/	
	function lastMsgBuyer($buyer_id) {
		App::import("Model","Message");
		$Message =  new Message();
		$user_id = $this->Session->read('User.id');
		$Message_id =  $Message->find('first' ,
			array('conditions'=>array('Message.to_user_id'=>$user_id,'Message.from_user_id'=>$buyer_id, 'Message.reply_id'=>NULL),
			'fields'=> array('Message.id'),
			'order'=> 'Message.id DESC',
			));
		$Message_id= $Message_id['Message']['id'];
		return $Message_id;
	}
	
	
	 /*

    Function Name:  autoComplete

    Functionality:  auto complete suggestion for any Data Base Model 

    @params:        $auto_complete_data

                      - Model                 

                      - Field

                      - q(query string)

  */

  function autoComplete($auto_complete_data=array()){
    if(!empty($auto_complete_data)){

      $model_name = $auto_complete_data['Model'];

      $field_name = $auto_complete_data['Field'];

      $q          = $auto_complete_data['q'];

    }
	App::import('Model',$model_name);
	$this->$model_name =  new $model_name();

	$this->$model_name->displayField  = $field_name;

	$options['conditions']  = array($field_name." LIKE"=>$q."%");

	$data_list  = $this->$model_name->find('list',$options);

  	foreach($data_list as $key=>$FieldValue){

  	echo $FieldValue.' ('.$key.')'."\n";

  	}

     exit;

  }
  
  // get Color List  
	function getColors() {
		App::import('Model','Color');
		$this->Color = & new Color();
		$colorsArr = array();
		$colorsArr =  $this->Color->find('list', array('fields'=> array('Color.id','Color.color_name'),'order'=>array('Color.color_name ASC') ));
		return $colorsArr;
	}

}
?>