<?php $this->Html->addCrumb('Website Pages', ' ');
	$this->Html->addCrumb('View Question', 'javascript:void(0)');
	?>
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr class="adminBoxHeading reportListingHeading">
						<td class="adminGridHeading heading"><?php echo $list_title;?></td>
						<td class="adminGridHeading" align="right"><?php echo $html->link('Back','/admin/faqs');    ?></td>
			       </tr>
							
							<tr>
								<td colspan="2">
									<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
										<tr height="15">
											<td width="1%"></td>
											<td width="20%" align="right"></td>
											<td width="3%" align="left"></td>
											<td align="left"></td>
										</tr>
										<tr>
											<td></td>
											<td align="right" valign="top">Question</td>
											<td align="left" valign="top">:</td>
											<td align="left"><?php echo $format->html_entities( $result['Faq']['question']);   ?></td>
										</tr>
										<tr>
											<td></td>
											<td align="right" valign="top">Answer</td>
											<td align="left" valign="top">:</td>
											<td align="left"><?php echo html_entity_decode(htmlentities($result['Faq']['answer']), ENT_NOQUOTES, 'UTF-8');?></td>
										</tr>
										<tr>
											<td></td>
											<td align="right" valign="top">Type</td>
											<td align="left" valign="top">:</td>
											<td align="left"><?php echo $result['FaqCategory']['title'];   ?></td>
										</tr>
										<tr>
											<td></td>
											<td align="right" valign="top">Created on</td>
											<td align="left" valign="top">:</td>
											<td align="left"><?php echo $format->date_format($result['Faq']['created']);
											?></td>
										</tr>
										<tr>
											<td></td>
											<td align="right" valign="top">Modified on</td>
											<td align="left" valign="top">:</td>
											<td align="left"><?php echo $format->date_format($result['Faq']['modified']);   ?></td>
										</tr>
										<tr height="15">
											<td colspan="4">&nbsp;</td>
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
</table>