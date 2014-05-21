<?php pr($modelis);?>
<!--Paging Widget Start-->
<?php echo $form->create('Marketplace',array('action'=>'gotoPage','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));?>
<div class="search-paging">
	<ul>
		<?php if($this->params['paging']['ProductSeller']['page'] == 1){
			$from = 1;
			if($this->params['paging']['ProductSeller']['count'] == $this->params['paging']['ProductSeller']['current'])
				$to = $this->params['paging']['ProductSeller']['count'];
			else
				$to = $this->params['paging']['ProductSeller']['defaults']['limit'];
		} else{
			$from = ($this->params['paging']['ProductSeller']['page'] - 1) * ($this->params['paging']['ProductSeller']['defaults']['limit']) + 1;
			if($this->params['paging']['ProductSeller']['page'] == $this->params['paging']['ProductSeller']['pageCount']) {
				$to = $this->params['paging']['ProductSeller']['count'];
			} else {
				$to = ($this->params['paging']['ProductSeller']['page']) * ($this->params['paging']['ProductSeller']['defaults']['limit']);
			}
		}
		?>
		<li>Products <strong><?php echo $from; ?></strong> to <strong><?php echo $to; ?></strong> of <strong><?php echo $this->params['paging']['ProductSeller']['count'];?></strong></li>
		<?php if($paginator->numbers()) { ?>
		<li class="paging-sec"><strong>Go to Page:</strong> 
			<?php echo $form->input('Page.goto_page',array('class'=>'form-textfield num-width','label'=>false,'div'=>false)); echo $form->hidden('Page.keyword',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$keyword)); echo $form->hidden('Page.url',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['url']['url']));?>
			<?php echo $form->submit('',array('alt'=>'Search','type'=>'image','src'=>'/img/go-grn-btn.gif','border'=>'0', "value"=>"search",'class'=>'v-align-middle','div'=>false))?>
			<span class="padding-left"><strong>Page: </strong></span>
			<?php if($this->params['paging']['ProductSeller']['pageCount'] > 8) {
				echo $paginator->first('First',array('class'=>"homeLink")); ?>
				<a href="#">...</a>
			<?php }
			echo $paginator->prev('Previous',array('class'=>"homeLink"));?> <?php
			echo $paginator->numbers();?> <?php
			echo $paginator->next('Next',array('class'=>"homeLink"));
			if($this->params['paging']['ProductSeller']['pageCount'] > 8) { ?>
				<a href="#">...</a>
				<?php echo $paginator->last('Last',array('class'=>"homeLink")); } ?>
		</li>
		<?php }?>
	</ul>
</div>
<!--Paging Widget Closed-->
<?php echo $form->end();?>