<?php ?>
</section>
          <!--Search End-->
          <!--Seller Banner Starts-->
             <?php echo $this->element('mobile/homepage_best_sellers');?>
          <!--Seller Banner End-->
          <!--Main Content Starts--->
             <section class="maincont">
             <!--Sub Categories Starts-->
               <nav class="subnav">
                <ul class="subcategry">
                  <li><?php echo $html->link('Home',SITE_URL,array('escape'=>false));?>&nbsp;&nbsp;&gt;</li>
                  <?php echo $breadcrumb_string; ?>
                 </ul>
             </nav>
             
          <!--Sub Categories End-->
               <nav class="nav">
                <ul class="maincategory">
               <?php if(isset($childCategoryArr)  &&  is_array($childCategoryArr) ) {
			App::import('Model','Category');
			$this->Category = &new Category;
			foreach($childCategoryArr as $cat_id=>$cat_name){
				$childCatCount = $this->Category->getChildCount($cat_id);
				$dept_name = str_replace(array('&',' '), array('and','-'), "$department_name");
				$cat_url=$dept_name.'/'.str_replace(array('&',' ','/'), array('and','-','-'), $cat_name);
				if($childCatCount > 0){
					$cat_page_url = "/".$cat_url."/categories/index/".$cat_id;
				}else{
					$cat_page_url = "/".$cat_url."/categories/viewproducts/".$cat_id."/".$dept_id;
				}
				$activeClass = ( ( $cat_id == $selected_category) ? ('active'): ('') );
				echo '<li>';
				echo $html->link('<span>'.$cat_name.' </span>',$cat_page_url ,array('escape'=>false , 'class'=>$activeClass));
				echo '</li>';
			}
		} else{
			
			echo '';
		}
		?>

                   <?php echo $this->element('mobile/nav_footer');?>
                   
                  </ul>
               </nav>
             </section>
             <!--Main Content End--->
        </section>
      <!--Main Section End-->
   </section>