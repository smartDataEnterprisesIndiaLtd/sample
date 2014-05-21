<?php
$seller_id = $this->Session->read('User.id');
?>
<!--Seller Feedback Start-->
<div class="order-pro-info">
	<ul class="order-info">
		<li><?php echo $val['OrderItem']['product_name'];?></li>
		<?php if ($session->check('Message.flash')){ ?>
		<li style="padding-bottom:0px!important"><div  class="messageBlock"><?php echo $session->flash();?></div></li>
		<?php } ?>
		<li>
			<p class="smalr-fnt">Please contact seller to resolve any problems before leaving feedback</p>
			<p><span class="gray">Seller:</span>
			
			<?php
			if(!empty($val['OrderItem']['seller_name']))
				$sellerName = $val['OrderItem']['seller_name'];
				  else
				$sellerName = '';
				if(!empty($val['OrderItem']['seller_id']) && !empty($val['OrderItem']['product_id']) && !empty($val['OrderItem']['condition_id'])){
					$seller_name_url=str_replace(' ','-',html_entity_decode($sellerName, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link($sellerName,'/sellers/'.$seller_name_url.'/summary/'.$val['OrderItem']['seller_id'].'/'.$val['OrderItem']['product_id'].'/'.$val['OrderItem']	['condition_id'],array('escape'=>false,'class'=>'underline-link'));
					}else{
					echo $sellerName;
				}
			//$bestseller_url=str_replace(array(' ','/','&quot;'), array('-','','"'), html_entity_decode($val['OrderItem']['seller_name'], ENT_NOQUOTES, 'UTF-8'));
			//echo $html->link($val['OrderItem']['seller_name'],'/'.$bestseller_url.'/sellers/summary/'.$val['OrderItem']['seller_id'].'/'.$val['OrderItem']['product_id'].'/'.$val['OrderItem']['condition_id'],array('class'=>"underline-link",'escape'=>false));?></p>
			<div id="rate_module_<?php echo $val['OrderItem']['id']; ?>">
				<p style="padding-right:10px"><?php for($i = 0; $i<$val['Feedback']['rating']; $i++){
					echo $html->image('blue-star.png',array('alt'=>''));
				}
				for($j = $i; $j < 5; $j++){
					echo $html->image('bl-start.png',array('alt'=>''));
				} ?> </p>
				<p><?php echo $this->Common->currencyEnter($val['Feedback']['feedback']);?>
				</p>
				<p style="text-align:right; font-size:11px; color:#969696;">Updated: <?php if(!empty($val['Feedback']['created'])) echo date('d/m/Y', strtotime($val['Feedback']['created'])); else echo '-';?></p>
  
			</div>
		</li>
	</ul>
</div>
<!--Seller Feedback Closed-->