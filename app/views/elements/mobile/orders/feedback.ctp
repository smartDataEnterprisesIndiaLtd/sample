<script defer="defer" type="text/javascript" src="/js/lib/prototype.js"></script>
<script defer="defer" type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
<script defer="defer" type="text/javascript" src="/js/behaviour.js"></script>
<script defer="defer" type="text/javascript" src="/js/textarea_maxlen.js"></script>
<script defer="defer" type="text/javascript" src="/js/smartstars.js"></script>
<?php
	//echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'), true);
	//echo $javascript->link(array('behaviour','textarea_maxlen'));
	//echo $javascript->link(array('smartstars'), true);
	$seller_id = $this->Session->read('User.id');

?>

<!--Row1 Start-->
<div class="row pad-btm0">
	<!--Products Start-->
	<div class="prod">
		<!--Order Products Widget Start-->
		<div class="order-products-widget pd-top-none">
		
		<ul class="order-info">                            	
		<li><p class="font11">Please contact the seller to resolve any problems before leaving feedback.</p></li>
		</ul>
		
		<div class="order-product-image">
			<?php
				$productImage = $this->Common->getProductImage($itemVal['OrderItem']['product_id']);
				$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$productImage;
				if(!file_exists($image_path) ){
					$image_path = 'no_image_50.jpg';
				}else{
					$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$productImage;
				}
			echo $html->link($html->image($image_path,array('width'=>"75",'height'=>"75",'alt'=>$itemVal['OrderItem']['product_name'],'title'=>$itemVal['OrderItem']['product_name'] )), "/".$this->Common->getProductUrl($itemVal['OrderItem']['product_id'])."/categories/productdetail/".$itemVal['OrderItem']['product_id'],array( 'escape'=>false));?>
			<!--img src="<?php //echo SITE_URL;?>img/mobile/order-img1.jpg" width="75" height="75" alt="" /-->
		</div>                        
		<!--Order Product Content Start-->
		<div class="order-product-content">                           
		<!--Order Product Information Start-->
		<div class="order-pro-info pad-tp">
			<p><?php echo $itemVal['OrderItem']['product_name']; ?></p>
			<p>
				<span class="gray">Seller:</span>
				<?php
				if(!empty($itemVal['OrderItem']['seller_name']))
				$sellerName = $itemVal['OrderItem']['seller_name'];
				  else
				$sellerName = '';
				if(!empty($itemVal['OrderItem']['seller_id']) && !empty($itemVal['OrderItem']['product_id']) && !empty($itemVal['OrderItem']['condition_id'])){
					$seller_name_url=str_replace(array(' ', '&'),array('-','and'),html_entity_decode($sellerName, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link($sellerName,'/sellers/'.$seller_name_url.'/summary/'.$itemVal['OrderItem']['seller_id'].'/'.$itemVal['OrderItem']['product_id'].'/'.$itemVal['OrderItem']['condition_id'],array('escape'=>false,'class'=>'underline-link'));
					}else{
					echo $sellerName;
				}
				
				//$bestseller_url=str_replace(array(' ','/','&quot;'), array('-','','"'), html_entity_decode($itemVal['OrderItem']['seller_name'], ENT_NOQUOTES, 'UTF-8'));
				//echo $html->link($itemVal['OrderItem']['seller_name'],'/'.$bestseller_url.'/sellers/summary/'.$itemVal['OrderItem']['seller_id'].'/'.$itemVal['OrderItem']['product_id'].'/'.$itemVal['OrderItem']['condition_id'],array('class'=>"underline-link",'escape'=>false));?>
			</p> 
		</div>
		<!--Order Product Information Closed-->
		</div>
		<!--Order Product Content Closed-->                        
		<div class="clear"></div>
		
	</div>
	<!--Order Products Widget Closed-->
	
	</div>
	<!--Products Closed-->
	
</div>
<!--Row1 Closed-->

<!--Confirm Request Start-->
<ul class="confirm-request">
<?php echo $form->create('Order',array('action'=>'add_feedback','method'=>'POST','name'=>'f'.$itemVal['OrderItem']['id'],'id'=>'frmAddFeedback_'.$itemVal['OrderItem']['id'])); ?>
<li><p class="pad-tp" style="float:left;padding-right:4px;">
	<span class="gray">Seller:</span> 
		<?php
		if(!empty($itemVal['OrderItem']['seller_name']))
		$sellerName = $itemVal['OrderItem']['seller_name'];
		  else
		$sellerName = '';
		if(!empty($itemVal['OrderItem']['seller_id']) && !empty($itemVal['OrderItem']['product_id']) && !empty($itemVal['OrderItem']['condition_id'])){
			$seller_name_url=str_replace(array(' ', '&'),array('-','and'),html_entity_decode($sellerName, ENT_NOQUOTES, 'UTF-8'));
			echo $html->link($sellerName,'/sellers/'.$seller_name_url.'/summary/'.$itemVal['OrderItem']['seller_id'].'/'.$itemVal['OrderItem']['product_id'].'/'.$itemVal['OrderItem']['condition_id'],array('escape'=>false,'class'=>'underline-link'));
			}else{
			echo $sellerName;
		}
		//$bestseller_url=str_replace(array(' ','/','&quot;'), array('-','','"'), html_entity_decode($itemVal['OrderItem']['seller_name'], ENT_NOQUOTES, 'UTF-8'));
		//echo $html->link($itemVal['OrderItem']['seller_name'],'/'.$bestseller_url.'/sellers/summary/'.$itemVal['OrderItem']['seller_id'].'/'.$itemVal['OrderItem']['product_id'].'/'.$itemVal['OrderItem']['condition_id'],array('class'=>"underline-link",'escape'=>false));?>
	</p>
	
	</li>
	<?php if ($session->check('Message.flash')){ ?>
		<li>
		 <div  class="messageBlock" style="margin:0;"><?php echo $session->flash();?></div>
		</li>
	<?php } ?>
	<li>
		<style>
			.SmartStarsLinks{display:inline-block;}
			.SmartStarsImages{margin:2px;}
		</style>
		<div calss="star-rating sel_rate" id="rate_module_<?php echo $itemVal['OrderItem']['id']; ?>" style="text-align:center;">
			<p style="padding-bottom:6px;"><span id='stars<?php echo $itemVal['OrderItem']['id'];?>'></span></p>
			<div id="commentField<?php echo $itemVal['OrderItem']['id'];?>">Choose a rating</div>
		</div>
	</li>

<li>
	<input type="hidden" size="1" name="t<?php echo $itemVal['OrderItem']['id'];?>" id="t<?php echo $itemVal['OrderItem']['id'];?>" >
	
<strong>Comments about your experience with this seller:</strong></li>
<li><p class="pad-rt2">
	<?php echo $form->input("Order.feedback".$itemVal['OrderItem']['id'],array('style'=>'width:99%; height:90px; padding:0px;', "label"=>false,"div"=>false,'rows'=>5,'maxlength'=>400, 'cols'=>30, 'class'=>'textfield full-width', 'showremain'=>"limitOne".$itemVal['OrderItem']['id'])); ?><?php echo $form->error('Order.feedback'); ?>
	</textarea>
	
</p></li>
<li>
	<p class="font11">Max. 400 characters, no HTML</p>
</li>
<li>
	<?php echo $form->hidden('Order.user_id',array('label'=>false,'div'=>false, 'value'=>$itemVal['Order']['user_id']));?>
	<?php echo $form->hidden('Order.seller_id',array('label'=>false,'div'=>false, 'value'=>$itemVal['OrderItem']['seller_id']));?>
	<?php echo $form->hidden('Order.product_id',array('label'=>false,'div'=>false, 'value'=>$itemVal['OrderItem']['product_id']));?>
	<?php echo $form->hidden('Order.order_id',array('label'=>false,'div'=>false, 'value'=>$itemVal['Order']['id']));?>
	<?php echo $form->hidden('Order.orderItemId',array('label'=>false,'div'=>false, 'value'=>$itemVal['OrderItem']['id']));?>
	<?php 
	$options = array(
	"url"=>"/orders/add_feedback","before"=>"",
	"update"=>"feedback_".$itemVal['OrderItem']['id'],
	"indicator"=>"plsLoaderID",
	'loading'=>"Element.show('plsLoaderID')",
	"complete"=>"Element.hide('plsLoaderID')",
	"class" =>"blkgradbtn",
	"type"=>"Submit",
	"id"=>"feedbackId".$itemVal['OrderItem']['id'],
	);
	?>
	<?php echo $ajax->submit('Submit Feedback',$options);?>	
	<!--<input type="button" class="blkgradbtn" value="Submit feedback">-->
	</li>
<?php echo $form->end(); ?>
<script defer="defer" type='text/javascript'>
		var itemId = <?php echo $itemVal['OrderItem']['id'];?>;
		document.getElementById('commentField'+itemId).firstChild.nodeValue="Choose a rating";
		function textDesc(idx)
		{
			var item_id = <?php echo $itemVal['OrderItem']['id'];?>;
			var comments=
			['I would not recommend this seller', 'Some improvement required',
			'Satisfactory service','Good',
			'Excellent, would use again'];
			document.getElementById('commentField'+item_id).firstChild.nodeValue=idx>-1 ? comments[idx] :"Choose a rating";
		}
		SmartStars.init('stars'+<?php echo $itemVal['OrderItem']['id'];?>, document.forms.f<?php echo $itemVal['OrderItem']['id'];?>.t<?php echo $itemVal['OrderItem']['id'];?>, 0, 5, "<?php echo SITE_URL;?>img/bl-start.png", "<?php echo SITE_URL;?>img/blue-star.png",textDesc );
		cnt = cnt+1;
	</script>

</ul>
<!--Confirm Request Closed-->




<!--Seller Feedback Closed-->