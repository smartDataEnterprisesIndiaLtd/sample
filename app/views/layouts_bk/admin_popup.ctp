<?php ob_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Choiceful <?php echo ucwords($title_for_layout); ?> :: Admin Panel</title>
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
		<link rel="shortcut icon" href="/img/favicon.ico">
			<?php echo $javascript->link("jquery"); ?>
			<?php echo $javascript->link("admin"); ?>
			<?php echo $javascript->link("settxt_focus"); ?>
			<?php echo $javascript->link("functions"); ?>
		
		
		<script type="text/javascript">
			var SITE_URL = "<?php echo SITE_URL; ?>";
		</script>
		<?php echo $scripts_for_layout; ?>

		
	</head>
	<body >
		<table border="0" cellspacing="0" cellpadding="0"  align="center" width="100%" >
			<?php if ($session->check('Message.flash')){ ?>
			<tr>
				<td valign="top" align="left">
						<div class="messageBlock">
							<?php echo $session->flash();?>
						</div>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td valign="top" align="left">
					<?php echo $content_for_layout;?>
				</td>
			</tr>
		</table>
	</body>

</html>
<?php echo $this->element('sql_dump');?>
<script type="text/javascript">
f_setfocus();
</script>