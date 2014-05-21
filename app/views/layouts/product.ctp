		<!DOCTYPE HTML>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<!--[if lt IE 9]>
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<meta http-equiv="cache-control" content="no-cache"> <!-- tells browser not to cache -->
		<meta http-equiv="expires" content="0"> <!-- says that the cache expires 'now' -->
		<meta http-equiv="pragma" content="no-cache"> <!-- says not to use cached stuff, if there is any -->
		
		<title><?php //echo $title_for_layout.$catTitle; ?><?php echo $title_for_layout; ?></title>
		<?php //echo $javascript->link(array('prototype')); ?>
		<?php
		//meta keywords you can set these from controller files e.g for home page of site open users_controller.php file and see index() method
		if(!empty($meta_keywords))
			echo $html->meta('keywords',$meta_keywords);
		//meta descriptions
		if(!empty($meta_description))
			echo $html->meta('description',substr($meta_description,0,130));
				
		echo $html->meta('icon');
		echo $html->css('style'); 
		echo $javascript->link(array('headerslider/jquery-1.7.1.min','functions'));
		//echo $scripts_for_layout; ?>
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
		<?php
			$actual_link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if(empty($this->params['xyz'])){
				@$prd_name = $this->Common->getProductUrl($this->params['pass'][0]);
				$actual_link = "http://".$_SERVER['HTTP_HOST']."/".$prd_name.$_SERVER['REQUEST_URI'];
			}
			if(($this->params['controller'] == 'categories') && $this->params['action'] == 'productdetail'){
				$newUrl = array();
				$newUrl = explode('/categories/productdetail',$_SERVER['REQUEST_URI']);
						if(!empty($this->params['pass'][0])){
					$restOfString = isset($newUrl)?$newUrl:'';
					$prd_name = @$this->Common->getProductUrl($this->params['pass'][0]);
					$actual_link = "http://".$_SERVER['HTTP_HOST']."/".$prd_name."/categories/productdetail/".$this->params['pass'][0];//$restOfString[1];
				}else{
					$actual_link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				}
			}
			//$newUrl = array();
			//$newUrl = explode('/categories/productdetail',$_SERVER['REQUEST_URI']);
			//		if(!empty($this->params['pass'][0])){
			//	$restOfString = isset($newUrl)?$newUrl:'';
			//	$prd_name = @$this->Common->getProductUrl($this->params['pass'][0]);
			//	$actual_link = "http://".$_SERVER['HTTP_HOST']."/".$prd_name."/categories/productdetail/".$this->params['pass'][0];//$restOfString[1];
			//}else{
			//	$actual_link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			//}
		
		?>
		<link rel="canonical" href="<?php echo $actual_link ?>"/>
	</head>
	<body onload="getFooterHeight();">
		<div id="main-container">
			<?php echo $this->element('header');?>
			<?php //echo $this->element('top_navigation');?>
			<!--Content Started-->
			<div id="content">
			<?php
				echo $this->element('left_navigation');
				//echo $this->element('search');
				echo $content_for_layout;
			?>
			</div> 
			
			<!--Content Closed-->
			<div class="push" id="setPushHeight"></div>
			</div>
		</div>
		<?php echo $this->element('footer');?>
	</body>
</html>
		<script>
			/*jQuery(document).ready(function(){
				
				jQuery("a").each(function(){
					//jQuery(this).attr('href')
					var newStr = jQuery(this).prop('href').toLowerCase();
					jQuery(this).prop('href',newStr);
				});
			});*/
			
			
		</script>
<?php echo $this->element('sql_dump');?>