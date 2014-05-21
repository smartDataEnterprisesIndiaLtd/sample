<?php
$controller_name = $this->params['controller'];
$action_name 	 = $this->params['action'];
$controllerNameArray = array('categories', 'products');
$actionNameArray = array('index', 'viewproducts','productdetail');
?>
<!--Browse Start-->
<?php /**************************** INCLUDE FOR HOME AND DEPARTMENT PAGE  ENDS HERE **************************/ ?>
<?php
if($controller_name == 'departments' ||  $controller_name == 'homes' ){
	if(isset($selected_department) && $selected_department >0  ){  //show all main categories for a department 
		if(isset($department_name)){
			$department_name = $department_name;
		} ?>
		<div class="side-content">
			<?php if(strlen($department_name)>16){
				$display_department_name = substr($department_name,0, 14).'...';
			} else{
				$display_department_name = $department_name;
			}?>
			<h4 class="blue-head"> <?php echo $html->link('<span>Browse '.$display_department_name.'</span>',"javascript::void(0)",array('escape'=>false,'title'=>$department_name));?></h4>
			<ul class="links">
				<li class="main-head">
					<?php 
					$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link('<span><strong>'.$department_name.' </strong></span>',"/".$dept_url_name."/departments/index/".$selected_department ,array('escape'=>false));?>
					<?php echo $html->link( $html->image('cross-icon.gif', array('width'=>11, 'height'=>11 ,'alt'=>'close') ), "/" ,array('class'=>'cross', 'escape'=>false));?>
				</li>
				<?php if(isset($topCategoryArr)  &&  is_array($topCategoryArr)  ){
					foreach($topCategoryArr as $cat_id=>$cat_name){ ?>
					<li>
						<?php
							$cat_url=$dept_url_name.'/'.str_replace(array('&','/',' '), array('and','-','-'), $cat_name);
							echo $html->link('<span>'.$cat_name.'</span>',"/".$cat_url."/categories/index/".$cat_id ,array('escape'=>false));?>
					</li>
					<?php  } ?>
				<?php }?>
			</ul>
		</div>
	<?php } else{  // show all departments only   ?>
		<div class="side-content">
			<h4 class="blue-head"><span>Browse</span></h4>
			<ul class="links">
				<?php if(!empty($departments_list)){
						foreach($departments_list as $department_id=>$department){ ?>
					<li>
					<?php
						$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department, ENT_NOQUOTES, 'UTF-8'));
						echo $html->link('<span>'.$department.' </span>',"/".$dept_url_name."/departments/index/".$department_id ,array('escape'=>false));?>
					</li>
					<?php  } ?>
				<?php }?>
			</ul>
		</div>
	<?php }
} else if( in_array($controller_name, $controllerNameArray  )  &&  in_array( $action_name, $actionNameArray  ) ) { ?>
<div class="side-content">
	<h4 class="blue-head"><span>Browse <?php echo substr($department_name,0, 16);?></span></h4>
	<ul class="links">
		 <li class="main-head">
			<?php
			$dept_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
			echo $html->link('<span><strong>'.$department_name.' </strong></span>',"/".$dept_name."/departments/index/".$selected_department ,array('escape'=>false)); ?>
			<?php echo $html->link( $html->image('cross-icon.gif', array('width'=>11, 'height'=>11 ,'alt'=>'close') ), "/" ,array('class'=>'cross', 'escape'=>false));?>
		 </li>
		 <?php
		if(isset($parentCategoryArr)  &&  is_array($parentCategoryArr)  ) {
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
			       echo '<li class="main-head">';
			       $cat_url=$dept_name.'/'.str_replace(array('&','/',' '), array('and','/','-'), $par_cat_name);
			       echo $html->link('<span><strong>'.$par_cat_name.' </strong></span>',"/".$cat_url."/categories/index/".$par_cat_id ,array('escape'=>false));?>
			       <?php echo $html->link( $html->image('cross-icon.gif', array('width'=>11, 'height'=>11 ,'alt'=>'close') ), $close_url ,array('class'=>'cross', 'escape'=>false));?>
			       <?php echo '</li>';
			       $par_parent_id = $par_cat_id;
		        }
		}	
		if(isset($childCategoryArr)  &&  is_array($childCategoryArr) ) {
			App::import('Model','Category');
			$this->Category = &new Category;
			foreach($childCategoryArr as $cat_id=>$cat_name){
				$childCatCount = $this->Category->getChildCount($cat_id);
				$cat_url_child=$dept_name.'/'.str_replace(array('&','/',' '), array('and','-','-'), $cat_name);
				if($childCatCount > 0){
					$cat_page_url = "/".$cat_url_child."/categories/index/".$cat_id;
				}else{
					//$cat_page_url = "/".$cat_url_child."/categories/viewproducts/".$cat_id;
					//We need department id on view product page.
					$cat_page_url = "/".$cat_url_child."/categories/viewproducts/".$cat_id."/".$selected_department;
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
	</ul>
</div>
<?php
 } else { ?>
<div class="side-content">
	<h4 class="blue-head"><span>Browse</span></h4>
	<ul class="links">
		<?php if(!empty($departments_list)){
				foreach($departments_list as $department_id=>$department){ ?>
				<li>	
					<?php 
					$dept_name = str_replace(array('&',' '), array('and','-'), $department);
					echo $html->link('<span>'.$department.' </span>',"/".$dept_name."/departments/index/".$department_id ,array('escape'=>false));?>
				</li>
			<?php  } ?>
		<?php }?>
	</ul>
</div>
<?php } ?>
<!--Browse Closed-->