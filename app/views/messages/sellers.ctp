<?php //e($html->script('jquery_paging') ); ?>
<style type="text/css">
	.messageBlock {
		border:0px;
		margin:0px
	}
	.search-results-widget {
    clear: left;
}
</style>
<script>
jQuery(document).ready(function(){
    // load home page when the page loads
    var SITE_URL = "<?php echo SITE_URL;?>";
   // jQuery("#msg_area").load(SITE_URL+"messages/item_msgs/0/<?php echo $last_msg_id;?>");
});
</script>
<div class="mid-content pad-rt-none">
	<?php echo $this->element('message/message_top'); ?>	
</div>
<div style="" class="search-results-widget ">
	<div class="left-content-widget">
		<div class="row" id = "messageinbox_id" name="inbox">
			<?php echo $this->element('message/inbox');   ?>
		</div>
		
		<div id="OrderInbox" name="order">
			<?php echo $this->element('message/order_inbox');?>
		</div>
	</div>
	<div class="right-content-widget overflow-h" id="msg_area">
		<a name="commenttext"></a>
		<?php echo $this->element('message/message_textarea'); ?>
	</div>
	<!--Right Content Widget Closed-->
</div>
<script type="text/javascript">


function msg_box(){
	var ajax_urlmsg1 =  SITE_URL+'messages/msg_inbox';
	jQuery.ajax({
		url: ajax_urlmsg1,
		cache: false,
		success: function(msg){
		jQuery('div#messageinbox_id').html(msg);	
			
		//$(this).addClass("done");
  	}
	});
}
msg_box();
</script>