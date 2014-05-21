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
		if(!empty($meta_description))
			echo $html->meta('description',$meta_description);
		echo $html->meta('icon');
		echo $html->css('checkout');
		
		?>
		<script type="text/javascript">
			var SITE_URL = "<?php echo SITE_URL; ?>";
		</script>
		<?php
		//echo $javascript->link(array('jquery','functions'));
		echo $scripts_for_layout; ?>
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
		<div id="checkout-main-container">
			<?php if(!empty($from_giftcertificate)) {
				echo $this->element('checkout/gift_header');
			} else { 
				echo $this->element('checkout/header');
			}?>
			<?php echo $content_for_layout;  // include contents ?>
			<?php echo $this->element('checkout_footer'); ?>
		</div>
		<!--Main Container Closed-->
	</body>
</html>

	

  

<?php echo $this->element('sql_dump');?>