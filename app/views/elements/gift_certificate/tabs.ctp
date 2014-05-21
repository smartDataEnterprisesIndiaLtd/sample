<?php
$action = $this->params['action'];
 ?>
<!--Tabs Widget Start-->
<div class="tabs-widget">
	<ul>
		<li>
			<?php if($action == 'gift_balance') { $class = 'active'; } else { $class = ''; }
			echo $html->link('View Gift Certificate Balance','/certificates/gift_balance',array('class'=>$class, 'escape'=>false)); ?>
		</li>
		<li>
			<?php if($action == 'apply_gift') { $class = 'active'; } else { $class = ''; }
			echo $html->link('Apply a Gift Certificate','/certificates/apply_gift',array('class'=>$class, 'escape'=>false)); ?>
		</li>
	</ul>
</div>
<!--Tabs Widget Closed-->