<?php if($this->params['action'] == 'search_results'){
	$paging_class = ' box-margin-right';
} else{
	$paging_class ='';
}?>
<!--Paging Widget Start-->
<?php echo $form->create('Marketplace',array('action'=>'gotoPage','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));?>
<div class="search-paging <?php echo $paging_class;?>">
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
		<li>Products <strong><?php echo $from; ?></strong> to <strong><?php echo $to; ?></strong> of <strong><?php echo $this->params['paging'][$modelis]['count'];?></strong></li>
		<?php if($paginator->numbers()) { ?>
		<li class="paging-sec">
			<span style="float:left">
			<strong>Go to Page:</strong> 
			<?php 
				echo $form->input('Page.goto_page',array('value'=> '' /*$go_to_page*/  , 'class'=>'form-textfield num-width','label'=>false,'div'=>false));
				
				echo $form->hidden('Page.keyword',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$keyword));
				echo $form->hidden('Page.limit',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$to));
					
				if($this->params['action'] == 'update_listing' || $this->params['action'] == 'save_listing'){
					$this->params['action'] = 'manage_listing';
				}
				if($this->params['action'] == 'search_results' || $this->params['action'] == 'search_product'){
					echo $form->hidden('Page.from_price',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$from_price));
					if($this->params['action'] == 'search_product'){
						echo $form->hidden('Page.sort',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$sort));
					}
					echo $form->hidden('Page.to_price',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$to_price));
					echo $form->hidden('Page.brand_str',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$brand_str));
					echo $form->hidden('Page.rate',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$rate));
				}
				echo $form->hidden('Page.action',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['action']));
				echo $form->hidden('Page.url',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['url']['url']));?>  
				<?php echo $form->submit('',array('alt'=>'Search','type'=>'image','src'=>SITE_URL.'/img/go-grn-btn.gif','border'=>'0', "value"=>"search",'class'=>'v-align-middle','div'=>false,'style'=>'margin-right:10px'));?>
				
			<!--span class="padding-left"><strong>Page: </strong></span--> 
			<?php //if(($this->params['paging'][$modelis]['page'] - 5) >= 1) {
				//echo $paginator->first('First',array('class'=>"homeLink")); ?>
				<!--a href="#">...</a-->
			<?php //}?>
			</span>
			
			<div class="pagingdef">
				<ul class="overflow-h">
					<?php
					if(!empty($this->params['named']['seller_id'])){
						$paginator->options(array(
							'url'=> array(
							'controller' => 'marketplaces', 
							'action' => 'manage_listing', 
							'seller_id' => $this->params['named']['seller_id']
							))
						);
					}else{
						$paginator->options(array(
							'url'=> array(
							'controller' => 'marketplaces', 
							'action' => 'manage_listing', 
							))
						);
					}
					?>
					<?php echo $paginator->prev('Prev',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
					<?php echo $this->Paginator->numbers(array('separator'=>'','tag' => 'li','class'=>'active')); ?>
					<?php echo $paginator->next('Next',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
				</ul>
			</div>
			<?php 
			//echo $paginator->prev('Prev',array('class'=>"homeLink"));
			//echo $paginator->numbers();
			//echo $paginator->next('Next',array('class'=>"homeLink"));
			
			//if(($this->params['paging'][$modelis]['pageCount'] - $this->params['paging'][$modelis]['page']) >= 5) { ?>
				<!--a href="#">...</a-->
			<?php //echo $paginator->last('Last',array('class'=>"homeLink")); } ?>
		</li>
		<?php }?>
	</ul>
</div>
<!--Paging Widget Closed-->
<?php echo $form->end();?>