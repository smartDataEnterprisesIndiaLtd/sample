<?php

$this->Html->addCrumb('Order Management', ' ');
	$this->Html->addCrumb('Download Orders', 'javascript:void(0)');
//echo $javascript->link(array('jquery-1.3.2.min'), false);
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
$showArr = array();
?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" >
	<tr>
		<td class="adminGridHeading heading"><?php echo $title_for_layout;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			<?php // echo $html->link("Add New",array("controller"=>"Orders","action"=>"add")); ?>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
	<td>
	<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
		<tr>
			<td>
				<?php echo $form->create("Order",array("action"=>"download_orders","method"=>"Post", "id"=>"frmDownloadorder", "name"=>"frmDownloadorder"));?>
				<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
					<tr>
					<td>
						<table width="100%" cellspacing="4" cellpadding="2" align="left" border="0">
						<tr>
							<td align="right" width="20%">Select Shipping Status:</td>
							<td align="left" >
							<?php echo $form->select('Search.shipping_status',$statusArr,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'All Orders'); ?>
							</td>
						</tr>
						<tr>
							<td  align="right">Start Date:</td>
							<td align="left" ><?php
							echo $form->input('Search.start_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-s'/*,'readonly'=>'readonly'*/));	
							echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].SearchStartDate,'yyyy-mm-dd',this)"));
							?></td>
						</tr>
						<tr>
							<td align="right" >End Date:</td>
							<td align="left" ><?php
							echo $form->input('Search.end_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20' ,'label'=>false,'div'=>false,'class'=>'textbox-s'/*,'readonly'=>'readonly'*/));
							echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].SearchEndDate,'yyyy-mm-dd',this)"));
							?></td>
						</tr>
						<tr>
							<td  align="right" >&nbsp;</td>
							<td align="left" >
							<?php echo $form->submit('Download',array('alt'=>'Next','width'=>'38','height'=>'31','border'=>'0', "value"=>"search",'class'=>'btn_53'))?>
							
							</td>
						</tr>
						</table>
					</td>
					</tr>
				</table>
				<?php echo $form->end();?>
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>
	
