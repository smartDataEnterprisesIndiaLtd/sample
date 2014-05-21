<?php $javascript->link(array('jquery-1.3.2.min'), false); ?>
<?php

//r($ArrSpecialDepartments);
?>
	<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			<?php //echo $html->link('Add New','/admin/hotproducts/add')?>&nbsp;&nbsp;
		</td>
	</tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" >
			<?php //echo $this->element('admin/hotproduct_listing'); ?>
	
		<?php 
		if(isset($ArrSpecialDepartments) && is_array($ArrSpecialDepartments) && count($ArrSpecialDepartments) > 0){?>
			<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
			
			<?php
			echo $form->create('SpecialProduct',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"SpecialProduct")'));
			echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
			?>
			<tr>
			   <!-- <td width="2%" class="adminGridHeading" align="left">
				<?php //echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[faqListing][select]",this.form.select1)')); ?>
			    </td>
			    <td class="adminGridHeading" width="5%" >Status</td>-->
			    <td align="left" class="adminGridHeading" width="30%" >
				Department 
			    </td>
			    <td class="adminGridHeading" align="center" width="30%" >
				    Action
			    </td>
			</tr>
			<?php
			$class= 'rowClassEven';
			foreach ($ArrSpecialDepartments as $SpecialProduct) {
			    $class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			    /* status image */
			    /*if($SpecialProduct['SpecialProduct']['status']){
				$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));$show_status = 'Deactivate';}
			    else{
				$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive')); $show_status = 'Activate';
			    }
			    */?>
			
			    <tr class="<?php echo $class?>">
				<!--<td><?php  // echo $form->checkbox('select.'.$SpecialProduct['SpecialProduct']['id'],array('value'=>$SpecialProduct['SpecialProduct']['id'],'id'=>'select1')); ?></td>
				<td><span id="active">
				    <?php  //echo $html->link($img, '/admin/SpecialProducts/status/'.$SpecialProduct['SpecialProduct']['id'].'/'.$SpecialProduct['SpecialProduct']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
				</span></td>-->
				    
				<td align="left">
				    <?php echo $SpecialProduct['Department']['name'];?>
				</td>
				<td align="center">
				    <?php
				    echo $html->link('Add Product',array("controller"=>"special_products","action"=>"addproduct",$SpecialProduct['SpecialDepartment']['id']),array('escape'=>false,'title'=>'Add Product')); echo '&nbsp;&nbsp';
				    echo $html->link('View Products',array("controller"=>"special_products","action"=>"viewproducts",$SpecialProduct['SpecialDepartment']['id']),array('escape'=>false,'title'=>'View Products')); echo '&nbsp;&nbsp';
				    echo $html->link('Edit Department',array("controller"=>"special_products","action"=>"editdepartment",$SpecialProduct['SpecialDepartment']['id']),array('escape'=>false,'title'=>'Edit'));?> 
				</td>
			    </tr>
			<?php }?>
			
			<!-- <tr>
			    <td colspan="3" style="padding-left:7px" height="30">
			    <?php // echo  $form->select('SpecialProduct.status',array('active'=>'Active','inactive'=>'Inactive'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			    <?php  // echo  $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));?>
			    </td>
			</tr>-->
			    <?php echo $form->end(); ?>
			
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
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td class="legends">
			<b>Legends:</b>
			<?php // echo $html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')); ?>
		</td>
	</tr>
	<!-- Legends -->
	</table>	

