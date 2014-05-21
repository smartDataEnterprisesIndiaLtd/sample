<?php
App::import('Model','Department');
$Department = & new Department();		

?>


<!--mid Content Start-->
            <div class="mid-content padding_left0 pad-rt-none page_min_height" >
                <div class="breadcrumb-widget"><strong>You are here</strong>:
		
		<?php
				$this->Html->addCrumb('Home', '/');
				$this->Html->addCrumb('Sitemap', '/sitemaps/sitemap');
				$this->Html->addCrumb('<span>Product Map</span>', '');
				echo $this->Html->getCrumbs(' &gt ' , '');
			?>
		</div>
		
                <div class="row-widget">
			
                	<ul>
			<?php
			if(!empty($departments) && count($departments) >0) {
			foreach ($departments as $department ){
			?>	
                    	<li> <?php echo $html->link($department['Department']['name'],"/sitemaps/product_map_topcategories/".$department['Department']['id'],array('escape'=>false)); ?></li>
                        <?php
			
			}
			
			} //if ends
			
			else
			{
			    
			    echo 'No records found';
			}
			
			?>
                    </ul>
                </div>
            </div>
            <!--mid Content Closed-->
	

                 