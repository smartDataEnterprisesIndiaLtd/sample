<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr class="adminBoxHeading reportListingHeading">
	<td class="adminGridHeading heading"><?php echo $listTitle; ?>
	</td>
	<td class="adminGridHeading heading" height="25px" align="right">
		<?php echo $html->link('Back','/admin/affiliates/index/');    ?>
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
			<td align="left">
			<?php echo $format->html_entities($this->data['Affiliate']['title']);   ?></td>
		</tr>
		<tr>
			<td></td>
			<td align="right" valign="top">Content</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $this->data['Affiliate']['content'];   ?></td>
			</tr>
			<tr>
			<td></td>
			<td align="right" valign="top">Created on</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $format->date_format($this->data['Affiliate']['created']);?></td>
		</tr>
		<tr>
			<td></td>
			<td align="right" valign="top">Modified on</td>
			<td align="left" valign="top">:</td>
			<td align="left"><?php echo $format->date_format($this->data['Affiliate']['modified']);   ?></td>
		</tr>
		<tr height="15">
			<td colspan="4">&nbsp;</td>
		</tr>
	</table>
</td>
</tr>
</table>
					