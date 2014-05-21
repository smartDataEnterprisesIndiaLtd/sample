<?php 
echo $html->script('jquery-1.4.3.min',true);
echo $javascript->link('lib/prototype',true);?>
 <!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->
<span id="plsLoaderID" style="display:none; text-align:center; margin-left:50%" class="dimmer"><img src="/img/loading.gif" alt="Loading" style="position:fixed;left:30%;top:40%;z-index:999;" />                     </span>

<!--Tbs Cnt start-->
<section class="tab-content padding0">
<!--Manage Listings Start-->
<section class="offers">
	<?php echo $html->link(
	'<section class="gr_grd brd-tp0">
		<h4 class="orng-clr">
			<font color=#ED6C0B>Manage Listings</font>
		</h4>
	<div class="loader-img">
		'.$html->image('mobile/down_arrow_blue.png',array('alt'=>'')).'
	</div>
	</section>'
	,'/marketplaces/manage_listing',array('escape'=>false));?>
	
</section>
<!--Manage Listings Closed-->
<?php /****************************Manage Listings Closed*************************/?>

<!--View Orders Start-->
<section class="offers">

	<section class="gr_grd" style="margin-top:11px;">
		<h4 class="orng-clr">
			<?php echo $html->link('<font color=#ED6C0B>View Orders</font>','/sellers/orders/',array('escape'=>false));?>
		</h4>
		<div class="loader-img">
			<?php echo $html->image('mobile/down_arrow_blue.png',array('alt'=>'',))?>
		</div>
	</section>
	<!--Row1 Start-->
	<div class="row-sec">
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
	</div>
	<!--Row1 Closed-->
	
</section>
<!--View Orders Closed-->
<?php /****************************View Orders Closed*************************/?>

<!--************************Sales Reports Start*************************-->
<section class="offers">
	<?php echo $html->link(
	'<section class="gr_grd">
		<h4 class="orng-clr">
			<font color=#ED6C0B>Sales Reports</font>
		</h4>
		<div class="loader-img">
			'.$html->image("mobile/down_arrow_blue.png",array("alt"=>"")).'
		</div>
	</section>'
	,'/marketplaces/sales_report/',array('escape'=>false));?>
	<!--Row1 Start-->
	<div class="row-sec" id="salesreports" style="dispaly:none;padding:5px 0px;">
	
	</div>
	<!--Row1 Closed-->
	
</section>
<!--Sales Reports Closed-->
<?php /****************************Sales Reports Closed*************************/?>
<!--Account Settings Start-->
<section class="offers">                	
		<?php echo $html->link(
			'<section class="gr_grd">
			<h4 class="orng-clr">
				<font color=#ED6C0B>Account Settings</font>
			</h4>
				<div class="loader-img">
					'.$html->image('mobile/down_arrow_blue.png',array('alt'=>'',)).'
				</div>
			</section>'
		,'/sellers/my_account/',array('escape'=>false));?>
	<!--Row1 Start for account settion contaion comes on this div-->
	<div class="row-full" id="my-account" style="dispaly:none;padding:5px 0px;">
	</div>
	<!--Row1 Closed-->
	
</section>
<!--Account Settings Closed-->
<?php /****************************Account Settings Closed*************************/?>
</section>
<!--Tbs Cnt closed-->
<script language="JavaScript">
	function updateFiltertext(fromid,toid){
		var valuefilter = jQuery('#Listing'+fromid+'Options').val();
		jQuery('#Listing'+toid+'Options').val(valuefilter);
		jQuery('#PageFilter').val(valuefilter);
	}
</script>
