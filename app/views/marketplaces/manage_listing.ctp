<?php
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');

?><style type="text/css">
/*.dimmer{
position:absolute;
left:45%;
top:55%;
}
*/
.account-setting {
margin:0px;
}
.messageBlock{
margin:5px 0px;
}
</style>

<script language="JavaScript">
	jQuery(document).ready(function()  { // for writing a review
		jQuery("a.uploadListing").fancybox({
			'autoScale' : true,
			'centerOnScroll' : true,
			//'scrolling': 'no',
			'width' : 300,
			'height' : 185,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'hideOnOverlayClick':false,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': true,
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
	<!--Messge Place will changed-->
	<?php if(!empty($_SESSION['update_msg'])){?>
	<div>
		<?php 	echo $_SESSION['update_msg'];
			unset($_SESSION['update_msg']);
		?>
		<!--- <a href="javascript:void(0)" onclick="hidediv();"><?php echo $html->image("cross_btn.png" ,array('width'=>"",'height'=>"" ,'alt'=>"Corss" ));?></a> --->
	</div>
	<?php }?>
	
	<?php if ($session->check('Message.flash')){ ?>
	<div>
		<?php echo $session->flash();?>
		<!--<a href="javascript:void(0)" onclick="hidediv();"><?php echo $html->image("cross_btn.png" ,array('width'=>"",'height'=>"" ,'alt'=>"Corss" ));?></a>--->
	</div>
	<?php }?>
	<!--END Messge Place will changed-->
	
	
	<!--Setting Tabs Widget Start-->
	<?php //echo $this->element('marketplace/breadcrum'); ?>
	<!--Setting Tabs Widget Start-->
	<div class="row-widget">
		<!--Tabs Widget Start-->
		<?php echo $this->element('navigations/seller_heading_bar'); ?>
	
		<!--Tabs Content Start-->
		<div class="tabs-content">
			<!--Choice Headding Start-->
			<!--<h2 class="choice_headding choiceful">Bulk Upload Inventory</h2> --->
			<!--Choice Headding Closed-->
			<!--Discription Start-->
			<div class="inner-content">
				<p>Use this page to edit or delete your listing. To sort your listings, use the links at the top of each column. You can also edit your prices; view the lowest price offered by marketplace sellers and edit your listing quantity.</p>
				<!-- <p>Upload your entire product inventory using our uploading tool. It's really simple and fast, upload your inventory in the format provided in the sample template and we'll activate your listings.</p> -->
				<ul><li style="float:left;padding:0 20px 0 0"><?php echo $html->link('Add a Product' ,"/marketplaces/search_product" ,array('escape'=>false,'class'=>"underline-link"));?> &nbsp;| &nbsp;<?php echo $html->link('Bulk Listing for Volume Sellers' ,"/marketplaces/upload_listing" ,array('escape'=>false,'class'=>"underline-link"));?> &nbsp;| &nbsp;<?php echo $html->link('Create Manual Listing for Manufacturers and Publishers' ,"/marketplaces/create_product_step1" ,array('escape'=>false,'class'=>"underline-link"));?></li>
				<li style="text-align:right;">
				<?php 
					if(empty($this->params['named']['seller_id'])){
						echo $html->link('Download Listings' ,"/marketplaces/download_listing/" ,array('escape'=>false,'class'=>"underline-link"));
					}else{
						echo $html->link('Download Listings' ,"/marketplaces/download_listing/seller_id:".$seller_user_id ,array('escape'=>false,'class'=>"underline-link"));
					}
				?>
					&nbsp;| &nbsp;
				<?php 
					if(empty($this->params['named']['seller_id'])){
						echo $html->link('Update Listings' ,"/marketplaces/upload_edited_listing" ,array('escape'=>false,'class'=>"underline-link uploadListing"));
					}else{
						echo $html->link('Update Listings' ,"/marketplaces/upload_edited_listing/seller_id:".$seller_user_id ,array('escape'=>false,'class'=>"underline-link uploadListing"));
					}
				?>
				</li>
					<!---<li style="text-align:right;"><?php //echo $html->link('Sample',array('action'=>'download_sample_template'),array('escape'=>false,'class'=>'underline-link','style'=>"font-size:10px;margin-right:50px"));?></li>--->
</ul>
			</div>
			<!--Discription Closed-->
		</div>
		<!--Tabs Content Closed-->
	</div>
	<!--Setting Tabs Widget Closed-->
</div>
<!--mid Content Closed-->

<!--Search Results Start-->
<div class="search-results-widget" style="overflow:visible;">
	<!--Search Widget Start-->
	<?php echo $form->create('Marketplace',array('action'=>'manage_listing/seller_id:'.$seller_user_id,'method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));?>
	<div class="gray-color-bar border-botom-none" style="clear:left;">
		<ul>
			<li><strong>Search Your Listings</strong>
			<?php echo $form->input('Search.keyword',array('class'=>'form-textfield bigger-input','label'=>false,'div'=>false));
			/*$options=array(
				"url"=>"/marketplaces/search_sellerPro_listing","before"=>"",
				"update"=>"listing",
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"v-align-middle",
				'div'=>false,
				"type"=>"Submit",
				"id"=>"search_listing",
			);*/?>
			<?php //echo $ajax->submit('go-grn-btn.gif',$options);?><?php echo $form->submit('',array('alt'=>'Search','type'=>'image','src'=>SITE_URL.'/img/go-grn-btn.gif','border'=>'0', "value"=>"search",'class'=>'v-align-middle','div'=>false))?>
			</li>
		</ul>
	</div>
	<?php echo $form->end();?>
	<div id="listing">
		<?php echo $this->element('marketplace/products_listing');?>
	</div>
	<script type="text/javascript">
	function hidediv(){
		jQuery('#success').hide();
	}
</script>
</div>
<!--Search Results Closed-->
