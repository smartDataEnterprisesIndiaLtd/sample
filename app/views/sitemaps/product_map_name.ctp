<?php
App::import('Model','Department');
$Department = & new Department();		

?>


<!--mid Content Start-->
            <div class="mid-content padding_left0 pad-rt-none page_min_height" >
                <div class="breadcrumb-widget">
		
		<?php
		
				/*$this->Html->addCrumb('Home', '/');
				$this->Html->addCrumb('Sitemap', '/sitemaps/sitemap');
				$this->Html->addCrumb('Product Map', '/sitemaps/product_map');
				$this->Html->addCrumb($department_name, '/sitemaps/product_map_topcategories/'.$this->params['pass'][0]);
				$this->Html->addCrumb($selected_category_name, '/sitemaps/product_map_short/'.$this->params['pass'][0].'/'.$this->params['pass'][1]);
				$this->Html->addCrumb("<span>".$categoryname."</span>", "");
				echo $this->Html->getCrumbs(' &gt ' , '');*/
				echo $strBreadcrumb;
			?>
		</div>
		
                <div class="row-widget">
			
                    <ul>
			<?php if(isset($totalproducts) && count($totalproducts) >0) {
			foreach ($totalproducts as $totalproduct){
			    
			    if(!empty($totalproduct['product_name'])) {
			    
			    ?>
			    <li><?php echo $html->link($totalproduct['id'].' - '.$totalproduct['product_name'],'/'.$this->Common->getProductUrl($totalproduct['id']).'/categories/productdetail/'.$totalproduct['id'],array('escape'=>false)); ?></li>
			    
			<?php 
			    }
			}
			
			}
			else
			{
			    echo '<li>No records found.</li>';
			}
			?>
                    </ul>
                </div>
            </div>
            <!--mid Content Closed-->
	

                 