<?php
$this->Html->addCrumb('Website Settings', 'javascript:void(0)');
$this->Html->addCrumb('Manage Delivery Destinations', 'javascript:void(0)');
if($paginator->sortDir() == 'asc'){
	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>''));
}
else if($paginator->sortDir() == 'desc'){
	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>''));
}
else{
	$image = '';
}
//pr($destinationData);
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
<tr>
	<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
	<td class="adminGridHeading" height="25px" align="right">
		<?php echo $html->link("Add New",array("controller"=>"settings","action"=>"add_delivery_destination")); ?>
		
	</td>
</tr>
<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading ">Search </td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("Setting",array("action"=>"delivery_destination","method"=>"Post", "id"=>"frmSearchDeliveryDestination", "name"=>"frmSearchDeliveryDestination"));?>
									<table cellspacing="1" cellpadding="1" align="left" border="0">
										<tr>
											<td align="left">Dispatch Country : 
												<?php echo $form->select('Search.country_from',$countries,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Field--'); ?>
											Destination Country : 
												<?php echo $form->select('Search.country_to',$countries,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Field--'); ?>
											</td><td align="left" style="margin-left:10px; float:left;">
												<?php echo $form->submit('Search',array('alt'=>'Next','width'=>'38','height'=>'31','border'=>'0', "value"=>"search",'class'=>'btn_53'))?>
											</td>
										</tr>
									</table>
									<?php echo $form->end();?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
			</table>
		</td>
	</tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr>
	<td colspan="2" id="pagging">
		

			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
			    <tr>
				<td >
					<?php
					if(isset($destinationData) && is_array($destinationData) && count($destinationData) > 0){?>
					<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
					    <tr>
						<td class="adminGridHeading" align="center" width="15%">
						    <?php echo $paginator->sort('Dispatch Country', 'country_from'); ?><?php if($paginator->sortKey() == 'DeliveryDestination.country_from'){
							echo ' '.$image; 
						    }?>
						</td>
						<td align="center" class="adminGridHeading" width="18%">
						    <?php echo $paginator->sort('Destination Country', 'country_to'); ?><?php if($paginator->sortKey() == 'DeliveryDestination.country_to'){
							echo ' '.$image; 
						    }?>
						</td>
						<td align="center" class="adminGridHeading" width="15%">
						    <?php echo $paginator->sort('Standard Dispatch Time (Days)', 'sd_dispatch'); ?><?php if($paginator->sortKey() == 'DeliveryDestination.sd_dispatch'){
							echo ' '.$image; 
						    }?>
						</td>
						<td align="center" class="adminGridHeading" width="15%">
						    <?php echo $paginator->sort('Expedited Dispatch Time (Days)', 'sd_dispatch'); ?><?php if($paginator->sortKey() == 'DeliveryDestination.ex_dispatch'){
							echo ' '.$image; 
						    }?>
						</td>
						<td align="center" class="adminGridHeading" width="15%">
						    <?php echo $paginator->sort('Standard Delivery Time (Days)', 'sd_delivery'); ?><?php if($paginator->sortKey() == 'DeliveryDestination.sd_delivery'){
							echo ' '.$image; 
						    }?>
						</td>
						<td align="center" class="adminGridHeading" width="15%">
						    <?php echo $paginator->sort('Expedited Delivery Time (Days)', 'ex_delivery'); ?><?php if($paginator->sortKey() == 'DeliveryDestination.ex_delivery'){
							echo ' '.$image; 
						    }?>
						</td>
						<td class="adminGridHeading" align="center" >
							Action
						</td>
					    </tr>
					    <?php
					    $class= 'rowClassEven';
					    foreach ($destinationData as $destination) {
						$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
						?>

						<tr class="<?php echo $class?>">
						    <td align="left">&nbsp;
							<?php  echo $countries[$destination['DeliveryDestination']['country_from']];?>
						    </td>
						    <td align="left">&nbsp;
							<?php  echo $countries[$destination['DeliveryDestination']['country_to']];?>
						    </td>
						   <td align="center">&nbsp;
							<?php  echo $destination['DeliveryDestination']['sd_dispatch'];?>
						    </td>
						   <td align="center">&nbsp;
							<?php  echo $destination['DeliveryDestination']['ex_dispatch'];?>
						    </td>
						   <td align="center">&nbsp;
							<?php  echo $destination['DeliveryDestination']['sd_delivery'];?>
						    </td>
						   <td align="center">&nbsp;
							<?php  echo $destination['DeliveryDestination']['ex_delivery'];?>
						    </td>
						    <td align="center">
							<?php echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"settings","action"=>"add_delivery_destination",$destination['DeliveryDestination']['id']),array('escape'=>false,'title'=>'Edit'));?>
						    </td>
						</tr>
					    <?php }?>
					    <tr><td heigth="8" colspan="7">&nbsp;</td></tr>
					    <tr>
						<td colspan="7" align="left">
						<?php
						/************** paging box ************/
						 echo $this->element('admin/paging_box');
						?>
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
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td class="legends">
		<b>Legends:</b>
		<?php echo $html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')) ?>&nbsp;Edit&nbsp;
	</td>
</tr>
<!-- Legends -->
</table>
