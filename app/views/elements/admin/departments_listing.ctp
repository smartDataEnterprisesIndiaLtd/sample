<?php
echo $javascript->link('selectAllCheckbox'); 
$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;

if($paginator->sortDir() == 'asc'){
	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>'','div'=>false));
}else if($paginator->sortDir() == 'desc'){
	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>'','div'=>false));
}else{
	$image = '';
}

?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td colspan=2>&nbsp;</td></tr>
	<tr>
		<td colspan="2">
		<?php
		if(isset($departments) && is_array($departments) && count($departments) > 0){
		?>
			<table width="100%" cellpadding="2" cellspacing="0" border="0" >
				<tr>
					<td>
						<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
						<?php
						echo $form->create('Department',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Department")'));
						echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
						echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));
						echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
						?>
						<tr>
							<td width="4%" class="adminGridHeading_" align="center">
								<?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[departmentListing][select]",this.form.select1)')); ?>
							</td>
							<td class="adminGridHeading" width="5%"  align="center">Status</td>
							<td class="adminGridHeading"  width="15%"  align="center">
								<?php echo $paginator->sort('Department ID', 'Department.id'); ?>
								<?php if($paginator->sortKey() == 'Department.id'){
								echo $image; 
								}?>
							</td>
							<!--td class="adminGridHeading" width="15%"  align="center">Department ID</td-->
							<td width="60%" class="adminGridHeading"   align="left">
								<?php echo $paginator->sort('Title', 'Department.name'); ?>
								<?php if($paginator->sortKey() == 'Department.name'){
								echo $image; 
								}?>
							</td>
							<td align="center" class="adminGridHeading" width="10%" >
								<?php echo $paginator->sort('Modified', 'Department.modified'); ?><?php if($paginator->sortKey() == 'Department.modified'){
								echo ' '.$image; 
								}?>
							</td>
							<td class="adminGridHeading" align="center" width="5%" >
								Action
							</td>
						</tr>
						<?php
						$class= 'rowClassEven';
						foreach ($departments as $department) {
						$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
						/* status image */
						if($department['Department']['status']){
							$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));$show_status = 'Deactivate';}
						else{
							$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive')); $show_status = 'Activate';
						}?>
						<tr class="<?php echo $class; ?>" >
							<td align="center"><?php echo $form->checkbox('select.'.$department['Department']['id'],array('value'=>$department['Department']['id'],'id'=>'select1')); ?></td>
							<td align="center"><span id="active">
								<?php echo $html->link($img, '/admin/departments/status/'.$department['Department']['id'].'/'.$department['Department']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
							</span></td>
							<td align="center">
								<?php echo $department['Department']['id'];?>
							</td>
							<td align="left">
								<?php echo $html->link($department['Department']['name'],'/admin/categories/index/'.base64_encode($department['Department']['id']), array('class'=>'') )?>
							</td>
							<td align="center">
								<?php
								if($department['Department']['modified'] == '0000-00-00 00:00:00'){
									echo 'NA';
								} else{
									echo date(DATE_FORMAT,strtotime($department['Department']['modified']));
								}?>
							</td>
							<td align="center">
								<?php
								echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"departments","action"=>"add",$department['Department']['id']),array('escape'=>false,'title'=>'Edit'));?>
							</td>
						</tr>
						<?php }?>
						<tr>
							<td colspan="6" style="padding-left:7px" height="30">
								<?php
								echo $form->select('Department.status',array('active'=>'Active','inactive'=>'Inactive'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53')); ?>
							</td>
						</tr>
						<?php
						echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));	
						echo $form->end();
						?>
						<tr><td colspan="5" >
						<?php
							/************** paging box ************/
							echo $this->element('admin/paging_box');
							?>
						</td></tr>
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