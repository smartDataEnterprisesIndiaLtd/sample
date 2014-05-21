<?php 
$controller = $this->params['controller'];
echo $javascript->link('selectAllCheckbox');
$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;?>
<?php
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
 <table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
	
	<?php if(!empty($users)){ ?>
	
<?php 
echo $form->create('Adminuser',array('action'=>'multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Adminuser")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
?>

	<tr>
		<td width="3%" class="" align="center">
			<?php echo $form->checkbox('Adminuser.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td width="5%" class="adminGridHeading" align="center" style="padding:0px">
			<?php echo $paginator->sort('Status', 'Adminuser.status');?>
			<?php if($paginator->sortKey() == 'Adminuser.status'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="13%" class="adminGridHeading" align="left">
			<?php echo $paginator->sort('First Name', 'Adminuser.firstname');?>
			<?php if($paginator->sortKey() == 'Adminuser.firstname'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="13%" class="adminGridHeading" align="left">
			<?php echo $paginator->sort('Last Name', 'Adminuser.lastname');?>
			<?php if($paginator->sortKey() == 'Adminuser.lastname'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="25%" align="left" class="adminGridHeading">
			<?php echo $paginator->sort('Email', 'Adminuser.email');?>
			<?php if($paginator->sortKey() == 'Adminuser.email'){
				echo ' '.$image; 
			}?>
		</td>
		
		<td width="10%"  class="adminGridHeading" style="padding:0px" align="center">
			<?php echo $paginator->sort('Created On', 'Adminuser.created');?>
			<?php if($paginator->sortKey() == 'Adminuser.created'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="10%" class="adminGridHeading" align="center">Permission
		<?php //echo $paginator->sort('Permissions', 'Adminuser.type');?>
		</td>
		<td class="adminGridHeading" align="center">Action</td>
	</tr>
	<?php
	
	$class= 'rowClassEven';
	foreach ($users as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		/* status image */
		if($row['Adminuser']['status']){
			$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));
$show_status = 'Deactivate';}
		else{
			$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive'));
$show_status = 'Activate';
		}?>
		<tr class="<?php echo $class?>">
			<td align="center">
				<?php echo $form->checkbox('select.'.$row['Adminuser']['id'],array('value'=>$row['Adminuser']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td align="center"><span id="active">
				<?php echo $html->link($img, '/admin/adminusers/status/'.$row['Adminuser']['id'].'/'.$row['Adminuser']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); 
?>
				</span>
			</td>
			<td align="left" >
				<?php 
				if(!empty($row['Adminuser']['firstname'])){
					echo ucfirst( wordwrap( $row['Adminuser']['firstname'] ,15, '<br />', true));
				} else { echo '-';}?>
			</td>
 			<td align="left">
				<?php 
				if(!empty($row['Adminuser']['lastname'])){
					echo ucfirst( wordwrap( $row['Adminuser']['lastname'], 15, '<br />', true));
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['Adminuser']['email'])){
					echo  "<a href='mailto:".$row['Adminuser']['email']."' >".wordwrap($row['Adminuser']['email'], 30, '<br />', true). "</a>";
				} else { echo '-';}?>
			</td>
			
			<td align="center">
				<?php 
				if(!empty($row['Adminuser']['created'])){
					echo date(DATE_FORMAT,strtotime($row['Adminuser']['created']));
				} else { echo '-';}?>
			</td>
			<td align="center">
				<?php if($row['Adminuser']['type'] == 'Superadmin'){
					echo 'Superadmin';
				} else{
					echo $html->link($html->image("admin/lock.png", array("alt" => "Permissions","title" => "Permissions","class"=>"homeLink")),array("controller"=>"adminusers","action"=>"access/".$row['Adminuser']['id']),array('escape'=>false));
				}?>
			</td>
			<td align="center" valign="bottom">
				<?php echo $html->link($html->image("change_pass_icon.png", array("alt"=>"Change Password",'style'=>'border:0px;'))/*'[Change Password]'*/,array("controller"=>"adminusers","action"=>"user_changepassword",$row['Adminuser']['id']),array('escape'=>false,'title'=>'Change Password'));

				echo '&nbsp';
				echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px;')),array("controller"=>"adminusers","action"=>"delete",$row['Adminuser']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this user?');"));
				echo '&nbsp';
				echo $html->link($html->image("edit.png",array("alt"=>"Edit",'style'=>'border:0px', 'title'=>"Edit " )),array("controller"=>"adminusers","action"=>"add",$row['Adminuser']['id']),array('escape'=>false));
				?></td>
		</tr>
		<?php
	}
	?>
	
	<tr><td heigth="6" colspan=8></td></tr>
	<tr>
		<td colspan="3" style="padding-left:7px;" >
			<?php echo $form->select('Adminuser.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));
			?>
		</td>
		<td colspan="5" align="right">
		</td>
	</tr>
	<?php 	echo $form->end();	?>
	<tr><td colspan="8" >
	<?php
		/************** paging box ************/
		 echo $this->element('admin/paging_box');
		 ?>
	</td></tr>
	

	<?php } else {?>
		<tr>
			<td colspan="4" align="center">No record found</td>
		</tr>
	<?php } ?>
</table>