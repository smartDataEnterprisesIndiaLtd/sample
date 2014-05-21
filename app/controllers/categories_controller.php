<?php
/**  @class:		CategoriesController 
 @Created by: 		RAMANPREET PAL KAUR
 @Modify:		NULL
 @Created Date:		03-10-2010
*/
App::import('Sanitize');
class CategoriesController extends AppController{
	var $name = 'Categories';
	var $helpers = array('Form','Html','Javascript','Session','Format','Ajax','Validation','Common','Paginator');
	var $components = array ('RequestHandler', 'File','Common','Email','Session','Cookie');
	var $permission_id = 4;  // for category /department module
	/**
	* @Date: Nov 12, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		//check session other than admin_login page
		$this->detectMobileBrowser();
		$includeBeforeFilter = array('admin_index','admin_add','admin_status','admin_multiplAction','admin_delete');
		if (in_array($this->params['action'],$includeBeforeFilter))
		{
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id);
			// validate admin session
			$this->checkSessionAdmin();
		}
	}
	/**
	@function:	admin_index
	@description:	listing of categories,
	@params:	department_id, parent category id
	@Created by: 	Ramanpreet Pal Kaur
	@Modify:	NULL
	@Created Date:	Oct 19,2010
	*/		

	function admin_index($department_id = null,$parent_id = null){
		// get breadCrumb for category pages 
		$strBreadcrumb = $this->adminBreadcrumb($department_id, $parent_id);
		$this->set('breadcrumb_string', $strBreadcrumb);
		$this->set('department_id',$department_id);
		$this->set('parent_id',$parent_id);
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
		$sort = '';
		$value = '';
		$criteria=' 1 ';
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['Category.cat_name'] = "Name";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
			if(!empty($this->data['Search']['searchin']))
				$fieldname = $this->data['Search']['searchin'];
			else
				$fieldname = 'All';
			$value = trim($this->data['Search']['keyword']);
			
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
					$criteria .= " and (Category.cat_name LIKE '%".$value1."%')";
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
					$criteria .= " and Category.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		$this->set('keyword', $value);
		$this->set('fieldname',$fieldname);
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		   
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		/** sorting and search */
		if($this->RequestHandler->isAjax()==0)
			$this->layout = 'layout_admin';
		else
			$this->layout = 'ajax';
		if(!empty($parent_id)){
			$criteria = $criteria.' AND Category.parent_id ='.base64_decode($parent_id);
		} else{
			$criteria = $criteria.' AND Category.parent_id = 0';
		}
		$this->paginate = array( 
			'limit' => $limit,
			'order' => array(
				'Category.created' => 'Desc'
			),
			'conditions' => array('Category.department_id'=>base64_decode($department_id))
			
		);
		$this->set('listTitle','Manage Categories');
		$categories = $this->paginate('Category',$criteria);
		$this->set('categories',$categories);
	}

	/**
	@function:admin_add 
	@description:Add/edit categories,
	@params:department id, category id,product id
	@Created by: kulvinder
	@Modify:NULL
	@Created Date:Oct 19,2010
	*/
	function admin_add($department_id = null, $parent_id = null, $id = null){
		$this->set('department_id',$department_id);
		$this->set('parent_id',$parent_id);
		$this->set("id",$id);
		$this->layout = 'layout_admin';
		if(empty($id))
			$this->set('listTitle','Add New Category');
		else
			$this->set('listTitle','Update Category');
		if(!empty($this->data)){
			$this->data['Category']['department_id'] = base64_decode($department_id);
			$this->data['Category']['parent_id'] 	 = ( is_null($parent_id) )?(0):(base64_decode($parent_id));
			$this->data['Category']['id'] = $id;
			$this->Category->set($this->data);
			if($this->Category->validates()){
				// clean data before save
				uses('sanitize');
				$this->Sanitize = new Sanitize;
				/*** Upload Image if provided */
				if(!empty($this->data['Category']['photo']['name'])){
					App::import('Component','File');
					$this->File=new FileComponent();
					$this->File->destPath =  WWW_ROOT.PATH_CATEGORY;
					$this->File->setFilename(time()."_".$this->data['Category']['photo']['name']);
					$fileName  = $this->File->uploadFile($this->data['Category']['photo']['name'],$this->data['Category']['photo']['tmp_name']);
					if( !$fileName  ){ // Error in uploading
						$this->Session->setFlash('Error in uploading the image.','default',array('class'=>'flashError')); 
						$this->redirect('/admin/categories/index/'.$department_id.'/'.$parent_id);
					} else { // uploaded successful and delete the old file
						$this->Category->id = $id;
						$oldfile = $this->Category->findById($id);
						// delete old file
						$this->File->deleteFile( $oldfile['Category']['cat_image']);
						$this->data['Category']['cat_image']= $fileName;
					}
				}
				if( ! empty($id) ){ // edit case
					$this->data =Sanitize::clean($this->data);
					if ($this->Category->save($this->data)) {
						$this->Session->setFlash('Records has been updated successfully.');
						$this->redirect('/admin/categories/index/'.$department_id.'/'.$parent_id);
					}else {
						$this->set('errors',$this->Category->validationErrors);
					}
				
				}else{ // add category
					$this->data['Category']['status'] = 1;
					$this->data = Sanitize::clean($this->data);
					if ($this->Category->save($this->data)) {
						$this->Session->setFlash('Records has been added successfully.');
						$this->redirect('/admin/categories/index/'.$department_id.'/'.$parent_id);
					}else {
						$this->set('errors',$this->Category->validationErrors);
					}
				}
			} else {
				
				$this->set('errors',$this->Category->validationErrors);
			}
		} else{
			$this->Category->id = $id;
			$this->data = $this->Category->findById($id);
			
			if(!empty($this->data['Category'])){
				foreach($this->data['Category'] as $field_index => $info){
					$this->data['Category'][$field_index] = html_entity_decode($info);
					$this->data['Category'][$field_index] = str_replace('&#039;',"'",$this->data['Category'][$field_index]);
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
	@Created Date:		Oct 20,2010
	**/
	
	function admin_status($id = null,$status=0){
		$parent = $this->Category->find('first',array('conditions'=>array('Category.id'=>$id),'fields'=>array('Category.parent_id')));
		$this->Category->id = $id;
		if($status==1){
			$this->Category->saveField('status','0');
			$this->Session->setFlash('Information updated  successfully.');
		} else {
			$this->Category->saveField('status','1');
			$this->Session->setFlash('Information updated  successfully.');
		}
		$this->redirect('/admin/categories/index/'.base64_encode($parent['Category']['parent_id']));
	}

	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	category id
	@created	:	Oct 20,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_multiplAction($cat_id = null){
		foreach($this->data['select'] as $id_index => $id){
			$parent = $this->Category->find('first',array('conditions'=>array('Category.id'=>$id_index),'fields'=>array('Category.department_id','Category.parent_id')));
			break;
		}
		if($this->data['Category']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Category->id=$id;
					$this->Category->saveField('status','1');
					$this->Session->setFlash('Information updated successfully.');
				}	
			}
		} elseif($this->data['Category']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Category->id=$id;
					$this->Category->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');	
				}
			}
		} elseif($this->data['Category']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$action = 'multiple';
					$this->admin_delete($id,$action);
				}
			}
		}
		/** for searching and sorting*/
		if(!empty($parent['Category']['parent_id'])) {
			$this->redirect('/admin/categories/index/'.base64_encode($parent['Category']['department_id']).'/'.base64_encode($parent['Category']['parent_id']));
		} else{
			$this->redirect('/admin/categories/index/'.base64_encode($parent['Category']['department_id']));
		}
	}

	/** 
	@function	:	admin_delete
	@description	:	Delete the content page
	@params		:	$id=id of row
	@created	:	Oct 29,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete($id=null,$action=null){
		
		if(!empty($id)){
			$parent = $this->Category->find('first',array('conditions'=>array('Category.id'=>$id),'fields'=>array('Category.department_id','Category.parent_id')));
			$all_sub_categories = $this->Category->find('all',array('conditions'=>array('Category.parent_id'=>$id),'fields'=>array('Category.id','Category.parent_id')));
			if(!empty($all_sub_categories)){
				$this->Session->setFlash('You can\'t delete this category as its having sub categories, please delete those first.','default',array('class'=>'flashError'));

				if(!empty($parent['Category']['parent_id'])) {
					$this->redirect('/admin/categories/index/'.base64_encode($parent['Category']['department_id']).'/'.base64_encode($parent['Category']['parent_id']));
				} else{
					$this->redirect('/admin/categories/index/'.base64_encode($parent['Category']['department_id']));
				}
			} else{
				$photo=$this->Category->findById($id,'cat_image');
				if(!empty($photo['Category']['cat_image'])){
					@chmod(IMAGES.'categories/'.$photo['Category']['cat_image'],"0777");
					@unlink(IMAGES.'categories/'.$photo['Category']['cat_image']); 
				}
				$this->Category->delete($id);
				$this->Session->setFlash('Information deleted successfully.');
				if(empty($action)){
				$this->redirect('/admin/categories/index/'.base64_encode($parent['Category']['department_id']).'/'.base64_encode($parent['Category']['parent_id']));
			}
			}
		} else{
			$this->Session->setFlash('Information not deleted.','default',array('class'=>'flashError'));
			$this->redirect('/admin/departments');
		}
	}
	
	/********************************************** */
	/** 
	@function:	 getParentCategory	
	@description	get list of all parent category ids 
	@Created by: 	kulvinder Singh	
	@params		category id 
	@Modify:		NULL
	@Created Date:		21-10-2010
	*/
	function getParentCategory($cat_id = null){
		static $strIds ;
		static $strCatNames ;
		//$arrValues = array();
		$catArr  = $this->Category->find('first' , array(
			'conditions' => array('Category.id' => $cat_id),
			'fields' => array('Category.cat_name', 'Category.id','Category.department_id','Category.parent_id')
			));
		
		$strIds = $strIds."#".$catArr['Category']['id'];
		$strCatNames = $strCatNames."#".$catArr['Category']['cat_name'];
		
		if($catArr['Category']['parent_id'] != 0 ){
			$this->getParentCategory($catArr['Category']['parent_id']);
		}
		$strIds = ltrim($strIds, '#');
		$strCatNames = ltrim($strCatNames, '#');
		$arrValues['ids']  = $strIds;
		$arrValues['name'] = $strCatNames;
		return $arrValues;
	}
	
	/********************************************** */
	/** 
	@function:	 getParentCategoryArray	
	@description	get list of all parent category array 
	@Created by: 	kulvinder Singh	
	@params		category id 
	@Modify:		NULL
	@Created Date:		17 NOv 2010
	*/
	function getParentCategoryArray($cat_id = null){		
		$strCategory = $this->getParentCategory($cat_id);
		//pr($strCategory);
		$strCatIdsArr = array();
		$strCatNameArr = array();
		$strCatIdsArr = explode("#" ,$strCategory['ids'] );
		$strCatIdsArr = array_reverse($strCatIdsArr);
		$strCatNameArr = explode("#" ,$strCategory['name'] );
		$strCatNameArr = array_reverse($strCatNameArr);
		$finalArr = array_combine($strCatIdsArr ,$strCatNameArr);
		return $finalArr;
	}

	/** 
	@function:	 getChildCategory	
	@description	get list of all child category ids 
	@Created by: 	kulvinder Singh	
	@params		category id 
	@Modify:		NULL
	@Created Date:		19 Nov
	*/
	function getChildCategory($cat_id = null){
		$childCatArr  = $this->Category->find('list' , array(
			'conditions' => array('Category.parent_id' => $cat_id, 'Category.status' =>1),
			'fields' => array('Category.id','Category.cat_name' ),'order'=>array('Category.cat_rank DESC')));
		return $childCatArr;
	}

	/** 
	@function:	 adminBreadcrumb	
	@description	create breadcrumb for category page	in admin side
	@Created by: 	kulvinder Singh	
	@params		deaprtment id , category id 
	@Modify:		NULL
	@Created Date:		
	*/
	function adminBreadcrumb($department_id , $cat_id = null){
		$department_id = base64_decode($department_id);
		App::import('Model','Department');
		$this->Department = &new Department;
		$departArr  = $this->Department->find('first' , array(
			'conditions' => array('Department.id' => $department_id),
			'fields' => array('Department.name', 'Department.id')
			));
		if(is_null($cat_id) ){
			$strLink = $departArr['Department']['name'];
		}else{
			$cat_id = base64_decode($cat_id);
			$finalArr = $this->getParentCategoryArray($cat_id);
			$totalCount = count($finalArr);
			$outerlink =SITE_URL."admin/categories/index/".base64_encode($department_id);
			$strLink ='<a href="'.$outerlink.'" >' .$departArr['Department']['name']. '</a>';	
			$strLink .=' &raquo; ';
			if( is_array($finalArr) ){
				$j = 0;
				foreach($finalArr as $key=>$value){
					$j++;
					
					if($j == $totalCount){
						$strLink .= $value;	
					}else{
					$innerlink = SITE_URL."admin/categories/index/".base64_encode($department_id)."/".base64_encode($key)."";
					$strLink .='<a href="'.$innerlink.'">' .$value. '</a>';
					$strLink .=' &raquo; ';
					}
				}
			}
		}
		return $strLink;
	}
	
	/********************************************** */
	/** 
	@function:	 frontendBreadcrumb	
	@description	create breadcrumb for category page for front end side	
	@Created by: 	kulvinder Singh	
	@params		category id 
	@Modify: 
	@Created Date:	18 Nov 2010	
	*/
	function frontendBreadcrumb($category_id = null){
		
		// get department name and id 
		$this->Category->expects( array( 'Department' ) );
		$departArr  = $this->Category->find('first' , array(
			'conditions' => array('Category.id' => $category_id),
			'fields' => array('Department.name', 'Department.id')
		));
		$department_name = $departArr['Department']['name'];
		$department_id = $departArr['Department']['id'];
		//$link_seperator = "&raquo;" ;
		$strLink = '';
		$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
		
			$finalArr = $this->getParentCategoryArray($category_id);
			
			$totalCount = count($finalArr);
			//pr($totalCount);
		if ($this->RequestHandler->isMobile()) {
			$link_seperator = "<span class='bread_sep'>&gt;</span>";
           		$strLink .= '<a href="'.SITE_URL.''.$dept_url_name.'/departments/index/'.$department_id.'" >' .$department_name. '</a>'.$link_seperator;
			}else{
				$class ='';
				$strLink = '<li><a href="/" class="star_c1">Choiceful</a></li>';
				if($totalCount==1){
				$class ="class=active";
				}
				$strLink .= '<li><a '.$class.' href="'.SITE_URL.''.strtolower($dept_url_name).'/departments/index/'.$department_id.'" >' .$department_name. '</a></li>';
			}
		
			if( is_array($finalArr) ){
				$j = 0;
				foreach($finalArr as $key=>$value){
					$j++;
					
					if($j == $totalCount){
						if ($this->RequestHandler->isMobile()) {
							$strLink .= $value;
						}else{
							$strLink .= '<li class="last"><span>'.$value.'</span></li>';
						}
					}else{
						
						$cat_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($value, ENT_NOQUOTES, 'UTF-8'));
						
						$innerlink = SITE_URL.strtolower($dept_url_name).'/'.strtolower($cat_url_name).'/categories/index/'.$key;
						if ($this->RequestHandler->isMobile()) {
							$strLink .='<a href="'.$innerlink.'">' .$value. '</a>'.$link_seperator;
						}else{
							
							if($j == $totalCount-1){
								$strLink .='<li><a class="active" href="'.strtolower($innerlink).'">' .$value. '</a></li>';
							}
							else{
								$strLink .='<li><a href="'.strtolower($innerlink).'">' .$value. '</a></li>';
								
							}
						}
						
						//$strLink .= $link_seperator;
					}
				}
			}
			
			
		return $strLink;
	}
	
	
	/********************************************** */
	/** 
	@function:	 getCategoryDetail	
	@description	get category details
	@Created by: 	kulvinder Singh	
	@params		category  id 
	@Modify:		NULL
	@Created Date:		
	*/
	function getCategoryDetail($cat_id = null){
		$catArr  = $this->Category->find('first' , array(
			'conditions' => array('Category.id' => $cat_id),
			'fields' => array('Category.id','Category.cat_name', 'Category.department_id', 'Category.parent_id' )
			));
		return $catArr;
	}
	
	/** 
	@function:	 getLeftNavigations
	@description	show category list on home page	
	*/
	function getLeftNavigations($selected_category = null){
		$this->set('selected_category',$selected_category);
		// get category details and department name
		$catDetailsArr = $this->getCategoryDetail($selected_category);
		$selected_department = $catDetailsArr['Category']['department_id'];
		$immediate_parent_category = $catDetailsArr['Category']['parent_id'];
		$this->set('selected_department', $selected_department);
		// show breadcrumb
		$strBreadcrumb = $this->frontendBreadcrumb($selected_category);
		$this->set('breadcrumb_string', $strBreadcrumb);
		//pr($catDetailsArr);
		App::import('Model','Department');
		$this->Department = &new Department;
		$department_name = $this->Department->getDepartmentName($selected_department) ;
		$this->set('department_name', $department_name);
		// get a list of all parent category 
		$arrParentCategory = $this->getParentCategoryArray($selected_category);
		$this->set('parentCategoryArr', $arrParentCategory);
		$childCategoryArr = $arrChildCategory = $this->getChildCategory($selected_category);
		$this->set('childCategoryArr' , $childCategoryArr);
		if(!is_array($childCategoryArr) || count($childCategoryArr) == 0) {
			// remove last parent id from parent category list
			array_pop($arrParentCategory);
			$this->set('parentCategoryArr', $arrParentCategory);
			// fetch category on same level 
			$lastChildCategoryArr  = $this->getChildCategory($immediate_parent_category);
			$this->set('childCategoryArr' , $lastChildCategoryArr);
		}
	}

	/** 
	@function:	 index	
	@description	show category list on home page	
	@Created by: 	Nakul kumar
	@params		deaprtment id , category id 
	@Modify:		NULL
	@Created Date:		
	*/
	function index($selected_category = null){
		if ($this->RequestHandler->isMobile()) {
            	// if device is mobile, change layout to mobile
           		$this->layout = 'mobile/home';
           			}else{
			$this->layout = 'home';
		}
		$new_meta_desc = '';
		$new_title_for_layout ='';
		
		$this->set('selected_category',$selected_category);
		$metaTagsArr = $this->Category->find('first',array(
			'conditions' => array('Category.id' =>$selected_category, 'Category.status' => 1 ),
			'fields'=>array('Category.cat_name','Category.meta_title','Category.meta_keywords','Category.meta_description','Category.department_id','Category.parent_id')
			));
			
		$dept_id = $metaTagsArr['Category']['department_id'];
			
		App::import('Model','Department');
		$this->Department = &new Department;
		$department_name = $this->Department->getDepartmentName($dept_id);
		$this->set('dept_id',$dept_id);
		$this->set('department_name', $department_name);
		
		###################  Add product data to the product visit ################
		App::import('Model','CategoryVisit');
		$this->CategoryVisit = &new CategoryVisit;
		$categoryId = $selected_category;
		$this->CategoryVisit->addVisitedCategory($categoryId,$metaTagsArr['Category']['parent_id'],$metaTagsArr['Category']['department_id']);
		#############################################
		
		if(!empty($metaTagsArr)){
			$this->set('title_for_layout', $metaTagsArr['Category']['meta_title']);
			$this->set('meta_keywords', $metaTagsArr['Category']['meta_keywords']);
			$this->set('meta_description', $metaTagsArr['Category']['meta_description']);
			$this->set('category_name_fh', $metaTagsArr['Category']['cat_name']);
		}
		$this->getLeftNavigations($selected_category);
		$fh_themes = array();
		$fh_themes_right = array();
		$best_dept_item = array();
		$bestseller_dept_slogan = array();
		$best_cat_item = array();
		$bestseller_cat_slogan = array();
		
		/** FH starts here **/
		$fh_ok = FH_OK;
		if($fh_ok == 'OK'){
		$fh_url_var = $this->fh_url($selected_category);
		$ws_location = WS_LOCATION;
		//Create a new soap client
		//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		//Build the query string
		$fh_location = @$fh_url_var;
		$this->set('fh_url_var',@$fh_url_var);
		//Send the query string to the Fredhopper Query Server & obtain the result
		//$fh_location = "fh_location=//catalog01/en_GB/department_name={home___garden}/categories<{catalog01_1490}/categories<{catalog01_1490_1517}";
		$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
		//pr($result);
		//Find the universe marked as 'selected' in the result
		foreach($result->universes->universe as $r) {
			if($r->{"type"} == "selected"){
				//Extract & print the breadcrumbs from the result
				if(!empty($r->themes))
					$themes = (array)$r->themes;
				if(!empty($themes)){
					
					if(!empty($themes['theme'])){
						//$fh_themes = $themes['theme'];
						if(count($themes['theme']) == 1){
							$fh_themes[0] = $themes['theme'];
						} else {
							$fh_themes = $themes['theme'];
						}
					}
				}
			}
		}
		if(!empty($fh_themes)){
			$fh_themes_right[1] = @$fh_themes[0];
			if(!empty($fh_themes[1])){
				$fh_themes_right[0] = $fh_themes[1];
			}
		}
		$j = 0;
		foreach($fh_themes as $fh_themes){
			if($fh_themes->{'custom-fields'}->{'custom-field'}->_ == "Sub-Category Item Preview"){
				$cat_items = $fh_themes->items->item;
				$i = 0;
				if(!isset($cat_items->attribute)){
				foreach($cat_items as $category_product){
					
					foreach($category_product->attribute as $attribute){
						if($attribute->name == 'secondid' && !empty($attribute->value->_)){
							$products_info[$j][$i]['secondid'] = $attribute->value->_;
						}
						if($attribute->name == 'product_name' && !empty($attribute->value->_)){
							$products_info[$j][$i]['product_name'] = $attribute->value->_;
						}
						if($attribute->name == 'product_image' && !empty($attribute->value->_)){
							$products_info[$j][$i]['product_image'] = $attribute->value->_;
						}
						if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
							$products_info[$j][$i]['avg_rating'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
							$products_info[$j][$i]['minimum_price_value'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
							$products_info[$j][$i]['minimum_price_used'] = $attribute->value->_;
						}
						if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
							$products_info[$j][$i]['product_rrp'] = $attribute->value->_;
						}
					}
					
				$i++;
				}
				
				}else{
					foreach($cat_items->attribute as $attribute){
						if($attribute->name == 'secondid' && !empty($attribute->value->_)){
							$products_info[$j][$i]['secondid'] = $attribute->value->_;
						}
						if($attribute->name == 'product_name' && !empty($attribute->value->_)){
							$products_info[$j][$i]['product_name'] = $attribute->value->_;
						}
						if($attribute->name == 'product_image' && !empty($attribute->value->_)){
							$products_info[$j][$i]['product_image'] = $attribute->value->_;
						}
						if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
							$products_info[$j][$i]['avg_rating'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
							@$products_info[$j][$i]['minimum_price_value'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
							@$products_info[$j][$i]['minimum_price_used'] = $attribute->value->_;
						}
						if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
							$products_info[$j][$i]['product_rrp'] = $attribute->value->_;
						}
					}
					
				}
				
			}
			//Department best Seller Products
			if($fh_themes->{'custom-fields'}->{'custom-field'}->_ == 'Bestsellers - Department Specific'){
				$bestseller_items_dept = $fh_themes->items->item;
				$bestseller_dept_slogan = $fh_themes->slogan;
				$i = 0;
				if(!isset($bestseller_items_dept->attribute)){
					foreach($bestseller_items_dept as $best_dept_items){
						foreach($best_dept_items->attribute as $attribute){
							if($attribute->name == 'secondid' && !empty($attribute->value->_)){
								$best_dept_item[$i]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name' && !empty($attribute->value->_)){
								$best_dept_item[$i]['product_name'] = $attribute->value->_;
							}
							if($attribute->name == 'product_image' && !empty($attribute->value->_)){
								$best_dept_item[$i]['product_image'] = $attribute->value->_;
							}
							if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
								$best_dept_item[$i]['avg_rating'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
								$best_dept_item[$i]['minimum_price_value'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
								$best_dept_item[$i]['minimum_price_used'] = $attribute->value->_;
							}
							if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
								$best_dept_item[$i]['product_rrp'] = $attribute->value->_;
							}
							
							if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
								$best_dept_item[$i]['condition_new'] = $attribute->value->_;
							}
							if($attribute->name == 'condition_used' && !empty($attribute->value->_)){
								$best_dept_item[$i]['condition_used'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_seller' && !empty($attribute->value->_)){
								$best_dept_item[$i]['minimum_price_seller'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used_seller' && !empty($attribute->value->_)){
								$best_dept_item[$i]['minimum_price_used_seller'] = $attribute->value->_;
							}
						}
					$i++;
					}
				}else{
					$i = 0;
					foreach($bestseller_items_dept->attribute as $attribute){
						if($attribute->name == 'secondid' && !empty($attribute->value->_)){
							$best_dept_item[$i]['secondid'] = $attribute->value->_;
						}
						if($attribute->name == 'product_name' && !empty($attribute->value->_)){
							$best_dept_item[$i]['product_name'] = $attribute->value->_;
						}
						if($attribute->name == 'product_image' && !empty($attribute->value->_)){
							$best_dept_item[$i]['product_image'] = $attribute->value->_;
						}
						if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
							$best_dept_item[$i]['avg_rating'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
							$best_dept_item[$i]['minimum_price_value'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
							$best_dept_item[$i]['minimum_price_used'] = $attribute->value->_;
						}
						if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
							$best_dept_item[$i]['product_rrp'] = $attribute->value->_;
						}
						
						if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
							$best_dept_item[$i]['condition_new'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_used' && !empty($attribute->value->_)){
							$best_dept_item[$i]['condition_used'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_seller' && !empty($attribute->value->_)){
							$best_dept_item[$i]['minimum_price_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used_seller' && !empty($attribute->value->_)){
							$best_dept_item[$i]['minimum_price_used_seller'] = $attribute->value->_;
						}
					$i++;
					}
				}
			}
			//End Department best Seller Products
			
			// Category best seller products 
			if($fh_themes->{'custom-fields'}->{'custom-field'}->_ == 'Bestsellers - Category Specific'){
				$bestseller_items_cat = $fh_themes->items->item;
				$bestseller_cat_slogan = $fh_themes->slogan;
				$i = 0;
				if(!isset($bestseller_items_cat->attribute)){
					foreach($bestseller_items_cat as $best_cat_items){
						foreach($best_cat_items->attribute as $attribute){
							if($attribute->name == 'secondid' && !empty($attribute->value->_)){
								$best_cat_item[$i]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name' && !empty($attribute->value->_)){
								$best_cat_item[$i]['product_name'] = $attribute->value->_;
							}
							if($attribute->name == 'product_image' && !empty($attribute->value->_)){
								$best_cat_item[$i]['product_image'] = $attribute->value->_;
							}
							if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
								$best_cat_item[$i]['avg_rating'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
								$best_cat_item[$i]['minimum_price_value'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
								$best_cat_item[$i]['minimum_price_used'] = $attribute->value->_;
							}
							if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
								$best_cat_item[$i]['product_rrp'] = $attribute->value->_;
							}
							
							if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
								$best_cat_item[$i]['condition_new'] = $attribute->value->_;
							}
							if($attribute->name == 'condition_used' && !empty($attribute->value->_)){
								$best_cat_item[$i]['condition_used'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_seller' && !empty($attribute->value->_)){
								$best_cat_item[$i]['minimum_price_seller'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used_seller' && !empty($attribute->value->_)){
								$best_cat_item[$i]['minimum_price_used_seller'] = $attribute->value->_;
							}
						}
					$i++;
					}
				}else{
					$i = 0;
					foreach($bestseller_items_cat->attribute as $attribute){
						if($attribute->name == 'secondid' && !empty($attribute->value->_)){
							$best_cat_item[$i]['secondid'] = $attribute->value->_;
						}
						if($attribute->name == 'product_name' && !empty($attribute->value->_)){
							$best_cat_item[$i]['product_name'] = $attribute->value->_;
						}
						if($attribute->name == 'product_image' && !empty($attribute->value->_)){
							$best_cat_item[$i]['product_image'] = $attribute->value->_;
						}
						if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
							$best_cat_item[$i]['avg_rating'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
							$best_cat_item[$i]['minimum_price_value'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
							$best_cat_item[$i]['minimum_price_used'] = $attribute->value->_;
						}
						if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
							$best_cat_item[$i]['product_rrp'] = $attribute->value->_;
						}
						
						if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
							$best_cat_item[$i]['condition_new'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_used' && !empty($attribute->value->_)){
							$best_cat_item[$i]['condition_used'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_seller' && !empty($attribute->value->_)){
							$best_cat_item[$i]['minimum_price_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used_seller' && !empty($attribute->value->_)){
							$best_cat_item[$i]['minimum_price_used_seller'] = $attribute->value->_;
						}
					$i++;
					}
				}
			}
			//End Department best Seller Products
			
			$j++;
			
		}
		
		$products_info = array_values($products_info);	
		//pr($products_info);
		//Find the universe marked as 'selected' in the result Find for category Name in array on 3/Feb/2012
		foreach($result->universes->universe as $r) {
			if($r->{"type"} == "selected"){
				//Extract & print the breadcrumbs from the result
				if(!empty($r->facetmap))
				$facetmap = (array)$r->facetmap;
				if(!empty($facetmap)){
					if(!empty($facetmap['filter'])){
						foreach($facetmap['filter'] as $facetFilter){
							if($facetFilter->title == "Product Categories"){
								if(count($facetFilter->filtersection)>1){
									foreach($facetFilter->filtersection as $cat_id){
										$cat_ids[] = end(explode('_',$cat_id->value->_));
									}
								}else{
										$cat_ids[] = end(explode('_',$facetFilter->filtersection->value->_));
								}
							}
						}
					}
				}
			}
		}
		$slectedCategory = $metaTagsArr['Category']['cat_name'];
		$parentId = $metaTagsArr['Category']['parent_id'];
		$parentCategory ='';
		$parentCategory = $this->Category->getCategoryName($parentId);
		if(!empty($parentCategory)){
			$parentCategory  = " | ".$parentCategory;
		}
		$new_meta_desc = "Shop for Cheap $department_name ". $slectedCategory ." at Choiceful.com, click here to browse a huge range of  $department_name ". $slectedCategory ." at low low prices.";
		$new_title_for_layout.= $slectedCategory.$parentCategory." | ".$department_name.SITE_NAME; 
		
		$this->set('title_for_layout',$new_title_for_layout);
		$this->set('meta_description',$new_meta_desc);
		
		if(!empty($fh_themes_right))
		ksort($fh_themes_right);
		//$this->set('fh_themes',$fh_themes_right);
		$this->set('best_cat_item',$best_cat_item);
		$this->set('bestseller_cat_slogan',$bestseller_cat_slogan);
		
		$this->set('best_dept_item',$best_dept_item);
		$this->set('bestseller_dept_slogan',$bestseller_dept_slogan);
		
		$this->set('cat_ids',$cat_ids);
		$this->set('products_info',$products_info);
		//$this->set('fh_themes',$fh_themes);
		
		//$this->set('fh_subcategory',$fh_themes);
		}
		/** FH close here **/
	}
	
	
	/** 
	@function:	getparent
	@description	show parent_categories of a given category
	@Created by: 	nakul kumar
	@params		category id 
	@Modify:	NULL
	@Created Date:	Apr 24,2012	
	*/
	function getparent($dept_id = null){
		$this->loadModel("Category");
		$catcountarr=array();
		$categoryplist=$this->Category->find("list",array("conditions"=>array('Category.department_id'=>$dept_id),"fields"=>array("Category.parent_id")));
		
		return $categoryplist;
		
	}
	/** 
	@function:	getparent
	@description	show parent_categories of a given category
	@Created by: 	nakul kumar
	@params		category id  and department id
	@Modify:	NULL
	@Created Date:	Apr 24,2012	
	*/
	function getparentcagetories($id = null ,$dept_id = null){
		$catparentids=$this->getparent($dept_id);
		$cid=$id;
		$topcate=array();
		//$topcate[]=$id;
		while(!empty($catparentids[$cid]) && $catparentids[$cid]!=0) {
			
			$topcate[]=$catparentids[$cid];
			$cid=$catparentids[$cid];
			
		}
		return array_reverse($topcate);
	}
	
	/** 
	@function:	 parentCategories
	@description	show parent_categories of a given category
	@Created by: 	Ramanpreet Pal
	@params		category id 
	@Modify:	NULL
	@Created Date:	July 29,2011	
	*/
	function parentCategories($cate_id = null){
		$parentArr = array();
		$test_parent_arr = array();
		$parent_info = $this->Category->find('first',array('conditions'=>array('Category.id'=>$cate_id),'fields'=>array('Category.parent_id')));
		if(!empty($parent_info)){
			if($parent_info['Category']['parent_id'] > 0){
				$test_parent_arr = $this->Session->read('parentArr');
				if(!empty($test_parent_arr))
					$parentArr = $test_parent_arr;
				$parentArr[] = $parent_info['Category']['parent_id'];
				$parentArr = array_unique($parentArr);
				$this->Session->write('parentArr',$parentArr);
				$this->parentCategories($parent_info['Category']['parent_id']);
			}
		}
		//session_unset();
		$this->Session->delete('parentArr');
		return $parentArr;
	}

	/** 
	@function:	fh_url
	@description	show fredhopper url variable
	@Created by: 	Ramanpreet Pal
	@params		department_name, categoriesarray
	@Modify:	17 may 2012
	@Created Date:	July 29,2011	
	*/
	function fh_url($selected_category = null){
		
		if(!empty($selected_category)){
			$dept_id_info = $this->Category->find('first',array('conditions'=>array('Category.id'=>$selected_category),'fields'=>array('Category.parent_id','Category.department_id')));
			if(!empty($dept_id_info)){
				App::import('Departmet');
				$this->Department = &new Department;
				$dept_info = $this->Department->find('first',array('conditions'=>array('Department.id'=>@$dept_id_info['Category']['department_id']),'fields'=>array('Department.name')));
			}
				
			if(empty($dept_id_info['Category']['parent_id'])){
				$parentArr = array();
				$this->Session->write('parentArr',$parentArr);
			}
			$par_cate_arr = $this->parentCategories($selected_category);
		}
		if(!empty($par_cate_arr)){
			foreach($par_cate_arr as $par_cate_id){
				if(empty($par_cate_str)){
					$par_cate_str = $par_cate_id;
					$cat_url = 'categories<{catalog01_'.$par_cate_str.'}';
				}else{
					$par_cate_str = $par_cate_str.'_'.$par_cate_id;
					$cat_url = 'categories<{catalog01_'.$par_cate_str.'}';
				}
			}
		}
		if(!empty($selected_category)) {
			if(empty($par_cate_str)){
				$par_cate_str = $selected_category;
				$cat_url = 'categories<{catalog01_'.$par_cate_str.'}';
			}else{
				$par_cate = $par_cate_str.'_'.$selected_category;
				$cat_url = 'categories<{catalog01_'.$par_cate_str.'}';
				$cat_url = $cat_url .'/categories<{catalog01_'.$par_cate.'}';
			}
		}
		//$this->set('dept_name_display',);
		if(!empty($par_cate_str)){
			if(!empty($dept_info)){
				$department_name_fh = str_replace(array(' ','&','and'),'_', html_entity_decode(strtolower($dept_info['Department']['name']), ENT_NOQUOTES, 'UTF-8'));
				
				//$department_name_fh = str_replace(' & ','___',strtolower($dept_info['Department']['name']));
			}
			$fh_url_var = 'fh_location=//catalog01/en_GB/department_name={'.$department_name_fh.'}/'.$cat_url;
			//$fh_url_var = 'fh_location=//catalog01/en_GB/department_name={'.$department_name_fh.'}/categories<{catalog01_'.$par_cate_str.'}';
		}
		return $fh_url_var;
	}
	
	/** 
	@function:	 viewproduct	
	@description	show category  products  subcategory page 	
	@Created by: 	kulvinder Singh	
	@params		category id 
	@Modify:		NULL
	@Created Date:		
	*/
	function viewproducts($selected_category = null , $department_id = null , $sort_by = null){
	$this->set('selected_category',$selected_category);
	$this->set('department_id',$department_id);
	$this->set('sort_by',$sort_by);
	$new_meta_desc = '';
	$new_title_for_layout ='';
		$cat_name = '';
		////////////  set meta tags keywords
		  $metaTagsArr = $this->Category->find('first',array(
			'conditions' => array('Category.id' =>$selected_category, 'Category.status' => 1 ),
			'fields'=>array('Category.meta_title','Category.meta_keywords', 'Category.meta_description', 'Category.cat_name', 'Category.parent_id','Category.department_id')
			 ));
		$cat_name = @$metaTagsArr['Category']['cat_name'];
		
		###################  Add product data to the product visit ################
		App::import('Model','CategoryVisit');
		$this->CategoryVisit = &new CategoryVisit;
		$categoryId = $selected_category;
		$this->CategoryVisit->addVisitedCategory($categoryId,$metaTagsArr['Category']['parent_id'],$metaTagsArr['Category']['department_id']);
		#############################################
		
		
		$this->set('cat_name_m',$cat_name);
		if(!empty($metaTagsArr) ){
			$this->set('title_for_layout',$metaTagsArr['Category']['meta_title']);
			$this->set('meta_keywords',$metaTagsArr['Category']['meta_keywords']);
			$this->set('meta_description',$metaTagsArr['Category']['meta_description']);
		}
		$this->getLeftNavigations($selected_category);
		if ($this->RequestHandler->isMobile()) {
            	// if device is mobile, change layout to mobile
           		 $this->layout = 'mobile/home';
           		 	}else{
			if($this->RequestHandler->isAjax()==0){
				$this->layout = 'product';
			}else{
				$this->layout = 'ajax';
			}
		}
		$parentArr = array();
		//Change by nakul on Apr 23 2012 because brower is not back is not working properly
		//$parentArr = $this->parentCategories($selected_category);
		$parentArr = $this->getparentcagetories($selected_category,$department_id);
		if(!empty($department_id)){
			$this->loadModel("Department");
			$department = $this->Department->getDepartmentName($department_id);
			$dept_name = str_replace(array('&',' '), array('_','_'), html_entity_decode(strtolower($department), ENT_NOQUOTES, 'UTF-8'));
			
		}
		if(!empty($parentArr)){
			
			foreach($parentArr as $parentArr_id){
				if(empty($parent_str))
					$parent_str = $parentArr_id;
				else
					$parent_str = $parent_str.'_'.$parentArr_id;
			}
			$parent_str = $parent_str.'_'.$selected_category;
		}
		$fh_ok = FH_OK;
		if($fh_ok == 'OK'){
		$items = array();$results =array(); $facetmap = array();
		$ws_location = WS_LOCATION;
		//Create a new soap client
		//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		$items_recomanded = array();
		//Start Fro mobile limit
		if(empty($this->data['Record']['limit'])){
			if ($this->RequestHandler->isMobile()) {
				$view_size = VIEW_SIZE_FH_MOBILE;
			}else{
				$view_size = VIEW_SIZE_FH;
			}
		} else {
			$view_size = $this->data['Record']['limit'];
		}
		//End Fro mobile limit
		
		$this->set('view_size',$view_size);
		//Build the query string
		
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
		
		$paging_flag = 1;
		if(empty($fh_location)){
			$this->loadModel("Department");
			$department = $this->Department->getDepartmentName($department_id);
			$dept_name = str_replace(array('&',' '), array('_','_'), html_entity_decode(strtolower($department), ENT_NOQUOTES, 'UTF-8'));
			
			$fh_location = 'fh_location=//catalog01/en_GB/department_name={'.$dept_name.'}/categories<{catalog01_'.$parent_str.'}';
			if(!empty($sort_by)){
					$fh_location = $fh_location.'&fh_sort_by='.$sort_by;
				}
			$fh_location = $fh_location."&fh_view_size=$view_size&fh_start_index=0";
			$pass_url = $fh_location."&preview_advanced=true&fh_view_size=$view_size&fh_start_index=0";
			$paging_flag = 0;
		} else {
			$fh_location = '?fh_eds=ß&'.$fh_location;
			$pass_url = $fh_location;
			$fh_location = str_replace('~','/',$fh_location);
			$fh_location = $fh_location;
			$paging_flag = 1;
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
		//pr($result);
		
				$k = 0;
				if(!empty($items['item'])){
				foreach($items['item'] as $item) {
					
					if(!empty($item->attribute)) {
						
						foreach($item->attribute as $attribute){
							if($attribute->name == 'secondid' && !empty($attribute->value->_)){
								$cat_items[$k]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name' && !empty($attribute->value->_)){
								$cat_items[$k]['product_name'] = $attribute->value->_;
							}
							if($attribute->name == 'product_image' && !empty($attribute->value->_)){
								$cat_items[$k]['product_image'] = $attribute->value->_;
							}
							if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
								$cat_items[$k]['avg_rating'] = $attribute->value->_;
							}
							if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
								$cat_items[$k]['product_rrp'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
								$cat_items[$k]['minimum_price_used'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
								$cat_items[$k]['minimum_price_value'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_seller' && !empty($attribute->value->_)){
								$cat_items[$k]['minimum_price_seller'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used_seller' && !empty($attribute->value->_)){
								$cat_items[$k]['minimum_price_used_seller'] = $attribute->value->_;
							}
							if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
								$cat_items[$k]['condition_new'] = $attribute->value->_;
							}
							if($attribute->name == 'condition_used' && !empty($attribute->value->_)){
								$cat_items[$k]['condition_used'] = $attribute->value->_;
							}
						}
						
					}
				$k++;	
				}
				}
				
				
		
// 
		if(!empty($items['item']))
			$items = $items['item'];
		if(!empty($items)){
			if(count($items) == 1){
				
		App::import('Model','Product');
		$this->Product = &new Product;
				$qc_code = $items->attribute[0]->value->_;
				$pr_id_info = $this->Product->find('first',array('conditions'=>array('Product.quick_code'=>$qc_code),'fields'=>array('Product.id')));
				$pr_id = @$pr_id_info['Product']['id'];
				$this->Common->getProductUrl($pr_id);
				if(!empty($pr_id)){
					$this->redirect('/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id);
				} /*else {
					$this->redirect('/');
				}*/
			}
		}
// 		/** Paging parameters **/
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
			
		$Selectedcat_name = @$metaTagsArr['Category']['cat_name'];
		$pareentCategory  ='';
		$parentId = @$metaTagsArr['Category']['parent_id'];
		$pareentCategory = $this->Category->getCategoryname($parentId);
		if(!empty($pareentCategory)){
			$pareentCategory = ' | '.$pareentCategory;
		}
		/*$new_title_for_layout.= $Selectedcat_name.$pareentCategory." | ".$department.SITE_NAME; */
		/*	$brandN ='';
			$brandNC ='';
			$brandName ='';
			$brandNC = strpos($this->params['url']['fh_location'],'brand={');
			if(!empty($brandNC) && isset($brandNC)){
			$brandN = substr($this->params['url']['fh_location'],(strpos($this->params['url']['fh_location'],'brand={')+7));
			$brandN =  str_replace(array('_','}'),array(' ',''),$brandN);
			
			$brandName = $brandN." | ";
			}
			
			$new_title_for_layout = $brandName.$Selectedcat_name.$pareentCategory." | ".$department.SITE_NAME;
			if(strlen($new_title_for_layout)>100){
				$new_title_for_layout = substr($brandName.$Selectedcat_name.$pareentCategory,0,80).SITE_NAME;
			}
		$this->set('title_for_layout',$new_title_for_layout);*/
		$Selectedcat_name = @$metaTagsArr['Category']['cat_name'];
			
			$pareentCategory  ='';
			$parentId = @$metaTagsArr['Category']['parent_id'];
			$pareentCategory = $this->Category->getCategoryname($parentId);
			
			
			$brand ='';
			$brandName ='';
			
			if(empty($department)){
			$department ='';
			}else{
				$department =" | ".$department;
			}
			
			if(!empty($this->params['named']['brand'])){
				$brand = str_replace('_',' ',$this->params['named']['brand']);
				$brandName = $brand." | ";
			}else if(!empty($this->params['url']['fh_location'])){
				if (strpos($this->params['url']['fh_location'],'brand') !== false) {
					$brandName = substr($this->params['url']['fh_location'],(strpos($this->params['url']['fh_location'],'brand={')+7));
					$brandName =  str_replace(array('_','}'),array(' ',''),$brandName);
				}
			
			}
			
			}
			//FH Close
			
			$brandName = strip_tags($brandName);
			$brandName = preg_replace('/[^A-Za-z\-]/', ' ', $brandName);
			$brandName = trim($brandName);
			$Selectedcat_name_pipe =$Selectedcat_name;
			if(!empty($brandName)){
				$Selectedcat_name_pipe = " | ".$Selectedcat_name;
			}
			if(!empty($Selectedcat_name_pipe)){
				$pareentCategory = ' | '.$pareentCategory;
			}
			$new_title_for_layout = $brandName.$Selectedcat_name_pipe.$pareentCategory.$department.SITE_NAME;
			if(strlen($new_title_for_layout)>100){
				$new_title_for_layout = substr($brandName.$Selectedcat_name_pipe.$pareentCategory,0,80).SITE_NAME;
			}
			

		
		$this->set('title_for_layout',$new_title_for_layout);
		
		$new_meta_desc = "Shop for Cheap ".$brandName." ". $Selectedcat_name ." at Choiceful.com, click here to browse a huge range of ".$brandName." ". $Selectedcat_name ." at low low prices.";
		$this->set('meta_description',$new_meta_desc);
			
		/** Paging parameters **/
		$this->set('results',$results);
		$this->set('breadcrumbs',$breadcrumbs);
		//$this->set('items',$items);
		$this->set('cat_items',$cat_items);
		
		if(!Empty($facetmap)){
			if(!empty($facetmap['filter'])) {
				$facetmap = $facetmap['filter'];
			}
		}
		$this->set('facetmap',$facetmap);
	}
	
	/**
	/* function to get listing of products from data bases on the basis of category and crirteria	
	**/
	function getProductListing($selected_category = null, $criteria, $sortby='product_name'){
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$limit = 25;
		App::import('Model','ProductCategory');
		$this->ProductCategory = &new ProductCategory;
		$this->ProductCategory->expects(array('Product'));
		$this->paginate = array(
			'limit' => $limit,
			'conditions' => array('ProductCategory.category_id ='.$selected_category,'Product.status'=>"1"),
			'order' => array(
				"Product.".$sortby => 'DESC'
			),
			'fields' => array(
				'Product.id',
				'Product.quick_code',
				'Product.product_name',
				'Product.product_rrp',
				'Product.product_image',
				'ProductCategory.category_id',
			)
		);
		$arrcategoryProducts  = $this->paginate('ProductCategory', $criteria);
		$this->set('arrcategoryProducts',$arrcategoryProducts);
	}
	
	/*
	 @ productdetail
	 function to view the product details 
	 
	*/
	function productdetail($product_id = null,$cat_id = null,$conditions = null){
		$customer_also_bought = array();
		$customer_also_bought_slogan = array();
		$customer_buy_aft_this = array();
		$customer_buy_aft_this_slogan = array();
		$frequently_bought_togather = array();
		$frequently_bought_togather_slogan = array();
		$continue_shopping = array();
		$continue_shopping_slogan = array();
		$best_sellers_dept = array();
		$dept_theme_slogan = array();
		$best_sellers_cat = array();
		$best_sellers_cat_slogan = array();
		$new_meta_desc = '';
		$new_title_for_layout ='';
		
		if($this->is_really_int($product_id)){
			$product_id = mysql_real_escape_string(trim($product_id));
		} else {
			$this->Session->setFlash('Not a vaild product','default',array('class'=>'errors'));
			$this->redirect('/');
		}
		
		
		if( empty($product_id) ){
			$this->Session->setFlash('Not a vaild product','default',array('class'=>'errors'));
			$this->redirect('/homes');
		}
		
		
		// show breadcrumbs add  by pradeep on 19 feb 2013
	
		$product_breadcrumb_string = $this->productBreadcrumb($product_id);
		$this->set('product_breadcrumb_string', $product_breadcrumb_string);
		
		//ends
		
		
		###################  Add product data to the product visit ################
		App::import('Model','ProductVisit');
		$this->ProductVisit = &new ProductVisit;
		$prodId = $product_id;
		$this->Cookie->delete("RecentHistoryCookie[$prodId]");
		$this->Cookie->write("RecentHistoryCookie[$prodId]",$prodId, false);
		$this->ProductVisit->addVisitedProduct($product_id);
		$myRecentProducts = $this->ProductVisit->getMyVisitedProducts();
		$this->set('myRecentProducts',$myRecentProducts);
		#############################################
		$countries = $this->Common->getcountries();
		$this->set('countries',$countries);
		### if category not provided in url
		App::import('Model','ProductCategory');
		$this->ProductCategory = &new ProductCategory;
		if(is_null($cat_id) || empty($cat_id) ){
			$cat_id = $this->ProductCategory->getProductCategory($product_id);
		}
		App::import('Model','Category');
		$this->Category = &new Category;
		if(!empty($cat_id) ){
			$cat_name = $this->Category->getCategoryname($cat_id);
			$this->set('cat_name',$cat_name);
		}
		###################### bread crumb display ###############
		/*
		$catArray = $this->ProductCategory->getAllProductCategory($product_id);
		if(count($catArray) >0){
			foreach($catArray as $catid ):
				$parentCats = $this->getParentCategoryArray($catid);
				//pr($this->getParentCategoryArray($catid));
				//unset($parentCats);
			endforeach;
		}
		*/
		##################################################
		// pr($catArray);
		if ($this->RequestHandler->isMobile()) {
            	// if device is mobile, change layout to mobile
           			$this->layout = 'mobile/product';
           		}else{
				$this->layout = 'product';
		}
		$this->getLeftNavigations($cat_id);
		App::import('Model','Product');
		$this->Product = &new Product;
		App::import('Model','ProductQuestion');
		$this->ProductQuestion = &new ProductQuestion;
		App::import('Model','ProductAnswer');
		$this->ProductAnswer = &new ProductAnswer;
		$this->Product->expects(array('Productimage','ProductDetail'));
		$product_details = $this->Product->find('first',array('conditions'=>array('Product.id'=>$product_id,'Product.status'=>'1')));
		
		/*==Added on Oct 29==*/
		if(@$this->params['url']['review'] == 'yes')
		{
			$this->Session->write('FromEmailLink','yes');
			$this->redirect('/'.str_replace(" ","-",$product_details['Product']['product_name']).'/categories/productdetail/'.$product_id);
		}
		/*===================*/
		
		if(!empty($product_details)){
			############################################
			$prodValuesForReplacement = array();
			$prodValuesForReplacement['new_condition_id'] 	= $product_details['Product']['new_condition_id'];
			$prodValuesForReplacement['new_price'] 		= $product_details['Product']['minimum_price_value'];
			$prodValuesForReplacement['new_seller_id'] 	= $product_details['Product']['minimum_price_seller'];
			$prodValuesForReplacement['used_condition_id'] 	= $product_details['Product']['used_condition_id'];
			$prodValuesForReplacement['used_price']		= $product_details['Product']['minimum_price_used'];
			$prodValuesForReplacement['used_seller_id'] 	= $product_details['Product']['minimum_price_used_seller'];
			if(!empty($product_details['Product']['minimum_price_seller'])) {
				$getdetail_sellerId = $product_details['Product']['minimum_price_seller'];
			} else{
				$getdetail_sellerId = $product_details['Product']['minimum_price_used_seller'];
			}
			if(!empty($getdetail_sellerId)){
			/*** TO GET SELLER DETAILS ***/
			$positive_percentage_selectedSeller  = $this->Common->positivePercentFeedback($getdetail_sellerId);
			$prod_selectedSeller['Seller']['positive_percentage'] = $positive_percentage_selectedSeller;
			$avg_rating_selectedSeller = $this->Common->avgSellerRating($getdetail_sellerId);
			$prod_selectedSeller['Seller']['avg_rating'] = $avg_rating_selectedSeller['value'];
			$prod_selectedSeller['Seller']['avg_half_star'] = $avg_rating_selectedSeller['avg_half_star'];
			$prod_selectedSeller['Seller']['avg_full_star'] = $avg_rating_selectedSeller['avg_full_star'];
			$prod_selectedSeller['Seller']['count_rating'] = $avg_rating_selectedSeller['count_total_rating'];
			$prod_selectedSeller['Seller']['id'] = $getdetail_sellerId;
			$prod_selectedSeller['Seller']['product_id'] = $product_id;
			} else{
				$prod_selectedSeller = array();
			}
			$this->set('prod_selectedSeller',$prod_selectedSeller);
			/*** TO GET SELLER DETAILS ***/
			##############################################
			$this->set('title_for_layout',$product_details['ProductDetail']['meta_title']);
			$this->set('meta_description',$product_details['ProductDetail']['meta_description']);
			$meta_keywords = $product_details['ProductDetail']['meta_keywords'];
			App::import('Model','ProductSearchtag');
			$this->ProductSearchtag = &new ProductSearchtag;
			$searchtags = $this->ProductSearchtag->find('list',array('conditions'=>array('ProductSearchtag.product_id'=>$product_id,'ProductSearchtag.status'=>'1'),'fields'=>array('ProductSearchtag.tags')));
									
			$searchtag_str = '';
			if(!empty($searchtags)){
				foreach($searchtags as $searchtag){
					if(empty($searchtag_str)){
						$searchtag_str = $searchtag;
					} else{
						$searchtag_str = $searchtag_str.','.$searchtag;
					}
				}
			}
			// added by nakul on 11 sep 2011 for added in keywords metakeywords form prodcut details as well as search tag.
			$meta_keywords_arr=$meta_keywords.','.$searchtag_str;
			$meta_keywords_arr= explode(',',$meta_keywords_arr);
			$meta_keywords_set=array_unique($meta_keywords_arr);
			$meta_keywords_setvalue=implode(',',$meta_keywords_set);
			
			$this->set('meta_keywords',$meta_keywords_setvalue);
			$questions = $this->ProductQuestion->find('all',array('conditions'=>array('ProductQuestion.product_id'=>$product_id,'ProductQuestion.status'=>'1')));
			if(!empty($questions)){
				$i = 0;
				foreach($questions as $ques_det){
					$questions[$i] = $ques_det['ProductQuestion'];
					$answers = $this->ProductAnswer->find('all',array('conditions'=>array('ProductAnswer.product_question_id'=>$ques_det['ProductQuestion']['id'],'ProductAnswer.status'=>'1')));
					if(!empty($answers)){
						$j =0;
						foreach($answers as $ans){
							$answers[$j] = $ans['ProductAnswer'];
							$j++;
						}
					}
					$questions[$i]['ProductAnswer'] = $answers;
					$i++;
				}
			}
			//print_r($questions);
			$product_details['ProductQuestion'] = $questions;
			App::import('Model', 'ProductRating');
			$this->ProductRating = new ProductRating();
			$avgRating = $this->ProductRating->get_avg_rating($product_id);
			$this->set('full_stars',$avgRating['full_stars']);
			$this->set('half_star',$avgRating['half_star']);
			$this->set('total_rating_reviewers',$avgRating['total_rating_reviewers']);
			if(empty($conditions)){
				$conditions = '1-2-3-4-5-6-7';
			}
			$all_pr_sellers = $this->get_allsellers_product($product_id,$conditions,$prodValuesForReplacement,'4');
			$this->set('all_pr_sellers',$all_pr_sellers);
			$this->set('product_details',$product_details);
				
				
			/*** More to explore ***/
			App::import('Model', 'ProductCategory');
			$this->ProductCategory = new ProductCategory();
			$this->ProductCategory->expects(array('Category'));
				
			$all_pro_cats = $this->ProductCategory->find('all',array('conditions'=>array('ProductCategory.product_id'=>$product_id),'fields'=>array('ProductCategory.category_id','Category.id','Category.department_id','Category.parent_id','Category.cat_name')));
			
			$parentsArr = array();
			if(!empty($all_pro_cats)){
				foreach($all_pro_cats as $cat_index => $pro_cat){
					if(!empty($pro_cat['Category']['id'])){
						$this->parent_cat($pro_cat['Category']['id']);
						$parentsArr[] = $this->Session->read('Parents');
					}
				}
					
				if(count($all_pro_cats) < 4){
					$remaining_cates = 4 - count($all_pro_cats);
					
					$all_other_cats = $this->Category->find('list',array('conditions'=>array('Category.parent_id'=>$all_pro_cats[0]['ProductCategory']['category_id']),'fields'=>array('Category.id')));
					if(empty($all_other_cats)){
						if(!empty($all_pro_cats[0]['Category']['parent_id'])){
							$all_other_cats = $this->Category->find('list',array('conditions'=>array('Category.parent_id'=>$all_pro_cats[0]['Category']['parent_id'],'Category.id != '.$all_pro_cats[0]['ProductCategory']['category_id']),'fields'=>array('Category.id')));
						}
					}
					if(!empty($all_other_cats)){
						//pr($remaining_cates);
						$count_other_cats = count($all_other_cats);
						if($remaining_cates > $count_other_cats)
							$remaining_cates = $count_other_cats;
						$all_other_cats_rand = array_rand($all_other_cats,$remaining_cates);
						if($remaining_cates > 1){
							if(!empty($all_other_cats_rand)){
								foreach($all_other_cats_rand as $cat_index => $other_cat){
									if(!empty($other_cat)){
										$this->parent_cat($other_cat);
										$parentsArr[] = $this->Session->read('Parents');
									}
								}
							}
						} elseif($remaining_cates == 1) {
							if(!empty($all_other_cats_rand)){
								if(!empty($all_other_cats_rand)){
									$this->parent_cat($all_other_cats_rand);
									$parentsArr[] = $this->Session->read('Parents');
								}
							}
						} else {}
					}
				}
			}
			
			$this->set('moreToExploreArr',$parentsArr);
			
			//Add on 13 feb 2013 for display category array on title of the page  
			$catTitle = '';
			foreach(array_reverse($parentsArr[0]['Parents_arr']) as $parentsTitleArr){
				$catname = str_replace(array('&'),array('and'),html_entity_decode($parentsTitleArr['Category']['cat_name'], ENT_NOQUOTES, 'UTF-8'));
				$catTitle =$catTitle.' - '.$catname;
				$catname = '';
			}
			$this->set('catTitle',$catTitle);
			//End on 13 feb 2013 for display category array on title of the page
			
			/*** More to explore ***/
			
		/*** Fredhopper Call ***/
			$fh_ok = FH_OK;
			if($fh_ok == 'OK'){
			$ws_location = WS_LOCATION;
			//Create a new soap client
			//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
			$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
			$items_recomanded = array();
			
			if(!empty($all_pro_cats)){
				//pr($all_pro_cats[0]['ProductCategory']['category_id']);
				$pr_cate = $all_pro_cats[0]['ProductCategory']['category_id'];
			}

			if(!empty($pr_cate)){
				$fh_url_var = $this->fh_url($pr_cate);
			}
			if(!Empty($product_details)){
				$pr_qccode = $product_details['Product']['quick_code'];
			} else {
				$pr_qccode = '';
			}
			$fh_url_var = $fh_url_var.'&fh_secondid='.$pr_qccode;
			//$fh_location = 'fh_location=//catalog01/en_GB/&preview_search='.$pr_qccode;

			
			App::import('Model', 'Department');
			$this->Department = new Department();
			$dept_info = $this->Department->find('first',array('conditions'=>array('Department.id'=>$product_details['Product']['department_id']),'fields'=>array('Department.name','Department.id')));
			//commented by nakul on 16-02-2012
			$this->set('dept_name',$dept_info['Department']['name']);
			//$dept_name = str_replace(array('&',''),'_',strtolower($dept_info['Department']['name']));
			$dept_name = str_replace(array(' ','&'),'_', html_entity_decode(strtolower($dept_info['Department']['name']), ENT_NOQUOTES, 'UTF-8'));
			$dept_id = $dept_info['Department']['id'];
			//$fh_location = 'fh_location=//catalog01/en_GB/department_name%3d{'.$dept_name.'}&fh_view=detail&fh_reftheme=fe8f0803-928e-46ca-b167-de2375961be8%2cdetail%2c//catalog01/en_GB/department_name%3d{'.$dept_name.'}&fh_refview=lister&fh_secondid='.$pr_qccode;
			$fh_location = 'fh_location=//catalog01/en_GB/department_name={'.$dept_name.'}&fh_secondid='.$pr_qccode;
			//If i will add a Department name then BestSeller does not apper on rightpanel.
			//$fh_location = 'fh_location=//catalog01/en_GB&fh_secondid='.$pr_qccode;
			//Send the query string to the Fredhopper Query Server & obtain the result
			$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
			//Find the universe marked as 'selected' in the result
			foreach($result->universes->universe as $r) {
				if($r->{"type"} == "selected"){
					//Extract & print the breadcrumbs from the result
					if(!empty($r->themes))
						$themes = (array)$r->themes;
				}
			}
			if(!empty($themes)){
				if(!empty($themes['theme'])){
					$themes = $themes['theme'];
					if(!empty($themes)){
						foreach($themes as $theme){
							//pr($theme);
							if($theme->{'custom-fields'}->{'custom-field'}->_ == 'Customers Also Bought'){
								if(!empty($theme->items)){
									if(!empty($theme->items->item)) {
										if(count($theme->items->item) == 1){
											$customer_also_bought[0] = $theme->items->item;
											$customer_also_bought_slogan = $theme->slogan;
										}else{
											$customer_also_bought = $theme->items->item;
											$customer_also_bought_slogan = $theme->slogan;
										}
									}
								}
							} else if($theme->{'custom-fields'}->{'custom-field'}->_  == 'What Do Customers Buy'){
								if(!empty($theme->items)){
									if(!empty($theme->items->item)) {
										if(count($theme->items->item) == 1){
											$customer_buy_aft_this[0] = $theme->items->item;
											$customer_buy_aft_this_slogan = $theme->slogan;
										}else{
											$customer_buy_aft_this = $theme->items->item;
											$customer_buy_aft_this_slogan = $theme->slogan;
										}
									}
								}
							} else if($theme->{'custom-fields'}->{'custom-field'}->_ == 'Frequently Bought Together'){
								if(!empty($theme->items)){
									if(!empty($theme->items->item)) {
										if(count($theme->items->item) == 1){
											$frequently_bought_togather[0] = $theme->items->item;
											$frequently_bought_togather_slogan = $theme->slogan;
										}else{
											$frequently_bought_togather = $theme->items->item;
											$frequently_bought_togather_slogan = $theme->slogan;
										}
									}
								}
							} else if($theme->{'custom-fields'}->{'custom-field'}->_ == 'Recommended Products - Footer'){
								if(!empty($theme->items)){
									if(!empty($theme->items->item)) {
										if(count($theme->items->item) == 1){
											$continue_shopping[0] = $theme->items->item;
											$continue_shopping_slogan = $theme->slogan;
										}else{
											$continue_shopping = $theme->items->item;
											$continue_shopping_slogan = $theme->slogan;
										}
									}
								}
							} else 	if(!empty($theme->{"custom-fields"})){
									if(!empty($theme->{"custom-fields"}->{"custom-field"})){
										if(!empty($theme->{"custom-fields"}->{"custom-field"}->_)){
											if($theme->{"custom-fields"}->{"custom-field"}->_ == 'Bestsellers - Department Specific'){
												
												if(!empty($theme->items->item)) {
													if(count($theme->items->item) == 1)
														$best_sellers_dept[0] = $theme->items->item;
													else
														$best_sellers_dept = $theme->items->item;
														
													if(!empty($theme->slogan)){
														$dept_theme_slogan = $theme->slogan;
													} else {
														$dept_theme_slogan = '';
													}
												}
											} else if($theme->{"custom-fields"}->{"custom-field"}->_ == 'Bestsellers - Category Specific'){
												if(!empty($theme->items->item)) {
													if(count($theme->items->item) == 1){
														$best_sellers_cat[0] = $theme->items->item;
														$best_sellers_cat_slogan = $theme->slogan;
													}else{
														$best_sellers_cat = $theme->items->item;
														$best_sellers_cat_slogan = $theme->slogan;
													}
												}
											}
										}
									}
								}
						}
					}
				}
			}
			
			$this->set('dept_id',$dept_id);
			$this->set('customer_also_bought',$customer_also_bought);
			$this->set('customer_also_bought_slogan',$customer_also_bought_slogan);
			$this->set('customer_buy_aft_this',$customer_buy_aft_this);
			$this->set('customer_buy_aft_this_slogan',$customer_buy_aft_this_slogan);
			$this->set('frequently_bought_togather',$frequently_bought_togather);
			$this->set('frequently_bought_togather_slogan',$frequently_bought_togather_slogan);
			$this->set('continue_shopping',$continue_shopping);
			$this->set('continue_shopping_slogan',$continue_shopping_slogan);
			$this->set('best_sellers_dept',$best_sellers_dept);
			$this->set('dept_theme_slogan',$dept_theme_slogan);
			$this->set('best_sellers_cat',$best_sellers_cat);
			$this->set('best_sellers_cat_slogan',$best_sellers_cat_slogan);
			
// 			pr($themes);
			$this->set('themes',$themes);
			}
			/** End of Fredhopper Call **/
			//$new_title_for_layout.= substr(substr($product_details['Product']['product_name'],0,35)." | ".$new_catTitle.$dept_info['Department']['name'].SITE_NAME,0,100); 
			$product_title = $product_details['Product']['product_name'];
			if(strlen($product_title)>80){
				$product_title = substr($product_title,0,80);
				$new_title_for_layout = $product_title.SITE_NAME;
			}else{
				$new_title_for_layout.= substr($product_title." | ".$cat_name.SITE_NAME,0,100);
			}
			$product_title_meta = $product_title;
			if(strlen($product_title)>60){
				$product_title_meta = substr($product_title,0,60);
			}
			$new_meta_desc = "Buy ".$product_title_meta." from Choiceful.com now, or click here to browse more items from the ".$cat_name." department";

			$this->set('title_for_layout',$new_title_for_layout);
			$this->set('meta_description',$new_meta_desc);
			
			/** End of Fredhopper Call **/
			
		} else{
			$this->Session->setFlash('Product does not exist','default',array('class'=>'flashError'));
			$this->redirect('/homes');
		}
	}



	
	
	function parent_cat($cat_id = null,$count = null){
		if(!empty($count)){
			$i = $count;
		} else {
			$i = 0;
			$new_parentArr = array();
		}
		App::import('Model', 'Category');
		$this->Category = new Category();
		$category_info = $this->Category->find('first',array('conditions'=>array('Category.id'=>$cat_id),'fields'=>array('Category.id','Category.parent_id','Category.department_id','Category.cat_name')));

		$is_array_exists = $this->Session->read('new_parentArr');
		if(!empty($is_array_exists)){
			$new_parentArr = $is_array_exists;
			$this->Session->delete('new_parentArr');
		}
		
		if(!empty($category_info)){
			if(!empty($category_info['Category']['parent_id'])){
				$new_parentArr['Parents_arr'][$i] = $category_info;
				$this->Session->write('new_parentArr',$new_parentArr);
				$i = $i+1;
				$this->parent_cat($category_info['Category']['parent_id'],$i);
			} else {
				App::import('Model', 'Department');
				$this->Department = new Department();
				$dept = $this->Department->find('first',array('conditions'=>array('Department.id'=>$category_info['Category']['department_id']),'fields'=>array('Department.name','Department.id')));
				//$category_info['Dept'] = $dept;
				$new_parentArr['Parents_arr'][$i] = $category_info;
				$new_parentArr['Dept'] = $dept;
				krsort($new_parentArr['Parents_arr']);
				//pr($new_parentArr);
				$this->Session->write('Parents',$new_parentArr);
			}
		}
	}


	/**
	@function:	admin_index
	@description:	to enlarge the image on click
	@params:	image id
	@Created by: 	Ramanpreet Pal Kaur
	@Modify:	NULL
	@Created Date:	
	*/	
	function enlarge_image($image_id = null, $product_id = null){
		App::import('Model','Productimage');
		$this->Productimage = &new Productimage;
		$this->Productimage->expects(array('Product'));
		$main_image1 = $this->Productimage->find('first',array('conditions'=>array('Productimage.id'=>$image_id),'fields'=>array('Productimage.image','Product.product_name','Product.id')));
		$main_image['image'] = $main_image1['Productimage']['image'];
		$main_image['product_name'] = $main_image1['Product']['product_name'];
		$main_image['id'] = $main_image1['Product']['id'];
		$this->set('main_image',$main_image);
		
		if ($this->RequestHandler->isMobile()) {
			App::import('Model','Product');
			$this->Product = &new Product;
			//$main_image2 = $this->Product->find('first',array('conditions'=>array('Product.id'=>$image_id),'fields'=>array('Product.product_image','Product.product_name')));
			
			$this->Product->expects(array('Productimage'));
			$main_image2 = $this->Product->find('first',array('conditions'=>array('Product.id'=>$product_id),'fields'=>array('Product.product_image','Product.product_name','Product.id','Product.product_rrp','Product.minimum_price_value','Product.minimum_price_seller','Product.minimum_price_used','Product.minimum_price_used_seller','Product.new_condition_id')));
			$main_image_additional['Product']['id'] = $main_image2['Product']['id'];
			$main_image_additional['Product']['product_rrp'] = $main_image2['Product']['product_rrp'];
			$main_image_additional['Product']['minimum_price_value'] = $main_image2['Product']['minimum_price_value'];
			$main_image_additional['Product']['minimum_price_seller'] = $main_image2['Product']['minimum_price_seller'];
			$main_image_additional['Product']['minimum_price_used'] = $main_image2['Product']['minimum_price_used'];
			$main_image_additional['Product']['minimum_price_used_seller'] = $main_image2['Product']['minimum_price_used_seller'];
			$main_image_additional['Product']['new_condition_id'] = $main_image2['Product']['new_condition_id'];
			$main_image_additional['Product']['image'] = $main_image2['Product']['product_image'];
			$main_image_additional['Product']['product_name'] = $main_image2['Product']['product_name'];
			$main_image_additional['Productimage'] = $main_image2['Productimage'];
			$this->set('main_image_additional',$main_image_additional);	
				
           			$this->layout = 'mobile/product';
           		}else{
				$this->layout = 'ajax';
		}
	}

	/**
	@function:	admin_index
	@description:	to enlarge the product's main image on click
	@params:	image id
	@Created by: 	Ramanpreet Pal Kaur
	@Modify:	NULL
	@Created Date:	
	*/	
	function enlarge_mainimage($image_id = null){
		App::import('Model','Product');
		$this->Product = &new Product;
		//$main_image2 = $this->Product->find('first',array('conditions'=>array('Product.id'=>$image_id),'fields'=>array('Product.product_image','Product.product_name')));
		
		$this->Product->expects(array('Productimage'));
		$main_image2 = $this->Product->find('first',array('conditions'=>array('Product.id'=>$image_id),'fields'=>array('Product.product_image','Product.product_name','Product.id','Product.product_rrp','Product.minimum_price_value','Product.minimum_price_seller','Product.minimum_price_used','Product.minimum_price_used_seller','Product.new_condition_id')));
		$main_image['Product']['id'] = $main_image2['Product']['id'];
		$main_image['Product']['product_rrp'] = $main_image2['Product']['product_rrp'];
		$main_image['Product']['minimum_price_value'] = $main_image2['Product']['minimum_price_value'];
		$main_image['Product']['minimum_price_seller'] = $main_image2['Product']['minimum_price_seller'];
		$main_image['Product']['minimum_price_used'] = $main_image2['Product']['minimum_price_used'];
		$main_image['Product']['minimum_price_used_seller'] = $main_image2['Product']['minimum_price_used_seller'];
		$main_image['Product']['new_condition_id'] = $main_image2['Product']['new_condition_id'];
		$main_image['Product']['image'] = $main_image2['Product']['product_image'];
		$main_image['Product']['product_name'] = $main_image2['Product']['product_name'];
		$main_image['Productimage'] = $main_image2['Productimage'];
		
		$this->set('main_image',$main_image);
		if ($this->RequestHandler->isMobile()) {
            	// if device is mobile, change layout to mobile
           			$this->layout = 'mobile/product';
           		}else{
				$this->layout = 'ajax';
		}
		//$this->layout='ajax';
	}

	/**
	@function:	admin_index
	@description:	to get all sellers for the selected product
	@params:	product id, prduct conditions, products conditions to display these will conditions will replace the previous one
	@Created by: 	Ramanpreet Pal Kaur
	@Modify:	NULL
	@Created Date:	
	*/	
	function get_allsellers_product($pr_id = null, $conditions = null,$prodValuesForReplacement = null,$check=null) {
		if($check !=4){
			if($this->RequestHandler->isAjax()!=1) {
				$this->redirect('/');
			}
		}
		$product_id = $pr_id;
		$this->set('product_id',$product_id);
		$this->set('conditions',$conditions);
		App::import('Model', 'ProductCondition');
		$this->ProductCondition = new ProductCondition();
		// get product conditions array
		$product_condition_array = $this->ProductCondition->getProductConditions();
		$this->set('product_condition_array', $product_condition_array);
		$conditions = str_replace('-',',',$conditions);
		$allSellers = array();
		$new_array = array();
		if (!empty($this->passedArgs['updateId'])) {
			$this->set('updateId', $this->passedArgs['updateId']);
		}
		if(empty($product_id) && is_null($product_id) ){
		} else{
			App::import('Model','ProductSeller');
			$this->ProductSeller = new ProductSeller();
			$this->paginate = array(
				'limit' => 3,
				'conditions' =>array('ProductSeller.product_id'=>$product_id,
					'ProductSeller.condition_id IN ('.$conditions.')',
					'ProductSeller.listing_status' => '1'),
				'order' => array(
					'ProductSeller.price' => 'ASC'
				),
				'fields' => array(
					'ProductSeller.id',
					'ProductSeller.quantity',
					'ProductSeller.seller_id',
					'ProductSeller.condition_id',
					'ProductSeller.standard_delivery_price',
					'ProductSeller.notes',
					'ProductSeller.express_delivery',
					'ProductSeller.express_delivery_price',
					'ProductSeller.minimum_price_disabled',
					'ProductSeller.minimum_price',
					'ProductSeller.price',
					'ProductSeller.dispatch_country'
					
				)
			);
			$prodSellers = $this->paginate($this->ProductSeller);
			if(!empty($prodSellers)){
				App::import('Model','Seller');
				$this->Seller = new Seller();
				$i = 0;
				foreach($prodSellers as $prodSeller){
					if(!empty($prodValuesForReplacement)){
						if(($prodValuesForReplacement['new_condition_id'] == $prodSeller['ProductSeller']['condition_id']) && ($prodValuesForReplacement['new_seller_id'] == $prodSeller['ProductSeller']['seller_id'])){
							$prodSellers[$i]['ProductSeller']['price'] = $prodValuesForReplacement['new_price'];
						}
						if(($prodValuesForReplacement['used_condition_id'] == $prodSeller['ProductSeller']['condition_id']) && ($prodValuesForReplacement['used_seller_id'] == $prodSeller['ProductSeller']['seller_id'])){
							$prodSellers[$i]['ProductSeller']['price'] = $prodValuesForReplacement['used_price'];
						}
					}
					$sellerinfo =  $this->Seller->find('first', array('conditions'=>array('Seller.user_id'=>$prodSeller['ProductSeller']['seller_id']),'fields'=>array('Seller.id','Seller.user_id','Seller.user_id','Seller.free_delivery','Seller.threshold_order_value','Seller.business_display_name')));
					$prodSellers[$i]['Seller'] = $sellerinfo['Seller'];
					$positive_percentage  = $this->Common->positivePercentFeedback($prodSeller['ProductSeller']['seller_id']);
					$prodSellers[$i]['Seller']['positive_percentage'] = $positive_percentage;
					$avg_seller_rating = $this->Common->avgSellerRating($prodSeller['ProductSeller']['seller_id']);
					$prodSellers[$i]['Seller']['avg_rating'] = $avg_seller_rating['value'];
					$prodSellers[$i]['Seller']['avg_half_star'] = $avg_seller_rating['avg_half_star'];
					$prodSellers[$i]['Seller']['avg_full_star'] = $avg_seller_rating['avg_full_star'];
					$prodSellers[$i]['Seller']['count_rating'] = $avg_seller_rating['count_total_rating'];
					$prodSellers[$i]['Seller']['pr_seller_id'] = $prodSeller['ProductSeller']['seller_id'];
					$prodSellers[$i]['Seller']['pr_id'] = $product_id;
					$i = $i+1;
				}
			}
			$all_sellers = $prodSellers;
		}
		$sorted_seller = $all_sellers;
		$sellersArr_lowestprice =array();
		if(!empty($all_sellers)){
			$i = 0;
			foreach($all_sellers as $seller_index => $seller){
				$pr_price = $seller['ProductSeller']['price'];
				//$all_sellers[$i]['ProductSeller']['display_price'] = $pr_price;
				$pr_price = ($seller['ProductSeller']['price']+$seller['ProductSeller']['standard_delivery_price']);
				$new_array_prices[$seller['ProductSeller']['seller_id'].'_'.$seller['ProductSeller']['condition_id']] = $pr_price;
				$new_array[$pr_price] = $seller;
				$i++;
			}
			asort($new_array_prices);
			foreach($new_array_prices as $index => $new_array_price){
				$indexArr = explode('_',$index);
				$sellerID = $indexArr[0];
				$conditionID = $indexArr[1];
				foreach($all_sellers as $seller_index => $seller_price){
					if($seller_price['ProductSeller']['seller_id'] == $sellerID && $seller_price['ProductSeller']['condition_id'] == $conditionID  ){
						$sellersArr_lowestprice[] = $seller_price;
					} else{

					}
				}
			}
		}
		$this->set('all_sellers',$sellersArr_lowestprice);
		if($this->RequestHandler->isAjax()==1) {
			$countries = $this->Common->getcountries();
			$this->set('countries',$countries);
			$product_details['Product']['id'] = $product_id;
			$this->set('product_details',$product_details);
			$this->set("throughAjax", 1);
			if ($this->RequestHandler->isMobile()) {
			$this->viewPath = 'elements/mobile/product' ;
			$this->render('buying_choices');
			}else{
			$this->viewPath = 'elements/product' ;
			$this->render('buying_choices');
			}
			
		 }
		 if ($this->RequestHandler->isMobile()) {
            	// if device is mobile, change layout to mobile
           		$this->set("isMobile", true);
		}
		return $sellersArr_lowestprice;
	}
	
	/********************************************** */
	/** 
	@function:	productBreadcrumb	
	@description	create breadcrumb for products details page for front end side	
	@Created by: 	Pradeep kumar
	@params		category id & product id
	@Modify: 
	@Created Date:	20 Feb 2013	
	*/
	
	function productBreadcrumb($product_id=null){
	
		App::import('Model','ProductCategory');
		$this->ProductCategory = &new ProductCategory;
		$category_id = $this->ProductCategory->getProductCategory($product_id);
		
		// get department name and id 
		$this->Category->expects( array( 'Department' ) );
		$departArr  = $this->Category->find('first' , array(
			'conditions' => array('Category.id' => $category_id),
			'fields' => array('Department.name', 'Department.id')
		));
		$department_name = $departArr['Department']['name'];
		$department_id = $departArr['Department']['id'];
		//$link_seperator = "&raquo;" ;
		$dept_url_name = strtolower(str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8')));
		$link_seperator = " > " ;
		//$strLink = '<div class="crumb_text_break"><strong>You are here:</strong><a href="/" class="star_c"><img src="/img/star_c.png" border=0 ></a></div><div class="crumb_img_break">'.$link_seperator ;
		$strLink = '<li><a href="/" class="star_c1">Choiceful</a></li>' ;

		$strLink .= '<li><a href="'.SITE_URL.''.strtolower($dept_url_name).'/departments/index/'.$department_id.'" >' .$department_name. '</a></li>';
		
		//$strLink .= $link_seperator;
			
			
			$finalArr = $this->getParentCategoryArray($category_id);
			if(isset($product_id) && !empty($product_id)){
				App::import('Model','Product');
				$this->Product = &new Product;
				$proArr  = $this->Product->find('first' , array(
					'conditions' => array('Product.id' => $product_id),
					'fields' => array('Product.product_name')));
				if(count($finalArr) >0){
					$finalArr[$product_id] = $proArr['Product']['product_name'];
				}
			}
				
			$totalCount = count($finalArr);
			if( is_array($finalArr) ){
				$j = 0;
				foreach($finalArr as $key=>$value){
					$j++;
					
					if($j == $totalCount){
						
						$strLink .= "<li  class='last'><span>".$value."</span></li>";	
					}
					else if($j == ($totalCount-1)){
						
						$innerlink = SITE_URL.$dept_url_name.'/'.strtolower($cat_url_name).'/categories/viewproducts/'.$key.'/'.$department_id;
						$strLink .='<li><a class="active" href="'.$innerlink.'">' .$value. '</a></li>';
						//$strLink .= $link_seperator;	
					}
					else{
						
						$cat_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($value, ENT_NOQUOTES, 'UTF-8'));
						
						$innerlink = SITE_URL.strtolower($dept_url_name).'/'.strtolower($cat_url_name).'/categories/index/'.$key;
						$strLink .='<li><a href="'.$innerlink.'">' .$value. '</a></li>';
						//$strLink .= $link_seperator;
					}
				}
			}
			
			//die;
			//echo $strLink;
			//die;
			 
                  
               
			
		return $strLink;
	}
	


/** 
	@function:		admin_export 
	@description:		export categories and its data as csv
	@params:		
	@Modify:		
	@Created Date:		10-March-2013
	*/
	
	function admin_export(){
	App::import('Model','Department');
	$this->Department = &new Department;
	$this->data = $this->Department->find('all',array('fields'=>array('Department.id','Department.name')));
	
		$csv_output='';
		if(count($this->data) > 0){
			foreach($this->data as $value){
				
				foreach($value['Department'] as $field_index => $user_info){
					$value['Department'][$field_index] = html_entity_decode($user_info);
					$value['Department'][$field_index] = str_replace('&#039;',"'",$value['Department'][$field_index]);
				}
				
				
				$categories = $this->Category->getTopCategory($value['Department']['id']);
				
				$csv_output .= strtoupper($value['Department']['name'])." (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/departments/index/".$value['Department']['id'].")"."\n";
				
				foreach ($categories as $key=>$cats){
					
				$csv_output .= ";".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$key.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$key/".$value['Department']['id'].")\n";
				$childCategoryArr = $this->getChildCategory($key);
				
				foreach($childCategoryArr as $cat_id=>$cat_name) {
				$childCatCount =  $this->Category->getChildCount($cat_id);
				$csv_output .= ";;".trim(html_entity_decode(str_replace(',','-',$cat_name)))." (".$cat_id.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cat_name))."/categories/viewproducts/$cat_id/".$value['Department']['id'].") \n";
				
				if($childCatCount > 0){
				$childCategoryArr1 = $this->getChildCategory($cat_id);
				foreach($childCategoryArr1 as $catid=>$cats) {
				$childCatCount1 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].") \n";
				if($childCatCount1 > 0){
				$childCategoryArr2 = $this->getChildCategory($catid);
				foreach($childCategoryArr2 as $catid=>$cats) {
				$childCatCount2 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].") \n";
				
				if($childCatCount2 > 0)
				{
				$childCategoryArr3 = $this->getChildCategory($catid);
				foreach($childCategoryArr3 as $catid=>$cats) {
				$childCatCount3 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].") \n";
				
				if($childCatCount3 > 0)
				{
				$childCategoryArr4 = $this->getChildCategory($catid);
				foreach($childCategoryArr4 as $catid=>$cats) {
				$childCatCount4 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].") \n";
				
				if($childCatCount4 > 0)
				{
				$childCategoryArr5 = $this->getChildCategory($catid);
				foreach($childCategoryArr5 as $catid=>$cats) {
				$childCatCount5 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].") \n";
				
				if($childCatCount5 > 0)
				{
				$childCategoryArr6 = $this->getChildCategory($catid);
				foreach($childCategoryArr6 as $catid=>$cats) {
				$childCatCount6 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].") \n";
				if($childCatCount6 > 0)
				{
				$childCategoryArr7 = $this->getChildCategory($catid);
				foreach($childCategoryArr7 as $catid=>$cats) {
				$childCatCount7 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].") \n";
				if($childCatCount7 > 0)
				{
				$childCategoryArr8 = $this->getChildCategory($catid);
				foreach($childCategoryArr8 as $catid=>$cats) {
				$childCatCount8 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].")\n";
				if($childCatCount8 > 0)
				{
				$childCategoryArr9 = $this->getChildCategory($catid);
				foreach($childCategoryArr9 as $catid=>$cats) {
				$childCatCount9 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].")\n";
				if($childCatCount9 > 0)
				{
				$childCategoryArr10 = $this->getChildCategory($catid);
				foreach($childCategoryArr10 as $catid=>$cats) {
				$childCatCount10 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].")\n";
				if($childCatCount10 > 0)
				{
				$childCategoryArr11 = $this->getChildCategory($catid);
				foreach($childCategoryArr11 as $catid=>$cats) {
				$childCatCount11 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].") \n";
				if($childCatCount11 > 0)
				{
				$childCategoryArr12 = $this->getChildCategory($catid);
				foreach($childCategoryArr12 as $catid=>$cats) {
				$childCatCount12 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;;;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].") \n";
				if($childCatCount12 > 0)
				{
				$childCategoryArr13 = $this->getChildCategory($catid);
				foreach($childCategoryArr13 as $catid=>$cats) {
				$childCatCount13 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;;;;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].") \n";
				if($childCatCount13 > 0)
				{
				$childCategoryArr14 = $this->getChildCategory($catid);
				foreach($childCategoryArr14 as $catid=>$cats) {
				$childCatCount14 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;;;;;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].")\n";
				if($childCatCount14 > 0)
				{
				$childCategoryArr15 = $this->getChildCategory($catid);
				foreach($childCategoryArr15 as $catid=>$cats) {
				$childCatCount15 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;;;;;;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].")\n";
				if($childCatCount15 > 0)
				{
				$childCategoryArr16 = $this->getChildCategory($catid);
				foreach($childCategoryArr16 as $catid=>$cats) {
				$childCatCount16 =  $this->Category->getChildCount($catid);
				$csv_output .= ";;;;;;;;;;;;;;;;;;".trim(html_entity_decode(str_replace(',','-',$cats)))." (".$catid.") (".SITE_URL.str_replace(' & ','-and-',html_entity_decode($value['Department']['name']))."/".str_replace(' & ','-and-',html_entity_decode($cats))."/categories/viewproducts/$catid/".$value['Department']['id'].")\n";
				
				}
				}
				}
				}
				}
				}
				}
				}
				}
				}
				}
				}
				}
				}
				
				}
				}
				}
				}
				
				}
				}
				}
				}
				
				}
				}
				
				}
				}
				
				
				}
				}
				}
				}
				
				}
				
				}
				
				} // sub labels end here */
				
				}
				
				$csv_output .= "\n";
			}
		}else{
			$csv_output .= "No Record Found.."; 
		}
		
		header("Content-type: application/vnd.ms-excel");
		$filePath="categories_".date("Ymd").".csv";
		header("Content-Disposition: attachment; filename=".$filePath."");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $csv_output;
		exit;
	}
	
	
	/**
	@function:	reviewqa
	@description:	Only for mobile to auto refrease the tab for review Question and answer
	@params:	product id
	@Created by: 	Nakul
	@Modify:	NULL
	@Created Date:	7 Jun 2013
	*/
	function reviewqa($product_id = null)
	{
		
		App::import('Model','ProductQuestion');
		$this->ProductQuestion = &new ProductQuestion;
		App::import('Model','ProductAnswer');
		$this->ProductAnswer = &new ProductAnswer;
		
		$product_details['Product']['id'] = $product_id;
		$questions = $this->ProductQuestion->find('all',array('conditions'=>array('ProductQuestion.product_id'=>$product_id,'ProductQuestion.status'=>'1')));
			if(!empty($questions)){
				$i = 0;
				foreach($questions as $ques_det){
					$questions[$i] = $ques_det['ProductQuestion'];
					$answers = $this->ProductAnswer->find('all',array('conditions'=>array('ProductAnswer.product_question_id'=>$ques_det['ProductQuestion']['id'],'ProductAnswer.status'=>'1')));
					if(!empty($answers)){
						$j =0;
						foreach($answers as $ans){
							$answers[$j] = $ans['ProductAnswer'];
							$j++;
						}
					}
					$questions[$i]['ProductAnswer'] = $answers;
					$i++;
				}
			}
			$product_details['ProductQuestion'] = $questions;
		
		$this->set('product_details', $product_details);
		$this->viewPath = 'elements/mobile/product' ;
		$this->render('reviews');
		$this->render('question_answers');
	}
}?>