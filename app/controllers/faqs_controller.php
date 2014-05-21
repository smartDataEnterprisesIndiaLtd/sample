<?php
	/**
	* Faqs PagesController class
	* PHP versions 5.1.4
	* @date 
	* @Purpose:This controller handles all the functionalities regarding FAQ management.
	* @filesource
	* @author     
	* @revision
	* @copyright  Copyright @ 2010 smartData
	* @version 0.0.1 
	**/

App::import('Sanitize');
class FaqsController extends AppController
{
	var $name = "Faqs";
	var $helpers = array('Html', 'Form', 'Javascript','Session','Fck','Validation','Format','Common','Ajax');
	var $components = array('RequestHandler','Common');
	var $paginate = array();
	var $uses = array('Faq');
	
	/**
	* @Date: Dec 08, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		$this->detectMobileBrowser();
	}
	
	/**
	* @Date : Oct 14,2010
	* @Method : admin_index
	* @Purpose : This function is to show faqs.
	* @Param : none
	* @Return :  none
	**/
	function admin_index(){
		$this->set('listTitle', 'Faqs');
		$this->checkSessionAdmin();
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
		$value = '';
		$criteria=' 1 ';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['question'] = "Question";
		$options['answer'] = "Answer";
		$options['title'] = "Type";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		
		if(!empty($this->data['Search'])){
			$fieldname = $this->data['Search']['searchin'];
			$value = $this->data['Search']['keyword'];
			$value1= Sanitize::escape($value);
			$show = $this->data['Search']['show'];
			if($show == 'Active'){
				$matchshow = '1';
			}
			if($show == 'Deactive'){
				$matchshow = '0';
			}
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (Faq.question LIKE '%".$value1."%' OR Faq.answer LIKE '%".$value1."%' )";
				} elseif(trim($fieldname)=='title') {
					$criteria .= " and FaqCategory.".$fieldname." LIKE '%".$value1."%'";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and Faq.".$fieldname." LIKE '%".$value1."%'";
							$this->set("keyword",$value);
						} else{
							$this->set("keyword",$value);
						}
						$this->set('fieldname',$fieldname);
					}
				}
			}

			if(isset($show) && $show!==""){
				if($show == 'All'){
				} else {
					$criteria .= " and Faq.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		 
		/** sorting and search */
 		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
		$this->admin_faqlist($criteria,$value,$show,$fieldname);
	}

	/**
	* @Date : Oct 14,2010
	* @Method : admin_add
	* @Purpose : Function to add faqs.
	* @Param : $id
	* @Return : none
	**/

	function admin_add($id = null) {
		$this->checkSessionAdmin();
		$all_categories = $this->get_faq_categories();
		$this->set('categories', $all_categories);
		$page_id = "";
		$this->layout = 'layout_admin';
		if(!empty($this->data)) {
			$this->Faq->set($this->data['Faq']);
			$validate = $this->Faq->validates();
			$page_id = $this->data['Faq']['id'];
			if($validate){
				$mrClean = new Sanitize();
				$this->data['Faq']['question']=$mrClean->clean($this->data['Faq']['question']);
				if(!empty($this->data['Faq']['id'])){
					if($this->Faq->save($this->data['Faq'])){
						$this->Session->setFlash("Record has been updated successfully.");
					} else{
						$this->Session->setFlash("Record has not been updated.");
					}
				}else{
					if($this->Faq->save($this->data['Faq'])){
						$this->Session->setFlash("Record has been created successfully.");
					} else{
						$this->Session->setFlash("Record has not been created.");
					}
				}
				$this->redirect('/admin/faqs');
			} else{
				$errorArray = $this->Faq->validationErrors;
				$this->set('errors',$errorArray);
			}
		} elseif(isset($id) && is_numeric($id)){
			$this->data = $this->Faq->findById($id);
			
		
			if(!empty($this->data['Faq'])){
				foreach($this->data['Faq'] as $field_index => $info){
					$this->data['Faq'][$field_index] = html_entity_decode($info, ENT_NOQUOTES, 'UTF-8');
					//$this->data['Faq'][$field_index] = str_replace('&#039;',"'",$this->data['Faq'][$field_index]);
					//$this->data['Faq'][$field_index] = str_replace('\n',"",$this->data['Faq'][$field_index]);
				}
			}
			if(is_array($this->data)){
				$id = $this->data['Faq']['id'];
			}else{
				$this->redirect('faqs');
			}
		}
		$this->set('id',$id);
		$this->set('listTitle','Add question');
	}

	/**
	@function : admin_view
	@description : view content pages,
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Oct 14,2010
	*/
	function admin_view($id = null){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->_validateId($id);
		$this->layout = 'layout_admin';
		$this->set('list_title','View Question');
		$this->Faq->id = $id;$this->Faq->expects(array('FaqCategory'));
		$result = $this->Faq->read();
		
		if(!empty($result['Faq'])){
			foreach($result['Faq'] as $field_index => $info){
				$result['Faq'][$field_index] = html_entity_decode($info);
				$result['Faq'][$field_index] = str_replace('&#039;',"'",$result['Faq'][$field_index]);
				$result['Faq'][$field_index] = str_replace('\n',"",$result['Faq'][$field_index]);
			}
		}
		$this->set('result',$result);
	}
	
	/** 
	@function : validateId 
	@description : Validate of ID,
	@params : id
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Oct 14,2010
	*/
	function _validateId($id){
		if(empty($id) || !is_numeric($id)){
			$this->Session->setFlash('Id is missing.','default',array('class'=>'flashError'));
			$this->redirect('/admin/faqs');
		}
	}

	/**
	@function : admin_delete
	@description : Delete the content page
	@params : $id=id of row
	@created : Oct 14,2010
	@credated by : Ramanpreet Pal Kaur
	**/
	function admin_delete($id=null){
		//check that admin is login
		$this->checkSessionAdmin();
		if($this->Faq->deleteAll("Faq.id ='".$id."'"))
			$this->Session->setFlash('Information deleted successfully.');	
		else
			$this->Session->setFlash('Information not deleted.','default',array('class'=>'flashError'));	
		$this->redirect('/admin/faqs');
		
	}

	/**
	@function : admin_multiplAction
	@description : Active/Deactive/Delete multiple record
	@params : NULL
	@created : 03-05-2010
	@credated by : Ramanpreet Pal Kaur
	**/
	function admin_multiplAction(){
		//check that admin is login
		$this->checkSessionAdmin();
		if($this->data['Faq']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Faq->id=$id;
					$this->Faq->saveField('status','1');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['Faq']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Faq->id=$id;
					$this->Faq->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');	
				}
			}
		} elseif($this->data['Faq']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Faq->delete($id);
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
		$this->redirect('/admin/faqs/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/**
	@function : admin_status
	@description : change the status of active/deactive
	@params : $id=id of row, $status=status
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Oct 14,2010
	**/
	function admin_status($id,$status=0){	
		//check that admin is login
		$this->checkSessionAdmin();
		$this->Faq->id = $id;
		if($status == 1){
			$this->Faq->saveField('status','0');
			$this->set('img','red3.jpg');
			$this->set('alt','Inactive');
			$this->set('status','0');
			$this->Session->setFlash('Information updated  successfully.');
			$this->set('url','/admin/faqs/status/'.$id.'/0');
		} else {
			$this->Faq->saveField('status','1');
			$this->set('img','green2.jpg');
			$this->set('alt','Active');
			$this->set('status','1');
			$this->set('url','/admin/faqs/status/'.$id.'/1');	$this->Session->setFlash('Information updated  successfully.');
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
		$this->redirect('/admin/faqs/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/** 
	@function : admin_savesequense
	@description : to save sequence of questions
	@params : $faq_id, $sequence
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Oct 14,2010
	**/
	function admin_savesequense($faq_id = null, $sequence = null){
		$this->checkSessionAdmin();
		$this->Faq->id = $faq_id;
		$this->Faq->saveField('sequence',$sequence);
		$criteria = "1=1";
		$this->admin_faqlist($criteria);
		$this->layout='ajax';
		$this->viewPath = 'elements/admin' ;
		$this->render('faq_listing');
	}

	/**
	@function : admin_faqlist
	@description : to dispaly list of all questions
	@params : $criteria,$value,$show,$fieldname
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Oct 14,2010
	**/
	function admin_faqlist($criteria = null,$value=null,$show=null,$fieldname=null){
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
		
		$this->Faq->expects(array('FaqCategory'));
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'Faq.id' => 'DESC'
					),
			'fields' => array(
					'Faq.id',
					'Faq.question',
					'FaqCategory.title',
					'Faq.sequence',
					'Faq.answer',
					'Faq.faq_category_id',
					'Faq.created',
					'Faq.status',
					'Faq.modified'
				)
		);
		$data = $this->paginate('Faq',$criteria);
		$this->set('resultData', $data);
	}

	/** 
	@function : get_faq_categories
	@description : to generate list of all faq categories
	@params : 
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Oct 14,2010
	**/
	function get_faq_categories(){
		App::import("Model","FaqCategory");
		$this->FaqCategory = new FaqCategory();
		$allcategories = $this->FaqCategory->find('list',array('order'=>'title'));
		return $allcategories;
	}
	
	/** 
	@function : view all category questions 
	@description : view all category questions 
	@params : 
	@Created by : kulvinder singh
	@Modify : NULL
	@Created Date : Nov 02 ,2010
	**/
	function viewfaqs( $faqCategory_id = null ){
		$this->layout = 'staticpages';
		// fetch all faq categories 
		App::import('Model','FaqCategory');
		$this->FaqCategory = new FaqCategory();
		$this->set('faqCategoryArr' , $this->FaqCategory->find('all'));
		
		$faqsArr = $this->Faq->find('all',array('conditions'=>array('Faq.faq_category_id'=>$faqCategory_id,'Faq.status'=> 1 )));
		$this->set('faqsArr', $faqsArr);
	}
	/*****************************************/

	/**
	@function : view
	@description : to display faqs of a category on front end
	@params : 
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Nov 8,2010
	**/
	function view($category_id = null){
	if ($this->RequestHandler->isMobile()) {
		$this->layout = 'mobile/staticpages';
	} else{
		$this->layout = 'staticpages';
	}
$this->layout = 'staticpages';
		$allfaqs = $this->Faq->find('all',array('conditions'=>array('faq_category_id'=>$category_id,'status'=>1),'order'=>array('Faq.id')));
		if(!empty($allfaqs)){
			foreach($allfaqs as $index_faq => $result){
				if(!empty($result['Faq'])){
					foreach($result['Faq'] as $field_index => $info){
						$allfaqs[$index_faq]['Faq'][$field_index] = html_entity_decode($info);
						$allfaqs[$index_faq]['Faq'][$field_index] = str_replace('&#039;',"'",$allfaqs[$index_faq]['Faq'][$field_index]);
						$allfaqs[$index_faq]['Faq'][$field_index] = str_replace('\n',"",$allfaqs[$index_faq]['Faq'][$field_index]);
					}
				}
			}
		}
		
		App::import('Model','FaqCategory');
		$this->FaqCategory = new FaqCategory();
		$faqCategory = $this->FaqCategory->find('list');
		$this->set('faqCategoryArr' , $faqCategory);
		$this->set('allfaqs',$allfaqs);
	}
}
?>