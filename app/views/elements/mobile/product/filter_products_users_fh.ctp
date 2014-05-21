<script defer="defer" language="javascript"> 
function toggle() {
	var ele = document.getElementById("toggleText");
	var text = document.getElementById("displayText");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
    		text.className = "fltrrsltlnk";
		//text.innerHTML = "show";
  	}
	else {
		ele.style.display = "block";
		text.className = "fltrrsltlnk fltrrstlnkdwn";
		//text.innerHTML = "hide" fltrrstlnkdwn;
	}
} 
</script>
<section class="filterrslts">
                      <a href="javascript:toggle();" id="displayText" class="fltrrsltlnk">Filter Results</a>
                      <div id="toggleText" style="display: none">
                      
                     <!--Department Start-->
                     <?php foreach($facetmap as $facet_filter) {
                     	$test_facet_filter = $facet_filter->filter;
			foreach($test_facet_filter as $facet) {
			if((@$facet->link->name == 'EXACT') || ($facet == 'searchresults')){
			} else {?>
                      <div class="side-content margin-top">
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
								$count_pr = $filter->nr;
							}else{
							
								$url_fh = $filter->{"url-params"};
								$link_name = $filter->name;
								$count_pr = $facet->filtersection->nr;
							}
							$url_fh = str_replace('%2f','~',$url_fh);
	
							echo $html->link(@$link_name,$this->params['action'].'/'.$searchWord.'/&'.$url_fh,array('escape'=>false)); ?> <span>(<?php echo $count_pr; ?>)</span>
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
	// 						//echo $html->link(@$link_more_name,$this->params['action'].'/.'$searchWord.'/&'.$url_more_fh,array('escape'=>false,'class'=>'see-more')).'('.$count_more_pr.')';
	// echo $searchWord;				if(!empty($searchWord)){
	// 							echo $html->link($searchWord,$this->params['action'].'/.'$searchWord.'/&'.$pass_url,array('escape'=>false,'alert'=>''));
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
							
	
								if(!empty($url_more_fh) && !empty($link_more_name)) {
									$url_more_fh = str_replace('%2f','~',$url_more_fh);
									echo $html->link(@$link_more_name,$this->params['action'].'/'.$searchWord.'/&'.$url_more_fh,array('escape'=>false,'class'=>'see-more')); ?>
								<?php }
							
							?>
							</li>
					<?php } }
					}
					?>
				</ul>	
			</div>
			<?php }?>
		<?php } }
		?>
                     <!--Department Closed-->
                     
                     <!--Price Closed-->
                     </div>
                </section>

<?php ?>
<!--Filter Search Closed-->
