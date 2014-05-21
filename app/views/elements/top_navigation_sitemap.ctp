<?php
$action_params = $this->params['action'];
$controller_params = $this->params['controller'];
if(($controller_params == 'departments' && $action_params == 'index') || !empty($selected_department)){
	$hot_searchs = $this->Common->fh_call_hotsearch($selected_department);
}else {
	$hot_searchs = $this->Common->fh_call_hotsearch();
}
 ?><!--Sub Nav Start-->
<div class="sub-nav">
	
	<ul>
		<?php //if(($action_params == 'bestseller' || $action_params == 'bestseller_products') && $controller_params == 'products'){?>
		<li class="first"><?php echo $hot_searchs['slogan']['slogan'];?></li>
		<?php if(!empty($hot_searchs)){
			
			foreach($hot_searchs['items'] as $hot_search) {
				$pro_id = $this->Common->getProductId_Qccode($hot_search['secondid']);?>
				<li><?php echo $html->link($hot_search['product_name'],'/'.$this->Common->getProductUrl($pro_id).'/categories/productdetail/'.$pro_id,array('escape'=>false));?></li>
			<?php }
		}?>
	</ul>
	
	
</div>
<!--Sub Nav Start-->