<?php echo $javascript->link(array('lib/prototype'), false); 

?>
<style>
.seller-feedback-address {  width:145px;}
.order-list-details_r { margin-left:200px; }
.order-list-details_l { width:200px; }
</style>
<!--mid Content Start-->
<div class="mid-content">
<!--- <?php  //echo $this->element('orders/order_breadcrumb');?> --->
	<!--Setting Tabs Widget Start-->
	<div class="row breadcrumb-widget">
		<?php echo $this->element('orders/tab');?>
		<!--Tabs Content Start-->
		<div class="tabs-content">
			<script>var cnt = 1;</script>
			<?php  echo $this->element('orders/leave_seller_feedback');?>
		</div>
		<!--Tabs Content Closed-->
	<div id="kpl">
			
		</div>
                <!--Tabs Content Closed-->
		<?php
		//pr($this->params['paging']);
			$tCount = @$this->params['paging']['OrderItem']['count'];
			$fullNextUrlP = '';
			if(!empty($buyer_orders) && $tCount>10){
				$fullNextUrlP = SITE_URL.'orders/leave_seller_feedback/page:';
				
		?>
		 <!--Load More Content Start-->
                <section class="loadmore" id="loadFocus">
			<a id="ajax_h_a"  href=" " class="loadmorebtn"><span>Load more</span></a>
                </section>
		<?php } ?>
		
	</div>
	<!--Setting Tabs Widget Closed-->
</div>
<input type="hidden" id="tempVal" value="2">
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
	
	// set the flag for disable the ajax request
	//var flag =1;

	jQuery('#ajax_h_a').click(function(){
		jQuery('#ajax_h_a').removeClass('loadmorebtn');
		jQuery('#ajax_h_a').addClass('processingbtn');
		jQuery('#fade').show();
		jQuery('#plsLoaderID').show();
		var pageId= jQuery("#tempVal").val();
		var total = "<?php echo $tCount; ?>";
		var checkTotal = parseInt(pageId)*parseInt(10);
		var makeCond = parseInt(total)-parseInt(checkTotal);
		//alert(makeCond+"vhbvn"+total);
		
		//disable ajax request after all  the record has been fetched
		/*if(flag== 2){
			jQuery('#fade').hide();
			jQuery('#plsLoaderID').hide();
			return false;	
		}*/
		
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
					jQuery('#ajax_h_a').removeClass('processingbtn');
					jQuery('#ajax_h_a').addClass('loadmorebtn');
					if(makeCond<=0){
						jQuery('#loadFocus').hide();
						jQuery('#fade').hide();
						jQuery('#plsLoaderID').hide();
						//return false;	
					}
					// hide the laoding screen
					jQuery('#fade').hide();
					jQuery('#plsLoaderID').hide();
					if(makeCond<=0){
						jQuery('#loadFocus').hide();
					}
				}
			
		
		});
		if(makeCond<=0){
			return false;	
		}	
		
		return false;
		
	});
});
</script>
<?php if(!empty($active_order_item_id)){ ?>
<script>
var active_order_item_id = '<?php echo $active_order_item_id;?>';

jQuery('#OrderFeedback'+active_order_item_id).focus();
</script><?php 
}?>
