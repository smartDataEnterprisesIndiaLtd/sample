<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
		<title><?php echo ucwords($title_for_layout); ?></title>
		<?php
		//meta keywords you can set these from controller files e.g for home page of site open users_controller.php file and see index() method
		if(!empty($meta_keywords))
			echo $html->meta('keywords',$meta_keywords);
		//meta descriptions
		if(!empty($meta_descriptions))
			echo $html->meta('description',$meta_descriptions);
		echo $html->meta('icon');
		echo $html->css('front_popup');
		echo $html->css('style_progress');
		?>
		<script type="text/javascript">
			var SITE_URL = "<?php echo SITE_URL; ?>";
		</script>
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
		<div class="popup-widget popup-width1">
			<!--<div align="center" class="messageBlock">
				<?php echo $session->flash();?>
			</div>-->
			<?php echo $content_for_layout; ?>
		</div>
		<!--Popup Widget Closed-->
		
		<script language="JavaScript">
			function golink(link_url){
				var link_url_length = link_url.length;
				link_url = link_url.substr(1,(link_url_length-1));
				parent.location.href = SITE_URL+link_url;
			}
		</script>
	</body>
</html>

<?php echo $this->element('sql_dump');?>