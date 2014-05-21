<?php 

?>
<!--Sorting Start-->
<div class="paging border-top">
	<ul>
		<li><strong>Page</strong></li>
		<li><?php echo $paginator->prev('Previous',array('class'=>"homeLink"));?></li>
		<li><?php echo $paginator->numbers();?></li>
		<li><?php echo $paginator->next('Next',array('class'=>"homeLink"));?></li>
	</ul>
	<div class="clear"></div>
</div>
<!--Sorting Closed-->