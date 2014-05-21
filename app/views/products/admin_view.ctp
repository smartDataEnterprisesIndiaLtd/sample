<?php
$this->Html->addCrumb('Product Management', ' ');
$this->Html->addCrumb('Sellers view Products', 'javascript:void(0)');

?>

<script>jQuery.noConflict();</script>
<?php
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
?>
<script language="JavaScript">
jQuery(document).ready(function()  {
jQuery("a.large-image").fancybox({
			'autoScale' : true,
			'centerOnScroll': true,
			'width' : 600,
			'height' : 700,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'autoDimensions': false,
		});
});
</script>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="top">
<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr class="adminBoxHeading">
	<td class="adminGridHeading heading" height="25px" align="left"><?php //echo $list_title; ?>
	</td>
	<td class="adminGridHeading" height="25px" align="right">
	<?php //echo $html->link('Back',array('controller'=>'users','action'=>'index'));    ?>
	</td>
</tr>
<tr>
	<td colspan="2">
		<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
			<tr height="5">
				<td width="1%"></td>
				<td width="20%" align="right"></td>
				<td width="3%" align="left"></td>
				<td align="left"></td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Product Name</td>
				<td align="left" valign="top">:</td>
				<td align="left"> <?php echo ucfirst($product_details['Product']['product_name']);?></td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Brand Name</td>
				<td align="left" valign="top">:</td>
				<td align="left">
				<?php
					if(!empty($product_details['Brand']['name'])){
						echo $product_details['Brand']['name'];
					}else{
						echo "NA";
					}
				?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">EAN/UPC (Bar Code)</td>
				<td align="left" valign="top">:</td>
				<td align="left">
				<?php
					if(!empty($product_details['Product']['barcode'])){
						echo $product_details['Product']['barcode'];
					}else{
						echo "NA";
					}
				?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top"> Manufacturer</td>
				<td align="left" valign="top">:</td>
				<td align="left">
				<?php
					if(!empty($product_details['Product']['manufacturer'])){
						echo $product_details['Product']['manufacturer'];
					}else{
						echo "NA";
					}
				?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Model Number</td>
				<td align="left" valign="top">:</td>
				<td align="left">
				<?php
					if(!empty($product_details['Product']['model_number'])){
						echo $product_details['Product']['model_number'];
					}else{
						echo "NA";
					}
				?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Price RRP</td>
				<td align="left" valign="top">:</td>
				<td align="left">
				<?php
					if(!empty($product_details['Product']['product_rrp'])){
						echo CURRENCY_SYMBOL.$product_details['Product']['product_rrp'];
					}else{
						echo "NA";
					}
				?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Department</td>
				<td align="left" valign="top">:</td>
				<td align="left">
				<?php
				if(!empty($moreToExploreArr)){
					foreach($moreToExploreArr as $breadcrums){
					if(!empty($breadcrums)){
					?>
					<li><?php
						$i = 1;
						if(!empty($breadcrums['Dept'])){
							$dept_url=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($breadcrums['Dept']['Department']['name'], ENT_NOQUOTES, 'UTF-8'));
							echo $html->link($breadcrums['Dept']['Department']['name'],"/".$dept_url."/departments/index/".$breadcrums['Dept']['Department']['id'],array('escape'=>false,'class'=>'')); echo ' &gt; ';
						}
						if(!empty($breadcrums['Parents_arr'])) {
							foreach($breadcrums['Parents_arr'] as $breadcrum){
								if($i != count($breadcrums['Parents_arr'])){
								$dept_cat_url=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($breadcrum['Category']['cat_name'], ENT_NOQUOTES, 'UTF-8'));
									echo $html->link($breadcrum['Category']['cat_name'],"/".$dept_url."/".$dept_cat_url."/categories/index/".$breadcrum['Category']['id']."/".$breadcrums['Dept']['Department']['id'],array('escape'=>false,'class'=>'')); echo ' &gt; ';
								} else {
								$dept_cat_url=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($breadcrum['Category']['cat_name'], ENT_NOQUOTES, 'UTF-8'));
									echo $html->link($breadcrum['Category']['cat_name'],"/".$dept_url."/".$dept_cat_url."/categories/viewproducts/".$breadcrum['Category']['id']."/".$breadcrums['Dept']['Department']['id'],array('escape'=>false,'class'=>''));
								}?>
							<?php $i++; }
						}?></li>
					<?php }
					}
				}
				?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="middle">Product Image</td>
				<td align="left" valign="middle">:</td>
				<td align="left">
				<?php
				if(!empty($product_details['Product']['product_image'])){
					$main_imagePath = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$product_details['Product']['product_image'];
					if(file_exists($main_imagePath)){
						//echo $html->image('/'.PATH_PRODUCT."medium/img_200_".$product_details['Product']['product_image'], array('alt'=>$product_details["Product"]["product_name"],'title'=>$product_details["Product"]["product_name"]));
						$image_path = '/'.PATH_PRODUCT."small/img_100_".$product_details['Product']['product_image'];
						echo $html->link($html->image($image_path,array('alt'=>$product_details["Product"]["product_name"],'title'=>$product_details["Product"]["product_name"])), "/categories/enlarge_mainimage/".$product_details['Product']['id'],array( 'escape'=>false,'class'=>'large-image'));
					}else{
						echo $html->link($html->image('/img/no_image_100.jpg', array('alt'=>$product_details["Product"]["product_name"],'title'=>$product_details["Product"]["product_name"])), "/categories/enlarge_mainimage/".$product_details['Product']['id'],array( 'escape'=>false,'class'=>'large-image'));
					}
					
				}else{
					echo $html->link($html->image('/img/no_image_100.jpg', array('alt'=>$product_details["Product"]["product_name"],'title'=>$product_details["Product"]["product_name"])), "/categories/enlarge_mainimage/".$product_details['Product']['id'],array( 'escape'=>false,'class'=>'large-image'));	
				}?>

				
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="middle">Multiple images </td>
				<td align="left" valign="middle">:</td>
				<td align="left">
					<style>
						.thumb-imgs img {
							margin-right: 5px !important;
						    }
						    .thumb-imgs img {
							border: 1px solid #999999;
							margin-top: 5px;
						    }
						    .video_playicon {
							border: medium none !important;
							position: absolute;
							right: 9px;
							top: -14px;
						    }
					</style>
					<p class="thumb-imgs videos-imgs-sec">
					<?php
					if(!empty($product_details['Productimage']) || !empty($product_details['Product']['product_video'])) {
					if(!empty($product_details['Productimage'])) {
						$imgCnt = 1; //Count thumbnails
						foreach($product_details['Productimage'] as $pro_image){
								$imagesPath = WWW_ROOT.PATH_PRODUCT.'small/img_50_'.$pro_image['image'];
								if(file_exists($imagesPath)){
									$image_url = $html->image('/'.PATH_PRODUCT.$pro_image['image']);
									$link_str = '/categories/enlarge_image/'.$pro_image['id'];
									echo $html->link($html->image('/'.PATH_PRODUCT."small/img_50_".$pro_image['image'], array('alt'=>"",'width'=>'30')),$link_str,array('escape'=>false,'class'=>'large-image','title'=>'Enlarge'),false,false);}
						$imgCnt = $imgCnt+1;
						}
					}
					if(!empty($product_details['Product']['product_video'])) { 
						$video_url_array = explode('/',$product_details['Product']['product_video']);
					}
					if(!empty($video_url_array[4])){
						echo $html->link($html->image('play-btn.png', array('alt'=>"",'class'=>'video_playicon')).$html->image('http://img.youtube.com/vi/'.$video_url_array[4].'/3.jpg', array('alt'=>"",'width'=>'30','height'=>'30')),'/products/play_video/'.$product_details['Product']['id'],array('escape'=>false,'class'=>'playvideo', 'style'=>'position:relative'),false,false);?><?php
					}
					}else{
						echo "NA";
					}
					?>
					</p>
				</td>
			</tr>
			<?php if($product_details['Product']['department_id'] == '1'){?>
			<tr>
				<td></td>
				<td align="right" valign="top">Author</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['author_name'])){
							echo $product_details['ProductDetail']['author_name'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Publisher</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['publisher'])){
							echo $product_details['ProductDetail']['publisher'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Language</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['language'])){
							echo $product_details['ProductDetail']['language'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">ISBN</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_isbn'])){
							echo $product_details['ProductDetail']['product_isbn'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Format</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['format'])){
							echo $product_details['ProductDetail']['format'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Pages</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['pages'])){
							echo $product_details['ProductDetail']['pages'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Publisher Review</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php
					
						if(!empty($product_details['ProductDetail']['publisher_review'])){
							echo html_entity_decode($product_details['ProductDetail']['publisher_review'], ENT_NOQUOTES, 'UTF-8');
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Year Published</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['year_published'])){
							echo $product_details['ProductDetail']['year_published'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Product Weight</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_weight'])){
							echo $product_details['ProductDetail']['product_weight'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<?php }?>
			<?php if($product_details['Product']['department_id'] == '2'){?>
			<tr>
				<td></td>
				<td align="right" valign="top">Artist</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['artist_name'])){
							echo $product_details['ProductDetail']['artist_name'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Label</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['label'])){
							echo $product_details['ProductDetail']['label'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Format</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['format'])){
							echo $product_details['ProductDetail']['format'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Rated</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['rated'])){
							echo $product_details['ProductDetail']['rated'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Number of Discs</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['number_of_disk'])){
							echo $product_details['ProductDetail']['number_of_disk'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Track List</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['track_list'])){
							echo $product_details['ProductDetail']['track_list'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Release Date</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php
						if(!empty($product_details['ProductDetail']['release_date'])){
							echo $product_details['ProductDetail']['release_date'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Product Weight</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_weight'])){
							echo $product_details['ProductDetail']['product_weight'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<?php }?>
			<?php if($product_details['Product']['department_id'] == '3'){?>
			<tr>
				<td></td>
				<td align="right" valign="top">Starring</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['star_name'])){
							echo $product_details['ProductDetail']['star_name'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Directed By</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['directedby'])){
							echo $product_details['ProductDetail']['directedby'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Format</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['format'])){
							echo $product_details['ProductDetail']['format'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Number of Discs</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['number_of_disk'])){
							echo $product_details['ProductDetail']['number_of_disk'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Rated</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['rated'])){
							echo $product_details['ProductDetail']['rated'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Language</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['language'])){
							echo $product_details['ProductDetail']['language'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Studio</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['studio'])){
							echo $product_details['ProductDetail']['studio'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Release Date</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php
						if(!empty($product_details['ProductDetail']['release_date'])){
							echo $product_details['ProductDetail']['release_date'];
							//echo $format->date_format($product_details['ProductDetail']['release_date']);
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Run Time</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['run_time'])){
							echo $product_details['ProductDetail']['run_time'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Product Weight</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_weight'])){
							echo $product_details['ProductDetail']['product_weight'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<?php }?>
			<?php if($product_details['Product']['department_id'] == '4'){?>
			<tr>
				<td></td>
				<td align="right" valign="top">Platform</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['plateform'])){
							echo $product_details['ProductDetail']['plateform'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Rated</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['rated'])){
							echo $product_details['ProductDetail']['rated'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Release Date</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['release_date'])){
							echo $format->date_format($product_details['ProductDetail']['release_date']);
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Region</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['region'])){
							echo $product_details['ProductDetail']['region'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Product Weight</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_weight'])){
							echo $product_details['ProductDetail']['product_weight'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<?php }?>
			<?php if($product_details['Product']['department_id'] == '5' || $product_details['Product']['department_id'] == '6' || $product_details['Product']['department_id'] == '7'|| $product_details['Product']['department_id'] == '8'){?>
			<tr>
				<td></td>
				<td align="right" valign="top">Product Weight</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_weight'])){
							echo $product_details['ProductDetail']['product_weight'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<?php }?>
			<?php if($product_details['Product']['department_id'] == '9'){?>
			<tr>
				<td></td>
				<td align="right" valign="top">Suitable For</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['suitable_for'])){
							echo $product_details['ProductDetail']['suitable_for'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">How to Use</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['how_to_use'])){
							echo $product_details['ProductDetail']['how_to_use'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top"> Hazards & Cautions</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['hazard_caution'])){
							echo $product_details['ProductDetail']['hazard_caution'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Precautions</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['precautions'])){
							echo $product_details['ProductDetail']['precautions'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Ingredients</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['ingredients'])){
							echo $product_details['ProductDetail']['ingredients'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			
			<tr>
				<td></td>
				<td align="right" valign="top">Product Weight</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_weight'])){
							echo $product_details['ProductDetail']['product_weight'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<?php }?>
			<tr>
				<td></td>
				<td align="right" valign="top">Height(cm)</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_height'])){
							echo $product_details['ProductDetail']['product_height'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Width(cm)</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_width'])){
							echo $product_details['ProductDetail']['product_width'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Lenght(cm)</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_length'])){
							echo $product_details['ProductDetail']['product_length'];
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Search Terms/Tags</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_searchtag'])){
							echo html_entity_decode($product_details['ProductDetail']['product_searchtag'], ENT_NOQUOTES, 'UTF-8');
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Key Features</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['product_features'])){
							echo html_entity_decode($product_details['ProductDetail']['product_features'], ENT_NOQUOTES, 'UTF-8');
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Product Description</td>
				<td align="left" valign="top">:</td>
				<td align="left">
				<?php 
						if(!empty($product_details['ProductDetail']['description'])){
							echo html_entity_decode($product_details['ProductDetail']['description'], ENT_NOQUOTES, 'UTF-8');
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Meta Title</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['meta_title'])){
							echo html_entity_decode($product_details['ProductDetail']['meta_title'], ENT_NOQUOTES, 'UTF-8');
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Meta Keywords</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['meta_keywords'])){
							echo html_entity_decode($product_details['ProductDetail']['meta_keywords'], ENT_NOQUOTES, 'UTF-8');
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Meta Description</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
						if(!empty($product_details['ProductDetail']['meta_description'])){
							echo html_entity_decode($product_details['ProductDetail']['meta_description'], ENT_NOQUOTES, 'UTF-8');
						}else{
							echo "NA";
						}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Status</td>
				<td align="left" valign="top">:</td>
				<td align="left">
					<?php 
					if($product_details['Product']['status']  == '1'){
						echo 'Active' ;
					} else {
						echo 'Inactive';
					} ?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Created on</td>
				<td align="left" valign="top">:</td>
				<td align="left"><?php echo $format->date_format($product_details['Product']['created']);
				?></td>
			</tr>
			<tr>
				<td></td>
				<td align="right" valign="top">Modified on</td>
				<td align="left" valign="top">:</td>
				<td align="left"><?php echo $format->date_format($product_details['Product']['modified']); ?></td>
			</tr>
			
		</table>
	</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>