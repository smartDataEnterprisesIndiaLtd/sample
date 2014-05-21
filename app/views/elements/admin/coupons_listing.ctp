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
	
<?php if(!empty($coupons)){

echo $form->create('Coupon',array('action'=>'multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Coupon")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
?>

	<tr>
		<td width="5%" class="adminGridHeading" align="left">
			<?php echo $form->checkbox('Coupon.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td width="5%" class="adminGridHeading" align="center" style="padding-right:0px">
			<?php echo $paginator->sort('Status', 'Coupon.status');?>
			<?php if($paginator->sortKey() == 'Coupon.status'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="35%" class="adminGridHeading" align="left">
			<?php echo $paginator->sort('Name', 'Coupon.name');?>
			<?php if($paginator->sortKey() == 'Coupon.name'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="20%" class="adminGridHeading" align="center" style="padding-right:0px">
			<?php echo $paginator->sort('Code', 'Coupon.discount_code');?>
			<?php if($paginator->sortKey() == 'Coupon.discount_code'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="10%" align="left" class="adminGridHeading">
			<?php echo $paginator->sort('Can use', 'Coupon.used_times');?>
			<?php if($paginator->sortKey() == 'Coupon.used_times'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="10%" align="center" class="adminGridHeading" style="padding-right:0px">
			<?php echo $paginator->sort('Expiry Date', 'Coupon.expiry_date');?>
			<?php if($paginator->sortKey() == 'Coupon.expiry_date'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="10%"  class="adminGridHeading" align="center" style="padding-right:0px">
			<?php echo $paginator->sort('Created On', 'Coupon.created');?>
			<?php if($paginator->sortKey() == 'Coupon.created'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="center">Action</td>
	</tr>
	<?php
	
	$class= 'rowClassEven';
	foreach ($coupons as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		/* status image */
		if($row['Coupon']['status']){
			$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));
			$show_status = 'Deactivate';
		} else{
			$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive'));
			$show_status = 'Activate';
		}?>
		<tr class="<?php echo $class?>">
			<td>
				<?php echo $form->checkbox('select.'.$row['Coupon']['id'],array('value'=>$row['Coupon']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td align="center"><span id="active">
				<?php echo $html->link($img, '/admin/coupons/status/'.$row['Coupon']['id'].'/'.$row['Coupon']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
				</span>
			</td>
			<td align="left">
				<?php
				if(!empty($row['Coupon']['name'])){
					echo  $row['Coupon']['name'];
				} else { echo '-'; } ?>
			</td>
			<td  align="center"  >
				<?php 
				if(!empty($row['Coupon']['discount_code'])){
					echo $row['Coupon']['discount_code'];
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['Coupon']['used_times'])){
					if(($row['Coupon']['used_times']) > 1 )
						echo  $row['Coupon']['used_times'].' times';
					else
						echo  $row['Coupon']['used_times'].' time';
				} else { echo 'Unlimited';}?>
			</td>
			<td align="center">
				<?php 
				if(!empty($row['Coupon']['expiry_date'])){
					echo date(DATE_FORMAT,strtotime($row['Coupon']['expiry_date']));
				} else { echo '-';}?>
			</td>
			<td align="center">
				<?php 
				if(!empty($row['Coupon']['created'])){
					echo date(DATE_FORMAT,strtotime($row['Coupon']['created']));
				} else { echo '-';}?>
			</td>
			<td align="center" valign="bottom">
				<?php echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px;')),array("controller"=>"coupons","action"=>"delete",$row['Coupon']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this coupon?');"));
				echo '&nbsp';
				echo $html->link($html->image("edit.png",array("alt"=>"Edit",'style'=>'border:0px', 'title'=>"Edit " )),array("controller"=>"coupons","action"=>"add",$row['Coupon']['id']),array('escape'=>false));
				?>
			</td>
		</tr>
	<?php } ?>
	
	<tr><td heigth="6" colspan=8></td></tr>
	<tr>
		<td colspan="3" style="padding-left:7px;" >
			<?php echo $form->select('Coupon.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?><!--&nbsp;&nbsp;-->
			<?php //echo $form->select('Coupon.status',array('del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
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