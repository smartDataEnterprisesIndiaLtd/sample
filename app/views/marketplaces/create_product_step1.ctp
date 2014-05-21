<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
$user_signed = $this->Session->read('User');

$departments = $this->Common->getdepartments();
//pr($departments);
?>
<script type="text/javascript" language="javascript">	
jQuery(document).ready(function(){
	var depId = jQuery("#ProductDepartmentId").val();
	
	var selected_category = '<?php echo $this->data['Product']['category_id']; ?>';
	if( depId != ''){
		showCategoryCombo(depId, selected_category);
	}
	
	var catId = jQuery("#ProductCategoryId").val();
	if(catId == ''){
		jQuery("#categorymissingerror").show();
	}
});

// function to get department based category combo box
function showCategoryCombo(depId, selected_category){
		jQuery('#plsLoaderID').show();
		jQuery('#fancybox-overlay-header').show();
		var selectclassName = jQuery("#SellerCategoryclass").val();
		
		var postUrl = SITE_URL+'totalajax/getDepartmentCategory/depid:'+depId+'/selected_cat:'+selected_category+'/selectclass:'+selectclassName;
		
		jQuery.ajax({
			cache:false,
			async: false,
			type: "GET",
			url: postUrl,
			success: function(msg){
				jQuery('#department_based_category').html(msg);
				jQuery('#plsLoaderID').hide();
				jQuery('#fancybox-overlay-header').hide();
			}
		 });
}
</script>


<!--mid Content Start-->
<div class="mid-content pad-rt-none inc-pad">
        <!---   <?php echo $this->element('marketplace/breadcrum'); ?> --->
          <div class="row-widget">
            
            
           	  <!--Tabs Widget Start-->
          		<?php echo $this->element('navigations/seller_heading_bar'); ?>
                <!--Tabs Widget Closed-->
                
                <!--Tabs Content Start-->
          		<div class="tabs-content">
                 <!--Choice Headding Start-->
                	<h2 class="choice_headding choiceful">Create New Product Listings</h2>
                 <!--Choice Headding Closed-->
                  <!--Discription Start-->
                  <div class="inner-content">
                    <p>If your products do not already exist on choiceful.com they can be added to our product catalogue so that you can start selling them.</p>
                    <p>Follow the step-by-step process to create a product detail page.</p>
		    <?php
			if(!empty($errors)){	
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
			<div class="error_msg_box" style="overflow: hidden;"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }?>
                    <h4 class="ornge-cl-head">Step 1 of 3</h4>
                	<p>Begin by telling us which department the product is most suitable for listing.</p>
                  </div>
                 <!--Discription Closed-->
<?php echo $form->create('Marketplace',array('action'=>'create_product_step1','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));?>
               	<!--Sample Bot Row Srart-->
                 <div class="department_selection">
                 	<div class="lable"><b>Select Department:</b></div>
                     <div class="value">
			<?php
				if(!empty($errors['department_id'])){
					$errorDepartmentId ='select_big error_message_box';
				}else{
					$errorDepartmentId ='select_big';
				}
				echo $form->select('Product.department_id', $departments, $this->data['Product']['department_id'],array('class'=>$errorDepartmentId, 'type'=>'select','onChange'=>'showCategoryCombo(this.value, "")'),'Choose your department'); 
			    //echo $form->error('Product.department_id');
			    //  $options = array('url' => '/departments/getDepartmentCategory','update' => 'department_based_category');
			    //  echo $ajax->observeField('ProductDepartmentId', $options);
			    ?>


                        <?php echo $html->image('parrent_arrow.png',array('alt'=>''));?>
			<?php
				if(!empty($errors['category_id'])){
					$errorCategoryId ='select_short error_message_box';
				}else{
					$errorCategoryId ='select_short';
				}
				echo $form->hidden('Seller.categoryclass',array('value'=>$errorCategoryId));?>
                         <div id="department_based_category">
				<?php 
					echo $form->select('Product.category_id', null, null,array('class'=>$errorCategoryId, 'type'=>'select'),'Choose your category'); 
				 //echo $form->error('Product.category_id');
			      ?>
			 </div>
			 
                     </div>
                 </div>
                 <!--Sample Bot Row Closed-->
               
                 <!--Sample Bot Row Srart-->
                 <div class="sample_bot_row">
                 	<span class="orange-sml-btn">
				<input type="button" alt="" class="orange-back" value="Back" onclick="history.back();"/>
			</span>
			<?php echo $form->button('',array('type'=>'submit','div'=>false,'class'=>'continue'));?>
                 </div>
                 <!--Sample Bot Row Closed-->
                 
       <?php echo $form->end(); ?>       
               </div>
                 <!--Tabs Content Closed-->
          </div>
            <!--Setting Tabs Widget Closed-->
</div>
<!--mid Content Closed-->