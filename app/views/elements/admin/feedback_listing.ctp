<?php
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
?>

<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
	<?php if(!empty($feedbacksArr)){
	?>
<?php 
echo $form->create('Seller',array('action'=>'multiplAction_feedback','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Feedback")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
//echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
?>
	<tr>
		<td align="center" width="3%">
			<?php echo $form->checkbox('Feedback.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td class="adminGridHeading" align="left" width="13%">
			<?php echo $paginator->sort('Customer Name', 'User.firstname');?>
			<?php if($paginator->sortKey() == 'User.firstname'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="left" width="15%">
			<?php echo $paginator->sort('Customer Email', 'User.email');?>
			<?php if($paginator->sortKey() == 'User.email'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="left" width="25%">
			<?php echo $paginator->sort('Seller Name', 'SellerSummary.firstname');?>
			<?php if($paginator->sortKey() == 'SellerSummary.firstname'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="left" width="20%">
			<?php echo $paginator->sort('Product', 'OrderItem.product_name');?>
			<?php if($paginator->sortKey() == 'OrderItem.product_name'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="left" width="7%">
			<?php echo $paginator->sort('Product QCID', 'Product.quick_code');?>
			<?php if($paginator->sortKey() == 'Product.quick_code'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="center" style="padding:0px" width="10%">
			<?php echo $paginator->sort('Created On', 'Feedback.created');?>
			<?php if($paginator->sortKey() == 'Feedback.created'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="center">Action</td>
	</tr>
	<?php
	
	$class= 'rowClassEven';
	foreach ($feedbacksArr as $row) {
		
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		?>
		<tr class="<?php echo $class?>">
			<td align="center">
				<?php echo $form->checkbox('select.'.$row['Feedback']['id'],array('value'=>$row['Feedback']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td align="left" >
				<?php 
				if(!empty($row['User']['firstname'])){
					echo ucfirst($row['User']['firstname']).' ';
				}
				if(!empty($row['User']['lastname'])){
					echo ucfirst($row['User']['lastname']);
				}?>
			</td>
			<td align="left" >
				<?php 
				if(!empty($row['User']['email'])){
					echo ucfirst($row['User']['email']).' ';
				}
				?>
			</td>
 			<td align="left">
				<?php
				if(!empty($row['SellerInfo']['business_display_name'])){
					echo ucfirst($row['SellerInfo']['business_display_name']);
				}
				
				
				/*if(!empty($row['SellerSummary']['firstname'])){
					echo ucfirst($row['SellerSummary']['firstname']).' ';
				}
				if(!empty($row['SellerSummary']['lastname'])){
					echo ucfirst($row['SellerSummary']['lastname']);
				}*/?>
			</td>
			
			<td align="left">
				<?php 
				if(!empty($row['OrderItem']['product_name'])){
					echo $row['OrderItem']['product_name'];
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['Product']['quick_code'])){
					echo $html->link($row['Product']['quick_code'],'/'.$this->Common->getProductUrl($row['Product']['id']).'/categories/productdetail/'.$row['Product']['id'],array('escape'=>false,'target'=>'_blank','class'=>"underline-link"));
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['Feedback']['created'])){
					echo date(DATE_FORMAT,strtotime($row['Feedback']['created']));
				} else { echo '-';}?>
			</td>
			<td align="center"><?php
				echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"sellers","action"=>"edit_feedback",base64_encode($row['Feedback']['id'])),array('escape'=>false,'title'=>'Edit'));
				echo '&nbsp;';
				echo $html->link($html->image("undo-icon.png", array("alt"=>"Undo",'style'=>'border:0px',)),array("controller"=>"sellers","action"=>"admin_undofeedback",base64_encode($row['Feedback']['id'])),array('escape'=>false,'title'=>'Undo'));
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
			<?php echo $form->select('Feedback.status',array('undo'=>'Undo'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));
			?>
		</td>
		<td colspan="5" align="right">
		</td>
	</tr>
	<?php echo $form->end();	?>
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