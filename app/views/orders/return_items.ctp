<?php
echo $javascript->link('lib/prototype');
e($html->script('jquery-1.4.3.min',false));
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
?>
<style type="text/css">
.order-product-image {
padding-top:0px;
}.v-smal-width {
width:30px;
padding:0px;
}
</style>
<!--mid Content Start-->
<div class="mid-content">
	<!--- <?php  //echo $this->element('orders/order_breadcrumb');?> --->
	
	<!--Setting Tabs Widget Start-->
	<div class="row breadcrumb-widget">
		<?php echo $this->element("orders/tab"); ?>
		<!--Tabs Content Start-->
		<div class="tabs-content">
				<?php  echo $this->element('orders/return_items');?>
		</div>
		<div id="kpl">
			
		</div>
		<?php
		$tCount = @$this->params['paging']['Order']['count'];
		$fullNextUrlP = '';
			if(!empty($buyer_orders) && $tCount>10){
				
				$fullNextUrlP = SITE_URL.'orders/return_items/page:';
				
		?>
		 <!--Load More Content Start-->
                <section class="loadmore" id="loadFocus">
			<a id="ajax_h_a"  href=" " class="loadmorebtn"><span>Load more</span></a>
                </section>
		<?php }
		
		?>
		 
	</div>
	<!--Setting Tabs Widget Closed-->
	<input type="hidden" id="tempVal" value="2">
</div>

	
	<?php $img_l =  $this->Html->image('ajax-loader.gif', array('alt' => 'In Progress'));?>
<!--mid Content Closed-->
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('body').prepend('<div class="black_overlay" id="fade" style="display: none;"></div><div style="background-color: white; display: none;" id="loading-image"><table border="0" cellspacing="0" cellpadding="5"><tbody><tr><td><?php echo $img_l; ?></td><td class="upload_cloud_img">Loading..Please Wait!</td></tr></tbody></table></div>');
	// get updated paginate page value
	var pageId= jQuery("#tempVal").val();
	var newStr = "<?php  echo $fullNextUrlP;?>"+pageId;
	//set up the url intially
	jQuery('#loadFocus a').attr('href',newStr);
	
	jQuery('#ajax_h_a').click(function(){
		jQuery('#ajax_h_a').removeClass('loadmorebtn');
		jQuery('#ajax_h_a').addClass('processingbtn');
		jQuery('#fade').show();
		jQuery('#plsLoaderID').show();
		var pageId= jQuery("#tempVal").val();
		var total = "<?php echo $tCount; ?>";
		var checkTotal = parseInt(pageId)*parseInt(10);
		var makeCond = parseInt(total)-parseInt(checkTotal);
		
		//Get ajax URL 
		var ajax_url= jQuery('#ajax_h_a').attr('href');
		
		//Set the next URL for pagination 
		jQuery("#tempVal").val(parseInt(pageId)+1);
		var pageId= jQuery("#tempVal").val();
		var newStr = "<?php  echo $fullNextUrlP;?>"+pageId;
		jQuery(this).attr('href',newStr);
		
		// Run the ajax Call 
		jQuery.ajax({
			url: ajax_url,
			cache: false,
			success: function(msg){
			// Append the html 	
				jQuery('#kpl').append(msg).after(function() {
					
					
				});
				// hide the laoding screen
				jQuery('#fade').hide();
				jQuery('#plsLoaderID').hide();
				if(makeCond<=0){
					jQuery('#loadFocus').hide();
				}
				jQuery('#ajax_h_a').removeClass('processingbtn');
				jQuery('#ajax_h_a').addClass('loadmorebtn');
			}
		});
		if(makeCond<=0){
			return false;	
		}	
		
		return false;
		
	});
});

<?php if(empty($prev_item_id)) $prev_item_id = 0;?>
var itemId = <?php echo $prev_item_id; ?>;
if(itemId > 0){
	jQuery('#OrderReturn'+itemId).attr('checked',true);
	showdiv(itemId);
}
function showdiv(id){
	var checkedValue = jQuery('#OrderReturn'+id).attr('checked');

	if(checkedValue != ''){
 		jQuery('#returnThis'+id).css('display','block');
		jQuery('#err_msg'+id).css('display','block');
	} else{
 		jQuery('#returnThis'+id).css('display','none');
		jQuery('#err_msg'+id).css('display','none');
	}
// 	jQuery('#OrderFeedback'+id).focus();
}

</script>
