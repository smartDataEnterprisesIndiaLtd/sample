<?php $user_session = $this->Session->read('User');
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
?>
<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
	<a name="top" id="top"></a>
<div id="header" class="page-holder">
	<!--Logo Start-->
	<div class="logo"><?php echo $html->link('',"/",null);?></div>
	<!--Logo Closed-->
	<div class="tagline">
		<?php if(!empty($user_session)){ ?>
			<strong>Hello <?php
			if(isset($user_session['firstname'])){
				echo ucfirst($user_session['firstname']);	
			}?>,</strong> it's great to welcome you back again. <?php echo $html->link('Click here',array('controller'=>'users','action'=>'logout'),null);?> to logout.
		<?php }?>
	</div>
	<!--Top Right Start-->
	<div class="top-right">
		<ul class="top-links">
			<li><?php echo $html->link('My Account','/orders/view_open_orders',array('escape'=>false));?>  | <?php echo $html->link('Customer Service',"/pages/view/help-topics",null);?></li>    <li><?php echo $html->link('Change', array('controller'=>'homes','action'=>'international_sites'),null);?> &pound;</li> <li><?php echo $html->image("flag.gif" ,array('width'=>"17",'height'=>"11", 'alt'=>"" )); ?></li>
		</ul>
		<!--Shopping Cart Widget Start-->
		<div class="shopping-cart-widget" >
			<div class="blue-head-box">
				<div class="blue-head-top"><span>My Shopping Basket</span></div>
				<div class="box-mid-content" id="shopping_basket_id">
				<?php
				// include the mini basket for header 
				//echo $this->element('basket/header_minibasket');
				?>
				</div>
				<div class="box-bottom-widget">
					<span></span>
				</div>
			</div>
		</div>
		<!--Shopping Cart Widget Closed-->
	</div>
	<!--Top Right Closed-->
	<!--Right Links Start-->
	<div class="right-links">
		<?php echo $html->link('A to Z Index',"/departments/a_z_index",null,false,false);?>
		<?php echo $html->link('Quick order',"/baskets/quick_order",null);?>
		<!-- BEGIN PHP Live! code, (c) OSI Codes Inc. --><script type="text/javascript" src="//t1.phplivesupport.com/ramanpreet/js/phplive.js.php?d=1&base_url=%2F%2Ft1.phplivesupport.com%2Framanpreet&text=Live Help"></script><!-- END PHP Live! code, (c) OSI Codes Inc. --> 
	</div>
	<!--Right Links Closaed-->
</div>





<?php
//echo $show_department;
//pr($this->params);
# import department model to Display list of departments on the header bar 
App::import('Model','Department');
$this->Department = & new Department();

# fetch list of  active departments 
$departments_list = $this->Department->find('list',array('conditions'=>array('Department.status'=>'1'),'fields'=>array('id','name'),'limit'=>10,'order'=>array('Department.id')));

$this->set('departments_list', $departments_list);

//pr($departments_list);
?>

<!--Navigation Start-->
<div id="navigation">
	<!--Main Nav Start-->
	<div class="navigation">
		<ul>
			<li id="home__">
			<?php
			$pagecontroler = $this->params['controller'];
			$pageaction     = $this->params['action'];
			
			$homeController = array('homes', 'faqs' , 'affiliates','pages', 'users'  );
			$homeAction     = array('a_z_index', '');
			
			
			//if( in_array(  $pagecontroler, $homeController )  ||  in_array($pageaction, $homeAction) ){
			if( $pagecontroler == 'homes' ){
				$activeClass = 'selected';
			}else{
				$activeClass = 'active';
			}
			
			echo $html->link('<span>Home</span>',array('controller'=>'homes'),array('escape'=>false,'class'=> $activeClass ));?>
			</li>
			<?php
			if(!isset($selected_department)){
				$selected_department = '';
			}
			if(!empty($departments_list)){
				foreach($departments_list as $department_id =>$department){
					if( $department_id == $selected_department ){
						$spanClass = 'selected';
					}else{
						$spanClass = '';
					}
				?>
				<!--<li><a href="#" class="selected"><span><?php echo $department; ?> </span></a></li> -->
				<li><?php  echo $html->link('<span>'.$department.' </span>',"/departments/index/".$department_id,array('escape'=>false ,'class'=>$spanClass ));?></li>
			<?php
			 }
			}?>
			 <li><?php echo $html->link('<span>Sell Your Stuff</span>',"/marketplaces/search_product",array('escape'=>false));?>
				<!--<a href="/marketplaces/search_product"><span>Sell Your Stuff</span></a> --></li> 
		</ul>
	</div>
	<!--Main Nav Closed-->
	<div class="clear"></div>
</div>

<!--Navigation Closed-->