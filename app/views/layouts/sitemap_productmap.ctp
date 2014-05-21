<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
		<title><?php echo $title_for_layout; ?></title>
			<?php 
			//meta keywords you can set these from controller files e.g for home page of site open users_controller.php file and see index() method
			if(!empty($meta_keywords))
				echo $html->meta('keywords',$meta_keywords);
			//meta descriptions
			if(!empty($meta_description))
				echo $html->meta('description',$meta_description);
			//echo $html->meta('icon','favicon.ico', array('type' =>'icon'));
			echo $html->meta('icon');
			echo $html->css('sitemap');
			echo $javascript->link(array('headerslider/jquery-1.7.1.min','functions','custom'));
			?>
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
			
		    <div class="centered_content">
			<!--Header Start-->
			<div id="header" class="page-holder">
			
			    <!--Logo Start-->
			    <div class="logo">  <?php echo $html->link('choiceful.com',"/",array('escape'=>false)); ?></div>
			    <!--Logo Closed-->
			    
			</div>
			<!--Header Closed-->
			
			<!--Content Start-->
			<div id="content">
			    
			 <?php echo $content_for_layout; ?>   
				    
			</div>
			<!--Content Closed-->
		    
				<div class="push" id="setPushHeight"></div>
				</div>
		    </div>
		</div>
			<?php echo $this->element('footer');?>
	</body>
</html>
<?php echo $this->element('sql_dump');?>