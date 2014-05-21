<?php
App::import('Model','Department');
$this->Department = &new Department;
$departments_list = $this->Department->find('list');
if(!isset($department_id)){
	$department_id = '';
}
?>
<!--Right Content Start-->
<div>
	<?php echo $form->create("product",array("action"=>"/searchresult/","method"=>"get", "id"=>"frmSearchproduct", "name"=>"frmSearchproduct")); ?>
	<!--Search Widget Start-->
	<div class="search-widget">
		<div class="search-widget-left-crnr">
			<!--Button Start-->
			<div class="button-widget float-right">
				<?php //echo $form->button('Search',array('type'=>'submit','class'=>'orange-btn', 'label'=>false,'div'=>false, 'escape'=>false) );?>
				<input type="submit" name="button" class="orange-btn" value="Search" />
			</div>
			<!--Button Closed-->
			<div class="left-float">
				<?php echo $form->select('Marketplace.department',$departments_list,$department_id,array('style'=>'width:20%','class'=>'textfield', 'type'=>'select'),'Choiceful.com'); ?>
				<?php echo $form->input('Marketplace.keywords',array('id'=>'search_keywords', 'class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false));?>
			</div>
		</div>
	</div>
	<!--Search Widget Closed-->
	<?php  echo $form->end(); ?>
</div>
<!--Right Content Closed-->


