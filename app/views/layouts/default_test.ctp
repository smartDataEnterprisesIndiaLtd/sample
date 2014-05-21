<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
		<title>Error</title>
		<?php echo $html->css('style');?>
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