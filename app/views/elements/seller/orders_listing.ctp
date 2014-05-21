<?php
if(!empty($action)){
	$this->params['action']=$action;
}
$url = array(
	'action'=>'orders',
	'controller'=>'sellers',$filter
);
$paginator->options(array('url' => $url));
 ?>
<!--Search Widget Closed-->
<?php
if(!empty($orders)) {
	echo $this->element('seller/order_paging');
}
?>

<!--Search Widget Start-->
<?php echo $form->create('Seller',array('action'=>'orders','method'=>'POST','name'=>'frm1','id'=>'frm1'));?>
<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
<div class="gray-color-bar border-top-botom-none" id="width_div">
	<ul>
		<li>
			<b>Filter </b><?php echo $form->select('Listing1.options',$filter_time,null,array('class'=>'form-select', 'type'=>'select','onChange'=>'updateFiltertext("1","2")'),'-- Select --'); ?>
			<?php $options=array(
				"url"=>"/sellers/get_sellerOrders","before"=>"",
				"update"=>"listing",
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"v-align-middle",
				'div'=>false,
				"type"=>"Submit",
				"id"=>"update_listing1",
			);?>
			<?php echo $ajax->submit('go-grn-btn.gif',$options);?>
		</li>
	</ul>
</div>
<!--Search Widget Closed-->
<!--Search Products Start-->
<?php
// pr($paginator->sortDir());
// if(!empty($ajaxflag)){
	$sortdir = $paginator->sortDir();

// 	$sortdir = 'desc';
// }

if($sortdir == 'asc'){
	$image = $html->image('d-arrow-icon.gif',array('border'=>0,'alt'=>''));
} else {
	$image = $html->image('u-arrow-icon.gif',array('border'=>0,'alt'=>''));
}
?>
<div class="scroll-div">
	<table width="100%" border="1" bordercolor="#cccccc" rules="all" frame="void" cellspacing="0" cellpadding="5" style="border-collapse:collapse;" class="seller-listings">
		<tr>
			<td width="12%">
				<?php echo $paginator->sort('Order Date', 'Order.created');?>
			</td>
			<td width="35%">
				<b>Order Number</b>
			</td>
			<td width="10%">
				<b>Contact Buyer</b>
			</td>
			<td width="11%">
				<?php echo $paginator->sort('Shipping Service', 'OrderSeller.shipping_service');?>
			</td>
			<td width="13%"><?php echo $paginator->sort('Status', 'OrderSeller.shipping_status');?></td>
			<td width="12%"><b>Order Value</b></td>
			<td width="11%"> </td>
		</tr>
		<tr>
			<td><?php if($paginator->sortKey() == 'Order.created'){
				echo $image; 
			} else{
				//echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
			}?></td>
			<td> </td>
			<td> </td>
			<td><?php if($paginator->sortKey() == 'OrderSeller.shipping_service'){
				echo $image; 
			} else{
				//echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
			}?></td>
			<td><?php if($paginator->sortKey() == 'OrderSeller.shipping_status'){
				echo $image; 
			} else{
				//echo $html->image("d-arrow-icon.gif" ,array('width'=>"11",'height'=>"6" ,'alt'=>"" ));
			}?></td>
			<td> </td>
			<td> </td>
		</tr>
		<?php  //pr($conditionArr);
		if(!empty($orders)) {
		$i = 1;
		foreach($orders as $order) {
			if(($i%2) == 0){ $classtr = 'even'; } else { $classtr = 'odd'; } ?>
		<tr class = <?php echo $classtr;?> >
			<td align="left" valign="top"><?php if(!empty($order['Order']['created'])) echo date(ORDER_DATE_FORMAT,strtotime($order['Order']['created'])); else echo '-'; ?></td>
			<td align="left"><?php
				if(!empty($order['OrderSeller']['order_id'])){
					$or_id = $order['OrderSeller']['order_id'];
					$order_number = $order['Order']['order_number']; //$or_id.'-'.date('dmsiH',strtotime($order['Order']['created'])).'-'.$order['Order']['user_id'];
				}else{
					$or_id = '-';$order_number ='-';
				}echo $html->link('<strong>'.$order_number.'</strong>','/sellers/order_details/'.base64_encode($or_id),array('escape'=>false,'class'=>'underline-link'));
				if(!empty($order['Items'])){
					foreach($order['Items'] as $or_item){
						echo '<p><strong>'.$or_item['OrderItem']['product_name'].'<br></strong></p>';
					}
				} else { echo '-';}
				?>
			</td>
			<td valign ="top">
				<?php if(!empty($order['Items'])){
					foreach($order['Items'] as $or_item){
						if(!empty($or_item['OrderItem']['id'])){
							$or_it_id = $or_item['OrderItem']['id'];
							break;
						}
					}
				} else { echo '-';}
				echo '<p>&nbsp;</p>';
				if(!empty($order['Order']['UserSummary']['firstname'])) {
					if(!empty($or_it_id))
						echo $html->link($order['Order']['UserSummary']['firstname'].'&nbsp;'.$order['Order']['UserSummary']['lastname'],'/messages/sellers/'.$or_it_id,array('escape'=>false,'alt'=>''));
					else
						echo $order['Order']['UserSummary']['firstname'].'&nbsp;'.$order['Order']['UserSummary']['lastname'];
				} else
					echo '-'; ?>
			</td>
			<td>
				<?php
				echo '<p>&nbsp;</p>';
				if(!empty($order['Items'])){
					foreach($order['Items'] as $or_item){
						if($or_item['OrderItem']['delivery_method'] == 'E'){
							$shiping_service = 'Express';
						} else {
							$shiping_service = 'Standard';
						}
						echo '<p>'.$shiping_service.'</p>';
	
					}
				} else { echo '-';}
				?>
			</td>
			<td><?php if(!empty($order['OrderSeller']['shipping_status'])){
					if($order['OrderSeller']['shipping_status'] == 'Unshipped' || $order['OrderSeller']['shipping_status'] == 'Cancelled'){
						echo '<p class="red-color line-break"><strong>'.$order['OrderSeller']['shipping_status'].'</strong></p>';
						if($order['OrderSeller']['shipping_status'] == 'Unshipped'){
							echo $html->link($html->image('change-btn.png',array('height'=>'16','width'=>'57','alt'=>"")),'/sellers/ship_order/'.base64_encode($order['OrderSeller']['order_id']),array('escape'=>false,'alt'=>''));
						}
						if($order['OrderSeller']['shipping_status'] == 'Cancelled'){
							echo '<p>'.date(ORDER_DATE_FORMAT,strtotime($order['OrderSeller']['modified'])).'</p>';
						}
					} else if($order['OrderSeller']['shipping_status'] == 'Part Shipped'){
						echo '<p class="red-color line-break"><strong>'.$order['OrderSeller']['shipping_status'].'</strong><br>'.$html->link('Remove Items','/sellers/cancel_orderitems/'.base64_encode($order['OrderSeller']['order_id']),array('escape'=>false,'alt'=>'Cancel items','title'=>'Cancel items','class'=>'red-color','style'=>'text-decoration:underline')).'</p>';
					} else{
						echo '<p><strong>'.$order['OrderSeller']['shipping_status'].'</strong></p>';
						echo '<p>'.date(ORDER_DATE_FORMAT,strtotime($order['OrderSeller']['modified'])).'</p>';
					}
				} else echo '-'; ?></td>
			<td><?php if(!empty($order['Items'])){
					
					$order_value = 0;$order_delivery = 0;$delivery_chr = 0;
					foreach($order['Items'] as $or_item){
						
						$amount = 0;
						$unit_price = $or_item['OrderItem']['price'];
						$qty = $or_item['OrderItem']['quantity'];
						$amount = $unit_price * $qty;
						if(empty($or_item['OrderItem']['giftwrap_cost']))
							$or_item['OrderItem']['giftwrap_cost'] = 0;
						$order_value = $order_value + $amount + ($qty*$or_item['OrderItem']['giftwrap_cost']);
						
						$delivery_chr = $delivery_chr + ($or_item['OrderItem']['delivery_cost']*$qty);
					}
					echo '<b>'.CURRENCY_SYMBOL.$format->money($order_value,2).'</b><br />+ '.CURRENCY_SYMBOL.$format->money($delivery_chr,2).' Delivery';
				} else { echo '-';} ?></td>
			<td>
				<?php
				if($order['OrderSeller']['shipping_status'] == 'Part Shipped'){ ?>
					<p><a class="underline-link display-bl" href="#"><?php echo $html->link('Edit Shipments','/sellers/ship_order/'.base64_encode($order['OrderSeller']['order_id']).'/'.base64_encode('edit'),array('escape'=>false,));?>
					</p>
				<?php }
				if(($order['OrderSeller']['shipping_status'] == 'Part Shipped') || ($order['OrderSeller']['shipping_status'] == 'Shipped')){ ?>
					<p><?php echo $html->link($html->image("refund-btn.png",array('height'=>"16",'width'=>"66", 'alt'=>"")),'/sellers/refund_order/'.base64_encode($order['OrderSeller']['order_id']),array('escape'=>false,'class'=>'display-bl margin-top'));?></p>
				<?php }
				if($order['OrderSeller']['shipping_status'] == 'Unshipped'){ ?>
				<p><?php echo $html->link($html->image("cancel-refund-btn.png",array('height'=>"16", 'width'=>"110", 'alt'=>"")),'/sellers/cancel_order/'.base64_encode($order['OrderSeller']['order_id']),array('escape'=>false)); ?></p>
				<?php }
				if($order['OrderSeller']['shipping_status'] == 'Cancelled'){ ?>
				<p></p>
				<?php } ?>
			</td>
		</tr>
		<?php $i++; }?>
		
		<?php } else { ?>
			<tr>
				<td colspan="7">
					<div class="gray-color-bar border-top-botom-none">
						<ul>
							<li>
								No orders found
							</li>
						</ul>
					</div>
				</td>
			</tr>
		<?php } ?>
	</table>
</div>
<div class="gray-color-bar border-top-botom-none">
	<ul>
		<li>
			<b>Filter </b><?php echo $form->select('Listing2.options',$filter_time,null,array('class'=>'form-select bigger-input', 'type'=>'select','onChange'=>'updateFiltertext("2","1")'),'-- Select --'); ?>
			<?php $options=array(
				"url"=>"/sellers/get_sellerOrders","before"=>"",
				"update"=>"listing",
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"v-align-middle",
				'div'=>false,
				"type"=>"Submit",
				"id"=>"update_listing2",
			);?>
			<?php echo $ajax->submit('go-grn-btn.gif',$options);?>
		</li>
	</ul>
</div>
<!--Search Products Closed-->
<?php echo $form->end();?>

<?php
if(!empty($orders)) {
	echo $this->element('seller/order_paging');
}
?>

<?php echo $form->create('Seller',array('action'=>'orders','method'=>'POST','name'=>'frmlimit','id'=>'frmlimit'));?>
<div style="padding:10px 8px">
	<ul>
		<li>
			<?php
			echo $form->hidden('Page.action',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['action']));
			echo $form->hidden('Page.filter',array('class'=>'textfield-input num-width','label'=>false,'div'=>false));
			echo $form->hidden('Page.url',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$this->params['url']['url']));
			?>
			Show <?php echo $form->select('Paging.options',array('25'=>'25','50'=>'50','100'=>'100','150'=>'150','200'=>'200','250'=>'250'),null,array('class'=>'form-select', 'type'=>'select','style'=>'width:80px','onChange'=>'return setLimit(this.value)'),'-- Select --');?> results per page
		</li>
	</ul>
</div>
<?php echo $form->end();?>
<!--Search Widget Closed-->

<script type="text/javascript">
	function setLimit(limit){
		document.frmlimit.submit();
	}
	//alert(jQuery('#width_div').width());
</script>