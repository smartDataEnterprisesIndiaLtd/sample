<?php ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top">		
			<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
                        <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                           
			   <tr class="adminBoxHeading reportListingHeading">
						<td class="adminGridHeading heading"><?php echo $list_title;?></td>
						<td class="adminGridHeading" align="right"><?php echo $html->link('Back','/admin/reviews/');    ?>
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
                                            <td align="right" valign="top">Reviewed By</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo ucfirst($this->data['User']['firstname']).' '.ucfirst($this->data['User']['lastname']);   ?></td>
                                        </tr>
                                         <tr>
                                            <td></td>
                                            <td align="right" valign="top">Product Name</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $this->data['Product']['product_name'];   ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td align="right" valign="top">Quick Code</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $this->data['Product']['quick_code'];   ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td align="right" valign="top">Review Type</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php if($this->data['Review']['review_type']==0) echo 'Negative'; elseif($this->data['Review']['review_type']==1) echo 'Neutral'; else echo 'Positive'; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td align="right" valign="top">Comments</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $this->data['Review']['comments']; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td align="right" valign="top">Review Status</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php if($this->data['Review']['status'] == 0) echo 'Active'; else echo 'Inactive';   ?></td>
                                        </tr>
                                         <tr>
                                            <td></td>
                                            <td align="right" valign="top">Created on</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $format->date_format($this->data['Review']['created']);
                                            ?></td>
                                        </tr>
                                         <tr>
                                            <td></td>
                                            <td align="right" valign="top">Modified on</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $format->date_format($this->data['Review']['modified']);   ?></td>
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