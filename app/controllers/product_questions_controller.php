<?php
/**  @class:		ProductQuestionsController 
 @description		
 @Created by: 		
 @Modify:		NULL
 @Created Date:		Dec 3, 2010
*/
class ProductQuestionsController extends AppController{
	var $name = 'ProductQuestions';
	var $helpers = array('Form','Html','Javascript','Format','Session','Ajax','Fck','Validation','Common');
	var $components = array ('RequestHandler','Email','Common');
	var $permission_id = 12 ;  // for reviews and QA module
	
	
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
		$includeBeforeFilter = array('admin_index', 'admin_add', 'admin_status','admin_delete',
			'admin_delete_answer','admin_multiplAction','admin_answer_multiplAction',
			'admin_answers','admin_add_answer','admin_answer_status' );
		if (in_array($this->params['action'],$includeBeforeFilter)){
			// validate admin session
			$this->checkSessionAdmin();
			
			// validate module 
			$this->validateAdminModule($this->permission_id);
		}
	}


	/**
	@function:admin_index
	@description:listing questions with product,
	@params:NULL
	@Created by: Ramanpreet Pal
	@Modify:NULL
	@Created Date:
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
		$options['ProductQuestion.question'] = "Question";
		$options['Product.product_name'] = "Product Name";
		$options['Product.quick_code'] = "Product Quick Code";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search']))
		{
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
					$criteria .= " and (ProductQuestion.question LIKE '%".$value1."%' OR Product.product_name LIKE '%".$value1."%' OR Product.quick_code LIKE '%".$value1."%')";
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
					$criteria .= " and ProductQuestion.status = '".$matchshow."'";
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
		} else if( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->ProductQuestion->expects(array('Product'));
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'ProductQuestion.id' => 'Desc'
			),
			'fields'=>array(
					'Product.product_name',
					'Product.quick_code',
					'ProductQuestion.id',
					'ProductQuestion.question',
					'ProductQuestion.status',
					'ProductQuestion.created'
				),
		);
		$this->set('listTitle','Manage Product Questions');
		$this->set('questions', $this->paginate('ProductQuestion',$criteria));
	}

	/** 
	@function:		admin_add 
	@description:		Add/edit product questions,
	@params:		id
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		3 Dec, 2010
	*/
	function admin_add($id=Null){
		
		$this->layout = 'layout_admin';
		if(empty($id))
			$this->set('listTitle','Add Question');
		else
			$this->set('listTitle','Update Question');
		$this->set("id",$id);
		if(!empty($this->data)){
			$this->ProductQuestion->set($this->data);
			if($this->ProductQuestion->validates()){
				App::import('Model','Product');
				$this->Product = new Product;
				$productId = $this->Product->find('first',array('conditions'=>array('Product.quick_code'=>$this->data['ProductQuestion']['quick_code']),'fields'=>array('Product.id')));
				if(!empty($productId)){
					$this->data['ProductQuestion']['product_id'] = $productId['Product']['id'];
					$this->ProductQuestion->set($this->data);
					if ($this->ProductQuestion->save($this->data)) {
						if(empty($id)){
							$this->Session->setFlash('Question added successfully.');
						} else{
							$this->Session->setFlash('Question updated successfully.');
						}
						$this->redirect(array('action' => 'index'));
					} else {
						if(empty($id)){
							$this->Session->setFlash('Question has not been added.','default',array('class'=>'flashError'));
						} else{
							$this->Session->setFlash('Question has not been updated.','default',array('class'=>'flashError'));
						}
					}
				} else{
					$this->Session->setFlash('The product with given qiuck code doesn\'t exists, please check again.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->ProductQuestion->validationErrors);
			}
		} else{
			if(!empty($id)){
				$this->ProductQuestion->id = $id;
				$this->ProductQuestion->expects(array('Product'));
				$question_detail = $this->ProductQuestion->find('first',array('conditions'=>array('ProductQuestion.id'=>$id),'fields'=>array('ProductQuestion.id','ProductQuestion.question','Product.quick_code')));
				$this->data = $question_detail;
				$this->data['ProductQuestion']['quick_code'] = $question_detail['Product']['quick_code'];
			}
			if(!empty($this->data['ProductQuestion'])){
				foreach($this->data['ProductQuestion'] as $field_index => $user_info){
					//$this->data['ProductQuestion'][$field_index] = html_entity_decode($user_info, ENT_NOQUOTES, 'UTF-8');
					$this->data['ProductQuestion'][$field_index] = html_entity_decode($this->Common->currencyEnter($user_info), ENT_NOQUOTES, 'UTF-8');
					$this->data['ProductQuestion'][$field_index] = str_replace('&#039;',"'",$this->data['ProductQuestion'][$field_index]);
				}
			}
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
	
	function admin_status($id=null,$status=null){
		
		$this->ProductQuestion->id = $id;
		if($status==1){
			$this->ProductQuestion->saveField('status','0');
			$this->Session->setFlash('Information updated  successfully.');
		} else {
			$this->ProductQuestion->saveField('status','1');
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
		$this->redirect('/admin/product_questions/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/** 
	@function	:	admin_delete
	@description	:	Delete the question
	@params		:	$id=id of row
	@created	:	Nov 12, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete($id=null){
		
		
		if($this->ProductQuestion->deleteAll("ProductQuestion.id ='".$id."'"))
			$this->Session->setFlash('Information deleted successfully.');
		else
			$this->Session->setFlash('Information not deleted.','default',array('class'=>'flashError'));	
		$this->redirect('/admin/product_questions/');
	}

	/** 
	@function	:	admin_delete_answer
	@description	:	Delete the answer
	@params		:	$id=id of row
	@created	:	Dec 7, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete_answer($id=null,$que_id = null){
		//check that admin is login
		App::import('Model','ProductAnswer');
		$this->ProductAnswer = new ProductAnswer;
		
		if($this->ProductAnswer->deleteAll("ProductAnswer.id ='".$id."'"))
			$this->Session->setFlash('Information deleted successfully.');
		else
			$this->Session->setFlash('Information not deleted.','default',array('class'=>'flashError'));	
		$this->redirect('/admin/product_questions/answers/'.$que_id);
	}

	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	Nov 12, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_multiplAction(){
		
		if($this->data['ProductQuestion']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->ProductQuestion->id=$id;
					$this->ProductQuestion->saveField('status','1');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} else if($this->data['ProductQuestion']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					
					$this->ProductQuestion->id=$id;
					$this->ProductQuestion->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} else if($this->data['ProductQuestion']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->ProductQuestion->delete($id);
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
		$this->redirect('/admin/product_questions/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}


	/** 
	@function	:	admin_answer_multiplAction
	@description	:	Active/Deactive/Delete multiple answers
	@params		:	NULL
	@created	:	Dec 7, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_answer_multiplAction($que_id = null){
		App::import('Model','ProductAnswer');
		$this->ProductAnswer = new ProductAnswer;
		
		if($this->data['ProductAnswer']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->ProductAnswer->id=$id;
					$this->ProductAnswer->saveField('status','1');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} else if($this->data['ProductAnswer']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->ProductAnswer->id=$id;
					$this->ProductAnswer->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} else if($this->data['ProductAnswer']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->ProductAnswer->delete($id);
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
		$this->redirect('/admin/product_questions/answers/'.$que_id.'/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/**
	@function:admin_answers
	@description:listing questions with product,
	@params:NULL
	@Created by: Ramanpreet Pal
	@Modify:NULL
	@Created Date:
	*/
	function admin_answers($que_id = null){
		//check that admin is login
		if(empty($que_id)){
			$this->Session->setFlash('Please click on some question, to see related answers.','default',array('class'=>'flashError'));
			$this->redirect('index');
		}
		App::import('Model','ProductAnswer');
		$this->ProductAnswer = new ProductAnswer;
		
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
		$criteria=' ProductAnswer.product_question_id = '.$que_id;
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$option['All'] = "All";
		$options['ProductAnswer.answer'] = "Answer";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search']))
		{
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
					$criteria .= " and (ProductAnswer.answer LIKE '%".$value1."%')";
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
					$criteria .= " and ProductAnswer.status = '".$matchshow."'";
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
		$sess_limit_name = $this->params['controller']."_anslimit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} else if( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'ProductAnswer.id' => 'Desc'
			),
			'fields'=>array(
				'ProductAnswer.answer',
				'ProductAnswer.id',
				'ProductAnswer.status',
				'ProductAnswer.created'
			),
		);
		$this->ProductQuestion->expects(array('Product'));
		$question_info = $this->ProductQuestion->find('first',array('conditions'=>array('ProductQuestion.id'=>$que_id),'fields'=>array('Product.product_name','Product.quick_code','ProductQuestion.id','ProductQuestion.question')));
		$this->set('listTitle','Manage Product Answers');
		$this->set('answers', $this->paginate('ProductAnswer',$criteria));
		$this->set('question_detail', $question_info);
	}

	/** 
	@function:		admin_add_answer 
	@description:		Add/edit product answers,
	@params:		id
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		3 Dec, 2010
	*/
	function admin_add_answer($ques_id=Null,$id = null){
		
		$this->layout = 'layout_admin';
		if(empty($id))
			$this->set('listTitle','Add Answer');
		else
			$this->set('listTitle','Update Answer');

		$this->set("id",$id);
		App::import('Model','ProductAnswer');
		$this->ProductAnswer = new ProductAnswer;
		if(!empty($this->data)){
			$this->ProductAnswer->set($this->data);
			if($this->ProductAnswer->validates()){
				if ($this->ProductAnswer->save($this->data)) {
					if(empty($id)){
						$this->Session->setFlash('Answer added successfully.');
					} else{
						$this->Session->setFlash('Answer updated successfully.');
					}
					$this->redirect('answers/'.$this->data['ProductAnswer']['product_question_id']);
				} else {
					if(empty($id)){
						$this->Session->setFlash('Answer has not been added.','default',array('class'=>'flashError'));
					} else{
						$this->Session->setFlash('Answer has not been updated.','default',array('class'=>'flashError'));
					}
				}
			} else {
				$this->set('errors',$this->ProductAnswer->validationErrors);
			}
		} else{
			
			
			$this->ProductAnswer->id = $id;
			$this->data = $this->ProductAnswer->find('first',array('conditions'=>array('ProductAnswer.id'=>$id),'fields'=>array('ProductAnswer.id','ProductAnswer.answer')));
		}
		$this->ProductQuestion->id = $ques_id;
		$this->ProductQuestion->expects(array('Product'));
		$question_detail = $this->ProductQuestion->find('first',array('conditions'=>array('ProductQuestion.id'=>$ques_id),'fields'=>array('ProductQuestion.id','ProductQuestion.product_id','ProductQuestion.question','Product.product_name','Product.quick_code')));
		$this->data['ProductAnswer']['product_question_id'] = $ques_id;
		$this->data['ProductAnswer']['product_id'] = $question_detail['ProductQuestion']['product_id'];
		
		$this->set('ques_id',$ques_id);
		$this->set('question_detail',$question_detail);
	}

	
	/** 
	@function	:	admin_status
	@description	:	change the status of active/deactive
	@params		:	$id=id of row, $status=status
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		03-05-2010
	**/
	
	function admin_answer_status($id=null,$status=null,$que_id = null){
		//check that admin is login
		App::import('Model','ProductAnswer');
		$this->ProductAnswer = new ProductAnswer;
		
		$this->ProductAnswer->id = $id;
		if($status==1){
			$this->ProductAnswer->saveField('status','0');
			$this->Session->setFlash('Information updated  successfully.');
		} else {
			$this->ProductAnswer->saveField('status','1');
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
		$this->redirect('/admin/product_questions/answers/'.$que_id.'/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}
	
	
	
} // classs ends here 
?>