<?php
$controller = $this->params['controller'];
echo $javascript->link('selectAllCheckbox');
?>
<?php
if(!empty($msgs_items)){
$key = $paginator->sortKey();
if(!empty($key)) {
	if($paginator->sortDir() == 'asc'){
		$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>'','div'=>false));
	} else if($paginator->sortDir() == 'desc'){
		$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>'','div'=>false));
	} else{
		$image = '';
	}
} else{
	$image ='';
}
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
			<?php if(isset($msgs_items) && is_array($msgs_items) && count($msgs_items) > 0){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
					<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
						<tr>
							<td class="adminGridHeading" align="center" width="20%">
								<?php echo $paginator->sort('Order Id', 'OrderItem.order_id'); ?>
								<?php if($paginator->sortKey() == 'OrderItem.order_id'){ echo $image; } ?>
							</td>
							<td class="adminGridHeading" align="center" width="25%" >
								Order Placed On
							</td>
							<td class="adminGridHeading" width="45%" >
								<?php echo $paginator->sort('Order Item', 'OrderItem.product_name'); ?>
								<?php if($paginator->sortKey() == 'OrderItem.product_name'){ echo $image; } ?>
							</td>
							<td class="adminGridHeading" align="center" width="10%" >
								Action
							</td>
						</tr>
						<?php
						$class= 'rowClassEven';
						foreach ($msgs_items as $msgs_item) {
						$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';?>
						<tr class="<?php echo $class; ?>" >
							<td align="center">
								<?php if(!empty($msgs_item['OrderItem']['OrderCre']['order_number'])) echo $msgs_item['OrderItem']['OrderCre']['order_number']; ?>
							</td>
							<td align="center">
								<?php if(!empty($msgs_item['OrderItem']['OrderCre']['created'])) echo date('d/m/Y',strtotime($msgs_item['OrderItem']['OrderCre']['created'])); ?>
							</td>
							<td>
								<?php if(!empty($msgs_item['OrderItem']['product_name'])) echo $msgs_item['OrderItem']['product_name']; ?>
							</td>
							<td align="center">
							<?php
							echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),"/admin/messages/item_msgs/".$msgs_item['OrderItem']['id'],array('escape'=>false,'title'=>'View')); ?>
							</td>
						</tr>
						<?php }?>
						<tr>
							<td  align="center" width="100%" colspan="6">
							<?php
							/************** paging box ************/
							echo $this->element('admin/paging_box');
							?>
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
	    		<?php }else{ ?>
			<table width="100%" cellpadding="2" cellspacing="0" border="0" class="adminBox">
				<tr>
				<td align="center">No record found</td>
				</tr>
			</table>
			<?php } ?>
		</td>
	</tr>
</table>
<?php }?>