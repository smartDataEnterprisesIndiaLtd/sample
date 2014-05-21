<?php
$controller = $this->params['controller'];
echo $javascript->link('selectAllCheckbox');
$add_url_string="/keyword:".$keyword."/searchin:".$fieldname;?>
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
App::import('Model','Order');
$this->Order = new Order;
		
?>
 <table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
	
<?php if(!empty($gift_certificates)){ ?>

<tr><td colspan="8" >
	<?php
		/************** paging box ************/
		 echo $this->element('admin/paging_box');
		 ?>
	</td></tr>

<?php echo $form->create('Certificate',array('action'=>'multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Certificate")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
?>

	<tr>
		<td width="5%" class="adminGridHeading" align="center" style="padding-right:0px">
			<?php echo $form->checkbox('Certificate.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td width="5%" class="adminGridHeading" align="center" style="padding-right:0px">
			<?php echo $paginator->sort('Status', 'Certificate.status');?>
			<?php if($paginator->sortKey() == 'Certificate.status'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="20%" class="adminGridHeading" align="left" style="padding-left:5px">
			<?php echo $paginator->sort('Code', 'Certificate.code');?>
			<?php if($paginator->sortKey() == 'Coupon.code'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="15%" class="adminGridHeading" align="left">
			<?php echo $paginator->sort('Amount', 'Certificate.amount');?>
			<?php if($paginator->sortKey() == 'Certificate.amount'){
				echo ' '.$image; 
			}?>
		</td>
		
		<td width="18%" align="left" class="adminGridHeading"><!--Recipients-->
		<?php echo $paginator->sort('Recipients', 'Certificate.receiver');?>
			<?php if($paginator->sortKey() == 'Certificate.receiver'){
				echo ' '.$image; 
			}?>
		</td>
		
		<td width="18%" align="left" class="adminGridHeading">
		<?php echo $paginator->sort('Choiceful.com Email', 'User.email');?>
			<?php if($paginator->sortKey() == 'User.email'){
				echo ' '.$image; 
			}?>
		</td>
		
		<td width="9%" align="left" class="adminGridHeading">
		Amount Spent
		</td>
		
		<td width="10%"  class="adminGridHeading" align="center" style=" padding-right:0px;">
			<?php echo $paginator->sort('Created On', 'Certificate.created');?>
			<?php if($paginator->sortKey() == 'Certificate.created'){
				echo ' '.$image; 
			}?>
		</td>
		<!--<td class="adminGridHeading" align="center">Action</td>-->
	</tr>
	<?php
	
	$class= 'rowClassEven';
	foreach ($gift_certificates as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		/* status image */
		if($row['Certificate']['status']){
			$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));
			$show_status = 'Deactivate';
		} else{
			$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive'));
			$show_status = 'Activate';
		}
		
		/****code starts for spennt order***/
		
	
		$orderdata = $this->Order->find('first',array('conditions'=>array('Order.user_id'=>$row['Giftbalance']['user_id'],'DATE(Order.created) <=' => date('Y-m-d',strtotime($row['Giftbalance']['created']))),'fields'=>'SUM(Order.gc_amount) as gc_amount'));
		
		if($orderdata[0]['gc_amount'] <= $row['Certificate']['amount'])
		{
		$spend_amount =	$orderdata[0]['gc_amount'];
		}
		else
		{
		$spend_amount =	$row['Certificate']['amount'];
		}
		//pr($orderdata);
		
		
		
		/*****ends******/
		
		
		?>
		<tr class="<?php echo $class?>">
			<td align="center" style="padding-right:0px!important">
				<?php echo $form->checkbox('select.'.$row['Certificate']['id'],array('value'=>$row['Certificate']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td align="center"><span id="active">
				<?php echo $html->link($img, '/admin/certificates/status/'.$row['Certificate']['id'].'/'.$row['Certificate']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
				</span>
			</td>
			<td align="left" style="padding-left:5px">
				<?php
				if(!empty($row['Certificate']['code'])){
					echo  $row['Certificate']['code'];
				} else { echo '-'; } ?>
			</td>
			<td align="left" >
				<?php 
				if(!empty($row['Certificate']['amount'])){
					echo CURRENCY_SYMBOL.' '.$row['Certificate']['amount'];
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['Certificate']['receiver'])){
					echo  "<a href='mailto:".$row['Certificate']['receiver']."' >".wordwrap($row['Certificate']['receiver'], 25, '<br />', true). "</a>";
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['User']['email'])){
					echo $row['User']['email'];
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($spend_amount)){
					echo $spend_amount;
				} else { echo '-';}?>
			</td>
			
			<td align="center" align="left">
				<?php 
				if(!empty($row['Certificate']['created'])){
					echo date(DATE_FORMAT,strtotime($row['Certificate']['created']));
				} else { echo '-';}?>
			</td>
			<!--<td align="center" valign="bottom">
				<?php //echo $html->link($html->image("edit.png",array("alt"=>"Edit",'style'=>'border:0px', 'title'=>"Edit " )),array("controller"=>"certificates","action"=>"add",$row['Certificate']['id']),array('escape'=>false));
				?>
			</td>-->
		</tr>
	<?php } ?>
	
	<tr><td heigth="6" colspan=8></td></tr>
	<tr>
		<td colspan="3" style="padding-left:7px;" >
			<?php echo $form->select('Certificate.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?><!--&nbsp;&nbsp;-->
			<?php //echo $form->select('Coupon.status',array('del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));
			?>
		</td>
		<td colspan="5" align="right">
		</td>
	</tr>
	<?php echo $form->end(); ?>
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