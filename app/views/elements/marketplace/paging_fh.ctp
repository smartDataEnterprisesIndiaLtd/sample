<?php if($this->params['action'] == 'search_results'){
	$paging_class = ' box-margin-right';
} else{
	$paging_class ='';
}
if(!empty($results) && ($results['no_of_pages']>1)) {
	$url_fh_paging = $results['url-params'];
	$url_fh_paging = str_replace('%2f','~',$url_fh_paging);
      
?>

<style>
.paging{
	padding: 0;
}
</style>

<div class="search-paging <?php echo $paging_class;?>">
	<ul>
		<?php
		$end_produ = $start_prods-1 + $view_size;
		if($total_records < $end_produ){
			$end_produ = $total_records;
		}
		
		if(empty($total_pages)){
		?>
		<li>Products <strong><?php echo $start_prods; ?></strong> to <strong><?php echo $end_produ?></strong> of <strong><?php echo $total_records; ?></strong></li>
		<?php }?>
		<?php echo $form->create('Marketplace',array('action'=>$go_action,'method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace')); ?>
		<li class="paging-sec" style="float:right;">
			<span style="float: left;">
			<strong>Go to Page:</strong> 
			<?php 
				echo $form->input('Page.goto_page',array('class'=>'form-textfield num-width','label'=>false,'div'=>false, 'value'=>''));
				echo $form->hidden('Page.search_product_name',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$search_word));
				echo $form->hidden('Page.go_url',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$url_fh_paging.'&fh_start_index=0&fh_view_size='.$view_size));
				echo $form->submit('',array('alt'=>'Search','type'=>'image','src'=>SITE_URL.'/img/go-grn-btn.gif','border'=>'0', "value"=>"search",'class'=>'v-align-middle','div'=>false));?>
			</span>
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
			<?php if(empty($total_pages)){ ?>
			<!--span class="padding-left"><strong>Page: </strong></span-->
			<div class="paging">
				<ul class="overflow-h">
			<!--li><strong>Page: </strong></li-->
		<?php if(!empty($prev_page)){ ?>
			<!--li><?php //echo $html->link('First',$this->params['action'].'/'.$selected_category.'/'.$department_id.'/'.'&'.$url_fh_paging.'&fh_start_index=0&fh_view_size='.$view_size,array('escape'=>false,'class'=>'active')); ?></li-->
			<li><?php echo $html->link('Prev',$this->params['action'].'/'.$search_word.'/&'.$url_fh_paging.'&fh_start_index='.((($results['current_set']-1) * $view_size) - $view_size ).'&fh_view_size='.$view_size,array('escape'=>false,'class'=>'active')); ?></li>
			<?php if(!empty($not_shown_pages_prev) && $not_shown_pages_prev > 0) { ?>
				<!--li>...</li-->
			<?php }?>
			<?php foreach($prev_page as $pre_p){ ?>
				<li><?php echo $html->link($pre_p,$this->params['action'].'/'.$search_word.'/&'.$url_fh_paging.'&fh_start_index='.($pre_p-1)*$view_size.'&fh_view_size='.$view_size.'&',array('escape'=>false,'class'=>'active')); ?></li>
			<?php }
			}?>
			<?php if(!empty($results['current_set'])) { ?>
				<li class="action"><?php echo $results['current_set']; ?></li>
			<?php }?>
			<?php if(!empty($next_page)){ ?>
				<?php foreach($next_page as $next_p){ ?>
					<li><?php echo $html->link($next_p,$this->params['action'].'/'.$search_word.'/&'.$url_fh_paging.'&fh_start_index='.($next_p-1)*$view_size.'&fh_view_size='.$view_size.'&',array('escape'=>false,'class'=>'active')); ?></li>
				<?php } ?>
				<li><?php echo $html->link('Next',$this->params['action'].'/'.$search_word.'/&'.$url_fh_paging.'&fh_start_index='.($results['current_set'])*$view_size.'&fh_view_size='.$view_size.'&',array('escape'=>false,'class'=>'active')); ?></li>
				<?php if(!empty($not_shown_pages) && $not_shown_pages > 0) { ?>
					<!--li>...</li-->
				<?php }?>
				<!--li><?php //echo $html->link('Last',$this->params['action'].'/'.$selected_category.'/'.$department_id.'/'.'&'.$url_fh_paging.'&fh_start_index='.$results['last_page_starts'].'&fh_view_size='.$view_size.'&',array('escape'=>false,'class'=>'active')); ?></li-->
			<?php }?>
			<?php }?>
			</ul>
			</div>
		</li>
		<?php echo $form->end(); ?>
	</ul>
</div>
<!--Paging Widget Closed-->
<?php } ?>