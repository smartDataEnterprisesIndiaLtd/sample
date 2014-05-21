<?php echo $form->create('Seller',array('action'=>'gotoPage','method'=>'POST','name'=>'frmSeller','id'=>'frmSeller'));?>
<div class="search-paging">
	<ul> 
		<?php if($this->params['paging'][$modelis]['page'] == 1){
			$from = 1;
			if($this->params['paging'][$modelis]['count'] == $this->params['paging'][$modelis]['current'])
				$to = $this->params['paging'][$modelis]['count'];
			else
				$to = $this->params['paging'][$modelis]['defaults']['limit'];
		} else{
			$from = ($this->params['paging'][$modelis]['page'] - 1) * ($this->params['paging'][$modelis]['defaults']['limit']) + 1;
			if($this->params['paging'][$modelis]['page'] == $this->params['paging'][$modelis]['pageCount']) {
				$to = $this->params['paging'][$modelis]['count'];
			} else {
				$to = ($this->params['paging'][$modelis]['page']) * ($this->params['paging'][$modelis]['defaults']['limit']);
			}
		}
		
		?>
		<li>Orders <strong><?php echo $from; ?></strong> to <strong><?php echo $to; ?></strong> of <strong><?php echo $this->params['paging'][$modelis]['count'];?></strong></li>
		<?php if($paginator->numbers()) { ?>
		
		<li class="paging-sec">
			<span style="float:left">
			<strong>Go to Page:</strong>
			<?php 
				echo $form->input('Page.goto_page',array('class'=>'form-textfield num-width','label'=>false,'div'=>false));
					
				echo $form->hidden('Page.action',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>'orders'));
					
				echo $form->hidden('Page.filter',array('class'=>'textfield-input num-width','label'=>false,'div'=>false));
					
				echo $form->hidden('Page.url',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['url']['url']));?>
					
				<?php echo $form->submit('',array('alt'=>'Search','type'=>'image','src'=>'/img/go-grn-btn.gif','border'=>'0', "value"=>"search",'class'=>'v-align-middle','div'=>false))?>
			</span>
					
			<div class="pagingdef">
				<ul class="overflow-h">
					<?php echo $paginator->prev('Prev',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
					<?php echo $this->Paginator->numbers(array('separator'=>'','tag' => 'li','class'=>'active')); ?>
					<?php echo $paginator->next('Next',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
				</ul>
			</div>
					
		</li>
		<?php }?>
	</ul>
</div>
<!--Paging Widget Closed-->
<?php echo $form->end();?>