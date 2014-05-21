<?php if(!empty($results) && ($results['no_of_pages'] > 1) ) {
	$url_fh_paging = $results['url-params'];
	$url_fh_paging = str_replace('%2f','~',$url_fh_paging);
	
?>
<!--Sorting Start-->

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
					if(@$prev_page[0] < 2){
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
	
		<?php
                $new_search='';
                if(isset($searchWord)){
                 $new_search = '/'.$searchWord;
                }
                    if(!empty($prev_page)){
                        
                        $link_url =  $this->params['controller'].'/'.$this->params['action'].$new_search.'/&'.$url_fh_paging.'&fh_start_index='.($prev_page[0]-1)*$view_size.'&fh_view_size='.$view_size.'&';
                        echo "<link rel='prev' href='".SITE_URL.$link_url."'>";
                           
                    }
                    if(!empty($next_page)){ 
                            
                        $link_url_next = $this->params['controller'].'/'.$this->params['action'].'/'.$searchWord.'/&'.$url_fh_paging.'&fh_start_index='.($next_page[0]-1)*$view_size.'&fh_view_size='.$view_size.'&';
                        echo "<link rel='next' href='".SITE_URL.$link_url_next."'>";
                    }
                ?>
<!--Sorting Closed-->
<?php } ?>