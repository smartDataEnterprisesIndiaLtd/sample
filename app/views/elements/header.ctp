<?php 	echo $html->css('menu/jMenu.jquery');
	echo $html->css('media');
	$session_data = $_SESSION;
	//print_r($session);
	$expire=time()+60*60*24*30;
	setcookie("session_data", serialize($session_data), $expire);	
	//echo ($_COOKIE["session_data"]);
//print_r(unserialize($_COOKIE["session_data"]));
//setcookie("user", "Alex Porter", $expire);
//echo $_COOKIE["user"];
?>
<script>jQuery.noConflict();</script>
<?php echo $javascript->link(array('menu/jMenu.jquery'));
echo $javascript->link(array('lib/prototype'));
?>
<?php
$countryID ='';
$countryID  =  $this->Session->read('countryID');

if(!empty($countryID) && $countryID !=''){
		$countryName  =  $this->Session->read('countryName');
		$countryImage = $this->Session->read('countryImage');
		}else{
		
		$countryName = 'United Kingdom';
		$countryImage = 'uk.png';
}
		?>
<?php
//echo $session_id = session_id();
$user_session = $this->Session->read('User');
	$ip=$_SERVER['REMOTE_ADDR'];
	
	App::import('Model','Visitor');
	$this->Visitor = & new Visitor();
	
	$this->data['Visitor']['ip_add'] = $ip;
	$ip_visitor_info = $this->Visitor->find('first',array('conditions'=>array('Visitor.ip_add'=>$ip)));
	if(!empty($ip_visitor_info)){
		$ip_visitor_time = strtotime($ip_visitor_info['Visitor']['created']);
	} else{
		$ip_visitor_time = 0;
	}
	//IP have been added after 15 mints
	$current_time = strtotime(date('d-m-Y H:i:s'));
	if(($current_time - $ip_visitor_time) >= (15*60)){
		if(!empty($ip_visitor_info)){
			$this->Visitor->id = $ip_visitor_info['Visitor']['id'];
			$this->Visitor->delete();
		}
		$insert_flag = 0;
	} else{
		$insert_flag = 1;
	}
	
	if($insert_flag == 0){
		$this->data['Visitor']['id'] = 0;
		$this->data['Visitor']['ip_add'] = $ip;
		$this->Visitor->set($this->data);
		$this->Visitor->save();
	}
	//echo $javascript->link(array('custom'));
?>
<script type="text/javascript">

	var SITE_URL = "<?php echo SITE_URL; ?>";
 
 /*
  * function to show updated cart in header
  **/
	jQuery(document).ready(function()  {
		showUpdatedCart();
		
	});





// function to show updated mini shopping cart on the page
function showUpdatedCart(){
	var postUrl = SITE_URL+'baskets/minibasket/1'
	//alert(postUrl);
	jQuery.ajax({
		cache: false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#shopping_basket_id').html(msg);
		jQuery('#fancybox-overlay-header').hide();
	}
	});		  
}

// function to add item to cart
function addToBasket(product_id, qty_field_id,price,seller_id,condition,offer_product_t){
	
	var offer_product =  offer_product_t;
	offer_product_val='';
	if(offer_product){
		offer_product_val= "/+"+offer_product;
	}
	//price = 1450;
	if(qty_field_id == 1 ){ 
		var qty = '1';
	} else if( parseInt(qty_field_id) > 0 ){
		var qty = qty_field_id; 
	}else{
		var quantity_field_id = "#"+qty_field_id ;
		var qty = jQuery(quantity_field_id).val();
		if(qty == '' ||  qty == '0'){ // skip the action if qty is not proper 
			return false;
			//qty = 1;
		}
	}
	var postUrl = SITE_URL+'baskets/add_to_basket/'+product_id+'/'+qty+'/'+price+'/'+seller_id+'/'+condition+offer_product_val;
	//alert(postUrl);
	jQuery('#plsLoaderID').show();
	jQuery('#fancybox-overlay-header').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		
		/** Update the div**/
		jQuery('#shopping_basket_id').html(msg);
		jQuery('#plsLoaderID').hide();
		jQuery('#fancybox-overlay-header').hide();
		window.location.href="/baskets/view";
	}
	});
}

function showloading(){
	jQuery('#plsLoaderID').show();
	jQuery('#fancybox-overlay-header').show();
	
	height = jQuery(document).height();
	jQuery('#fancybox-overlay-header').css('height',height+'px');
}
function hideloading(chkParam){
	jQuery('#plsLoaderID').hide();
	jQuery('#fancybox-overlay-header').hide();
	if(chkParam=='name'){
		jQuery("#emailContainer").hide();
	}else if(chkParam=='email'){
		jQuery("#nameContainer").hide();
	}
}

</script>
<!--Header Start-->
	<?php echo $this->element('country_slider'); ?>
	<div id="content-NEW">
	<header>
    	<!--Select Country Start-->
    	
	
	<?php
		$selectedM='';
		$selectedP='';
		$selectedB='';
		$selectedD='';
		$pagecontroler = $this->params['controller'];
		$pageaction     = $this->params['action'];
		//$controllerPerm = array('marketplaces','pages','blog');
		switch($pagecontroler){
			case 'marketplaces':
				$selectedM = 'selected';
				break;
			case 'pages':
				$selectedP = 'selected';
				break;
			case 'blog':
				$selectedB = 'selected';
				break;
			case 'sellers':
				$selectedM = 'selected';
				break;
			case 'messages':
				$selectedM = 'selected';
				break;
			case 'orders':
				$selectedD = 'selected';
				break;
			default:
				$selectedD = 'selected';
				break;
		}
		if( $pagecontroler =='sellers' && ($pageaction  =='summary' || $pageaction  =='feedback' || $pageaction  =='returns' || $pageaction  =='store' )){
			$selectedM ='';
			$selectedD = 'selected';
		}
		
	?>
        <!--Select Country Closed-->
    	<!--Top Bar Start-->
    	<section class="topbar">
        	<section class="toplinks_widget">
            	<ul class="toplinks">
                	<li><?php echo $html->link('<span>Choiceful</span>',"/",array('class'=>$selectedD,'escape'=>false));?></li>
                    <li><?php echo $html->link('<span>Sell</span>',"/marketplaces/view/how-it-works",array('class'=>$selectedM,'escape'=>false));?></li>
                    <li><?php echo $html->link('<span>Help</span>',"/pages/view/help",array('class'=>$selectedP,'escape'=>false));?></li>
                    <li><?php echo $html->link('<span>Blog</span>',"/blog",array('class'=>$selectedB,'escape'=>false));?></li>
                </ul>
            </section>
            
            <section class="headerright">
            	<ul class="topright_links">
                	<li class="my_choiceful"><div>
			
			<?php echo $html->link('My Choiceful','/orders/view_open_orders',array('escape'=>false));?>
			<?php if(!empty($user_session)){ ?>|
			<?php echo $html->link('Log out',array('controller'=>'users','action'=>'logout'),null);?>
			<?php } ?>
			<!--| <a href="#">Logout</a>-->
			
			</div></li>
                    <li class="livehelpC"><script  type="text/javascript"  src="<?php echo SITE_URL;?>/app/webroot/phplive/js/phplive.js.php?d=0&base_url=%2F%2Fchoiceful.com%2Fapp%2Fwebroot%2Fphplive&text=Live Help"></script></li>
                    <li class="country"><a href="javascript:void('0');" id="countryDisplay">Store: <span id="dynamic_Coun"><?php echo $countryName;?></span></a></li>
                    <li class="cart" id="shopping_basket_id"><?php
					// include the mini basket for header 
					echo $this->element('basket/header_minibasket');
					?>
		    </li>
					<!--<a href="#">0 items - &pound;0.00</a>-->
                </ul>
            </section>
        </section>
        <!--Top Bar Closed-->
    	
        <!--Header Area Start-->
        <section class="header">
            <!--Logo Start-->
            <section class="logo"><?php echo $html->link('choiceful.com',"/",null);?></section>        
            <!--Logo Closed-->
            <?php echo $this->element('search');?>
            <!--Search Start--
            <section class="search_widget">
            	<section class="search_select"><a href="#" class="selectlink">Choiceful.com <span class="selarrow"></span></a></section>
                <section class="searchbtn">
                     <input type="submit" name="button4" value="Search" />
                </section>
                <section class="searchinput">
                    <p class="srchinputpad"><input type="text" name="textfield2" /></p>
                </section>
            </section>        
            Search Closed-->

        </section>
        <!--Header Area Closed-->
        
    </header>
    <!--Header Closed-->
    <?php
App::import('Model','Department');
$this->Department = & new Department();
# fetch list of  active departments 
$departments_list = $this->Department->find('list',array('conditions'=>array('Department.status'=>'1'),'fields'=>array('id','name'),'limit'=>10,'order'=>array('Department.id')));

$this->set('departments_list', $departments_list);
?>
    <!--Navigation Start-->
    <nav>
      <ul class="navigation" id="jMenu">
	<li id="home__">
			<?php 
			App::import('Model','Category');
			$this->Category = & new Category();
			$homeController = array('homes', 'faqs' , 'affiliates','pages', 'users');
			$homeAction     = array('a_z_index', '');
			
			if( $pagecontroler == 'homes' ){
				$activeClass = 'active';
				
			} else{
				$activeClass = 'firstnav';
			}
			
			echo $html->link('<span>Home</span>',array('controller'=>'homes'),array('escape'=>false,'class'=> $activeClass ));?>
	
			</li>
		<?php
			if(!isset($selected_department)){
				$selected_department = '';
			}
			if(!empty($departments_list)){
				foreach($departments_list as $department_id =>$department){
					if($pagecontroler != 'products' && $pageaction != 'bestseller_products'){
						if( $department_id == $selected_department ){
							$spanClass = 'active parent';
						} else{
							$spanClass = '';
						}
					}else{
						$spanClass = '';
					}
				?><li>
				
				
				<?php $dept_name = str_replace(array('&',' '), array('and','-'), html_entity_decode(strtolower($department), ENT_NOQUOTES, 'UTF-8'));?>
				<?php  echo $html->link($department.'<span class="downArrow"></span>',"/".$dept_name."/departments/index/".$department_id.'/',array('escape'=>false ,'class'=>"$spanClass fNiv"));?>
				
				<ul style="display:none;">
					
						<?php
							if( !is_null($department_id) && $department_id > 0 ){ 
								$topCategoryArr = $this->Category->find('list',array(
									'conditions' => array('Category.parent_id' => 0 , 'Category.department_id' =>$department_id, 'Category.status' => 1 ),
									'fields'=>array('Category.id','Category.cat_name'),
									
									//'limit'=>10,
									'order'=>array('Category.cat_name')));
									foreach($topCategoryArr as $catId=>$catName){
										$catName1 = strtolower(str_replace(array('&','/',' '), array('and','-','-'),$catName));
										echo "<li>". $html->link($catName,"/".$dept_name."/".$catName1."/categories/index/".$catId,array('escape'=>false)),"</li>";
									}
							}
							
							//pr($topCategoryArr);
							//die;
						?>
					
				</ul>
				
      
			</li>
			
				
				<?php
				}
			}?>
			
             
         <!---   <li><a href="#"><span>Books</span></a></li> 
            <li><a href="#"><span>Movies</span></a></li> 
            <li><a href="#"><span>Games</span></a></li>  
            <li><a href="#"><span>Electronics</span></a></li>  
            <li><a href="#"><span>Mobile</span></a></li> 
            <li><a href="#"><span>Office &amp; Computing</span></a></li> 
            <li><a href="#"><span>Home &amp; Garden</span></a></li>  
            <li><a href="#"><span>Healthy &amp; Beauty </span></a></li>  -->
        </ul>
    </nav>
    <?php
    $addClass ='';
     if(($pagecontroler == 'homes' || $pagecontroler == 'baskets')  && ($pageaction == 'index' || $pageaction == 'view')){
    $addClass = "style='border-bottom:none'";
    } ?>
    <section class="breadcrumb" <?php echo $addClass; ?>>
    	<!---<section class="breadcrumb_dots"> ...</section> 
	<?php  if(isset($product_breadcrumb_string) && !empty($product_breadcrumb_string)){ ?>
				<script>
				
				var chLen = "<?php echo strlen($product_breadcrumb_string); ?>";
				var lent = jQuery('#abc').width();
				//alert(document.getElementById("abc").offsetWidth);
				
				alert(lent-chLen);
				if(lent>chLen){
					document.write("<section class='breadcrumb_dots'> ...</section>");
				}
				
				</script>
				<?php  } ?>-->
        <section class="breadcrumb_frame">
            <ul>
		<?php if(in_array($pagecontroler,array('marketplaces','sellers','messages')) && !in_array($pageaction,array('sign_up','summary','feedback','returns','store','view','seller_location','sign_up_step2','sign_up_step3'))){
			echo $this->element('marketplace/breadcrum');
		}
		if(in_array($pagecontroler,array('orders'))){
			echo $this->element('orders/order_breadcrumb');
		}
		//Customers Viewing This Page May Be Interested in These Sponsored Links Closed -->
		if(in_array($pagecontroler,array('categories')) && in_array($pageaction,array('productdetail'))){
			if(isset($product_breadcrumb_string) && !empty($product_breadcrumb_string)){
				
				echo $product_breadcrumb_string;
			}
		}
		
		if(in_array($pagecontroler,array('sellers')) && in_array($pageaction,array('sign_up','sign_up_step2','sign_up_step3'))){?>
			<li><?php echo $html->link('Choiceful','/', array('escape'=>false,'class'=>''));?></li>
			<li><?php echo $html->link('Choiceful.com Marketplace',"/marketplaces/view/how-it-works'",array('escape'=>false,'class'=>'active'));?></li>
			<?php switch($pageaction){
				case 'sign_up':
					echo '<li class="last"><span>Create a Marketplace Account - Personal Information</span></li>';
					break;
				case 'sign_up_step2';
					echo '<li class="last"><span>Create a Marketplace Account - Business Information</span></li>';
					break;
				case 'sign_up_step3':
					echo '<li class="last"><span>Create a Marketplace Account - Seller Account Settings</span></li>';
					break;
				default:
				break;
				
				
				
			} //switch end
		} //if end
		if(in_array($pagecontroler,array('users')) && in_array($pageaction,array('login'))){
			echo "<li>".$html->link('Choiceful','/', array('escape'=>false,'class'=>''))."</li>";
			echo "<li>".$html->link("My Account",array("controller"=>"users","action"=>"my_account"),array('escape'=>false,'class'=>'active'))."</li>";
			echo "<li class='last'><span>Sign in</span></li>";
		}
		if(in_array($pagecontroler,array('users')) && in_array($pageaction,array('registration'))){
			echo "<li>".$html->link('Choiceful','/', array('escape'=>false,'class'=>''))."</li>";
			echo "<li>". $html->link("Sign In",array("controller"=>"users","action"=>"login"),array('escape'=>false,'class'=>'active'))."</li>";
			echo "<li class='last'><span>New Registration</span></li>";
		}
		if(in_array($pagecontroler,array('users')) && in_array($pageaction,array('forgotpassword'))){
			echo "<li>".$html->link('Choiceful','/', array('escape'=>false,'class'=>''))."</li>";
			echo "<li>". $html->link("My Account",array("controller"=>"users","action"=>"my_account"),array('escape'=>false,'class'=>'active'))."</li>";
			echo "<li class='last'><span>Forgot Password</span></li>";
		}
		if(in_array($pagecontroler,array('offers')) && in_array($pageaction,array('manage_offers','accepted_offers','rejected_offers'))){
		?>

		<li><?php echo $html->link('Choiceful', '/', array('alt'=>'') );?> </li>
		<li><?php echo $html->link('My Account', '/users/my_account', array('alt'=>'','class'=>'active') );?> </li>
		<li class="last"><span class="choiceful">Manage My Offers</span></li>
		<?php }
			if(in_array($pagecontroler,array('products')) && in_array($pageaction,array('my_reviews'))){
		?>
		<li><?php echo $html->link('Choiceful', '/', array('alt'=>'') );?> </li>
		<li><?php echo $html->link('My Account', '/orders/view_open_orders', array('alt'=>'','class'=>'active') );?> </li>
		<li class="last"><span class="choiceful">Orders</strong></li>
		<?php }
		
		if(in_array($pagecontroler,array('certificates')) && in_array($pageaction,array('apply_gift','gift_balance'))){
			?>
			<li><?php echo $html->link('Choiceful', '/', array('alt'=>'') );?> </li>
			<li><?php echo $html->link('My Account', '/orders/view_open_orders', array('alt'=>'','class'=>'active') );?> </li>
			<li class="last"><span class="choiceful">Gift Certificates</strong></li>
		<?php }
		if(in_array($pagecontroler,array('users')) && in_array($pageaction,array('my_account','manage_addresses','add_address','email_alerts','events_calendar'))){
			echo $this->element('useraccount/user_settings_breadcrumb');
		}
		if(in_array($pagecontroler,array('pages','faqs')) && in_array($pageaction,array('view','view'))){
			echo $this->element('top_navigation_staticpage');
		}
		if(isset($this->params['pass'][0]) && !empty($this->params['pass'][0])){
			$page_is = $this->params['pass'][0];
		}
		else {
			$page_is = '';
		}if(in_array($pagecontroler,array('products')) && in_array($pageaction,array('bestseller'))){
			?>
			<li><?php echo $html->link('Choiceful', '/', array('alt'=>'') );?> </li>
			<li class="last"><span class="choiceful">Bestsellers [All Departments]</strong></li>
		<?php }?>
		
		<?php if(in_array($pagecontroler,array('products')) && in_array($pageaction,array('bestseller_products'))){
			$dept_id = isset($this->params['pass'][0])?$this->params['pass'][0]:'';
			$dept_id = base64_decode($dept_id);
			$dept_name = '';
			$dept_name = $this->Department->find('first',array('conditions'=>array('Department.id'=>$dept_id),'fields'=>array('Department.name')));
			$dept_name = $dept_name['Department']['name'];
			$this->set('dept_name',$dept_name);
			$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($dept_name, ENT_NOQUOTES, 'UTF-8'));
			?>
			<li><?php echo $html->link('Choiceful', '/', array('alt'=>'') );?> </li>
			<li><?php echo $html->link('Bestsellers [All Departments]', '/products/all-department-topsellers', array('alt'=>'','class'=>'active') );?> </li>
			<li class="last"><span class="choiceful"><?php echo $dept_name;?></strong></li>
		<?php }
		if(in_array($pagecontroler,array('marketplaces')) && in_array($pageaction,array('view'))){
				echo "<li>".$html->link('Choiceful','/', array('escape'=>false,'class'=>''))."</li>";

				if($page_is=='how-it-works'){
									echo "<li>". $html->link("Choiceful.com Marketplace",array("controller"=>"marketplaces","action"=>"view",'how-it-works'),array('escape'=>false,'class'=>'active'))."</li>";

					$this->Html->addCrumb('How it works?', '');
					
				}
				
				else if($page_is=='marketplace-pricing'){
				echo "<li>". $html->link("Choiceful.com Marketplace",array("controller"=>"marketplaces","action"=>"view",'how-it-works'),array('escape'=>false,'class'=>'active'))."</li>";
				
				//$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
				$this->Html->addCrumb('Selling Fees', '');
				}
				
				else if($page_is=='international-sellers'){
				echo "<li>". $html->link("Choiceful.com Marketplace",array("controller"=>"marketplaces","action"=>"view",'how-it-works'),array('escape'=>false,'class'=>'active'))."</li>";
			//$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
				$this->Html->addCrumb('International Marketplace Stores', '',array('class'=>'last'));
				}
				
				else if($page_is=='marketplace-user-agreement'){
				echo "<li>". $html->link("Choiceful.com Marketplace",array("controller"=>"marketplaces","action"=>"view",'how-it-works'),array('escape'=>false,'class'=>'active'))."</li>";
	
				//$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
				$this->Html->addCrumb('Marketplace User Agreement', '');
				}
				
				else if($page_is=='faqs'){
				echo "<li>". $html->link("Choiceful.com Marketplace",array("controller"=>"marketplaces","action"=>"view",'how-it-works'),array('escape'=>false,'class'=>'active'))."</li>";
	
				//$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
				$this->Html->addCrumb('Marketplace FAQs', '');
				}
				
				else if($page_is=='choiceful-marketplace-sellers-guide'){
				echo "<li>". $html->link("Choiceful.com Marketplace",array("controller"=>"marketplaces","action"=>"view",'how-it-works'),array('escape'=>false,'class'=>'active'))."</li>";
	
				//$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
				$this->Html->addCrumb("Marketplace Seller's Guide", '');
				}
				echo "<li class='last'><span>".$this->Html->getCrumbs('' ,  '')."</span></li>";
	
			}
			if($pagecontroler == 'sellers' && $pageaction == 'seller_location'){
			?>
				<li><?php echo $html->link('Choiceful', '/', array('alt'=>'') );?> </li>
				<li><?php echo $html->link($this->Common->businessDisplayName($seller_id).' @ Choiceful.com', '/sellers/store/'.$seller_id, array('alt'=>'','class'=>'active') );?> </li>
				<li class="last"><span class="choiceful">Find Us Here</span></li>
			<?php }	
      
      	if($pagecontroler == 'sitemaps' && $pageaction == 'sitemap'){
			?>
				<li><?php echo $html->link('Choiceful', '/', array('alt'=>'') );?> </li>
				<li><?php echo	$this->Html->addCrumb('<span>Sitemap</span>', ''); ?></li>
			<?php	echo "<li class='last'><span>".$this->Html->getCrumbs('' ,  '')."</span></li>"; ?>
			<?php }	

			?>
	    <!--Navigation Closed-->
	  <?php  
	// pr($this->params['controller']);
	// pr($this->params['action']);/
	$controller_array = array('affiliates','categories','departments','gifts','advertisements','products','certificates','baskets','homes','sellers','baskets','homes','sitemaps');
	
	$action_topborder = array('a_z_index','productdetail');
	
	$action_sitemap_topborder = array('sitemap','product_categories','product_map','product_map_short','product_map_name');
	
	$action_fullfooter = array('viewproducts','view','searchresult','productdetail','purchase_gift','quick_order','summary','choiceful_on_mobile','feedback','returns','international_sites');
	
	//$action_fullfooter = array('viewproducts','view','searchresult','productdetail','purchase_gift','quick_order','international_sites','choiceful_on_mobile');
	
	
	if((in_array($this->params['controller'],$controller_array)) && (in_array($this->params['action'],$action_topborder) || in_array($this->params['action'],$action_fullfooter) || in_array($this->params['action'],$action_sitemap_topborder))) {
		if($this->params['action']=='view' || $this->params['controller']=='baskets' ) {
			$full_footer_class = "class='footer-right-margin border-top list-content'";
		} else if(in_array($this->params['action'],$action_topborder)  ) {
			$full_footer_class = "class='footer-right-margin border-top list-content'";
		} else if(in_array($this->params['action'],$action_fullfooter)){
			$full_footer_class = "class='footer-right-margin list-content'";
		}
		
		
			else if(in_array($this->params['action'],$action_sitemap_topborder)){
			$full_footer_class = "class='border-top list-content'";	
		} else{
			$full_footer_class = "class=' list-content'";
		}
	} else{
		$full_footer_class = '';
	}
	
	?>
	
	
	<!-- breadcrumb starts add on 21st Feb 2013-->
	<?php
	
	
	$controller_breadcrumb_array = array('affiliates','categories','departments','certificates','homes','sellers');
	$action_show_breadcrumb = array('index','summary','feedback','returns','viewproducts');
	
	if((in_array($this->params['controller'],$controller_breadcrumb_array)) && (in_array($this->params['action'],$action_show_breadcrumb))) {
		if(isset($breadcrumb_string) && !empty($breadcrumb_string)){
				echo  $breadcrumb_string;
		}
	
	}
	
	else if((in_array($this->params['controller'],$controller_breadcrumb_array)) && ($this->params['action']=='international_sites')){?>
	
	
		 <?php
			//echo "<div class='crumb_text_break'><strong>You are here:</strong>";
			//echo $html->link($html->image('/img/star_c.png', array("alt"=>"Choiceful.com",'class'=>'star_c')),'/',array('escape'=>false));
			//echo " </div><div class='crumb_img_break'> > " ;
			echo "<li><a class='' href='/'>Choiceful</a></li>";
			$this->Html->addCrumb('Choiceful.com Global Stores', '');
			echo "<li class='last'><span>".$this->Html->getCrumbs(' ' ,  $startText = false)."</span></li>";
			//echo "</div>" ;
			?>
	
		
		
	<?php } 
	
	
	else if((in_array($this->params['controller'],$controller_breadcrumb_array)) && ($this->params['action']=='a_z_index')){?>
	
	
		 <?php
		      //  echo "<div class='crumb_text_break'><strong>You are here:</strong>";
			//echo $html->link($html->image('/img/star_c.png', array("alt"=>"Choiceful.com",'class'=>'star_c')),'/',array('escape'=>false));
			//echo " </div><div class='crumb_img_break'> > " ;
			echo "<li><a class='' href='/'>Choiceful</a></li>";
			$this->Html->addCrumb('A to Z Category Index', '');
			echo "<li class='last'><span>".$this->Html->getCrumbs(' ' ,  $startText = false)."</span></li>";
			//echo "</div>" ;
			?>
	
		
	
	
	<?php }
	
	else if((in_array($this->params['controller'],$controller_breadcrumb_array)) && ($this->params['action']=='choiceful_on_mobile')){?>
	
	
		 <?php
	//echo "<div class='crumb_text_break'><strong>You are here:</strong>";
			///echo $html->link($html->image('/img/star_c.png', array("alt"=>"Choiceful.com",'class'=>'star_c')),'/',array('escape'=>false));
			//echo " </div><div class='crumb_img_break'> > " ;
			echo "<li><a class='' href='/'>Choiceful</a></li>";
			$this->Html->addCrumb('Choiceful Mobile', '');
			echo "<li class='last'><span>".$this->Html->getCrumbs(' ' ,  $startText = false)."</span></li>";
			//echo "</div>" ;
			?>
	
	
	
	<?php }
	
	else if(($this->params['controller']=='advertisements') && ($this->params['action']=='index')){
		
		
		?>
	
	
		 <?php
		      // echo "<div class='crumb_text_break'><strong>You are here:</strong>";
			//echo $html->link($html->image('/img/star_c.png', array("alt"=>"Choiceful.com",'class'=>'star_c')),'/',array('escape'=>false));
			//echo " </div><div class='crumb_img_break'> > " ;
			echo "<li><a class='' href='/'>Choiceful</a></li>";
			$this->Html->addCrumb('Advertise With Choiceful', '');
			echo "<li class='last'><span>".$this->Html->getCrumbs(' ' ,  $startText = false)."</span></li>";
			//echo "</div>" ;
			?>
		
		
		
	<?php } 
	
	else if((in_array($this->params['controller'],$controller_breadcrumb_array)) && ($this->params['action']=='view')){
		?>
	
	
		 <?php
		       // echo "<div class='crumb_text_break'><strong>You are here:</strong>";
			//echo $html->link($html->image('/img/star_c.png', array("alt"=>"Choiceful.com",'class'=>'star_c')),'/',array('escape'=>false));
			//echo " </div><div class='crumb_img_break'> > " ;
			echo "<li><a class='' href='/'>Choiceful</a></li>";
			if($this->params['pass'][0]==1){
			$this->Html->addCrumb('Affiliate Program - Make Money Advertising Choiceful', '');
			}
			else if($this->params['pass'][0]==2){
			$this->Html->addCrumb('Affiliate Program - Join Us', '');
			}
			else if($this->params['pass'][0]=='faq'){
			$this->Html->addCrumb('Affiliate Program - FAQs', '');
			}
			else if($this->params['pass'][0]==3){
			$this->Html->addCrumb('Affiliate Program - Contact Affiliates', '');
			}
			
			echo "<li class='last'><span>".$this->Html->getCrumbs('' ,  $startText = false)."</span></li>";
			//echo "</div>" ;
			?>
		
		
	
	
	
	<?php }
	
	else if((in_array($this->params['controller'],$controller_breadcrumb_array)) && ($this->params['action']=='purchase_gift')){
		
		?>
	
	
		 <?php
			//echo "<div class='crumb_text_break'><strong>You are here:</strong>";
			//echo $html->link($html->image('/img/star_c.png', array("alt"=>"Choiceful.com",'class'=>'star_c')),'/',array('escape'=>false));
			//echo " </div><div class='crumb_img_break'> > " ;
			echo "<li><a class='' href='/'>Choiceful</a></li>";
			$this->Html->addCrumb('Choiceful.com Gift Certificates - Give The Gift of Choice', '');
			echo "<li class='last'><span>".$this->Html->getCrumbs(' ' , $startText = false)."</span></li>";
			//echo "</div>" ;
			?>
		
		
		
	<?php }
	
	else if((in_array($this->params['controller'],$controller_breadcrumb_array)) && ($this->params['action']=='store')){
		
		?>
	
		 <?php
			echo "<li><a class='' href='/'>Choiceful</a></li>";
			//echo $html->link($html->image('/img/star_c.png', array("alt"=>"Choiceful.com",'class'=>'star_c')),'/',array('escape'=>false));
			//echo " </div><div class='crumb_img_break'> > " ;
			
			$this->Html->addCrumb($seller_info['Seller']['business_display_name'].' @ Choiceful.com', '');
			echo '<li class="last"><span>'.$this->Html->getCrumbs(' ' ,  $startText = false)."</span></li>";
			//echo "</div>" ;
			?>
		
		
		
	<?php } ?>
	
	
	  <!--Sub Nav Start--
	 <script type="text/javascript">
		    jQuery(document).ready(function() {
			jQuery("#jMenu").jMenu();
		    });
		</script>
		      <!--  <a href="#">Choiceful</a></li>
			<li><a href="#">Home &amp; Garden</a></li>   
			<li><a href="#">Building Supplies</a></li>
			<li><a href="#">Adhesives</a></li>   
			<li><a href="#" class="active">All Adhesives</a></li>  
			<li class="last"><span>Apple MacBook Pro MC976B/A 15-inch/Retina Display/Quad-Core i7 2.6GHz/8GB RAM/512GB Flash Storage/Intel Display/uad-Core i7 2.6GHz/8GB RAM/512GB Flash Storage/Intel Display...</span></li>
           ---> </ul>
        </section>
    </section>
<!--Sub Nav Closed-->
<style>
/* for fead img over ot light box*/
#fancybox-overlay-listing {
    background-color: #000000;
    display: none;
    left: 0;
    opacity: 0.4;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 1110;
}
/* END*/
	
</style>
<div id="fancybox-overlay-header"></div>
<!--Navigation Closed-->
<div id="plsLoaderID" class="dimmer" style="display:none">
	<?php echo $html->image("ajax-loader.gif" ,array('alt'=>"Loading"));?>
	Loading, please wait
</div>
<div id="fancybox-overlay-listing" style="display:none"></div>
<script>
	
jQuery(document).ready(function() {
	
	jQuery("#jMenu").jMenu();
	
	height = jQuery(document).height();
	jQuery('#fancybox-overlay-header').css('height',height+'px');
	jQuery('#fancybox-overlay-listing').css('height',height+'px');
	
	

});
</script>