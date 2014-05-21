<?php
/**
 *
* ProductVisit Model class
*/

class ProductVisit extends AppModel {
	var $name = 'ProductVisit';
	
	var $assocs = array(
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
			'foreignKey' => 'product_id',
		),
		'ProductSeller' => array(
			'type' => 'belongsTo',
			'className' => 'ProductSeller',
			'foreignKey' => false,
			'conditions' => 'ProductSeller.product_id = ProductVisit.product_id',
		)
 	);
	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		$parameters = compact('conditions', 'recursive');
		if (isset($extra['group'])) {
			$parameters['fields'] = $extra['group'];
			if (is_string($parameters['fields'])) {
				// pagination with single GROUP BY field
				if (substr($parameters['fields'], 0, 9) != 'DISTINCT ') {
					$parameters['fields'] = 'DISTINCT ' . $parameters['fields'];
				}
				unset($extra['group']);
				$count = $this->find('count', array_merge($parameters, $extra));
			} else {
				// resort to inefficient method for multiple GROUP BY fields
				$count = $this->find('count', array_merge($parameters, $extra));
				$count = $this->getAffectedRows();
			}
		} else {
			// regular pagination
			$count = $this->find('count', array_merge($parameters, $extra));
		}
		return $count;
	}
	/** 
	@function: getVisitedProducts
	@Created by: Kulvinder
	@Modify: 15 March 2011
	*/
	function getVisitedProducts($deptId = null){
		$session_id = session_id();
		/*$visitedProductsArr = $this->find('all',array(
			/* 'limit'=>8,*/
			/* 'order'=> 'created DESC',
			 'fields'=>array('DISTINCT product_id '),
			 'conditions'=>array("created >= DATE_SUB( NOW( ) , INTERVAL 1 DAY)" ),
			// 'group'=> 'product_id'
			// ));*/
		
		//pr($visitedProductsArr);
		$visitedProducts = array();
		$selectedDepId = '';
		if(isset($deptId) && $deptId!=null){
			$selectedDepId ="AND department_id = $deptId";
		}
		/*if(count($visitedProductsArr) ){
			App::import('Model','Product');
			$this->Product = & new Product();
			$count =0;
			foreach($visitedProductsArr as $id=>$product){
				if ($count<=8){
				$visited =  $this->Product->find('first',array(
					'conditions'=>array('id' => $product['ProductVisit']['product_id'],$selectedDepId),
					'fields'=> array('id','product_name','product_image','product_rrp',
						'minimum_price_value', 'minimum_price_used','avg_rating','department_id')			
						));
							
					if( !empty($visited) ){
						$count++;
						//if($count<=8)
						$visitedProducts[$id]  = $visited['Product'];
					}
				unset($visited);
				}
			}*/
			
			//pr($visitedProducts);
			/*if(count($visitedProducts)<4){
				$remainingProduct=array_diff_key($visitedProductsArr,$visitedProducts);
				foreach($remainingProduct as $id=>$product){
				$visited =  $this->Product->find('first',array(
					'conditions'=>array('id' => $product['ProductVisit']['product_id']),
					'fields'=> array('id','product_name','product_image','product_rrp',
						'minimum_price_value', 'minimum_price_used','avg_rating')			
						));
				
					if( !empty($visited) ){
						$count++;
						if($count<=8)
						$visitedProducts[$id]  = $visited['Product'];
					}
				unset($visited);
				}
			}*/
			
		//}
		
		$visited_Products = $this->query("SELECT DISTINCT pv.product_id,p.id,p.product_name,p.product_image,p.product_rrp,p.minimum_price_value,p.minimum_price_used,p.avg_rating,p.department_id FROM product_visits as pv, products as p WHERE 1 and p.id = pv.product_id and pv.created >= DATE_SUB( NOW( ) , INTERVAL 1 DAY) ".$selectedDepId." LIMIT 8");
			
			foreach($visited_Products as $visited_Product){
				$visitedProducts[]  = $visited_Product['p'];
			}
			
		return $visitedProducts;
	}
	
	
	/** 
	@function: getCookiesItems
	@Created by: Kulvinder
	@Modify: 15 March 2011
	*/
	function getCookiesItems(){
		//pr($_COOKIE);
		//echo $abc = $this->Cookie->check('CakeCookie');
		//pr($abc);
		$cookieArray = @$_COOKIE['CakeCookie'];
		$recentItems = array();
		if(isset($cookieArray) ) {
			if(count($cookieArray) > 0){ 
				
				foreach($cookieArray as $id=>$product){
					//echo substr($id , 0 , 7);
					if(substr($id , 0 , 7) == 'RecentH' && is_numeric($product) ){
						$recentItems[$product] = $product ;
					}
				}
			}
		}return $recentItems;
		
		
	}
	/** 
	@function: getMyVisitedProducts
	@Created by: Kulvinder
	@Modify: 15 March 2011
	*/
	function getMyVisitedProducts(){
		
		$session_id = session_id();
		$recentItems = $this->getCookiesItems();
		//pr($recentItems);
		if(count($recentItems) > 0){  //  IF ITEMS FOUND IN COOKIES
		       $myVisitedProductsArr = array_reverse($recentItems);
		    	App::import('Model','Product');
			$this->Product = & new Product();
			$visitedProducts = array();
			foreach($myVisitedProductsArr as $id=>$product){
				$visited =  $this->Product->find('first',array(
					'conditions'=>array('id' => $product ),
					'fields'=> array('id','product_name','product_image','product_rrp',
						'minimum_price_value', 'minimum_price_used')			
						));
					if( !empty($visited) ){ 
						$visitedProducts[$product]  = $visited['Product'];
					}
				unset($visited);
			}
			return $visitedProducts;
		}else{
			return '';
		}
	}
	
	/** 
	@function: addVisitedProduct
	@Created by: Kulvinder
	@Modify: 15 March 2011
	*/
	function addVisitedProduct($product_id){
		$session_id = session_id();
		$this->data['ProductVisit']['product_id'] = $product_id;
		$this->data['ProductVisit']['session_id'] = $session_id;
		$this->data['ProductVisit']['visits'] = 1;
		
		$visited = $this->find('first',array(
			'conditions'=>array("product_id = $product_id AND  created >= DATE_SUB( NOW( ) , INTERVAL 1 DAY)" ),
			'fields'=> array('ProductVisit.id')
			));
		pr($visited);
		if(is_array($visited) ){
			$id = $visited['ProductVisit']['id'];
			$this->query(" update product_visits set visits=visits+1, created = CURRENT_TIMESTAMP where id = $id");
		}else{ // add the product 
			$this->save($this->data['ProductVisit']);
		}
	}
	
}
?>