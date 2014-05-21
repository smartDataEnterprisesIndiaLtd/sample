<?php if(!empty($frequently_bought_togather)) { 
//pr($frequently_bought_togather);
?>
<!--Frequently Bought Together Start-->
<span>Frequently Bought Together</span>
<?php foreach($frequently_bought_togather as $frequently_bought_togather_item) {
		if(!empty($frequently_bought_togather_item->attribute)) {
			
			if(!empty($frequently_bought_togather_item->attribute[0])){
				if(!empty($frequently_bought_togather_item->attribute[0]->value)){
					if(!empty($frequently_bought_togather_item->attribute[0]->value->_)){
						$pr_qc = $frequently_bought_togather_item->attribute[0]->value->_;
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

			if(!empty($frequently_bought_togather_item->attribute[3])){
				if(!empty($frequently_bought_togather_item->attribute[3]->value)){
					if(!empty($frequently_bought_togather_item->attribute[3]->value->_)){
						if($frequently_bought_togather_item->attribute[3]->value->_ == 'no_image.gif' || $frequently_bought_togather_item->attribute[3]->value->_ == 'no_image.jpeg' ) {
							$cus_image_path = '/img/no_image_50.jpg';
						} else {
							$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_50_".$frequently_bought_togather_item->attribute[3]->value->_;
				
							if(!file_exists($image_path) ){
								$cus_image_path = '/img/no_image_50.jpg';
							}else{
								$cus_image_path = '/'.PATH_PRODUCT.'small/img_50_'.$frequently_bought_togather_item->attribute[3]->value->_;
							}
						}
					} else {
						$cus_image_path = '/img/no_image_50.jpg';
					}
				} else {
					$cus_image_path = '/img/no_image_50.jpg';
				}
			} else {
				$cus_image_path = '/img/no_image_50.jpg';
			}
			if(!empty($frequently_bought_togather_item->attribute[2])){
				if(!empty($frequently_bought_togather_item->attribute[2]->value)){
					if(!empty($frequently_bought_togather_item->attribute[2]->value->_)){
						$cus_pr_name = $frequently_bought_togather_item->attribute[2]->value->_;
					} else {
						$cus_pr_name = '';
					}
				}else {
					$cus_pr_name = '';
				}
			} else {
				$cus_pr_name = '';
			}
			if(!empty($cus_pr_name)) {
				if(strlen($cus_pr_name) > 40){
					$cus_pr_name = $this->Format->formatString($cus_pr_name,40);
				}
			}
			
			if(!empty($frequently_bought_togather_item->attribute[2])){
						if(!empty($frequently_bought_togather_item->attribute[2]->value)){
							if(!empty($frequently_bought_togather_item->attribute[2]->value->_)){
								$cus_pr_name = $frequently_bought_togather_item->attribute[2]->value->_;
							} else {
								$cus_pr_name = '';
							}
						}else {
							$cus_pr_name = '';
						}
					} else {
						$cus_pr_name = '';
					}
					if(!empty($cus_pr_name)) {
						if(strlen($cus_pr_name) > 40){
							$cus_pr_name = $this->Format->formatString($cus_pr_name,40);
						}
					}
					
					
					if(!empty($frequently_bought_togather_item->attribute[5])){
						if(!empty($frequently_bought_togather_item->attribute[5]->value)){
							if(!empty($frequently_bought_togather_item->attribute[5]->value->_)){
								$minimum_seller_price = $frequently_bought_togather_item->attribute[5]->value->_;
								
							} else {
								$minimum_seller_price = '';
							}
						}else {
							$minimum_seller_price = '';
						}
						
					} else {
						$minimum_seller_price = '';
					}
					
					if(!empty($frequently_bought_togather_item->attribute[14])){
						if(!empty($frequently_bought_togather_item->attribute[14]->value)){
							if(!empty($frequently_bought_togather_item->attribute[14]->value->_)){
								$minimum_price_seller_id = $frequently_bought_togather_item->attribute[14]->value->_;
								
							} else {
								$minimum_price_seller_id = '';
							}
						}else {
							$minimum_price_seller_id = '';
						}
						
					} else {
						$minimum_price_seller_id = '';
					}
					
					if(!empty($frequently_bought_togather_item->attribute[14])){
						if(!empty($frequently_bought_togather_item->attribute[14]->value)){
							if(!empty($frequently_bought_togather_item->attribute[14]->value->_)){
								$minimum_price_seller_id = $frequently_bought_togather_item->attribute[14]->value->_;
								
							} else {
								$minimum_price_seller_id = '';
							}
						}else {
							$minimum_price_seller_id = '';
						}
						
					} else {
						$minimum_price_seller_id = '';
					}
					
					
					$product_condition_id = '';
					if(!empty($frequently_bought_togather_item->attribute[11])){
						if(!empty($frequently_bought_togather_item->attribute[11]->value)){
							if(!empty($frequently_bought_togather_item->attribute[11]->value->_)){
								$product_condition_id = $frequently_bought_togather_item->attribute[11]->value->_;
								
							} else {
								$product_condition_id = '';
							}
						}else {
							$product_condition_id = '';
						}
						
					} else {
						$product_condition_id = '';
					}
					

					/************Start commented by Nakul on 20-jan-2012*****************************/
					/*if(!empty($frequently_bought_togather_item->attribute[7])){
						if(!empty($frequently_bought_togather_item->attribute[7]->value)){
							if(!empty($frequently_bought_togather_item->attribute[7]->value->_)){
								$cus_product_rrp = $frequently_bought_togather_item->attribute[7]->value->_;
							} else {
								$cus_product_rrp = '';
							}
						}else {
							$cus_product_rrp = '';
						}
					} else {
						$cus_product_rrp = '';
					}
					$minimum_price_used_seller = '';
					if(!empty($frequently_bought_togather_item->attribute[5])){

						if(!empty($frequently_bought_togather_item->attribute[5]->value)){
							if(!empty($frequently_bought_togather_item->attribute[5]->value->_)){
								$minimum_price_used = $frequently_bought_togather_item->attribute[5]->value->_;
								if(!empty($frequently_bought_togather_item->attribute[10])){
									if(!empty($frequently_bought_togather_item->attribute[10]->value)){
										if(!empty($frequently_bought_togather_item->attribute[10]->value->_)){
											$minimum_price_used_seller = $frequently_bought_togather_item->attribute[10]->value->_;
										}
									}
								}
								if(!empty($frequently_bought_togather_item->attribute[12])){
									if(!empty($frequently_bought_togather_item->attribute[12]->value)){
										if(!empty($frequently_bought_togather_item->attribute[12]->value->_)){
											$condition_used_seller = $frequently_bought_togather_item->attribute[12]->value->_;
										}
									}
								}
							} else {
								$minimum_price_used = '';
							}
						}else {
							$minimum_price_used = '';
						}
						
					} else {
						$minimum_price_used = '';
					}
					$minimum_price_new_seller = '';
					if(!empty($frequently_bought_togather_item->attribute[6])){
						if(!empty($frequently_bought_togather_item->attribute[6]->value)){
							if(!empty($frequently_bought_togather_item->attribute[6]->value->_)){
								$minimum_price_new = $frequently_bought_togather_item->attribute[6]->value->_;
								
								if(!empty($frequently_bought_togather_item->attribute[9])){
									if(!empty($frequently_bought_togather_item->attribute[9]->value)){
										if(!empty($frequently_bought_togather_item->attribute[9]->value->_)){
											$minimum_price_new_seller = $frequently_bought_togather_item->attribute[9]->value->_;
										}
									}
								}
								
								if(!empty($frequently_bought_togather_item->attribute[11])){
									if(!empty($frequently_bought_togather_item->attribute[11]->value)){
										if(!empty($frequently_bought_togather_item->attribute[11]->value->_)){
											$condition_new_seller = $frequently_bought_togather_item->attribute[11]->value->_;
										}
									}
								}
							} else {
								$minimum_price_new = '';
							}
						}else {
							$minimum_price_new = '';
						}
						
					} else {
						$minimum_price_new = '';
					}
				}
				
				if(!empty($condition_new_seller)){
					$condition_new_seller = $this->Common->getProductConIdByConName($condition_new_seller);
				} else {
					$condition_new_seller = '';
				}
				if(!empty($condition_used_seller)){
					$condition_new_seller = $this->Common->getProductConIdByConName($condition_used_seller);
				} else {
					$condition_used_seller = '';
				}


				$prods_fre_togather[$pr_qc]['id'] = $pr_id;
				$prods_fre_togather[$pr_qc]['qc_code'] = $pr_qc;
				$prods_fre_togather[$pr_qc]['image'] = $cus_image_path;
				$prods_fre_togather[$pr_qc]['name'] = $cus_pr_name;
				$prods_fre_togather[$pr_qc]['rrp'] = $cus_product_rrp;
				$prods_fre_togather[$pr_qc]['minimum_price_used'] = $minimum_price_used;
				$prods_fre_togather[$pr_qc]['minimum_price_new'] = $minimum_price_new;
				$prods_fre_togather[$pr_qc]['minimum_price_used_seller'] = $minimum_price_used_seller;
				$prods_fre_togather[$pr_qc]['minimum_price_new_seller'] = $minimum_price_new_seller;
				$prods_fre_togather[$pr_qc]['condition_used_seller'] = $condition_used_seller;
				$prods_fre_togather[$pr_qc]['condition_new_seller'] = $condition_new_seller;*/
				/************END commented by Nakul on 20-jan-2012*****************************/
				
				$prods_fre_togather[$pr_qc]['id'] = $pr_id;
				$prods_fre_togather[$pr_qc]['qc_code'] = $pr_qc;
				$prods_fre_togather[$pr_qc]['image'] = $cus_image_path;
				$prods_fre_togather[$pr_qc]['name'] = $cus_pr_name;
				$prods_fre_togather[$pr_qc]['minimum_seller_price'] = $minimum_seller_price;
				$prods_fre_togather[$pr_qc]['minimum_price_seller_id'] = $minimum_price_seller_id;
				$prods_fre_togather[$pr_qc]['pro_con_id'] = $product_condition_id;
				
			}}
	if(!empty($prods_fre_togather)) {?>
<section class="forall">
	<p class="thumb-imgs allitems">
		<?php $i = 1;$total_price_added = 0;
			foreach($prods_fre_togather as $freq_prod){
			echo $html->link($html->image($freq_prod['image'],array('alt'=>$freq_prod['name'],'width'=>'30','height'=>'30' )),'/'.$this->Common->getProductUrl($freq_prod['id']).'/categories/productdetail/'.$freq_prod['id'],array('escape'=>false)); if($i < count($prods_fre_togather)) {?>
			
			<?php echo $html->image('mobile/plus_icon.png', array('alt'=>'','width'=>'12','height'=>'12','class'=>'plusicon'));?>
			<?php }?>
			<?php
			$i++;
			}
		?>
	</p>
	<!--<p class="thumb-imgs allitems"> 
	<a href="#"><img width="30" height="30" alt="" src="images/product_detail_thumb1.gif"></a>
	<a href="#"><img src="images/plus_icon.png" alt="" width="12" height="12" class="plusicon" /></a>
	<a href="#"><img width="30" height="30" alt="" src="images/product_detail_thumb2.gif"></a>
	</p>-->
	<!---->
	<section class="allprice">
		<?php
			$mix_prods_str = '';
			foreach($prods_fre_togather as $freq_prod){
					
				if(!empty($freq_prod['minimum_seller_price'])){
						$price_add = $freq_prod['minimum_seller_price'];
						$pro_seller_id = (int) ($freq_prod['minimum_price_seller_id']);
						$prod_condition = $freq_prod['pro_con_id'];
					} else {
						$price_add = 0;$pro_seller_id = 0;$prod_condition=0;
					}
					
					
					$pro_qty_info = $common->getProductSellerInfo($freq_prod['id'],$pro_seller_id,$prod_condition);
					$prod_qty = 0;
					if(!empty($pro_qty_info)){
						if((!empty($pro_qty_info['ProductSeller']['quantity'])) && ($pro_qty_info['ProductSeller']['quantity'] > 0)){
							$prod_qty = $pro_qty_info['ProductSeller']['quantity'];
						}
					}
					$prods_fre_togather[$freq_prod['qc_code']]['qty'] = $prod_qty;
					$prods_fre_togather[$freq_prod['qc_code']]['sale_price'] = $price_add;
					$prods_fre_togather[$freq_prod['qc_code']]['sel_id'] = $pro_seller_id;
					$prods_fre_togather[$freq_prod['qc_code']]['c_id'] = $prod_condition;
					if($prod_qty > 0){
						if(!empty($price_add)){
							$total_price_added = $total_price_added + $price_add;
							if(empty($mix_prods_str)){
								$mix_prods_str = $freq_prod['id'].'-1-'.$price_add.'-'.$pro_seller_id.'-'.$prod_condition;
							} else {
								$mix_prods_str = $mix_prods_str.'~'.$freq_prod['id'].'-1-'.$price_add.'-'.$pro_seller_id.'-'.$prod_condition;
							}
						}
					}
				}
			// $addtobasket = 'product_id,quantity,price,seller_id,condition';
			echo $form->hidden('basket_values',array('value'=>$mix_prods_str));
			?>
			Price for all 
			<?php echo CURRENCY_SYMBOL;?><span id = "total_freq_price"><?php echo $format->money($total_price_added,2)?>
			</span>
		<?php echo $html->link('<input type="button" value="Add all to Basket" class="adallbskt" />',"javascript:void(0)",array('escape'=>false,'class'=>'grn-btn','onClick'=>'goToBasket();'));?>
	</section>
 
	<!---->
</section>

<!---->
<?php }?>

<section class="alsobuy">

		<?php
			$i = 1;
			foreach($prods_fre_togather as $freq_prod){
			?>
				<?php
				if(!empty($freq_prod['sale_price']) && ($freq_prod['qty'] > 0)){
					$qty = $freq_prod['qty'];
					$pri = $freq_prod['sale_price'];
					$s_id = $freq_prod['sel_id'];
					$c_id = $freq_prod['c_id'];
					echo '<p>'. $form->checkbox('select_'.$freq_prod['id'],array('value'=>$freq_prod['sale_price'],'id'=>$freq_prod['id'],'checked'=>'checked','onClick'=>'changeValuesForBasket(this.id,'.$pri.','.$s_id.','.$c_id.');','style'=>array('border:0')));
				} ?> 
				<?php
				echo $html->link($freq_prod['name'],'/'.$this->Common->getProductUrl($freq_prod['id']).'/categories/productdetail/'.$freq_prod['id'],array('escape'=>false,'class'=>'underline-link')).'</p>';?>
		<?php }?>
</section>
<p class="sellmor mrktplcsllr">List and Sell for Free on Choiceful.com
                                      <a href="#">(Find out more)</a></p>
                                    <p>
                                    	<?php
						echo $html->link('<input type="button" value="Sell yours here" class="bluegradbtn margin-top" />',"/marketplaces/create_listing/".$product_details['Product']['id'],array('escape'=>false));
					?>
					
                                    
                                    </p>
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
function changeValuesForBasket(pr_id,pr_price,pr_selId,pr_cId){
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
	total_fr_price = total_fr_price.toFixed(2);
	jQuery('#basket_values').val(new_set_str);
	jQuery('#total_freq_price').text(total_fr_price);
}
</script>
