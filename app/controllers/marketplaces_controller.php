<?php
/**  @class:		MarketplacesController 
 @description		 etc.,
 @Created by: 		
 @Modify:		NULL
 @Created Date:		Dec 7, 2010
*/
App::import('Sanitize');
class MarketplacesController extends AppController{
	var $name = 'Marketplaces';
	var $helpers =  array('Html', 'Form','Common', 'Javascript','Session','Validation','Ajax', 'Format');
	var $components =  array('RequestHandler','Email','Common','File','Thumb','Jpgraph','Ordercom');
	var $paginate =  array();
	//var $permission_id = '' ;  // for product module
	
	/**
	* @Date: Dec 08, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	/*function beforeFilter(){
		$this->detectMobileBrowser();
		//check session other for front end user login 
		$includeBeforeFilter = array('upload_listing', 'create_product_step1','create_product_step2','create_product_step3','manage_listing','search_results','search_product');
		if (in_array($this->params['action'],$includeBeforeFilter))
		{
			// check front end user session
			$this->checkSessionFrontUser();
		}
		// seller section validations
		$includeForSeller = array('upload_listing', 'create_product_step1','create_product_step2','create_product_step3','create_listing','review_listing','confirm_listing','manage_listing','sales_report','search_product');
		if (in_array($this->params['action'],$includeForSeller))
		{
			// seller's section validations
			$this->validateSeller();
		}
		
		
	}*/
	
	
	function beforeFilter(){
		$this->detectMobileBrowser();
		//check session other for front end user login 
		//$includeBeforeFilter = array('upload_listing', 'create_product_step1','create_product_step2','create_product_step3','manage_listing','search_results','search_product');
		if (!$this->Session->check('SESSION_ADMIN') || empty($this->params['named']['seller_id'])){
			$includeBeforeFilter = array('upload_listing', 'create_product_step1','create_product_step2','create_product_step3','manage_listing','search_results','search_product','download_listing');
		function upload_frame(){
		$this->layout = null;
	}}else{
			$includeBeforeFilter = array('upload_listing', 'create_product_step1','create_product_step2','create_product_step3','search_results','search_product');
		}
		if (in_array($this->params['action'],$includeBeforeFilter))
		{
			// check front end user session
			$this->checkSessionFrontUser();
		}
		
		// seller section validations
		if (!$this->Session->check('SESSION_ADMIN') || empty($this->params['named']['seller_id'])){
			$includeForSeller = array('upload_listing', 'create_product_step1','create_product_step2','create_product_step3','create_listing','review_listing','confirm_listing','manage_listing','sales_report','search_product','download_listing');
		}else{
			//$includeForSeller = array('upload_listing', 'create_product_step1','create_product_step2','create_product_step3','create_listing','review_listing','confirm_listing','sales_report','search_product');
			$includeForSeller = array('upload_listing', 'create_product_step1','create_product_step2','create_product_step3','create_listing','review_listing','confirm_listing','sales_report','search_product');
		}
		if (in_array($this->params['action'],$includeForSeller))
		{
			// seller's section validations
			$this->validateSeller();
		}
		
		
	}
	
	
	function upload_frame(){
		$this->layout = null;
	}
	
	/** 
	@function:	view 
	@description:	method to fetch the content for static pages of the site at front end section
	@Created by:	Ramanpreet Pal Kaur
	@params:	$id string page-code for the page to be shown
	@Modify:	NULL
	@Created Date:	07-12-2010
	*/
	function view($pagecode = null){
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/staticpages';
			} else{
			$this->layout = 'sellonchoiceful';
			}
		if($pagecode == 'faqs'){
			App::import('Model','Faq');
			$this->Faq = new Faq();
			$allfaqs = $this->Faq->find('all',array('conditions'=>array('faq_category_id'=>11),'order'=>array('Faq.id')));
			$this->set('allfaqs',$allfaqs);
			
		} else{
			App::import('Model','Page');
			$this->Page = new Page();
			$this->data = $this->Page->find('first',array('conditions'=>array('Page.pagecode'=> $pagecode)));
			
			if(!empty($this->data['Message'])){
				foreach($this->data['Message'] as $field_index => $info){
					$this->data['Message'][$field_index] = html_entity_decode($info);
					$this->data['Message'][$field_index] = str_replace('&#039;',"'",$this->data['Message'][$field_index]);
					$this->data['Message'][$field_index] = str_replace('\n',"",$this->data['Message'][$field_index]);
				}
			}
			/** Manage Title, meta description and meta keywords ***/
			$this->pageTitle  = $this->data['Page']['meta_title'];
			$this->set('title_for_layout',$this->data['Page']['meta_title']);
			$this->set('meta_descriptions',$this->data['Page']['meta_description']);
			$this->set('meta_keywords',$this->data['Page']['meta_keyword']);
			/** Manage Title, meta description and meta keywords ***/
		}
	}
	
	
	/** 
	@function	:	admin_download_bulk_files
	@description	:	admin_download_bulk_files
	@params		:	NULL
	**/
	function download_sample_template(){
		$filePath = WWW_ROOT."files/sample_template/sample_template.xls";
		$file_contents = file_get_contents($filePath) ;
		$file_name = "sample_template.xls";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$file_name."");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $file_contents;
		exit;
	}
	
	/** 
	@function: upload_listing
	@description: to upload inventory in bulk for sellers
	@Created by: Kulvinder
	@Modify:  08 Dec 2010
	*/
	function upload_listing(){
		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'marketplace_fullscreen';
 		else
			$this->layout = 'ajax';
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Bulk Upload');
		// import bulk upload database
		App::import('Model','BulkUpload');
		$this->BulkUpload = new BulkUpload;
		App::import('Model','Seller');
		$this->Seller = new Seller;
		if(!empty($this->data)){
			if(!empty( $this->data['BulkUpload']['sample_file']['name'])){
				#validate csv file
				$validationFlag = $this->File->validateCsvFile( $this->data['BulkUpload']['sample_file']['name'] );
				if( $validationFlag  ==  true  ) {  // if in accepted formats
					$this->File->destPath =  WWW_ROOT.PATH_BULKUPLOADS;
					$newName = time()."_".$this->data['BulkUpload']['sample_file']['name'];
					$this->File->setFilename($newName);
					//pr($this->data);
					$fileName  = $this->File->uploadFile($this->data['BulkUpload']['sample_file']['name'],$this->data['BulkUpload']['sample_file']['tmp_name']);
					if( !$fileName  ){ // Error in uploading
						$this->Session->setFlash('Error in uploading the image.','default',array('class'=>'flashError')); 
						//$this->redirect('/marketplaces/upload_listing');
							
					}else{ // uploaded successful
						$this->data['BulkUpload']['sample_file']= $fileName;
						if ($this->BulkUpload->save($this->data)) {
							/** Send email after registration **/
							$this->Email->smtpOptions = array(
								'host' => Configure::read('host'),
								'username' =>Configure::read('username'),
								'password' => Configure::read('password'),
								'timeout' => Configure::read('timeout')
							);
							
							$this->Email->replyTo=Configure::read('replytoEmail');
							$ccmailId = Configure::read('cc');
							$this->Email->cc = array("$ccmailId");
						
							$this->Email->sendAs= 'html';
							$link=Configure::read('siteUrl');
							/**
							table: 		email_templates
							id:		14 
							description:	Marketplace Bulk Listing Upload
							*/

							$template = $this->Common->getEmailTemplate('14');
							$userInfo = $this->Common->getUserMailInfo($this->data['BulkUpload']['user_id']);
							$sellerInfo = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$this->data['BulkUpload']['user_id']),'fields'=>array('Seller.user_id','Seller.business_display_name')));
							if(!empty($sellerInfo)){
								if(!empty($sellerInfo['Seller']['business_display_name']))
									$seller_display_name = $sellerInfo['Seller']['business_display_name'];
								else 
									$seller_display_name = 'Seller';
							} else {
								$seller_display_name = 'Seller';
							}
								
							$this->Email->from = $template['EmailTemplate']['from_email'];
							$data = $template['EmailTemplate']['description'];
							$data=str_replace('[SellersDisplayName]',$seller_display_name,$data);
								
							$this->Email->subject = $template['EmailTemplate']['subject'];
							$this->set('data',$data);
							$this->Email->to = $userInfo['User']['email'];
							/******import emailTemplate Model and get template****/
							$this->Email->template='commanEmailTemplate';
							$this->Email->send();
							/** Send email  **/
							$this->Session->setFlash("Your file has been uploaded, check back in 48 hours to view your listings.", 'default', array( 'class'=>'message')); 
						}else{
						}
						$this->redirect('/marketplaces/upload_listing');
					}
				}else{
					$this->Session->setFlash('Please choose a csv file to upload', 'default', array( 'class'=>'flashError') );
				}
			} else {
				$this->Session->setFlash('Please choose a csv file to upload', 'default', array( 'class'=>'flashError') );
			}
		}else{
			
		}
	}
	
	/** 
	@function: create_product_step1
	@description: to add product mannually
	@Created by: Kulvinder
	@Modify:  07 Dec 2010
	*/
	function create_product_step1(){
		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'marketplace_fullscreen';
 		else
			$this->layout = 'ajax';
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Create New Product - Step 1 of 3');
		
		//pr($this->data);
		
		
		// clear the step 2 data
		$this->Session->write('create_product_step2', '');
		$this->Session->write('create_product_step3', '');
		
		// import temporary products DB
		App::import('Model', 'Product');
		$this->Product = new Product;
		
		if(!empty($this->data)){ 
			$this->Product->set($this->data);
			$sellerValidate = $this->Product->validates();
			if(!empty($sellerValidate)){
				$this->Session->write('create_product_step1',$this->data);
				$this->data = '';
				$this->redirect('/marketplaces/create_product_step2');
			} else {
				$errorArray = $this->Product->validationErrors;
				$this->set('errors',$errorArray);
			}
		}else{
			$data_step1 = $this->Session->read('create_product_step1');
			if(!empty($data_step1) ){
				$this->data['Product']['department_id'] = $data_step1['Product']['department_id'];
				$this->data['Product']['category_id']   = $data_step1['Product']['category_id'];
			}
		}
		
	}
	
	/** 
	@function: create_product_step2
	@description: to add product mannually
	@Created by: Kulvinder
	@Modify:  07 Dec 2010
	*/
	function create_product_step2(){
		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'marketplace_fullscreen';
 		else
			$this->layout = 'ajax';
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Create New Product - Step 2 of 3');
		// validate step 1 data
		$data_step1 = $this->Session->read('create_product_step1');
		if( empty($data_step1) ){
			$this->redirect('/marketplaces/create_product_step1');
		}
		$department_id = $data_step1['Product']['department_id'];
		$this->set('department_id',$department_id);
		
		// clear the step 3 data
		$this->Session->write('create_product_step3', '');
		
		// import temporary products DB
		App::import('Model', 'Product');
		$this->Product = new Product;
		// import temporary products DB
		App::import('Model', 'ProductDetail');
		$this->ProductDetail = new ProductDetail;
		 
		if(!empty($this->data)){
			
			//$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->Product->set($this->data);
			$this->ProductDetail->set($this->data);
			$sellerValidate = $this->Product->validates();
			$productDetailValidate = $this->ProductDetail->validates();
			if(!empty($sellerValidate) && !empty($productDetailValidate) ){
				if(!empty($this->data['ProductDetail']['music_rated']) ){
					$this->data['ProductDetail']['rated']  = $this->data['ProductDetail']['music_rated'];
				}
				if(!empty($this->data['ProductDetail']['movie_language']) ){
					$this->data['ProductDetail']['language']  = $this->data['ProductDetail']['movie_language'];
				}
				if(!empty($this->data['ProductDetail']['release_date']) ){
					$release_date = explode('/', $this->data['ProductDetail']['release_date']);
					$release_date = $release_date[2]."-".$release_date[1]."-".$release_date[0];
					$this->data['ProductDetail']['release_date'] = $release_date;
				}
				
				$brand_id = $this->Common->getBrandIdByName($this->data['Product']['brand_name']);
				
				if($brand_id > 0){
					$this->data['Product']['brand_id'] = $brand_id;
				}else{
					$this->data['Product']['brand_id'] = $this->data['Product']['brand_name'];
				}
				$this->Session->write('create_product_step2',$this->data);
				$this->data = '';
				$this->redirect('/marketplaces/create_product_step3');
			} else {
				$errorArray = $this->Product->validationErrors;
				$this->set('errors',$errorArray);
				$errorArrayD = $this->ProductDetail->validationErrors;
				$this->set('errorsd',$errorArrayD);
			}
		}else{
			$old_data = $this->Session->read('create_product_step2');
			if( is_array($old_data) ){ 
				if(is_array($old_data['Product'])){
					$this->data['Product'] =  $old_data['Product'];
				}
				if(is_array($old_data['ProductDetail'])){
					$this->data['ProductDetail'] =  $old_data['ProductDetail'];
				}
			}
		}
	}

	/** 
	@function: create_product_step3
	@description: to add product mannually
	@Created by: Kulvinder
	@Modify:  07 Dec 2010
	*/
	function create_product_step3(){
		if($this->RequestHandler->isAjax()==0){
 			$this->layout = 'marketplace_fullscreen';
		}else{
			$this->layout = 'ajax';
		}
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Create New Product - Step 3 of 3');
		$this->Session->write('image_error','');
		// validate step 1 data
		$data_step2 = $this->Session->read('create_product_step2');
		//pr($data_step2);
		if( empty($data_step2) ){
			$this->redirect('/marketplaces/create_product_step2');
		}	
		
		
		// import  products DB
		App::import('Model', 'Product');
		$this->Product = new Product;
		
		// import ProductSiteuser  DB
		App::import('Model', 'ProductSiteuser');
		$this->ProductSiteuser = new ProductSiteuser;
		
		// import temporary products DB
		App::import('Model', 'ProductDetail');
		$this->ProductDetail = new ProductDetail;
		
		if(!empty($this->data)){
			
			//$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->ProductDetail->set($this->data);
			$product_image_check = $this->data['Product']['product_image'][0]['name'];
			if(!empty($product_image_check) ){
				$imageType = $this->data['Product']['product_image'][0]['type'];
				$imageTypeArr = explode('/',$imageType);
				$validImage = $this->File->validateGifJpgImage($imageTypeArr[1]); // allow only gif/jpeg images
			}else{
				$validImage = true;
			}
			if($product_image_check == ''){ // check image select or not 
				$this->Session->write('image_error','Select at least one image');
			}elseif($validImage == false){
				$this->Session->write('image_error','Select only "gif" or "jpg" images');
			}
			$sellerValidate = $this->ProductDetail->validates();
			if(!empty($sellerValidate) && $this->Session->read('image_error') == ''){
				$key_features = '';
				if( !empty($this->data['ProductDetail']['product_features1']) ){
					$key_features .=  "<p>".htmlentities($this->data['ProductDetail']['product_features1'])."</p>";
				}
				if( !empty($this->data['ProductDetail']['product_features2']) ){
					$key_features .=  "<p>".htmlentities($this->data['ProductDetail']['product_features2'])."</p>";
				}
				if( !empty($this->data['ProductDetail']['product_features3']) ){
					$key_features .=  "<p>".htmlentities($this->data['ProductDetail']['product_features3'])."</p>";	
				}
				if( !empty($this->data['ProductDetail']['product_features4']) ){
					$key_features .=  "<p>".htmlentities($this->data['ProductDetail']['product_features4'])."</p>";	
				}
				$this->data['ProductDetail']['product_features']  = $key_features;
					
					
				$data_step1 = array();
				$data_step2 = array();
				$data_step1 = $this->Session->read('create_product_step1');
				$data_step2 = $this->Session->read('create_product_step2');
				
				/*if(!is_array($data_step2['Product'])){
					$data_step2['Product'] = array();
				}*/
				if(!is_array($data_step1['Product'])){
					$data_step1['Product'] = array();
				}
				if(!is_array($data_step2['Product'])){
					$data_step2['Product'] = array();
				}
				if(!is_array($data_step2['ProductDetail'])){
					$data_step2['ProductDetail'] = array();
				}
				if(!is_array($this->data['ProductDetail'])){
					$this->data['ProductDetail'] = array();
				}
					
				$this->data['Product'] = array_merge($data_step1['Product'],$data_step2['Product'], $this->data['Product']);
				$this->data['ProductDetail'] = array_merge($data_step2['ProductDetail'], $this->data['ProductDetail']);
					
				$other_images = $this->data['Product']['product_image'];
				$this->data['Product']['product_image'] = $this->data['Product']['product_image'][0];
					
					
				if(!empty($this->data['Product']['product_image']['name'])){
					$this->File->destPath =  WWW_ROOT.PATH_PRODUCT;
					$this->File->setFilename(time()."_".$this->data['Product']['product_image']['name']);
					$fileName  = $this->File->uploadFile($this->data['Product']['product_image']['name'],$this->data['Product']['product_image']['tmp_name']);
					$mime ='';
					$file = $fileName;
					@copy($this->File->destPath.DS.$file,$this->File->destPath.'large/img_400_'.$file);
					@copy($this->File->destPath.DS.$file,$this->File->destPath.'large/img_300_'.$file);
					$this->Thumb->getResized('img_400_'.$file, $mime, $this->File->destPath.'large/', 400, 400, 'FFFFFF', true, true,$this->File->destPath.'large/', false);
					$this->Thumb->getResized('img_300_'.$file, $mime, $this->File->destPath.'large/', 300, 300, 'FFFFFF', true, true,$this->File->destPath.'large/', false);
					
					@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_200_'.$file);
					@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_150_'.$file);
					@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_135_'.$file);
					@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_125_'.$file);
					$this->Thumb->getResized('img_200_'.$file, $mime, $this->File->destPath.'medium/', 200, 200, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
					$this->Thumb->getResized('img_150_'.$file, $mime, $this->File->destPath.'medium/', 150, 150, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
					$this->Thumb->getResized('img_135_'.$file, $mime, $this->File->destPath.'medium/', 135, 135, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
					$this->Thumb->getResized('img_125_'.$file, $mime, $this->File->destPath.'medium/', 125, 125, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
					@copy($this->File->destPath.DS.$file,$this->File->destPath.'small/img_100_'.$file);
					@copy($this->File->destPath.DS.$file,$this->File->destPath.'small/img_75_'.$file);
					@copy($this->File->destPath.DS.$file,$this->File->destPath.'small/img_50_'.$file);
					$this->Thumb->getResized('img_100_'.$file, $mime, $this->File->destPath.'small/', 100, 100, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
					$this->Thumb->getResized('img_75_'.$file, $mime, $this->File->destPath.'small/', 75, 75, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
					$this->Thumb->getResized('img_50_'.$file, $mime, $this->File->destPath.'small/', 50, 50, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
				}
				$this->data['Product']['quick_code'] = 'null';
				$this->data['Product']['status'] = 0;
				
				$this->data['Product']['product_image'] = $fileName;
				// save the data in DB
				$this->Product->set($this->data);
				//$this->data = Sanitize::clean($this->data);

				$product_searchtag = htmlentities($this->data['ProductDetail']['product_searchtag']);
				$product_features = htmlentities($this->data['ProductDetail']['product_features']);
				$description = htmlentities($this->data['ProductDetail']['description']);

				$publisher_review  = htmlentities(@$this->data['Product']['publisher_review']);


				$this->data = Sanitize::clean($this->data);
				
				$this->data['ProductDetail']['product_searchtag'] = $product_searchtag;
				$this->data['ProductDetail']['product_features'] = $product_features;
				$this->data['ProductDetail']['description'] = $description;
				$this->data['Product']['publisher_review'] = $publisher_review;



				$this->Product->set($this->data);

// pr($this->data); die;
				if ($this->Product->save($this->data)) { // succsess
				
				$product_id = $this->Product->getLastInsertId();
				$this->data['ProductDetail']  = $this->data['ProductDetail'];
				$this->data['ProductDetail']['product_id']  = $product_id;
				$this->ProductDetail->set($this->data);
				$this->ProductDetail->save($this->data);
					
				# insert data into site users's table
				$this->data['ProductSiteuser']['product_id']   = $product_id;
				$this->data['ProductSiteuser']['category_id'] = $this->data['Product']['category_id'];
				$this->data['ProductSiteuser']['brand_name']  = $this->data['Product']['brand_name'];
				$this->data['ProductSiteuser']['seller_id']   = $this->Session->read('User.id');
				
// pr($this->data); die;

				$this->ProductSiteuser->set($this->data);
				$this->ProductSiteuser->save($this->data);
					$department_id = $this->data['Product']['department_id'];
				        $quickCode = $this->Product->generateQuickCode($product_id,$department_id );
					$this->Product->id = $product_id;
					$this->Product->saveField('quick_code',$quickCode);
					
					$this->data['Product'] = '';
					// import the Productimage DB
					App::import('Model', 'Productimage');
					$this->Productimage = new Productimage();
					
					$this->data['Productimage']['product_id'] = $product_id;
					// upload all images
					$this->File->destPath =  WWW_ROOT.PATH_PRODUCT;
					if(is_array($other_images) ){
						unset($other_images[0]);
						
						foreach($other_images as $temp_image){
							$imageType = $temp_image['type'];
							$imageTypeArr = explode('/',$imageType);
							$validImage = $this->File->validateGifJpgImage($imageTypeArr[1]);
							if($validImage == true){ 
								$newName = time()."_".$temp_image['name'];
								$this->File->setFilename($newName);
								$file  = $this->File->uploadFile($temp_image['name'],$temp_image['tmp_name']);
								$mime = '';
								@copy($this->File->destPath.DS.$file,$this->File->destPath.'large/img_400_'.$file);
								@copy($this->File->destPath.DS.$file,$this->File->destPath.'large/img_300_'.$file);
								$this->Thumb->getResized('img_400_'.$file, $mime, $this->File->destPath.'large/', 400, 400, 'FFFFFF', true, true,$this->File->destPath.'large/', false);
								$this->Thumb->getResized('img_300_'.$file, $mime, $this->File->destPath.'large/', 300, 300, 'FFFFFF', true, true,$this->File->destPath.'large/', false);
								@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_200_'.$file);
								@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_150_'.$file);
								@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_135_'.$file);
								@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_125_'.$file);
								$this->Thumb->getResized('img_200_'.$file, $mime, $this->File->destPath.'medium/', 200, 200, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
								$this->Thumb->getResized('img_150_'.$file, $mime, $this->File->destPath.'medium/', 150, 150, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
								$this->Thumb->getResized('img_135_'.$file, $mime, $this->File->destPath.'medium/', 135, 135, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
								$this->Thumb->getResized('img_125_'.$file, $mime, $this->File->destPath.'medium/', 125, 125, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
								@copy($this->File->destPath.DS.$file,$this->File->destPath.'small/img_100_'.$file);
								@copy($this->File->destPath.DS.$file,$this->File->destPath.'small/img_75_'.$file);
								@copy($this->File->destPath.DS.$file,$this->File->destPath.'small/img_50_'.$file);
								$this->Thumb->getResized('img_100_'.$file, $mime, $this->File->destPath.'small/', 100, 100, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
								$this->Thumb->getResized('img_75_'.$file, $mime, $this->File->destPath.'small/', 75, 75, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
								$this->Thumb->getResized('img_50_'.$file, $mime, $this->File->destPath.'small/', 50, 50, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
								$this->data['Productimage']['id'] = '';
								$this->data['Productimage']['image'] = $file;
								$this->Productimage->save($this->data);
							}
						}
					}
					######################### inert into site users products table
					###############################################################
					//$this->Session->setFlash('Records has been submitted successfully.');
					#clear the back page product session data

					$this->Session->delete('create_product_step1');
					$this->Session->delete('create_product_step2');
				
					$this->Session->write('last_page_url', 'create_product_step3');
					$this->redirect('/marketplaces/create_listing/'.$product_id);
					
				}else{ // error in saving the records
					$this->Session->setFlash('Error in submitting the records.','default',array('class'=>'flashError'));
				}
				
			} else {
				$errorArray = $this->ProductDetail->validationErrors;
				$this->set('errors',$errorArray);
			}
		}else{
			
		}
	}
	
	
	/** 
	@function: create_listing
	@description: to create listing 
	@Created by: Kulvinder
	@Modify:  10 Dec 2010
	*/
	function create_listing($product_id = null){
		
		
 		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else {
			$this->layout = 'marketplace';
		}
		
		//$this->layout = 'marketplace_fullscreen';
 		if(empty($product_id)){
			$this->Session->setFlash('Sorry,product data missing, request can not be completed.','default',array('class'=>'flashError'));
		}
		$this->set('title_for_layout','Choiceful.com Marketplace: Enter Product Selling Information');
		$this->set('product_id',$product_id); // product id in case of edit
		
		$dispatchCountryArr = $this->Common->getDispatchCountryList();
		$this->set('dispatchCountryArr',$dispatchCountryArr); 
		
		// get product details
		// import temporary products DB
		App::import('Model', 'Product');
		$this->Product = new Product;
		$product_details = $this->Product->find('first' ,
			array('conditions'=> array('Product.id' =>$product_id ),
				'fields'=>array('Product.id','Product.product_name','Product.barcode','Product.quick_code', 'Product.model_number',
					'Product.product_image','Product.product_rrp','Product.minimum_price_value','minimum_price_seller','new_condition_id',
					'minimum_price_used','minimum_price_used_seller','used_condition_id')
				));
		$this->set('product_details',$product_details);
		App::import('Model', 'ProductCondition');
		$this->ProductCondition = new ProductCondition();
		// get product conditions array
		$product_condition_array = $this->ProductCondition->getProductConditions();
		$this->set('product_condition_array', $product_condition_array);
		// import temporary products DB
		App::import('Model', 'ProductSeller');
		$this->ProductSeller = new ProductSeller;
		// get all product sellers count
		$product_sellers_count = $this->Common->getproductsellercount($product_id);
		$this->set('product_sellers_count',$product_sellers_count);
		
		if ($this->RequestHandler->isMobile()) {
			$seller_id = $this->Session->read('User.id');
			$product_seller = $this->ProductSeller->find('first' ,
			array('conditions'=> array('ProductSeller.product_id' =>$product_id, 'ProductSeller.seller_id' =>$seller_id ),
				'fields'=>array('ProductSeller.id','ProductSeller.reference_code','ProductSeller.quantity','ProductSeller.barcode','ProductSeller.condition_id','ProductSeller.notes','ProductSeller.price','ProductSeller.minimum_price_disabled','ProductSeller.minimum_price','ProductSeller.dispatch_country','ProductSeller.standard_delivery_price','ProductSeller.express_delivery','ProductSeller.express_delivery_price')
				));
		$this->set('product_seller',$product_seller);
		}
		
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->ProductSeller->set($this->data);
			$sellerValidate = $this->ProductSeller->validates();
			
			if(!empty($sellerValidate)){
				$create_listing_data = '';
				$this->data['ProductSeller']['price'] = floatval($this->data['ProductSeller']['price']);
				$this->data['ProductSeller']['quantity'] = intval($this->data['ProductSeller']['quantity']);
				$this->data['ProductSeller']['standard_delivery_price'] = floatval($this->data['ProductSeller']['standard_delivery_price']);
				if(!empty($this->data['ProductSeller']['minimum_price'])){
					$this->data['ProductSeller']['minimum_price'] = floatval($this->data['ProductSeller']['minimum_price']);
				}
				if(!empty($this->data['ProductSeller']['express_delivery_price'])){
					$this->data['ProductSeller']['express_delivery_price'] = floatval($this->data['ProductSeller']['express_delivery_price']);
				}
				$this->data['ProductSeller']['seller_id'] =  $this->Session->read('User.id');
				$this->data['ProductSeller']['product_id'] =  $product_id;
				$this->Session->write('create_listing_data',$this->data);
				$this->data = '';
				$this->redirect('/marketplaces/review_listing');
			} else {
				$this->set('errors',$this->ProductSeller->validationErrors);
			}
		}else{
			$create_listing_data = $this->Session->read('create_listing_data');
			$back_page = $this->Session->read('last_page_url');
			if( !empty($back_page)  && $back_page == 'create_product_step3'){
				$this->data['ProductSeller']['barcode'] = $product_details['Product']['barcode'];
			}
			if(!empty($create_listing_data) ){
				$this->ProductSeller->set($create_listing_data);
				$this->data = $create_listing_data;
			}
		}
	}
	
	
	
	/** 
	@function: review_listing
	@description: to review the listing 
	@Created by: Kulvinder
	@Modify:  10 Dec 2010
	*/
	function review_listing(){
 		if ($this->RequestHandler->isMobile()) {
			$this->layout = 'mobile/product';
		} else{
			$this->layout = 'marketplace';
		}
		$this->set('title_for_layout','Choiceful.com Marketplace: Listing Confirmation');
		$create_listing_data = $this->Session->read('create_listing_data');
		// validate the create listing data
		if( is_array($create_listing_data) && !empty($create_listing_data) ){
			$product_id = $create_listing_data['ProductSeller']['product_id'];
			$this->set('product_id',$product_id); // product id in case of edit
			$this->set('data', $create_listing_data);
		}else{
			$this->redirect('/marketplaces/create_listing');
		}
		 
		 // get all product sellers count
		$product_sellers_count = $this->Common->getproductsellercount($product_id);
		$this->set('product_sellers_count',$product_sellers_count);
		
		// get product details
		// import temporary products DB
		App::import('Model', 'Product');
		$this->Product = new Product;
		$product_details = $this->Product->find('first' ,
			array('conditions'=> array('Product.id' =>$product_id ),
				'fields'=>array('Product.id','Product.product_name','Product.barcode','Product.quick_code', 'Product.model_number',
					'Product.product_image','Product.product_rrp','Product.minimum_price_value','minimum_price_seller','new_condition_id',
					'minimum_price_used','minimum_price_used_seller','used_condition_id')
				));
		$this->set('product_details',$product_details);
		
		App::import('Model', 'ProductCondition');
		$this->ProductCondition = new ProductCondition();
		// get product conditions array
		$product_condition_array = $this->ProductCondition->getProductConditions();
		$this->set('product_condition_array', $product_condition_array);
		
		// confirm  the data
		if($this->data['FormData']['confirm'] == 'yes'){

			$this->data = '';
			// import ProductSeller DB
			App::import('Model', 'ProductSeller');
			$this->ProductSeller = new ProductSeller;
			$this->data  =  $create_listing_data;
			$this->Session->write('create_listing_data' ,''); // clear the session data

			$product_notes = htmlentities($this->data['ProductSeller']['notes']);



			$this->data = Sanitize::clean($this->data);
			
			$condition_str = 'NEW';

			$this->data['ProductSeller']['notes'] = $product_notes;
			
			if($this->data['ProductSeller']['condition_id'] == 2 || $this->data['ProductSeller']['condition_id'] == 3 || $this->data['ProductSeller']['condition_id'] == 5 || $this->data['ProductSeller']['condition_id'] == 6 || $this->data['ProductSeller']['condition_id'] == 7 ){
				$condition_str = 'USED';
			}
			//$this->data = Sanitize::clean($this->data);
			$this->ProductSeller->set($this->data);
			if ($this->ProductSeller->save($this->data)) { // succsess
				
				if (!$this->RequestHandler->isMobile()) {
					$prod_selller_id = $this->ProductSeller->getLastInsertId();
					$this->Common->setMinimumPriceProductNewSeller($product_id,$condition_str); // Set minimum price seller for product
					$this->redirect('/marketplaces/confirm_listing/'.$prod_selller_id);
				}else{
					if(empty($this->data['ProductSeller']['id'])){
						$prod_selller_id = $this->ProductSeller->getLastInsertId();
					}else{
						$prod_selller_id = $this->data['ProductSeller']['id'];
					}
					$this->Common->setMinimumPriceProductNewSeller($product_id,$condition_str); // Set minimum price seller for product
					$this->redirect('/marketplaces/confirm_listing/'.$prod_selller_id);
				}
				
				
			}else{
				$this->Session->setFlash('Error in submitting the records.','default',array('class'=>'flashError'));
			}
			
		}
	}
	
	/**
	@function: confirm_listing
	@description: to confirm the listing 
	@Created by: Kulvinder
	@Modify:  11 Dec 2010
	*/
	function confirm_listing($prod_selller_id = null ){
 		if ($this->RequestHandler->isMobile()) {
			$this->layout = 'mobile/product';
		} else{
			$this->layout = 'marketplace';
		}
		// validate  data
 		if( empty($prod_selller_id)){
			$this->redirect('/marketplaces/review_listing');
		}
		$this->set('title_for_layout','Choiceful.com Marketplace: Listing Confirmation');
		# import product seller
		App::import('Model', 'ProductSeller');
		$this->ProductSeller = new ProductSeller;
		
		$this->ProductSeller->id = $prod_selller_id;
		$data = $this->ProductSeller->read();
		$this->set('data', $data);
		
		$product_id = $data['ProductSeller']['product_id'];
		// get all product sellers count
		$product_sellers_count = $this->Common->getproductsellercount($product_id);
		$this->set('product_sellers_count',$product_sellers_count);
		
		// get product details
		// import temporary products DB
		App::import('Model', 'Product');
		$this->Product = new Product;
		$product_details = $this->Product->find('first' ,
			array('conditions'=> array('Product.id' =>$product_id ),
				'fields'=>array('Product.id','Product.product_name','Product.barcode','Product.quick_code', 'Product.model_number',
					'Product.product_image','Product.product_rrp','Product.minimum_price_value','minimum_price_seller','new_condition_id',
					'minimum_price_used','minimum_price_used_seller','used_condition_id')
				));
		$this->set('product_details',$product_details);
		App::import('Model', 'ProductCondition');
		$this->ProductCondition = new ProductCondition();
		
		// get product conditions array
		$product_condition_array = $this->ProductCondition->getProductConditions();
		$this->set('product_condition_array', $product_condition_array);
	}
	
	/** 
	@function: search_product
	@description: to review the listing 
	@Created by: Ramanoreet Pal
	@Modify:  DEc 23, 2010
	*/
	function search_product($search_word_url = null){
		
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			$this->layout = 'marketplace_fullscreen';
		}
		if($this->data['Marketplace']['search_product_name'] != "")
		{
			$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Search Results for "'.$this->data['Marketplace']['search_product_name'].'"');
		}else{
			$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Find Your Products');
		}
		$total_pages = '';
		$total_records = '';
		$search_word = '';
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		$seller_listed_id =$this->Session->read('User.id');
		$product_seller_listed = $this->ProductSeller->find('list',array('conditions'=>array('ProductSeller.seller_id'=>$seller_listed_id),'fields'=>array('ProductSeller.id','ProductSeller.product_id')));
		$this->set('product_seller_listed',$product_seller_listed);
		//FH OPEN
		$fh_ok = FH_OK;
		if($fh_ok == 'OK'){
		$items = array();$results =array(); $facetmap = array();
		$ws_location = WS_LOCATION;
		//Create a new soap client
		//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
// 		$this->Common->fh_call();
		$items_recomanded = array();
		
		if ($this->RequestHandler->isMobile()) {
 			$view_size = VIEW_SIZE_FH_MOBILE;
 			if(!empty($this->data['Record']['limit'])){
 				$view_size = $this->data['Record']['limit'];
 			}
		} else{
			$view_size = VIEW_SIZE_FH;
		}
		$this->set('view_size',$view_size);
		
		//Build the query string
		//$fh_location = '';
		
		/*if(!empty($this->params['url'])){
			foreach($this->params['url'] as $url_index => $url_fh){
				if($url_index != 'url' && $url_index != 'ext'){
					if(empty($fh_location)){
						$fh_location="fh_location=//catalog01/en_GB/";
						$fh_location = $fh_location."&".$url_index."=".$url_fh;
						$fh_location = str_replace('~','/',$fh_location);
						$fh_location = $fh_location;
						$paging_flag = 1;
					} else {
						$fh_location = $fh_location."&".$url_index."=".$url_fh;
						$fh_location = str_replace('~','/',$fh_location);
						$fh_location = $fh_location;
						$paging_flag = 1;
					}
				}
			}
		}*/
		
		
		//Build the query string
		$fh_location = '';
		if(!empty($this->params['url'])){
			foreach($this->params['url'] as $url_index => $url_fh){
				if($url_index != 'url' && $url_index != 'ext'){
					if ($this->RequestHandler->isMobile()) {
						$this->params['url']['fh_view_size']=$view_size;
					}
					if(empty($fh_location)){
						$fh_location = $url_index."=".$url_fh;
					} else {
						$fh_location = $fh_location."&".$url_index."=".$url_fh;
					}
				}
			}
		}
		
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			$this->data = Sanitize::clean($this->data, array('encode' => false));
		
		if(!empty($this->data['Page']['search_product_name'])){
			$this->data['Marketplace']['search_product_name'] = trim($this->data['Page']['search_product_name']);
			$search_word = $this->data['Marketplace']['search_product_name'];
			$this->set('search_word',$search_word);
		}
		if(!empty($this->data['Page'])){
			if(!empty($this->data['Page']['go_url'])){
				$fh_location = $this->data['Page']['go_url'];
			}
		}
		
		$paging_flag = 1;
		if(empty($fh_location)){
			$fh_location="fh_location=//catalog01/en_GB/";
			
			if(!empty($this->data['Marketplace']['search_product_name'])){
				$search_word = trim($this->data['Marketplace']['search_product_name']);
				App::import('Sanitize');
				$search_word = Sanitize::escape($search_word);
				$this->set('search_word',$search_word);
				//$this->set('searchWord',$search_word);
				$search_word = str_replace(' ','\u0020',$search_word);
				$search_word = str_replace('!','\u0021',$search_word);
				$search_word = str_replace('"','\u0022',$search_word);
				$search_word = str_replace('#','\u0023',$search_word);
				$search_word = str_replace('/','\u002f',$search_word);
				$search_word = str_replace('@','\u0040',$search_word);
				$fh_location = $fh_location.'$s='.$search_word;
				$paging_flag = 0;
			}
			$fh_location = $fh_location."&preview_advanced=true&fh_view_size=$view_size&fh_start_index=0";
			$pass_url = $fh_location."&preview_advanced=true&fh_view_size=$view_size&fh_start_index=0";
			$paging_flag = 0;
		} else {
			//$fh_location = '?fh_eds=ß&'.$fh_location;
			$pass_url = $fh_location;
			$fh_location = str_replace('~','/',$fh_location);
			$fh_location = $fh_location;
			$paging_flag = 1;
		}
		}
		$this->set('pass_url',$pass_url);
		if(!empty($this->data['Page']['goto_page'])){
			
			$fh_location = $fh_location. '&fh_start_index='.($this->data['Page']['goto_page']-1)*$view_size.'&fh_view_size=25&';
			
		}
		//Send the query string to the Fredhopper Query Server & obtain the result
		$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
		//Find the universe marked as 'selected' in the result
		
		foreach($result->universes->universe as $r) {
			if($r->{"type"} == "selected"){
				//Extract & print the breadcrumbs from the result
				
				if(!empty($r->facetmap))
					$facetmap = (array)$r->facetmap;
					
				if(!empty($r->breadcrumbs))
					$breadcrumbs = (array)$r->breadcrumbs;
				if(!empty($r->themes))
					$themes = (array)$r->themes;
					$themes_continue = $themes['theme'];
					
				if($fh_location != '?fh_location=//catalog01/en_GB/') {
					//Extract & print the item information from the result
					if(!empty($r->{"items-section"})){
						if(!empty($r->{"items-section"}->items)) {
							$items = (array)$r->{"items-section"}->items;
						}
						if(!empty($r->{"items-section"}->results)) {
							$results = (array)$r->{"items-section"}->results;
						}
					}
				}
			}
		}
			
		$k = 0;
		$search_result = array();
			if(!empty($items['item'])){
			if(empty($items['item']->attribute)) {
				foreach($items['item'] as $item) {
					if(!empty($item->attribute)) {
						
						foreach($item->attribute as $attribute){
							if($attribute->name == 'secondid' && !empty($attribute->value->_)){
								$search_result[$k]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name' && !empty($attribute->value->_)){
								$search_result[$k]['product_name'] = $attribute->value->_;
							}
							if($attribute->name == 'product_image' && !empty($attribute->value->_)){
								$search_result[$k]['product_image'] = $attribute->value->_;
							}
							if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
								$search_result[$k]['avg_rating'] = $attribute->value->_;
							}
							if($attribute->name == 'model_number' && !empty($attribute->value->_)){
								$search_result[$k]['model_number'] = $attribute->value->_;
							}
						}
						
					}
				$k++;	
				}
			}else{
				foreach($items['item']->attribute as $attribute){
					if($attribute->name == 'secondid' && !empty($attribute->value->_)){
						$search_result[$k]['secondid'] = $attribute->value->_;
					}
					if($attribute->name == 'product_name' && !empty($attribute->value->_)){
						$search_result[$k]['product_name'] = $attribute->value->_;
					}
					if($attribute->name == 'product_image' && !empty($attribute->value->_)){
						$search_result[$k]['product_image'] = $attribute->value->_;
					}
					if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
						$search_result[$k]['avg_rating'] = $attribute->value->_;
					}
					if($attribute->name == 'model_number' && !empty($attribute->value->_)){
						$search_result[$k]['model_number'] = $attribute->value->_;
					}
				}
				$k++;
				
			}
			}
		if(!empty($items['item']))
			$items = $items['item'];
		
		if(!empty($items)){
			if(count($items) == 1){
				App::import('Model','Product');
				$this->Product = new Product();
				$qc_code = $items->attribute[0]->value->_;
				$pr_id_info = $this->Product->find('first',array('conditions'=>array('Product.quick_code'=>$qc_code),'fields'=>array('Product.id')));
				$pr_id = @$pr_id_info['Product']['id'];
				if(!empty($pr_id)){
					$this->redirect('/categories/productdetail/'.$pr_id);
				} else {
					$this->redirect('/');
				}
			}
		}
		// FH CLOSE
		}
		/** Paging parameters **/
		if(!empty($results)) {
			$total_records = $results['total_items'];
			$no_records_page = $results['view_size'];
			
			if(empty($no_records_page)){
				$no_records_page = 1;
			}
			$no_of_pages = (int) ($total_records / $no_records_page).'<br>';
			
			$remain_items = $total_records % $no_records_page;
			if(!empty($remain_items)) {
				$no_of_pages = $no_of_pages + 1;
				$last_page_starts = $total_records - $remain_items;
			} else {
				$last_page_starts = ($no_of_pages-1)*$no_records_page;
				
			}
			
			$results['last_page_starts'] = $last_page_starts;
			$results['no_of_pages'] = $no_of_pages;
			
		}
		if(!empty($search_word_url)){
			$search_word = $search_word_url;
		}
		$this->data['Marketplace']['search_product_name'] = '';
		/** Paging parameters **/
		$this->set('results',$results);
		$this->set('go_action','search_product');
		$this->set('total_records',$total_records);
		$this->set('breadcrumbs',$breadcrumbs);
		$this->set('search_word',$search_word);
		$this->set('search_result',$search_result);
		$this->set('marketplace_facetmap',$facetmap);
		$this->set('total_pages',$total_pages);
	}

	

	/** 
	@function : search_results
	@description : to search products for users
	@Created by : Ramanpreet Pal Kaur
	@params : 
	@Modify : 
	@Created Date : 
	*/
	function search_results($search_word = null,$search_word_url = null){
		$this->layout = 'marketplace';
		if($this->data['Marketplace']['search_product_name'] != "")
		{
			$this->set('title_for_layout','Choiceful.com Marketplace: Search Results for "'.$this->data['Marketplace']['search_product_name'].'"');
		}else{
			$this->set('title_for_layout','Choiceful.com Marketplace: Find Your Products');
		}
		$total_pages = '';
		$total_records = '';
		if(empty($search_word)){
			$search_word = '';
		}
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		$seller_listed_id =$this->Session->read('User.id');
		$product_seller_listed = $this->ProductSeller->find('list',array('conditions'=>array('ProductSeller.seller_id'=>$seller_listed_id),'fields'=>array('ProductSeller.id','ProductSeller.product_id')));
		$this->set('product_seller_listed',$product_seller_listed);
		
		//FH OPEN
		$fh_ok = FH_OK;
		if($fh_ok == 'OK'){
		$items = array();$results =array(); $facetmap = array();
		$ws_location = WS_LOCATION;
		//Create a new soap client
		//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
// 		$this->Common->fh_call();
		$items_recomanded = array();
		
		$view_size = VIEW_SIZE_FH;
		
		$this->set('view_size',$view_size);
		
		//Build the query string
		$fh_location = '';
		
		if(!empty($this->params['url'])){
			foreach($this->params['url'] as $url_index => $url_fh){
				if($url_index != 'url' && $url_index != 'ext'){
					if(empty($fh_location)){
						$fh_location = $url_index."=".$url_fh;
					} else {
						$fh_location = $fh_location."&".$url_index."=".$url_fh;
					}
				}
			}
		}
		
		
		
		
		
		//echo $fh_location;
		$paging_flag = 1;
		if(empty($fh_location)){
			// start check empty data
				if(!empty($this->data)){
					
					$this->data = $this->cleardata($this->data);
					$this->data = Sanitize::clean($this->data, array('encode' => false));
					
				if(!empty($this->data['Page']['search_product_name'])){
					$this->data['Marketplace']['search_product_name'] = trim($this->data['Page']['search_product_name']);
					$search_word = $this->data['Marketplace']['search_product_name'];
					$this->set('search_word',$search_word);
				}
				if(!empty($this->data['Page'])){
					if(!empty($this->data['Page']['go_url'])){
						$fh_location = $this->data['Page']['go_url'];
					}
				}
			$fh_location="fh_location=//catalog01/en_GB/";
			
			if(!empty($this->data['Marketplace']['search_product_name'])){
				$search_word = trim($this->data['Marketplace']['search_product_name']);
				
				App::import('Sanitize');
				$search_word = Sanitize::escape($search_word);
				$this->set('search_word',$search_word);
				//$this->set('searchWord',$search_word);
				$search_word = str_replace(' ','\u0020',$search_word);
				$search_word = str_replace('!','\u0021',$search_word);
				$search_word = str_replace('"','\u0022',$search_word);
				$search_word = str_replace('#','\u0023',$search_word);
				$search_word = str_replace('/','\u002f',$search_word);
				$search_word = str_replace('@','\u0040',$search_word);
				$fh_location = $fh_location.'$s='.$search_word;
				$paging_flag = 0;
			}
			$fh_location = $fh_location."&preview_advanced=true&fh_view_size=$view_size&fh_start_index=0";
			$pass_url = $fh_location."&preview_advanced=true&fh_view_size=$view_size&fh_start_index=0";
			$paging_flag = 0;
			
			} //end check empty data
		} else {
			//$fh_location = '?fh_eds=ß&'.$fh_location;
			$pass_url = $fh_location;
			$fh_location = str_replace('~','/',$fh_location);
			$fh_location = $fh_location;
			$paging_flag = 1;
			$this->set('search_word',$search_word);
		}
		
		
		$this->set('pass_url',$pass_url);
		if(!empty($this->data['Page']['goto_page'])){
			
			$fh_location = $fh_location. '&fh_start_index='.($this->data['Page']['goto_page']-1)*$view_size.'&fh_view_size=25&';
			
		}
		//Send the query string to the Fredhopper Query Server & obtain the result
		$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
		//Find the universe marked as 'selected' in the result
		
		foreach($result->universes->universe as $r) {
			if($r->{"type"} == "selected"){
				//Extract & print the breadcrumbs from the result
				
				if(!empty($r->facetmap))
					$facetmap = (array)$r->facetmap;
					
				if(!empty($r->breadcrumbs))
					$breadcrumbs = (array)$r->breadcrumbs;
				if(!empty($r->themes))
					$themes = (array)$r->themes;
					$themes_continue = $themes['theme'];
					
				if($fh_location != '?fh_location=//catalog01/en_GB/') {
					//Extract & print the item information from the result
					if(!empty($r->{"items-section"})){
						if(!empty($r->{"items-section"}->items)) {
							$items = (array)$r->{"items-section"}->items;
						}
						if(!empty($r->{"items-section"}->results)) {
							$results = (array)$r->{"items-section"}->results;
						}
					}
				}
			}
		}
			
		$k = 0;
		$search_result = array();
			if(!empty($items['item'])){
			if(empty($items['item']->attribute)) {
				foreach($items['item'] as $item) {
					if(!empty($item->attribute)) {
						
						foreach($item->attribute as $attribute){
							if($attribute->name == 'secondid' && !empty($attribute->value->_)){
								$search_result[$k]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name' && !empty($attribute->value->_)){
								$search_result[$k]['product_name'] = $attribute->value->_;
							}
							if($attribute->name == 'product_image' && !empty($attribute->value->_)){
								$search_result[$k]['product_image'] = $attribute->value->_;
							}
							if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
								$search_result[$k]['avg_rating'] = $attribute->value->_;
							}
							if($attribute->name == 'model_number' && !empty($attribute->value->_)){
								$search_result[$k]['model_number'] = $attribute->value->_;
							}
						}
						
					}
				$k++;	
				}
			}else{
				foreach($items['item']->attribute as $attribute){
					if($attribute->name == 'secondid' && !empty($attribute->value->_)){
						$search_result[$k]['secondid'] = $attribute->value->_;
					}
					if($attribute->name == 'product_name' && !empty($attribute->value->_)){
						$search_result[$k]['product_name'] = $attribute->value->_;
					}
					if($attribute->name == 'product_image' && !empty($attribute->value->_)){
						$search_result[$k]['product_image'] = $attribute->value->_;
					}
					if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
						$search_result[$k]['avg_rating'] = $attribute->value->_;
					}
					if($attribute->name == 'model_number' && !empty($attribute->value->_)){
						$search_result[$k]['model_number'] = $attribute->value->_;
					}
				}
				$k++;
				
			}
			}
		if(!empty($items['item']))
			$items = $items['item'];
		
		if(!empty($items)){
			if(count($items) == 1){
				App::import('Model','Product');
				$this->Product = new Product();
				$qc_code = $items->attribute[0]->value->_;
				$pr_id_info = $this->Product->find('first',array('conditions'=>array('Product.quick_code'=>$qc_code),'fields'=>array('Product.id')));
				$pr_id = @$pr_id_info['Product']['id'];
				if(!empty($pr_id)){
					$this->redirect('/categories/productdetail/'.$pr_id);
				} else {
					$this->redirect('/');
				}
			}
		}
		}
		//FH Close
		/** Paging parameters **/
		if(!empty($results)) {
			$total_records = $results['total_items'];
			$no_records_page = $results['view_size'];
			
			if(empty($no_records_page)){
				$no_records_page = 1;
			}
			$no_of_pages = (int) ($total_records / $no_records_page).'<br>';
			
			$remain_items = $total_records % $no_records_page;
			if(!empty($remain_items)) {
				$no_of_pages = $no_of_pages + 1;
				$last_page_starts = $total_records - $remain_items;
			} else {
				$last_page_starts = ($no_of_pages-1)*$no_records_page;
				
			}
			
			$results['last_page_starts'] = $last_page_starts;
			$results['no_of_pages'] = $no_of_pages;
			
		}
		if(!empty($search_word_url)){
			$search_word = $search_word_url;
		}
		$this->data['Marketplace']['search_product_name'] = '';
		/** Paging parameters **/
		$this->set('results',$results);
		$this->set('go_action','search_results');
		$this->set('total_records',$total_records);
		$this->set('breadcrumbs',$breadcrumbs);
		$this->set('search_result',$search_result);
		$this->set('marketplace_facetmap',$facetmap);
		$this->set('total_pages',$total_pages);
		
	}

	/** 
	@function: manage_listing
	@description: to manage product listings for sellers from product_sellers table
	@Created by: Ramanpreet Pal
	@Modify:  21 Dec 2010
	*/
	function manage_listing(){
		
		$upload_session = $this->Session->read('Errorupdatelisting');
		if(!empty($upload_session)){
			$this->Session->delete('Errorupdatelisting');
		}
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Manage Listings');
		$go_to_page = "";
		if(!empty($this->params['named']['page'])){
			$go_to_page = $this->params['named']['page'];
		}
			
		if(empty($this->data)){
				
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=trim($this->params['named']['keyword']);
			else
				$this->data['Search']['keyword'] = '';
		}
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			$this->layout = 'marketplace_fullscreen';
		}
		
		if(empty($this->params['named']['seller_id'])){
			$seller_user_id =$this->Session->read('User.id');
		}else{
			$seller_user_id =$this->params['named']['seller_id'];
			$this->set('seller_user_id', $seller_user_id);
			// for delete session if any seller of user is login form front end
			if(!empty($_SESSION)){
			foreach($_SESSION as $session_index => $session_variable){
				if($session_index == 'Config' || $session_index == 'SESSION_ADMIN'){
				} else {
					$this->Session->delete($session_index);
				}
			}
			}
			// END for delete session
		}
		
		$creteria = "ProductSeller.seller_id = ".$seller_user_id;
		$value = '';
			
			
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			
			if(!empty($this->data['Paging'])){
				if(!empty($this->data['Paging']['options'])){
					$limit_is = $this->data['Paging']['options'];
					$this->Session->write('listingLimit',$limit_is);
					$this->data['Search']['keyword'] = $this->data['Page']['keyword'];
				}
			}
			if(!empty($this->data['Search'])){
				if(!empty($this->data['Search']['keyword'])){
					$value = trim($this->data['Search']['keyword']);
					App::import('Sanitize');
					$value1 = Sanitize::escape($value);
					//$creteria .= " AND ( ProductSeller.reference_code = '".$value1."' OR Product.product_name LIKE '%".$value1."%')";
					$creteria .= " AND ( ProductSeller.reference_code = '".$value1."' OR Product.product_name LIKE '%".$value1."%' OR Product.quick_code LIKE '%".$value1."%' OR Product.barcode LIKE '%".$value1."%')";
				}
			}
		}
		$this->set('keyword', $value);
		$this->set('go_to_page', $go_to_page);
		$this->set('modelis','ProductSeller');
			
		$products = $this->get_sellerProducts($creteria);
			
		$this->set('products',$products);
			
		App::import('Model','ProductCondition');
			
		$this->ProductCondition = new ProductCondition();
		$conditionArr = $this->ProductCondition->getProductConditions();
		$this->set('conditionArr',$conditionArr);
		$this->data['Listing1']['options'] = 'save';
		$this->data['Listing2']['options'] = 'save';
	}

	/** 
	@function: update_listing
	@description: to update(save or delete) product listings for sellers in product_sellers table 
	@Created by: Ramanpreet Pal
	@Modify:  22 Dec 2010
	@Modify:  08 Dec 2010
	*/
	function update_listing(){
		//echo "<pre>";
		//print_r($this->data);
		///echo "</pre>";
		//die;
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		//Configure::write('debug',2);
		if(!empty($this->data)){
				
			$this->data = $this->cleardata($this->data);
			$this->data = Sanitize::clean($this->data, array('encode' => false));	
				
			if(!empty($this->data['Listing2']['options']))
				$this->data['Listing1']['options'] = $this->data['Listing2']['options'];
			if($this->data['Listing1']['options'] == 'save'){
				foreach($this->data['Listing'] as $proseller_id => $product_info){
					if(!empty($this->data['Listing'][$proseller_id]) && !empty($product_info['ProductSeller']['selected']) && 
					$product_info['ProductSeller']['selected']==1
					){
						$this->data['ProductSeller']['id'] = $proseller_id;
						if($product_info['ProductSeller']['quantity'] < 0)
							$product_info['ProductSeller']['quantity'] = 0;
							
						$this->data['ProductSeller']['notes'] = $product_info['ProductSeller']['notes'];
						$this->data['ProductSeller']['quantity'] = intval($product_info['ProductSeller']['quantity']);
							
							
						$this->data['ProductSeller']['price'] = (float)$product_info['ProductSeller']['price'];
						
						if($product_info['ProductSeller']['minimum_price'] < 0)
							$product_info['ProductSeller']['minimum_price'] = 0;
							
						$this->data['ProductSeller']['minimum_price'] =  floatval($product_info['ProductSeller']['minimum_price']);
						
						if(!empty($this->data['ProductSeller']['minimum_price'])){
							$this->data['ProductSeller']['minimum_price_disabled'] = 0;
						} else{
							$this->data['ProductSeller']['minimum_price_disabled'] = 1;
						}
						if($product_info['ProductSeller']['standard_delivery_price'] < 0)
							$product_info['ProductSeller']['standard_delivery_price'] = 0;
							
						$this->data['ProductSeller']['standard_delivery_price'] = floatval($product_info['ProductSeller']['standard_delivery_price']);
						if($product_info['ProductSeller']['express_delivery_price'] < 0)
							$this->data['ProductSeller']['express_delivery_price'] = 0;
							
						$this->data['ProductSeller']['express_delivery_price']  = floatval($product_info['ProductSeller']['express_delivery_price']);
							
						if(!empty($this->data['ProductSeller']['express_delivery_price'])){
							$this->data['ProductSeller']['express_delivery'] = 1;
						} else{
							$this->data['ProductSeller']['express_delivery'] = 0;
						}
						if(!empty($product_info['ProductSeller']['condition_id'])){
							$this->data['ProductSeller']['condition_id'] = $product_info['ProductSeller']['condition_id'];
						} else{
							$condition_id  = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.id'=>$proseller_id),'fields'=>array('ProductSeller.condition_id')));
							$this->data['ProductSeller']['condition_id'] = $condition_id['ProductSeller']['condition_id'];
						}
						$this->data = Sanitize::clean($this->data);
						$this->ProductSeller->set($this->data);
						if($this->data['ProductSeller']['price'] > 0)
						//if($this->data['ProductSeller']['price'] >= 0)
							$this->ProductSeller->save($this->data);
					}
					//$this->Session->setFlash('All selected products have been updated successfully!','');
					$this->Session->setFlash('All selected products have been updated successfully!','default',array('class'=>'message'));
				}
			//}
			} elseif($this->data['Listing1']['options'] == 'delete'){
				if(!empty($this->data['select'])) {
					foreach($this->data['select'] as $proseller_id){
						if(!empty($proseller_id)){
							if(!empty($this->data['Listing'][$proseller_id])){
								$this->ProductSeller->id = $proseller_id;
								$this->ProductSeller->delete($proseller_id);
							}
						}
					}
					$this->Session->setFlash('Update complete - Selected listings have been deleted','');
				}
			} else { }
				
				
		}
		if(empty($this->params['named']['seller_id'])){
			$seller_user_id =$this->Session->read('User.id');
			$redirect_con =$this->Session->read('User.id');
		}else{
			$seller_user_id =$this->params['named']['seller_id'];
			$this->set('seller_user_id', $seller_user_id);
		}
		
		if(!empty($this->data['ProductSeller']['Pageno'])){
			$pageno = $this->data['ProductSeller']['Pageno'];
		}
		if(empty($pageno)){
			if(empty($redirect_con)){
				$this->redirect('/marketplaces/manage_listing/seller_id:'.$seller_user_id);
			}else{
				$this->redirect('/marketplaces/manage_listing/');
			}
		}else{
			if(empty($redirect_con)){
				$this->redirect('/marketplaces/manage_listing/seller_id:'.$seller_user_id.'/page:'.$pageno);
			}else{
				$this->redirect('/marketplaces/manage_listing/page:'.$pageno);
			}
		}
		
		}


	/** 
	@function: update_listing
	@description: to update(save or delete) product listings for sellers in product_sellers table 
	@Created by: Ramanpreet Pal
	@Modify:  22 Dec 2010
	*/
	function save_listing(){
		if(!empty($this->data)){
			App::import('Model','ProductSeller');
			$this->ProductSeller = new ProductSeller();
			//pr($this->data);echo '<hr>'; echo '<hr>'; echo '<hr>';
			foreach($this->data['Listing'] as $proseller_id => $product_info){
				//echo $proseller_id;
				if(!empty($proseller_id)){
// pr($product_info);
					$this->data['ProductSeller']['id'] = $proseller_id;
					if($product_info['ProductSeller']['quantity'] < 0)
						$product_info['ProductSeller']['quantity'] = 0;
						
					$this->data['ProductSeller']['quantity'] = intval($product_info['ProductSeller']['quantity']);

					$this->data['ProductSeller']['notes'] = $product_info['ProductSeller']['notes'];

					$this->data['ProductSeller']['price'] = floatval($product_info['ProductSeller']['price']);

					$this->data['ProductSeller']['minimum_price'] = floatval($product_info['ProductSeller']['minimum_price']);

					if(!empty($this->data['ProductSeller']['minimum_price'])){
						$this->data['ProductSeller']['minimum_price_disabled'] = 0;
					}
					$this->data['ProductSeller']['standard_delivery_price'] = floatval($product_info['ProductSeller']['standard_delivery_price']);

					$this->data['ProductSeller']['express_delivery_price']  = floatval($product_info['ProductSeller']['express_delivery_price']);

					if(!empty($product_info['ProductSeller']['condition_id'])){
						$this->data['ProductSeller']['condition_id'] = $product_info['ProductSeller']['condition_id'];
					} else{
						$condition_id  = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.id'=>$proseller_id),'fields'=>array('ProductSeller.condition_id')));
						$this->data['ProductSeller']['condition_id'] = $condition_id['ProductSeller']['condition_id'];
					}
					
					//pr($this->data['ProductSeller']); echo '<hr>';
					$this->data = Sanitize::clean($this->data);
					$this->ProductSeller->set($this->data);
					//pr($this->data['ProductSeller']); echo '<hr>'; echo '<hr>';
					$this->ProductSeller->save($this->data);
				}
			}
		}
		$seller_user_id =$this->Session->read('User.id');
		$creteria = "ProductSeller.seller_id = ".$seller_user_id;
		$value = '';
		if(!empty($this->data['Search'])){
			if(!empty($this->data['Search']['keyword'])){
				$value = $this->data['Search']['keyword'];
				App::import('Sanitize');
				$value1 = Sanitize::escape($value);
				$creteria .= " AND ( ProductSeller.reference_code = '".$value1."' OR Product.product_name LIKE '%".$value1."%')";
			}
		}
		$this->set('keyword', $value);
		$this->generate_list($creteria);
		$this->redirect('/marketplaces/manage_listing');
	}


	/** 
	@function: generate_list
	@description: 
	@Created by: Ramanpreet Pal
	@Modify:  22 Dec 2010
	*/
	function generate_list($creteria = null,$sortby = null){
		$products = $this->get_sellerProducts($creteria,$sortby);
		$this->set('products',$products);
		App::import('Model','ProductCondition');
		$this->ProductCondition = new ProductCondition();
		$conditionArr = $this->ProductCondition->getProductConditions();
		$this->set('conditionArr',$conditionArr);
		$this->set('modelis','ProductSeller');
		$this->data['select'] = '';
		$this->viewPath = 'elements/marketplace' ;
		$this->render('products_listing');
	}

	/**
	@function: get_sellerProducts
	@description: returns allproducts for a logged i seller
	@Created by: Ramanpreet Pal
	@Modify:  22 Dec 2010
	*/
	function get_sellerProducts($creteria = null) {
		$limit_is = 0;
		$limit_is = $this->Session->read('listingLimit');
		
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		if(empty($sortby)){
			$sortby = 'ProductSeller.reference_code';
		}
		$this->ProductSeller->expects(array('Product','ProductCondition'));
			
		if(empty($limit_is))
			$limit_is = 50;
			
		$this->paginate = array(
			'limit' => $limit_is,
			'order' => array(
				'ProductSeller.reference_code' => 'ASC'
			),
			'fields' => array(
				'ProductSeller.id',
				'ProductSeller.seller_id',
				'ProductSeller.reference_code',
				'ProductSeller.product_id',
				'ProductSeller.condition_id',
				'ProductSeller.quantity',
				'ProductSeller.price',
				'ProductSeller.minimum_price_disabled',
				'ProductSeller.minimum_price','ProductSeller.notes',
				'ProductSeller.standard_delivery',
				'ProductSeller.standard_delivery_price',
				'ProductSeller.express_delivery',
				'ProductSeller.express_delivery_price',
				'ProductSeller.created',
				'Product.product_name',
				'Product.minimum_price_value',
				'Product.minimum_price_used',
				'Product.minimum_price_seller',
				'Product.minimum_price_used_seller',
				'ProductCondition.name'
			)
		);
		$products = $this->paginate('ProductSeller',$creteria);
		return $products;
	}

	/**
	@function: gotoPage
	@description: 
	@Created by: Ramanpreet Pal
	@Modify:  22 Dec 2010
	*/

	function gotoPage(){
		if($this->data['Page']['action'] != ''){
			$goaction = $this->data['Page']['action'];
		}
			
		$from_price = ''; $to_price=''; $rate = ''; $brand_str = '';$sort = '';
		if($goaction == 'search_results' || $goaction == 'search_product'){
			if(!empty($this->data['Page']['from_price'])){
				$from_price = $this->data['Page']['from_price'];
			}
			if(!empty($this->data['Page']['to_price'])){
				$to_price = $this->data['Page']['to_price'];
			}
			if(!empty($this->data['Page']['brand_str'])){
				$brand_str = $this->data['Page']['brand_str'];
			}
			if(!empty($this->data['Page']['rate'])){
				$rate = $this->data['Page']['rate'];
			}
			if(!empty($this->data['Page']['sort'])){
				$sort = $this->data['Page']['sort'];
			}
			$redirect = "/marketplaces/".$goaction."/page:".$this->data['Page']['goto_page']."/keyword:".$this->data['Page']['keyword'];
			
			if(!empty($to_price) || !empty($from_price))
				$redirect .= "/to_price:".$to_price."/from_price:".$from_price;
			if(!empty($brand_str))
				$redirect .= "/brand:".$brand_str;
			if(!empty($sort))
				$redirect .= "/sort:".$sort;
			if(!empty($rate))
				$redirect .= "/rate:".$rate;
				
			$this->redirect($redirect);
		} else {
			if(!empty($this->data['Page']['goto_page'])){
				$this->redirect("/marketplaces/".$goaction."/page:".$this->data['Page']['goto_page']."/keyword:".$this->data['Page']['keyword']);
			} else {
				$this->redirect('/'.$this->data['Page']['url']);
			}
		}
	}


	/** 
	@function : download_listing 
	@description : export sellers products
	@params : 
	@Modify : 
	@Created Date : Dec 24,2010
	@Created By : Ramanpreet Pal Kaur
	*/
	function download_listing(){
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		if(empty($sortby)){
			$sortby = 'ProductSeller.reference_code';
		}
		$this->ProductSeller->expects(array('Product'));
		if(empty($this->params['named']['seller_id'])){
			$seller_user_id =$this->Session->read('User.id');
		}else{
			$seller_user_id =$this->params['named']['seller_id'];
			$this->set('seller_user_id', $seller_user_id);
		}
		$creteria = "ProductSeller.seller_id = ".$seller_user_id;
		$products = $this->ProductSeller->find('all',
			array(
				'conditions'=>$creteria,
				'order' => array('ProductSeller.reference_code' => 'ASC'),
				'fields' => array(
					'Product.quick_code',
					'Product.product_name',
					'Product.model_number',
					'ProductSeller.reference_code',
					'ProductSeller.dispatch_country',
					'ProductSeller.quantity',
					'ProductSeller.id',
					'ProductSeller.condition_id',
					'ProductSeller.notes',
					'ProductSeller.price',
					'ProductSeller.minimum_price_disabled',
					'ProductSeller.minimum_price',
					'ProductSeller.standard_delivery',
					'ProductSeller.standard_delivery_price',
					'ProductSeller.express_delivery',
					'ProductSeller.express_delivery_price'
				)
			)
		);
		
		$country_array   = $this->Common->getcountries();
		$condition_array = $this->Common->getconditions();
		
		
		#Creating CSV
		if(!empty($condition_array)){
				$conditions = "CONDITION: ";
				foreach($condition_array as $conditionId=>$condiion_name){
					$conditions = $conditions.$conditionId."->".$condiion_name." | ";
				}
			}
		$csv_output =  "CIN - NOT EDITABLE,QCID - NOT EDITABLE, SELLER ID, MANUFACTURER-MODEL ID - NOT EDITABLE, TITLE-ITEM NAME - NOT EDITABLE, DISPATCH COUNTRY- NOT EDITABLE, QUANTITY, $conditions,NOTES,PRICE, ENABLE MP, MINIMUM PRICE,STANDARD DELIVERY, SD PRICE, EXPRESS DELIVERY, ED PRICE " ;
		$csv_output .= "\r\n";
		
		if(count($products) > 0){
			foreach($products as $value){
				if(!empty($value['ProductSeller'])){
					foreach($value['ProductSeller'] as $field_index => $info){
						$value['ProductSeller'][$field_index] = html_entity_decode($info);
						$value['ProductSeller'][$field_index] = str_replace('&#039;',"'",$value['ProductSeller'][$field_index]);
						
					}
				}
				if(!empty($value['Product'])){
					foreach($value['Product'] as $field_index => $info){
						$value['Product'][$field_index] = html_entity_decode($info);
						$value['Product'][$field_index] = str_replace('&#039;',"'",$value['Product'][$field_index]);
						
					}
				}
				
			$condition  = $value['ProductSeller']['condition_id'];
			$dispatch_country = $country_array[$value['ProductSeller']['dispatch_country']];
			
			$enable_mp  = ($value['ProductSeller']['minimum_price_disabled'] == 0 )?('Yes'):('No');
			$standard_delivery  = ($value['ProductSeller']['standard_delivery'] == 1 )?('Yes'):('No');
			$express_delivery   = ($value['ProductSeller']['express_delivery'] == 1 )?('Yes'):('No');
			
			$csv_output .="".str_replace(",",' || ',
			$value['ProductSeller']['id']).",".str_replace(",",' || ',
			$value['Product']['quick_code']).",".str_replace(",",' || ',
			$value['ProductSeller']['reference_code']).",".str_replace(",",' || ',
			$value['Product']['model_number']).",".str_replace(",",' || ',								
			$value['Product']['product_name']).",".str_replace(",",' || ',			
			$dispatch_country).",".str_replace(",",' || ',
			$value['ProductSeller']['quantity']).",".str_replace(",",' || ',
			$condition).",".str_replace(",",' || ',
			$value['ProductSeller']['notes']).",".str_replace(",",' || ',
			$value['ProductSeller']['price']).",".str_replace(",",' || ',
			$enable_mp).",".str_replace(",",' || ',
			$value['ProductSeller']['minimum_price']).",".str_replace(",",' || ',
			$standard_delivery).",".str_replace(",",' || ',
			$value['ProductSeller']['standard_delivery_price']).",".str_replace(",",' || ',
			$express_delivery).",".str_replace(",",' || ',
			$value['ProductSeller']['express_delivery_price'])."\r\n";
			}
			
			/*if(!empty($condition_array)){
				$csv_output = $csv_output."Conditions:, ";
				foreach($condition_array as $conditionId=>$condiion_name){
					$csv_output = $csv_output.$conditionId."->".$condiion_name." | ";
				}
			}*/
		} else{
			$csv_output .= "No Record Found."; 
		}
// echo $csv_output; exit();
		$filePath="product_listing_".date("Ymd").".csv";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$filePath."");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $csv_output;
		exit;
	}


	/** 
	@function : download_edit_listing 
	@description : export sellers products to edit
	@params : 
	@Modify : 
	@Created Date : MArch 15, 2011
	@Created By : Ramanpreet Pal Kaur
	*/
// 	function download_edit_listing(){
// 		App::import('Model','ProductSeller');
// 		$this->ProductSeller = new ProductSeller();
// 		if(empty($sortby)){
// 			$sortby = 'ProductSeller.reference_code';
// 		}
// 		$this->ProductSeller->expects(array('Product'));
// 		$seller_user_id =$this->Session->read('User.id');
// 		$creteria = "ProductSeller.seller_id = ".$seller_user_id;
// 		$products = $this->ProductSeller->find('all',
// 			array(
// 				'conditions'=>$creteria,
// // 				'order' => array('ProductSeller.reference_code' => 'ASC'),
// 				'fields' => array(
// 					'Product.quick_code',
// 					'Product.product_name',
// 					'ProductSeller.reference_code',
// 					'ProductSeller.id',
// 					'ProductSeller.quantity',
// 					'ProductSeller.condition_id',
// 					'ProductSeller.notes',
// 					'ProductSeller.price',
// 					'ProductSeller.minimum_price',
// 					'ProductSeller.standard_delivery_price',
// 					'ProductSeller.express_delivery_price'
// 				)
// 			)
// 		);
// 		
// 		$condition_array = $this->Common->getconditions();
// 		
// 		
// 		#Creating CSV
// 		$csv_output =  "ID(Not Editable),QCID(Not Editable), SELLER ID(Not Editable), TITLE/ITEM NAME(Not Editable), QUANTITY, CONDITION, NOTES,PRICE, MINIMUM PRICE, SD PRICE, ED PRICE " ;
// 		$csv_output .= "\n";
// 		
// 		if(count($products) > 0){
// 			foreach($products as $value){
// 				$condition  = $value['ProductSeller']['condition_id'];
// 				$csv_output .="".str_replace(",",' || ',
// 				$value['ProductSeller']['id']).",".str_replace(",",' || ',
// 				$value['Product']['quick_code']).",".str_replace(",",' || ',
// 				$value['ProductSeller']['reference_code']).",".str_replace(",",' || ',
// 				$value['Product']['product_name']).",".str_replace(",",' || ',
// 				$value['ProductSeller']['quantity']).",".str_replace(",",' || ',
// 				$condition).",".str_replace(",",' || ',
// 				$value['ProductSeller']['notes']).",".str_replace(",",' || ',
// 				$value['ProductSeller']['price']).",".str_replace(",",' || ',
// 				$value['ProductSeller']['minimum_price']).",".str_replace(",",' || ',
// 				$value['ProductSeller']['standard_delivery_price']).",".str_replace(",",' || ',
// 				$value['ProductSeller']['express_delivery_price']).",\n";
// 			}
// 			if(!empty($condition_array)){
// 				$csv_output = $csv_output."Conditions:, ";
// 				foreach($condition_array as $conditionId=>$condiion_name){
// 					$csv_output = $csv_output.$conditionId."->".$condiion_name." | ";
// 				}
// 			}
// 		} else{
// 			$csv_output .= "No Record Found..";
// 		}
// 		$filePath = "product_edit_listing_".date("Ymd").".csv";
// 		header("Content-type: application/vnd.ms-excel");
// 		header("Content-Disposition: attachment; filename=".$filePath."");
// 		header("Pragma: no-cache");
// 		header("Expires: 0");
// // 		chmod("product_edit_listing_".date("Ymd").".csv", 0751);
// 		print $csv_output;
// 		
// 		exit;
// 	}


	/** 
	@function: upload_edited_listing
	@description: to upload updated  volume  selles's listing
	@Created by: Ramanpreet Pal kaur
	@Modify:  March 15, 2011
	*/
	function upload_edited_listing(){
		$this->layout='front_popup';
		$this->set('Products_all' , '');
		$this->set('Products_uploaded' , '');
		$this->set('Products_notuploaded' , '');
		$this->set('form_posted' , false);
		// import bulk upload database
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller;
		$Products_all = '';
		$Products_uploaded = '';
		$Products_notuploaded = '';
		$skipped_header_row = '';
			App::import('Vendor', 'PhpUploader', array('file' => 'phpfileuploader'.DS.'phpuploader'.DS.'include_phpuploader.php'));
			$uploader=new PhpUploader();
		
		$this->set('uploader',$uploader);
			
		if(empty($this->params['named']['seller_id'])){	
			$seller_user_id =$this->Session->read('User.id');
		}else{
			$seller_user_id =$this->params['named']['seller_id'];
			$this->set('seller_user_id',$seller_user_id);
		}
		
		if(!empty($this->data)){
			//echo '<pre>'; print_r($this->data); die;
			$this->data['ProductSeller'] = $this->data['Marketplace'];
			$this->ProductSeller->set($this->data);
			//$sellerValidate = $this->ProductSeller->validates();
			if($this->data['ProductSeller']['sample_bulk_data']['name'] != ''){
				// validate the csv file type
				$validationFlag = $this->File->validateCsvFile($this->data['ProductSeller']['sample_bulk_data']['name'] );
				if( $validationFlag  == true ) {  // if in accepted formats
					$this->set('form_posted' , true);
					$file = $this->data['ProductSeller']['sample_bulk_data']['tmp_name'];
					$seller_id = $seller_user_id;
					$skipped_rows = '';
					$handle = fopen($file, 'r');
					$rowchek = fgetcsv($handle, 4096, ",");
						
					$columns_count = count($rowchek);
					if( $columns_count == 16){ // is file is ok to upload
						$skipped_header_row = implode(', ', $rowchek);
						$error = '';
						$ch = 0;
						while (($row = fgetcsv($handle, 4096, ",")) !== FALSE) {
							$first_row_test = trim($row[0]);
							if(empty($row[0]) && empty($row[1]) && empty($row[2])){
								break;
							}
							if(trim(strtolower($row[0])) == 'conditions:' || trim(strtolower($row[0])) == 'conditions' || trim(strtolower($row[0])) == 'conditions :'){
								
							} else{
								if(is_numeric(trim($first_row_test))) {
								} else {
									$error = 'YES';
									break;
								}
								if(is_numeric(trim($row[6]))) {
									
								} else {
									$error = 'YES';
									break;
								}
								if(is_numeric(trim($row[7]))) {
									
								} else {
									$error = 'YES';
									break;
								}
								if(is_numeric(trim($row[9])) || is_float(trim($row[9]))) {
									
								} else {
									$error = 'YES';
									break;
								}
								if(is_numeric(trim($row[11])) || is_float(trim($row[11]))) {
									
								} else {
									
									break;
								}
								if(is_numeric(trim($row[13])) || is_float(trim($row[13]))) {
									
								} else {
									$error = 'YES';
									break;
								}
								if(is_numeric(trim($row[15])) || is_float(trim($row[15]))) {
									
								} else {
									$error = 'YES';
									break;
								}
							}
						}
						if($error == 'YES'){
							$this->Session->setFlash('Your listings were not updated, please check the data in the uploaded file, refer to the Sample Template.','default',array('class'=>'flashError'));
						} else {
							$handle1 = fopen($file, 'r');
							while (($row = fgetcsv($handle1, 4096, ",")) !== FALSE) {
								$first_row_test = strtoupper(trim($row[0]));
								if(!is_numeric($first_row_test)){
								} else{
									if(empty($row[0]) && empty($row[1]) && empty($row[2])){
										break;
									}
									$is_sellers = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.id'=>$first_row_test),'fields'=>array('ProductSeller.seller_id')));
									if(!empty($is_sellers)){
										if($is_sellers['ProductSeller']['seller_id'] == $seller_user_id){
											$this->data['ProductSeller']['id'] = trim($row[0]);
											if(is_numeric(trim($row[6])))
												$this->data['ProductSeller']['quantity'] = trim($row[6]);
											if(is_numeric(trim($row[7])))
												$this->data['ProductSeller']['condition_id'] = trim($row[7]);
											$this->data['ProductSeller']['notes'] = trim($row[8]);
											if(is_numeric(trim($row[9])) || is_float(trim($row[9])))
												$this->data['ProductSeller']['price'] = trim($row[9]);
											/* 0:enable 1: disable */
											if(strtolower(trim($row[10])) == 'yes'){
												$mpststus = 0;
											} else if(strtolower(trim($row[10])) == 'no'){
												$mpststus = 1;
											} else {
												$mpststus = 2;
											}
											if($mpststus != 2)
												$this->data['ProductSeller']['minimum_price_disabled'] = $mpststus;
												$this->data['ProductSeller']['reference_code'] = trim($row[2]);
												
											if(is_numeric(trim($row[11])) || is_float(trim($row[11])))
												$this->data['ProductSeller']['minimum_price'] = trim($row[11]);
													
											/* 0:enable 1: disable */
											/*if(strtolower(trim($row[12])) == 'yes'){
												$sdstatus = 0;
											} else if(strtolower(trim($row[12])) == 'no'){
												$sdstatus = 1;
											} else {
												$sdstatus = 2;
											}
											if($sdstatus != 2)
												$this->data['ProductSeller']['standard_delivery'] = $sdstatus;
											*/
											if(strtolower(trim($row[12])) == 'yes'){
												$sdstatus = 1;
											} else if(strtolower(trim($row[12])) == 'no'){
												$sdstatus = 0;
											} else {
												$sdstatus = 1;
											}
											if($sdstatus != '2')
												$this->data['ProductSeller']['standard_delivery'] = "$sdstatus";
												
												
											if(is_numeric(trim($row[13])) || is_float(trim($row[13])))
												$this->data['ProductSeller']['standard_delivery_price'] = trim($row[13]);
												
											/* 0:enable 1: disable */
											if(strtolower(trim($row[14])) == 'yes'){
												$edststus = 1;
											} else if(strtolower(trim($row[14])) == 'no'){
												$edststus = 0;
											} else {
												$edststus = 2;
											}
											if($edststus != 2)
												$this->data['ProductSeller']['express_delivery'] = $edststus;
												
											if(is_numeric(trim($row[15])) || is_float(trim($row[15])))
												$this->data['ProductSeller']['express_delivery_price'] = trim($row[15]);
													
													
											if(empty($Products_all)){
												$Products_all = trim($row[3]).'('.trim($row[1]).')';
											} else {
												$Products_all = $Products_all.','.trim($row[3]).'('.trim($row[1]).')';
											}
													
											$this->data['ProductSeller']['notes'] = str_replace('||',',',$this->data['ProductSeller']['notes']);
											$this->data = Sanitize::clean($this->data);
											$this->ProductSeller->set($this->data);
											if($this->ProductSeller->save($this->data)){
												if(empty($Products_uploaded)){
													$Products_uploaded = trim($row[4]).'('.trim($row[1]).')';
												} else {
													$Products_uploaded = $Products_uploaded.', '.trim($row[4]).'('.trim($row[1]).')';
												}
											} else {
// 												$errorArray[trim($row[0])] = $this->ProductSeller->validationErrors;
// pr($errorArray);											
												if(empty($Products_notuploaded)){
													$Products_notuploaded = trim($row[4]).'('.trim($row[1]).')';
												} else {
													$Products_notuploaded = $Products_notuploaded.', '.trim($row[4]).'('.trim($row[1]).')';
												}
											}
										}
									}
								}
							}
							$uploadStatus['all_products'] = $Products_all;
							$uploadStatus['uploaded_products'] = $Products_uploaded;
							$uploadStatus['notuploaded_products']	= $Products_notuploaded;
								
							//$sessionMsg = 'Products requested to update: ';$Products_all;
								
							if(!empty($Products_uploaded)){
								$this->Session->delete('Errorupdatelisting');
								$this->Session->setFlash('Products updated successfully.', 'default', array('class'=>'message','id'=>'success'));
								$sessionMsg = '<div id="flashMessage" class="message">Products updated successfully.</div>'/*: '.$Products_uploaded*/;
							}
							if(!empty($Products_notuploaded)){
								$sessionMsg = '<div class="flashError">Some content in the file is not valid . Kindly correct and upload.</div>';
								//$sessionMsg = '<div class="flashError">Following  products not updated successfully: '.$Products_notuploaded.'</div>';
								$this->Session->write('Errorupdatelisting',1);
							}
							if(empty($sessionMsg)){
								$sessionMsg ='';
							}
							$_SESSION['update_msg'] = @$sessionMsg;
							//$this->Session->setFlash($sessionMsg);
								
							echo "<script type=\"text/javascript\">setTimeout('parent.jQuery.fancybox.close()',1);
							parent.location.reload(true);
							</script>";
						}
					}else{
						$this->Session->setFlash('Your listings were not updated, please check the data in the uploaded file, refer to the Sample Template.', 'default', array( 'class'=>'flashError') );
					}
				}else{
					$this->Session->setFlash('Please upload .csv file formats only!', 'default', array( 'class'=>'flashError') );
				}
			} else {
				$this->Session->setFlash('Please choose a file to upload!', 'default', array( 'class'=>'flashError') );
			}
		}else{
			
		}
	}

	/** 
	@function:	sales_report
	@description	to display sales report of a seller
	@Created by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date:	21 March, 2011
	@Modified Date: 21 March, 2011
	*/
	function sales_report() {

		//$this->layout = 'message';
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			$this->layout = 'message';
		}
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Seller Statistics & Reports');
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.id');
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		
		$this->OrderItem->expects(array('Order'));
		
		$cuYear = date('Y');
		for($i=$cuYear; $i>=$cuYear-2; $i--){
			$year_sales[$i] = $this->sales_total($i,$seller_id);
		}
		$this->set('seller_id',$seller_id);
		
		
		//$year_sales['2011'] = array(10,20,30,90,150,260,60,130,490,160,120,520);
		//$year_sales['2010'] = array(60,70,30,20,250,160,40,150,230,130,210,520);
		//$year_sales['2009'] = array(20,60,50,50,350,60,80,160,390,180,210,220);
		
		for($j=0; $j<12; $j++){
			$total_yrmnth_sales = 0;
			foreach($year_sales as $year_index => $year_sale){
				$total_yrmnth_sales = $total_yrmnth_sales + $year_sale[$j];
				$total_yearmonth_sales[$j] = $total_yrmnth_sales;
			}
		}
		
		for($j=0; $j<12; $j++){
			if(empty($total_yearmonth_sales[$j])){
				$total_yrmn_sales = 1;
			} else{
				$total_yrmn_sales = $total_yearmonth_sales[$j];
			}
			foreach($year_sales as $year_index => $year_sale){
				$total_yrmnth_sales_per = ($year_sale[$j]/$total_yrmn_sales) * 100;
				$total_yearmonth_sales_per[$year_index][$j] = $total_yrmnth_sales_per;
			}
		}
		
		$this->Jpgraph->sales_graph($total_yearmonth_sales_per,$seller_id,$year_sales);
		
		$bestSelling_products = $this->OrderItem->find('all',array('conditions'=>array('Order.deleted'=>'0','Order.payment_status'=>'Y','OrderItem.seller_id'=>$seller_id),'fields'=>array('OrderItem.product_name','OrderItem.product_id','Order.created','SUM(OrderItem.quantity) as total_units'),'group'=>array('OrderItem.product_id'),'order'=>array('total_units DESC'),'limit'=>10/*,'order'=>array('Order.created')*/));
		$this->set('bestSelling_products',$bestSelling_products);
		
		App::import('Model','Seller');
		$this->Seller = new Seller;
		$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('Seller.created','Seller.user_id')));
		$this->set('seller_info',$seller_info);
		$positive_percentage  = $this->Common->positivePercentFeedback($seller_id);
		$this->set('positive_percentage',$positive_percentage);

		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller;


		$this->OrderSeller->expects(array('Order'));

		$creteria_numbberOfOrdersHistory = array('OrderSeller.seller_id'=>$seller_id,'Order.deleted'=>'0','Order.payment_status'=>'Y');
		$number_of_orders_history = 0;
		$number_of_orders_history = $this->number_of_orders($creteria_numbberOfOrdersHistory);

		$creteria_numbberOfOrders30d = array('OrderSeller.seller_id'=>$seller_id,'Order.deleted'=>'0','Order.payment_status'=>'Y','Order.created > DATE_SUB( NOW( ) , INTERVAL 30 DAY)');
		$number_of_orders_30day = 0;
		$number_of_orders_30day = $this->number_of_orders($creteria_numbberOfOrders30d);

		$creteria_numbberOfOrders6months = array('OrderSeller.seller_id'=>$seller_id,'Order.deleted'=>'0','Order.payment_status'=>'Y','Order.created > DATE_SUB( NOW( ) , INTERVAL 6 MONTH)');
		$number_of_orders_6month = 0;
		$number_of_orders_6month = $this->number_of_orders($creteria_numbberOfOrders6months);

		$this->set('number_of_orders_30day',$number_of_orders_30day);
		$this->set('number_of_orders_6month',$number_of_orders_6month);
		$this->set('number_of_orders_history',$number_of_orders_history);


		/**** PRESHIP CANCEL ORDERS ***/
		$preshipped_30_cancelled_array = array();
		$rate_preship_cancel_30day = 0;

		$current_date = date('Y-m-d');
		$date_b4_30days = date('Y-m-d', strtotime($current_date) - 29*24*60*60);
		$preshipped_30_cancelled_array = $this->Ordercom->getCancelledItemsCost($seller_id,$date_b4_30days,$current_date);
		if(!empty($preshipped_30_cancelled_array)){
			$preshipped_30_cancelled_amount = $preshipped_30_cancelled_array[0][0]['cancelled_amount'];
		}
		$total_30_order_array = $this->Ordercom->getTotalSale($seller_id,$date_b4_30days,$current_date);
		if(!empty($total_30_order_array)){
			$total_30_order_amount = $total_30_order_array[0][0]['total_sale'];
		}
		if(empty($total_30_order_amount))
			$total_30_order_amount = 1;
		if(empty($preshipped_30_cancelled_amount))
			$preshipped_30_cancelled_amount = 0;
		$rate_preship_cancel_30day = ($preshipped_30_cancelled_amount / $total_30_order_amount) * 100;
		

		

		
		$preshipped_6m_cancelled_array = array();
		$rate_preship_cancel_6month = 0;

		$current_date = date('Y-m-d');
		
		$date_b4_6ms = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-179,date('Y')));

		$preshipped_6m_cancelled_array = $this->Ordercom->getCancelledItemsCost($seller_id,$date_b4_6ms,$current_date);

		if(!empty($preshipped_6m_cancelled_array)){
			$preshipped_6m_cancelled_amount = $preshipped_6m_cancelled_array[0][0]['cancelled_amount'];
		}
		$total_6m_order_array = $this->Ordercom->getTotalSale($seller_id,$date_b4_6ms,$current_date);
		if(!empty($total_6m_order_array)){
			$total_6m_order_amount = $total_6m_order_array[0][0]['total_sale'];
		}
		if(empty($total_6m_order_amount))
			$total_6m_order_amount = 1;
		if(empty($preshipped_6m_cancelled_amount))
			$preshipped_6m_cancelled_amount = 0;
		$rate_preship_cancel_6month = ($preshipped_6m_cancelled_amount / $total_6m_order_amount) * 100;

		$preshipped_6m_cancelled_array = array();
		$rate_preship_cancel = 0;
		$preshipped_cancelled_array = $this->Ordercom->getCancelledItemsCost($seller_id);
		if(!empty($preshipped_cancelled_array)){
			$preshipped_cancelled_amount = $preshipped_cancelled_array[0][0]['cancelled_amount'];
		}
		$total_order_array = $this->Ordercom->getTotalSale($seller_id);
		if(!empty($total_order_array)){
			$total_order_amount = $total_order_array[0][0]['total_sale'];
		}
		if(empty($total_order_amount))
			$total_order_amount = 1;
		if(empty($preshipped_cancelled_amount))
			$preshipped_cancelled_amount = 0;
		$rate_preship_cancel = ($preshipped_cancelled_amount / $total_order_amount) * 100;


		$this->set('rate_preship_cancel_30day',$rate_preship_cancel_30day);
		$this->set('rate_preship_cancel_6month',$rate_preship_cancel_6month);
		$this->set('rate_preship_cancel',$rate_preship_cancel);
		/**** END PRESHIP CANCEL ORDERS ***/


		/**** REFUNDED ORDERS ***/
		
		App::import('Model','OrderRefund');
		$this->OrderRefund = new OrderRefund;
		$this->OrderRefund->expects(array('Order'));


		$refundedOrder_30d = 0;
		if(!empty($number_of_orders_30day)){
			$creteria_of_refunded_30day = array('OrderRefund.seller_id' => $seller_id, 'Order.deleted' => '0', 'Order.payment_status' => 'Y','Order.created > DATE_SUB( NOW( ) , INTERVAL 30 DAY)');

			$refundedOrder_30d = $this->OrderRefund->find('all',array('conditions' => $creteria_of_refunded_30day, 'fields' => array('SUM(amount) as total_refund')));

			$order_30d = $this->OrderItem->find('all',array('conditions' => array('OrderItem.seller_id' => $seller_id, 'Order.deleted' => '0', 'Order.payment_status' => 'Y','Order.created > DATE_SUB( NOW( ) , INTERVAL 30 DAY)'),'fields'=>array('OrderItem.price','OrderItem.quantity')));

			$total_amount_30d = 0;
			if(!empty($order_30d)){
				foreach($order_30d as $order_30d){
					$total_amount_30d = $total_amount_30d + $order_30d['OrderItem']['price'] * $order_30d['OrderItem']['quantity'];
				}
			}
			
		}
			
		$rate_refund_30day = 0;
		if(!empty($refundedOrder_30d)){
			if(empty($total_amount_30d))
				$total_amount_30d = 1;
			$rate_refund_30day = ($refundedOrder_30d[0][0]['total_refund'] / $total_amount_30d) * 100;
		}
			
			
		$refundedOrder_6month = 0;
		if(!empty($number_of_orders_6month)){
			$creteria_of_refunded_6month = array('OrderRefund.seller_id' => $seller_id, 'Order.deleted' => '0', 'Order.payment_status' => 'Y', 'Order.created > DATE_SUB( NOW( ) , INTERVAL 6 Month)');
			$refundedOrder_6month = $this->OrderRefund->find('all',array('conditions' => $creteria_of_refunded_6month, 'fields' => array('SUM(amount) as total_refund')));

			$order_6month = $this->OrderItem->find('all',array('conditions' => array('OrderItem.seller_id' => $seller_id, 'Order.deleted' => '0', 'Order.payment_status' => 'Y','Order.created > DATE_SUB( NOW( ) , INTERVAL 6 MONTH)'),'fields'=>array('OrderItem.price','OrderItem.quantity')));

			$total_amount_6mth = 0;
			if(!empty($order_6month)){
				foreach($order_6month as $order_6mth){
					$total_amount_6mth = $total_amount_6mth + $order_6mth['OrderItem']['price'] * $order_6mth['OrderItem']['quantity'];
				}
			}
			
		}
		$rate_refund_6month = 0;
		if(!empty($refundedOrder_6month)){
			if(empty($total_amount_6mth))
				$total_amount_6mth = 1;
			$rate_refund_6month = ($refundedOrder_6month[0][0]['total_refund'] / $total_amount_6mth) * 100;
		}


		$refundedOrder = 0;
		if(!empty($number_of_orders_history)) {
			$creteria_of_refunded = array('OrderRefund.seller_id' => $seller_id, 'Order.deleted' => '0', 'Order.payment_status' => 'Y');
			
			$refundedOrder = $this->OrderRefund->find('all',array('conditions' => $creteria_of_refunded, 'fields' => array('SUM(amount) as total_refund')));

			$order_total = $this->OrderItem->find('all',array('conditions' => array('OrderItem.seller_id' => $seller_id, 'Order.deleted' => '0', 'Order.payment_status' => 'Y'),'fields'=>array('OrderItem.price','OrderItem.quantity')));

			$total_amount = 0;
			if(!empty($order_total)){
				foreach($order_total as $order_tal){
					$total_amount = $total_amount + $order_tal['OrderItem']['price'] * $order_tal['OrderItem']['quantity'];
				}
			}
			
		}
		$rate_refund_history = 0;
		if(!empty($refundedOrder)){
			if(empty($total_amount))
				$total_amount = 1;
				$rate_refund_history = ($refundedOrder[0][0]['total_refund'] / $total_amount) * 100;
		}
		
		
		$this->set('rate_refund_history',$rate_refund_history);
		$this->set('rate_refund_30day',$rate_refund_30day);
		$this->set('rate_refund_6month',$rate_refund_6month);
		/**** END REFUNDED ORDERS ***/
		
		
		
		/**** LATE SHIPMENT ORDERS ***/
		$lateship_30days_creteria = 'OrderSeller.seller_id = '.$seller_id.' AND OrderSeller.dispatch_date != "" AND OrderSeller.dispatch_date > OrderSeller.expected_dispatch_date AND Order.created > DATE_SUB( NOW( ) , INTERVAL 30 DAY)';
		$lateship_30days_orders = $this->number_of_orders($lateship_30days_creteria);
		$lateship_30day_rate = 0;
		if(empty($number_of_orders_30day))
			$number_of_orders_30day = 1;
		$lateship_30day_rate = ($lateship_30days_orders/$number_of_orders_30day)*100;
		
		
		$lateship_6month_creteria = 'OrderSeller.seller_id = '.$seller_id.' AND OrderSeller.dispatch_date != "" AND OrderSeller.dispatch_date > OrderSeller.expected_dispatch_date AND Order.created > DATE_SUB( NOW( ) , INTERVAL 6 Month)';
		$lateship_6month_orders = $this->number_of_orders($lateship_6month_creteria);
		$lateship_6month_rate = 0;
		if(empty($number_of_orders_6month))
			$number_of_orders_6month = 1;
		$lateship_6month_rate = ($lateship_6month_orders/$number_of_orders_6month)*100;
		
		
		$lateship_creteria = 'OrderSeller.seller_id = '.$seller_id.' AND OrderSeller.dispatch_date != "" AND OrderSeller.dispatch_date > OrderSeller.expected_dispatch_date';
		$lateship_orders = $this->number_of_orders($lateship_creteria);
		$lateship_rate = 0;
		if(empty($number_of_orders_history))
			$number_of_orders_history = 1;
		$lateship_rate = ($lateship_orders/$number_of_orders_history)*100;
		
		$this->set('lateship_30day_rate',$lateship_30day_rate);
		$this->set('lateship_6month_rate',$lateship_6month_rate);
		$this->set('lateship_rate',$lateship_rate);
		/**** END  LATE SHIPMENT ORDERS ***/
		
		
		App::import('Model','ProductVisit');
		$this->ProductVisit = new ProductVisit;
		$this->ProductVisit->expects(array('ProductSeller','Product'));
		
		$viewed_products = $this->ProductVisit->query("SELECT ProductVisit.product_id, SUM( ProductVisit.visits )  AS total_visits, Product.product_name
			FROM product_visits AS ProductVisit, product_sellers AS ProductSeller, products AS Product
			WHERE ProductSeller.seller_id =".$seller_id."
			AND ProductVisit.product_id = ProductSeller.product_id
			AND ProductSeller.product_id = Product.id
			GROUP  BY ProductVisit.product_id
			ORDER  BY total_visits DESC 
			LIMIT 10 ");
			
		//pr($viewed_products);
		/*$viewed_products = $this->ProductSeller->find('all',array('conditions'=>array('ProductSeller.seller_id'=>$seller_id),'fields'=>array('ProductSeller.seller_id','ProductSeller.product_id','SUM(ProductVisit.visits) as total_visits','Product.product_name'),'group'=>array('ProductVisit.product_id'),'order'=>array('total_visits DESC'),'limit'=>5));*/
		$this->set('viewed_products',$viewed_products);
	}
	
	/** 
	@function : sales_total
	@description : to get total sales of selected seller
	@Created by : Ramanpreet Pal Kaur
	@params : year, seller id
	@Modify : 21 March, 2011
	@Created Date : 21 March, 2011
	*/

	function sales_total($year = null,$seller_id= null){
		if(empty($year))
			$year = date('Y');
		for($j = 1; $j<=12;$j++){
			if(strlen($j) < 2){
				$j ='0'.$j;
			}
			$start_date = $year.'-'.$j.'-01';
			if($j==12){
				$end_date = ($year+1).'-01'.'-01';
			}else{
				$end_date = $year.'-'.($j+1).'-01';
			}

			$or_items = $this->OrderItem->find('all',array('conditions'=>array('Order.deleted'=>'0','Order.payment_status'=>'Y','OrderItem.seller_id'=>$seller_id,'Order.created BETWEEN "'.$start_date.'" AND "'.$end_date.'"' ),'fields'=>array('OrderItem.quantity','OrderItem.price','OrderItem.delivery_cost','Order.created')));
			$total_amount = 0;
			if(!empty($or_items)){
				foreach($or_items as $or_item){
					$total_amount = $total_amount + $or_item['OrderItem']['quantity'] * $or_item['OrderItem']['price'] + $or_item['OrderItem']['delivery_cost'];
				}
			}
			$data[] = $total_amount;
		}
		return $data;
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
}
?>