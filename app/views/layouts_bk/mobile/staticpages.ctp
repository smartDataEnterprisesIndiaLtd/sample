<?php ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; text/html; charset=UTF-8"> 
<!-- 		<meta name="google-site-verification" content="zulAOZgemPGXtBjBbj8twxq-i4jTqO3v3XNwK_NdXG8" /> -->
		<title><?php echo $title_for_layout; ?></title>
		<?php
			//meta keywords you can set these from controller files e.g for home page of site open users_controller.php file and see index() method
			if(!empty($meta_keywords))
				echo $html->meta('keywords',$meta_keywords);
			//meta descriptions
			if(!empty($meta_description))
				echo $html->meta('description',$meta_description);
				
				
			echo $html->meta('icon');
			echo $html->css('style_mobile');
			echo $javascript->link(array('jquery-1.3.2.min','mobile/jquery-latest','functions','mobile/custom'));
			//echo $javascript->link("jquery");
			echo $scripts_for_layout;
		?>
	</head>
	<body>
		<!--Center Align Outer Section Starts-->
		<section id="wrapper-cont">
		<!--Main Section Starts-->
			<section id="wrapper">
			<!--Header Starts-->
			 <?php echo $this->element('mobile/header');?>
			<!--Header End-->
			<!--main Content Start-->
				<?php
					echo $content_for_layout;
				?>
			<!--Main Content End--->
			</section>
		</section>
	<!--Main Content End--->
			<!--Search and Breadcrumb Starts-->
             			<?php echo $this->element('mobile/search_product');?>
         		 <!--Search and BreadCrumb End-->
         		 
			<!--Navigation Starts-->
			<section class="maincont">
				<nav class="nav">
					<ul class="maincategory yellowlist">
						<?php echo $this->element('mobile/nav_footer');?>
					</ul>
				</nav>
			</section>
			<!--Navigation End-->
			<!--Foo Starts-->
				<?php echo $this->element('mobile/footer');?>
			<!--Foo End-->
			</section>
		<!--Main Section End-->
		</section>
		<!--Center Align Outer Section End--> 
</body>
</html>
<?php echo $this->element('sql_dump');?>