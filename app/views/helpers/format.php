<?php 
class FormatHelper extends Helper
{	
	
	
	//add html entities for string going to print
	function html_entities($string){
		return htmlentities($string,ENT_QUOTES);
	}
	
	/*
	 show offerIntervalTime
	 measure time difference between current time and offer time in FORMAT ()
	 //10Days: 14 hours 37 minutes 21 seconds
	*/
	function offerIntervalTime($offerDate){
		
		$date1 = $offerDate;
		$date2 = strtotime(date('Y-m-d H:i:s') );
		$diff  = abs($date2 - $date1);
		$time_remains = abs(172800 - $diff);
		
		$years   = floor($time_remains / (365*60*60*24)); 
		$months  = floor(($time_remains - $years * 365*60*60*24) / (30*60*60*24)); 
		$days    = floor(($time_remains - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$hours   = floor(($time_remains - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
		$minuts  = floor(($time_remains - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
		$seconds = floor(($time_remains - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60));
		
		$timeIntercvalStr = '';
		if(!empty($months) ){
			$timeIntercvalStr .= $months." Months: ";
		}
		
		if(!empty($days) ){
			$timeIntercvalStr .= $days." Days: ";
		}
		if(!empty($hours) ){
			$timeIntercvalStr .= $hours." hours ";
		}
		return $timeIntercvalStr .=  $minuts. " minutes ". $seconds." seconds ";
		
		
		/*
		$years   = floor($diff / (365*60*60*24)); 
		$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
		$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
		$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
		$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60));
		
		$timeIntercvalStr = '';
		if(!empty($months) ){
			$timeIntercvalStr .= $months." Months: ";
		}
		
		if(!empty($days) ){
			$timeIntercvalStr .= $days." Days: ";
		}
		if(!empty($hours) ){
			$timeIntercvalStr .= $hours." hours ";
		}
		return $timeIntercvalStr .=  $minuts. " minuts ". $seconds." seconds ";
		*/
	
	}
	
		
	/*
	 show date format in 12 June 2010 14:56pm format */
	function offerStatusChangeTime($date){
		
		if(!empty($date) && $date !== '0000-00-00 00:00:00'){
			return date('j M Y g:ia' ,strtotime($date));
		}else{
			return 'N/A';
		}
	}
	
	function offerStatusChangeTimeMobile($date){
		
		if(!empty($date) && $date !== '0000-00-00 00:00:00'){
			return date('j F Y g:ia' ,strtotime($date));
		}else{
			return 'N/A';
		}
	}
	function offerStatusChangeTimeMobileR($date){
		
		if(!empty($date) && $date !== '0000-00-00 00:00:00'){
			return date('j F Y' ,strtotime($date));
		}else{
			return 'N/A';
		}
	}
	
	//show date format
	function date_format($date){
		
		if(!empty($date) && $date !== '0000-00-00 00:00:00'){
			return date(DATE_FORMAT ,strtotime($date));
		}else{
			return 'N/A';
		}
	}
	//show date format
	function date_time_format($date){
		
		if(!empty($date) && $date !== '0000-00-00 00:00:00'){
			return date(Configure::read('DATE_TIME_FORMAT'),strtotime($date));
		}else{
			return 'N/A';
		}
	}
/** 
	@function:		money
	@description:		change the money format
	@params:		NULL
	@Created by: 		
	@Modify:		NULL
	@Created Date:		
	*/	
	function money($amount=0.0,$decimal=0){
		$amt=explode('.',$amount);	
		$length=strlen(@$amt[1]);	
		if($length>2)
			$decimal=2;
		if(empty($amt[1])){
			if(empty($decimal))
				return number_format($amount,0);
			else
				return number_format($amount,$decimal);
		}
		else{
			if(empty($decimal))
				return number_format($amount,0);
			else
				return number_format($amount,$decimal);
		}
		
	}

	/** 
	@function:		percentage
	@description:		change the money format
	@params:		NULL
	@Created by: 		
	@Modify:		NULL
	@Created Date:		
	*/	
	function percentage($obtained=0.0,$total=0.0,$decimal_points = 2){
		$percentage =0.00;
		if($total > 0){
			$percentage = ($obtained/$total)*100;
		}
		$return_per = 0;
// 		$decimal = 2;
		if($decimal_points == 0)
			$percentage = round($percentage);
		$return_per =  number_format($percentage,$decimal_points);
		return $return_per;
	}
/** 
	@function:		formatString
	@description:		display the string
	@params:		NULL
	@Created by: 		
	@Modify:		NULL
	@Created Date:		
	*/	
	function formatString($string = ' ',$length = 10, $del = '...'){

		$string = trim($string);
		
		if(strlen($string) > $length ){
			$total_length = strlen($string);
			$total_length = $length - strlen($del);
			$nstring =  strrev(strstr(strrev(substr(htmlspecialchars_decode($string , ENT_QUOTES), 0,$total_length)), ' '));
			$nstring .= $del;
			return $nstring;
		}else{
			return $string;
		}
		/*if($del==-1)
			$del="&nbsp;";
		return (!empty($string)?(strlen($string)>$length?substr($string,0,$length).'...':$string):$del);
		 // */
	
	}
	
	
    
	
	/** 
	@function:		custom_image_dimentions
	@description:		function to get the best dimension for a image 
	*/
	
	function custom_image_dimentions($image_path,$max_width,$max_height)	{

		if(!file_exists($image_path))
			return array('width'=>$max_width,'height'=>$max_height);
		
		$size = @getimagesize($image_path);
		$width = $size[0];
		$height = $size[1];
	
		$x_ratio = $max_width / $width;
		$y_ratio = $max_height / $height;
	
		if( ($width <= $max_width) && ($height <= $max_height) )
		{
		   $tn_width = $width;
		   $tn_height = $height;
		}
		elseif (($x_ratio * $height) < $max_height)
		{
		   $tn_height = ceil($x_ratio * $height);
		   $tn_width = $max_width;
		}
		else
		{
		   $tn_width = ceil($y_ratio * $width);
		   $tn_height = $max_height;
		}
		return array('width'=>$tn_width,'height'=>$tn_height);
	}


	function estimatedDeliveryDayDate($pro_id = null,$seller_id=null,$condition_id=null){
// 		date_default_timezone_set('Europe/London');
// 		$current_date =  date('Y-m-d H:i:s'); H:i:s

		$dType = 'S';
		$delivery_days = 5;
		$current_date = strtotime(gmdate('Y-m-d'));
		$current_hr = gmdate('H');
		$current_min = gmdate('i');
		$fix_hr = ESTIMATED_DELIVERY_TIME;
		$fix_mins = 0;
		if($current_hr == $fix_hr){
			if($current_min > $fix_mins){
				$current_hr = $current_hr + 1;
			}
		}
		
		$orderDay = date('l', strtotime($current_date));
		$proseller_info = array();

		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller;
		App::import('Model','Setting');
		$this->Setting = new Setting;
		$to_country = $this->Setting->find('first',array('fields'=>array('Setting.website_home_location')));

		if(!empty($seller_id) && !empty($condition_id)){
			$proseller_info = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.product_id'=>$pro_id,'ProductSeller.seller_id'=>$seller_id,'ProductSeller.condition_id'=>$condition_id),'fields'=>array('ProductSeller.dispatch_country','ProductSeller.express_delivery')));
		} else{
			App::import('Model','Product');
			$this->Product = new Product;
			$pro_info = $this->Product->find('first',array('conditions'=>array('Product.id'=>$pro_id),'fields'=>array('Product.id','Product.minimum_price_value','Product.minimum_price_seller','Product.new_condition_id','Product.minimum_price_used','Product.minimum_price_used_seller','Product.used_condition_id')));

			if(!empty($pro_info)){
				if(!empty($pro_info['Product']['minimum_price_seller'])){
					//$proseller_info = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.product_id'=>$pro_id,'ProductSeller.seller_id'=>$pro_info['Product']['minimum_price_seller'],'ProductSeller.condition_id'=>$pro_info['Product']['new_condition_id']),'fields'=>array('ProductSeller.dispatch_country','ProductSeller.express_delivery')));
					$proseller_info = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.product_id'=>$pro_id,'ProductSeller.seller_id'=>$pro_info['Product']['minimum_price_seller']/*,'ProductSeller.condition_id'=>$pro_info['Product']['new_condition_id']*/),'fields'=>array('ProductSeller.dispatch_country','ProductSeller.express_delivery')));
				} else{
					//$proseller_info = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.product_id'=>$pro_id,'ProductSeller.seller_id'=>$pro_info['Product']['minimum_price_used_seller'],'ProductSeller.condition_id'=>$pro_info['Product']['used_condition_id']),'fields'=>array('ProductSeller.dispatch_country','ProductSeller.express_delivery')));
					$proseller_info = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.product_id'=>$pro_id,'ProductSeller.seller_id'=>$pro_info['Product']['minimum_price_used_seller']/*,'ProductSeller.condition_id'=>$pro_info['Product']['used_condition_id']*/),'fields'=>array('ProductSeller.dispatch_country','ProductSeller.express_delivery')));
				}
			}

		}

		if(!empty($proseller_info['ProductSeller']['dispatch_country']))
			$days_arr = $this->getRequiredShippingDays($proseller_info['ProductSeller']['dispatch_country'],$to_country['Setting']['website_home_location']);
		else
			$days_arr = $this->getRequiredShippingDays($to_country['Setting']['website_home_location'],$to_country['Setting']['website_home_location']);


		if(!empty($proseller_info['ProductSeller']['express_delivery'])){
			$dType = 'E';
		}
		if($dType == 'S'){
			$delivery_days = $days_arr['DeliveryDestination']['sd_delivery'];
		} else{
			$delivery_days = $days_arr['DeliveryDestination']['ex_delivery'];
		}
		if($current_hr > $fix_hr){
			$delivery_days = $delivery_days+1;
		}/*
return 1;*/
		$delivery_date = $this->getFinalDeliveryDate($delivery_days);
		$deliver_date = date('l, M jS', strtotime($delivery_date));
		return $deliver_date;
	}
	

	function remainingTime(){
		$current_date = strtotime(gmdate('Y-m-d'));
		$current_hr = gmdate('H');
		$current_min = gmdate('i');

		$fix_hr = 13;
		$fix_mins = 0;

		if($current_hr < $fix_hr){
			$diff = ($fix_hr*60+$fix_mins) - ($current_hr*60 + $current_min);
			$minutes = $diff%60;
			$hrs = (int)($diff/60);
		} else if($current_hr == $fix_hr){
			if($current_min < $fix_mins){
				$hrs = 0;
				$minutes = $fix_mins-$current_min;
			} elseif($current_min == $fix_mins) {
				$hrs = 23;
				$minutes = 59;
			} else {
				$hrs = 23;
				$minutes = 59-$current_min;
			}
		} else{
			$diff = ((24+$fix_hr)*60+$fix_mins) - ($current_hr*60 + $current_min);
			$minutes = $diff%60;
			$hrs = (int)($diff/60);
		}

		if($hrs <= 9){
			//$hrs = '0'.$hrs;
			$hrs = $hrs;
		}
		if($minutes <= 9){
			//$minutes = '0'.$minutes;
			$minutes = $minutes;
		}
		$remaining_time = $hrs.' hours : '.$minutes.' minutes';
		return $remaining_time;
	}


	# @ function to get shipping estimations
	function getRequiredShippingDays($fromCountryId, $toCountryId  ){
		
		if( empty($fromCountryId) || empty($fromCountryId)  ){
			return '';
		}
		App::import('Model', 'DeliveryDestination');
		$this->DeliveryDestination = new DeliveryDestination();
		
		$dataArr = $this->DeliveryDestination->find('first',array(
				'conditions' => array('DeliveryDestination.country_from' => $fromCountryId, 'DeliveryDestination.country_to' => $toCountryId ),
				));
		return 	$dataArr;	
	}



	function getFinalDeliveryDate($delivery_days){
		if(empty($delivery_days) ){
			return '';
		}
		$current_date = strtotime(date('Y-m-d') );
		$orderDay = date('l', strtotime($current_date));
		
		switch(strtolower($orderDay)):
			case'sunday':
				$days_interval = $delivery_days+1;
				break;
			case'saturday':
				$days_interval = $delivery_days+2;
				break;
			default:
				$days_interval = $delivery_days;
			break;
		endswitch;
		
		$estimated_del_date = date('Y-m-d', mktime(0,0,0,date('m',$current_date),date('d',$current_date)+$days_interval,date('Y',$current_date)));
		$deliveryDay = date('l', strtotime($estimated_del_date));
		
		#  get additional days required to deliver the product
			switch(strtolower($deliveryDay)):
				case'sunday':
					$additional_day = 1;
					break;
				case'saturday':
					$additional_day = 2;
					break;
				default:
					$additional_day = 0;
				break;
			endswitch;
		
		# if sat sunday  comes on delivery date	
		if(!empty($additional_day) ){ 
			$estimated_del_date = strtotime($estimated_del_date) ;
			$final_delivery_date = date('Y-m-d', mktime(0,0,0,date('m',$estimated_del_date),date('d',$estimated_del_date)+$additional_day,date('Y',$estimated_del_date)));
		}else{
			$final_delivery_date = $estimated_del_date;
		}
		return $final_delivery_date;
	}
	//For Money Format in UK Nakul Kumar on 19-SEP-2012
 	/** 
	@function:		money
	@description:		Money format on Category right hand side bar
	@params:		NULL
	@Created by: 		NAkul Kumar
	@Modify:		NULL
	@Created Date:		19-09-2012
	*/	
	function moneyFormat($amount){
		//setlocale(LC_MONETARY, 'en_GB');
		$fmt = '%i';
		$money = money_format($fmt, $amount) . "\n";
		return $money;
	}
	
}?>