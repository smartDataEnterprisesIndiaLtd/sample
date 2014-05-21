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
			if(!empty($meta_description))
				echo $html->meta('description',$meta_description);
			//echo $html->meta('icon','favicon.ico', array('type' =>'icon'));
			echo $html->meta('icon');
			echo $html->css('style');
			//echo $javascript->link(array('lib/prototype','jquery-1.3.2.min','functions'));
			echo $javascript->link(array('jquery-1.3.2.min','functions'));
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
			<?php echo $this->element('top_navigation');?>
			<!--Content Started-->
			<div id="content">
				<!-- <?php //echo $this->element('left_navigation');?>
				<?php //echo $this->element('search');?>
				<?php //echo $this->element('right_navigation');?> --->
				<?php
				if ($session->check('Message.flash')){ ?>
					<div class="messageBlock">
						<?php echo $session->flash();?>
					</div>
				<?php } ?>
				<?php
				echo $content_for_layout;
				?>
			</div>
			<!--Content Closed-->
			<?php echo $this->element('footer');?>
		</div>
	</body>
</html>
<?php echo $this->element('sql_dump');?>