<?php
/**  @class:		ReviewsController 
 @description		emial Templates  etc.,
 @Created by: 		
 @Modify:		NULL
 @Created Date:		11 Nov, 2010
*/
class ReviewsController extends AppController{
	var $name = 'Reviews';
	var $helpers = array('Form','Html','Javascript','Format','Session','Ajax','Fck','Validation');
	var $components = array ('RequestHandler','Email');
	
	var $permission_id = 12 ;  // for reviews and QA  module
	
	/**
	* @Date: Dec 08, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		//check session other than admin_login page
		$this->detectMobileBrowser();
		$includeBeforeFilter = array('admin_index',
			'admin_add','admin_view','admin_delete',
			'admin_status',	'admin_multiplAction','admin_delete_certificate',
			'admin_gift_certificate', 'admin_certificate_status',
			'admin_certificate_multiplAction', 'admin_add_gift_certificate'
		);
		if (in_array($this->params['action'],$includeBeforeFilter)) {
			//check that admin is login
			$this->checkSessionAdmin();
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id); 
		}
	}
	
	/**
	@function : admin_index
	@description : listing reviews,
	@params : NULL
	@Created by : Ramanpreet Pal
	@Modify : NULL
	@Created Date : 12 Nov, 2010
	*/
	function admin_index(){
		/** for paging and sorting we are setting values */
		if(empty($this->data)){
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin']=$this->params['named']['searchin'];
			else
				$this->data['Search']['searchin']='';
	
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
			if(isset($this->params['named']['showtype']))
				$this->data['Search']['show']=$this->params['named']['showtype'];
			else
				$this->data['Search']['show']='';
		}
		$criteria=' 1 ';
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$option['All'] = "All";
		$options['Product.quick_code'] = "Product Code";
		$options['Product.product_name'] = "Product Name";
		$options['User.firstname'] = "First Name ";
		$options['User.lastname'] = "Last Name ";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])) {
			if(empty($this->data['Search']['searchin'])){
				$fieldname = 'All';
			} else {
				$fieldname = $this->data['Search']['searchin'];
			}
			$value = $this->data['Search']['keyword'];
			$show = $this->data['Search']['show'];
			if($show == 'Active'){
				$matchshow = '1';
			}
			if($show == 'Deactive'){
				$matchshow = '0';
			}
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (User.firstname LIKE '%".$value1."%' OR User.lastname LIKE '%".$value1."%' OR Product.quick_code LIKE '%".$value1."%' OR Product.product_name LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
							
						}
					}
				}
			}
			if(isset($show) && $show!==""){
				if($show == 'All'){
				} else {
					$criteria .= " and Review.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		/** sorting and search */
 		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->Review->expects(array('User','Product'));
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'Review.id' => 'Desc'
			),
			'fields'=>array('Product.product_name','Product.quick_code','User.firstname','User.lastname','Review.created','Review.status','Review.id'),
		);
		$this->set('listTitle','Manage Reviews');
		$this->set('reviews', $this->paginate('Review',$criteria));
	}

	/** 
	@function : admin_add 
	@description : Add/edit user review,
	@params : id
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : 12 Nov, 2010
	*/
	function admin_add($id=Null){
	
		$this->layout = 'layout_admin';
		App::import('Model','User');
		$this->User = new User;
		
		App::import('Model','Product');
		$this->Product = new Product;

		if(empty($id))
			$this->set('listTitle','Add Review');
		else
			$this->set('listTitle','Update Review');

		$this->set("id",$id);
		if(!empty($this->data)){
			if($this->data['Review']['review_type'] == '2'){
				$this->data['Review']['review_value'] = '+1';
			} else if($this->data['Review']['review_type'] == '1'){
				$this->data['Review']['review_value'] = '0';
			} else if($this->data['Review']['review_type'] == '0'){
				$this->data['Review']['review_value'] = '-1';
			}
			$this->Review->set($this->data);
			if($this->Review->validates()){
				$this->data['Review']['user_email'] = trim($this->data['Review']['user_email']);
				$userArray = $this->User->findByEmail($this->data['Review']['user_email'], array('fields' =>'User.id') );
				if(is_array($userArray)  &&  $userArray['User']['id'] != '' ){
					$this->data['Review']['user_id'] = $userArray['User']['id'];
					if(!empty($this->data['Review']['product_code'])){
						$productId = $this->Product->find('first',array('conditions'=>array('Product.quick_code'=>$this->data['Review']['product_code']),'fields'=>array('Product.id')));
						if(!empty($productId)){
							$this->data['Review']['product_id'] = $productId['Product']['id'];
							$this->Review->set($this->data);
							if ($this->Review->save($this->data)) {
								if(empty($id)){
									$this->Session->setFlash('Review added successfully.');
								} else{
									$this->Session->setFlash('Review updated successfully.');
								}
								$this->redirect(array('action' => 'index'));
							} else {
								if(empty($id)){
									$this->Session->setFlash('Review has not been added.','default',array('class'=>'flashError'));
								} else{
									$this->Session->setFlash('Review has not been updated.','default',array('class'=>'flashError'));
								}
							}
						} else{
							$this->Session->setFlash('The product with given qiuck code doesn\'t exists, please check again.','default',array('class'=>'flashError'));
						}
					} else{
						$this->Session->setFlash('The product with given qiuck code doesn\'t exists, please check again.','default',array('class'=>'flashError'));
					}
				} else{
					$this->Session->setFlash('User does not exist in database. please check the user email.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->Review->validationErrors);
				$this->data['Review']['review_type'] = 2;
			}
		} else{
			if(!empty($id)){
				$this->Review->id = $id;
				$this->Review->expects(array('Product'));
				$review_detail = $this->Review->find('first',array('conditions'=>array('Review.id'=>$id),'fields'=>array('Review.id','Review.comments','Review.user_id','Review.review_type','Review.product_id','Product.quick_code')));
				$this->data = $review_detail;
				$this->data['Review']['product_code'] = $review_detail['Product']['quick_code'];
				$userArray = $this->User->findById($this->data['Review']['user_id'], array('fields' =>'User.email') );
				$this->data['Review']['user_email'] = $userArray['User']['email'];
				if(!empty($this->data['Review'])){
					foreach($this->data['Review'] as $field_index => $user_info){
						$this->data['Review'][$field_index] = html_entity_decode($user_info);
						$this->data['Review'][$field_index] = str_replace('&#039;',"'",$this->data['Review'][$field_index]);
					}
				}
				if(!empty($this->data['Product'])){
					foreach($this->data['Product'] as $field_index => $user_info){
						$this->data['Product'][$field_index] = html_entity_decode($user_info);
						$this->data['Product'][$field_index] = str_replace('&#039;',"'",$this->data['Product'][$field_index]);
					}
				}
			} else{
				$this->data['Review']['review_type'] = 2;
			}
		}
	}

	/**
	@function : admin_view 
	@description : view user review
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Nov 12, 2010
	*/
	function admin_view($id){
	
		$this->_validateId($id);
		$this->layout = 'layout_admin';
		$this->set('list_title','View User Rview about Product');
		$this->Review->expects(array('User','Product'));
		$this->Review->id = $id;
		$this->data = $this->Review->find('first',array('conditions'=>array('Review.id'=>$id),'fields'=>array('Product.quick_code','Product.product_name','Review.status','Review.review_type','Review.created','Review.modified','Review.comments','User.firstname','User.lastname')));
	}

	/**
	@function : validateId 
	@description : Validate of ID,
	@params : id
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Nov 12, 2010
	*/
	function _validateId($id){
		if(empty($id) || !is_numeric($id)){
			$this->Session->setFlash('Id is missing.','default',array('class'=>'flashError'));
			$this->redirect('/admin/reviews');
		}
	}

	/** 
	@function	:	admin_status
	@description	:	change the status of active/deactive
	@params		:	$id=id of row, $status=status
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		03-05-2010
	**/
	
	function admin_status($id,$status=null){
		
		$this->Review->id = $id;
		if($status==1){
			$this->Review->saveField('status','0');
			$this->Session->setFlash('Information updated  successfully.');
		} else {
			$this->Review->saveField('status','1');
			$this->Session->setFlash('Information updated  successfully.');
		}
		/** for search and sorting**/
		if(empty($this->data)){
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin']=$this->params['named']['searchin'];
			else
				$this->data['Search']['searchin']='';
	
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
			if(isset($this->params['named']['showtype']))
				$this->data['Search']['show']=$this->params['named']['showtype'];
			else
				$this->data['Search']['show']='';
		}
		$this->redirect('/admin/reviews/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/** 
	@function	:	admin_delete
	@description	:	Delete the review
	@params		:	$id=id of row
	@created	:	Nov 12, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete($id=null){
		
		if($this->Review->deleteAll("Review.id ='".$id."'"))
			$this->Session->setFlash('Information deleted successfully.');
		else
			$this->Session->setFlash('Information not deleted.','default',array('class'=>'flashError'));	
		$this->redirect('/admin/reviews');
	}
	/** 
	@function	:	admin_delete_certificate
	@description	:	Delete the certificate review
	@params		:	$id=id of row
	@created	:	Nov 12, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete_certificate($id = null) {
		//check that admin is login
		App::import('Model','CertificateReview');
		$this->CertificateReview = new CertificateReview;
		
		
		if($this->CertificateReview->deleteAll("CertificateReview.id ='".$id."'"))
			$this->Session->setFlash('Information deleted successfully.');
		else
			$this->Session->setFlash('Information not deleted.','default',array('class'=>'flashError'));	
		$this->redirect('/admin/reviews/gift_certificate');
	}


	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	Nov 12, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_multiplAction(){
		
		if($this->data['Review']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Review->id=$id;
					$this->Review->saveField('status','1');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['Review']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Review->id=$id;
					$this->Review->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['Review']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Review->delete($id);
					$this->Session->setFlash('Information deleted successfully.');
				}
			}
		}
		/** for searching and sorting*/
		if(empty($this->data)){
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin']=$this->params['named']['searchin'];
			else
				$this->data['Search']['searchin']='';
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
			if(isset($this->params['named']['showtype']))
				$this->data['Search']['show']=$this->params['named']['showtype'];
			else
				$this->data['Search']['show']='';
		}
		/** for searching and sorting*/
		$this->redirect('/admin/reviews/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/** 
	@function	:	add
	@description	:	To add new review from front end for a product
	@params		:	NULL
	@created	:	Nov 12, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function add($product_id = null) {
		if ($this->RequestHandler->isMobile()) {
            		// if device is mobile, change layout to mobile
           			$this->layout = 'ajax';
           		}else{
				$this->layout = 'front_popup';
		}
		$user = $this->Session->read('User');
		$overall_reviews = '';
		if(!empty($user)){
			if(!empty($this->data)){
				
				$this->data = $this->cleardata($this->data);
				$this->data = Sanitize::clean($this->data, array('encode' => false));
				
				if(empty($product_id)){
					if(!empty($this->data['Review']['product_id']))
						$product_id = $this->data['Review']['product_id'];
				}
				$this->data['Review']['user_id'] = $user['id'];
				if($user['user_type'] == 1)
					$this->data['Review']['user_type'] = 'Seller';
				else
					$this->data['Review']['user_type'] = 'Buyer';
				if($this->data['Review']['review_type'] == '2'){
					$this->data['Review']['review_value'] = '+1';
				} else if($this->data['Review']['review_type'] == '1'){
					$this->data['Review']['review_value'] = '0';
				} else if($this->data['Review']['review_type'] == '0'){
					$this->data['Review']['review_value'] = '-1';
				}
				$this->Review->set($this->data);
				if($this->Review->validates()){
					if($this->Review->save($this->data)){
						$this->Session->setFlash('Review added successfully.');
						if (!$this->RequestHandler->isMobile()) {
							echo "<script type=\"text/javascript\">
								parent.location.reload(true);
								parent.jQuery.fancybox.close();
								//alert('Hello')
								
							</script>";
						}
					} else{
						$this->Session->setFlash('Review has not been added successfully.');
						//echo "<script type=\"text/javascript\">parent.$.fancybox.close();
							//window.location.href='/users/login/';
						//</script>";
					}
					$errors = "";
					$this->set('errors',$errors);
				} else {
					$errors = $this->Review->validationErrors;
					
					if(!empty($this->data['Review'])){
						foreach($this->data['Review'] as $field_index => $user_info){
							$this->data['Review'][$field_index] = html_entity_decode($user_info);
							$this->data['Review'][$field_index] = str_replace('&#039;',"'",$this->data['Review'][$field_index]);
						}
					}
					if(!empty($errors['review_type'])){
						$this->data['Review']['review_type'] = null;
					}
					$this->set('errors',$errors);
				}
			}
			App::import('Model','Product');
			$this->Product = new Product;
			$pro_detail = $this->Product->find('first',array('conditions'=>array('Product.id'=>$product_id),'fields'=>array('Product.id','Product.quick_code','Product.product_name')));
			$all_reviews = $this->Review->find('list',array('conditions'=>array('Review.product_id = '.$product_id.' AND Review.status = "1"'),'fields'=>array('Review.id','Review.review_value')));
			$total_reviews = count($all_reviews);
			$over_all_review_value = 0;
			if(!empty($all_reviews)){
				foreach($all_reviews as $review_value){
					$over_all_review_value = $over_all_review_value + $review_value;
				}
			}
			if($over_all_review_value > 0){
				$over_all = 'Positive';
			} else if($over_all_review_value < 0){
				$over_all = 'Negative';
			} else if($over_all_review_value == 0){
				$over_all = 'Neutral';
			}
			$total_count_selected = count($all_reviews);
			$this->set('total_count_selected',$total_count_selected);
			$this->set('overall_reviews',$over_all);
			if(!empty($pro_detail)) {
				$this->data['Review']['product_code'] = $pro_detail['Product']['quick_code'];
				$this->data['Review']['product_id'] = $pro_detail['Product']['id'];
				$this->data['Review']['product_name'] = $pro_detail['Product']['product_name'];
			}
			$this->set('error',0);
		} else{
			$this->Session->setFlash('Please login first.','default',array('class'=>'flashError'));
			$this->set('error',1);
			
			//echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();</script>";

			echo "<script type=\"text/javascript\">setTimeout('parent.jQuery.fancybox.close()',1000);</script>";
			//s$this->redirect('/users/login');
		}
	}

	/** 
	@function	:	savevote
	@description	:	To add vote on a review from front end
	@params		:	NULL
	@created	:	
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function savevote($review_id = null , $vote = null, $review_type = null){
		App::import('Model','ReviewVote');
		$this->ReviewVote = new ReviewVote;
		if($this->RequestHandler->isMobile()){
			$this->viewPath = 'elements/mobile/product';
		}else{
			$this->viewPath = 'elements/product';
		}
		if(!empty($review_id)) {
			$this->data['ReviewVote']['review_id'] = $review_id;
			$this->data['ReviewVote']['user_vote'] = $vote;
			$this->set($this->data);
			if($this->ReviewVote->save($this->data)){
				if($review_type == 0) {
					$this->Session->write('votesaved_neg'.$review_id,1);
					$this->set('rev_neg_id',$review_id);
					$this->render('vote_neg');
				} else if($review_type == 1) {
					$this->Session->write('votesaved_neu'.$review_id,1);
					$this->set('rev_neu_id',$review_id);
					$this->render('vote_neu');
				} else if($review_type == 2) {
					$this->Session->write('votesaved_pos'.$review_id,1);
					$this->set('rev_pos_id',$review_id);
					$this->render('vote_pos');
				}
			} else{
				if($review_type == 0) {
					$this->Session->write('votesaved_neg'.$review_id,0);
					$this->set('rev_neg_id',$review_id);
					$this->render('vote_neg');
				} else if($review_type == 1) {
					$this->Session->write('votesaved_neu'.$review_id,0);
					$this->set('rev_neu_id',$review_id);
					$this->render('vote_neu');
				} else if($review_type == 2) {
					$this->Session->write('votesaved_pos'.$review_id,0);
					$this->set('rev_pos_id',$review_id);
					$this->render('vote_pos');
				}
			}
		} else{
			if($review_type == 0) {
				$this->Session->write('votesaved_neg'.$review_id,0);
				$this->set('rev_neg_id',$review_id);
				$this->render('vote_neg');
			} else if($review_type == 1 ){
				$this->Session->write('votesaved_neu'.$review_id,0);
				$this->set('rev_neu_id',$review_id);
				$this->render('vote_neu');
			} else if($review_type == 2) {
				$this->Session->write('votesaved_pos'.$review_id,0);
				$this->set('rev_pos_id',$review_id);
				$this->render('vote_pos');
			}
		}
	}

	/** 
	@function	:	report_review
	@description	:	To send report on a review from front end
	@params		:	NULL
	@created	:	
	@credated by	:	Ramanpreet Pal Kaur
	**/
	/*
	function report_review($review_id = null){
		$this->layout = 'front_popup';
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->Review->set($this->data);
			if($this->Review->validates()){
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);
				$this->Email->from = Configure::read('fromEmail');
				$this->Email->replyTo=Configure::read('replytoEmail');
				
				$this->Email->sendAs= 'html';

				$data = '<table width="100%" cellspacing="3" cellpadding ="3" border="0">';

				if($this->data['Review']['review_type'] == 2){
					$display_type = 'Positive';
				} else if($this->data['Review']['review_type'] == 1){
					$display_type = 'Neutral';
				} else {
					$display_type = 'Negative';
				}
				$data = $data.'<tr><td>You have received following report on  "('.$display_type.') '.$this->data['Review']['review'].'" review for  "'.$this->data['Review']['product_name'].'" product:</td></tr>';

				$data = $data.'<tr><td><br/>'.$this->data['Review']['reason'].'</td></tr>';

				$data = $data.'</table>';
				$this->Email->subject = 'Review report for '.$this->data['Review']['product_name'].' product';
				$this->set('data',$data);
				$this->Email->to = Configure::read('fromEmail');
				//import emailTemplate Model and get template
				$this->Email->template='commanEmailTemplate';

				if($this->Email->send()) {
					$this->Session->setFlash('Report has been sent successfully.');
					echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
						</script>";
				} else{
					$this->Session->setFlash('An error occurred while sending the email. Please try later.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->Review->validationErrors);
			}
		} else{
			$this->Review->expects(array('User','Product'));
			$review_detail = $this->Review->find('first',array('conditions'=>array('Review.id'=>$review_id),'fields'=>array('Review.id','Review.product_id','Review.review_type','Review.comments','Review.user_id','User.email','Product.product_name')));
			$this->data['Review']['user'] = $review_detail['User']['email'];
			$this->data['Review']['review_id'] = $review_detail['Review']['id'];
			$this->data['Review']['review_type'] = $review_detail['Review']['review_type'];
			$this->data['Review']['product_name'] = $review_detail['Product']['product_name'];
			$this->data['Review']['review'] = $review_detail['Review']['comments'];
		}
	}
	*/
	
	/** 
	@function	:	report_review
	@description	:	To send report on a review from front end
	@params		:	NULL
	@created	:	
	@credated by	:	Ramanpreet Pal Kaur
	@Modified by	: Vikas Uniyal
	@MOdified on	: Oct. 19, 2012
	@Modified Des.	: Email Template added
	**/
	function report_review($review_id = null){
		$this->layout = 'front_popup';
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->Review->set($this->data);
			if($this->Review->validates()){
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);
				
				$this->Email->replyTo=Configure::read('replytoEmail');
				$this->Email->sendAs= 'html';

				if($this->data['Review']['review_type'] == 2){
					$display_type = 'Positive';
				} else if($this->data['Review']['review_type'] == 1){
					$display_type = 'Neutral';
				} else {
					$display_type = 'Negative';
				}
				/******import emailTemplate Model and get template****/
				App::import('Model','EmailTemplate');
				$this->EmailTemplate = new EmailTemplate;
				/**
				table: email_templates
				id: 32
				description: Report mail format for admin
				*/
				$template = $this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>34)));
				$this->Email->from = $template['EmailTemplate']['from_email'];
				$pro_url_name = str_replace(array(' ','/','&quot;','&','andamp','and;'), array('-','','"','and','and','and'),$this->data['Review']['product_name']);
				$subject = str_replace('[ProductName]',$pro_url_name,$template['EmailTemplate']['subject']);
				$this->Email->subject = $subject;
				$data = $template['EmailTemplate']['description'];
				$data = str_replace('[DISPLAY_TYPE]', $display_type, $data);
				$data = str_replace('[ProductName]', trim($this->data['Review']['product_name']), $data);
				$data = str_replace('[REASON]', trim($this->data['Review']['reason']), $data);
				$link = '<a href="'.SITE_URL.$pro_url_name.'/categories/productdetail/'.$this->data["Review"]["product_id"].'">'.SITE_URL.$pro_url_name.'/categories/productdetail/'.$this->data["Review"]["product_id"].'</a>';
				$data = str_replace('[PRODUCT_URL]', $link, $data);
				$this->set('data',$data);
				$this->Email->to = Configure::read('fromEmail');
				/******import emailTemplate Model and get template****/
				$this->Email->template='commanEmailTemplate';
				//echo '<pre>'; print_r($this->Email); die;
				if($this->Email->send()) {
					$this->Session->setFlash('Report has been sent successfully.');
					echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
						</script>";
				} else{
					$this->Session->setFlash('An error occurred while sending the email. Please try later.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->Review->validationErrors);
			}
		} else{
			$this->Review->expects(array('User','Product'));
			$review_detail = $this->Review->find('first',array('conditions'=>array('Review.id'=>$review_id),'fields'=>array('Review.id','Review.product_id','Review.review_type','Review.comments','Review.user_id','User.email','Product.product_name')));
			$this->data['Review']['user'] = $review_detail['User']['email'];
			$this->data['Review']['review_id'] = $review_detail['Review']['id'];
			$this->data['Review']['review_type'] = $review_detail['Review']['review_type'];
			$this->data['Review']['product_name'] = $review_detail['Product']['product_name'];
			$this->data['Review']['product_id'] = $review_detail['Review']['product_id'];
			$this->data['Review']['review'] = $review_detail['Review']['comments'];
		}
	}
	

	/**
	@function : admin_index
	@description : listing reviews of gift certificate,
	@params : NULL
	@Created by : Ramanpreet Pal
	@Modify : NULL
	@Created Date : 11 Jan, 2011
	*/

	function admin_gift_certificate(){
		
		/** for paging and sorting we are setting values */
		if(empty($this->data)){
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin']=$this->params['named']['searchin'];
			else
				$this->data['Search']['searchin']='';
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
			if(isset($this->params['named']['showtype']))
				$this->data['Search']['show']=$this->params['named']['showtype'];
			else
				$this->data['Search']['show']='';
		}
		$criteria=' 1 ';
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$option['All'] = "All";
		$options['User.firstname'] = "First Name";
		$options['User.lastname'] = "Last Name";
		$options['CertificateReview.comments'] = "Review Comment";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])) {
			if(empty($this->data['Search']['searchin'])){
				$fieldname = 'All';
			} else {
				$fieldname = $this->data['Search']['searchin'];
			}
			$value = $this->data['Search']['keyword'];
			$show = $this->data['Search']['show'];
			if($show == 'Active') {
				$matchshow = '1';
			}
			if($show == 'Deactive') {
				$matchshow = '0';
			}
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (User.firstname LIKE '%".$value1."%' OR User.lastname LIKE '%".$value1."%' OR CertificateReview.comments LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
			if(isset($show) && $show!==""){
				if($show == 'All'){
				} else {
					$criteria .= " and CertificateReview.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		/** sorting and search */
 		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
		
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_giftcertilimit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */

		App::import('Model','CertificateReview');
		$this->CertificateReview = new CertificateReview;
		$this->CertificateReview->expects(array('User'));
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'CertificateReview.id' => 'Desc'
			),
			'fields'=>array('User.firstname','User.lastname','CertificateReview.created','CertificateReview.status','CertificateReview.id','CertificateReview.comments'),
		);
		$this->set('listTitle','Manage Gift Certificate Reviews');
		$this->set('reviews', $this->paginate('CertificateReview',$criteria));
	}

	/** 
	@function	:	admin_certificate_status
	@description	:	change the status of active/deactive
	@params		:	$id=id of row, $status=status
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		Jan 11, 2010
	**/
	
	function admin_certificate_status($id,$status=null){
		
		App::import('Model','CertificateReview');
		$this->CertificateReview = new CertificateReview;
		$this->CertificateReview->id = $id;
		if($status==1){
			$this->CertificateReview->saveField('status','0');
			$this->Session->setFlash('Information updated  successfully.');
		} else {
			$this->CertificateReview->saveField('status','1');
			$this->Session->setFlash('Information updated  successfully.');
		}
		/** for search and sorting**/
		if(empty($this->data)){
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin']=$this->params['named']['searchin'];
			else
				$this->data['Search']['searchin']='';
	
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
			if(isset($this->params['named']['showtype']))
				$this->data['Search']['show']=$this->params['named']['showtype'];
			else
				$this->data['Search']['show']='';
		}
		$this->redirect('/admin/reviews/gift_certificate/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/** 
	@function	:	admin_certificate_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	Jan 11, 2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	
	function admin_certificate_multiplAction(){
		
		App::import('Model','CertificateReview');
		$this->CertificateReview = new CertificateReview;
		if($this->data['CertificateReview']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->CertificateReview->id=$id;
					$this->CertificateReview->saveField('status','1');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['CertificateReview']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->CertificateReview->id=$id;
					$this->CertificateReview->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['CertificateReview']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->CertificateReview->delete($id);
					$this->CertificateReview->setFlash('Information deleted successfully.');
				}
			}
		}
		/** for searching and sorting*/
		if(empty($this->data)){
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin']=$this->params['named']['searchin'];
			else
				$this->data['Search']['searchin']='';
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
			if(isset($this->params['named']['showtype']))
				$this->data['Search']['show']=$this->params['named']['showtype'];
			else
				$this->data['Search']['show']='';
		}
		/** for searching and sorting*/
		$this->redirect('/admin/reviews/gift_certificate/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}


	/** 
	@function : admin_add_gift_certificate
	@description : Add/edit user review,
	@params : id
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : 12 Nov, 2010
	*/
	
	
	
	function admin_add_gift_certificate($id=Null){
		
		App::import('Model','CertificateReview');
		$this->CertificateReview = new CertificateReview;
		$this->layout = 'layout_admin';
		App::import('Model','User');
		$this->User = new User;
		
		if(empty($id))
			$this->set('listTitle','Add Gift Certificate Review');
		else
			$this->set('listTitle','Update Gift Certificate Review');

		$this->set("id",$id);
		if(!empty($this->data)){
			if($this->data['CertificateReview']['review_type'] == '2'){
				$this->data['CertificateReview']['review_value'] = '+1';
			} else if($this->data['CertificateReview']['review_type'] == '1'){
				$this->data['CertificateReview']['review_value'] = '0';
			} else if($this->data['CertificateReview']['review_type'] == '0'){
				$this->data['CertificateReview']['review_value'] = '-1';
			}
			$this->CertificateReview->set($this->data);
			if($this->CertificateReview->validates()){
				$this->data['CertificateReview']['user_email'] = trim($this->data['CertificateReview']['user_email']);
				$userArray = $this->User->findByEmail($this->data['CertificateReview']['user_email'], array('fields' =>'User.id') );

				if(is_array($userArray)  &&  $userArray['User']['id'] != '' ){
					$this->data['CertificateReview']['user_id'] = $userArray['User']['id'];
					$this->CertificateReview->set($this->data);
					if ($this->CertificateReview->save($this->data)) {
						if(empty($id)){
							$this->Session->setFlash('Review added successfully.');
						} else{
							$this->Session->setFlash('Review updated successfully.');
						}
						$this->redirect(array('action' => 'gift_certificate'));
					} else {
						if(empty($id)){
							$this->Session->setFlash('Review has not been added.','default',array('class'=>'flashError'));
						} else{
							$this->Session->setFlash('Review has not been updated.','default',array('class'=>'flashError'));
						}
					}
				} else{
					$this->Session->setFlash('User does not exist in database. please check the user email.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->CertificateReview->validationErrors);
				$this->data['CertificateReview']['review_type'] = 2;
				
				if(!empty($this->data['CertificateReview'])){
					foreach($this->data['CertificateReview'] as $field_index => $user_info){
						$this->data['CertificateReview'][$field_index] = html_entity_decode($user_info);
						$this->data['CertificateReview'][$field_index] = str_replace('&#039;',"'",$this->data['CertificateReview'][$field_index]);
					}
				}
			}
		} else{
			if(!empty($id)){
				$this->CertificateReview->id = $id;
				$review_detail = $this->CertificateReview->find('first',array('conditions'=>array('CertificateReview.id'=>$id),'fields'=>array('CertificateReview.id','CertificateReview.comments','CertificateReview.user_id','CertificateReview.review_type')));
				$this->data = $review_detail;
				$userArray = $this->User->findById($this->data['CertificateReview']['user_id'], array('fields' =>'User.email') );
				$this->data['CertificateReview']['user_email'] = $userArray['User']['email'];
				$this->data['CertificateReview']['id'] = $id;
				
					
				if(!empty($this->data['CertificateReview'])){
					foreach($this->data['CertificateReview'] as $field_index => $user_info){
						$this->data['CertificateReview'][$field_index] = html_entity_decode($user_info);
						$this->data['CertificateReview'][$field_index] = str_replace('&#039;',"'",$this->data['CertificateReview'][$field_index]);
					}
				}
			} else{
				$this->data['CertificateReview']['review_type'] = 2;
			}
		}
	}
}
?>