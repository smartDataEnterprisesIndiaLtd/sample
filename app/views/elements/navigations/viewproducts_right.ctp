<?php ?><!--Right Widget Star -->
<div class="right-widget">
	<!--Right Box Start-->
	<div class="wt-top-widget"></div>
	<!--Right Box Ends -->
	<!-- White Box Start-->
	<div class="white-box">
		<?php //foreach($facetmap as $facet_filter) {
// pr($facet_filter);
		//$test_facet_filter = $facet_filter->filter;
		foreach($facetmap as $facet) {
			if((@$facet->link->name == 'EXACT') || ($facet == 'searchresults') || $facet->title == 'categories'){
			} else {
			?>
			<div class="side-content">
				<h4 class="orange-col-head help-topic-head"><span><?php echo ucfirst(@$facet->title); ?></span></h4>
				<ul class="filter-search">
					<?php if(!empty($facet->filtersection)) {
						 foreach($facet->filtersection as $filter){
						
							if(!empty($filter->name) || !empty($filter->link->name)) {
							?>
							<li class="margin-top"><?php
							
							if(!empty($filter->link->{"url-params"})){
								$url_fh = $filter->link->{"url-params"};
								$link_name = $filter->link->name;
								if($facet->title == "Average Star Rating"){
									$link_name = $filter->link->name;
									$link_name=$common->displayProductRatingYellowSearchPage($link_name).' & Up';
									
								}elseif($facet->title == "Seller ID"){
									$link_name = $filter->link->name;
									$link_name=$common->businessDisplayName($link_name);
								}else{
									$link_name = $filter->link->name;
								}
								
								$count_pr = $filter->nr;
							}else{
								$url_fh = $filter->{"url-params"};
								$link_name = $filter->name;
								
								if($facet->title == "Average Star Rating"){
									$link_name = $filter->name;
									$link_name=$common->displayProductRatingYellowSearchPage($link_name).' & Up';
								}elseif($facet->title == "Seller ID"){
									$link_name = $filter->name;
									$link_name=$common->businessDisplayName($link_name);
								}else{
									$link_name = $filter->name;
								}
								$count_pr = $facet->filtersection->nr;
							}
							$url_fh = str_replace('%2f','~',$url_fh);
							$ftitle  = str_replace(" ","_",strtolower($facet->title));
							if($crawl1){	
							echo $html->link(@$link_name,$this->params['action'].'/'.$selected_category.'/'.$department_id.'/'.$sort_by.'/'.'&'.$url_fh,array('escape'=>false)); ?> <span>(<?php echo $count_pr; ?>)</span>
							<?php } else{
								if($ftitle == "brand"){
							echo $html->link(@$link_name,$this->params['action'].'/'.$selected_category.'/'.$department_id.'/'.$sort_by.'/'.'&'.$url_fh,array('escape'=>false)); ?> <span>(<?php echo $count_pr; ?>)</span>
							<?php 	
								}
							}
							?>
							</li><?php
							}
						}
					}
					?>
						
							
					<?php 
					$url_more_fh = ''; $link_more_name =''; $count_more_pr = '';
					if(!empty($facet->link)) {
						$link_more_name = $facet->link->name;
					if(!empty($link_more_name)) {
						if($link_more_name == 'EXACT'){
	// 						$count_more_pr = @$facet->nr;
	// 						$url_more_fh = str_replace('%2f','~',$url_more_fh);
	// 						$url_more_fh = str_replace('/','~',$url_more_fh);
	// 						//echo $html->link(@$link_more_name,$this->params['action'].'/'.$selected_category.'/'.'&'.$url_more_fh,array('escape'=>false,'class'=>'see-more')).'('.$count_more_pr.')';
	// echo $searchWord;				if(!empty($searchWord)){
	// 							echo $html->link($searchWord,$this->params['action'].'/'.$selected_category.'/'.'&'.$pass_url,array('escape'=>false,'alert'=>''));
	// 						}
						} else {
						//pr($facet); 
							
						?>
							<li class="margin-top"><?php
							if(!empty($facet->link->{"url-params"})){
								$url_more_fh = $facet->link->{"url-params"};
								$link_more_name = $facet->link->name;
								$count_more_pr = @$facet->link->nr;
									
							}	
									
									
								if(!empty($url_more_fh) && !empty($link_more_name) && $crawl1) {
									$url_more_fh = str_replace('%2f','~',$url_more_fh);
									echo $html->link(@$link_more_name,$this->params['action'].'/'.$selected_category.'/'.'&'.$url_more_fh,array('escape'=>false,'class'=>'see-more')); ?>
								<?php }
								
							?>
							</li>
					<?php } }
					}
					?>
				</ul>	
			</div>
			<?php }?>
		<?php } //}
		?>
	</div>
	<!-- White Box Closed-->
</div>
<!--Right Widget Start-->

