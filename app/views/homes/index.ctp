<?php
$dayPicksIds = array();

$hotProductIds = array();
$hotPickIds = array();

$release1_field_ids = array();
$release2_field_ids = array();
$release3_field_ids = array();

$department1_field_ids = array();
$department2_field_ids = array();
$department3_field_ids = array();
$department4_field_ids = array();

$customer_field_ids = array();
$prodIds = array();
$customer_Products = array();


/*

if(!empty($this->params['pass'][0])){
	$dept_id = $this->params['pass'][0];
} else{
	$dept_id = '0';
}*/


$depName =$this->params['url']['url'];
switch($depName){
	case 'books':
		$dept_id =1;
		break;
	case 'music':
		$dept_id =2;
		break;
	case 'movies':
		$dept_id =3;
		break;
	case 'games':
		$dept_id =4;
		break;
	case 'electronics':
		$dept_id =5;
		break;
	case 'office-and-computing':
		$dept_id =6;
		break;
	case 'mobile':
		$dept_id =7;
		break;
	case 'home-and-garden':
		$dept_id =8;
		break;
	case "health-and-beauty":
		$dept_id =9;
		break;
	default :
		$dept_id = '0';
		break;
}

$this->set('dept_id',$dept_id);
App::import('Model','HomepageProduct');
$this->HomepageProduct = & new HomepageProduct();

$hm_products = $this->HomepageProduct->find('first',array('conditions'=>array('HomepageProduct.department_id'=>$dept_id)));
$this->set('hm_products',$hm_products);
//pr($hm_products);
$prodIdsArray = array('release1_product1','release1_product2','release1_product3','release1_product4','release1_product5','release1_product6','release1_product7','release1_product8',
		 'release2_product1','release2_product2','release2_product3','release2_product4','release2_product5','release2_product6','release2_product7','release2_product8',
		 'release3_product1','release3_product2','release3_product3','release3_product4','release3_product5','release3_product6','release3_product7','release3_product8',
		 'heading1_product1','heading1_product2','heading1_product3','heading1_product4' ,
		 'heading2_product1','heading2_product2','heading2_product3','heading2_product4',
		 'heading3_product1','heading3_product2','heading3_product3','heading3_product4','heading3_product5','heading3_product6','heading3_product7','heading3_product8',
		 'heading4_product1','heading4_product2','heading4_product3','heading4_product4','heading4_product5','heading4_product6','heading4_product7','heading4_product8',
		 'day_pick_1','day_pick_2','day_pick_3','day_pick_4','hot_product','hot_pick','customer_product1','customer_product2','customer_product3','customer_product4',
		 'customer_product5', 'customer_product6','customer_product7'
		 );


$dayPicks = array('day_pick_1','day_pick_2','day_pick_3','day_pick_4');
$release1_field_array = array('release1_product1','release1_product2','release1_product3','release1_product4','release1_product5','release1_product6','release1_product7','release1_product8');
$release2_field_array = array('release2_product1','release2_product2','release2_product3','release2_product4','release2_product5','release2_product6','release2_product7','release2_product8');
$release3_field_array = array('release3_product1','release3_product2','release3_product3','release3_product4','release3_product5','release3_product6','release3_product7','release3_product8');

$depart1_field_array = array('heading1_product1','heading1_product2','heading1_product3','heading1_product4' );
$depart2_field_array = array('heading2_product1','heading2_product2','heading2_product3','heading2_product4' );
$depart3_field_array = array('heading3_product1','heading3_product2','heading3_product3','heading3_product4','heading3_product5','heading3_product6','heading3_product7','heading3_product8' );
$depart4_field_array = array('heading4_product1','heading4_product2','heading4_product3','heading4_product4','heading4_product5','heading4_product6','heading4_product7','heading4_product8' );

$customer_field_array = array('customer_product1','customer_product2','customer_product3','customer_product4', 'customer_product5', 'customer_product6','customer_product7');

// pr($prodIdsArray);
if(count($hm_products) > 0){
	foreach( $prodIdsArray as $prod_key){
		if(!empty($hm_products['HomepageProduct'][$prod_key])){
			
			$prodIds[] = $hm_products['HomepageProduct'][$prod_key];
			#########################
			if(in_array($prod_key, $dayPicks) ){
				$dayPicksIds[$prod_key] = $hm_products['HomepageProduct'][$prod_key];
			}
			########################
			if($prod_key == 'hot_product'){
				$hotProductIds[$prod_key] = $hm_products['HomepageProduct'][$prod_key];
			}
			########################
			if($prod_key == 'hot_pick'){
				$hotPickIds[$prod_key] = $hm_products['HomepageProduct'][$prod_key];
			}
			##################### New Release Section #########################################
			if(in_array($prod_key, $release1_field_array) ){
				$release1_field_ids[$prod_key] = $hm_products['HomepageProduct'][$prod_key];
			}
			if(in_array($prod_key, $release2_field_array) ){
				$release2_field_ids[$prod_key] = $hm_products['HomepageProduct'][$prod_key];
			}
			if(in_array($prod_key, $release3_field_array) ){
				$release3_field_ids[$prod_key] = $hm_products['HomepageProduct'][$prod_key];
			}
			##################### New Release Section Ends Here ################################			
			##################### Heading  Section Starts Here #################################
			if(in_array($prod_key, $depart1_field_array) ){
				$department1_field_ids[$prod_key] = $hm_products['HomepageProduct'][$prod_key];
			}
			if(in_array($prod_key, $depart2_field_array) ){
				$department2_field_ids[$prod_key] = $hm_products['HomepageProduct'][$prod_key];
			}
			if(in_array($prod_key, $depart3_field_array) ){
				$department3_field_ids[$prod_key] = $hm_products['HomepageProduct'][$prod_key];
			}
			if(in_array($prod_key, $depart4_field_array) ){
				$department4_field_ids[$prod_key] = $hm_products['HomepageProduct'][$prod_key];
			}
			##################### Heading  Section Ends Here #################################
			if(in_array($prod_key, $customer_field_array) ){
				$customer_field_ids[$prod_key] = $hm_products['HomepageProduct'][$prod_key];
			}
		}		
	}
}

$this->set('dayPicksIds', $dayPicksIds);
$this->set('hotProductIds', $hotProductIds);
$this->set('hotPickIds', $hotPickIds);

$this->set('release1_field_ids', $release1_field_ids);
$this->set('release2_field_ids', $release2_field_ids);
$this->set('release3_field_ids', $release3_field_ids);

$this->set('department1_field_ids', $department1_field_ids);
$this->set('department2_field_ids', $department2_field_ids);
$this->set('department3_field_ids', $department3_field_ids);
$this->set('department4_field_ids', $department4_field_ids);

$this->set('customer_field_ids', $customer_field_ids);




//pr($customer_field_ids);
$prodIds = array_unique($prodIds);
$prodIdsStr = implode(',', $prodIds);

// import the database
App::import('Model','Product');
$this->Product = & new Product();
$this->Product->expects(array('ProductDetail'));

$allFieldsArray = array('Product.id','Product.product_name','Product.product_image','ProductDetail.description',
		     'Product.product_rrp','Product.minimum_price_value','Product.minimum_price_seller','Product.new_condition_id','Product.minimum_price_used','Product.minimum_price_used_seller' ,'Product.used_condition_id','Product.avg_rating');
if(!empty($prodIdsStr)){
	$productsArray = $this->Product->find('all',array('conditions'=>array('Product.id in ('.$prodIdsStr.')','Product.status'=>'1'),'fields'=>$allFieldsArray));
}


$dayPicksProduct = $hotProduct = $hotPicProduct = array();
$release1_Products = $release2_Products = $release3_Products = array();
$department1_Products = $department2_Products = $department3_Products = $department4_Products = array();
if(!empty($productsArray)){
	if(count($productsArray) > 0){
		foreach( $productsArray as $product):
			$productId = $product['Product']['id'];
			########################################
			if( in_array($productId, $dayPicksIds) ){
				$dayPicksProduct[$productId] = $product;
			}
			########################################
			if( in_array($productId, $hotProductIds) ){
				$hotProduct['Product'] = $product['Product'];
			}
			########################################
			if( in_array($productId, $hotPickIds) ){
				$hotPicProduct['Product'] = $product['Product'];
			}
			
			##################### New Release Section Start Here ################################
			if( in_array($productId, $release1_field_ids) ){
				$release1_Products[$productId] = $product;
			}
			if( in_array($productId, $release2_field_ids) ){
				$release2_Products[$productId] = $product;
			}
			if( in_array($productId, $release3_field_ids) ){
				$release3_Products[$productId] = $product;
			}
			##################### New Release Section Ends Here ################################
			##################### Heading  Section Starts Here #################################
			if( in_array($productId, $department1_field_ids) ){
				$department1_Products[$productId] = $product;
			}
			if( in_array($productId, $department2_field_ids) ){
				$department2_Products[$productId] = $product;
			}
			if( in_array($productId, $department3_field_ids) ){
				$department3_Products[$productId] = $product;
			}
			if( in_array($productId, $department4_field_ids) ){
				$department4_Products[$productId] = $product;
			}
			##################### Heading  Section Ends Here #################################
			if( in_array($productId, $customer_field_ids) ){
				$customer_Products[$productId] = $product;
			}
		endforeach;
	}
}
//pr($release1_field_ids);
//pr($pos1_newreleases);

$this->set('dayPicksProduct', $dayPicksProduct);
$this->set('hotProduct', $hotProduct);
$this->set('hotPicProduct', $hotPicProduct);

$this->set('release1_Products', $release1_Products);
$this->set('release2_Products', $release2_Products);
$this->set('release3_Products', $release3_Products);



$this->set('department1_Products', $department1_Products);
$this->set('department2_Products', $department2_Products);
$this->set('department3_Products', $department3_Products);
$this->set('department4_Products', $department4_Products);

$this->set('customer_Products', $customer_Products);


//pr($release1_Products);

?>
<!--mid Content Start-->
<div class="mid-content diffrent_pd" id="resolutionDivId">
	
	
	<?php
	if ($session->check('Message.flash')){ ?>
			<?php echo $session->flash();?>
	<?php } ?>
	
	<div class="banner-ad" >
		<?php
		/******** Main Banner section start here ********/
		// show main banner with id = 1
		if(is_array($AdsData) &&  count($AdsData) > 0 ){
			if($AdsData[0]['Advertisement']['status'] == 1){
				if( !empty($AdsData[0]['Advertisement']['banner_image']) || $AdsData[0]['Advertisement']['banner_image'] != 'no_image.gif'){
					$AdsImage = "/".PATH_ADVERTISEMENTS.$AdsData[0]['Advertisement']['banner_image'];
					$adsLabel = ( !empty($AdsData[0]['Advertisement']['bannerlabel']) )?($AdsData[0]['Advertisement']['bannerlabel']):('');
					$adsUrl = ( !empty($AdsData[0]['Advertisement']['bannerurl']) )?($AdsData[0]['Advertisement']['bannerurl']):('#');
					
					echo $html->link($html->image($AdsImage, array('width'=>'889' ,'height'=>'140','border'=>'0' ) ), $adsUrl, array('escape'=>false, 'target'=>'_blank'));
				}
				
			}
		}
		/******** Main Banner section End here  ********/
		?>
		<?php //echo $html->image("mix-match-any-2.jpg",array('width'=>"889",'height'=>"140",'alt'=>""));?>
	</div>
	<!--What Other Customers Are Looking At Right Now Start-->
	
	
	
	<!--Products Widget Start-->
		<?php  echo $this->element('customer_looking_now');?>
	
	<!--Products Widget Closed-->
	<!--What Other Customers Are Looking At Right Now Closed-->
	<!--Highlights Start-->
	<h1 class="heading margin-bottom">Highlights</h1>
	
		
				<?php echo $this->element('day_pick');?>
			
		
	<?php
	# display all new releases and department prodeucts section
	echo $this->element('homepage_middle_section');
	
	?>
	
</div>
<script>
var width_pre_div = 632;
</script>
<?php echo $javascript->link(array('change_resolution'));?>
<!--mid Content Closed-->