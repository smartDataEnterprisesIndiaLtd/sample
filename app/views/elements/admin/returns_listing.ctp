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
	<tr><td colspan=2>&nbsp;</td></tr>
	<tr>
		<td colspan="2">
			<?php if(isset($returns) && is_array($returns) && count($returns) > 0){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
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
							<td align="center" class="adminGridHeading" width="15%" >
								<?php echo $paginator->sort('Order Number', 'Order.order_number'); ?>
								<?php if($paginator->sortKey() == 'Order.order_number'){ echo $image; } ?>
							</td>
							<td align="center" class="adminGridHeading" width="20%" >
								<?php echo $paginator->sort('Return Submitted Date/Time', 'OrderReturn.created'); ?>
								<?php if($paginator->sortKey() == 'OrderReturn.created'){ echo $image; } ?>
							</td>
							<td align="center" class="adminGridHeading" width="15%" >
								<?php echo $paginator->sort('Customers Name', 'UserSummary.firstname'); ?>
								<?php if($paginator->sortKey() == 'UserSummary.firstname'){ echo ' '.$image; }?>
							</td>
							<td align="center" class="adminGridHeading" width="15%" >
								<?php echo $paginator->sort('Sellers Display Name', 'SellerSummary.firstname'); ?>
								<?php if($paginator->sortKey() == 'SellerSummary.firstname'){  echo ' '.$image; }?>
							</td>
							<td class="adminGridHeading" align="center" width="10%" >
								Action
							</td>
						</tr>
						<?php
						$class= 'rowClassEven';
						foreach ($returns as $return) {
						$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';?>
						<tr class="<?php echo $class; ?>" >
							<td align="center">
								<?php if(!empty($return['Order']['created'])) echo date(DATE_TIME_FORMAT,strtotime($return['Order']['created'])); ?>
							</td>
							<td align="center">
							<?php if(!empty($return['Order']['order_number'])) echo $html->link($return['Order']['order_number'],'/admin/orders/order_detail/'.$return['Order']['id'],array('escape'=>false)); ?>
							</td>
							<td align="center">
								<?php if(!empty($return['OrderReturn']['created'])) echo date(DATE_TIME_FORMAT,strtotime($return['OrderReturn']['created'])); ?>
							</td>
							<td align="center">
								<?php if(!empty($return['UserSummary']['firstname'])) echo $return['UserSummary']['firstname']; ?>
							</td>
							
							<td align="center">
							<?php if(!empty($return['OrderReturn']['sellers'])) echo $return['OrderReturn']['sellers']; ?>
							</td>
							<td align="center">
							<?php
							echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"order_returns","action"=>"view",$return['OrderReturn']['order_id']),array('escape'=>false,'title'=>'View'));
							// echo '&nbsp;';
							//  echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"order_returns","action"=>"delete",$return['OrderReturn']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));?>
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