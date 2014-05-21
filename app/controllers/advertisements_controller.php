<?php
/**  @class:		AdvertisementsController 
 @Created by: 		RAMANPREET PAL KAUR
 @Modify:		NULL
 @Created Date:		03-10-2010
*/
class AdvertisementsController extends AppController{
	var $name 	= 'Advertisements';
	var $helpers 	=  array('Html','Form','Common', 'Javascript','Session','Validation','Ajax', 'Format');
	var $components =  array('RequestHandler','Email','Common','File','Thumb');

	var $permission_id = 9;  // for promotions module
	
	/**
	* @Date: Nov 01, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		
		//check session other than admin_login page
		$excludeBeforeFilter = array('view','index','contact');
		if (!in_array($this->params['action'],$excludeBeforeFilter))
		{
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id); 
			
		}
	}
	
	
	
	/**
	@function:	admin_index
	@description:	listing of advertisements,
	@params:	NULL
	@Created by: 	Ramanpreet Pal Kaur
	@Modify:	NULL
	@Created Date:	03-08-2010
	*/		

	function admin_index(){
		//check that admin is login
		$this->checkSessionAdmin();
		
		$criteria=' 1 ';
		if($this->RequestHandler->isAjax()==0)
			$this->layout = 'layout_admin';
		else
			$this->layout = 'ajax';
	
/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'Advertisement.id' => 'ASC'
					),
			'fields' => array(
					'Advertisement.id',
					'Advertisement.bannerurl',
					'Advertisement.bannerlabel',
					'Advertisement.banner_image',
					'Advertisement.status',
					'Advertisement.modified',
					'Advertisement.created',
				)
		);
		$this->set('listTitle','Manage Advertisements');
		$advertisements = $this->paginate('Advertisement',$criteria);
		$this->set('advertisements',$advertisements);
	}

	/**
	@function:admin_add
	@description:Add/edit advertisements,
	@params:id
	@Created by: Ramanpreet Pal Kaur
	@Modify:NULL
	@Created Date:03-10-2010
	*/
	function admin_add($id=Null){
		$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		if(empty($id))
			$this->set('listTitle','Add Advertisement');
		else
			$this->set('listTitle','Update Advertisement');
		$this->set("id",$id);
		
		if(!empty($this->data)){
			$this->Advertisement->set($this->data);
			if($this->Advertisement->validates()){
				/*** Upload Image if provided */
				if(!empty($this->data['Advertisement']['photo']['name'])){
					App::import('Component','File');
					$this->File=& new FileComponent();
					$this->File->destPath =  WWW_ROOT.PATH_ADVERTISEMENTS;
					$this->File->setFilename(time()."_".$this->data['Advertisement']['photo']['name']);
					$fileName  = $this->File->uploadFile($this->data['Advertisement']['photo']['name'],$this->data['Advertisement']['photo']['tmp_name']);
					//$this->Thumb->getResized($fileName, '', $this->File->destPath.'large/', $b_width, $b_height, 'FFFFFF', true, true,$this->File->destPath, false);
					if( !$fileName  ){ // Error in uploading
						$this->Session->setFlash('Error in uploading the image.','default',array('class'=>'flashError')); 
						$this->redirect('/admin/advertisements');
					}else{ // uploaded successful and delete the old file
						$this->Advertisement->id = $id;
						$oldfile = $this->Advertisement->findById($id);
						// delete old file
						$this->File->deleteFile( $oldfile['Advertisement']['banner_image']);
						$this->data['Advertisement']['banner_image']= $fileName;
					}
				}
				
				$this->data['Advertisement'] = Sanitize::clean($this->data['Advertisement']);
				if($this->Advertisement->save($this->data)) {
					$this->Session->setFlash('Information updated successfully.');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->set('errors',$this->Advertisement->validationErrors);
				}
			} else {
				$this->set('errors',$this->Advertisement->validationErrors);
			}
		} else{
			$this->Advertisement->id = $id;
			$this->data = $this->Advertisement->findById($id);
			
			
			if(!empty($this->data['Advertisement'])){
				foreach($this->data['Advertisement'] as $field_index => $info){
					$this->data['Advertisement'][$field_index] = html_entity_decode($info);
					$this->data['Advertisement'][$field_index] = str_replace('&#039;',"'",$this->data['Advertisement'][$field_index]);
					$this->data['Advertisement'][$field_index] = str_replace('\n',"",$this->data['Advertisement'][$field_index]);
				}
			}
		}
	}

	/**
	@function:	admin_view
	@description:	view advertisements,
	@Created by:	Ramanpreet Pal Kaur
	@Modify:	NULL
	@Created Date:	03-10-2010
	*/
	function admin_view($id){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->_validateId($id);
		$this->layout = 'layout_admin';
		$this->set('list_title','View ');
		$this->Advertisement->id = $id;
		$this->data = $this->Advertisement->read();
		
		
		if(!empty($this->data['Advertisement'])){
			foreach($this->data['Advertisement'] as $field_index => $info){
				$this->data['Advertisement'][$field_index] = html_entity_decode($info);
				$this->data['Advertisement'][$field_index] = str_replace('&#039;',"'",$this->data['Advertisement'][$field_index]);
				$this->data['Advertisement'][$field_index] = str_replace('\n',"",$this->data['Advertisement'][$field_index]);
			}
		}
	}
	
	/** 
	@function:		validateId 
	@description:		Validate of ID,
	@params:		id
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		03-10-2010
	*/
	function _validateId($id){
		if(empty($id) || !is_numeric($id)){
			$this->Session->setFlash('Id is missing.','default',array('class'=>'flashError'));
			$this->redirect('/admin/advertisements');
		}
	}

	/** 
	@function	:	admin_status
	@description	:	change the status of active/deactive
	@params		:	$id=id of row, $status=status
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		03-10-2010
	**/
	
	function admin_status($id,$status=0){
		$this->checkSessionAdmin();
		$this->Advertisement->id = $id;
		if($status==1){
			$this->Advertisement->saveField('status','0');
			$this->Session->setFlash('Records has been updated  successfully.');
		} else {
			$this->Advertisement->saveField('status','1');
			$this->Session->setFlash('Records has been updated  successfully.');
		}
		$this->redirect('/admin/advertisements/');
	}
	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	03-10-2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_multiplAction(){
		//check that admin is login
		$this->checkSessionAdmin();
		if($this->data['Advertisement']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
				$this->Advertisement->id=$id;
				$this->Advertisement->saveField('status','1');
				$this->Session->setFlash('Records has been updated  successfully.');
				}
			}
		} elseif($this->data['Advertisement']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Advertisement->id=$id;
					$this->Advertisement->saveField('status','0');
					$this->Session->setFlash('Records has been updated  successfully.');	
				}
			}
		} elseif($this->data['Advertisement']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$photo=$this->Advertisement->findById($id,'banner_image');
					if(!empty($photo['Advertisement']['banner_image'])){
						@chmod(IMAGES.'banners/'.$photo['Advertisement']['banner_image'],"0777");
						@unlink(IMAGES.'banners/'.$photo['Advertisement']['banner_image']);
					}
					$this->Advertisement->delete($id);
					$this->Session->setFlash('Records has been deleted successfully.');	
				}
			}
		}
		/** for searching and sorting*/
		$this->redirect('/admin/advertisements/');
	}

	/** 
	@function	:	admin_delete
	@description	:	Delete the content page
	@params		:	$id=id of row
	@created	:	03-05-2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete($id=null){
		//check that admin is login
		$this->checkSessionAdmin();
		if(!empty($id)){
			$photo=$this->Advertisement->findById($id,'banner_image');
			if(!empty($photo['Advertisement']['banner_image'])){
				@chmod(IMAGES.'banners/'.$photo['Advertisement']['banner_image'],"0777");
				@unlink(IMAGES.'banners/'.$photo['Advertisement']['banner_image']); 
			}
			$this->Advertisement->delete($id);
			$this->Session->setFlash('Records has been deleted successfully.');	
		} else{
			$this->Session->setFlash('Records has not deleted.');	
		}
		$this->redirect('/admin/advertisements');
	}

	
	/**
	* @Date: 
	* @Method : index
	* Created By: Ramanpreet Pal Kaur
	* @Purpose: This function is used to display static pages content on front end
	* @Param: none
	* @Return: none 
	**/
	function index(){
		App::import('Model','Page');
		$this->Page = & new Page();
		$this->layout = 'advertise';
		$this->data = $this->Page->find('first',array('conditions'=>array('Page.pagecode'=> 'advertisement-with-us')));
		/** Manage Title, meta description and meta keywords ***/
		$this->pageTitle  = $this->data['Page']['meta_title'];
		$this->set('title_for_layout',$this->data['Page']['meta_title']);
		$this->set('meta_description',$this->data['Page']['meta_description']);
		$this->set('meta_keywords',$this->data['Page']['meta_keyword']);
	}

	/**
	* @Date: 
	* @Method : contact
	* Created By: Ramanpreet Pal Kaur
	* @Purpose: This function is used for contact us for advertisement on front end
	* @Param: none
	* @Return: none 
	**/
	function contact(){
		$this->layout = 'front_popup';
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			$this->data = Sanitize::clean($this->data, array('encode' => false));	
				
			
			$vaild_data = 0;
			$this->Advertisement->set($this->data);
			$vaild_data = $this->Advertisement->validates();
			if(!empty($vaild_data)){
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);
				$this->Email->from = $this->data['Advertisement']['email'];
				$this->Email->replyTo= $this->data['Advertisement']['email'];
				$this->Email->sendAs= 'html';
				$to_sales_representative =  Configure::read('advertisementSales');
				$to_sales_representativeName =  ucwords(strtolower(Configure::read('advertisementSales_name')));
				
				
				
				$link=Configure::read('siteUrl');
				$this->Email->subject = 'Advertise with us';
				$data = '<table width="100%" border="0" cellspacing="2" cellpadding="2"><tr><td>Hi '.ucwords(strtolower($to_sales_representativeName)).'</td></tr>';
				$data = $data.'<tr><td>Following user wants to contact you for advertise with choiceful:</td></tr>';
				$data = $data.'<tr><td><table width="100%" border="0" cellspacing="2" cellpadding="2"><tr><td width = "20%"></td><td></td></tr>';
				$data = $data.'<tr><td>Full Name: </td><td>'.$this->data['Advertisement']['contact_name'].'</td></tr>';
				$data = $data.'<tr><td>Company: </td><td>'.$this->data['Advertisement']['company'].'</td></tr>';
				$data = $data.'<tr><td>Email: </td><td>'.$this->data['Advertisement']['email'].'</td></tr>';
				if(!empty($this->data['Advertisement']['website'])) {
					$data = $data.'<tr><td>Website: </td><td>'.$this->data['Advertisement']['website'].'</td></tr>';
				}
				if(!empty($this->data['Advertisement']['product_service'])) {
					$data = $data.'<tr><td>Product/Service: </td><td>'.$this->data['Advertisement']['product_service'].'</td></tr>';
				}
				if(!empty($this->data['Advertisement']['phone'])) {
					$data = $data.'<tr><td>Phone: </td><td>'.$this->data['Advertisement']['phone'].'</td></tr>';
				}
				if(!empty($this->data['Advertisement']['description'])) {
					$data = $data.'<tr><td>Description: </td><td>'.$this->data['Advertisement']['description'].'</td></tr>';
				}
				$data = $data.'</table></tr></td></table>';
				$this->set('data',$data);
				$this->Email->to = $to_sales_representative;
				/******import emailTemplate Model and get template****/
				$this->Email->template='commanEmailTemplate';
				if($this->Email->send()){
					$this->Session->setFlash('Email has set to sales representative successfully.');
					echo "<script type=\"text/javascript\">setTimeout('parent.jQuery.fancybox.close()',1000);</script>";
				} else {
					$this->Session->setFlash('An error occurred while sending the email. Please contact Customer Support at '.Configure::read('phone'),'default',array('class'=>'error_msg_box advertisement_mail_failed'));
				}
			} else{
				$errorArray = $this->Advertisement->validationErrors;
				$this->set('errors',$errorArray);
			}
		}
	}
}
?>