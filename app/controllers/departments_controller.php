<?php
/**  @class:		DepartmentsController 
 @Created by: 		RAMANPREET PAL KAUR
 @Modify:		NULL
 @Created Date:		03-10-2010
 
*/
App::import('Sanitize');
class DepartmentsController extends AppController{
	var $name = 'Departments';
	var $helpers = array('Form','Html','Javascript','Session','Format','Common','Ajax', 'Validation');
	var $components = array ('RequestHandler', 'Common');
	var $permission_id = 4; // for department module
	
	/**
	* @Date: Dec 12, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		//check session other than admin_login page
		$this->detectMobileBrowser();
		$includeBeforeFilter = array('admin_index','admin_export', 'admin_add', 'admin_status','admin_view', 'admin_delete', 'admin_multiplAction','admin_departmentlist' );
		if (in_array($this->params['action'],$includeBeforeFilter)){
			// validate module 
			$this->validateAdminModule($this->permission_id);
			// validate admin session
			$this->checkSessionAdmin();
			
		}
	}
	
	/**
	@function:	admin_index
	@description:	listing of departments,
	@params:	NULL
	@Created by: 	Ramanpreet Pal Kaur
	@Modify:	NULL
	@Created Date:	Oct 19, 2010
	*/		

	function admin_home(){
		
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
		$options['Department.name'] = "Name";
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
					$criteria .= " and (Department.name LIKE '%".$value1."%')";
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
					$criteria .= " and Department.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		
		/** sorting and search */
		if($this->RequestHandler->isAjax()==0)
			$this->layout = 'layout_admin';
		else
			$this->layout = 'ajax';
	
		$this->admin_departmentlist($criteria,$value,$show,$fieldname);
		$departments = $this->admin_departmentlist($criteria,$value,$show,$fieldname);
		
		$this->set('listTitle','Manage Departments');
		$this->set('departments',$departments);
	}

	/**
	@function:admin_add 
	@description:Add/edit departments,
	@params:id
	@Created by: Ramanpreet Pal Kaur
	@Modify:NULL
	@Created Date:Oct 19, 2010
	*/
	function admin_add($id=Null){
		$this->layout = 'layout_admin';
		if(empty($id))
			$this->set('listTitle','Add New Department');
		else
			$this->set('listTitle','Update Department Details');
		
		
		$this->set("id",$id);
		
		if(!empty($this->data)){
			$this->Department->set($this->data);
			if($this->Department->validates()){
				$this->Department->set($this->data);
				//$this->data = Sanitize::clean($this->data);
				
				if ($this->Department->save($this->data)) {
					$this->Session->setFlash('Information updated successfully.');
					$this->redirect(array('action' => 'home'));
				}else {
					$this->set('errors',$this->Department->validationErrors);
				}
			} else {
				$this->set('errors',$this->Department->validationErrors);
			}
		} else{
			$this->Department->id = $id;
			$this->data = $this->Department->findById($id);
			$this->data['Department'] = $this->data['Department'];
			if(!empty($this->data['Department'])){
				foreach($this->data['Department'] as $field_index => $info){
					$this->data['Department'][$field_index] = html_entity_decode($info);
					$this->data['Department'][$field_index] = str_replace('&#039;',"'",$this->data['Department'][$field_index]);
					$this->data['Department'][$field_index] = str_replace('\n',"",$this->data['Department'][$field_index]);
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
	@Created Date:		Oct 19, 2010
	**/
	
	function admin_status($id,$status=0){	
		
		$this->Department->id = $id;
		if($status==1){
			$this->Department->saveField('status','0');
			$this->Session->setFlash('Information updated  successfully.');
		} else {
			$this->Department->saveField('status','1');
			$this->Session->setFlash('Information updated  successfully.');
		}
		
		$this->redirect('/admin/departments/home');
	}
	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	Oct 19, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_multiplAction(){
		if($this->data['Department']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
				$this->Department->id=$id;
				$this->Department->saveField('status','1');
				$this->Session->setFlash('Information updated successfully.');
				}	
			}
		} elseif($this->data['Department']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Department->id=$id;
					$this->Department->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');	
				}
			}
		} elseif($this->data['Department']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Department->id=$id;
					$this->Department->delete($id);
					$this->Session->setFlash('Information deleted successfully.');	
				}
			}
		}
		/** for searching and sorting*/
		$this->redirect('/admin/departments/home');
	}


	/** 
	@function	:	admin_delete
	@description	:	Delete the department
	@params		:	$id=id of row
	@created	:	Oct 19,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete($id=null){
		if(!empty($id)){
			$this->Department->id=$id;
			$this->Department->delete($id);
			$this->Session->setFlash('Information deleted successfully.');	
		} else{
			$this->Session->setFlash('Information not deleted.','default',array('class'=>'flashError'));	
		}
		$this->redirect('/admin/departments');
		
	}

	/** 
	@function	:	admin_departmentlist
	@description	:	to generate list of departments
	@params		:	$id=id of row
	@created	:	Oct 19,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_departmentlist($criteria = null,$value=null,$show=null,$fieldname=null){
		$this->set('keyword', $value);
		$this->set('show', $show);
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
		
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'Department.name' => 'ASC'
					)
		);
		$departments = $this->paginate('Department',$criteria);
		
		return $departments;
	}
	
	
	/**
	* @Date: Oct 15, 2010
	* @Method : index
	* @Purpose: This function is to show home page departments .
	* @Param: none
	* @Return: none 
	**/
	function a_z_index(){
		$this->layout = 'product';
		$this->set('selected_department', 0);
		$this->set('title_for_layout','Choiceful.com Department Index: Buy & Sell Millions of Products');
		$departments = $this->Department->find('list') ;
		$this->set('departments', $departments);
	}

	/**
	* @Date: Oct 15, 2010
	* @Method : index
	* @Purpose: This function is to show home page departments .
	* @Param: none
	* @Return: none 
	**/
	function index( $selected_department = null){
		
		$depName =$this->params['url']['url'];
		switch($depName){
			case 'books':
				$selected_department =1;
				break;
			case 'music':
				$selected_department =2;
				break;
			case 'movies':
				$selected_department =3;
				break;
			case 'games':
				$selected_department =4;
				break;
			case 'electronics':
				$selected_department =5;
				break;
			case 'office-and-computing':
				$selected_department =6;
				break;
			case 'mobile':
				$selected_department =7;
				break;
			case 'home-and-garden':
				$selected_department =8;
				break;
			case "health-and-beauty":
				$selected_department =9;
				break;
			default :
				break;
		}
		if ($this->RequestHandler->isMobile()) {
            	// if device is mobile, change layout to mobile
           		$this->layout = 'mobile/home';
           		 	}else{
			$this->layout = 'home';
		}
		$this->set('selected_department', $selected_department);
		
		
		//show breadcrumbs starts here
		$strBreadcrumb = $this->frontendBreadcrumb($selected_department);
		$this->set('breadcrumb_string', $strBreadcrumb);
		$new_meta_desc = '';
		$new_title_for_layout ='';		
		//ends	
			
		###################  Add department data to the department_visits table ################
		App::import('Model','DepartmentVisit');
		$this->DepartmentVisit = &new DepartmentVisit;
		$deptId = $selected_department;
		$this->set('deptId',$deptId);
		$this->DepartmentVisit->addVisitedDepartment($deptId);
		#############################################
			
			
			
		$cate_arr = array();
		////////////  set meta tags keywords
		$metaTagsArr = $this->Department->find('first',array(
			'conditions' => array('Department.id' =>$selected_department, 'Department.status' => 1 ),
			'fields'=>array('Department.name','Department.meta_title','Department.meta_keywords', 'Department.meta_description')
			 ));
		if(!empty($metaTagsArr) ){
			$this->set('title_for_layout',      $metaTagsArr['Department']['meta_title']);
			$this->set('meta_keywords',         $metaTagsArr['Department']['meta_keywords']);
			$this->set('meta_description',      $metaTagsArr['Department']['meta_description']);
		}
		
		////////////////////////////////////////////////////
		$facetmap = array();
		$ws_location = WS_LOCATION;
		//Create a new soap client
		//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		$this->set('selected_department',$selected_department);
		if($selected_department == 1){
			$fh_location = '?fh_view=detail&fh_refview=home&fh_refpath=facet_8&fh_reffacet=department_name&fh_oneslice=yes&fh_location=%2f%2fcatalog01%2fen_GB%2fdepartment_name%3d{books}&fh_eds=%C3%9F';
		} else if($selected_department == 2){
			$fh_location = '?fh_refview=home&fh_refpath=facet_8&fh_reffacet=department_name&fh_oneslice=yes&fh_location=%2F%2Fcatalog01%2Fen_GB%2Fdepartment_name%3D{music}&fh_eds=ß';
		} else if($selected_department == 3){
			$fh_location = '?fh_refview=home&fh_refpath=facet_8&fh_reffacet=department_name&fh_location=%2f%2fcatalog01%2fen_GB%2fdepartment_name%3d{movies}&fh_eds=ß';
		} else if($selected_department == 4){
			$fh_location = '?fh_refview=home&fh_refpath=facet_8&fh_reffacet=department_name&fh_location=%2f%2fcatalog01%2fen_GB%2fdepartment_name%3d{games}&fh_eds=ß';
		} else if($selected_department == 5){
			$fh_location = '?fh_view=detail&fh_refview=home&fh_refpath=facet_8&fh_reffacet=department_name&fh_oneslice=yes&fh_location=%2f%2fcatalog01%2fen_GB%2fdepartment_name%3d{electronics}&fh_eds=ß';
			
		} else if($selected_department == 6){
			$fh_location = '?fh_refview=home&fh_refpath=facet_8&fh_reffacet=department_name&fh_location=%2F%2Fcatalog01%2Fen_GB%2Fdepartment_name%3D{office___computing}&fh_eds=ß';
		} else if($selected_department == 7){
			$fh_location = '?fh_refview=home&fh_refpath=facet_8&fh_reffacet=department_name&fh_location=%2f%2fcatalog01%2fen_GB%2fdepartment_name%3d{mobile}&fh_eds=ß';
		} else if($selected_department == 8){
			$fh_location = '?fh_refview=home&fh_refpath=facet_8&fh_reffacet=department_name&fh_location=%2f%2fcatalog01%2fen_GB%2fdepartment_name%3d{home___garden}&fh_eds=ß';
			
		} else if($selected_department == 9){
			$fh_location = '?fh_refview=home&fh_refpath=facet_8&fh_reffacet=department_name&fh_location=%2f%2fcatalog01%2fen_GB%2fdepartment_name%3d{health___beauty}&fh_eds=ß';
		}
		if(!empty($fh_location)){
			$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
			//Find the universe marked as 'selected' in the result
			foreach($result->universes->universe as $r) {
				if($r->{"type"} == "selected"){
					//Extract & print the breadcrumbs from the result
					if(!empty($r->facetmap))
						$facetmap = (array)$r->facetmap;
				}
			}
			if(!empty($facetmap['filter'])){
					
				foreach($facetmap['filter'] as $f){
					if(!empty($f->title)){
						if($f->title == 'categories'){
							$cate_arr = $f->filtersection;
							
						}
					}
				}
			}
		}
		$this->set('cate_arr',$cate_arr);
		# get a list of all  advertisement banners/advertisements
		App::import('Model','Advertisement');
		$this->Advertisement = & new Advertisement();
		$this->set( 'AdsData', $this->Advertisement->getAdvertisementsList());
		
		// fetch department name for selected department id
		$department_name = $this->Department->getDepartmentName($selected_department) ;
		$this->set('department_name', $department_name);
		
		$new_title_for_layout.= $department_name.SITE_NAME; 
		$this->set('title_for_layout',$new_title_for_layout);
		
		$new_meta_desc = "Shop for Cheap ". $department_name ." at Choiceful.com, click here to browse a huge range of ". $department_name ." at low low prices.";
		$this->set('meta_description',$new_meta_desc);
		
		
		// get list of departments for left navigation links
		App::import('Model','Category');
		$this->Category = & new Category();

		if( !is_null($selected_department) && $selected_department > 0 ){ 
			$topCategoryArr = $this->Category->find('list',array(
				'conditions' => array('Category.parent_id' => 0 , 'Category.department_id' =>$selected_department, 'Category.status' => 1 ),
				'fields'=>array('Category.id','Category.cat_name'),
				
				//'limit'=>10,
				'order'=>array('Category.cat_name')));
		
			$this->set('topCategoryArr', $topCategoryArr);
		} else{ // show all departments
			$departments = $this->Department->find('list') ;
			$this->set('departments', $departments);
		}
		// set
		$this->pick_of_day();
		//assign the  index view from homes 
		if ($this->RequestHandler->isMobile()) {
            	// if device is mobile, change layout to mobile
           		 $this->viewPath = 'homes/mobile';
           		 	}else{
			$this->viewPath = 'homes';
		}
		
	} // index dunctions end here 
	

	/**
	* @Date: Oct 15, 2010
	* @Method : index
	* @Purpose: This function is to show home page departments .
	* @Param: none
	* @Return: none 
	**/
	function pick_of_day($product_id = null,$dept_id= null){
		$this->set('product_id',$product_id);
		$this->set('dept_id',$dept_id);
	}
	
	/********************************************** */
	/** 
	@function:	 frontendBreadcrumb	
	@description	create breadcrumb for department page for front end side	
	@Created by: 	Pradeep Kumar	
	@params		department id 
	@Modify: 
	@Created Date:	19 Feb 2013
	*/
	function frontendBreadcrumb($department_id = null){
		
		if(!is_null($department_id) ){ // if department id is not null then show further breadcrumb
		// get department name and id 
		$departArr  = $this->Department->find('first' , array(
			'conditions' => array('Department.id' => $department_id),
			'fields' => array('Department.name', 'Department.id')
		));
		$department_name = $departArr['Department']['name'];
		$department_id = $departArr['Department']['id'];
		//$link_seperator = "&raquo;" ;
		$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
		$link_seperator = " > " ;
		$strLink = '<li><a href="/" class="star_c1">Choiceful</a></li>';
		$strLink .= '<li class="last"><span>'. $department_name.'</span></li>' ;
	
		}
		return $strLink;
	}
}
?>