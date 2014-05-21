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
			
			//echo $javascript->link(array('lib/prototype','jquery-1.3.2.min','functions'));
			echo $javascript->link(array('headerslider/jquery-1.7.1.min','functions'));
			?>
			<?php
			echo $html->css('style');
			//echo $javascript->link(array('change_resolution'));
			
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
	<body>
		
		<div id="main-container">
			<?php echo $this->element('header');?>
			<!--Content Started-->
			<div>
				<?php
				echo $content_for_layout;
				?>
			</div>
	
			<!--Content Closed-->
			<?php //echo $this->element('footer');?>
			</div>
		</div>
		
		</body>
</html>
<?php //echo $this->element('sql_dump');?>