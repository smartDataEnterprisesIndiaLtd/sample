<?php
$this->Html->addCrumb('Product Management', '/admin/products');
	$this->Html->addCrumb('Homepage Products', 'javascript:void(0)');
//$javascript->link(array('jquery-1.3.2.min'), false); ?>

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
		<?php //echo $this->element('admin/hotproduct_listing');
		//pr($arrHomepageDepartments); ?>

	<?php 
	if(isset($arrHomepageDepartments) && is_array($arrHomepageDepartments) && count($arrHomepageDepartments) > 0){?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		
		<?php
		echo $form->create('homepage_products',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"SpecialProduct")'));
		echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
		?>
		<tr>
		    <td align="left" class="adminGridHeading" width="89%">
			Page Name 
		    </td>
		    <td class="adminGridHeading" align="center">
			    Action
		    </td>
		</tr>
		<?php 
		$class= 'rowClassEven';
		foreach ($arrHomepageDepartments as $homepageDepartment) {
		    $class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		  ?>
		    <tr class="<?php echo $class?>">
			<td align="left">
			    <?php
			    if( !empty($homepageDepartment['Department']['name']) ){
				echo $homepageDepartment['Department']['name'];
			    }else{
				echo 'Home Page';
			    }?>
			</td>
			<td align="center">
			    <?php
			    $pageName = (!empty($homepageDepartment['Department']['name']) )?($homepageDepartment['Department']['name']):('Home Page');
			    echo $html->link('Add/Edit Products',array("controller"=>"homepage_products","action"=>"editproducts",$homepageDepartment['HomepageProduct']['id'], urlencode($pageName)),array('escape'=>false,'title'=>'Add or edit products')); echo '&nbsp;&nbsp';
			    ?>
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

<!-- Legends -->
</table>	

