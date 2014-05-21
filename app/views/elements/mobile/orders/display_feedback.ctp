<?php
$seller_id = $this->Session->read('User.id');
?>
<!--Seller Feedback Start-->
<div class="order-pro-info">
	<ul class="order-info">
		<li><?php echo $val['OrderItem']['product_name']; ?></li>
		<?php if ($session->check('Message.flash')){ ?>
		<li style="padding-bottom:0px!important"><div  class="messageBlock"><?php echo $session->flash();?></div></li>
		<?php } ?>
		<li>
			<p class="smalr-fnt">Please contact seller to resolve any problems before leaving feedback</p>
			<p><span class="gray">Seller:</span> <?php 
			$bestseller_url=str_replace(array(' ','/','&quot;'), array('-','','"'), html_entity_decode($val['OrderItem']['seller_name'], ENT_NOQUOTES, 'UTF-8'));
			echo $html->link($val['OrderItem']['seller_name'],'/sellers/'.$bestseller_url.'/summary/'.$val['OrderItem']['seller_id'].'/'.$val['OrderItem']['product_id'].'/'.$val['OrderItem']['condition_id'],array('class'=>"underline-link",'escape'=>false));?></p>
			<div id="rate_module_<?php echo $val['OrderItem']['id']; ?>">
				<p style="float:left; padding-right:10px"><?php for($i = 0; $i<$val['Feedback']['rating']; $i++){
					echo $html->image('blue-star.png',array('alt'=>''));
				}
				for($j = $i; $j < 5; $j++){
					echo $html->image('bl-start.png',array('alt'=>''));
				} ?> </p>
				<p style="text-align:right">Updated: <?php if(!empty($val['Feedback']['created'])) echo date('d/m/Y', strtotime($val['Feedback']['created'])); else echo '-';?></p>
				<p><?php echo $val['Feedback']['feedback'];?>
				</p>
			</div>
		</li>
	</ul>
</div>
<!--Seller Feedback Closed-->