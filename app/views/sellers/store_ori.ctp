<?php
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
?>
<style type="text/css">
.select {
float:none;
margin-right:0px;
}
</style>
<div class="mid-content">
	<?php if(!empty($seller_info['Seller']['business_display_name'])) { ?>
	<h2 class="choice_headding choiceful"><span class="black-color">Browse</span> <?php echo $seller_info['Seller']['business_display_name']."'s Store";?></h2>
	<?php }?>
	<div id="listing1234556">
		<?php echo $this->element('seller/seller_products');?>
	</div>
	
	<!--Recent History Widget Start-->
	<div class="recent-history-widget">
		<!--Recent History Start-->
		<div class="recent-history">
			<h4><strong>Your Recent History</strong></h4>
			<ul>
				<?php
				if(!empty($myRecentProducts)){
					$i=0;
				foreach ($myRecentProducts as $product){
					if($product['product_image'] == 'no_image.gif' || $product['product_image'] == 'no_image.jpeg'){
						$image_path = '/img/no_image.jpeg';
					} else{
						$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_50_'.$product['product_image'];
						if(!file_exists($image_path) ){
							$image_path = '/img/no_image_50.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_50_'.$product['product_image'];
						}
						
					}
					$i++;
					if($i > 5){ // ahow only 5 items
						continue;
					}
				?>
				<li>
				<?php  echo $html->image($image_path,array('width'=>"20",'height'=>"20", 'alt'=>""));?> <?php echo $html->link($format->formatString($product['product_name'],25, '..'),"/categories/productdetail/".$product['id'],array('escape'=>false,'class'=>''));?></li>
				<?php  }
				}  ?>
			</ul>
		</div>
		<!--Recent History Closed-->
		<!--Recent History Product List Start-->
		<div class="recent-history-pro-list">
			<h4 style="font-weight:normal;"><strong>Countinue Shopping:</strong> Customers who bought items in your recent history also bought</h4>
				<ul class="products">
				<li>
					<p class="image-sec"><?php echo $html->image('images/cat-img2.jpg',array('alt'=>'')); ?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]','#',array('escape'=>false));?></p>
					<p class="price larger-font"><strong><?php echo CURRENCY_SYMBOL; ?>5.99</strong></p>
				</li>
				<li>
					<p class="image-sec"><?php echo $html->image('images/cat-img3.jpg',array('alt'=>'')); ?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]','#',array('escape'=>false));?></p>
					<p class="price larger-font"><strong><?php echo CURRENCY_SYMBOL; ?>5.99</strong></p>
				</li>
				<li>
					<p class="image-sec"><?php echo $html->image('images/cat-img4.jpg',array('alt'=>'')); ?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]','#',array('escape'=>false));?></p>
					<p class="price larger-font"><strong><?php echo CURRENCY_SYMBOL; ?>5.99</strong></p>
				</li>
				<li>
					<p class="image-sec"><?php echo $html->image('images/cat-img5.jpg',array('alt'=>'')); ?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]','#',array('escape'=>false));?></p>
					<p class="price larger-font"><strong><?php echo CURRENCY_SYMBOL; ?>5.99</strong></p>
				</li>
				<li>
					<p class="image-sec"><?php echo $html->image('images/cat-img6.jpg',array('alt'=>'')); ?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]','#',array('escape'=>false));?></p>
					<p class="price larger-font"><strong><?php echo CURRENCY_SYMBOL; ?>5.99</strong></p>
				</li>
			</ul>
		</div>
		<!--Recent History Product List Closed-->
	</div>
	<!--Recent History Widget Closed-->
</div>
<?php  e($html->script('jquery_paging_sellerpro') );?>