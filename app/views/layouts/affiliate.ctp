<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
		<meta name="google-site-verification" content="zulAOZgemPGXtBjBbj8twxq-i4jTqO3v3XNwK_NdXG8" />
		<title><?php echo $title_for_layout; ?></title>
		<?php
			echo $html->meta('keywords', $keywords_for_layout);
			echo $html->meta('description', $description_for_layout);
			echo $html->meta('icon');
			echo $html->css('style');
			echo $javascript->link('headerslider/jquery-1.7.1.min'); 
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
	<body onload="getFooterHeight();">
		<div id="main-container">
			<?php echo $this->element('header');?>
			<?php //echo $this->element('top_navigation');?>
			<!--Content Started-->
			<div id="content">
				<?php echo $this->element('left_navigation_affiliate');?>
				<?php //echo $this->element('search');?>
				
				<?php
				echo $content_for_layout;
				?>
			</div>
			<div class="push" id="setPushHeight"></div>
			<!--Content Closed-->
		</div>	
		</div>
		<?php echo $this->element('footer');?>
	</body>
</html>
<?php echo $this->element('sql_dump');?>