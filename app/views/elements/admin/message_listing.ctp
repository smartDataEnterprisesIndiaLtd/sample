<?php
$controller = $this->params['controller'];
echo $javascript->link('selectAllCheckbox');
$add_url_string="/keyword:".$keyword;?>
<?php
if(!empty($msgs)){
$key = $paginator->sortKey();
if(!empty($key)) {
	if($paginator->sortDir() == 'asc'){
		$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>'','div'=>false));
	} else if($paginator->sortDir() == 'desc'){
		$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>'','div'=>false));
	} else{
		$image = '';
	}
} else{
	$image ='';
}
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td colspan=2>&nbsp;</td></tr>
	<tr>
		<td colspan="2">
			<?php if(isset($msgs) && is_array($msgs) && count($msgs) > 0){ ?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
					<?php
					echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
					?>
					<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
						<tr>
							<td class="adminGridHeading" >
								<?php echo $paginator->sort('From User', 'FromUserSummary.email'); ?>
								<?php if($paginator->sortKey() == 'FromUserSummary.email'){ echo $image; } ?>
							</td>
							<td class="adminGridHeading" align="center" style="padding:0px" width="20%">
								<?php echo $paginator->sort('Latest Message On', 'Message.created'); ?>
								<?php if($paginator->sortKey() == 'Message.created'){ echo $image; } ?>
							</td>
							<td class="adminGridHeading" align="center" width="20%" >
								Action
							</td>
						</tr>
						<?php
						$class= 'rowClassEven';
						foreach ($msgs as $msg) {
						$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';?>
						<tr class="<?php echo $class; ?>" >
							<td>
							<?php if(!empty($msg['FromUserSummary']['email'])) echo $msg['FromUserSummary']['email']; ?>
							</td>
							<td align="center">
							<?php if(!empty($msg['Message']['created'])) echo date(DATE_TIME_FORMAT,strtotime($msg['Message']['created'])); ?>
							</td>
							<td align="center">
							<?php
							echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),"/admin/messages/communicated_items/".urlencode($msg_type.'~'.$msg['ToUserSummary']['id']."~".$msg['FromUserSummary']['id']),array('escape'=>false,'title'=>'View')); ?>
							</td>
						</tr>
						<?php }?>
						<tr>
							<td  align="center" width="100%" colspan="6">
							<?php
							/************** paging box ************/
							echo $this->element('admin/paging_box');
							?>
							</td>
						</tr>
					</table>
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
<?php }?>