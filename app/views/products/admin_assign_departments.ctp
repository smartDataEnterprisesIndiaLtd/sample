<?php
$this->Html->addCrumb('Product Management', ' ');
$this->Html->addCrumb('Assign Multiple Departments', 'javascript:void(0)');
?>
<div id="proadd">
<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
//echo $javascript->link(array('jquery-1.3.2.min'));
echo  $javascript->link('uploadmultiplephoto');
//echo $javascript->link(array('jquery.MultiFile'),false);
echo $javascript->link('fckeditor');

echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
?>

<?php

echo $form->create('Product',array('action'=>'assign_departments/'.$product_id,'method'=>'POST','name'=>'frmProduct','id'=>'frmProduct'));


echo $form->input('Product.id',array('value'=>$product_id));

?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td valign="top">
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr class="adminBoxHeading reportListingHeading">
					<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
					<td class="adminGridHeading" align="right">
						<?php
						echo $html->link('Back ', '/admin/products/');
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%"><tr><td>&nbsp;</td></tr>
							<?php if(!empty($departments_array)) {
							foreach($departments_array as $dept_id => $department) {
								$categories = '';
								if(!empty($cat_departments_array)){
								foreach($cat_departments_array as $cat_department_index => $cat_departments){
									if($cat_department_index == $dept_id) {
										if(!empty($cat_departments)){
											$categories = '';
											foreach($cat_departments as $dept_cat){
												if(empty($categories))
													$categories = $dept_cat;
												else
													$categories = $categories.','.$dept_cat;
											}
										}
									}
								}
								}
							?>
							<tr>
								<td>
									<?php
echo $form->checkbox('Product.department.'.$dept_id,array('value'=>$dept_id,'onChange'=>'showProductTemplate(this.value)')); echo ' '.$department; ?></td>
							</tr>
							<tr>
								<?php echo $form->hidden('Product.categories'.$dept_id,array('value'=>@$categories,'label'=>false,'div'=>false)); ?>
								<td  align="center" id="dep_wise_category_div<?php echo $dept_id; ?>"></td>
							</tr>
				<?php } }?>
							<tr><td >&nbsp;</td></tr>
							<tr>
								
								<td align="left" >
								<?php
									echo $form->button('Save',array('value'=>'save', 'name' =>'submit' , 'type'=>'submit','class'=>'btn_53','div'=>false));
								?>
								<?php
								echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/products')"));?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script type="text/javascript" language="javascript">
// function to get department based templates
function showProductTemplate(depId){
	var catgories = '';
	catgories = jQuery('#ProductCategories'+depId).val();
	<?php if(!empty($product_id)){?>
		productId = '<?php  echo $product_id; ?>';
		
	<?php  }?>
	showCategoryCombo(depId,catgories);
}
// function to get department based category combo box
function showCategoryCombo(depId,catgories){
	
	if(depId == ''){
		jQuery('#dep_wise_category_div').html('');
	} else {
		var checked_value = jQuery('#ProductDepartment'+depId).attr('checked');
		if(checked_value == true){
			jQuery('#preloader').show();
			var postUrl = SITE_URL+'products/get_departmentcategory/'+depId+'/'+catgories;
			jQuery.ajax({
				cache:false,
				async: false,
				type: "GET",
				url: postUrl,
				success: function(msg){
					jQuery('#dep_wise_category_div'+depId).html(msg);
					jQuery('#preloader').hide();
				}
			});
		} else {
			jQuery('#dep_wise_category_div'+depId).html('');
		}
	}
}


function checked_departments(dept_id, catego_ids){
	jQuery('#ProductDepartment'+dept_id).click();

}
</script>
<?php
if(!empty($cat_departments_array)){
	
	foreach($cat_departments_array as $dept_index_cat => $cat_dept_arr){
		$dept_cat_id = '';
		if(empty($str_cat_dept)){
			$dept_cat_id = $dept_index_cat;
		}
		?>
		<script>
			var dept_id = <?php echo @$dept_cat_id;?>;
			var dept_cat_str = '<?php echo @$str_cat_dept;?>';
			checked_departments(dept_id);
		</script><?php 
	}
}
?>
</div>