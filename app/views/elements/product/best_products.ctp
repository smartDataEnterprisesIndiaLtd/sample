<?php if(!Empty($products_info)) {?>
<div class="sorting-widget" >
	<div style="float:left"><span class="smalr-fnt">Based on <?php echo $dept_name;?> Product Sales on Choiceful.com (Updated hourly)</span></div>
	<?php if(count($products_info) >25) { ?>
	<div class="paging" style="padding:0">
		<ul>
		
		<?php
		if($page_display>=25 && $page_display<=50){
			$page_no = (($page_display-25)+1);
		}elseif($page_display>=50 && $page_display<=75){
			$page_no = (($page_display-50)+2);
		}elseif($page_display>=75){
			$page_no = (($page_display-75)+3);
		}else{
			$page_no = ($page_display);
		}
		
		$selected_department = base64_encode($selected_department);
		$results = array('current_set' => $page_no,'no_of_pages'=>round(count($products_info)/25));
		$last_pr_sh_page = 0; $last_nx_sh_page = 0;
		if($results['current_set'] > 1){
			
			$prev_page[] = $results['current_set'] - 1;
			if(!empty($prev_page[0])) {
				$last_pr_sh_page = $prev_page[0];
				if($prev_page[0] > 1){
					$prev_page[] = $prev_page[0] - 1;
				}
			}
			if(!empty($prev_page[1])) {
				$last_pr_sh_page = $prev_page[1];
				if($prev_page[1] > 1){
					$prev_page[] = $prev_page[1] - 1;
					if(!empty($prev_page[2])){
						$last_pr_sh_page = $prev_page[2];
					}
				}
			}
		}
		if(!empty($prev_page))
			asort($prev_page);

		if($results['current_set'] < $results['no_of_pages']){
			$next_page[] = $results['current_set'] + 1;
			if(!empty($next_page[0])) {
				$last_nx_sh_page = $next_page[0];
				if($next_page[0] < $results['no_of_pages']){
					$next_page[] = $next_page[0] + 1;
				}
			}
			if(!empty($next_page[1])) {
				$last_nx_sh_page = $next_page[1];
				if($next_page[1] < $results['no_of_pages']){
					$next_page[] = $next_page[1] + 1;
					if(!empty($next_page[2])) {
						$last_nx_sh_page = $next_page[2];
					}
				}
			}
		}
		if(!empty($next_page))
			asort($next_page);

		$not_shown_pages = 0; $not_shown_pages_prev =0; 
		$not_shown_pages = $results['no_of_pages'] - $last_nx_sh_page;
		$not_shown_pages_prev = $last_pr_sh_page - 1;
		?>
		<?php if(!empty($prev_page)){ ?>
			<li><?php echo $html->link('Prev','products/bestseller_products/'.$selected_department.'/'.(($page_no*25)-49),array('escape'=>false,'class'=>'active')); ?></li>
			<?php if(!empty($not_shown_pages_prev) && $not_shown_pages_prev > 0) { ?>
			<?php }?>
			<?php foreach($prev_page as $pre_p){ ?>
				<li><?php echo $html->link($pre_p,'products/bestseller_products/'.$selected_department.'/'.((($pre_p-1)*25)+1),array('escape'=>false,'class'=>'active')); ?></li>
			<?php }
		}?>
		<?php if(!empty($results['current_set'])) { ?>
			<li class="action"><?php echo $results['current_set']; ?></li>
		<?php }?>
		<?php if(!empty($next_page)){ ?>
			<?php foreach($next_page as $next_p){ ?>
				<li><?php echo $html->link($next_p,'products/bestseller_products/'.$selected_department.'/'.((($next_p-1)*25)+1),array('escape'=>false,'class'=>'active')); ?></li>
			<?php } ?>
			<li><?php echo $html->link('Next','products/bestseller_products/'.$selected_department.'/'.(($page_no*25)+1),array('escape'=>false,'class'=>'active')); ?></li>
		<?php }?>
	</ul>
	</div>
	<?php }?>
	<div class="clear"></div>
</div>
<!--Sorting Closed-->
<!--Product Listings Widget Start-->
<div class="products-listings-widget">
	<!--Left Widget Start-->
	<div class="product-listings-wdgt">
		<?php
		$i = $page_display;
		//if(count($products_info) > 25 ){
			for($it= $page_display;$it <= $i+24; $it++) {
				if(!empty($products_info[$it])){
					$product_dept[$it] = $products_info[$it];
				}
			}
			$products = $product_dept;
		//}
		//pr($products_info);
		foreach($products as $product) {
			if(!empty($product['product_image'])) {
					$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_100_".$product['product_image'];
						
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$product['product_image'];
					}
				} else {
					$image_path = '/img/no_image_100.jpg';
				}
				$pr_name = $product['product_name'];
				$pr_id = $this->Common->getProductId_Qccode($product['secondid']);
				$product_rrp = $product['product_rrp'];
				$pr_avg_rate = $product['avg_rating'];
				if(key_exists($product['secondid'],$top_seller_product)){
					$pro_pos_old = $top_seller_product[$product['secondid']];
				}else{
					$pro_pos_old = "";
				}
				$product_pos_new = ($i-1);
				
				if(key_exists('minimum_price_used',$product)){
					$pr_price_used = $product['minimum_price_used'];
				}
				if(key_exists('minimum_price_used_seller',$product)){
					$min_used_seller  = $product['minimum_price_used_seller'];
				}
				if(key_exists('condition_used',$product)){
					$used_con_id  = $product['condition_used'];
				}
					
				if(key_exists('minimum_price_value',$product)){
					$pr_price_new = $product['minimum_price_value'];
				}
				if(key_exists('minimum_price_seller',$product)){
					$min_new_seller  = $product['minimum_price_seller'];
				}
				if(key_exists('condition_new',$product)){
					$new_con_id  = $product['condition_new'];
				}
				if(!empty($pr_id) && !empty($min_new_seller) && !empty($new_con_id)){
					$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_new_seller, $new_con_id);
					if(!empty($prodSellerInfo))
						$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
					else
						$prodStock = "";
				}		
						
				if(!empty($pr_id) && !empty($min_used_seller) && !empty($used_con_id)){
					$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_used_seller, $used_con_id);
					if(!empty($prodSellerInfo))
						$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
					else
						$prodStock = "";
				}
				$rating = $common->displayProductRating($pr_avg_rate,$pr_id);

		?>
		<!--Row1 Start-->
		<div class="pro-listing-row">
			<div class="num-widget"><?php echo $i;?>.</div>
			<div class="pro-img">
			<?php //echo $html->image($image_path ,array('alt'=>$pr_name)); ?>
			<?php echo $html->link($html->image($image_path ,array('alt'=>$pr_name,'title'=>$pr_name)),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>'underline-link'));?>
			</div>
			<div class="product-details-widget margin-tp-btm">
				<h4>
					<?php if(!empty($pr_name))
					echo $html->link('<strong>'.$format->formatString($pr_name,500,'..').'</strong>','/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>'underline-link')); else echo '-';?>
					<span class="padding-left">
						<?php echo $rating; ?></span>
					</span>
				</h4>
				<p class="margin-tp-btm">
				<?php
				//if($i%2 == 0)
				if($product_pos_new <= $pro_pos_old || $pro_pos_old == "")
					echo $html->image('green-up-arrow.gif',array('width'=>'13','height'=>'11','alt'=>''));
				else
					echo $html->image('red-down-arrow.gif',array('width'=>'13','height'=>'11','alt'=>''));
				?>
				
				</p>
				<?php if(!empty($pr_price_new) && $pr_price_new > 0 || !empty($pr_price_used) && $pr_price_used > 0 ) { ?>
				<p class="used-from pad-tp">
					<?php if(!empty($pr_price_new)) { ?>
						New from <span class="price larger-font"><strong><?php echo CURRENCY_SYMBOL.$format->money($pr_price_new,2); ?></strong></span>
					<?php }?>
					<?php if(!empty($pr_price_used)) { ?>
						Used from <span class="price larger-font"><strong><?php echo CURRENCY_SYMBOL.$format->money($pr_price_used,2); ?></strong></span>
					<?php }?>
				</p>
				<?php } ?>
				<?php if(!empty($prodStock)){ ?>
				<p><strong>In stock</strong> | Usually dispatched within 24 hours </p>
				<?php }else { ?>
				<p><strong>Out of stock</strong></p>
				<?php }?>
			</div>
			<div class="clear"></div>
		</div>
		<!--Row1 Closed-->
		<?php
			$pr_price_used = "";
			$min_used_seller  = "";
			$min_used_con  = "";
			$pr_price_new = "";
			$min_new_seller  = "";
			$new_con_id  = "";
			$prodStock = "";
		 $i++;
		}?>
	</div>
	<!--Left Widget Closed-->
</div>
<!--Product Listings Widget Closed-->
<!--Sorting Start-->
<?php if(count($products_info) >25) { ?>
	<div class="border-top">
		<div class="paging">
		<ul>
		<?php if(!empty($prev_page)){ ?>
			<li><?php echo $html->link('Prev','products/bestseller_products/'.$selected_department.'/'.(($page_no*25)-49),array('escape'=>false,'class'=>'active')); ?></li>
			<?php if(!empty($not_shown_pages_prev) && $not_shown_pages_prev > 0) { ?>
			<?php }?>
			<?php foreach($prev_page as $pre_p){ ?>
				<li><?php echo $html->link($pre_p,'products/bestseller_products/'.$selected_department.'/'.((($pre_p-1)*25)+1),array('escape'=>false,'class'=>'active')); ?></li>
			<?php }
		}?>
		<?php if(!empty($results['current_set'])) { ?>
			<li class="action"><?php echo $results['current_set']; ?></li>
		<?php }?>
		<?php if(!empty($next_page)){ ?>
			<?php foreach($next_page as $next_p){ ?>
				<li><?php echo $html->link($next_p,'products/bestseller_products/'.$selected_department.'/'.((($next_p-1)*25)+1),array('escape'=>false,'class'=>'active')); ?></li>
			<?php } ?>
			<li><?php echo $html->link('Next','products/bestseller_products/'.$selected_department.'/'.(($page_no*25)+1),array('escape'=>false,'class'=>'active')); ?></li>
		<?php }?>
	</ul>
	</div>
	<div class="clear"></div>
	</div>
<?php }?>
<!--Sorting Closed-->
<?php }?>