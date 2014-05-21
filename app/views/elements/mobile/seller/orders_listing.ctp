<?php echo $html->script('jquery-1.4.3.min',true);?>

<?php if(!empty($orders)) { ?>
<!--Search Results Start-->
<p style="text-align:justify;">To view more information about the order, such as the buyer name or shipping address click on the order number.</p>

<div class="overflow-h padding-top10">
	<!--Paging Widget Start-->
		<?php echo $this->element('mobile/seller/order_paging'); ?>
	<!--Paging Widget Closed-->

	<!--Search Widget Start-->
	<div class="gry-clr-br brdr-tp-btm-nn">
		<ul>
		<?php echo $form->create('Seller',array('action'=>'orders','method'=>'POST','name'=>'frm1','id'=>'frm1'));?>
		<li><strong>Filter</strong>
			<?php echo $form->select('Listing1.options',$filter_time,null,array('class'=>'form-select', 'type'=>'select','onChange'=>'updateFiltertext("1","2")'),'-- Select --'); ?>
			
			<!--<select name="select2" class="form-select">
			<option>All Time</option>
			</select>-->
			<?php $options=array(
				"url"=>"/sellers/get_sellerOrders/testpage:1","before"=>"",
				"update"=>"viewOrders-listing",
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"grngradbtn",
				'div'=>false,
				"type"=>"Submit",
				"id"=>"update_listing1",
			);?>
			<?php echo $ajax->submit('Go',$options);?>
			
			<!--<input type="submit" name="button2" value="Go" onclick="filterlist()" class="grngradbtn" />-->
		</li>
		<?php echo $form->end();?>
		</ul>
	</div>
	<!--Search Widget Closed-->

	<!--Search Products Start-->
	<div class="scroll-div">                                
		<table width="100%" border="1" bordercolor="#cccccc" rules="all" frame="void" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" class="seller-listings">
		
			<tr>
			<td width="20%"><?php echo $paginator->sort('Order Date', 'Order.created');?><!--<a href="#">Order Date</a>--></td>
			<td width="60%"><strong>Order Number</strong></td>
			<td width="20%"><strong>Value</strong></td>
			</tr>
			<?php
				if($paginator->sortDir() == 'asc'){
					$image = $html->image('d-arrow-icon.gif',array('border'=>0,'alt'=>''));
				}
				else if($paginator->sortDir() == 'desc'){
					$image = $html->image('u-arrow-icon.gif',array('border'=>0,'alt'=>''));
				}
				else{
					$image = $html->image('d-arrow-icon.gif',array('border'=>0,'alt'=>''));
				}
			?>
			<tr>
			<td>
				<?php if($paginator->sortKey() == 'Order.created'){
					echo $image; 
				}?>
			</td>
			<td> </td>
			<td> </td>
			</tr>
			
			<?php  //pr($conditionArr);
			$i = 1;
			foreach($orders as $order) {
			if(($i%2) == 0){ $classtr = 'even'; } else { $classtr = 'odd'; } ?>
			<tr class = <?php echo $classtr;?> >
			<td align="left" valign="top">
				<!--<p>Aug-18-2011</p>
				<p>09:44:38</p>-->
				<?php if(!empty($order['Order']['created'])) echo date('F-d-Y \<\b\r\/\> H:i:s',strtotime($order['Order']['created'])); else echo '-'; ?>
			</td>
			<td align="left">
				
					<?php
					if(!empty($order['OrderSeller']['order_id'])){
						$or_id = $order['OrderSeller']['order_id'];
						$order_number = $order['Order']['order_number']; //$or_id.'-'.date('dmsiH',strtotime($order['Order']['created'])).'-'.$order['Order']['user_id'];
					}else{
						$or_id = '-';$order_number ='-';
					}echo $html->link('<p><strong>'.$order_number.'</strong></p>','/sellers/order_details/'.base64_encode($or_id),array('escape'=>false,'class'=>'underline-link'));
					if(!empty($order['Items'])){
						foreach($order['Items'] as $or_item){
							echo '<p><strong>'.$or_item['OrderItem']['product_name'].'<br></strong></p>';
						}
					} else { echo '-';}
					?>
				<!--<a href="#"><strong>100207-1908241606-240393</strong></a>-->
				
			<!--<p><strong>Goddards Long Term Silver</strong></p>
			<p><strong>Loctite Super Glue 3g</strong></p>
			<p><strong>Loctile Precision Super Glue</strong></p>--></td>
			<td>
				<!--<p><strong>&pound;11.00</strong></p>
				<p>+ &pound;14.85</p>-->
				<?php if(!empty($order['Items'])){
					
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
					echo '<p><strong>'.CURRENCY_SYMBOL.$format->money($order_value,2).'</strong></p>
					<p>+ '.CURRENCY_SYMBOL.$format->money($delivery_chr,2).'</p>';
				} else { echo '-';} ?>
			</td>
			</tr>
			<?php }?>
			
		</table>
	
	</div>
	<!--Search Products Closed-->

	<!--Paging Widget Start-->
	<div class="srch-pg" style="padding:8px 0; border-top:1px #ccc solid;">
	<ul>
		<?php echo $this->element('mobile/seller/order_paging_footer'); ?>
	</ul>
	</div>
	
	
<!--Paging Widget Closed-->
</div>
<!--Search Products Closed-->
<?php } else { ?>
<div class="gray-color-bar border-top-botom-none">
	<ul>
		<li>
			No record found
		</li>
	</ul>
</div>
<?php } ?>