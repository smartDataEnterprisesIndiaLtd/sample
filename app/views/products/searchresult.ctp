<?php e($html->script('jquery_paging') );?>
<style type="text/css">
.select {
float:none;
margin-right:0px;
}

/*.dimmer{
	position:relative;
	left:45%;
	top:55%;
}*/

</style>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www."); document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript">
var pageTracker = _gat._getTracker('UA-629547-1');
pageTracker._initData();
pageTracker._trackPageview('<?php echo SITE_URL.$this->params['url']['url'].'?q='.$this->params['url']['q']?>');
</script>

<div class="mid-content">
<?php 
	if(!empty($search_result)){
		if(!empty($breadcrumbs)){
		
	?>
	<div class="breadcrumb-widget">
	
	<span class="larger-fnt"><strong>Search Results</strong>
		for 
		<?php echo $html->image('gray-fade-arrow.gif',array('width'=>"8",'height'=>"9", 'alt'=>""));?>
		      <strong>"<?php echo $searchWord;?>"</strong>
		
	<?php 
	/*for($crum_i = 2; $crum_i < count($breadcrumbs['crumb']); $crum_i ++){
		
		
	$url_fh_crumb = @$breadcrumbs['crumb'][$crum_i]->{"url-params"};
		
	$url_fh_crumb = str_replace('%2f','~',$url_fh_crumb);
		
	$name_dis = @$breadcrumbs['crumb'][$crum_i]->name->_;
		
	if($breadcrumbs['crumb'][$crum_i]->name->value == 'search'){
		$name_dis = $breadcrumbs['crumb'][$crum_i]->searchterms->term->_;
		echo $html->link(@$name_dis,$this->params['action'].'/keywords:'.$searchWord.'/dept_id:'.$department_id.'/sort_by:'.$sort.'/&'.$url_fh_crumb.'&fh_start_index=0&fh_view_size='.$view_size,array('escape'=>false,'id'=>'search_term')); if($crum_i != (count($breadcrumbs['crumb']) -1 )) echo ' >';
	} else {
		echo $html->link(@$name_dis,$this->params['action'].'/keywords:'.$searchWord.'/dept_id:'.$department_id.'/sort_by:'.$sort.'/&'.$url_fh_crumb.'&fh_start_index=0&fh_view_size='.$view_size,array('escape'=>false)); if($crum_i != (count($breadcrumbs['crumb']) -1 )) echo ' >';
	}*/?>
	<?php //}?>
	 <?php //echo $html->link('Biography',,array('escape'=>false));?><!-- > <span>British Royality</span>--></div>
	<?php } }
	?>
	</strong>
	</span>
		
	<div id="listing1234556">
		<?php echo $this->element('product/search_products_users_fh');?>
	</div>
		
	<!--Suggestion Box Start-->
	<div class="suggestion-box-widget">
		
	<!--span id="plsLoaderID1" style="display:none" class="dimmer">
		<?php //echo $html->image("waiting.gif" ,array('alt'=>"Loading"));?>
		Loading, please wait
	</span-->
		
	<div class="search-feedback">
	<h5>Search Feedback</h5>
	<?php $searchWord=urldecode($searchWord);?>
	<p>Did you find what you were looking for?
	<span id="sug_vote"><?php echo $this->element('product/user_suggestion');?></span>
	</p>
		
	<p>If you need help or have a question for Customer Services, please visi the <?php echo $html->link('Help Section','/pages/view/help-topics',array('escape'=>false));?></p>
</div>
<!--Search Feedback Closed-->

	<span id="sug_vote_box"><?php echo $this->element('product/user_suggestion_box');?></span>
		
	</div>
	<!--Suggestion Box Closed-->
	<!--Recent History Widget Start-->
	<div class="recent-history-widget">
		<!--Recent History Start-->
		<div class="recent-history">
			<h4><strong>Your Recent History</strong></h4>
			<ul>
				
				<?php
				if(!empty($myRecentProducts)){
					$i=0;
					foreach ($myRecentProducts as $product){
						if($product['product_image'] == 'no_image.gif' || $product['product_image'] == 'no_image.jpeg'){
							$image_path = '/img/no_image.jpeg';
						} else{
							$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_50_'.$product['product_image'];
							if(!file_exists($image_path) ){
								$image_path = '/img/no_image_50.jpg';
							}else{
								$image_path = '/'.PATH_PRODUCT.'small/img_50_'.$product['product_image'];
							}
						}
						$i++;
						if($i > 5){ // ahow only 5 items
							continue;
						} ?>
					<li>
						<span class="rec_his_img">
							<?php echo $html->link($html->image($image_path,array('width'=>"20",'height'=>"20", 'alt'=>$product['product_name'], 'title'=>$product['product_name'])),"/".$this->Common->getProductUrl($product['id'])."/categories/productdetail/".$product['id'],array('escape'=>false,'class'=>''));?>
						</span>
						<span class="rec_his_des">
							<?php echo $html->link($format->formatString($product['product_name'],500, '..'),"/".$this->Common->getProductUrl($product['id'])."/categories/productdetail/".$product['id'],array('escape'=>false,'class'=>''));?>
						</span>
					</li>
					
				<?php  }
				} else { ?>
					<p style="color: #86838A; ">No products viewed. </p>
				<?php
				}?>
			</ul>
		</div>
		<!--Recent History Closed-->
		<script>
		var width_pre_div = 1000;
		</script>
		<?php echo $this->element('product/continue_shopping'); ?>
	</div>
	<!--Recent History Widget Closed-->
</div>