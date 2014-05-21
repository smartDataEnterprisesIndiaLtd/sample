<?php
/**  @class:		ChoicefulFavoritesController 
 @Created by: 		RAMANPREET PAL KAUR
 @Modify:		NULL
 @Created Date:		03-10-2010
*/
App::import('Sanitize');
class BlogsController extends AppController{
	var $name = 'Blogs';
	var $helpers = array('Form','Html','Javascript','Format','Session','Ajax','Fck','Validation','Common');
	var $components =  array('RequestHandler','Email','Common','File','Thumb','ImageResize');
	var $permission_id = 9;  // for promotions module
	
	/**
	* @Date: Nov 01, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none
	*
	*
	**/
	
	
	function beforeFilter()
	{
	$includeBeforeFilter = array('admin_index','admin_add','admin_reviewcomments', 'admin_view','admin_delete','admin_status','admin_multiplAction', 'admin_commentstatus','admin_blogslist','admin_blogCommentlist','admin_multiplAction1','admin_addcomment','admin_commentdelete','admin_reviewQuestions','admin_questionsdelete','admin_blogQuestionslist','admin_questionsdelete','admin_multiplAction','admin_multiplAction2','admin_addquestion');
		if (in_array($this->params['action'],$includeBeforeFilter)){
			//check that admin is login
			$this->checkSessionAdmin();
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id); 
		}
		
		
		// random articles starts here
		$randomblog = $this->Blog->find('first', array('conditions'=>array('Blog.status'=>1),'order' => array('rand()')));
		$this->set('randomblog',$randomblog);
		
		//ends
	}
	
	/**
	@function:	admin_index
	@description:	listing of choiceful favorites,
	@params:	NULL
	@Created by: 	Pradeep
	@Modify:	NULL
	@Created Date:	03-08-2010
	*/

	function admin_index(){
		//check that admin is login
		//$this->checkSessionAdmin();
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
				$this->data['Search']['limit']= 20;
		}
		$value = '';
		$criteria= ' 1 ';
		$matchshow = '';
		$fieldname = '';
		$show = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['title'] = "Title";
		$options['description'] = "Content";
		$options['publisher_name'] = "Publisher";
		
		$this->set('options',$options);
		if(!empty($this->data['Search']))
		{
			if(!empty($this->data['Search']['searchin'])){
				$fieldname = $this->data['Search']['searchin'];
			} else{
				$fieldname = 'All';
			}
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (Blog.title LIKE '%".$value1."%' OR Blog.description LIKE '%".$value1."%' )";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and Blog.".$fieldname." LIKE '%".$value1."%'";
							$this->set("keyword",$value);
						} else{
							$this->set("keyword",$value);
						}
						$this->set('fieldname',$fieldname);
					}
				}
			}
		}
		/** sorting and search */
		
		if($this->RequestHandler->isAjax()==0)
			$this->layout = 'layout_admin';
		else
			$this->layout = 'ajax';
			
		$this->set('keyword', $value);
		$this->set('fieldname',$fieldname);
		$this->admin_blogslist($criteria,$value,$show,$fieldname);
	}

	
	
	/**
	@function:	admin_index
	@description:	listing of choiceful favorites,
	@params:	NULL
	@Created by: 	Pradeep
	@Modify:	NULL
	@Created Date:	03-08-2010
	*/

	function admin_reviewComments($blog_id = null){
		
		//check that admin is login
		//$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
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
				$this->data['Search']['limit']= 20;
		}
		$value = '';
		//$criteria= ' 1 ';
		$matchshow = '';
		$fieldname = '';
		$show = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['name'] = "Name";
		$options['comment'] = "Comment";

		$this->set('options',$options);
		$criteria = 'BlogComment.blog_id = "'.$blog_id.'"';
		if(!empty($this->data['Search']))
		{
			if(!empty($this->data['Search']['searchin'])){
				$fieldname = $this->data['Search']['searchin'];
			} else{
				$fieldname = 'All';
			}
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (BlogComment.name LIKE '%".$value1."%' OR BlogComment.comment LIKE '%".$value1."%' )";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and BlogComment.".$fieldname." LIKE '%".$value1."%'";
							$this->set("keyword",$value);
						} else{
							$this->set("keyword",$value);
						}
						$this->set('fieldname',$fieldname);
					}
				}
			}
		}
		/** sorting and search */
		
		$this->set('blog_id',$blog_id);
		$this->set('keyword', $value);
		$this->set('fieldname',$fieldname);
		$this->admin_blogCommentlist($criteria,$value,$show,$fieldname);
	}

	/**
	@function:admin_add 
	@description:Add/edit blogs articles,
	@params:id
	@Created by: Pradeep
	@Modify:NULL
	@Created Date:03-10-2010
	*/
	function admin_add($id=Null){
		//$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		
		if(empty($id)) {
			$this->set('listTitle','Add New Blog Article');
		}
		else {
			$this->set('listTitle','Update Blog Article ');
		}
		$this->set("id",$id);
		if(!empty($this->data)){
			
			$this->Blog->set($this->data);
			$video_content = $this->data['Blog']['blog_video'];
			if($this->Blog->validates()){
				
			/***Image Uploading starts here**/
			
			if(!empty($this->data['Blog']['photo']['name'])){
			$imageType = $this->data['Blog']['photo']['type'];
			$imageTypeArr = explode('/',$imageType);
			$validImage = $this->File->validateImage($imageTypeArr[1]);
			if($validImage == true){
			$this->File->destPath =  WWW_ROOT.PATH_CHOICEFUL_BLOGS;
			$this->File->setFilename(time()."_".$this->data['Blog']['photo']['name']);
			$fileName  = $this->File->uploadFile($this->data['Blog']['photo']['name'],$this->data['Blog']['photo']['tmp_name']);
			$mime ='';
			$file = $fileName;
			if(file_exists($file)){
	  $imgSizeArr = getimagesize($file);
	  
	  $width=$imgSizeArr[0];$height=$imgSizeArr[1];
	}
		$this->ImageResize->resize($this->File->destPath.DS.$file,$this->File->destPath.'large/img_400_'.$file, $new_width = $width, $new_height = $height, $quality = 100);
			
			$this->ImageResize->resize($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_200_'.$file, $new_width = 279, $new_height = 0, $quality = 100);
			
			//$this->ImageResize->cropImage(279,0,0,0,0,'400','400',$this->File->destPath.'medium/img_200_'.$file, $this->File->destPath.'large/img_400_'.$file);
			
			$this->ImageResize->resize($this->File->destPath.DS.$file,$this->File->destPath.'small/img_75_'.$file, $new_width = 77, $new_height = 77, $quality = 100);
			
			
			$this->ImageResize->cropImage(77,0,0,0,0,'77','77',$this->File->destPath.'small/img_75_'.$file, $this->File->destPath.'small/img_75_'.$file);
			
			
			
		      ## delete the main directory substitue file
							
			## delete the main directory substitue file
			$this->File->deleteFile( $fileName);
						}
			if( !$fileName  ){ // Error in uploading
				$this->Session->setFlash('Error in uploading the image.','default',array('class'=>'flashError')); 
				$this->redirect('/admin/blogs');
			} else{ // uploaded successful and delete the old file
				$this->Blog->id = $id;
				$oldfile = $this->Blog->findById($id);
				// delete old file
				$this->File->deleteFile( $oldfile['Blog']['image']);
				$this->data['Blog']['image']= $fileName;
				
			}
					}
					/**ends*/
				
				
				$this->data = Sanitize::clean($this->data);
				
				$this->data['Blog']['blog_video'] = $this->data['Blog']['blog_video'];
				
				if ($this->Blog->save($this->data)) {
				/***starts insert search tags**/
				$this->loadModel('BlogSearchtag');
				$searchtagsArr = array();				
				$searchtagsarr = explode(",",$this->data['Blog']['blog_searchtag']);
				if(!empty($id)){
				$oldsearchtags = $this->BlogSearchtag->find('all',array('conditions'=>array('BlogSearchtag.blog_id'=>$id)));
				foreach ($oldsearchtags as $oldsearchtag)
				{
				$this->BlogSearchtag->id = NULL;
				$this->BlogSearchtag->delete( $oldsearchtag['BlogSearchtag']['id']);	
				}
				foreach ($searchtagsarr as $searchtagsArrK=>$searchtagsArrv) {
				$searchtagsArr['BlogSearchtag']['tags'] = $searchtagsArrv;
				$searchtagsArr['BlogSearchtag']['blog_id'] = $id;
				$this->BlogSearchtag->delete($searchtagsArr['BlogSearchtag']);
				$this->BlogSearchtag->id = NULL;
				$this->BlogSearchtag->save($searchtagsArr['BlogSearchtag']);
				}
				}
				else {
				foreach ($searchtagsarr as $searchtagsArrK=>$searchtagsArrv) {
				$searchtagsArr['BlogSearchtag']['tags'] = $searchtagsArrv;
				$searchtagsArr['BlogSearchtag']['blog_id'] = $this->Blog->getLastInsertID();
				$this->BlogSearchtag->id = NULL;
				$this->BlogSearchtag->save($searchtagsArr['BlogSearchtag']);
				}
				}
			
				/**ends**/
					
					if(empty($id)){
					// get last insert id from  product table
					$saved_blog_id = $this->Blog->getLastInsertId();
					$this->Session->setFlash('Records has been added successfully.');
						} else{
							$saved_blog_id = $id;
					$this->Session->setFlash('Records has been updated successfully.');
						}
					
		############ Other images  section #######################
	if( isset($this->data['Blog']['photom']) ){
		$other_images = $this->data['Blog']['photom'];
		// pr($other_images);
		// import the Blogimage DB
		App::import('Model', 'Blogimage');
		$this->Blogimage = new Blogimage();
		$this->data['Blogimage']['blog_id'] = $saved_blog_id;
		$this->File->destPath =  WWW_ROOT.PATH_CHOICEFUL_BLOGS;
		foreach($other_images as $temp_image){
			$imageType = $temp_image['type'];
			$imageTypeArr = explode('/',$imageType);
			$validImage = $this->File->validateImage($imageTypeArr[1]);
			if($validImage == true){
			$newName = time()."_".$temp_image['name'];
			$this->File->setFilename($newName);
			$file  = $this->File->uploadFile($temp_image['name'],$temp_image['tmp_name']);
			$subStituefileName =$file;
			$mime = '';
			
			$this->ImageResize->resize($this->File->destPath.DS.$file,$this->File->destPath.'large/img_400_'.$file, $new_width = 400, $new_height = 400, $quality = 100);
			
			//$this->ImageResize->resize($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_200_'.$file, $new_width = 279, $new_height = 203, $quality = 100);
			
			$this->ImageResize->cropImage(279,0,0,0,0,'279','203',$this->File->destPath.'medium/img_200_'.$file, $this->File->destPath.'large/img_400_'.$file);
			
			$this->ImageResize->resize($this->File->destPath.DS.$file,$this->File->destPath.'small/img_75_'.$file, $new_width = 77, $new_height = 77, $quality = 100);
			
			$this->ImageResize->cropImage(77,0,0,0,0,'77','77',$this->File->destPath.'small/img_75_'.$file, $this->File->destPath.'small/img_75_'.$file);
			
			
			/*@copy($this->File->destPath.DS.$file,$this->File->destPath.'large/img_400_'.$file);
			$this->Thumb->getResized('img_400_'.$file, $mime, $this->File->destPath.'large/', 400, 400, 'FFFFFF', true, true,$this->File->destPath.'large/', false);
			@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_200_'.$file);
			$this->Thumb->getResized('img_200_'.$file, $mime, $this->File->destPath.'medium/', 279, 203, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
			@copy($this->File->destPath.DS.$file,$this->File->destPath.'small/img_75_'.$file);
			$this->Thumb->getResized('img_75_'.$file, $mime, $this->File->destPath.'small/', 77, 77, 'FFFFFF', true, true,$this->File->destPath.'small/', false);*/
			$this->data['Blogimage']['id'] = 0;
			$this->data['Blogimage']['image'] = $file;
			$this->Blogimage->set($this->data);
			$this->Blogimage->save($this->data);
			$this->File->deleteFile($subStituefileName);
			}
		}
	}
			# ########## Other images  section ends here #######################
					$this->redirect(array('action' => 'index'));
				} else {
					$this->set('errors',$this->Blog->validationErrors);
				}
			} else {
				$this->set('errors',$this->Blog->validationErrors);
			}
		} else{
			
			$this->Blog->id = $id;
			$this->data = $this->Blog->findById($id);
			
			
			
			/**show search tags**/
			$searchtagsstr ='';
			if(!empty($this->data['BlogSearchtag'])){
			foreach ($this->data['BlogSearchtag'] as $searchtagsStrk=>$searchtagsStrv) {
				$searchtagsstr .= $searchtagsStrv['tags'].',';
				}
				$this->data['Blog']['blog_searchtag'] = substr($searchtagsstr,0,-1);
		}
			/***ends**/
			
			
			
			if(!empty($this->data['Blog'])){
				foreach($this->data['Blog'] as $field_index => $info){
					$this->data['Blog'][$field_index] = html_entity_decode($info);
					$this->data['Blog'][$field_index] = str_replace('&#039;',"'",$this->data['Blog'][$field_index]);
					$this->data['Blog'][$field_index] = str_replace('\n',"",$this->data['Blog'][$field_index]);
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
		//$this->checkSessionAdmin();
		$this->_validateId($id);
		$this->layout = 'layout_admin';
		$this->set('list_title','View choiceful blog article');
		$this->Blog->id = $id;
		$this->data = $this->Blog->read();
		
		if(!empty($this->data['Blog'])){
				foreach($this->data['Blog'] as $field_index => $info){
					$this->data['Blog'][$field_index] = html_entity_decode($info);
					$this->data['Blog'][$field_index] = str_replace('&#039;',"'",$this->data['Blog'][$field_index]);
					$this->data['Blog'][$field_index] = str_replace('\n',"",$this->data['Blog'][$field_index]);
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
			$this->redirect('/admin/blogs');
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
		//$this->checkSessionAdmin();
		$this->Blog->id = $id;
		if($status==1){
			$this->Blog->saveField('status','0');
			$this->Session->setFlash('Records has been updated successfully.');
		} else {
			$this->Blog->saveField('status','1');
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
		
		$this->redirect('/admin/blogs/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);

	}
	
	
	/** 
	@function	:	admin_commentstatus
	@description	:	change the status of active/deactive
	@params		:	$blog_id= $blog_id, $id=id of row, $status=status
	@Created by: 		Pradeep kumar
	@Modify:		NULL
	@Created Date:		03-10-2010
	**/
	
	function admin_commentstatus($blog_id,$id,$status=0){
		$this->checkSessionAdmin();
		$this->loadModel('BlogComment');
		$this->BlogComment->blog_id = $blog_id;
		$this->BlogComment->id = $id;
		
		if($status==1){
			$this->BlogComment->saveField('status','0');
			$this->Session->setFlash('Records has been updated successfully.');
		} else {
			$this->BlogComment->saveField('status','1');
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
		
		$this->redirect('/admin/blogs/reviewcomments/'.$blog_id.'/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		
		
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
		
		
		//$this->checkSessionAdmin();
		if($this->data['Blog']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
				$this->Blog->id=$id;
				$this->Blog->saveField('status','1');
				$this->Session->setFlash('Records has been updated successfully.');
				}
			}
		} elseif($this->data['Blog']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Blog->id=$id;
					$this->Blog->saveField('status','0');
					$this->Session->setFlash('Records has been updated successfully.');	
				}
			}
		} elseif($this->data['Blog']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$photo=$this->Blog->findById($id,'image');
					if(!empty($photo['Blog']['image'])){
						@chmod(IMAGES.'blogs/'.$photo['Blog']['image'],"0777");
						@unlink(IMAGES.'blogs/'.$photo['Blog']['image']); 
					}
					$this->Blog->delete($id);
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
			$this->redirect('/admin/blogs/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		else
			$this->redirect('/admin/blogs');
	}

	
	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	03-10-2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_multipleAction1($blog_id=null){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->loadModel('BlogComment');
		if($this->data['BlogComment']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
				$this->BlogComment->id=$id;
				$this->BlogComment->saveField('status','1');
				$this->Session->setFlash('Records has been updated successfully.');
				}
			}
		} elseif($this->data['BlogComment']['status']=='inactive'){
			
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->BlogComment->id=$id;
					$this->BlogComment->saveField('status','0');
					$this->Session->setFlash('Records has been updated successfully.');	
				}
			}
			
		} elseif($this->data['BlogComment']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->BlogComment->delete($id);
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
			$this->redirect('/admin/blogs/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		else
			$this->redirect('/admin/blogs/reviewcomments/'.$blog_id);
	}

	/** 
	@function : admin_choicefulfavoritelist
	@description : to generate choiceful favoritelist for admin
	@Created by : Ramanpreet Pal Kaur
	@params : conditions,value,show, fields for list
	@Modify : 
	@Created Date : 
	*/
	function admin_blogslist($criteria = null,$value=null,$show=null,$fieldname=null){
		$this->set('title', $value);
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
					'Blog.created' => 'DESC'
					),
			'contain'=> array('BlogComment'=>array('fields'=>array('name','id'))),
			'fields' => array(
				'Blog.id',
				'Blog.title',
				'Blog.publisher_name',
				'Blog.image',
				'Blog.status',
				'Blog.views',
				'Blog.modified',
				'Blog.created',
				
			)
		);
		$this->set('listTitle','Manage Blog Articles');
		
		$blogs = $this->paginate('Blog',$criteria);
		$this->set('blogs',$blogs);
		
	}
	
	/** 
	@function : admin_blogCommentlist
	@description : to generate comments of the blogs for admin
	@Created by : Pradeep
	@params : conditions,value,show, fields for list
	@Modify : 
	@Created Date : 
	*/
	function admin_blogCommentlist($criteria = null,$value=null,$show=null,$fieldname=null){
		
		$this->set('title', $value);
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
		
		$this->loadModel('BlogComment');
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'BlogComment.id' => 'DESC'
					),
			'fields' => array(
				'BlogComment.id',
				'BlogComment.blog_id',
				'BlogComment.name',
				'BlogComment.comment',
				'BlogComment.status',
				'BlogComment.modified',
				'BlogComment.created',
				
			)
		);
		$this->set('listTitle','Review Blog Articles Comments');
		$blogcomments = $this->paginate('BlogComment',$criteria);
		$this->set('blogcomments',$blogcomments);
		
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
		//$this->checkSessionAdmin();

		if(!empty($id)){
			$photo=$this->Blog->findById($id,'image');
			if(!empty($photo['Blog']['image'])){
				@chmod(IMAGES.'blogs/'.$photo['Blog']['image'],"0777");
				@unlink(IMAGES.'blogs/'.$photo['Blog']['image']); 
			}
			$this->Blog->delete($id);
			$this->Session->setFlash('Records has been deleted successfully.');	
		} else {
			$this->Session->setFlash('Records not deleted.','default',array('class'=>'flashError'));
			
			$this->loadModel('BlogComment');
			
		$blocomments = $this->BlogComment->find('all',array('conditions'=>array('BlogComment.blog_id'=>$id)));
				foreach ($blocomments as $blocomment)
				{
				$this->BlogComment->id = NULL;
				$this->BlogComment->delete( $blocomment['BlogComment']['id']);	
				}
		}
		$this->redirect('index');
	}
	
	
	/**
	@function:admin_add 
	@description:Add/edit choiceful favorites,
	@params:id
	@Created by: Pradeep
	@Modify:NULL
	@Created Date:03-10-2010
	*/
	function admin_addcomment($blog_id=null, $id=null){
		
		$this->loadModel('BlogComment');
		$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		if(empty($id)) {
			$this->set('listTitle','Add New Comment');
		}
		else {
			$this->set('listTitle','Update New Comment');
		}
		$this->set("id",$id);
		$this->set("blog_id",$blog_id);
		if(!empty($this->data)){
			$this->BlogComment->set($this->data);
			if($this->BlogComment->validates()){
				//$this->data = Sanitize::clean($this->data, array('encode' => false));
				
				$this->data =$this->cleardata($this->data);
			
				if ($this->BlogComment->save($this->data)) {
					$this->Session->setFlash('Records has been updated successfully.');
					$this->redirect(array('action' => 'reviewcomments',$blog_id));
				} else {
					$this->set('errors',$this->BlogComment->validationErrors);
					
				}
			} else {
				$this->set('errors',$this->BlogComment->validationErrors);
			}
		}
		else {
			
			
			$this->BlogComment->id = $id;
			$this->data = $this->BlogComment->findById($id);
			
			if(!empty($this->data['BlogComment'])){
				foreach($this->data['BlogComment'] as $field_index => $info){
					$this->data['BlogComment'][$field_index] = html_entity_decode($info);
					$this->data['BlogComment'][$field_index] = str_replace('&#039;',"'",$this->data['BlogComment'][$field_index]);
					$this->data['BlogComment'][$field_index] = str_replace('\n',"",$this->data['BlogComment'][$field_index]);
				}
			}
		}
	}
	
	/** 
	@function	:	admin_commentdelete
	@description	:	Delete the commenst of the blog page
	@params		:	$id=id of row
	@created	:	03-05-2010
	@credated by	:	Pradeep
	**/
	function admin_commentdelete($blog_id=null, $id=null){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->loadModel('BlogComment');
		if(!empty($id)){
			$this->BlogComment->delete($id);
			$this->Session->setFlash('Records has been deleted successfully.');	
		} else{
			$this->Session->setFlash('Records not deleted.','default',array('class'=>'flashError'));	
		}
		$this->redirect('/admin/blogs/reviewcomments/'.$blog_id);
	}
	
	
	/** 
	@function	: delete_blog_image (Multiple images)
	@description	: to delete blog image
	*/
	function delete_blog_image($blogimage_id = null){
		App::import('Model', 'Blogimage');
		$this->Blogimage = new Blogimage();
		$photo=$this->Blogimage->find('first',array('conditions'=>array('Blogimage.id'=>$blogimage_id),'fields'=>array('Blogimage.blog_id','Blogimage.image')));
		$blog_id = $photo['Blogimage']['blog_id'];
		if(!empty($photo['Blogimage']['image'])){
			
			@chmod(IMAGES.'blogs/'.$photo['Blogimage']['image'],"0777");
			@chmod(IMAGES.'blogs/medium/img_200_'.$photo['Blogimage']['image'],"0777");
			@chmod(IMAGES.'blogs/large/img_400_'.$photo['Blogimage']['image'],"0777");
			@chmod(IMAGES.'blogs/small/img_75_'.$photo['Blogimage']['image'],"0777");
			@unlink(IMAGES.'blogs/'.$photo['Blogimage']['image']);
			@unlink(IMAGES.'blogs/medium/img_200_'.$photo['Blogimage']['image']);
			@unlink(IMAGES.'blogs/large/img_400_'.$photo['Blogimage']['image']);
			@unlink(IMAGES.'blogs/small/img_75_'.$photo['Blogimage']['image']);
		}
		$this->Blogimage->delete($blogimage_id);
		$this->redirect('/admin/blogs/add/'.$blog_id);
	}
	
	
	/** 
	@function	: delete_image
	@description	: to delete blog main image
	*/
	function delete_image($id = null){
		$conditions = array('Blog.id ='.$id);
		$photo = $this->Blog->find('first',array('conditions'=>$conditions,'fields' => array('Blog.image')));
		$this->Blog->id = $id;
		if($this->Blog->saveField('image','')){
			@chmod(IMAGES.'blogs/'.$photo['Blogimage']['image'],"0777");
			@chmod(IMAGES.'blogs/medium/img_200_'.$photo['Blogimage']['image'],"0777");
			@chmod(IMAGES.'blogs/large/img_400_'.$photo['Blogimage']['image'],"0777");
			@chmod(IMAGES.'blogs/small/img_75_'.$photo['Blogimage']['image'],"0777");
			@unlink(IMAGES.'blogs/'.$photo['Blogimage']['image']);
			@unlink(IMAGES.'blogs/medium/img_200_'.$photo['Blogimage']['image']);
			@unlink(IMAGES.'blogs/large/img_400_'.$photo['Blogimage']['image']);
			@unlink(IMAGES.'blogs/small/img_75_'.$photo['Blogimage']['image']);
			}
			$this->Session->setFlash("Image has been deleted successfully.");
		$this->redirect('/admin/blogs/add/'.$id);
	}
	
	/** 
	@function	:	index
	@description	:	Display the blogs at the front end
	@params		:	NULL
	@created	:	07-01-2013
	@credated by	:	Pradeep	
	**/
		function blog_left_more($start=0){
		
		$this->layout = "";
		$end = 20;
		$startN = $start; 
		$blogs = $this->Blog->find('all',array('conditions'=>array('Blog.status'=>1),'order' => 'Blog.views DESC','limit'=>"$startN,$end"));
		$this->set("blogs_left",$blogs);
		$this->render('/elements/blogs/blog_left_more');
	}
	function blog_left_more_detail($start=0){
		
		$this->layout = "";
		$end = 10;
		$startN = $start; 
		$blogs = $this->Blog->find('all',array('conditions'=>array('Blog.status'=>1),'order' => 'Blog.views DESC','limit'=>"$startN,$end"));
		$this->set("blogs_left",$blogs);
		$this->render('/elements/blogs/blog_left_more');
	}
	
	    function getConnectionWithAccessToken($oauth_token, $oauth_token_secret) {
	App::import('Vendor', 'TwitterOAuth', array('file' => 'twitteroauth-master'.DS.'twitteroauth'.DS.'twitteroauth.php'));
      $connection = new TwitterOAuth("lQuNaoOqFdLTmFwOH9R43w", "1be9nx8Ff8UnjLduJsE3cuPbrZSpNR8RZGYXnpbcZxo", $oauth_token, $oauth_token_secret);

      return $connection;

    }
    
	function get_page_posts_int($start=0,$pageId=0){
		//$this->layout = "";
		$end = 10;
		$blogs = $this->Blog->find('all',array('conditions'=>array('Blog.status'=>1),'order' => 'Blog.created DESC','limit'=>"$start,$end"));
		return $blogs;		
		
	}
	function index(){
			
 $connection = $this->getConnectionWithAccessToken("475169124-KoHG7xO99GzvRHnNCZmOx2v5RmbQOjyx8zkgmhs", "aVDNfaNw2L3GbYrddsjI9pJW8mUkumu8EHxLqcVs0");
//$content = $connection->get('users/show', array('screen_name' => 'simaran12'));
    $content = $connection->get("statuses/user_timeline");
   // pr($content);
    if(!empty($content)){
    $this->set('content',$content);
    }
		$this->set('title_for_layout','Choiceful.com Blog');
		$this->layout = 'layout_blog';
                $blogs  = $this->Blog->find('all',array('conditions'=>array('Blog.status'=>1),'order' => 'Blog.views DESC','limit'=>"0,20"));
		$this->set("blogs_left",$blogs);
		
		$blogs_main = $this->get_page_posts_int(0);
		
		$this->set("blogs_main12",$blogs_main);
		
		
		/***testimonails starts here */
		$this->loadModel('Testimonial');
		$testimonials = $this->Testimonial->find('first', array('conditions'=>array('Testimonial.status'=>1),'order' => array('rand()')));
		$this->set('testimonials',$testimonials);
		
	
		/**ends**/
		
		/***blogs count starts here*/
		
		$pCount = $this->Blog->find('count',array('conditions'=>array('Blog.status'=>1),'contain'=>false));
		$this->set('pCount',$pCount);
	
		/**ends**/
		
		/*if(!empty($this->data['Blog']['keywords'])){

		$this->redirect(Configure::read('siteUrl').'/products/searchresult/keywords:'.$this->data['Blog']['keywords']);
		}
		*/
		
		
		
        }
	
	function blogSearch()
	{
		if(!empty($this->data['Blog']['keywords'])){

		$this->redirect(Configure::read('siteUrl').'/products/searchresult/keywords:'.$this->data['Blog']['keywords']);
		}
		
	}
	
	
	function blogDetails($blog_id=null){

		
		$connection = $this->getConnectionWithAccessToken("475169124-KoHG7xO99GzvRHnNCZmOx2v5RmbQOjyx8zkgmhs", "aVDNfaNw2L3GbYrddsjI9pJW8mUkumu8EHxLqcVs0");
		//$content = $connection->get('users/show', array('screen_name' => 'simaran12'));
		$content = $connection->get("statuses/user_timeline");
	    
		if(!empty($content)){
		$this->set('content',$content);
		}
		
		$pCount = $this->Blog->find('count',array('conditions'=>array('Blog.status'=>1),'contain'=>false));
		$this->set('pCount',$pCount);
		/*******ends********/
		/**left panel blogs starts here**/
		$this->layout = 'layout_blog';
                $blogs       = $this->Blog->find('all',array('conditions'=>array('Blog.status'=>1),'order' => 'Blog.views DESC','limit'=>10));
		$this->set("blogs_left",$blogs);
		
		/***testimonails starts here */
		$this->loadModel('Testimonial');
		$testimonials = $this->Testimonial->find('first', array('conditions'=>array('Testimonial.status'=>1),'order' => array('rand()')));
		$this->set('testimonials',$testimonials);
		/****ends***/
		
		
		/***load Questions starts here */
		$this->loadModel('BlogQuestion');
		$questions = $this->BlogQuestion->find('first', array('conditions'=>array('BlogQuestion.status'=>1),'contain'=>array('BlogQuestionAnswer'=>array('fields'=>array('answer','id','question_id','correct_answer'))),'order' => array('rand()')));
	
		$this->set('questions',$questions);
		
		/**ends**/
		
		if(!empty($this->data['Blog']['keywords'])){
		$this->redirect(Configure::read('siteUrl').'/products/searchresult/keywords:'.$this->data['Blog']['keywords']);
		}
		
		if(!empty($this->data)) {
			$this->addcomment($blog_id);
		}
		
		if(isset($blog_id) && !empty($blog_id)){
			$blogDetails = $this->Blog->find('first', array('conditions' => array('Blog.slug' => $blog_id)));
			$blog_id = $blogDetails['Blog']['id'];
		}
		
		if(!empty($blog_id)) {
		// blog details
		$this->layout = 'layout_blog';
		$this->_validateId($blog_id);
		$this->Blog->id = $blog_id;
		$this->data = $this->Blog->read();
		$this->set('meta_keywords',$this->data['Blog']['meta_keyword']);
		$this->set('meta_description',$this->data['Blog']['meta_description']);
		$this->set('title_for_layout',$this->data['Blog']['title']);
		$this->set('arctile_title',$this->data['Blog']['title']); 
		 }
		 else
		 {
		 $this->Session->setFlash("I'm sorry we could not find the requested blog article -- it may no longer be available");
		 $this->redirect('/blog');	
		 }
		
		//ends
		if(!empty($this->data['Blog'])){
				foreach($this->data['Blog'] as $field_index => $info){
					$this->data['Blog'][$field_index] = html_entity_decode($info);
					$this->data['Blog'][$field_index] = str_replace('&#039;',"'",$this->data['Blog'][$field_index]);
					$this->data['Blog'][$field_index] = str_replace('\n',"",$this->data['Blog'][$field_index]);
				}
			}
		
		/***update views count starts here***/
		$views= ($this->data['Blog']['views'] + 1);
		$query = "update blogs set views=".$views." where id=".$blog_id;
		$this->Blog->query($query);
		/**ends**/
		
		
        }
	
	
	
	/**
	@function:addcomment 
	@description:Add/edit blog comment,
	@params:blog id, commentid
	@Created by: Pradeep
	@Modify:NULL
	@Created Date:10-01-2013
	*/
	function addcomment($blog_id=null){
		
		$this->loadModel('BlogComment');
		$this->set("blog_id",$blog_id);
		
		
		if(!empty($this->data)){
			$this->BlogComment->set($this->data);
			if($this->BlogComment->validates()){
			$this->data = $this->cleardata($this->data);
			$correctanswer = (empty($this->data['BlogQuestionAnswer']['correct_answer'])) ? '' : $this->data['BlogQuestionAnswer']['correct_answer'];
			$question_id = isset($this->data['BlogQuestion']['newid']) && !empty($this->data['BlogQuestion']['newid'])? $this->data['BlogQuestion']['newid'] :$this->data['BlogQuestion']['id'];
			$answer = $this->checkCorrectAnswer($question_id,$correctanswer);
				
				if ($answer && $this->BlogComment->save($this->data)) {
					
					$this->redirect(array('action' => 'blogdetails',$blog_id));
				} else {
					
					$this->set('errors',$this->BlogComment->validationErrors);
					$this->set('qerrors','wrong-answer');
					
				}
			} else {
				$this->set('errors',$this->BlogComment->validationErrors);
				
			}
		}
		
	}
	
	/**
	* Function Description - To get more blog artciles on the page
	*
	* @name - get_pages
	* @Date: 03rd Sept 2012
	* @Method : get_pages
	* @Purpose: To get more pages by scroll down
	* @author - Pradeep
	* @Last Modified Date - 03rd Sept 2012
	* @Modified By- Pradeep
	* @return - none
	* @param - none
	* 
	**/
	function get_page_posts($start=0,$pageId=0){
		$this->layout = "";
		$end = 10;
		$blogs = $this->Blog->find('all',array('conditions'=>array('Blog.status'=>1),'order' => 'Blog.created DESC','limit'=>"$start,$end"));
		$this->set("blogs",$blogs);
		$this->render('/elements/blogs/blog_posts_listing');
				
		
	}
	
	
	
	
	function getcomments($blog_id, $sortby=null)
	{
		
		$this->loadModel('BlogComment');
		$this->layout = "";
		if(!empty($sortby) && $sortby=='new'){
			$sort = 'BlogComment.created DESC';
		}
		else if(!empty($sortby) && $sortby=='old'){
			$sort = 'BlogComment.created ASC';
		}
		else {
		$sort = 'BlogComment.id DESC';	
		}
		$blogscomments      = $this->BlogComment->find('all',array('conditions'=>array('BlogComment.blog_id'=>$blog_id),'order' => $sort));
		
		$this->set("bcomments",$blogscomments);
		
		$this->render('/elements/blogs/blog_postcomment_listing');
		
	}
	
	

	/**
	@function:	admin_index
	@description:	listing of choiceful blogs questions answers,
	@params:	NULL
	@Created by: 	Pradeep
	@Modify:	NULL
	@Created Date:	03-08-2010
	*/

	function admin_reviewQuestions(){
		
		//check that admin is login
		//$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
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
				$this->data['Search']['limit']= 20;
		}
		$value = '';
		//$criteria= ' 1 ';
		$matchshow = '';
		$fieldname = '';
		$show = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['question'] = "Question";
		$options['answer'] = "Correct Answer";

		$this->set('options',$options);
		$criteria =1;
		if(!empty($this->data['Search']))
		{
			if(!empty($this->data['Search']['searchin'])){
				$fieldname = $this->data['Search']['searchin'];
			} else{
				$fieldname = 'All';
			}
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (BlogQuestion.question LIKE '%".$value1."%' OR BlogQuestion.answer LIKE '%".$value1."%' )";
				} else {
					
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and BlogQuestion.".$fieldname." LIKE '%".$value1."%'";
							$this->set("keyword",$value);
						} else{
							$this->set("keyword",$value);
						}
						$this->set('fieldname',$fieldname);
					}
					
					
				}
			}
		}
		/** sorting and search */
		
		
		$this->set('keyword', $value);
		$this->set('fieldname',$fieldname);
		$this->admin_blogQuestionslist($criteria,$value,$show,$fieldname);
	}


/** 
	@function : admin_blogCommentlist
	@description : to generate comments of the blogs for admin
	@Created by : Pradeep
	@params : conditions,value,show, fields for list
	@Modify : 
	@Created Date : 
	*/
	function admin_blogQuestionslist($criteria = null,$value=null,$show=null,$fieldname=null){
		$this->set('title', $value);
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
		
		$this->loadModel('BlogQuestion');
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'BlogQuestion.id' => 'DESC'
					),
			'contain'=>array('BlogQuestionAnswer'=>array('conditions'=>array('BlogQuestionAnswer.correct_answer'=>1),'fields'=>array('answer','id','question_id','correct_answer'))),
			'fields' => array(
				'BlogQuestion.id',
				'BlogQuestion.question',
				'BlogQuestion.number_of_answers',
				'BlogQuestion.status',
				'BlogQuestion.modified',
				'BlogQuestion.created',
				
			)
		);
		$this->set('listTitle','Review Blog Question & Answers');
		$blogquestions = $this->paginate('BlogQuestion',$criteria);
		//pr($blogquestions);
		//exit;
		$this->set('blogquestions',$blogquestions);
		
	}
	
	
	/** 
	@function	:	admin_questionsdelete
	@description	:	Delete the questions and its answers
	@params		:	$id=id of row
	@created	:	10-04-2013
	@credated by	:	Pradeep kumar
	**/
	function admin_questionsdelete($id=null){
		$this->checkSessionAdmin();
		$this->loadModel('BlogQuestion');
		
		if(!empty($id)){
			$this->BlogQuestion->delete($id);
			$this->Session->setFlash('Records has been deleted successfully.');	
			$this->loadModel('BlogQuestionAnswer');
			
		$answers = $this->BlogQuestionAnswer->find('all',array('conditions'=>array('BlogQuestionAnswer.question_id'=>$id)));
				foreach ($answers as $answer)
				{
				$this->BlogQuestionAnswer->id = NULL;
				$this->BlogQuestionAnswer->delete( $answer['BlogQuestionAnswer']['id']);	
				}
		}
		else {
			$this->Session->setFlash('Records not deleted.','default',array('class'=>'flashError'));
		}
		$this->redirect(array('action' => 'reviewquestions'));
		
	}
	
	
	/** 
	@function	:	admin_multipleAction2
	@description	:	Active/Deactive/Delete multiple records for questions and answers
	@params		:	NULL
	@created	:	04-10-2013
	@credated by	:	Pradeep Kumar
	**/
	function admin_multipleAction2($blog_id=null){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->loadModel('BlogQuestion');
		if($this->data['BlogQuestion']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
				$this->BlogQuestion->id=$id;
				$this->BlogQuestion->saveField('status','1');
				$this->Session->setFlash('Records has been updated successfully.');
				}
			}
		} elseif($this->data['BlogQuestion']['status']=='inactive'){
			
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->BlogQuestion->id=$id;
					$this->BlogQuestion->saveField('status','0');
					$this->Session->setFlash('Records has been updated successfully.');	
				}
			}
			
		} elseif($this->data['BlogQuestion']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->BlogQuestion->delete($id);
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
			$this->redirect('/admin/blogs/reviewquestions/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		else
			$this->redirect('/admin/blogs/reviewquestions/'.$blog_id);
	}
	
	
	/** 
	@function	:	admin_questionstatus
	@description	:	change the status of active/deactive
	@params		:	$id=id of row, $status=status
	@Created by: 		Pradeep kumar
	@Modify:		NULL
	@Created Date:		04-10-2010
	**/
	
	function admin_questionstatus($id,$status=0){
		$this->checkSessionAdmin();
		$this->loadModel('BlogQuestion');
		$this->BlogQuestion->id = $id;
		
		if($status==1){
			$this->BlogQuestion->saveField('status','0');
			$this->Session->setFlash('Records has been updated successfully.');
		} else {
			$this->BlogQuestion->saveField('status','1');
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
		
		$this->redirect('/admin/blogs/reviewquestions/'.$blog_id.'/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		
		
	}
	
	
	
	/**
	@function:admin_addquestion 
	@description:Add/edit blog questions and answers
	@params:id
	@Created by: Pradeep
	@Modify:NULL
	@Created Date:04-10-2010
	*/
	function admin_addquestion($id=null){
		$this->checkSessionAdmin();
		$this->loadModel('BlogQuestion');
		$this->loadModel('BlogQuestionAnswer');
		$this->layout = 'layout_admin';
		if(empty($id)) {
			$this->set('listTitle','Add New Question');
		}
		else {
			$this->set('listTitle','Update New Question');
		}
		$this->set("id",$id);
		
		
		if(!empty($this->data)){
			$this->BlogQuestion->set($this->data);
			$this->BlogQuestionAnswer->validates();
			if($this->BlogQuestion->validates()){
				if($this->BlogQuestion->save($this->data,array('validate'=>false))){	
					/***starts questions anwsers**/
				$this->loadModel('BlogQuestionAnswer');
				$questionArr = array();
				$correctanskey = $this->data['BlogQuestion']['correct_answer'];
				$id = $this->BlogQuestion->id ;
				if(!empty($id)){
				$oldanswers = $this->BlogQuestionAnswer->find('all',array('conditions'=>array('BlogQuestionAnswer.question_id'=>$id)));
				foreach ($oldanswers as $oldanswer)
				{
				$this->BlogQuestionAnswer->id = NULL;
				$this->BlogQuestionAnswer->delete( $oldanswer['BlogQuestionAnswer']['id']);	
				}
				
				foreach ($this->data['BlogQuestionAnswer'] as $questionArrK=>$questionArrv) {
				if($correctanskey == $questionArrK+1)
				{
				$this->data['BlogQuestion']['answer'] = $questionArrv['answer'];
				$questionArr['BlogQuestionAnswer']['correct_answer'] = 1;	
				}
				else
				{
				$questionArr['BlogQuestionAnswer']['correct_answer'] = 0;		
				}
				$questionArr['BlogQuestionAnswer']['answer'] = $questionArrv['answer'];
				$questionArr['BlogQuestionAnswer']['question_id'] = $id;
				$this->BlogQuestionAnswer->id = NULL;
				$this->BlogQuestion->save($this->data);
				$this->BlogQuestionAnswer->validates();
				$this->BlogQuestionAnswer->save($questionArr['BlogQuestionAnswer'],array('validate'=>false));
				}
				}
				else {
					
				foreach ($this->data['BlogQuestionAnswer'] as $questionArrK=>$questionArrv) {
				if($correctanskey == $questionArrK+1)
				{
				$this->data['BlogQuestion']['answer'] = $questionArrv['answer'];
				$questionArr['BlogQuestionAnswer']['correct_answer'] = 1;	
				}
				else
				{
				$questionArr['BlogQuestionAnswer']['correct_answer'] = 0;		
				}
				
				$questionArr['BlogQuestionAnswer']['answer'] = $questionArrv['answer'];
				$questionArr['BlogQuestionAnswer']['question_id'] = $this->BlogQuestion->getLastInsertID();
				$this->BlogQuestionAnswer->id = NULL;
				$this->BlogQuestion->save($this->data);
				$this->BlogQuestionAnswer->validates();
				$this->BlogQuestionAnswer->save($questionArr['BlogQuestionAnswer'],array('validate'=>false));
				
				
				}
				}
			
				/**ends**/
					$this->Session->setFlash('Records has been updated successfully.');
					$this->redirect(array('action' => 'reviewquestions'));
				} else { 
					$this->set('errors',$this->BlogQuestion->validationErrors);
					$this->set('errors',$this->BlogQuestionAnswer->validationErrors);
					pr($this->BlogQuestion->validationErrors);
					pr($this->BlogQuestionAnswer->validationErrors);
				}
			} else {
				
				$this->set('errors',$this->BlogQuestion->validationErrors);
				if($this->BlogQuestionAnswer->validates())
				{
					
				}
				else
				{
				$this->set('errors1',$this->BlogQuestionAnswer->validationErrors);
				}
				
				
			}
		}
		else {
			
			$this->BlogQuestion->id = $id;
			$this->data = $this->BlogQuestion->findById($id);
			
			if(!empty($id)) {
				
			foreach ($this->data['BlogQuestionAnswer'] as $key=>$adata)
			{
				if($adata['correct_answer']==1)
				{
				$this->data['BlogQuestion']['correct_answer'] = $key+1;
				}
			
			}
			}
			if(!empty($this->data['BlogQuestion'])){
				foreach($this->data['BlogQuestion'] as $field_index => $info){
					$this->data['BlogQuestion'][$field_index] = html_entity_decode($info);
					$this->data['BlogQuestion'][$field_index] = str_replace('&#039;',"'",$this->data['BlogQuestion'][$field_index]);
					$this->data['BlogQuestion'][$field_index] = str_replace('\n',"",$this->data['BlogQuestion'][$field_index]);
				}
			}
		}
	}
	
	
	
	/**
	@function:checkCorrectAnswer 
	@description:check the correct answer for the question
	@params:blog id, commentid
	@Created by: Pradeep
	@Modify:NULL
	@Created Date:10-01-2013
	*/
	
	function checkCorrectAnswer($question_id=null, $ans=null )
	{
		$this->loadModel('BlogQuestionAnswer');
		$result = $this->BlogQuestionAnswer->find('count',array('conditions'=>array('BlogQuestionAnswer.question_id'=>$question_id,'BlogQuestionAnswer.correct_answer'=>1,'BlogQuestionAnswer.answer'=>trim($ans))));
		
		if($result==1)
		return true;
		else
		return false;
		
	}
	
	/**
	@function:displayquestion 
	@description: Display another question
	@params:id
	@Created by: Pradeep
	@Modify:NULL
	@Created Date:04-12-2010
	*/
	
	function displayquestion($count=null)
	{
		$this->layout = "";
		$this->loadModel('BlogQuestion');
		$this->loadModel('BlogQuestionLinkCount');
		$questions = $this->BlogQuestion->find('first', array('conditions'=>array('BlogQuestion.status'=>1),'contain'=>array('BlogQuestionAnswer'=>array('fields'=>array('answer','id','question_id','correct_answer'))),'order' => array('rand()')));
		
		$this->data['BlogQuestionLinkCount']['session_id'] = $count;
		$this->BlogQuestionLinkCount->save($this->data);
		$this->set('questions',$questions);
		$this->set('count',$count);
		$this->render('/elements/blogs/displayquestion');
		
		
	}
	
	
}
?>