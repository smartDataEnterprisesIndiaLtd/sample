<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN" http://www.w3.org/TR/REC-html40/frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
		<title>Error</title>
		<?php echo $html->css('style');?>
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
		<!--Header Start-->
			<?php echo $this->element('error_header');?>
				<?php echo $this->element('top_navigation');?>
				<!--Content Started-->
				<div id="content">
					<?php echo $this->element('search_fullpage');?>
					<?php echo $this->element('right_navigation');?>
					<?php
					echo $content_for_layout;
					?>
				
				</div>
				<!--Content Closed-->
			<?php echo $this->element('error_footer');?>
		</div>
	<!--Main Container Closed-->
	</body>
</html>
<?php echo $this->element('sql_dump');?>