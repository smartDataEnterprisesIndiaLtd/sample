<?php
$this->Html->addCrumb('Email Templates', ' ');
$this->Html->addCrumb('Manage Email Templates', 'javascript:void(0)');

$url = array(
	'keyword' =>$keyword,	
	'searchin' => $fieldname,
	);
$paginator->options(array('url' => $url)); 
?>
	<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" height="25px" align="right"></td>
	</tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading ">Search Email Templates</td>
				</tr>
				<tr>
				<td>
					<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
						<tr>
							<td>
								<?php echo $form->create("EmailTemplate",array("action"=>"index","method"=>"Post", "id"=>"frmSearchEmailTemplate", "name"=>"frmSearchEmailTemplate"));?>
								<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0" class="keywordtbl_search">
										<tr>
											<td align="left" width="60%">
												<div class="keyword_widget">
													<label>Keyword :</label>
													<div class="field_widget">
														<p class="pdrt2"><?php echo $form->input('Search.keyword',array('size'=>'53','class'=>'textbox','label'=>false,'div'=>false,'maxlength'=>'50','value'=>$keyword));?></p>
														
										</div>
												</div>
											</td>
											<td width="40%" class="select_input">
											<?php echo $form->select('Search.searchin',$options,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Field--'); ?>
										
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
	<tr>
		<td colspan="2" id="pagging">
			<?php echo $this->element('admin/EmailTemplateListing'); ?>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td class="legends">
			<b>Legends:</b>
			<?php echo $html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')) ?>&nbsp;Edit&nbsp;
			<?php echo $html->image('zoom.png',array('border'=>0,'alt'=>'Active','title'=>'Active')); ?>&nbsp;View&nbsp;
		</td>
	</tr>
	<!-- Legends -->
	</table>