<?php

?>
<!--Right Section Start-->
<?php echo $this->element('/recommended_product_fh');?>
<!--Right Section Closed-->
	<!--Right Section Closed-->
	<!--mid Content Start-->
	<div class="mid-content pro-mid-content">
		<!--Quich order Start-->
		
		<?php
		if ($session->check('Message.flash')){ ?>
			<div style="overflow: hidden; margin-bottom:3px;">
				<?php echo $session->flash();?>
			</div>
			<?php 	$errorQuickCode ='form-textfield small-width error_message_box';
				$errorQuantity ='form-textfield v-smal-width error_message_box';
			?>
		<?php }else{
				$errorQuickCode ='form-textfield small-width';
				$errorQuantity ='form-textfield v-smal-width';
			
		}?>
		
		<div class="gray-head-bx" style="margin:0px;">
			<h4 class="gray-heading sml-fnt">Quick Order using QuickCodes</h4>
			<div class="wht-bx-widget">
				<ul>
					<li>If you already have the QuickCodes for the items you wish to add to your order, fill them in and the quantity of each, then add directly to your shopping basket.</li>
					<li><strong>Note</strong>: Only new products will be added. The lowest price seller will be taken for each product entered.</li>
				</ul>
			</div>
		</div>
		<!--Quich order Closed-->
		<!--Quich Code Start-->
		<?php echo $form->create('Basket',array('action'=>'quick_order','method'=>'POST','name'=>'frmBasket','id'=>'frmBasket'));?>
		<div class="quick-code-widget">
			<!--Left Start-->
			<div class="side-quick-codes">
				<ul>
					<li><strong>Quick Code</strong></li>
					<?php for($i=0; $i<7;$i++){ ?>
					<li>
						<?php echo $form->input('Basket.quick_code.'.$i,array('class'=>$errorQuickCode,'label'=>false,'maxlength'=>'20','div'=>false));?>
						<span class="margn-lt"><strong>Quantity:</strong></span>
						<?php echo $form->input('Basket.quantity.'.$i,array('class'=>$errorQuantity,'onkeyup'=>'javascript: if( isNaN(this.value) ){ this.value=""; }','label'=>false,'maxlength'=>'20','div'=>false));?>
					</li>
					<?php }?>
				</ul>
			</div>
			<!--Left Closed-->
			<!--Right Start-->
			<div class="side-quick-codes">
				<ul>
					<li><strong>Quick Code</strong></li>
					<?php for($i=7; $i<14;$i++){ ?>
					<li>
						<?php echo $form->input('Basket.quick_code.'.$i,array('class'=>$errorQuickCode,'label'=>false,'maxlength'=>'20','div'=>false));?>
						<span class="margn-lt"><strong>Quantity:</strong></span>
						<?php echo $form->input('Basket.quantity.'.$i,array('class'=>$errorQuantity,'label'=>false,'onkeyup'=>'javascript: if( isNaN(this.value) ){ this.value=""; }','maxlength'=>'20','div'=>false));?>
					</li>
					<?php }?>
				</ul>
			</div>
			<!--Right Closed-->
			<div class="clear"></div>
			<p class="button-widget inline-block mar-lt"><input type="submit" name="button" class="orange-btn" value="Add to Basket"></p>
			<p>&nbsp;</p>
		</div>
		<!--Quich Code Closed-->
		<?php echo $form->end();?>
		

<?php  if( !empty($myRecentProducts) ){ ?>
		<!--Customers Who Bought This Item Also Bought Start-->
		<div class="row no-pad-btm">
			<h4 class="mid-gr-head blue-color"><span>Recently Viewed Items</span></h4>
			<!--Products Widget Start-->
			<div class="top-products-widget outerdiv_resolution outerdiv_resolution-customerlooking">
	<!-- 		<div class="top-products-widget"> -->
				<ul class="products no-pad-btm">
					<?php 
					$i = 0;
					foreach ($myRecentProducts as $keyId=>$productArr){
					$i++;
					if($productArr['product_image'] == 'no_image.gif' || $productArr['product_image'] == 'no_image.jpeg'){
						$image_path = '/img/no_image.jpeg';
					} else{
						$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$productArr['product_image'];
						if(!file_exists($image_path) ){
							$image_path = '/img/no_image_100.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$productArr['product_image'];
						}
						
						
					}
					?>
					<li class="inner_div_resolution res<?php echo $i;?>">
	<!--<li> -->
					<div style ="padding:0 5px">
						<p class="image-sec">
							<?php  
							$product_url_quicko=str_replace(array(' ','/','&quot;'), array('-','','"'), html_entity_decode($productArr['product_name'], ENT_NOQUOTES, 'UTF-8'));
							echo
							$html->link($html->image($image_path, array('alt'=>"")),'/'.$product_url_quicko.'/categories/productdetail/'.$productArr['id'],array('escape'=>false,));?>
						</p>
						<p>
							<?php
							$prodName = $format->formatString($productArr['product_name'], 500 ); 
							echo $html->link($prodName,'/'.$product_url_quicko.'/categories/productdetail/'.$productArr['id'],array('escape'=>false,));?>
						</p>
						<p>
							<?php
							if(!empty($productArr['minimum_price_value']) && $productArr['minimum_price_value'] > 0 ){
								echo '<span class="smalr-fnt">New from &nbsp;</span> <span class="price larger-font"> <strong>';
								echo CURRENCY_SYMBOL.$format->money($productArr['minimum_price_value'],2).'</span></strong>';
							}else{
								echo '<span class="smalr-fnt">RRP &nbsp;</span> <span class="price larger-font"> <strong>';
								echo CURRENCY_SYMBOL.$format->money($productArr['product_rrp'],2).'</span></strong>';
							}
							?>
						</p>
						<?php if(!empty($productArr['minimum_price_used']) && $productArr['minimum_price_value'] > 0 ){ ?>
						<p ><span class="used-from">Used from &nbsp;</span><span class="price"> 
							<?php	echo CURRENCY_SYMBOL.$format->money($productArr['minimum_price_used'],2); ?>
							</span>
						</p>
						<?php } ?>
					</div></li>
					<?php  }  ?>
				</ul>
			</div>
			<!--Products Widget Closed-->
		</div>
		<!--Customers Who Bought This Item Also Bought Closed-->
	<?php }?>
	</div>
	<!--mid Content Closed-->
</div>
<?php echo $javascript->link(array('change_resolution_basket'));?>