<?php
	$this->Paginator->options(array(
	'update' => '#test123',
	'evalScripts' => true,
	'url'=>array('controller'=>'messages', 'action'=>'order_inbox'),
	));
?>
<?php

$sortdir = 'desc';
if(!empty($ajaxflag))
	$sortdir = $paginator->sortDir();

if($sortdir == 'asc'){
	$image = $html->image('d-arrow-icon.gif',array('border'=>0,'alt'=>''));
} else{
	$image = $html->image('u-arrow-icon.gif',array('border'=>0,'alt'=>''));
}
?>
<!--Paging Widget Start-->
<div class="search-paging" id="outboxidDisplay">
	<table border="0" cellspacing="2" cellpadding="0" width="100%">
		<tr>	<?php //pr($this->params);?>
			<?php if($this->params['paging']['OrderItem']['page'] == 1){
				$from = 1;
				if($this->params['paging']['OrderItem']['count'] == $this->params['paging']['OrderItem']['current'])
					$to = $this->params['paging']['OrderItem']['count'];
				else
					$to = $this->params['paging']['OrderItem']['defaults']['limit'];
			} else{
				$from = ($this->params['paging']['OrderItem']['page'] - 1) * ($this->params['paging']['OrderItem']['defaults']['limit']) + 1;
				if($this->params['paging']['OrderItem']['page'] == $this->params['paging']['OrderItem']['pageCount']) {
					$to = $this->params['paging']['OrderItem']['count'];
				} else {
					$to = ($this->params['paging']['OrderItem']['page']) * ($this->params['paging']['OrderItem']['defaults']['limit']);
				}
			}
			if($from < 0){
				$from = 0;
			}
			
			?>
			<td>Orders <strong><?php echo $from; ?></strong> to <strong><?php echo $to; ?></strong> of <strong><?php echo $this->params['paging']['OrderItem']['count'];?></strong></td>
			<td id="pagingtd" align="right" style="vertical-align:top">
				<?php if($this->Paginator->numbers() != '') {
				echo $form->create('Message',array('action'=>'gotoPage','method'=>'POST','name'=>'frmMessage','id'=>'frmMessage','div'=>false,'style'=>"width:100px;float:left"));
				echo $form->input('Page.goto_page',array('class'=>'textfield-input num-width','label'=>false,'div'=>false));
				echo $form->hidden('Page.filter_val',array('type'=>'text','div'=>false,'value'=>@$filter));?> <?php
				$options=array(
					"url"=>"/messages/gotoPage","before"=>"",
					"update"=>"OrderInbox",
					"indicator"=>"plsLoaderID",
					'loading'=>"showloading()",
					"complete"=>"hideloading()",
					"class" =>"v-align-middle",
					"type"=>"Submit",
					"id"=>"goToPage",
					'div'=>false
				);
				echo $ajax->submit('/img/go-grn-btn.gif',$options);
				echo $form->end();
				} ?>
				
				
				
				<?php //if($this->Paginator->prev('Prev') || $this->Paginator->prev('Next')){ ?>
				<!--span class="padding-left"><strong>Page: </strong--><?php //}?>
				
				<?php //echo $this->Paginator->prev('Prev',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
				<?php //echo $this->Paginator->numbers(array('separator'=>'','tag' => 'li')); ?>
				<?php //echo $this->Paginator->next('Next',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
				<span class="padding-left pagingdef" id="outboxid">
					<ul>
						<?php $options = array(
							'url'=> array(
							    'controller' => 'messages', 
							    'action' => 'order_inbox', 
							    '?' => 'filter='.$filter
							 ),
							'class'=>'active',
							'tag' => 'li',
							'escape'=>false,
							);
						?>
						<?php echo $this->Paginator->prev('Prev',$options);?>
						<?php echo $this->Paginator->numbers(array('separator'=>'','tag' => 'li','options' => $options)); ?>
						<?php echo $this->Paginator->next('Next',$options);?>
						
					</ul>
				</span>
			</td>
		</tr>
	</table>
</div>
<!--Paging Widget Closed-->
<!--Search Widget Start-->
<div class="gray-color-bar border-top-botom-none">
	<?php echo $form->create('Message',array('action'=>'order_inbox','method'=>'POST','name'=>'frmMessage','id'=>'frmMessage','div'=>false));?>
	<ul>
		<li><b>Filter </b><?php echo $form->select('Page.filter',$filter_time,@$filter,array('class'=>'form-select', 'type'=>'select'),'-- Select --'); ?>
			<?php $options=array(
				"url"=>"/messages/order_inbox","before"=>"",
				"update"=>"OrderInbox",
				"indicator"=>"plsLoaderID",
				'loading'=>"showloading()",
				"complete"=>"hideloading()",
				"class" =>"v-align-middle",
				'div'=>false,
				"type"=>"Submit",
				"id"=>"filterPage",
			);?>
			<?php echo $ajax->submit('go-grn-btn.gif',$options);?>
		</li>
	</ul>
	<?php echo $form->end();?>
</div>
<!--Search Widget Closed-->
<!--Search Products Start-->
<div class="scroll-div border-bottom">
	<table frame="void" cellspacing="0" cellpadding="5" bordercolor="#cccccc" border="1" width="100%" rules="all" class="seller-listings" style="border-collapse: collapse;">
		<tbody>
			<tr>
				<td width="20%" id="sortdate"><?php echo $paginator->sort('Order Date', 'Order.created');?>
				</td>
				<td width="50%"><strong>Order Number</strong></td>
				<td width="30%"><strong>Contact Buyer</strong></td>
			</tr>
			<?php
			
			if(!empty($seller_orders)){ ?>
			<tr>
				<td><?php //if($paginator->sortKey() == 'Order.created'){
				echo $image;
				//}?></td>
				<td> </td>
				<td> </td>
			</tr>
			<?php	
				$count = 1;
				foreach($seller_orders AS $oKey=>$oVal){ //pr($oVal);
				if($count%2==0){ 
					$class="even";
				}else{ 
					$class="odd";
				}
			?>
			<tr class="<?php echo $class; ?>">
				<td align="left" valign="top"><p><?php if(!empty($oVal['Order']['created'])) echo date('d F Y', strtotime($oVal['Order']['created'])); ?></p>
					<p><?php echo date('H:i:s', strtotime($oVal['Order']['created'])); ?></p>
				</td>
				<td align="left"><p><?php echo $html->link('<strong>'.@$oVal['Order']['order_number'].'</strong>','/sellers/order_details/'.base64_encode(@$oVal['Order']['id']),array('escape'=>false,'class'=>'underline-link')); ?></p>
				<p><strong><?php echo @$oVal['OrderItem']['product_name']; ?></strong></p>
				</td>
					<td><?php echo $ajax->link(ucwords($oVal[0]['username']),'', array('escape'=>false,'update' => 'msg_area', 'url' => '/messages/item_msgs/'.@$oVal['OrderItem']['id'],'id'=>'link-'.@$oVal['OrderItem']['id'],'class'=>'underline-link',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading()"), null,false);
				?></td>
			</tr>
			<?php $count++; }?>
			<?php }else{ ?>
			<tr>
				<td colspan="3">No orders found</td>
			</tr>	
			<?php } ?>
		</tbody>
	</table>
</div>
<!--Search Products Closed-->
<?php //echo $js->writeBuffer(); ?>
<script type="text/javascript">
jQuery(document).ready(function(){


jQuery('#sortdate a').click(function(){
	var ajax_url= jQuery(this).attr('href');
			
	jQuery.ajax({
		url: ajax_url,
		success: function(msg){
		jQuery('div#OrderInbox').html(msg);	
  	}
	});
	return false;
	});

jQuery('#outboxid li a').click(function(){
	var ajax_url= jQuery(this).attr('href');
	var return_homeURL = SITE_URL+'users/sign-in';
	jQuery('#plsLoaderID').show();
	jQuery('#fancybox-overlay-header').show();
	jQuery.ajax({
		url: ajax_url,
		success: function(msg){
		jQuery('#plsLoaderID').hide();
		if(msg == 'SessionExpired'){
			window.location.assign(return_homeURL);
			return false;
		}
		jQuery('#OrderInbox').html(msg);
		jQuery('#fancybox-overlay-header').hide();
  	}
	});
	return false;
	
	});

});
</script>