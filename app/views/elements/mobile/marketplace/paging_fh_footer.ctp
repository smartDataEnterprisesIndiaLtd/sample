<?php if($this->params['action'] == 'search_results'){
	$paging_class = ' box-margin-right';
} else{
	$paging_class ='';
}
if(!empty($results) && ($results['no_of_pages'] > 1) ) {
	$url_fh_paging = $results['url-params'];
	$url_fh_paging = str_replace('%2f','~',$url_fh_paging);
	
?>
<section class="pagiarea">

<!--Showing Products Starts-->
<!--<ul class="showngprdcts">
	<li>Show<select><option>10</option></select> Products</li>
</ul>-->
		<?php
			$last_pr_sh_page = 0; $last_nx_sh_page = 0;
			if($results['current_set'] > 1){
				$prev_page[] = $results['current_set'] - 1;
				/*if(!empty($prev_page[0])) {
					$last_pr_sh_page = $prev_page[0];
					if($prev_page[0] > 1){
						$prev_page[] = $prev_page[0] - 1;
					}
				}*/
				if(!empty($prev_page[1])) {
					$last_pr_sh_page = $prev_page[1];
					if($prev_page[1] > 1){
						$prev_page[] = $prev_page[1] - 1;
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
				/*if(!empty($next_page[0])) {
					$last_nx_sh_page = $next_page[0];
					if($next_page[0] < $results['no_of_pages']){
						$next_page[] = $next_page[0] + 1;
					}
				}*/
				if(!empty($next_page[1])) {
					$last_nx_sh_page = $next_page[1];
					if($next_page[1] < $results['no_of_pages']){
						$next_page[] = $next_page[1] + 1;
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
			
			$target_page_url = "/".ltrim($_SERVER['REQUEST_URI'], "/");
			
			?>
<form name="frmRecordsPages" action="<?php echo $target_page_url; ?>" method="post" >
<ul class="showngprdcts">
        <li>Show
                    <?php  echo $form->select('Record.limit',array('10'=>'10','15'=>'15','20'=>'20','25'=>'25','50'=>'50','100'=>'100','200'=>'200'),$view_size,array('type'=>'select','onChange'=>'this.form.submit()', 'class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1,'style'=>'width:60px'));
			if(!empty($pass_url)){
				echo $form->hidden('Record.pass_url_value',array('value'=>base64_encode($pass_url)));
			}
			if(!empty($search_word)){
				echo $form->hidden('Marketplace.search_product_name',array('value'=>$search_word));
			}?>
		Products
	</li>
</ul>
<?php echo $form->end();?>

<!--Showing Products Starts-->

<!--Pagination Start-->
<div class="paging margin-right">
	<ul>
		<?php if(empty($total_pages)){ ?>
		<?php if(!empty($prev_page)){ ?>
			<li><?php echo $html->link('Prev',$this->params['action'].'/'.$search_word.'/&'.$url_fh_paging.'&fh_start_index='.((($results['current_set']-1) * $view_size) - $view_size ).'&fh_view_size='.$view_size.'&',array('escape'=>false)); ?></li> 
		<?php 
			foreach($prev_page as $pre_p){ ?>
				<li><?php echo $html->link($pre_p,$this->params['action'].'/'.$search_word.'&'.$url_fh_paging.'&fh_start_index='.($pre_p-1)*$view_size.'&fh_view_size='.$view_size.'&',array('escape'=>false)); ?></li>
			<?php }
		}
		if(!empty($results['current_set'])) { ?>
			<li>	<a href = "#" class="current">
					<?php echo $results['current_set']; ?>
				</a>
			</li>
		<?php }
		if(!empty($next_page)){
			foreach($next_page as $next_p){ ?>
				<li><?php echo $html->link($next_p,$this->params['action'].'/'.$search_word.'&'.$url_fh_paging.'&fh_start_index='.($next_p-1)*$view_size.'&fh_view_size='.$view_size.'&',array('escape'=>false)); ?></li>
			<?php }	?>
			
			<li><?php echo $html->link('Next',$this->params['action'].'/'.$search_word.'/&'.$url_fh_paging.'&fh_start_index='.($results['current_set'] * $view_size).'&fh_view_size='.$view_size.'&',array('escape'=>false)); ?></li>
		<?php }?>
		<?php } ?>
	</ul>
	<div class="clear"></div>
</div>
<!--Pagination Closed-->
</section>
<?php }?>