<?php ?>
</section>
          <!--Search End-->
          <!--Seller Banner Starts-->
             <?php echo $this->element('mobile/homepage_best_sellers');?>
          <!--Seller Banner End-->
          <!--Main Content Starts--->
             <section class="maincont">
             <!--Sub Categories Starts-->
             <?php if(isset($topCategoryArr)  &&  is_array($topCategoryArr)  ) {?>
               <nav class="subnav">
                <ul class="subcategry">
                  <li><?php echo $html->link('Home',SITE_URL,array('escape'=>false));?>&nbsp;&nbsp;&gt;</li>
                  <li><?php echo $department_name;?></li>
                </ul>
             </nav>
             <?php }?>
          <!--Sub Categories End-->
          
               <nav class="nav">
                <ul class="maincategory">
                  <?php
			if(!isset($selected_department)){
				$selected_department = '';
			}
			if(!empty($departments)){
				foreach($departments as $department_id =>$department){
					if( $department_id == $selected_department ){
						$spanClass = 'active';
					} else{
						$spanClass = '';
					}
				?>
				<li>
				<?php $dept_name = str_replace(array('&',' '), array('and','-'), "$department");?>
				<?php echo $html->link('<span>'.$department.' </span>',"/".$dept_name."/departments/index/".$department_id,array('escape'=>false ,'class'=>$spanClass ));?></li>
				<?php
				}
			}?>
			
			<?php
			
			if(isset($topCategoryArr)  &&  is_array($topCategoryArr)  ) {
			$i = 0;
			$par_parent_id = '';
			foreach($topCategoryArr as $par_cat_id => $par_cat_name) {
				$i++;
				if($i == 1) {
					$close_url = "/departments/index/".$selected_department;
				} else {
					$close_url = "/categories/index/".$par_parent_id;
				}
				echo '<li>';
				$dept_name = str_replace(array('&',' '), array('and','-'), "$department_name");
				$cat_url=$dept_name.'/'.str_replace(array('&',' ','/'), array('and','-','-'), $par_cat_name);
				echo $html->link('<span>'.$par_cat_name.' </span>',"/".$cat_url."/categories/index/".$par_cat_id ,array('escape'=>false));?>
			<?php echo '</li>';
				$par_parent_id = $par_cat_id;
			}
		 }?>
		 
			<!--Navigation Starts-->
                		<?php echo $this->element('mobile/nav_footer');?> 
               		<!--Navigation End-->
                </ul>
               </nav>
        </section>
      <!--Main Section End-->
   </section>