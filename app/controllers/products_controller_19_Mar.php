<?php 
/**
* ProductsController class
* PHP versions 5.1.4
* @date Oct 14, 2010
* @Purpose:This controller handles all the functionalities regarding product
* @filesource
* @author    kulvinder
**/

App::import('Sanitize');
class ProductsController extends AppController {
	var $name = 'Products';
	var $helpers =  array('Html','Ajax','Fck', 'Form', 'Javascript','Format','Common','Session','Validation','Calendar');
	var $components =  array('RequestHandler','Email','Common','File','Thumb');
	var $paginate =  array();
	var $uses =  array('Product');
	var $permission_id = 5;  // for product module
	var $actsAs = array('Containable');
	/**
	* @Date: Nov 01, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate products access  permissions and  admin user sessions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		//check session other than admin_login page
		$includeBeforeFilter = array('admin_index','admin_add','admin_add_step2', 'admin_view','admin_delete','admin_status','admin_multiplAction', 'admin_newproducts','admin_searchtags','admin_add_tags','admin_delete_tags','admin_tagstatus','admin_searchtag_multiplAction','admin_bulk_upload','admin_assign_departments');
		if (in_array($this->params['action'],$includeBeforeFilter)){
			//check that admin is login
			$this->checkSessionAdmin();
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id); 
		}
	}
	
	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	Nov 01,2010
	@credated by	:	Raman Preet
	**/
	function admin_multiplAction(){
		App::import('Model','ProductSearchtag');
		$this->ProductSearchtag = new ProductSearchtag;
		if($this->data['Product']['status']=='active'){
			foreach($this->data['select'] as $id){
				$tags = $this->ProductSearchtag->find('all',array('conditions'=>array('ProductSearchtag.product_id'=>$id)));
				if(!empty($id)){
					$this->Product->id=$id;
					$this->Product->saveField('status','1');
					if(!empty($tags)){
						foreach($tags as $tag){
							$this->ProductSearchtag->id = $tag['ProductSearchtag']['id'];
							$this->ProductSearchtag->saveField('status','1');
						}
					}
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['Product']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Product->id=$id;
					$this->Product->saveField('status','0');
					if(!empty($tags)){
						foreach($tags as $tag){
							$this->ProductSearchtag->id = $tag['ProductSearchtag']['id'];
							$this->ProductSearchtag->saveField('status','0');
						}
					}
					$this->Session->setFlash('Information updated successfully.');	
				}
			}
		} elseif($this->data['Product']['status']=='del'){
			$this->Product->expects(array('ProductCategory', 'ProductDetail', 'ProductSeller','ProductQuestion', 'ProductRating','Productimage'));
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$tags = $this->ProductSearchtag->find('all',array('conditions'=>array('ProductSearchtag.product_id'=>$id)));
					if(!empty($tags)){
						foreach($tags as $tag){
							if(!empty($tag['ProductSearchtag']['id'])){
								$this->ProductSearchtag->delete($tag['ProductSearchtag']['id']);	
							}
						}
					}
					$this->Product->delete($id);
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
		if(!empty($this->data['Search']['keyword']) && !empty($this->data['Search']['searchin']) && !empty($this->data['Search']['show']))
			$this->redirect('/admin/products/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		else
			$this->redirect('/admin/products/index/');
	}
 
	/** 
	@function	:	admin_index
	@description	:	to display list of products
	@params		:	NULL
	@created	:	Nov  01,2010
	@credated by	:	
	**/
	function admin_index() {
		$this->layout='layout_admin';
		$criteria = 1;
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
		/** **************************************** **/
		$this->set('title_for_layout','Products');
		$value = ''; $show = ''; $matchshow = ''; $fieldname = '';	
		/** SEARCHING **/
		$reqData = $this->data;
		$options['quick_code'] 	 = "Quick Code";
		$options['product_name'] = "Product Name";
		$options['manufacturer'] = "Manufacturer";
		$options['model_number '] = "Model Number";
		$options['barcode '] = "Bar Code";
		$options['id'] = "Product Id";
		//Start for status On 24 OCT 2012
		$options['1'] = "Active";
		$options['0'] = "In Active";
		//End for status On 24 OCT 2012
		$showArr = $this->getDepartments();
		$this->set('departmentsArr',$showArr);
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
			if(empty($this->data['Search']['searchin']) && $this->data['Search']['searchin'] != 1 && $this->data['Search']['searchin'] != '0'){
				$fieldname = 'All';
			} else {
				$fieldname = $this->data['Search']['searchin'];
			}
			$value = trim($this->data['Search']['keyword']);
			$show = $this->data['Search']['show'];
			// sanitze the search data
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
			if($value1 !="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (Product.quick_code = '".$value1."' OR Product.product_name LIKE '%".$value1."%' OR Product.manufacturer LIKE '%".$value1."%' OR Product.model_number LIKE '%".$value1."%' OR Product.barcode LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value != "") {
							$criteria .= " and Product.".$fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
			if(isset($show) && $show !=""){
				if($show == 'All'){
				} else {
					$criteria .= " and Product.department_id = '".$show."'";
					$this->set('show',$show);
				}
			}
		}
		//Only for status
		if($fieldname == 1 || $fieldname == '0'){
			$criteria .= " and Product.status = '$fieldname'";
		}
		//End only for status
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		$this->set('heading','Products');
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'Product.id' => 'DESC'
				),
			'fields'=> array('Product.id', 'Product.quick_code','Product.product_name','Product.product_rrp','Product.created','Product.status','Product.department_id','Product.manufacturer')
		);
		$this->set('products',$this->paginate('Product',$criteria));
		$this->set('count_products',$this->Product->find('count',array('conditions'=>$criteria)));
		/************** To showing the condition name in products listing as legend **********/
		App::import('Model','ProductCondition');
		$this->ProductCondition = new ProductCondition;
		$product_condition = $this->ProductCondition->getProductConditions();
		$this->set('conditions',$product_condition);
	}
	
	/**
	@function	:	admin_newproducts
	@description	:	to display list of products
	@params		:	NULL
	@created	:	15 Dec ,2010
	@credated by	:	kulvinder singh
	**/
	function admin_newproducts() {
	$this->layout='layout_admin';
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
		/** **************************************** **/
		$this->set('title_for_layout','New Products Entered by Site Users');
		$value = ''; $show = ''; $matchshow = ''; $fieldname = '';	
		/** SEARCHING **/
		$criteria = 1;
		$reqData = $this->data;
		$options['Product.quick_code'] 	 = "Quick Code";
		$options['Product.product_name'] = "Product Name";
		$options['Product.manufacturer'] = "Manufacturer";
		$options['User.email'] = "User Email";
		//$showArr = $this->getStatus();
		$showArr = $this->getDepartments();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
			if(empty($this->data['Search']['searchin'])){
				$fieldname = 'All';
			} else {
				$fieldname = $this->data['Search']['searchin'];
			}
			$value = $this->data['Search']['keyword'];
			$show = $this->data['Search']['show'];
			// sanitze the search data
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
			if($value1 !="") {
			if(trim($fieldname)=='All'){
					$criteria .= " and (Product.quick_code = '".$value1."' OR Product.product_name LIKE '%".$value1."%' OR Product.manufacturer LIKE '%".$value1."%' OR User.email LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value != "") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
			if(isset($show) && $show !=""){
				if($show == 'All'){
				} else {
					$criteria .= " and Product.department_id = '".$show."'";
					$this->set('show',$show);
				}
			}
		}
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		$this->set('heading','Products');
		// sanitze the search data
		App::import('Model','ProductSiteuser');
		$this->ProductSiteuser = new ProductSiteuser;
		$this->ProductSiteuser->bindModel(
			array('belongsTo'=>array(
			       'Product'=>array('foreignKey'=>'product_id'),
			       'User'=>array('foreignKey'=>'seller_id')
				)
			),
			false
		);
		$criteria .= " AND Product.status = '0' ";
		$criteria .= " AND ProductSiteuser.approved = '0' ";
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
			$limit = $this->data['Record']['limit'];
			$this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'Product.id' => 'DESC'
			),
			'fields'=> array('Product.id', 'Product.quick_code','Product.product_name','Product.product_rrp',
			'Product.created','Product.status',
			'ProductSiteuser.id','ProductSiteuser.brand_name',
			'User.email')
		);
		//echo $criteria;
		$this->set('products',$this->paginate('ProductSiteuser',$criteria));
	
	}

	/** ***********************************************************************
	/* @function	:	getBrands
	@description	:	get a list of all brands
	@params		:	NULL
	@created	:	Nov 20,2010
	@credated by	:	kulvinder
	**/
	function getBrands($brandId= null) {
		// get Department array
		App::import('Model', 'Brand');
		$this->Brand = new Brand();
		if( !empty($brandId) ){
		       $brands_array = $this->Brand->find('first', array('order' =>array('Brand.name ASC'), 'condition'=> array('Brand.id='.$brandId )  ) );
		} else{
		       $brands_array = $this->Brand->find('list');
		}
		return $brands_array;
	}

	/** @function	:	getBrands
	@function	:	getDepartments
	@description	:	get a list of all departments
	@params		:	NULL
	@created	:	Nov 03,2010
	@credated by	:	kulvinder
	**/
	function getDepartments($depId = null) {
		// get Department array
		App::import('Model', 'Department');
		$this->Department = new Department();
		if( !empty($depId) ){
			$departments_array = $this->Department->find('first', array('condition'=> array('Department.id='.$depId )  ) );
			return $departments_array;
		} else{
			$departments_array = $this->Department->find('list');
			return $departments_array;
		}
	}
	
	/** ***********************************************************************
	@function	:	admin_add
	@description	:	to add/edit products 
	@params		:	NULL
	@created	:	Nov 03,2010
	@credated by	:	kulvinder
	**/
	
	function admin_add($id = null, $new_product_id = null) {
		//Configure::write('debug',2);
		
		$this->set('id',$id); // product id in case of edit
		$this->layout = 'layout_admin';
		if(!empty($id)){
			$this->set('listTitle','Edit Details');
		} else{
			$this->set('listTitle','Add New Product');
		}
		//Start For After updating product redirect to the same page
		$params = $this->params['named'];
		$params_url = '';
		foreach($params as $key => $values){
			$params_url = $params_url.'/'.$key.':'.$values;
		}
		//End For After updating product redirect to the same page
		$back_page_url = (!empty($new_product_id))?('/admin/products/newproducts'):('/admin/products/index');
		$this->set('back_page_url', $back_page_url.'/'.$params_url);
		
		// get Department ends array
		$departments_array = $this->getDepartments();
		$this->set('departments_array', $departments_array);
		$product_brand_array = $this->getBrands();
		$this->set('product_brand_array', $product_brand_array);
		// get product category  array
		App::import('Model','ProductCategory');
		$this->ProductCategory = new ProductCategory;
		App::import('Model','ProductSiteuser');
		$this->ProductSiteuser = new ProductSiteuser;
		// get ProductSiteuser
		if( !is_null($new_product_id) ){
			$this->set('new_product_id',$new_product_id); // new product id in case of edit
			$this->ProductSiteuser->bindModel(array('belongsTo'=>array(
			'Category'=>array('foreignKey'=>'category_id')
			)));
			$newProductData = $this->ProductSiteuser->find('first', array('conditions'=>array('ProductSiteuser.id'=>$new_product_id),'fields'=>array('ProductSiteuser.id','ProductSiteuser.seller_id','ProductSiteuser.brand_name','ProductSiteuser.category_id','Category.cat_name' ) ));
			$this->set('newProductData', $newProductData);
		} else{
			$this->set('new_product_id', '' ); // new product id in case of edit
			$this->set('newProductData', '');
		}
		if(!empty($this->data)) { //  save the records
			
			$this->Product->set($this->data);
			$video_content = $this->data['Product']['product_video'];
			$productValidate = $this->Product->validates();
			if($productValidate ){
				if(!isset($this->data['ProductCategory']) ){
					$this->Session->setFlash('Please select at least one category.','default', array('class'=>'flashError'));
				}elseif(count($this->data['ProductCategory']) <= 0) {
					$this->Session->setFlash('Please select at least one category.', 'default', array('class'=>'flashError'));
				}else{
					/*** Upload Image if provided */
					if(!empty($this->data['Product']['photo']['name'])){
						$imageType = $this->data['Product']['photo']['type'];
						$imageTypeArr = explode('/',$imageType);
						$validImage = $this->File->validateImage($imageTypeArr[1]);
						if($validImage == true){
							$this->File->destPath =  WWW_ROOT.PATH_PRODUCT;
							$this->File->setFilename(time()."_".$this->data['Product']['photo']['name']);
							$fileName  = $this->File->uploadFile($this->data['Product']['photo']['name'],$this->data['Product']['photo']['tmp_name']);
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
							## delete the main directory substitue file
							$this->File->deleteFile( $fileName);
						}
						if( !$fileName  ){ // Error in uploading
							$this->Session->setFlash('Error in uploading the image.','default',array('class'=>'flashError')); 
							$this->redirect($back_page_url.'/'.$params_url);
						} else{ // uploaded successful and delete the old file
							$this->Product->id = $id;
							$oldfile = $this->Product->findById($id);
							# delete product all old images
							$this->deleteProductAllOldImages($oldfile['Product']['product_image']);
							// delete old file
							$this->File->deleteFile( $oldfile['Product']['product_image']);
							$this->data['Product']['product_image']= $fileName;
						}
					}
					// pr($this->data); die;
					$this->data = Sanitize::clean($this->data);
					$this->data['Product']['product_video'] = str_replace('http://youtu.be','http://www.youtube.com/v',$video_content);
					$this->data['Product']['product_video'] = str_replace('http://www.youtu.be','http://www.youtube.com/v',$this->data['Product']['product_video']);
					$this->Product->set($this->data);
					if ($this->Product->save($this->data)) {
						if(!empty($this->data['Product']['new_product_id'])){
							if($this->data['Product']['status'] == 1){
								
								$pass_arr = $newProductData['ProductSiteuser']['seller_id'].'~'.$this->data['Product']['id'].'~'.$this->data['Product']['product_name'];
								
								//pr($pass_arr);
								$pass_str = urlencode($pass_arr);
								//pr($pass_str);pr(urldecode($pass_arr)); die;
								$this->sendEmailListing($pass_str);
									
							}
						}
						App::import('Model','ProductDetail');
						$this->ProductDetail = new ProductDetail;
						App::import('Model','ProductSearchtag');
						$this->ProductSearchtag = new ProductSearchtag;
						$existing_product_tags = $this->ProductSearchtag->find('all',array('conditions'=>array('ProductSearchtag.product_id'=>$this->data['Product']['id'])));
						if($this->data['Product']['status'] == 1){
							if(!empty($existing_product_tags)){
								foreach($existing_product_tags as $product_tag){
									$this->ProductSearchtag->id = $product_tag['ProductSearchtag']['id'];
									$this->ProductSearchtag->saveField('status',1);
								}
							} else {
								$product_tags = $this->ProductDetail->find('first',array('conditions'=>array('ProductDetail.product_id'=>$this->data['Product']['id'])));
								// pr($product_tags); die;
								if(!empty($product_tags)){
									App::import('Model','ProductSearchtag');
									$this->ProductSearchtag = new ProductSearchtag;
									$this->data['ProductSearchtag']['product_id'] = $this->data['Product']['id'];
									$this->data['ProductSearchtag']['tags'] = $product_tags['ProductDetail']['product_searchtag'];
									$this->data['ProductSearchtag']['status'] = 1;
									$this->data = Sanitize::clean($this->data);
									$this->ProductSearchtag->set($this->data);
									$this->ProductSearchtag->save($this->data);
								}
							}
						} else{
							if(!empty($existing_product_tags)){
								foreach($existing_product_tags as $product_tag){
									$this->ProductSearchtag->id = $product_tag['ProductSearchtag']['id'];
									$this->ProductSearchtag->saveField('status',0);
								}
							}
						}
						if(empty($id)){
							// get last insert id from  product table
							$saved_product_id = $this->Product->getLastInsertId();
							$this->Session->setFlash('Records has been added successfully.');
						} else{
							$saved_product_id = $id;
							$this->Session->setFlash('Records has been updated successfully.');
						}
						############ Other images  section #######################
						if( isset($this->data['Product']['photom']) ){
							$other_images = $this->data['Product']['photom'];
							// pr($other_images);
							// import the Productimage DB
							App::import('Model', 'Productimage');
							$this->Productimage = new Productimage();
							$this->data['Productimage']['product_id'] = $saved_product_id;
							$this->File->destPath =  WWW_ROOT.PATH_PRODUCT;
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
									$this->data['Productimage']['id'] = 0;
									$this->data['Productimage']['image'] = $file;
									$this->Productimage->set($this->data);
	// 								pr($this->data); die;
									$this->Productimage->save($this->data);
									## delete the main directory substitue file
									$this->File->deleteFile($subStituefileName);
								}
							}
						}
						# ########## Other images  section ends here #######################
						//  generate and update the quick code for the product
						$department_id = $this->data['Product']['department_id'];
						$quickCode = $this->Product->generateQuickCode($saved_product_id,$department_id );
						$quickCode = $this->updateQuickCode($saved_product_id,$quickCode );
						// ends update quick code section
						
						########## update  new product status
						if(!empty($new_product_id) && $this->data['Product']['status'] == 1 ) {
							$this->ProductSiteuser->id = $new_product_id;
							$this->ProductSiteuser->saveField('approved', 1);
						}
						
						
					if(!empty($this->data['Product']['status']) && $this->data['Product']['status'] == 1 ) {
						$newProductsellerId = $this->ProductSiteuser->find('first', array('conditions'=>array('ProductSiteuser.product_id '=>$id ),'fields'=>array('ProductSiteuser.seller_id')));
						 $seller_id=$newProductsellerId['ProductSiteuser']['seller_id'];
						
						App::import('Model','User');
						$this->User = new User;
						$this->User->expects(array('SellerSummary'));	
						$newProductsellerDetail = $this->User->find('first', array('conditions'=>array('User.id'=>$seller_id),'fields'=>array('User.email', 'SellerSummary.business_display_name')));
						$user_email=$newProductsellerDetail['User']['email'];
						$SellersDisplayName=$newProductsellerDetail['SellerSummary']['business_display_name'];
							
						/** Send email after product Approvel **/
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
						id: 20
						description: ad product approvel mail format for admin
						*/
						$template = $this->Common->getEmailTemplate(20);
						$data = $template['EmailTemplate']['description'];
						$this->Email->from = $template['EmailTemplate']['from_email'];
						$this->Email->subject = $template['EmailTemplate']['subject'];
			
						$product_name = trim($this->data['Product']['product_name']);
						
						/*== Added on Oct. 30 ==*/
						$item_in_url = str_replace(' ','-',$product_name);
						$pId = $this->data['Product']['id'];
						$product_link = '<a href="'.SITE_URL.'categories/productdetail/'.$pId.'">'.$product_name.'</a>';
						/*========= ============*/
						
						$this->data = Sanitize::clean($this->data);
						//$data = str_replace('[ItemName]', $product_name, $data);
						$data = str_replace('[ItemName]', $product_link, $data);
						$data = str_replace('[SellersDisplayName]', $SellersDisplayName, $data);
						$this->set('data',$data);
						$this->Email->to = $user_email;
						/******import emailTemplate Model and get template****/
						$this->Email->template='commanEmailTemplate';
						$this->Email->send();
						
					}
						
						############## add/update category ids ##################
						if(!empty($this->data['ProductCategory'])) {
							$allcategories = $this->data['ProductCategory'];
							$this->data['ProductCategory']['product_id'] = $saved_product_id;
							$this->ProductCategory->deleteAll("ProductCategory.product_id ='".$saved_product_id."'");
							foreach($allcategories as $index=>$category_id){
								$this->data['ProductCategory']['category_id'] = $category_id;
								$this->data['ProductCategory']['id'] = 0;
								$this->ProductCategory->set($this->data);
								$this->ProductCategory->save($this->data);
							}
						}
						############## add/update category ids ##################
					} else{ // add category
						$this->Session->setFlash('Record has not been added successfully.');
					}
					$buttanName =  substr(trim($this->params['form']['submit1']), -8);
					if( strtolower($buttanName) == 'continue' || strtolower($this->params['form']['submit1']) == 'continue'){ // continue after save the data
						$sessionDate['department_id']  = $this->data['Product']['department_id'];
						$sessionDate['back_page_url']  = $this->data['Product']['back_page_url'];
						$sessionDate['new_product_id'] = $this->data['Product']['new_product_id'];
						$sessionDate['id'] = $saved_product_id;
						$this->Session->write('data_step1', $sessionDate);
						$this->Session->setFlash('');
						$this->redirect('/admin/products/add_step2/'.$saved_product_id.'/'.$params_url);
					} else{ // save and go back
						$this->redirect($this->data['Product']['back_page_url']);
					}
				}
			} else{
				$this->set('errors',$this->Product->validationErrors);
			}
		} else{ // edit case opened 
			if(!empty($id)) {
				$this->Product->id = $id;
				$conditions = array('Product.id'=>$id);
				$this->Product->expects(array('ProductCategory', 'Productimage'));
				$this->data = $this->Product->find('first',array('conditions'=>$conditions));
				if(!empty($new_product_id)){
					App::import('Model','ProductSiteuser');
					$this->ProductSiteuser = new ProductSiteuser;
					$siteuser = $this->ProductSiteuser->find('first',array('conditions'=>array('ProductSiteuser.id'=>$new_product_id)));
				}
				if(!empty($siteuser['ProductSiteuser']['seller_id'])){
					$this->data['ProductSearchtag']['user_id'] = $siteuser['ProductSiteuser']['seller_id'];
				} else {
					$this->data['ProductSearchtag']['user_id'] = -1;
				}
				if(!empty($this->data['Product'])){
					foreach($this->data['Product'] as $field_index => $user_info){
						$this->data['Product'][$field_index] = html_entity_decode($user_info, ENT_NOQUOTES, 'UTF-8');

						//$this->data['Product'][$field_index] = html_entity_decode($user_info);
						$this->data['Product'][$field_index] = str_replace('&#039;',"'",$this->data['Product'][$field_index]);
					}
				}
			}
		}
	}
	/** ***********************************************************************
	@function	:	deleteProductAllOldImages
	@description	:	to delete the old  product images
	@params		:	NULL
	@created	:	17 Feb,2011
	@credated by	:	kulvinder
	**/
	function deleteProductAllOldImages($oldFileName){
		$destBaseFilePath =  WWW_ROOT.PATH_PRODUCT;
		@unlink($destBaseFilePath.'large/img_400_'.$oldFileName);
		@unlink($destBaseFilePath.'large/img_300_'.$oldFileName);
		@unlink($destBaseFilePath.'medium/img_200_'.$oldFileName);
		@unlink($destBaseFilePath.'medium/img_150_'.$oldFileName);
		@unlink($destBaseFilePath.'medium/img_135_'.$oldFileName);
		@unlink($destBaseFilePath.'medium/img_125_'.$oldFileName);
		@unlink($destBaseFilePath.'small/img_100_'.$oldFileName);
		@unlink($destBaseFilePath.'small/img_75_'.$oldFileName);
		@unlink($destBaseFilePath.'small/img_50_'.$oldFileName);
	}
	
	/** ***********************************************************************
	@function	:	admin_add_step2
	@description	:	to add/edit products 
	@params		:	NULL
	@created	:	06 jan,2011
	@credated by	:	kulvinder
	**/
	function admin_add_step2($id = null) {
		//Configure::write('debug',3);
		$this->set('id',$id); // product id in case of edit
		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
		if(!empty($id)){
			$this->set('listTitle','Edit Details ');
		} else{
			$this->set('listTitle','Add New Product');
		}
		$previous_form_data = $this->Session->read('data_step1');
		$new_product_id =$previous_form_data['new_product_id'];
		$department_id =$previous_form_data['department_id'];
		$this->set('department_id',$department_id);
		$this->set('new_product_id',$new_product_id);
		$back_page_url = $previous_form_data['back_page_url'];
		// get product category  array
		App::import('Model','ProductDetail');
		$this->ProductDetail = new ProductDetail;
		App::import('Model','ProductSiteuser');
		$this->ProductSiteuser = new ProductSiteuser;
		if(!empty($this->data)){
			$this->ProductDetail->set($this->data);
			$productDetailsValidate = $this->ProductDetail->validates();
			if( $productDetailsValidate ){
				$product_searchtag = htmlentities($this->data['ProductDetail']['product_searchtag']);
				//$technical_details = htmlentities($this->data['ProductDetail']['technical_details']);
				$product_features = $this->data['ProductDetail']['product_features'];
				$description = htmlentities($this->data['ProductDetail']['description']);
				$meta_title = htmlentities($this->data['ProductDetail']['meta_title']);
				$meta_keywords = htmlentities($this->data['ProductDetail']['meta_keywords']);
				$meta_description = htmlentities($this->data['ProductDetail']['meta_description']);
				if(!empty($this->data['ProductDetail']['track_list'])){
					$track_list = $this->data['ProductDetail']['track_list'];
				} else
					$track_list = '';
				if(!empty($this->data['ProductDetail']['publisher_review'])){
					$publisher_review = htmlentities($this->data['ProductDetail']['publisher_review']);
				} else
					$publisher_review = '';
				$this->data = Sanitize::clean($this->data);
				$this->data['ProductDetail']['product_searchtag'] = $product_searchtag;
				//$this->data['ProductDetail']['technical_details'] = $technical_details;
				$this->data['ProductDetail']['product_features'] = $product_features;
				$this->data['ProductDetail']['track_list'] = $track_list;
				$this->data['ProductDetail']['description'] = $description;
				$this->data['ProductDetail']['meta_title'] = $meta_title;
				$this->data['ProductDetail']['meta_keywords'] = $meta_keywords;
				$this->data['ProductDetail']['meta_description'] = $meta_description;
				$this->data['ProductDetail']['publisher_review'] = $publisher_review;
				$this->ProductDetail->set($this->data);
				if($this->data['ProductDetail']['id'] != ''  &&  !empty($this->data['ProductDetail']['id'])  ){ // edit 
					$this->ProductDetail->save($this->data);
					$this->Session->setFlash('Records has been updated successfully.');
				} else{ // add 
					$this->ProductDetail->save($this->data);
					$this->Session->setFlash('Records has been added successfully.');
				}
				App::import('Model','ProductSearchtag');
				$this->ProductSearchtag = new ProductSearchtag;
				$existing_product_tags = $this->ProductSearchtag->find('all',array('conditions'=>array('ProductSearchtag.product_id'=>$this->data['ProductDetail']['product_id'])));
				$pro_information = $this->Product->find('first',array('conditions'=>array('Product.id'=>$this->data['ProductDetail']['product_id']),'fields'=>array('Product.status')));
				if($pro_information['Product']['status'] == 1){
				if(!empty($existing_product_tags)){
						foreach($existing_product_tags as $product_tag){
							$this->ProductSearchtag->id = $product_tag['ProductSearchtag']['id'];
							$this->data['ProductSearchtag']['tags'] = $product_searchtag;
							$this->data['ProductSearchtag']['status'] ='1';
							$this->data = Sanitize::clean($this->data);
							$this->ProductSearchtag->set($this->data);
							$this->ProductSearchtag->save($this->data);
						}
					} else {
						$product_tags = $this->data['ProductDetail']['product_searchtag'];
						if(!empty($product_tags)){
							$this->data['ProductSearchtag']['product_id'] = $this->data['ProductDetail']['product_id'];
							$this->data['ProductSearchtag']['user_id'] = -1;
							$this->data['ProductSearchtag']['tags'] = $product_tags;
							$this->data['ProductSearchtag']['status'] = 1;
							$this->data = Sanitize::clean($this->data);
							$this->ProductSearchtag->set($this->data);
							$this->ProductSearchtag->save($this->data);
						}
					}
				} else{
					if(!empty($existing_product_tags)){
						foreach($existing_product_tags as $product_tag){
							$this->ProductSearchtag->id = $product_tag['ProductSearchtag']['id'];
							$this->ProductSearchtag->saveField('status',0);
						}
					}
				}
				$this->redirect($back_page_url);
			} else{
				$this->set('errors',$this->ProductDetail->validationErrors);
			}
		} else{ // edit case opened 
			if(!empty($id)) {
				$this->Product->id = $id;
				$conditions = array('ProductDetail.product_id'=>$id);
				$this->data = $this->ProductDetail->find('first',array('conditions'=>$conditions));
				if(!empty($this->data['ProductDetail'])){
					foreach($this->data['ProductDetail'] as $field_index => $user_info){
						$this->data['ProductDetail'][$field_index] = html_entity_decode($user_info);
						$this->data['ProductDetail'][$field_index] = str_replace('&#039;',"'",$this->data['ProductDetail'][$field_index]);
					}
				}
			}
		}
	}
	
	/** 
	@function	: delete_product_image
	@description	: to delete_product_image
	*/
	function delete_product_image($productimage_id = null){
		App::import('Model', 'Productimage');
		$this->Productimage = new Productimage();
		$photo=$this->Productimage->find('first',array('conditions'=>array('Productimage.id'=>$productimage_id),'fields'=>array('Productimage.product_id','Productimage.image')));
		$product_id = $photo['Productimage']['product_id'];
		if(!empty($photo['Productimage']['image'])){
			
			@chmod(IMAGES.'products/'.$photo['Productimage']['image'],"0777");
			@chmod(IMAGES.'products/medium/img_200_'.$photo['Productimage']['image'],"0777");
			@chmod(IMAGES.'products/medium/img_150_'.$photo['Productimage']['image'],"0777");
			@chmod(IMAGES.'products/medium/img_135_'.$photo['Productimage']['image'],"0777");
			@chmod(IMAGES.'products/medium/img_125_'.$photo['Productimage']['image'],"0777");
			@chmod(IMAGES.'products/large/img_400_'.$photo['Productimage']['image'],"0777");
			@chmod(IMAGES.'products/large/img_300_'.$photo['Productimage']['image'],"0777");
			@chmod(IMAGES.'products/small/img_100_'.$photo['Productimage']['image'],"0777");
			@chmod(IMAGES.'products/small/img_75_'.$photo['Productimage']['image'],"0777");
			@chmod(IMAGES.'products/small/img_50_'.$photo['Productimage']['image'],"0777");
			@unlink(IMAGES.'products/'.$photo['Productimage']['image']);
			@unlink(IMAGES.'products/medium/img_200_'.$photo['Productimage']['image']);
			@unlink(IMAGES.'products/medium/img_150_'.$photo['Productimage']['image']);
			@unlink(IMAGES.'products/medium/img_135_'.$photo['Productimage']['image']);
			@unlink(IMAGES.'products/medium/img_125_'.$photo['Productimage']['image']);
			@unlink(IMAGES.'products/large/img_400_'.$photo['Productimage']['image']);
			@unlink(IMAGES.'products/large/img_300_'.$photo['Productimage']['image']);
			@unlink(IMAGES.'products/small/img_100_'.$photo['Productimage']['image']);
			@unlink(IMAGES.'products/small/img_75_'.$photo['Productimage']['image']);
			@unlink(IMAGES.'products/small/img_50_'.$photo['Productimage']['image']); 
		}
		$this->Productimage->delete($productimage_id);
		$this->redirect('/admin/products/add/'.$product_id);
	}

	/*@function	: delete_image 
	@description	: to delete_product_image from product table
	*/
	function delete_image($prodId = null){
		$conditions = array('Product.id ='.$prodId);
		$photo = $this->Product->find('first',array('conditions'=>$conditions,'fields' => array('Product.Product_image')));
		$this->Product->id = $prodId;
		if($this->Product->saveField('product_image','')){
			@chmod(IMAGES.'products/'.$photo['Product']['Product_image'],"0777");
			@chmod(IMAGES.'products/medium/img_200_'.$photo['Product']['Product_image'],"0777");
			@chmod(IMAGES.'products/medium/img_150_'.$photo['Product']['Product_image'],"0777");
			@chmod(IMAGES.'products/medium/img_135_'.$photo['Product']['Product_image'],"0777");
			@chmod(IMAGES.'products/medium/img_125_'.$photo['Product']['Product_image'],"0777");
			@chmod(IMAGES.'products/large/img_400_'.$photo['Product']['Product_image'],"0777");
			@chmod(IMAGES.'products/large/img_300_'.$photo['Product']['Product_image'],"0777");
			@chmod(IMAGES.'products/small/img_100_'.$photo['Product']['Product_image'],"0777");
			@chmod(IMAGES.'products/small/img_75_'.$photo['Product']['Product_image'],"0777");
			@chmod(IMAGES.'products/small/img_50_'.$photo['Product']['Product_image'],"0777");
			@unlink(IMAGES.'products/'.$photo['Product']['Product_image']);
			@unlink(IMAGES.'products/medium/img_200_'.$photo['Product']['Product_image']);
			@unlink(IMAGES.'products/medium/img_150_'.$photo['Product']['Product_image']);
			@unlink(IMAGES.'products/medium/img_135_'.$photo['Product']['Product_image']);
			@unlink(IMAGES.'products/medium/img_125_'.$photo['Product']['Product_image']);
			@unlink(IMAGES.'products/large/img_400_'.$photo['Product']['Product_image']);
			@unlink(IMAGES.'products/large/img_300_'.$photo['Product']['Product_image']);
			@unlink(IMAGES.'products/small/img_100_'.$photo['Product']['Product_image']);
			@unlink(IMAGES.'products/small/img_75_'.$photo['Product']['Product_image']);
			@unlink(IMAGES.'products/small/img_50_'.$photo['Product']['Product_image']); 
		}
		$this->Session->setFlash("Image has been deleted successfully.");
		$this->redirect('/admin/products/add/'.$prodId);
	}
	/** 
	@function	:	admin_status
	@description	:	to update status of selected admin users
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	
	**/
	function admin_status($id = null,$status= null) {
		if(!empty($id)) {
			$this->data['Product']['id'] = $id;
			if($status == 0){
				$this->data['Product']['status'] = 1;
				$status = 1;
			} else{
				$this->data['Product']['status'] = 0;
				$status = 0;
			}
			$this->data = Sanitize::clean($this->data);
			$this->Product->set($this->data);
			if($this->Product->save($this->data)){
				App::import('Model','ProductSearchtag');
				$this->ProductSearchtag = new ProductSearchtag;
				$tags = $this->ProductSearchtag->find('all',array('conditions'=>array('ProductSearchtag.product_id'=>$id)));
				if(!empty($tags)){
					foreach($tags as $tag){
						$this->ProductSearchtag->id = $tag['ProductSearchtag']['id'];
						$this->ProductSearchtag->saveField('status',$status);
					}
				}
			}
		}
		$this->redirect('index');
	}


	/** 
	@function	:	admin_delete
	@description	:	to delete 
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	kulvinder Singh
	**/
	function admin_delete($id = null) {
		$this->Product->expects(array('ProductCategory', 'ProductDetail', 'ProductSeller','ProductQuestion', 'ProductRating','Productimage','ProductSiteuser','ProductSearchtag'));
		$this->Product->deleteAll("Product.id ='".$id."'");
		$this->Session->setFlash("Product has been deleted successfully.");
		$this->redirect(array('controller'=>'Products','action'=>'index'));
	}

	/** 
	@function	:	admin_delete_newproduct
	@description	:	to delete selected admin users
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	kulvinder Singh
	**/
	function admin_delete_newproduct($id = null) {
		App::import('Model','ProductSiteuser');
		$this->ProductSiteuser = new ProductSiteuser;
		$this->ProductSiteuser->deleteAll("ProductSiteuser.product_id ='".$id."'");
		$this->Product->expects(array('ProductCategory', 'ProductDetail', 'ProductSeller','ProductQuestion', 'ProductRating','Productimage','ProductSiteuser','ProductSearchtag'));
		$this->Product->deleteAll("Product.id ='".$id."'");
		$this->Session->setFlash("Product has been deleted successfully.");
		$this->redirect(array('controller'=>'Products','action'=>'newproducts'));
	}

	/** 
	@function	:	admin_deleteMultiple
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	Dec 15 2010
	@credated by	:	kulvinder 
	**/
	function admin_deleteMultiple(){
		App::import('Model','ProductSiteuser');
		$this->ProductSiteuser = new ProductSiteuser;
		if($this->data['Product']['status']=='del'){
			$this->Product->expects(array('ProductCategory', 'ProductDetail', 'ProductSeller','ProductQuestion', 'ProductRating','Productimage','ProductSearchtag'));
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Product->delete($id);
					$this->ProductSiteuser->deleteAll("ProductSiteuser.product_id ='".$id."'");
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
		if(!empty($this->data['Search']['keyword']) && !empty($this->data['Search']['searchin']) && !empty($this->data['Search']['show']))
			$this->redirect('/admin/products/newproducts/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		else
			$this->redirect('/admin/products/newproducts/');
	}

	
	/**
	@function:admin_view 
	@description		view Product,
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		Oct 13,2010
	*/
	function admin_view($id){
		$this->_validateId($id);
		$this->layout = 'layout_admin';
		$this->set('list_title','View Details');
		$this->Product->id = $id;
		$this->data = $this->Product->read();
	}

	/** 
	@function:		validateId 
	@description:		Validate of ID,
	@params:		id
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		Oct 13,2010
	*/
	function _validateId($id){
		if(empty($id) || !is_numeric($id)){
			$this->Session->setFlash('Id is missing.','default',array('class'=>'flashError'));
			$this->redirect('/admin/Products/index/');
		}
	}

	/** ***********************************************************************
	@function	:	get_product_template
	@description	:	to get department based product templates
	@params		:	NULL
	@created	:	Nov 09,2010
	@credated by	:	kulvinder Singh
	**/
	
	function admin_get_product_template($id = null, $product_id = null ) {
		$this->layout = 'ajax';
		$department_id = $id;
		$this->set('department_id',$department_id);
		if(!empty($product_id) ) {
			$conditions = array('Product.id ='.$product_id);
			$this->data = $this->Product->find('first',array('conditions'=>$conditions));
		} else {
			$this->data = $this->data;
		}
	}
	
	/** ***********************************************************************
	@function	:	get_department_category
	@description	:	to get department based category combo 
	@params		:	NULL
	@created	:	Nov 09,2010
	@credated by	:	kulvinder Singh
	**/
	
	function get_department_category($id = null,$categories = null) {
		$department_id = $id;
		$categories_array = '';
		if(!empty($categories)){
			$categories_array = explode(',',$categories);
		}
		$departments = $this->getDepartments();
		$this->set('departments',$departments );
		$this->set('categories_array',$categories_array);
		if(!empty($department_id) ){
			App::import('Model', 'Category');
			$this->Category = new Category();
			$conditions = array('Category.parent_id = 0' , 'Category.department_id ='.$department_id);
			$dep_category_array = $this->Category->find('list', array('conditions'=>  $conditions,
				'fields'=>array('Category.id', 'Category.cat_name'),
				'order' => 'Category.cat_name ASC'
			) );
			$this->set('dep_category_array', $dep_category_array);
		} else{
		}
	}
	

	/** 
	@function	:	add_question
	@description	:	to add questions for a product
	@params		:	NULL
	@created	:	Nov  01,2010
	@credated by	:	
	**/
	function add_question($product_id=null,$product_code=null,$product_name = null){
		$this->layout = 'front_popup';
		if(!empty($this->data)){
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			App::import('Model', 'ProductQuestion');
			$this->ProductQuestion = new ProductQuestion();
			$this->ProductQuestion->set($this->data);
			if($this->ProductQuestion->validates()){
				if($this->ProductQuestion->save($this->data)){
					$this->Session->setFlash('Your question added successfully.');
					echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
					parent.location.reload(true);
					</script>";
				} else{
					$this->Session->setFlash('Your question has not been added successfully.');
				}
			} else{
				$this->set('errors',$this->ProductQuestion->validationErrors);
			}
		} else{
			$this->data['ProductQuestion']['product_name'] = $product_name;
			$this->data['ProductQuestion']['product_code'] = $product_code;
			$this->data['ProductQuestion']['product_id'] = $product_id;
			
			if(!empty($this->data['ProductQuestion'])){
				foreach($this->data['ProductQuestion'] as $field_index => $user_info){
					$this->data['ProductQuestion'][$field_index] = html_entity_decode($user_info);
					$this->data['ProductQuestion'][$field_index] = str_replace('&#039;',"'",$this->data['ProductQuestion'][$field_index]);
				}
			}
		}
	}

	/** ***********************************************************************
	@function	:	updateQuickCode
	@description	:	to update the product quick code on the basis of product id 
	@params		:	NULL
	@created	:	15 Nov 2010
	@credated by	:	kulvinder Singh
	**/
	function updateQuickCode( $prodId = null,$quickcode = null) {
		$this->Product->id = $prodId;
		if($this->Product->saveField('quick_code',$quickcode)){
			return true;
		} else{
			return false;
		}
	}

	/** 
	@function	:	answer_question
	@description	:	to answer the product questions for a product
	@params		:	NULL
	@created	:	Nov  01,2010
	@credated by	:	
	**/
	function answer_question($question_id=null){
		$this->layout = 'front_popup';
		App::import('Model', 'ProductAnswer');
		$this->ProductAnswer = new ProductAnswer();
		App::import('Model', 'ProductQuestion');
		$this->ProductQuestion = new ProductQuestion();
		
		$user = $this->Session->read('User');
		if(!empty($user)){
			if(!empty($this->data)){
					
				$this->data = $this->cleardata($this->data);
				//$this->data = Sanitize::clean($this->data, array('encode' => false));
					
				$this->ProductAnswer->set($this->data);
				if($this->ProductAnswer->validates()){
					if($this->ProductAnswer->save($this->data)){
						$this->Session->setFlash('Your answer added successfully.');
						echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
						parent.location.reload(true);
						</script>";
					} else{
						$this->Session->setFlash('Your answer has not been added successfully.');
					}
				} else{
					$this->set('errors',$this->ProductAnswer->validationErrors);
				}
			} else{
				$this->ProductQuestion->expects(array('Product'));
				$product_ques = $this->ProductQuestion->find('first',array('conditions'=>array('ProductQuestion.id'=>$question_id),'fields'=>array('ProductQuestion.id','ProductQuestion.product_id','ProductQuestion.question','Product.product_name')));
				$this->data['ProductAnswer']['question'] = $product_ques['ProductQuestion']['question'];
				$this->data['ProductAnswer']['product_name'] = $product_ques['Product']['product_name'];
				$this->data['ProductAnswer']['product_question_id'] = $product_ques['ProductQuestion']['id'];
				$this->data['ProductAnswer']['product_id'] = $product_ques['ProductQuestion']['product_id'];
				if(!empty($this->data['ProductQuestion'])){
					foreach($this->data['ProductQuestion'] as $field_index => $user_info){
						$this->data['ProductQuestion'][$field_index] = html_entity_decode($user_info);
						$this->data['ProductQuestion'][$field_index] = str_replace('&#039;',"'",$this->data['ProductQuestion'][$field_index]);
					}
				}
				if(!empty($this->data['ProductAnswer'])){
					foreach($this->data['ProductAnswer'] as $field_index => $user_info){
						$this->data['ProductAnswer'][$field_index] = html_entity_decode($user_info);
						$this->data['ProductAnswer'][$field_index] = str_replace('&#039;',"'",$this->data['ProductAnswer'][$field_index]);
					}
				}
			}
		}else{
			$this->Session->setFlash('Please login before add a question');
			$this->redirect('/homes/index');
		}
	}
	

	/** 
	@function :	searchresult	
	@description :	show searchresult 	
	@Created by:	Ramanpreet Pal Kaur
	@params
	@Modify:
	@Created Date:
	*/
	function searchresult(){
		$this->layout = 'search_product_user';
		//$this->set('title_for_layout','Please define this using the search term as: Choiceful.com Search Results for "Search Term"');
		$items = array();$results =array(); $facetmap = array();
		$ws_location = WS_LOCATION;
		//Create a new soap client
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		$search_result = array();
		$continue_shopping = array();
		$continue_shopping_slogan = array();
		$params_url = array();
		$view_size = VIEW_SIZE_FH;
		
		if(!empty($this->params['named']['keywords'])){
			$keyword = $this->params['named']['keywords'];
		}elseif(!empty($this->params['pass'][0])){
			$keyword = $this->params['pass'][0];
		}else{
			$keyword = null;
		}
		
		$this->set('searchWord',trim($keyword));
		if(!empty($this->params['named']['dept_id'])){
			$department_id = $this->params['named']['dept_id'];
		}else{
			$department_id = null;
		}
		if(!empty($this->params['named']['sort_by'])){
			$sort_by = $this->params['named']['sort_by'];
		}else{
			$sort_by = 'null';
		}
		
		$this->set('title_for_layout','Choiceful.com Search Results for "'.$keyword.'"');
		
		$this->set('view_size',$view_size);
		//echo $this->data['Product']['params_url'];
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
		$paging_flag = 1;
		if(empty($fh_location)){
			$fh_location="fh_location=//catalog01/en_GB/";
			if(!empty($this->data['Marketplace']['keywords']) || !empty($keyword)){
				if(!empty($this->data['Marketplace']['keywords'])){
					$search_word = trim($this->data['Marketplace']['keywords']);
				}else{
					$search_word = trim($keyword);
				}
				$this->set('searchWord',$search_word);
				$this->set('department_id',$department_id);
				
				App::import('Sanitize');
				$search_word = Sanitize::escape($search_word);
				
				$search_word = str_replace(' ','\u0020',$search_word);
				$search_word = str_replace('!','\u0021',$search_word);
				$search_word = str_replace('"','\u0022',$search_word);
				$search_word = str_replace('#','\u0023',$search_word);
				$search_word = str_replace('/','\u002f',$search_word);
				$search_word = str_replace('@','\u0040',$search_word);
				$fh_location = $fh_location.'$s='.$search_word;
				//Added by nakul
				if(!empty($this->data['Marketplace']['department']) || !empty($department_id)){
					/*if(!empty($this->data['Marketplace']['keywords'])){
					$department_id = trim($this->data['Marketplace']['MarketplaceDepartment']);
				}else{
					$department_id = $department_id;
				}*/
				$department_id = $department_id;
				$this->loadModel("Department");
				$department = $this->Department->getDepartmentName($department_id);
				$dept_name = str_replace(array('&',' '), array('_','_'), html_entity_decode(strtolower($department), ENT_NOQUOTES, 'UTF-8'));
				$fh_location = $fh_location.'/department_name={'.$dept_name.'}';
				}
				//End by nakul
				$paging_flag = 0;
			}else{
				$search_word = "";
			}
			
			//Start Filter Section
			//pr($this->params);
			if(!empty($this->params['named']['fh_loc'])){
					$fhloc = str_replace('-','/',$this->params['named']['fh_loc']);
					$fh_location = $fh_location.'/'.$fhloc;
					$this->set("fhloc",$fhloc);
				}
			//echo urlencode($this->params['named']['fvalue']);
			if(!empty($this->params['named']['ftitle'])){
			if(!empty($this->params['named']['ftitle']) && $this->params['named']['ftitle'] == "product_height"){
				$fh_location = $fh_location.'/'.$this->params['named']['ftitle'].'='.$this->params['named']['fvalue'];
			}elseif(!empty($this->params['named']['ftitle']) && $this->params['named']['ftitle'] == "average_star_rating"){
				$fh_location = $fh_location.'&avg_rating='.$this->params['named']['fvalue'];
			}elseif(!empty($this->params['named']['ftitle']) && $this->params['named']['ftitle'] == "product_categories"){
				$fh_location = $fh_location.'/'.'categories'.'<{'.$this->params['named']['fvalue'].'}';
			}elseif(!empty($this->params['named']['ftitle']) && $this->params['named']['ftitle'] == "seller_id"){
				$fh_location = $fh_location.'/'.$this->params['named']['ftitle'].'='.$this->params['named']['fvalue'];
			}elseif(!empty($this->params['named']['ftitle']) && $this->params['named']['ftitle'] == "price"){
				$fh_location = $fh_location.'/'.urlencode($this->params['named']['fvalue']);
			}elseif(!empty($this->params['named']['ftitle']) && $this->params['named']['Multiselect'] == "Multiselect"){
				$mulValue = str_replace(',',';',$this->params['named']['fvalue']);
				$fh_location = $fh_location.'/'.$this->params['named']['ftitle'].'={'.$mulValue.'}';
			}elseif(!empty($this->params['named']['ftitle'])){
				$fh_location = $fh_location.'/'.$this->params['named']['ftitle'].'={'.$this->params['named']['fvalue'].'}';
			}
			
			$this->set("ftitle",$this->params['named']['ftitle']);
			$this->set("fvalue",$this->params['named']['fvalue']);
			if($this->params['named']['Multiselect'] == "Multiselect"){
				$multiselectArr = $this->params['named']['fvalue'];
				$this->set('multiselectArr', $multiselectArr);
			}
			if($this->params['named']['ftitle'] == "department_name"){
				$this->loadModel("Department");
				$fhdepartments = $this->Department->getListFh_departments();
				$department_id = $fhdepartments[$this->params['named']['fvalue']];
				$this->set('department_id', $department_id);
			}
			
			}
			//End Filter Section
				
			//Start for sorting
				if(!empty($this->data['Product']['sort'])){
					$fh_location = $fh_location.'&fh_sort_by='.$this->data['Product']['sort'];
					$sort = $this->data['Product']['sort'];
					$this->set('sort',$sort);
				}elseif(!empty($sort_by)){
					$fh_location = $fh_location.'&fh_sort_by='.$sort_by;
					$this->set('sort',$sort_by);
				}
			//End for Sorting
			$fh_location = $fh_location."&preview_advanced=true&fh_view_size=$view_size&fh_start_index=0";
			$pass_url = $fh_location."&preview_advanced=true&fh_view_size=$view_size&fh_start_index=0";
			$paging_flag = 0;
			
			//echo $fh_location;
		} else {
			//echo $keyword;
			//$fh_location = '?fh_eds=ß&'.$fh_location;
			$this->set('searchWord',$keyword);
			$this->set('sort',$sort_by);
			$this->set('department_id',urlencode($department_id));
			
			//$this->set('sort',$sort);
			$pass_url = $fh_location;
			$fh_location = str_replace('~','/',$fh_location);
			
			// for brands sorting
			/*$brands = explode('/',$fh_location);
			pr($brands);
			//$brands = "brand=";
			foreach($brands as $brand){
				if(strstr($brand, "brand=")) {
					echo $brand;
					$brands_name = explode('={',$brand);
					pr($brands_name);
					echo $brands_multi = str_replace('}','',$brands_name[1]);
				}
			}*/
			//end for brainds soting
			$fh_location = $fh_location;
			$paging_flag = 1;
		}
		/*if(empty($search_word) && !empty($keyword)){
			$search_word = urldecode($keyword);
		}
		
		$this->set('department_id',urlencode($department_id));*/
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
					if(!empty($themes_continue)){
						foreach($themes_continue as $themes_continue){
							if(!empty($themes_continue->{'custom-fields'}->{'custom-field'}->_)){
							if($themes_continue->{'custom-fields'}->{'custom-field'}->_ == 'Recommended Products - Footer'){
									if(!empty($themes_continue->items)){
										if(count($themes_continue->items->item) == 1){
											$continue_shopping[0] = $themes_continue->items->item;
											$continue_shopping_slogan = $themes_continue->slogan;
										}else{
											$continue_shopping = $themes_continue->items->item;
											$continue_shopping_slogan = $themes_continue->slogan;
										}
									}
								}
							}
							
						}
					}
					
					
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
				// added on 17 May 2012
			}
		}
		
		$k = 0;
		//pr($items['item']);
			if(!empty($items['item']) && count($items['item'])>1){
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
						if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
							$search_result[$k]['product_rrp'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
							$search_result[$k]['minimum_price_used'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price'  && !empty($attribute->value->_)){
							$search_result[$k]['minimum_price'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_value'  && !empty($attribute->value->_)){
							$search_result[$k]['minimum_price_value'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_seller'  && !empty($attribute->value->_)){
							$search_result[$k]['minimum_price_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used_seller'  && !empty($attribute->value->_)){
							$search_result[$k]['minimum_price_used_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
							$search_result[$k]['condition_new'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_used'  && !empty($attribute->value->_)){
							$search_result[$k]['condition_used'] = $attribute->value->_;
						}
					}
					
				}
			$k++;	
			}
			}
			
		if(!empty($items['item']))
			$items = $items['item'];
			
		if(!empty($items)){
			if(count($items) == 1){
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
		unset($result);
		
		###################  Add product data to the product visit ################
		App::import('Model','ProductVisit');
		$this->ProductVisit = new ProductVisit;
		$myRecentProducts = $this->ProductVisit->getMyVisitedProducts();
		$this->set('myRecentProducts',$myRecentProducts);
		
		#############################################
		/** Paging parameters **/
		
		$this->set('continue_shopping_slogan',$continue_shopping_slogan);
		$this->set('continue_shopping',$continue_shopping);
		$this->set('results',$results);
		$this->set('results',$results);
		$this->set('breadcrumbs',$breadcrumbs);
		//$this->set('items',$items);
		if(count($search_result)==0){
			$this->set("fhloc","");
			$this->set("ftitle","");
			$this->set("fvalue","");
		}
		$this->set('search_result',$search_result);
		$this->set('facetmap',$facetmap);
	}

	/** 
	@function : save_ansvote
	@description : to save votes for answers
	@Created by : Ramanpreet Pal Kaur
	@params : 	
	@Modify : 
	@Created Date : 
	*/
	function save_ansvote($answer_id = null , $vote = null){
		App::import('Model','ProductanswerVote');
		$this->ProductanswerVote = new ProductanswerVote;
		$this->layout = 'ajax';
		if(!empty($answer_id)) {
			$this->data['ProductanswerVote']['answer_id'] = $answer_id;
			$this->data['ProductanswerVote']['user_vote'] = $vote;
			$this->set($this->data);
			if($this->ProductanswerVote->save($this->data)){
				$this->Session->write('sessionAnsId'.$answer_id,1);
			} else{
				$this->Session->write('sessionAnsId'.$answer_id,0);
			}
			$this->set('ans_id',$answer_id);
		} else{
			$this->Session->write('sessionAnsId'.$answer_id,0);
		}
		$this->set('ans_id',$answer_id);
	}
	
	/** 
	@function : report_answer
	@description : to send report for answers
	@Created by : Ramanpreet Pal Kaur
	@params : 	
	@Modify : 
	@Created Date : 
	*/
	/*
	function report_answer($ans_id = null){
		$this->layout = 'front_popup';
		App::import('Model', 'ProductAnswer');
		$this->ProductAnswer = new ProductAnswer();
		if(!empty($this->data)){
			$this->Product->set($this->data);
			if($this->Product->validates()){
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
				$data = $data.'<tr><td>You have received following report on  "('.$this->data['Product']['product_name'].' product) '.$this->data['Product']['question'].'" question for  "'.$this->data['Product']['answer'].' answer":</td></tr>';
				$data = $data.'<tr><td><br/>'.$this->data['Product']['reason'].'</td></tr>';
				$data = $data.'</table>';
				$this->Email->subject = 'Answer report for '.$this->data['Product']['product_name'].' product';
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
				$this->set('errors',$this->Product->validationErrors);
			}
		} else {
			$this->ProductAnswer->expects(array('ProductQuestion'));
			$this->ProductAnswer->ProductQuestion->expects(array('Product'));
			$this->ProductAnswer->recursive = 2;
			$product_detail = $this->ProductAnswer->find('first',array('conditions'=>array('ProductAnswer.id'=>$ans_id),'fields'=>array('ProductAnswer.id','ProductAnswer.product_question_id','ProductAnswer.answer','ProductQuestion.product_id','ProductQuestion.question')));
			$this->data['Product']['id'] = $product_detail['ProductQuestion']['Product']['id'];
			$this->data['Product']['question'] = $product_detail['ProductQuestion']['question'];
			$this->data['Product']['answer'] = $product_detail['ProductAnswer']['answer'];
			$this->data['Product']['product_name'] = $product_detail['ProductQuestion']['Product']['product_name'];
		}
	}
	*/
	
	/** 
	@function : report_answer
	@description : to send report for answers
	@Created by : Ramanpreet Pal Kaur
	@params : 	
	@Created Date : 
	@Modified By: Vikas Uniyal
	@Modified on: Oct. 19, 2012
	@Modified Description: Email Template added
	
	*/
	function report_answer($ans_id = null){
		$this->layout = 'front_popup';
		App::import('Model', 'ProductAnswer');
		$this->ProductAnswer = new ProductAnswer();
		if(!empty($this->data)){
			$this->Product->set($this->data);
			if($this->Product->validates()){
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);
				$this->Email->replyTo=Configure::read('replytoEmail');
				$this->Email->sendAs= 'html';
				
				/******import emailTemplate Model and get template****/
				App::import('Model','EmailTemplate');
				$this->EmailTemplate = new EmailTemplate;
				/**
				table: email_templates
				id: 32
				description: Report mail format for admin
				*/
				$template = $this->Common->getEmailTemplate(33);
				
				$this->Email->from = $template['EmailTemplate']['from_email'];
				$productName = str_replace(array(' ','/','&quot;','&','andamp','and;'), array('-','','"','and','and','and'),$this->data["Product"]["product_name"]);
				$subject = str_replace('[ProductName]',$productName,$template['EmailTemplate']['subject']);
				$this->Email->subject = $subject;
				$data = $template['EmailTemplate']['description'];
				$data = str_replace('[ProductName]', trim($this->data["Product"]["product_name"]), $data);
				$data = str_replace('[REASON]', trim($this->data['Product']['reason']), $data);
				$data = str_replace('[QUESTION]', trim($this->data['Product']['question']), $data);
				$data = str_replace('[ANSWER]', trim($this->data['Product']['answer']), $data);
				$link = '<a href="'.SITE_URL.$productName.'/categories/productdetail/'.$this->data["Product"]["id"].'">'.SITE_URL.$productName.'/categories/productdetail/'.$this->data["Product"]["id"].'</a>';
				$data = str_replace('[PRODUCT_URL]', $link, $data);
				$this->set('data',$data);
				
				$this->Email->to = Configure::read('fromEmail');
				//$this->Email->to = 'smaartdatatest@gmail.com';
				/******import emailTemplate Model and get template****/
				$this->Email->template='commanEmailTemplate';
				if($this->Email->send()) {
					$this->Session->setFlash('Report has been sent successfully.');
					echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
						</script>";
				} else{
					$this->Session->setFlash('An error occurred while sending the email. Please try later.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->Product->validationErrors);
			}
		} else {
			$this->ProductAnswer->expects(array('ProductQuestion'));
			$this->ProductAnswer->ProductQuestion->expects(array('Product'));
			$this->ProductAnswer->recursive = 2;
			$product_detail = $this->ProductAnswer->find('first',array('conditions'=>array('ProductAnswer.id'=>$ans_id),'fields'=>array('ProductAnswer.id','ProductAnswer.product_question_id','ProductAnswer.answer','ProductQuestion.product_id','ProductQuestion.question')));
			$this->data['Product']['id'] = $product_detail['ProductQuestion']['Product']['id'];
			$this->data['Product']['question'] = $product_detail['ProductQuestion']['question'];
			$this->data['Product']['answer'] = $product_detail['ProductAnswer']['answer'];
			$this->data['Product']['product_name'] = $product_detail['ProductQuestion']['Product']['product_name'];
		}
	}

	/** 
	@function : save_rating
	@description : to store rating of a product in product_ratings as well as avg_rating in products table
	@Created by : Ramanpreet Pal Kaur
	@params : 	
	@Modify : 
	@Created Date : 
	*/
	function save_rating($product_id = null,$rate=null){
		$this->layout = 'ajax';
		
		if($rate<=5 && $this->RequestHandler->isAjax()){
		
		App::import('Model', 'ProductRating');
		$this->ProductRating = new ProductRating();
		$this->data['ProductRating']['product_id'] = $product_id;
		$this->data['ProductRating']['rating'] = $rate;
		$this->ProductRating->set($this->data);
		$saveRatingId = 'saveRating'.$product_id;
		
		if($this->ProductRating->save($this->data)) {
			$this->Session->write($saveRatingId,1);
		} else {
			$this->Session->write($saveRatingId,0);
		}
		$avgRating = $this->ProductRating->get_avg_rating($product_id);
		if(!empty($avgRating)){
			if(!empty($avgRating['save_avg'])){
				$this->data['Product']['id'] = $product_id;
				$this->data['Product']['avg_rating'] = $avgRating['save_avg'];
				$this->Product->set($this->data);
				$this->Product->save($this->data);
			}
		}
		$this->set('product_id',$product_id);
		$this->set('full_stars',$avgRating['full_stars']);
		$this->set('half_star',$avgRating['half_star']);
		$this->set('total_rating_reviewers',$avgRating['total_rating_reviewers']);
		$rating_value = 'rating_value'.$product_id;
		$this->Session->write($rating_value,$rate);
		$this->viewPath = 'elements/product' ;
		$this->render('save_rating');
		}else{
			echo 'Invalid attempt';
		}
		
	}

	/** 
	@function : save_productpageVote
	@description : to store vote for product
	@Created by : Ramanpreet Pal Kaur
	@params : 	
	@Modify : 
	@Created Date : 
	*/
	function save_productpageVote($product_id = null , $vote = null){
		App::import('Model','ProductVote');
		$this->ProductVote = new ProductVote;
		$productpageVote = 'productpageVote_'.$product_id;
		$this->layout = 'ajax';
		if(!empty($product_id)) {
			$this->data['ProductVote']['product_id'] = $product_id;
			$this->data['ProductVote']['user_vote'] = $vote;
			$this->set($this->data);
			if($this->ProductVote->save($this->data)){
				$this->Session->write($productpageVote,1);
			} else{
				$this->Session->write($productpageVote,0);
			}
		} else{
			$this->Session->write($productpageVote,0);
		}
		$this->set('product_id',$product_id);
		$this->viewPath = 'elements/product' ;
		$this->render('product_vote');
	}
	
	/** 
	@function : bestseller	
	@description : to show best sold products for all pr department based
	@Created by : kulvinder Singh	
	@params : 
	@Modify : 8 June 2011 (Ramanpreet Pal Kaur)
	@Created Date : 24-12-2010	
	*/
	function bestseller(){
		$this->layout = 'product';
		App::import('Model','Department');
		$this->Department = new Department;
		
		$this->set('title_for_layout','Choiceful.com Bestsellers: All Departments');
		
		$ws_location = WS_LOCATION;
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		$fh_location = 'fh_location=//catalog01/en_GB&special-page-id=bestsellers';
			$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
			//Find the universe marked as 'selected' in the result
			if(!empty($result)){
				foreach($result->universes->universe as $r) {
					if($r->{"type"} == "selected"){
						//Extract & print the breadcrumbs from the result
						if(!empty($r->themes)){
							$facetmap = (array)$r->facetmap->filter;
						}
						//pr($facetmap);
						foreach($facetmap as $facetmap){
							foreach($facetmap->{'custom-fields'}->{'custom-field'}  as $custom){
								if($custom->_ == "Topmenu"){
									if($facetmap->filtersection){
										foreach($facetmap->filtersection as $filtersection){
											$dep_name[] = $filtersection->link->name;
										}
									}
								}
							}
						}
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
			}
		//pr($result);
		/*$departments_list = array();
		$departments_list = $this->Department->find('all',array('conditions'=>array('Department.status'=>'1'),'fields'=>array('Department.id','Department.name'), 'order'=>'Department.name'));
		$dept_themes = array();
		if(!empty($departments_list)){
			//pr($departments_list);
		}*/
		//pr($fh_themes);
		if(!empty($fh_themes)){
			$j = 0;
			foreach($fh_themes as $fh_themes){
				
				//pr($departments_list[$j]);
				if($fh_themes->{'custom-fields'}->{'custom-field'}->_ == "Sub-Category Item Preview"){
					$best_items = $fh_themes->items->item;
					$department_name = $dep_name[$j];
					$i = 0;
					if(!isset($best_items->attribute)){
					foreach($best_items as $bestseller_product){
						
						foreach($bestseller_product->attribute as $attribute){
							if($attribute->name == 'department_name' && !empty($attribute->value->_)){
								$products_info[$j]['department_name'] = $department_name;
							}
							if($attribute->name == 'secondid' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['product_name'] = $attribute->value->_;
							}
							if($attribute->name == 'product_image' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['product_image'] = $attribute->value->_;
							}
							if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['avg_rating'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['minimum_price_value'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['minimum_price_used'] = $attribute->value->_;
							}
							if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['product_rrp'] = $attribute->value->_;
							}
						}
						
					$i++;
					}
					}else{
						foreach($best_items->attribute as $attribute){
							if($attribute->name == 'department_name' && !empty($attribute->value->_)){
								$products_info[$j]['department_name'] = $department_name;
							}
							if($attribute->name == 'secondid' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['product_name'] = $attribute->value->_;
							}
							if($attribute->name == 'product_image' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['product_image'] = $attribute->value->_;
							}
							if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['avg_rating'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['minimum_price_value'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['minimum_price_used'] = $attribute->value->_;
							}
							if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['product_rrp'] = $attribute->value->_;
							}
						}
						
					}
					
				}
				$j++;
			}
			
			
		}
		//pr($products_info);
		$departments_list = $this->getDepartmentName();
		
		$this->set('departments_list',$departments_list);
		$this->set('products_info',$products_info);
		
	}
	
	/** 
	@function : bestseller	
	@description : to show best sold products for selected department
	@Created by : Ramanpreet Pal Kaur
	@Created Date : 8 June 2011
	*/
	function bestseller_products($dept_id = null,$page_display= null){
		$dept_items = array();
		
		//$this->set('title_for_layout','Choiceful.com Bestsellers: Bestsellers in "Department Name"');
		
		
		if(empty($page_display))
			$page_display = 25;
			
		$this->set('selected_department',base64_decode($dept_id));
		$dept_id = base64_decode($dept_id);
		App::import('Model','Department');
		$this->Department = new Department;
		
		$dept_name = '';
		$dept_name = $this->Department->find('first',array('conditions'=>array('Department.id'=>$dept_id),'fields'=>array('Department.name')));
		$dept_name = $dept_name['Department']['name'];
		$this->set('dept_name',$dept_name);
		
		$this->set('title_for_layout','Choiceful.com Bestsellers: Bestsellers in "'.$dept_name.'"');
		
		$ws_location = WS_LOCATION;
		//Create a new soap client
		//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		$dept = str_replace(array('&',' '), array('_','_'), html_entity_decode(strtolower($dept_name), ENT_NOQUOTES, 'UTF-8'));
		//$fh_location = 'fh_location=//catalog01/en_GB/department_name={'.$dept.'}';
		
		$fh_location = 'fh_location=//catalog01/en_GB&special-page-id=bestsellers';
		/*if(!empty($dept_id)){
			$fh_location = $fh_location.'/department_name={'.$dept.'}';
		}*/
		$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
		//pr($result);
		//Find the universe marked as 'selected' in the result
		if(!empty($result)){
			foreach($result->universes->universe as $r) {
				if($r->{"type"} == "selected"){
					//Extract & print the breadcrumbs from the result
					if(!empty($r->themes)){
						$facetmap = (array)$r->facetmap->filter;
					}
					
					//pr($facetmap);
					foreach($facetmap as $facetmap){
						foreach($facetmap->{'custom-fields'}->{'custom-field'}  as $custom){
							if($custom->_ == "Topmenu"){
								if($facetmap->filtersection){
									foreach($facetmap->filtersection as $filtersection){
										$dep_name[] = $filtersection->link->name;
									}
								}
							}
						}
					}
					
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
		}
		
		//pr($fh_themes);
		if(!empty($fh_themes)){
			$j = 0;
			foreach($fh_themes as $fh_themes){
				if($fh_themes->{'custom-fields'}->{'custom-field'}->_ == "Sub-Category Item Preview"){
					$best_items = $fh_themes->items->item;
					
					$department_name = $dep_name[$j];
					if($department_name == $dept_name){
					$i = 1;
					if(!isset($best_items->attribute)){
					foreach($best_items as $bestseller_product){
						
						foreach($bestseller_product->attribute as $attribute){
							if($attribute->name == 'secondid' && !empty($attribute->value->_)){
								$products_info[$i]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name' && !empty($attribute->value->_)){
								$products_info[$i]['product_name'] = $attribute->value->_;
							}
							if($attribute->name == 'product_image' && !empty($attribute->value->_)){
								$products_info[$i]['product_image'] = $attribute->value->_;
							}
							if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
								$products_info[$i]['avg_rating'] = $attribute->value->_;
							}
							if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
								$products_info[$i]['product_rrp'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
								$products_info[$i]['minimum_price_used'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
								$products_info[$i]['minimum_price_value'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_seller' && !empty($attribute->value->_)){
								$products_info[$i]['minimum_price_seller'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used_seller' && !empty($attribute->value->_)){
								$products_info[$i]['minimum_price_used_seller'] = $attribute->value->_;
							}
							if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
								$products_info[$i]['condition_new'] = $attribute->value->_;
							}
							if($attribute->name == 'condition_used' && !empty($attribute->value->_)){
								$products_info[$i]['condition_used'] = $attribute->value->_;
							}
							
						}
						
					$i++;
					}
					}else{
						foreach($best_items->attribute as $attribute){
							if($attribute->name == 'secondid' && !empty($attribute->value->_)){
								$products_info['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name' && !empty($attribute->value->_)){
								$products_info[$i]['product_name'] = $attribute->value->_;
							}
							if($attribute->name == 'product_image' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['product_image'] = $attribute->value->_;
							}
							if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
								$products_info[$j]["item"][$i]['avg_rating'] = $attribute->value->_;
							}
							if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
								$products_info[$i]['product_rrp'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
								$products_info[$i]['minimum_price_used'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
								$products_info[$i]['minimum_price_value'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_seller' && !empty($attribute->value->_)){
								$products_info[$i]['minimum_price_seller'] = $attribute->value->_;
							}
							if($attribute->name == 'minimum_price_used_seller' && !empty($attribute->value->_)){
								$products_info[$i]['minimum_price_used_seller'] = $attribute->value->_;
							}
							if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
								$products_info[$i]['condition_new'] = $attribute->value->_;
							}
							if($attribute->name == 'condition_used' && !empty($attribute->value->_)){
								$products_info[$i]['condition_used'] = $attribute->value->_;
							}
						}
						
					}
					}
					
				}
				$j++;
			}
		}
		/*Fro Top Seller */
		App::import('Model' , 'TempTopSeller');
		$this->TempTopSeller = new TempTopSeller();
		$top_seller_product = $this->TempTopSeller->find('list',array('fields'=>array('TempTopSeller.quick_code','TempTopSeller.position')));
		/* End for Top Seller*/
		$this->set('products_info',$products_info);
		$this->set('page_display',$page_display);
		$this->set('top_seller_product',$top_seller_product);
// echo $page_display; die;
		if($this->RequestHandler->isAjax() == 0) {
			$this->layout = 'product';
		}else {
			$this->layout='ajax';
			$this->viewPath = 'elements/product' ;
			$this->render('best_products');
			
		}
	}
	
	
	/** 
	@function : email_friend
	@description : to send this page link to your friend
	@Created by : Ramanpreet Pal Kaur
	@params : 	
	@Modify : 
	@Created Date : 21 Jan, 2010
	*/
	function email_friend($pro_id = null,$pro_name= null){
		$this->set('pro_id',$pro_id);
		$this->set('pro_name',$pro_name);
		$this->layout = 'front_popup'; 
		if(!empty($this->data)) {
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
				$this->Email->subject = $this->data['Product']['product_name'].' Product on choiceful.com';
				$data = '<table width="100%" cellspacing="2" cellpadding="2" border="0">';
				$data .= '<tr><td>Hello '.ucfirst($this->data['Product']['recipient_name']).'</td></tr>';
				$data .= '<tr><td>Visit the link given below:<br><br><a href="'.SITE_URL.'categories/productdetail/'.$this->data['Product']['id'].'">'.SITE_URL.'categories/productdetail/'.$this->data['Product']['id'].'</a></td></tr>';
				if(!empty($this->data['Product']['message'])){
					$data .= '<tr><td>&nbsp;</td></tr>';
					$data .= '<tr><td>'.$this->data['Product']['message'].'</td></tr>';
				}
				$this->set('data',$data);
				$this->Email->to = $this->data['Product']['recipient_email'];
				/******import emailTemplate Model and get template****/
				$this->Email->template='commanEmailTemplate';
				if($this->Email->send()) {
					$this->Session->setFlash('Mail has been sent successfully.');
					echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
					</script>";
					
				} else{
					$this->Session->setFlash('An error occurred while sending the email,please try again.','default',array('class'=>'flashError'));
				}
			} else{
				$this->set('errors',$this->Product->validationErrors);
			}
		} else{
			$this->data['Product']['id'] = $pro_id;
			$this->data['Product']['product_name'] = $pro_name;
		}
	}
	
	/** 
	@function : tell_admin
	@description : if mistake tell admin
	@Created by : Ramanpreet Pal Kaur
	@params : 	
	@Modify : 
	@Created Date : Jan 21,2011
	*/
	/*
	function tell_admin($pro_id = null,$pro_name= null){
		$this->layout = 'front_popup';
		$user = $this->Session->read('User');
		if(!empty($this->data)){
			$this->Product->set($this->data);
			if($this->Product->validates()){
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);
				$this->Email->from = ucwords(strtolower($user['firstname'].' '.$user['lastname'])).'<'.$user['email'].'>';
				$this->Email->from = ucwords(strtolower($user['firstname'].' '.$user['lastname'])).'<'.$user['email'].'>';
				$this->Email->sendAs= 'html';
				$data = '<table width="100%" cellspacing="3" cellpadding ="3" border="0">';
				$data = $data.'<tr><td>You have received a suggession for '.$this->data['Product']['name'].' product detail page.</td></tr>';
				$data = $data.'<tr><td><br/>'.$this->data['Product']['reason'].'<br /><strong>Please click on the link below to visit this page:</strong><br /><a href="'.SITE_URL.'categories/productdetail/'.$this->data['Product']['id'].'">'.SITE_URL.'categories/productdetail/'.$this->data['Product']['id'].'</a></td></tr>';
				$data = $data.'</table>';
				$this->Email->subject = 'Suggession for '.$this->data['Product']['name'].' product detail page.';
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
				$this->set('errors',$this->Product->validationErrors);
			}
		} else{
			$this->data['Product']['id'] = $pro_id;
			$this->data['Product']['name'] = $pro_name;
		}
	}
	*/
	
	/** 
	@function : tell_admin
	@description : if mistake tell admin
	@Created by : Ramanpreet Pal Kaur
	@params : 	
	@Created Date : Jan 21,2011
	@Modified By: Vikas Uniyal
	@Modify on: Oct 19
	@Modification Description: Email template added 
	*/
	function tell_admin($pro_id = null,$pro_name= null){
		$this->layout = 'front_popup';
		$user = $this->Session->read('User');
		if(!empty($this->data)){
			$this->Product->set($this->data);
			if($this->Product->validates()){
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);
				
				$this->Email->replyTo=Configure::read('replytoEmail');
				$this->Email->sendAs= 'html';
				
				/******import emailTemplate Model and get template****/
				App::import('Model','EmailTemplate');
				$this->EmailTemplate = new EmailTemplate;
				/**
				table: email_templates
				id: 32
				description: Report mail format for admin
				*/
				$template = $this->Common->getEmailTemplate(32);
				
				$this->Email->from = $template['EmailTemplate']['from_email'];
				$productName = str_replace(array(' ','/','&quot;','&'), array('-','','"','and'),$this->data["Product"]["name"]);
				$subject = str_replace('[ProductName]',$productName,$template['EmailTemplate']['subject']);
				$this->Email->subject = $subject;
				$data = $template['EmailTemplate']['description'];
				$data = str_replace('[ProductName]', trim($this->data["Product"]["name"]), $data);
				$data = str_replace('[REASON]', trim($this->data['Product']['reason']), $data);
				$link = '<a href="'.SITE_URL.$productName.'/categories/productdetail/'.$this->data["Product"]["id"].'">'.SITE_URL.$productName.'/categories/productdetail/'.$this->data["Product"]["id"].'</a>';
				$data = str_replace('[PRODUCT_URL]', $link, $data);
				$this->set('data',$data);
				$this->Email->to = Configure::read('fromEmail');
				//$this->Email->to = 'smaartdatatest@gmail.com';
				$this->Email->template='commanEmailTemplate';
				if($this->Email->send()) {
					$this->Session->setFlash('Report has been sent successfully.');
					echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
						</script>";
				} else{
					$this->Session->setFlash('An error occurred while sending the email. Please try later.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->Product->validationErrors);
			}
		} else{
			$this->data['Product']['id'] = $pro_id;
			$this->data['Product']['name'] = $pro_name;
		}
	}


	/** 
	@function:		my_reviews
	@description		to display all reviews given by user on different products to that user
	@Created by: 		Ramanpreet Pal
	@params		
	@Modify:		NULL
	@Created Date:		Jan 31, 2011
	*/
	function my_reviews(){
		$this->checkSessionFrontUser();
		$this->layout='front';
		$this->set('title_for_layout','Choiceful.com: My Account - Manage Reviews');
		$this->checkSessionFrontUser();
		$reviews_detail = array();
		App::import('Model','Review');
		$this->Review = new Review;
		$user_id = $this->Session->read('User.id');
		$this->Review->expects(array('Product'));
		$all_reviews = $this->Review->find('all',array('conditions'=>array('Review.user_id'=>$user_id,'Review.status'=>'1'),'fields'=>array('Review.id','Review.product_id','Review.review_type','Review.user_id','Review.review_value','Review.comments','Review.status','Product.id','Product.product_name','Review.created','Review.modified'),'order'=>array('Review.created DESC')));
		if(!empty($all_reviews)){
			foreach($all_reviews as $review){
				$reviews_detail[$review['Product']['id']]['Product'] = $review['Product'];
				$reviews_detail[$review['Product']['id']]['Reviews'][] = $review['Review'];
			}
		}
		$this->set('all_reviews',$reviews_detail);
		$all_certificate_reviews = array();
		App::import('Model','CertificateReview');
		$this->CertificateReview = new CertificateReview;
		$user_id = $this->Session->read('User.id');
		$all_certificate_reviews = $this->CertificateReview->find('all',array('conditions'=>array('CertificateReview.user_id'=>$user_id,'CertificateReview.status'=>'1'),'fields'=>array('CertificateReview.id','CertificateReview.review_type','CertificateReview.user_id','CertificateReview.review_value','CertificateReview.comments','CertificateReview.status','CertificateReview.created','CertificateReview.modified'),'order'=>array('CertificateReview.created DESC')));
		$this->set('all_certificate_reviews',$all_certificate_reviews);
	}


	/** 
	@function:		save_searchtags
	@description		to save search tags for a products
	@Created by: 		Ramanpreet Pal
	@params		
	@Modify:		NULL
	@Created Date:		Feb 1, 2011
	*/
	function save_searchtags($searchtags = null, $pr_id = null,$review_pro_id = null){
		$this->set('review_pro_id',$review_pro_id);
		$this->set('pro_id',$pr_id);
		App::import('Model','ProductSearchtag');
		$this->ProductSearchtag = new ProductSearchtag;
		$user_id = $this->Session->read('User.id');
		if(!empty($user_id)){
			if(!empty($searchtags)){
				$this->data['ProductSearchtag']['user_id'] = $user_id;
				$this->data['ProductSearchtag']['product_id'] = $pr_id;
				$this->data['ProductSearchtag']['tags'] = $searchtags;
				
				$this->data = $this->cleardata($this->data);
				//$this->data = Sanitize::clean($this->data, array('encode' => false));
				
				$this->ProductSearchtag->set($this->data);
				if($this->ProductSearchtag->save($this->data)){
					$this->Session->setFlash('Following search tags has been saved successfully, and will implemented after admin approval.<br>'.$searchtags);
				} else{
					$this->Session->setFlash('Search tags has not been saved successfully,try again.','default',array('class'=>'flashError'));
				}
			} else{
				$this->Session->setFlash('Enter search tags.','default',array('class'=>'flashError'));
			}
		} else{
			$this->Session->setFlash('Your session has expired please login again.','default',array('class'=>'flashError'));
		}
		$this->viewPath = 'elements/product' ;
		$this->render('save_search_tags');
	}

	/** 
	@function:		add_certificate_searchtags
	@description		to save search tags for gift certificate
	@Created by: 		Ramanpreet Pal
	@params		
	@Modify:		NULL
	@Created Date:		April 19, 2011
	*/
	function add_certificate_searchtags($searchtags = null){
		App::import('Model','CertificateSearchtag');
		$this->CertificateSearchtag = new CertificateSearchtag;
		$user_id = $this->Session->read('User.id');
		if(!empty($user_id)){
			if(!empty($searchtags)){
				$this->data['CertificateSearchtag']['user_id'] = $user_id;
				$this->data['CertificateSearchtag']['tags'] = $searchtags;
				
				$this->data = $this->cleardata($this->data);
				//$this->data = Sanitize::clean($this->data, array('encode' => false));
				
				$this->CertificateSearchtag->set($this->data);
				if($this->CertificateSearchtag->save($this->data)){
					//$this->Session->setFlash('Following search tags has been saved successfully, and will implemented after admin approval.<br>'.$searchtags);
					$this->Session->setFlash('Your information has been saved successfully, once approved they will added to the product search tags.');
				} else{
					$this->Session->setFlash('Search tags has not been saved successfully,try again.','default',array('class'=>'flashError'));
				}
			} else{
				$this->Session->setFlash('Enter search tags.','default',array('class'=>'flashError'));
			}
		} else{
			$this->Session->setFlash('Your session has expired please login again.','default',array('class'=>'flashError'));
		}
		$this->viewPath = 'elements/gift_certificate' ;
		$this->render('save_search_tags');
	}

	/** 
	@function:		admin_searchtags
	@description		to display search tags with products
	@Created by: 		Ramanpreet Pal
	@params		
	@Modify:		NULL
	@Created Date:		Feb 1, 2011
	*/
	function admin_searchtags(){
		App::import('Model','ProductSearchtag');
		$this->ProductSearchtag = new ProductSearchtag;
		$this->layout='layout_admin';
		$criteria = 1;
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
		/** **************************************** **/
		$this->set('title_for_layout','Product Search Tags');
		$value = '';
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/** SEARCHING **/
		$reqData = $this->data;
		$options['Product.quick_code'] 	 = "Quick Code";
		$options['Product.product_name'] = "Product Name";
		$options['ProductSearchtag.tags'] = "Tag";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
			if(empty($this->data['Search']['searchin'])){
				$fieldname = 'All';
			} else {
				$fieldname = $this->data['Search']['searchin'];
			}
			$show = $this->data['Search']['show'];
			if($show == 'Active'){
				$matchshow = '1';
			}
			if($show == 'Deactive'){
				$matchshow = '0';
			}
			$value = trim($this->data['Search']['keyword']);
			// sanitze the search data
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
			if($value1 !="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (ProductSearchtag.tags = '".$value1."' OR Product.product_name LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value != "") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
			if(isset($show) && $show!==""){
				if($show == 'All'){
				} else {
					$criteria .= " and ProductSearchtag.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		$this->set('heading','Search Tags');
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."searchtags_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
			$limit = $this->data['Record']['limit'];
			$this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		
		$this->paginate = array(
			'limit' => $limit,
			'order' => array('ProductSearchtag.created' => 'DESC'),
			'fields'=> array('Product.id',
				'Product.product_name',
				'Product.quick_code',
				'User.id',
				'User.firstname',
				'User.lastname',
				'User.email',
				'ProductSearchtag.id',
				'ProductSearchtag.product_id',
				'ProductSearchtag.user_id',
				'ProductSearchtag.tags',
				'ProductSearchtag.status',
				'ProductSearchtag.created'
			)
		);
		$total_tages=$this->ProductSearchtag->find('all',
				array(
				'fields'=>array('SUM((LENGTH(ProductSearchtag.tags) - LENGTH(REPLACE(ProductSearchtag.tags , ",","")) +1 )) AS total_tag'),
				));
		$this->set('total_tag',$total_tages[0][0]['total_tag']);
			
		$this->ProductSearchtag->expects(array('Product','User'));
		$this->set('product_tags',$this->paginate('ProductSearchtag',$criteria));
	}


	
	/** 
	@function	:	admin_searchtag_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	Feb 1,2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_searchtag_multiplAction(){
		App::import('Model','ProductSearchtag');
		$this->ProductSearchtag = new ProductSearchtag;
		if($this->data['ProductSearchtag']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->ProductSearchtag->id=$id;
					$this->ProductSearchtag->saveField('status','1');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['ProductSearchtag']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->ProductSearchtag->id=$id;
					$this->ProductSearchtag->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');	
				}
			}
		} elseif($this->data['ProductSearchtag']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->ProductSearchtag->delete($id);
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
		if(!empty($this->data['Search']['keyword']) && !empty($this->data['Search']['searchin']) && !empty($this->data['Search']['show']))
			$this->redirect('/admin/products/searchtags/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		else
			$this->redirect('/admin/products/searchtags/');
	}


	/** 
	@function	:	admin_tagstatus
	@description	:	to update status of selected search users
	@params		:	NULL
	@created	:	February 1,2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_tagstatus($id = null,$status= null) {
		App::import('Model','ProductSearchtag');
		$this->ProductSearchtag = new ProductSearchtag;
		if(!empty($id)) {
			$this->data['ProductSearchtag']['id'] = $id;
			if($status == 0){
				$this->data['ProductSearchtag']['status'] = 1;
			} else{
				$this->data['ProductSearchtag']['status'] = 0;
			}
			$this->ProductSearchtag->save($this->data);
		}
		$this->redirect('searchtags');
	}

	/** 
	@function	:	admin_delete_tags
	@description	:	to delete selected search tags
	@params		:	NULL
	@created	:	February 1,2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete_tags($id = null) {
		App::import('Model','ProductSearchtag');
		$this->ProductSearchtag = new ProductSearchtag;
		$this->ProductSearchtag->deleteAll("ProductSearchtag.id ='".$id."'");
		$this->Session->setFlash("Record has been deleted successfully.");
		$this->redirect(array('controller'=>'products','action'=>'searchtags'));
	}

	/** 
	@function	:	admin_add_tags
	@description	:	to add/edit search tags
	@params		:	NULL
	@created	:	February 1,2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_add_tags($id = null) {
		$this->set('id',$id);
		$flag =1;
		App::import('Model','ProductSearchtag');
		$this->ProductSearchtag = new ProductSearchtag;
		$this->layout = 'layout_admin';
		if(!empty($id)){
			$this->set('listTitle','Update Search Tag');
		} else{
			$this->set('listTitle','Add Search Tag');
		}
		if(!empty($this->data)){
			$this->ProductSearchtag->set($this->data);
			if($this->ProductSearchtag->validates()){
				if(empty($this->data['ProductSearchtag']['id'])) {
					$flag = 0;
					$this->data['ProductSearchtag']['status'] = 1;
					if(!empty($this->data['ProductSearchtag']['quick_code'])){
						$pr_id = $this->Common->getProductIdfromQuickCode($this->data['ProductSearchtag']['quick_code']);
						$this->data['ProductSearchtag']['product_id'] = $pr_id;
					}
					if(!empty($this->data['ProductSearchtag']['product_id'])) {
						$flag = 1;
					}
				}
				$this->ProductSearchtag->set($this->data);
				if(!empty($flag)) {
					if($this->ProductSearchtag->save()) {
						if(empty($this->data['ProductSearchtag']['id'])) {
							$this->Session->setFlash("Search tag has been added successfully.");
						} else{
							$this->Session->setFlash("Search tag has been updated successfully.");
						}
						$this->redirect('searchtags');
					} else{
						if(empty($this->data['ProductSearchtag']['id'])) {
							$this->Session->setFlash("Information has not been added successfully.",'default',array('class'=>'flashError'));
						} else{
							$this->Session->setFlash("Information has not been updated successfully.",'default',array('class'=>'flashError'));
						}
					}
				} else{
					$this->Session->setFlash("Given quick code doesn't belong to any product.",'default',array('class'=>'flashError'));
				}
			} else{
				$errorArray = $this->ProductSearchtag->validationErrors;
				$this->set('errors',$errorArray);
			}
		} elseif(!empty($id)) {
			$this->ProductSearchtag->id = $id;
			$conditions = array('ProductSearchtag.id = '.$id);
			$this->ProductSearchtag->expects(array('Product','User'));
			$this->data = $this->ProductSearchtag->find('first',array('conditions'=>$conditions,'fields'=>array('ProductSearchtag.id','ProductSearchtag.user_id','ProductSearchtag.product_id','ProductSearchtag.tags','Product.id','Product.quick_code','Product.product_name','User.id','User.firstname','User.lastname','User.email')));
			$this->data['ProductSearchtag']['quick_code'] = $this->data['Product']['quick_code'];
			if(!empty($this->data['ProductSearchtag'])){
				foreach($this->data['ProductSearchtag'] as $field_index => $user_info){
					$this->data['ProductSearchtag'][$field_index] = html_entity_decode($user_info);
					$this->data['ProductSearchtag'][$field_index] = str_replace('&#039;',"'",$this->data['ProductSearchtag'][$field_index]);
				}
			}
			if(empty($this->data)){
				$this->redirect('searchtags');
			}
		}
	}

	/** 
	@function	:	admin_bulk_upload
	@description	:	to upload products from admin end
	@params		:	NULL
	@created	:	Nov  01,2010
	@credated by	:	
	**/
	function admin_bulk_upload(){
		Configure::write('debug',3);
		$this->layout='layout_admin';
		$this->set('listTitle',"Upload Products");
		$departments = $this->Common->getdepartments();
		$this->set('departments',$departments);
		$Products_all = '';
		$Products_uploaded = '';
		$Products_notuploaded = '';
		$skipped_header_row = '';
		if(!empty($this->data)){
			$this->Product->set($this->data);
			$sellerValidate = $this->Product->validates();
			if($this->data['Product']['sample_bulk_data']['name'] != '' ){
				$validationFlag = $this->File->validateCsvFile( $this->data['Product']['sample_bulk_data']['name'] );
				if( $validationFlag  == true ) {
					App::import('Model','ProductDetail');
					$this->ProductDetail = new ProductDetail;
					App::import('Model','ProductSearchtag');
					$this->ProductSearchtag = new ProductSearchtag;
					$this->set('form_posted' , true);
					$file = $this->data['Product']['sample_bulk_data']['tmp_name'];
					$skipped_rows = '';
					//ini_set('auto_detect_line_endings', true);
					$handle = fopen($file, 'r');
					//stream_get_line($handle, 4096, ",");
					$rowchek = fgetcsv($handle, 4096, ",");

					$columns_count = count($rowchek);

					$dept_id = $this->data['Product']['department_id'];
					switch ($dept_id) {
						case 1:
							if( $columns_count >= 22){ // is file is ok to upload
								$skipped_header_row = implode(', ', $rowchek);
								while (($row = fgetcsv($handle, 4096, ",")) !== FALSE) {
									$first_row_test  = strtoupper(trim($row[0]));
									$Products_all++;
									if((is_numeric(trim($row[2])) || is_float(trim($row[2]))) && (trim($row[3]) == 1 || trim($row[3]) == 0 ) && (is_numeric(trim($row[10])))  &&  (is_numeric(trim($row[15])) || is_float(trim($row[15])))  && (is_numeric(trim($row[16])) || is_float(trim($row[16])))  && (is_numeric(trim($row[17])) || is_float(trim($row[17])))  && (is_numeric(trim($row[18])) || is_float(trim($row[18]))) ) {
										$Products_uploaded++;
										$this->data['Product']['id'] = 0;
										$this->data['Product']['quick_code'] = '';
										$this->data['Product']['product_name'] = str_replace('||',',',trim($row[0]));
										$this->data['Product']['barcode'] = trim($row[1]);
										$this->data['Product']['product_rrp'] = trim($row[2]);
										$this->data['Product']['status'] = trim($row[3]);

										$imgfile = trim($row[4]);
										$img_file_name = explode('.',$imgfile);
										$img_file_name[0] = trim($img_file_name[0]);
										$img_file_name[0] = str_replace(' ','_',$img_file_name[0]);
										$img_file = $img_file_name[0].'.'.$img_file_name[1];
										
										$this->data['Product']['product_image'] = $img_file;
										$this->Product->set($this->data);
										//$this->Product->save();
										$this->data = Sanitize::clean($this->data);
										$this->Product->set($this->data);
										if(!$this->Product->save($this->data)){
											$skipped_rows .= implode(', ', $row);
											$skipped_rows .= "\n";
											$Products_notuploaded++;
											continue;
										} else{
											$product_id = $this->Product->getLastInsertID();
											if($this->data['Product']['status'] == 1){
												$this->data['ProductSearchtag']['status'] = 1;
											} else {
												$this->data['ProductSearchtag']['status'] = 0;
											}
												$this->data['ProductSearchtag']['id'] = 0;
												$this->data['ProductSearchtag']['user_id'] = -1;
												$this->data['ProductSearchtag']['product_id'] = $product_id;
												$this->data['ProductSearchtag']['tags'] = str_replace('||',',',trim($row[14]));
												$this->data = Sanitize::clean($this->data);
												$this->ProductSearchtag->set($this->data);
												$this->ProductSearchtag->save($this->data);
											$this->data['ProductDetail']['id'] = 0;
											$quickCode = $this->Product->generateQuickCode($product_id,$dept_id);
											$quickCode = $this->updateQuickCode($product_id,$quickCode );
											// ends update quick code section
											$this->data['ProductDetail']['product_id'] = $product_id;
											$this->data['ProductDetail']['author_name'] = str_replace('||',',',trim($row[5]));
											$this->data['ProductDetail']['publisher'] = str_replace('||',',',trim($row[6]));
											$this->data['ProductDetail']['language'] = str_replace('||',',',trim($row[7]));
											$this->data['ProductDetail']['product_isbn'] = trim($row[8]);
											$this->data['ProductDetail']['format'] = str_replace('||',',',trim($row[9]));
											$this->data['ProductDetail']['pages'] = str_replace('||',',',trim($row[10]));
											$this->data['ProductDetail']['publisher_review'] = trim($row[11]);
											$this->data['ProductDetail']['year_published'] = trim($row[12]);
											$this->data['ProductDetail']['description'] = str_replace('||',',',trim($row[13]));
											$this->data['ProductDetail']['product_searchtag'] = str_replace('||',',',trim($row[14]));
											$this->data['ProductDetail']['product_weight'] = str_replace('||',',',trim($row[15]));
											$this->data['ProductDetail']['product_height'] = str_replace('||',',',trim($row[16]));
											$this->data['ProductDetail']['product_length'] = trim($row[17]);
											$this->data['ProductDetail']['product_width'] = str_replace('||',',',trim($row[18]));
											$this->data['ProductDetail']['meta_title'] = str_replace('||',',',trim($row[19]));
											$this->data['ProductDetail']['meta_keywords'] = str_replace('||',',',trim($row[20]));
											$this->data['ProductDetail']['meta_description'] = str_replace('||',',',trim($row[21]));
											$this->data = Sanitize::clean($this->data);
											$this->ProductDetail->set($this->data);
											if(!$this->ProductDetail->save($this->data)){
												$skipped_rows .= implode(', ', $row);
												$skipped_rows .= "\n";
												$Products_notuploaded++;
												continue;
											} else{
												
											}
										}
									} else {
										$skipped_rows .= implode(', ', $row);
										$skipped_rows .= "\n";
										$Products_notuploaded++;
										continue;
									}
								}
		
								if($skipped_rows != ''){ // set the skipped rows data
									$skipped_file_contents  = $skipped_header_row;
									$skipped_file_contents  .= "\n";
									$skipped_file_contents .= $skipped_rows;	
									$errorFileName = "Failed_".str_replace(" ", "_", $this->data['Product']['sample_bulk_data']['name']);
									$filename = WWW_ROOT."files/error_files/".$errorFileName;
									$fp = fopen($filename, "w+");
									fwrite($fp, $skipped_file_contents);
								}
								$uploadStatus['all_products'] = $Products_all;
								$uploadStatus['uploaded_products'] = $Products_uploaded;
								$uploadStatus['notuploaded_products'] = $Products_notuploaded;
								$this->Session->write('upload_status' ,$uploadStatus );
								if(!empty($errorFileName)){
									$this->Session->setFlash('Some records are not in proper format please recheck this file to download <a href="'.SITE_URL.'products/download_error_bulk_files/'.$errorFileName.'">click here!</a>', 'default', array( 'class'=>'flashError') );
									$this->redirect('/admin/products/bulk_upload');
									$errorFileName = base64_encode($errorFileName);
								} else{
									$this->Session->setFlash('Records uploaded successfully.');
								}
							} else{
								$this->Session->setFlash('Selected file is not in proper format.please check the file columns !', 'default', array( 'class'=>'flashError') );
							}
						break;
						case 2:
							if( $columns_count >= 21){ // is file is ok to upload
								$skipped_header_row = implode(', ', $rowchek);
								while (($row = fgetcsv($handle, 4096, ",")) !== FALSE) {
									$first_row_test  = strtoupper(trim($row[0]));
									$Products_all++;
									if((is_numeric(trim($row[2])) || is_float(trim($row[2]))) && (trim($row[3]) == 1 || trim($row[3]) == 0 ) && (is_numeric(trim($row[8])))  && (is_numeric(trim($row[9])))  &&  (is_numeric(trim($row[14])) || is_float(trim($row[14])))  && (is_numeric(trim($row[15])) || is_float(trim($row[15])))  && (is_numeric(trim($row[16])) || is_float(trim($row[16])))  && (is_numeric(trim($row[17])) || is_float(trim($row[17]))) ) {
										$Products_uploaded++;
										$this->data['Product']['id'] = 0;
										$this->data['Product']['quick_code'] = '';
										$this->data['Product']['product_name'] = $this->data['ProductDetail']['description'] = str_replace('||',',',trim($row[0]));
										$this->data['Product']['barcode'] = trim($row[1]);
										$this->data['Product']['product_rrp'] = trim($row[2]);
										$this->data['Product']['status'] = trim($row[3]);
										$imgfile = trim($row[4]);
										$img_file_name = explode('.',$imgfile);
										$img_file_name[0] = trim($img_file_name[0]);
										$img_file_name[0] = str_replace(' ','_',$img_file_name[0]);
										$img_file = $img_file_name[0].'.'.$img_file_name[1];
										$this->data['Product']['product_image'] = $img_file;

										$this->data = Sanitize::clean($this->data);
										$this->Product->set($this->data);
										if(!$this->Product->save($this->data)){
											$skipped_rows .= implode(', ', $row);
											$skipped_rows .= "\n";
											$Products_notuploaded++;
											continue;
										} else{
											$product_id = $this->Product->getLastInsertID();
											$product_id = $this->Product->getLastInsertID();
											if($this->data['Product']['status'] == 1){
												$this->data['ProductSearchtag']['status'] = 1;
											} else {
												$this->data['ProductSearchtag']['status'] = 1;
											}
											$this->data['ProductSearchtag']['id'] = 0;
											$this->data['ProductSearchtag']['user_id'] = -1;
											$this->data['ProductSearchtag']['product_id'] = $product_id;
											$this->data['ProductSearchtag']['tags'] = str_replace('||',',',trim($row[14]));
											$this->ProductSearchtag->set($this->data);
											$this->ProductSearchtag->save($this->data);
											$this->data['ProductDetail']['id'] = 0;
											$quickCode = $this->Product->generateQuickCode($product_id,$this->data['Product']['department_id'] );
											$quickCode = $this->updateQuickCode($product_id,$quickCode );
											// ends update quick code section
											$this->data['ProductDetail']['product_id'] = $product_id;
											$this->data['ProductDetail']['artist_name'] = str_replace('||',',',trim($row[5]));
											$this->data['ProductDetail']['label'] = str_replace('||',',',trim($row[6]));
											$this->data['ProductDetail']['format'] = str_replace('||',',',trim($row[7]));
											$this->data['ProductDetail']['rated'] = trim($row[8]);
											$this->data['ProductDetail']['number_of_disk'] = trim($row[9]);
											$this->data['ProductDetail']['track_list'] = str_replace('||',',',trim($row[10]));
											$this->data['ProductDetail']['description'] = str_replace('||',',',trim($row[11]));
											if(!empty($row[12])){
												$date_array = explode('/',trim($row[12]));
												$new_date = $date_array[2].'-'.$date_array[1].'-'.$date_array[0];
												
											}
											$this->data['ProductDetail']['release_date'] = $new_date;
											$this->data['ProductDetail']['product_searchtag'] = str_replace('||',',',trim($row[13]));
											$this->data['ProductDetail']['product_weight'] = trim($row[14]);
											$this->data['ProductDetail']['product_height'] = trim($row[15]);
											$this->data['ProductDetail']['product_length'] = trim($row[16]);
											$this->data['ProductDetail']['product_width'] = trim($row[17]);
											$this->data['ProductDetail']['meta_title'] = str_replace('||',',',trim($row[18]));
											$this->data['ProductDetail']['meta_keywords'] = str_replace('||',',',trim($row[19]));
											$this->data['ProductDetail']['meta_description'] = str_replace('||',',',trim($row[20]));
											$this->ProductDetail->set($this->data);
											if(!$this->ProductDetail->save($this->data)){
												$skipped_rows .= implode(', ', $row);
												$skipped_rows .= "\n";
												$Products_notuploaded++;
												continue;
											} else{
												
											}
										}
									} else {
										$skipped_rows .= implode(', ', $row);
										$skipped_rows .= "\n";
										$Products_notuploaded++;
										continue;
									}
									
								}
								if($skipped_rows != ''){ // set the skipped rows data
									$skipped_file_contents  = $skipped_header_row;
									$skipped_file_contents  .= "\n";
									$skipped_file_contents .= $skipped_rows;	
									$errorFileName = "Failed_".str_replace(" ", "_", $this->data['Product']['sample_bulk_data']['name']);
									$filename = WWW_ROOT."files/error_files/".$errorFileName;
									$fp = fopen($filename, "w+");
									fwrite($fp, $skipped_file_contents);
								}
								$uploadStatus['all_products']     	= $Products_all;
								$uploadStatus['uploaded_products']	= $Products_uploaded;
								$uploadStatus['notuploaded_products']	= $Products_notuploaded;
								$this->Session->write('upload_status' ,$uploadStatus );
								if(!empty($errorFileName)){
									$this->Session->setFlash('Some records are not in proper format please recheck this file to download <a href="'.SITE_URL.'products/download_error_bulk_files/'.$errorFileName.'">click here!</a>', 'default', array( 'class'=>'flashError') );
									$this->redirect('/admin/products/bulk_upload');
									$errorFileName = base64_encode($errorFileName);
								} else{
									$this->Session->setFlash('Records uploaded successfully.');
									$this->redirect('/admin/products/bulk_upload');
								}
							} else{
								$this->Session->setFlash('Selected file is not in proper format.please check the file columns !', 'default', array( 'class'=>'flashError') );
							}
						break;
						case 3:
							if( $columns_count >= 23){ // is file is ok to upload
								$skipped_header_row = implode(', ', $rowchek);
								while (($row = fgetcsv($handle, 4096, ",")) !== FALSE) {
									$Products_all++;
									if((is_numeric(trim($row[2])) || is_float(trim($row[2]))) && (trim($row[3]) == 1 || trim($row[3]) == 0 ) && (is_numeric(trim($row[8])))  &&  (is_numeric(trim($row[16])) || is_float(trim($row[16]))) && (is_numeric(trim($row[17])) || is_float(trim($row[17])))  && (is_numeric(trim($row[18])) || is_float(trim($row[18])))  && (is_numeric(trim($row[19])) || is_float(trim($row[19]))) ) {
										$Products_uploaded++;
										$this->data['Product']['id'] = 0;
										$this->data['Product']['quick_code'] = '';
										$this->data['Product']['product_name'] = str_replace('||',',',trim($row[0]));
										$this->data['Product']['barcode'] = trim($row[1]);
										$this->data['Product']['product_rrp'] = trim($row[2]);
										$this->data['Product']['status'] = trim($row[3]);
										$imgfile = trim($row[4]);
										$img_file_name = explode('.',$imgfile);
										$img_file_name[0] = trim($img_file_name[0]);
										$img_file_name[0] = str_replace(' ','_',$img_file_name[0]);
										$img_file = $img_file_name[0].'.'.$img_file_name[1];
										$this->data['Product']['product_image'] = $img_file;
										$this->Product->set($this->data);
										if(!$this->Product->save($this->data)){
											$skipped_rows .= implode(', ', $row);
											$skipped_rows .= "\n";
											$Products_notuploaded++;
											continue;
										} else{
											$product_id = $this->Product->getLastInsertID();
											if($this->data['Product']['status'] == 1){
												$this->data['ProductSearchtag']['status'] = 1;
											} else {
												$this->data['ProductSearchtag']['status'] = 0;
											}
											$this->data['ProductSearchtag']['id'] = 0;
											$this->data['ProductSearchtag']['user_id'] = -1;
											$this->data['ProductSearchtag']['product_id'] = $product_id;
											$this->data['ProductSearchtag']['tags'] = str_replace('||',',',trim($row[15]));
											$this->ProductSearchtag->set($this->data);
											$this->ProductSearchtag->save($this->data);
											$this->data['ProductDetail']['id'] = 0;
											$quickCode = $this->Product->generateQuickCode($product_id,$this->data['Product']['department_id'] );
											$quickCode = $this->updateQuickCode($product_id,$quickCode );
											// ends update quick code section
											$this->data['ProductDetail']['product_id'] = $product_id;
											$this->data['ProductDetail']['star_name'] = str_replace('||',',',trim($row[5]));
											$this->data['ProductDetail']['directedby'] = str_replace('||',',',trim($row[6]));
											$this->data['ProductDetail']['format'] = trim($row[7]);
											$this->data['ProductDetail']['number_of_disk'] = trim($row[8]);
											$this->data['ProductDetail']['rated'] = trim($row[9]);
											$this->data['ProductDetail']['language'] = str_replace('||',',',trim($row[10]));
											$this->data['ProductDetail']['studio'] = str_replace('||',',',trim($row[11]));
											if(!empty($row[12])){
												$date_array = explode('/',trim($row[12]));
												$new_date = $date_array[2].'-'.$date_array[1].'-'.$date_array[0];
											}
											$this->data['ProductDetail']['release_date'] = $new_date;
											$this->data['ProductDetail']['run_time'] = trim($row[13]);
											$this->data['ProductDetail']['description'] = str_replace('||',',',trim($row[14]));
											$this->data['ProductDetail']['product_searchtag'] = str_replace('||',',',trim($row[15]));
											$this->data['ProductDetail']['product_weight'] = str_replace('||',',',trim($row[16]));
											$this->data['ProductDetail']['product_height'] = trim($row[17]);
											$this->data['ProductDetail']['product_width'] = str_replace('||',',',trim($row[18]));
											$this->data['ProductDetail']['product_length'] = str_replace('||',',',trim($row[19]));
											$this->data['ProductDetail']['meta_title'] = str_replace('||',',',trim($row[20]));
											$this->data['ProductDetail']['meta_keywords'] = str_replace('||',',',trim($row[21]));
											$this->data['ProductDetail']['meta_description'] = str_replace('||',',',trim($row[22]));
											$this->ProductDetail->set($this->data);
											if(!$this->ProductDetail->save($this->data)){
												$skipped_rows .= implode(', ', $row);
												$skipped_rows .= "\n";
												$Products_notuploaded++;
												continue;
											} else{
											}
										}
									} else {
										$skipped_rows .= implode(', ', $row);
										$skipped_rows .= "\n";
										$Products_notuploaded++;
										continue;
									}
								}
		
								if($skipped_rows != ''){ // set the skipped rows data
									$skipped_file_contents  = $skipped_header_row;
									$skipped_file_contents  .= "\n";
									$skipped_file_contents .= $skipped_rows;	
									$errorFileName = "Failed_".str_replace(" ", "_", $this->data['Product']['sample_bulk_data']['name']);
									$filename = WWW_ROOT."files/error_files/".$errorFileName;
									$fp = fopen($filename, "w+");
									fwrite($fp, $skipped_file_contents);
								}
								$uploadStatus['all_products']     	= $Products_all;
								$uploadStatus['uploaded_products']	= $Products_uploaded;
								$uploadStatus['notuploaded_products']	= $Products_notuploaded;
								$this->Session->write('upload_status' ,$uploadStatus );
								if(!empty($errorFileName)){
									$this->Session->setFlash('Some records are not in proper format please recheck this file to download <a href="'.SITE_URL.'products/download_error_bulk_files/'.$errorFileName.'">click here!</a>', 'default', array( 'class'=>'flashError') );
									$this->redirect('/admin/products/bulk_upload');
									$errorFileName = base64_encode($errorFileName);
								} else{
									$this->Session->setFlash('Records uploaded successfully.');
									$this->redirect('/admin/products/bulk_upload');
								}
							} else{
								$this->Session->setFlash('Selected file is not in proper format.please check the file columns !', 'default', array( 'class'=>'flashError') );
							}
						break;
						case 4:
							if( $columns_count >= 18){ // is file is ok to upload
								$skipped_header_row = implode(', ', $rowchek);
								while (($row = fgetcsv($handle, 4096, ",")) !== FALSE) {
									$Products_all++;
									if((is_numeric(trim($row[2])) || is_float(trim($row[2]))) && (trim($row[3]) == 1 || trim($row[3]) == 0 ) && (is_numeric(trim($row[11])) || is_float(trim($row[11])))  && (is_numeric(trim($row[12])) || is_float(trim($row[12])))  && (is_numeric(trim($row[13])) || is_float(trim($row[13])))  && (is_numeric(trim($row[14])) || is_float(trim($row[14]))) ) {
										$Products_uploaded++;
										$this->data['Product']['id'] = 0;
										$this->data['Product']['quick_code'] = '';
										$this->data['Product']['product_name'] = str_replace('||',',',trim($row[0]));
										$this->data['Product']['barcode'] = trim($row[1]);
										$this->data['Product']['product_rrp'] = trim($row[2]);
										$this->data['Product']['status'] = trim($row[3]);

$imgfile = trim($row[4]);
$img_file_name = explode('.',$imgfile);
$img_file_name[0] = trim($img_file_name[0]);
$img_file_name[0] = str_replace(' ','_',$img_file_name[0]);
$img_file = $img_file_name[0].'.'.$img_file_name[1];

$this->data['Product']['product_image'] = $img_file;
										$this->Product->set($this->data);
										if(!$this->Product->save($this->data)){
											$skipped_rows .= implode(', ', $row);
											$skipped_rows .= "\n";
											$Products_notuploaded++;
											continue;
										} else{
											$product_id = $this->Product->getLastInsertID();
											$product_id = $this->Product->getLastInsertID();
											if($this->data['Product']['status'] == 1){
												$this->data['ProductSearchtag']['status'] = 1;
											} else{
												$this->data['ProductSearchtag']['status'] = 0;
											}
											$this->data['ProductSearchtag']['id'] = 0;
											$this->data['ProductSearchtag']['user_id'] = -1;
											$this->data['ProductSearchtag']['product_id'] = $product_id;
											$this->data['ProductSearchtag']['tags'] = str_replace('||',',',trim($row[14]));
											
											$this->ProductSearchtag->set($this->data);
											$this->ProductSearchtag->save($this->data);
											
											
											$this->data['ProductDetail']['id'] = 0;
											$quickCode = $this->Product->generateQuickCode($product_id,$this->data['Product']['department_id'] );
											$quickCode = $this->updateQuickCode($product_id,$quickCode );
											// ends update quick code section
											$this->data['ProductDetail']['product_id'] = $product_id;
											$this->data['ProductDetail']['plateform'] = str_replace('||',',',trim($row[5]));
											$this->data['ProductDetail']['rated'] = trim($row[6]);
											if(!empty($row[7])){
												$date_array = explode('/',trim($row[7]));
												$new_date = $date_array[2].'-'.$date_array[1].'-'.$date_array[0];
												
											}
											$this->data['ProductDetail']['release_date'] = $new_date;
											$this->data['ProductDetail']['description'] = str_replace('||',',',trim($row[8]));
											$this->data['ProductDetail']['region'] = str_replace('||',',',trim($row[9]));
											$this->data['ProductDetail']['product_searchtag'] = str_replace('||',',',trim($row[10]));
											$this->data['ProductDetail']['product_weight'] = trim($row[11]);
											$this->data['ProductDetail']['product_height'] = trim($row[12]);
											$this->data['ProductDetail']['product_width'] = trim($row[13]);
											$this->data['ProductDetail']['product_length'] = trim($row[14]);
											$this->data['ProductDetail']['meta_title'] = str_replace('||',',',trim($row[15]));
											$this->data['ProductDetail']['meta_keywords'] = str_replace('||',',',trim($row[16]));
											$this->data['ProductDetail']['meta_description'] = str_replace('||',',',trim($row[17]));
											$this->ProductDetail->set($this->data);
											if(!$this->ProductDetail->save($this->data)){
												$skipped_rows .= implode(', ', $row);
												$skipped_rows .= "\n";
												$Products_notuploaded++;
												continue;
											} else{
												
											}
										}
									} else {
										$skipped_rows .= implode(', ', $row);
										$skipped_rows .= "\n";
										$Products_notuploaded++;
										continue;
									}
								}
		
								if($skipped_rows != ''){  //set the skipped rows
									$skipped_file_contents  = $skipped_header_row;
									$skipped_file_contents  .= "\n";
									$skipped_file_contents .= $skipped_rows;	
									$errorFileName = "Failed_".str_replace(" ", "_", $this->data['Product']['sample_bulk_data']['name']);
									$filename = WWW_ROOT."files/error_files/".$errorFileName;
									$fp = fopen($filename, "w+");
									fwrite($fp, $skipped_file_contents);
								}
								$uploadStatus['all_products']     	= $Products_all;
								$uploadStatus['uploaded_products']	= $Products_uploaded;
								$uploadStatus['notuploaded_products']	= $Products_notuploaded;
								$this->Session->write('upload_status' ,$uploadStatus );
								if(!empty($errorFileName)){
									$this->Session->setFlash('Some records are not in proper format please recheck this file to download <a href="'.SITE_URL.'products/download_error_bulk_files/'.$errorFileName.'">click here!</a>', 'default', array( 'class'=>'flashError') );
									$this->redirect('/admin/products/bulk_upload');
									$errorFileName = base64_encode($errorFileName);
								} else{
									$this->Session->setFlash('Records uploaded successfully.');
									$this->redirect('/admin/products/bulk_upload');
								}
							} else{
								$this->Session->setFlash('Selected file is not in proper format.please check the file columns !', 'default', array( 'class'=>'flashError') );
							}
						break;
						case 5:
						case 6:
						case 7:
						case 8:
							if( $columns_count >= 17){ // is file is ok to upload
								$skipped_header_row = implode(', ', $rowchek);
								while (($row = fgetcsv($handle, 4096, ",")) !== FALSE) {
									$Products_all++;
										if((is_numeric(trim($row[2])) || is_float(trim($row[2]))) && (trim($row[3]) == 1 || trim($row[3]) == 0 ) && (is_numeric(trim($row[5])))  && (is_numeric(trim($row[9])) || is_float(trim($row[9])))  &&(is_numeric(trim($row[10])) || is_float(trim($row[10])))  && (is_numeric(trim($row[11])) || is_float(trim($row[11])))  && (is_numeric(trim($row[12])) || is_float(trim($row[12])))  /*&& (is_numeric(trim($row[13])) || is_float(trim($row[13])))*/  ) {
										$Products_uploaded++;
										$this->data['Product']['id'] = 0;
										
										$this->data['Product']['quick_code'] = '';
										$this->data['Product']['product_name'] = str_replace('||',',',trim($row[0]));
										$this->data['Product']['barcode'] = trim($row[1]);
										$this->data['Product']['product_rrp'] = trim($row[2]);
										$this->data['Product']['status'] = trim($row[3]);
										
										
										$imgfile = trim($row[4]);
										$img_file_name = explode('.',$imgfile);
										$img_file_name[0] = trim($img_file_name[0]);
										$img_file_name[0] = str_replace(' ','_',$img_file_name[0]);
										$img_file = $img_file_name[0].'.'.$img_file_name[1];
										
										$this->data['Product']['product_image'] = $img_file;
										$this->data['Product']['brand_id'] = trim($row[5]);
										$this->data['Product']['model_number'] = trim($row[6]);
										$this->Product->set($this->data);
										
										if(!$this->Product->save($this->data)){
											$skipped_rows .= implode(', ', $row);
											$skipped_rows .= "\n";
											$Products_notuploaded++;
											continue;
										} else{
											$product_id = $this->Product->getLastInsertID();
											$product_id = $this->Product->getLastInsertID();
											if($this->data['Product']['status'] == 1){
												$this->data['ProductSearchtag']['status'] = 1;
											} else {
												$this->data['ProductSearchtag']['status'] = 0;
											}
											$this->data['ProductSearchtag']['id'] = 0;
											$this->data['ProductSearchtag']['user_id'] = -1;
											$this->data['ProductSearchtag']['product_id'] = $product_id;
											$this->data['ProductSearchtag']['tags'] = str_replace('||',',',trim($row[8]));
											$this->ProductSearchtag->set($this->data);
											$this->ProductSearchtag->save($this->data);
												
												
												
											$this->data['ProductDetail']['id'] = 0;
											$quickCode = $this->Product->generateQuickCode($product_id,$this->data['Product']['department_id'] );
											$quickCode = $this->updateQuickCode($product_id,$quickCode );
											// ends update quick code section
											$this->data['ProductDetail']['product_id'] = $product_id;
											$this->data['ProductDetail']['product_weight'] = trim($row[9]);
											$this->data['ProductDetail']['product_height'] = trim($row[10]);
											$this->data['ProductDetail']['product_width'] = trim($row[11]);
											$this->data['ProductDetail']['product_length'] = trim($row[12]);
											$this->data['ProductDetail']['description'] = str_replace('||',',',trim($row[7]));
											$this->data['ProductDetail']['technical_details'] = str_replace('||',',',trim($row[13]));
											$this->data['ProductDetail']['product_searchtag'] = trim(str_replace('||',',',$row[8]));
											$this->data['ProductDetail']['meta_title'] = str_replace('||',',',trim($row[14]));
											$this->data['ProductDetail']['meta_keywords'] = str_replace('||',',',trim($row[15]));
											$this->data['ProductDetail']['meta_description'] = str_replace('||',',',trim($row[16]));

											$this->ProductDetail->set($this->data);
											if(!$this->ProductDetail->save($this->data)){
												$skipped_rows .= implode(', ', $row);
												$skipped_rows .= "\n";
												$Products_notuploaded++;
												continue;
											} else{
												
											}
										}
									} else {
										$skipped_rows .= implode(', ', $row);
										$skipped_rows .= "\n";
										$Products_notuploaded++;
										continue;
									}
								}
		
								if($skipped_rows != ''){ // set the skipped rows data
									$skipped_file_contents  = $skipped_header_row;
									$skipped_file_contents  .= "\n";
									$skipped_file_contents .= $skipped_rows;	
									$errorFileName = "Failed_".str_replace(" ", "_", $this->data['Product']['sample_bulk_data']['name']);
									$filename = WWW_ROOT."files/error_files/".$errorFileName;
									$fp = fopen($filename, "w+");
									fwrite($fp, $skipped_file_contents);
								}
								$uploadStatus['all_products']     	= $Products_all;
								$uploadStatus['uploaded_products']	= $Products_uploaded;
								$uploadStatus['notuploaded_products']	= $Products_notuploaded;
								$this->Session->write('upload_status' ,$uploadStatus );
								if(!empty($errorFileName)){
									$this->Session->setFlash('Some records are not in proper format please recheck this file to download <a href="'.SITE_URL.'products/download_error_bulk_files/'.$errorFileName.'">click here!</a>', 'default', array( 'class'=>'flashError') );
									$this->redirect('/admin/products/bulk_upload');
									$errorFileName = base64_encode($errorFileName);
								} else{
									$this->Session->setFlash('Records uploaded successfully.');
									$this->redirect('/admin/products/bulk_upload');
								}
							} else{
								$this->Session->setFlash('Selected file is not in proper format.please check the file columns !', 'default', array( 'class'=>'flashError') );
							}
						break;
						case 9:
							//echo $columns_count;
							if( $columns_count == 17){ // is file is ok to upload
								$skipped_header_row = implode(', ', $rowchek);
								$row_val = 1;
								while (($row = fgetcsv($handle, 4096, ",")) !== FALSE) {
									$Products_all++;
									//echo $row_val;
									if(!empty($row)){
										foreach($row as $row_index=>$row_data){
											$row[$row_index] = str_replace('\r\n','`',$row_data);
										}
									}
									//pr($row); //echo (strlen($row[16]));
									//echo '<hr>';
									$row_val++;
									if((is_numeric(trim($row[2])) || is_float(trim($row[2]))) && (trim($row[3]) == 1 || trim($row[3]) == 0 ) && (is_numeric(trim($row[5])))  &&  (is_numeric(trim($row[11])) || is_float(trim($row[11])))  && (is_numeric(trim($row[12])) || is_float(trim($row[12])))  && (is_numeric(trim($row[13])) || is_float(trim($row[13]))) ) {
										$Products_uploaded++;
										$this->data['Product']['id'] = 0;
										$this->data['Product']['quick_code'] = '';
										$this->data['Product']['product_name'] = str_replace('||',',',trim($row[0]));
										$this->data['Product']['barcode'] = trim($row[1]);
										$this->data['Product']['product_rrp'] = trim($row[2]);
										$this->data['Product']['status'] = trim($row[3]);

$imgfile = trim($row[4]);
$img_file_name = explode('.',$imgfile);
$img_file_name[0] = trim($img_file_name[0]);
$img_file_name[0] = str_replace(' ','_',$img_file_name[0]);
$img_file = $img_file_name[0].'.'.$img_file_name[1];

$this->data['Product']['product_image'] = $img_file;
										
										$this->data['Product']['brand_id'] = trim($row[5]);
										$this->data['Product']['model_number'] = trim($row[6]);
										$this->Product->set($this->data);
										if(!$this->Product->save($this->data)){
											$skipped_rows .= implode(', ', $row);
											$skipped_rows .= "\n";
											$Products_notuploaded++;
											continue;
										} else{
											$product_id = $this->Product->getLastInsertID();
											if($this->data['Product']['status'] == 1){
												$this->data['ProductSearchtag']['status'] = 1;
											} else {
												$this->data['ProductSearchtag']['status'] = 0;
											}
											$this->data['ProductSearchtag']['id'] = 0;
											$this->data['ProductSearchtag']['user_id'] = -1;
											$this->data['ProductSearchtag']['product_id'] = $product_id;
											$this->data['ProductSearchtag']['tags'] = str_replace('||',',',trim($row[10]));
											$this->ProductSearchtag->set($this->data);
											$this->ProductSearchtag->save($this->data);
											$this->data['ProductDetail']['id'] = 0;
											$quickCode = $this->Product->generateQuickCode($product_id,$this->data['Product']['department_id'] );
											$quickCode = $this->updateQuickCode($product_id,$quickCode );
											// ends update quick code section
											$this->data['ProductDetail']['id'] = 0;
											$this->data['ProductDetail']['product_id'] = $product_id;
											$this->data['ProductDetail']['description'] = str_replace('||',',',trim($row[8]));
											$this->data['ProductDetail']['technical_details'] = str_replace('||',',',trim($row[9]));
											$this->data['ProductDetail']['product_searchtag'] = str_replace('||',',',trim($row[10]));
											$this->data['ProductDetail']['product_weight'] = trim($row[7]);
											$this->data['ProductDetail']['product_height'] = trim($row[11]);
											$this->data['ProductDetail']['product_width'] = trim($row[12]);
											$this->data['ProductDetail']['product_length'] = trim($row[13]);
											$this->data['ProductDetail']['meta_title'] = str_replace('||',',',trim($row[14]));
											$this->data['ProductDetail']['meta_keywords'] = str_replace('||',',',trim($row[15]));
											$this->data['ProductDetail']['meta_description'] = str_replace('||',',',trim($row[16]));
											$this->ProductDetail->set($this->data);
											if(!$this->ProductDetail->save($this->data)){
												$skipped_rows .= implode(', ', $row);
												$skipped_rows .= "\n";
												$Products_notuploaded++;
												continue;
											} else{
												
											}
										}
									} else {
										$skipped_rows .= implode(', ', $row);
										$skipped_rows .= "\n";
										$Products_notuploaded++;
										continue;
									}
								}
								if($skipped_rows != ''){ // set the skipped rows data
									$skipped_file_contents  = $skipped_header_row;
									$skipped_file_contents  .= "\n";
									$skipped_file_contents .= $skipped_rows;	
									$errorFileName = "Failed_".str_replace(" ", "_", $this->data['Product']['sample_bulk_data']['name']);
									$filename = WWW_ROOT."files/error_files/".$errorFileName;
									$fp = fopen($filename, "w+");
									fwrite($fp, $skipped_file_contents);
								}
								$uploadStatus['all_products']     	= $Products_all;
								$uploadStatus['uploaded_products']	= $Products_uploaded;
								$uploadStatus['notuploaded_products']	= $Products_notuploaded;
								$this->Session->write('upload_status' ,$uploadStatus );
								
								if(!empty($errorFileName)){
									$this->Session->setFlash('Some records are not in proper format please recheck this file to download <a href="'.SITE_URL.'products/download_error_bulk_files/'.$errorFileName.'">click here!</a>', 'default', array( 'class'=>'flashError') );
									//$this->redirect('/admin/products/bulk_upload');
									$errorFileName = base64_encode($errorFileName);
								} else{
									$this->Session->setFlash('Records uploaded successfully.');
								}
							} else{
								$this->Session->setFlash('Selected file is not in proper format.please check the file columns !', 'default', array( 'class'=>'flashError') );
							}
						break;
					}
					
				} else{
					$this->Session->setFlash('Select only csv file to upload !', 'default', array( 'class'=>'flashError') );
				}
			} else {
				$this->Session->setFlash('Please select a file to upload !', 'default', array( 'class'=>'flashError') );
			}
		} else{
			
		}
	}




	
	/** 
	@function : admin_upload_images
	@description : to upload images from temp folder to products folder for bulk uploaded products
	@Created by : Ramanpreet Pal Kaur
	@params : order item id and users id
	@Modify : 11 April, 2011
	@Created Date : 11 April, 2011
	*/
	function admin_upload_images() {
		set_time_limit(0);
		ini_set('memory_limit','999999M');
		$original_image_dir = WWW_ROOT.'ftp_bulk_images/';
		if(!($dp = opendir($original_image_dir))) die("Cannot open $original_image_dir.");
		$count1 = 1;
		while($file = readdir($dp)) {
			$count1++;
			if($file != '.' && $file != '..')  {
				$file_name = explode('.',$file);
				$file_name[0] = trim($file_name[0]);
				$file_name[0] = str_replace(' ','_',$file_name[0]);
				$file_uploadimage_name = $file_name[0].'.'.$file_name[1];
				$product_image = $this->Product->find('first',array('conditions'=>array('Product.product_image' =>$file_uploadimage_name)));
				if(!empty($product_image)){
					$this->File->destPath =  WWW_ROOT.PATH_PRODUCT;
					$mime ='';
					@copy($original_image_dir.$file,$this->File->destPath.'large/img_400_'.$file_uploadimage_name);
					@copy($original_image_dir.$file,$this->File->destPath.'large/img_300_'.$file_uploadimage_name);
					$this->Thumb->getResized('img_400_'.$file_uploadimage_name, $mime, $this->File->destPath.'large/', 400, 400, 'FFFFFF', true, true,$this->File->destPath.'large/', false);
					$this->Thumb->getResized('img_300_'.$file_uploadimage_name, $mime, $this->File->destPath.'large/', 300, 300, 'FFFFFF', true, true,$this->File->destPath.'large/', false);
					@copy($original_image_dir.$file,$this->File->destPath.'medium/img_200_'.$file_uploadimage_name);
					@copy($original_image_dir.$file,$this->File->destPath.'medium/img_150_'.$file_uploadimage_name);
					@copy($original_image_dir.$file,$this->File->destPath.'medium/img_135_'.$file_uploadimage_name);
					@copy($original_image_dir.$file,$this->File->destPath.'medium/img_125_'.$file_uploadimage_name);
					$this->Thumb->getResized('img_200_'.$file_uploadimage_name, $mime, $this->File->destPath.'medium/', 200, 200, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
					$this->Thumb->getResized('img_150_'.$file_uploadimage_name, $mime, $this->File->destPath.'medium/', 150, 150, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
					$this->Thumb->getResized('img_135_'.$file_uploadimage_name, $mime, $this->File->destPath.'medium/', 135, 135, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
					$this->Thumb->getResized('img_125_'.$file_uploadimage_name, $mime, $this->File->destPath.'medium/', 125, 125, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
					@copy($original_image_dir.$file,$this->File->destPath.'small/img_100_'.$file_uploadimage_name);
					@copy($original_image_dir.$file,$this->File->destPath.'small/img_75_'.$file_uploadimage_name);
					@copy($original_image_dir.$file,$this->File->destPath.'small/img_50_'.$file_uploadimage_name);
					$this->Thumb->getResized('img_100_'.$file_uploadimage_name, $mime, $this->File->destPath.'small/', 100, 100, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
					$this->Thumb->getResized('img_75_'.$file_uploadimage_name, $mime, $this->File->destPath.'small/', 75, 75, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
					$this->Thumb->getResized('img_50_'.$file_uploadimage_name, $mime, $this->File->destPath.'small/', 50, 50, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
					$this->File->deleteFile_bulkupload($original_image_dir.$file);
				}
			}
		}
		closedir($dp);
		$this->redirect('/admin/products/bulk_upload');
	}


	/** 
	@function	:	admin_download_bulk_files
	@description	:	admin_download_bulk_files
	@params		:	NULL
	**/
	function download_sample_template($file_name){
		$filePath = WWW_ROOT."files/sample_template/".$file_name;
		$file_contents = file_get_contents($filePath) ;
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$file_name."");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $file_contents;
		exit;
	}

	/** 
	@function	:	admin_download_error_bulk_files
	@description	:	admin_download_bulk_files
	@params		:	NULL
	created : RAMANPREET PAL KAUR
	**/
	function admin_download_error_bulk_files($file_name = null){
		$filePath = WWW_ROOT."files/error_files/".$file_name;
		$file_contents = file_get_contents($filePath) ;
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$file_name."");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $file_contents;
		exit;
	}

	/** 
	@function	:	add_feedback
	@description	:	
	@params		:	NULL
	@created	:	Nov 12, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function ad_feedback($quick_code) {
		$this->layout = 'front_popup';
		$user = $this->Session->read('User');
		
		$this->set('quick_code', $quick_code);
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
					
				$quick_code = trim($this->data['Product']['quick_code']);
				$comments   = trim($this->data['Product']['comments']);
				$date_time = date('j M, Y H:i');
				$this->data = Sanitize::clean($this->data);
				$data = str_replace('[QCID]', $quick_code, $data);
				$data = str_replace('[DATE_TIME]', $date_time, $data);
				$data = str_replace('[COMMENTS]', $comments, $data);
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
			$this->redirect('/homes/index');
		}
	}
	
	/** 
	@function	:	play_video
	@description	:	
	@params		:	NULL
	@created	:	May 26,2011
	@credated by	:	Ramanpreet Pal
	**/
	function play_video($product_id = null){
		$this->layout = 'front_popup';
		$video_src = array();
		if(!empty($product_id)){
			$video_src = $this->Product->find('first',array('conditions'=>array('Product.id'=>$product_id),'fields'=>array('Product.product_video')));
		}
		$this->set('video_src',$video_src);
	}





	/** 
	@function	:	admin_bulk_upload_categories
	@description	:	to upload products from admin end
	@params		:	NULL
	@created	:	MAy 28,2011
	@credated by	:	Ramanpreet Pal
	**/
	function admin_bulk_upload_categories(){
		$this->layout='layout_admin';
		$this->set('listTitle',"Upload Products Categories");
		$Products_allcate = '';
		$Products_uploadedcate = '';
		$Products_notuploadedcate = '';
		$skipped_header_row = '';

		if(!empty($this->data)){
			$this->Product->set($this->data);
			if($this->data['Product']['sample_bulk_data_category']['name'] != '' ){
				$validationFlag = $this->File->validateCsvFile( $this->data['Product']['sample_bulk_data_category']['name'] );
				if( $validationFlag  == true ) {
					App::import('Model','ProductCategory');
					$this->ProductCategory = new ProductCategory;
					$this->set('form_posted' , true);
					$file = $this->data['Product']['sample_bulk_data_category']['tmp_name'];
					$skipped_rows = '';
					$handle = fopen($file, 'r');
					$rowchek = fgetcsv($handle, 4096, ",");
					$columns_count = count($rowchek);
					if($columns_count = 2){ // is file is ok to upload
						$skipped_header_row = implode(', ', $rowchek);
						while (($row = fgetcsv($handle, 4096, ",")) !== FALSE) {
							$first_row_test  = strtoupper(trim($row[0]));
							$Products_allcate++;
							if((is_numeric(trim($row[0]))) && (is_numeric(trim($row[1])))) {
								$Products_uploadedcate++;
									$this->data['ProductCategory']['id'] = 0;
									$this->data['ProductCategory']['product_id'] = trim($row[0]);
									$this->data['ProductCategory']['category_id'] = trim($row[1]);
									$this->ProductCategory->set($this->data);
									if(!$this->ProductCategory->save($this->data)){
										$skipped_rows .= implode(', ', $row);
										$skipped_rows .= "\n";
										$Products_notuploadedcate++;
										continue;
									} else{
									}
							} else {
								$skipped_rows .= implode(', ', $row);
								$skipped_rows .= "\n";
								$Products_notuploadedcate++;
								continue;
							}
									
						}
		
						if($skipped_rows != ''){ // set the skipped rows data
							$skipped_file_contents  = $skipped_header_row;
							$skipped_file_contents  .= "\n";
							$skipped_file_contents .= $skipped_rows;	
							$errorFileName = "Failed_".str_replace(" ", "_", $this->data['Product']['sample_bulk_data_category']['name']);
							$filename = WWW_ROOT."files/error_files/".$errorFileName;
								$fp = fopen($filename, "w+");
								fwrite($fp, $skipped_file_contents);
						}
						$uploadStatus['all_products'] = $Products_allcate;
						$uploadStatus['uploaded_products'] = $Products_uploadedcate;
						$uploadStatus['notuploaded_products'] = $Products_notuploadedcate;
						$this->Session->write('upload_status' ,$uploadStatus );
						if(!empty($errorFileName)){
							$errorFileName = base64_encode($errorFileName);
						} else{
						}
					} else{
						$this->Session->setFlash('Selected file is not in proper format.please check the file columns !', 'default', array( 'class'=>'flashError') );
					}
				} else{
					$this->Session->setFlash('Selected file is not in proper format.please check the file columns !', 'default', array( 'class'=>'flashError') );
				}
			} else{
				$this->Session->setFlash('Please select a file !', 'default', array( 'class'=>'flashError') );
			}
		}
	}



	/** 
	@function	:	admin_assign_departments
	@description	:	assign a product to multiple categories of different departments
	@params		:	NULL
	@created	:	June 15,2011
	@credated by	:	Ramanpreet Pal
	**/
	function admin_assign_departments($product_id = null){
		$this->set('product_id',$product_id); // product id in case of edit
		$this->layout = 'layout_admin';
		if(!empty($id)){
			$this->set('listTitle','Assign Multiple Departments');
		} else{
			$this->set('listTitle','Assign Multiple Departments');
		}
		// get Department ends array
		$departments_array = $this->getDepartments();
		$this->set('departments_array', $departments_array);
		App::import('Model', 'ProductCategory');
		$this->ProductCategory = new ProductCategory();
		App::import('Model', 'Category');
		$this->Category = new Category();

		if(!empty($this->data)){
			$data_array['ProductCategory'] = $this->data['ProductCategory'];
			$product_id = $this->data['Product']['id'];
			
			$this->data['ProductCategory']['product_id'] = $product_id;
			if(!empty($data_array['ProductCategory'])){
				if($this->ProductCategory->deleteAll(array('ProductCategory.product_id' => $product_id))){
					foreach($data_array['ProductCategory'] as $dept_index => $categories) {
						if(!empty($categories)){
							foreach($categories as $cat_id){
								$this->data['ProductCategory']['id'] = 0;
								$this->data['ProductCategory']['category_id'] = $cat_id;
								if($this->ProductCategory->save($this->data)){
									$saved_flag[] = 'saved';
								} else{
									$saved_flag[] = 'notsaved';
								}
							}
						}
					}
				} else {
					$saved_flag[] = 'notsaved';
				}
				//pr($saved_flag);
				if(in_array('notsaved',$saved_flag)){
					$this->Session->setFlash('All categories have not been saved successfully, please varify.','default',array('class'=>''));
					$this->redirect('/admin/products/assign_departments/'.$product_id);
				} else {
					$this->Session->setFlash('Product has been assigned to multiple departments successfully.','default',array('class'=>''));
					$this->redirect('/admin/products/');
				}
			}
		} else{
			$all_categories = $this->ProductCategory->find('list',array('conditions'=>array('ProductCategory.product_id'=>$product_id),'fields'=>array('ProductCategory.category_id')));
			//pr($all_categories);
			if(!empty($all_categories)){
				foreach($all_categories as $cat){
					$cat_departmentid = $this->Category->find('first',array('conditions'=>array('Category.id'=>$cat),'fields'=>array('Category.department_id')));
					if(!empty($cat_departmentid)) {
						$cat_departments_array[$cat_departmentid['Category']['department_id']][] = $cat;
					}
				}
			}
			ksort($cat_departments_array);
			$this->set('cat_departments_array',$cat_departments_array);
		}
	}


	/** 
	@function	:	get_departmentcategory
	@description	:	to open categories box on selection of a department
	@params		:	NULL
	@created	:	June 15,2011
	@credated by	:	Ramanpreet Pal
	**/
	function get_departmentcategory($id = null,$categories = null) {
		$department_id = $id;
		$this->set('department_id',$department_id);
		$categories_array = '';
		if(!empty($categories)){
			$categories_array = explode(',',$categories);
		}
		$departments = $this->getDepartments();
		$this->set('departments',$departments );
		$this->set('categories_array',$categories_array);
		if(!empty($department_id) ){ 
			App::import('Model', 'Category');
			$this->Category = new Category();
			$conditions = array('Category.parent_id = 0' , 'Category.department_id ='.$department_id);
			$dep_category_array = $this->Category->find('list', array('conditions'=>  $conditions,
				'fields'=>array('Category.id', 'Category.cat_name'),
				'order' => 'Category.cat_name ASC'
			) );
			$this->set('dep_category_array', $dep_category_array);
		} else{
		}
	}

	function sendEmailListing($url_data){
		
		$url_data = urldecode($url_data);
		$data = explode('~',$url_data);
		
		App::import('Model','User');
		$this->User = new User;
		$this->User->expects(array('Seller'));
		if(!empty($data[0]))
			$user_info = $this->User->find('first',array('conditions'=>array('User.id'=>@$data[0]),'fields'=>array('User.firstname','User.lastname','User.email','Seller.business_display_name')));
		

		$this->Email->smtpOptions = array(
		'host' => Configure::read('host'),
		'username' =>Configure::read('username'),
		'password' => Configure::read('password'),
		'timeout' => Configure::read('timeout')
		);

		$this->Email->sendAs= 'html';
		$link=Configure::read('siteUrl');
		$template = $this->Common->getEmailTemplate(20); // 20 to mail after activating his updated product
		$this->Email->from =$template['EmailTemplate']['from_email'];
		$email_data = $template['EmailTemplate']['description'];

		$email_data = str_replace('[SellersDisplayName]',$user_info['Seller']['business_display_name'],$email_data);
		$email_data = str_replace('[ItemName]','<a href='.SITE_URL.'categories/productdetail/'.@$data[1].'>'.@$data[2].'</a>',$email_data);

		################### Email Send  Scripts #####################
		
		$this->Email->subject = $template['EmailTemplate']['subject'];
		$this->Email->from = $template['EmailTemplate']['from_email'];
		$this->set('data',$email_data);
		
		$this->Email->to = @$user_info['User']['email'];
		/******import emailTemplate Model and get template****/
		$this->Email->template='commanEmailTemplate';
		
		
		
		$this->Email->send();
		################### Send Order Email Ends Here ###########################

	}

/**
 * Connects to fredhopper and stores the result in a global variable $FREDHOPPER_PAGE
 *
 * @param $query_string the string to query fredhopper with, eg brand<{nike}
 * 
 * The returned result is an xml soap object that contains all information needed to show facets, campaigns (or promotions), breadcrumbs and listers
 * More info on how to construct the $query_string:
 * - Understand the Fredhopper Query API: https://www.fredhopper.com/learningcenter/x/G4ax
 * - Fredhopper Query API reference: https://www.fredhopper.com/learningcenter/x/fgBy
 **/
function get_fredhopper_page($query_string){
	global $FREDHOPPER_PAGE;
	
	// Discover a Fredhopper Query Service
	$wsdl_location='http://82.165.37.158:9180/fredhopper-ws/services/FASWebService?wsdl';
	 
	// Create a new soap client
	$client = new SoapClient($wsdl_location);//, array('login'=>'username', 'passowrd'=>'password'));
	 
	// Build the query string
	$fh_location="fh_location=" . $query_string;
	 
	// Send the query string to the Fredhopper Query Server & obtain the result
	$FREDHOPPER_PAGE = $client->__soapCall('getAll', array('fh_params' => $fh_location));

	
}

/**
 * Returns the page_info object,
 * which is in /page/info
 * usage:
 * 		$page_info = get_page_info()
 * 		$page_info->query 
 * 		$page_info->view
 * 		$page_info->..
 * 		etc.
 *	When investigating all the possible attributes, try to run
 *  print_r($page)
 *	and view the source in firefox (it will give a nice overview of all available attributes)
 **/
function get_page_info(){
	global $FREDHOPPER_PAGE;	
	return $FREDHOPPER_PAGE->info;
}
	

/**
 * Returns all the facets of the fredhopper page 
 * The facets are in /universes/universe[type=selected]/facetmap
 *
 * Usage: $facetmap = get_facetmap()
 * 
 *
 **/
function get_facetmap(){
	global $FREDHOPPER_PAGE;
	foreach($FREDHOPPER_PAGE->universes->universe as $r) { // 
		if($r->{"type"} == "selected"){
			return $r->facetmap;
		}
	}
}
	


////////////////////////////////////////
/////////// EXAMPLES ///////////////////

function facetmap_example(){
	//global $FREDHOPPER_PAGE;
	//print_r($FREDHOPPER_PAGE);
	$facetmap = get_facetmap();
	foreach($facetmap->filter as $facet) {
		echo "<h2>Facet:" . $facet->title . "</h2>";
		echo "<h4>Custom fields:</h4>";
		//print_r($facet->{custom-fields});
		foreach($facet->{"custom-fields"}->{"custom-field"} as $custom_field){
			echo $custom_field->name . "=" . $custom_field->_ . "</br>";	
		}
		echo "<h4>Values:</h4>";
		foreach($facet->filtersection as $filter){
			if(isset($filter->link)){
				echo "-Filter name: " . $filter->link->name . "<br/>"; // . "(" . $filter->link->{"url-params"} . ") <br/>";	
				echo "--# items in this selection: " . $filter->nr . "<br/>";
				//echo "--params to use: " . $filter->link->{"url-params"} . "</br>";
				echo "-- Link to this selection in the preview page: <a href='http://82.165.37.158:9180/preview/?" . $filter->link->{"url-params"} . "'>link</a><br/>";
				echo "-- Link to this selection: <a href='http://localhost:81/choiceful/index.php?" . $filter->link->{"url-params"} . "'>link</a><br/>";
			}
			else if(isset($filter->name)){
				echo $filter->name;// . "(" . $filter->{"url-params"} . ")" ;	
			}		
		}
	}	
}


/** 
	@function :	product_catalogue
	@description :	download product catalogue time to time through excle seet.
	@Created by:	Nakul Kumar
	@params
	@Modify:
	@Created Date: 29-09-2011
	*/
	/*function product_catalogue(){
		ini_set('memory_limit', '9999M');
		set_time_limit(0);
		App::import('Model','ProductCatalouge');
		$this->ProductCatalouge = new ProductCatalouge();
			
		$productCatalouge=$this->ProductCatalouge->find('all',
				array(
				//'conditions'=>array('ProductCatalouge.status'=>'1'),
				'limit' => 10,
				));
		//pr($productCatalouge);
		
		$productList1[0]['product']=array('product_id' , 'Product QCID' , 'Barcode','Product Name','Product Description','Key Features','Brand','Manufacturer','Quantity','Price','Condition','Department Name','Weight','Height','Width','Length','Model Number','Image URL','Page URL','Status','Created','Video','Meta Title','Meta Keywords','Meta Description');
		$filePath=WWW_ROOT."files/fhcsvs/product_catalouge.csv";
		$filePath = fopen($filePath, "w+");
			
		if(!empty($productList1)){
		$Content='';	
		foreach($productList1 as $fields1){
			for($k=0;$k<count($fields1);$k++){
				$Content .= $fields1['product'][0]."\t";
				$Content .= $fields1['product'][1]."\t";
				$Content .= $fields1['product'][2]."\t";
				$Content .= $fields1['product'][3]."\t";
				$Content .= $fields1['product'][4]."\t";
				$Content .= $fields1['product'][5]."\t";
				$Content .= $fields1['product'][6]."\t";
				$Content .= $fields1['product'][7]."\t";
				$Content .= $fields1['product'][9]."\t";
				$Content .= $fields1['product'][10]."\t";
				$Content .= $fields1['product'][11]."\t";
				$Content .= $fields1['product'][12]."\t";
				$Content .= $fields1['product'][13]."\t";
				$Content .= $fields1['product'][14]."\t";
				$Content .= $fields1['product'][15]."\t";
				$Content .= $fields1['product'][16]."\t";
				$Content .= $fields1['product'][17]."\t";
				$Content .= $fields1['product'][18]."\t";
				$Content .= $fields1['product'][19]."\t";
				$Content .= $fields1['product'][20]."\t";
				$Content .= $fields1['product'][21]."\t";
				$Content .= $fields1['product'][22]."\t";
				$Content .= $fields1['product'][23]."\t";
				$Content .= $fields1['product'][24]."\t";
				$Content .= "\n";
			}
		}
		}
		if(!empty($productCatalouge)){
				$Content1='';	
				foreach($productCatalouge as $fields){
					$Content1 .= $fields['ProductCatalouge']['id']."\t";
					$Content1 .= $fields['ProductCatalouge']['quick_code']."\t";
					$Content1 .= $fields['ProductCatalouge']['barcode']."\t";
					$Content1 .= trim($fields['ProductCatalouge']['product_name'])."\t";
					$Content1 .= str_replace(array("\r\n","\n"),array("~","~"),trim(htmlentities($fields['ProductCatalouge']['description'])))."\t";
					$Content1 .= str_replace(array("\r\n","\n"),array("~","~"),trim(htmlentities($fields['ProductCatalouge']['product_features'])))."\t";
					$Content1 .= trim($fields['ProductCatalouge']['Brand'])."\t";
					$Content1 .= trim($fields['ProductCatalouge']['manufacturer'])."\t";
					$Content1 .= trim($fields['ProductCatalouge']['quantity'])."\t";
					$Content1 .= trim($fields['ProductCatalouge']['price'])."\t";
					$Content1 .= trim($fields['ProductCatalouge']['conditions'])."\t";	
					//$Content1 .= trim($fields['ProductCatalouge']['department_name'])."\t";
					
			/*** More to explore ***/
			/*App::import('Model', 'ProductCategory');
			$this->ProductCategory = new ProductCategory();
			$this->ProductCategory->expects(array('Category'));

			$all_pro_cats = $this->ProductCategory->find('all',array('conditions'=>array('ProductCategory.product_id'=>$fields['ProductCatalouge']['id']),'fields'=>array('ProductCategory.category_id','Category.id','Category.department_id','Category.parent_id','Category.cat_name')));

			$parentsArr = array();
			if(!empty($all_pro_cats)){
				foreach($all_pro_cats as $cat_index => $pro_cat){
					if(!empty($pro_cat['Category']['id'])){
						$this->parent_cat($pro_cat['Category']['id'],'');
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
			foreach($parentsArr as $breadcrums){
			$breadcrums1="";
						$i = 1;
						if(!empty($breadcrums['Dept'])){
							$breadcrums1.=$breadcrums['Dept']['Department']['name'].'&gt;';
						}
						if(!empty($breadcrums['Parents_arr'])) {
							foreach($breadcrums['Parents_arr'] as $breadcrum){
								if($i != count($breadcrums['Parents_arr'])){
									$breadcrums1.=$breadcrum['Category']['cat_name'].'&gt;';
								} else {
									$breadcrums1.=$breadcrum['Category']['cat_name'];
								}
							 $i++; }
						}
					}
			$Content1 .=$breadcrums1."\t";	
		/****End********/
					/*$Content1 .= trim($fields['ProductCatalouge']['product_weight'])."\t";
					$Content1 .= trim($fields['ProductCatalouge']['product_height'])."\t";
					$Content1 .= trim($fields['ProductCatalouge']['product_width'])."\t";
					$Content1 .= trim($fields['ProductCatalouge']['product_length'])."\t";
					$Content1 .= trim($fields['ProductCatalouge']['model_number'])."\t";
					$Content1 .= SITE_URL."img/products/medium/img_200_".trim($fields['ProductCatalouge']['image_url'])."\t";
					$Content1 .= SITE_URL."categories/productdetail/".trim($fields['ProductCatalouge']['page_url'])."\t";
					$Content1 .= trim($fields['ProductCatalouge']['status'])."\t";
					$Content1 .= trim($fields['ProductCatalouge']['created'])."\t";
					$Content1 .= trim($fields['ProductCatalouge']['product_video'])."\t";
					$Content1 .= str_replace(array("\r\n","\n"),'~',trim($fields['ProductCatalouge']['meta_title']))."\t";
					$Content1 .= str_replace(array("\r\n","\n"),'~',trim($fields['ProductCatalouge']['meta_keywords']))."\t";
					$Content1 .= str_replace(array("\r\n","\n"),'~',trim($fields['ProductCatalouge']['meta_description']))."\t";
					$Content1 .= "\n";
				}
			}
		//exit;
		$wholeContent=$Content.$Content1;
		//pr($wholeContent);
		$fileComp=fwrite($filePath, $wholeContent);
		fclose($filePath);
		
		if($fileComp){
			echo "complete";
		}else{
			echo "Not complete";
		}		
		
		
	}
	/** 
	@function :	parent_cat
	@description :	used in above product_catalogue function for getting parent category.
	@Created by:	Nakul Kumar
	@params
	@Modify:
	@Created Date: 13-10-2011
	*/
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
	@function :	admin_barcodelist
	@description :	used in admin edit product page to display more barcode related to one product.
	@Created by:	Nakul Kumar
	@params
	@Modify:
	@Created Date: 23-10-2011
	*/
	function admin_barcodelist($pid=null){
		$this->layout='layout_admin';
		Configure::write('debug', 2);
		$this->set('title_for_layout','Barcode');
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller;
		$this->ProductSeller->expects(array('Product'));
		$criteria='';
		if(isset($pid) && $pid != "") {
			$criteria = "ProductSeller.product_id= $pid or Product.id= $pid";
		}
		
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'ProductSeller.id' => 'DESC'
				),
			'fields'=> array('ProductSeller.id','Product.id')
		);
		$this->set('barcodes',$this->paginate('ProductSeller',$criteria));
		$this->set('count_products',$this->ProductSeller->find('count',array('conditions'=>$criteria)));
	}
}
?>