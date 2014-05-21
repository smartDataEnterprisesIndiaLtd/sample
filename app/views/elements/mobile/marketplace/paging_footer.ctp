<?php ?>
<div class="srch-pg" style="padding:8px 0; border-top:1px #ccc solid;">
	<ul>
	
	<?php echo $form->create('Marketplace',array('action'=>'manage_listing','method'=>'POST','name'=>'frmlimit','id'=>'frmlimit'));?>

		<li class="pad-tp">
			<?php echo $form->hidden('Page.keyword',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$keyword));

			if($this->params['action'] == 'update_listing' || $this->params['action'] == 'save_listing'){
				$this->params['action'] = 'manage_listing';
			}
			echo $form->hidden('Page.action',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['action']));
			echo $form->hidden('Page.url',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['url']['url']));?>
			
			Show <?php echo $form->select('Paging.options',array('50'=>'50','100'=>'100','150'=>'150','200'=>'200','250'=>'250'),null,array('class'=>'form-select', 'type'=>'select','style'=>'width:80px','onChange'=>'return setLimit(this.value)'),'-- Select --');?>
		</li>
	<?php echo $form->end();?>

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
				if(($this->params['paging'][$modelis]['pageCount'] - $this->params['paging'][$modelis]['page']) >= 5) { ?>
				<?php //echo $paginator->last('Last',array('class'=>"homeLink")); } ?>
				<?php }?>
			</ul>
			<div class="clear"></div>
		</div>
	</li>
	
	<!--<li class="float-right">
		<div class="paging">
			<ul>
			<li><a href="#">Prev</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#" class="active">5</a></li>
			<li><a href="#">6</a></li>
			<li><a href="#">Next</a></li>
			</ul>
			<div class="clear"></div>
		</div>
	</li>-->
	<?php echo $form->end();?>
	</ul>
</div>
