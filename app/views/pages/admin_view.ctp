<?php $this->Html->addCrumb('Website Pages', '/admin/faqs');

$this->Html->addCrumb('View static page', 'javascript:void(0)');	
 ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top">		
			<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
                        <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                           
			   <tr class="adminBoxHeading reportListingHeading">
						<td class="adminGridHeading heading"><?php echo $list_title;?></td>
						<td class="adminGridHeading" align="right"><?php echo $html->link('Back','/admin/pages/');    ?>
						</td>
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
                                            <td align="right" valign="top">Page</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $format->html_entities($this->data['Page']['title']);   ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td align="right" valign="top">Content</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $this->data['Page']['description'];   ?></td>
                                        </tr>
                                         <tr>
                                            <td></td>
                                            <td align="right" valign="top">Created on</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $format->date_format($this->data['Page']['created']);
                                            ?></td>
                                        </tr>
                                         <tr>
                                            <td></td>
                                            <td align="right" valign="top">Modified on</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $format->date_format($this->data['Page']['modified']);   ?></td>
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