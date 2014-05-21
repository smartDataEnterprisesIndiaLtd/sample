<?php
$user_id =$this->Session->read('User.id');
//echo $javascript->link('lib/prototype');
e($html->script('jquery-1.4.3.min',false));
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
?>

<script language="JavaScript">
jQuery(document).ready(function()  { // file a claim
	jQuery("a.fileaclaim").fancybox({
		'autoScale' : true,
		'width' : 428,
		'centerOnScroll': true,
		//'height' : 409,
		
		'padding':0,'overlayColor':'#000000',
		'overlayOpacity':0.5,
		'opacity':	true,
		'hideOnOverlayClick':false,
		'opacity':	true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'autoDimensions': false,
		'onComplete' : function() {
		jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
		  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
		});
		}
	});

	jQuery("a.track").fancybox({
		'autoScale' : true,
		'width' : 500,
		'centerOnScroll': true,
		//'height' : 275,
		'padding':0,'overlayColor':'#000000',
		'overlayOpacity':0.5,
		'opacity':	true,
		'hideOnOverlayClick':false,
		'opacity':	true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
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
		<?php echo $this->element('orders/tab');?>
		<!--Tabs Content Start-->
		
		<div class="tabs-content">
		<?php  if(!empty($buyer_orders)) { ?>
			<div class="order-history-top">
				<?php if(!empty($piegraph) && !empty($bargraph)) { ?>
				<!--All Categories Start-->
				<div class="all-categories">
					<h4>All Categories</h4>
					<div class="blue-fade-bg overflow-h" style="float:left;padding-right:0px">
						<!--Categories Start-->
						<div class="categories">
						<?php if(!empty($dept_value_array)) { ?>
						<ul>
							<?php foreach($dept_value_array as $dept_index_id => $depts){ //echo $dept_index_id;
							if($dept_index_id == 1)
								$dept_class = 'books';
							if($dept_index_id == 2)
								$dept_class = 'music';
							if($dept_index_id == 3)
								$dept_class = 'movies';
							if($dept_index_id == 4)
								$dept_class = 'games';
							if($dept_index_id == 5)
								$dept_class = 'electronics';
							if($dept_index_id == 6)
								$dept_class = 'office-computing';
							if($dept_index_id == 7)
								$dept_class = 'mobile';
							if($dept_index_id == 8)
								$dept_class = 'home-garden';
							if($dept_index_id == 9)
								$dept_class = 'health-beauty';
							?>
							<li class='<?php echo $dept_class;?>'><?php echo $depts['dept_name'].' ('. $depts['dept_value'].'%)'; ?></li>
							<?php }?>
							
						</ul>
						<?php }?>
						</div>
					</div>
					<div class="blue-fade-bg overflow-h" style="padding-top: 15px;padding-left:0px;padding-right:0;text-align:center">
						<!--Categories Closed-->
						<!--Categories Graph Start-->
						<div class="category-graph" style="width:100%"><?php echo $html->image("/".PATH_GRAPH."order-history-graph_".$user_id.".png",array(' alt'=>""));?></div>
						<!--Categories Graph Closed-->
					</div>
				</div>
				<!--All Categories Closed-->
				<!--Spending History Start-->
				<div class="spending-history">
					<h4>Spending History</h4>
					<div class="blue-fade-bg" style="padding-top: 15px;padding-left:0px;padding-right:0;text-align:center"><?php echo $html->image("/".PATH_GRAPH."order-history-bar-graph_".$user_id.".png",array(' alt'=>""));?></div>
				</div>
				<!--Spending History Closed-->
				<?php } else {
					echo $html->image("order-history-image.jpg",array('alt'=>''));
				}?>
				<div class="clear"></div>
			</div>
			<?php  } ?>
			<?php  echo $this->element('orders/order_history');?>
		</div>
		
		
		
		<!--Tabs Content Closed-->
		<div id="kpl">
			
		</div>
		<?php $tCount = @$this->params['paging']['Order']['count'];
			$fullNextUrlP = '';
			if(!empty($buyer_orders) && $tCount>10){
				
				$fullNextUrlP = SITE_URL.'orders/order_history/page:';
				
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

jQuery.noConflict()
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
				jQuery('#ajax_h_a').removeClass('processingbtn');
				jQuery('#ajax_h_a').addClass('loadmorebtn');
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
