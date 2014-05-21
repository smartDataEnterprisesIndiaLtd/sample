<?php ?>
<!--Tabs Widget Start-->
<div class="tabs-widget">
	<ul>
		<li>
			<?php
			if($this->params['action'] == 'my_reviews'){
				$class = 'active';
			} else{
				$class = '';
			}
			echo $html->link('See All My Reviews','/products/my_reviews',array('escape'=>false,'class'=>$class));?>
		</li>
		<li><?php
			if($this->params['action'] == 'leave_seller_feedback'){
				$class = 'active';
			} else{
				$class = '';
			}
			echo $html->link('Leave Seller Feedback','/orders/leave_seller_feedback/',array('escape'=>false,'class'=>$class));?>
		</li>
	</ul>
</div>
<!--Tabs Widget Closed-->