<?php

if(!empty($action)){
$this->params['action']=$action;
}
$add_url_string="/keyword:".$keyword;
$url = array(
	'action'=>'manage_listing',
	'controller'=>'marketplaces',
	'keyword' =>$keyword,
);

$paginator->options(array('update'=>'listing','url' => $url));
//pr($paginator);
//

if(!empty($products)) {

?>
<style>
.red-color a{
	color:#C10000;
	text-decoration:none;
}
.red-color a:hover{
	color:#C10000;
	text-decoration:none;
}
</style>
<!--Search Widget Closed-->
<?php echo $this->element('marketplace/paging'); ?>
<!--Search Widget Start-->
<?php echo $form->create('Marketplace',array(/*'action'=>'save_details',*/'action'=>'update_listing/seller_id:'.$seller_user_id,'method'=>'POST','name'=>'frm1','id'=>'frm1'));?>

<?php echo $form->hidden('Search.keyword',array('class'=>'form-textfield small-width','label'=>false,'div'=>false,'value'=>$keyword));
//echo $form->input('Check.total',array('class'=>'form-textfield small-width','label'=>false,'div'=>false,'value'=>count($products)));?>

<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
<div class="gray-color-bar border-top-botom-none">
	<ul>
		<li>
			<?php echo $form->select('Listing1.options',array('delete'=>'Delete Listings','save'=>'Save Changes'),null,array('class'=>'form-select bigger-input', 'type'=>'select','onChange'=>'updateListingvalue(this.id,"Listing2Options");'),'-- Select --'); ?>
			<!--<select name="select2" class="form-select bigger-input">
			<option>Delete Listings</option>
			</select>-->
			<?php /*$options=array(
				"url"=>"/marketplaces/update_listing","before"=>"",
				"update"=>"listing",
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"v-align-middle",
				'div'=>false,
				"type"=>"Submit",
				"id"=>"delete",
			);*/?>
			<?php //echo $ajax->submit('go-grn-btn.gif',$options);?>
			<?php echo $form->submit('go-grn-btn.gif',array('div'=>false,'type'=>'image','class'=>'v-align-middle'));?>
		</li>
		<li class="float-right">
			<!--Button Start-->
			<div class="button-widget float-right">
				<?php /*$options=array(
					"url"=>"/marketplaces/save_listing",
					"before"=>"",
					"update"=>"listing",
					"indicator"=>"plsLoaderID",
					'loading'=>"Element.show('plsLoaderID')",
					"complete"=>"Element.hide('plsLoaderID')",
					"class" =>"orange-btn",
					"type"=>"Submit",
					"id"=>"save",
				);*/?>
				<?php //echo $ajax->submit('Save Changes',$options);?>
				<?php echo $form->submit('Save Changes',array('div'=>false,'class'=>'orange-btn'));?>
				<!--<input type="submit" name="button" class="" value="" />-->
			</div>
			<!--Button Closed-->
			<div class=" float-right margin-right"><input type="reset" name="button4" class="blk-bg-button" value="Reset Values" /></div>
		</li>
	</ul>
</div>
<!--Search Widget Closed-->
<!--Search Products Start-->
<?php

if($paginator->sortDir() == 'asc'){
	$image = $html->image('d-arrow-icon.gif',array('border'=>0,'alt'=>''));
}
else if($paginator->sortDir() == 'desc'){
	$image = $html->image('u-arrow-icon.gif',array('border'=>0,'alt'=>''));
}
else{
	$image = $html->image('d-arrow-icon.gif',array('border'=>0,'alt'=>''));
}
?>
<div class="scroll-div">
	<table width="100%" border="1" bordercolor="#cccccc" rules="all" frame="void" cellspacing="0" cellpadding="5" style="border-collapse:collapse;" class="seller-listings">
		<tr>
			<!--<td>&nbsp;</td>-->
			<td width="3%">&nbsp;</td>
			<td width="5%">
				<?php if(empty($this->params['named']['seller_id'])){
					$seller_id = '';
				}else{
					$seller_id = 'seller_id:'.$this->params['named']['seller_id'];
				}
				?>
				<?php echo $paginator->sort('Seller Code', 'ProductSeller.reference_code',array('url' => array($seller_id)));?>
			</td>
			<td width="15%">
				<?php echo $paginator->sort('Product Name', 'Product.product_name',array('url' => array($seller_id)));?>
			</td>
			<td width="7%">
				<?php echo $paginator->sort('Date Created', 'ProductSeller.created',array('url' => array($seller_id)));?>
			</td>
			<td width="7%">
				<?php echo $paginator->sort('Quantity', 'ProductSeller.quantity',array('url' => array($seller_id)));?>
			</td>
			<td width="7%">Condition</td>
			<td width="7%">Notes</td>
			<td width="10%">
				<?php echo $paginator->sort('Your Price', 'ProductSeller.price',array('url' => array($seller_id)));?>
			</td>
			<td width="10%">
				<?php echo $paginator->sort('Min Price', 'ProductSeller.minimum_price',array('url' => array($seller_id)));?>
			</td>
			<td width="7%">Low Price</td>
			<td width="10%">
				<?php echo $paginator->sort('Standard Delivery', 'ProductSeller.standard_delivery_price',array('url' => array($seller_id)));?>
			</td>
			<td width="10%">
				<?php echo $paginator->sort('Express Delivery', 'ProductSeller.express_delivery_price',array('url' => array($seller_id)));?>
			</td>
		</tr>
		<tr>
			<!--<td>&nbsp;</td>-->
			<td><?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectall', 'onChange'=>'checkedall()','style'=>array('border:0'))); ?></td>
			<td><?php if($paginator->sortKey() == 'ProductSeller.reference_code'){
				echo ' '.$image; 
			} else{
				echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
			}?></td>
			<td><?php if($paginator->sortKey() == 'Product.product_name'){
				echo ' '.$image; 
			} else{
				echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
			}?></td>
			<td><?php if($paginator->sortKey() == 'ProductSeller.created'){
				echo ' '.$image; 
			} else{
				echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
			}?></td>
			<td><?php if($paginator->sortKey() == 'ProductSeller.quantity'){
				echo ' '.$image; 
			} else{
				echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
			}?>
			</td>
			<td><?php echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" )); ?></td>
			<td><?php echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" )); ?></td>
			<td><?php if($paginator->sortKey() == 'ProductSeller.price'){
				echo ' '.$image; 
			} else{
				echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
			}?></td>
			<td><?php if($paginator->sortKey() == 'ProductSeller.minimum_price'){
				echo ' '.$image; 
			} else{
				echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
			}?></td>
			<td><?php echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" )); ?></td>
			<td><?php if($paginator->sortKey() == 'ProductSeller.standard_delivery_price'){
				echo ' '.$image; 
			} else{
				echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
			}?></td>
			<td><?php if($paginator->sortKey() == 'ProductSeller.express_delivery_price'){
				echo ' '.$image; 
			} else{
				echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
			}?></td>
		</tr>
		<?php  //pr($conditionArr);
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller();
		$i = 1;
		foreach($products as $product) { 
			//'fields'=>array('ProductSeller.seller_id')
			if(($i%2) == 0){ $classtr = 'even'; } else { $classtr = 'odd'; } ?>
		<tr class = "<?php echo $classtr;?>">
		<?php //pr($product);?>
			<!--<td>&nbsp;</td>-->
			<td>
				<?php echo $form->checkbox('select.'.$product['ProductSeller']['id'],array('value'=>$product['ProductSeller']['id'],'id'=>'select1_'.$product['ProductSeller']['id'], 'onChange'=>'checkedProductOnCheckBox('.$product['ProductSeller']['id'].')','style'=>array('border:0'))); ?>
				
				<?php echo $form->hidden('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.selected',array('class'=>'form-textfield small-width','label'=>false,'div'=>false));?>
			</td>
			<td><?php if(!empty($product['ProductSeller']['reference_code'])) echo $product['ProductSeller']['reference_code']; else echo '-'; ?></td>
			<td align="left"><?php
				
				if(!empty($product['Product']['product_name']))
					$pro_name = $product['Product']['product_name'];
				else
					$pro_name ='-';
				 echo $html->link($pro_name ,"/".$this->Common->getProductUrl($product['ProductSeller']['product_id'])."/categories/productdetail/".$product['ProductSeller']['product_id'] ,array('escape'=>false));?>
			</td>
			<td>
				<?php
				if(!empty($product['ProductSeller']['created']))
					echo date(DATE_FORMAT,strtotime($product['ProductSeller']['created']));
				else
					echo '-'; ?>
			</td>
			<td>
					<?php
						$quantityVal = $product['ProductSeller']['quantity'];
						$classQuantity = '';
					if(isset($errorr['Listing'][$product['ProductSeller']['id']]['ProductSeller']['quantity'])){
						$classQuantity =  'error_message_box';
						$quantityVal ='';
					}
						?>
			<?php echo $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.quantity',array('class'=>"form-textfield small-width $classQuantity",'maxlength'=>'9','label'=>false,'div'=>false,'value'=>$quantityVal,'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['id'].')'));?>
	
			<td>
				<?php //if(!empty($this->data['ProductSeller']['condition_id'])){ ?>
					<?php
						$condVal = $product['ProductSeller']['condition_id'];
						$classCond ='';
					if(isset($errorr['Listing'][$product['ProductSeller']['id']]['ProductSeller']['condition_id'])){
						 $classCond = 'error_message_box';
						 $condVal = array();
					
					}
				?>

				<?php echo $form->select('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.condition_id',$conditionArr,$condVal,array('class'=>"form-textfield small-width $classCond",'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['id'].')' , 'type'=>'select'),'-- Select --'); ?></td>
				<?php //} ?>
			</td>
			<td><?php echo $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.notes',array('class'=>'form-textfield small-width','maxlength'=>'100','label'=>false,'div'=>false,'value'=>$product['ProductSeller']['notes'], 'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['id'].')'));?>
			<?php echo $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.product_id',array('type'=>'hidden','class'=>'form-textfield small-width','maxlength'=>'100','label'=>false,'div'=>false,'value'=>$product['ProductSeller']['product_id'], 'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['id'].')'));?>
			<?php echo $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.seller_id',array('type'=>'hidden','class'=>'form-textfield small-width','maxlength'=>'100','label'=>false,'div'=>false,'value'=>$product['ProductSeller']['seller_id'], 'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['seller_id'].')'));?>

			</td>
			<td><?php
				$priceVal = $product['ProductSeller']['price'];
				$classPrice ='';
				if(isset($errorr['Listing'][$product['ProductSeller']['id']]['ProductSeller']['price'])){
					$classPrice = 'error_message_box';
					$priceVal ='';
				}
				
				?>
			<?php echo CURRENCY_SYMBOL.' '. $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.price',array('class'=>"form-textfield width50 $classPrice",'maxlength'=>'9','label'=>false,'div'=>false,'value'=>$priceVal,'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['id'].')'));?></td>
			<?php
				$priceMinVal = $product['ProductSeller']['minimum_price'];
				$classMinPrice ='';
				if(isset($errorr['Listing'][$product['ProductSeller']['id']]['ProductSeller']['minimum_price'])){
					$classMinPrice = 'error_message_box';
					$priceMinVal ='';
				}
				
				?>
			
			<td><?php echo CURRENCY_SYMBOL.' '. $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.minimum_price',array('class'=>"form-textfield width50 $classMinPrice",'maxlength'=>'9','label'=>false,'div'=>false,'value'=>$priceMinVal , 'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['id'].')'));?></td>
			
			
			<td><?php				
				
			$standard_low_shipping = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.seller_id'=>$product['Product']['minimum_price_seller'],'ProductSeller.product_id'=>$product['ProductSeller']['product_id']),'fields'=>array('ProductSeller.seller_id','standard_delivery_price')));
			$standard_delivery_price = $standard_low_shipping['ProductSeller']['standard_delivery_price'];
				
				
			
					$displaySellerName = html_entity_decode($this->Common->businessDisplayName($product['Product']['minimum_price_seller']), ENT_NOQUOTES, 'UTF-8');
					if($product['ProductSeller']['condition_id'] == 1 || $product['ProductSeller']['condition_id'] == 4){
						if($product['ProductSeller']['seller_id'] != $product['Product']['minimum_price_seller']){?>
								<p><span class="red-color">
									<?php
										if($product['Product']['minimum_price_value']){
											$low_item_price =($product['Product']['minimum_price_value']+$standard_delivery_price);							
											echo '<span style="padding-left:3px;"><a href = "javascript:void(0);" title="Lowest Priced Seller: '.$displaySellerName.'">'.number_format($low_item_price,2).'</a></span>';
										}else{
											echo '<span style="padding-left:3px;">NA</span>';
										}
									?>
								</span>
								</p>
							
						<?php  }else{?>
							<p><?php echo $html->image("check-green-icon.gif" ,array('alt'=>"",'class'=>"pad-tp-btm" )); ?></p>
						<?php }
					}else{
						if($product['ProductSeller']['seller_id'] != $product['Product']['minimum_price_used_seller']){ ?>
							<p><span class="red-color"><?php 
								if($product['Product']['minimum_price_used']){
								$low_item_price =($product['Product']['minimum_price_value']+$standard_delivery_price);	
									echo '<span style="padding-left:3px;"><a href = "javascript:void(0);" title="Lowest Priced Seller: '.$displaySellerName.'">'.number_format($low_item_price,2).'</a></span>';
								}else{
									echo '<span style="padding-left:3px;">NA</span>';
								}
								?></span>
							</p>
						<?php } else{ ?>
							<p><?php echo $html->image("check-green-icon.gif" ,array('alt'=>"",'class'=>"pad-tp-btm" )); ?></p><?php 
						}
					}	
				
				?>
			</td>
			<?php
				$standVal = $product['ProductSeller']['standard_delivery_price'];
				$classStand='';
			if(isset($errorr['Listing'][$product['ProductSeller']['id']]['ProductSeller']['standard_delivery_price'])){
					$classStand='error_message_box';
					$standVal = '';
				}
			?>
			
			<td><?php echo CURRENCY_SYMBOL.' '. $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.standard_delivery_price',array('class'=>"form-textfield width50 $classStand",'label'=>false,'div'=>false,'value'=>$standVal, 'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['id'].')'));?></td>
			
			<?php
			$ecpressVal = $product['ProductSeller']['express_delivery_price'];
				$classExpress='';
			if(isset($errorr['Listing'][$product['ProductSeller']['id']]['ProductSeller']['express_delivery_price'])){
					$classExpress='error_message_box';
					$ecpressVal = '';
				}
			?>
			
			<td>
				<?php if(!empty($product['ProductSeller']['express_delivery_price'])){ ?>
				<?php echo CURRENCY_SYMBOL.' '.$form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.express_delivery_price',array('class'=>"form-textfield width50 $classExpress",'maxlength'=>'9','label'=>false,'div'=>false,'value'=>$ecpressVal , 'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['id'].')'));?>
				<?php  } else {?>
				<?php echo CURRENCY_SYMBOL.' '.$form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.express_delivery_price',array('class'=>"form-textfield width50 $classExpress",'maxlength'=>'9','label'=>false,'div'=>false,'value'=>'', 'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['id'].')'));?>
				<?php } ?>
			</td>
		</tr>
		<?php $i++; }
		//pr($this->params);
		echo $form->hidden('ProductSeller.Pageno',array('value'=>@$this->params['named']['page'],'class'=>'form-textfield small-width','label'=>false,'div'=>false));
		
		?>
	</table>
</div>

<div class="gray-color-bar border-top-botom-none">
	<ul>
		<li>
			
			<?php echo $form->select('Listing2.options',array('delete'=>'Delete Listings','save'=>'Save Changes'),null,array('class'=>'form-select bigger-input', 'type'=>'select','onChange'=>'updateListingvalue(this.id,"Listing1Options");'),'-- Select --'); ?>
			<!--<select name="select2" class="form-select bigger-input">
			<option>Delete Listings</option>
			</select>-->
			<?php /*$options=array(
				"url"=>"/marketplaces/update_listing","before"=>"",
				"update"=>"listing",
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"v-align-middle",
				'div'=>false,
				"type"=>"Submit",
				"id"=>"delete",
			);*/?>
			<?php //echo $ajax->submit('go-grn-btn.gif',$options);?>
			<?php echo $form->submit('go-grn-btn.gif',array('div'=>false,'type'=>'image','class'=>'v-align-middle'));?>
			
	
			</li>
		<li class="float-right">
			<!--Button Start-->
			<div class="button-widget float-right">
				<?php /*$options=array(
					"url"=>"/marketplaces/save_listing",
					"before"=>"",
					"update"=>"listing",
					"indicator"=>"plsLoaderID",
					'loading'=>"Element.show('plsLoaderID')",
					"complete"=>"Element.hide('plsLoaderID')",
					"class" =>"orange-btn",
					"type"=>"Submit",
					"id"=>"save",
				);*/?>
				<?php //echo $ajax->submit('Save Changes',$options);?>
				<?php echo $form->submit('Save Changes',array('div'=>false,'class'=>'orange-btn'));?>
				<!--<input type="submit" name="button" class="" value="" />-->
			</div>
			<!--Button Closed-->
			<div class=" float-right margin-right"><input type="reset" name="button4" class="blk-bg-button" value="Reset Values" /></div>
		</li>
	</ul>
</div>



		
<!--div class="gray-color-bar border-botom-none">
	<ul>
		<li>
			<?php //echo $form->create('Marketplace',array('action'=>'manage_listing/seller_id:'.$seller_user_id,'method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));?>
				<strong>Search Your Listings</strong>
				<?php //echo $form->input('Search.keyword',array('class'=>'form-textfield bigger-input','label'=>false,'div'=>false));?>
				<?php //echo $form->submit('',array('alt'=>'Search','type'=>'image','src'=>SITE_URL.'/img/go-grn-btn.gif','border'=>'0', "value"=>"search",'class'=>'v-align-middle','div'=>false))?>
			<?php //echo $form->end();?>
		</li>
	</ul>
</div-->
<!--Search Products Closed-->
<?php echo $form->end();?>

<?php echo $this->element('marketplace/paging'); ?>
<?php echo $form->create('Marketplace',array('action'=>'manage_listing/seller_id:'.$seller_user_id,'method'=>'POST','name'=>'frmlimit','id'=>'frmlimit'));?>
<div style="padding:10px 8px">
	<ul>
		<li>
			<?php echo $form->hidden('Page.keyword',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$keyword));
			if($this->params['action'] == 'update_listing' || $this->params['action'] == 'save_listing'){
				$this->params['action'] = 'manage_listing';
			}
			echo $form->hidden('Page.action',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['action']));
			echo $form->hidden('Page.url',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['url']['url']));?>
			Show <?php echo $form->select('Paging.options',array('50'=>'50','100'=>'100','150'=>'150','200'=>'200','250'=>'250'),null,array('class'=>'form-select', 'type'=>'select','style'=>'width:80px','onChange'=>'return setLimit(this.value)'),'Select');?> results per page
		</li>
	</ul>
</div>
<?php echo $form->end();?>
<!--Search Widget Closed-->
<?php } else { ?>
<div class="gray-color-bar border-top-botom-none">
	<ul>
		<li>
			No record found
		</li>
	</ul>
</div>
<?php } ?>
<script type="text/javascript">
	function setLimit(limit){
		document.frmlimit.submit();
	}

	function updateListingvalue(firstid,secondid){
		var getvalue = jQuery('#'+firstid).val();
		jQuery('#'+secondid).val(getvalue);
	}
	
	function checkedProductOnValue(ProductSeller){
		//if(jQuery('#select1_'+ProductSeller).attr('checked') == false){
		if(!jQuery('#select1_'+ProductSeller).is(':checked')){
			jQuery('#select1_'+ProductSeller).attr('checked', true);
			jQuery('#Listing'+ProductSeller+'ProductSellerSelected').val('1');
			//checkedProductOnCheckBox();
		}
	}
	
	function checkedProductOnCheckBox(ProductSeller){
		//if(jQuery('#select1_'+ProductSeller).attr('checked') == true){
		if(jQuery('#select1_'+ProductSeller).is(':checked')){
			jQuery('#Listing'+ProductSeller+'ProductSellerSelected').val('1');
		}else{
			jQuery('#Listing'+ProductSeller+'ProductSellerSelected').val('');
		}
		var j = 0;
		<?php foreach($products as $product) {
			$pro_seller_id = $product['ProductSeller']['id'];?>
			var seller_id = '<?php echo $pro_seller_id?>';
			if(jQuery('#Listing'+seller_id+'ProductSellerSelected').val() == "1"){
				j++;
			}
		<?php }?>
			if(jQuery('#PageLimit').val() != ""){
				var pagelimit = jQuery('#PageLimit').val();
			}
			if(j == pagelimit){
				jQuery('#selectall').attr('checked', true);
			}else{
				jQuery('#selectall').attr('checked', false);
			}
	}
	
	function checkedall(){
		
		//if(jQuery('#selectall').attr('checked') == true){
		if(jQuery('#selectall').is(':checked')){
			<?php foreach($products as $product) {
				$pro_seller_id = $product['ProductSeller']['id'];?>
				var seller_id = '<?php echo $pro_seller_id?>';
				jQuery('#select1_'+seller_id).attr('checked', true);
				jQuery('#Listing'+seller_id+'ProductSellerSelected').val('1');
			<?php } ?>
		}else{
			<?php foreach($products as $product) {
				$pro_seller_id = $product['ProductSeller']['id'];?>
				var seller_id = '<?php echo $pro_seller_id?>';
				jQuery('#select1_'+seller_id).attr('checked', false);
				jQuery('#Listing'+seller_id+'ProductSellerSelected').val('');
			<?php } ?>
		}
	}

	
</script>