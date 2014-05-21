<?php ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top">		
			<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
                        <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr class="adminBoxHeading">
                                <td class="reportListingHeading lpad5 heading" height="25px" align="left"><?php echo $list_title; ?>
                                </td>
                                <td class="reportListingHeading rpad5" height="25px" align="right">
                                    <?php echo $html->link('Back',array('controller'=>'adminusers','action'=>'list'));    ?>
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
                                            <td align="right" valign="top">Username</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $this->data['Adminuser']['username'];   ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td align="right" valign="top">Name</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo ucfirst($this->data['Adminuser']['firstname']).' '.ucfirst($this->data['Adminuser']['lastname']);   ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td align="right" valign="top">Email</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $this->data['Adminuser']['email'];   ?></td>
                                        </tr>
                                         <tr>
                                            <td></td>
                                            <td align="right" valign="top">Created on</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $format->date_format($this->data['Adminuser']['created']);
                                            ?></td>
                                        </tr>
                                         <tr>
                                            <td></td>
                                            <td align="right" valign="top">Modified on</td>
                                            <td align="left" valign="top">:</td>
                                            <td align="left"><?php echo $format->date_format($this->data['Adminuser']['modified']);   ?></td>
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