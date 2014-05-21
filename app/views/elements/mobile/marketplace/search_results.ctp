<!--Paging Widget Start-->
<?php if(!empty($results)) {
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
	<div>
		<div class="srch-pg">
		<ul>
		<li class="font16"><strong>Search Results</strong><?php if(!empty($search_word)) { ?> for <?php echo $html->image('gray-fade-arrow.gif' ,array('alt'=>"",'width'=>'8','height'=>'9' ));?> <strong>"<?php echo $search_word;?>"</strong><?php }?></li>
		</ul>
		</div>
		<!--Paging Widget Closed-->
		
		
		<!--Filter Results Starts-->
		<section class="filterrslts marg-pad">
			<!--a href="#" class="fltrrsltlnk">Filter Results</a-->
			<?php echo $this->element('mobile/product/filter_products_users_fh'); ?>
		</section>
		<!--Filter Results End-->
			
		<!--mid Content Start-->
		<div class="mid-content">
		
			<!--Sorting Start-->
			<?php echo $this->element('mobile/marketplace/paging_fh');?>
			<!--Sorting Closed-->
			
			<!--Product Listings Widget Start-->
			<div class="products-listings-widget">
				<!--Left Widget Start-->
				<div class="product-listings-wdgt">
					<!--Row1 Start-->
					<?php foreach($search_result as $search_result_pro){?>
						<div class="pro-listing-row">
							<div class="pro-img">
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
							
							echo $html->link($html->image($image_path ,array('alt'=>htmlspecialchars_decode($product_name , ENT_QUOTES), 'title'=>htmlspecialchars_decode($product_name , ENT_QUOTES), 'height'=>'79','width'=>'69')),'/'.$this->Common->getProductUrl(@$pr_id).'/categories/productdetail/'.@$pr_id,array('escape'=>false));
							unset($image_path);
							?>
							</div>
							
							<div class="product-details-widget">
							<h4 class="lstprdctname">
								<?php echo $html->link($product_name,'/'.$this->Common->getProductUrl(@$pr_id).'/categories/productdetail/'.@$pr_id,array('escape'=>false,'class'=>"underline-link"));?>
							</h4>
							
							<!--p class="font11">RRP: <span class="lgtorngcolor"><s>
							<?php //echo CURRENCY_SYMBOL.$format->money(@$item_info->attribute[52]->value->_,2); ?></s></span> | You save: <span class="lgtorngcolor"><?php echo CURRENCY_SYMBOL.$format->money(@$total_save,2); ?> (<?php echo $format->money(@$saving_percentage,2); ?>%)</span></p>
						 	
						 	<p class="pad-tp">
						 	<?php 
							//echo '<span class="font11">New from</span>  <span class="choiceful"><strong>'.CURRENCY_SYMBOL.$format->money(@$item_info->attribute[36]->value->_,2).'</strong></span></span>';
							//echo ' <span class="font11">Used from</span> <span class="choiceful"><strong>'.CURRENCY_SYMBOL.$format->money(@$item_info->attribute[34]->value->_,2).'</strong></span></span>';
							?>
								
						</p-->
							
							<p><strong>Model # <?php echo $model_pr;?></strong></p>
							<p>
								<?php if(in_array($pr_id,$product_seller_listed)) {?>
								<span style="color:#888888">Already listed</span>
								<?php } else {
									echo $html->link('<span>Sell yours here</span>','/marketplaces/create_listing/'.$pr_id,array('escape'=>false,'class'=>"ornggradbtn font11"));
								}?>
							</p>
							</div>
							<div class="clear"></div>
						</div>
					<?php } // End of for loop?>
						<!--Row1 Closed-->
				
				</div>
				<!--Left Widget Closed-->
			</div>
			<!--Product Listings Widget Closed-->
			
		<!--Bottom Pagination Area Starts-->
			<?php echo $this->element('mobile/marketplace/paging_fh_footer');?>
		<!--Bottom Pagination Area End-->
		<!--For Going Back To Previous Page-->
		<section class="backbtnbox">
			<a href="javascript: window.history.go(-1)">
				<input type="button" value="Back" class="greenbtn"/>
			</a>
		</section>
		<!--For Going Back To Previous End-->
		
		</div>
               <!--mid Content Closed-->
	</div>
	<!--Search Products Closed-->
<?php } else { ?>
<div>
	<div class="sortng-wdt" style ="border:none; margin-bottom:10px; margin-top:10px;">
		<p align="center"><span class="larger-fnt"><strong></strong></p>
		<div class="clear"></div>
	</div>
</div>
<?php } ?>