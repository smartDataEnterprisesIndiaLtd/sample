<?php 
echo $html->script('jquery-1.4.3.min',true);
//echo $javascript->link('lib/prototype');?>
<?php $url = array(
'controller' =>'sellers',
'action' => 'get_sellerOrders',
'testpage'=>1
);
$this->Paginator->options(array('update' => '#viewOrders','url'=>$url,'evalScripts' => true));
//$this->helpers['Paginator'] = array('ajax' => 'Ajax');
?>
<!--mid Content Start-->
	<!--Search Results Start-->
		<?php
		if ($session->check('Message.flash')){ ?>
			<div class="messageBlock">
				<?php echo $session->flash();?>
			</div>
		<?php } ?>
		
		
		
		<!--Search Results Start-->
		<div class="search-results-widget" style="overflow:visible;">
			<div id="viewOrders-listing">
				<?php echo $this->element('mobile/seller/orders_listing');?>
			</div>
			
		</div>
	<!--Search Results END-->
	
	
<script language="JavaScript">
	function updateFiltertext(fromid,toid){
		var valuefilter = jQuery('#Listing'+fromid+'Options').val();
		jQuery('#Listing'+toid+'Options').val(valuefilter);
		jQuery('#PageFilter').val(valuefilter);
	}
</script>