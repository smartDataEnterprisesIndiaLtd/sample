<?php
/**  @class:		ReportsController 
 @Created by: 		Kulvinder Singh
 @Modify:		NULL
 @Created Date:		07 March 2011
 
*/
//set_time_limit(-1);
//ini_set("memory_limit",256M);

class ReportsController extends AppController{
	var $name = 'Reports';
	var $helpers = array('Form','Html','Javascript','Session','Format','Common','Ajax', 'Validation');
	var $components = array ('RequestHandler', 'Common', 'Ordercom');
	var $permission_id = 4; // for department module
	//var $uses= array('CustomAttribute');
	/**
	* @Date: 07 March 2011
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		//check session other than admin_login page
		$includeBeforeFilter = array('admin_inventory', 'admin_marketplace', 'admin_financial_accounting' ,'admin_getDateWiseFinancialReport' , 'admin_getSellerWiseFinancialReport' , 'admin_most_viewed_departments' , 'admin_most_viewed_products' , 'admin_most_viewed_category' , 'admin_product_reviewed' , 'admin_product_question' , 'admin_seller_ratings' , 'admin_marketplace_highest_products' , 'admin_marketplace_earners','admin_preshipped_cancel_rates' , 'admin_late_shipped_rates' , 'admin_refund_rates');
		if (in_array($this->params['action'],$includeBeforeFilter)){
			// validate admin session
			$this->checkSessionAdmin();
			
			// validate module 
			$this->validateAdminModule($this->permission_id);
			
			
		}
	}
	
	/**
	@function:	admin_index
	@description:	listing of departments,
	@params:	NULL
	@Created by: 	Kulvinder
	@Modify:	NULL
	@Created Date:	07 March 2011
	*/		
	
	function admin_inventory(){
		$this->layout = 'layout_admin';
		$this->set('listTitle', 'Inventory');
		App::import('Model', 'Department');
		$this->Department = new Department();
		App::import('Model','Product');
		$this->Product =  new Product();
		$total_active_products = $this->Product->find('count',array('conditions'=>array('Product.status'=>'1')));
		$this->set('total_active_products', $total_active_products);
		$total_inactive_products = $this->Product->find('count',array('conditions'=>array('Product.status'=>'0')));
		$this->set('total_inactive_products', $total_inactive_products);
		$all_departments = $this->Department->find('list') ;
		foreach($all_departments as $id=>$value){
			$departments[$id]['id']  =$id;
			$departments[$id]['name']= $value;
			$total_products = $this->Product->find('count',array('conditions'=>array('Product.department_id'=>$id, 'Product.status'=>1)));
			$departments[$id]['products']= $total_products;
		}
		$this->set('departments', $departments);

		$productList1[0]['product']=array('Department Name' , 'Number of Products');
		if(!empty($productList1)){
		$Content='';	
		foreach($productList1 as $fields1){
			//for($k=0;$k<count($fields1);$k++){
				$Content .= $fields1['product'][0]."\t\t";
				$Content .= $fields1['product'][1];
				$Content .= "\n";
			//}
		}
		}
		//pr($Content);
		if(!empty($departments)){
				$Content1='';	
				foreach($departments as $fields){
					//for($i=0;$i<count($fields);$i++){
						$Content1 .= $fields['name']."\t\t";
						$Content1 .= $fields['products'];
						$Content1 .= "\n";
					//}
				}
			}
		$filePath=WWW_ROOT."files/productno/department_no_product.csv";
		$filePath = fopen($filePath, 'w+');
		$wholeContent=$Content.$Content1;
		$fileComp=fwrite($filePath, $wholeContent);
		fclose($filePath);
		
	}


	/**
	@function:	admin_marketplace_highest_products
	@description:	Marketplace Highest products sellers listing 
	@params:	NULL
	@Created by: 	nakul
	@Modify:	NULL
	@Created Date:	16 March 2011
	*/	

	function admin_marketplace_highest_products(){
				
		$this->set('listTitle','Marketplace Highest Products');
 		if($this->RequestHandler->isAjax() == 0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
			
		$total_sales_amount = array();
			
		App::import('Model', 'ProductSeller');
		$this->ProductSeller = new ProductSeller();
		$prodCountQuery = " select count(product_id) as total_products, seller_id from product_sellers ProductSeller  group by seller_id order by total_products desc limit 1";
		$seller_products  = $this->ProductSeller->query($prodCountQuery);
		$this->set('seller_products',$seller_products);
		//pr($seller_products);	
			
				
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_provisit_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			//'conditions'=>array(''),
			'fields' => array('count(product_id) as total_product','ProductSeller.seller_id'),
			'order'=>array('total_product DESC'),
			'group'=>array('ProductSeller.seller_id')
			);
		$allSellerProducts = $this->paginate('ProductSeller');
		$this->set('allSellerProducts' , $allSellerProducts);
		
	}
	
	/**
	@function:	admin_marketplace_earners
	@description:	Marketplace top earners list By date range. 
	@params:	NULL
	@Created by: 	nakul
	@Modify:	NULL
	@Created Date:	16 March 2011
	*/	

	function admin_marketplace_earners(){
				
		$this->set('listTitle','Marketplace Earners');
 		if($this->RequestHandler->isAjax() == 0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
					
					
					
			App::import('Model', 'OrderItem');
			$this->OrderItem = new OrderItem();
			$criteria = "";
			$from_date = trim($this->data['Search']['start_date']);
			$end_date  = trim($this->data['Search']['end_date']);
			if(!empty($from_date) ){
				$from_date = date("Y-m-d H:i:s ", mktime(00, 00, 00, date('m', strtotime($from_date) ), date('d', strtotime($from_date) ), date('Y', strtotime($from_date) )));
				$criteria .= " AND orders.created >= '".$from_date."' ";
			}
			if(!empty($end_date) ){
				$end_date = date("Y-m-d H:i:s ", mktime(23, 59, 59, date('m', strtotime($end_date) ), date('d', strtotime($end_date) ), date('Y', strtotime($end_date) )));
				$criteria .= " AND orders.created <= '".$end_date."' ";
			}
			
			$strEarningQuery = " select  SUM((price*quantity)+(delivery_cost*quantity)) as earning , seller_id from order_items  ";
			$strEarningQuery .= "inner join orders on (orders.id = order_items.order_id ) ";
			$strEarningQuery .= " where orders.payment_status = 'Y'  AND orders.deleted = '0' ";
			if(!empty($criteria)){
				$strEarningQuery .= " $criteria ";
			}
			$strEarningQuery .= " group by seller_id  order by earning desc";

			$earningSellers = $this->OrderItem->query($strEarningQuery);
			
			$sellersCancels = array();
			if(count($earningSellers) ){
				foreach($earningSellers as $sellerData){
					$seller_id = $sellerData['order_items']['seller_id'];
					if(!empty($seller_id) ){ 
						$cancelSellersData = $this->Ordercom->getCancelledItemsCost($seller_id , $sDate = $from_date , $eDate = $end_date);
						//pr($cancelSellersData);
						if(!empty($cancelSellersData) ){
							$sellersCancels[$seller_id] = $cancelSellersData[0][0]['cancelled_amount'];
						}else{
							$sellersCancels[$seller_id] = 0;
						}
						
					}
				}
			}
			//pr($sellersCancels);
			$this->set('earningSellers',$earningSellers);
			$this->set('sellersCancels',$sellersCancels);
			$this->set('sDateTime',date('d-F-Y',strtotime($from_date)));
			$this->set('eDateTime',date('d-F-Y',strtotime($end_date)));
			$this->data['Search']['start_date'] = '';
			$this->data['Search']['end_date'] = '';
		//}
		
	}

	
	/**
	@function:	admin_financial_accounting
	@description:	all finacial and management accounting report,
	@params:	NULL
	@Created by: 	Kulvinder
	@Modify:	NULL
	@Created Date:	10 March 2011
	*/		
	
	function admin_financial_accounting(){
		
		$this->layout = 'layout_admin';
		$this->set('listTitle', 'Inventory');
		
		$yearArray = $this->get_years();
		$this->set('yearArray',$yearArray);
		
		$monthsArray = $this->get_months();
		$this->set('monthsArray',$monthsArray);
		
		if(!empty($this->data['Report']['year'])){
			$Year = trim($this->data['Report']['year']);
		}else{
			$Year = date('Y');
		}
		$this->set('Year', $Year);
		
		App::import('Model' , 'Order');
		$this->Order = new Order();
		App::import('Model' , 'OrderRefund');
		$this->OrderRefund = new OrderRefund();
		App::import('Model' , 'OrderCertificate');
		$this->OrderCertificate = new OrderCertificate();
		App::import('Model','CanceledItem');
		$this->CanceledItem = new CanceledItem();
		
		$arrMonData = array();
		foreach($monthsArray as $monKey=>$monVal){
			$month = $monKey;
			$arrMonData[$monKey]['month']        = $monVal;
			$arrMonData[$monKey]['year']         = $Year;
			$sDate =  date("Y-m-d H:i:s ",mktime(0, 0, 0, $month,01,$Year));
			$eDate =  date("Y-m-d H:i:s ",mktime(23, 59, 59, $month+1, 00,$Year));
			
			$ordQuery =  "";
			$criteria = "";
			if(!empty($sDate)){
				$criteria = " AND created >= '".$sDate."' " ;
			}
			if(!empty($eDate)){
				$criteria .= " AND created <= '".$eDate."' " ;
			}
			$strOrderQuery = " select  count(id) as total_orders, SUM(order_total_cost-insurance_amount) as gross_revenue,  ";
			$strOrderQuery .= " SUM(dc_amount) as discount_vouchers ";
			$strOrderQuery .= " from orders  where orders.payment_status = 'Y' AND deleted = '0' ";
			if(!empty($criteria)){
				$strOrderQuery .= " $criteria ";
			}
			$orderData = $this->Order->query($strOrderQuery);
			
			$refundData = $this->OrderRefund->find('all',array('conditions'=>array(
				'OrderRefund.created >= "'.$sDate.'" AND OrderRefund.created <= "'.$eDate.'"',
				),
				'fields'=> array( 'SUM(amount) as refund_amount ' )
				));
			//pr($refundData);
			$cancelData = $this->Ordercom->getCancelledItemsCost(null , $sDate , $eDate, '2'); // 2 for preshipped cancell
			//pr($cancelData);
			$certificateData = $this->OrderCertificate->find('all',array('conditions'=>array(
				'OrderCertificate.created >= "'.$sDate.'" AND OrderCertificate.created <= "'.$eDate.'"',
				'OrderCertificate.payment_status' => 'Y' ),
				'fields'=> array( 'SUM(total_amount) as gc_revenue ' )
				));
			
			$arrMonData[$monKey]['total_orders']       	= $orderData[0][0]['total_orders'];
			$arrMonData[$monKey]['discount_vouchers'] 	= $orderData[0][0]['discount_vouchers'];
			$arrMonData[$monKey]['gross_revenue']   	= $orderData[0][0]['gross_revenue'];
			$arrMonData[$monKey]['refund_value']   		= $cancelData[0][0]['cancelled_amount']+$refundData[0][0]['refund_amount'];
			//$arrMonData[$monKey]['refund_value']   		= $refundData[0][0]['refund_amount'];
			
			$net_revenue   		= $orderData[0][0]['gross_revenue']-($cancelData[0][0]['cancelled_amount']+ $refundData[0][0]['refund_amount']);
			
			$arrMonData[$monKey]['net_revenue']		= $net_revenue ;
			$arrMonData[$monKey]['marketplace_fees']  	= $marketplaceFees = $this->geMarketplaceFees($sDate, $eDate, $net_revenue );
			
			//$arrMonData[$monKey]['net_revenue']    		= $orderData[0][0]['gross_revenue']-$refundData[0][0]['refund_amount'];
			$arrMonData[$monKey]['gc_revenue']       	= $certificateData[0][0]['gc_revenue'];

			unset($order_count);unset($cancelData); unset($net_revenue);
			unset($gross_revenue);unset($refundData);
		}
		$this->set('arrMonData', $arrMonData);
		
	}
	
	
	/**
	@function:	getDateWiseFinancialReport
	@description:	
	@params:	
	@Created by: 	Kulvinder
	@Modify:	NULL
	@Created Date:	11 March 2011
	*/		
	
	function admin_getDateWiseFinancialReport( $month_year_data ){
		
		$this->layout = 'ajax';
		$this->set('listTitle', 'Inventory');
		$mon_year_data_arr  = explode("_", $month_year_data);

		$month = $mon_year_data_arr[0];
		$year  = $mon_year_data_arr[1];
		$sDate =  date("Y-m-d H:i:s ",mktime(0, 0, 0, $month,01,$year));
		$eDate =  date("Y-m-d H:i:s ",mktime(23, 59,59, $month+1,0,$year));
		$this->set('start_date',date( 'd-M-Y',strtotime($sDate)) );
		$this->set('end_date',date( 'd-M-Y',strtotime($eDate)) );
		
		
		$monthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$this->set('monthDays', $monthDays);
		$this->set('selected_year', $year);
		$this->set('selected_month', date('m', strtotime($sDate)));
		
		$arrDaysData = array();
		for($d = 1; $d <= $monthDays; $d++){
			$sDateTime =  date("Y-m-d H:i:s ",mktime(0, 0, 0, $month,$d,$year));
			$eDateTime =  date("Y-m-d H:i:s ",mktime(23, 59,59, $month,$d,$year));
			
			$arrDaysData[$d]['day'] = $d ;
			$arrDaysData[$d]['month']  = date('m', strtotime($sDateTime));
			$arrDaysData[$d]['year']   = date('Y', strtotime($sDateTime));
			$arrDaysData[$d]['Month']  = date('M', strtotime($sDateTime));
			
			
			$ccPayments = $this->getSaleByPaymentMethod( $sDateTime, $eDateTime , 'Sage' ); // Sage
			$ppPayments = $this->getSaleByPaymentMethod( $sDateTime, $eDateTime , 'PayPal' ); // PayPal
			$gcPayments = $this->getSaleByPaymentMethod( $sDateTime, $eDateTime , 'Google Checkout' ); // Google Checkout
			$abandanedPayments = $this->getAbandanedSale( $sDateTime, $eDateTime ); // abandened sale
			$fraudPayments = $this->getFraudPayment( $sDateTime, $eDateTime ); // Fraud Orders payments 
			$consumption  = $this->getBalanceConsumption( $sDateTime, $eDateTime ); //  consumption of coupons and gift certificates
			$preShippedItemCost    = $this->getPreShippedCancel( $sDateTime, $eDateTime ); // preshipped cancels 
			
			$arrDaysData[$d]['sage_payment']   = $ccPayments[0][0]['gross_revenue'];
			$arrDaysData[$d]['paypal_payment'] = $ppPayments[0][0]['gross_revenue'];
			$arrDaysData[$d]['google_payment'] = $gcPayments[0][0]['gross_revenue'];
			$arrDaysData[$d]['abandened_payment'] = $abandanedPayments[0][0]['gross_revenue'];
			$arrDaysData[$d]['fraud_payment']   = $fraudPayments[0][0]['gross_revenue'];
			$arrDaysData[$d]['gift_payment']    = $consumption[0][0]['gross_gift_value'];
			$arrDaysData[$d]['coupon_payment']    = $consumption[0][0]['gross_coupon_value'];
			
			$arrDaysData[$d]['pre_shipped_payment']    = $preShippedItemCost;
			unset($ccPayments);
			unset($ppPayments);
			unset($gcPayments);
			unset($abandanedPayments);
			unset($fraudPayments);
			unset($consumption);
			unset($preShippedItemCost);
		}
		$this->set('arrDaysData', $arrDaysData);
	}
	
	/**
	@function:	getSaleByPaymentMethod
	@description:	total Sale by payment mthods 
	@params:	
	@Created by: 	Kulvinder
	@Modify:	NULL
	@Created Date:	11 March 2011
	*/		
	function getSaleByPaymentMethod($sDateTime, $eDateTime , $method){
		App::import('Model' , 'Order');
		$this->Order = new Order();
		$orderData = $this->Order->find('all',array('conditions'=>array(
				'Order.created >= "'.$sDateTime.'" AND Order.created <= "'.$eDateTime.'"
				 AND  Order.payment_method = "'.$method.'"  AND Order.payment_status = "Y"  AND Order.deleted = "0" '),
				'fields'=> array( 'SUM(order_total_cost-(gc_amount+insurance_amount)) as gross_revenue' )
				));
		
		return $orderData;
	}
	
	
	/**
	@function:	getPreShippedCancel
	@description:	
	*/
	function getPreShippedCancel($sDateTime, $eDateTime ){
		
		$cancelData = $this->Ordercom->getCancelledItemsCost(null , $sDateTime , $eDateTime, '2');
		//pr($cancelData);
		return $cancelData[0][0]['cancelled_amount'];
	}
	
	
	/**
	@function:	getFraudPayment
	@description:	total Sale by fraud
	@params:	
	@Created by: 	Kulvinder
	@Modify:	NULL
	@Created Date:	11 March 2011
	*/		
	function getFraudPayment($sDateTime, $eDateTime ){
		App::import('Model' , 'Order');
		$this->Order = new Order();
		$orderData = $this->Order->find('all',array('conditions'=>array(
				'Order.created >= "'.$sDateTime.'" AND Order.created <= "'.$eDateTime.'"
				 AND Order.payment_status = "Y" AND Order.deleted = "2" '),
				'fields'=> array( 'SUM(order_total_cost-insurance_amount) as gross_revenue' )
				));
		
		return $orderData;
	}
	
	
	/**
	@function:	getBalanceConsumption
	@description:	total consumptions  of discount coupons and cerrtificates
	@params:	
	@Created by: 	Kulvinder
	@Modify:	NULL
	@Created Date:	11 March 2011
	*/		
	function getBalanceConsumption($sDateTime, $eDateTime ){
		App::import('Model' , 'Order');
		$this->Order = new Order();
		$orderData = $this->Order->find('all',array('conditions'=>array(
				'Order.created >= "'.$sDateTime.'" AND Order.created <= "'.$eDateTime.'"
				 AND Order.payment_status = "Y" AND Order.deleted = "0"  '),
				'fields'=> array( 'SUM(gc_amount) as gross_gift_value','SUM(dc_amount) as gross_coupon_value'  )
				));
		//pr($orderData);
		return $orderData;
	}
	
	
	/**
	@function:	getSaleByPaymentMethod
	@description:	total Sale by payment mthods 
	@params:	
	@Created by: 	Kulvinder
	@Modify:	NULL
	@Created Date:	11 March 2011
	*/		
	function getAbandanedSale($sDateTime, $eDateTime ){
		
		App::import('Model' , 'Order');
		$this->Order = new Order();
		$orderData = $this->Order->find('all',array('conditions'=>array(
				'Order.created >= "'.$sDateTime.'" AND Order.created <= "'.$eDateTime.'"
				 AND Order.payment_status = "N" '),
				'fields'=> array( 'SUM(order_total_cost-insurance_amount) as gross_revenue' )
				));
		return $orderData;
	}
	
	/**
	@function:	getDateWiseFinancialReport
	@description:	
	@params:	
	@Created by: 	Kulvinder
	@Modify:	NULL
	@Created Date:	11 March 2011
	*/		
	function admin_getSellerWiseFinancialReport( $day_month_year_data ){
		// d_m_y

		$this->layout = 'ajax';
		$this->set('listTitle', 'Inventory');
		$day_mon_year_data_arr  = explode("_", $day_month_year_data);
		
		$day 	= $day_mon_year_data_arr[0];
		$month  = $day_mon_year_data_arr[1];
		$year   = $day_mon_year_data_arr[2];
		
		$sDateTime =  date("Y-m-d H:i:s ",mktime(0, 0, 0, $month,$day,$year));
		$eDateTime =  date("Y-m-d H:i:s ",mktime(23, 59,59, $month,$day,$year));
		
		$this->set('saleDate',$sDateTime);
		
		$sellerData = array();
		
		$this->set('sellerData',$sellerData );
		
		App::import('Model' , 'OrderItem');
		$this->OrderItem = new OrderItem();
	
		App::import('Model' , 'Order');
		$this->Order = new Order();
			$dayOrdersList = $this->Order->find('list',array('conditions'=>array(
				'Order.created >= "'.$sDateTime.'" AND Order.created <= "'.$eDateTime.'"',
				'Order.payment_status = "Y" AND Order.deleted =  "0" '	)
				));

		if(is_array($dayOrdersList) && count($dayOrdersList) > 0){
			$dayOrderStr = implode(',' , $dayOrdersList);
			$strSellerQuery  = " select SUM((price*quantity)+(quantity*delivery_cost)+(quantity*giftwrap_cost)) as revenue , count(distinct(order_id)) as total_orders , seller_id from order_items  ";
			$strSellerQuery .= " where order_id IN($dayOrderStr) ";
			$strSellerQuery .= " group by seller_id ";
			$sellerDataArr = $this->OrderItem->query($strSellerQuery);
		}else{
			$sellerDataArr =  array();
		}
		
		//pr($sellerDataArr);
		$sellerWiseDataArr = array();
		if( count($sellerDataArr) > 0 ){
			foreach($sellerDataArr as $id=>$sData){
				$sellerId = $sData['order_items']['seller_id'];
				$sellerWiseDataArr[$id]['gross_revenue'] = $sData[0]['revenue'];
				$sellerWiseDataArr[$id]['total_orders'] = $sData[0]['total_orders'];
				$sellerWiseDataArr[$id]['seller_id'] = $sellerId;
				
				$refundData  = $this->getRefundBySeller($sellerId, $sDateTime, $eDateTime );
				$cancelData  = $this->Ordercom->getCancelledItemsCost($sellerId, $sDateTime, $eDateTime, '2' );
				if(count($cancelData) >0){
					$cancelledAmount = $cancelData[0][0]['cancelled_amount'];
				}else{
					$cancelledAmount = 0;
				}
				$seller_data = $this->Common->getSellerInfo($sellerId);				
				$sellerWiseDataArr[$id]['seller_name'] 		= $seller_data['Seller']['business_display_name'];

				$refundedAmount 	= $refundData[0][0]['refund_amount'];
				$totalCancelledAmount 	= $refundedAmount + $cancelledAmount;
				$sellerWiseDataArr[$id]['refund_amount'] 	= $totalCancelledAmount;
				$new_revenue = 	 $sData[0]['revenue']-$totalCancelledAmount;
				$sellerWiseDataArr[$id]['net_revenue'] = $new_revenue;
				
				$marketplaceFees = $this->geMarketplaceFees($sDateTime, $eDateTime, $new_revenue, $sellerId );
				$sellerWiseDataArr[$id]['marketplace_fees'] 	= $marketplaceFees;				
				
				$DepositData = $this->gerDepositForSeller($sellerId, $sDateTime, $eDateTime);
				if(!empty($DepositData)) {
					$sellerWiseDataArr[$id]['deposit_amount'] = @$DepositData['PaymentReport']['deposited'];
					$seposited_amount = @$DepositData['PaymentReport']['deposited'];
				} else {
					$sellerWiseDataArr[$id]['deposit_amount'] = 0;
					$seposited_amount = @$DepositData['PaymentReport']['deposited'];
				}
				$sellerWiseDataArr[$id]['balance'] 		= $sellerWiseDataArr[$id]['net_revenue'] - $seposited_amount;
				
				unset($sellerId);unset($cancelData);unset($refundedAmount);unset($cancelledAmount);
				unset($refundData);unset($totalCancelledAmount);
				unset($seller_data);unset($marketplaceFees);unset($DepositData);
				unset($new_revenue);
				
			}
		}
		
		function cmp($a, $b)
		{
			return strcmp($a['seller_name'], $b['seller_name']);
		}
		usort($sellerWiseDataArr, "cmp");
		//pr($sellerWiseDataArr);
		$this->set('sellerWiseDataArr' , $sellerWiseDataArr);
	}
	
	
	
	/**
	 * @ function to get amount refunded by seller
	 */

	 function getRefundBySeller($seller_id , $sDateTime, $eDateTime ){ 
		App::import('Model', 'OrderRefund' );
		$this->OrderRefund = new OrderRefund();
		
		$refundData = $this->OrderRefund->find('all',array('conditions'=>array(
				'OrderRefund.created >= "'.$sDateTime.'" AND OrderRefund.created <= "'.$eDateTime.'"',
				'seller_id'=> $seller_id ),
				'fields'=> array( 'SUM(amount) as refund_amount ' )
				));
		return $refundData;
	 }
	 
	 
	/**
	 * @ function to get deposited value for a seller
	 */
	 function gerDepositForSeller($seller_id , $sDateTime, $eDateTime ){ 
		
// 		App::import('Model', 'SellerPayment' );
// 		$this->SellerPayment = new SellerPayment();
// 		
// 		$depositData = $this->SellerPayment->find('all',array('conditions'=>array(
// 				'SellerPayment.created >= "'.$sDateTime.'" AND SellerPayment.created <= "'.$eDateTime.'"',
// 				'seller_id'=> $seller_id ),
// 				'fields'=> array( 'SUM(amount) as deposit_amount' )
// 				));
// 		return $depositData;
		App::import('Model', 'PaymentReport' );
		$this->PaymentReport = new PaymentReport();
		
		$depositData = $this->PaymentReport->find('first',array('conditions'=>array(
				'PaymentReport.created >= "'.$sDateTime.'" AND PaymentReport.created <= "'.$eDateTime.'"',
				'seller_id'=> $seller_id ),
				'fields'=> array( 'PaymentReport.deposited' )
				));
		return $depositData;
	 }
	 
	 
	 /**
	 * @ function to get market place fees
	 */
	 function geMarketplaceFees($sDateTime, $eDateTime, $net_revenue, $seller_id = null ){
		App::import('Model', 'OrderItem' );
		$this->OrderItem = new OrderItem();
		
		$itemSalesArray = $this->Ordercom->getSoldItemsCount( $sDateTime, $eDateTime, $seller_id  );
		$itemCancelArray = $this->Ordercom->getCancelledItemsCount( $sDateTime, $eDateTime, $seller_id  );
		
		$actual_items_sold = (int)$itemSalesArray[0][0]['total_items_count'] - (int)$itemCancelArray[0][0]['cancelled_items_count'];

		if($actual_items_sold > 0 ){
			// 5% of net revenue + 25 p per item
			$marketplaceFees = ($net_revenue * 5 /100)+ ( $actual_items_sold * 0.25) ;	
		}else{
			$marketplaceFees = 0;
		}
		return $marketplaceFees ;
	 }
	 
	 /**
	@function:	most_viewed_departments
	@description:	total Sale by payment mthods 
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	08 Aug 2011
	*/		
	function admin_most_viewed_departments(){
		
		$this->layout='layout_admin';
		$this->set('title_for_layout','Most Viewed Departments');
		
		$sDateTime=$this->data['DepartmentVisit']['start_date'];
		$eDateTime=$this->data['DepartmentVisit']['end_date'];
		if(Empty($sDateTime)){
			$sDateTime=date('Y-m-d', mktime(00,00,00,date('m'),date('d')-30,date('Y')));
			$eDateTime=date('Y-m-d', mktime(23,59,59,date('m'),date('d')+1,date('Y')));
		}else{
			$sDateTime=date('Y-m-d',strtotime($sDateTime));
			$eDateTime=date('Y-m-d',strtotime($eDateTime));
			$sDateTime=$sDateTime.' 00:00:00';
			$eDateTime=$eDateTime.' 23:59:59';
		}
			
			
		App::import('Model' , 'DepartmentVisit');
		$this->DepartmentVisit = new DepartmentVisit();
		$this->DepartmentVisit->expects(array('Department'));
		$allVisitDepartment = $this->DepartmentVisit->find('all',array('conditions'=>array(
				'DepartmentVisit.created BETWEEN "'.$sDateTime.'" AND "'.$eDateTime.'"'),
				//'DepartmentVisit.created >= "'.$sDateTime.'" AND DepartmentVisit.created <= "'.$eDateTime.'"'),
				'fields'=>array('sum(visits) as total_visits','DepartmentVisit.department_id','Department.name'),
				'order'=> array( 'total_visits DESC' ),
				'group'=>array('DepartmentVisit.department_id'),
				));
		
		$this->set('sDateTime',date('d-F-Y',strtotime($sDateTime)));
		$this->set('eDateTime',date('d-F-Y',strtotime($eDateTime)));
		$this->set('allVisitDepartment' , $allVisitDepartment);
		
	}
	
	
	 /**
	@function:	admin_most_viewed_product
	@description:	total Sale by payment mthods 
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	08 Aug 2011
	*/		
	function admin_most_viewed_products(){
		
		$this->layout='layout_admin';
		$this->set('title_for_layout','Most Viewed Products');
		
		if(!empty($this->data['ProductsVisit']['start_date'])){
			$sDateTime=$this->data['ProductsVisit']['start_date'];
			$eDateTime=$this->data['ProductsVisit']['end_date'];
		}elseif(empty($this->data['ProductsVisit']['start_date']) && !empty($this->params['named'])){
			$sDateTime=$this->params['named']['start_date'];
			$eDateTime=$this->params['named']['end_date'];
		}
		
		if(Empty($sDateTime)){
			$sDateTime=date('Y-m-d', mktime(00,00,00,date('m'),date('d')-30,date('Y')));
			$eDateTime=date('Y-m-d', mktime(23,59,59,date('m'),date('d')+1,date('Y')));
		}else{
			$sDateTime=date('Y-m-d',strtotime($sDateTime));
			$eDateTime=date('Y-m-d',strtotime($eDateTime));
			$sDateTime=$sDateTime.' 00:00:00';
			$eDateTime=$eDateTime.' 23:59:59';
		}
		
		$criteria = 1;
		App::import('Model' , 'ProductVisit');
		$this->ProductVisit = new ProductVisit();
		$this->ProductVisit->expects(array('Product'));
		$criteria .= ' AND ProductVisit.created between "'.$sDateTime.'" AND "'.$eDateTime.'"';
		//$criteria .= ' AND (ProductVisit.created>= "'.$sDateTime.'" AND ProductVisit.created <= "'.$eDateTime.'")';
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_provisit_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'conditions'=>array('Product.product_name != ""'),
			'fields' => array('sum(visits) as total_visits','ProductVisit.product_id','Product.product_name','Product.id','Product.quick_code'),
			'order'=>array('total_visits DESC'),
			'group'=>array('ProductVisit.product_id')
			);
		$visitProduct=$this->paginate('ProductVisit',$criteria);
		$this->set('sDateTime',date('d-F-Y',strtotime($sDateTime)));
		$this->set('eDateTime',date('d-F-Y',strtotime($eDateTime)));
		$this->set('visitProduct',$visitProduct);
		if(!empty($this->data['ProductsVisit']['start_date']) && !empty($this->data['ProductsVisit']['end_date'])){
			$url['start_date'] = $this->data['ProductsVisit']['start_date'];
			$url['end_date'] = $this->data['ProductsVisit']['end_date']; 
			$this->redirect($url,null);
		}
	}
	
	
	 /**
	@function:	admin_most_viewed_category
	@description:	total Sale by payment mthods 
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	08 Aug 2011
	*/		
	function admin_most_viewed_category($dept_id = null,$parent_id = null){
		
		$this->layout='layout_admin';
		$this->set('title_for_layout','Most Viewed Category');
		
		
		$sDateTime=$this->data['CategoryVisit']['start_date'];
		$eDateTime=$this->data['CategoryVisit']['end_date'];
		if(Empty($sDateTime)){
			$sDateTime=date('Y-m-d', mktime(00,00,00,date('m'),date('d')-30,date('Y')));
			$eDateTime=date('Y-m-d', mktime(23,59,59,date('m'),date('d')+1,date('Y')));
		}else{
			$sDateTime=date('Y-m-d',strtotime($sDateTime));
			$eDateTime=date('Y-m-d',strtotime($eDateTime));
			$sDateTime=$sDateTime.' 00:00:00';
			$eDateTime=$eDateTime.' 23:59:59';
		}
		if(Empty($dept_id)){
			$dept_id=$this->data['CategoryVisit']['dept_id'];
		}
		
		if(Empty($parent_id) && !Empty($this->data['CategoryVisit']['parent_id'])){
			$parent_id=$this->data['CategoryVisit']['parent_id'];
		}
		$this->set('dept_id',$dept_id);
		$this->set('parent_id',$parent_id);
		
		$criteria = 1;
		App::import('Model' , 'CategoryVisit');
		$this->CategoryVisit = new CategoryVisit();
		$this->CategoryVisit->expects(array('Category'));
		$criteria .= ' AND (CategoryVisit.created>= "'.$sDateTime.'" AND CategoryVisit.created <= "'.$eDateTime.'")';
		
		if(!Empty($parent_id) && $parent_id > 0){
			$criteria .= ' AND (CategoryVisit.parent_id = "'.$parent_id.'")';
		}else{
			$criteria .= ' AND (CategoryVisit.parent_id = 0)';
		}
		
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_provisit_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'conditions'=>array('CategoryVisit.department_id'=>$dept_id,'Category.cat_name != ""'),
			'fields' => array('sum(visits) as total_visits','CategoryVisit.category_id','CategoryVisit.parent_id','Category.cat_name'),
			'order'=>array('total_visits DESC'),
			'group'=>array('CategoryVisit.category_id')
			);
		$visitCategory=$this->paginate('CategoryVisit',$criteria);
		//Start for Beadcrum
		App::import('Model','Department');
		$this->Department = &new Department;
		$departArr  = $this->Department->find('first' , array(
			'conditions' => array('Department.id' => $dept_id),
			'fields' => array('Department.name', 'Department.id')
			));
		$strDepName = $departArr['Department']['name'];
		$this->set('strDepName',$strDepName);
		$finalArr='';
		$finalArr=$this->Common->adminCategoryBreadcrumb($dept_id,$parent_id);
		//End for Beadcrum
		$this->set('finalArr',$finalArr);
		$this->set('sDateTime',date('d-F-Y',strtotime($sDateTime)));
		$this->set('eDateTime',date('d-F-Y',strtotime($eDateTime)));
		$this->set('visitCategory',$visitCategory);
	}
	 
	
	function admin_inventory_category($department_id = null,$cate_id = null){
		$this->layout = 'layout_admin';
		$this->set('listTitle', 'Inventory Categories');
			
			
		App::import('Model','Product');
		$this->Product =  new Product();
		App::import('Model','Department');
		$this->Department =  new Department();
		$dept_info = $this->Department->find('first',array('conditions'=>array('Department.id'=>$department_id)));
		$this->set('dept_info',$dept_info);
		$total_active_products = $this->Product->find('count',array('conditions'=>array('Product.status'=>'1')));
		$this->set('total_active_products', $total_active_products);
		$total_inactive_products = $this->Product->find('count',array('conditions'=>array('Product.status'=>'0')));
		$this->set('total_inactive_products', $total_inactive_products);
			
			
		App::import('Model','Category');
		$this->Category = new Category;
			
		if(!empty($cate_id)){
			$conArr = array('Category.parent_id' => $cate_id);
		} else {
			$conArr = array('Category.department_id' => $department_id,'Category.parent_id' => 0);
		}
			
		$all_cate = $this->Category->find('all',array('conditions'=>$conArr,'order' => array('Category.cat_name'),'fields' => array('Category.id','Category.department_id','Category.cat_name')));
			
		if(!empty($all_cate)){
			$count =0;
			foreach($all_cate as $cat){
					
				$this->Session->delete('all_pr_count');
				$this->Session->delete('cate_id');
				$this->Session->write('cate_id',$cat['Category']['id']);
				$this->sub_cats($cat['Category']['id']);
				$all_pro = $this->Session->read('all_pr_count');
				if(!Empty($all_pro)){
					foreach ($all_pro as $pr_count){
						$pro_cntArr[$cat['Category']['id']] = $pr_count;
					}
				} else {
						$pro_cntArr[$cat['Category']['id']] = 0;
				}
					
				$count++;
			}
		} else {
			if(!Empty($cate_id)) {
				$this->Session->delete('all_pr_count');
				$this->Session->delete('cate_id');
				$this->Session->write('cate_id',$cate_id);
				$this->sub_cats($cate_id);
				$all_pro = $this->Session->read('all_pr_count');
				if(!Empty($all_pro)){
					foreach ($all_pro as $pr_count){
						$pro_cntArr[$cate_id] = $pr_count;
					}
				} else {
					$pro_cntArr[$cate_id] = 0;
				}
			}
		}
			
		if(!empty($pro_cntArr)){
			arsort($pro_cntArr);
			$i = 0;
			foreach($pro_cntArr as $cat_id => $pro_cnt){
				if(!Empty($all_cate)){
					foreach($all_cate as $cat){
						if($cat['Category']['id'] == $cat_id){
							$proCntArr[$i]['Category'] = $cat['Category'];
							$proCntArr[$i]['Category']['pr_count'] = $pro_cnt;
						}
					}
				}
				$i++;
			}
		}
		$finalArr=$this->Common->adminCategoryBreadcrumb($department_id,$cate_id);
		$this->set('department_id',$department_id);
		$this->set('finalArr',$finalArr);
		$this->set('all_cate',$proCntArr);
	}


	function sub_cats($cate_id = null){
		App::import('Model','Category');
		$this->Category = new Category;
		App::import('Model','ProductCategory');
		$this->ProductCategory = new ProductCategory;
		$all_sub_cate = $this->Category->find('all',array('conditions'=>array('Category.parent_id'=>$cate_id),'fields'=>array('Category.id','Category.cat_name')));
		$prev_cate_id = 0;

		if(!empty($all_sub_cate)){
			
			$count_products = 0;
			foreach($all_sub_cate as $sub_cat){
				$cat_prods_info = $this->ProductCategory->find('all',array('conditions'=>array('ProductCategory.product_id!=""','ProductCategory.category_id'=>$sub_cat['Category']['id']),'fields'=>array('count(id) as count','ProductCategory.category_id')));
				
				$prev_cate_id = $this->Session->read('cate_id');

				if(!empty($prev_cate_id)){
					$all_pr_count = $this->Session->read('all_pr_count');
					if(!Empty($all_pr_count)){
						$count_products = $all_pr_count[$prev_cate_id];
					}
				}
				if(empty($count_products))
					$count_products = $cat_prods_info[0][0]['count'];
				else 
					$count_products = $count_products + $cat_prods_info[0][0]['count'];

				if(!empty($prev_cate_id))
					$all_pr_count[$prev_cate_id] = $count_products;
				else
					$all_pr_count[$cate_id] = $count_products;

				$this->Session->write('all_pr_count',$all_pr_count);
				$this->sub_cats($sub_cat['Category']['id']);

				
			}
		} else {
			$count_products = 0;
			$cat_prods_info = $this->ProductCategory->find('all',array('conditions'=>array('ProductCategory.category_id'=>$cate_id),'fields'=>array('count(id) as count')));
				
			$prev_cate_id = $this->Session->read('cate_id');

			if(!empty($prev_cate_id)){
				$all_pr_count = $this->Session->read('all_pr_count');
				if(!Empty($all_pr_count)){
					$count_products = $all_pr_count[$prev_cate_id];
				}
			}
			if(empty($count_products))
				$count_products = $cat_prods_info[0][0]['count'];
			else 
				$count_products = $count_products + $cat_prods_info[0][0]['count'];

			if(!empty($prev_cate_id))
				$all_pr_count[$prev_cate_id] = $count_products;
			else
				$all_pr_count[$cate_id] = $count_products;

			$this->Session->write('all_pr_count',$all_pr_count);
			//$this->sub_cats($sub_cat['Category']['id']);

			
		}
	}
	
	 /**
	@function:	product_reviewed
	@description:	View all product which is most reviewed 
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	11 Aug 2011
	*/		
	function admin_product_reviewed(){
		
		$this->layout='layout_admin';
		$this->set('title_for_layout','Most Reviewed Product');
		
		/*$sDateTime=$this->data['DepartmentVisit']['start_date'];
		$eDateTime=$this->data['DepartmentVisit']['end_date'];
		if(Empty($sDateTime)){
			$sDateTime=date('Y-m-d', mktime(00,00,00,date('m'),date('d')-30,date('Y')));
			$eDateTime=date('Y-m-d', mktime(23,59,59,date('m'),date('d')+1,date('Y')));
		}else{
			$sDateTime=date('Y-m-d',strtotime($sDateTime));
			$eDateTime=date('Y-m-d',strtotime($eDateTime));
			$sDateTime=$sDateTime.' 00:00:00';
			$eDateTime=$eDateTime.' 23:59:59';
		}*/
				
		App::import('Model' , 'Review');
		$this->Review = new Review();
				
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_provisit_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			//'conditions'=>array(''),
			'fields' => array('count(Review.id) as total_review','Review.product_id','Product.product_name','Product.id','Product.quick_code'),
			'order'=>array('total_review DESC'),
			'group'=>array('Review.product_id')
			);
		$this->Review->expects(array('Product'));
		$ProductReviewed = $this->paginate('Review');
		//pr($ProductReviewed);
		/*$this->set('sDateTime',date('d-F-Y',strtotime($sDateTime)));
		$this->set('eDateTime',date('d-F-Y',strtotime($eDateTime)));*/
		$this->set('ProductReviewed' , $ProductReviewed);
		
	}
	
	
	 /**
	@function:	product_question
	@description:	View all product which is most Qusetion / Answers 
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	11 Aug 2011
	*/		
	function admin_product_question(){
		
		
		if(empty($this->data)){
			if(isset($this->params['named']['keyword'])){
				$this->data['ProductQuestion']['productFor']=$this->params['named']['keyword'];
				$this->data['ProductQuestion']['productRecord']='';
			}
		}
		
		
		if(Empty($this->data)){
			$productFor='question';
			$productRecord='';
		}else{
			$productFor=$this->data['ProductQuestion']['productFor'];
			$productRecord=$this->data['ProductQuestion']['productRecord'];
		}
		
		$this->layout='layout_admin';
		$this->set('title_for_layout','Most Questions/Answer Product');
		$options['question'] = "By Question";
		$options['answer'] = "By Answer";
		$showArr['100'] = "100";
		$showArr['250'] = "250";
		$showArr['500'] = "500";
		$showArr['1000'] = "1000";
		$showArr['5000'] = "5000";
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		
		App::import('Model' , 'ProductQuestion');
		$this->ProductQuestion = new ProductQuestion();	
						
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_provisit_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			//'conditions'=>array(''),
			'fields' => array('count(ProductQuestion.id) as total_question','ProductQuestion.product_id','Product.product_name'),
			'order'=>array('total_question DESC'),
			'group'=>array('ProductQuestion.product_id')
			);
		$this->ProductQuestion->expects(array('Product'));
		$ProductQuestion = $this->paginate('ProductQuestion');
		$this->set('ProductQuestion' , $ProductQuestion);
		
		App::import('Model' , 'ProductAnswer');
		$this->ProductAnswer = new ProductAnswer();
		$this->paginate = array(
			'limit' => $limit,
			'conditions'=>array('ProductAnswer.product_id=Product.id'),
			'fields' => array('count(ProductAnswer.id) as total_answer','ProductAnswer.product_id','Product.product_name'),
			'order'=>array('total_answer DESC'),
			'group'=>array('ProductAnswer.product_id')
			);
		$this->ProductAnswer->expects(array('Product'));
		$ProductAnswer = $this->paginate('ProductAnswer');
		//pr($ProductAnswer);
		$this->set('ProductAnswer' , $ProductAnswer);
		$this->set('productFor',$productFor);
		
	}
	
	
	 /**
	@function:	admin_seller_ratings
	@description:	Rating by Best Sellers 
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	11 Aug 2011
	*/		
	function admin_seller_ratings(){
		
		$this->layout='layout_admin';
		$this->set('title_for_layout','Best Seller Ratings');
		
		/*$sDateTime=$this->data['DepartmentVisit']['start_date'];
		$eDateTime=$this->data['DepartmentVisit']['end_date'];
		if(Empty($sDateTime)){
			$sDateTime=date('Y-m-d', mktime(00,00,00,date('m'),date('d')-30,date('Y')));
			$eDateTime=date('Y-m-d', mktime(23,59,59,date('m'),date('d')+1,date('Y')));
		}else{
			$sDateTime=date('Y-m-d',strtotime($sDateTime));
			$eDateTime=date('Y-m-d',strtotime($eDateTime));
			$sDateTime=$sDateTime.' 00:00:00';
			$eDateTime=$eDateTime.' 23:59:59';
		}*/
		
		App::import('Model' , 'Feedback');
		$this->Feedback = new Feedback();	
						
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_provisit_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			//'conditions'=>array(''),
			'fields' => array('avg(Feedback.rating) as total_rating','Feedback.seller_id'),
			'order'=>array('total_rating DESC'),
			'group'=>array('Feedback.seller_id')
			);
			$sellerRating = $this->paginate('Feedback');
		
		/*$this->set('sDateTime',date('d-F-Y',strtotime($sDateTime)));
		$this->set('eDateTime',date('d-F-Y',strtotime($eDateTime)));*/
		$this->set('sellerRating' , $sellerRating);
		
	}
	
	
	/**
	@function:	admin_bestselling_departments
	@description:	Bestselling products by department
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	12 Agu 2011
	*/		
	function admin_bestselling_departments(){
		
		$this->layout='layout_admin';
		$this->set('title_for_layout','Bestselling Products By Department');
		
		if(empty($this->data)){			
			if(isset($this->params['named']['keyword'])){
				$arrkeyword = explode('~' , $this->params['named']['keyword']);
				$sDateTime=date('Y-m-d',$arrkeyword[0]);
				$eDateTime=date('Y-m-d',$arrkeyword[1]);
			}else{
				$this->data['Search']['keyword']='';
			}
		}else{
			$sDateTime=$this->data['OrderItem']['start_date'];
			$eDateTime=$this->data['OrderItem']['end_date'];
		}
		
		if(Empty($sDateTime)){
			$sDateTime=date('Y-m-d', mktime(00,00,00,date('m'),date('d')-30,date('Y')));
			$eDateTime=date('Y-m-d', mktime(23,59,59,date('m'),date('d')+1,date('Y')));
		}else{
			$sDateTime=date('Y-m-d',strtotime($sDateTime));
			$eDateTime=date('Y-m-d',strtotime($eDateTime));
			$sDateTime=$sDateTime.' 00:00:00';
			$eDateTime=$eDateTime.' 23:59:59';
		}
		
		
		$criteria = 1;
		App::import('Model' , 'OrderItem');
		$this->OrderItem = new OrderItem();
		$this->OrderItem->expects(array('Order'));
		$criteria .= ' AND (Order.created>= "'.$sDateTime.'" AND Order.created <= "'.$eDateTime.'")';
				
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_provisit_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
						'limit' => $limit,
						//'conditions'=>array(''),
						'fields'=>array('sum(quantity) as total_quantity','OrderItem.product_id','OrderItem.product_name','Product.department_id'),
						'order'=> array( 'total_quantity DESC' ),
						'group'=>array( 'Product.department_id' )
						);
		$this->OrderItem->expects(array('Product'));
		$bestSellingProduct=$this->paginate('OrderItem',$criteria);
		//pr($bestSellingProduct);
		$this->set('sDateTime',date('d-F-Y',strtotime($sDateTime)));
		$this->set('eDateTime',date('d-F-Y',strtotime($eDateTime)));
		$this->set('bestSellingProduct' , $bestSellingProduct);
	}
	
	
	/**
	@function:	admin_preshipped_cancel_rates
	@description:	Rating of seller before shipping the product 
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	23 Aug 2011
	*/		
	function admin_preshipped_cancel_rates(){
		$this->layout='layout_admin';
		$this->set('title_for_layout','Pre-Shipped Cancel Rates');
		
		App::import('Model' , 'CanceledItem');
		$this->CanceledItem = new CanceledItem();	
						
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_provisit_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		
		/* ******************* page limit sction **************** */
						
		$this->paginate = array(
			'limit' => $limit,
			'conditions'=>array('CanceledItem.preshipped_canceled' => 2),
			'fields' => array('sum(CanceledItem.item_price * CanceledItem.quantity+(OrderItem.delivery_cost*CanceledItem.quantity)+(CanceledItem.quantity*OrderItem.giftwrap_cost)) as cancelled_amount','CanceledItem.seller_id'),
			'order'=>array('cancelled_amount DESC'),
			'group'=>array('CanceledItem.seller_id')
			);
			$this->CanceledItem->expects(array('OrderItem'));

			$cancelItemAmount = $this->paginate('CanceledItem');
			foreach($cancelItemAmount as $key => $cancelItemAmount){
				$arrCancle[$key]['seller_id']=$cancelItemAmount['CanceledItem']['seller_id'];
				$CancelledItemsCost=$this->Ordercom->getCancelledItemsCost($cancelItemAmount['CanceledItem']['seller_id']);
				$cc=$CancelledItemsCost[0][0]['cancelled_amount'];
				$TotalSale=$this->Ordercom->getTotalSale($cancelItemAmount['CanceledItem']['seller_id']);
				$ts=$TotalSale[0][0]['total_sale'];
				$arrCancle[$key]['rate']=($cc/$ts*100);
			}
			
		$this->set('arrCancle' , $arrCancle);
		
	}
	
	
	
	/**
	@function:	admin_late_shipped_rates
	@description:	Rating of seller Late shipping the product 
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	24 Aug 2011
	*/		
	function admin_late_shipped_rates(){
		
		$this->layout='layout_admin';
		$this->set('title_for_layout','Late Shipment Rates');
		
		App::import('Model' , 'OrderSeller');
		$this->OrderSeller = new OrderSeller();	
		
			
			
		$this->OrderSeller->expects(array('Order'));
		$lateShipmentRates = $this->OrderSeller->find('all',array('conditions'=>array(
				'OrderSeller.dispatch_date != "" AND OrderSeller.dispatch_date > OrderSeller.expected_dispatch_date'),
				'fields'=>array('OrderSeller.seller_id'),
				'order'=> array( 'OrderSeller.seller_id' ),
				'group'=>array('OrderSeller.seller_id'),
				));
				
			foreach($lateShipmentRates as $key => $lateShipmentRates){
				 $lateShipmentRatesArr[$key]['seller_id'] = $lateShipmentRates['OrderSeller']['seller_id'];
					
				$creteria_numbberOfOrdersHistory = array('OrderSeller.seller_id'=>$lateShipmentRates['OrderSeller']['seller_id'],'Order.deleted'=>'0','Order.payment_status'=>'Y');
				$number_of_orders_history = 0;
				$number_of_orders_history = $this->number_of_orders($creteria_numbberOfOrdersHistory);	
					
					
				$lateship_creteria = 'OrderSeller.seller_id = '.$lateShipmentRates['OrderSeller']['seller_id'].' AND OrderSeller.dispatch_date != "" AND OrderSeller.dispatch_date > OrderSeller.expected_dispatch_date';
					$lateship_orders = $this->number_of_orders($lateship_creteria);
				$lateship_rate = 0;
			if(empty($number_of_orders_history))
				$number_of_orders_history = 1;
				
				$lateship_rate = ($lateship_orders/$number_of_orders_history)*100;	
				$lateShipmentRatesArr[$key]['lateship_rate'] = $lateship_rate;
				
			}	
			//pr($lateShipmentRatesArr);
			
		$this->set('lateShipmentRatesArr' , $lateShipmentRatesArr);
		
	}
		
		
	/**
	@function:	admin_refund_rates
	@description:	Rating of seller Refunded product 
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	24 Aug 2011
	*/		
	function admin_refund_rates(){
		//Configure::write('debug',2);	

		$this->layout='layout_admin';
		$this->set('title_for_layout','Refund Rates');
		
		App::import('Model' , 'OrderRefund');
		$this->OrderRefund = new OrderRefund();	
		
		App::import('Model' , 'OrderItem');
		$this->OrderItem = new OrderItem();
		
		$this->OrderRefund->expects(array('Order'));
		$this->OrderItem->expects(array('Order'));
		$creteria_of_refunded = array('Order.deleted' => '0', 'Order.payment_status' => 'Y');
		
		
		$refundedOrder = $this->OrderRefund->find('all',array('conditions' => $creteria_of_refunded, 'fields' => array('SUM(amount) as total_refund' , 'OrderRefund.seller_id'),
				'order'=> array( 'OrderRefund.seller_id' ),
				'group'=>array('OrderRefund.seller_id'),
				));
		foreach($refundedOrder as $key => $refundedOrder){
			$arrRefundedOrder[$key]['seller_id'] = $refundedOrder['OrderRefund']['seller_id'];
			
			
			$order_total = $this->OrderItem->find('all',array('conditions' => array('OrderItem.seller_id' => $refundedOrder['OrderRefund']['seller_id'], 'Order.deleted' => '0', 'Order.payment_status' => 'Y'),'fields'=>array('OrderItem.price','OrderItem.quantity')));

			$total_amount = 0;
			if(!empty($order_total)){
				foreach($order_total as $order_tal){
					$total_amount = $total_amount + $order_tal['OrderItem']['price'] * $order_tal['OrderItem']['quantity'];
				}
			}
			
		$rate_refund_history = 0;
		if(!empty($refundedOrder)){
			if(empty($total_amount))
				$total_amount = 1;
			$arrRefundedOrder[$key]['refundedrate'] = ($refundedOrder[0]['total_refund'] / $total_amount) * 100;
		}
		
				
				
}	
		//pr($arrRefundedOrder);
		$this->set('arrRefundedOrder' , $arrRefundedOrder);
		
	}
	
	
	
	
	/**
	@function:	admin_bestselling_category
	@description:	Bestselling products by Category
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	16 Agu 2011
	*/		
	function admin_bestselling_category(){
		
		$this->layout='layout_admin';
		$this->set('title_for_layout','Bestselling Products By Category');
		
		if(empty($this->data)){			
			if(isset($this->params['named']['keyword'])){
				$arrkeyword = explode('~' , $this->params['named']['keyword']);
				$sDateTime=date('Y-m-d',$arrkeyword[0]);
				$eDateTime=date('Y-m-d',$arrkeyword[1]);
			}else{
				$this->data['Search']['keyword']='';
			}
		}else{
			$sDateTime=$this->data['OrderItem']['start_date'];
			$eDateTime=$this->data['OrderItem']['end_date'];
		}
		
		if(Empty($sDateTime)){
			$sDateTime=date('Y-m-d', mktime(00,00,00,date('m'),date('d')-30,date('Y')));
			$eDateTime=date('Y-m-d', mktime(23,59,59,date('m'),date('d')+1,date('Y')));
		}else{
			$sDateTime=date('Y-m-d',strtotime($sDateTime));
			$eDateTime=date('Y-m-d',strtotime($eDateTime));
			$sDateTime=$sDateTime.' 00:00:00';
			$eDateTime=$eDateTime.' 23:59:59';
		}
		
		
		$criteria = 1;
		App::import('Model' , 'OrderItem');
		$this->OrderItem = new OrderItem();
		$this->OrderItem->expects(array('Order'));
		$criteria .= ' AND (Order.created>= "'.$sDateTime.'" AND Order.created <= "'.$eDateTime.'")';
				
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_provisit_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
						'limit' => $limit,
						//'conditions'=>array(''),
						'fields'=>array('sum(quantity) as total_quantity','OrderItem.product_id','OrderItem.product_name','ProductCategory.category_id'),
						'order'=> array( 'total_quantity DESC' ),
						'group'=>array( 'ProductCategory.category_id' )
						);
		$this->OrderItem->expects(array('ProductCategory'));
		$bestSellingProduct=$this->paginate('OrderItem',$criteria);
		//pr($bestSellingProduct);
		$this->set('sDateTime',date('d-F-Y',strtotime($sDateTime)));
		$this->set('eDateTime',date('d-F-Y',strtotime($eDateTime)));
		$this->set('bestSellingProduct' , $bestSellingProduct);
	}

/** 
	@function : number_of_orders
	@description : to get total snumber of orders for a given condition
	@Created by : Ramanpreet Pal Kaur
	@params : condition
	@Modify : 21 March, 2011
	@Created Date : 21 March, 2011
	*/
	function number_of_orders($creteria = null){
		$number_of_orders = $this->OrderSeller->find('count',array('conditions'=>$creteria));
		return $number_of_orders;
	}	

	 /**
	@function:	admin_categories_csv
	@description:	Get category Csv for FH  
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	17 Agu 2011
	*/		
	function admin_categories_csv(){
		
		/*$this->layout='layout_admin';
		Configure::write('debug',2);
		App::import('Model' , 'Category');
		$this->Category = new Category();
		$categoryList1[0]['Category']=array('category_id' , 'parent_id' , 'locale' , 'category_name');
		$categoryList2[0]['Category']=array('catalog01' , 'catalog01' , 'en_GB' , 'catalog01');
		
		$categoryList = $this->Category->find('all',
				array(
				'fields'=> array('Category.id' , 'Category.parent_id' , 'Category.cat_name'),	
				));
			 
		$filePath=WWW_ROOT."files/fhcsvs/categories.csv";
		$fp = fopen($filePath, 'w');
		$i=1;
		foreach ($categoryList1 as $fields1) {
			if(!empty($fields1['Category'])){
				foreach($fields1['Category'] as $cat_f){
					$csv_outpu[] = $cat_f;
					if($i<count($fields1['Category'])){
					   $csv_outpu[] = '';
					}
					$i++;
				}
			}
			fputcsv($fp, $csv_outpu,"\t",chr(0));
		}
		
		$k=1;
		foreach ($categoryList2 as $fields2) {
			if(!empty($fields2['Category'])){
				foreach($fields2['Category'] as $cat_head){
					$csv_output[] = $cat_head;
					if($k<count($fields1['Category'])){
						$csv_output[] = '';
					}
					$k++;
				}
			}
			fputcsv($fp, $csv_output,"\t",chr(2));
		}
		
		foreach ($categoryList as $fields) {
			$csv_outpu = '';
			//$csv_outpu = $fields['Category'];
			if(!empty($fields['Category'])){
				$i=0;
				$j=1;
				foreach($fields['Category'] as $arr_ind => $cat_f){
				if($cat_f==0 && is_numeric($cat_f)){
					$csv_outpu[$arr_ind] = 'catalog01';
				}else{
					$csv_outpu[$arr_ind] = trim($cat_f);
				}
				
					if($i==1){
						$csv_outpu[] = '';
						$csv_outpu[] = "en_GB";
					}
					if($j<count($fields['Category'])){
					$csv_outpu[] = '';
					}
					$i++;
					$j++;
				}
			}
			$fileComp=fputcsv($fp, $csv_outpu,"\t",chr(2)); 
		
			//pr($csv_outpu);
		}
		fclose($fp);
		if($fileComp){
			echo "complate";
		}else{
			echo "Not complate";
		}
		exit;*/
		$this->layout='layout_admin';
		//Configure::write('debug',2);
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
		}else{
			echo "Not complete";
		}
		exit;
		
		
	}
	//Categories csv with department id and name
	/*function admin_categories_csv(){
		
		$this->layout='layout_admin';
		Configure::write('debug',2);
		App::import('Model' , 'Category');
		$this->Category = new Category();
		
		App::import('Model' , 'Department');
		$this->Department = new Department();
		$this->Category->expects(array('Department'));
		
		$categoryList1[0]['Category']=array('category_id' , 'parent_id' , 'locale' , 'category_name','department_id','department_name');
		
		$categoryList = $this->Category->find('all',
				array(
				'fields'=> array('Category.id' , 'Category.parent_id' , 'Category.cat_name', 'Category.department_id', 'Department.name'),	
				));
		//pr($categoryList);
		$filePath=WWW_ROOT."files/fhcsvs/categories.csv";
		$fp = fopen($filePath, 'w');
		$i=1;
		foreach ($categoryList1 as $fields1) {
			if(!empty($fields1['Category'])){
				foreach($fields1['Category'] as $cat_f){
					$csv_outpu[] = $cat_f;
					if($i<count($fields1['Category'])){
						$csv_outpu[] = '';
					}
					$i++;
				}
			}
			fputcsv($fp, $csv_outpu,"\t"); 
		}
		
		foreach ($categoryList as $fields) {
			$csv_outpu = '';
			//$csv_outpu = $fields['Category'];
			if(!empty($fields['Category'])){
				$i=0;
				$j=1;
				foreach($fields['Category'] as $arr_ind => $cat_f){
				if($cat_f==0 && is_numeric($cat_f)){
					$csv_outpu[$arr_ind] = 'catalog01';
				}else{
					$csv_outpu[$arr_ind] = $cat_f;
				}
				
					if($i==1){
						$csv_outpu[] = '';
						$csv_outpu[] = "en_GB";
						
					}
					if($j<count($fields['Category'])){
					$csv_outpu[] = '';
					}
					$i++;
					$j++;
				}				
				foreach($fields['Department'] as $arr_ind => $cat_f){
					$csv_outpu[] = '';
					$csv_outpu[$arr_ind] = $cat_f;
				}
			}
			
			$fileComp=fputcsv($fp, $csv_outpu,"\t",chr(0)); 
		
			//pr($csv_outpu);
		}
		fclose($fp);
		if($fileComp){
			echo "complate";
		}else{
			echo "Not complate";
		}
		exit;
		
		
	}*/

	 /**
	@function:	admin_product_csv
	@description:	Get Products with categories Csv for FH
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	17 Agu 2011
	*/		
	function admin_product_csv(){
		/*Configure::write('debug',2);
		$this->layout='layout_admin';
		App::import('Model' , 'ProductCategory');
		$this->ProductCategory = new ProductCategory();
		$this->ProductCategory->expects(array('Product'));
		$productList = $this->ProductCategory->find('all',
				array(
				'conditions'=>array('Product.status'=>'1'),
				'fields'=>array('Product.quick_code','group_concat(ProductCategory.category_id SEPARATOR " ") AS category_id'),
				'order' => array('Product.quick_code DESC'),
				'group' => array('Product.quick_code'),
				//'limit' => 200,
				));
		//pr($productList);
		$categoryList1[0]['Product']=array('product_id' , 'locale' , 'category_ids');
		$filePath=WWW_ROOT."files/fhcsvs/products.csv";
		$fp = fopen($filePath, 'w');
		foreach ($categoryList1 as $fields1) {
			$i=1;
			if(!empty($fields1['Product'])){
				foreach($fields1['Product'] as $cat_f){
					$csv_outpu[] = $cat_f;
					if($i<count($fields1['Product'])){
						$csv_outpu[] = '';
					}
					$i++;
				}
			}
			fputcsv($fp, $csv_outpu,"\t");
		}
			
		foreach ($productList as $fields) {
			$csv_output = '';
			if(!empty($fields['Product'])){
				$i=0;
				foreach($fields['Product'] as $arr_ind => $cat_f){
				$csv_output[$arr_ind] = $cat_f;
					if($i==0){
						$csv_output[] = '';
						$csv_output[] = "en_GB";
						
					}
					$csv_output[] = '';
					$i++;
				}
				
				foreach($fields['0'] as $arr_ind_pro => $pro_cat){
					$csv_output[$arr_ind_pro] = $pro_cat;
				}
			}
			//pr($csv_output);
			$fileComp=fputcsv($fp, $csv_output,"\t",chr(0));
		}
		fclose($fp);
		if($fileComp){
			echo "complate";
		}else{
			echo "Not complate";
		}*/		
		
		Configure::write('debug',2);
		$this->layout='layout_admin';
		App::import('Model' , 'ProductCategory');
		$this->ProductCategory = new ProductCategory();
		$this->ProductCategory->expects(array('Product'));
		$productList = $this->ProductCategory->find('all',
				array(
				'conditions'=>array('Product.status'=>'1'),
				'fields'=>array('Product.quick_code','group_concat(ProductCategory.category_id SEPARATOR " ") AS category_id'),
				'order' => array('Product.quick_code DESC'),
				'group' => array('Product.quick_code'),
				//'limit' => 200,
				));
		
		$categoryList1[0]['Product']=array('product_id' , 'locale' , 'category_ids');
		$filePath=WWW_ROOT."files/fhcsvs/products.csv";
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
					for($i=0;$i<count($fields);$i++){
						$Content1 .= $fields['Product']['quick_code']."\t\t";
						$Content1 .= "en_GB"."\t\t";
						$Content1 .= $fields[0]['category_id'];
						$Content1 .= "\n";
					}
				}
			}
		$wholeContent=$Content.$Content1;
		$fileComp=fwrite($filePath, $wholeContent);
		fclose($filePath);
		if($fileComp){
			echo "complete";
		}else{
			echo "Not complete";
		}
		exit;
		
		
		
		
	}
	
	
	 /**
	@function:	admin_custom_attributes_values_csv
	@description:	Get Products with categories Csv for FH
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	25 Agu 2011
	*/
	
	/*function admin_custom_attribute(){
		//ini_set('memory_limit', '9999M');
		//set_time_limit(0);
		//phpinfo();
		
		Configure::write('debug',2);
		$this->layout='ajax';
		
		App::import('Model','CustomAttribute');
		$this->CustomAttribute = new CustomAttribute();
			
		$productList=$this->CustomAttribute->find('all',
				array(
				//'fields'=>array('CustomAttribute.status'),
				'conditions'=>array('CustomAttribute.status'=>'1'),
				//'order' => array('CustomAttribute.id Desc'),
				'limit' => 3,
				));
				
		for($i=0;$i<count($productList); $i++)
		{
			
			//pr($productList);
			$arrMerge[$i] =$productList[$i]['CustomAttribute'];
			$arrMergeKey[$i] = array_keys($arrMerge[$i]);
			for($j=0;$j<=count($arrMerge[$i]);$j++)
			{
				if($j<58){
				$newArr[$i][$j][0] = $arrMerge[$i][$arrMergeKey[0][1]];
				$newArr[$i][$j][1] = "";
				$newArr[$i][$j][2] = "en_GB";
				$newArr[$i][$j][3] = "";
				$newArr[$i][$j][4] = $arrMergeKey[0][$j+2];
				$newArr[$i][$j][5] = "";
				$newArr[$i][$j][6] = $arrMerge[$i][$arrMergeKey[0][$j+2]];
				}
				
			}
			
			
		}
		
		
		$productList1[0]['product']=array('product_id' , 'locale' , 'attribute_id','attribute_value_id');
		$filePath=WWW_ROOT."files/fhcsvs/attributes_values_".date("Ymd").".csv";
		$fp = fopen($filePath, 'w');
			
		foreach ($productList1 as $fields1) {
			$i=0;
			if(!empty($fields1['product'])){
				
				foreach($fields1['product'] as $cat_f){
					$csv_output_print[] = $cat_f;
					$csv_output_print[] = '';
				}
				$i++;
			}
			
			fputcsv($fp, $csv_output_print);
		}
		
		foreach ($newArr as $fields) {
			$csv_output = '';
			if(!empty($fields)){
				$i=0;
				foreach($fields as $arr_ind => $cat_f){
				$csv_output = str_replace (" ", "_", $cat_f);
					foreach($csv_output as $arr_ind_print => $product_print){
						$csv_output_print[$arr_ind_print] = $product_print;
					}					
					$fileComp=fputcsv($fp, $csv_output_print,"\t");
					
				}
				
			}
			
		}		
		fclose($fp);
		if($fileComp){
			echo "complate";
		}else{
			echo "Not complate";
		}
		
	}*/
	
	
	 /**
	@function:	admin_variants_csv
	@description:	Get Variants Csv for FH  
	@params:	
	@Created by: 	Nakul
	@Modify:	13 oct 2011
	@Created Date:	7 Sep 2011
	*/		
	function admin_variants_csv(){	
		Configure::write('debug', 2);
		$this->layout='ajax';
			
		App::import('Model' , 'ProductSeller');
		$this->ProductSeller = new ProductSeller();
		$this->ProductSeller->expects(array('Product'));
		
		$productList1[0]['Product']=array('variant_id' , 'product_id' , 'locale');
		$productList=$this->ProductSeller->find('all',
				array(
				'fields'=>array('Product.quick_code','Product.id' , 'ProductSeller.seller_id','ProductSeller.condition_id'),
				//'conditions'=>array('Product.status'=>'1'),
				'order' => array('ProductSeller.id Desc'),
				//'limit' => 30,
				));
		//pr($productList);
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
		if(!empty($productList)){
			foreach ($productList as $fields) {
			$csv_output = '';
					$csv_output[] = $fields['Product']['quick_code'].'_'.$fields['ProductSeller']['seller_id'].'_'.$fields['ProductSeller']['condition_id'];
					$csv_output[] = '';
					$csv_output[] = $fields['Product']['quick_code'];
					$csv_output[] = '';
					$csv_output[] = "en_GB";
				
			$fileComp=fputcsv($fp, $csv_output,"\t");
			}
			
		}
		fclose($fp);
		if($fileComp){
			echo "complate";
		}else{
			echo "Not complate";
		}
		/*Configure::write('debug', 2);
		$this->layout='ajax';
			
		App::import('Model' , 'Product');
		$this->Product = new Product();
		$productList1[0]['Product']=array('variant_id' , 'product_id' , 'locale');
		$productList=$this->Product->find('all',
				array(
				'fields'=>array('Product.quick_code','Product.id'),
				'conditions'=>array('Product.status'=>'1'),
				'order' => array('Product.id Desc'),
				//'limit' => 3,
				));
		//pr($productList);
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
		if(!empty($productList)){
			foreach ($productList as $fields) {
			$csv_output = '';
					$csv_output[] = $fields['Product']['quick_code'].'_'.$fields['Product']['quick_code'].'_'.$fields['Product']['id'];
					$csv_output[] = '';
					$csv_output[] = $fields['Product']['quick_code'];
					$csv_output[] = '';
					$csv_output[] = "en_GB";
				
			$fileComp=fputcsv($fp, $csv_output,"\t"); 
			}
		}
		
		fclose($fp);
		if($fileComp){
			echo "complate";
		}else{
			echo "Not complate";
		}*/
		
	}
	
	
	 /**
	@function:	admin_variant_attributes_csv
	@description:	Get Variants values Csv for FH  
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	8 Sep 2011
	*/		
	/*function admin_variant_attributes_csv(){
		//ini_set('memory_limit', '9999M');
		//set_time_limit(0);
		Configure::write('debug', 2);
		$this->layout='ajax';
			
		App::import('Model' , 'VariantAttribute');
		$this->VariantAttribute = new VariantAttribute();
		
		$variantAttributes=$this->VariantAttribute->find('all',
				array(
				//'fields'=>array('ProductSeller.product_id'),
				'conditions'=>array('VariantAttribute.listing_status'=>'1'),
				'order' => array('VariantAttribute.product_id Desc'),
				'limit' => 3,
				));
		//pr($variantAttributes);
		
		for($i=0;count($variantAttributes)>$i;$i++){
			$arrvariant[$i]=$variantAttributes[$i]['VariantAttribute'];
			$arrvariantKey[$i]=array_keys($arrvariant[$i]);
				for($j=0;count($arrvariant[$i])>$j;$j++){
					if($j<14){
					$arrvariantPrint[$i][$j][0]=$arrvariant[$i][$arrvariantKey[$i][1]].'_'.$arrvariant[$i][$arrvariantKey[$i][1]].'_'.$arrvariant[$i][$arrvariantKey[$i][0]];
					$arrvariantPrint[$i][$j][1]="";
					$arrvariantPrint[$i][$j][2]="en_GB";
					$arrvariantPrint[$i][$j][3]="";
					$arrvariantPrint[$i][$j][4]=$arrvariantKey[0][$j+2];
					$arrvariantPrint[$i][$j][5]="";
					$arrvariantPrint[$i][$j][6]=strtolower(str_replace(" ","_",$arrvariant[$i][$arrvariantKey[0][$j+2]]));
					$arrvariantPrint[$i][$j][7]="";
					$arrvariantPrint[$i][$j][8]=$arrvariant[$i][$arrvariantKey[0][$j+2]];
					}
			}
		}
		//pr($arrvariantPrint);
		
		
		$productList1[0]['product']=array('product_id' , 'locale' , 'attribute_id' , 'attribute_value_id' , 'attribute_value');
		$filePath=WWW_ROOT."files/fhcsvs/custom_variant_attributes123.csv";
		$fp = fopen($filePath, 'w+');
			
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
						
		foreach ($arrvariantPrint as $fields) {
			$csv_output = '';
			if(!empty($fields)){
				$i=0;
				foreach($fields as $arr_ind => $cat_f){
					foreach($cat_f as $arr_ind_print => $product_print){
						$csv_output_print[$arr_ind_print] = $product_print;
					}
					
					$fileComp=fputcsv($fp, $csv_output_print,"\t");
					
				}
				
			}
			
		}		
		fclose($fp);
		if($fileComp){
			echo "complate";
		}else{
			echo "Not complate";
		}	
		
	}*/
	
	
	
		
	 /**
	@function:	admin_custom_attributes_meta_csv
	@description:	Get Custom attributes meta csv for FH 
	@params:	
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	8 Sep 2011
	*/		
	function admin_custom_attributes_meta_csv(){
		Configure::write('debug', 2);
		$this->layout='ajax';
			
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
				$customAttributeMeta[$i][2]=$type[0];
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
		}else{
			echo "Not complate";
		}
		
	}
} ######### Classs Ends Here -----------------------
?>