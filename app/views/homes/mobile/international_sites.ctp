<?php ?>
<!--Content Start-->
<div class="content-widget">
<h4>Choose your location</h4>
<p>You can shop at all our sites by using a credit or debit card. Prices will be displayed in the home currency of each site. Your credit card provider will convert your purchase on your credit card statement.</p>
	<div class="worldwide">
		<?php echo $html->image('mobile/globe.png',array('alt'=>'' , 'width'=>'11', 'height' => '11'));?>
		<span class="gray">Worldwide (All)</span>
	</div>

<!--Links Start-->
<div class="row">
	
	<!--Column1 Start-->
	<div class="clmn-links">
	<ul><li><?php echo $html->link($html->image('australia-flag.png',array('alt'=>'Australia','title'=>'Australia','class'=>'flag-img','height'=>11,'width'=>17)).'Australia','#',array('escape'=>false));?></li>
				<li><?php echo $html->link($html->image('brazil-flag.png',array('alt'=>'Brazil','title'=>'Brazil','class'=>'flag-img','height'=>11,'width'=>17)).'Brazil','#',array('escape'=>false));?></li>
				<li><?php echo $html->link($html->image('canada-flag.png',array('alt'=>'Canada','title'=>'Canada','class'=>'flag-img','height'=>11,'width'=>17)).'Canada','#',array('escape'=>false));?></li>
				<li><?php echo $html->link($html->image('czech-republic-flag.png',array('alt'=>'Czech Republic','title'=>'Czech Republic','class'=>'flag-img','height'=>11,'width'=>17)).'Czech Republic','#',array('escape'=>false)); ?></li>
				<li><?php echo $html->link($html->image('germany-flag.png',array('alt'=>'Germany','title'=>'Germany','class'=>'flag-img','height'=>11,'width'=>17)).'Germany','#',array('escape'=>false));?></li>
					
					<li><?php echo $html->link($html->image('spain-flag.png',array('alt'=>'Spain','title'=>'Spain','class'=>'flag-img','height'=>11,'width'=>17)).'Spain','#',array('escape'=>false));?></li>
					<li><?php echo $html->link($html->image('france-flag.png',array('alt'=>'France','title'=>'France','class'=>'flag-img','height'=>11,'width'=>17)).'France','#',array('escape'=>false)); ?></li>
					<li><?php echo $html->link($html->image('uk-flag.png',array('alt'=>'UK','title'=>'UK','class'=>'flag-img','height'=>11,'width'=>17)).'UK','#',array('escape'=>false)); ?></li>
					<li><?php echo $html->link($html->image('hong-kong-flag.png',array('alt'=>'Hong Kong','title'=>'Hong Kong','class'=>'flag-img','height'=>11,'width'=>17)).'Hong Kong','#',array('escape'=>false));?></li>
					<li><?php echo $html->link($html->image('ireland-flag.png',array('alt'=>'Ireland','title'=>'Ireland','class'=>'flag-img','height'=>11,'width'=>17)).'Ireland','#',array('escape'=>false)); ?></li>
	</ul>                    
	</div>
	<!--Column1 Closed-->
	
	<!--Column2 Start-->
	<div class="clmn-links">
	<ul>
		<li><?php echo $html->link($html->image('israel-flag.png',array('alt'=>'Israel','title'=>'Ireland','class'=>'flag-img','height'=>11,'width'=>17)).'Israel','#',array('escape'=>false));?></li>
		<li><?php echo $html->link($html->image('india-flag.png',array('alt'=>'India','title'=>'India','class'=>'flag-img','height'=>11,'width'=>17)).'India','#',array('escape'=>false)); ?></li>
		<li><?php echo $html->link($html->image('italy-flag.png',array('alt'=>'Italy','title'=>'Italy','class'=>'flag-img','height'=>11,'width'=>17)).'Italy','#',array('escape'=>false)); ?></li>
		<li><?php echo $html->link($html->image('japan-flag.png',array('alt'=>'Japan','title'=>'Japan','class'=>'flag-img','height'=>11,'width'=>17)).'Japan','#',array('escape'=>false)); ?></li>
		<li><?php echo $html->link($html->image('south-korea-flag.png',array('alt'=>'South Korea','title'=>'South Korea','class'=>'flag-img','height'=>11,'width'=>17)).'South Korea','#',array('escape'=>false)); ?></li>
		
		
		<li><?php echo $html->link($html->image('mexico-flag.png',array('alt'=>'Mexico','title'=>'Mexico','class'=>'flag-img','height'=>11,'width'=>17)).'Mexico','#',array('escape'=>false)); ?></li>
		<li><?php echo $html->link($html->image('netherlands-flag.png',array('alt'=>'Netherlands','title'=>'Netherlands','class'=>'flag-img','height'=>11,'width'=>17)).'Netherlands','#',array('escape'=>false)); ?></li>
		<li><?php echo $html->link($html->image('new-zealand-flag.png',array('alt'=>'New Zealand','title'=>'New Zealand','class'=>'flag-img','height'=>11,'width'=>17)).'New Zealand','#',array('escape'=>false)); ?></li>
		<li><?php echo $html->link($html->image('poland-flag.png',array('alt'=>'Poland','title'=>'Poland','class'=>'flag-img','height'=>11,'width'=>17)).'Poland','#',array('escape'=>false));?></li>
		<li><?php echo $html->link($html->image('russia-flag.png',array('alt'=>'Russia','title'=>'Russia','class'=>'flag-img','height'=>11,'width'=>17)).'Russia','#',array('escape'=>false));?></li>
		
	</ul>                    
	</div>
	<!--Column2 Closed-->
	
	<!--Column5 Start-->
	<div class="clmn-links">
	<ul>
		<li><?php echo $html->link($html->image('sweden-flag.png',array('alt'=>'Sweden','title'=>'Mexico','class'=>'flag-img','height'=>11,'width'=>17)).'Sweden','#',array('escape'=>false)); ?></li>
					<li><?php echo $html->link($html->image('taiwan-flag.png',array('alt'=>'Taiwan','title'=>'Taiwan','class'=>'flag-img','height'=>11,'width'=>17)).'Taiwan','#',array('escape'=>false)); ?></li>
					<li><?php echo $html->link($html->image('south-africa-flag.png',array('alt'=>'South Africa','title'=>'South Africa','class'=>'flag-img','height'=>11,'width'=>17)).'South Africa','#',array('escape'=>false)); ?></li>
					<li><?php echo $html->link($html->image('usa-flag.png',array('alt'=>'USA','title'=>'USA','class'=>'flag-img','height'=>11,'width'=>17)).'USA','#',array('escape'=>false)); ?></li>
	</ul>                    
	</div>
	<!--Column5 Closed-->
	<div class="clear"></div>
	
</div>
<!--Links Closed-->
</div>
<!--Content Closed-->

<!--Main Content Starts--->
<section class="maincont">
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
          <!--Main Content End--->