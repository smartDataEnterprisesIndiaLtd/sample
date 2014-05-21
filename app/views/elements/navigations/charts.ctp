<?php

$controller_name = $this->params['controller'];
$action_name 	 = $this->params['action'];
$controllerNameArray = array('homes', 'departments');

if( in_array($controller_name, $controllerNameArray  ) ) {
?>
<!--Charts Start-->
<div class="side-content">
	<h4 class="gray-bg-head"><span>Charts</span></h4>
	<div class="gray-fade-bg-box padding">
		<ul>
			<li><?php echo $html->link("Top Sellers","/products/all-department-topsellers",array('escape'=>false));?></li>
		</ul>
	</div>
</div>
<!--Charts Closed-->
<?php  } ?>