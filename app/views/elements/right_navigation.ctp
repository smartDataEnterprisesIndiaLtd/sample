<?php ?>
<!--Right Widget Start-->
<?php 
/*if(!empty($this->params['pass'][0])){
	$styler = 'style="padding-top: 30px;"';
} else{
	$styler = 'style="padding-top: 10px;"';
}*/
?>
<div class="right-widget" >
	
		
	<?php
	// include the top banner and 
	// pr($this->params);
	$controller_name = $this->params['controller'];
	$action_name 	 = $this->params['action'];
	//$QS1  	 	 = $this->params['pass'][0];
	//$QS2	 	 = $this->params['pass'][1];
	
	
	// include right home page navigation for department and homes only 
	if($controller_name == 'departments' ||  $controller_name == 'homes' ){
		echo $this->element('navigations/right_navigation_home');
	}
	
	// include right category navigation for category page only 
	if($controller_name == 'categories' &&  $action_name == 'index' ){
		echo $this->element('navigations/right_navigation_category');
	}
	
	
	?>
	
</div>
<!--Right Widget Closed-->