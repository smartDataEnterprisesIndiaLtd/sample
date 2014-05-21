<?php 
/**
* CronsController class
* PHP versions 5.1.4
* @date Feb 18, 2011
* @Purpose:This controller handles all the cron functions
* @author    kulvinder

**/


App::import('Sanitize');
class CronsController extends AppController {
	var $name = 'Crons';
	var $helpers =  array('Html','Ajax','Fck', 'Form', 'Javascript','Format','Common','Session','Validation','Calendar');
	var $components =  array('RequestHandler','Email','Common','File','Thumb');
	var $permission_id = 5;  // for product module
	
	/**
	* @Date: Feb 18, 2011
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate products access  permissions and  admin user sessions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		
		//check session other than admin_login page
		$includeBeforeFilter = array('admin_index',);
		
		if (in_array($this->params['action'],$includeBeforeFilter)){
			//check that admin is login
			$this->checkSessionAdmin();
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id); 
		}
	}
	
	
	/**
	@function : index 
	@description : to call all function to run cron
	@Created by : kulvinder singh
	@Modify : NULL
	@Created Date : Feb 18, 2011
	*/
	function index(){
// 		ini_set('memory_limit', '9999M');
// 		set_time_limit(0);
		$this->layout = 'layout_admin';
		$this->setProductMinimumPrice();
		$this->redirect('/admin/homes/dashboard');
		//exit;
	}
	/**
	@function : setProductMinimumPrice 
	@description : update product minimum price for  product
	@Created by : kulvinder singh
	@Modify : NULL
	@Created Date : Feb 18, 2011
	*/
	function setProductMinimumPrice(){
		//ini_set('memory_limit', '9999M');
		set_time_limit(0);
		//Configure::write('debug',2);
		$this->layout = 'blank';
		$this->set('list_title','Update Minimum Price For All Products');
		
		
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		
		App::import('Model','Product');
		$this->Product = new Product();
		
		// Commented by nakul on 10-Feb-2012 Because its takes longer time.
		
		//$productsArr = $this->ProductSeller->find('all', array('conditions'=> array('ProductSeller.listing_status'=>'1'),'fields'=>array('DISTINCT(ProductSeller.product_id) As product_id') ));
		$productsArr=$this->ProductSeller->find('all',
				array(
				'conditions'=>array('ProductSeller.listing_status'=>'1','ProductSeller.`modified` > NOW() - INTERVAL 1 HOUR'),
				'fields'=>array('DISTINCT(ProductSeller.product_id) As product_id'),
				));
		$this->data= '';
		if(is_array($productsArr) && !empty($productsArr) ){
			foreach($productsArr as $key=>$value){
				$product_id = $value['ProductSeller']['product_id'] ;
				$newMinPriceData  = $this->getProductMinimumPrice($product_id, 'NEW');
				$usedMinPriceData = $this->getProductMinimumPrice($product_id, 'USED');
				if(!empty( $newMinPriceData ) ){
					$this->data['Product']['minimum_price_value']  = $newMinPriceData['price'];
					$this->data['Product']['minimum_price_seller'] = $newMinPriceData['seller_id'];
					$this->data['Product']['new_condition_id']     = $newMinPriceData['condition_id'];
					$this->data['Product']['listed_date']          = $newMinPriceData['created'];
				} else{
					$this->data['Product']['minimum_price_value']   = null;
					$this->data['Product']['minimum_price_seller']  = null;
					$this->data['Product']['new_condition_id'] 	= null;
					$this->data['Product']['listed_date'] 		= null;
				}
				
				if(!empty( $usedMinPriceData ) ){
					$this->data['Product']['minimum_price_used']        = $usedMinPriceData['price'];
					$this->data['Product']['minimum_price_used_seller'] = $usedMinPriceData['seller_id'];
					$this->data['Product']['used_condition_id']         = $usedMinPriceData['condition_id'];
					$this->data['Product']['listed_date']     	    = $usedMinPriceData['created'];
				}else{
					$this->data['Product']['minimum_price_used']        = null;
					$this->data['Product']['minimum_price_used_seller'] = null;
					$this->data['Product']['used_condition_id']         = null;
					$this->data['Product']['listed_date'] 		    = null;
				}
				$this->data['Product']['id'] = $product_id;
				$this->Product->set($this->data);
				$this->data = Sanitize::clean($this->data);
				$this->Product->save($this->data);
				unset($usedMinPriceData);
				unset($newMinPriceData);
			}
		}
		//$this->Session->setFlash('Minimum price for all the products has been updated successfully !');
		//$this->redirect('/admin/homes/dashboard');
		exit;
	}
	
	function upadteMinimumPrice(){
		ini_set('max_execution_time', '-1');
		//ini_set('memory_limit', '9999M');
		set_time_limit(0);
		Configure::write('debug',2);
		$this->layout = 'blank';
		$this->set('list_title','Update Minimum Price For All Products');
		
		
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		
		App::import('Model','Product');
		$this->Product = new Product();
		
		// Commented by nakul on 10-Feb-2012 Because its takes longer time.
		
		//$productsArr = $this->ProductSeller->find('all', array('conditions'=> array('ProductSeller.listing_status'=>'1'),'fields'=>array('DISTINCT(ProductSeller.product_id) As product_id') ));
		$productsArr=$this->ProductSeller->find('all',
				array(
				'conditions'=>array('ProductSeller.listing_status'=>'1'),
				'fields'=>array('DISTINCT(ProductSeller.product_id) As product_id'),
				));
		$this->data= '';
		if(is_array($productsArr) && !empty($productsArr) ){
			foreach($productsArr as $key=>$value){
				$product_id = $value['ProductSeller']['product_id'] ;
				$newMinPriceData  = $this->getProductMinimumPrice($product_id, 'NEW');
				$usedMinPriceData = $this->getProductMinimumPrice($product_id, 'USED');
				if(!empty( $newMinPriceData ) ){
					$this->data['Product']['minimum_price_value']  = $newMinPriceData['price'];
					$this->data['Product']['minimum_price_seller'] = $newMinPriceData['seller_id'];
					$this->data['Product']['new_condition_id']     = $newMinPriceData['condition_id'];
					$this->data['Product']['listed_date']          = $newMinPriceData['created'];
				} else{
					$this->data['Product']['minimum_price_value']   = null;
					$this->data['Product']['minimum_price_seller']  = null;
					$this->data['Product']['new_condition_id'] 	= null;
					$this->data['Product']['listed_date'] 		= null;
				}
				
				if(!empty( $usedMinPriceData ) ){
					$this->data['Product']['minimum_price_used']        = $usedMinPriceData['price'];
					$this->data['Product']['minimum_price_used_seller'] = $usedMinPriceData['seller_id'];
					$this->data['Product']['used_condition_id']         = $usedMinPriceData['condition_id'];
					$this->data['Product']['listed_date']     	    = $usedMinPriceData['created'];
				}else{
					$this->data['Product']['minimum_price_used']        = null;
					$this->data['Product']['minimum_price_used_seller'] = null;
					$this->data['Product']['used_condition_id']         = null;
					$this->data['Product']['listed_date'] 		    = null;
				}
				$this->data['Product']['id'] = $product_id;
				$this->Product->set($this->data);
				$this->data = Sanitize::clean($this->data);
				$this->Product->save($this->data);
				unset($usedMinPriceData);
				unset($newMinPriceData);
			}
		}
		
		exit("all record has benn updated function :upadteMinimumPrice");
	}
	
	function setProduct(){
		ini_set('max_execution_time', '-1');
		
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		
		App::import('Model','Product');
		$this->Product = new Product();
		
		$productId = '';
		$product = $this->Product->query("SELECT Product.id FROM products AS Product LEFT OUTER JOIN product_sellers AS ProductSeller ON ( Product.id = ProductSeller.product_id ) WHERE ProductSeller.product_id IS NULL");
		/*echo "<pre>";
		print_r($product);
		die;*/
		foreach($product as $ni =>$producttt){
			
			$productId = $producttt['Product']['id'];
			$this->data['Product']['minimum_price_value']   = null;
			$this->data['Product']['minimum_price_seller']  = null;
			$this->data['Product']['new_condition_id'] 	= null;
			$this->data['Product']['minimum_price_used']        = null;
			$this->data['Product']['minimum_price_used_seller'] = null;
			$this->data['Product']['used_condition_id']         = null;
			
			$this->data['Product']['id'] = $productId;
			$this->Product->set($this->data);
			$this->data = Sanitize::clean($this->data);
			$this->Product->save($this->data);
		}
		die('dataUpadted ,function : setProduct');
		
	}
	
	/**
	@function : RemoveZip 
	@description : Remove zip file which are downloaded by users
	@Created by : 
	@Modify : NULL
	@Created Date : Jul 17, 2013
	*/
	function RemoveZip() {
        $this->loadModel('DeleteZip');
	$zipFile = $this->DeleteZip->find('list',array('fields'=>array('id','name')));
		if (is_array($zipFile) && !empty($zipFile)) {
			foreach($zipFile as $id => $fileName) {
				$fileFullPath = WWW_ROOT.PATH_DOWNLOADDATA.$fileName;
				if(is_file($fileFullPath)){
					if(unlink($fileFullPath)){
						$this->DeleteZip->delete($id);	
					}
				}
			}
		    
		}
		exit();
	}
	
	/**
	@function : setProductMinimumPrice 
	@description : update product minimum price for  product
	@Created by : kulvinder singh
	@Modify : NULL
	*/	
	function getProductMinimumPrice($product_id = null, $condition = null ) {
		$server_load = $this->get_server_load();
		$cron_flag = array();
		@exec("ps auxwww", $processList);
		for($i=0; $i<count($processList); $i++)
		{
			$pos = strpos($processList[$i], '/crons/setProductMinimumPrice');
			if ($pos === false) {
				$cron_flag[] = 'y';
			}
			else
			{
				$cron_flag[] = 'n';
			}
		}
// 		echo $server_load;
// 		if($server_load < 3){
// 			if(in_array('y',$cron_flag)) {
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
				$priceQuery .= " where product_id = '".$product_id."' AND listing_status = '1' AND quantity > '0' AND condition_id IN ($strCondition) ";
				$priceQuery .= " order by total_price ASC limit 1 ";
				$leastTotalPriceArr  = $this->ProductSeller->query($priceQuery);
				
				
				# price existes for this  product
				if(count($leastTotalPriceArr)  > 0){ // price existes for thsi product
					$minpriceQuery = " select condition_id, price,minimum_price,standard_delivery_price, seller_id, created from product_sellers AS ProductSeller ";
					
					$minpriceQuery .= " where product_id = '".$product_id."' AND listing_status = '1' AND quantity > '0' AND  condition_id IN ($strCondition) AND minimum_price_disabled = '0' AND minimum_price != '0.00' order by minimum_price limit 1";
					
					$leastMinPriceArr  = $this->ProductSeller->query($minpriceQuery);
					//pr($leastMinPriceArr);
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
				//pr($dataArr);
				return $dataArr;
// 			} else {
// 				$cu_date_time = date('d-m-Y H:i:s');
// 				mail('raman411@gmail.com', 'Already exe Cron not executed at'.$cu_date_time, 'Cron is already executing');
// 			}
// 		} else{
// 			$cu_date_time = date('d-m-Y H:i:s');
// 			mail('raman411@gmail.com', 'Cron not executed at'.$cu_date_time, 'Sever load is very high');
// 		}
	}

	/**
	@function : get_server_load 
	@description : to find load on server
	@Created by : Ramanpreet Pal
	@Modify : NULL
	@Created Date : 
	*/
	function get_server_load($windows = 0) {
		$os = strtolower(PHP_OS);
		if(strpos($os, "win") === false) {
			if(file_exists("/proc/loadavg")) {
				$load = file_get_contents("/proc/loadavg");
				$load = explode(' ', $load);
				return $load[0];
			}
			elseif(function_exists("shell_exec")) {
				$load = explode(' ', `uptime`);
				return $load[count($load)-1];
			}
			else {
				return "";
			}
		}
		elseif($windows) {
			if(class_exists("COM")) {
				$wmi = new COM("WinMgmts:\\\\.");
				$cpus = $wmi->InstancesOf("Win32_Processor");
				
				$cpuload = 0;
				$i = 0;
				while ($cpu = $cpus->Next()) {
					$cpuload += $cpu->LoadPercentage;
					$i++;
				}
				$cpuload = round($cpuload / $i, 2);
				return "$cpuload%";
			}
			else {
				return "";
			}
		}
	}


	/**
	@function : seller_payments 
	@description : to generate seller's payments
	@Created by : Ramanpreet Pal
	@Modify : NULL
	@Created Date : June 29,2011
	*/
	function seller_payments(){
		ini_set('memory_limit', '9999M');
		set_time_limit(0);
		//Configure::write('debug',2);
		App::import('Model','User');
		$this->User = new User();
		$this->User->expects(array('Seller'));
		$sellers = $this->User->find('all',array('conditions'=>array('User.user_type'=>'1','User.status'=>'1'),'fields'=>array('Seller.business_display_name','Seller.bank_account_number','Seller.paypal_account_mail','User.id','User.firstname','User.lastname','User.email')));
		
		if(!empty($sellers)){
			App::import('Model','PaymentReport');
			$this->PaymentReport = new PaymentReport();
			App::import('Model','OrderSeller');
			$this->OrderSeller = new OrderSeller();
			
			App::import('Model','OrderItem');
			$this->OrderItem = new OrderItem();
			App::import('Model','OrderRefund');
			$this->OrderRefund = new OrderRefund();
			
			App::import('Model','PaymentPenalty');
			$this->PaymentPenalty = new PaymentPenalty();
			
			App::import('Model','Setting');
			$this->Setting = new Setting();
			$currency_name = '';
			$currency_info = $this->Setting->find('first',array('fields'=>'Setting.currency_name'));
			if(!empty($currency_info)){
				$currency_name = $currency_info['Setting']['currency_name'];
			}
			$this->OrderSeller->expects(array('Order'));
			$FULL_PATH_TO_DT =  WWW_ROOT.'/files/payment_reports/';
			foreach($sellers as $seller){
				$items = array();
				$last_report = $this->PaymentReport->find('first',array('conditions'=>array('PaymentReport.seller_id'=>$seller['User']['id']),'fields'=>array('PaymentReport.id','PaymentReport.seller_id','PaymentReport.from_date','PaymentReport.to_date','PaymentReport.report_name','PaymentReport.opening_balance','PaymentReport.closing_balance','PaymentReport.deposited'),'order'=>array('PaymentReport.id DESC')));
				$opening_balance = 0;
				$closing_balance = 0;
				
				$all_orders = array();
				$all_penalty = array();
				if(empty($last_report)){
					$date = date('Y-m-d');
					$date_b4_30days = date('Y-m-d',(strtotime($date) - 30*24*60*60));
					$datetime_b4_15days = date('Y-m-d',(strtotime($date) - 15*24*60*60))." 23:59:59";
// 					$datetime_b4_15days = "2011-06-17 23:59:59";
// 					$date_b4_30days = '2011-06-11';
					$date_b4_30days_start = $date_b4_30days.' 00:00:00';
					$date_b4_30days_end = $date_b4_30days.' 23:59:59';
					$order_b430days = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.seller_id'=>$seller['User']['id'],'OrderSeller.created >= "'.$date_b4_30days_start.'" AND OrderSeller.created <= "'.$date_b4_30days_end.'"')));
// 					$date = '2011-06-25';
					if(!empty($order_b430days)){
						$all_orders = $this->OrderSeller->find('all',array('conditions'=>array('OrderSeller.seller_id'=>$seller['User']['id'],'OrderSeller.created >= "'.$date_b4_30days_start.'" AND OrderSeller.created < "'.$date.'" AND (Order.deleted = "0")'),'fields'=>array('OrderSeller.order_id,OrderSeller.seller_id,OrderSeller.created','Order.deleted','Order.order_number')));
						
						$all_penalty = $this->PaymentPenalty->find('all',array('conditions'=>array('PaymentPenalty.seller_id'=>$seller['User']['id'],'PaymentPenalty. from_date >= "'.$date_b4_30days_start.'" AND PaymentPenalty. from_date < "'.$date.'" '), 'fields'=>array('PaymentPenalty.id','PaymentPenalty.seller_id','PaymentPenalty.created','PaymentPenalty.reason','PaymentPenalty.  	  from_date','PaymentPenalty.fees')));
					
					}
					$from_date = $date_b4_30days;
					$to_date = $date;
					$flag_next15 = 0;
				} else {
					$opening_balance = $last_report['PaymentReport']['closing_balance'];
					$date = $last_report['PaymentReport']['to_date'];
					$date_aft_15days = date('Y-m-d',(strtotime($date) + 15*24*60*60));
					//$date_aft_15days = "2011-09-14";
					$current_date = date('Y-m-d');
					$flag_next15 = 1;
					$date_aft_15days_end = $date_aft_15days.' 00:00:00';
					if($current_date > $date_aft_15days){
						$date_b4_15days_start = $date.' 00:00:00';
						$all_orders = $this->OrderSeller->find('all',array('conditions'=>array('OrderSeller.seller_id'=>$seller['User']['id'],'OrderSeller.created >= "'.$date_b4_15days_start.'" AND OrderSeller.created < "'.$date_aft_15days_end.'" AND (Order.deleted = "0")'),'fields'=>array('OrderSeller.order_id,OrderSeller.seller_id,OrderSeller.created','Order.order_number')));
						$all_penalty = $this->PaymentPenalty->find('all',array('conditions'=>array('PaymentPenalty.seller_id'=>$seller['User']['id'],'PaymentPenalty. from_date >= "'.$date_b4_15days_start.'" AND PaymentPenalty. from_date < "'.$date_aft_15days_end.'"'), 'fields'=>array('PaymentPenalty.id','PaymentPenalty.seller_id','PaymentPenalty.created','PaymentPenalty.reason','PaymentPenalty.  	  from_date','PaymentPenalty.fees')));
					}
					$from_date = $date;
					$to_date = $current_date;					
				}
				if(!empty($all_orders)){
					$i = 0;
					$deposited = 0;
					$total_balance = 0;
					foreach($all_orders as $order){
						$items[$order['OrderSeller']['order_id']] = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.order_id'=>$order['OrderSeller']['order_id'],'OrderItem.seller_id'=>$order['OrderSeller']['seller_id']),'fields'=>array('sum(price*quantity) as total_sales','sum(delivery_cost*quantity) as total_delivery_cost','round(sum(((price*quantity)+(delivery_cost*quantity)) * 5/100)+(0.25*(sum(quantity))),2) as fee')));
						$total_refund_amount = $this->OrderRefund->find('all',array('conditions'=>array('OrderRefund.order_id'=>$order['OrderSeller']['order_id'],'OrderRefund.seller_id'=>$order['OrderSeller']['seller_id']),'fields'=>array('sum(amount) as total_refund')));
						$total_refund_created = $this->OrderRefund->find('first',array('conditions'=>array('OrderRefund.order_id'=>$order['OrderSeller']['order_id'],'OrderRefund.seller_id'=>$order['OrderSeller']['seller_id']),'fields'=>array('OrderRefund.created'),'order'=>array('OrderRefund.created DESC')));
						$total_refund_created_date = '';
						if(!empty($total_refund_created)){
							$total_refund_created_date = $total_refund_created['OrderRefund']['created'];
						} else {
							$total_refund_created_date = '-';
						}
						$items[$order['OrderSeller']['order_id']][0][0]['refund_created'] = $total_refund_created_date;

						if(empty($total_refund_amount[0][0]['total_refund'])){
							$total_refund_amount[0][0]['total_refund'] = '-';
						} else {
							$total_refund_amount[0][0]['total_refund'] = '-'.$total_refund_amount[0][0]['total_refund'];
						}
						if(!empty($items)){
							$items[$order['OrderSeller']['order_id']][0][0]['total_refund_amount'] = $total_refund_amount[0][0]['total_refund'];
							$items[$order['OrderSeller']['order_id']][0][0]['balance'] = round(($items[$order['OrderSeller']['order_id']][0][0]['total_sales'] + $items[$order['OrderSeller']['order_id']][0][0]['total_delivery_cost'] + $items[$order['OrderSeller']['order_id']][0][0]['total_refund_amount']),2);
							if($items[$order['OrderSeller']['order_id']][0][0]['balance'] > 0){
								$items[$order['OrderSeller']['order_id']][0][0]['total_deposite'] = round(($items[$order['OrderSeller']['order_id']][0][0]['balance'] - $items[$order['OrderSeller']['order_id']][0][0]['fee']),2) ;
							} else {
								$items[$order['OrderSeller']['order_id']][0][0]['total_deposite'] = 0;
							}
							
							if($flag_next15 == 0){
								if(strtotime($order['OrderSeller']['created']) <= strtotime($datetime_b4_15days)) {
									$deposited = round(($deposited + $items[$order['OrderSeller']['order_id']][0][0]['total_deposite']),2);
								}
								
							} else {
								$deposited = $opening_balance;
								
							}
							$items[$order['OrderSeller']['order_id']][0][0]['order_number'] = $order['Order']['order_number'];
							if(!empty($items[$order['OrderSeller']['order_id']])){
								$all_orders[$i]['PaymentInfo'] = $items[$order['OrderSeller']['order_id']][0][0];
							}
							$total_balance = round(($total_balance + $items[$order['OrderSeller']['order_id']][0][0]['total_deposite']),2);
						}
						$i++;
					}
					
					if(!empty($all_penalty)){
						$totalpenalty1=0;
						foreach($all_penalty as $penalty){
							$totalpenalty=$penalty['PaymentPenalty']['fees'];
							$totalpenalty1=$totalpenalty+$totalpenalty1;
						}						
					}
					
					if($flag_next15 == 0){
						$closing_balance = ($total_balance - $deposited)-$totalpenalty1;
					} else {
						$closing_balance = $total_balance - $totalpenalty1;
					}
// pr($all_orders);echo 'OB: '.$opening_balance.'<br>CB: '.$closing_balance.'<br>Deposited: '.$deposited.'<br> TBD : '.$total_balance;
// 				echo '<hr>';

					if(!empty($seller['Seller']['bank_account_number'])){
						$this->data['PaymentReport']['account_info'] = $seller['Seller']['bank_account_number'];
					} else if(!empty($seller['Seller']['paypal_account_mail'])){
						$this->data['PaymentReport']['account_info'] = $seller['Seller']['paypal_account_mail'];
					} else {
						$this->data['PaymentReport']['account_info'] = '';
					}
					$FileName = 'paymentreport_'.$seller['User']['id'].'_'.date("d_m_Y-H_i_s").'.csv';
					$NewFile = fopen($FULL_PATH_TO_DT.'/'.$FileName,"w+");
					$Content = "PAYMENT ACCOUNT:,".$this->data['PaymentReport']['account_info'].",\n";
					$Content = $Content."DATE:,".date('d/m/Y').",\n";
					$Content = $Content."OPENING BALANCE:,".$opening_balance.",\n";
					$Content = $Content."CLOSING BALANCE:,".$closing_balance.",\n";
					$Content = $Content."DEPOSITED IN ACCOUNT:,".$deposited.",\n";
					$Content = $Content."TOTAL BALANCE:,".$total_balance.",\n";
					$Content = $Content."ORDER ID,DATE,SALES TOTAL,DELIVERY TOTAL,REFUND VALUE,REFUND DATE,BALANCE,FEES,TOTAL DEPOSIT,CURRENCY,\n";
					if(!empty($all_orders)){
						foreach($all_orders as $order_current){
							$order_deposited = round($order_current['PaymentInfo']['total_deposite'],2);
							
							$Content = $Content.$order_current['PaymentInfo']['order_number'].",".date('d/m/Y', strtotime($order_current['OrderSeller']['created'])).",".$order_current['PaymentInfo']['total_sales'].",".$order_current['PaymentInfo']['total_delivery_cost'].",".$order_current['PaymentInfo']['total_refund_amount'].",".$order_current['PaymentInfo']['refund_created'].",".$order_current['PaymentInfo']['balance'].",".$order_current['PaymentInfo']['fee'].",".$order_deposited.",".$currency_name.",\n";
						}
					}
					$Content1='';
					if(!empty($all_penalty)){
						$Content1='';						
						foreach($all_penalty as $all_penalty1){
							
							$Content1 = $Content1.$all_penalty1['PaymentPenalty']['reason'].",".date('d/m/Y', strtotime($all_penalty1['PaymentPenalty']['from_date'])).",0.00,0.00,0.00,0.00,0.00,-".$all_penalty1['PaymentPenalty']['fees'].",".$all_penalty1['PaymentPenalty']['fees'].",".$currency_name.",\n";
							
						}
					}
					$wholeContent=$Content.",\n".$Content1;
					if(fwrite($NewFile, $wholeContent)) {
						$this->data['PaymentReport']['id'] = 0;
						$this->data['PaymentReport']['seller_id'] = $seller['User']['id'];
						if(!empty($seller['Seller']['bank_account_number'])){
							$this->data['PaymentReport']['account_info'] = $seller['Seller']['bank_account_number'];
						} else if(!empty($seller['Seller']['paypal_account_mail'])){
							$this->data['PaymentReport']['account_info'] = $seller['Seller']['paypal_account_mail'];
						} else {
							$this->data['PaymentReport']['account_info'] = '';
						}
						$this->data['PaymentReport']['from_date'] = $from_date;
						$this->data['PaymentReport']['to_date'] = $to_date;
						$this->data['PaymentReport']['opening_balance'] = $opening_balance;
						$this->data['PaymentReport']['closing_balance'] = $closing_balance;
						$this->data['PaymentReport']['deposited'] = $deposited;
						$this->data['PaymentReport']['report_name'] = $FileName;
						$this->PaymentReport->set($this->data);
						if($this->PaymentReport->save()){
							$this->send_email($seller['User']['email'],$seller['Seller']['business_display_name'],$seller['User']['firstname'],$seller['User']['lastname']);
						}
					} else {
						$Errors['error'][] = "Could not write to CSV file!";
					}
					fclose($NewFile);
					header("Content-type: application/force-download");
					header('Content-Disposition: inline; filename="'.$NewFile.'"');
					header("Content-Transfer-Encoding: Binary");
					header("Content-length: ".filesize($NewFile));
					header('Content-Type: application/excel');
					header('Content-Disposition: attachment; filename="'.$FileName.'"');
					readfile($NewFile);
				}
			}
			
		}
	}


	/**
	@function : send_email
	@description : to send mail when payment report is generated
	@Created by : Ramanpreet Pal
	@Modify : NULL
	@Created Date : June 29,2011
	*/
	function send_email($seller_email = null,$seller_displayname = null,$seller_firstname = null,$seller_last_name = null){
// 		ini_set('memory_limit', '9999M');
// 		set_time_limit(0);
		
		/** Send upcominf payment notification email **/
		$this->Email->smtpOptions = array(
			'host' => Configure::read('host'),
			'username' =>Configure::read('username'),
			'password' => Configure::read('password'),
			'timeout' => Configure::read('timeout')
		);
		
		$this->Email->sendAs= 'html';
		$link=Configure::read('siteUrl');
			/******import emailTemplate Model and get template****/
		App::import('Model','EmailTemplate');
		$this->EmailTemplate = new EmailTemplate;
			
		/**
		table: 		email_templates
		id:		18
		description:	Customer event
		*/
		$template = $this->Common->getEmailTemplate(18);

		$this->Email->from = $template['EmailTemplate']['from_email'];
		$data=$template['EmailTemplate']['description'];
		
		
		$data=str_replace('[SellersDisplayName]',$seller_displayname,$data);
		$template['EmailTemplate']['subject'] = $template['EmailTemplate']['subject'];
		$this->Email->subject = $template['EmailTemplate']['subject'];
		$this->set('data',$data);
		//$this->Email->to = $seller_email;
		$this->Email->to = array('gyanp.sdei@gmail.com','vcvreddy@yahoo.com');
		/******import emailTemplate Model and get template****/
		$this->Email->template='commanEmailTemplate';
		$this->Email->send();
		
		exit;
		
	}

	function test(){
		echo date('d/m/Y H:i:s A');
		$this->layout='ajax';
		//echo phpinfo();
		set_time_limit(0);
		ini_set('memory_limit', '9999M');
		
	//Configure::write('debug',2);
$dir = WWW_ROOT.'img/products/medium';
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
    		$count = 0;
       		while (($file = readdir($dh)) !== false) {
       			if($file != '.' && $file !='..'){
       			//pr($file);
       			$this->data['TempMid']['id']='';
			$this->data['TempMid']['img_mid_name'] = $file;
			$count=$count+1;
			//$inserts=$this->TempMid->save($this->data);
			}
        	}
        	echo $count;
        }
  }
      closedir($dh);
      
		//Configure::write('debug',2);		
		//App::import('Model','CustomAttribute');
		//$this->CustomAttribute = new CustomAttribute();
		//echo $totalRec = $this->CustomAttribute->find('count');
		//echo "1321321";
/*Configure::write('debug',1);
App::import('Model' , 'TempMid');
$this->TempMid = new TempMid();

$dir = WWW_ROOT.'img/products/medium';
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
       		while (($file = readdir($dh)) !== false) {
       			if($file != '.' && $file !='..'){
       			//pr($file);
       			$this->data['TempMid']['id']='';
			$this->data['TempMid']['img_mid_name'] = $file;
			//pr($this->data);
			$inserts=$this->TempMid->save($this->data);
			}
        	}
        }
  }
      closedir($dh);
      if($inserts){
 		echo "complate";
      }*/

/*foreach($totalimg as $imgname){
$dir = WWW_ROOT.'img/products/large';
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
		if('img_400_'.$imgname['Product']['product_image']==$file){
			//$imagename[]=array($imgname['Product']['product_image']);
			$imagename[] = 'yes';
		}else{
			$imagename[] = 'No';
		}
        }
        }
     //}
        closedir($dh);
    }
}*/
//pr($imagename);

/*$filePath=WWW_ROOT."files/fhcsvs/categories123.csv";
$fp = fopen($filePath, 'w');
foreach($imagename as $imagename){
	$fileComp=fputcsv($fp, $imagename,"\t");
}
unset($imagename);
fclose($fp);
		if($fileComp){
			echo "complate";
		}else{
			echo "Not complate";
		}
		exit;*/

//foreach($totalimg as $imgname){

	//if ($handle = opendir(WWW_ROOT.'img/products/large')) {
	//	$entry = readdir($handle);
	//	pr($entry);
		//while (false !== ('img_400_'.$imgname['Product']['product_image'] = readdir($handle))) {
		//if(is_array('img_400_'.$imgname['Product']['product_image'],$handle)){
		//if('img_400_'.$imgname['Product']['product_image']==$entry){
		//$cnt = $cnt+1;
		//}
		//}
		//}

	//}
	
	
	
	
//}
//echo $cnt;

//if ($handle = opendir(WWW_ROOT.'img/products/large')) {
  //  echo "Directory handle: $handle\n";
   // echo "Entries:\n";

    /* This is the correct way to loop over the directory. */
   // $cnt = "";
  //  while (false !== ($entry = readdir($handle))) {
    //	if($entry != '.' || $entry !='..'){
    		//if($entry=strstr(img_400_)
    		//if(strstr($entry, 'img_400_')){
    		//$cnt = $cnt+1;
    		//}
    		//if($imgname['Product']['product_image']==$entry){
		//$cnt = $cnt+1;
		
		//}
    		
    		
    //	}
   // }
    
  // }
  // echo $cnt;

   // closedir($handle);
//}//foreach close

exit;
	}
	
	
	/**
	@function : get_sellers_list 
	@description : to Sellers id who is not before 1 month create or update his/her product
	@Created by : Nakul Kumar
	@Modify : NULL
	@Created Date : 18-Aug-2011 
	*/
	function send_listingmail_sellers() {
				
		//$sDateTime=date('Y-m-d', mktime(00,00,00,date('m'),date('d')-30,date('Y')));
		
		$sDateTime=date('Y-m-d', mktime(00,00,00,date('m'),date('d')-30,date('Y')));
				
		App::import('Model' , 'ProductSeller');
		$this->ProductSeller = new ProductSeller();
		$this->ProductSeller->expects(array('User'));
		$this->ProductSeller->User->expects(array('SellerSummary'));
		$this->ProductSeller->recursive = 2;
		/*
		$allSellerList = $this->ProductSeller->find('all',array('conditions'=>array(
				('ProductSeller.created >= "'.$sDateTime.'"' || 'ProductSeller.modified >= "'.$sDateTime.'"')),
				'fields'=>array('ProductSeller.seller_id','ProductSeller.product_id', 'User.email'),
				'order'=> array( 'ProductSeller.seller_id DESC' ),
				'group'=>array('ProductSeller.seller_id'),
				//'limit'=>10,
				));
		
		$allSellerList = $this->ProductSeller->find('all',array('conditions'=>array("OR"=>array('date(ProductSeller.created)' => $sDateTime, 'date(ProductSeller.modified)' => $sDateTime)),
				'fields'=>array('ProductSeller.seller_id','ProductSeller.product_id','ProductSeller.created','ProductSeller.modified', 'User.email'),
				'order'=> array( 'ProductSeller.seller_id DESC' ),
				'group'=>array('ProductSeller.seller_id'),
				//'limit'=>10,
				//'limit'=>3,
				));
		*/
		$allSellerList = $this->ProductSeller->find('all',array(
				'fields'=>array('ProductSeller.seller_id','ProductSeller.product_id','ProductSeller.created','DATEDIFF( NOW( ) , DATE( MAX( `ProductSeller`.`modified` ) ) ) AS modified', 'User.email'),
				'order'=> array( 'ProductSeller.seller_id DESC' ),
				'group'=>array('ProductSeller.seller_id')
				));
		//echo '<pre>'; print_r($allSellerList);
		//die;
		/** Send email after feedback **/
			$this->Email->smtpOptions = array(
				'host' => Configure::read('host'),
				'username' =>Configure::read('username'),
				'password' => Configure::read('password'),
				'timeout' => Configure::read('timeout')
			);
			
			$this->Email->replyTo=Configure::read('replytoEmail');
			$this->Email->sendAs= 'html';
			$link=Configure::read('siteUrl');
			/******import emailTemplate Model and get template****/
			
			App::import('Model','EmailTemplate');
			$this->EmailTemplate = new EmailTemplate;
			/**
			table: email_templates
			id: 28
			description: ad feedback mail format for admin
			*/
			$template = $this->Common->getEmailTemplate(19);
									
		foreach($allSellerList as $value){
			$sellerEmail=$value['User']['email'];
			//$SellersDisplayName=$value['User']['SellerSummary']['business_display_name'];
			$SellersDisplayName=$value['User']['firstname'];
			
			$data = $template['EmailTemplate']['description'];
			$this->Email->from = $template['EmailTemplate']['from_email'];
			
			//$template['EmailTemplate']['subject'] = str_replace('[SellersDisplayName]', $SellersDisplayName, $template['EmailTemplate']['subject']);
			//$this->Email->subject = $template['EmailTemplate']['subject'];
			
			$subjectOfMail = "";
			$subjectOfMail = $template['EmailTemplate']['subject'];
			//$template['EmailTemplate']['subject'] = str_replace('[SellersDisplayName]', $SellersDisplayName, $template['EmailTemplate']['subject']);
			$subjectOfMail = str_replace('[SellersDisplayName]', $value['User']['firstname'], $subjectOfMail);
			$this->Email->subject = $subjectOfMail;
			
			
			$this->data = Sanitize::clean($this->data);
			$data = str_replace('[SellersDisplayName]', $SellersDisplayName, $data);
			$this->set('data',$data);
			//$this->Email->to = 'gyanprakaash@hotmail.com';
			$this->Email->to = $sellerEmail;
			//$this->Email->to = array('gyanp.sdei@gmail.com','vcvreddy@yahoo.com');
						
			/******import emailTemplate Model and get template****/
			$this->Email->template='commanEmailTemplate';
			if($value[0]['modified'] >30){
			if($this->Email->send()){
				$this->Session->setFlash('Feedback has been submitted successfully!');
			}else{
				$this->Session->setFlash('Please login first.','default',array('class'=>'flashError'));
			}
			}
		}
		
		
		//$this->set('sDateTime',date('d-F-Y',strtotime($sDateTime)));
		$this->set('allSellerList' , $allSellerList);
		die;
	}
	
	
	/**
	@function:	custom_attribute_csv
	@description:	Get Products with categories Csv for FH
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	25 Agu 2011
	*/		
		
	function custom_attribute_csv(){
		//die('test123');
		//set_time_limit(0);
		//ini_set('memory_limit', '9999M');
		Configure::write('debug',2);
		/*echo WWW_ROOT;
		$filePath=WWW_ROOT."files/fhcsvs/nakul.txt";
		$fp = fopen($filePath, 'w');
		fwrite($fp, '1');
		fwrite($fp, '23');
		fclose($fp);	
		echo "done";
		exit;*/
		
		App::import('Model','CustomAttribute');
		$this->CustomAttribute = new CustomAttribute();
		/*Start For add some extra fields*/
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		App::import('Model','ProductVisit');
		$this->ProductVisit = new ProductVisit();
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		$this->OrderItem->expects(array('Order'));
		App::import('Model','Product');
		$this->Product = new Product();
		App::import('Model','Review');
		$this->Review = new Review();
		App::import('Model','ProductQuestion');
		$this->ProductQuestion = new ProductQuestion();
		App::import('Model','ProductAnswer');
		$this->ProductAnswer = new ProductAnswer();
		
		$pro_seller = array();
		$productsellers = $this->ProductSeller->find('all',
				array(
				'fields'=> array('ProductSeller.product_id' , 'count(ProductSeller.seller_id) as totalSeller'),
				'group'=>array('ProductSeller.product_id'),
			//	'limit'=>30,
				));
		foreach($productsellers as $productseller){
			$pro_seller[$productseller['ProductSeller']['product_id']] = $productseller['0']['totalSeller'];
		}
		
		
		$is_seller = array();
		$is_seller = $this->ProductSeller->find('list',
				array(
				'conditions'=> array('ProductSeller.quantity > 0'),
				'fields'=> array('ProductSeller.product_id' , 'ProductSeller.product_id'),
				'group'=>array('ProductSeller.product_id'),
				));
		$pro_visit90 = array();
		$productvisits90 = $this->ProductVisit->find('all',
				array(
				'conditions'=> array('created BETWEEN DATE_SUB(now() , INTERVAL 90 DAY) and now()'),
				'fields'=> array('ProductVisit.product_id' , 'ProductVisit.created' , 'sum(ProductVisit.visits) as totalVisit'),
				'group'=>array('ProductVisit.product_id'),
				//'limit'=>30,
				));
		foreach($productvisits90 as $productvisits90){
			$pro_visit90[$productvisits90['ProductVisit']['product_id']] = $productvisits90['0']['totalVisit'];
		}
		//pr($pro_visit90);
		//exit;
		
		$pro_visit = array();
		$productvisits = $this->ProductVisit->find('all',
				array(
				'fields'=> array('ProductVisit.product_id' , 'sum(ProductVisit.visits) as totalVisit'),
				'group'=>array('ProductVisit.product_id'),
				//'limit'=>30,
				));
		foreach($productvisits as $productvisits){
			$pro_visit[$productvisits['ProductVisit']['product_id']] = $productvisits['0']['totalVisit'];
		}
		
		$pro_sold90 = array();
		$productsolds90 = $this->OrderItem->find('all',
				array(
				'conditions'=> array('Order.created BETWEEN DATE_SUB(now() , INTERVAL 90 DAY) and now()'),
				'fields'=> array('OrderItem.product_id' , 'Order.id', 'OrderItem.order_id','sum(OrderItem.quantity) as totalSold'),
				'group'=>array('OrderItem.product_id'),
				//'limit'=>30,
				));
		foreach($productsolds90 as $productsolds90){
			$pro_sold90[$productsolds90['OrderItem']['product_id']] = $productsolds90['0']['totalSold'];
		}
		//pr($pro_sold90);
		//exit;
		$pro_sold = array();
		$productsolds = $this->OrderItem->find('all',
				array(
				'fields'=> array('OrderItem.product_id' , 'sum(OrderItem.quantity) as totalSold'),
				'group'=>array('OrderItem.product_id'),
				//'limit'=>30,
				));
		foreach($productsolds as $productsolds){
			$pro_sold[$productsolds['OrderItem']['product_id']] = $productsolds['0']['totalSold'];
		}
		//pr($pro_sold);
		//exit;
		$pro_revenue = array();
		$productrevenues = $this->OrderItem->find('all',
				array(
				'fields'=> array('OrderItem.product_id' , 'sum(OrderItem.quantity * OrderItem.price) as totalSold'),
				'group'=>array('OrderItem.product_id'),
				//'limit'=>30,
				));
		foreach($productrevenues as $productrevenues){
			$pro_revenue[$productrevenues['OrderItem']['product_id']] = $productrevenues['0']['totalSold'];
		}
		//pr($pro_revenue);
		//exit;
		
		$seller_rating = array();
		$joptions = array(
				array('table' => 'feedbacks',
				'alias' => 'Feedback',
				'type' => 'LEFT',
				'conditions' => array('Feedback.seller_id = if(Product.minimum_price_seller,Product.minimum_price_seller,Product.minimum_price_used_seller)')
				)
				);
		$sellerAvgRatting = $this->Product->find('all',
				array(
				'fields'=> array('Product.id' , 'if(Product.minimum_price_seller,Product.minimum_price_seller,Product.minimum_price_used_seller) as seller_id',"(sum(Feedback.rating)/(count(Feedback.rating)*5))*100 as avgRating"),
				'order'=>array('Product.id'),
				"joins"=>$joptions,
				"group"=>array('Product.id',"Product.minimum_price_seller"),
				//'limit'=>'30'
				));
		//pr($sellerAvgRatting);
		//exit;
			/*$sellerAvgRatting = $this->Product->find('all',
				array(
				'fields'=> array('Feedback.product_id' , 'Feedback.seller_id',"(sum(Feedback.rating)/(count(Feedback.rating)*5))*100 as avgRating"),
				'order'=>array('Feedback.product_id'),
				"group"=>array('Feedback.product_id',"Product.minimum_price_seller","Product.minimum_price_used_seller"),
				//'limit'=>'30'
				)); cast(varfield as signed)*/
		
		/*$joptions = array(
				array('table' => 'feedbacks',
				'alias' => 'Feedback',
				'type' => 'inner',
				'conditions' => array('Feedback.seller_id = seller_id')
				)
				);
		
		$sellerAvgRatting = $this->Product->find('all',array("fields"=>array("Product.id","if(Product.minimum_price_seller,Product.minimum_price_seller,Product.minimum_price_used_seller) as seller_id","Feedback.rating as avgRating"), 'joins'=>$joptions, "order"=>array("Product.id"),"group"=>array("Product.id","seller_id","Feedback.rating")));
		
		pr($sellerAvgRatting);*/
		//exit;
		foreach($sellerAvgRatting as $sellerAvgRatting){
			$seller_rating[$sellerAvgRatting['Product']['id']] = round($sellerAvgRatting['0']['avgRating'],2);
		}
		$pro_reviews = array();
		$product_reviews = $this->Review->find('all',
				array(
				'fields'=> array('Review.product_id' , 'count(Review.id) as totalReview'),
				'order'=>array('Review.product_id'),
				"group"=>array('Review.product_id'),
				//'limit'=>'30'
				));
		$product_review = array();
		foreach($product_reviews as $product_reviews){
			$product_review[$product_reviews['Review']['product_id']] = $product_reviews['0']['totalReview'];
		}
		
		$pro_questions = array();
		$product_question = $this->ProductQuestion->find('all',
				array(
				'fields'=> array('ProductQuestion.product_id' , 'count(ProductQuestion.id) as totalQuestion'),
				'order'=>array('ProductQuestion.product_id'),
				"group"=>array('ProductQuestion.product_id'),
				//'limit'=>'30'
				));
		foreach($product_question as $product_question){
			$pro_questions[$product_question['ProductQuestion']['product_id']] = $product_question['0']['totalQuestion'];
		}
			
		$pro_answers = array();
		$product_answers = $this->ProductAnswer->find('all',
				array(
				'fields'=> array('ProductAnswer.product_id' , 'count(ProductAnswer.id) as totalAnswer'),
				'order'=>array('ProductAnswer.product_id'),
				"group"=>array('ProductAnswer.product_id'),
				//'limit'=>'30'
				));
		foreach($product_answers as $product_answers){
			$pro_answers[$product_answers['ProductAnswer']['product_id']] = $product_answers['0']['totalAnswer'];
		}
			
		$product_video = array();
		$product_video = $this->Product->find('list',
				array(
				'fields'=> array('Product.id' , 'Product.product_video'),
				'order'=>array('Product.id'),
				"group"=>array('Product.id'),
				//'limit'=>'30'
				));
		//exit;
		/*foreach($product_video as $product_video){
			$pro_video[$product_video['ProductAnswer']['product_id']] = $product_video['0']['totalAnswer'];
		}
		pr($pro_answers);*/
		
		$productList1[0]['product']=array('product_id' , 'locale' , 'attribute_id', 'attribute_value_id', 'attribute_value');
		$filePath=WWW_ROOT."files/fhcsvs/custom_attributes_values.csv";
		/*
		if file exist delete the fiule file and create a new file
		*/
		if(file_exists($filePath)){
			unlink($filePath);
		}
		
		
		$fileHead = fopen($filePath, "w");
		if(!empty($productList1)){
		$Content='';	
			foreach($productList1 as $fields1){
				//for($k=0;$k<count($fields1);$k++){
					$Content .= $fields1['product'][0]."\t\t";
					$Content .= $fields1['product'][1]."\t\t";
					$Content .= $fields1['product'][2]."\t\t";
					$Content .= $fields1['product'][3]."\t\t";
					$Content .= $fields1['product'][4];
					$Content .= "\n";
				//}
			}
		}
		$fileHeadWrite=fwrite($fileHead, $Content);
		fclose($fileHead);
		unset($productList1);
		unset($Content);
		$totallist = $this->CustomAttribute->find('list',array("fields"=>array("CustomAttribute.quick_code"),"order"=>array("CustomAttribute.id"),"group"=>array("CustomAttribute.quick_code")));
		//$totalRec = 30;
		$quickcodearra=array();
		$totalRec=count($totallist);
		$totalPage=$totalRec/1000;
		$pagearray=array_chunk($totallist, 1000);
		//pr($pagearray); die;
		
		
		foreach($pagearray as $pa){
					$productList=$this->CustomAttribute->find('all',
					array("conditions"=>array("CustomAttribute.quick_code"=>$pa),'group'=>array('CustomAttribute.quick_code')
					));
					//pr($productList);
			$search  = array(' ', "\r\n", ',','.','&');
			$cnt=count($productList);
			$array_attr=array();
			$ContentFieldValue='';	
			$qcode="";
			$notarray=array("id","quick_code","department_id");
			foreach($productList as $prod){
				
			$qcode=$prod["CustomAttribute"]["quick_code"];
			foreach($prod["CustomAttribute"] as $key=>$atrarr){
			 		if(!in_array($key,$notarray)){
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= $key."\t\t";
					$ContentFieldValue .=  str_replace($search,'_',trim(preg_replace('/[^a-zA-Z0-9]/',' ',strip_tags(html_entity_decode( $atrarr,ENT_QUOTES,'UTF-8')))))."\t\t";
					$ContentFieldValue .=  str_replace(array("\r\n","\n","&amp;"),array('~','~','and'),trim($atrarr));
					$ContentFieldValue .= "\n";
					}
			}					
			               
			                $ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "number_of_marketplace_sellers\t\t";
					$ContentFieldValue .=  ((!empty($pro_seller[$prod["CustomAttribute"]["id"]])) ? $pro_seller[$prod["CustomAttribute"]["id"]] : "0")."\t\t";
					$ContentFieldValue .=  ((!empty($pro_seller[$prod["CustomAttribute"]["id"]])) ? $pro_seller[$prod["CustomAttribute"]["id"]] : "0");
					$ContentFieldValue .= "\n";
					
					if(key_exists($prod["CustomAttribute"]["id"], $is_seller)){
						$isseller = 'Y';
					}else{
						$isseller = 'N';
					}
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "is_marketplace_seller\t\t";
					$ContentFieldValue .=  $isseller."\t\t";
					$ContentFieldValue .=  $isseller;
					$ContentFieldValue .= "\n";
					
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "product_page_views_90\t\t";
					$ContentFieldValue .=  ((!empty($pro_visit90[$prod["CustomAttribute"]["id"]])) ? $pro_visit90[$prod["CustomAttribute"]["id"]] : "0")."\t\t";
					$ContentFieldValue .=  ((!empty($pro_visit90[$prod["CustomAttribute"]["id"]])) ? $pro_visit90[$prod["CustomAttribute"]["id"]] : "0");
					$ContentFieldValue .= "\n";
					
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "product_page_views_lifetime\t\t";
					$ContentFieldValue .=  ((!empty($pro_visit[$prod["CustomAttribute"]["id"]])) ? $pro_visit[$prod["CustomAttribute"]["id"]] : "0")."\t\t";
					$ContentFieldValue .=  ((!empty($pro_visit[$prod["CustomAttribute"]["id"]])) ? $pro_visit[$prod["CustomAttribute"]["id"]] : "0");
					$ContentFieldValue .= "\n";
					
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "number_of_product_sold_90\t\t";
					$ContentFieldValue .=  ((!empty($pro_sold90[$prod["CustomAttribute"]["id"]])) ? $pro_sold90[$prod["CustomAttribute"]["id"]] : "0")."\t\t";
					$ContentFieldValue .=  ((!empty($pro_sold90[$prod["CustomAttribute"]["id"]])) ? $pro_sold90[$prod["CustomAttribute"]["id"]] : "0");
					$ContentFieldValue .= "\n";
					
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "number_of_product_sold_life\t\t";
					$ContentFieldValue .=  ((!empty($pro_sold[$prod["CustomAttribute"]["id"]])) ? $pro_sold[$prod["CustomAttribute"]["id"]] : "0")."\t\t";
					$ContentFieldValue .=  ((!empty($pro_sold[$prod["CustomAttribute"]["id"]])) ? $pro_sold[$prod["CustomAttribute"]["id"]] : "0");
					$ContentFieldValue .= "\n";
					
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "product_total_revenue\t\t";
					$ContentFieldValue .=  ((!empty($pro_revenue[$prod["CustomAttribute"]["id"]])) ? $pro_revenue[$prod["CustomAttribute"]["id"]] : "0")."\t\t";
					$ContentFieldValue .=  ((!empty($pro_revenue[$prod["CustomAttribute"]["id"]])) ? $pro_revenue[$prod["CustomAttribute"]["id"]] : "0");
					$ContentFieldValue .= "\n";
					
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "lowest_priced_marketplace_seller_rating_percentage\t\t";
					$ContentFieldValue .=  ((!empty($seller_rating[$prod["CustomAttribute"]["id"]])) ? $seller_rating[$prod["CustomAttribute"]["id"]] : "0")."\t\t";
					$ContentFieldValue .=  ((!empty($seller_rating[$prod["CustomAttribute"]["id"]])) ? $seller_rating[$prod["CustomAttribute"]["id"]] : "0");
					$ContentFieldValue .= "\n";
					
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "number_reviews_product\t\t";
					$ContentFieldValue .=  ((!empty($product_review[$prod["CustomAttribute"]["id"]])) ? $product_review[$prod["CustomAttribute"]["id"]] : "0")."\t\t";
					$ContentFieldValue .=  ((!empty($product_review[$prod["CustomAttribute"]["id"]])) ? $product_review[$prod["CustomAttribute"]["id"]] : "0");
					$ContentFieldValue .= "\n";
					
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "number_questions_product\t\t";
					$ContentFieldValue .=  ((!empty($pro_questions[$prod["CustomAttribute"]["id"]])) ? $pro_questions[$prod["CustomAttribute"]["id"]] : "0")."\t\t";
					$ContentFieldValue .=  ((!empty($pro_questions[$prod["CustomAttribute"]["id"]])) ? $pro_questions[$prod["CustomAttribute"]["id"]] : "0");
					$ContentFieldValue .= "\n";
					
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "number_answers_products\t\t";
					$ContentFieldValue .=  ((!empty($pro_answers[$prod["CustomAttribute"]["id"]])) ? $pro_answers[$prod["CustomAttribute"]["id"]] : "0")."\t\t";
					$ContentFieldValue .=  ((!empty($pro_answers[$prod["CustomAttribute"]["id"]])) ? $pro_answers[$prod["CustomAttribute"]["id"]] : "0");
					$ContentFieldValue .= "\n";
					
					$ContentFieldValue .= $qcode."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= "is_products_video\t\t";
					$ContentFieldValue .=  ((!empty($product_video[$prod["CustomAttribute"]["id"]])) ? "Y" : "N")."\t\t";
					$ContentFieldValue .=  ((!empty($product_video[$prod["CustomAttribute"]["id"]])) ? "Y" : "N");
					$ContentFieldValue .= "\n";
			}
			//pr($ContentFieldValue); die;
			
			
			$pathContent=WWW_ROOT."files/fhcsvs/custom_attributes_values.csv";
			$pathContentOpen = fopen($pathContent, "a+");
			$pathContentWrite=fwrite($pathContentOpen, $ContentFieldValue);
			unset($ContentFieldValue);
			//$incrivalue = $incrivalue+$end_limit;
			fclose($pathContentOpen);
			//die();
		}
		exit;
	}
	
	
	
	/**
	@function:	variant_attributes_csv
	@description:	Get Variants values Csv for FH  
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	08 Sep 2011
	*/
	function variant_attributes_csv(){
		//ini_set('memory_limit', '9999M');
		//set_time_limit(0);
		Configure::write('debug',2);
		
		App::import('Model' , 'VariantAttribute');
		$this->VariantAttribute = new VariantAttribute();
		
		
		$productList1[0]['product']=array('variant_id' , 'locale' , 'attribute_id' , 'attribute_value_id' , 'attribute_value');
		$filePath=WWW_ROOT."files/fhcsvs/custom_variant_attributes.csv";
		/*
		if file exist delete the fiule file and create a new file
		*/
		if(file_exists($filePath)){
			unlink($filePath);
		}
		
		$fileHead = fopen($filePath, "w");
		if(!empty($productList1)){
		$Content='';	
			foreach($productList1 as $fields1){
				//for($k=0;$k<count($fields1);$k++){
					$Content .= $fields1['product'][0]."\t\t";
					$Content .= $fields1['product'][1]."\t\t";
					$Content .= $fields1['product'][2]."\t\t";
					$Content .= $fields1['product'][3]."\t\t";
					$Content .= $fields1['product'][4];
					$Content .= "\n";
				//}
			}
		}
		$fileHeadWrite=fwrite($fileHead, $Content);
		fclose($fileHead);
		unset($productList1);
		unset($Content);
		
		
		$totallist = $this->VariantAttribute->find('all',array(
						"fields"=>array("VariantAttribute.quick_code"),
						"group"=>array("VariantAttribute.quick_code"),
						//'limit'=>'2'
						));
		$product_list_array = array();
		$n = 0;
		foreach($totallist as $product_list){
			$product_list_array[$n] = $product_list['VariantAttribute']['quick_code'];
			$n++;
		}
		//$totalRec = 30;
		//$quickcodearra=array();
		//echo $totalRec=count($totallist);
		//$totalPage=$totalRec/1000;
		$pagearray=array_chunk($product_list_array, 1000);
		foreach($pagearray as $productArray){
			foreach($productArray as $pa){
					$variantAttributes=$this->VariantAttribute->find('all',
					array("conditions"=>array("VariantAttribute.quick_code"=>$pa),
					"group"=>array("VariantAttribute.quick_code")
					));
						
		//$variantAttributes=$this->VariantAttribute->find('all',
				//array( 
				//"fields"=>array("*",),`seller_id` =240386
				//'conditions'=>array('VariantAttribute.seller_id'=>'240386'),
				//'group'=>array("VariantAttribute.quick_code"),
				//'qc_sellerid' => 'CONCAT(VariantAttribute.quick_code,VariantAttribute.seller_id)',
				//'group'=>array('CONCAT(VariantAttribute.quick_code,VariantAttribute.seller_id)')
				//));
		/*for($i=0;count($variantAttributes)>$i;$i++){
			$arrvariant[$i]=$variantAttributes[$i]['VariantAttribute'];
			$arrvariantKey[$i]=array_keys($arrvariant[$i]);
			for($j=0;count($arrvariant[$i])>$j;$j++){
				if($j<14){
				$arrvariantPrint[$i][$j][0]=$arrvariant[$i][$arrvariantKey[$i][1]].'_'.$arrvariant[$i][$arrvariantKey[$i][13]].'_'.$arrvariant[$i][$arrvariantKey[$i][2]];
				$arrvariantPrint[$i][$j][1]="en_GB";
				$arrvariantPrint[$i][$j][2]=$arrvariantKey[0][$j+3];
				$arrvariantPrint[$i][$j][3]=strtolower(str_replace(" ","_",trim($arrvariant[$i][$arrvariantKey[0][$j+3]])));
				$arrvariantPrint[$i][$j][4]=trim($arrvariant[$i][$arrvariantKey[0][$j+3]]);
				}
			}
		}*/
		
		/*$productList1[0]['product']=array('variant_id' , 'locale' , 'attribute_id' , 'attribute_value_id' , 'attribute_value');
		if(!empty($productList1)){
		$Content='';	
		foreach($productList1 as $fields1){
			//for($k=0;$k<count($fields1);$k++){
				$Content .= $fields1['product'][0]."\t\t";
				$Content .= $fields1['product'][1]."\t\t";
				$Content .= $fields1['product'][2]."\t\t";
				$Content .= $fields1['product'][3]."\t\t";
				$Content .= $fields1['product'][4];
				$Content .= "\n";
			//}
		}
		}*/
		
		
		
		
		
		
		
		/*if(!empty($arrvariantPrint)){
				$Content1='';	
				foreach($arrvariantPrint as $fields){
					for($i=0;$i<count($fields);$i++){
						$Content1 .= $fields[$i][0]."\t\t";
						$Content1 .= $fields[$i][1]."\t\t";
						$Content1 .= $fields[$i][2]."\t\t";
						$Content1 .= $fields[$i][3]."\t\t";
						$Content1 .= $fields[$i][4];
						$Content1 .= "\n";
					}
				}
			}*/
		$ContentFieldValue = "";
		foreach($variantAttributes as $attributes){
				
			$qcode=$attributes["VariantAttribute"]["quick_code"];
			$seller_id=$attributes["VariantAttribute"]["seller_id"];
			$condition_id=$attributes["VariantAttribute"]["condition_id"];
			$noarray = array('product_id','quick_code','condition_id');
			foreach($attributes["VariantAttribute"] as $key=>$atrarr){
				if(!in_array($key,$noarray)){
					$ContentFieldValue .= $qcode.'_'.$seller_id.'_'.$condition_id."\t\t";
					$ContentFieldValue .= "en_GB"."\t\t";
					$ContentFieldValue .= $key."\t\t";
					$ContentFieldValue .=strtolower(str_replace(" ","_",trim($atrarr)))."\t\t";
					$ContentFieldValue .=trim($atrarr);
					$ContentFieldValue .= "\n";
				}
			}
		}
		$filePath=WWW_ROOT."files/fhcsvs/custom_variant_attributes.csv";
		//$filePath = fopen($filePath, 'w+');
		$filePath = fopen($filePath, 'a+');
		$fileComp=fwrite($filePath, $ContentFieldValue);
		unset($ContentFieldValue);
		fclose($filePath);
		}}
		exit;
	}
	
	 /**
	@function:	product_csv
	@description:	Get Products with Product Csv for FH
	@params:	
	@Created by: 	Nakul Kumar
	@Modify:	8 Feb 2012
	@Created Date:	17 Agu 2011
	*/		
	function product_csv(){
		//Configure::write('debug',2);
		//$this->layout='layout_admin';
		App::import('Model' , 'ProductCategory');
		$this->ProductCategory = new ProductCategory();
		$this->ProductCategory->expects(array('Product'));
		$productList = $this->ProductCategory->find('all',
				array(
				'conditions'=>array('Product.status'=>'1'),
				'fields'=>array('Product.quick_code','group_concat(ProductCategory.category_id SEPARATOR " ") AS category_id'),
				//'order' => array('Product.quick_code'),
				'group' => array('Product.quick_code')
				//'limit' => 200,
				));
		$categoryList1[0]['Product']=array('product_id' , 'locale' , 'category_ids');
		$filePath=WWW_ROOT."files/fhcsvs/products.csv";
		$closefile = unlink($filePath);
		
		$filePath = fopen($filePath,"w+");
		
		if(!empty($categoryList1)){
		$Content='';	
		foreach($categoryList1 as $fields1){
			for($k=0;$k<count($fields1);$k++){
				$Content .= $fields1['Product'][0]."\t\t";
				$Content .= $fields1['Product'][1]."\t\t";
				$Content .= $fields1['Product'][2];
				$Content .= "\n";
			}
		}
		}	
		if(!empty($productList)){
				$Content1='';	
				foreach($productList as $fields){
					//for($i=0;$i<count($fields);$i++){
						$Content1 .= $fields['Product']['quick_code']."\t\t";
						$Content1 .= "en_GB"."\t\t";
						$Content1 .= $fields[0]['category_id'];
						$Content1 .= "\n";
					//}
				}
			}
		$wholeContent=$Content.$Content1;
		$fileComp=fwrite($filePath, $wholeContent);
		fclose($filePath);
		if($fileComp){
			echo "complete";
			exit;
		}else{
			echo "Not complete";
			exit;
		}
	}

	
	
	 /**
	@function:	admin_categories_csv
	@description:	Get category Csv for FH  
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	17 Agu 2011
	*/		
	function categories_csv(){
		//$this->layout='layout_admin';
		App::import('Model' , 'Category');
		$this->Category = new Category();
		$categoryList1[0]['Category']=array('category_id' , 'parent_category_id' , 'locale' , 'category_name');
		$categoryList1[1]['Category']=array('catalog01' , 'catalog01' , 'en_GB' , 'catalog01');
		
		$categoryList = $this->Category->find('all',
				array(
				'fields'=> array('Category.id' , 'Category.parent_id' , 'Category.cat_name'),
				//'limit'=>3,
				));
			 
		$filePath=WWW_ROOT."files/fhcsvs/categories.csv";
		
		$filePath = fopen($filePath,"w+");
		if(!empty($categoryList)){
		$Content='';	
		foreach($categoryList1 as $fields1){
			for($k=0;$k<count($fields1);$k++){
				$Content .= $fields1['Category'][0]."\t\t";
				$Content .= $fields1['Category'][1]."\t\t";
				$Content .= $fields1['Category'][2]."\t\t";
				$Content .= $fields1['Category'][3];
				$Content .= "\n";
			}
		}
		}	
			if(!empty($categoryList)){
				$Content1='';	
				foreach($categoryList as $fields){
					for($i=0;$i<count($fields);$i++){
						$Content1 .= $fields['Category']['id']."\t\t";	
						$Content1 .= (($fields['Category']['parent_id'] == 0) ? "catalog01" : $fields['Category']['parent_id'])."\t\t";
						$Content1 .= "en_GB"."\t\t";
						$Content1 .= trim($fields['Category']['cat_name']);
						$Content1 .= "\n";
					}
				}
			}
			//pr($Content);
			$wholeContent=$Content.$Content1;			
			$fileComp=fwrite($filePath, $wholeContent);
		fclose($filePath);
		if($fileComp){
			echo "complete";
			exit;
		}else{
			echo "Not complete";
			exit;
		}
		exit;
	}
	
	/**
	@function:	custom_attributes_meta_csv
	@description:	Get Custom attributes meta csv for FH 
	@params:	
	@Created by: 	Nakul Kumar
	@Modify:	NULL
	@Created Date:	8 Sep 2011
	*/		
	function custom_attributes_meta_csv(){
		//Configure::write('debug', 2);
		//$this->layout='ajax';
		App::import('Model' , 'CustomAttribute');
		$this->CustomAttribute = new CustomAttribute();
		$CustomAttribute="";
		$CustomAttributeQuery="DESC custom_attributes";
		$CustomAttribute=$this->CustomAttribute->query($CustomAttributeQuery);
		
		App::import('Model' , 'VariantAttribute');
		$this->VariantAttribute = new VariantAttribute();
		$VarientAttribute="";
		$VarientAttributeQuery="DESC variant_attributes";
		$VarientAttribute=$this->CustomAttribute->query($VarientAttributeQuery);
		
		
		
		App::import('Model' , 'ProductRating');
		$this->ProductRating = new ProductRating();
		$ProductRating="";
		$ProductRatingQuery="DESC product_ratings";
		$ProductRating=$this->ProductRating->query($ProductRatingQuery);
				
			for($i=0;count($VarientAttribute)>$i;$i++){
				$VarientAttributeArange[0]['COLUMNS']=$VarientAttribute[12]['COLUMNS'];
				$VarientAttributeArange[1]['COLUMNS']=$VarientAttribute[11]['COLUMNS'];
				$VarientAttributeArange[2]['COLUMNS']=$VarientAttribute[10]['COLUMNS'];
				$VarientAttributeArange[3]['COLUMNS']=$VarientAttribute[13]['COLUMNS'];
				$VarientAttributeArange[4]['COLUMNS']=$VarientAttribute[8]['COLUMNS'];
				$VarientAttributeArange[5]['COLUMNS']=$VarientAttribute[7]['COLUMNS'];
				$VarientAttributeArange[6]['COLUMNS']=$VarientAttribute[9]['COLUMNS'];
				$VarientAttributeArange[7]['COLUMNS']=$VarientAttribute[14]['COLUMNS'];
				$VarientAttributeArange[8]['COLUMNS']=$VarientAttribute[15]['COLUMNS'];
				$VarientAttributeArange[9]['COLUMNS']=$VarientAttribute[4]['COLUMNS'];
				$VarientAttributeArange[10]['COLUMNS']=$VarientAttribute[5]['COLUMNS'];
				$VarientAttributeArange[11]['COLUMNS']=$VarientAttribute[6]['COLUMNS'];
				$VarientAttributeArange[12]['COLUMNS']=$VarientAttribute[3]['COLUMNS'];
				$VarientAttributeArange[13]['COLUMNS']=$VarientAttribute[2]['COLUMNS'];	
			}
			for($i=0;count($ProductRating)>$i;$i++){
				$ProductRating1[0]['COLUMNS']=$ProductRating[2]['COLUMNS'];
				
			}
		$arrMarge=array_merge($CustomAttribute,$ProductRating1,$VarientAttributeArange);
		
			for($i=0;count($arrMarge)>$i;$i++){
				if($i!=1){
				$type=explode("(",$arrMarge[$i]['COLUMNS']['Type']);
				
				$customAttributeMeta[$i][0]=$arrMarge[$i]['COLUMNS']['Field'];
				$customAttributeMeta[$i][1]="";
				if($customAttributeMeta[$i][2]=$type[0]=='varchar'){
					$customAttributeMeta[$i][2]='asset';
				}else{
					$customAttributeMeta[$i][2]=$type[0];
				}
				$customAttributeMeta[$i][3]="";
				$customAttributeMeta[$i][4]="en_GB";
				$customAttributeMeta[$i][5]="";
				$customAttributeMeta[$i][6]=ucwords(str_replace("_"," ",$arrMarge[$i]['COLUMNS']['Field']));
				}
			}
		//pr($customAttributeMeta);
		
		$productList1[0]['product']=array('attribute_id' , 'type' , 'locale' , 'name');
		$filePath=WWW_ROOT."files/fhcsvs/custom_attributes_meta.csv";
		$fp = fopen($filePath, 'w');
			
		foreach ($productList1 as $fields1) {
			$i=1;
			if(!empty($fields1['product'])){
				
				foreach($fields1['product'] as $cat_f){
					$csv_output_print[] = $cat_f;
					if($i<count($fields1['product'])){
					$csv_output_print[] = '';
					}
					$i++;
				}
			}
			
			fputcsv($fp, $csv_output_print,"\t"); 
		}
		if(!empty($customAttributeMeta)){
			foreach ($customAttributeMeta as $fields) {
				
				$fileComp=fputcsv($fp, $fields,"\t");
			}
		}
		
		fclose($fp);
		if($fileComp){
			echo "complate";
			exit;
		}else{
			echo "Not complate";
			exit;
		}
		
	}
	
	 /**
	@function:	variants_csv
	@description:	Get Variants Csv for FH  
	@params:	
	@Created by: 	Nakul
	@Modify:	13 oct 2011, 9 feb 2012
	@Created Date:	7 Sep 2011
	*/		
	function variants_csv(){
		ini_set('memory_limit', '9999M');
		set_time_limit(0);
		App::import('Model' , 'Product');
		$this->Product = new Product();
		$prList=$this->Product->find('list',array('fields'=>array('Product.quick_code' )));
		
		$productList1[0]['Product']=array('variant_id' , 'product_id' , 'locale');
		$this->loadModel("ProductSeller");
		$productList=$this->ProductSeller->find('all',
				array(
				  'fields'=>array(
					'ProductSeller.product_id','ProductSeller.seller_id',"ProductSeller.condition_id"
					)
					//"limit"=>1000
				     )
				);
		//pr($productList); die;
		$filePath=WWW_ROOT."files/fhcsvs/variants.csv";
		$fp = fopen($filePath, 'w');
		foreach ($productList1 as $fields1) {
			if(!empty($fields1['Product'])){
				foreach($fields1['Product'] as $cat_f){
					$csv_output[] = $cat_f;
					$csv_output[] = '';
				}
			}
			fputcsv($fp, $csv_output,"\t"); 
		}
		$tempprolist=array();
		if(!empty($productList)){
			foreach ($productList as $fields) {
			$quick_code=$prList[$fields['ProductSeller']['product_id']];			
				        $csv_output = '';
				        $csv_output[] = $quick_code.'_'.$fields["ProductSeller"]["seller_id"].'_'.$fields["ProductSeller"]["condition_id"];
					$csv_output[] = '';
					$csv_output[] =$quick_code;
					$csv_output[] = '';
					$csv_output[] = "en_GB";
					$fileComp=fputcsv($fp, $csv_output,"\t");
					$tempprolist[$fields['ProductSeller']['product_id']]=$quick_code;	
			}
			
		}
		
		$diffprolist = array_diff($prList, $tempprolist);
		//pr($diffprolist);
		foreach($diffprolist as $fld) {
		 $csv_output = '';
		                        $csv_output[] = $fld.'_NA_NA';
					$csv_output[] = '';
					$csv_output[] =$fld;
					$csv_output[] = '';
					$csv_output[] = "en_GB";
					
					$fileComp=fputcsv($fp, $csv_output,"\t");
		}
		
		fclose($fp);
		if($fileComp){
			echo "complate";
			exit;
		}else{
			echo "Not complate";
			exit;
		}
	}
	
	/**
	@function:	incremental_variant_attributes_csv
	@description:	Get Variants values Csv incremental for FH  
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	08 Sep 2011
	*/
	function incremental_variant_attributes_csv(){
		ini_set('memory_limit', '9999M');
		set_time_limit(0);
		//Configure::write('debug',2);			
		App::import('Model' , 'VariantAttribute');
		$this->VariantAttribute = new VariantAttribute();
		App::import('Model' , 'ProductSeller');
		$this->ProductSeller = new ProductSeller();
		$productseller=$this->ProductSeller->find('all',
				array(
				'conditions'=>array('ProductSeller.`modified` > NOW() - INTERVAL 1 HOUR'),
				'fields'=>array('ProductSeller.product_id','ProductSeller.seller_id'),
				));
		for($k=0;count($productseller)>$k;$k++){
		$product_id=$productseller[$k]['ProductSeller']['product_id'];
		$seller_id=$productseller[$k]['ProductSeller']['seller_id'];
		$variantAttributes[$k]=$this->VariantAttribute->find('first',
				array(
				'conditions'=>array('VariantAttribute.product_id'=>$product_id,'VariantAttribute.seller_id'=>$seller_id),
				//'order' => array('VariantAttribute.product_id Desc'),
				//'limit' => 30,
				));
		}
		if(!empty($variantAttributes)){
			for($i=0;count($variantAttributes)>$i;$i++){
				$arrvariant[$i]=$variantAttributes[$i]['VariantAttribute'];
				$arrvariantKey[$i]=array_keys($arrvariant[$i]);
					for($j=0;count($arrvariant[$i])>$j;$j++){
						if($j<14){
						$arrvariantPrint[$i][$j][0]=$arrvariant[$i][$arrvariantKey[$i][1]].'_'.$arrvariant[$i][$arrvariantKey[$i][13]].'_'.$arrvariant[$i][$arrvariantKey[$i][2]];
						$arrvariantPrint[$i][$j][1]="en_GB";
						$arrvariantPrint[$i][$j][2]=$arrvariantKey[0][$j+3];
						$arrvariantPrint[$i][$j][3]=strtolower(str_replace(" ","_",trim($arrvariant[$i][$arrvariantKey[0][$j+3]])));
						$arrvariantPrint[$i][$j][4]=trim($arrvariant[$i][$arrvariantKey[0][$j+3]]);
						}
				}
			}
		}
		$productList1[0]['product']=array('variant_id' , 'locale' , 'attribute_id' , 'attribute_value_id' , 'attribute_value');
		$filePath=WWW_ROOT."files/fhcsvs/incremental/custom_variant_attributes.csv";
	
		$filePath = fopen($filePath, 'w+');
			
		if(!empty($productList1)){
		$Content='';	
		foreach($productList1 as $fields1){
			for($k=0;$k<count($fields1);$k++){
				$Content .= $fields1['product'][0]."\t\t";
				$Content .= $fields1['product'][1]."\t\t";
				$Content .= $fields1['product'][2]."\t\t";
				$Content .= $fields1['product'][3]."\t\t";
				$Content .= $fields1['product'][4];
				$Content .= "\n";
			}
		}
		}
		
		$Content1='';
		if(!empty($arrvariantPrint)){
				
				foreach($arrvariantPrint as $fields){
						for($i=0;$i<count($fields);$i++){
						$Content1 .= $fields[$i][0]."\t\t";
						$Content1 .= $fields[$i][1]."\t\t";
						$Content1 .= $fields[$i][2]."\t\t";
						$Content1 .= $fields[$i][3]."\t\t";
						$Content1 .= $fields[$i][4];
						$Content1 .= "\n";
						if($i==(count($fields)-1)){
							$Content1 .= $fields[$i][0]."\t\t";
							$Content1 .= "\t\t";
							$Content1 .= "operation_type \t\t";
							$Content1 .= "\t\t";
							$Content1 .= "update";
							$Content1 .= "\n";
						}
						
					}
				}
			}
		$wholeContent=$Content.$Content1;
		$fileComp=fwrite($filePath, $wholeContent);
		fclose($filePath);
		
		if($fileComp){
			echo "complate";
			exit;
		}else{
			echo "Not complate";
			exit;
		}
	}
	
	/**
	@function:	incremental_custom_attribute_csv
	@description:	Get Products with categories Csv incremental for FH  
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	9 Feb 2012
	*/		
		
	function incremental_custom_attribute_csv(){
		set_time_limit(0);
		ini_set('memory_limit', '9999M');
		Configure::write('debug',2);
		App::import('Model','CustomAttribute');
		$this->CustomAttribute = new CustomAttribute();
		$productList1[0]['product']=array('product_id' , 'locale' , 'attribute_id','attribute_value_id','attribute_value');
		$filePath=WWW_ROOT."files/fhcsvs/incremental/custom_attributes_values.csv";
		$fileHead = fopen($filePath, "w+");
		if(!empty($productList1)){
		$Content='';	
			foreach($productList1 as $fields1){
				for($k=0;$k<count($fields1);$k++){
					$Content .= $fields1['product'][0]."\t\t";
					$Content .= $fields1['product'][1]."\t\t";
					$Content .= $fields1['product'][2]."\t\t";
					$Content .= $fields1['product'][3]."\t\t";
					$Content .= $fields1['product'][4];
					$Content .= "\n";
				}
			}
		}
		
		$fileHeadWrite=fwrite($fileHead, $Content);
		fclose($fileHead);
		unset($productList1);
		
		$totalRec=$this->CustomAttribute->find('count',
				array(
				'conditions'=>array('CustomAttribute.`modified` > NOW() - INTERVAL 1 HOUR'),
				));
		//$totalRec = 33700;
		$end_limit = 1000;
		$totalPage = ceil($totalRec/$end_limit);
		$incrivalue = 0;
		
		for($l=0;$l<$totalPage;$l++){
					$productList=$this->CustomAttribute->find('all',
					array(
					'conditions'=>array('CustomAttribute.`modified` > NOW() - INTERVAL 1 HOUR'),
					'limit' => "$incrivalue,$end_limit",
					));
			$search  = array(' ', "\r\n", ',','.');
			for($i=0;$i<count($productList); $i++)
			{	
				$arrMerge[$i] =$productList[$i]['CustomAttribute'];
				$arrMergeKey[$i] = array_keys($arrMerge[$i]);
				for($j=0;$j<=count($arrMerge[$i]);$j++)
				{
					if($j<59){
					$array_attr[$i][$j][0] = $arrMerge[$i][$arrMergeKey[0][1]];
					$array_attr[$i][$j][1] = "en_GB";
					$array_attr[$i][$j][2] = $arrMergeKey[0][$j+2];
					$array_attr[$i][$j][3] = str_replace($search,'_',trim(preg_replace('/[^a-zA-Z0-9]/',' ',strip_tags(html_entity_decode($arrMerge[$i][$arrMergeKey[0][$j+2]] ,ENT_QUOTES,'UTF-8')))));
					$array_attr[$i][$j][4] = str_replace(array("\r\n","\n"),'~',trim($arrMerge[$i][$arrMergeKey[0][$j+2]]));
					}
				}
			}
			
			if(!empty($array_attr)){
				$Content1='';
				foreach($array_attr as $fields){
					for($i=0;$i<count($fields);$i++){
					$Content1 .= $fields[$i][0]."\t\t";
					$Content1 .= $fields[$i][1]."\t\t";
					$Content1 .= $fields[$i][2]."\t\t";
					$Content1 .= $fields[$i][3]."\t\t";
					$Content1 .= $fields[$i][4];
					$Content1 .= "\n";
						if($i==(count($fields)-1)){
							$Content1 .= $fields[$i][0]."\t\t";
							$Content1 .= "\t\t";
							$Content1 .= "operation_type \t\t";
							$Content1 .= "\t\t";
							$Content1 .= "update";
							$Content1 .= "\n";
						}
					}
				}
			}
			$pathContent=WWW_ROOT."files/fhcsvs/incremental/custom_attributes_values.csv";
			$pathContentOpen = fopen($pathContent, "a+");
			$pathContentWrite=fwrite($pathContentOpen, $Content1);
			fclose($pathContentOpen);
			$incrivalue = $incrivalue+$end_limit;
		}
		exit;
	}
	
	
	
	 /**
	@function:	incremental_product_csv
	@description:	Get Products with Product Csv for FH incremental
	@params:	
	@Created by: 	Nakul Kumar
	@Modify:	
	@Created Date:	5 Apr 2012
	*/		
	function incremental_product_csv(){
		Configure::write('debug',2);
		App::import('Model' , 'ProductCategory');
		$this->ProductCategory = new ProductCategory();
		$this->ProductCategory->expects(array('Product'));
		
		App::import('Model' , 'CustomAttribute');
		$this->CustomAttribute = new CustomAttribute();
		$totalRec=$this->CustomAttribute->find('all',
				array(
				'conditions'=>array('CustomAttribute.`modified` > NOW() - INTERVAL 1 HOUR'),
				'fields'=>array('CustomAttribute.quick_code')
				));
		$productList = $this->ProductCategory->find('all',
				array(
				'conditions'=>array('Product.`modified` > NOW() - INTERVAL 1 HOUR',in_array('Product.quick_code',$totalRec)),
				'fields'=>array('Product.quick_code','group_concat(ProductCategory.category_id SEPARATOR " ") AS category_id'),
				//'order' => array('Product.quick_code'),
				'group' => array('Product.quick_code')
				//'limit' => 200,
				));
		$categoryList1[0]['Product']=array('product_id' , 'locale' , 'category_ids');
		$filePath=WWW_ROOT."files/fhcsvs/incremental/products.csv";
		$filePath = fopen($filePath,"w+");
		
		if(!empty($categoryList1)){
		$Content='';	
		foreach($categoryList1 as $fields1){
			for($k=0;$k<count($fields1);$k++){
				$Content .= $fields1['Product'][0]."\t\t";
				$Content .= $fields1['Product'][1]."\t\t";
				$Content .= $fields1['Product'][2];
				$Content .= "\n";
			}
		}
		}	
		if(!empty($productList)){
				$Content1='';	
				foreach($productList as $fields){
						$Content1 .= $fields['Product']['quick_code']."\t\t";
						$Content1 .= "en_GB"."\t\t";
						$Content1 .= $fields[0]['category_id'];
						$Content1 .= "\n";
				}
			}
		$wholeContent=$Content.$Content1;
		$fileComp=fwrite($filePath, $wholeContent);
		fclose($filePath);
		if($fileComp){
			echo "complete";
			exit;
		}else{
			echo "Not complete";
			exit;
		}
	}
	
	 /**
	@function:	variants_csv
	@description:	Get Variants Csv for FH  
	@params:	
	@Created by: 	Nakul
	@Modify:	13 oct 2011, 9 feb 2012
	@Created Date:	7 Sep 2011
	*/		
	function incremental_variants_csv(){
		ini_set('memory_limit', '9999M');
		set_time_limit(0);
		App::import('Model' , 'Product');
		$this->Product = new Product();
		$prList=$this->Product->find('list',array(
				'conditions'=>array('Product.`modified` > NOW() - INTERVAL 1 HOUR'),'fields'=>array('Product.quick_code')));
		$productList1[0]['Product']=array('variant_id' , 'product_id' , 'locale');
		$this->loadModel("ProductSeller");
		$productList=$this->ProductSeller->find('all',
				array(
				'conditions'=>array('ProductSeller.`modified` > NOW() - INTERVAL 1 HOUR'),
				  'fields'=>array(
					'ProductSeller.product_id','ProductSeller.seller_id',"ProductSeller.condition_id"
					)
				     )
				);
		//pr($productList); die;
		$filePath=WWW_ROOT."files/fhcsvs/incremental/variants.csv";
		$fp = fopen($filePath, 'w');
		foreach ($productList1 as $fields1) {
			if(!empty($fields1['Product'])){
				foreach($fields1['Product'] as $cat_f){
					$csv_output[] = $cat_f;
					$csv_output[] = '';
				}
			}
			fputcsv($fp, $csv_output,"\t"); 
		}
		$tempprolist=array();
		if(!empty($productList)){
			foreach ($productList as $fields) {
			$quick_code=$prList[$fields['ProductSeller']['product_id']];
				        $csv_output = '';
				        $csv_output[] = $quick_code.'_'.$fields["ProductSeller"]["seller_id"].'_'.$fields["ProductSeller"]["condition_id"];
					$csv_output[] = '';
					$csv_output[] =$quick_code;
					$csv_output[] = '';
					$csv_output[] = "en_GB";
					$fileComp=fputcsv($fp, $csv_output,"\t");
					$tempprolist[$fields['ProductSeller']['product_id']]=$quick_code;	
			}
			
		}
		
		$diffprolist = array_diff($prList, $tempprolist);
		//pr($diffprolist);
		foreach($diffprolist as $fld) {
		 $csv_output = '';
		                        $csv_output[] = $fld.'_NA_NA';
					$csv_output[] = '';
					$csv_output[] =$fld;
					$csv_output[] = '';
					$csv_output[] = "en_GB";
					
					$fileComp=fputcsv($fp, $csv_output,"\t");
		}
		
		fclose($fp);
		if($fileComp){
			echo "complate";
			exit;
		}else{
			echo "Not complate";
			exit;
		}
	}
	
	
	 /**
	@function:	top seller position up and down arrow 
	@description:	top seller for FH  
	@params:	
	@Created by: 	Nakul
	@Modify:	31 May 2012
	@Created Date:	31 May 2012
	*/		
	function top_seller(){
		
		App::import('Model' , 'TempTopSeller');
		$this->TempTopSeller = new TempTopSeller();
		
		$ws_location = WS_LOCATION;
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		$fh_location = 'fh_location=//catalog01/en_GB&special-page-id=bestsellers';
		
			$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
			//Find the universe marked as 'selected' in the result
			if(!empty($result)){
				foreach($result->universes->universe as $r) {
					if($r->{"type"} == "selected"){
						if(!empty($r->themes)){
							$facetmap = (array)$r->facetmap->filter;
						}
						foreach($facetmap as $facetmap){
							foreach($facetmap->{'custom-fields'}->{'custom-field'}  as $custom){
								if($custom->_ == "Topmenu"){
									if($facetmap->filtersection){
										foreach($facetmap->filtersection as $filtersection){
											$dep_name[] = $filtersection->link->name;
										}
									}
								}
							}
						}
						if(!empty($r->themes))
							$themes = (array)$r->themes;
						if(!empty($themes)){
							
							if(!empty($themes['theme'])){
								//$fh_themes = $themes['theme'];
								if(count($themes['theme']) == 1){
									$fh_themes[0] = $themes['theme'];
								} else {
									$fh_themes = $themes['theme'];
								}
							}
						}
					}
				}
			}
		if(!empty($fh_themes)){
			$j = 0;
			foreach($fh_themes as $fh_themes){
				
				//pr($departments_list[$j]);
				if($fh_themes->{'custom-fields'}->{'custom-field'}->_ == "Sub-Category Item Preview"){
					$best_items = $fh_themes->items->item;
					$department_name = $dep_name[$j];
					$i = 0;
					if(!isset($best_items->attribute)){
					foreach($best_items as $bestseller_product){
						
						foreach($bestseller_product->attribute as $attribute){
							if($attribute->name == 'department_name'){
								$products_info[$j]['department_name'] = $department_name;
							}
							if($attribute->name == 'secondid'){
								$products_info[$j]["item"][$i]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name'){
								$products_info[$j]["item"][$i]['product_name'] = $attribute->value->_;
							}
							if($attribute->name == 'product_image'){
								$products_info[$j]["item"][$i]['product_image'] = $attribute->value->_;
							}
							if($attribute->name == 'avg_rating'){
								$products_info[$j]["item"][$i]['avg_rating'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price'){
								$products_info[$j]["item"][$i]['minimum_price'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used'){
								$products_info[$j]["item"][$i]['minimum_price_used'] = $attribute->value->_;
							}
							if($attribute->name == 'product_rrp'){
								$products_info[$j]["item"][$i]['product_rrp'] = $attribute->value->_;
							}
						}
						
					$i++;
					}
					}else{
						foreach($best_items->attribute as $attribute){
							if($attribute->name == 'department_name'){
								$products_info[$j]['department_name'] = $department_name;
							}
							if($attribute->name == 'secondid'){
								$products_info[$j]["item"][$i]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name'){
								$products_info[$j]["item"][$i]['product_name'] = $attribute->value->_;
							}
							if($attribute->name == 'product_image'){
								$products_info[$j]["item"][$i]['product_image'] = $attribute->value->_;
							}
							if($attribute->name == 'avg_rating'){
								$products_info[$j]["item"][$i]['avg_rating'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price'){
								$products_info[$j]["item"][$i]['minimum_price'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used'){
								$products_info[$j]["item"][$i]['minimum_price_used'] = $attribute->value->_;
							}
							if($attribute->name == 'product_rrp'){
								$products_info[$j]["item"][$i]['product_rrp'] = $attribute->value->_;
							}
						}
						
					}
					
				}
				$j++;
			}
			
			
		}
		//pr($products_info);
		$this->TempTopSeller->query('TRUNCATE temp_top_sellers');
		if(!empty($products_info)){
			foreach($products_info as $product_info){
				//pr($product_info);
				$j = 0;
				foreach($product_info['item'] as $product_item){
					$this->data[$j]['TempTopSeller']['position'] = $j;
					$this->data[$j]['TempTopSeller']['quick_code'] = $product_item['secondid'];
					$this->data[$j]['TempTopSeller']['department_name'] = $product_info['department_name'];
				$j++;
				}
				$this->TempTopSeller->set($this->data);
				$this->TempTopSeller->saveAll($this->data);
			}
		}
		//file_put_contents(WWW_ROOT."files/fhcsvs/incremental/abc.txt","Success - nakul");
		//echo "ankul";
		//exit;
		exit;
		//$this->set('products_info',$products_info);
		
		
		
	}
	
	
	/**
	@function:	dataupload
	@description:	Get Products with categories Csv incremental for FH  
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	24 Mar 2012
	*/		
		
	function dataupload(){
		set_time_limit(0);
		//ini_set('memory_limit', '9999M');
		Configure::write('debug',2);
		if (extension_loaded("curl"))
			{
			echo "cURL extension is loaded<br>";
			}
			else
			{
			echo "cURL extension is not available<br>";
			}
		$getData=WWW_ROOT."files/fhcsvs/data.zip";
		$dataMd = md5($getData);
		echo $dataMd.'-';
		$url='https://my.fredhopperservices.com/fas:live1/data/input/data.zip\?checksum='.$dataMd;
		$ch = curl_init();
		//curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_USERPWD, "choiceful:aiteiyienole");
		curl_setopt( $ch, CURLOPT_PUT, true);
		curl_setopt( $ch, CURLOPT_INFILE, $getData );
		curl_setopt( $ch, CURLOPT_INFILESIZE, filesize($getData) );		
	/*	 curl_setopt($ch, CURLOPT_POST, 1);
		$post = "checksum=".$dataMd;
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post); */
	
	//	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );    # required for https urls
		
		//curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
		$content = curl_exec( $ch );
		$response = curl_getinfo( $ch );
		curl_close ( $ch );
		print_r($content);
		print_r($response);
			
		die;	
		//echo $response;
		
		//echo $response = 'curl -D - -u choiceful:aiteiyienole -X PUT -H "Content-Type: application/zip" --data-binary @data.zip https://my.fredhopperservices.com/fas:live1/data/input/data.zip\?checksum='.$dataMd;
	}
	
	
	/**
	@function : order_mail 
	@description : send mail to buyer after 21 days of order made
	@Created by : Vikas Uniyal
	@Created Date : Oct. 22, 2012
	@Modify : NULL
	*/
	function order_mail()
	{
		App::import('Model' , 'Order');
		$this->Order = new Order();
		
		//Find date before 21 days
		$today = date('Y-m-d');
		$dateBefore21Days = date('Y-m-d', strtotime(date("Y-m-d", strtotime($today)) . " -21 day"));
		$siteurl = 'http://www.choiceful.com/';
		//Find all orders before 21 days
		$allOrders = $this->Order->find('all',array('conditions'=>array('date(Order.created)' =>$dateBefore21Days),'fields'=>array('Order.id','Order.order_number','Order.user_id','Order.user_email','Order.billing_firstname','billing_lastname','Order.created')));
		App::import('Model' , 'OrderItem');
		$this->OrderItem = new OrderItem();
		//find each order and send email to each buyer
		foreach($allOrders as $orderData)
		{
			$orderItemData = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.order_id'=>$orderData['Order']['id']),'fields'=>array('OrderItem.id','OrderItem.seller_id','OrderItem.product_name','OrderItem.product_id','OrderItem.quantity','OrderItem.seller_name')));
			
			$sellerDisplayName = $orderItemData['OrderItem']['seller_name'];
			$customerFirstName = $orderData['Order']['billing_firstname'];
			$orderNumber = $orderData['Order']['order_number'];
			$quantity = $orderItemData['OrderItem']['quantity'];
			$productName = $orderItemData['OrderItem']['product_name'];
			$buyer_email = $orderData['Order']['user_email'];
			$orderDate = date('d-m-Y',strtotime($orderData['Order']['created']));
				
			$this->Email->smtpOptions = array(
			'host' => Configure::read('host'),
			'username' =>Configure::read('username'),
			'password' => Configure::read('password'),
			'timeout' => Configure::read('timeout')
			);
				
			$this->Email->sendAs= 'html';
			
			/******import emailTemplate Model and get template****/
			App::import('Model','EmailTemplate');
			$this->EmailTemplate = new EmailTemplate;
				
			/**
			table: 		email_templates
			id:		17
			description:	Customer event
			*/
			$template = $this->Common->getEmailTemplate(17);
				
			$this->Email->from = $template['EmailTemplate']['from_email'];
			$this->Email->subject = str_replace('[SellersDisplayName]',$sellerDisplayName,$template['EmailTemplate']['subject']);
			$data=$template['EmailTemplate']['description'];
			$data=str_replace('[SellerDisplayName]',$sellerDisplayName,$data);
			$data=str_replace('[OrderDateDayMonthYear]',$orderDate,$data);
			$data=str_replace('[CustomerFirstName]',$customerFirstName,$data);
			$data=str_replace('[OrderNumber]',$orderNumber,$data);
			$data=str_replace('[Qty]',$quantity,$data);
			$data=str_replace('[ItemName]',$productName,$data);
			$sellerUrlName = str_replace(array(' ','/','&quot;','&','andamp','and;'), array('-','','"','and','and','and'),$sellerDisplayName);
			$sellerLink = '<a href="'.$siteurl.'sellers/'.$sellerUrlName.'/summary/'.$orderItemData['OrderItem']['seller_id'].'/'.$orderItemData['OrderItem']['product_id'].'?utm_source=Let+Others+Know+of+your+experience+buying&amp;utm_medium=email">'.$sellerDisplayName.'</a>';
			$data=str_replace('[LinkToSellerDisplayName]',$sellerLink,$data);
				
			$pro_name_in_url = str_replace(array(' ','/','&quot;','&','andamp','and;'), array('-','','"','and','and','and'),$productName);
			$pro_name_in_url = preg_replace('/[^0-9^a-z-]+/i', '' ,$pro_name_in_url);
			$review_link = '<a href="'.$siteurl.$pro_name_in_url.'/categories/productdetail/'.$orderItemData['OrderItem']['product_id'].'?review=yes&utm_source=Let+Others+Know+of+your+experience+buying&amp;utm_medium=email">Write a Review</a>';
			$data=str_replace('[Write_a_Review]',$review_link,$data);
			
			$this->set('data',$data);
			$this->Email->to = $buyer_email;
			//$this->Email->to = 'davsohi@hotmail.com';
			//$this->Email->to = 'gyanprakaash@hotmail.com';
			//$this->Email->to = 'gyan.prakaash@yahoo.com';
			//$this->Email->to = 'gyanp.sdei@gmail.com';
			//$this->Email->to = array('gyanp.sdei@gmail.com','vcvreddy@yahoo.com');
			$this->Email->template='commanEmailTemplate';
			$this->Email->send();
			
		}
		
		die;
	}
	
	/**
	@function : service_metrics 
	@description : Get Service Metrics Fro Front End 
	@Created by : Nakul kumar
	@Created Date : FEb. 15, 2013
	@Modify : NULL
	*/
	function service_metrics(){
		$customerServiceAgents = rand(250,300);
		$emailsPerHour = rand(3000,3500);
		$emailResponseTimeHour = rand(8,12);
		$emailResponseTimeMinute = rand(0,60);
		$emailResponseTime = sprintf("%02s", $emailResponseTimeHour).':'.sprintf("%02s", $emailResponseTimeMinute);
		
		$helpDeskHour = rand(4,9);
		$helpDeskMinute = rand(0,60);
		$helpdesk = sprintf("%02s", $helpDeskHour).':'.sprintf("%02s", $helpDeskMinute);
			
		App::import('Model','MetricsService');
		$this->MetricsService = new MetricsService();
			
		$this->data['MetricsService']['id'] = 0;
		$this->data['MetricsService']['service_agent'] = $customerServiceAgents;
		$this->data['MetricsService']['emails_per_hour'] = $emailsPerHour;
		$this->data['MetricsService']['email_response_time'] = $emailResponseTime;
		$this->data['MetricsService']['help_desk'] = $helpdesk;
		$this->MetricsService->set($this->data);
		$this->MetricsService->save($this->data);
			
		exit;
	}
	
	
	/**
	@function : products 
	@description : Generate XML for product sitemaps
	@Created by : Pradeep Kumar	
	@Created Date : MARCH 07 2013
	@Modify : NULL
	*/
	
	
	function products()
	{
		App::import('Model','Product');
		$this->Product = new Product();
		
		$products = $this->Product->find('all',array('fields'=>array('id','product_name','modified'),'limit'=>'50000'));
		
		
		$xmldata = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	    
	    if(isset($products) && !empty($products)) {
	    foreach ($products as $product){
		$xmldata .= '<url>';
		$xmldata .= '<loc>'.Router::url('http://www.choiceful.com/'.$this->Common->getProductUrl($product['Product']['id']).'/categories/productdetail/'.$product['Product']['id'],true).'</loc>';
		$xmldata .= '<lastmod>'.date("Y-m-d",strtotime($product['Product']['modified'])).'</lastmod>';
		$xmldata .= '</url>';
	    
	    } } 
		
		$xmldata .= '</urlset>';
	
		$fp = fopen(WWW_ROOT.'files/sitemap/products.xml', 'w');
		fwrite($fp,$xmldata);
		fclose($fp);
		// Name of the file we are compressing
		$file = WWW_ROOT."files/sitemap/products.xml";
	
		// Name of the gz file we are creating
		$gzfile = WWW_ROOT."files/sitemap/products.xml.gz";
		
		// Open the gz file (w9 is the highest compression)
		$fp = gzopen ($gzfile, 'w9');
		
		// Compress the file
		gzwrite ($fp, file_get_contents($file));
		
		// Close the gz file and we are done
		gzclose($fp);
		
		exit;
		//$this->set("products", $products);
		//$this->RequestHandler->respondAs('xml');
	
       }
       
	/**
	@function : products1 
	@description : Generate XML for product sitemaps
	@Created by : Pradeep Kumar	
	@Created Date : MARCH 07 2013
	@Modify : NULL
	*/
	
	 function products1()
	{
		App::import('Model','Product');
		$this->Product = new Product();
		
		$products = $this->Product->find('all',array('fields'=>array('id','product_name','modified'),'limit'=>'50001,50000'));
		
		
		$xmldata = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	    
	    if(isset($products) && !empty($products)) {
	    foreach ($products as $product){
		$xmldata .= '<url>';
		$xmldata .= '<loc>'.Router::url('http://www.choiceful.com/'.$this->Common->getProductUrl($product['Product']['id']).'/categories/productdetail/'.$product['Product']['id'],true).'</loc>';
		$xmldata .= '<lastmod>'.date("Y-m-d",strtotime($product['Product']['modified'])).'</lastmod>';
		$xmldata .= '</url>';
	    
	    } } 
		
		$xmldata .= '</urlset>';
		
	
		
		$fp = fopen(WWW_ROOT.'files/sitemap/products1.xml', 'w');
		fwrite($fp,$xmldata);
		fclose($fp);
		// Name of the file we are compressing
		$file = WWW_ROOT."files/sitemap/products1.xml";
	
		// Name of the gz file we are creating
		$gzfile = WWW_ROOT."files/sitemap/products1.xml.gz";
		
		// Open the gz file (w9 is the highest compression)
		$fp = gzopen ($gzfile, 'w9');
		
		// Compress the file
		gzwrite ($fp, file_get_contents($file));
		
		// Close the gz file and we are done
		gzclose($fp);
		
		exit;
		//$this->set("products", $products);
		//$this->RequestHandler->respondAs('xml');
	
       }
       
       
       
       /**
	@function:	peerius_attribute_csv
	@description:	Get Products with categories Csv for peerius
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	25 Agu 2011
	*/		
		
	function peerius_attribute_csv(){
		set_time_limit(0);
		ini_set('memory_limit', '9999M');
		Configure::write('debug',2);
		
		App::import('Model','PeeriusAttribute');
		$this->PeeriusAttribute = new PeeriusAttribute();
		/*Start For add some extra fields*/
		
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		App::import('Model','ProductVisit');
		$this->ProductVisit = new ProductVisit();
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		$this->OrderItem->expects(array('Order'));
		App::import('Model','Product');
		$this->Product = new Product();
		App::import('Model','Review');
		$this->Review = new Review();
		App::import('Model','ProductQuestion');
		$this->ProductQuestion = new ProductQuestion();
		App::import('Model','ProductAnswer');
		$this->ProductAnswer = new ProductAnswer();
		
		App::import('Model','ProductDetail');
		$this->ProductDetail = new ProductDetail();
		$this->Product->expects(array('ProductDetail'));
		
		App::import('Model', 'Productimage');
		$this->Productimage = new Productimage();
		App::import('Model', 'ProductRating');
		$this->ProductRating = new ProductRating();
		
		App::import('Model', 'ProductCategory');
		$this->ProductCategory = new ProductCategory();
		$this->ProductCategory->expects(array('Category'));
		/*END For add some extra fields*/
		
		
		$breadcrumbs = array();
		$productbread = $this->ProductCategory->find('all',
				array(
				'fields'=> array('ProductCategory.product_id' , 'Category.breadcrumbs'),
				'group'=>array('ProductCategory.product_id'),
				//'limit'=>30,
				));
		foreach($productbread as $productbread){
			$breadcrumbs[$productbread['ProductCategory']['product_id']] = $productbread['Category']['breadcrumbs'];
		}

		$count_pro_rating = array();
		$productRatings = $this->ProductRating->find('all',
				array(
				'fields'=> array('ProductRating.product_id' , 'count(ProductRating.product_id) as totalRating'),
				'group'=>array('ProductRating.product_id'),
				//'limit'=>30,
				));
		foreach($productRatings as $productRatings){
			$count_pro_rating[$productRatings['ProductRating']['product_id']] = $productRatings['0']['totalRating'];
		}
		
		/*$pro_mul_image = array();
		$productMimage = $this->Productimage->find('all',
				array(
				'fields'=> array('Productimage.product_id' , 'count(Productimage.image) as timage'),
				'group'=>array('Productimage.product_id'),
			//	'limit'=>30,
				));
		foreach($productMimage as $productMimage){
			$pro_mul_image[$productMimage['Productimage']['product_id']] = $productMimage['0']['timage'];
		}*/
		//$pro_mul_image = array();
		$productMimage = array();
		$productMimage = $this->Productimage->find('list',
				array(
				'fields'=> array('Productimage.product_id' , 'Productimage.product_id'),
				'group'=>array('Productimage.product_id'),
			//	'limit'=>30,
				));
		/*foreach($productMimage as $productMimage){
			$pro_mul_image[$productMimage['Productimage']['product_id']] = $productMimage['0']['timage'];
		}*/
		
		$productBookFormat = array();
		$productBookLanguage = array();
		$productbformat = $this->Product->find('all',
				array(
				'conditions'=> array('Product.department_id'=>1),
				'fields'=> array('Product.id' , 'ProductDetail.format', 'ProductDetail.language',),
				'group'=>array('Product.id'),
				//'limit'=>30,
				));
		foreach($productbformat as $productbformat){
			$productBookFormat[$productbformat['Product']['id']] = $productbformat['ProductDetail']['format'];
			$productBookLanguage[$productbformat['Product']['id']] = $productbformat['ProductDetail']['language'];
		}
		
		$productMusicFormat = array();
		$productMusicRated = array();
		$productMusicNodisk = array();
		$productmuformat = $this->Product->find('all',
				array(
				'conditions'=> array('Product.department_id'=>2),
				'fields'=> array('Product.id' , 'ProductDetail.format','ProductDetail.rated','ProductDetail.number_of_disk'),
				'group'=>array('Product.id'),
			//	'limit'=>30,
				));
		foreach($productmuformat as $productmuformat){
			$productMusicFormat[$productmuformat['Product']['id']] = $productmuformat['ProductDetail']['format'];
			$productMusicRated[$productmuformat['Product']['id']] = $productmuformat['ProductDetail']['rated'];
			$productMusicNodisk[$productmuformat['Product']['id']] = $productmuformat['ProductDetail']['number_of_disk'];
		}
		
		
		$productMoviesFormat = array();
		$productMoviesRated = array();
		$productMovieslanguage = array();
		$productMoviesReleaseDate = array();
		$productMoviesNodisk = array();
		$productmorated = $this->Product->find('all',
				array(
				'conditions'=> array('Product.department_id'=>3),
				'fields'=> array('Product.id' , 'ProductDetail.format','ProductDetail.rated', 'ProductDetail.language', 'ProductDetail.release_date','ProductDetail.number_of_disk'),
				'group'=>array('Product.id'),
			//	'limit'=>30,
				));
		foreach($productmorated as $productmorated){
			$productMoviesRated[$productmorated['Product']['id']] = $productmorated['ProductDetail']['rated'];
			$productMovieslanguage[$productmorated['Product']['id']] = $productmorated['ProductDetail']['language'];
			$productMoviesReleaseDate[$productmorated['Product']['id']] = $productmorated['ProductDetail']['release_date'];
			$productMoviesFormat[$productmorated['Product']['id']] = $productmorated['ProductDetail']['format'];
			$productMoviesNodisk[$productmorated['Product']['id']] = $productmorated['ProductDetail']['number_of_disk'];
		}
		
		$productGamesRated = array();
		$productGamesReleaseDate = array();
		$productgarated = $this->Product->find('all',
				array(
				'conditions'=> array('Product.department_id'=>4),
				'fields'=> array('Product.id' , 'ProductDetail.rated', 'ProductDetail.release_date'),
				'group'=>array('Product.id'),
			//	'limit'=>30,
				));
		foreach($productgarated as $productgarated){
			$productGamesRated[$productgarated['Product']['id']] = $productgarated['ProductDetail']['rated'];
			$productGamesReleaseDate[$productgarated['Product']['id']] = $productgarated['ProductDetail']['release_date'];
		}
		
		$pro_seller = array();
		$productsellers = $this->ProductSeller->find('all',
				array(
				'fields'=> array('ProductSeller.product_id' , 'count(ProductSeller.seller_id) as totalSeller'),
				'group'=>array('ProductSeller.product_id'),
			//	'limit'=>30,
				));
		foreach($productsellers as $productseller){
			$pro_seller[$productseller['ProductSeller']['product_id']] = $productseller['0']['totalSeller'];
		}
		
		
		$is_seller = array();
		$is_seller = $this->ProductSeller->find('list',
				array(
				'conditions'=> array('ProductSeller.quantity > 0'),
				'fields'=> array('ProductSeller.product_id' , 'ProductSeller.product_id'),
				'group'=>array('ProductSeller.product_id'),
				));
		$pro_visit90 = array();
		$productvisits90 = $this->ProductVisit->find('all',
				array(
				'conditions'=> array('created BETWEEN DATE_SUB(now() , INTERVAL 90 DAY) and now()'),
				'fields'=> array('ProductVisit.product_id' , 'ProductVisit.created' , 'sum(ProductVisit.visits) as totalVisit'),
				'group'=>array('ProductVisit.product_id'),
				//'limit'=>30,
				));
		foreach($productvisits90 as $productvisits90){
			$pro_visit90[$productvisits90['ProductVisit']['product_id']] = $productvisits90['0']['totalVisit'];
		}
		//pr($pro_visit90);
		//exit;
		
		$pro_visit = array();
		$productvisits = $this->ProductVisit->find('all',
				array(
				'fields'=> array('ProductVisit.product_id' , 'sum(ProductVisit.visits) as totalVisit'),
				'group'=>array('ProductVisit.product_id'),
				//'limit'=>30,
				));
		foreach($productvisits as $productvisits){
			$pro_visit[$productvisits['ProductVisit']['product_id']] = $productvisits['0']['totalVisit'];
		}
		
		$pro_sold90 = array();
		$productsolds90 = $this->OrderItem->find('all',
				array(
				'conditions'=> array('Order.created BETWEEN DATE_SUB(now() , INTERVAL 90 DAY) and now()'),
				'fields'=> array('OrderItem.product_id' , 'Order.id', 'OrderItem.order_id','sum(OrderItem.quantity) as totalSold'),
				'group'=>array('OrderItem.product_id'),
				//'limit'=>30,
				));
		foreach($productsolds90 as $productsolds90){
			$pro_sold90[$productsolds90['OrderItem']['product_id']] = $productsolds90['0']['totalSold'];
		}
		//pr($pro_sold90);
		//exit;
		$pro_sold = array();
		$productsolds = $this->OrderItem->find('all',
				array(
				'fields'=> array('OrderItem.product_id' , 'sum(OrderItem.quantity) as totalSold'),
				'group'=>array('OrderItem.product_id'),
				//'limit'=>30,
				));
		foreach($productsolds as $productsolds){
			$pro_sold[$productsolds['OrderItem']['product_id']] = $productsolds['0']['totalSold'];
		}
		//pr($pro_sold);
		//exit;
		$pro_revenue = array();
		$productrevenues = $this->OrderItem->find('all',
				array(
				'fields'=> array('OrderItem.product_id' , 'sum(OrderItem.quantity * OrderItem.price) as totalSold'),
				'group'=>array('OrderItem.product_id'),
				//'limit'=>30,
				));
		foreach($productrevenues as $productrevenues){
			$pro_revenue[$productrevenues['OrderItem']['product_id']] = $productrevenues['0']['totalSold'];
		}
		//pr($pro_revenue);
		//exit;
		
		$seller_rating = array();
		$joptions = array(
				array('table' => 'feedbacks',
				'alias' => 'Feedback',
				'type' => 'LEFT',
				'conditions' => array( 'Feedback.seller_id = Product.minimum_price_seller')
				)
				);
		$sellerAvgRatting = $this->Product->find('all',
				array(
				'fields'=> array('Product.id' , 'Product.minimum_price_seller',"avg(Feedback.rating) as avgRating"),
				'order'=>array('Product.id'),
				"joins"=>$joptions,
				"group"=>array('Product.id',"Product.minimum_price_seller"),
				//'limit'=>'30'
				));
		//pr($sellerAvgRatting);
		foreach($sellerAvgRatting as $sellerAvgRatting){
			$seller_rating[$sellerAvgRatting['Product']['id']] = round($sellerAvgRatting['0']['avgRating'],2);
		}
		$pro_reviews = array();
		$product_reviews = $this->Review->find('all',
				array(
				'fields'=> array('Review.product_id' , 'count(Review.id) as totalReview'),
				'order'=>array('Review.product_id'),
				"group"=>array('Review.product_id'),
				//'limit'=>'30'
				));
		foreach($product_reviews as $product_reviews){
			$pro_reviews[$product_reviews['Review']['product_id']] = $product_reviews['0']['totalReview'];
		}
		
		$pro_questions = array();
		$product_question = $this->ProductQuestion->find('all',
				array(
				'fields'=> array('ProductQuestion.product_id' , 'count(ProductQuestion.id) as totalQuestion'),
				'order'=>array('ProductQuestion.product_id'),
				"group"=>array('ProductQuestion.product_id'),
				//'limit'=>'30'
				));
		foreach($product_question as $product_question){
			$pro_questions[$product_question['ProductQuestion']['product_id']] = $product_question['0']['totalQuestion'];
		}
			
		$pro_answers = array();
		$product_answers = $this->ProductAnswer->find('all',
				array(
				'fields'=> array('ProductAnswer.product_id' , 'count(ProductAnswer.id) as totalAnswer'),
				'order'=>array('ProductAnswer.product_id'),
				"group"=>array('ProductAnswer.product_id'),
				//'limit'=>'30'
				));
		foreach($product_answers as $product_answers){
			$pro_answers[$product_answers['ProductAnswer']['product_id']] = $product_answers['0']['totalAnswer'];
		}
			
		$product_video = array();
		$product_video = $this->Product->find('list',
				array(
				'fields'=> array('Product.id' , 'Product.product_video'),
				'order'=>array('Product.id'),
				"group"=>array('Product.id'),
				//'limit'=>'30'
			));
		
		$filePath=WWW_ROOT."files/fhcsvs/peerius_attributes.csv";
		/*
		if file exist delete the fiule file and create a new file
		*/
		if(file_exists($filePath)){
			unlink($filePath);
		}
		
		
		$fileHead = fopen($filePath, "w");
			
		$Content = "Product Id\t\t QCID\t\t Product Name\t\t Brand\t\t Product Image\t\t Product Video\t\t Barcode\t\t Manufacturer\t\t Model Number\t\t Product RRP\t\t Minimum Price New Value\t\t Minimum Price New Seller\t\t Minimum Price Used\t\t Minimum Price Used Seller\t\t Average Product Rating\t\t Product Status\t\t Modified\t\t Created\t\t Department Name\t\t Category Structure\t\t Department Status\t\t Condition New\t\t Condition Used\t\t Author Name Books\t\t Publisher Books\t\t Product Language Books\t\t  Product Isbn Books\t\t Product Format Books\t\t Pages Books\t\t Year Published Books\t\t Artist Name Music\t\t Label Music\t\t Rated Music\t\t Number Of Disk Music\t\t Track List Music\t\t Release Date Movies\t\t Star Name Movies\t\t Directed By Movies\t\t Studio Movies\t\t Run Time Movies\t\t Platform Games\t\t Region Games\t\t Suitable For Health Beauty\t\t Ingredients Health Beauty\t\t Media Storage Capacity Games\t\t Media Storage Capacity Electronics\t\t Media Storage Capacity Office and Computing\t\t  Media Storage Capacity Mobile\t\t Worldwide Compatibility\t\t Product Weight\t\t  Product Features\t\t Technical Details\t\t Product Searchtag\t\t Meta Keywords\t\t Format Music\t\t Rated Movies\t\t Format Movies\t\t Number Of Discs Movies\t\t Language Movies\t\t Rated Games\t\t Release Date Games\t\t Colour\t\t Material Type\t\t Size\t\t Volume/Capacity\t\t Accessories (QCID,comma-separated)\t\t Number of Ratings\t\t Has Marketplace Seller\t\t Number Of Marketplace Sellers\t\t Product Page Views in Last 90 Days\t\t  Product Page Views in Lifetime\t\t Number Sold in Last 90 Days\t\t Number Sold in Lifetime\t\t Total Product Revenue\t\t Lowest Priced Marketplace Seller Rating Percentage\t\t Number Reviews Product\t\t Number Questions Product\t\t Number Answers Products\t\t Has Product Video\t\t Is This A GD Product?\t\t Is This A Deal Product?\t\t Is This Product Part Of A Bundle?\t\t Number Of MMAO\t\t Choiceful Sales Ranking\t\t Is There A Product Image Available?\t\t Is There Multiple Product Images Available?\t\t Is This A Discontinued Product By Manufacturer?\t\t Choiceful 24Hour Ranking\t\t";
		$Content .= "\r\n";
		
		$fileHeadWrite=fwrite($fileHead, $Content);
		fclose($fileHead);
		unset($Content);
		$totallist = $this->PeeriusAttribute->find('list',array("fields"=>array("PeeriusAttribute.quick_code"),"order"=>array("PeeriusAttribute.id"),"group"=>array("PeeriusAttribute.quick_code")));
		//$totalRec = 30;
		$quickcodearra=array();
		$totalRec=count($totallist);
		$totalPage=$totalRec/1000;
		$pagearray=array_chunk($totallist, 1000);
		//pr($pagearray); die;
		
		
		foreach($pagearray as $pa){
		$peeriusAttributes = $this->PeeriusAttribute->find('all',
			array(
				'order' => array('PeeriusAttribute.quick_code1' => 'ASC'),
				'group'=>array('PeeriusAttribute.quick_code'),
				'conditions'=>array("PeeriusAttribute.quick_code"=>$pa),
				//'limit' => 10,
				'fields' => array(
					'PeeriusAttribute.id',
					'PeeriusAttribute.quick_code',
					'PeeriusAttribute.product_name',
					'PeeriusAttribute.brand',
					'PeeriusAttribute.product_image',
					'PeeriusAttribute.product_video',
					
					'PeeriusAttribute.barcode',
					'PeeriusAttribute.manufacturer',
					'PeeriusAttribute.model_number',
					'PeeriusAttribute.product_rrp',
					'PeeriusAttribute.minimum_price_value',
					
					'PeeriusAttribute.minimum_price_seller',
					'PeeriusAttribute.minimum_price_used',
					'PeeriusAttribute.minimum_price_used_seller',
					'PeeriusAttribute.avg_rating',
					'PeeriusAttribute.status',
					
					'PeeriusAttribute.modified',
					'PeeriusAttribute.created',
					'PeeriusAttribute.department_name',
					'PeeriusAttribute.department_id',
					'PeeriusAttribute.department_status',
					
					/*'PeeriusAttribute.department_meta_title',
					'PeeriusAttribute.department_meta_keywords',
					'PeeriusAttribute.department_meta_description',*/
					
					'PeeriusAttribute.condition_new',
					'PeeriusAttribute.condition_used',
					'PeeriusAttribute.author_name',
					'PeeriusAttribute.publisher',
					'PeeriusAttribute.product_language',
					
					'PeeriusAttribute.product_isbn',
					'PeeriusAttribute.product_format',
					'PeeriusAttribute.pages',
					/*'PeeriusAttribute.publisher_review',*/
					'PeeriusAttribute.year_published',
					'PeeriusAttribute.label',
					
					'PeeriusAttribute.rated',
					'PeeriusAttribute.artist_name',
					'PeeriusAttribute.number_of_disk',
					'PeeriusAttribute.track_list',
					'PeeriusAttribute.release_date',
					
					'PeeriusAttribute.star_name',
					'PeeriusAttribute.directedby',
					/*'PeeriusAttribute.department_meta_keywords',
					'PeeriusAttribute.department_meta_description',*/
					'PeeriusAttribute.condition_new',
					'PeeriusAttribute.condition_used',
					'PeeriusAttribute.author_name',
					
					'PeeriusAttribute.publisher',
					'PeeriusAttribute.product_language',
					'PeeriusAttribute.product_isbn',
					'PeeriusAttribute.product_format',
					'PeeriusAttribute.studio',
					
					'PeeriusAttribute.run_time',
					'PeeriusAttribute.plateform',
					'PeeriusAttribute.region',
					'PeeriusAttribute.suitable_for',
					'PeeriusAttribute.how_to_use',
					
					'PeeriusAttribute.hazard_caution',
					'PeeriusAttribute.precautions',
					'PeeriusAttribute.ingredients',
					'PeeriusAttribute.product_weight',
					/*'PeeriusAttribute.product_height',
					'PeeriusAttribute.product_width',
					'PeeriusAttribute.product_length',*/
					'PeeriusAttribute.product_features',
					'PeeriusAttribute.technical_details',
					'PeeriusAttribute.product_searchtag',
					/*'PeeriusAttribute.meta_title',*/
					'PeeriusAttribute.meta_keywords',
					/*'PeeriusAttribute.meta_description',*/
					
					'PeeriusAttribute.gd_product',
				)
			)
		);
			
			
		$cnt=count($peeriusAttributes);
		
		//pr($peeriusAttributes);
		
		$search  = array(' ', "\r\n", ',','.','&');
		if(!empty($peeriusAttributes)){
				$Content1='';	
				foreach($peeriusAttributes as $peeriusAttribute){
					
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['id']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['quick_code']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['product_name']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['brand']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['product_image']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['product_video']."\t\t";
					
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['barcode']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['manufacturer']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['model_number']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['product_rrp']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['minimum_price_value']."\t\t";
					
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['minimum_price_seller']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['minimum_price_used']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['minimum_price_used_seller']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['avg_rating']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['status']."\t\t";
					
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['modified']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['created']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['department_name']."\t\t";
					$Content1 .=  ((!empty($breadcrumbs[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $breadcrumbs[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					//$Content1 .=  $peeriusAttribute['PeeriusAttribute']['department_id']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['department_status']."\t\t";
					
					/*$Content1 .=  $peeriusAttribute['PeeriusAttribute']['department_meta_title']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['department_meta_keywords']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['department_meta_description']."\t\t";*/
					//$Content1 .=  $peeriusAttribute['PeeriusAttribute']['condition_new']."\t\t";
					//$Content1 .=  $peeriusAttribute['PeeriusAttribute']['condition_used']."\t\t";
					$Content1 .=  ((!empty($peeriusAttribute['PeeriusAttribute']['condition_new'])) ? "1" : "0")."\t\t";
					$Content1 .=  ((!empty($peeriusAttribute['PeeriusAttribute']['condition_used'])) ? "1" : "0")."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['author_name']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['publisher']."\t\t";
					$Content1 .=  ((!empty($productBookLanguage[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productBookLanguage[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['product_isbn']."\t\t";
					
					$Content1 .=  ((!empty($productBookFormat[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productBookFormat[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['pages']."\t\t";
					/*$Content1 .=  $peeriusAttribute['PeeriusAttribute']['publisher_review']."\t\t";*/
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['year_published']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['artist_name']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['label']."\t\t";
					
					$Content1 .=  ((!empty($productMusicRated[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productMusicRated[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($productMusicNodisk[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productMusicNodisk[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					
					$Content1 .=  strip_tags(html_entity_decode($peeriusAttribute['PeeriusAttribute']['track_list'],ENT_QUOTES,'UTF-8'))."\t\t";
					$Content1 .=  ((!empty($productMoviesReleaseDate[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productMoviesReleaseDate[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['star_name']."\t\t";
					
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['directedby']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['studio']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['run_time']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['plateform']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['region']."\t\t";
					
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['suitable_for']."\t\t";
					/*$Content1 .=  $peeriusAttribute['PeeriusAttribute']['how_to_use']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['hazard_caution']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['precautions']."\t\t";*/
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['ingredients']."\t\t";
					
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['product_weight']."\t\t";
					
					/*$Content1 .=  $peeriusAttribute['PeeriusAttribute']['product_height']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['product_width']."\t\t";
					$Content1 .=  $peeriusAttribute['PeeriusAttribute']['product_length']."\t\t";*/
					$Content1 .=  str_replace($search,'_',trim(preg_replace('/[^a-zA-Z0-9]/',' ',strip_tags(html_entity_decode( $peeriusAttribute['PeeriusAttribute']['product_features'],ENT_QUOTES,'UTF-8')))))."\t\t";
					$Content1 .=  str_replace($search,'_',trim(preg_replace('/[^a-zA-Z0-9]/',' ',strip_tags(html_entity_decode( $peeriusAttribute['PeeriusAttribute']['technical_details'],ENT_QUOTES,'UTF-8')))))."\t\t";
					$Content1 .=  str_replace($search,'_',trim(preg_replace('/[^a-zA-Z0-9]/',' ',strip_tags(html_entity_decode( $peeriusAttribute['PeeriusAttribute']['product_searchtag'],ENT_QUOTES,'UTF-8')))))."\t\t";
					/*$Content1 .=  str_replace($search,'_',trim(preg_replace('/[^a-zA-Z0-9]/',' ',strip_tags(html_entity_decode( $peeriusAttribute['PeeriusAttribute']['meta_title'],ENT_QUOTES,'UTF-8')))))."\t\t";*/
					$Content1 .=  str_replace($search,'_',trim(preg_replace('/[^a-zA-Z0-9]/',' ',strip_tags(html_entity_decode( $peeriusAttribute['PeeriusAttribute']['meta_keywords'],ENT_QUOTES,'UTF-8')))))."\t\t";
					/*$Content1 .=  str_replace($search,'_',trim(preg_replace('/[^a-zA-Z0-9]/',' ',strip_tags(html_entity_decode( $peeriusAttribute['PeeriusAttribute']['meta_description'],ENT_QUOTES,'UTF-8')))))."\t\t"; */

					$Content1 .=  ((!empty($productMusicFormat[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productMusicFormat[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($productMoviesRated[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productMoviesRated[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($productMoviesFormat[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productMoviesFormat[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($productMoviesNodisk[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productMoviesNodisk[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($productMovieslanguage[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productMovieslanguage[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($productGamesRated[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productGamesRated[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($productGamesReleaseDate[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $productGamesReleaseDate[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  ((!empty($count_pro_rating[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $count_pro_rating[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					
					if(key_exists($peeriusAttribute['PeeriusAttribute']['id'], $is_seller)){
						$isseller = 'Y';
					}else{
						$isseller = 'N';
					}
					$Content1 .=  $isseller."\t\t";
					
					if(!empty($peeriusAttribute['PeeriusAttribute']['minimum_price_seller'])){
						$seller_id = $peeriusAttribute['PeeriusAttribute']['minimum_price_seller'];
					}else{
						$seller_id = $peeriusAttribute['PeeriusAttribute']['minimum_price_used_seller'];
					}
					if(!empty($seller_id)){
						$seller_percent = $this->Common->positivePercentFeedback($seller_id);
					}else{
						$seller_percent = "";
					}
					
					
					$Content1 .=  ((!empty($pro_seller[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $pro_seller[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($pro_visit90[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $pro_visit90[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($pro_visit[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $pro_visit[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($pro_sold90[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $pro_sold90[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($pro_sold[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $pro_sold[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($pro_revenue[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $pro_revenue[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($seller_percent)) ? $seller_percent : "0")."\t\t";
					//$Content1 .=  ((!empty($seller_rating[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $seller_rating[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($pro_reviews[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $pro_reviews[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($pro_questions[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $pro_questions[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($pro_answers[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $pro_answers[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($product_video[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? "Y" : "N")."\t\t";
					
					$Content1 .=  (($peeriusAttribute['PeeriusAttribute']['gd_product'] == '1') ? "Y" : "N")."\t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  ((!empty($peeriusAttribute['PeeriusAttribute']['product_image'])) ? "Y" : "N")."\t\t";
					
					if(key_exists($peeriusAttribute['PeeriusAttribute']['id'], $productMimage)){
						$MulImage = 'Yes';
					}else{
						$MulImage = 'No';
					}
					$Content1 .=  $MulImage."\t\t";
					//$Content1 .=  ((!empty($pro_mul_image[$peeriusAttribute["PeeriusAttribute"]["id"]])) ? $pro_mul_image[$peeriusAttribute["PeeriusAttribute"]["id"]] : "0")."\t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .= "\r\n";
					
				}
			}
					
		$pathContent=WWW_ROOT."files/fhcsvs/peerius_attributes.csv";
			$pathContentOpen = fopen($pathContent, "a+");
			$pathContentWrite=fwrite($pathContentOpen, $Content1);
			unset($ContentFieldValue);
			//$incrivalue = $incrivalue+$end_limit;
			fclose($pathContentOpen);
			//die();
		
		}
		exit;
		
	}
	
	 /**
	@function:	peerius_attribute_csv
	@description:	Get Products with categories Csv for FH
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	25 Agu 2011
	*/		
		
	function peerius_variant_csv(){
		set_time_limit(0);
		ini_set('memory_limit', '9999M');
		//Configure::write('debug',2);
		App::import('Model' , 'VariantAttribute');
		$this->VariantAttribute = new VariantAttribute();
		/*Start For add some extra fields*/
		App::import('Model','Feedback');
		$this->Feedback = &new Feedback;
		
		App::import('Model','Seller');
		$this->Seller = &new Seller;
			
		/*END For add some extra fields*/
		
		$count_rating = array();
		$avg_rating = array();
		$sellerRatings = $this->Feedback->find('all',
				array(
				'fields'=> array('Feedback.seller_id' , 'count(Feedback.id) as totalRating','Avg(Feedback.rating) as avg_rating'),
				'group'=>array('Feedback.seller_id'),
				//'limit'=>30,
				));
		foreach($sellerRatings as $sellerRating){
			$count_rating[$sellerRating['Feedback']['seller_id']] = $sellerRating['0']['totalRating'];
			$avg_rating[$sellerRating['Feedback']['seller_id']] = $sellerRating['0']['avg_rating'];
		}
		
		$seller_days = array();
		$seller_gift = array();
		$sellerDates = $this->Seller->find('all',
				array(
				'fields'=> array('Seller.user_id','DATEDIFF(CURDATE( ),Seller.created) AS days','if(Seller.gift_service > 1,"Yes","No") as gift_service'),
				'group'=>array('Seller.user_id'),
				//'limit'=>30,
				));
		foreach($sellerDates as $sellerDate){
			$seller_days[$sellerDate['Seller']['user_id']] = $sellerDate['0']['days'];
			$seller_gift[$sellerDate['Seller']['user_id']] = $sellerDate['0']['gift_service'];
		}
		$totalSellerProduct = $this->Common->totalnoProductSeller();
		$new_data = array();
		
		
		$filePath=WWW_ROOT."files/fhcsvs/peerius_variant.csv";
		/*
		if file exist delete the fiule file and create a new file
		*/
		if(file_exists($filePath)){
			unlink($filePath);
		}
		
		
		$fileHead = fopen($filePath, "w");
			
		$Content = "Product Id\t\t QCID\t\t Condition Id\t\t Dispatch Country Code\t\t Dispatch Country Name\t\t Express Delivery\t\t Express Delivery Price\t\t Seller Status\t\t Minimum Price\t\t Minimum Price Disabled\t\t Notes\t\t Quantity\t\t Reference Code\t\t Seller Id\t\t Seller Price\t\t Standard Delivery\t\t Standard Delivery Price\t\t Seller Feedback Rating\t\t Total Number of Feedbacks\t\t Seller Since (Number of Days)\t\t VIP Seller\t\t MMM Seller\t\t CI Seller\t\t Product Page Creator\t\t Are Gift Options Enable?\t\t Is Pre-Order Available?\t\t Restock Date\t\t  Number of Listings\t\t";
		$Content .= "\r\n";
		
		$fileHeadWrite=fwrite($fileHead, $Content);
		fclose($fileHead);
		unset($Content);
		
		$totallist = $this->VariantAttribute->find('list',array("fields"=>array("VariantAttribute.product_id","VariantAttribute.quick_code"),"order"=>array("VariantAttribute.product_id")));
		//$totalRec = 30;
		$quickcodearra=array();
		$totalRec=count($totallist);
		$totalPage=$totalRec/1000;
		$pagearray=array_chunk($totallist, 1000);
		//pr($pagearray); die;
		
		
		foreach($pagearray as $pa){
		$peeriusVariants = $this->VariantAttribute->find('all',
			array(
				'order' => array('VariantAttribute.quick_code' => 'ASC'),
				//'group'=>array('VariantAttribute.quick_code'),
				'conditions'=>array("VariantAttribute.quick_code"=>$pa),
				//'limit' => 10,
				'fields' => array(
					'VariantAttribute.product_id',
					'VariantAttribute.quick_code',
					'VariantAttribute.condition_id',
					'VariantAttribute.dispatch_country_code',
					
					'VariantAttribute.dispatch_country_name',
					'VariantAttribute.express_delivery',
					'VariantAttribute.express_delivery_price',
					'VariantAttribute.listing_status',
					'VariantAttribute.minimum_price',
					'VariantAttribute.minimum_price_disabled',
					'VariantAttribute.notes',
					'VariantAttribute.quantity',
					
					'VariantAttribute.reference_code',
					'VariantAttribute.seller_id',
					'VariantAttribute.seller_price',
					'VariantAttribute.standard_delivery',
					'VariantAttribute.standard_delivery_price',
				)
			)
		);
			
			
		$cnt=count($peeriusVariants);
		
		//pr($peeriusAttributes);
		
		$search  = array(' ', "\r\n", ',','.','&');
		if(!empty($peeriusVariants)){
				$Content1='';	
				foreach($peeriusVariants as $peeriusVariant){
					
					$Content1 .=  $peeriusVariant['VariantAttribute']['product_id']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['quick_code']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['condition_id']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['dispatch_country_code']."\t\t";
					
					$Content1 .=  $peeriusVariant['VariantAttribute']['dispatch_country_name']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['express_delivery']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['express_delivery_price']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['listing_status']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['minimum_price']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['minimum_price_disabled']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['notes']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['quantity']."\t\t";
					
					$Content1 .=  $peeriusVariant['VariantAttribute']['reference_code']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['seller_id']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['seller_price']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['standard_delivery']."\t\t";
					$Content1 .=  $peeriusVariant['VariantAttribute']['standard_delivery_price']."\t\t";
					
					
					$seller_percent = $this->Common->positivePercentFeedback($peeriusVariant["VariantAttribute"]["seller_id"]);
					
					//$Content1 .=  ((!empty($avg_rating[$peeriusVariant["VariantAttribute"]["seller_id"]])) ? $avg_rating[$peeriusVariant["VariantAttribute"]["seller_id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($seller_percent)) ? $seller_percent : "0")."\t\t";
					$Content1 .=  ((!empty($count_rating[$peeriusVariant["VariantAttribute"]["seller_id"]])) ? $count_rating[$peeriusVariant["VariantAttribute"]["seller_id"]] : "0")."\t\t";
					$Content1 .=  ((!empty($seller_days[$peeriusVariant["VariantAttribute"]["seller_id"]])) ? $seller_days[$peeriusVariant["VariantAttribute"]["seller_id"]] : "0")."\t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  ((!empty($seller_gift[$peeriusVariant["VariantAttribute"]["seller_id"]])) ? $seller_gift[$peeriusVariant["VariantAttribute"]["seller_id"]] : "0")."\t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  "0 \t\t";
					$Content1 .=  ((!empty($totalSellerProduct[$peeriusVariant["VariantAttribute"]["seller_id"]])) ? $totalSellerProduct[$peeriusVariant["VariantAttribute"]["seller_id"]] : "0")."\t\t";
					
					$Content1 .= "\r\n";
					
				}
			}
					
		$pathContent=WWW_ROOT."files/fhcsvs/peerius_variant.csv";
			$pathContentOpen = fopen($pathContent, "a+");
			$pathContentWrite=fwrite($pathContentOpen, $Content1);
			unset($ContentFieldValue);
			//$incrivalue = $incrivalue+$end_limit;
			fclose($pathContentOpen);
			//die();
		}
		exit;
		
	}
	
	
	 /**
	@function:	peerius_seller_info
	@description:	Get Products with Product Csv for FH
	@params:	
	@Created by: 	Nakul Kumar
	@Modify:	8 Feb 2012
	@Created Date:	25 July 2013
	*/		
	function peerius_seller_info(){
		Configure::write('debug',2);
		$this->layout='layout_admin';
		
		App::import('Model' , 'SellerInfoFeed');
		$this->SellerInfoFeed = new SellerInfoFeed();
		
		App::import('Model' , 'User');
		$this->User = new User();
		App::import('Model' , 'Seller');
		$this->Seller = new Seller();
		App::import('Model' , 'Address');
		$this->Address = new Address();
		
		App::import('Model' , 'Feedback');
		$this->Feedback = new Feedback();
		
		$this->Seller->expects(array('Address','ProductSeller'));
		
		//Fro extra fields
		App::import('Model' , 'ProductSeller');
		$this->ProductSeller = new ProductSeller();
		//End extra field
		
		$departmentName = array();
		$getDepartments = $this->ProductSeller->query('SELECT ps.seller_id,GROUP_CONCAT(DISTINCT d.name SEPARATOR ",") as tproductID FROM product_sellers as ps,products as p, departments as d WHERE 1 and (p.id = ps.product_id) and (p.department_id = d.id) group by ps.seller_id');
		if(!empty($getDepartments)){
			foreach($getDepartments as $getDepartment){
				$departmentName[$getDepartment['ps']['seller_id']] = $getDepartment['0']['tproductID'];
			}
		}
		
		$current_date = date('Y-m-d');
		$current_year = date('Y');
		$current_month = date('m');
		$current_day = date('d');
		$before_year = $current_year-1;
		$before_year_date = $before_year.'-'.$current_month.'-'.$current_day;
			
		$seller_rating = array();
		$seller_rating_count = array();
		$joptions = array(
				array('table' => 'feedbacks',
				'alias' => 'Feedback',
				'type' => 'LEFT',
				'conditions' => array('Feedback.seller_id = Seller.user_id','Feedback.created >= "'.$before_year_date.'"')));
		$sellerRatingPer = $this->Seller->find('all',
				array(
				'fields'=> array('Seller.user_id',"(sum(Feedback.rating)/(count(Feedback.rating)*5))*100 as ratingPer"),
				'order'=>array('Seller.user_id'),
				"joins"=>$joptions,
				"group"=>array('Seller.user_id'),
				//'limit'=>'30'
				));
		foreach($sellerRatingPer as $sellerRatingPer){
			$seller_rating[$sellerRatingPer['Seller']['user_id']] = round($sellerRatingPer['0']['ratingPer'],2);
		}
		
		$seller_rating_count = array();
		$sellerFeedback = $this->Feedback->find('all',
				array(
				'fields'=> array('Feedback.seller_id' , 'count(Feedback.id) as totalFeedback'),
				'order'=>array('Feedback.seller_id'),
				"group"=>array('Feedback.seller_id'),
				//'limit'=>'30'
				));
		foreach($sellerFeedback as $sellerFeedback){
			$seller_rating_count[$sellerFeedback['Feedback']['seller_id']] = $sellerFeedback['0']['totalFeedback'];
		}
		
		$userInfo = array();
		$joptions = array(
				array('table' => 'addresses',
				'alias' => 'Address',
				'type' => 'LEFT',
				'conditions' => array('Address.user_id = User.id','Address.primary_address = "1"')));
		$user_info = $this->User->find('all',
				array(
				'fields'=> array('User.id','User.firstname','Address.add_city'),
				'order'=>array('User.id'),
				"joins"=>$joptions,
				"group"=>array('User.id'),
				//'limit'=>'30'
				));
		foreach($user_info as $user_info){
			$userInfo[$user_info['User']['id']] = $user_info['User']['firstname'].'-'.$user_info['Address']['add_city'];
		}		
				

		$search  = array(' ', "\r\n", ',','.','&');
		//$sellerRating = array();
		$sellerRating1 = array();
		$sellerRating2 = array();
		$sellerRating3 = array();
		$sellerRating4 = array();
		$sellerRating5 = array();
		$sellers_feedback_info = $this->Feedback->query('SELECT id, seller_id, feedback,created,rating,user_id FROM ( SELECT id, seller_id, feedback,created,rating,user_id, CASE WHEN @seller_id!= seller_id THEN @rn := 1 ELSE @rn := @rn + 1 END rn,  @seller_id:=seller_id FROM (SELECT * FROM feedbacks ORDER BY created DESC) a,(SELECT @rn:=0, @seller_id:= NULL) r ORDER BY created DESC) s WHERE rn <= 5');
			/*foreach($sellers_feedback_info as  $seller_feedback_info){
			if(in_array($seller_feedback_info['s']['seller_id'],array_keys($sellerRating1))){
				$sellerRating[$i][$seller_feedback_info['s']['seller_id']]['rating'] = $seller_feedback_info['s']['rating'];
				$sellerRating[$i][$seller_feedback_info['s']['seller_id']]['created'] = $seller_feedback_info['s']['created'];
				$sellerRating[$i][$seller_feedback_info['s']['seller_id']]['feedback'] = $seller_feedback_info['s']['feedback'];
				$sellerRating[$i][$seller_feedback_info['s']['seller_id']]['username'] = $userInfo[$seller_feedback_info['s']['user_id']];
				$i++;
			}else{
				$i=1;
				$sellerRating1[$seller_feedback_info['s']['seller_id']]['rating'] = $seller_feedback_info['s']['rating'];
				$sellerRating1[$seller_feedback_info['s']['seller_id']]['created'] = $seller_feedback_info['s']['created'];
				$sellerRating1[$seller_feedback_info['s']['seller_id']]['feedback'] = $seller_feedback_info['s']['feedback'];
				$sellerRating1[$seller_feedback_info['s']['seller_id']]['username'] = $userInfo[$seller_feedback_info['s']['user_id']];
			}
			}*/
			foreach($sellers_feedback_info as  $seller_feedback_info){
				if(in_array($seller_feedback_info['s']['seller_id'],array_keys($sellerRating4))){
					if(empty($sellerRating5[$seller_feedback_info['s']['seller_id']]['rating'])){
					$sellerRating5[$seller_feedback_info['s']['seller_id']]['rating'] = $seller_feedback_info['s']['rating'];
					$sellerRating5[$seller_feedback_info['s']['seller_id']]['created'] = $seller_feedback_info['s']['created'];
					$sellerRating5[$seller_feedback_info['s']['seller_id']]['feedback'] = $seller_feedback_info['s']['feedback'];
					$sellerRating5[$seller_feedback_info['s']['seller_id']]['username'] = $userInfo[$seller_feedback_info['s']['user_id']];
					}
				}else if(in_array($seller_feedback_info['s']['seller_id'],array_keys($sellerRating3))){
					$sellerRating4[$seller_feedback_info['s']['seller_id']]['rating'] = $seller_feedback_info['s']['rating'];
					$sellerRating4[$seller_feedback_info['s']['seller_id']]['created'] = $seller_feedback_info['s']['created'];
					$sellerRating4[$seller_feedback_info['s']['seller_id']]['feedback'] = $seller_feedback_info['s']['feedback'];
					$sellerRating4[$seller_feedback_info['s']['seller_id']]['username'] = $userInfo[$seller_feedback_info['s']['user_id']];
				}else if(in_array($seller_feedback_info['s']['seller_id'],array_keys($sellerRating2))){
					$sellerRating3[$seller_feedback_info['s']['seller_id']]['rating'] = $seller_feedback_info['s']['rating'];
					$sellerRating3[$seller_feedback_info['s']['seller_id']]['created'] = $seller_feedback_info['s']['created'];
					$sellerRating3[$seller_feedback_info['s']['seller_id']]['feedback'] = $seller_feedback_info['s']['feedback'];
					$sellerRating3[$seller_feedback_info['s']['seller_id']]['username'] = $userInfo[$seller_feedback_info['s']['user_id']];
				}else if(in_array($seller_feedback_info['s']['seller_id'],array_keys($sellerRating1))){
					$sellerRating2[$seller_feedback_info['s']['seller_id']]['rating'] = $seller_feedback_info['s']['rating'];
					$sellerRating2[$seller_feedback_info['s']['seller_id']]['created'] = $seller_feedback_info['s']['created'];
					$sellerRating2[$seller_feedback_info['s']['seller_id']]['feedback'] = $seller_feedback_info['s']['feedback'];
					$sellerRating2[$seller_feedback_info['s']['seller_id']]['username'] = $userInfo[$seller_feedback_info['s']['user_id']];
				}else{
					$sellerRating1[$seller_feedback_info['s']['seller_id']]['rating'] = $seller_feedback_info['s']['rating'];
					$sellerRating1[$seller_feedback_info['s']['seller_id']]['created'] = $seller_feedback_info['s']['created'];
					$sellerRating1[$seller_feedback_info['s']['seller_id']]['feedback'] = $seller_feedback_info['s']['feedback'];
					$sellerRating1[$seller_feedback_info['s']['seller_id']]['username'] = $userInfo[$seller_feedback_info['s']['user_id']];
				}
				
			} 
			//pr($sellerRating1);
			//pr($sellerRating2);
			//pr($sellerRating3);
			//pr($sellerRating4);
			//pr($sellerRating5);
			//exit;
			
			
			$sellertLists = $this->Seller->find('all',
			array(
			'fields'=>array('Seller.id','Seller.user_id'),
			'group' => array('Seller.user_id'),
			//'limit' => 200,
			));
		$this->SellerInfoFeed->query('TRUNCATE TABLE seller_info_feeds');
		if(!empty($sellertLists)){
			foreach($sellertLists as $sellertList){
				$this->data['SellerInfoFeed']['seller_id'] = $sellertList['Seller']['user_id'];
				$this->data['SellerInfoFeed']['tlc_name'] = ((!empty($departmentName[$sellertList['Seller']['user_id']])) ? $departmentName[$sellertList['Seller']['user_id']] : "NA");
				$this->data['SellerInfoFeed']['percentage_feedback_rating'] = ((!empty($seller_rating[$sellertList['Seller']['user_id']])) ? $seller_rating[$sellertList['Seller']['user_id']] : "NA");
				$this->data['SellerInfoFeed']['number_of_feedback'] = ((!empty($seller_rating_count[$sellertList['Seller']['user_id']])) ? $seller_rating_count[$sellertList['Seller']['user_id']] : "NA");
				$this->data['SellerInfoFeed']['feedback_1_rating'] = ((!empty($sellerRating1[$sellertList['Seller']['user_id']]['rating'])) ? $sellerRating1[$sellertList['Seller']['user_id']]['rating'] : "NA");
				$this->data['SellerInfoFeed']['feedback_1_date'] = ((!empty($sellerRating1[$sellertList['Seller']['user_id']]['created'])) ? $sellerRating1[$sellertList['Seller']['user_id']]['created'] : "NA");
				$this->data['SellerInfoFeed']['feedback_1_comment'] = ((!empty($sellerRating1[$sellertList['Seller']['user_id']]['feedback'])) ? $sellerRating1[$sellertList['Seller']['user_id']]['feedback'] : "NA");
				$this->data['SellerInfoFeed']['first_name_town_buyer1'] = ((!empty($sellerRating1[$sellertList['Seller']['user_id']]['username'])) ? $sellerRating1[$sellertList['Seller']['user_id']]['username'] : "NA");
				
				$this->data['SellerInfoFeed']['feedback_2_rating'] = ((!empty($sellerRating2[$sellertList['Seller']['user_id']]['rating'])) ? $sellerRating2[$sellertList['Seller']['user_id']]['rating'] : "NA");
				
				$this->data['SellerInfoFeed']['feedback_2_date'] = ((!empty($sellerRating2[$sellertList['Seller']['user_id']]['created'])) ? $sellerRating2[$sellertList['Seller']['user_id']]['created'] : "NA");
				
				$this->data['SellerInfoFeed']['feedback_2_comment'] = ((!empty($sellerRating2[$sellertList['Seller']['user_id']]['feedback'])) ? $sellerRating2[$sellertList['Seller']['user_id']]['feedback'] : "NA");
				
				$this->data['SellerInfoFeed']['first_name_town_buyer2'] = ((!empty($sellerRating2[$sellertList['Seller']['user_id']]['username'])) ? $sellerRating2[$sellertList['Seller']['user_id']]['username'] : "NA");
				
				
				$this->data['SellerInfoFeed']['feedback_3_rating'] = ((!empty($sellerRating3[$sellertList['Seller']['user_id']]['rating'])) ? $sellerRating3[$sellertList['Seller']['user_id']]['rating'] : "NA");
				$this->data['SellerInfoFeed']['feedback_3_date'] = ((!empty($sellerRating3[$sellertList['Seller']['user_id']]['created'])) ? $sellerRating3[$sellertList['Seller']['user_id']]['created'] : "NA");
				$this->data['SellerInfoFeed']['feedback_3_comment'] = ((!empty($sellerRating3[$sellertList['Seller']['user_id']]['feedback'])) ? $sellerRating3[$sellertList['Seller']['user_id']]['feedback'] : "NA");
				$this->data['SellerInfoFeed']['first_name_town_buyer3'] = ((!empty($sellerRating3[$sellertList['Seller']['user_id']]['username'])) ? $sellerRating3[$sellertList['Seller']['user_id']]['username'] : "NA");
				
				
				$this->data['SellerInfoFeed']['feedback_4_rating'] = ((!empty($sellerRating4[$sellertList['Seller']['user_id']]['rating'])) ? $sellerRating4[$sellertList['Seller']['user_id']]['rating'] : "NA");
				$this->data['SellerInfoFeed']['feedback_4_date'] = ((!empty($sellerRating4[$sellertList['Seller']['user_id']]['created'])) ? $sellerRating4[$sellertList['Seller']['user_id']]['created'] : "NA");
				$this->data['SellerInfoFeed']['feedback_4_comment'] = ((!empty($sellerRating4[$sellertList['Seller']['user_id']]['feedback'])) ? $sellerRating4[$sellertList['Seller']['user_id']]['feedback'] : "NA");
				$this->data['SellerInfoFeed']['first_name_town_buyer4'] = ((!empty($sellerRating4[$sellertList['Seller']['user_id']]['username'])) ? $sellerRating4[$sellertList['Seller']['user_id']]['username'] : "NA");
				
				$this->data['SellerInfoFeed']['feedback_5_rating'] = ((!empty($sellerRating5[$sellertList['Seller']['user_id']]['rating'])) ? $sellerRating5[$sellertList['Seller']['user_id']]['rating'] : "NA");
				$this->data['SellerInfoFeed']['feedback_5_date'] = ((!empty($sellerRating5[$sellertList['Seller']['user_id']]['created'])) ? $sellerRating5[$sellertList['Seller']['user_id']]['created'] : "NA");
				$this->data['SellerInfoFeed']['feedback_5_comment'] = ((!empty($sellerRating5[$sellertList['Seller']['user_id']]['feedback'])) ? $sellerRating5[$sellertList['Seller']['user_id']]['feedback'] : "NA");
				$this->data['SellerInfoFeed']['first_name_town_buyer5'] = ((!empty($sellerRating5[$sellertList['Seller']['user_id']]['username'])) ? $sellerRating5[$sellertList['Seller']['user_id']]['username'] : "NA");
				
				
			
			$this->SellerInfoFeed->set($this->data);
			//pr($this->data);
			$this->SellerInfoFeed->save();
				
			}
		}
		//pr($this->data);
		
		exit;
		
		
		
				
		$sellertLists = $this->Seller->find('all',
				array(
				'fields'=>array('Seller.id',
						'Seller.user_id',
						'Seller.business_display_name',
						'Seller.created',
						'Seller.free_delivery',
						'Seller.threshold_order_value',
						'Seller.gift_service',
						'Seller.image',
						'Address.add_postcode',
						),
				'group' => array('Seller.user_id'),
				//'limit' => 200,
				));
		$Content = "Seller ID\t\t Seller Display Name\t\t Account Created\t\t TLC Names\t\t Seller Postcode/ZIP\t\t About Seller\t\t Seller Photo\t\t Facebook Link\t\t Twitter Link\t\t Google Plus Link\t\t Pinterest Link\t\t Tumblr Link\t\t Youtube Link\t\t Free Delivery\t\t Free Delivery Threshold Value\t\t Make me an Offer\t\t Gift Settings\t\t Bulk Buying Discounts\t\t Eco-Packaging\t\t Multi-Item Shipping Discounts\t\t Free Returns Service\t\t Percentage Feedback Rating over 12 months\t\t Number of Feedback over 12 months\t\t Feedback 1 Rating\t\t Feedback 1 Date\t\t Feedback 1 Comment\t\t Feedback 1 First Name and Town/City of Buyer\t\t  Feedback 2 Rating\t\t Feedback 2 Date\t\t Feedback 2 Comment\t\t Feedback 2 First Name and Town/City of Buyer\t\t Feedback 3 Rating\t\t Feedback 3 Date\t\t Feedback 3 Comment\t\t Feedback 3 First Name and Town/City of Buyer\t\t Feedback 4 Rating\t\t Feedback 4 Date\t\t Feedback 4 Comment\t\t Feedback 4 First Name and Town/City of Buyer\t\t Feedback 5 Rating\t\t Feedback 5 Date\t\t Feedback 5 Comment\t\t Feedback 5 First Name and Town/City of Buyer";
		$Content .= "\r\n";
		
		$filePath=WWW_ROOT."files/fhcsvs/seller_info.csv";
		$filePath = fopen($filePath,"w+");
		
		if(!empty($sellertLists)){
				foreach($sellertLists as $sellertList){
					$Content .=  $sellertList['Seller']['user_id']."\t\t";
					$Content .=  $sellertList['Seller']['business_display_name']."\t\t";
					$Content .=  $sellertList['Seller']['created']."\t\t";
					
					$Content .=  ((!empty($departmentName[$sellertList['Seller']['user_id']])) ? $departmentName[$sellertList['Seller']['user_id']] : "NA")."\t\t";
					$Content .=  $sellertList['Address']['add_postcode']."\t\t";
					$Content .=  'NA'."\t\t";
					$Content .=  $sellertList['Seller']['image']."\t\t";
					$Content .=  'NA'."\t\t";
					$Content .=  'NA'."\t\t";
					$Content .=  'NA'."\t\t";
					$Content .=  'NA'."\t\t";
					$Content .=  'NA'."\t\t";
					$Content .=  'NA'."\t\t";
					
					$Content .=  $sellertList['Seller']['free_delivery']."\t\t";
					$Content .=  $sellertList['Seller']['threshold_order_value']."\t\t";
					$Content .=  'NA'."\t\t";
					$Content .=  $sellertList['Seller']['gift_service']."\t\t";
					$Content .=  'NA'."\t\t";
					$Content .=  'NA'."\t\t";
					$Content .=  'NA'."\t\t";
					$Content .=  'NA'."\t\t";
					$Content .=  ((!empty($seller_rating[$sellertList['Seller']['user_id']])) ? $seller_rating[$sellertList['Seller']['user_id']] : "NA")."\t\t";		  $Content .=  ((!empty($seller_rating_count[$sellertList['Seller']['user_id']])) ? $seller_rating_count[$sellertList['Seller']['user_id']] : "NA")."\t\t";
					
					$Content .=  ((!empty($sellerRating1[$sellertList['Seller']['user_id']]['rating'])) ? $sellerRating1[$sellertList['Seller']['user_id']]['rating'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating1[$sellertList['Seller']['user_id']]['created'])) ? $sellerRating1[$sellertList['Seller']['user_id']]['created'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating1[$sellertList['Seller']['user_id']]['feedback'])) ? $sellerRating1[$sellertList['Seller']['user_id']]['feedback'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating1[$sellertList['Seller']['user_id']]['username'])) ? $sellerRating1[$sellertList['Seller']['user_id']]['username'] : "NA")."\t\t";
					
					$Content .=  ((!empty($sellerRating[1][$sellertList['Seller']['user_id']]['rating'])) ? $sellerRating[1][$sellertList['Seller']['user_id']]['rating'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[1][$sellertList['Seller']['user_id']]['created'])) ? $sellerRating[1][$sellertList['Seller']['user_id']]['created'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[1][$sellertList['Seller']['user_id']]['feedback'])) ? $sellerRating[1][$sellertList['Seller']['user_id']]['feedback'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[1][$sellertList['Seller']['user_id']]['username'])) ? $sellerRating[1][$sellertList['Seller']['user_id']]['username'] : "NA")."\t\t";
					
					$Content .=  ((!empty($sellerRating[2][$sellertList['Seller']['user_id']]['rating'])) ? $sellerRating[2][$sellertList['Seller']['user_id']]['rating'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[2][$sellertList['Seller']['user_id']]['created'])) ? $sellerRating[2][$sellertList['Seller']['user_id']]['created'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[2][$sellertList['Seller']['user_id']]['feedback'])) ? $sellerRating[2][$sellertList['Seller']['user_id']]['feedback'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[2][$sellertList['Seller']['user_id']]['username'])) ? $sellerRating[2][$sellertList['Seller']['user_id']]['username'] : "NA")."\t\t";
					
					$Content .=  ((!empty($sellerRating[3][$sellertList['Seller']['user_id']]['rating'])) ? $sellerRating[3][$sellertList['Seller']['user_id']]['rating'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[3][$sellertList['Seller']['user_id']]['created'])) ? $sellerRating[3][$sellertList['Seller']['user_id']]['created'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[3][$sellertList['Seller']['user_id']]['feedback'])) ? $sellerRating[3][$sellertList['Seller']['user_id']]['feedback'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[3][$sellertList['Seller']['user_id']]['username'])) ? $sellerRating[3][$sellertList['Seller']['user_id']]['username'] : "NA")."\t\t";
					
					$Content .=  ((!empty($sellerRating[4][$sellertList['Seller']['user_id']]['rating'])) ? $sellerRating[4][$sellertList['Seller']['user_id']]['rating'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[4][$sellertList['Seller']['user_id']]['created'])) ? $sellerRating[4][$sellertList['Seller']['user_id']]['created'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[4][$sellertList['Seller']['user_id']]['feedback'])) ? $sellerRating[4][$sellertList['Seller']['user_id']]['feedback'] : "NA")."\t\t";
					$Content .=  ((!empty($sellerRating[4][$sellertList['Seller']['user_id']]['username'])) ? $sellerRating[4][$sellertList['Seller']['user_id']]['username'] : "NA")."\t\t";
					
					$Content .= "\r\n";
				}
			}
		$fileComp=fwrite($filePath, $Content);
		fclose($filePath);
		if($fileComp){
			echo "complete";
			exit;
		}else{
			echo "Not complete";
			exit;
		}
	}
	
	function saveseller(){
		Configure::write('debug',2);
		/*Start For add some extra fields*/
		App::import('Model' , 'SellerFeed');
		$this->SellerFeed = new SellerFeed();
		App::import('Model','Feedback');
		$this->Feedback = &new Feedback;
		App::import('Model','Seller');
		$this->Seller = &new Seller;
		/*END For add some extra fields*/
		$count_rating = array();
		$avg_rating = array();
		$sellerRatings = $this->Feedback->find('all',
				array(
				'fields'=> array('Feedback.seller_id' , 'count(Feedback.id) as totalRating','Avg(Feedback.rating) as avg_rating'),
				'group'=>array('Feedback.seller_id'),
				//'limit'=>30,
				));
		foreach($sellerRatings as $sellerRating){
			$count_rating[$sellerRating['Feedback']['seller_id']] = $sellerRating['0']['totalRating'];
			$avg_rating[$sellerRating['Feedback']['seller_id']] = $sellerRating['0']['avg_rating'];
		}
		
		$totalSellerProduct = $this->Common->totalnoProductSeller();
		
		$seller_days = array();
		$seller_gift = array();
		$sellerDates = $this->Seller->find('all',
				array(
				'fields'=> array('Seller.user_id','DATEDIFF(CURDATE( ),Seller.created) AS days','if(Seller.gift_service > 1,"Yes","No") as gift_service'),
				'group'=>array('Seller.user_id'),
				//'limit'=>30,
				));
					
					
		$current_date = date('Y-m-d');
		$current_year = date('Y');
		$current_month = date('m');
		$current_day = date('d');
		$before_year = $current_year-1;
		$before_year_date = $before_year.'-'.$current_month.'-'.$current_day;
		$seller_rating_count = array();
		$joptions = array(
				array('table' => 'feedbacks',
				'alias' => 'Feedback',
				'type' => 'LEFT',
				'conditions' => array('Feedback.seller_id = Seller.user_id','Feedback.created >= "'.$before_year_date.'"')));
		$sellerRatingPer = $this->Seller->find('all',
				array(
				'fields'=> array('Seller.user_id',"(sum(Feedback.rating)/(count(Feedback.rating)*5))*100 as ratingPer"),
				'order'=>array('Seller.user_id'),
				"joins"=>$joptions,
				"group"=>array('Seller.user_id'),
				//'limit'=>'30'
				));
		foreach($sellerRatingPer as $sellerRatingPer){
			$seller_rating[$sellerRatingPer['Seller']['user_id']] = round($sellerRatingPer['0']['ratingPer'],2);
		}
		//Fro empty the table 
		$this->SellerFeed->query('TRUNCATE TABLE seller_feeds;');
		
		foreach($sellerDates as $sellerDate){
			//$seller_days[$sellerDate['Seller']['user_id']] = $sellerDate['0']['days'];
			//$seller_gift[$sellerDate['Seller']['user_id']] = $sellerDate['0']['gift_service'];
			
			
			$this->data['SellerFeed']['seller_id'] = $sellerDate['Seller']['user_id'];
			$this->data['SellerFeed']['total_rating'] = ((!empty($count_rating[$sellerDate['Seller']['user_id']])) ? $count_rating[$sellerDate['Seller']['user_id']] : "NA");
			$this->data['SellerFeed']['avg_rating'] = ((!empty($avg_rating[$sellerDate['Seller']['user_id']])) ? $avg_rating[$sellerDate['Seller']['user_id']] : "NA");
			$this->data['SellerFeed']['total_no_product'] = ((!empty($totalSellerProduct[$sellerDate['Seller']['user_id']])) ? $totalSellerProduct[$sellerDate['Seller']['user_id']] : "NA");
			
			$this->data['SellerFeed']['seller_days'] = $sellerDate['0']['days'];
			$this->data['SellerFeed']['seller_gift'] = $sellerDate['0']['gift_service'];
			$this->data['SellerFeed']['seller_feedback_percent'] = ((!empty($seller_rating[$sellerDate['Seller']['user_id']])) ? $seller_rating[$sellerDate['Seller']['user_id']] : "NA");
			
			$this->SellerFeed->set($this->data);
			print_r($this->data);
			pr($this->data);
			$this->SellerFeed->save();
		}
		
		
	}
	
	function productfeed(){
		Configure::write('debug',2);
		/*Start For add some extra fields*/
		
		App::import('Model','ProductFeed');
		$this->ProductFeed = new ProductFeed();
		App::import('Model','PeeriusAttribute');
		$this->PeeriusAttribute = new PeeriusAttribute();
		/*Start For add some extra fields*/
		
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		App::import('Model','ProductVisit');
		$this->ProductVisit = new ProductVisit();
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		$this->OrderItem->expects(array('Order'));
		App::import('Model','Product');
		$this->Product = new Product();
		App::import('Model','Review');
		$this->Review = new Review();
		App::import('Model','ProductQuestion');
		$this->ProductQuestion = new ProductQuestion();
		App::import('Model','ProductAnswer');
		$this->ProductAnswer = new ProductAnswer();
		
		App::import('Model','ProductDetail');
		$this->ProductDetail = new ProductDetail();
		$this->Product->expects(array('ProductDetail'));
		
		App::import('Model', 'Productimage');
		$this->Productimage = new Productimage();
		App::import('Model', 'ProductRating');
		$this->ProductRating = new ProductRating();
		
		App::import('Model', 'ProductCategory');
		$this->ProductCategory = new ProductCategory();
		$this->ProductCategory->expects(array('Category'));
		
		App::import('Model', 'Seller');
		$this->Seller = new Seller();
		/*END For add some extra fields*/
		
		
		$breadcrumbs = array();
		$productbread = $this->ProductCategory->find('all',
				array(
				'fields'=> array('ProductCategory.product_id' , 'Category.breadcrumbs'),
				'group'=>array('ProductCategory.product_id'),
				//'limit'=>30,
				));
		foreach($productbread as $productbread){
			$breadcrumbs[$productbread['ProductCategory']['product_id']] = $productbread['Category']['breadcrumbs'];
		}
		
		$current_date = date('Y-m-d');
		$current_year = date('Y');
		$current_month = date('m');
		$current_day = date('d');
		$before_year = $current_year-1;
		$before_year_date = $before_year.'-'.$current_month.'-'.$current_day;
		$seller_rating_per = array();
		$joptions = array(
				array('table' => 'feedbacks',
				'alias' => 'Feedback',
				'type' => 'LEFT',
				'conditions' => array('Feedback.seller_id = Seller.user_id','Feedback.created >= "'.$before_year_date.'"')));
		$sellerRatingPer = $this->Seller->find('all',
				array(
				'fields'=> array('Seller.user_id',"(sum(Feedback.rating)/(count(Feedback.rating)*5))*100 as ratingPer"),
				'order'=>array('Seller.user_id'),
				"joins"=>$joptions,
				"group"=>array('Seller.user_id'),
				//'limit'=>'30'
				));
		foreach($sellerRatingPer as $sellerRatingPer){
			$seller_rating_per[$sellerRatingPer['Seller']['user_id']] = number_format(round($sellerRatingPer['0']['ratingPer'],2),0);
		}
		$count_pro_rating = array();
		$productRatings = $this->ProductRating->find('all',
				array(
				'fields'=> array('ProductRating.product_id' , 'count(ProductRating.product_id) as totalRating'),
				'group'=>array('ProductRating.product_id'),
				//'limit'=>30,
				));
		foreach($productRatings as $productRatings){
			$count_pro_rating[$productRatings['ProductRating']['product_id']] = $productRatings['0']['totalRating'];
		}
		
		
		$productMimage = array();
		$productMimage = $this->Productimage->find('list',
				array(
				'fields'=> array('Productimage.product_id' , 'Productimage.product_id'),
				'group'=>array('Productimage.product_id'),
			//	'limit'=>30,
				));
				
		$pro_seller = array();
		$productsellers = $this->ProductSeller->find('all',
				array(
				'fields'=> array('ProductSeller.product_id' , 'count(ProductSeller.seller_id) as totalSeller'),
				'group'=>array('ProductSeller.product_id'),
			//	'limit'=>30,
				));
		foreach($productsellers as $productseller){
			$pro_seller[$productseller['ProductSeller']['product_id']] = $productseller['0']['totalSeller'];
		}
		
		$is_seller = array();
		$is_seller = $this->ProductSeller->find('list',
				array(
				'conditions'=> array('ProductSeller.quantity > 0'),
				'fields'=> array('ProductSeller.product_id' , 'ProductSeller.product_id'),
				'group'=>array('ProductSeller.product_id'),
				));
		$pro_visit90 = array();
		$productvisits90 = $this->ProductVisit->find('all',
				array(
				'conditions'=> array('created BETWEEN DATE_SUB(now() , INTERVAL 90 DAY) and now()'),
				'fields'=> array('ProductVisit.product_id' , 'ProductVisit.created' , 'sum(ProductVisit.visits) as totalVisit'),
				'group'=>array('ProductVisit.product_id'),
				//'limit'=>30,
				));
		foreach($productvisits90 as $productvisits90){
			$pro_visit90[$productvisits90['ProductVisit']['product_id']] = $productvisits90['0']['totalVisit'];
		}
		//pr($pro_visit90);
		//exit;
		
		$pro_visit = array();
		$productvisits = $this->ProductVisit->find('all',
				array(
				'fields'=> array('ProductVisit.product_id' , 'sum(ProductVisit.visits) as totalVisit'),
				'group'=>array('ProductVisit.product_id'),
				//'limit'=>30,
				));
		foreach($productvisits as $productvisits){
			$pro_visit[$productvisits['ProductVisit']['product_id']] = $productvisits['0']['totalVisit'];
		}
		
		$pro_sold90 = array();
		$productsolds90 = $this->OrderItem->find('all',
				array(
				'conditions'=> array('Order.created BETWEEN DATE_SUB(now() , INTERVAL 90 DAY) and now()'),
				'fields'=> array('OrderItem.product_id' , 'Order.id', 'OrderItem.order_id','sum(OrderItem.quantity) as totalSold'),
				'group'=>array('OrderItem.product_id'),
				//'limit'=>30,
				));
		foreach($productsolds90 as $productsolds90){
			$pro_sold90[$productsolds90['OrderItem']['product_id']] = $productsolds90['0']['totalSold'];
		}
		//pr($pro_sold90);
		//exit;
		$pro_sold = array();
		$productsolds = $this->OrderItem->find('all',
				array(
				'fields'=> array('OrderItem.product_id' , 'sum(OrderItem.quantity) as totalSold'),
				'group'=>array('OrderItem.product_id'),
				//'limit'=>30,
				));
		foreach($productsolds as $productsolds){
			$pro_sold[$productsolds['OrderItem']['product_id']] = $productsolds['0']['totalSold'];
		}
		//pr($pro_sold);
		//exit;
		$pro_revenue = array();
		$productrevenues = $this->OrderItem->find('all',
				array(
				'fields'=> array('OrderItem.product_id' , 'sum(OrderItem.quantity * OrderItem.price) as totalSold'),
				'group'=>array('OrderItem.product_id'),
				//'limit'=>30,
				));
		foreach($productrevenues as $productrevenues){
			$pro_revenue[$productrevenues['OrderItem']['product_id']] = $productrevenues['0']['totalSold'];
		}
		//pr($pro_revenue);
		//exit;
		
		$seller_rating = array();
		$joptions = array(
				array('table' => 'feedbacks',
				'alias' => 'Feedback',
				'type' => 'LEFT',
				'conditions' => array( 'Feedback.seller_id = Product.minimum_price_seller')
				)
				);
		$sellerAvgRatting = $this->Product->find('all',
				array(
				'fields'=> array('Product.id' , 'Product.minimum_price_seller',"avg(Feedback.rating) as avgRating"),
				'order'=>array('Product.id'),
				"joins"=>$joptions,
				"group"=>array('Product.id',"Product.minimum_price_seller"),
				//'limit'=>'30'
				));
		//pr($sellerAvgRatting);
		foreach($sellerAvgRatting as $sellerAvgRatting){
			$seller_rating[$sellerAvgRatting['Product']['id']] = round($sellerAvgRatting['0']['avgRating'],2);
		}
		$pro_reviews = array();
		$product_reviews = $this->Review->find('all',
				array(
				'fields'=> array('Review.product_id' , 'count(Review.id) as totalReview'),
				'order'=>array('Review.product_id'),
				"group"=>array('Review.product_id'),
				//'limit'=>'30'
				));
		foreach($product_reviews as $product_reviews){
			$pro_reviews[$product_reviews['Review']['product_id']] = $product_reviews['0']['totalReview'];
		}
		
		$pro_questions = array();
		$product_question = $this->ProductQuestion->find('all',
				array(
				'fields'=> array('ProductQuestion.product_id' , 'count(ProductQuestion.id) as totalQuestion'),
				'order'=>array('ProductQuestion.product_id'),
				"group"=>array('ProductQuestion.product_id'),
				//'limit'=>'30'
				));
		foreach($product_question as $product_question){
			$pro_questions[$product_question['ProductQuestion']['product_id']] = $product_question['0']['totalQuestion'];
		}
			
		$pro_answers = array();
		$product_answers = $this->ProductAnswer->find('all',
				array(
				'fields'=> array('ProductAnswer.product_id' , 'count(ProductAnswer.id) as totalAnswer'),
				'order'=>array('ProductAnswer.product_id'),
				"group"=>array('ProductAnswer.product_id'),
				//'limit'=>'30'
				));
		foreach($product_answers as $product_answers){
			$pro_answers[$product_answers['ProductAnswer']['product_id']] = $product_answers['0']['totalAnswer'];
		}
			
		$product_video = array();
		$product_video = $this->Product->find('list',
				array(
				'fields'=> array('Product.id' , 'Product.product_video'),
				'order'=>array('Product.id'),
				"group"=>array('Product.id'),
				//'limit'=>'30'
			));
		
		$product_feed= $this->Product->find('all',array("fields"=>array("Product.id","if(Product.minimum_price_seller,Product.minimum_price_seller,Product.minimum_price_used_seller) as seller_id"),"order"=>array("Product.id"=>"DESC"),"group"=>array("Product.id")/*, 'limit'=>'200'*/));
		//pr($product_feed);
		//exit;
		//Fro empty the table 
		$this->Product->query('TRUNCATE TABLE product_feeds;');
		
		foreach($product_feed as $pro_id => $product_feed){
			
			$pro_id = $product_feed['Product']['id'];
			$seller_id = $product_feed['0']['seller_id'];
			
			$this->data['ProductFeed']['product_id'] = $pro_id;
			$this->data['ProductFeed']['minimum_price_seller_id'] = $seller_id;
			$this->data['ProductFeed']['number_of_ratings'] = ((!empty($count_pro_rating[$pro_id])) ? $count_pro_rating[$pro_id] : "0");
			
			if(key_exists($pro_id, $is_seller)){
						$isseller = 'Y';
					}else{
						$isseller = 'N';
					}
			$this->data['ProductFeed']['is_marketplace_seller'] = $isseller;
			$this->data['ProductFeed']['number_of_marketplace_sellers'] = ((!empty($pro_seller[$pro_id])) ? $pro_seller[$pro_id] : "0");
			$this->data['ProductFeed']['product_page_views_90'] = ((!empty($pro_visit90[$pro_id])) ? $pro_visit90[$pro_id] : "0");
			$this->data['ProductFeed']['product_page_views_lifetime'] = ((!empty($pro_visit[$pro_id])) ? $pro_visit[$pro_id] : "0");
			$this->data['ProductFeed']['number_of_product_sold_90'] = ((!empty($pro_sold90[$pro_id])) ? $pro_sold90[$pro_id] : "0");
			$this->data['ProductFeed']['number_of_product_sold_life'] = ((!empty($pro_sold[$pro_id])) ? $pro_sold[$pro_id] : "0");
			$this->data['ProductFeed']['product_total_revenue'] = ((!empty($pro_revenue[$pro_id])) ? $pro_revenue[$pro_id] : "0");
			$this->data['ProductFeed']['seller_rating_percentage'] = ((!empty($seller_rating_per[$seller_id])) ? $seller_rating_per[$seller_id] : "0");
			$this->data['ProductFeed']['number_reviews_product'] = ((!empty($pro_reviews[$pro_id])) ? $pro_reviews[$pro_id] : "0");
			$this->data['ProductFeed']['number_questions_product'] = ((!empty($pro_questions[$pro_id])) ? $pro_questions[$pro_id] : "0");
			$this->data['ProductFeed']['number_answers_products'] = ((!empty($pro_answers[$pro_id])) ? $pro_answers[$pro_id] : "0");
			
			if(key_exists($pro_id, $productMimage)){
						$MulImage = 'Yes';
					}else{
						$MulImage = 'No';
					}
			$this->data['ProductFeed']['multiple_images'] = $MulImage;
			$this->data['ProductFeed']['breadcrumb'] = ((!empty($breadcrumbs[$pro_id])) ? $breadcrumbs[$pro_id] : "0");
			
			$this->data['ProductFeed']['number_of_MMAO'] = '0';
			$this->data['ProductFeed']['sales_ranking'] = '0';
			$this->ProductFeed->set($this->data);
			//pr($this->data);
			//exit;
			$this->ProductFeed->save();
		}
		
		
		
		
		
		
	}
	
}
?>