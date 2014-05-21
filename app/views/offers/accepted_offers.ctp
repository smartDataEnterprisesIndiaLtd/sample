<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'), false); ?>

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
			      <li><?php echo $html->link('Manage My Offers', '/offers/manage_offers', array('class'=>'') );?></li>
			      <li><?php echo $html->link('View Accepted Offers', '/offers/accepted_offers', array('class'=>'active') );?></li>
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

if( (count($offers_made) > 0) || (count($offers_recieved) > 0) ) {  //  if any of offers found to show  ?>

                <!--Offer Info widget Start-->
                    <div class="offer-info-widget overflow-h">
			
		<?php  if(is_array($offers_made) && count($offers_made) > 0  ) { ?>
                      <h4 class="choiceful">Offers you have made</h4>                      
                <?php  echo $this->element('offers/accepted_offers');  ?>
                        <?php }?>      
                    </div>
                    <!--Offer Info Widget Closed-->
                <div id="kpl">
			
		</div>
                <!--Tabs Content Closed-->
		<?php
		
			$tCount = @$this->params['paging']['MadeOffer']['count'];
			$fullNextUrlP ='';
			if(!empty($offers_made) && $tCount>10){
				$fullNextUrlP = SITE_URL.'offers/accepted_offers/madeOffer:1/page:';
				
		?>
		 <!--Load More Content Start-->
                <section class="loadmore" id="loadFocus" style="padding-bottom: 20px;">
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
	//jQuery('#h_a').attr('href','#content');
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
						jQuery('#fade').hide();
						jQuery('#ajax_h_a').removeClass('processingbtn');
						jQuery('#ajax_h_a').addClass('loadmorebtn');
						jQuery('#kpl').append(msg).after(function() {
							jQuery('#plsLoaderID').hide();
						});
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
		    
		    
		    
		    
		                  
                         
		    
                    <!--Offer Info widget Start-->
                    <div class="offer-info-widget overflow-h">
			
		<?php 	/************************** offers recieved ***********************************/
		//pr($offers_recieved);
		
		if(is_array($offers_recieved) && count($offers_recieved) > 0  ) { ?>
                   <h4 class="choiceful">Offers you have recieved</h4>                      
                   <?php  echo $this->element('offers/recieved_offer');  ?>
		   
               <?php //end foreach
		    }   #************************** offers recieved ***********************************/     ?>                 
                        
                  </div>
		      <div id="kplRec">
			
		  </div>
                <!--Updated div closed-->
		<?php
		
			$tCountRec = @$this->params['paging']['recievedOffer']['count'];
			$fullNextUrlREC = '';
			if(!empty($offers_recieved) && $tCountRec>10){
				$fullNextUrlREC = SITE_URL.'offers/accepted_offers/recievedOffer:1/page:';
				
		?>
		 <!--Load More Content Start-->
                <section class="loadmore" id="loadFocusRec">
			<a id="ajax_h_aRec"  href=" " class="loadmorebtn"><span>Load more</span></a>
                </section>
		<?php } ?>
                    <!--Offer Info Widget Closed-->
<?php  }else{  // show no offers found ?>                
                  <!--p class="no-list">There are currently no offers found ! </p-->
		  <div class="error_msg_box"> There are currently no offers found !</div>
<?php  } ?>      
                </div>
                <!--Tabs Content Closed-->
                
          </div>
            <!--Setting Tabs Widget Closed-->
		
        </div>
        <!--mid Content Closed-->
		
	
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
	
	// set the flag for disable the ajax request
	//var flag =1;

	jQuery('#ajax_h_aRec').click(function(){
		jQuery('#ajax_h_aRec').removeClass('loadmorebtn');
		jQuery('#ajax_h_aRec').addClass('processingbtn');
		jQuery('#fade').show();
		jQuery('#plsLoaderID').show();
		var pageIdRec= jQuery("#tempValRec").val();
		var totalRec = "<?php echo $tCountRec; ?>";
		var checkTotalRec = parseInt(pageIdRec)*parseInt(10);
		var makeCondRec = parseInt(totalRec)-parseInt(checkTotalRec);
		//alert(makeCondRec+"vhbvn"+checkTotalRec);
		
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
				  jQuery('#fade').hide();
				// Append the html
				jQuery('#ajax_h_aRec').removeClass('processingbtn');
				jQuery('#ajax_h_aRec').addClass('loadmorebtn');
				jQuery('#kplRec').append(msg).after(function() {
				});
				if(makeCondRec <= 0){
						jQuery("#loadFocusRec").hide();
					}
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

	


	

