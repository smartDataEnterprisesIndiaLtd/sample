<?php ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="cache-control" content="no-cache"> <!-- tells browser not to cache -->
		<meta http-equiv="expires" content="0"> <!-- says that the cache expires 'now' -->
		<meta http-equiv="pragma" content="no-cache"> <!-- says not to use cached stuff, if there is any -->
		
		<title><?php echo ucwords($title_for_layout); ?></title> <!-- .$catTitle --->
		<?php //echo $javascript->link(array('prototype')); ?>
		<?php
		//meta keywords you can set these from controller files e.g for home page of site open users_controller.php file and see index() method
		if(!empty($meta_keywords))
			echo $html->meta('keywords',$meta_keywords);
		//meta descriptions
		if(!empty($meta_description))
			echo $html->meta('description',$meta_description);
				
		echo $html->meta('icon');
		echo $html->css('style'); 
		echo $javascript->link(array('jquery-1.3.2.min','functions'));
		echo $scripts_for_layout; ?>
		<style type="text/css">
			div.disabled {
				display: inline;
				float: none;
				clear: none;
				color: #C0C0C0;
			}
		</style>
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
		<?php
			echo $this->element('product/paging_products_category_header_link');
		?>
		<?php  $actual_link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
		<link rel="canonical" href="<?php echo $actual_link ?>"/>
	</head>
	<body>
		<div id="main-container">
			<?php echo $this->element('header');?>
			<?php echo $this->element('top_navigation');?>
			<!--Content Started-->
			<div id="content">
			<?php
				echo $this->element('left_navigation');
				echo $this->element('search');
				echo $content_for_layout;
			?>
			</div> 
			
			<!--Content Closed-->
			
			<?php echo $this->element('footer');?>
		</div>
	</body>
</html>
<?php echo $this->element('sql_dump');?>