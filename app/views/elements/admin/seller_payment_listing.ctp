<?php echo $javascript->link('selectAllCheckbox'); ?>
<?php $add_url_string="/keyword:".$keyword."/searchin:".$fieldname;?>
<?php
	if($paginator->sortDir() == 'asc'){
		$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>''));
	}else if($paginator->sortDir() == 'desc'){
		$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>''));
	}else{
		$image = '';
	}
?>



<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
<?php if(!empty($volumeArr)){ ?>
<?php
	echo $form->create('Seller',array('action'=>'multiplAction_volumefile','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Seller")'));
	echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
	echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
	echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
?>
	<tr>
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
		<!--<td align="left" class="adminGridHeading" width="19%">
			<?php /*echo $paginator->sort('Email', 'User.email');?>
			<?php if($paginator->sortKey() == 'User.email'){
				echo ' '.$image; 
			}*/?>
		</td>-->
		<td align="left" class="adminGridHeading" width="21%">
			<?php echo $paginator->sort('Bank Account Holder Name', 'Seller.account_holder_name');?>
			<?php /*if($paginator->sortKey() == 'BulkUpload.sample_file'){
				echo ' '.$image; 
			}*/?>
		</td>
		<td align="left" class="adminGridHeading" width="15%">
			<?php echo $paginator->sort('Bank Account Number', 'Seller.bank_account_number');?>
			<?php /*if($paginator->sortKey() == 'BulkUpload.sample_file'){
				echo ' '.$image; 
			}*/?>
		</td>
		<td  class="adminGridHeading" align="left" width="15%">
			<?php echo $paginator->sort('Paypal Email', 'Seller.paypal_account_mail');?>
			<?php /*if($paginator->sortKey() == 'BulkUpload.created'){
				echo ' '.$image; 
			}*/?>
		</td>
		
		<!--<td class="adminGridHeading" align="center" width="7%">Make Payment</td>-->
		<td class="adminGridHeading" align="center" width="7%">Failed Attempts</td>
		<td class="adminGridHeading" align="center" width="7%">Verify Account</td>
		<td class="adminGridHeading" align="center" width="5%">Action</td>
		<!--<td class="adminGridHeading" align="center" width="7%">Payment Details</td>-->
	</tr>
	<?php
	//pr($volumeArr);
	$class= 'rowClassEven';
	foreach ($volumeArr as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		?>
		<tr class="<?php echo $class?>">
			<td align="left" >
				<?php 
				if(!empty($row['User']['firstname'])){
					echo ucfirst( wordwrap($row['User']['firstname'], 20 ,"<br>", true ) );
				} else { echo '-';}?>
			</td>
 			<td align="left">
				<?php 
				if(!empty($row['User']['lastname'])){
					echo ucfirst( wordwrap($row['User']['lastname'], 20, "<br>", false) );
				} else { echo '-';}?>
			</td>
			<!--<td align="left">
				<?php 
				/*if(!empty($row['User']['email'])){
					echo  "<a href='mailto:".$row['User']['email']."' >".wordwrap($row['User']['email'], 25, '<br />', true). "</a>";
				} else { echo '-';} */ ?>
			</td>-->
			<td align="left">
				<?php 
				if(!empty($row['Seller']['account_holder_name'])){
					echo ucfirst( wordwrap($row['Seller']['account_holder_name'], 20, "<br>", false) );
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['Seller']['bank_account_number'])){
					echo  $row['Seller']['bank_account_number'];
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['Seller']['paypal_account_mail'])){
					echo wordwrap($row['Seller']['paypal_account_mail'], 25, "<br>", false);
				} else { echo '-';}
				?>
			</td>
			
			<!--<td align="center"><?php //echo $html->link('Send','/admin/sellers/send_seller_deposit_mail/'.$row['Seller']['id'],array('escape'=>false,'title'=>'Deposit amount and send mail to seller','class'=>'deposit_mail')); ?></td>-->
			<td align="center">
				<?php 
				if(!empty($row['Seller']['attempt_number'])){
					echo $row['Seller']['attempt_number'];
				} else { echo '-';}
				?>
			</td>
			<td align="center">
				<?php if(!empty($row['Seller']['status']) && $row['Seller']['status']!=3){
					echo $html->link('Verify','/admin/sellers/verify_seller/'.$row['Seller']['id'],array('escape'=>false,'class'=>'vac'));
				} else {
					echo $html->image("positive-icon.png", array("alt"=>"Accout has been verified",'style'=>'border:0px','title'=>'Accout has been verified'));
				} ?>
			</td>
			<td align="center">
				<?php 
				echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"sellers","action"=>"edit_account_detail",base64_encode($row['Seller']['id'])),array('escape'=>false,'title'=>'Edit Bank Details'));
				?>
			</td>
			<!--<td align="center">-->
				<?php //echo $html->link('view','/admin/sellers/verify_seller/'.$row['User']['id'].'/3',array('escape'=>false,'title'=>'Verify seller account','class'=>'', 'class'=>'payment_details')); ?>
			<!--</td>-->
		</tr>
		<?php
	}
	?>
	<tr><td heigth="6" colspan="7"></td></tr>
	
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