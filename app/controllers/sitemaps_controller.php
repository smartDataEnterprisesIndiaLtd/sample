<?php
class SitemapsController extends AppController{

	var $name = 'Sitemaps';
	var $helpers = array('Time','Form','Html','Javascript','Format','Session','Ajax','Fck','Validation','Common');
	var $uses = array('Department','Category','Product','Blog','Page','ProductCategory'); 
	var $components =  array('RequestHandler','Common');
    

    function categories (){
	
	$sitemapData = array();
	$departments = $this->Department->find('all',array('fields'=>array('id','name')));
	foreach ($departments as $department) {
	$dept_name=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($department['Department']['name'], ENT_NOQUOTES, 'UTF-8'));
		
	$sitemapData[$department['Department']['id']]['department'] = $dept_name;
	
	$categories = $this->Category->getAllCategory($department['Department']['id']);
	
		
	if(isset($categories)  &&  is_array($categories)  ){
		foreach($categories as $cat_id=>$cat_name){ 
		$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
		
		$sitemapData[$department['Department']['id']]['categories'][$cat_id] = $cat_atoz;
		
	}
	}
	}
	
	$this->set("sitemapData", $sitemapData);
	$this->RequestHandler->respondAs('xml');
	
	
    }
    function blog(){
		$this->RequestHandler->respondAs('xml');
		
		$this->set('title_for_layout','Sitemap | Choiceful.com');
		$storeId = $this->Session->read('storeIdTemp');
		$this->loadModel('Blog');
		$blogs = $this->Blog->find('all',array('conditions'=>array('Blog.status'=>1),'order' => 'Blog.views DESC')); //,'limit'=>"0,20"
		$this->set('blogs',$blogs);
	}
	function static_links (){
	   $this->RequestHandler->respondAs('xml');
   
	}
	
	
       
	function products()
       {
		//ini_set('memory_limit','264M');
		//set_time_limit(0);
		$products = $this->Product->find('all',array('fields'=>array('id','product_name','modified'),'limit'=>'50000'));
		
		
		$xmldata = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	 
	    if(isset($products) && !empty($products)) {
	    foreach ($products as $product){
		$xmldata .= '<url>';
		$xmldata .= '<loc>'.Router::url('http://www.choiceful.com/'.$this->Common->getProductUrl($product['Product']['id']).'/categories/productdetail/'.$product['Product']['id'],true).'</loc>';
		$xmldata .= '<lastmod>'.date("Y-m-d H:i:s",strtotime($product['Product']['modified'])).'</lastmod>';
		$xmldata .= '</url>';
	    
	    } } 
		
		$xmldata .= '</urlset>';
	
		$fp = fopen(WWW_ROOT.'files/sitemap/products.xml', 'w');
		fwrite($fp,$xmldata);
		fclose($fp);
		// Name of the file we are compressing
		$file = WWW_ROOT."files/sitemap/products.xml";
	
		// Name of the gz file we are creating
		$gzfile = WWW_ROOT."files/sitemap/products.xml.gz";
		
		// Open the gz file (w9 is the highest compression)
		$fp = gzopen ($gzfile, 'w9');
		
		// Compress the file
		gzwrite ($fp, file_get_contents($file));
		
		// Close the gz file and we are done
		gzclose($fp);
		
		exit;
		//$this->set("products", $products);
		//$this->RequestHandler->respondAs('xml');
	
       }
       
	
	function index (){
		$this->layout = null;
		header('Content-type: text/xml');
		//$headers = apache_request_headers();
		$this->RequestHandler->setContent('xml','utf-8');
		//echo $this->RequestHandler->responseType();
		//$this->RequestHandler->setContent('xml','application/xml');
	}
	
	 function products1()
		{
			 //ini_set('memory_limit','264M');
			// set_time_limit(0);
			 $products = $this->Product->find('all',array('fields'=>array('id','product_name','modified'),'limit'=>'50001,50000'));
			 
			 $xmldata = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	    
	    if(isset($products) && !empty($products)) {
	    foreach ($products as $product){
		$xmldata .= '<url>';
		$xmldata .= '<loc>'.Router::url('http://www.choiceful.com/'.$this->Common->getProductUrl($product['Product']['id']).'/categories/productdetail/'.$product['Product']['id'],true).'</loc>';
		$xmldata .= '<lastmod>'.date("Y-m-d H:i:s",strtotime($product['Product']['modified'])).'</lastmod>';
		$xmldata .= '</url>';
	    
	    } } 
		
		$xmldata .= '</urlset>';
	
		$fp = fopen(WWW_ROOT.'files/sitemap/products1.xml', 'w');
		fwrite($fp,$xmldata);
		fclose($fp);
		// Name of the file we are compressing
		$file = WWW_ROOT."files/sitemap/products1.xml";
	
		// Name of the gz file we are creating
		$gzfile = WWW_ROOT."files/sitemap/products1.xml.gz";
		
		// Open the gz file (w9 is the highest compression)
		$fp = gzopen ($gzfile, 'w9');
		
		// Compress the file
		gzwrite ($fp, file_get_contents($file));
		
		// Close the gz file and we are done
		gzclose($fp);
		
		exit;
		//$this->set("products", $products);
		//$this->RequestHandler->respondAs('xml');
			// $this->set("products", $products);
			// $this->RequestHandler->respondAs('xml');
		}
	
	function sitemap()
	{
		$this->layout = "sitemap";
		$this->set('title_for_layout','Choiceful.com Sitemap');
		$sitemapData = array();
		$departments = $this->Department->find('list') ;
		$this->set('departments', $departments);
		
		//blogs list starts here
		$blogs = $this->Blog->find('all',array('conditions'=>array('Blog.status'=>1),'fields'=>array('id','slug','title'),'contain'=>false)) ;
		$this->set('blogs', $blogs);
		//blogs ends
		
			    
		//Configure::write ('debug', 0);
	}
	
	
	function product_categories($sortby=null)
	{
		$this->layout = "sitemap";
		$this->set('title_for_layout','Choiceful.com Sitemap');
		if(!empty($sortby))
		$sort= $sortby;
		else $sort ='A';
		$product_categories = $this->Category->find('all' , array('conditions' => array('Category.status' =>1,'Category.cat_name LIKE'=>$sort.'%'),'fields' => array('Category.id','Category.cat_name','department_id' ),'order'=>array('Category.cat_name')));
		$this->set("product_categories", $product_categories);
	}
	
	function product_map()
	{
		$this->layout = "sitemap_productmap";
		$this->set('title_for_layout','Choiceful.com Sitemap');
		
		$departments = $this->Department->find('all');
	
		$this->set('departments', $departments);
		
	
	}
	
	
	function product_map_topcategories($department_id= null)
	{
		$this->layout = "sitemap_productmap";
		$this->set('title_for_layout','Choiceful.com Sitemap');
		
		// top categories starts here
		$categories = $this->Category->getTopCategory($department_id);
		$this->set('categories',$categories);
		
		$categoryname = $this->getDepartmentname($department_id);
		$this->set('categoryname',$categoryname);
		
		
	}
	
	
	function product_map_short($department_id= null,$selected_category= null)
	{
		$this->layout = "sitemap_productmap";
		
		$catDetailsArr = $this->getCategoryDetail($selected_category);
		
		$selected_department = $catDetailsArr['Category']['department_id'];
		$selected_category_name = $catDetailsArr['Category']['cat_name'];
		$this->set('selected_category_name', $selected_category_name);
		$immediate_parent_category = $catDetailsArr['Category']['parent_id'];
		//$this->set('selected_department', $selected_department);
		
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
		
	// show breadcrumb starts
		$strBreadcrumb = $this->productmapBreadcrumb($selected_category);
		
		$this->set('strBreadcrumb', $strBreadcrumb);
		
		//ends
		
	}
	
	
	
	
	function getKeys($array=null)
	{
		
		//Configure::write ('debug', 2);
		$finalArray= array();
		$newCats = array();
		
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $k => $v) {
			$newCats[$k] = $k;
			$newCats[$k] = $this->getSubcats($v['sub']);
			}
		}
				
			 foreach ($newCats as $newkey=>$newval)
			 {
				$finalArray[$newkey] = $newkey;
				foreach ($newval as $nk=>$nv)
				{
				$finalArray[$nk] = $nk;	
				}
				
			 }
			 
	return $finalArray;
       }
	
	
	function getSubcats($array=null)
	{
		
		$newCats = array();
		if (is_array($array) && isset($array) > 0) {	
		foreach ($array as $newkey=>$newval){
		$newCats[$newkey] = $newkey;
		if (is_array($newval['sub']) && isset($newval['sub']) > 0) {
		$this->getSubcats($newval['sub']);
		}	
		
		}
		}
		return $newCats;
		
	}
	
	function product_map_name($department_id=null,$selected_category= null,$category_id=null)
	{
		Configure::write ('debug', 0);
		$this->layout = "sitemap_productmap";
		$this->set('title_for_layout','Choiceful.com Sitemap');
		
		$department_name = $this->getDepartmentname($department_id);
		$this->set('department_name',$department_name);
		
		$selected_category_name = $this->Category->getCategoryname($selected_category);
		$this->set('selected_category_name',$selected_category_name);
		
		$categoryname = $this->Category->getCategoryname($category_id);
		$this->set('categoryname',$categoryname);
		
	
		$productIds = $this->ProductCategory->find('list',array('fields' => array('ProductCategory.product_id','ProductCategory.id'),'conditions' => array('ProductCategory.category_id' =>$category_id)));
		

		$allproducts = array();
		if(isset($productIds) && !empty($productIds) && count($productIds) >0){
		foreach ($productIds as $productid=>$prodcutval){
		$totalproducts = $this->Product->find('all',array('conditions' => array('Product.id'=>$productid),'fields'=>array('Product.id','Product.product_name'),'order'=>array('Product.product_name ASC')));
		
		$allproducts[$productid]['id'] = $productid;
		$allproducts[$productid]['product_name'] = $totalproducts[0]['Product']['product_name'];
			
		}
		}
		
		$allproducts = $this->msort($allproducts, array('product_name'));
		$this->set("totalproducts", $allproducts);	
		
		// show breadcrumb starts
		$strBreadcrumb = $this->productmapBreadcrumb($category_id);
		$this->set('strBreadcrumb', $strBreadcrumb);
		
		//ends
		
	}
	
	
	
	function msort($array, $key, $sort_flags = SORT_REGULAR) {
		if (is_array($array) && count($array) > 0) {
		    if (!empty($key)) {
			$mapping = array();
			foreach ($array as $k => $v) {
			    $sort_key = '';
			    if (!is_array($key)) {
				$sort_key = $v[$key];
			    } else {
				// @TODO This should be fixed, now it will be sorted as string
				foreach ($key as $key_key) {
				    $sort_key .= $v[$key_key];
				}
				$sort_flags = SORT_STRING;
			    }
			    $mapping[$k] = $sort_key;
			}
			asort($mapping, $sort_flags);
			$sorted = array();
			foreach ($mapping as $k => $v) {
			    $sorted[] = $array[$k];
			}
			return $sorted;
		    }
		}
		return $array;
	    }
	
	
	function getDepartmentname($department_id=null)
	{
	$CategoryName  = $this->Department->find('first' , array(
			'fields' => array('Department.name'),
			'conditions' => array('Department.id' => $department_id)));
		return $CategoryName['Department']['name']; 	
		
	}
    
    
/********************************************** */
	/** 
	@function:	 getParentCategoryArray	
	@description	get list of all parent category array 
	@Created by: 	Pradeep kumar
	@params		category id 
	@Modify:	NULL
	@Created Date:	13 March 2013
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
    
    
     /********************************************** */
	/** 
	@function:	 getParentCategory	
	@description	 get list of all parent category ids 
	@Created by: 	pradeep kumar	
	@params		category id 
	@Modify:	NULL
	@Created Date: 13 March 2013
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
	
	
	/** 
	@function:	 getChildCategory	
	@description	get list of all child category ids 
	@Created by: 	Pradeep kumar
	@params		category id 
	@Modify:	NULL
	@Created Date:	13 March 2013
	*/
	function getChildCategory($cat_id = null){
		$childCatArr  = $this->Category->find('list' , array(
			'conditions' => array('Category.parent_id' => $cat_id, 'Category.status' =>1),
			'fields' => array('Category.id','Category.cat_name' ),'order'=>array('Category.cat_rank DESC')));
		return $childCatArr;
	}
	
	/********************************************** */
	/** 
	@function:	 getCategoryDetail	
	@description	get category details
	@Created by: 	Pradeep kumar
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
	
	
	/********************************************** */
	/** 
	@function:	 productmapBreadcrumb	
	@description	get bredacrumbs for thr product sitemap
	@Created by: 	Pradeep kumar
	@params		category  id 
	@Modify:		NULL
	@Created Date:		
	*/
	
	function productmapBreadcrumb($category_id = null){
		
		// get department name and id 
		$this->Category->expects( array( 'Department' ) );
		$departArr  = $this->Category->find('first' , array(
			'conditions' => array('Category.id' => $category_id),
			'fields' => array('Department.name', 'Department.id')
		));
		$department_name = $departArr['Department']['name'];
		$department_id = $departArr['Department']['id'];
		//$link_seperator = "&raquo;" ;
		$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
		$link_seperator = " > " ;
		$strLink  = '<strong>You are here:</strong> <a href="/" >Home</a>'.$link_seperator ;
		$strLink .= '<a href="/sitemaps/sitemap" >Sitemap</a>'.$link_seperator ;
		$strLink .= '<a href="/sitemaps/product_map" >Sitemap Map</a>'.$link_seperator ;
		$strLink .= '<a href="'.SITE_URL.'/sitemaps/product_map_topcategories/'.$department_id.'" >' .$department_name. '</a>';
		
		$strLink .= $link_seperator;
			
			
			$finalArr = $this->getParentCategoryArray($category_id);
			
			$totalCount = count($finalArr);
			if( is_array($finalArr) ){
				$j = 0;
				foreach($finalArr as $key=>$value){
					$j++;
					
					if($j == $totalCount){
						
						$strLink .= $value;	
					}else{
						
						$cat_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($value, ENT_NOQUOTES, 'UTF-8'));
						
						
						$innerlink = SITE_URL.'sitemaps/product_map_short/'.$department_id.'/'.$key;
						$strLink .='<a href="'.$innerlink.'">' .$value. '</a>';
						$strLink .= $link_seperator;
					}
				}
			}
			
			
		return $strLink;
	}
	
    
}