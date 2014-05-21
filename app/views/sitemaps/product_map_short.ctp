<!--mid Content Start-->
            <div class="mid-content padding_left0 pad-rt-none page_min_height">
                <div class="breadcrumb-widget">
		
		<?php
		
				/*$this->Html->addCrumb('Home', '/');
				$this->Html->addCrumb('Sitemap', '/sitemaps/sitemap');
				$this->Html->addCrumb('Product Map', '/sitemaps/product_map');
				$this->Html->addCrumb($department_name, '/sitemaps/product_map_topcategories/'.$this->params['pass'][0]);
				
		       
				$this->Html->addCrumb("<span>".$selected_category_name."</span>", "");
				echo $this->Html->getCrumbs(' &gt ' , '');*/
				echo $strBreadcrumb;
			?>
		</div>
		
                <div class="row-widget">
			
                	<ul>
			 <?php
		   /* if(isset($parentCategoryArr)  &&  is_array($parentCategoryArr)  ) {
		       $i = 0;
		       $par_parent_id = '';
		       foreach($parentCategoryArr as $par_cat_id => $par_cat_name) {
			       $i++;
			       $cat_url=$dept_name.'/'.str_replace(array('&','/',' '), array('and','/','-'), $par_cat_name);
			       if($i == 1) {
				       $close_url = "/".$dept_name."/departments/index/".$selected_department;
			       } else {
				       $close_url = "/".$cat_url."/categories/index/".$par_parent_id;
			       }
			       echo '<li>';
			       $cat_url=$dept_name.'/'.str_replace(array('&','/',' '), array('and','/','-'), $par_cat_name);
			       echo $html->link('<span><strong>'.$par_cat_name.' </strong></span>',"/".$cat_url."/categories/index/".$par_cat_id ,array('escape'=>false));?>
			       <?php echo $html->link( $html->image('cross-icon.gif', array('width'=>11, 'height'=>11 ,'alt'=>'close') ), $close_url ,array('class'=>'cross', 'escape'=>false));?>
			       <?php echo '</li>';
			       $par_parent_id = $par_cat_id;
		        }
		}	*/
		if(isset($childCategoryArr)  &&  is_array($childCategoryArr) ) {
			App::import('Model','Category');
			$this->Category = &new Category;
			foreach($childCategoryArr as $cat_id=>$cat_name){
				$childCatCount =  $this->Category->getChildCount($cat_id);
				$cat_url_child =  '/'.str_replace(array('&','/',' '), array('and','-','-'), $cat_name);
				if($childCatCount > 0){
					$cat_page_url = "/sitemaps/product_map_short/".$this->params['pass'][0].'/'.$cat_id;
				}else{
					
					$cat_page_url = "/sitemaps/product_map_name/".$this->params['pass'][0].'/'.'/'.$this->params['pass'][1].'/'.$cat_id;
				}				
				echo '<li>';
				echo $html->link($cat_name,$cat_page_url ,array('escape'=>false ));
				echo '</li>';
			}
		} else{
			
			echo '';
		}
		?>
                    </ul>
                </div>
            </div>
            <!--mid Content Closed-->
	

                 