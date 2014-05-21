<?php echo $javascript->link(array('lib/prototype'),false);
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');echo $javascript->link('selectAllCheckbox');
?>
<script language="JavaScript">
	jQuery(document).ready(function()  { 
		jQuery("a.edit").fancybox({
			'titlePosition': 'inside',
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : 450,
			'height' : 300,
			'padding':0,'overlayColor':'#DFDFDF',
			'overlayOpacity':0.8,
			'opacity':	true,
// 			'transitionIn' : 'fade',
// 			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
		});
	});
</script>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading heading" align="right"><?php echo $html->link('Add Message','/admin/messages/add/'.$order_item_id,array('escape'=>false));?></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Order Detail</td>
					<td class="reportListingHeading" align="right"><?php echo $html->link('Back','/admin/messages/communicated_items/'.$buyer_seller['ToUserSummary']['id'].'/'.$buyer_seller['FromUserSummary']['id'],array('escape'=>false));?></td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<table width="100%" cellspacing="3" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" width="15%"><b>Order Number :</b> </td>
											<td  width="21%">
												<?php echo $order_info['Order']['order_number']; ?>
											</td>
											<td width="17%"><b>Date/Time of Order : </b></td>
											<td >
												<?php echo date(DATE_TIME_FORMAT,strtotime($order_info['Order']['created'])); ?>
											</td>
										</tr>
										<tr>
											<td align="left" width="11%"><b>Order Item :</b> </td>
											<td  colspan="3">
												<?php echo $order_info['OrderItem']['product_name']; ?>
											</td>
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
	<tr><td colspan="2">&nbsp;</td></tr>
 	<tr>
		<td colspan="2" valign="top" id="pagging">
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<?php echo $form->create('Message',array('action'=>'multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Message")'));?>
						 <table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
							<?php $class = 'rowClassEven';
							$i=0; ?>
							<tr>
								<td class="adminGridHeading" align="center" style="padding-right:0px">
									<?php echo $form->checkbox('Message.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
								</td>
								<td></td>
								<td class="adminGridHeading" align="center">Action</td>
							</tr>
							<?php foreach($allmsgs as $msg) { //pr($msg); ?>
							<?php
							if($i%2 == 0)
								$class = 'rowClassEven';
							else
								$class = 'rowClassOdd';?>
							<tr class = "<?php echo $class;?>">
								<td align="center">
									<?php echo $form->checkbox('select.'.$msg['Message']['id'],array('value'=>$msg['Message']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
								</td>
								<td class="">
									<table>
										<tr>
											<td>
											<?php
											if($msg['Message']['msg_from'] == 'A'){ //pr($msg);?>
												<b>Message from Choiceful.com to <?php if(!empty($buyer_seller['ToUserSummary']['email'])) echo $msg['ToUserSummary']['email'];?> on <?php if(!empty($msg['Message']['created'])) echo date(DATE_TIME_FORMAT,strtotime($msg['Message']['created']));?></b>
											<?php } else {?>
											<b>Message from <?php if(!empty($msg['FromUserSummary']['email'])) echo $msg['FromUserSummary']['email'];?> to <?php if(!empty($msg['ToUserSummary']['email'])) echo $msg['ToUserSummary']['email'];?> on <?php if(!empty($msg['Message']['created'])) echo date(DATE_TIME_FORMAT,strtotime($msg['Message']['created']));?></b>
											<?php }?>
											</td>
										</tr>
										<tr>
											<td><?php if(!empty($msg['Message']['message']))
													echo nl2br($msg['Message']['message']);
												else echo '-'; ?>
											</td>
										</tr>
									</table>
								</td>
								<td align="center">
									<?php echo $html->link($html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')),'/admin/messages/add/'.$msg['Message']['order_item_id'].'/'.$msg['Message']['id'],array('escape'=>false));?>&nbsp;
									<?php //echo $html->link($html->image('b_drop.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')),'/admin/messages/delete/'.$msg['Message']['id'].'/'.$msg['Message']['order_item_id'],array('escape'=>false,));?>
								</td>
							</tr>
							<?php $i++; } ?>
							<tr><td heigth="6" colspan=3></td></tr>
							<tr>
								<td colspan="3" style="padding-left:7px;" >
									<?php echo $form->select('Message.status',array('del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
									<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));
									?>
								</td>
								</td>
							</tr>
						</table>
						<?php echo $form->hidden('Message.order_item_id',array('type'=>'text')); ?>
						<?php echo $form->end(); ?>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="legends">
						<b>Legends:</b>
						<?php echo $html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')); ?>&nbsp;Edit&nbsp;
						<?php echo $html->image('b_drop.png',array('border'=>0,'alt'=>'Delete','title'=>'Delete')); ?>&nbsp;Delete&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>