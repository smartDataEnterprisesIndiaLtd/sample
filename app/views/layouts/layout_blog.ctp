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
		echo $html->css('blogs');
		echo $javascript->link(array('jquery','functions','custom'));
		
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
		<!--Main Container Start-->
<section id="main-container">

	 <?php echo $this->element('blogs/header_new');
	 //echo $this->element('header');
	 ?>
	 
<?php
if ($session->check('Message.flash')){ ?>
<section class="error_msg blog_not_found">
        <section class="errorpic"><?php echo $this->Html->image('/img/images/blogs/error_icon.png', array('width' =>34,'height'=>34));?></section>
        <section class="error_message"><?php echo $session->flash();?></section>
</section>
<?php } ?>
    
    <!--Content Start-->
    <section id="content">
    	
        <?php echo $this->element('blogs/left_panel');?>
	<?php  echo $content_for_layout; ?> 
	
        
    </section>
    <!--Content Closed-->
    
    <?php echo $this->element('blogs/footer');?>
    
    
</section>
<!--Main Container Closed-->
	</body>
</html>
<?php echo $this->element('sql_dump');?>