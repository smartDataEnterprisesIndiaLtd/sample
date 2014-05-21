<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<?php 
// pr(); 
?>
<!--Search Results Start-->
<div class="search-results-widget" style="clear:left;">
	<?php if(!empty($results)) {
		if(!empty($results))
			$i = $results['start_index']+1;
		else
			$i =1;
		$this->set('start_prods',$i);
		echo $this->element('marketplace/paging_fh');
	} else { ?>
	<!--	<div class="search-paging  box-margin-right"> </div> -->
	<?php } ?>
	<!--Left Start-->
	<div class="left-content">
		<?php echo $this->element('marketplace/filter_products');?>
	</div>
	<!--Left Closed-->
	<!--Search Products Start-->
	<?php if(!empty($search_result)) {
		
		$jkl = 0;
		if($this->params['action'] == 'search_product'){
			$right_class = ''; ?>
			<style type="text/css">
			.form-textfield {
				width:90px;
			}
			</style>
		<?php } else{
			$right_class = 'box-margin-right';
		}
	?>
	<div class="search-result-pro-widget <?php echo $right_class;?>" style="min-height:200px;">
		<!--Sorting Start-->
		<div class="sortng-wdt" style ="margin-bottom:10px">
			<div style="float:left;width:83%"><p><span class="larger-fnt"><strong>Search Results</strong><?php if(!empty($search_word)) { ?> for <?php echo $html->image('gray-fade-arrow.gif' ,array('alt'=>"",'width'=>'8','height'=>'9' ));?> <strong>"<?php echo $search_word;?>"</strong><?php }?></span></p>
				<?php
				
				if(!empty($results)) {
					if(!empty($results)){
						$i = $results['start_index']+1;
					}else{
						$i =1;
					}
					$start_prods = $i;
				}
				
				$end_produ = $start_prods-1 + $view_size;
				if($total_records < $end_produ){
				$end_produ = $total_records;
				}
				
				if(empty($total_pages)){
				?>
				<li>Showing <?php echo $start_prods.'-'.$end_produ.' of '.$total_records.' Products';?></li>
				<?php }?>
			</div>
			<div class="clear"></div>
		</div>
		<?php 
		foreach($search_result as $search_result_pro){?>
		<!--Row1 Start-->
		<div class="search-pro-row-widget" style ="margin:10px 0">
			<div class="search-pro-img">
				<?php
				if($search_result_pro['product_image']){
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$search_result_pro['product_image'];
					
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$search_result_pro['product_image'];
					}
					
				} else{
					$image_path = '/img/no_image_100.jpg';
				}
					
				$pr_id = $common->getProductId_Qccode($search_result_pro['secondid']);
				
				if(!empty($search_result_pro['product_name'])) {
					$product_name = $search_result_pro['product_name'];
				} else {
					$product_name = "";
				}
				
				if(!empty($search_result_pro['model_number'])) {
					$model_pr = $search_result_pro['model_number'];
				} else {
					$model_pr = 'NA';
				}
				
				echo $html->link($html->image($image_path ,array('alt'=>htmlspecialchars_decode($product_name , ENT_QUOTES), 'title'=>htmlspecialchars_decode($product_name , ENT_QUOTES))),'/'.$this->Common->getProductUrl(@$pr_id).'/categories/productdetail/'.@$pr_id,array('escape'=>false));
				unset($image_path);
				?>
			</div>
			<div class="numric-widget mrgin-tp"><?php echo $i;?>. </div>
			<div class="product-details-widget mrgin-tp">
				<p><?php echo $html->link('<strong>'.htmlspecialchars_decode($product_name , ENT_QUOTES).'</strong>','/'.$this->Common->getProductUrl(@$pr_id).'/categories/productdetail/'.@$pr_id,array('escape'=>false,'class'=>"underline-link"));?></p>
				<p><strong>Model # <?php echo $model_pr;?></strong></p>
				<p><?php if(in_array($pr_id,$product_seller_listed)) {?>
					<span style="color:#888888">Already listed</span>
				<?php } else {
					echo $html->link('<span>Sell yours here</span>','/marketplaces/create_listing/'.$pr_id,array('escape'=>false,'class'=>"ornge-btn"));
				}?></p>
			</div>
		</div>
		<!--Row1 Closed-->
		<?php $i++; }?>
        </div>
        <!--Search Products Closed-->
	
	<?php } else { ?>
	<div class="search-result-pro-widget box-margin-right"><!--style="min-height:730px;"-->
		<div class="sortng-wdt" style ="border:none; margin-bottom:10px">
			<p align="center"><span class="larger-fnt"><strong>
				<?php
					if(!empty($total_pages)){
						echo 'Only '.$total_pages.' pages are available.';
					}
					if(!empty($search_word)){
						echo 'No record found.';
					}
				//if(empty($total_pages)){ echo 'No record found.'; } else{ echo 'Only '.$total_pages.' pages are available.'; } ?></strong></p>
			<div class="clear"></div>
		</div>
	</div>
	<?php } ?>
	<?php if(!empty($results)) { ?>
		<div class="clear"></div>
		<?php echo $this->element('marketplace/paging_fh');
	} else { ?>
		<!-- <div class="search-paging  box-margin-right"> </div> -->
	<?php } ?>
</div>