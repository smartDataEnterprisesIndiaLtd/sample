<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'), false); 
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
?>

<script language="JavaScript">
//open_fancy_box_id
jQuery(document).ready(function()  { // to open the offer
	jQuery("a.fancy_box_open").fancybox({
		'autoScale' : true,
		'width' : 362,
		'centerOnScroll': true,
		//'height' : 240,
		'padding':0,
		'overlayColor':'#000000',
		'hideOnOverlayClick':false,
		'overlayOpacity':0.5,
		'opacity':	true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'autoDimensions': false,
		'onClosed': function() {
			//parent.location.reload(true);;
		},
		'onComplete' : function() {
		jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
		  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
		});
		}
	});
});

jQuery(document).ready(function()  { // to change the status of the offer
	jQuery("a.fancy_box_open_status").fancybox({
		'autoScale' : true,
		'width' : 310,
		'centerOnScroll': true,
		//'height' : 270,
		'padding':0,
		'overlayColor':'#000000',
		'hideOnOverlayClick':false,
		'overlayOpacity':0.5,
		'opacity':	true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'autoDimensions': false,
		'onClosed': function() {
			//parent.location.reload(true);;
		},
		'onComplete' : function() {
		jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
		  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
		});
		}
	});
});
jQuery(document).ready(function()  { // to delete the offer
	jQuery("a.fancy_box_open_delete").fancybox({
		'autoScale' : true,
		'width' : 316,
		'centerOnScroll': true,
		//'height' : 200,
		'padding':0,
		'overlayColor':'#000000',
		'hideOnOverlayClick':false,
		'overlayOpacity':0.5,
		'opacity':	true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'autoDimensions': false,
		'onClosed': function() {
			//parent.location.reload(true);;
		},
		'onComplete' : function() {
		jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
		  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
		});
		}
	});
});

</script>


<!--mid Content Start-->
<div class="mid-content" style="min-height:635px;">
        	<!--- <div class="breadcrumb-widget">
		<?php echo $html->link('Home', '/', array('alt'=>'') );?> >
		<?php echo $html->link('My Account', '/users/my_account', array('alt'=>'') );?> >
		<span class="choiceful"><strong>Manage My Offers</strong></span>
		</div> --->
            <!--Setting Tabs Widget Start-->
		<div class="row breadcrumb-widget">
			<!--Tabs Widget Start-->
			      <div class="tabs-widget">
			      <ul>
			      <li><?php echo $html->link('Manage My Offers', '/offers/manage_offers', array('class'=>'active') );?></li>
			      <li><?php echo $html->link('View Accepted Offers', '/offers/accepted_offers', array('class'=>'') );?></li>
			     <li><?php echo $html->link('View Rejected Offers', '/offers/rejected_offers', array('class'=>'') );?></li>
			  </ul>
			</div>
			<!--Tabs Widget Closed-->
                
                <!--Tabs Content Start-->
          	<div class="tabs-content">
<?php
if ($session->check('Message.flash')){ ?>
	<div class="messageBlock"><?php echo $session->flash();?></div>
<?php } ?>

<?php

#pr($multiple_offers_made);

if( (count($offers_made) > 0) || (count($offers_recieved) > 0) || (count($multiple_offers_made) > 0) ) {  //  if any of offers found to show  ?>

	 <!--Offer Info widget Start-->
		<div class="offer-info-widget overflow-h">
	    
			<?php
	  
			if( (count($offers_made) > 0) || (count($multiple_offers_made) > 0) ) {  //  if any of offers found to show  ?>
				<h4 class="choiceful">Offers you have made</h4>  
				<?php  echo $this->element('offers/manage_offers_made');  ?>	
			    
			<?php  } //end array check ?>    
				
		</div>
	    <!--Offer Info Widget Closed-->
	 <div id="kpl">
			
		  </div>
                <!--Tabs Content Closed-->
		<?php
		
			$tCount = @$this->params['paging']['MadeOffer']['count'];
			$fullNextUrlP = '';
			if(!empty($offers_made) && $tCount>10){
				$fullNextUrlP = SITE_URL.'offers/manage_offers/madeOffer:1/page:';
				
		?>
	
		 <!--Load More Content Start-->
                <section class="loadmore" id="loadFocus">
			<a class="loadmorebtn" id="ajax_h_a"  href=" "><span>Load more</span></a>
			<!--- <a id="ajax_h_a"  href=" " class="loadmorebtn maxwidth640"><span>Load More...</span></a> -->
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
					jQuery('#ajax_h_a').removeClass('processingbtn');
				        jQuery('#ajax_h_a').addClass('loadmorebtn');
				    //alert(msg);
				  jQuery('#fade').hide();
				// Append the html 	
				jQuery('#kpl').append(msg).after(function() {
					
				});
				
					
					jQuery('#plsLoaderID').hide();
					if(makeCond<=0){
						jQuery('#loadFocus').hide();
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
	   
	   <?php /**************************  offers made  section ends here **********************/ ?>
	   
                   
		    
                    <!--Offer Info widget Start-->
                <div class="offer-info-widget overflow-h">
					
			<?php 	/************************** offers recieved ***********************************/
			if(is_array($offers_recieved) && count($offers_recieved) > 0  ) { ?>
				<h4 class="choiceful">Offers you have recieved</h4>
				<?php  echo $this->element('offers/manage_offers_recieved');  ?>
		       <?php  }    ?>                 
                        
                </div>
		 <div id="kplRec">
			
		  </div>
                <!--Updated div closed-->
		<?php
		
			$tCountRec = @$this->params['paging']['recievedOffer']['count'];
			$fullNextUrlREC = '';
			if(!empty($offers_recieved) && $tCountRec>10){
				$fullNextUrlREC = SITE_URL.'offers/manage_offers/recievedOffer:1/page:';
				
		?>
		 <!--Load More Content Start-->
                <section class="loadmore" id="loadFocusRec">
			 <a class="loadmorebtn" id="ajax_h_aRec"  href=" "><span>Load more</span></a>
			<!--- <a id="ajax_h_aRec"  href=" " class="loadmorebtn maxwidth640"><span>Load More...</span></a> --->
                </section>
		<?php } ?>
		<!-- /************************** offers recieved ***********************************/ --->  
                    <!--Offer Info Widget Closed-->
<?php  }else{  // show no offers found ?>                
                  <!--p class="no-list">There are currently no offers found ! </p-->
		  <div class="error_msg_box"> There are currently no offers found !</div>
<?php  } ?>      
                </div>
                <!--Tabs Content Closed-->
                
          </div>
           
        </div>

        <!--mid Content Closed-->
	<!--- <div class="footer_line"></div> --->
		
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
				 jQuery('#ajax_h_aRec').removeClass('processingbtn');
				        jQuery('#ajax_h_aRec').addClass('loadmorebtn');
				// Append the html 	
				jQuery('#kplRec').append(msg).after(function() {
					
				});
				
					 jQuery('#fade').hide();
					jQuery('#plsLoaderID').hide();
						
					if(makeCondRec<=0){
						
						jQuery('#loadFocusRec').hide();
						//return false;	
					}
			
			}
		});
		if(makeCondRec<=0){
			return false;	
		}	
		return false;
		
	});
});
</script>  

	

