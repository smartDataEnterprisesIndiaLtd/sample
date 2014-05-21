<?php
if(!empty($msgs)){
$url = array(
	'keyword' =>$keyword,
);
$optionspaging = array('url'=>$url);
$paginator->options($optionspaging);
}
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $title_for_layout;?></td>
		<td class="adminGridHeading" height="25px" align="right"><?php echo $html->link('Back','/admin/messages/index/'.base64_encode(@$pass_url),array('escape'=>false));?></td>
	</tr>
	<tr><td height="6"></td></tr>
	<tr><td> </td><td align="right" style="padding-right:10px">
		<?php 
		if(!empty($user['first_user']['User']['msg_status'])){
			$change_first_status = 'Disable';
		} else{
			$change_first_status = 'Enable';
		}
		echo $form->create('Message',array('action'=>'admin_user_message_status','method'=>'POST','name'=>'frmMessage','id'=>'frmMessage','style'=>"float:left"));
		echo $form->button($change_first_status.' '.$user['first_user']['User']['email'],array('type'=>'submit','class'=>'btn_53','div'=>false));
		echo $form->hidden('Message.main_user_id',array('type'=>'text','value'=>@$user['first_user']['User']['id']));
		echo $form->hidden('Message.second_user_id',array('type'=>'text','value'=>@$user['second_user']['User']['id']));
		echo $form->hidden('Message.msg_status',array('type'=>'text','value'=>@$user['first_user']['User']['msg_status']));
		echo $form->end();
		?>

		<?php 
		if(!empty($user['second_user']['User']['msg_status'])){
			$change_second_status = 'Disable';
		} else{
			$change_second_status = 'Enable';
		}
		echo $form->create('Message',array('action'=>'admin_user_message_status','method'=>'POST','name'=>'frmMessage','id'=>'frmMessage','style'=>"float:right"));
		 echo $form->button($change_second_status.' '.$user['second_user']['User']['email'],array('type'=>'submit','class'=>'btn_53','div'=>false));
		echo $form->hidden('Message.main_user_id',array('type'=>'text','value'=>@$user['second_user']['User']['id']));
		echo $form->hidden('Message.second_user_id',array('type'=>'text','value'=>@$user['first_user']['User']['id']));
		echo $form->hidden('Message.msg_status',array('type'=>'text','value'=>@$user['second_user']['User']['msg_status']));
		echo $form->end();
		?>
	</td></tr>
	<tr><td height="6"></td></tr>
	<?php if(!empty($user['first_user']) && !empty($user['second_user'])){ ?>
	<tr class="reportListingHeading" height="25">
		<td colspan="2" style="padding-left:10px">Communication Between <b><?php if(!empty($user['first_user']['User']['firstname'])) echo $user['first_user']['User']['firstname'];?> <?php if(!empty($user['first_user']['User']['lastname'])) echo $user['first_user']['User']['lastname'];?><?php if(!empty($user['first_user']['User']['lastname'])) echo ' ('.$user['first_user']['User']['email'].')';?></b> and <b><?php if(!empty($user['second_user']['User']['firstname'])) echo $user['second_user']['User']['firstname'];?> <?php if(!empty($user['second_user']['User']['lastname'])) echo $user['second_user']['User']['lastname'];?><?php if(!empty($user['second_user']['User']['lastname'])) echo ' ('.$user['second_user']['User']['email'].')';?></b></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
 	<tr>
		<td colspan="2" valign="top" id="pagging">

			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table   align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
							<tr>
								<td colspan="2" id = 'listing'>
									<?php echo $this->element('admin/message_items_listing');	?>
								</td>
							</tr>
						</table>
						 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="legends">
						<b>Legends:</b>
						<?php echo $html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')) ?>&nbsp;Edit&nbsp;
						<?php echo $html->image('zoom.png',array('border'=>0,'alt'=>'Active','title'=>'Active')); ?>&nbsp;View&nbsp;
						<?php echo $html->image('green2.jpg',array('border'=>0,'alt'=>'Active','title'=>'Active')); ?>&nbsp;Active&nbsp;
						<?php echo $html->image('red3.jpg',array('border'=>0,'alt'=>'In Active','title'=>'In Active')); ?>&nbsp;Inactive&nbsp;
						<?php echo $html->image('b_drop.png',array('border'=>0,'alt'=>'Delete','title'=>'Delete')); ?>&nbsp;Delete&nbsp;
					</td>
				</tr>
				<!-- Legends -->
			</table>
		</td>
	</tr>
	<?php } else { ?>
		<tr><td colspan="2">No record found</td></tr>
	<?php }?>
</table>