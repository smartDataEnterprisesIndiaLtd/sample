<?php $javascript->link(array('jquery-1.3.2.min'), false); ?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
<tr>
	<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
	<td class="adminGridHeading" height="25px" align="right">
		<?php //echo $html->link('Add New','/admin/hotproducts/add')?>&nbsp;&nbsp;
	</td>
</tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2">
	<table align="center" width="100%" border="0" cellpadding="2" cellspacing="2" valign="top">
	
	</table>
</td></tr>
<tr>
	<td colspan="2" >
		<?php //echo $this->element('admin/hotproduct_listing'); ?>

	<?php 
	if(isset($categories) && is_array($categories) && count($categories) > 0){ ?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		
		<?php
		echo $form->create('reports',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"SpecialProduct")'));
		echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
		?>
		<tr>
		    <td align="left" class="adminGridHeading" width="30%" >Department Name </td>
		    <td class="adminGridHeading" align="center" width="30%" >Number of Products </td>
		</tr>
		<?php
		//pr($categories);
		$class= 'rowClassEven';
		foreach ($categories as $category) {
		    $class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		  ?>
		    <tr class="<?php echo $class?>">
			<td align="left">
			<?php echo $html->link($category['Category']['cat_name'],'/admin/reports/category_inventory/'.$category['Category']['department_id'].'/'.$category['Category']['id'], array('class'=>'')); ?>
			</td>
			<td align="center"><?php  echo $this->Common->getProductsCountByCategory($category['Category']['id']);   ?>	</td>
		    </tr>
		<?php }?>
		
		
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

<!-- Legends -->
</table>	

