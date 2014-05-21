<?php
echo $javascript->link('selectAllCheckbox');
//$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;?>
<?php
// if($paginator->sortDir() == 'asc'){
// 	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>''));
// }
// else if($paginator->sortDir() == 'desc'){
// 	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>''));
// }
// else{
// 	$image = '';
// }
?>

<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
	<?php if(!empty($usersArr)){
	?>
<?php 
echo $form->create('Seller',array('action'=>'multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"User")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
?>
	<tr>
		<td width="3%" align="left">
			<?php echo $form->checkbox('User.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td class="adminGridHeading" align="left" width="5%">
			<?php echo $paginator->sort('Status', 'User.status');?>
			<?php if($paginator->sortKey() == 'User.status'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="left" width="13%">
			<?php echo $paginator->sort('First Name', 'User.firstname');?>
			<?php if($paginator->sortKey() == 'User.firstname'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="left" width="12%">
			<?php echo $paginator->sort('Last Name', 'User.lastname');?>
			<?php if($paginator->sortKey() == 'User.lastname'){
				echo ' '.$image; 
			}?>
		</td>
		<td align="left" class="adminGridHeading" width="15%">
			<?php echo $paginator->sort('Business Name', 'Seller.business_name');?>
			<?php if($paginator->sortKey() == 'Seller.business_name'){
				echo ' '.$image; 
			}?>
		</td>
		<td align="left" class="adminGridHeading" width="15%">
			<?php echo $paginator->sort('Email', 'User.email');?>
			<?php if($paginator->sortKey() == 'User.email'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="center" width="10%">
			<?php echo $paginator->sort('Created On', 'User.created');?>
			<?php if($paginator->sortKey() == 'User.created'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="center" >Action</td>
	</tr>
	<?php
	
	$class= 'rowClassEven';
	foreach ($usersArr as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		/* status image */
		if($row['User']['status']){
			$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));
			$show_status = 'Deactivate';}
		else{
			$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive'));
			$show_status = 'Activate';
		}?>
		<tr class="<?php echo $class?>">
			<td>
				<?php echo $form->checkbox('select.'.$row['User']['id'],array('value'=>$row['User']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td align="center">
				<?php echo $html->link($img, '/admin/sellers/status/'.$row['User']['id'].'/'.$row['User']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
			</td>
			<td align="left" >
				<?php 
				if(!empty($row['User']['firstname'])){
					echo ucfirst( wordwrap($row['User']['firstname'], 20 ,"<br>", true ) );
				} else { echo '-';}?>
			</td>
 			<td align="left">
				<?php 
				if(!empty($row['User']['lastname'])){
					echo ucfirst( wordwrap($row['User']['lastname'], 8, "<br>", false) );
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['Seller']['business_name'])){
					echo  $row['Seller']['business_name'];
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['User']['email'])){
					echo  "<a href='mailto:".$row['User']['email']."' >".wordwrap($row['User']['email'], 25, '<br />', true). "</a>";
				} else { echo '-';}?>
			</td>
			<!--<td align="left">
				<?php /*
				if( $row['User']['user_type']  == '1'){ // 1 for seller 0 for buyer 
					echo 'Seller' ;
				} else { echo 'Buyer'; }*/ ?>
			</td>-->
			<td align="center">
				<?php 
				if(!empty($row['User']['created'])){
					echo date(DATE_FORMAT,strtotime($row['User']['created']));
				} else { echo '-';}
				?>
			</td>
			<td align="center">
				<?php echo $html->link('[Change Password]',array("controller"=>"sellers","action"=>"seller_changepassword",$row['User']['id']),array('escape'=>false,'title'=>'Change Password'));
				echo '&nbsp';
				echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"sellers","action"=>"view",base64_encode($row['User']['id'])),array('escape'=>false,'title'=>'View'));
				echo '&nbsp;';
				echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"sellers","action"=>"delete",$row['User']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp;';
				echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"sellers","action"=>"add",base64_encode($row['User']['id'])),array('escape'=>false,'title'=>'Edit'));
				echo '&nbsp;';
				?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr><td heigth="6" colspan=8></td></tr>
	<tr>
		<td colspan="3" style="padding-left:7px;" >
			<?php echo $form->select('User.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));
			?>
		</td>
		<td colspan="5" align="right">
		</td>
	</tr>
	<?php 	echo $form->end();	?>
	<tr>
	<td colspan="7" style="padding-left:7px;" ></td>
		<?php
		/************** paging box ************/
		//echo $this->element('admin/paging_box');
		?>
	</tr>

	<?php } else {?>
		<tr>
			<td colspan="4" align="center">No record found</td>
		</tr>
	<?php } ?>
</table>