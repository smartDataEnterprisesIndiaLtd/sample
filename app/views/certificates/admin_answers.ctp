<?php
//$paginator->options(array('update'=>'pagging'));
$url = array(
	'/'.$question_detail['CertificateQuestion']['id'],
	'keyword' =>$keyword,	
	'searchin' => $fieldname,
	'showtype' => $show
	);


$paginator->options(array('url' => $url));
echo $javascript->link('selectAllCheckbox');
?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			<?php echo $html->link("Add New",array("controller"=>"certificates","action"=>"add_answer",$question_detail['CertificateQuestion']['id'])); ?>
		</td>
	</tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Search Answer</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("Certificate",array("action"=>"answers/".$question_detail['CertificateQuestion']['id'],"method"=>"Post", "id"=>"frmSearchCertificateAnswer", "name"=>"frmSearchCertificateAnswer"));?>
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
	<tr><td colspan="2">&nbsp;</td></tr>
	
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Question Detail</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" width="10%">Question : </td>
											<td colspan="3" >
												<?php echo $question_detail['CertificateQuestion']['question']; ?>
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
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table   align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
							<tr>
								<td colspan="2" >
									<?php echo $this->element('admin/gift_certificate_answers_listing');?>
								</td>
							</tr>
							<tr><td height="10"></td></tr>
							
							<tr>
								<td class="legends">
									<b>Legends:</b>
									<?php echo $html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')) ?>&nbsp;Edit&nbsp;
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
		</td>
	</tr>
</table>
