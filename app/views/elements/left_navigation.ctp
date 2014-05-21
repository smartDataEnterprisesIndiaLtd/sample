<?php
$controller_name = $this->params['controller'];
$action_name 	 = $this->params['action'];
?>
<!--Left Content Start-->
<div class="left-content">
<?php
$controllerNameNeedtop2  = array('departments' , 'homes');
$actionNameNeedtop2  = array('a_z_index', 'choiceful_on_mobile', 'international_sites');

if( in_array($controller_name, $controllerNameNeedtop2) && in_array($action_name, $actionNameNeedtop2)) {
	 echo $this->element('navigations/left_links');
	 echo $this->element('navigations/help');
	
}else{
	if(($this->params['action'] == 'searchresult' && $this->params['controller'] == 'products'))
		echo $this->element('product/filter_products_users_fh');
	if($this->params['action'] == 'store' && $this->params['controller'] == 'sellers') {
		echo $this->element('seller/filter_products_sellers_store');
		echo $this->element('navigations/help');
	} /*else if($this->params['action'] == 'store2' && $this->params['controller'] == 'sellers') {

		echo $this->element('seller/filter_products_sellers2');
		echo $this->element('navigations/help');
	}*/ else{
		
		if(($this->params['action'] == 'bestseller' || $this->params['action'] == 'bestseller_products') && $this->params['controller'] == 'products') {
			echo $this->element('navigations/bestsellers_left_links');
		}
		if($this->params['action'] != 'searchresult' && $this->params['controller'] != 'products') {
			echo $this->element('navigations/left_links');
		}
		echo $this->element('navigations/hot_picks');
		//echo $this->element('navigations/charts'); comment due to clieent request mail 26 sep 2013
		echo $this->element('navigations/help');
		echo $this->element('navigations/services');
		echo $this->element('navigations/business');
		echo $this->element('navigations/choiceful_favorites');
		echo $this->element('navigations/secure_shopping');
	}
}
if($this->params['action'] != 'searchresult' && $this->params['controller'] != 'products') {?>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style" style="padding:0 24px"> <!--  -->
	<a href="http://www.addthis.com/bookmark.php?v=250&amp;pubid=xa-4d882e8a367f2b78" class="addthis_button_compact">Share</a>
	<span class="addthis_separator"> </span>
	<a class="addthis_button_email"></a>
	<a class="addthis_button_facebook"></a>
	<a class="addthis_button_twitter"></a>
	<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4d882e8a367f2b78"></script>
</div>
<!-- AddThis Button END -->

<?php }?></div>
<!--Left Content Closed-->