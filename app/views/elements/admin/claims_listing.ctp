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
//pr($claims);

?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td colspan=2>&nbsp;</td></tr>
	<tr>    <td colspan="2">Total Claims : <?php echo $this->Paginator->counter(array('format' => '%count%'));?></td></tr>
	<tr>
		<td colspan="2">
		<?php if(isset($claims) && is_array($claims) && count($claims) > 0){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
					<?php
					echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
					echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
					?>
					<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
						
						<tr>
							<td  align="center" width="100%" colspan="6">
							<?php
							/************** paging box ************/
							echo $this->element('admin/paging_box');
							?>
							</td>
						</tr>
						<tr>
							<td class="adminGridHeading" width="20%"  align="center">
								<?php echo $paginator->sort('Date/Time of Order', 'Order.created'); ?>
								<?php if($paginator->sortKey() == 'Order.created'){ echo $image; } ?>
							</td>
							<td align="center" class="adminGridHeading" width="15%" >
								<?php echo $paginator->sort('Order Number', 'Order.id'); ?>
								<?php if($paginator->sortKey() == 'Order.order_number'){ echo $image; } ?>
							</td>
							<td align="center" class="adminGridHeading" width="20%" >
								<?php echo $paginator->sort('Claim Form Submitted Date', 'Claim.created'); ?>
								<?php if($paginator->sortKey() == 'Claim.created'){ echo $image; } ?>
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
						foreach ($claims as $claim) {
						$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';?>
						<?php
						$replied_seller = array();
						
						$replied_seller = explode(',',$claim['0']['totalclaimid']);
						$all_is_replied_seller = explode(',',$claim['0']['all_is_replied_seller']);
						$all_is_replied_buyer = explode(',',$claim['0']['all_is_replied_buyer']);
						
						$t_replied_seller = count($replied_seller);
						for($i = 0; $i < $t_replied_seller; $i++){
							
							//pr($all_is_replied_seller);
							//echo $i;
							//echo $all_is_replied_seller[$i];
							if($all_is_replied_seller[$i] == "1" && $all_is_replied_buyer[$i] == "1"){
								$class1 = 'bggreen';
							}elseif($all_is_replied_seller[$i] == "1" && $all_is_replied_buyer[$i] == "0"){
								$class1 = 'bgsky';
							}elseif($all_is_replied_seller[$i] == "0" && $all_is_replied_buyer[$i] == "1"){
								$class1 = 'bgred';
							}else{
								$class1 = '';
							}
							
							
						}
							/*if(in_array("0",$replied_seller)){
								echo "not replayed";
							}else{
								echo "replayed";
							}*/
						?>
						
						
						<tr class="<?php echo $class.' '.$class1;?>" >
							
							<td align="center">
								<?php if(!empty($claim['Order']['created'])) echo date(DATE_TIME_FORMAT,strtotime($claim['Order']['created'])); ?>
							</td>
							<td align="center">
							<?php if(!empty($claim['Order']['order_number'])) echo $claim['Order']['order_number']; ?>
							</td>			
							<td align="center">
								<?php if(!empty($claim['Claim']['created'])) echo date(DATE_TIME_FORMAT,strtotime($claim['Claim']['created'])); ?>
							</td>
							<td align="center">
								<?php if(!empty($claim['UserSummary']['firstname'])) echo $claim['UserSummary']['firstname']; ?> <?php if(!empty($claim['UserSummary']['lastname'])) echo $claim['UserSummary']['lastname']; ?>
							</td>
							
							<td align="center">
							<?php if(!empty($claim['Claim']['sellers'])) echo $claim['Claim']['sellers']; ?> 
							</td>
							<td align="center">
							<?php
							echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"order_returns","action"=>"claim_details",$claim['Claim']['order_id']),array('escape'=>false,'title'=>'View'));
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