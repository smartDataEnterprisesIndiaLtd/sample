<?php
echo $javascript->link('selectAllCheckbox'); 
$add_url_string="/keyword:".$keyword."/searchin:".$fieldname;

if($paginator->sortDir() == 'asc'){
	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>''));
}
else if($paginator->sortDir() == 'desc'){
	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>''));
}
else{
	$image = '';
}
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  align="center">
			<?php
			if(isset($emailTemplates) && is_array($emailTemplates) && count($emailTemplates) > 0){?>
			<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
				<tr>
					<td class="adminGridHeading" align="center" width="45%">
						<?php echo $paginator->sort('Title', 'title'); ?><?php if($paginator->sortKey() == 'EmailTemplate.title'){
						echo ' '.$image;
						}?>
					</td>
					<td align="center" class="adminGridHeading" width="40%">
						<?php echo $paginator->sort('Subject', 'subject'); ?><?php if($paginator->sortKey() == 'EmailTemplate.subject'){
						echo ' '.$image;
						}?>
					</td>
					<td align="center" class="adminGridHeading" width="10%">
						<?php echo $paginator->sort('Modified', 'modified'); ?><?php if($paginator->sortKey() == 'EmailTemplate.modified'){
						echo ' '.$image;
						}?>
					</td>
					<td class="adminGridHeading" align="center" >
						Action
					</td>
				</tr>
				<?php
				$class= 'rowClassEven';
				foreach ($emailTemplates as $staticPage) {
				$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
				/* status image */
				if($staticPage['EmailTemplate']['status']){
					$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));$show_status = 'Deactivate';}
				else{
					$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive')); $show_status = 'Activate';
				}?>
				<tr class="<?php echo $class?>">
					<td align="left">
						<?php echo wordwrap($staticPage['EmailTemplate']['title'], 60, "<br>", true);?>
					</td>
					<td align="left">
						<?php echo wordwrap($staticPage['EmailTemplate']['subject'], 60, "<br>", true);?>
					</td>
					<td align="center">
						<?php
						if($staticPage['EmailTemplate']['modified'] == '0000-00-00 00:00:00'){
							echo 'NA';
						} else{
							echo date(DATE_FORMAT,strtotime($staticPage['EmailTemplate']['modified']));
						}?>
					</td>
					<td align="center">
						<?php
						echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"email_templates","action"=>"view",$staticPage['EmailTemplate']['id']),array('escape'=>false,'title'=>'View'));
						echo "&nbsp;";
						echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"email_templates","action"=>"add",$staticPage['EmailTemplate']['id']),array('escape'=>false,'title'=>'Edit'));?>
					</td>
				</tr>
				<?php }?>
				<tr><td heigth="8">&nbsp;</td></tr>
				<tr>
					<td colspan="4" align="left">
						<?php
						/************** paging box ************/
						echo $this->element('admin/paging_box');
						?>
					</td>
				</tr>
			</table>
			<?php }else{ ?>
			<table width="100%" cellpadding="2" cellspacing="0" border="0" class="adminBox">
				<tr>
				<td align="center">No record found</td>
				</tr>
			</table>
			<?php } ?>
		</td>
	</tr>
</table>