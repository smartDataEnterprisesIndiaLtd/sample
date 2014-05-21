<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'), false); ?> <!--mid Content Start-->
<div class="mid-content pad-rt-none recent-history-widget">
	<div class="breadcrumb-widget font-size13">
		<?php echo $html->link('<strong>Home</strong>','/homes/',array('escape'=>false,'class'=>'underline-link'));?> &gt; 
		<?php 
		$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($dept_name, ENT_NOQUOTES, 'UTF-8'));
		//echo $html->link('<strong>Bestsellers [All Departments]</strong>','/'.$dept_url_name.'-topsellers-top-100/products/bestseller',array('escape'=>false,'class'=>'underline-link'));?>
		<?php echo $html->link('<strong>Bestsellers [All Departments]</strong>','/products/all-department-topsellers',array('escape'=>false,'class'=>'underline-link'));?> &gt; 
		<span class="choiceful"><strong><?php echo $dept_name;?></strong></span>
	</div>
	<!--Sorting Start-->
	
		<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
	<div id = "abclist">
		<?php echo $this->element('product/best_products');?>
	</div>
</div>
<!--mid Content Closed-->