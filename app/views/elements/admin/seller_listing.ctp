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
<?php echo "Total Sellers " .$this->Paginator->counter(array('format' => __('%count%', true)));?>
<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
	<?php if(!empty($usersArr)){?>
<?php 
echo $form->create('Seller',array('action'=>'multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"User")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
?>
	<tr>
		<td width="3%" align="center">
			<?php echo $form->checkbox('User.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td class="adminGridHeading" align="center" style="padding:0px" width="5%">
			<?php echo $paginator->sort('Status', 'User.status');?>
			<?php if($paginator->sortKey() == 'User.status'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="left" width="10%">
			<?php echo $paginator->sort('First Name', 'User.firstname');?>
			<?php if($paginator->sortKey() == 'User.firstname'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="left" width="10%">
			<?php echo $paginator->sort('Last Name', 'User.lastname');?>
			<?php if($paginator->sortKey() == 'User.lastname'){
				echo ' '.$image; 
			}?>
		</td>
		<td align="left" class="adminGridHeading" width="12%">
			<?php echo $paginator->sort('Business Name', 'Seller.business_name');?>
			<?php if($paginator->sortKey() == 'Seller.business_name'){
				echo ' '.$image; 
			}?>
		</td>
		<td align="left" class="adminGridHeading" width="16%">
			<?php echo $paginator->sort('Email', 'User.email');?>
			<?php if($paginator->sortKey() == 'User.email'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="center" width="7%">In/Out Stock Products</td>
		<td class="adminGridHeading" align="center" width="8%">Seller Id</td>
		
		<td  class="adminGridHeading"  align="center" style="padding:0px;" width="10%">
			Created/Login/Modified
			<?php //echo $paginator->sort('Created On', 'Seller.created');?>
			<?php //if($paginator->sortKey() == 'User.created'){
				//echo ' '.$image; 
			//}?>
		</td>
		<td  class="adminGridHeading"  align="center" style="padding:0px" width="7%">
			
			<?php echo  "Total Orders";//$paginator->sort('Total Orders', 'Order.order_count');
			 //if($paginator->sortKey() == 'Order.order_count'){
				//echo ' '.$image; 
			//}
			?>
			
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
			<td align="center">
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
			<td align="center">
				<a href="javascript:void(0)" title="<?php echo $row['Seller']['totalProducts']?>">
				<?php 
					echo '<span style="color:#003399">'.$row['Seller']['totalProductsInStock'].'</span> / <span style="color:#cc0000">'.$row['Seller']['totalProductsOutStock'].'</span>';
				?>
				</a>
			</td>
			<td align="center">
				<?php   
					$seller_name=str_replace(array(' ','&'),array('-','and'),html_entity_decode($row['Seller']['business_name'], ENT_NOQUOTES, 'UTF-8'));
					echo $html->link($row['User']['id'],'/sellers/'.$seller_name.'/summary/'.$row['User']['id']);
				?>
			</td>
			<td align="center">
				<?php 
				if(!empty($row['Seller']['created'])){
					echo date(DATE_FORMAT,strtotime($row['Seller']['created']));
				} else { echo '-';}
				echo '<br>';
				if(!empty($row['Seller']['sellerLastLogin'])){
					echo date(DATE_FORMAT,strtotime($row['Seller']['sellerLastLogin']));
				} else { echo '-';}
				echo '<br>';
				if(!empty($row['Seller']['sellerLastModify'])){
					echo date(DATE_FORMAT,strtotime($row['Seller']['sellerLastModify']));
				} else { echo '-';}
				?>
			</td>
			<td align="center">
				<?php 
				if($row['Order']['order_count']>0){
					echo $html->link($row['Order']['order_count'],'/admin/orders/index/seller/'.$row['User']['id']);
				}else{
					echo '0';	
				}
				?>
			</td>
			<td align="center">
				<?php echo $html->link($html->image("change_pass_icon.png", array("alt"=>"Change Password",'style'=>'border:0px;'))/*'[Change Password]'*/,array("controller"=>"sellers","action"=>"seller_changepassword",$row['User']['id']),array('escape'=>false,'title'=>'Change Password'));
				echo '&nbsp';
				echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"sellers","action"=>"view",base64_encode($row['User']['id'])),array('escape'=>false,'title'=>'View'));
				echo '&nbsp;';
				echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"sellers","action"=>"delete",$row['User']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp;';
				echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"sellers","action"=>"add",base64_encode($row['User']['id'])),array('escape'=>false,'title'=>'Edit'));
				echo ' &nbsp;';
				echo $html->link($html->image("reports_icon.png", array("alt"=>"Payment Reports",'style'=>'border:0px',)),"/admin/sellers/payment_summary/".$row['User']['id'],array('escape'=>false,'title'=>'Payment Reports'));
				echo '&nbsp;';
				echo $html->link($html->image("seller_list.png", array("alt"=>"Manage Seller Listing",'style'=>'border:0px',)),"/marketplaces/manage_listing/seller_id:".$row['User']['id'],array('escape'=>false,'target'=>'_Blank','title'=>'Manage Seller Listing'));
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