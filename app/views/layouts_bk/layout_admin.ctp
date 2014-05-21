<?php ob_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
		<!--<title>Choiceful <?php //$title_for_layout;?> :: Admin Panel</title>-->
		<meta http-equiv="cache-control" content="no-cache"> <!-- tells browser not to cache -->
		<meta http-equiv="expires" content="0"> <!-- says that the cache expires 'now' -->
		<meta http-equiv="pragma" content="no-cache"> <!-- says not to use cached stuff, if there is any -->
		<meta content="IE=7" http-equiv="X-UA-Compatible" />
		<meta content="English" name="language" />
		<meta content="1 week" name="revisit-after" />
		<meta content="global" name="distribution" />
		<meta content="index, follow" name="robots" />
		<?php print $html->charset('UTF-8') ?>
		<?php echo $html->css('menu/jMenu.jquery');?>
		<?php echo $html->css("admin"); ?>
		<link rel="shortcut icon" href="/img/favicon.ico">
		<script type="text/javascript">
			var SITE_URL = "<?php echo SITE_URL; ?>";
		</script><!--<script type="text/javascript" language="javascript">
var site_url = '<?php //echo SITE_URL;?>';
</script>-->
			<?php echo $javascript->link("jquery"); ?>
			<?php echo $javascript->link("lib/prototype",false); ?>
			<?php echo $javascript->link("admin"); ?>
			<?php echo $javascript->link("settxt_focus"); ?>
			<?php echo $javascript->link("functions");
				echo $scripts_for_layout; ?>

		<script type="text/javascript">

			jQuery(document).ready(function(){
				
			jQuery(".breadcrumb_frame ul li:last-child").addClass("last");	
				});
		</script>
	</head>
	<body>
		<div id="main">
		<table border="0" cellspacing="0" cellpadding="0"  align="center" width="100%">
			<!--- <tr>
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
								array('controller'=>'homes','action'=>'dashboard','admin'=>true),
								array('escape'=>false)
								);
							?>
							</td>
						</tr>
					</table>
				</td>
			</tr> --->
			<tr>
				<td valign="top"> <?php /*style="background-color:#84C5F3;"*/ ?>
					<table style="background-color:#C4EAF8;" width="100%" height="30" cellpadding="0" cellspacing="0"  border="0">
						<tr>
							<td  width="40%" class="control_heading">Choiceful Admin Control Panel &nbsp</td>
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
		<?php
				$admin_user = $this->Session->read('SESSION_ADMIN');
				if(!empty($admin_user)) {
					echo $this->element('/admin/left_navigation_new');
				}
		?>
		
					<!--Sub Nav Start-->
		      <section class="breadcrumb">
			      
			      <section class="breadcrumb_frame">
				  <ul><!--- <?php $breadCrumb ="";
					$controllerBrdCr = $this->params['controller'];
					echo $controllerBrdCr;
					switch($controllerBrdCr){
						case  in_array($controllerBrdCr,array('homes','adminusers','settings')):
							$breadCrumb = "Home";
							break;
						case  'users':
							$breadCrumb = "Customer Management";
							break;
						default:
							break;
					}
				  ?> --->
					<li><?php  echo $this->Html->getCrumbs('<li><span>',"Admin Home"); ?></li>
				      <!--<li><a href="#">Choiceful</a></li>
				      <li><a href="#">Home &amp; Garden</a></li>   
				      <li><a href="#">Building Supplies</a></li>
				      <li><a href="#">Adhesives</a></li>   
				      <li><a href="#" class="active">All Adhesives</a></li>  
				      <li class="last"><span>Apple MacBook Pro MC976B/A 15-inch/Retina Display/Quad-Core i7 2.6GHz/8GB RAM/512GB Flash Storage/Intel Display/uad-Core i7 2.6GHz/8GB RAM/512GB Flash Storage/Intel Display...</span></li>
				 --> </ul>
			      </section>
			  </section>
		     <!--Sub Nav Closed-->
		
		<?php /******************* Main container starts here **********************/ ?>
		<div style="padding:0 5px; clear:both;">
		<table border="0" cellspacing="0" cellpadding="0"  align="center" width="100%" >
			<tr>
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
		
		</div>
		<div class="push"></div>
		</div> 
		<?php /******************* Middle container ends here  here **********************/ ?>
		
		<?php /******************* Footer starts here **********************/ ?>
		
		<div class="footer">Copyright &#169; <?php echo date('Y'); ?> Choiceful. All rights reserved.</div>
		<?php /******************* Footer ends here **********************/ ?>
		
		<!--Pre Loader Start-->
		<div id="preloader" style="position:fixed;left:480px;top:180px;z-index:999;display:none;">
			<img src="/img/loading.gif">
		</div>
		<!--Pre Loader End-->
	</body>

</html>
<?php echo $this->element('sql_dump');
if($this->params['controller'] != 'sellers' && $this->params['action'] != 'payment_summary') {
?>
<script type="text/javascript">
f_setfocus();
</script>
<?php }?>