<?php if(!empty($frequently_bought_togather)) {?>
<!--Frequently Bought Together Start-->
<div class="row no-pad-btm">
	<!--FBTogether Start-->
	<div class="fbtogether">
		<h4 class="mid-gr-head blue-color"><span>
			<?php echo $frequently_bought_togather_slogan;?></span></h4>
		<!--fbtogetther-items Start-->
		<div style="min-height:90px;">
		<div class="fbtogetther-items">
			<?php
			
			$prods_fre_togather[0]['secondid'] = $product_details['Product']['quick_code'];
			$prods_fre_togather[0]['product_name'] = $product_details['Product']['product_name'];
			$prods_fre_togather[0]['product_image'] = $product_details['Product']['product_image'];
			$prods_fre_togather[0]['avg_rating'] = $product_details['Product']['avg_rating'];
			$prods_fre_togather[0]['product_rrp'] = $product_details['Product']['product_rrp'];
			
			$prods_fre_togather[0]['minimum_price_used'] = $product_details['Product']['minimum_price_used'];
			$prods_fre_togather[0]['minimum_price_value'] = $product_details['Product']['minimum_price_value'];
			$prods_fre_togather[0]['minimum_price_seller'] = $product_details['Product']['minimum_price_seller'];
			$prods_fre_togather[0]['minimum_price_used_seller'] = $product_details['Product']['minimum_price_used_seller'];
			
			$prods_fre_togather[0]['condition_new'] = $product_details['Product']['new_condition_id'];
			$prods_fre_togather[0]['condition_used'] = $product_details['Product']['used_condition_id'];
			
			$k = 1;
			foreach($frequently_bought_togather as $frequently_bought_togather_item) {
				if($k < 3){
				if(!empty($frequently_bought_togather_item->attribute)) {
					
					foreach($frequently_bought_togather_item->attribute as $attribute){
						if($attribute->name == 'secondid' && !empty($attribute->value->_)){
							$prods_fre_togather[$k]['secondid'] = $attribute->value->_;
						}
						if($attribute->name == 'product_name' && !empty($attribute->value->_)){
						      $prods_fre_togather[$k]['product_name'] = $attribute->value->_;
						}
						if($attribute->name == 'product_image' && !empty($attribute->value->_)){
						      $prods_fre_togather[$k]['product_image'] = $attribute->value->_;
						}
						
						if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
						      $prods_fre_togather[$k]['avg_rating'] = $attribute->value->_;
						}
						if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
						      $prods_fre_togather[$k]['product_rrp'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
						      $prods_fre_togather[$k]['minimum_price_used'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
						      $prods_fre_togather[$k]['minimum_price_value'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_seller' && !empty($attribute->value->_)){
						      $prods_fre_togather[$k]['minimum_price_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used_seller' && !empty($attribute->value->_)){
						      $prods_fre_togather[$k]['minimum_price_used_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
						      $prods_fre_togather[$k]['condition_new'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_used' && !empty($attribute->value->_)){
						      $prods_fre_togather[$k]['condition_used'] = $attribute->value->_;
						}
					}
					
				}
				}
			$k++;	
			}
				
				
			if(!empty($prods_fre_togather)) {
			 ?>
			<div class="items-widget" style="padding-right:10px;">
				<?php
				$i = 1;$total_price_added = 0;
				foreach($prods_fre_togather as $freq_prod){
					if(!empty($freq_prod['secondid'])){
						$pr_id = $this->Common->getProductId_Qccode($freq_prod['secondid']);
					}else{
						$pr_id = "";
					}
						
					if(!empty($freq_prod['minimum_price_used'])){
						$price_add = $freq_prod['minimum_price_used'];
						$pro_seller_id = $freq_prod['minimum_price_used_seller'];
						$prod_condition = $freq_prod['condition_used'];
						
					} else if(@$freq_prod['minimum_price_value']){
						$price_add = $freq_prod['minimum_price_value'];
						$pro_seller_id = (int) ($freq_prod['minimum_price_seller']);
						$prod_condition = $freq_prod['condition_new'];
						
					} else {
						$price_add = 0;$pro_seller_id = 0;$prod_condition=0;
					}
						
					$pro_qty_info = $common->getProductSellerInfo($pr_id,$pro_seller_id,$prod_condition);
					$prod_qty = 0;
					if(!empty($pro_qty_info)){
						if((!empty($pro_qty_info['ProductSeller']['quantity'])) && ($pro_qty_info['ProductSeller']['quantity'] > 0)){
							$prod_qty = $pro_qty_info['ProductSeller']['quantity'];
						}
					}
						
						
					if($prod_qty > 0){
					if(!empty($freq_prod['product_image'])) {
						$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_50_".$freq_prod['product_image'];
						if(!file_exists($image_path) ){
							$cus_image_path = '/img/no_image_50.jpg';
						}else{
							$cus_image_path = '/'.PATH_PRODUCT.'small/img_50_'.$freq_prod['product_image'];
						}
					} else {
						$cus_image_path = '/img/no_image_50.jpg';
					}
					?>
					<div class="fre_img hide_<?php echo $pr_id;?>">
						<?php if($i == 1){
							echo $html->image($cus_image_path,array('alt'=>$freq_prod['product_name'] ,'title'=>$freq_prod['product_name'] ));
						}else{?>
							<span class="plus-span tog_<?php echo $i;?>">+</span>
							<?php echo $html->link($html->image($cus_image_path,array('alt'=>$freq_prod['product_name'] ,'title'=>$freq_prod['product_name'] )),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false));
							
						}?>
					</div>
					<?php
						 //if($i < count($prods_fre_togather)) {?> <!--span class="plus-span tog_<?php //echo $i;?>">+</span--><?php //}
						$i++;
					}
						
						
						
				}
				?>
			</div>
			<div class="item-content">
				<?php
				$mix_prods_str = '';
				foreach($prods_fre_togather as $freq_prod){
					//pr($freq_prod);
					$pr_id = $this->Common->getProductId_Qccode($freq_prod['secondid']);
					if(!empty($freq_prod['minimum_price_used'])){
						$price_add = $freq_prod['minimum_price_used'];
						$pro_seller_id = $freq_prod['minimum_price_used_seller'];
						$prod_condition = $freq_prod['condition_used'];
						
					} else if(@$freq_prod['minimum_price_value']){
						$price_add = $freq_prod['minimum_price_value'];
						$pro_seller_id = (int) ($freq_prod['minimum_price_seller']);
						$prod_condition = $freq_prod['condition_new'];
						
					} else {
						$price_add = 0;$pro_seller_id = 0;$prod_condition=0;
					}
					
					$pro_qty_info = $common->getProductSellerInfo($pr_id,$pro_seller_id,$prod_condition);
					$prod_qty = 0;
					if(!empty($pro_qty_info)){
						if((!empty($pro_qty_info['ProductSeller']['quantity'])) && ($pro_qty_info['ProductSeller']['quantity'] > 0)){
							$prod_qty = $pro_qty_info['ProductSeller']['quantity'];
						}
					}
					
					$prods_fre_togather_seller[$freq_prod['secondid']]['qty'] = $prod_qty;
					$prods_fre_togather_seller[$freq_prod['secondid']]['sale_price'] = $price_add;
					$prods_fre_togather_seller[$freq_prod['secondid']]['sel_id'] = $pro_seller_id;
					$prods_fre_togather_seller[$freq_prod['secondid']]['c_id'] = $prod_condition;
					$prods_fre_togather_seller[$freq_prod['secondid']]['id'] = $pr_id;
					$prods_fre_togather_seller[$freq_prod['secondid']]['product_name'] = $freq_prod['product_name'];
					if($prod_qty > 0){
						if(!empty($price_add)){
							$total_price_added = $total_price_added + $price_add;
							if(empty($mix_prods_str)){
								$mix_prods_str = $pr_id.'-1-'.$price_add.'-'.$pro_seller_id.'-'.$prod_condition;
							} else {
								$mix_prods_str = $mix_prods_str.'~'.$pr_id.'-1-'.$price_add.'-'.$pro_seller_id.'-'.$prod_condition;
							}
						}
					}
				}
				//echo $mix_prods_str;
				//$addtobasket = 'product_id,quantity,price,seller_id,condition';
				echo $form->hidden('basket_values',array('value'=>$mix_prods_str));
				
				?>
				<p><strong>Price for all</strong> <span class="price"><strong><?php echo CURRENCY_SYMBOL.' <span id = "total_freq_price">'.$format->money($total_price_added,2).'</span>';?></strong></span></p>
				<p><?php echo $html->link('<span>Add all to Basket</span>',"javascript:void(0)",array('escape'=>false,'class'=>'grn-btn','onClick'=>'goToBasket();'));?></p>
				<p class="gray">Some of these items are dispatched sooner than the others.</p>
			</div>
			<?php } ?>
		</div>
	</div>
		<!--fbtogetther-items Closed-->
		<!--FBTogether items option Start-->
		<div class="optn">
			<?php
			if(!empty($prods_fre_togather_seller)){
				$j = 1;
				foreach($prods_fre_togather_seller as $freq_prod_seller){
				if(!empty($freq_prod_seller['sale_price']) && ($freq_prod_seller['qty'] > 0)){
				?>
				<p>
					<?php
					if(!empty($freq_prod_seller['sale_price']) && ($freq_prod_seller['qty'] > 0)){
						$qty = $freq_prod_seller['qty'];
						$pri = $freq_prod_seller['sale_price'];
						$s_id = $freq_prod_seller['sel_id'];
						$c_id = $freq_prod_seller['c_id'];
						echo $form->checkbox('select_'.$freq_prod_seller['id'],array('value'=>$freq_prod_seller['sale_price'],'id'=>$freq_prod_seller['id'],'checked'=>'checked','class'=>'checkbox','onClick'=>'changeValuesForBasket(this.id,'.$pri.','.$s_id.','.$c_id.','.$j.');','style'=>array('border:0')));
					} ?> 
					<?php
					if($j == 1){ ?>
						<span class="used-from">
						<?php echo $freq_prod_seller['product_name']; ?>
						</span>
					<?php
					} else {
						echo $html->link($freq_prod_seller['product_name'],'/'.$this->Common->getProductUrl($freq_prod_seller['id']).'/categories/productdetail/'.$freq_prod_seller['id'],array('escape'=>false,'class'=>'underline-link'));
					}
					?>
				</p>
				<?php }
				$j++;
				}
			}?>
		</div>
		<!--FBTogether items option Closed-->
	</div>
	<!--FBTogether Closed-->
</div>
<!--Frequently Bought Together Closed-->
<?php } ?>
<script>
function goToBasket(){
	var add_value = jQuery('#basket_values').val();
	var new_pros = add_value.split('~');
	if(new_pros != ''){
		for(var k = 0;k<new_pros.length;k++){
			var pro_bask_info = new_pros[k].split('-');
			addToBasket(pro_bask_info[0],pro_bask_info[1],pro_bask_info[2],pro_bask_info[3],pro_bask_info[4]);
		}
// 		
	}
// 	addToBasket
	
}
function changeValuesForBasket(pr_id,pr_price,pr_selId,pr_cId,tog){
	var add_value = jQuery('#basket_values').val();
	var new_pros = add_value.split('~');
	var new_set_str = '';
	var total_new_price = '';
	var total_fr_price = jQuery('#total_freq_price').text();

	var checkbox_val = jQuery('#'+pr_id).is(':checked');
	if(checkbox_val != true){
		if(new_pros != ''){
			for(var i=0; i<new_pros.length;i++){
				var products_info = new_pros[i].split('-');
				if(pr_id == products_info[0]){
					total_fr_price = total_fr_price - products_info[2];
					new_pros.splice(i,1);
				}
			}
		}
		if(new_pros != ''){
			for(var j=0;j<new_pros.length;j++){
				if(new_set_str == ''){
					new_set_str = new_pros[j];
				} else {
					new_set_str = new_set_str+'~'+new_pros[j];
				}
			}
		}
	}else {
		var new_pr_str = pr_id+'-1'+'-'+pr_price+'-'+pr_selId+'-'+pr_cId;
		new_set_str = add_value+'~'+new_pr_str;
		total_fr_price = parseFloat(total_fr_price) + parseFloat(pr_price);
	}
	if(checkbox_val != true){
		jQuery('.hide_'+pr_id).hide();
	}else{
		jQuery('.hide_'+pr_id).show();
	}
	if(tog=='1'){
		jQuery('.tog_2').toggle();
	}
	if(tog=='2'){
		jQuery('.tog_3').show();
		
	}

	if(new_pros.length > 0){
		jQuery('.fbtogetther-items').show();
	}else{
		jQuery('.fbtogetther-items').hide();
	}
	if(new_pros.length == 1){
		jQuery('.tog_3').hide();
	}
	if(new_pros.length == 2){
		jQuery('.tog_3').show();
	}
	
	total_fr_price = total_fr_price.toFixed(2);
	jQuery('#basket_values').val(new_set_str);
	jQuery('#total_freq_price').text(total_fr_price);
}
</script>