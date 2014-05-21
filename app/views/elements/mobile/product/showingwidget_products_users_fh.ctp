<?php if(!empty($results)){ ?>
<?php 
$controller = $this->params['controller'];
$action = $this->params['action'];
if($controller == 'products' && $action=='searchresult'){
	$show = 'results';
}else{
	$show = 'Products';
}

?>

<div class="showing-widget" style="width:100%">
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
	}
	$results['total_items'] = number_format ($results['total_items']);
	
	?>
	Showing <span id="from_id"></span><?php echo $start_records.' - '.$end_records; ?><span id="to_id"></span> of <?php echo $results['total_items']; ?> <?php echo $show;?>
</div>
<?php }?>
