<?php ?>
<!--Filter Search Start-->
<?php if(is_array($facetmap) && count($facetmap)>0){?>
<?php //Configure::write('debug',2); ?>
<?php foreach($facetmap as $facet_filter) {
if(is_array(@$facet_filter->filter) && !empty($facet_filter->filter)){?>
<div class="side-content">
	<!--Right Box Start-->
	<div class="wt-top-widget"></div>
	<!-- White Box Start-->
	<div class="white-box">
		<?php $test_facet_filter = $facet_filter->filter;
		foreach($test_facet_filter as $facet) {
			
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
								if($facet->title != "Average Rating"){
									$link_name = $filter->link->name;
								}else{
									$link_name = $filter->link->name;
									$link_name=$common->displayProductRatingYellowSearchPage($link_name);
								}
								$count_pr = $filter->nr;
							}else{
								$url_fh = $filter->{"url-params"};
								$link_name = $filter->name;
								$count_pr = $facet->filtersection->nr;
							}
							$url_fh = str_replace('%2f','~',$url_fh);
							
							//echo $html->link(@$link_name,$this->params['action'].'/keywords:'.$searchWord.'/dept_id:'.$department_id.'/sort_by:'.$sort.'/&'.$url_fh,array('escape'=>false)); ?> <!--<span>(<?php echo $count_pr; ?>)</span>-->
							<?php echo $html->link(@$link_name,'javascript:void(0);',array('escape'=>false,'onclick'=>'change_url()')); ?> <span>(<?php echo $count_pr; ?>)</span>
							
							<?php 	echo $form->hidden('Product.shotItem_'.$facet->title,array('value'=>$facet->title,'div'=>false, 'label'=>false));
								echo $form->hidden('Product.title_'.$filter->value->_,array('value'=>$filter->value->_,'div'=>false, 'label'=>false));
							?>
							
							</li>
							<?php
							}
						}
					}
				if(@$facet->title == "Price"){
					
				echo $form->create('Products',array('action'=>'searchresult/keywords:'.$searchWord.'/dept_id:'.$department_id.'/sort_by:'.$sort,'method'=>'POST','name'=>'frmPages','id'=>'frmPages'));
				
				echo CURRENCY_SYMBOL .$form->input('Marketplace.price',array('value'=>@$this->data['Marketplace']['price'],'div'=>false, 'label'=>false, 'style'=>'width:35px;padding-bottom:2px;padding-top:2px;')).'&nbsp&nbsp';
				
				echo CURRENCY_SYMBOL . $form->input('Marketplace.price1',array('value'=>@$this->data['Marketplace']['price1'],'div'=>false, 'label'=>false, 'style'=>'width:35px;padding-bottom:2px;padding-top:2px;')).'&nbsp&nbsp';
				
				//echo $form->hidden('Marketplace.keywords',array('value'=>$searchWord,'div'=>false, 'label'=>false));
				//echo $form->hidden('Marketplace.department',array('value'=>$department_id,'div'=>false, 'label'=>false));
				//echo $form->hidden('Product.sort',array('value'=>$sort,'div'=>false, 'label'=>false));
				
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
									echo $html->link(@$link_more_name,$this->params['action'].'/keywords:'.$searchWord.'/dept_id:'.$department_id.'/sort_by:'.$sort.'/&'.$url_more_fh,array('escape'=>false,'class'=>'see-more')); ?>
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
		


		<!--Brand Start-->	
		<!--<div class="side-content">
			<h4 class="orange-col-head help-topic-head"><span>Brand</span></h4>
			<ul class="filter-search">
				<li><input type="checkbox" name="checkbox" class="checkbox" /> LG Electronics <span>(20)</span></li>
				<li><input type="checkbox" name="checkbox" class="checkbox" /> 
				Pansonic <span>(4)</span></li>
				<li class="selected"><input type="checkbox" name="checkbox" class="checkbox" /> Toshiba4</li>
				<li><input type="checkbox" name="checkbox" class="checkbox" /> 
				Samsung <span>(19)</span></li>
				<li class="selected"><input type="checkbox" name="checkbox" class="checkbox" /> Sony</li>
				<li><input type="checkbox" name="checkbox" class="checkbox" /> 
				Philips <span>(21)</span></li>
				<li><input type="checkbox" name="checkbox" class="checkbox" /> 
				Daewoo <span>(2)</span></li>
				<li class="padding-left margin-top"><a href="#" class="see-more">See More','#',array('escape'=>false)); ?></li>
			</ul>	
		</div>-->
		<!--Brand Closed-->
		<!--Avg. Customer Review Start-->
		<!--<div class="side-content">
			<h4 class="orange-col-head help-topic-head"><span>Avg. Customer Review</span></h4>
			<ul class="filter-search">
				<li><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/gray-star-rating.png" width="12" height="12" alt="" /> <?php //echo $html->link('&amp; Up','#',array('escape'=>false)); ?> <span>(25)</span></li>
				<li><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/gray-star-rating.png" width="12" height="12" alt="" /><img src="images/gray-star-rating.png" width="12" height="12" alt="" /> <?php //echo $html->link('&amp; Up','#',array('escape'=>false)); ?> <span>(26)</span></li>
				<li><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/gray-star-rating.png" width="12" height="12" alt="" /><img src="images/gray-star-rating.png" width="12" height="12" alt="" /><img src="images/gray-star-rating.png" width="12" height="12" alt="" /> <?php //echo $html->link('&amp; Up','#',array('escape'=>false)); ?> <span>(26)</span></li>
				<li><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/gray-star-rating.png" width="12" height="12" alt="" /><img src="images/gray-star-rating.png" width="12" height="12" alt="" /><img src="images/gray-star-rating.png" width="12" height="12" alt="" /><img src="images/gray-star-rating.png" width="12" height="12" alt="" /> <?php //echo $html->link('&amp; Up','#',array('escape'=>false)); ?> <span>(26)</span></li>
			</ul>
		</div>-->
		<!--Avg. Customer Review Closed-->
		<!--Price Start-->
		<!--<div class="side-content">
			<h4 class="orange-col-head help-topic-head"><span>Price</span></h4>
			<p><strong>Any Price</strong></p>
			<ul class="filter-search">
				<li><?php //echo $html->link('&pound;0 - &pound;5','#',array('escape'=>false)); ?> <span>(20)</span></li>
				<li><?php //echo $html->link('&pound;5 - &pound;10','#',array('escape'=>false)); ?> <span>(20)</span></li>
				<li><?php //echo $html->link('&pound;10 - &pound;20','#',array('escape'=>false)); ?> <span>(20)</span></li>
				<li><?php //echo $html->link('&pound;20 - &pound;50','#',array('escape'=>false)); ?> <span>(20)</span></li>
				<li><?php //echo $html->link('&pound;50 - &pound;100','#',array('escape'=>false)); ?> <span>(75)</span></li>
				<li><?php //echo $html->link('&pound;100 - &pound;200','#',array('escape'=>false)); ?> <span>(71)</span></li>
				<li><?php //echo $html->link('&pound;200 - &pound;500','#',array('escape'=>false)); ?> <span>(1)</span></li>
				<li><?php //echo $html->link('over 500','#',array('escape'=>false)); ?> <span>(42)</span></li>
			</ul>
			<p class="to-from">&pound;
				<input type="text" name="textfield2" class="textfield" style="width:30px; padding-left:3px;" /> to &pound;
				<input type="text" name="textfield2" class="textfield" style="width:30px; padding-left:3px;" /> 
				<input type="submit" name="button2" value=" " class="go-btn" />
			</p>	
		</div>-->
		<!--Price Closed-->
		<!--Seller Start--><!--	
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head"><span>Seller</span></h4>
			<ul class="filter-search">
				<li><input type="checkbox" name="checkbox" class="checkbox" /> 
				TechnicsPro24 <span>(14)</span></li>
				<li><input type="checkbox" name="checkbox" class="checkbox" /> 
				Entertainment Xclusive  <span>(11)</span></li>
				<li><input type="checkbox" name="checkbox" class="checkbox" /> warehouse deals uk <span>(11)</span></li>
				<li><input type="checkbox" name="checkbox" class="checkbox" /> 
				Amazon.co.uk <span>(7)</span></li>
				<li><input type="checkbox" name="checkbox" class="checkbox" /> Reliant Direct <span>(7)</span></li>
				<li><input type="checkbox" name="checkbox" class="checkbox" /> 
				Hyper-Fi <span>(4)</span></li>
				<li><input type="checkbox" name="checkbox" class="checkbox" /> 
				TVS4U <span>(4)</span></li>
				<li class="padding-left margin-top"><?php echo $html->link('See More','#',array('escape'=>false,'class'=>'see-more')); ?></li>
			</ul>	
		</div>-->
		<!--Seller Closed-->
	</div>
	<!-- White Box Closed-->
</div>
<?php 
		} }
		}//end of If condition
		?>
<script type="text/javascript">
	function change_url(){
		//var product_sort = sort_val;
		var search_keywords = jQuery('#search_keywords').val();
		var department_id = jQuery('#MarketplaceDepartment').val();
		var product_sort = jQuery('#ProductSort').val();
		
		//var facetmap = '<?php echo json_encode($facetmap);?>';
		//var test = eval(facetmap);
		//alert(test.result);
		
		var urls= "<?php echo SITE_URL;?>products/searchresult/";
		if((search_keywords != "")){
			urls= urls = urls+'keywords:'+search_keywords;
		if((department_id != "")){
			urls = urls+"/dept_id:"+department_id;
		}
		if((product_sort != "")){
			urls = urls+"/sort_by:"+product_sort;
		}
		}
		window.location.href = urls;
		return false;
	}
</script>

<!--Filter Search Closed-->