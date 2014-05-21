<?php $javascript->link(array('jquery-1.3.2.min'), false); ?>
<?php
$url = array();
$paginator->options(array('url' => $url));
?>
	<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			<?php echo $html->link('Add New','/admin/hotproducts/add')?>&nbsp;&nbsp;
		</td>
	</tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" >
			<?php echo $this->element('admin/hotproduct_listing'); ?>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td class="legends">
			Note* :You must have one product for each "Hot Product" and "Hot Pick" type. <br />
			<b>Legends:</b>
			<?php echo $html->image('b_drop.png',array('border'=>0,'alt'=>'Delete','title'=>'Delete')); ?>&nbsp;Delete&nbsp;
		</td>
	</tr>
	<!-- Legends -->
	</table>	

