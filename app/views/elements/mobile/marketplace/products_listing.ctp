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
//

if(!empty($products)){
?>
	<!--Paging Widget Start-->
		<?php echo $this->element('mobile/marketplace/paging'); ?>
	<!--Paging Widget Closed-->
	<?php echo $form->create('Marketplace',array('action'=>'update_listing','method'=>'POST','name'=>'frm1','id'=>'frm1'));?>

		<?php echo $form->hidden('Search.keyword',array('class'=>'form-textfield small-width','label'=>false,'div'=>false,'value'=>$keyword));?>

		<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>

	<!--Search Widget Start-->
	<div class="gry-clr-br brdr-tp-btm-nn">
		<ul>
		<li>
			<?php //echo $form->select('Listing1.options',array('delete'=>'Delete Listings','save'=>'Save Changes'),null,array('class'=>'form-select ls-wider', 'type'=>'select','onChange'=>'updateListingvalue(this.id,"Listing2Options");'),'-- Select --'); ?>
			<?php echo $form->select('Listing1.options',array('delete'=>'Delete Listings','save'=>'Save Changes'),'-- Select --',array('class'=>'form-select ls-wider', 'type'=>'select','onChange'=>'updateListingvalue(this.id,"Listing2Options");'),'-- Select --'); ?>
			<?php echo $form->submit('Go',array('div'=>false,'type'=>'submit','class'=>'grngradbtn'));?>
			<!--<input type="submit" name="button2" value="Go" class="grngradbtn" />-->
		</li>
		</ul>
	</div>
	<!--Search Widget Closed-->
	
	<!--Search Products Start-->
	<div class="scroll-div">                                
		<table width="100%" border="1" bordercolor="#cccccc" rules="all" frame="void" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" class="seller-listings">
		
			<tr>
			<td>&nbsp;</td>
				<td>
					<?php echo $paginator->sort('Product Name', 'Product.product_name');?>
				</td>
				
				<td>
					<?php echo $paginator->sort('Quantity', 'ProductSeller.quantity');?>
				</td>
				
				<td style="width:20%">
					<?php echo $paginator->sort('Your Price', 'ProductSeller.price');?>
				</td>
			</tr>
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
			<tr>
				
				<td><?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectall', 'onChange'=>'checkedall()','style'=>array('border:0'))); ?></td>
				<td>
					<?php if($paginator->sortKey() == 'Product.product_name'){
						echo ' '.$image; 
					} else{
						echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
					}?>
				</td>
				
				<td>
					<?php if($paginator->sortKey() == 'ProductSeller.quantity'){
						echo ' '.$image; 
					} else{
						echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
					}?>
				</td>
				<td>
					<?php if($paginator->sortKey() == 'ProductSeller.price'){
						echo ' '.$image; 
					} else{
						echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
					}?>
				</td>
			</tr>
			
			
			<?php  //pr($conditionArr);
			$i = 1;
			foreach($products as $product) { 
				if(($i%2) == 0){ $classtr = 'even'; } else { $classtr = 'odd'; } 
				
				?>
			<tr class = <?php echo $classtr;?> >
			
				<td>
					<?php echo $form->checkbox('select.'.$product['ProductSeller']['id'],array('value'=>$product['ProductSeller']['id'],'id'=>'select1_'.$product['ProductSeller']['id'], 'onChange'=>'checkedProductOnCheckBox('.$product['ProductSeller']['id'].')','style'=>array('border:0'))); ?>
					<?php echo $form->hidden('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.selected',array('class'=>'form-textfield small-width','label'=>false,'div'=>false));?>
				</td>
				
				<td align="left">
					<?php
					if(!empty($product['Product']['product_name']))
						$pro_name = $product['Product']['product_name'];
					else
						$pro_name ='-';
					//echo $html->link($pro_name ,'/'.$this->Common->getProductUrl($product['ProductSeller']['product_id']).'/categories/productdetail/'.$product['ProductSeller']['product_id'] ,array('escape'=>false));
					echo $html->link($pro_name ,'/marketplaces/create_listing/'.$product['ProductSeller']['product_id'] ,array('escape'=>false));?>
					
					<?php /******Some Data is not display in mobile section *********/?>
					<?php echo $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.notes',array('class'=>'form-textfield small-width','type'=>'hidden','maxlength'=>'100','label'=>false,'div'=>false,'value'=>$product['ProductSeller']['notes']));?>
					
					<?php echo $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.notes',array('class'=>'form-textfield small-width', 'type'=>'hidden','maxlength'=>'100','label'=>false,'div'=>false,'value'=>$product['ProductSeller']['notes']));?>
				
					<?php  echo $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.minimum_price',array('class'=>'form-textfield width50', 'type'=>'hidden','label'=>false,'div'=>false,'value'=>$product['ProductSeller']['minimum_price']));?>
					
					<?php echo $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.standard_delivery_price',array('class'=>'form-textfield width50', 'type'=>'hidden','label'=>false,'div'=>false,'value'=>$product['ProductSeller']['standard_delivery_price']));?>
					
					<?php 
					echo $form->hidden('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.condition_id',array('class'=>'form-textfield small-width','label'=>false,'div'=>false,'value'=>$product['ProductSeller']['condition_id']));
					
					//echo $form->select('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.condition_id',$conditionArr,$product['ProductSeller']['condition_id'],array('class'=>'form-textfield small-width', 'type'=>'select'),'-- Select --'); ?>
					
					<?php if(!empty($product['ProductSeller']['express_delivery_price'])){ ?>
					<?php echo  $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.express_delivery_price',array('class'=>'form-textfield width50','type'=>'hidden','label'=>false,'div'=>false,'value'=>$product['ProductSeller']['express_delivery_price']));?>
					<?php  } else {?>
					<?php $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.express_delivery_price',array('class'=>'form-textfield width50','type'=>'hidden','label'=>false,'div'=>false,'value'=>''));?>
					<?php } ?>
					
					<?php /******END Some Data is not display in mobile section *********/?>
					
				</td>
					
				
				<td>
					<?php echo $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.quantity',array('class'=>'input lwr-wdth','label'=>false,'div'=>false,'value'=>$product['ProductSeller']['quantity'],'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['id'].')'));?>
					<?php //echo $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.quantity',array('class'=>"form-textfield small-width $classQuantity",'maxlength'=>'9','label'=>false,'div'=>false,'value'=>$quantityVal,'onChange'=>'checkedProductOnValue('.$product['ProductSeller']['id'].')'));?>
					
				<!--<input type="text" name="textfield4" class="input lwr-wdth" value="45" />-->
				</td>
				<td>
					<?php echo CURRENCY_SYMBOL.' '. $form->input('Listing.'.$product['ProductSeller']['id'].'.ProductSeller.price',array('class'=>'input lwr-wdth','label'=>false,'div'=>false,'value'=>$product['ProductSeller']['price']));?>
				</td>
				<!--&pound; <input type="text" name="textfield5" class="input lwr-wdth" value="0.00" />-->
			
			</tr>
			<?php $i++; }?>
			
		</table>
	</div>
	<!--Search Products Closed-->
	<?php echo $form->end();?>
	<!--Paging Widget Start-->
	<?php //echo $this->element('mobile/product/paging_products_users_fh');?>

	<?php echo $this->element('mobile/marketplace/paging_footer');?>
	<!--Paging Widget Closed-->

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
<script defer="defer" type="text/javascript">
	function setLimit(limit){
		document.frmlimit.submit();
	}

	function updateListingvalue(firstid,secondid){
		var getvalue = jQuery('#'+firstid).val();
		jQuery('#'+secondid).val(getvalue);
	}
	
	function checkedProductOnValue(ProductSeller){
		if(jQuery('#select1_'+ProductSeller).attr('checked') == false){
			jQuery('#select1_'+ProductSeller).attr('checked', true);
			jQuery('#Listing'+ProductSeller+'ProductSellerSelected').val('1');
			checkedProductOnCheckBox();
		}
	}
	
	function checkedProductOnCheckBox(ProductSeller){
		if(jQuery('#select1_'+ProductSeller).attr('checked') == true){
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
		if(jQuery('#selectall').attr('checked') == true){
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