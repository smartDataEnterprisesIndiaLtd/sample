<?php ob_start();?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
		<title>Choiceful <?php $title_for_layout;?> :: Admin Panel</title>
		<meta http-equiv="cache-control" content="no-cache"> <!-- tells browser not to cache -->
		<meta http-equiv="expires" content="0"> <!-- says that the cache expires 'now' -->
		<meta http-equiv="pragma" content="no-cache"> <!-- says not to use cached stuff, if there is any -->
		<meta content="IE=7" http-equiv="X-UA-Compatible" />
		<meta content="English" name="language" />
		<meta content="1 week" name="revisit-after" />
		<meta content="global" name="distribution" />
		<meta content="index, follow" name="robots" />
		<?php print $html->charset('UTF-8') ?>
		<?php echo $html->css("admin"); ?>
		<link rel="shortcut icon" href="/img/favicon.ico">
		<?php echo $javascript->link("admin"); ?>
		<?php echo $javascript->link("jquery"); ?>
		<?php echo $javascript->link("settxt_focus"); ?>
		<?php echo $javascript->link("functions"); ?>
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
		<!-- echo $scripts_for_layout; -->

		
	</head>
	<body >
		<?php echo $content_for_layout; ?>
	</body>
</html>
<?php echo $this->element('sql_dump');?>
<script type="text/javascript">
f_setfocus();
</script>


