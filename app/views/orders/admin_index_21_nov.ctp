<?php //echo $javascript->link(array('jquery-1.3.2.min'), false);
//$paginator->options(array('update'=>'pagging'));

$this->Html->addCrumb('Order Management', ' ');
	$this->Html->addCrumb('View Orders', 'javascript:void(0)');
$url = array(
	'keyword' =>$keyword,	
	'searchin' => $fieldname,
	'showtype' => $show
);
$optionspaging = array('url'=>$url);
$optionspaging = array('url'=>$url,'update'=>'listing');
$paginator->options($optionspaging);

?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $title_for_layout;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			<?php // echo $html->link("Add New",array("controller"=>"Orders","action"=>"add")); ?>
		</td>
	</tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
	<tr class="adminBoxHeading">
	<td height="25" class="reportListingHeading">Search Order</td>
	</tr>
	<tr>
	<td>
	<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
		<tr>
			<td>
				<?php echo $form->create("Order",array("action"=>"index","method"=>"Post", "id"=>"frmSearchorder", "name"=>"frmSearchorder"));?>
	
				<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0" class="keywordtbl_search">
					<tr>
						<td align="left" width="60%">
							<div class="keyword_widget">
								<label>Keyword :</label>
								<div class="field_widget">
									<p class="pdrt2"><?php echo $form->input('Search.keyword',array('size'=>'53','class'=>'textbox','label'=>false,'div'=>false,'maxlength'=>'53','value'=>$keyword));?></p>
								
								</div>
							</div>
						</td>
						<td width="40%" class="select_input">
							<?php echo $form->select('Search.searchin',$options,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Field--'); ?>
					
							<?php // echo $form->select('Search.show',$showArr,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Order Status--'); ?>
						
							<?php echo $form->submit('Search',array('alt'=>'Next','width'=>'38','height'=>'31','border'=>'0', "value"=>"search",'class'=>'btn_53'))?>
						</td>
					</tr>
					
				</table>
				<?php echo $form->end();?>
			</td>
		</tr>
		<tr><td >
		</td></tr>
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
					<td >					
					<table   align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
						<tr>
							<td colspan="2" id = 'listing'>
								<?php echo $this->element('admin/orders_listing');	?>
							</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="legends">
						<b>Legends:</b>
						<?php echo $html->image('zoom.png',array('border'=>0,'alt'=>'View','title'=>'View'));?>&nbsp;View &nbsp;
						<?php // echo $html->image('b_drop.png',array('border'=>0,'alt'=>'Delete','title'=>'Delete')); ?>
					</td>
				</tr>
				<tr>
					<td align="left" >
						<table width="100%" cellspacing="" cellpadding="3" align="center" border="0">
							<tr>
							<td align="left" width="100%">
							<table width="50%" cellspacing="2" cellpadding="2" align="left" border="0">
							<tr>
								<td class="fraudClass" width="5%" ></td>
								<td align="left" class="legends" >: Fraudelent</td></tr>
							<tr>
								<td class="cancelledClass" width="5%" ></td>
								<td align="left" class="legends" >: Cacelled</td>
							</tr>
							</table>
							</td>
							
							</tr>
						</table>
					</td>
				</tr> 
				<!-- Legends -->
				</table>
		</td>		
	</tr>

</table>
