<?php $javascript->link(array('jquery-1.3.2.min'), false); ?>
<?php
$url = array(
	'keyword' =>$keyword,	
	'searchin' => $fieldname,
	'showtype' => $show
	
	);
$paginator->options(array('url' => $url)); 
?>
	<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			<?php //echo $html->link('Add New','/admin/departments/add')?>&nbsp;&nbsp;
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Search Department</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("Department",array("action"=>"index","method"=>"Post", "id"=>"frmDepartment", "name"=>"frmDepartment"));?>

									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" width="9%">Keyword : </td>
											<td width="37%">
												<?php echo $form->input('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>false,'div'=>false,'maxlength'=>'50','value'=>$keyword));?>
											</td>
											<td width="16%">
												<?php echo $form->select('Search.searchin',$options,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Field--'); ?>
											</td>
											<td width="20%">
												<?php echo $form->select('Search.show',$showArr,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Status--'); ?>
											</td>
											<td>
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
			</table>
		</td>
	</tr>
	
	<tr>
		<td colspan="2" id="department_pagging">
			<?php echo $this->element('admin/departments_listing'); ?>
		</td>
	</tr>
	<tr>
		<td class="legends">
			<b>Legends:</b>
			<?php echo $html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')) ?>&nbsp;Edit&nbsp;<?php echo $html->image('green2.jpg',array('border'=>0,'alt'=>'Active','title'=>'Active')); ?>&nbsp;Active&nbsp;
			<?php echo $html->image('red3.jpg',array('border'=>0,'alt'=>'In Active','title'=>'In Active')); ?>&nbsp;Inactive&nbsp;
			
		</td>
	</tr>
	</table>	

