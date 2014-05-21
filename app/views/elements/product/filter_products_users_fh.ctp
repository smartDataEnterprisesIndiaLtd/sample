<?php ?>
<!--Filter Search Start-->
<?php if(is_array($facetmap) && count($facetmap)>0){?>
<?php //Configure::write('debug',2);?>
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
			$multiselectarr = $facet->{'custom-fields'}->{'custom-field'};
			foreach($multiselectarr as $multiselectarr){
				if($multiselectarr->name == "Facet type"){
					$multiselect = $multiselectarr->_;
				}
			}
			?>
			<div class="side-content">
				<h4 class="orange-col-head help-topic-head"><span><?php echo @$facet->title; ?></span></h4>
				<ul class="filter-search">
					<?php if($multiselect != 'Multiselect'){
						if(!empty($facet->filtersection)) {
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
								$fvalue = $filter->value->_;
							}else{
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
								$fvalue = $facet->filtersection->value->_;
							}
							$url_fh = str_replace('%2f','~',$url_fh);
							//echo $html->link(@$link_name,$this->params['action'].'/keywords:'.$searchWord.'/dept_id:'.$department_id.'/sort_by:'.$sort.'/&'.$url_fh,array('escape'=>false)); ?> <!--<span>(<?php //echo $count_pr; ?>)</span>-->
							<?php $ftitle  = str_replace(" ","_",strtolower($facet->title));?>
							<?php echo $html->link(@$link_name,'javascript:void(0);',array('escape'=>false,'onclick'=>"change_url('".$ftitle."','".$fvalue."')")); ?> <span>(<?php echo $count_pr; ?>)</span>
							<?php 	//echo $form->hidden('Product.item_'.$facet->title,array('value'=>$facet->title,'div'=>false, 'label'=>false));
								//echo $form->hidden('Product.title_'.$filter->value->_,array('value'=>$filter->value->_,'div'=>false, 'label'=>false));
							?>
							</li>
							<?php
							}
						}
					}
				if(@$facet->title == "Minimum Price Seller"){
					
				echo $form->create('Products',array('action'=>'searchresult','method'=>'POST','name'=>'frmPages','id'=>'frmPages'));
					
				echo CURRENCY_SYMBOL .$form->input('Marketplace.price',array('value'=>@$this->data['Marketplace']['price'],'div'=>false, 'label'=>false, 'style'=>'width:35px;padding-bottom:2px;padding-top:2px;')).'&nbsp&nbsp';
					
				echo CURRENCY_SYMBOL . $form->input('Marketplace.price1',array('value'=>@$this->data['Marketplace']['price1'],'div'=>false, 'label'=>false, 'style'=>'width:35px;padding-bottom:2px;padding-top:2px;')).'&nbsp&nbsp';
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
									echo $html->link(@$link_more_name,$this->params['action'].'/keywords:'.$searchWord.'/dept_id:'.$department_id.'/sort_by:'.$sort.'/&'.$url_more_fh,array('escape'=>false,'class'=>'see-more')); ?>
								<?php }
							
							?>
							</li>
					<?php } }
					}
					//Start of Multiselect
					}else{
						if(!empty($facet->filtersection)) {
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
								$fvalue = $filter->value->_;
							}else{
								$url_fh = $filter->{"url-params"};
								$link_name = $filter->name;
								$count_pr = $facet->filtersection->nr;
								$fvalue = $facet->filtersection->value->_;
							}
							$url_fh = str_replace('%2f','~',$url_fh);
							$ftitle  = str_replace(" ","_",strtolower($facet->title));
							//echo '<input type="checkbox" name="Multiselect" class="checkbox" onclick = "change_url()" />&nbsp';
							//echo $html->link(@$link_name,$this->params['action'].'/keywords:'.$searchWord.'/dept_id:'.$department_id.'/sort_by:'.$sort.'/&'.$url_fh,array('escape'=>false)); ?> <!--<span>(<?php //echo $count_pr; ?>)</span>-->
							<?php
								//echo '<input type="checkbox" name="Multiselect[]" id="Multiselect[]" class="checkbox" value = '.$fvalue.' onclick = "change_url()" />&nbsp';
								//multiselect
								if(!empty($multiselectArr)){
								$multiArr = explode(',',$multiselectArr);
								if(is_array($multiArr)){
									foreach($multiArr as $multiArr){
										if($multiArr == $fvalue){
											$checked = "checked";
										}
									}
								}
								}else{
									$checked = "";
								}
								echo $this->Form->checkbox('Multiselect[]', array('value' => $fvalue, 'class'=>"checkbox",$checked=>$checked , 'onclick'=>'get_brand("'.$ftitle.'")'));
								echo $html->link(@$link_name,'javascript:void(0);',array('escape'=>false)); ?> <span>(<?php echo $count_pr; ?>)</span>
								<?php $checked = "";?>
							</li>
							<?php
							}
						}
					}
				if(@$facet->title == "Minimum Price Seller"){
					
					echo $form->create('Products',array('action'=>'searchresult/keywords:'.$searchWord.'/dept_id:'.$department_id.'/sort_by:'.$sort,'method'=>'POST','name'=>'frmPages','id'=>'frmPages'));
					
					echo CURRENCY_SYMBOL .$form->input('Marketplace.price',array('value'=>@$this->data['Marketplace']['price'],'div'=>false, 'label'=>false, 'style'=>'width:35px;padding-bottom:2px;padding-top:2px;')).'&nbsp&nbsp';
					
					echo CURRENCY_SYMBOL . $form->input('Marketplace.price1',array('value'=>@$this->data['Marketplace']['price1'],'div'=>false, 'label'=>false, 'style'=>'width:35px;padding-bottom:2px;padding-top:2px;')).'&nbsp&nbsp';
					
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
									echo $html->link(@$link_more_name,$this->params['action'].'/keywords:'.$searchWord.'/dept_id:'.$department_id.'/sort_by:'.$sort.'/&'.$url_more_fh,array('escape'=>false,'class'=>'see-more')); ?>
								<?php }
							
							?>
							</li>
					<?php } }
					}
					//End of Multiselect
						
					}
					
				?>
				</ul>	
			</div>
			<?php }?>
		<?php }
		?>
	</div>
	<!-- White Box Closed-->
</div>
<?php 
	} }
	
	//pr($breadcrumbs);
	/*foreach($breadcrumbs as $breadcrumb){
		//if($breadcrumb->)
	}*/
	//echo $form->hidden('url_fh1',array('value'=>$url_fh1,'div'=>false, 'label'=>false));
	$url_fh = "";
	foreach($breadcrumbs['crumb'] as $bread){
		if($bread->name->type == 'facet' && !empty($bread->name->type)){
			$bread->name->{'attribute-type'};
			$bread->name->{'value'};
			/*foreach($bread->name as $bread_name){
				pr($bread_name);
			}*/
			if(!empty($url_fh)){
				if($bread->name->{'attribute-type'} == "minimum_price"){
					$price_fh = explode('-',$bread->name->_);
					$price_fh0 =  preg_replace ('/[^0-9.]+/i', '' ,$price_fh[0]);
					$price_fh1 =  preg_replace ('/[^0-9.]+/i', '' ,$price_fh[1]);
					$url_fh = $url_fh.'-'.$price_fh0.'%3Cminimum_price%3C'.$price_fh1;
					//$url_fh = Sanitize::clean($url_fh);
				}else{
					$url_fh = $url_fh.'-'.$bread->name->{'attribute-type'}.'='.$bread->name->{'value'};
				}
			}else{
				if($bread->name->{'attribute-type'} == "minimum_price"){
					$price_fh = explode('-',$bread->name->_);
					//echo $price_fh0 =  preg_replace ('/[^a-z^0-9.&\ ]+/i', '' ,$price_fh[0]);
					$price_fh0 =  preg_replace ('/[^0-9.]+/i', '' ,$price_fh[0]);
					$price_fh1 =  preg_replace ('/[^0-9.]+/i', '' ,$price_fh[1]);
					$url_fh = $price_fh0.'%3Cminimum_price%3C'.$price_fh1;
					//$url_fh = Sanitize::clean($url_fh);
				}else{
					$url_fh = $bread->name->{'attribute-type'}.'='.$bread->name->{'value'};
				}
			}
		}
		
	}
	//echo $url_fh;
	echo $form->hidden('url_fh',array('value'=>$url_fh,'div'=>false, 'label'=>false));
	//exit;
	
	}//end of If condition
	
	
	
	
	
		?>
<!--Filter Search Closed-->


<script type="text/javascript">

jQuery('#frmPages').submit(function() {
	  
		var search_keywords = jQuery('#search_keywords').val();
		var department_id = jQuery('#MarketplaceDepartment').val();
		var product_sort = jQuery('#ProductSort').val();
		var Price = jQuery('#MarketplacePrice').val();
		var Price1 = jQuery('#MarketplacePrice1').val();
		var url_fh = jQuery('#url_fh').val();
		var fvalue = Price+"%253Cminimum_price<"+Price1;
		var urls= "<?php echo SITE_URL;?>products/searchresult/";
		if((search_keywords != "")){
			urls= urls = urls+'keywords:'+search_keywords;
		if((department_id != "")){
			urls = urls+"/dept_id:"+department_id;
		}
		if((product_sort != "")){
			urls = urls+"/sort_by:"+product_sort;
		}
		if((url_fh != "")){
			urls = urls+"/fh_loc:"+url_fh;
		}
		if((fvalue != "")){
			urls = urls+"/fvalue:"+fvalue;
		}
		if((Price != "")){
			urls = urls+"/ftitle:price";
		}
		}
		window.location.href = encodeURI(urls);
		return false;
	 
});

	function change_url(ftitle,fvalue){
		//var product_sort = sort_val;
		var search_keywords = jQuery('#search_keywords').val();
		var department_id = jQuery('#MarketplaceDepartment').val();
		var product_sort = jQuery('#ProductSort').val();
		var url_fh = jQuery('#url_fh').val();
		var urls= "<?php echo SITE_URL;?>products/searchresult/";
		if((search_keywords != "")){
			urls= urls = urls+'keywords:'+search_keywords;
		if((department_id != "")){
			urls = urls+"/dept_id:"+department_id;
		}
		if((product_sort != "")){
			urls = urls+"/sort_by:"+product_sort;
		}
		if((url_fh != "")){
			urls = urls+"/fh_loc:"+url_fh;
		}
		if((ftitle != "")){
			urls = urls+"/ftitle:"+ftitle;
		}
		if((fvalue != "")){
			urls = urls+"/fvalue:"+fvalue.replace("<","%3C");
		}
		//alert(urls);
		/*if((fvalue != "")){
		str.replace("Microsoft","W3Schools"); 
			urls = urls+"preview_advanced=true&fh_view_size=25&fh_sort_by= null&fh_refview=search&fh_refpath=facet_8&fh_reffacet=department_name&fh_location=/catalog01/en_GB/";
			//urls = urls+"&fh_location=//catalog01/en_GB/$s="+search_keywords+"&fh_eds=ß;
		}
		/*if((fvalue != "")){
			urls = urls+"/&preview_advanced=true&fh_view_size=25&fh_refview=search&fh_refpath=facet_8&fh_reffacet=department_name&fh_location=~~catalog01~en_GB~$s="+search_keywords+";
			//urls = urls+"&fh_location=//catalog01/en_GB/$s="+search_keywords+"&fh_eds=ß;
		}*/
		 
		}
		window.location.href = encodeURI(urls);
		return false;
	}
	function get_brand(ftitle){
		var values = new Array();
			jQuery.each(jQuery("input[name='data[Multiselect[]]']:checked"), function() {
			values.push(jQuery(this).val());
			});
		var search_keywords = jQuery('#search_keywords').val();
		var department_id = jQuery('#MarketplaceDepartment').val();
		var product_sort = jQuery('#ProductSort').val();
		var url_fh = jQuery('#url_fh').val();
		var urls= "<?php echo SITE_URL;?>products/searchresult/";
		if((search_keywords != "")){
			urls= urls = urls+'keywords:'+search_keywords;
		if((department_id != "")){
			urls = urls+"/dept_id:"+department_id;
		}
		if((product_sort != "")){
			urls = urls+"/sort_by:"+product_sort;
		}
		/*if((url_fh != "")){
			urls = urls+"/fh_loc:"+url_fh;
		}*/
		if((ftitle != "")){
			urls = urls+"/ftitle:"+ftitle;
		}
		if((values != "")){
			urls = urls+"/fvalue:"+values;
		}
		if((values != "")){
			urls = urls+"/Multiselect:Multiselect";
		}
		}
		//alert(urls);
		window.location.href = encodeURI(urls);
		return false;
	}
</script>