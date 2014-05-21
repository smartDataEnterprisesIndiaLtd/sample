<?php
	//echo $javascript->link(array('lib/prototype'), false);
	echo $javascript->link(array('behaviour','textarea_maxlen'));
	echo $javascript->link(array('smartstars'));
	$seller_id = $this->Session->read('User.id');

?>

<!--Seller Feedback Start-->
<div class="order-pro-info">
	<ul class="order-info">
		<li><?php echo $itemVal['OrderItem']['product_name']; ?></li>
		<li>
			<p class="smalr-fnt">Please contact seller to resolve any problems before leaving feedback</p>
			<p><span class="gray">Seller:</span>
			<?php 
				?>
			
			<?php
			if(!empty($itemVal['OrderItem']['seller_name']))
				$sellerName = $itemVal['OrderItem']['seller_name'];
				  else
				$sellerName = '';
				if(!empty($itemVal['OrderItem']['seller_id']) && !empty($itemVal['OrderItem']['product_id']) && !empty($itemVal['OrderItem']['condition_id'])){
					$seller_name_url=str_replace(' ','-',html_entity_decode($sellerName, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link($sellerName,'/sellers/'.$seller_name_url.'/summary/'.$itemVal['OrderItem']['seller_id'].'/'.$itemVal['OrderItem']['product_id'].'/'.$itemVal['OrderItem']['condition_id'],array('escape'=>false,'class'=>'underline-link'));
					}else{
					echo $sellerName;
				}
			//$bestseller_url=str_replace(array(' ','/','&quot;'), array('-','','"'), html_entity_decode($val['OrderItem']['seller_name'], ENT_NOQUOTES, 'UTF-8'));
			//echo $html->link($itemVal['OrderItem']['seller_name'],'/'.$bestseller_url.'/sellers/summary/'.$itemVal['OrderItem']['seller_id'].'/'.$itemVal['OrderItem']['product_id'].'/'.$itemVal['OrderItem']['condition_id'],array('class'=>"underline-link",'escape'=>false));?></p>
			<div id="rate_module_<?php echo $itemVal['OrderItem']['id']; ?>">
				<style type='text/css'>
				a.SmartStarsLinks{padding:0px}
				.SmartStarsImages{margin:0px; border:none}
				</style>
				<p>
				<span id='stars<?php echo $itemVal['OrderItem']['id'];?>' style="float:left;padding-right:10px"></span> 
				<div id="commentField<?php echo $itemVal['OrderItem']['id'];?>" style="display: block; font-size:11px;">Rate it</div>
				</p>
			</div>
		</li>
		<li class="last-pro-dis">
			<?php echo $form->create('Order',array('action'=>'add_feedback','method'=>'POST','name'=>'f'.$itemVal['OrderItem']['id'],'id'=>'frmAddFeedback_'.$itemVal['OrderItem']['id'])); ?>

			<input type="hidden" size="1" name="t<?php echo $itemVal['OrderItem']['id'];?>" id="t<?php echo $itemVal['OrderItem']['id'];?>" >

			<p class="pad-btm"><strong>Comment about your experience with this seller:</strong></p>
			<?php if ($session->check('Message.flash')){ ?>
			<div  class="messageBlock"><?php echo $session->flash();?></div>
			<?php } ?>
			<p>
			<?php echo $form->input("Order.feedback".$itemVal['OrderItem']['id'],array('style'=>'width:99%; height:90px; padding:0px;', "label"=>false,"div"=>false,'rows'=>5,'maxlength'=>400, 'cols'=>45, 'class'=>'form-textfield', 'showremain'=>"limitOne".$itemVal['OrderItem']['id'])); ?><?php echo $form->error('Order.feedback'); ?>
			</p>
			<p class="pad-tp smalr-fnt">Max. 400 characters, no HTML
			<br />
			Remaining characters: <span id ="limitOne<?php echo $itemVal['OrderItem']['id'];?>"><?php if(!empty($this->data)){
				if(!empty($this->data['Order']['feedback'.$itemVal['OrderItem']['id']])) { 
					$remain = 400 - strlen($this->data['Order']['feedback'.$itemVal['OrderItem']['id']]);
					echo $remain;
				} else {
					echo '400'; 
				} 
			} else { 
				echo '400'; } ?></span></p>

			<!--<p class="pad-tp"><input type="image" src="/img/submit-feedback.gif" name="button2" value=" " /></p>-->
			<p class="pad-tp">
				<?php echo $form->hidden('Order.user_id',array('label'=>false,'div'=>false, 'value'=>$itemVal['Order']['user_id']));?>
				<?php echo $form->hidden('Order.seller_id',array('label'=>false,'div'=>false, 'value'=>$itemVal['OrderItem']['seller_id']));?>
				<?php echo $form->hidden('Order.product_id',array('label'=>false,'div'=>false, 'value'=>$itemVal['OrderItem']['product_id']));?>
				<?php echo $form->hidden('Order.order_id',array('label'=>false,'div'=>false, 'value'=>$itemVal['Order']['id']));?>
				<?php echo $form->hidden('Order.orderItemId',array('label'=>false,'div'=>false, 'value'=>$itemVal['OrderItem']['id']));?>
				<?php //echo $form->input('Order.rating.'.$itemVal['OrderItem']['id'],array('label'=>false,'div'=>false,'value'=>''));?>
				
				
				<?php 
					$options = array(
					"url"=>"/orders/add_feedback","before"=>"",
					"update"=>"feedback_".$itemVal['OrderItem']['id'],
					"indicator"=>"plsLoaderID",
					'loading'=>"showloading()",
					"complete"=>"hideloading()",
					"class" =>"blk-bg-input-small-long margin_left_0",
					"type"=>"Submit",
					"id"=>"feedbackId".$itemVal['OrderItem']['id'],
					);
				?>
				<?php echo $ajax->submit('Submit Feedback',$options);?>
			</p>

			<?php echo $form->end(); ?>
			<script type='text/javascript'>
				var itemId = <?php echo $itemVal['OrderItem']['id'];?>;
				document.getElementById('commentField'+itemId).firstChild.nodeValue= "Rate it";

				function textDesc(idx)
				{
					var item_id = <?php echo $itemVal['OrderItem']['id'];?>;
					var comments=
					['I would not recommend this seller', 'Some improvement required',
					'Satisfactory service','Good',
					'Excellent, would use again'];
					document.getElementById('commentField'+item_id).firstChild.nodeValue=idx>-1 ? comments[idx] : "Rate it";
				}
				SmartStars.init('stars'+<?php echo $itemVal['OrderItem']['id'];?>, document.forms.f<?php echo $itemVal['OrderItem']['id'];?>.t<?php echo $itemVal['OrderItem']['id'];?>, 0, 5, "<?php echo SITE_URL;?>img/bl-start.png", "<?php echo SITE_URL;?>img/blue-star.png",textDesc );
 				cnt = cnt+1;
			</script>
		</li>
	</ul>
</div>
<!--Seller Feedback Closed-->