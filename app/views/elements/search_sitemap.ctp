<?php
App::import('Model','Department');
$this->Department = &new Department;
$departments_list = $this->Department->find('list');
if(!isset($department_id)){
	$department_id = '';
}
if(!isset($sort)){
	$sort = "";
}
if(!isset($fhloc)){
	$fhloc = "";
}
if(!isset($ftitle)){
	$ftitle = "";
	$fvalue = "";	
}
?>
<!--Right Content Start-->
<div class="right-content margin-none"> 
	<?php
	//Comented by nakul on 26 Apr on 2012 passing the keyword work on url.
	echo $form->create("product",array("action"=>"/searchresult/","method"=>"get", "id"=>"frmSearchproduct", "name"=>"frmSearchproduct")); ?>
	<!--Search Widget Start-->
	<div class="search-widget">
		<div class="search-widget-left-crnr">
			<!--Button Start-->
			<div class="button-widget float-right">
				<?php //echo $form->button('Search',array('type'=>'submit','class'=>'orange-btn', 'label'=>false,'div'=>false, 'escape'=>false) );?>
				<input type="submit" id="submit" name="button" class="orange-btn" value="Search" />
			</div>
			<!--Button Closed-->
			<div class="left-float">
				<?php
				//commented by nakul on 24-04-2012 for selected departemtns 
				//echo $form->select('Marketplace.department',$departments_list,$department_id,array('style'=>'width:20%','class'=>'textfield', 'type'=>'select'),'Choiceful.com'); ?>
				<?php
					if(isset($selected_department) && !empty($selected_department)){
						$selected_department = $selected_department;
					}else{
						$selected_department = $department_id;
					}
					
					if(!empty($selected_department) || $ftitle =="department_name"){
						$disabled = 'disabled';
					}else{
						$disabled = '';
					}
					
				?>
				<?php echo $form->select('Marketplace.department',$departments_list,@$selected_department,array('style'=>'width:20%','class'=>'textfield', $disabled =>$disabled, 'type'=>'select'),'Choiceful.com'); ?>
				<?php echo $form->hidden('Product.sort',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$sort));?>
				<?php echo $form->hidden('Product.fhloc',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$fhloc));?>
				<?php echo $form->hidden('Product.ftitle',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$ftitle));?>
				<?php echo $form->hidden('Product.fvalue',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$fvalue));?>
				<?php echo $form->input('Marketplace.keywords',array('id'=>'search_keywords', 'value'=>@$searchWord, 'class'=>'textfield', 'style'=>'width:78%', 'label'=>false,'div'=>false, 'escape'=>false));?>
			</div>
		</div>
	</div>
	<!--Search Widget Closed-->
	<?php  echo $form->end(); ?>
</div>
<!--Right Content Closed-->

<?php if($this->params['action'] != 'return_items' && $this->params['controller'] != 'orders') { ?>
<script type="text/javascript">
jQuery(document).ready( function(){
	document.getElementById('search_keywords').focus();
	 
} );

jQuery("#frmSearchproduct").submit(function() {
var search_keywords = jQuery('#search_keywords').val();
var search_keywords = search_keywords.replace(/[^A-Za-z0-9\-\s]/g, "");
var department_id = jQuery('#MarketplaceDepartment').val();
var product_sort = jQuery('#ProductSort').val();

var url_fh = jQuery('#ProductFhloc').val();
var ftitle = jQuery('#ProductFtitle').val();
var fvalue = jQuery('#ProductFvalue').val();


var urls= "<?php echo SITE_URL;?>products/searchresult/";
	if((search_keywords != "")){
		urls= urls = urls+'keywords:'+search_keywords;
	if((department_id != "")){
		urls = urls+"/dept_id:"+department_id;
	}
	if((product_sort != "")){
		urls = urls+"/sort_by:"+product_sort;
	}
	if((url_fh != "")){
			urls = urls+"/fh_loc:"+url_fh;
		}
	if((ftitle != "")){
		urls = urls+"/ftitle:"+ftitle;
	}
	if((fvalue != "")){
		urls = urls+"/fvalue:"+fvalue.replace("<","%3C");
	}
	}
	window.location.href = urls;
	return false;
});


</script>
<?php }?>