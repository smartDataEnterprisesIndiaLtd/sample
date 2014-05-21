<?php
echo $javascript->link('selectAllCheckbox'); 
$add_url_string="/keyword:".$keyword."/searchin:".$fieldname;
?>
<?php
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
	<tr><td colspan = "2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
			<?php if(isset($cancelled_orders) && is_array($cancelled_orders) && count($cancelled_orders) > 0){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
					<tr>
						<td width="100%" colspan="4">
						<?php echo "Total Cancelled Order : " .$this->Paginator->counter(array('format' => __('%count%', true)));?>
						</td>
					</tr>
					
					<?php
					echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
					echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
					?>
					<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
						<tr>
							<td class="adminGridHeading" width="20%"  align="center">
								<?php echo $paginator->sort('Date/Time of Order', 'Order.created'); ?>
								<?php if($paginator->sortKey() == 'Order.created'){ echo $image; } ?>
							</td>
							<td align="center" class="adminGridHeading" width="20%" >
								<?php echo $paginator->sort('Order No.', 'Order.order_number'); ?>
								<?php if($paginator->sortKey() == 'Order.order_number'){ echo $image; } ?>
							</td>
							<td class="adminGridHeading" width="15%" >
								<?php echo $paginator->sort('Sellers Name', 'Seller.business_display_name'); ?>
								<?php if($paginator->sortKey() == 'Seller.business_display_name'){  echo ' '.$image; }?>
							</td>
							<td class="adminGridHeading" width="20%" >
								<?php echo $paginator->sort('Customers Name', 'UserSummary.firstname'); ?>
								<?php if($paginator->sortKey() == 'UserSummary.firstname'){ echo ' '.$image; }?>
							</td>
							
							
					<td class="adminGridHeading" width="25%"  align="left">
								Cancelled Date/Time
							</td>		
							<!--td class="adminGridHeading" width="15%" >
								<?php //echo $paginator->sort('Order Total', 'Order.order_total_cost'); ?>
								<?php //if($paginator->sortKey() == 'Order.order_total_cost'){ echo ' '.$image; }?>
							</td-->
							<!--<td class="adminGridHeading" align="center" width="10%" >
								Action
							</td>-->
						</tr>
						<?php
						$class= 'rowClassEven';
						foreach ($cancelled_orders as $cancelled_order) {
						$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';?>
						<tr class="<?php echo $class; ?>" >
							<td align="center">
								<?php if(!empty($cancelled_order['Order']['created'])) echo date(DATE_TIME_FORMAT,strtotime($cancelled_order['Order']['created'])); ?>
							</td>
							<td align="center">
							<?php 
								$orderId = $cancelled_order['Order']['id'];
								if(!empty($orderId) ){ 
									echo $html->link( $cancelled_order['Order']['order_number'], '/admin/orders/order_detail/'.$orderId, array('title'=>'view details')   );
								}
								?>
							</td>
							<td >
							<?php //if(!empty($cancelled_order['SellerSummary']['firstname'])) echo $cancelled_order['SellerSummary']['firstname']; ?>
							<?php //if(!empty($cancelled_order['SellerSummary']['lastname'])) echo $cancelled_order['SellerSummary']['lastname']; ?>
							<?php if(!empty($cancelled_order['Seller']['business_display_name'])) echo $cancelled_order['Seller']['business_display_name']; ?> 
							</td>
							<td >
								<?php if(!empty($cancelled_order['Order']['UserSummary']['firstname'])) echo $cancelled_order['Order']['UserSummary']['firstname']; ?> <?php if(!empty($cancelled_order['Order']['UserSummary']['lastname'])) echo $cancelled_order['Order']['UserSummary']['lastname']; ?>
								<?php //if(!empty($cancelled_order['Seller']['business_display_name'])) echo $cancelled_order['Seller']['business_display_name']; ?> 
							</td>
							
							
							<td align="left">
		<?php
				$str='';
				
				$cancelled_order_items = array_unique($cancelled_order['Order']['CanceledItem']);
				foreach($cancelled_order_items as $canceleditems)
				{
				if(!empty($canceleditems['created']))
				{
				$str .= date(DATE_TIME_FORMAT,strtotime($canceleditems['created'])).', ';	
				}	
				}
				echo rtrim($str,', ');
			
				?>				
		</td>
							<!--td >
								<?php //if(!empty($cancelled_order['Order']['order_total_cost'])) echo  CURRENCY_SYMBOL.' '.$cancelled_order['Order']['order_total_cost']; ?> 
							</td-->
<!-- 							<td align="center"> -->
							<?php
							//echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"order_returns","action"=>"view",$cancelled_order['Order']['id']),array('escape'=>false,'title'=>'View'));
							// echo '&nbsp;';
							//  echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"order_returns","action"=>"delete",$return['OrderReturn']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));?>
<!-- 							</td> -->
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