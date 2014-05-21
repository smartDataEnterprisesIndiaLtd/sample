<?php
/**
	* Homes Controller class
	* PHP versions 5.1.4
	* @date 
	* @Purpose:This controller handles all the functionalities regarding dashboard of admin.
	* @filesource
	* @author     Ramanpreet Pal Kaur
	* @revision
	* @copyright  Copyright � 2009 smartData
	* @version 0.0.1 
**/
App::import('Sanitize');
class HomesController extends AppController
{
    var $name =  "Homes";
    /**
	* Specifies helpers classes used in the view pages
	* @access public
    */
    var $helpers =  array('Html', 'Form', 'Javascript','Session','Validation','Format','Ajax','Common');
    /**
	* Specifies components classes used
	* @access public
    */
    var $components =  array('RequestHandler','Email','File', 'Common');
    var $paginate =  array();
    var $uses =  array('Home');
	
	 /**
	* @Date: Nov 12, 2011
	* @Method : beforeFilter
	* Created By: Nakul Kumar
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
	    
	    $cont = $this->params['controller'];
	    $acti = $this->params['action'];
    
	    if(@$_REQUEST['fullsite']){
		    $fullSite = $_REQUEST['fullsite'];
		    $this->Session->write('fullSite',$fullSite);
		    $fullSiteNew = $this->Session->read('fullSite');
	    }
	    if($cont == 'homes' && $acti =='index'){
		$check =SITE_URL."css/slider1/theme-metallic.css";
		if(@$fullSiteNew!='go'  && (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=$check)){
		    $this->Session->delete('fullSite');
		}
	    }
	    $this->detectMobileBrowser();
		
		
		//For Mobile dection function
		
		//For Mobile dection function
		/*if(@$_REQUEST['fullsite']){
			$fullSite = $_REQUEST['fullsite'];
			$this->Session->write('fullSite',$fullSite);
			$fullSite = $this->Session->read('fullSite');
		}
		if(@$fullSite!='go'){
			$this->Session->delete('fullSite');
			$this->detectMobileBrowser();
		}*/
	}
	
	/** 
	@function : email_friend
	@description : to send this page link to your friend
	@Created by : Ramanpreet Pal Kaur
	@params : 	
	@Modify : 
	@Created Date : 21 Jan, 2010
	*/
	function email_friend(){
		
		$this->layout = 'front_popup';
		$success='';
		if(!empty($this->data)) {
		  
			$this->loadModel('Product');
			$this->Product->set($this->data);
			if($this->Product->validates()){
				/** Send email after registration **/
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);
				$this->Email->from = ucwords(strtolower($this->data['Product']['your_name'])).'<'.$this->data['Product']['your_email'].'>';
				$this->Email->replyTo = ucwords(strtolower($this->data['Product']['your_name'])).'<'.$this->data['Product']['your_email'].'>';
				$this->Email->sendAs= 'html';
				$this->Email->subject = 'choiceful.com';
				//$this->Email->subject = 'Welcome to Choiceful';
				
				
				$data = '<table width="100%" cellspacing="2" cellpadding="2" border="0">';
				$data .= '<tr><td>Hello '.ucfirst($this->data['Product']['recipient_name']).'</td></tr>';
				$data .= '<tr><td>Visit the link given below:<br><br><a href="'.SITE_URL.$this->data['Product']['url'].'">'.SITE_URL.$this->data['Product']['url'].'</a></td></tr>';
				if(!empty($this->data['Product']['message'])){
					$data .= '<tr><td>&nbsp;</td></tr>';
					$data .= '<tr><td>'.$this->data['Product']['message'].'</td></tr>';
				}
				
				$data .= 'Successfull Registration';
				$this->set('data',$data);
				$this->Email->to = $this->data['Product']['recipient_email'];
				/******import emailTemplate Model and get template****/
				$this->Email->template='commanEmailTemplate';
				if($this->Email->send()) {
					$this->Session->setFlash('Mail has been sent successfully.');
					$success  = 1;
					$this->set('success',$success);
					
				} else{
					$this->Session->setFlash('An error occurred while sending the email,please try again.','default',array('class'=>'flashError'));
				}
			} else{
			 	$this->set('errors',$this->Product->validationErrors);
			}
		} else{
			
		}
		$this->set('title_for_layout','Email Friend | Choiceful.com ');

	}
	
	
 	/**
	* @Date: Oct 13, 2010
	* @Method : admin_dashboard
	* @Purpose: This function is to show Admin dashboard.
	* Modified By: Ramanpreet Pal Kaur
	* Modified on: 8 Feb, 2010
	* @Param: none
	* @Return: none 
	**/
	function admin_dashboard(){
		$this->checkSessionAdmin();
		$this->set('title_for_layout', 'Dashboard');
		$this->layout = 'layout_admin';
		
		App::import('Model','User');
		$this->User = new User();
		App::import('Model','Seller');
		$this->Seller = new Seller();
		App::import('Model','Visitor');
		$this->Visitor = new Visitor();
		
		App::import('Model','Order');
		$this->Order = new Order();
		App::import('Model','Product');
		$this->Product = new Product();
		
		$current_date = date('Y-m-d');
		$current_month = date('m');
		$current_day = date('d');
		$current_year = date('Y');
		    
		if($current_month == 1){
			$last_month = 12;
			$last_year = $current_year - 1;
		} else{
			$last_month = $current_month - 1;
			$last_year = $current_year;
		}		
		if($last_month < 9){
			$last_month = '0'.$last_month;
		}	
			
		$lastmonth_date = $last_year.'-'.$last_month.'-'.$current_day;
		/*   
		$days_diff = $current_date-$lastmonth_date;
		    
		$all_sales = $this->Order->find('all',array('conditions'=>array('Order.created1 BETWEEN "'.$lastmonth_date.'" AND "'.$current_date.'"','Order.payment_status'=>'Y','Order.deleted'=>'0'),'fields'=>array('Order.created','SUM(Order.order_total_cost) as total_sales','count(id) as total_number'),'group'=>array('date(Order.created)'),'order'=>'Order.created DESC'));
		*/
		
		//Fro shorthing on 29 - 11 - 2012 
		App::import('Model','OrderNumber');
		$this->OrderNumber = new OrderNumber();
		
		$criteria  = "";
		$this->paginate = array(
			'limit' => '30',
			'order' => array(
				'OrderNumber.created' => 'DESC'
				),
			'fields'=> array('OrderNumber.created', 'OrderNumber.total_sales','OrderNumber.total_number')
		);
		$this->set('all_sales',$this->paginate('OrderNumber',$criteria));
		    
		    
		    
		$this->set('from_date',$lastmonth_date);$this->set('to_date',$current_date);
		    
		$total_users = 0;$total_sellers = 0;$visitors = 0;
		/*$current_date = date('Y-m-d H:i:s');
		$current_15_date = date(DATABASE_DATE_FORMAT,strtotime($current_date)-(15*60));
		$visitors = $this->Visitor->find('count',array('conditions'=>array('Visitor.created >= "'.$current_15_date.'"')));*/
		$visitors = $this->Visitor->find('count',array('conditions'=>array('DATE(Visitor.created) = CURDATE()')));
			
		$total_users = $this->User->find('count');
		$total_online_users = $this->User->find('count',array('conditions'=>array('User.online_flag'=>'1')));
			
		$total_products = $this->Product->find('count',array('conditions'=>array('Product.status'=>'1')));
			
		$total_sellers = $this->Seller->find('count');
		$this->set('total_products',$total_products);
		$this->set('total_users',$total_users);
		$this->set('total_sellers',$total_sellers);
		$this->set('total_visitors',$visitors);
	}		
		
	/**
	* @Date: Oct 13, 2010
	* @Method : admin_noaccess
	* @Purpose: This function is used when admin user have no access for a module 
	* @Param: none
	* @Return: none 
	**/
	function admin_noaccess(){
		$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		$this->set('title_for_layout','Unauthorised Admin User');
	}
	/**
	* @Date: Oct 15, 2010
	* @Method : index
	* @Purpose: This function is to show home page.
	* @Param: none
	* @Return: none 
	**/
	function index(){
		if ($this->RequestHandler->isMobile()) {
            	// if device is mobile, change layout to mobile
           		 $this->layout = 'mobile/home';
           		    }else{
			$this->layout = 'home';
		}
		$recomanded_pros = array();
		# get a list of all  advertisement banners/advertisements
		App::import('Model','Advertisement');
		$this->Advertisement = new Advertisement();
		$this->set( 'AdsData', $this->Advertisement->getAdvertisementsList());
		
		// get list of departments for left navigation links
		App::import('Model','Department');
		$this->Department = new Department();
		
		$departments = $this->Department->find('list',array('conditions'=>array('Department.status'=>'1'),'fields'=>array('id','name'),'limit'=>10,'order'=>array('Department.id')));
		$this->set('departments', $departments);
		$this->set('selected_department', '');
		
		/** Manage Title, meta description and meta keywords ***/
		$this->set('title_for_layout','Choiceful.com: Love Choice, Love Choiceful - Choiceful.com Marketplace: Low Prices Every Day');
		$this->set('meta_description','Choiceful.com marketplace buy and sell millions of new and pre-owned products. Low prices and daily deals on electronics, cameras, computers, mobiles, software, books, movies, DVDs, games, home and garden, health and beauty and much more');
		$this->set('meta_keywords','online marketplace, sell online, low prices, electronics, books, DVD, games, movies, software, office supplies, computers, digital entertainment, home, kitchen, garden, health, beauty, choiceful');
		
		
	} // index dunctions end here 

/**
	* @Date: 2Feb , 2011
	* @Method : choiceful_on_mobile
	* @Purpose: This function is to show choiceful_on_mobile page
	* @Param: none
	* @Return: none 
	**/
	function choiceful_on_mobile(){
		$this->layout = 'product';
		App::import('Model','Page');
		$this->Page = new Page();
		$this->data = $this->Page->find('first',array('recursive'=>1,'conditions'=>array('Page.pagecode'=> 'ichoiceful-app')));
		
		if(!empty($this->data['Page'])){
			foreach($this->data['Page'] as $field_index => $info){
				$this->data['Page'][$field_index] = html_entity_decode($info);
				$this->data['Page'][$field_index] = str_replace('&#039;',"'",$this->data['Page'][$field_index]);
				$this->data['Page'][$field_index] = str_replace('\n',"",$this->data['Page'][$field_index]);
			}
		}
		/** Manage Title, meta description and meta keywords ***/
		$this->pageTitle  = $this->data['Page']['meta_title'];
		$this->set('title_for_layout',$this->data['Page']['meta_title']);
		$this->set('meta_description',$this->data['Page']['meta_description']);
		$this->set('meta_keywords',$this->data['Page']['meta_keyword']);
	} // index choiceful_on_mobile


/**
	* @Date: 2Feb 2011
	* @Method : choiceful_on_mobile
	* @Purpose: This function is to show choiceful_on_mobile page
	* @Param: none
	* @Return: none 
	**/
	function international_sites(){
		if ($this->RequestHandler->isMobile()) {
		    $this->layout = 'mobile/home';
		}else{
		    $this->layout = 'product';
		}
		
		// get list of departments for left navigation links
		App::import('Model','Department');
		$this->Department = new Department();
	    	$departments = $this->Department->find('list',array('conditions'=>array('Department.status'=>'1'),'fields'=>array('id','name'),'limit'=>10,'order'=>array('Department.id')));
		$this->set('departments', $departments);
		$this->set('selected_department', '');
		
		$this->set('title_for_layout','Choiceful.com International Stores');
	} 

	/* function for pick of the day products */
	function pick_of_day($product_id = null,$dept_id= null){
		$this->set('product_id',$product_id);
		$this->set('dept_id',$dept_id);

	}
	function setcountry($country_id = null,$country_img= null,$country_name= null)
	{
	    $countryID = '';
	    $countryName ='';
	    $countryImage ='';
	    $countryID  =  $this->Session->read('countryID');
	    $countryName  =  $this->Session->read('countryName');
	    $countryImage  =  $this->Session->read('countryImage');
	    
	    if(!empty($countryName)){
		$this->Session->delete('countryName');
	    }
	     if(!empty($countryImage)){
		$this->Session->delete('countryImage');
	    }
	    
	    
	    
	    if(!empty($countryID)){
		$this->Session->delete('countryID');
		//$this->Session->destroy('countryName');
		//$this->Session->destroy('countryImage');
	    }
	    $this->Session->write('countryID',$country_id);
	    $this->Session->write('countryName',$country_name);
	    $this->Session->write('countryImage',$country_img);
	   exit();
	}
	/** 
	@function	:	add_feedback
	@description	:	
	@params		:	NULL
	@created	:	Nov 12, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function ad_feedback() {
		$this->layout = 'front_popup';
		$user = $this->Session->read('User');
		if(!empty($user)){
			if(!empty($this->data)){
				
				if(!empty($this->data['Product']['comments'])){
				
				$this->data = $this->cleardata($this->data);
				//$this->data = Sanitize::clean($this->data, array('encode' => false));
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
				$template = $this->Common->getEmailTemplate(28);
				$data = $template['EmailTemplate']['description'];
				$this->Email->from = $template['EmailTemplate']['from_email'];
				$this->Email->subject = $template['EmailTemplate']['subject'];
				
				//$quick_code = trim($this->data['Product']['quick_code']);
				$comments   = trim($this->data['Product']['comments']);
				$date_time = date('j M, Y H:i');
				$this->data = Sanitize::clean($this->data);
				$data = str_replace('[QCID]','website', $data);
				$data = str_replace('[DATE_TIME]', $date_time, $data);
				$data = str_replace('[COMMENTS]', $comments, $data);
				$data = str_replace('product', '', $data);
				$this->set('data',$data);
				$this->Email->to = Configure::read('replytoEmail');
				/******import emailTemplate Model and get template****/
				$this->Email->template='commanEmailTemplate';
				if($this->Email->send()){
					$this->Session->setFlash('Feedback has been submitted successfully!');
					echo "<script type=\"text/javascript\">setTimeout('parent.jQuery.fancybox.close()',5000);</script>";
				}else{
					$this->Session->setFlash('Please login first.','default',array('class'=>'flashError'));
				}
				}else{
					$this->set('errors','Please enter comment');
				}
			}
		}else{
			$this->Session->setFlash('Please login before add a question');
			//$this->redirect('/homes/index');
		}
	}
		
}
?>