<?php
/**  @class:		ChoicefulFavoritesController 
 @Created by: 		RAMANPREET PAL KAUR
 @Modify:		NULL
 @Created Date:		03-10-2010
*/
App::import('Sanitize');
class ChoicefulFavoritesController extends AppController{
	var $name = 'ChoicefulFavorites';
	var $helpers =  array('Html', 'Form','Common', 'Javascript','Session','Validation','Ajax', 'Format');
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
		$excludeBeforeFilter = array('view','index');
		if (!in_array($this->params['action'],$excludeBeforeFilter))
		{
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id);
			
		}
	}
	
	/**
	@function:	admin_index
	@description:	listing of choiceful favorites,
	@params:	NULL
	@Created by: 	Ramanpreet Pal Kaur
	@Modify:	NULL
	@Created Date:	03-08-2010
	*/

	function admin_index(){
		//check that admin is login
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
		$options['ChoicefulFavorite.title'] = "Title";
		$options['ChoicefulFavorite.favorite_url'] = "Url";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search']))
		{
			if(!empty($this->data['Search']['searchin']))
				$fieldname = $this->data['Search']['searchin'];
			else
				$fieldname = 'All';
			$value = trim($this->data['Search']['keyword']);
			// sanitize the data before search
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
					$criteria .= " and (ChoicefulFavorite.title LIKE '%".$value1."%' OR ChoicefulFavorite.favorite_url LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
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
					$criteria .= " and ChoicefulFavorite.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		/** sorting and search */
		if($this->RequestHandler->isAjax()==0)
			$this->layout = 'layout_admin';
		else
			$this->layout = 'ajax';
		$this->admin_choicefulfavoritelist($criteria,$value,$show,$fieldname);
	}

	/**
	@function:admin_add 
	@description:Add/edit choiceful favorites,
	@params:id
	@Created by: Ramanpreet Pal Kaur
	@Modify:NULL
	@Created Date:03-10-2010
	*/
	function admin_add($id=Null){
		$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		if(empty($id))
			$this->set('listTitle','Add Choiceful Favorite');
		else
			$this->set('listTitle','Update Choiceful Favorite');
		$this->set("id",$id);
		if(!empty($this->data)){
			$this->ChoicefulFavorite->set($this->data);
			if($this->ChoicefulFavorite->validates()){
				if(!empty($this->data['ChoicefulFavorite']['photo']['name'])){
					$this->File->destPath =  WWW_ROOT.PATH_CHOICEFUL_FAVORITE;
					$data=$this->data['ChoicefulFavorite']['photo'];
					$newName =time()."_".substr($data['name'],-10);
					$this->File->setFilename($newName);
					$file  = $this->File->uploadFile($data['name'],$data['tmp_name']);
					$mime = '';
					$this->Thumb->getResized($file, $mime, $this->File->destPath, 150, 35, 'FFFFFF', true, true,$this->File->destPath, false);
					if(empty($file)){
						$this->Session->setFlash('Image is not uploaded.','default',array('class'=>'flashError')); 
						$this->redirect('/admin/choiceful_favorites');
					} else{
						$this->ChoicefulFavorite->id = $id;
						$oldfile = $this->ChoicefulFavorite->findById($id);
						// delete old file
						$this->File->deleteFile( $oldfile['ChoicefulFavorite']['image']);
						$this->data['ChoicefulFavorite']['image']=$file;
					}
					
				}
				
				$this->data = Sanitize::clean($this->data);
				if ($this->ChoicefulFavorite->save($this->data)) {
					$this->Session->setFlash('Records has been updated successfully.');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->set('errors',$this->ChoicefulFavorite->validationErrors);
				}
			} else {
				$this->set('errors',$this->ChoicefulFavorite->validationErrors);
			}
		} else{
			$this->ChoicefulFavorite->id = $id;
			$this->data = $this->ChoicefulFavorite->findById($id);
			
			if(!empty($this->data['ChoicefulFavorite'])){
				foreach($this->data['ChoicefulFavorite'] as $field_index => $info){
					$this->data['ChoicefulFavorite'][$field_index] = html_entity_decode($info);
					$this->data['ChoicefulFavorite'][$field_index] = str_replace('&#039;',"'",$this->data['ChoicefulFavorite'][$field_index]);
					$this->data['ChoicefulFavorite'][$field_index] = str_replace('\n',"",$this->data['ChoicefulFavorite'][$field_index]);
				}
			}
		}
	}
	/**
	@function:	admin_view
	@description:	view choiceful favorites,
	@Created by:	Ramanpreet Pal Kaur
	@Modify:	NULL
	@Created Date:	03-10-2010
	*/
	function admin_view($id){
		$this->checkSessionAdmin();
		$this->_validateId($id);
		$this->layout = 'layout_admin';
		$this->set('list_title','View choiceful favorite');
		$this->ChoicefulFavorite->id = $id;
		$this->data = $this->ChoicefulFavorite->read();
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
			$this->redirect('/admin/choiceful_favorites');
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
		$this->ChoicefulFavorite->id = $id;
		if($status==1){
			$this->ChoicefulFavorite->saveField('status','0');
			$this->Session->setFlash('Records has been updated successfully.');
		} else {
			$this->ChoicefulFavorite->saveField('status','1');
			$this->Session->setFlash('Records has been updated successfully.');
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
		$this->redirect('/admin/choiceful_favorites/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
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
		if($this->data['ChoicefulFavorite']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
				$this->ChoicefulFavorite->id=$id;
				$this->ChoicefulFavorite->saveField('status','1');
				$this->Session->setFlash('Records has been updated successfully.');
				}
			}
		} elseif($this->data['ChoicefulFavorite']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->ChoicefulFavorite->id=$id;
					$this->ChoicefulFavorite->saveField('status','0');
					$this->Session->setFlash('Records has been updated successfully.');	
				}
			}
		} elseif($this->data['ChoicefulFavorite']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$photo=$this->ChoicefulFavorite->findById($id,'image');
					if(!empty($photo['ChoicefulFavorite']['image'])){
						@chmod(IMAGES.'choiceful_favorites/'.$photo['ChoicefulFavorite']['image'],"0777");
						@unlink(IMAGES.'choiceful_favorites/'.$photo['ChoicefulFavorite']['image']); 
					}
					$this->ChoicefulFavorite->delete($id);
					$this->Session->setFlash('Records has been deleted successfully.');	
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
		if(!empty($this->data['Search']['keyword']) && !empty($this->data['Search']['searchin']) && !empty($this->data['Search']['show']))
			$this->redirect('/admin/choiceful_favorites/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		else
			$this->redirect('/admin/choiceful_favorites');
	}

	/** 
	@function : admin_choicefulfavoritelist
	@description : to generate choiceful favoritelist for admin
	@Created by : Ramanpreet Pal Kaur
	@params : conditions,value,show, fields for list
	@Modify : 
	@Created Date : 
	*/
	function admin_choicefulfavoritelist($criteria = null,$value=null,$show=null,$fieldname=null){
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
		
		
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'ChoicefulFavorite.id' => 'DESC'
					),
			'fields' => array(
				'ChoicefulFavorite.id',
				'ChoicefulFavorite.favorite_url',
				'ChoicefulFavorite.title',
				'ChoicefulFavorite.image',
				'ChoicefulFavorite.status',
				'ChoicefulFavorite.modified',
				'ChoicefulFavorite.created',
			)
		);
		$this->set('listTitle','Manage Choiceful Favorites');
		$choiceful_favorites = $this->paginate('ChoicefulFavorite',$criteria);
		$this->set('choiceful_favorites',$choiceful_favorites);

		
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
			$photo=$this->ChoicefulFavorite->findById($id,'image');
			if(!empty($photo['ChoicefulFavorite']['image'])){
				@chmod(IMAGES.'choiceful_favorites/'.$photo['ChoicefulFavorite']['image'],"0777");
				@unlink(IMAGES.'choiceful_favorites/'.$photo['ChoicefulFavorite']['image']); 
			}
			$this->ChoicefulFavorite->delete($id);
			$this->Session->setFlash('Records has been deleted successfully.');	
		} else{
			$this->Session->setFlash('Records not deleted.','default',array('class'=>'flashError'));	
		}
		$this->redirect('index');
	}
}
?>