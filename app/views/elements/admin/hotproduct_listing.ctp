<?php
echo $javascript->link('selectAllCheckbox'); 
$add_url_string="";

if($paginator->sortDir() == 'asc'){
	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>''));
}
else if($paginator->sortDir() == 'desc'){
	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>''));
}
else{
	$image = '';
}

//pr($arrHotproducts);

?>


<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
	<td colspan="2">
		<?php 
		if(isset($arrHotproducts) && is_array($arrHotproducts) && count($arrHotproducts) > 0){?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		    
<?php
echo $form->create('Hotproduct',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Hotproduct")'));
echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
?>
		    <tr>
			<td width="2%" class="adminGridHeading" align="left">
			    <?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[faqListing][select]",this.form.select1)')); ?>
			</td>
			
			
			<td align="left" class="adminGridHeading" width="10%" >
			   <?php echo $paginator->sort('Code', 'Product.quick_code'); 
			   if($paginator->sortKey() == 'Product.quick_code'){
							echo ' '.$image; 
			   }?>
			</td>
			<td align="left" class="adminGridHeading" width="20%" >
			   <?php echo $paginator->sort('Product Name', 'Product.product_name'); 
			   if($paginator->sortKey() == 'Product.product_name'){
							echo ' '.$image; 
			   }?>
			</td>
			
			<td align="left" class="adminGridHeading" width="20%" >
			   <?php echo $paginator->sort('Product Type', 'Hotproduct.product_type'); 
			   if($paginator->sortKey() == 'Hotproduct.product_type'){
							echo ' '.$image; 
			   }?>
			</td>
			
			
			<td class="adminGridHeading" align="center" width="10%" >
				Action
			</td>
		    </tr>
		    <?php
		    $class= 'rowClassEven';
		    foreach ($arrHotproducts as $Hotproduct) {
			$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			?>
			<tr class="<?php echo $class?>">
			    <td>
			    <?php echo $form->checkbox('select.'.$Hotproduct['Hotproduct']['id'],array('value'=>$Hotproduct['Hotproduct']['id'],'id'=>'select1')); ?></td>
			    <td align="left">
				<?php
				if( !empty($Hotproduct['Product']['quick_code']) ){ 
					echo $Hotproduct['Product']['quick_code'];
				}else{
					echo "NA";
				}?>
			    </td>				
			    <td align="left">
				<?php echo $format->formatString($Hotproduct['Product']['product_name'], 30);?>
			    </td>
			    <td align="left">
				<?php
				if( !empty($Hotproduct['Hotproduct']['product_type']) ){
					echo $ProductTypeArr[$Hotproduct['Hotproduct']['product_type']];
				}
				?>
			    </td>
			    
			    <td align="center">
				<?php
				 echo $html->link($html->image("edit.png",array("alt"=>"Edit",'style'=>'border:0px', 'title'=>"Edit " )),array("controller"=>"Hotproducts","action"=>"add",$Hotproduct['Hotproduct']['id']),array('escape'=>false,'title'=>'Edit')); ?> &nbsp;&nbsp;&nbsp;
				 <?php echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"Hotproducts","action"=>"delete",$Hotproduct['Hotproduct']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				?>
			    </td>
			</tr>
		    <?php }?>
		  
		    <tr>
			<td colspan="7" style="padding-left:7px;" height="30">
			<?php echo $form->select('Hotproduct.status',array('del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));?>
			</td>
		    </tr>
			<?php echo $form->end(); ?>
			
			<tr><td colspan="7" >
			<?php
			/************** paging box ************/
			echo $this->element('admin/paging_box');
			?>
			</td>
		</tr>


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
</table>
