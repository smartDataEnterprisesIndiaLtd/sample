<?php $this->Html->addCrumb('Email Templates', ' ');
	$this->Html->addCrumb('View Email Template', 'javascript:void(0)'); ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
<tr>
<td valign="top">		
<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0" >
<tr>
<td>
	<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="adminBoxHeading reportListingHeading">
			<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
			<td class="adminGridHeading" align="right">
			<?php echo $html->link('Back','/admin/email_templates/index/');  ?></td>
		</tr>
		
		<tr>
			<td colspan="2">
			<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
				<tr height="15">
					<td width="1%"></td>
					<td width="15%" align="right"></td>
					<td width="1%" align="center"></td>
					<td align="left"></td>
				</tr>
				<tr>
					<td></td>
					<td align="right" valign="top">Page Title</td>
					<td align="center" valign="top">:</td>
					<td align="left"><?php
					//echo $format->html_entities($this->data['EmailTemplate']['title']);
					echo $this->data['EmailTemplate']['title'];
					?></td>
				</tr>
				<tr>
					<td></td>
					<td align="right" valign="top">Subject</td>
					<td align="center" valign="top">:</td>
					<td align="left"><?php
					//echo $format->html_entities($this->data['EmailTemplate']['title']);
					echo $this->data['EmailTemplate']['subject'];
					?></td>
				</tr>
				<tr>
					<td></td>
					<td align="right" valign="top">From Address Email</td>
					<td align="center" valign="top">:</td>
					<td align="left"><?php
					echo $this->data['EmailTemplate']['from_email'];
					?></td>
				</tr>
				<tr>
					<td></td>
					<td align="right" valign="top">Content</td>
					<td align="center" valign="top">:</td>
					<td align="left"><?php echo $this->data['EmailTemplate']['description'];   ?></td>
					</tr>
					<tr>
					<td></td>
					<td align="right" valign="top">Created on</td>
					<td align="center" valign="top">:</td>
					<td align="left"><?php echo $format->date_format($this->data['EmailTemplate']['created']);?></td>
				</tr>
				<tr>
					<td></td>
					<td align="right" valign="top">Modified on</td>
					<td align="center" valign="top">:</td>
					<td align="left"><?php echo $format->date_format($this->data['EmailTemplate']['modified']);   ?></td>
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