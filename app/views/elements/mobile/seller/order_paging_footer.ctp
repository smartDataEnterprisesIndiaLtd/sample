<?php ?>
<div class="search-paging">
	<ul>
		<li class="pad-tp">
			<?php
			if($this->params['paging'][$modelis]['page'] == 1){
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
			
			echo $form->create('Seller',array('action'=>'orders','method'=>'POST','name'=>'frmlimit','id'=>'frmlimit'));?>
			<?php
			echo $form->hidden('Page.action',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['action']));
			echo $form->hidden('Page.filter',array('class'=>'textfield-input num-width','label'=>false,'div'=>false));
			echo $form->hidden('Page.url',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['url']['url']));
			?>
			Show
			<?php echo $form->select('Paging.options',array('2'=>'2','5'=>'5','10'=>'10','20'=>'20','50'=>'50','100'=>'100','150'=>'150','200'=>'200','250'=>'250'),$to,array('class'=>'form-select', 'type'=>'select','onChange'=>'this.form.submit()','style'=>'width:80px'),'-- Select --');
			echo $form->end();
			?>
		</li>
		
		<li class="float-right">
                        <div class="paging">
			<ul>
			<?php 
				echo $paginator->prev('Prev',array('tag' => 'li','class'=>"homeLink"));?>
				<?php
					echo $paginator->numbers(array('tag' => 'li','separator' =>' ' ,'modulus' => '2','escape'=>false));
					echo $paginator->next('Next',array('tag' => 'li','class'=>"homeLink"));
				?>
			</ul>
                        <div class="clear"></div>
		</li>
	</ul>
</div>
<!--Paging Widget Closed-->