<?php
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
<p style="float:right; margin-right:10px;"><?php echo "Total Users: ".$total_users;?></p>
<p style="float:right; margin-right:10px;"><?php echo "Mobile Users: ".$mobile_users;?></p>
<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
	<?php if(!empty($usersArr)){
	?>
<?php 
echo $form->create('User',array('action'=>'multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"User")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
?>
	<tr>
		<td align="center" width="3%">
			<?php echo $form->checkbox('VCustomerOrder.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td class="adminGridHeading" align="center" style="padding:0px" width="4%">
			<?php echo $paginator->sort('Status', 'VCustomerOrder.status');?>
			<?php if($paginator->sortKey() == 'VCustomerOrder.status'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="center" width="18%">
			<?php echo $paginator->sort('First Name', 'VCustomerOrder.firstname');?>
			<?php if($paginator->sortKey() == 'VCustomerOrder.firstname'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="center" width="13%">
			<?php echo $paginator->sort('Last Name', 'VCustomerOrder.lastname');?>
			<?php if($paginator->sortKey() == 'VCustomerOrder.lastname'){
				echo ' '.$image; 
			}?>
		</td>
		<td align="center" class="adminGridHeading" width="25%">
			<?php echo $paginator->sort('Email', 'VCustomerOrder.email');?>
			<?php if($paginator->sortKey() == 'VCustomerOrder.email'){
				echo ' '.$image; 
			}?>
		</td>
		<td align="center" class="adminGridHeading" width="5%">
			<?php echo $paginator->sort('Logins', 'VCustomerOrder.total_logins');?>
			<?php if($paginator->sortKey() == 'VCustomerOrder.total_logins'){
				echo ' '.$image; 
			}?>
		</td><td align="center" class="adminGridHeading" width="7%">
			<?php echo $paginator->sort('Last Login', 'VCustomerOrder.login_time');?>
			<?php if($paginator->sortKey() == 'VCustomerOrder.login_time'){
				echo ' '.$image; 
			}?>
		</td>
		<td align="center" class="adminGridHeading" width="8%">
			<?php echo $paginator->sort('Total Orders', 'VCustomerOrder.total_order');?>
			<?php if($paginator->sortKey() == 'VCustomerOrder.total_order'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="center" style="padding:0px" width="7%">
			<?php echo $paginator->sort('Created On', 'VCustomerOrder.created');?>
			<?php if($paginator->sortKey() == 'VCustomerOrder.created'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="center">Action</td>
	</tr>
	<?php
	
	$class= 'rowClassEven';
	foreach ($usersArr as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		/* status image */
		if($row['VCustomerOrder']['status']){
			$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));
			$show_status = 'Deactivate';}
		else{
			$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive'));
			$show_status = 'Activate';
		}?>
		<tr class="<?php echo $class?>">
			<td align="center">
				<?php echo $form->checkbox('select.'.$row['VCustomerOrder']['id'],array('value'=>$row['VCustomerOrder']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td align="center">
				<?php echo $html->link($img, '/admin/users/status/'.$row['VCustomerOrder']['id'].'/'.$row['VCustomerOrder']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
			</td>
			<td align="left" >
				<?php 
				if(!empty($row['VCustomerOrder']['firstname'])){
					echo ucfirst( wordwrap($row['VCustomerOrder']['firstname'], 20 ,"<br>", true ) );
				} else { echo '-';}?>
			</td>
 			<td align="left">
				<?php 
				if(!empty($row['VCustomerOrder']['lastname'])){
					echo ucfirst( wordwrap($row['VCustomerOrder']['lastname'], 8, "<br>", false) );
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['VCustomerOrder']['email'])){
					//echo  "<a href='mailto:".$row['User']['email']."' >".wordwrap($row['User']['email'], 25, '<br />', true). "</a>";
					echo  "<a href='mailto:".$row['VCustomerOrder']['email']."' >".wordwrap($row['VCustomerOrder']['email'], 50, '<br />', true). "</a>";
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
				if(!empty($row['VCustomerOrder']['total_logins'])){
					echo $row['VCustomerOrder']['total_logins'];
				} else { echo '-';}
				?>
				
			</td>
			<td align="center">
				<?php 
				if(!empty($row['VCustomerOrder']['login_time'])){
					echo date(DATE_FORMAT,strtotime($row['VCustomerOrder']['login_time']));
					//echo $row['VCustomerOrder']['login_time'];
				} else { echo '-';}
				?>
			</td>
			<td align="center">
				<?php 
				if(!empty($row['VCustomerOrder']['total_order'])){
					echo $html->link($row['VCustomerOrder']['total_order'],'/admin/orders/index/custom/'.$row['VCustomerOrder']['email']);
				
				} else { echo '-';}
				?>
			</td>
			<td align="center">
				<?php 
				if(!empty($row['VCustomerOrder']['created'])){
					echo date(DATE_FORMAT,strtotime($row['VCustomerOrder']['created']));
				} else { echo '-';}
				?>
			</td>
			<td align="left">
				<?php echo $html->link($html->image("change_pass_icon.png", array("alt"=>"Change Password",'style'=>'border:0px;'))/*'[Change Password]'*/,array("controller"=>"users","action"=>"user_changepassword",$row['VCustomerOrder']['id']),array('escape'=>false,'title'=>'Change Password','class'=>'chp'));
				
				//$linkmain_str = '/categories/enlarge_mainimage/'.$product_details['Product']['id'];
				//echo $html->link('<strong>View Larger Image</strong>',$linkmain_str,array('escape'=>false,'class'=>'view-larger large-image'));

				echo '&nbsp';
				echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"users","action"=>"view",base64_encode($row['VCustomerOrder']['id'])),array('escape'=>false,'title'=>'View'));
				echo '&nbsp;';
				echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"users","action"=>"delete",$row['VCustomerOrder']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp;';
				echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"users","action"=>"add",base64_encode($row['VCustomerOrder']['id'])),array('escape'=>false,'title'=>'Edit'));
				echo '&nbsp;';
				echo $html->link($html->image("admin/users.png", array("alt"=>"Update as Seller",'style'=>'border:0px')),array("controller"=>"sellers","action"=>"add",base64_encode($row['VCustomerOrder']['id'])),array('escape'=>false,'title'=>'Upgrade as Seller'));
				if($row['VCustomerOrder']['mobile_users'] ==1){
					echo '&nbsp';
					echo $html->link($html->image("/img/images/mobile.png", array("alt"=>"Mobile",'style'=>'border:0px',)),"javascript:void('0')",array('escape'=>false,'title'=>'Mobile Users'));
				}
				?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr><td heigth="6" colspan=8></td></tr>
	<tr>
		<td colspan="3" style="padding-left:7px;" >
			<?php echo $form->select('User.status',array('active'=>'Active','inactive'=>'Inactive'/*,'del'=>'Delete'*/),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
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
		echo $this->element('admin/paging_box');
		?>
	</tr>

	<?php } else {?>
		<tr>
			<td colspan="4" align="center">No record found</td>
		</tr>
	<?php } ?>
</table>