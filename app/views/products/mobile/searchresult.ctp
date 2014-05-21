<script defer="defer" type="text/javascript" src="/js/jquery_paging.js"></script>
<?php // e($html->script('jquery_paging') );?>
<style type="text/css">
.select {
float:none;
margin-right:0px;
}
.dimmer{
	position:relative;
	left:45%;
	top:55%;
}
</style>

<?php
	if(!empty($items)){
		if(!empty($breadcrumbs)){ 
	 ?>
<?php 
	for($crum_i = 2; $crum_i < count($breadcrumbs['crumb']); $crum_i++){
		
	$url_fh_crumb = @$breadcrumbs['crumb'][$crum_i]->{"url-params"};
	
	$url_fh_crumb = str_replace('%2f','~',$url_fh_crumb);

	if($breadcrumbs['crumb'][$crum_i]->name->value == 'search'){
		$name_dis = $breadcrumbs['crumb'][$crum_i]->searchterms->term->_;
		 $html->link(@$name_dis,$this->params['action'].'&'.$url_fh_crumb.'&fh_start_index=0&fh_view_size='.$view_size,array('escape'=>false,'id'=>'search_term')); if($crum_i != (count($breadcrumbs['crumb']) -1 )) echo ' >';
	} else {
	
	 $html->link(@$name_dis,$this->params['action'].'&'.$url_fh_crumb.'&fh_start_index=0&fh_view_size='.$view_size,array('escape'=>false));
	}?>
	<?php }?>
	 <?php //echo $html->link('Biography',,array('escape'=>false));?><!-- > <span>British Royality</span>--></div>
	<?php } }
	?>

	<!--Main Content Starts--->
             <section class="maincont">
               <!--Filter Results Starts-->
               <?php echo $this->element('mobile/product/filter_products_users_fh'); ?>
               <!--Filter Results End-->
               <!--mid Content Start-->
                <div class="mid-content">
                    <!--Sorting Start-->
                    <div class="sorting-widget blusrtng">
                        <?php echo $this->element('mobile/product/showingwidget_products_users_fh'); ?>
                        <div class="clear"></div>
                    </div>
                    <!--Sorting Closed-->
                   	<!--Product Listings Widget Start-->
                        <?php echo $this->element('mobile/product/search_products_users_fh');?>
               		<!--Bottom Pagination Area End-->
                
                <!--For Going Back To Previous Page-->
                
		
		<section class="backbtnbox">
               	 <input type="button" value="Back" class="greenbtn" onclick="history.go(-1)"/>
		 <!--<?php echo $form->button('Back',array('value'=>'Back' , 'label'=>false,'div'=>false, 'escape'=>false,'class'=>'greenbtn' , 'ONCLICK'=>'history.go(-1)'));?>-->
             	</section>
                <!--For Going Back To Previous End-->  
                <!--Navigation Starts-->
                    <nav class="nav">
                      <ul class="maincategory yellowlist">
                         <?php echo $this->element('mobile/nav_footer');?>
                      </ul>
                    </nav>
               <!--Navigation End-->
             </div>
               <!--mid Content Closed-->
             </section>
