<?php ?>
<!--Filter Search Start-->
<?php if(is_array($facetmap) && count($facetmap)>0){?>
<?php //Configure::write('debug',2);?>
<?php foreach($facetmap as $facet_filter) {
if(is_array($facet_filter) && !empty($facet_filter)){?>
<div class="side-content">
	<!--Right Box Start-->
	<div class="wt-top-widget"></div>
	<!-- White Box Start-->
	<div class="white-box">
		<?php //$test_facet_filter = $facet_filter->filter;
		foreach($facet_filter as $facet) {
			if((@$facet->link->name == 'EXACT') || ($facet == 'searchresults')){
			} else {
			//pr($facet);
			?>
			<div class="side-content">
				<h4 class="orange-col-head help-topic-head"><span><?php echo @$facet->title; ?></span></h4>
				<ul class="filter-search">
					<?php if(!empty($facet->filtersection)) {
							
						 foreach($facet->filtersection as $filter){
							if(!empty($filter->name) || !empty($filter->link->name)) {
							?>
							<li class="margin-top"><?php
							if(!empty($filter->link->{"url-params"})){
								$url_fh = $filter->link->{"url-params"};
								$link_name = $filter->link->name;
								if($facet->title != "Average Star Rating"){
									$link_name = $filter->link->name;
								}else{
									$link_name = $filter->link->name;
									$link_name=$common->displayProductRatingYellowSearchPage($link_name).' & Up';
								}
								
								$count_pr = $filter->nr;
							}else{
								$url_fh = $filter->{"url-params"};
								$link_name = $filter->name;
								$count_pr = $facet->filtersection->nr;
							}
							$url_fh = str_replace('%2f','~',$url_fh);
							
							echo $html->link(@$link_name,$this->params['action'].'/'.$seller_id.'/&'.$url_fh,array('escape'=>false)); ?> <span>(<?php echo $count_pr; ?>)</span>
							</li>
							<?php
							}
						}
					}
				if(@$facet->title == "Price"){
					
				echo $form->create('Sellers',array('action'=>'store/'.$seller_id,'method'=>'POST','name'=>'frmPages','id'=>'frmPages'));
					
				echo CURRENCY_SYMBOL.$form->input('Sellers.price',array('value'=>@$this->data['Marketplace']['price'],'div'=>false, 'label'=>false, 'style'=>'width:35px;padding-bottom:2px;padding-top:2px;')).'&nbsp&nbsp';
					
				echo CURRENCY_SYMBOL.$form->input('Sellers.price1',array('value'=>@$this->data['Marketplace']['price1'],'div'=>false, 'label'=>false, 'style'=>'width:35px;padding-bottom:2px;padding-top:2px;')).'&nbsp&nbsp';
					
				//echo $form->hidden('Sellers.keywords',array('value'=>$seller_id,'div'=>false, 'label'=>false));
					
				echo $form->button('Go',array('type'=>'submit','class'=>'bluggradbtn','div'=>false));
				echo $form->end();
				}
				?>
					
					
					<?php 
					$url_more_fh = ''; $link_more_name =''; $count_more_pr = '';
					if(!empty($facet->link)) {
						$link_more_name = $facet->link->name;
					if(!empty($link_more_name)) {
						if($link_more_name == 'EXACT'){
						} else {
							
						?>
							<li class="margin-top"><?php
							if(!empty($facet->link->{"url-params"})){
								$url_more_fh = $facet->link->{"url-params"};
								$link_more_name = $facet->link->name;
								$count_more_pr = @$facet->link->nr;
								
							}
									
									
								if(!empty($url_more_fh) && !empty($link_more_name)) {
									$url_more_fh = str_replace('%2f','~',$url_more_fh);
									echo $html->link(@$link_more_name,$this->params['action'].'/'.$seller_id.'/&'.$url_more_fh,array('escape'=>false,'class'=>'see-more')); ?>
								<?php }
							
							?>
							</li>
					<?php } }
					}
					?>
				</ul>	
			</div>
			<?php }?>
		<?php }
		?>
		
	<!--Seller Closed-->
	</div>
	<!-- White Box Closed-->
</div>
<?php 
		} }
		}//end of If condition
		?>
<!--Filter Search Closed-->