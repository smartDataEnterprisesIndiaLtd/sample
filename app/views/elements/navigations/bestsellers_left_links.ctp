<?php ?>
<div class="side-content">
	<h4 class="blue-head"><span>Browse Bestsellers</span></h4>
	<ul class="links">
		<?php if(!empty($departments_list)){
				foreach($departments_list as $department_id=>$department){ ?>
			<li>
			<?php
			if(@$dept_name == $department){
				echo $html->link('<span class="choiceful"><strong>'.$dept_name.'</strong></span>','/products/bestseller_products/'.base64_encode($department_id) ,array('escape'=>false));
			} else {
				echo $html->link('<span>'.$department.' </span>','/products/bestseller_products/'.base64_encode($department_id) ,array('escape'=>false));
			}?>
			</li>
			<?php  } ?>
		<?php }?>
	</ul>
</div>