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
				$this->Html->addCrumb('Product Categories A to Z', '/sitemaps/product_categories/A');
				$this->Html->addCrumb('<span>Results for '.$this->params['pass'][0].'</span>', '');
				echo $this->Html->getCrumbs(' &gt ' , '');
			?>
		</div>	
        	
            
             <!--All Categories Start-->
            <h1 class="heading all_cat">Product Categories A to Z</h1>
            <div class="row">
            	<div class="all_categories_widget">
                    <p>Click the intial letter of the item you wish to find, for example B for Blenders. (Please use product types and not brand names)</p>
                    <ul class="atoz">
			<?php
			$class = '';
			foreach (range('A','Z') as $char)
			{
				
				if(isset($this->params['pass'][0]) && !empty($this->params['pass'][0]) && $char==$this->params['pass'][0])
				{
				$class ='active';	
				}
				else
				{
				$class ='';	
				}
				
			?>
			<li><?php echo $html->link($char,"/sitemaps/product_categories/".$char,array('escape'=>false,'class'=>$class));	?></li>
			<?php }
			?>
                      
                    </ul>
                </div>
		<?php if(!empty($product_categories) && count($product_categories) >0 && count($product_categories) > 5 ) {
			$loopcounter = round(count($product_categories) / 5 ) ;
			?>
		
            	<div class="column-links col_links">                	
                    <!--Loop 1 Start-->
                    <div class="row">
                      <ul>
			<?php
			for ($i=0; $i< $loopcounter; $i++ ){ ?>
			    <li><?php
			 $deprtment_name = $Department->find('first',array('conditions'=>array('Department.id'=>$product_categories[$i]['Category']['department_id']),'fields'=>array('Department.id','Department.name')));
		
			  $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($deprtment_name['Department']['name'], ENT_NOQUOTES, 'UTF-8'));
			  
			$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), 	html_entity_decode($product_categories[$i]['Category']['cat_name'], ENT_NOQUOTES, 'UTF-8'));
			echo $html->link($product_categories[$i]['Category']['cat_name'],"/".$dept_atoz."/".$cat_atoz."/categories/viewproducts/".$product_categories[$i]['Category']['id'].'/'.$product_categories[$i]['Category']['department_id'] ,array('escape'=>false));?></li>
			   
			    <?php } ?>
			 
		       
                      </ul>
                    </div>
                    <!--Loop 1 Closed-->
                </div>
              
	      
	      <div class="column-links col_links">                	
                    <!--Loop 2 Start-->
                    <div class="row">
                      <ul>
                    <?php
		    if($loopcounter <1)
		    $start = 0;
		    else
		    $start = (($loopcounter*1)-1);
		    $end = (($loopcounter*2)-1);
		    for ($i=$start; $i< ($end); $i++ ){ ?>
                        
			    <li><?php
			 $deprtment_name = $Department->find('first',array('conditions'=>array('Department.id'=>$product_categories[$i]['Category']['department_id']),'fields'=>array('Department.id','Department.name')));
		
			  $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($deprtment_name['Department']['name'], ENT_NOQUOTES, 'UTF-8'));
			  
			$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), 	html_entity_decode($product_categories[$i]['Category']['cat_name'], ENT_NOQUOTES, 'UTF-8'));
			echo $html->link($product_categories[$i]['Category']['cat_name'],"/".$dept_atoz."/".$cat_atoz."/categories/viewproducts/".$product_categories[$i]['Category']['id'].'/'.$product_categories[$i]['Category']['department_id'] ,array('escape'=>false));?></li>
			   
			    <?php } ?>
		       
                      </ul>
                    </div>
                    <!--Loop 2  Closed-->
                </div>
	      
	      <div class="column-links col_links">                	
                    <!--Loop 3 Start-->
                    <div class="row">
                      <ul>
                   <?php
		    $start = (($loopcounter*2)-1);
		    $end = (($loopcounter*3)-1);
		   for ($i=$start; $i< $end; $i++ ){ ?>
			    <li><?php
			 $deprtment_name = $Department->find('first',array('conditions'=>array('Department.id'=>$product_categories[$i]['Category']['department_id']),'fields'=>array('Department.id','Department.name')));
		
			  $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($deprtment_name['Department']['name'], ENT_NOQUOTES, 'UTF-8'));
			  
			$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), 	html_entity_decode($product_categories[$i]['Category']['cat_name'], ENT_NOQUOTES, 'UTF-8'));
			echo $html->link($product_categories[$i]['Category']['cat_name'],"/".$dept_atoz."/".$cat_atoz."/categories/viewproducts/".$product_categories[$i]['Category']['id'].'/'.$product_categories[$i]['Category']['department_id'] ,array('escape'=>false));?></li>
			   
			    <?php } ?>
		       
                      </ul>
                    </div>
                    <!--Loop 3 Closed-->
                </div>
	      
	      <div class="column-links col_links">                	
                    <!--Loop 4 Start-->
                    <div class="row">
                      <ul>
                     <?php
			$start = (($loopcounter*3)-1);
			$end = (($loopcounter*4)-1);
		     for ($i=$start; $i< $end; $i++ ){ ?>
                        
			    <li><?php
			 $deprtment_name = $Department->find('first',array('conditions'=>array('Department.id'=>$product_categories[$i]['Category']['department_id']),'fields'=>array('Department.id','Department.name')));
		
			  $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($deprtment_name['Department']['name'], ENT_NOQUOTES, 'UTF-8'));
			  
			$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), 	html_entity_decode($product_categories[$i]['Category']['cat_name'], ENT_NOQUOTES, 'UTF-8'));
			echo $html->link($product_categories[$i]['Category']['cat_name'],"/".$dept_atoz."/".$cat_atoz."/categories/viewproducts/".$product_categories[$i]['Category']['id'].'/'.$product_categories[$i]['Category']['department_id'] ,array('escape'=>false));?></li>
			   
			    <?php } ?>
		       
                      </ul>
                    </div>
                    <!--Loop 4 Closed-->
                </div>
	      
	      <div class="column-links col_links">                	
                    <!--Loop 5 Start-->
                    <div class="row">
                      <ul>
                   <?php
			$start = (($loopcounter*4)-1);
			$end = (count($product_categories));
		   for ($i=$start; $i< $end; $i++ ){ ?>
			    <li><?php
			 $deprtment_name = $Department->find('first',array('conditions'=>array('Department.id'=>$product_categories[$i]['Category']['department_id']),'fields'=>array('Department.id','Department.name')));
		
			  $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($deprtment_name['Department']['name'], ENT_NOQUOTES, 'UTF-8'));
			  
			$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), 	html_entity_decode($product_categories[$i]['Category']['cat_name'], ENT_NOQUOTES, 'UTF-8'));
			echo $html->link($product_categories[$i]['Category']['cat_name'],"/".$dept_atoz."/".$cat_atoz."/categories/viewproducts/".$product_categories[$i]['Category']['id'].'/'.$product_categories[$i]['Category']['department_id'] ,array('escape'=>false));?></li>
			   
			    <?php } ?>
		       
                      </ul>
                    </div>
                    <!--Loop 5 Closed-->
                </div>
                <?php } else if(!empty($product_categories) && count($product_categories) >0 && count($product_categories) < 6 ) {
			foreach ($product_categories as $product_category){?>
		<div class="column-links col_links">                	
                    <!--Books Start-->
                    <div class="row">
                      <ul>
			 <li><?php
			 $deprtment_name = $Department->find('first',array('conditions'=>array('Department.id'=>$product_category['Category']['department_id']),'fields'=>array('Department.id','Department.name')));
		
			  $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($deprtment_name['Department']['name'], ENT_NOQUOTES, 'UTF-8'));
			  
			$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), 	html_entity_decode($product_category['Category']['cat_name'], ENT_NOQUOTES, 'UTF-8'));
			echo $html->link($product_category['Category']['cat_name'],"/".$dept_atoz."/".$cat_atoz."/categories/viewproducts/".$product_category['Category']['id'].'/'.$product_category['Category']['department_id'] ,array('escape'=>false));?></li>
			 
			 </div>
		    </div>
			 <?php }
			 
		} //else if ends else
		
		else
		{
			echo 'No records found';
		}
		?>
                <div class="clear"></div>     
            </div>
            <!--All Categories Closed-->
           
        </div>
        <!--mid Content Closed-->
	

                 