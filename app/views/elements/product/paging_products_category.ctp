<?php if(!empty($results) && ($results['no_of_pages'] > 1) ) {
	$url_fh_paging = $results['url-params'];
	$url_fh_paging = str_replace('%2f','~',$url_fh_paging);
?>
<!--Sorting Start-->
<div class="border-top">
<div class="paging">
	<ul>
		<?php
		$last_pr_sh_page = 0; $last_nx_sh_page = 0;
		if($results['current_set'] > 1){
			
			$prev_page[] = $results['current_set'] - 1;
			if(!empty($prev_page[0])) {
				$last_pr_sh_page = $prev_page[0];
				if($prev_page[0] > 1){
					$prev_page[] = $prev_page[0] - 1;
				}
			}
			if(!empty($prev_page[1])) {
				$last_pr_sh_page = $prev_page[1];
				if($prev_page[1] > 1){
					//$prev_page[] = $prev_page[1] - 1;
					if(!empty($prev_page[2])){
						$last_pr_sh_page = $prev_page[2];
					}
				}
			}
		}
		if(!empty($prev_page))
			asort($prev_page);

		if($results['current_set'] < $results['no_of_pages']){
			$next_page[] = $results['current_set'] + 1;
			if(!empty($next_page[0])) {
				$last_nx_sh_page = $next_page[0];
				if($next_page[0] < $results['no_of_pages']){
					$next_page[] = $next_page[0] + 1;
				}
			}
			if(!empty($next_page[1])) {
				$last_nx_sh_page = $next_page[1];
				if($next_page[1] < $results['no_of_pages']){
					if($prev_page[0] < 2){
					$next_page[] = $next_page[1] + 1;
					}
					if(!empty($next_page[2])) {
						$last_nx_sh_page = $next_page[2];
					}
				}
			}
		}
		if(!empty($next_page))
			asort($next_page);

		$not_shown_pages = 0; $not_shown_pages_prev =0; 
		$not_shown_pages = $results['no_of_pages'] - $last_nx_sh_page;
		$not_shown_pages_prev = $last_pr_sh_page - 1;
		?>
		<!--li><strong>Page: </strong></li-->
		<?php if(!empty($prev_page)){ ?>
			<!--li><?php //echo $html->link('First',$this->params['action'].'/'.$selected_category.'/'.$department_id.'/'.'&'.$url_fh_paging.'&fh_start_index=0&fh_view_size='.$view_size,array('escape'=>false,'class'=>'active')); ?></li-->
			<li><?php echo $html->link('Prev',$this->params['action'].'/'.$selected_category.'/'.$department_id.'/'.'&'.$url_fh_paging.'&fh_start_index='.((($results['current_set']-1) * $view_size) - $view_size ).'&fh_view_size='.$view_size.'&',array('escape'=>false,'class'=>'active')); ?></li>
			<?php if(!empty($not_shown_pages_prev) && $not_shown_pages_prev > 0) { ?>
				<!--li>...</li-->
			<?php }?>
			<?php foreach($prev_page as $pre_p){ ?>
				<li><?php echo $html->link($pre_p,$this->params['action'].'/'.$selected_category.'/'.$department_id.'/'.'&'.$url_fh_paging.'&fh_start_index='.($pre_p-1)*$view_size.'&fh_view_size='.$view_size.'&',array('escape'=>false,'class'=>'active')); ?></li>
			<?php }
		}?>
		<?php if(!empty($results['current_set'])) { ?>
			<li class="action"><?php echo $results['current_set']; ?></li>
		<?php }?>
		<?php if(!empty($next_page)){ ?>
			<?php foreach($next_page as $next_p){ ?>
				<li><?php echo $html->link($next_p,$this->params['action'].'/'.$selected_category.'/'.$department_id.'/'.'&'.$url_fh_paging.'&fh_start_index='.($next_p-1)*$view_size.'&fh_view_size='.$view_size.'&',array('escape'=>false,'class'=>'active')); ?></li>
			<?php } ?>
			<li><?php echo $html->link('Next',$this->params['action'].'/'.$selected_category.'/'.$department_id.'/'.'&'.$url_fh_paging.'&fh_start_index='.($results['current_set'] * $view_size).'&fh_view_size='.$view_size.'&',array('escape'=>false,'class'=>'active')); ?></li>
			<?php if(!empty($not_shown_pages) && $not_shown_pages > 0) { ?>
				<!--li>...</li-->
			<?php }?>
			<!--li><?php //echo $html->link('Last',$this->params['action'].'/'.$selected_category.'/'.$department_id.'/'.'&'.$url_fh_paging.'&fh_start_index='.$results['last_page_starts'].'&fh_view_size='.$view_size.'&',array('escape'=>false,'class'=>'active')); ?></li-->
		<?php }?>
	</ul>
	<div class="clear"></div>
</div>
</div>
<!--Sorting Closed-->
<?php } ?>