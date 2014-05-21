<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
		<title><?php echo $title_for_layout; ?></title>
		<?php
			if(!empty($meta_keywords))
				echo $html->meta('keywords',$meta_keywords);
			if(!empty($meta_descriptions))
				echo $html->meta('description',$meta_descriptions);
			echo $html->meta('icon');
			echo $html->css('style'); ?>
			<?php echo $javascript->link(array('headerslider/jquery-1.7.1.min','functions'));
			
			// echo $javascript->link("jquery");
			//echo $scripts_for_layout; ?>
			<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-629547-1']);
			_gaq.push(['_trackPageview']);
		      
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>

	</head>
	<body onload="getFooterHeight();">
		<div id="main-container">
			<?php echo $this->element('header');?>
			<!--- <?php //echo $this->element('top_navigation');?> --->
			<!--Content Started-->
			<div id="content">
				<!--Left Content Start-->
				<div class="left-content">
					<!--Choose a Topic Start-->
					<div class="side-content">
						<h4 class="gray-bg-head"><span>Choose a Topic</span></h4>
						<div class="gray-fade-bg-box padding">
							<?php
							$page_is = $this->params['pass'][0];
							?>
							<ul class="help-links1">
								<li><?php
								if($page_is == 'how-it-works')
									$class_page = 'active';
								else
									$class_page = '';
								echo $html->link('How it works?',"/marketplaces/view/choiceful-marketplace-how-it-works",array('escape'=>false,'class'=>$class_page));?></li>
								<li><?php
								if($page_is == 'marketplace-pricing')
									$class_page = 'active';
								else
									$class_page = '';
								echo $html->link('Pricing',"/marketplaces/view/choiceful-marketplace-marketplace-pricing",array('escape'=>false,'class'=>$class_page));?></li>
								<li><?php
								if($page_is == 'international-sellers')
									$class_page = 'active';
								else
									$class_page = '';
								echo $html->link('International Sellers',"/marketplaces/view/choiceful-marketplace-international-sellers",array('escape'=>false,'class'=>$class_page));?></li>
								<li><?php
								if($page_is == 'marketplace-user-agreement' || $page_is == 'sellers-guide')
									$class_page = 'active';
								else
									$class_page = '';
								echo $html->link('Seller User Agreement',"/marketplaces/view/choiceful-marketplace-user-agreement",array('escape'=>false,'class'=>$class_page));?></li>
								<li><?php
								if($page_is == 'faqs')
									$class_page = 'active';
								else
									$class_page = '';
								echo $html->link('FAQ\'s',"/marketplaces/view/choiceful-marketplace-faqs",array('escape'=>false,'class'=>$class_page));?></li>
							</ul>
						</div>
					</div>
					<!--Choose a Topic Closed-->
				</div>
				<!--Left Content Closed-->
				<!---  <?php //echo $this->element('search');?> --->
				<!--Right Widget Start-->
				<div class="right-widget">
					<!--Self Services Start-->
					<div class="side-content">
						<div class="gray-fade-bg-box padding no-bg">
							<ul class="quick-tips">
								<li class="lft-img"><?php echo $html->image("selling-tips-img.png" ,array('width'=>"40",'height'=>"45", 'alt'=>"" )); ?></li>
								<li class="rht-con">
								<h5><?php echo $html->link('Selling quick tips',"/marketplaces/view/choiceful-marketplace-sellers-guide",array('escape'=>false,'style'=>'color:#333333'));?></h5>
								<p class="gray">Watch and learn in 2 minutes or less.</p>
								</li>
							</ul>
						</div>
					</div>
					<!--Self Services Closed-->
					<!--Self Services Start-->
					<div class="side-content">
						<h4 class="gray-bg-head sml-fnt"><span class="markt-heading sml-fnt">Join &amp; List Products Free!</span></h4>
						<div class="gray-fade-bg-box padding no-bg">
							<p><?php 
								$session_user = $this->Session->read('User.seller_id');
								if(!empty($session_user)){
									$link_is = '/marketplaces/search_product';
								} else{
									$link_is = '/sellers/choiceful-marketplace-sign-up';
								}
								echo $html->link('Start Selling',$link_is,array('escape'=>false,'class'=>"start-selling"));?></p>
						</div>
					</div>
					<!--Self Services Closed-->
				</div>
				<!--Right Widget Closed-->
				<?php
				echo $content_for_layout;
				?>
				
			</div>
			<!--Content Closed-->
			<div class="push" id="setPushHeight"></div>
			 <!-- _marketplace -->
			 </div>
		</div>
		<?php echo $this->element('footer');?>
	</body>
</html>
<?php echo $this->element('sql_dump');?>