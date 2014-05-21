<?php

if(!empty($this->params['url']['url'])){
	$urlAccessed = explode('/',$this->params['url']['url']);

$urlPrefix = $urlAccessed[0] ;
} else {
$urlPrefix = -1;
}
?>

<?php  if(strtolower($urlPrefix) == 'admin') {  // if admin panal is opened  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--title>Choiceful <?php //$title_for_layout;?> :: Admin Panel</title-->
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
<body >
	<table border="0" cellspacing="0" cellpadding="0"  align="center" width="100%">
		<tr>
			<td valign="top" align="center">
				<table width="100%" cellpadding="0" cellspacing="0"  bgcolor="#FFFFFF" border="0" class="adminHeader">
					<tr>
						<td width="40%" height="75"  align="left" valign="middle" class="adminLogo">
						<?php
						//$logo_image = $html->image('/img/admin/logo.gif', array(
						$logo_image = $html->image('/img/Choiceful-LO-FF_30.jpg', array(
							 'alt' => 'Choiceful Administration Panel',
							 'border'=>0,
							 'title'=>Configure::read('SITE_TITLE')
							 ));
							echo $html->link(
							$logo_image,
							array('controller'=>'admin','admin'=>false),
							array('escape'=>false)
							);
						?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top"> <?php /*style="background-color:#84C5F3;"*/ ?>
				<table style="background-color:#C4EAF8;" width="100%" height="30" cellpadding="0" cellspacing="0"  border="0">
					<tr>
						<td  width="40%" class="control_heading">Admin Control Panel &nbsp</td>
						<td align="right" style="padding-right:10px; vertical-align:middle;" class="homeLink" >
						<?php
						$adminDetailsArr  = $this->Session->read('SESSION_ADMIN');
						$logout_image = $html->image('/img/logout.gif', array( 'alt' =>'', 'border'=>0) );
						if(!empty($adminDetailsArr)) {
							echo "Welcome ".ucfirst($adminDetailsArr['firstname']);
							echo "&nbsp;|&nbsp;";
							echo $html->link(" Logout", array("controller"=>"adminusers","action"=>"logout"),array('class'=>'homeLink', 'escape'=>false), null, false); 
						}else{
							
						}?>
							
						</td>
					</tr>		
				</table>
			</td>
		</tr>
		<tr bgcolor="#FE8C3F">				
			<td height="6"></td>
		</tr>
	</table>
	<?php /******************* Headere ends starts here **********************/ ?>
	
	<?php /******************* Main container starts here **********************/  ?>
	<table border="0" cellspacing="0" cellpadding="0"  align="center" width="100%" >
		<tr>
			<?php
			$admin_user = $this->Session->read('SESSION_ADMIN');
			if(!empty($admin_user)) { ?>
				<td valign="top" width="230" align="left">
					<?php  // echo $this->element('/admin/left_navigation');?>
				</td>
				<td width="15"></td>
			<?php }?>
			<td valign="top" align="left">
			<?php 
				if ($session->check('Message.flash')){ ?>
					<div class="messageBlock">
						<?php echo $session->flash();?>
					</div>
				<?php } 
				echo $content_for_layout;
			?>
			</td>
		</tr>
	</table>
	<?php /******************* Middle container ends here  here **********************/ ?>
	
	<?php /******************* Footer starts here **********************/ ?>
	
	<table cellpadding="0" cellspacing="0" border="0" width=100% >
		<tr>
			<td  height="5">
		<!--Pre Loader Start-->
		<div id="preloader" style="position:absolute;left:480px;top:180px;z-index:999;display:none;">
			<img src="/img/loading.gif">
		</div>
		<!--Pre Loader End-->
			</td>
		</tr>
		<tr>
			<td align="center"  class="footer">Copyright &#169; <?php echo date('Y'); ?> Choiceful. All rights reserved.</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<?php /******************* Footer ends here **********************/ ?>
</body>
</html>



<?php } else{ // otherwise display front end panel ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN" http://www.w3.org/TR/REC-html40/frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
		<title>Error</title>
		<?php echo $html->css('style');?>
	</head>
	
	<body>
		<div id="main-container">
		<!--Header Start-->
		<?php echo $this->element('error_header');?>
		<?php //echo $this->element('top_navigation');
		echo $this->element('top_navigation_staticpage');?>
		<!--Content Started-->
		<div id="content">
			<?php echo $this->element('search_fullpage');?>
			<?php echo $this->element('right_navigation');?>
			<?php
			if ($session->check('Message.flash')){ ?>
				<div class="messageBlock">
					<?php echo $session->flash();?>
				</div>
			<?php } ?><div class="mid-content" style="padding:10px 0;width:100%;height:300px">
			<?php
			echo $content_for_layout;
			?>
		</div>
	</div>
	<!--Content Closed-->
	<?php echo $this->element('error_footer');?>
</div>
<!--Main Container Closed-->
	</body>
</html>


<?php } ?>

<?php echo $this->element('sql_dump');?>