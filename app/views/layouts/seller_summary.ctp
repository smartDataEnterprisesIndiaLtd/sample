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
		echo $html->css('style');
		echo $javascript->link(array('headerslider/jquery-1.7.1.min','functions'));
		//echo $scripts_for_layout;
		$seller_ID = isset($this->params['pass'][0])?$this->params['pass'][0]:'';
		$product_ID = isset($this->params['pass'][1])?$this->params['pass'][1]:'';
		$name = isset($this->params['nam'])?$this->params['nam']:'';
		$controller = isset($this->params['controller'])?$this->params['controller']:'';
		if(!empty($product_ID)){?>
		<link  rel="canonical" href="<?php echo SITE_URL.$controller."/".$name."/summary/".$seller_ID; ?>">
			<?php }  ?>
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
				<?php echo $content_for_layout; ?>
				<div class="push"></div>
			</div>
			<!--Content Closed-->
			<div class="push" id="setPushHeight"></div>
			</div>
		</div>
		<?php echo $this->element('footer');?>
	</body>
</html>
<?php echo $this->element('sql_dump');?>