<?php 
/*** Search tags for this product ****/

		/*** Search tags for this product ****/
if(!empty($meta_keywords)){
	$search_tag_arr = explode(',',$meta_keywords);
?>
<!--Search Tags Associated With This Product Start-->
<div class="row no-pad-btm overflow-h">
	<!--FBTogether Start-->
	<div class="fbtogether" style="verticle-align:middel">
		<h4 class="mid-gr-head blue-color"><span>Search Tags Associated With This Product</span></h4>
		<?php
		$number_colums = 2;
		$tag = 0;$tag_max = count($search_tag_arr)/$number_colums;$index = 0;
		for($count_tag = 0; $count_tag < $number_colums; $count_tag++ ) { ?>
		<div class="search-tags">
			<ul>
				<?php for($tag=0; $tag < $tag_max; $tag++ ) {
					if(!empty($search_tag_arr[$index])) { ?>
						<li><span style="color:#003399;text-decoration:underline"><?php echo ucwords($search_tag_arr[$index]); ?></span></li>
					<?php }
				$index++; }?>
			</ul>
		</div>
		<?php } ?>
		<div class="share-tags pad-top"><!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_default_style ">
				<a href="http://www.addthis.com/bookmark.php?v=250&amp;pubid=xa-4d882e8a367f2b78" class="addthis_button_compact">Share this Product </a>
				<span class="addthis_separator"> </span>
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_email"></a>
				<a class="addthis_button_twitter"></a>
			</div>
			<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4d882e8a367f2b78"></script>
			<!-- AddThis Button END -->
		</div>
		<div class="clear"></div>
	</div>
	<!--FBTogether Closed-->
</div>
<!--Search Tags Associated With This Product Closed-->
<?php }?>