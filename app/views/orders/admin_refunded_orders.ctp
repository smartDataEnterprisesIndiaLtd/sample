<style>
.textbox-l{
width:83%;
}
</style>
<?php
//echo $javascript->link(array('jquery-1.3.2.min'), false);
$this->Html->addCrumb('Order Management', ' ');
	$this->Html->addCrumb('Manage Refunded Orders', 'javascript:void(0)');
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
?>
<?php
$url = array(
	'keyword' =>$keyword,
	'searchin' => $fieldname,
	);
$paginator->options(array('url' => $url));
?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" height="25px" align="right">
		
		<?php //echo $html->link('<span>Download Now</span>',array("controller"=>"orders","action"=>"admin_export_refunded_order") , array('escape'=>false,'class'=>'wt_btn','title'=>'Download Now') ); ?>
		</td>
	</tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Search:</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("Order",array("action"=>"refunded_orders","method"=>"Post", "id"=>"frmSearchOrder", "name"=>"frmSearchOrder"));?>
<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
          										<tr>
              										<td colspan="3" align="left">
                    										<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0" class="keywordtbl_search">
                          									<tr>
                                											<td align="left" width="60%">
                                												<div class="keyword_widget">
                                													<label>Keyword :</label>
                                													<div class="field_widget">
                                														<p class="pdrt2"><?php echo $form->input('Search.keyword',array('size'=>'53','class'=>'textbox','label'=>false,'div'=>false,'maxlength'=>'53','value'=>$keyword));?></p>
                                											        </div>
                                												</div> </td>
                                											
                                											<td width="40%" class="select_input">
                              												
                              												<?php echo $form->select('Search.searchin',$options,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Field--'); ?>
                              										
                              												<?php echo $form->submit('Search',array('alt'=>'Next','width'=>'38','height'=>'31','border'=>'0', "value"=>"search",'class'=>'btn_53'))?>
                              											</td>
                          										</tr>
                    									     </table>
              									     </td>				
          									   </tr>
										
										            <tr>
                          			       <td colspan="3" height="10">&nbsp;</td>				
                          			</tr>
                          			<tr>
                          			         <td colspan="3"><strong>Download Refund Orders</strong></td>	
                          			</tr>
                          			<tr>
                              			<td align="left" width="9%">Date : </td>
                              			<td colspan="2">
                                      			<table cellspacing="4" cellpadding="2" align="left" border="0">
                                            			<tr>
                                                			<td>Start Date:</td>
                                                			<td align="left" ><?php
                                                			echo $form->input('Search.start_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20', 'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));
                                                		  echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].SearchStartDate,'yyyy-mm-dd',this)"));?></td>
                                                			<td>End Date:</td>
                                                			<td align="left"><?php
                                                			echo $form->input('Search.end_date',array('autocomplete'=>'off','type'=>'text', 'size'=>'20' ,'label'=>false,'div'=>false,'class'=>'textbox-l','readonly'=>'readonly'));
                                                			echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].SearchEndDate,'yyyy-mm-dd',this)"));
                                                			?></td>
                                                			<td align="left">
                                                			
                                                			<?php echo $html->link('<span>Download Now</span>','javascript:', array('escape'=>false,'class'=>'wt_btn','title'=>'Download Now','onclick'=>'downLoadRefundOrders();') ); ?>
                                                			
                                                			<?php //echo $html->link( $html->image('admin/download-now.png',array('border'=>0,'alt'=>'Download','title'=>'Download Now')) ,'javascript:' , array('escape'=>false, 'onclick'=>'downLoadRefundOrders();') ); ?>
                                                			</td>
                                            			</tr>
                                    			 </table>
                            			   </td>
                            			 <td></td>
                          			</tr>				
                        </table>
									<?php echo $form->end();?>
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
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table   align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
							<tr>
								<td colspan="2" >
									<?php echo $this->element('admin/refunded_listing');?>
								</td>
							</tr>
							<tr><td height="10"></td></tr>
							<tr>
								<td class="legends">
									<b>Legends:</b>
									<?php echo $html->image('zoom.png',array('border'=>0,'alt'=>'View','title'=>'View')); ?>&nbsp;View&nbsp;
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>

</table>

<script type="text/javascript">

function downLoadRefundOrders()

{
	var SearchStartDate =jQuery("#SearchStartDate").val();
	var SearchEndDate =jQuery("#SearchEndDate").val();
	if(SearchStartDate!='' && SearchEndDate!='')
	{
		window.location.href='/admin/orders/export_refunded_order/'+SearchStartDate+'/'+SearchEndDate;
	}
	else
	{
		alert('Please select start and end date');
		return false;
	}
}

</script>

