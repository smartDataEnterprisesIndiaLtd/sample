<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
		<meta http-equiv="cache-control" content="max-age=0" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
		<meta http-equiv="pragma" content="no-cache" />

		<title><?php echo $title_for_layout; ?></title>
		<?php
			if(!empty($meta_keywords))
				echo $html->meta('keywords',$meta_keywords);
			if(!empty($meta_descriptions))
				echo $html->meta('description',$meta_descriptions);
			echo $html->meta('icon');
			echo $html->css('style'); ?>
			
			<?php echo $javascript->link(array('headerslider/jquery-1.7.1.min','functions'));
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
			<!---<?php //echo $this->element('top_navigation');?> --->
			<!--Content Started-->
			<div id="content">
				<?php echo $this->element('left_navigation_marketplace');?>
				<!-- <?php //echo $this->element('search');?> --->
				<?php echo $this->element('right_navigation_marketplace');?>
				<?php
				echo $content_for_layout;
				?>
				
			</div>
			
			<div class="push" id="setPushHeight"></div>
			<!--Content Closed-->
</div>
		</div>
					<?php
			
			// Set up new footer on join marketplace
			
			$cur_action = $this->params['action'];
			
			if(in_array($cur_action,array('sign_up','sign_up_step2','sign_up_step3'))){
				echo $this->element('footer');
			}else{
				echo $this->element('footer_marketplace');
			}
			
			?> <!-- --->
	</body>
</html>
<?php echo $this->element('sql_dump');?>