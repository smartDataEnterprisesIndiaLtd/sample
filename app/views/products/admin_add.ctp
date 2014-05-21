<div id="proadd">
<?php
$this->Html->addCrumb('Product Management', ' ');
if(!empty($id)){
$this->Html->addCrumb('Edit Details', 'javascript:void(0)');
}else{
$this->Html->addCrumb('Add New Product', 'javascript:void(0)');
}
echo $javascript->link(array('lib/prototype'),false);
//echo $javascript->link(array('jquery-1.3.2.min'));
echo  $javascript->link('uploadmultiplephoto');
//echo $javascript->link(array('jquery.MultiFile'),false);
echo $javascript->link('fckeditor');

echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');

$params = $this->params['named'];
$params_url = '';
foreach($params as $key => $values){
	$params_url = $params_url.'/'.$key.':'.$values;
}

//pr($this->data['Product']);
/*
   $templateValues = array('suitable_for', 'how_to_use', 'hazard_caution',
    'precautions','ingredients', 'author_name', 'publisher','language','product_isbn','format',
    'pages','publisher_review','year_published','artist_name','label','rated','number_of_disk',
    'track_list','release_date', 'star_name','directedby','studio', 'run_time','plateform','region');




$arrName = array();
$arrValues = array();
if(!empty($this->data['Product']) ){
	$ids = '';
	$valuess = '';
	
	foreach($this->data['Product'] as $key =>$val){
		
		if(in_array($key ,$templateValues) ){
			if(!empty($val) && !is_array($val) ){
				
				$keyVal  = "data[Product][$key]";
				$newName = "input[name='$keyVal']";
				$ids 	 .= '"'.$newName.'" ,';
				$valuess .= '"'.$val.'" ,';
				$arrName[] = $newName;
				$arrValues[] = $val;
			}
		}
	}
	$fieldIds = rtrim($ids, ",");
	$fieldValues = rtrim($valuess, ",");
	
}
$arrFieldCount = count($arrName);
//pr($arrName);


*/

?>

<?php 
echo $javascript->link(array('autocomplete/jquery.autocomplete'));
echo $this->Html->css(array('autocomplete/jquery.autocomplete'));
?>

<script type="text/javascript" language="javascript">	
jQuery(document).ready(function(){
	var depId = jQuery("#ProductDepartmentId").val();
	if( depId != ''){
		showProductTemplate(depId);
	}
});

// function to add other brand name in brand DB
function addBrandName(){
	brand_name = jQuery('#other_brand_name').val();
	//alert(brand_name);
	jQuery('#other_brand_name').val('');
	if(brand_name != ''){
		jQuery('#preloader').show();
		brand_name = brand_name.replace('&','and');
		var postUrl =  SITE_URL+'totalajax/add_get_brand_name/'+brand_name
		jQuery.ajax({
			cache:false,
			async: false,
			type: "POST",
			url: postUrl,
			success: function(msg){
				jQuery('#brand_selection_box').html(msg);
				jQuery('#preloader').hide();
				jQuery('#other_brand_name_holder').hide();
			}
		 });
	}
}
jQuery(function() {
	jQuery("#valid_brand_name").autocomplete("/products/get_autocomplete_brandlist", {
				matchContains: false,
				selectFirst: false
		    });
	 
});
// function to add other brand name in brand DB
function addColorName(){
	color_name = jQuery('#other_color_name').val();
	//jQuery('#other_color_name').val('');
	if(color_name != ''){
		jQuery('#preloader').show();
		//color_name = color_name.replace('&','and');
		var postUrl =  SITE_URL+'totalajax/add_get_color_name/'+color_name
		jQuery.ajax({
			cache:false,
			async: false,
			type: "POST",
			url: postUrl,
			success: function(msg){
				jQuery('#color_selection_box').html(msg);
				jQuery('#preloader').hide();
				jQuery('#other_color_name_holder').hide();
			}
		 });
	}
}

jQuery(function() {
	jQuery("#valid_color_name").autocomplete("/products/get_autocomplete_colrolist", {
				matchContains: false,
				selectFirst: false
		    });
	 
});

	
	function manageGdProductName(){
		if (document.getElementById('gd_checked').checked){
		    document.getElementById('gd_show').style.display = "";
		    document.getElementById('ProductGdProductName').value = document.getElementById('ProductProductName').value;
		    
		}else{
			 document.getElementById('ProductGdProductName').value = "";
			 document.getElementById('gd_show').style.display = "none";
			 
		}
	}
</script>

<?php

if(!empty($new_product_id) ){
	
	echo $form->create('Product',array('action'=>'add/'.$id.'/'.$new_product_id.'/'.$params_url,'method'=>'POST','name'=>'frmProduct','id'=>'frmProduct','enctype'=>'multipart/form-data'));
	echo $form->hidden('Product.new_product_id',array('value'=>$new_product_id));
}else{
	echo $form->create('Product',array('action'=>'add/'.$params_url,'method'=>'POST','name'=>'frmProduct','id'=>'frmProduct','enctype'=>'multipart/form-data'));
	echo $form->hidden('Product.new_product_id',array('value'=>''));
}

echo $form->hidden('Product.back_page_url',array('value'=>$back_page_url));

?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
<tr>
<td valign="top">
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" align="right">
			<?php
			     if(is_array($newProductData) ){
				echo $html->link('Back ', '/admin/products/newproducts');
			     }else{
				echo $html->link('Back ', '/admin/products/');
			     }?>
		</td>
	</tr>
	
	<tr>
		<td colspan="2">
			<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
				<tr height="20px">
					<td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.
					<?php echo $form->error('Product.categories');
					?>
					</td>
				</tr>
			<?php if(is_array($newProductData) ){ ?>
			<tr>
				<td align="center" width="100%"  colspan="2"> 
					<table  border="0" cellpadding="2" cellspacing="2" width="100%"  style="background-color:#FFF7D6;">
					<tr><td align="left" colspan="2" >Product's Details Entered by Seller:</td>
					 </td>
					</tr>
					<tr>
						<td align="left" width="20%" >Brand Name :</td>
						<td align="left" ><?php echo $newProductData['ProductSiteuser']['brand_name'];?>
					 </td>
					</tr>
					<tr>
						<td align="left" width="20%" >Main Category Name :</td>
						<td align="left" ><?php echo $newProductData['Category']['cat_name'];?></td>
					</tr>
					</table>
				</td>
			</tr>
			<?php  } ?>
				<tr>
					<td align="right" width="20%"><span class="error_msg">*</span> Product Name  :</td>
					<td align="left">
						<?php echo $form->input('Product.product_name',array('class'=>'textbox-m','label'=>false,'maxlength'=>500,'div'=>false));?>
					</td>
				</tr>
				<?php 
				if($this->data['Product']['gd_product']=='1'){
				}else{
					$style = 'display:none;';
				}
				?>
				<tr id="gd_show" style = "<?php echo $style; ?>;">
					<td align="right" width="20%"><span class="error_msg">*</span> Gd Product Name  :</td>
					<td align="left">
						<?php echo $form->input('Product.gd_product_name',array('class'=>'textbox-m','label'=>false,'maxlength'=>500,'div'=>false));?>
					</td>
				</tr>
				
				<tr >
					<td align="right"><span class="error_msg">*</span> Brand Name :</td>
					<td align="left" >
						<table  border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
						<td align="left" width="80%" id="brand_selection_box">
						<?php //echo $form->select('Product.brand_id',$product_brand_array,null,array('class'=>'textbox-m', 'type'=>'select'),'Select Brand..'); ?>
						
						<?php echo $form->input('Product.brand_name', array('autocomplete'=>"off",'type'=>'text','id'=>'valid_brand_name', 'div'=>false,'label'=>false,'class'=>'textbox-m','style'=>'width:50%;')); ?>
						<?php echo $form->error('Product.brand_id'); ?>
						</td>
						<td align="left" width="20%">
						<a href="javascript:void(0)" onClick="javascript:jQuery('#other_brand_name_holder').show();" title="Add new brand">
							<strong>Add New Brand</strong>
						</a></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr id="other_brand_name_holder"  style="display:none;">
					<td align="right" width="20%"><span class="error_msg"></span>Other Brand Name  :</td>
					<td align="left">
						<?php echo $form->input('other_brand_name',array('id'=>'other_brand_name', 'class'=>'textbox-m','label'=>false,'div'=>false));?>
						<?php echo $form->button('Add',array('type'=>'button','class'=>'textbox','onClick'=>"addBrandName()"));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'textbox','onClick'=>"javascript:jQuery('#other_brand_name_holder').hide();"));?>
					</td>
				</tr>	
				<tr>
					<td align="right" width="20%" ><span class="error_msg">*</span>EAN/UPC (Bar Code) :</td>
					<td align="left">
						<?php echo $form->input('Product.barcode',array('class'=>'textbox-m','label'=>false,'div'=>false));?> 
						<?php //echo $html->link("<strong>View More Barcodes</strong>",'/admin/products/barcodelist/'.$id , array('class'=>'','id'=>"products",'escape'=>false), null, false); ?>						
					</td>
				</tr><tr>
					<td align="right" ><span class="error_msg"></span> Manufacturer  :</td>
					<td>
						<?php echo $form->input('Product.manufacturer',array('class'=>'textbox-m','label'=>false,'div'=>false));?>
					</td>
				</tr>
				<tr>
					<td align="right" ><span class="error_msg">*</span> Model Number :</td>
					<td align="left">
						<?php echo $form->input('Product.model_number',array('class'=>'textbox-m','label'=>false,'div'=>false));?>
					</td>
				</tr>
				<tr>
					<td align="right"><span class="error_msg">*</span> Price RRP:</td>
					<td align="left">
						<?php echo $form->input('Product.product_rrp',array('onkeyup'=>'javascript: if(isNaN(this.value)){this.clear(); }', 'class'=>'textbox-s','label'=>false,'div'=>false));?>
					</td>
				</tr>
				<tr >
					<td align="right"><span class="error_msg">*</span> Colour Name :</td>
					<td align="left" >
						<table  border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
						<td align="left" width="80%" id="color_selection_box">
						<?php //echo $form->select('Product.color_id',$all_color_array,null,array('class'=>'textbox-m', 'type'=>'select'),'Select color..'); ?>
						
						<?php echo $form->input('Product.color_name', array('autocomplete'=>"off",'type'=>'text','id'=>'valid_color_name', 'div'=>false,'label'=>false,'class'=>'textbox-m','style'=>'width:50%;')); ?>
						<?php echo $form->error('Product.color_id'); ?>
						</td>
						<td align="left" width="20%">
						<a href="javascript:void(0)" onClick="javascript:jQuery('#other_color_name_holder').show();" title="Add New Color">
							<strong>Add New Color</strong>
						</a></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr id="other_color_name_holder"  style="display:none;">
					<td align="right" width="20%"><span class="error_msg"></span>Other Colour Name  :</td>
					<td align="left">
						<?php echo $form->input('other_color_name',array('id'=>'other_color_name', 'class'=>'textbox-m','label'=>false,'div'=>false));?>
						<?php echo $form->button('Add',array('type'=>'button','class'=>'textbox','onClick'=>"addColorName()"));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'textbox','onClick'=>"javascript:jQuery('#other_color_name_holder').hide();"));?>
					</td>
				</tr>
				<tr>
					<td align="right" width="20%"><span class="error_msg">*</span> Department :</td>
					
					<td align="left">
						<table  border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
						<td align="left" width="75%" id="brand_selection_box">
						
						<?php echo $form->select('Product.department_id', $departments_array, null,array('class'=>'textbox-m', 'type'=>'select','onChange'=>'showProductTemplate(this.value)'),'Select Department'); 
						echo $form->error('Product.department_id');
						?>
						</td>
						<td align="left" width="3%" id="is_gd">
						<?php $checkbox = '';
							if($this->data['Product']['gd_product']=='1'){
								$checkbox = true;
							}else{
								$checkbox = false;
							}
						?>
						<?php echo $form->checkbox('Product.gd_product',array('id' => 'gd_checked', 'onclick' => 'javascript: manageGdProductName();', "checked"=>$checkbox,'style'=>array('border:0'))); ?>
						</td>
						<td id="gd_product">Goodwinsdirect product</td>
						</table>
					</td>
				</tr>
				<tr>
				<td align="left" colspan="2" >
					<table border="0" cellpadding="0" cellspacing="0" width="100%" >
						<tr>
						<td width="70%" align="left" id="dep_wise_category_div" valign="top" align="left"></td>
						<td width="30%" style="background:#D6CEC6;padding:10px 0px 10px 10px;display:none;" id="selected_categories" valign="top" align="left"></td>
						</tr>
					</table>
				</td>
				</tr>
					
				
				
				<!--<tr>-->
				<!--	<td  align="center" colspan="2" id="dep_wise_product_div"></td>-->
				<!--</tr>-->
				<?php
				if(!empty($this->data['Product']['product_image'])){?>
				<tr>
					<td></td>
					<td align="left">
					<?php
					$imagePath = WWW_ROOT.PATH_PRODUCT."small/img_100_".$this->data['Product']['product_image'];
					if(file_exists($imagePath) && !empty($this->data['Product']['product_image']) ){
						
					?>
					<fieldset style="border:0px;">
					<legend>Current Image Preview</legend>
						<?php echo $html->image('/'.PATH_PRODUCT."small/img_100_".$this->data['Product']['product_image'], array('style'=>'border: 1px dashed #666666; padding:5px; background-color:#EFEBE7;')); ?>
						<?php echo ' '.$html->link("Remove","/products/delete_image/".$this->data['Product']['id'],array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this image?');",'style'=>'margin-left:10px;')); ?>
						<?php echo $form->hidden('Product.product_image',array('class'=>'textbox-m','type'=>'text','label'=>false,'div'=>false));?>
						</fieldset>
					<?php } ?>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td align="right" valign="top">Upload Image: </td>
					<td align="left">
						<!--<input name ="data[Product][product_image][]"  type="file" class="multi" accept="gif|jpg|jpeg" maxlength="4"/>-->
					<?php
					echo $form->input('Product.photo',array('class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'type' => 'file'));?>
					<!-- For search tags -->
					<?php echo $form->hidden('ProductSearchtag.user_id',array('class'=>'textbox-m','type'=>'text','label'=>false,'div'=>false));?>
					<!-- End of For search tags -->
					</td>
				</tr>
		<?php if(!empty($this->data['Productimage'])){
		
		?>
		<tr>
			<td colspan="2" align="left">
				<div style="width:720px;overflow-x: scroll; border:1px dashed;">
					<table width="100%" border="0"  cellpadding="0" cellspacing="0" >
						<tr> 
						<?php 
						foreach($this->data['Productimage'] as $product_image){
						if(!empty($product_image)){
						?>
							<td  valign="top"  >
							<table width="100%" border="0"  cellpadding="0" cellspacing="0" >
								<tr>
								<td  valign="top" align="center" height="120" style="padding:5px;">
							<?php
							$imagePath1 = WWW_ROOT.PATH_PRODUCT."small/img_100_".$product_image['image'];
							if(file_exists($imagePath1)){
							echo $html->image('/'.PATH_PRODUCT."small/img_100_".$product_image['image'], array('style'=>'border: 1px dashed #666666; padding:5px; background-color:#EFEBE7;'));
							}  
							?>
							</td></tr>
							<tr><td valign="baseline" align="center"><?php echo ' '.$html->link("Remove","/products/delete_product_image/".$product_image['id'],array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this image?');")); ?></td>
							</tr>
							</table>
							</td>
						
						<?php }
						}?>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<?php }?>
		
			<tr>
				<td align="right" valign="top">Multiple images</td>
				<td align="left"><?php
				//echo $form->input('Product.photom.0',array('class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'type' => 'file','id'=>'ProductPhotoIdm_0'));
				echo "<div id='moreSoftware'></div>";
				echo "<br><div id='moreSoftwareLink'>";
				echo $form->button('Add more image',array('onclick'=>'return addSoftwareInput()','type'=>'button','value'=>'Add More Photo'));
				echo "</div>";?>
			</tr>
			<tr>
				<td align="right">Embed video :</td>
				<td align="left">
				<?php
				echo $form->input('Product.product_video',array(/*'rows'=>'7','cols'=>'30',*/'class'=>'textbox-l','type'=>'text','label'=>false,'div'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td align="right"><span class="error_msg">*</span> Status: </td>
				<td align="left">
					<?php echo $form->select('Product.status',array('0'=>'Inactive','1'=>'Active'),null,array('class'=>'textbox-s', 'type'=>'select'),'Select Status'); ?>
					<?php echo $form->error('Product.status'); ?>
				</td>
			</tr>	
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td >&nbsp;</td>
				<td align="left" >
				<?php if(!empty($this->data['Product']['id'])) {
					
					//echo $form->button('Save',array('value'=>'save', 'name' =>'submit' , 'type'=>'submit','class'=>'btn_53','div'=>false));
				}
				?>
				
			<?php 
			$options = array(
			"url"=>"/orders/add_msg","before"=>"",
			"indicator"=>"plsLoaderID",
			'loading'=>"Element.show('plsLoaderID')",
			"complete"=>"Element.hide('plsLoaderID')",
			"type"=>"Submit",
			);?>
			
			<?php
			echo $form->button('Save',array('class'=>'btn_53','div'=>false,'id'=>'','onclick'=>"submitcon('save'); this.disabled=true;this.value='Save';this.form.submit();"));
			echo $form->button('Save & Continue',array('class'=>'btn_53','div'=>false,'id'=>'','onclick'=>"submitcon('continue'); this.disabled=true;this.value='Save & Continue';this.form.submit();"));
				echo $form->hidden('continue',array('value'=>'continue','name' =>'submit1' ,'id'=>'submit1','type'=>'input','class'=>'btn_53','div'=>false));
				echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/Products/index')"));?>
			</td>
			</tr>
			</table>
		</td>
	</tr>
</table>
</td>
</tr>
</table>

<?php 
echo $form->input('Product.id');
$categories = '';
if(!empty($this->data['ProductCategory'])){
	
		foreach($this->data['ProductCategory'] as $cat){
			
			if(empty($categories)){
				$categories = $cat['category_id'];
			} else{
				$categories = $categories.','.$cat['category_id'];
			}
	}
}
echo $form->hidden('Product.categories',array('value'=>$categories,'label'=>false,'div'=>false));

echo $form->end();
?>
<script type="text/javascript" language="javascript">
// function to get department based templates
function showProductTemplate(depId){
	// display category  selection box 
	var catgories = '';
	catgories = jQuery('#ProductCategories').val();
	<?php if(!empty($id)){?>
		productId = '<?php  echo $id; ?>';
		
	<?php  }?>
	showCategoryCombo(depId,catgories);
	showSelectedCats();
}


// function to get department based category combo box
function showCategoryCombo(depId,catgories){
		//for Gd product
		if(depId == '8'){
			jQuery('#is_gd').show();
			jQuery('#gd_product').show();
		}else{
			jQuery('#is_gd').hide();
			jQuery('#gd_product').hide();
		}
		//End for Gd product
		if(depId == ''){
			jQuery('#dep_wise_category_div').html('');
		}else{
		jQuery('#preloader').show();
		var postUrl = SITE_URL+'products/get_department_category/'+depId+'/'+catgories;
		jQuery.ajax({
			cache:false,
			async: false,
			type: "GET",
			url: postUrl,
			success: function(msg){
				jQuery('#dep_wise_category_div').html(msg);
				jQuery('#preloader').hide();
			}
		 });
		}
}
//For Submit Conditon save and save and Continue 
function submitcon(savecon){
	jQuery("#submit1").val(savecon);
	return true;
}


function showSelectedCats() {
	jQuery('#selected_categories').css('display', '');
	jQuery("#selected_categories").html('Selected Categories: <br/><br/>');
			var i=1;
			<?php if(isset($this->params['pass'][0]) && !empty($this->params['pass'][0])){?>
			var params = <?php echo $this->params['pass'][0]?>;
			<?php 	} else {?>
				params ='';	
			<?php } ?>
			if(params!=='')
			{
				jQuery("#selected_categories").html('Selected Categories: <br/><br/>');
				jQuery('#dep_wise_category_div input:checked').each(function() {
				var postUrl = SITE_URL+'products/show_selected_category/'+jQuery("#ProductDepartmentId").val()+'/'+jQuery(this).val();
			jQuery('#preloader').show();	
			jQuery.ajax({
				cache:false,
				async: false,
				type: "POST",
				url: postUrl,
				success: function(msg){
					jQuery('#selected_categories').append('<table width="100%" border="0"  cellpadding="0" cellspacing="0" ><tr><td width="5%" valign="top">'+i+'. </td><td>'+msg+'</td></table>');
					i=i+1;
					jQuery('#preloader').hide();
					
				}
			 });
			})
			}
		
			//jQuery('.input-btn-last').live('click',function(){
			jQuery('.input-btn-last').click( function(){
			if(jQuery(this).is(':checked')){
			jQuery('#preloader').show();
			var postUrl = SITE_URL+'products/show_selected_category/'+jQuery("#ProductDepartmentId").val()+'/'+jQuery(this).val();
			jQuery.ajax({
				cache:false,
				async: false,
				type: "POST",
				url: postUrl,
				success: function(msg){
					jQuery('#selected_categories').append('<table width="100%" border="0"  cellpadding="0" cellspacing="0" ><tr><td width="5%" valign="top">'+i+'. </td><td>'+msg+'</td></table>');
					i=i+1;
					jQuery('#preloader').hide();
					
				}
			 });
			
	
		} else
		
		{
			var j=1;
			jQuery("#selected_categories").html('Selected Categories: <br/><br/>');
			jQuery('#dep_wise_category_div input:checked').each(function() {
				var postUrl = SITE_URL+'products/show_selected_category/'+jQuery("#ProductDepartmentId").val()+'/'+jQuery(this).val();
			jQuery('#preloader').show();	
				
			jQuery.ajax({
				cache:false,
				async: false,
				type: "POST",
				url: postUrl,
				success: function(msg){
					jQuery('#selected_categories').append('<table width="100%" border="0"  cellpadding="0" cellspacing="0" ><tr><td width="5%" valign="top">'+j+'. </td><td>'+msg+'</td></table>');
					j=j+1;
					jQuery('#preloader').hide();
					
				}
			 });
			})
		
		}
		
	});
	

}
</script>
</div>
