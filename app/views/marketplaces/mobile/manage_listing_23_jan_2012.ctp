<?php
echo $html->script('jquery-1.4.3.min',true);
//echo $javascript->link('lib/prototype');
?>
 <!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->
<span id="plsLoaderID" style="display:none; text-align:center; margin-left:50%" class="dimmer"><img src="/img/loading.gif" alt="Loading" style="position:fixed;left:30%;top:40%;z-index:999;" />                     </span>

<!--Tbs Cnt start-->
<section class="tab-content padding0">
<!--Manage Listings Start-->
<section class="offers">                	
	<section class="gr_grd brd-tp0">
	<h4 class="orng-clr">Manage Listings</h4>
	<div class="loader-img">
		<?php echo $html->image('mobile/loader.gif',array('width'=>'22','height'=>'22','alt'=>''));?>
	</div>
	</section>
	<!--Row1 Start-->
	<div class="row-sec">
	<p>Search, edit and add new listings. Click on any product to get started.</p>
	<!--Search Results Start-->
		<div class="overflow-h padding-top10">
		
		<!--Search Widget Start-->
		<?php echo $form->create('Marketplace',array('action'=>'manage_listing','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));?>
		<div class="gry-clr-br brdr-btm-nn">
			<ul>
			<li><strong>Search Your Listings</strong>
				<?php echo $form->input('Search.keyword',array('class'=>'input ls-wider','label'=>false,'div'=>false));?>
				
				<?php echo $form->submit('Go',array("type"=>"submit",'class'=>'grngradbtn','div'=>false));?>
			</li>
			</ul>
		</div>
		<?php echo $form->end();?>
		<!--Search Widget Closed-->
		<?php echo $this->element('mobile/marketplace/products_listing');?>
		</div>
		<!--Search Results Closed-->
		
	</div>
	<!--Row1 Closed-->
	
</section>
<!--Manage Listings Closed-->
<?php /****************************Manage Listings Closed*************************/?>

<!--View Orders Start-->
<section class="offers">
	<a href="javascript:void(0);" onclick="vieworder();">
	<section class="gr_grd">
	<h4 class="orng-clr"><font color=#ED6C0B>View Orders</font></a></h4>
		<div class="loader-img">
			<?php echo $html->image('mobile/loader.gif',array('alt'=>'','width'=>'22','height'=>'22'))?>
		</div>
	</section>
	</a>
	<!--Row1 Start-->
	<div class="row-sec" id="viewOrders">

	</div>
	<!--Row1 Closed-->
	
</section>
<!--View Orders Closed-->
<?php /****************************View Orders Closed*************************/?>

<!--************************Sales Reports Start*************************-->
<section class="offers">	
	<section class="gr_grd">
		<h4 class="orng-clr">
			<a href="javascript:void(0);" onclick="viewSelesReport();">
				<font color=#ED6C0B>Sales Reports</font>
			</a>
		</h4>
		<div class="loader-img">
			<?php echo $html->image('mobile/loader.gif',array('alt'=>'','width'=>'22','height'=>'22'))?>
		</div>
	</section>
	<!--Row1 Start-->
	<div class="row-sec" id="salesreports">
	
	</div>
	<!--Row1 Closed-->
	
</section>
<!--Sales Reports Closed-->
<?php /****************************Sales Reports Closed*************************/?>
<!--Account Settings Start-->
<section class="offers">                	
		<section class="gr_grd">
		<h4 class="orng-clr">Account Settings</h4>
			<div class="loader-img">
				<?php echo $html->image('mobile/loader.gif',array('alt'=>'','width'=>'22','height'=>'22'));?>
			</div>
		</section>
	<!--Row1 Start for account settion contaion comes on this div-->
	<div class="row-full" id="my-account">
	</div>
	<!--Row1 Closed-->
	
</section>
<!--Account Settings Closed-->
<?php /****************************Account Settings Closed*************************/?>
</section>
<!--Tbs Cnt closed-->
<!--Search Results Closed-->
<script type="text/javascript">
var SITE_URL = "<?php echo SITE_URL; ?>";
 // function to like add a question
function vieworder(){
	var postUrl = SITE_URL+'sellers/orders/';
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#viewOrders').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
window.onload = vieworder();

function viewSelesReport(){
	var postUrl = SITE_URL+'marketplaces/sales_report/';
	jQuery('#plsLoaderID');
	jQuery.ajax({
		cache:false,
		async:false,
		type:"GET",
		url:postUrl,
		success:function(msg){
		jQuery('#salesreports').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
window.onload = viewSelesReport();

function accountSettings (){
	var postUrl = SITE_URL+'sellers/my_account/';
	jQuery('#plsLoaderID');
	jQuery.ajax({
		cache:false,
		async:false,
		type:"GET",
		url:postUrl,
		success:function(msg){
		jQuery('#my-account').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
window.onload = accountSettings();
</script>
<?php echo $this->Js->writeBuffer(); ?>