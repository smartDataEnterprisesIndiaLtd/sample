<?php if(!empty($results)){ ?><div class="showing-widget">
	<?php
		$end_records = '';
		$start_records = '';
		if(!empty($results)){
		if(!empty($results['current_set'])) {
			$start_records = ($results['current_set'] - 1) * $view_size + 1;
			$end_records = $results['current_set'] * $view_size;
			if($results['current_set'] == $results['no_of_pages'])
				$end_records = $results['total_items'];
		}
	}?>
	Showing <span id="from_id"></span><?php echo $start_records.' - '.$end_records; ?><span id="to_id"></span> of <?php echo $results['total_items']; ?> Products
</div>
<?php }?>
