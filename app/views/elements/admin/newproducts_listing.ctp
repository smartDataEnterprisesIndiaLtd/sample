<?php
echo $javascript->link('selectAllCheckbox'); 
$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;
?>
<?php
if($paginator->sortDir() == 'asc'){
	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>'','div'=>false));
}
else if($paginator->sortDir() == 'desc'){
	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>'','div'=>false));
}
else{
	$image = '';
}

//pr($products);


?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td colspan=2>&nbsp;</td></tr>
<tr>
    <td colspan="2">
<?php
if(isset($products) && is_array($products) && count($products) > 0){
?>
	    <table width="100%" cellpadding="0" cellspacing="0" border="0">
	     <tr>
		<td>
<?php
echo $form->create('Product',array('action'=>'admin_deleteMultiple','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Product")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));

?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		<tr>
		    <td width="2%" align="center">
			<?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[departmentListing][select]",this.form.select1)')); ?>
		    </td>
		    <td width="5%"  align="center"><b>Status</b></td>
		     <td class="adminGridHeading" width="20%"  align="center">
			<?php echo $paginator->sort('User', 'User.email'); ?>
			<?php if($paginator->sortKey() == 'User.email'){     echo $image; 	} ?>
		    </td>
		    <td class="adminGridHeading" width="10%"  align="center">
			<?php echo $paginator->sort('Quick Code', 'Product.quick_code'); ?>
			<?php if($paginator->sortKey() == 'Product.quick_code'){     echo $image; 	} ?>
		    </td>
		    <td align="center" class="adminGridHeading" width="38%" >
			<?php echo $paginator->sort('Product Name', 'Product.product_name'); ?>
			<?php if($paginator->sortKey() == 'Product.product_name'){     echo $image; 	} ?>
		    </td>
		     <td align="center" class="adminGridHeading" width="10%" >
			<?php echo $paginator->sort('Price', 'Product.product_rrp'); ?>
			(<?php echo CURRENCY_SYMBOL ; ?>)
			<?php if($paginator->sortKey() == 'Product.product_rrp'){  echo ' '.$image; }?>
		    </td>
		     <td align="center" class="adminGridHeading" width="10%" >
			<?php echo $paginator->sort('Created', 'Product.created'); ?>
			<?php if($paginator->sortKey() == 'Product.created'){  echo ' '.$image; }?>
		    </td>
		    <td class="adminGridHeading" align="center"  >
			    Action
		    </td>
		</tr>
		<?php
		
		//pr($products);
		$class= 'rowClassEven';
		foreach ($products as $product) {
			$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			/* status image */
			if($product['Product']['status']){
				$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));$show_status = 'Deactivate';
			} else{
				$img =$html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive')); $show_status = 'Activate';
			}
			?>

		    <tr class="<?php echo $class; ?>" >
			<td align="center"><?php echo $form->checkbox('select.'.$product['Product']['id'],array('value'=>$product['Product']['id'],'id'=>'select1')); ?></td>
			<td align="center">
			    <?php echo  $img; //echo $html->link($img, '/admin/products/status/'.$product['Product']['id'].'/'.$product['Product']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
			</td>
			<td align="center">
				<?php 
				if(!empty($product['User']['email'])){
					echo  "<a href='mailto:".$product['User']['email']."' >".wordwrap($product['User']['email'], 30, '<br />', true). "</a>";
				} else { echo '-';}?>
			</td>
			<td align="center">
			<?php echo $product['Product']['quick_code']; ?>
			</td>
			<td align="center">
			    <?php echo wordwrap($product['Product']['product_name'], 45, "<br>", true); ?>
			</td>			
			<td align="center"><?php echo $product['Product']['product_rrp']; ?></td>
			<td align="center"><?php echo  $format->date_format($product['Product']['created']); ?></td>
			<td align="center">
			    <?php
			     // echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"products","action"=>"view",$product['Product']['id']),array('escape'=>false,'title'=>'View'));
			    echo '&nbsp;';
			    echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"products","action"=>"delete_newproduct",$product['Product']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
			    echo '&nbsp;';
			    echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"products","action"=>"add",$product['Product']['id'],$product['ProductSiteuser']['id']),array('escape'=>false,'title'=>'Edit'));?>
			</td>
		    </tr>
		<?php }?>
	      
		<tr>
		    <td colspan="9" style="padding-left:7px" valign="bottom" height="30" >
		    <?php
		    echo $form->select('Product.status',array('del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53')); ?>
		    </td>
		    </tr>
				 
		 </table>
		 <?php
		    echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));	
		    echo $form->end();
		 ?>
		 </td>
		</tr>
		 <tr>
		    <td  align="center" width="100%">
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
