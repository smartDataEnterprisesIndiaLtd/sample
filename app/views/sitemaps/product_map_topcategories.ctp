<?php
App::import('Model','Department');
$Department = & new Department();		

?>


<!--mid Content Start-->
            <div class="mid-content padding_left0 pad-rt-none page_min_height">
                <div class="breadcrumb-widget"><strong>You are here</strong>:
		
		<?php
		
				$this->Html->addCrumb('Home', '/');
				$this->Html->addCrumb('Sitemap', '/sitemaps/sitemap');
				$this->Html->addCrumb('Product Map', '/sitemaps/product_map');
				$this->Html->addCrumb("<span>".$categoryname."</span>", "");
				echo $this->Html->getCrumbs(' &gt ' , '');
			?>
		</div>
		
                <div class="row-widget">
			
                	<ul>
			<?php
			
			if(!empty($categories) && count($categories) >0) {
			foreach ($categories as $cat_id=>$cat_name ){
			?>	
                    	<li> <?php echo $html->link($cat_name,"/sitemaps/product_map_short/".$this->params['pass'][0].'/'.$cat_id,array('escape'=>false)); ?></li>
                        <?php
			}
			} // if ends  ?>
                    </ul>
                </div>
            </div>
            <!--mid Content Closed-->
	

                 