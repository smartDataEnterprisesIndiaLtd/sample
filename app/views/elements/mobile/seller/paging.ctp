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
<div class="srch-pg" style="border-bottom: 1px solid #CCCCCC;">
	<ul>
		<li class="pad-top">Viewing All Feedback</li>
		<li class="pad-top" style="float:right"><strong><?php echo $from; ?></strong> to <strong><?php echo $to; ?></strong> of <strong><?php echo $this->params['paging'][$modelis]['count'];?></strong></li>
	</ul>
</div>