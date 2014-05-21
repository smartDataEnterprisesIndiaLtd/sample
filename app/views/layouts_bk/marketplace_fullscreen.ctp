<?php ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="cache-control" content="no-cache"> <!-- tells browser not to cache -->
		<meta http-equiv="expires" content="0"> <!-- says that the cache expires 'now' -->
		<meta http-equiv="pragma" content="no-cache"> <!-- says not to use cached stuff, if there is any -->
		<title><?php echo ucwords($title_for_layout); ?></title>
		<?php
			if(!empty($meta_keywords))
				echo $html->meta('keywords',$meta_keywords);
			if(!empty($meta_descriptions))
				echo $html->meta('description',$meta_descriptions);
				
				echo $html->meta('icon');
				echo $html->css('style'); ?>
			<?php echo $javascript->link(array('jquery','functions')); ?>
			<?php echo $scripts_for_layout; ?>
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
				if(isset($paginator)){
					$controllerCheck= $paginator->params['controller'];
					if($controllerCheck =='sellers'){
						$prevPage = $paginator->params['paging']['OrderSeller']['prevPage'];
						$nextPage = $paginator->params['paging']['OrderSeller']['nextPage'];
						
						$page = $paginator->params['paging']['OrderSeller']['page'];
					}
					if($controllerCheck =='marketplaces'){
						$prevPage = $paginator->params['paging']['ProductSeller']['prevPage'];
						$nextPage = $paginator->params['paging']['ProductSeller']['nextPage'];
						
						$page = $paginator->params['paging']['ProductSeller']['page'];
					}
					$url = SITE_URL.$paginator->params['controller']."/".$paginator->params['action']."/page:";
					if($prevPage){
						echo '<link rel="prev" href ="'.$url.($page-1).'">';
					}
					if($nextPage){
						echo '<link rel="next" href ="'.$url.($page+1).'">';
					}
				}
			?>
	</head>
	<body>
		<div id="main-container">
			<?php echo $this->element('header');?>
			<?php echo $this->element('top_navigation');?>
			<!--Content Started-->
			<div id="content">
				<div class="left-content">
					<?php echo $this->element('navigations/market_place');?>
				</div>
				<?php echo $this->element('search');?>
				<?php echo $content_for_layout;	?>
			</div>
			<!--Content Closed-->
			<?php echo $this->element('footer_marketplace');?>
		</div>
	</body>
</html>
<?php echo $this->element('sql_dump');?>