<?php 
class CommonHelper extends Helper
{
	
	/**
	@function: conditions_array
	@Modify: NULL
	@Created Date: jan 19, 2011
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
	
	// get countries List as a dropdown 
	function getcountries() {
		// import the country DB
		$cntArray = array();	    
		App::import("Model","Country");
		$this->Country=& new Country();
		$country =  $this->Country->find('all', array('conditions'=>array('Country.status'=>'1'), 'fields'=>array('Country.id','Country.country_name')));
		foreach($country as $cat){
			$cntArray[$cat['Country']['id']] = $cat['Country']['country_name'];
		}
		return $cntArray;
	}
	
	# function to get an array of states
	function getStates(){
		App::import('Model', 'State');
		$this->State = new State();
		$stateArr =  array();
		$stateArr = $this->State->find('list',array(
			'fields'=>array('State.state_code','State.name'),
			'order'=>array('State.name')
			));
		return $stateArr;
	}

	// get getdepartments List of all departments 
	function getdepartments() {
		// import department db
		App::import('Model','Department');
		$this->Department = & new Department();
		# fetch list of  active departments 
		$departments_list = $this->Department->find('list',array('conditions'=>array('Department.status'=>'1'),'fields'=>array('id','name'),'limit'=>10,'order'=>array('Department.id')));
		return $departments_list;
	}
	
	// get departments name by id
	function getDepartmentsName($id = null) {
		// import department db
		App::import('Model','Department');
		$this->Department = & new Department();
		# fetch list of  active departments 
		$departments_name = $this->Department->find('all',array('conditions'=>array('Department.status'=>'1' , 'Department.id'=>$id),'fields'=>array('id','name')));
		return $departments_name;
	}
	
	// get Category name by id
	function getCategoryName($id = null) {
		// import Category db
		App::import('Model','Category');
		$this->Category = & new Category();
		# fetch list of  active departments 
		$category_name = $this->Category->find('all',array('conditions'=>array('Category.status'=>'1' , 'Category.id'=>$id),'fields'=>array('id','cat_name')));
		return $category_name;
	}

	/* **************************** */	
	function getDepartmentCategories($department_id){
		App::import('Model', 'Category');
		$Category = & new Category();
		$conditions = array('Category.department_id ='.$department_id);
		$depart_cat_array = $Category->find('list', array('conditions'=>  $conditions,'fields'=>array('Category.id', 'Category.cat_name'),'order' => 'Category.cat_name ASC'));
		return $depart_cat_array;
	}

	/* **************************** */	
	function getVisitedSubCategories($cate_id = null){
		App::import('Model', 'CategoryVisit');
		$this->CategoryVisit = & new CategoryVisit();
		$conditions = array('CategoryVisit.parent_id ='.$cate_id);
		$sub_cat_array = $this->CategoryVisit->find('list', array('conditions'=>  $conditions,'fields'=>array('CategoryVisit.id')));
		if(!empty($sub_cat_array))
			return $sub_cat_array;
		else
			return 0;
	}

	/* **************************** */	
	function getSubCategories($cate_id = null){
		App::import('Model', 'Category');
		$this->Category = & new Category();
		$conditions = array('Category.parent_id ='.$cate_id);
		$sub_cat_array = $this->Category->find('list', array('conditions'=>  $conditions,'fields'=>array('Category.id')));
		if(!empty($sub_cat_array))
			return $sub_cat_array;
		else
			return 0;
	}
	
	// get getDeliveryCharges for a product and seller
	function getDeliveryCharges($product_id = null, $seller_id = null, $condition_id = null) {
		if(empty($product_id) && is_null($seller_id)  ){
		}
		App::import('Model','ProductSeller');
		$this->ProductSeller = & new ProductSeller();
		$prodSellerInfo =  $this->ProductSeller->find('first', array('conditions'=>array('ProductSeller.product_id'=>$product_id ,'ProductSeller.seller_id'=>$seller_id , 'ProductSeller.condition_id'=>$condition_id ),'fields'=>array('ProductSeller.standard_delivery_price')));
		//pr($prodSellerInfo);
		if(is_array($prodSellerInfo)){
			return $prodSellerInfo['ProductSeller']['standard_delivery_price'];
		}else{
			return false;
		}
	}
	
	// get getUserMailInfo 
	// user information to mail
	function getUserBasicInfo($id = null) {
		if( empty($id) || is_null($id) ){
			return false;
		}
		App::import('Model','User');
		$this->User = & new User();
		$userArr  = $this->User->find('first',array('conditions'=>array("User .id"=>$id),'fields' =>array( 'User.firstname','User.lastname','User.email')));
		return $userArr;
	}
	
	function displayProductRatingYellow($rating = null,$pro_id = null) {
		// import department db
		App::import('Model','ProductRating');
		$this->ProductRating = & new ProductRating();
		$total_rating_reviewers = $this->ProductRating->find('count',array('conditions'=>array('ProductRating.product_id'=>$pro_id)));
		$half_star = 0;$full_star = 0;$avg_rating = 0;$ratingStar='';
		if(!empty($rating)){
			$rating_arr = explode('.',$rating);
			$full_star = $rating_arr[0];
			if(!empty($rating_arr[1])){
				$first_decimal = $rating_arr[1][0];
				if($first_decimal >= 5){
					$half_star = 1;
				}
			}
		}
		for($avgrate = 0;  $avgrate < $full_star; $avgrate++){
			$ratingStar .= '<img src="'.SITE_URL.'img/yellow-star.png" width="12" height="12" alt="" >';
		}
		if(!empty($half_star)){ // half star
			$ratingStar .=  '<img src="'.SITE_URL.'img/hy-star.png" width="13" border="0" height="12" alt="" >';
			$avg_rating = $full_star + 1;
		} else{
			$avg_rating = $full_star;
		}
		// show gray color stars
		for($avgrate_white = 0;  $avgrate_white < (5-$avg_rating); $avgrate_white++){
			$ratingStar .=  '<img src="'.SITE_URL.'img/white-star.png" width="12" height="12" alt="" >';
		}
		return $ratingStar. " ($total_rating_reviewers)";
	}
	
	function displayProductRatingYellowSearchPage($rating = null,$pro_id = null) {
		
		$half_star = 0;$full_star = 0;$avg_rating = 0;$ratingStar='';
		
		if(!empty($rating)){
			$rating_arr = explode('.',$rating);
			$full_star = $rating_arr[0];
			if(!empty($rating_arr[1])){
				$first_decimal = $rating_arr[1][0];
				if($first_decimal >= 5){
					$half_star = 1;
				}
			}
		}
		for($avgrate = 0;  $avgrate < $full_star; $avgrate++){
			$ratingStar .= '<img src="'.SITE_URL.'img/yellow-star.png" width="12" height="12" alt="" >';
		}
		if(!empty($half_star)){ // half star
			$ratingStar .=  '<img src="'.SITE_URL.'img/hy-star.png" width="13" border="0" height="12" alt="" >';
			$avg_rating = $full_star + 1;
		} else{
			$avg_rating = $full_star;
		}
		// show gray color stars
		for($avgrate_white = 0;  $avgrate_white < (5-$avg_rating); $avgrate_white++){
			$ratingStar .=  '<img src="'.SITE_URL.'img/white-star.png" width="12" height="12" alt="" >';
		}
		return $ratingStar;
	}

	// get getProductRating for a product
	function displayProductRating($rating = null,$pro_id = null) {
		// import department db
		App::import('Model','ProductRating');
		$this->ProductRating = & new ProductRating();
		$total_rating_reviewers = $this->ProductRating->find('count',array('conditions'=>array('ProductRating.product_id'=>$pro_id)));
		$half_star = 0;$full_star = 0;$avg_rating = 0;$ratingStar='';
		if(!empty($rating)){
			$rating_arr = explode('.',$rating);
			$full_star = $rating_arr[0];
			if(!empty($rating_arr[1])){
				$first_decimal = $rating_arr[1][0];
				if($first_decimal >= 5){
					$half_star = 1;
				}
			}
		}
		if(!empty($full_star)){
			for($avgrate = 0;  $avgrate < $full_star; $avgrate++){
				$ratingStar .= '<img src="'.SITE_URL.'img/red-star-rating.png" width="12" height="12" alt="" >';
			}
		}
		if(!empty($half_star)){ // half star
			$ratingStar .=  '<img src="'.SITE_URL.'img/half-red-star-rating.png" width="12" height="12" alt="" >';
			$avg_rating = $full_star + 1;
		} else{
			$avg_rating = $full_star;
		}
		// show gray color stars
		for($avgrate_white = 0;  $avgrate_white < (5-$avg_rating); $avgrate_white++){
			$ratingStar .=  '<img src="'.SITE_URL.'img/gray-star-rating.png" width="12" height="12" alt="" >';
		}	
		return $ratingStar. " ($total_rating_reviewers)";
	}
	
	/** 
	@function: getBasketData
	@Created by: Kulvinder
	@Modify:  11 JAn 2010 
	*/
	function getBasketCount(){
		App::import('Model','Basket');
		$this->Basket = & new Basket();
		$totalItems = 0;
		$session_id = session_id();
		$totalItems = $this->Basket->find('first',array('conditions'=>array('Basket.session_id'=>$session_id),'fields'=> array('SUM(qty) as total_items')));
		if(empty($totalItems[0]['total_items']))
			$totalItems[0]['total_items'] = 0;
		return $totalItems[0]['total_items'];
	}
	
	/** 
	@function: getProductMainDetails
	@Created by: Kulvinder
	@Modify:  19 Feb 2011
	*/
	function getProductMainDetails($product_id){
		App::import('Model','Product');
		$this->Product = & new Product();
		$prodArr = $this->Product->find('first',array(
			'conditions'=>array('Product.id'=>$product_id),
			'fields'=> array('Product.id' , 'Product.quick_code','Product.product_name', 'Product.product_image')
			));
		return $prodArr;
	}
	
	/** 
	@function: getBasketData
	@Created by: Kulvinder
	@Modify:  11 JAn 2010 
	*/
	function getBasketLastItem(){
		App::import('Model','Basket');
		$this->Basket = & new Basket();
		$session_id = session_id();
		$query = "select products.product_name from baskets inner join products products ON (products.id= baskets.product_id)
		where session_id = '".$session_id."' order by baskets.created desc limit 1";
		$cartDetails = $this->Basket->query($query);
		//pr($cartDetails);
		if(empty($cartDetails[0]['products']['product_name']))
			$cartDetails[0]['products']['product_name'] = '-';
		if(is_array($cartDetails) && count($cartDetails) > 0 ){
			$prodName = $cartDetails[0]['products']['product_name'];
			return $prodName;
		}else{
			return '';
		}
	}
	
	/** 
	@function: getProductSellerInfo
	@Created by: Kulvinder
	@Modify:  11 Jan 2010 
	*/
	function getProductSellerInfo($product_id = null, $seller_id = null, $condition_id =null) {
		$prodSellerInfo = array();
		if(empty($product_id) && is_null($seller_id)  ){
			return $prodSellerInfo;
		}
		App::import('Model','ProductSeller');
		$this->ProductSeller = & new ProductSeller();
		//$this->ProductSeller->expects( array('Seller') );
		$prodSellerInfo =  $this->ProductSeller->find('first', array('conditions'=>array('ProductSeller.product_id'=>$product_id ,'ProductSeller.seller_id'=>$seller_id,'ProductSeller.condition_id'=>$condition_id  ), 'fields'=>array('ProductSeller.id','ProductSeller.quantity','ProductSeller.standard_delivery_price', 'ProductSeller.dispatch_country','ProductSeller.express_delivery','ProductSeller.express_delivery_price', 'ProductSeller.notes' )));
		 return $prodSellerInfo;
		
	}
	
	/** 
	@function: getsellerInfo
	@Created by: Kulvinder
	@Modify:  11 Jan 2011 
	*/ 
	function getsellerInfo($seller_id = null ) {
		App::import("Model","User");
		$this->User=& new User();
		$sellersDataArr = array();
		$this->User->expects( array('Seller') );
		$sellersDataArr =  $this->User->find('first', array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('User.id','User.firstname', 'User.lastname','Seller.business_display_name','Seller.service_email', 'Seller.free_delivery', 'Seller.threshold_order_value','Seller.gift_service')));
		return $sellersDataArr;
	}

	function displayProductRatingYellow_detail($rating = null,$pro_id = null) {
		// import department db
		App::import('Model','ProductRating');
		$this->ProductRating = & new ProductRating();
		$total_rating_reviewers = $this->ProductRating->find('count',array('conditions'=>array('ProductRating.product_id'=>$pro_id)));
		$half_star = 0;$full_star = 0;$avg_rating = 0;$ratingStar='';
		if(!empty($rating)){
			$rating_arr = explode('.',$rating);
			$full_star = $rating_arr[0];
			if(!empty($rating_arr[1])){
				$first_decimal = $rating_arr[1][0];
				if($first_decimal >= 5){
					$half_star = 1;
				}
			}
		}
		for($avgrate = 0;  $avgrate < $full_star; $avgrate++){
			$ratingStar .= '<img src="'.SITE_URL.'img/yellow-star.png" width="12" height="12" alt="" >';
		}
		if(!empty($half_star)){ // half star
			$ratingStar .=  '<img src="'.SITE_URL.'img/hy-star.png" width="13" border="0" height="12" alt="" >';
			$avg_rating = $full_star + 1;
		} else{
			$avg_rating = $full_star;
		}
		// show gray color stars
		for($avgrate_white = 0;  $avgrate_white < (5-$avg_rating); $avgrate_white++){
			$ratingStar .=  '<img src="'.SITE_URL.'img/white-star.png" width="12" height="12" alt="" >';
		}
		return $ratingStar.=" (<a class=\"underline-link\" href=\"#review-rating\">".$total_rating_reviewers." customer reviews</a>)";
	}

	/* @ function : to multiple offers listing 
	 * @ author :kulvinder singh
	 * @ created : 27 jan 2011 
	 **/
	function get_multiple_offers($user_id, $product_id ){
		App::import("Model","Offer");
		$this->Offer = & new Offer();
		$query_fields = "Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,Offer.offer_price,Offer.product_id,Offer.created,Product.product_name,Seller.business_display_name,Product.product_image,Product.product_rrp ";
		$offers_made_query  = " select $query_fields from offers Offer left join products Product ON (Offer.product_id = Product.id) ";
		$offers_made_query .= " left join sellers Seller ON (Offer.recipient_id = Seller.user_id) ";
		$offers_made_query .= " where Offer.sender_id = $user_id  AND Offer.product_id = $product_id ";
		$offers_made_query .= " AND Offer.offer_type = 'M' ";
		$offers_made = $this->Offer->query($offers_made_query);
		return $offers_made;
	}
	
	/* @ function : to get LowestPriceSellerInfo
	* @ author :kulvinder singh
	* @ created : 31 jan 2011 
	**/

	function getLowestPriceSellerInfo($product_id ){
		App::import('Model','Product');
		$this->Product = & new Product();
		$prodArr = $this->Product->find('first',array('conditions'=>array('Product.id'=>$product_id),'fields'=> array('minimum_price_seller','minimum_price_used_seller')));
		if(is_array($prodArr) && count($prodArr) > 0){
			if(!empty($prodArr['Product']['minimum_price_seller'])){
				$min_price_seller_id = $prodArr['Product']['minimum_price_seller'];
				
			} elseif(!empty($prodArr['Product']['minimum_price_used_seller'])){
				
				$min_price_seller_id = $prodArr['Product']['minimum_price_used_seller'];
			} else{
				$min_price_seller_id = '';
				
			}
			if($min_price_seller_id > 0){
				$lowPriceSellerData = $this->getsellerInfo($min_price_seller_id);
			}
		} else{
			$lowPriceSellerData = array();
		}
		return $lowPriceSellerData;
	}
	
	/* @ function : to reject the offers made 
	 * @ author :kulvinder singh
	 * @ created : 27 jan 2011 
	 **/
	function reject_expired_offer($offer_id, $created_date ){
		# import offer DB
		App::import("Model","Offer");
		$this->Offer = & new Offer();
		$offer_id = $offer_id;
		$offer_created_time = strtotime($created_date);
		$date_now_time = strtotime(date('Y-m-d H:i:s') );
 		$time_elapsed  = abs($date_now_time - $offer_created_time);
		// 172800 is 2 days  seconds (2*24*60*60;)
		if($time_elapsed >= 172800 ){ // if 2 days time reached or crossed then reject the offer
			$this->data['Offer']['id'] = $offer_id;
			$this->data['Offer']['offer_status'] = '2'; // 2 for rejected offer 
			$this->data['Offer']['offer_status_time'] =  date('Y-m-d H:i:s' ,strtotime ( '+2 day' , $offer_created_time )) ;
			$this->Offer->save($this->data) ;
		}
	}
	
	function displaySellerrating($rating = null){
		for($i = 0; $i< $rating; $i++) {
			echo '<img src="'.SITE_URL.'img/orange-star-12x12.gif" alt="" >';
		} 
		for($j = $i; $j < 5; $j++){
			echo '<img src="'.SITE_URL.'img/white-star.png" alt="" >';
		}
	}

	function sellerAvgrate($seller_avg_full_star = null,$seller_avg_half_star = null,$seller_avg_rating = null,$seller_id = null,$product_id = null){
		echo '<p><span class="gray smalr-fnt">Rating:</span> ';
		for($seller_avg_i = 0; $seller_avg_i < $seller_avg_full_star; $seller_avg_i++){
			echo '<img src="'.SITE_URL.'img/ylw-star.png" alt="" >';
		}
		$seller_avg_j = $seller_avg_i;
		if(!empty($seller_avg_half_star)){
			echo '<img src="'.SITE_URL.'img/ylw-star-half.png" alt="" >';
			$seller_avg_j = $seller_avg_j+1;
		}
		for($seller_avg_j_count = $seller_avg_j; $seller_avg_j_count < 5; $seller_avg_j_count++){
			echo '<img src="'.SITE_URL.'img/ylw-star-gray.png" alt="" >';
		}
		
		if(!empty($seller_avg_rating) && !empty($seller_id) && !empty($product_id)){
			echo ' (<span class="underline-link"><a href="'.SITE_URL.'sellers/summary/'.$seller_id.'/'.$product_id.'">'.$seller_avg_rating.' ratings</a></span>)';
		} else if(!empty($seller_avg_rating) && !empty($seller_id)){
			echo ' (<span class="underline-link"><a href="'.SITE_URL.'sellers/summary/'.$seller_id.'">'.$seller_avg_rating.' ratings</a></span>)';
		} else if(!empty($seller_avg_rating)){
			echo ' (<span class="underline-link">'.$seller_avg_rating.' ratings</span>)';
		}
		echo '</p>';
	}

	function sellerPositivePercentage($positive_percentage = null){
		echo '<p><span class="green-color larger-fnt"><strong>'.$positive_percentage.'%</strong></span> <strong>positive</strong> over 12 months </p>';
	}
	
	function getSellerOrderTotal($orderId, $sellerId){
		App::import('Model','OrderItem');
		$this->OrderItem = & new OrderItem();
		$orderQuery = " select quantity*price as price, If( delivery_method = 'E', delivery_cost, '0' ) AS delivery_price, If( giftwrap = 'YES', giftwrap_cost, '0' ) AS giftwrap_cost   from order_items 
		where order_id = '".$orderId."' AND seller_id = '".$sellerId."' ";
		$orderData = $this->OrderItem->query($orderQuery);
		#pr($cartDetails);
		if(is_array($cartDetails) && count($cartDetails) > 0 ){
			$prodName = $cartDetails[0]['Products']['product_name'];
			return $prodName;
		}else{
			return '';
		}
	}
	
	/** 
	@function: getOrdersellerInfo
	@Created by: Kulvinder
	@Modify:  28 Feb 2011
	*/ 
	function getOrdersellerInfo($orderId, $sellerId = null ) {
		App::import("Model","OrderSeller");
		$this->OrderSeller=& new OrderSeller();
		$osDataArr =  $this->User->find('first', array('conditions'=>array('OrderSeller.order_id'=>$orderId, 'OrderSeller.seller_id'=>$sellerId),'fields'=>array('OrderSeller.dispatch_date','OrderSeller.shipping_carrier','OrderSeller.other_carrier','OrderSeller.shipping_status', 'OrderSeller.shipping_service','OrderSeller.shipped_via','OrderSeller.tracking_id','OrderSeller.seller_note')));
		return $osDataArr;
	}
	
	/** 
	@function: getProductsCountByCategory
	@Created by: Kulvinder
	@Modify:  07 March 2011
	*/ 
	function getProductsCountByCategory($category_id  ) {
		App::import("Model","ProductCategory");
		$this->ProductCategory = & new ProductCategory();
		$total_products = $this->ProductCategory->find('count',array('conditions'=>array("ProductCategory.category_id" => $category_id),'group'=> 'ProductCategory.product_id'));
		 return $total_products;
	}
	
	/** 
	@function: getSellerProductStock
	@Created by: Kulvinder
	@Modify:  11 JAn 2010 
	*/
	function getSellerProductStock($seller_id = null, $product_id = null, $condition= 'new') {
		$prodStockInfo = array();
		if(empty($product_id) && is_null($seller_id)  ){
			return $prodSellerInfo;
		}
		if(strtolower($condition) == 'used'){ // for used
			$conditions = '2,3,5,6,7';
		}else{ // for new
			$conditions = '1,4';
		}
// 		$conditions;
		App::import('Model','ProductSeller');
		$this->ProductSeller = & new ProductSeller();
		$prodStockInfo =  $this->ProductSeller->find('first', array('conditions'=>array('ProductSeller.product_id'=>$product_id ,'ProductSeller.seller_id'=>$seller_id ,"ProductSeller.condition_id IN ($conditions) "),'fields'=>array('ProductSeller.quantity','ProductSeller.standard_delivery_price','ProductSeller.express_delivery','ProductSeller.express_delivery_price' )));
		 return $prodStockInfo;
	}
	
	/** 
	@function : getDispatchedQuantity
	@description : to get total quantity of items dispatched by the selller to customer
	@params : 
	@created : 21 March 2011
	@credated by :kulvinder Singh
	**/
	function getDispatchedQuantity($order_id , $order_item_id = null ) {
		# import database
		App::import("Model","DispatchedItem");
		$this->DispatchedItem = & new DispatchedItem();
		$qtyDispData = $this->DispatchedItem->query(" SELECT SUM(quantity) AS quantity from dispatched_items DispatchedItem where order_id = '".$order_id."' and order_item_id = '".$order_item_id."'  " );
		if(is_array($qtyDispData) && !empty($qtyDispData)){
			if(!empty($qtyDispData[0][0]['quantity']) ){
				 return $qtyDispData[0][0]['quantity'];
			}else{
				return 0;
			}
		}else{
		    return 0;
		}
	}

	
	/** 
	@function: getProductId_Qccode
	@Created by: Ramanpreet Pal KAur
	@Modify:  11 Jul, 2011
	*/
	function getProductId_Qccode($qc_code = null){
		App::import('Model','Product');
		$this->Product = & new Product();
		$pr_id = '';
		$prodArr = $this->Product->find('first',array(
			'conditions'=>array('Product.quick_code'=>$qc_code),
			'fields'=> array('Product.id')
			));
		if(!empty($prodArr)){
			$pr_id = $prodArr['Product']['id'];
		}
		return $pr_id;
	}


	/** 
	@function : fh_call_hotsearch
	@description : to hot search(Orange) bar on every page from FH
	@params : 
	@created : 
	@credated by :Ramanpreet Pal Kaur
	**/
	function fh_call_hotsearch($selected_department = null,$fh_url = null){
		//Configure::write('debug',2);
		$orange_bar = array();
		$ws_location = WS_LOCATION;
		//Create a new soap client
		//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		//Build the query string
		$controller_current = $this->params['controller'];
		$page_current = $this->params['action'];
		if($controller_current == 'categories' && $page_current == 'productdetail'){
			if(!empty($this->params['pass'])){
				if(!empty($this->params['pass'][0])){
					$prod_id = $this->params['pass'][0];
					$pr_detail = $this->getProductMainDetails($prod_id);
					//pr($pr_detail);
					if(!empty($pr_detail['Product'])){
						if(!empty($pr_detail['Product']['quick_code'])){
							$fh_location = 'fh_location=//catalog01/en_GB/&preview_search='.$pr_detail['Product']['quick_code'];
						} else {
							$fh_location="fh_location=//catalog01/en_GB/";
						}
					} else {
						$fh_location="fh_location=//catalog01/en_GB/";
					}
				} else {
					$fh_location="fh_location=//catalog01/en_GB/";
				}
			} else {
				$fh_location="fh_location=//catalog01/en_GB/";
			}
		} else {
			$fh_location = $this->getFHUrl($selected_department);
		}
		//Send the query string to the Fredhopper Query Server & obtain the result
		$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
		//echo htmlentities($client->__getLastRequest());die("I am here..")
		//Find the universe marked as 'selected' in the result
		foreach($result->universes->universe as $r) {
			
			if($r->{"type"} == "selected"){
				//Extract & print the breadcrumbs from the result
				if(!empty($r->themes))
					$themes = (array)$r->themes;
			}
		}
		//pr($themes['theme']);
		/*if(!empty($themes['theme'])){
			foreach ($themes['theme'] as $theme){
				if($theme->title == "Hot Searches"){
					$orange_bar = $theme->items->item;
				}
			}
		}*/
		//pr($themes);
		if(!empty($themes)){
			if(!empty($themes['theme'])){
				if(empty($selected_department)){
					//Commented by nakul on 25 apr 2012 for view "Most Viewed" product in "Orange Bar"
					if(!empty($themes['theme'][2])){
								
						if(!empty($themes['theme'][2]->items)){
							if(!empty($themes['theme'][2]->items->item)){
								if(count($themes['theme'][2]->items->item) > 1){
									$orange_bar = $themes['theme'][2]->items->item;
								} else {
									$orange_bar[0] = $themes['theme'][2]->items->item;
								}
								
							}
						}
					}
				} else {
					if($selected_department != 'C'){
						if(!empty($themes['theme'][4])){
							if(!empty($themes['theme'][4]->items)){
								if(!empty($themes['theme'][4]->items->item)){
									if(count($themes['theme'][4]->items->item) > 1){
										$orange_bar = $themes['theme'][4]->items->item;
									} else {
										$orange_bar[0] = $themes['theme'][4]->items->item;
									}
								}
							}
						}
					}
				}
			}
		}
		//pr($orange_bar);
		return $orange_bar;
	}



	/** 
	@function : fh_call_recomandedproducts
	@description : to get recomandded products from FH
	@params : 
	@created : 
	@credated by :Ramanpreet Pal Kaur
	**/
	function fh_call_recomandedproducts($selected_department = null){
		$recomanded_products = array();
		$ws_location = WS_LOCATION;
		//Create a new soap client
		//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		//Build the query string
		$fh_location = $this->getFHUrl($selected_department);

		//Send the query string to the Fredhopper Query Server & obtain the result
		$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
		
		//Find the universe marked as 'selected' in the result
		foreach($result->universes->universe as $r) {
			if($r->{"type"} == "selected"){
				//Extract & print the breadcrumbs from the result
				if(!empty($r->themes))
					$themes = (array)$r->themes;
			}
		}
		
		if(!empty($themes['theme'])){
			foreach ($themes['theme'] as $theme){
				if($theme->title == "Customers who viewed this item also viewed"){
					$recomanded_products = $theme->items->item;
				}
			}
		}
		/*if(!empty($themes)){
			if(!empty($themes['theme'])){
				if(empty($selected_department)){
					if(!empty($themes['theme'][0])) {
						if(!empty($themes['theme'][0]->items)) {
							if(!empty($themes['theme'][0]->items->item)){
								$recomanded_products = $themes['theme'][0]->items->item;
							}
						}
					}
				} else {
					if(!empty($themes['theme'][2])) {
						if(!empty($themes['theme'][2]->items)) {
							if(!empty($themes['theme'][2]->items->item)){
								
								if(count($themes['theme'][2]->items->item) > 1){
									$recomanded_products = $themes['theme'][2]->items->item;
								} else {
									$recomanded_products[0] = $themes['theme'][2]->items->item;
								}
							}
						}
					}
					
				}
			}
		}*/
		
		return $recomanded_products;
	}

	/** 
	@function : getFHUrl
	@description : to get FH url fro a selected department
	@params : $selected_department(department id for which we are making the FH url)
	@created : 
	@credated by :Ramanpreet Pal Kaur
	**/
	function getFHUrl($selected_department = null){
		App::import('Model','Department');
		$this->Department = new Department;
		$department_info = $this->Department->find('first',array('conditions'=>array('Department.id'=>$selected_department),'fields'=>array('Department.name')));
		
		$dept_name = '';
		if(!empty($department_info)){
			$dept_name = $department_info['Department']['name'];
		}
		if(!empty($dept_name)){
			$dept = str_replace(array(' ','&'),'_', html_entity_decode(strtolower($dept_name), ENT_NOQUOTES, 'UTF-8'));
			//$dept = str_replace(' & ','___',strtolower($dept_name));
			$fh_location = 'fh_location=//catalog01/en_GB/department_name={'.$dept.'}';
		} else {
			$fh_location="fh_location=//catalog01/en_GB/";
		}
		
		return $fh_location;
	}

	/** 
	@function : fh_call_hotproduct
	@description : to get hot product from FH
	@params : $selected_department(department id for which we are making the FH url)
	@created : 
	@credated by :Ramanpreet Pal Kaur
	**/
	function fh_call_hotproduct($selected_department = null){
		$hot_product = array();
		$ws_location = WS_LOCATION;
		//Create a new soap client
		//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		//Build the query string
		$fh_location = $this->getFHUrl($selected_department);
		//Send the query string to the Fredhopper Query Server & obtain the result
		$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
		
		//Find the universe marked as 'selected' in the result
		if(!empty($result)){
			foreach($result->universes->universe as $r) {
				if($r->{"type"} == "selected"){
					//Extract & print the breadcrumbs from the result
					if(!empty($r->themes))
						$themes = (array)$r->themes;
				}
			}
		}
		//pr($themes);
		/*Rakesh sir*/
		if(!empty($themes['theme'])){
			foreach ($themes['theme'] as $theme){
				if($theme->title == "Hot Product"){
					$hot_product = $theme->items->item;
				}
			}
		}
			/*themes->theme[$i]->slogan
			themes->theme[$i]->custom-fields->custom-field->_
			themes->theme[$i]->custom-fields->custom-field->id
			themes->theme[$i]->custom-fields->custom-field->name
			themes->theme[$i]->link
			foreach (themes->theme[$i]->link as $va)
			{
			
			
			}
			themes->theme[$i]->items
			forwe
			
			
		*/
	/*End of Rakesh sir Code*/
		
		
		
		/*if(!empty($themes)){
			if(!empty($themes['theme'])){
				if(empty($selected_department)){
					if(!empty($themes['theme'][1])) {
						if(!empty($themes['theme'][1]->items)) {
							if(!empty($themes['theme'][1]->items->item)){
								$hot_product = $themes['theme'][1]->items->item;
							}
						}
					}
				} else {
					if($selected_department == 3 || $selected_department == 4 || $selected_department == 6 || $selected_department == 7 || $selected_department == 8){
						if(!empty($themes['theme'][2])) {
							if(!empty($themes['theme'][2]->items)) {
								if(!empty($themes['theme'][2]->items->item)){
									$hot_product = $themes['theme'][2]->items->item;
								}
							}
						}
					} else {
						
						if(!empty($themes['theme'][3])) {
							if(!empty($themes['theme'][3]->items)) {
								if(!empty($themes['theme'][3]->items->item)){
									$hot_product = $themes['theme'][3]->items->item;
								}
							}
						}
					}
					
				}
			}
		}*/
		return $hot_product;
	}


	
	
	function fh_call_continueshopping(){

		$items_recomanded = array();
		$ws_location = WS_LOCATION;
		//Create a new soap client
		//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
// 		$this->Common->fh_call();
		$items_recomanded = array();
		//Build the query string
		$fh_location="fh_location=//catalog01/en_GB/";
		//Send the query string to the Fredhopper Query Server & obtain the result
		$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));

		//Find the universe marked as 'selected' in the result
		foreach($result->universes->universe as $r) {
			if($r->{"type"} == "selected"){
				//Extract & print the breadcrumbs from the result
				if(!empty($r->themes))
					$themes = (array)$r->themes;
				if(!empty($themes)){
					if(!empty($themes['theme'])){
						if(!empty($themes['theme']->items)){
							if(!empty($themes['theme']->items->item)){
								$items_recomanded = $themes['theme']->items->item;
							}
						}
					}
				}
				
			}
		}
		return $items_recomanded;
	}


	/** 
	@function: getProductConIdByConName
	@description: get product's condition_id from Product condition's name used for FH
	@Created by: Ramanpreet Pal KAur
	@Modify:  3 Aug, 2011
	*/
	
	function getProductConIdByConName($condition_name = null){
		if(!empty($condition_name)){
			App::import('Model','ProductCondition');
			$this->ProductCondition = & new ProductCondition();
			$pro_cond_arr = $this->ProductCondition->find('first',array('conditions'=>array('ProductCondition.name'=>$condition_name)));
			if(!Empty($pro_cond_arr)){
				$condition_id = $pro_cond_arr['ProductCondition']['id'];
			} else {
				$condition_id = null;
			}
		} else {
			$condition_id = null;
		}
		return $condition_id;
	}

	/** 
	@function: getProductFreeDelivery
	@description: get product's condition_id from Product condition's name used for FH
	@Created by: Ramanpreet Pal KAur
	@Modify:  4 Aug, 2011
	*/
	
	function getProductFreeDelivery($seller_id = null,$pro_price = null){
		App::import('Model','Seller');
		$this->Seller = & new Seller();
		$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('Seller.free_delivery','Seller.threshold_order_value')));

		if(!Empty($seller_info)){
			if(!empty($seller_info['Seller']['free_delivery'])){
				if($pro_price >= $seller_info['Seller']['threshold_order_value']){
					$free_del = 1;
				} else {
					$free_del = 0;
				}
			} else{
				$free_del = 0;
			}
		} else {
			$free_del = 0;
		}
		return $free_del;
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
				return str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($productName, ENT_NOQUOTES, 'UTF-8'));
				
			} else {
				return 0;
		}
	}
	
	
	
} // class ends here ?>