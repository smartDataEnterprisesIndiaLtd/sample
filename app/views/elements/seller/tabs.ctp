<?php 
$action = $this->params['action'];
?>
<!--Tabs Start-->
<div class="tbs-wdgt">
	<ul>
		<li><?php
			if($action == 'summary') { $class = 'active'; } else { $class = ''; }
			$seller_name_url=str_replace(' ','-',html_entity_decode($seller_info['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
			echo $html->link('Seller Summary','/sellers/'.$seller_name_url.'/summary/'.$seller_id.'/'.$product_id.'/'.$condition_id,array('class'=>$class,'escape'=>false));?></li>
		<li><?php 
			if($action == 'feedback') { $class = 'active'; } else { $class = ''; }
			$seller_name_url=str_replace(' ','-',html_entity_decode($seller_info['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
			echo $html->link('Feedback','/sellers/'.$seller_name_url.'/feedback/'.$seller_id.'/'.$product_id.'/'.$condition_id,array('class'=>$class,'escape'=>false));?></li>
		<li><?php 
			if($action == 'returns') { $class = 'active'; } else { $class = ''; }
			$seller_name_url=str_replace(' ','-',html_entity_decode($seller_info['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
			echo $html->link('Returns','/sellers/'.$seller_name_url.'/returns/'.$seller_id.'/'.$product_id.'/'.$condition_id,array('class'=>$class,'escape'=>false));?></li>
	</ul>
	<div class="clear"></div>
</div>
<!--Tabs Closed-->