<?php ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="google-site-verification" content="zulAOZgemPGXtBjBbj8twxq-i4jTqO3v3XNwK_NdXG8" />
		<title><?php echo ucwords($title_for_layout); ?></title>
		<?php
			echo $html->meta('keywords', $keywords_for_layout);
			echo $html->meta('description', $description_for_layout);
			echo $html->meta('icon');
			echo $html->css('style');
			echo $javascript->link("jquery"); 
			echo $scripts_for_layout;
			
			
			
		?>
		<script language="javascript">
		// function to show a hidden div
		function showDiv(divId){
			//var FinalDiv =  "#"+divId;
			jQuery("#"+divId).show();
			
		}
		// function to hide a div
		function hideDiv(divId){
			jQuery("#"+divId).hide();
			
		}
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
		<div id="main-container">
			<?php echo $this->element('header');?>
			<?php echo $this->element('top_navigation');?>
			<!--Content Started-->
			<div id="content">
				<?php echo $this->element('left_navigation_affiliate');?>
				<?php echo $this->element('search');?>
				
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