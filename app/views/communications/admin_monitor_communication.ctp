<?php 
echo $javascript->link(array('jquery-1.3.2.min'), false);

?>
<?php echo $form->create('Communication',array('action'=>'monitor_communication','method'=>'POST','name'=>'frmUser','id'=>'frmUser'));?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php //echo $title_for_layout;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			<?php //echo $html->link( $html->image('admin/download-now.png',array('border'=>0,'alt'=>'Download','title'=>'Download Now')) ,array("controller"=>"sellers","action"=>"export") , array('escape'=>false) ); ?>
			&nbsp; &nbsp;
			<?php //echo $html->link("Add New",array("controller"=>"sellers","action"=>"add")); ?>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Monitor communication between Buyers and Sellers</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="1">
							<tr>
								<td>
									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" width="10%">Email Id : </td>
											<td width="40%">
												<?php echo $form->input('Message.email',array('size'=>'30','class'=>'textbox','label'=>false,'div'=>false,'maxlength'=>'50','value'=>''));?>
											</td>
											<td width="50%">
												<?php echo $form->submit('Search',array('alt'=>'Next','width'=>'38','height'=>'31','border'=>'0', "value"=>"search",'class'=>'btn_53'))?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" valign="top" id="pagging">

			<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0">
				<tr>
					<td>					
						<table   align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
							<tr>
								<td colspan="2" id = 'listing'>
									<?php echo $this->element('admin/monitor_listing');	?>
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
						<?php echo $html->image('zoom.png',array('border'=>0,'alt'=>'Active','title'=>'Active')); ?>&nbsp;View&nbsp;
						<?php echo $html->image('green2.jpg',array('border'=>0,'alt'=>'Active','title'=>'Active')); ?>&nbsp;Active&nbsp;
						<?php echo $html->image('red3.jpg',array('border'=>0,'alt'=>'In Active','title'=>'In Active')); ?>&nbsp;Inactive&nbsp;
						<?php echo $html->image('b_drop.png',array('border'=>0,'alt'=>'Delete','title'=>'Delete')); ?>&nbsp;Delete&nbsp;
					</td>
				</tr>
				<!-- Legends -->
			</table>
		</td>		
	</tr>
</table>


<?php echo $form->end(); ?>