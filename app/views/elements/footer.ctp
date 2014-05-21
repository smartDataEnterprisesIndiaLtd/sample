<style>
 #slider1 {
  width: 160px;
height:70px;
  list-style: none;
 }
.anythingSlider-metallic.activeSlider .anythingWindow {
    border: medium none;
    margin-right:40px;
}
.anythingSlider .panel img{
height: 50px !important;
}
</style>
  <?php
			if(!empty($logg_user_id)){
				$ad_feedback = '/homes/ad_feedback';
				$fancy_feedback_width = 355;
			}
			else{
				$ad_feedback = '/users/sign_in/';
				$fancy_feedback_width = 560;
			}
	
  $current_contrtoller = isset($this->params['controller'])?$this->params['controller']:'';
  $current_action = isset($this->params['action'])?$this->params['action']:'';
  
  if($current_contrtoller == 'categories' && $current_action =='productdetail'){
  }else{
  	//echo $javascript->link(array('lib/prototype'),false);
	e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
	e($html->script('fancybox/jquery.easing-1.3.pack'));
	e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
	echo $html->css('jquery.fancybox-1.3.4');
	
  }

		echo $javascript->link('slider/prettify');
		echo $javascript->link('slider/jquery.anythingslider');
		echo $html->css('slider1/theme-metallic');
?>
<!-- breadcrumb ends add on 21st Feb 2013-->
 <!--Footer Start-->
    <footer id="getFooter">
    	<section class="footerframe">
            <!--Footer Top Start-->
            <section class="footertop">
                <section class="footertop_left">
			
			
			
			
                    <section class="footerslider">
			<?php //pr($footerSlider); ?>
                    	<ul class="slidelogos" style="width:1000px;" id="slider1">
				<!--<li><?php echo $html->image("/img/new/images/truste.png" ,array('alt'=>"" )); ?></li> -->
				<?php 	if(isset($footerSlider) && !empty($footerSlider)){
					
						foreach($footerSlider as $record=>$sliderData){
							$alt_text = $sliderData['FooterBanner']['alt_text'];
							$name = $sliderData['FooterBanner']['file'];
							$script = $sliderData['FooterBanner']['script'];
							$flag = $sliderData['FooterBanner']['flag'];
						
				?>
						<?php if($flag ==0){ ?>
							<li> <?php echo $html->image("/img/banner/medium/img_135_$name" ,array('title'=>$alt_text,'alt'=>$alt_text,'style'=>'height:auto !important;width:auto !important;')); ?></li>
						<?php } else{
								echo "<li>".html_entity_decode($script)."</li>";
							} //esle closed 
					  	} // foreach closed
					} // if closed
				?>
				
                        <!--	<li><?php echo $html->image("/img/new/images/truste.png" ,array('alt'=>"" )); ?></li>
                            <li><?php echo $html->image("/img/new/images/PCI-Compliant-1.png" ,array('alt'=>"" )); ?></li>
                            <li><?php echo $html->image("/img/new/images/PCI-Compliant-2.png" ,array('alt'=>"" )); ?></li>
                            <li><?php echo $html->image("/img/new/images/Thawte.png",array('alt'=>"" )); ?></li>
                            <li><?php echo $html->image("/img/new/images/Secure-Transactions.png" ,array('alt'=>"" )); ?></li> --->
                        </ul>
                   <!--     <section class="footerpaging"><a href="#">1</a><a href="#">2</a><a href="#" class="active">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a></section>-->
                    </section> 
		    
		    
		    
		    
                    <section class="cardsopt"><?php echo $html->image("/img/new/images/cards.png" ,array('width'=>"204", 'height'=>"87" ,'alt'=>"Payments accepted by Choiceful.com" ,'title'=>"Payments accepted by Choiceful.com")); ?></section>
                    <section class="securepay">
                    	<h4>100% Secure Payments</h4>
                        <p>All major credit &amp; debit cards accepted</p>
                    </section>
                </section>
                
                <!--Footer Top Right Start-->
                <section class="footerright">
                	<p class="hdttl">Everything you need to know about Choiceful is right here...</p>
                    <section class="footerlinks_widget">
                    	<!--Shopping at Choiceful Start-->
                    	<section class="footerlinks">
                        	<h5>Shopping at Choiceful</h5>
                            <ul>
				<li><?php echo $html->link('Ordering With Us',array('controller'=>'pages','action'=>'view','how-to-order'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Order Tracking',array('controller'=>'orders','action'=>'view_open_orders'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Delivery',array('controller'=>'pages','action'=>'view','estimated-delivery-dates'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Returns &amp; Refunds',array('controller'=>'pages','action'=>'view','returns-policy'),array('escape'=>false));?></li>
				<li><?php echo $html->link('A to Z Product Index',array('controller'=>'departments','action'=>'a_z_index'),array('escape'=>false));?></li>
                               <!-- <li><?php echo $html->link('Bestsellers',array('controller'=>'products','action'=>'bestseller'),array('escape'=>false));?></li> --->
                                <li><?php echo $html->link('Gift Certificates',array('controller'=>'certificates','action'=>'purchase_gift'),array('escape'=>false));?></li>
                            </ul>
			    
                        </section>
                        <!--Shopping at Choiceful Closed-->                        
                        <!--Earn Money Start-->
                    	<section class="footerlinks earnmoney">
                        	<h5>Earn Money</h5>
                        <ul>
                                <li><?php echo $html->link('What is Choiceful Marketplace?',array('controller'=>'pages','action'=>'view','what-is-choiceful'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Sell on Choiceful',array('controller'=>'marketplaces','action'=>'view','how-it-works'),array('escape'=>false));?></li>
                               	<li><?php echo $html->link('Marketplace Fees',array('controller'=>'pages','action'=>'view','marketplace-pricing'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Marketplace User Agreement',array('controller'=>'pages','action'=>'view','marketplace-user-agreement'),array('escape'=>false));?></li>
				<li><?php echo $html->link('International Selling',array('controller'=>'marketplaces','action'=>'view','choiceful-marketplace-international-sellers'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Advertising with Choiceful',array('controller'=>'advertisements','action'=>'index'),array('escape'=>false));?></li>
                                <li><?php echo $html->link('Affiliates Program',array('controller'=>'pages','action'=>'view','become-an-affiliate'),array('escape'=>false));?><?php //echo $html->link('Affiliate Program','/affiliates/view/make-money-advertising-choiceful-using-our-affiliate-programme/1',array('escape'=>false));?></li>
			 </ul>
                        </section>
                        <!--Earn Money Closed-->                        
                        <!--Trust &amp; Security Start-->
                        <section class="footerlinks">
                        <h5>Trust &amp; Security</h5>
                            <ul>
				<li><?php echo $html->link('Buy-With-Confidence',array('controller'=>'pages','action'=>'view','buy-confidence-guarantee'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Conditions of Use',array('controller'=>'pages','action'=>'view','conditions-of-use'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Privacy Policy',array('controller'=>'pages','action'=>'view','privacy-policy'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Terms and Conditions',array('controller'=>'pages','action'=>'view','terms-and-conditions'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Returns Guidelines',array('controller'=>'pages','action'=>'view','refund-policy'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Cookies Policy',array('controller'=>'pages','action'=>'view','cookies-policy'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Secure Online Shopping',array('controller'=>'pages','action'=>'view','our-safe-shopping-promise'),array('escape'=>false));?></li>
                            </ul>
                        </section>
                        <!--Trust &amp; Security Closed-->                        
                        <!--Company Start-->
                        <section class="footerlinks companycol">
                            <h5>Company</h5>
                            <ul>
				<li><?php echo $html->link('About Choiceful',array('controller'=>'pages','action'=>'view','about-website'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Our Global Stores',array('controller'=>'pages','action'=>'view','our-global-stores'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Selling Your Products',array('controller'=>'pages','action'=>'view','what-is-choiceful'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Secure Shopping',array('controller'=>'pages','action'=>'view','our-safe-shopping-promise'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Choiceful Blog',array('controller'=>'blog','action'=>'index'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Choiceful Charity',array('controller'=>'pages','action'=>'view','choiceful-charity'),array('escape'=>false));?></li>
                            </ul>
                        </section>
                        <!--Company Closed-->                        
                        <!--Customer Help Start-->
                        <section class="footerlinks custhelp">
                        <h5>Customer Help</h5>
                            <ul>
                                <li><span class="livhelp"><script  type="text/javascript"  src="<?php echo SITE_URL;?>/app/webroot/phplive/js/phplive.js.php?d=0&base_url=%2F%2Fchoiceful.com%2Fapp%2Fwebroot%2Fphplive&text=Live help"></script></span></li>
				<li><?php echo $html->link('Contact Us',array('controller'=>'pages','action'=>'view','contact-us'),array('escape'=>false));?></li>
                                <li><?php echo $html->link('Help Topics',array('controller'=>'pages','action'=>'view','help'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Frequently Asked Questions',"/faqs/view/1",array('escape'=>false));?></li>
				<!-- <script  type="text/javascript"  src="<?php echo SITE_URL;?>/app/webroot/phplive/js/phplive.js.php?d=0&base_url=%2F%2Fchoiceful.com%2Fapp%2Fwebroot%2Fphplive"></script> --->
                                
                            </ul>
                        </section>
                        <!--Customer Help Closed-->
                    </section>
                    
                     <section class="joinus">
                        <h5>Join us on</h5>
                        <ul class="joinuson">
                            <li class="facebook"><a target="_blank" title="Facebook" href="https://facebook.com/choiceful"><span></span>Facebook</a></li>
                            <li class="googleplus"><a target="_blank" title="Google Plus" href="https://plus.google.com/105885727970905038288"><span></span>Google+</a></li>
                            <li class="twitter"><a target="_blank" title="Twitter" href="https://twitter.com/Choicefulcom"><span></span>Twitter</a></li>
			    
			    <li class="email"><?php echo $html->link('Email a friend about this page','/homes/email_friend',array('id'=>'email_friend_page','escape'=>false,'class'=>''));?> |  <?php echo $html->link('Website Feedback',$ad_feedback,array('escape'=>false,'class'=>'feedback-popup'));?><a href="#"></a></li>
                        </ul>
                    </section>
                </section>
                <!--Footer Top Right Closed-->
       
            </section>
            <!--Footer Top Closed-->
            
            <!--Footer Content Text Start-->
            <section class="footer_text">
		<?php if(!empty($footerDesc)){
				echo $footerDesc;
			}else{
		?>
		<p>Choiceful.com is one of the largest e-commerce marketplaces providing a platform for small, medium and large businesses across 52 countries to connect with millions of customers worldwide. Our easy-to-use and secure platforms make it simple for sellers to advertise and distribute their products to the widest audience of online buyers. Our product range consists of a wide choice of national and international brands across diverse categories including Electronics, Mobile, Home & Garden, Health & Beauty, Office & Computing, Movies and Books, with tens of millions of products available we truly offer buyers and sellers an immense choice in every category. Shoppers enjoy some of the lowest prices available for brands they love buying thanks to the industry-beating marketplace fees we charge our sellers. Find unbeatable offers on the world's top-selling brands like Sony, Apple, Samsung, Canon, Hugo Boss, Armani, Prada and more. Our hassle-free shopping experience includes multi-payment options and many of our products are available with free standard delivery and a no-hassle return service for peace of mind.</p>

<p>Selling and managing your business on Choiceful.com is simple, whether you are at home, work or on the go via mobile. We offer the lowest marketplace fees which means our sellers are able to beat prices compared to other websites. Cost-for-cost comparisons against own website businesses have shown that our low marketplace fees make selling on Choiceful.com more profitable for sellers as payment processing charges (such as credit card processing fees) can be around 2-4%, website development, maintenance, server hosting and marketing costs for websites can be significant for small to medium sized companies. Selling on Choiceful.com means you pay only when you sell a product, there are never any listings fees and you can list millions of products for free. We hope we can cater to your needs and that you have a great experience using Choiceful.com.</p>
			<!-- <p>Choiceful.com is one of the larget ecommerce marketplaces providing a platform for small, medium and large businesses across 52 countries to connect with millions of customers worldwide. Our easy-to-use and secure platforms make it simple for sellers to advertise and distribute their products to the widest audience of online buyers. Our product range consists of a wide choice of national and international brands across diverse categories including Electronics, Mobile, Home & Garden, Health & Beauty, Office & Computing, Movies, Games and Books, with tens of millions of products available we truly offer buyers and sellers an immense choice in every category. Shoppers enjoy some of the lowest prices available for brands they love buying thanks to the industry-beating marketplace fees we charge our sellers. Find unbeatable offers on the world?s top-selling brands like Sony, Apple, Samsung, Canon, Hugo Boss, Armani, Prada and more. Our hassle-free shopping experience includes multi-payment options and many of our products are available with free standard delivery and a no-hassle return service for peace of mind.</p>
			<p>Selling and managing your business on Choiceful.com is simple, whether you are at home, work or on the go via mobile. We offer the lowest marketplace fees which means our sellers are able to beat prices compared to other websites. Cost-for-cost comparisons against own website businesses have shown that our low marketplace fees make selling on Choiceful.com more profitable for sellers as payment processing charges (such as credit card processing fees) can be around 2-4%, website development, maintenance, server hosting and marketing costs for websites can be significant for small to medium sized companies. Selling on Choiceful.com means you pay only when you sell a product, there are never any listings fees and you can list millions of products for free. Whatever you choose, we hope you have a great experience using Choiceful.com.</p> --->
            
		<?php } ?>
	    </section>
            <!--Footer Content Text Closed-->
            
            <section class="bottom">
            	<section class="sitelinks"><?php echo $html->link('Mobile Site',array('controller'=>'homes','action'=>'choiceful-mobile'),array('escape'=>false));?> | <?php echo $html->link('Site Map',array('controller'=>'sitemaps','action'=>'sitemap'),array('escape'=>false));?></section>
                <a href="javascript:void('0')" class="backtop" id="gototop">Back to top</a>
            	<section class="copyright">
                	<p class="extrapad">Choice.ful (choice'full) adj. To make "bold, wise and the right" choices</p>
                    <p><?php echo $html->link($html->image("/img/new/images/footerlogo.png" ,array('width'=>"122" ,'height'=>"20", 'alt'=>"" ),array('escape'=>false)),"/",array('escape'=>false));?></p>
                    <p class="copyrighttext">Copyright &copy; Choiceful.com 2013. All Rights Reserved.</p>
                </section>
            </section>
        </section>
    </footer>
    <!--Footer Closed-->
<?php if($this->params['action'] != 'return_items' && $this->params['controller'] != 'orders') { ?>
<?php echo $javascript->link("settxt_focus"); ?>
<script type="text/javascript">


 
f_setfocus();

// function to call afunction when screen get resized
 jQuery(window).resize(function() {
 	var divWidth = jQuery('#resolutionDivId').width();
 	//jQuery('ul.products').children().css('width', divWidth/5+'px');
 });
	//jQuery('.message').fadeOut(20000);
	//jQuery('.error-message').fadeOut(20000);
	//jQuery('.flashError').fadeOut(20000);
</script>
<?php }?>
       
	<script>
	function getFooterHeight(){
    var h = document.getElementById("getFooter").clientHeight;
    document.getElementById("setPushHeight").style.height =h+"px";
    document.getElementById("main-container").style.marginBottom="-"+h+"px";

}
		// Set up Sliders
		// **************
		jQuery(function(){
jQuery("#email_friend_page").fancybox({
			'autoScale' : true,
			'titlePosition': 'inside',
			'centerOnScroll': true,
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : 410,
			'height' : 285,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'autoDimensions': false,
			'onClosed': function() {
			},
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
		jQuery("a.feedback-popup").fancybox({
			'autoScale' : true,
			'centerOnScroll': true,
			
			'width' : <?php echo $fancy_feedback_width; ?>,
			'centerOnScroll': true,
			//'height' : 203,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'title':false,
			'autoDimensions': false,
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
			jQuery('#slider1').anythingSlider({
				theme           : 'metallic',
				buildStartStop      : false,
				autoPlayLocked      : true,
				autoPlayDelayed     : false,
				resumeDelay         : 	1000,
				/*autoPlayDelayed     : false,*/
				infiniteSlides      : true,
				hashTags            : false, 
				resizeContents      : true,
				
				buildArrows         : false,
				easing              : 'swing',
				navigationFormatter : function(index, panel){
					return [<?php 	if(isset($footerSlider) && !empty($footerSlider)){
					
						foreach($footerSlider as $record=>$sliderData){
							$alt_text = $sliderData['FooterBanner']['alt_text'];
							echo "'$alt_text'";
							if($record < (count($footerSlider)-1)){
								echo ",";
							}
						}
						}?>][index - 1];
				}
			});
			

			// tooltips for first demo
			//$.jatt();
			
			jQuery('#gototop').click(function(){
		     jQuery('html, body').animate({scrollTop:0}, 'slow');
		     return false;
		     });

		});
	</script>