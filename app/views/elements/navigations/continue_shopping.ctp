<?php
$items_recomanded = $this->Common->fh_call_continueshopping();
if(!empty($items_recomanded)){ ?>
<!--Recent History Product List Start-->
<div class="recent-history-pro-list" style="height:210px">
	<h4><strong>Continue Shopping:</strong> Customers who bought items in your recent history also bought</h4>
		<ul class="products outerdiv_resolution">
		<?php foreach($items_recomanded as $reco_item) {
		if(!empty($reco_item->attribute)) {
			if(!empty($reco_item->attribute[0])){
				if(!empty($reco_item->attribute[0]->value)){
					if(!empty($reco_item->attribute[0]->value->_)){
						$pr_qc = $reco_item->attribute[0]->value->_;
					} else {
						$pr_qc = '';
					}
				}else {
					$pr_qc = '';
				}
			} else {
				$pr_qc = '';
			}
			if(!empty($pr_qc)){
				$pr_id = $this->Common->getProductId_Qccode($pr_qc);
			}

			if(!empty($reco_item->attribute[3])){
				if(!empty($reco_item->attribute[3]->value)){
					if(!empty($reco_item->attribute[3]->value->_)){
						if($reco_item->attribute[3]->value->_ == 'no_image.gif' || $reco_item->attribute[3]->value->_ == 'no_image.jpeg' ) {
							$cus_image_path = '/img/no_image.jpeg';
						} else {
							$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_100_".$reco_item->attribute[3]->value->_;
				
							if(!file_exists($image_path) ){
								$cus_image_path = '/img/no_image_100.jpg';
							}else{
								$cus_image_path = '/'.PATH_PRODUCT.'small/img_100_'.$reco_item->attribute[3]->value->_;
							}
						}
					} else {
						$cus_image_path = '/img/no_image.jpeg';
					}
				} else {
					$cus_image_path = '/img/no_image.jpeg';
				}
			} else {
				$cus_image_path = '/img/no_image.jpeg';
			}
			?>
			<li class="inner_div_resolution" style="height:160px">
				<p class="image-sec"><?php echo $html->link($html->image($cus_image_path,array('alt'=>'')), "/categories/productdetail/".$pr_id,array( 'escape'=>false)); ?></p>
				
				<?php if(!empty($reco_item->attribute[2])){
					if(!empty($reco_item->attribute[2]->value)){
						if(!empty($reco_item->attribute[2]->value->_)){
							$cus_pr_name = $reco_item->attribute[2]->value->_;
						} else {
							$cus_pr_name = '';
						}
					}else {
						$cus_pr_name = '';
					}
				} else {
					$cus_pr_name = '';
				} if(!empty($cus_pr_name)) {
				if(strlen($cus_pr_name) > 40){
					$cus_pr_name = $this->Format->formatString($cus_pr_name,40);
				} }
				?>
				<p style="height:30px;"><?php echo $html->link(@$cus_pr_name,"/categories/productdetail/".$pr_id,null);?></p>
				<?php
				if(!empty($reco_item->attribute[7])){
					if(!empty($reco_item->attribute[7]->value)){
						if(!empty($reco_item->attribute[7]->value->_)){
							$cus_product_rrp = $reco_item->attribute[7]->value->_;
						} else {
							$cus_product_rrp = '';
						}
					}else {
						$cus_product_rrp = '';
					}
				} else {
					$cus_product_rrp = '';
				} ?>
				<p class="price larger-font"><strong><?php echo CURRENCY_SYMBOL.$cus_product_rrp; ?></strong></p>
			</li>
			<?php }
		} ?>
	</ul>
</div>
<!--Recent History Product List Closed-->
<?php } ?>