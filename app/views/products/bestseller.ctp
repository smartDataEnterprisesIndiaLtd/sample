<?php ?>
<!--mid Content Start-->
<div class="mid-content pad-rt-none recent-history-widget">
	<div class="breadcrumb-widget font-size13">
		<?php echo $html->link('<strong>Home</strong>','/homes/',array('escape'=>false,'class'=>'underline-link'));?> &gt; 
		<span class="choiceful">
			<strong>Bestsellers [All Departments]</strong>
		</span>
	</div>
	<p class="larger-font margin-bottom">Based on Product Sales on Choiceful.com: <span class="dif-col-blu-code"><strong>Updated hourly</strong></span></p>
	<!--Books Start-->
	<?php if(!empty($products_info)){
	foreach($products_info as $products_info) {
		if(!empty($products_info['department_name'])){
			$dept_name = $products_info['department_name'];
		} else {
			$dept_name = '-';
		}
		$dept_id = $departments_list[$dept_name];
	?>
	<h4 class="mid-gr-head blue-color" style="margin-bottom:2px"><span><?php echo $dept_name; ?></span> 
	<?php 
	$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($dept_name, ENT_NOQUOTES, 'UTF-8'));
	
	if(!empty($dept_id)) echo $html->link('Explore all bestsellers in '.strtolower($dept_name),'/'.$dept_url_name.'-topsellers-top-100/products/bestseller_products/'.base64_encode($dept_id),array('escape'=>false,'class'=>'view-all-catagory underline-link'));?></h4>
	
	<div class="row">
		<!--Products Widget Start-->
		<div class="departments_container products-widget">
			<ul class="products pos-rel" style="width:100%">
				<?php
				$dept_items_count = 1;
				// foreach($dept_info['items'] as $dept_items) { 
				if(count($products_info['item']) > 10){
					$chk_count = 10;
				} else {
					$chk_count = count($products_info['item']);
				}
				for($item_count = 0; $item_count < 10; $item_count++){
					//$dept_items = $dept_info['items'][$item_count];
					if(!empty($products_info['item'][$item_count]['product_image'])) {
						$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_100_".$products_info['item'][$item_count]['product_image'];
						if(!file_exists($image_path) ){
							$image_path = '/img/no_image_100.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$products_info['item'][$item_count]['product_image'];
						}
					} else {
						$image_path = '/img/no_image_100.jpg';
					}
					$pr_name = $products_info['item'][$item_count]['product_name'];
					$pr_id = $this->Common->getProductId_Qccode($products_info['item'][$item_count]['secondid']);
				?>
					<li class="products_container tops<?php echo $dept_items_count;?>" style="margin-bottom:35px;padding:0px!important;width:20%"><div style ="padding:0 5px">
						<p class="numric"><?php echo $dept_items_count; ?>.</p>
						<p class="image-sec"><?php 
						echo  $html->link($html->image($image_path,array('alt'=>$pr_name,'title'=>$pr_name)),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false)); ?></p>
						<p><?php echo $html->link($format->formatString($pr_name,200,'...'),'/'.$this->Common->getProductUrl($pr_id) 	.'/categories/productdetail/'.$pr_id,array('escape'=>false));?></p></div>
					</li>
					
				<?php $dept_items_count++;
				
				} ?>
			</ul>
		</div>
		<!--Products Widget Closed-->
	</div>
	<?php } } ?>
	<!--Books Closed-->
</div>
<!--mid Content Closed-->
<script type="text/javascript">
var width_pre_div = 901;

jQuery(window).resize(function() {
	//alert('hello');
	change_resolution();
});

jQuery(document).ready(function()  {
	//alert('hi');
	change_resolution();
});
function change_resolution() {
	var width_div = jQuery('.departments_container').width();
	var width_diff = width_div-width_pre_div;
	//alert(width_diff);
	if(width_div == width_pre_div){
		jQuery('.products_container').css('width','20%');
	}else if(width_div < width_pre_div){
		if(width_diff > -95 ){
			jQuery('.products_container').css('width','20%');
		} else if(width_diff < -95 && width_diff > -150){
			jQuery('.products_container').css('width','25%');
			
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow25');
			
		} else{
			jQuery('.products_container').css('width','33.3%');
			
			jQuery(".products").removeClass('proshow25');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow33');
		}
	}else if(width_div > width_pre_div){
		//jQuery('.products_container').css('width','16.6%');
		if(width_diff < 50){
			jQuery('.products_container').css('width','20%');
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow25');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow20');
		}
		if((width_diff >= 50) && (width_diff < 440)){
			jQuery('.products_container').css('width','20%');
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow25');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow20');
		}
		if(width_diff > 800 && width_diff < 1000){
			jQuery('.products_container').css('width','16.6%');
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow25');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow16');
		}
		if(width_diff >= 1000 && width_diff < 1400){
			jQuery('.products_container').css('width','14.2%');
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow25');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow14');
		}
		if(width_diff >= 1400){
			jQuery('.products_container').css('width','12.5%');
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow25');
			jQuery(".products").addClass('proshow12');
		}
	} else{

	}
}

</script>