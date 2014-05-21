<?php if($this->params['action'] == 'search_results'){
	$paging_class = ' box-margin-right';
} else{
	$paging_class ='';
}
if(!empty($results) && ($results['no_of_pages'] > 1) ) {
	$url_fh_paging = $results['url-params'];
	$url_fh_paging = str_replace('%2f','~',$url_fh_paging);
	$start_prods = $results['start_index'];
	$view_size = $results['view_size'];

?>
<div class="sorting-widget blusrtng">
	<?php
	$start_prods = ($start_prods + 1);
	$end_produ = ($start_prods-1) + $view_size; 
		if(empty($total_pages)){
		?>
	<div class="showing-widget">Showing <?php echo $start_prods; ?>-<?php echo $end_produ?> of <?php echo $total_records; ?> results</div>
	<?php }?>
	<!--<div class="sort-by">Sort by:
	<select name="select2" class="select">
	<option>Relevance</option>
	</select>
	</div>-->
	<div class="clear"></div>
</div>
<!--Paging Widget Closed-->
<?php } ?>