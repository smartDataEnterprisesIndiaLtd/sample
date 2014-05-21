<?php

$controller_name = $this->params['controller'];
$action_name 	 = $this->params['action'];



?>
<!--Left Content Start-->
<div class="left-content">
<?php

$controllerNameNeedtop2  = array('departments' , 'homes');
$actionNameNeedtop2  = array('a_z_index', 'choiceful_on_mobile');

if( in_array( $controller_name, $controllerNameNeedtop2 )  &&  in_array( $action_name, $actionNameNeedtop2 )  ) {
	
	 echo $this->element('navigations/left_links');
	 echo $this->element('navigations/help');
	
}else{
	if($this->params['action'] == 'searchresult' && $this->params['controller'] == 'products')
		echo $this->element('product/filter_products_users');

	echo $this->element('navigations/giftCertificate_links');
	echo $this->element('navigations/hot_picks');
	echo $this->element('navigations/charts');
	echo $this->element('navigations/help');
	echo $this->element('navigations/services');
	echo $this->element('navigations/business');
	echo $this->element('navigations/choiceful_favorites');
	echo $this->element('navigations/secure_shopping');
	
}?>
	
</div>
<!--Left Content Closed-->
