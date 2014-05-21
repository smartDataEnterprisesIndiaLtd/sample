<?php
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
?>
<script language="javascript">
	jQuery(document).ready(function()  { // for writing a review
		jQuery("a.cancel_order_item").fancybox({
// 			'autoScale' : true,
			'titlePosition': 'inside',
			'centerOnScroll' : true,
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : 360,
			'height' : 280,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'hideOnOverlayClick':false,
			'opacity':	true,
			'type' : 'iframe',
			'autoDimensions': false,
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
	});
</script>
<!--mid Content Start-->
<div class="mid-content">
	<?php //if ($session->check('Message.flash')) { ?>
		<!--div  class="messageBlock"><?php //echo $session->flash();?></div-->
	<?php //} ?> 
	<?php if(isset($_SESSION['custom_msg'])){?>
		<div  class="messageBlock">
			<?php 	echo $_SESSION['custom_msg'];
				unset($_SESSION['custom_msg']);
			?>
		</div>
	<?php }?>
	<!--- <?php  //echo $this->element('orders/order_breadcrumb');?> --->
	
	<!--Setting Tabs Widget Start-->
	<div class="row breadcrumb-widget">
		<?php echo $this->element("orders/tab"); ?>
			<!--Tabs Content Start-->
		<div class="tabs-content">
			<?php  echo $this->element('orders/view_open_order');?>
			
                </div>
                <!--Tabs Content Closed-->
		<div id="kpl">
			
		</div>
                <!--Tabs Content Closed-->
		<?php
			$tCount = @$this->params['paging']['Order']['count'];
			$fullNextUrlP = '';			
			if(!empty($buyer_orders) && $tCount>10){
				$fullNextUrlP = SITE_URL.'orders/view_open_orders/page:';
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
				
			}
		});
			
		if(makeCond<=0){
			return false;	
		}	
		
		return false;
		
	});
});
</script>
