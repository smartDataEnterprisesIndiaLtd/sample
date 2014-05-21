<?php
/**  @class:		AjaxController 
 @description		specially for ajax purpose
 @Created by: 		
 @Modify:		NULL
 @Created Date:		10- 12, 2010
*/


class TotalajaxController extends AppController{
	var $name = 'Totalajax';
	var $helpers =  array('Html', 'Form','Common', 'Javascript','Session','Validation','Ajax', 'Format');
	var $components =  array('RequestHandler','Email','Common','File','Thumb', 'Ordercom');
	var $paginate 	=  array();
	
	
	// function to get department wise category for create product ste1 page
	function getDepartmentCategory($selected_department = '', $selected_category = null){
		//Add on 27 Oct 2012
		if(empty($selected_department)){
			$selected_department = $this->params['named']['depid'];
		}
		if(empty($selected_category)){
			$selected_category = $this->params['named']['selected_cat'];	
		}
		$selectclassName = $this->params['named']['selectclass'];
		//End on 27 Oct 2012
		
		$this->layout = 'ajax';
		 // import category DB
		App::import('Model','Category');
		$this->Category = new Category();
		if(!empty($selected_department) ){
			$topCategoryArr = $this->Category->find('list',array(
		'conditions' => array('Category.parent_id' => 0 , 'Category.department_id' =>$selected_department, 'Category.status' => 1 ),
		'fields'=>array('Category.id','Category.cat_name'),
		'order'=>array('Category.cat_name')));
		}else{
			$topCategoryArr = '';
		}
		// set the value
		$this->set('topCategoryArray', $topCategoryArr);
		// set selected category id
		$this->set('selected_id', $selected_category);
		$this->set('selectclassName', $selectclassName);
	}
	
	
// function to get department wise category for create product ste1 page
	function add_get_brand_name($brand_name = null){
		$brand_name = str_replace('and','&',$brand_name);
		$this->layout = 'ajax';
		 // import category DB
		App::import('Model','Brand');
		$this->Brand = new Brand();
		
		if(!empty($brand_name) ){
			$this->data['Brand']['name'] = $brand_name;
			# add brand name
			$this->Brand->save($this->data);
			$added_brand_id = $this->Brand->getLastInsertId();
			# set  last inserted id as selected
			$this->set('added_brand_id', $added_brand_id);
		}else{
			$this->set('added_brand_id', null);
			
		}
		$all_brand_array = $this->Common->getbrands();
		// set the value
		$this->set('all_brand_array', $all_brand_array);
	}
	
	
// function to get either texbox or selection box for state depends on country ID
	function DisplayStateBox($countryId, $stateFieldName, $selectedValue = '1' , $selectclassName = '', $textclassName = '',$errorstate = ''){
		// 1selected value 1 for test purpose means balank
		
		$this->layout = 'ajax';
		App::import('Model', 'State');
		$this->State = new State();
		App::import('Model', 'User');
		$this->User = new User();
		$stateArr =  array();
		if( $countryId > 0){
			$stateArr = $this->State->find('list',array(
				'conditions' => array('State.country_id' => $countryId ),
				'fields'=>array('State.state_code','State.name'),
				'order'=>array('State.name')
				));
		}
		$this->set('statesArray', $stateArr);
		$this->set('country_id', $countryId);
		$this->set('stateFieldName', $stateFieldName);
		if( $selectedValue == '1'){ // 1 for blank value
			$this->set('selectedValue', '');
		}else{
			$this->set('selectedValue', $selectedValue);
		}
		$this->set('errors',$errorstate);
		$this->set('selectclassName', $selectclassName);
		$this->set('textclassName', $textclassName);
	}
	
	
	// function to get either texbox or selection box for state depends on country ID
	function DisplayBillingStateBox($countryId, $stateFieldName, $selectedValue = null){
		//stateFieldName;
		$this->layout = 'ajax';
		App::import('Model', 'State');
		$this->State = new State();
		$stateArr =  array();
		if( $countryId > 0){
			$stateArr = $this->State->find('list',array(
				'conditions' => array('State.country_id' => $countryId ),
				'fields'=>array('State.state_code','State.name'),
				'order'=>array('State.name')
				));
		}
		$this->set('statesArray', $stateArr);
		$this->set('country_id', $countryId);
		$this->set('stateFieldName', $stateFieldName);
		$this->set('selectedValue', $selectedValue);
	}
	
	// function to get either texbox or selection box for state depends on country ID
	function DisplayShippingStateBox($countryId, $stateFieldName, $selectedValue = null){
		//stateFieldName;
		$this->layout = 'ajax';
		App::import('Model', 'State');
		$this->State = new State();
		$stateArr =  array();
		if( $countryId > 0){
			$stateArr = $this->State->find('list',array(
				'conditions' => array('State.country_id' => $countryId ),
				'fields'=>array('State.state_code','State.name'),
				'order'=>array('State.name')
				));
		}
		$this->set('statesArray', $stateArr);
		$this->set('country_id', $countryId);
		$this->set('stateFieldName', $stateFieldName);
		$this->set('selectedValue', $selectedValue);
	}
	
	
	
	//unction to get shipping estimations
	function getShippingEstimation($toCountryId = null, $fromCountryId = null, $shipType = null){
		$shippingData = $this->Ordercom->getRequiredShippingDays($fromCountryId,$toCountryId);
		//echo 'kk'; exit;
		
		if(is_array($shippingData) ){ 
			if(strtoupper($shipType)  == 'S' ){
				$estimatedDeliveryDay = $shippingData['DeliveryDestination']['sd_delivery'];
				
			}else{
				$estimatedDeliveryDay = $shippingData['DeliveryDestination']['ex_delivery'];
			}
		}else{
			$estimatedDeliveryDay = '';
		}
		//o $estimatedDeliveryDay ;
		
		if(!empty($estimatedDeliveryDay) ){
			$estimatedDate = $this->Ordercom->getFinalDeliveryDate($estimatedDeliveryDay);
			//commented by nakul on 7 dec 2011 due to getFinalDeliveryDateTime function is not Found in ordercom Components
			//$estimatedDate = $this->Ordercom->getFinalDeliveryDateTime($estimatedDeliveryDay);
			echo date('l jS F Y', strtotime($estimatedDate));
		} else{
			echo 'No Estimate ';
		}
		
		exit;
	}

	//unction to get shipping estimations
	function getShippingEstimationMobile($toCountryId = null, $fromCountryId = null, $shipType = null){
		$shippingData = $this->Ordercom->getRequiredShippingDays($fromCountryId,$toCountryId);
		//echo 'kk'; exit;
		
		if(is_array($shippingData) ){ 
			if(strtoupper($shipType)  == 'S' ){
				$estimatedDeliveryDay = $shippingData['DeliveryDestination']['sd_delivery'];
				
			}else{
				$estimatedDeliveryDay = $shippingData['DeliveryDestination']['ex_delivery'];
			}
		}else{
			$estimatedDeliveryDay = '';
		}
		//o $estimatedDeliveryDay ;
		
		if(!empty($estimatedDeliveryDay) ){
			$estimatedDate = $this->Ordercom->getFinalDeliveryDate($estimatedDeliveryDay);
				//$estimatedDate = $this->Ordercom->getFinalDeliveryDateTime($estimatedDeliveryDay);
			echo date('jS M Y', strtotime($estimatedDate));
		} else{
			echo 'No Estimate ';
		}
		
		exit;
	}

/** 
	@function :	Suggestion Box	
	@description :	show Suggestion send by the suer 	
	@Created by:	Nakul Kumar
	@params
	@Modify:
	@Created Date:
	*/
	function suggestion_user($feedback='',$searchWord=''){
		$this->set('layout',$this->layout);
		$this->set('searchWord', urlencode($searchWord));
		
		/** Send suggestion email **/
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
		table: email_templates
		id: 1
		description: Customer suggestion
		*/
		App::import('Model','UserSuggestion');
		$this->UserSuggestion = new UserSuggestion;
		if(!Empty($this->data)){
			if($this->UserSuggestion->validates()){
				$this->data['UserSuggestion']['suggestion_from'] = 'B';
				
				$this->data = $this->cleardata($this->data);
				//$this->data = Sanitize::clean($this->data, array('encode' => false));
				$this->UserSuggestion->set($this->data);
				
				if($this->UserSuggestion->save($this->data)){
					$this->set('searchWord', $this->data['UserSuggestion']['search_key']);
					$template = $this->Common->getEmailTemplate(31);
					$this->Email->from =  $template['EmailTemplate']['from_email'];
					$this->Email->subject = $template['EmailTemplate']['subject'];
					$data=$template['EmailTemplate']['description'];
					$date=date("F j, Y, g:i a");
					$data=str_replace('[DATE_TIME]',$date,$data);
					$data=str_replace('[MESSAGE_BODY]',$this->data['UserSuggestion']['suggestion'],$data);
					$this->set('data',$data);
					$this->Email->to =$template['EmailTemplate']['from_email'];
					//$this->Email->to ='roi.incentive@gmail.com';
					/******import emailTemplate Model and get template****/
					$this->Email->template='commanEmailTemplate';
					
					$sessionSearchWrd = $this->data['UserSuggestion']['search_key'];
					if($this->Email->send()) {
						$this->Session->write('Box_'.$sessionSearchWrd,'1');
						//$testSession = $this->Session->read('Box_'.$sessionSearchWrd);
						//pr($testSession);
						
						//$this->Session->setFlash('Thank You For Send Suggestion successfully!');
					} else{
						$this->Session->setFlash('An error occurred while sending an email to the email address provided. Please reset your email address.','default',array('class'=>'flashError'));
					}
						
				} else {
					//$this->Session->setFlash('Error occurred on your suggestion saved, please try again!','default',array('class'=>'flashError'));
				}
				$this->set('errors',$this->UserSuggestion->validationErrors);
				$this->viewPath = 'elements/product';
				$this->render('user_suggestion_box');
				
			}
		} elseif(!Empty($feedback)) {
		$template = $this->Common->getEmailTemplate(30);
		$date=date("F j, Y, g:i a");
		$this->Email->from =  $template['EmailTemplate']['from_email'];
		$data=$template['EmailTemplate']['description'];
			if($feedback=='yes'){
				$feedback='';
			}else{
				$feedback='did not';
			}
		$data=str_replace('[YES_NO]',$feedback,$data);
		//$feedbackMessage="After searching user send his/her feedback as <b>".$feedback."</b> regarding <b>".$searchWord."</b> key word.";
		$suggestionArr=array('ip_address'=>$_SERVER['REMOTE_ADDR'],'search_key'=>$searchWord,'suggestion'=>$data);
		if($this->UserSuggestion->save($suggestionArr)){
				
		$data=str_replace('[SEARCH_KEYWORD]',$searchWord,$data);
		$data=str_replace('[DATE_TIME]',$date,$data);
		$this->Email->subject = $template['EmailTemplate']['subject'];
		$this->set('data',$data);
		$this->Email->to =$template['EmailTemplate']['from_email'];
		//$this->Email->to ='roi.incentive@gmail.com';
		/******import emailTemplate Model and get template****/
		$this->Email->template='commanEmailTemplate';
		if($this->Email->send()) {
			$this->Session->write('Feedback_'.$searchWord,'1');
			$this->Session->setFlash('Thanks for your feedback.');

		} else{
			$this->Session->setFlash('An error occurred while sending an email to the email address provided. Please reset your email address.','default',array('class'=>'flashError'));
			
		}
		
		} else {
			$this->Session->setFlash('Error occurred on your feedback saved, please send again!','default',array('class'=>'flashError'));
		}
		
		$this->viewPath = 'elements/product';
		$this->render('user_suggestion');
		}
			
	   }
	
	// function add new color for product
	function add_get_color_name($color_name = null){
		//$brand_name = str_replace('and','&',$brand_name);
		$this->layout = 'ajax';
		 // import Color DB
		$color_name = $color_name;
		App::import('Model','Color');
		$this->Color = new Color();
		if(!empty($color_name) ){
			$this->data['Color']['color_name'] = $color_name;
			# add color name
			//$this->Color->set($this->data);
			$this->Color->save($this->data);
			$added_color_id = $this->Color->getLastInsertId();
			# set  last inserted id as selected
			$this->set('added_color_id', $added_color_id);
		}else{
			$this->set('added_color_id', null);
			
		}
		$all_color_array = $this->Common->getColors();
		// set the value
		$this->set('all_color_array', $all_color_array);
	}
	
	
}
?>