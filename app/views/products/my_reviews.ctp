<?php ?>
<!--mid Content Start-->
<div class="mid-content" style="min-height:635px;">
	<!---<div class="breadcrumb-widget">
		
		<?php echo $html->link('Home', '/', array('alt'=>'') );?> >
		<?php echo $html->link('My Account', '/orders/view_open_orders', array('alt'=>'') );?> >
		<span class="choiceful"><strong>Orders</strong></span>
	
	</div> --->
	<!--Setting Tabs Widget Start-->
	<div class="row breadcrumb-widget">
		<?php
		//echo "<pre>";
		//print_r($all_reviews);
		//echo "</pre>";
		
		echo $this->element('product/tabs'); ?>
		<!--Tabs Content Start-->
		<div class="tabs-content">
			<?php if(!empty($all_reviews) || !empty($all_certificate_reviews)){ ?>
			<?php  echo $this->element('product/all_reviews');  ?>
			

		                   <div id="kpl">
			
		  </div>
                <!--Tabs Content Closed-->
		<?php
		
			$tCount = @$this->params['paging']['MadeOffer']['count'];
            //echo $tCount;
			$fullNextUrlP = '';
			if(!empty($all_reviews) && $tCount>10){
				$fullNextUrlP = SITE_URL.'products/my_reviews/madeOffer:1/page:';
				
		?>
		 <!--Load More Content Start-->
                <section class="loadmore" id="loadFocus">
			<a id="ajax_h_a"  href=" " class="loadmorebtn"><span>Load more</span></a>
                </section>
		<?php } ?>
		
	
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
	jQuery('#h_a').attr('href','#content');
	// set the flag for disable the ajax request
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
				    //alert(msg);
				  jQuery('#fade').hide();
				// Append the html 	
				jQuery('#kpl').append(msg).after(function() {
					jQuery('#ajax_h_a').removeClass('processingbtn');
				        jQuery('#ajax_h_a').addClass('loadmorebtn')
					jQuery('#plsLoaderID').hide();
					if(makeCond<=0){
						jQuery('#loadFocus').hide();
					}
				});
				
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
		<?php  echo $this->element('product/all_certificate_reviews');  ?>
		
		                      <div id="kplRec">
			
		  </div>
                <!--Updated div closed-->
		<?php
		
			$tCountRec = @$this->params['paging']['recievedOffer']['count'];
			$fullNextUrlREC = '';
			//echo $tCountRec;
			if(!empty($all_certificate_reviews) && $tCountRec>10){
				$fullNextUrlREC = SITE_URL.'products/my_reviews/recievedOffer:1/page:';
				
		?>
		 <!--Load More Content Start-->
                <section class="loadmore" id="loadFocusRec">
			<a id="ajax_h_aRec"  href=" " class="loadmorebtn"><span>Load more</span></a>
                </section>
		<?php } ?>
                
                <input type="hidden" id="tempValRec" value="2">
	<?php $img_l =  $this->Html->image('ajax-loader.gif', array('alt' => 'In Progress'));?>
<!--mid Content Closed-->
<script type="text/javascript">
jQuery(document).ready(function(){
	// get updated paginate page value
	var pageIdRec= jQuery("#tempValRec").val();
	var newStrRec = "<?php  echo $fullNextUrlREC;?>"+pageIdRec;
	//set up the url intially
	jQuery('#loadFocusRec a').attr('href',newStrRec);
	
	jQuery('#ajax_h_aRec').click(function(){
		jQuery('#ajax_h_aRec').removeClass('loadmorebtn');
		jQuery('#ajax_h_aRec').addClass('processingbtn');
		jQuery('#fade').show();
		jQuery('#plsLoaderID').show();
		var pageIdRec= jQuery("#tempValRec").val();
		var totalRec = "<?php echo $tCountRec; ?>";
		var checkTotalRec = parseInt(pageIdRec)*parseInt(10);
		var makeCondRec = parseInt(totalRec)-parseInt(checkTotalRec);
		//alert(makeCond+"vhbvn"+total);
		
		//Get ajax URL 
		var ajax_urlRec= jQuery('#ajax_h_aRec').attr('href');
		
		//Set the next URL for pagination 
		jQuery("#tempValRec").val(parseInt(pageIdRec)+1);
		var pageIdRec= jQuery("#tempValRec").val();
		var newStrRec = "<?php  echo $fullNextUrlREC;?>"+pageIdRec;
		jQuery(this).attr('href',newStrRec);
		
		// Run the ajax Call 
			jQuery.ajax({
				url: ajax_urlRec,
				cache: false,
				
				success: function(msg){
				//  alert(msg);
				 
				// Append the html 	
				jQuery('#kplRec').append(msg).after(function() {
					jQuery('#ajax_h_aRec').removeClass('processingbtn');
				        jQuery('#ajax_h_aRec').addClass('loadmorebtn');
					jQuery('#fade').hide();
					jQuery('#plsLoaderID').hide();
					if(makeCondRec<=0){
						
						jQuery('#loadFocusRec').hide();
						//return false;	
					}
				});
				
				// hide the laoding screen
				jQuery('#fade').hide();
				jQuery('#plsLoaderID').hide();
			}
		});
		if(makeCondRec<=0){
			return false;	
		}	
		return false;
		
	});
});
</script>  

		

			<?php } else {?>
			<div class="error_msg_box"> There are currently no reviews on file.</div>
			<!--p class="no-list">There are currently no reviews on file.</p--> <?php }?>
		</div>
		<!--Tabs Content Closed-->
		
	</div>
	<!--Setting Tabs Widget Closed-->
		 
</div>

<!--mid Content Closed-->


<script>
function save_searchtags(id,pro_id){
	var searchtags = jQuery('#SearchtagSearchtag'+id).val();
	if(searchtags == ''){
		searchtags = 0;
	}
	var postUrl = SITE_URL+'products/save_searchtags/'+searchtags+'/'+pro_id+'/'+id;
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#search-tag'+id).html(msg);
	}
	});
}
function save_certtificate_searchtags(){
	var searchtags = jQuery('#SearchtagCertificatesearchtag').val();
	if(searchtags == ''){
		searchtags = 0;
	}
	var postUrl = SITE_URL+'products/add_certificate_searchtags/'+searchtags;
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#search-tag-certificate').html(msg);
	}
	});
}
</script>
