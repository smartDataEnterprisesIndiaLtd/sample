<?php ?>
<div class="srch-pg">
	<ul>
	<?php echo $form->create('Marketplace',array('action'=>'gotoPage','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));?>
	
	<li class="float-right">
		<div class="paging">
			<ul>
				<?php 
				echo $paginator->prev('Prev',array('tag' => 'li','class'=>"homeLink"));?>
				
				<?php
					echo $paginator->numbers(array('tag' => 'li','separator' =>' ' ,'modulus' => '2','escape'=>false));?>
				<?php
				echo $paginator->next('Next',array('tag' => 'li','class'=>"homeLink"));
				/*if(($this->params['paging'][$modelis]['pageCount'] - $this->params['paging'][$modelis]['page']) >= 5) { */?>
				<?php //echo $paginator->last('Last',array('class'=>"homeLink")); } ?>
				<?php //}?>
			</ul>
			<div class="clear"></div>
		</div>
	</li>
	<?php echo $form->end();?>
	</ul>
</div>
