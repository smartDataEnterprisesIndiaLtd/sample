<?php
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
?>
<script language="JavaScript">
jQuery(document).ready(function()  {
	jQuery("a.form-contactus").fancybox({
		'autoScale' : true,
		'width' : 330,
		'height' : 325,
		'padding':0,'overlayColor':'#000000',
		'overlayOpacity':0.5,
		'opacity':	true,
		'hideOnOverlayClick':false,
		'type' : 'iframe',
		'autoDimensions': false,
		'onClosed': function() {
			//parent.location.reload(true);
		},
		'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
		}
	});
	
});

</script>
<!--mid Content Start-->
<div class="mid-content pad-rt-none">
	
	
	
	<?php
	if ($session->check('Message.flash')){ ?>
		<div class="messageBlock">
			<?php echo $session->flash();?>
		</div>
	<?php } ?>
	<!--Highlights Start-->
	<h1 class="heading small-font-head"><?php print $this->data['Page']['title'];?></h1>
	<!--Highlights Closed-->
	<!--Business Services: Delivering Better Value Start-->
	<div class="inner-content pad-lt-rt">
		<?php print $this->data['Page']['description'];?>
	</div>

</div>
<!--mid Content Closed-->