<?php
	echo $javascript->link('selectAllCheckbox'); 
	$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;
	if($paginator->sortDir() == 'asc'){
		$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>'','div'=>false));
	}
	else if($paginator->sortDir() == 'desc'){
		$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>'','div'=>false));
	}
	else{
		$image = '';
	}

	//Start For After updating product redirect to the same page
	$params = $this->params['named'];
	$params_url = '';
	foreach($params as $key => $values){
		$params_url = $params_url.'/'.$key.':'.$values;
	}
	//End After updating product redirect to the same page
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan="2">
<?php if(isset($products) && is_array($products) && count($products) > 0){ ?>
	    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr><td><?php echo $count_products;
		if($count_products > 1) 
			echo ' Results';
		else if($count_products == 1) 
			echo ' Result'; 
		else 
			echo '';?> </td></tr>
		
		 <tr>
		    <td  align="center" width="100%">&nbsp;</td>
		</tr>	
		
	          <tr>
		    <td  align="center" width="100%">
		    <?php
		    /************** paging box ************/
		   echo $this->element('admin/paging_box');
		    ?>
		    </td>
		</tr>
		  
		  <tr>
		    <td  align="center" width="100%">&nbsp;</td>
		</tr>	 
	     <tr>
		<td>
<?php
echo $form->create('Product',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Product")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));

?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		<tr>
		    <td width="2%" align="center">
			<?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[departmentListing][select]",this.form.select1)')); ?>
		    </td>
		    <td width="5%" class="adminGridHeading"  align="center"><b>
		    <?php echo $paginator->sort('Status', 'Product.status'); ?>
			<?php if($paginator->sortKey() == 'Product.status'){     echo $image; 	} ?>
		    
		    </b></td>
		    <td class="adminGridHeading" width="10%"  align="center">
			<?php echo $paginator->sort('Quick Code', 'Product.quick_code'); ?>
			<?php if($paginator->sortKey() == 'Product.quick_code'){     echo $image; 	} ?>
		    </td>
		    <td align="center" class="adminGridHeading" width="6%" >
			<?php echo $paginator->sort('Prod Id', 'Product.id'); ?>
			<?php if($paginator->sortKey() == 'Product.id'){     echo $image; 	} ?>
		    </td>
		    <td align="center" class="adminGridHeading" width="10%" >
			<?php echo $paginator->sort('Product Name', 'Product.product_name'); ?>
			<?php if($paginator->sortKey() == 'Product.product_name'){     echo $image; 	} ?>
		    </td>
		     <td align="center" class="adminGridHeading" width="9%" >
			<?php echo $paginator->sort('Department', 'Product.department_id'); ?>
			<?php if($paginator->sortKey() == 'Product.department_id'){     echo $image; 	} ?>
		    </td>
		   
		     <td align="center" class="adminGridHeading" width="6%" >
			<?php echo $paginator->sort('RRP', 'Product.product_rrp'); ?>
			(<?php echo CURRENCY_SYMBOL ; ?>)
			<?php if($paginator->sortKey() == 'Product.product_rrp'){  echo ' '.$image; }?>
		    </td>
		     <td align="center" class="adminGridHeading" width="12%" >
			<?php echo $paginator->sort('LMPS(New)', 'Product.minimum_price_value'); ?>
			<?php if($paginator->sortKey() == 'Product.minimum_price_value'){  echo ' '.$image; }?>
		    </td>
		     <td align="center" class="adminGridHeading" width="12%" >
			<?php echo $paginator->sort('LMPS(Used)', 'Product.minimum_price_used'); ?>
			<?php if($paginator->sortKey() == 'Product.minimum_price_used'){  echo ' '.$image; }?>
		    </td>
		     
		     <td align="center" class="adminGridHeading" width="10%" >
			<?php echo $paginator->sort('Barcode', 'Product.barcode'); ?>
			<?php if($paginator->sortKey() == 'Product.barcode'){  echo ' '.$image; }?>
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
			<?php echo $html->link($product['Product']['quick_code'],'/'.$this->Common->getProductUrl($product['Product']['id']).'/categories/productdetail/'.$product['Product']['id'],array('escape'=>false,'target'=>'_blank','class'=>"underline-link"));?>
			</td>
			<td align="center">
			<?php echo $product['Product']['id']; ?>
			</td>
			<td align="center">
			    <?php echo wordwrap($product['Product']['product_name'], 45, "<br>", true); ?>
			</td>			
			<td align="center">
				<?php echo $departmentsArr[$product['Product']['department_id']]; ?>
			</td>
			
			<td align="center">
				<?php echo $product['Product']['product_rrp']; ?>
			</td>
			<td align="center">
				<?php
					if(!empty($product['Product']['minimum_price_value']) && $product['Product']['minimum_price_value'] != '0.00'){
						$seller_id_new = $product['Product']['minimum_price_seller'];
						$seller_name = str_replace(array(' ','&'),array('-','and'),html_entity_decode($this->Common->businessDisplayName($seller_id_new), ENT_NOQUOTES, 'UTF-8'));
						echo $html->link($this->Common->businessDisplayName($product['Product']['minimum_price_seller']),'/sellers/'.$seller_name.'/summary/'.$seller_id_new.'/'.$product['Product']['id'],array('escape'=>false,'target'=>'_blank','class'=>"underline-link",'style'=>'color:#0070C0'));
						echo '<br>';
						$deliveryChargesNew = $common->getDeliveryCharges($product['Product']['id'],$product['Product']['minimum_price_seller'], $product['Product']['new_condition_id']);
						echo '<strong>'.CURRENCY_SYMBOL.number_format(($product['Product']['minimum_price_value'] + $deliveryChargesNew),2,'.','').'</strong>';
						echo '<br>';
						echo CURRENCY_SYMBOL.$product['Product']['minimum_price_value'];
						if(!empty($deliveryChargesNew)){
							echo ' + '.CURRENCY_SYMBOL.$deliveryChargesNew;
						}else{
							echo ' + '.CURRENCY_SYMBOL.'0.00';
						}
					}else{
						echo "No Sellers Available";
					}
				?>
			</td>
			<td align="center">
				<?php
					if(!empty($product['Product']['minimum_price_used']) && $product['Product']['minimum_price_used'] != '0.00'){
						$seller_id_used = $product['Product']['minimum_price_used_seller'];
						$seller_name_used = str_replace(array(' ','&'),array('-','and'),html_entity_decode($this->Common->businessDisplayName($seller_id_used), ENT_NOQUOTES, 'UTF-8'));
						echo $html->link($this->Common->businessDisplayName($seller_id_used),'/sellers/'.$seller_name_used.'/summary/'.$seller_id_used.'/'.$product['Product']['id'],array('escape'=>false,'target'=>'_blank','class'=>"underline-link",'style'=>'color:#0070C0'));
						echo '<br>';
						$deliveryChargesUsed = $common->getDeliveryCharges($product['Product']['id'],$product['Product']['minimum_price_used_seller'], $product['Product']['used_condition_id']);
						echo '<strong>'.CURRENCY_SYMBOL.number_format(($product['Product']['minimum_price_used'] + $deliveryChargesUsed),2,'.','').'</strong>';
						echo '<br>';
						echo CURRENCY_SYMBOL.$product['Product']['minimum_price_used'];
						if(!empty($deliveryChargesUsed)){
							echo ' + '.CURRENCY_SYMBOL.$deliveryChargesUsed;
						}else{
							echo ' + '.CURRENCY_SYMBOL.'0.00';
						}
					}else{
						echo "No Sellers Available";
					}
				?>
			</td>
			
			<td align="center">
				<?php echo $product['Product']['barcode']; ?>
			</td>
			
			<td align="center">
			    <?php echo  $format->date_format($product['Product']['created']); ?>
			</td>
			<td align="center">
			    <?php
			    echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"products","action"=>"view",$product['Product']['id']),array('escape'=>false,'title'=>'View'));
			    echo '&nbsp;';
			    echo $html->link($html->image("cube_molecule.png", array("alt"=>"Assign multiple departments",'style'=>'border:0px',)),array("controller"=>"products","action"=>"assign_departments",$product['Product']['id']),array('escape'=>false,'title'=>'Assign multiple departments'));
			    echo '&nbsp;';
			    echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"products","action"=>"delete",$product['Product']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
			    echo '&nbsp;';
			    echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"products","action"=>"add",$product['Product']['id'], $params_url),array('escape'=>false,'title'=>'Edit'));
			    echo '&nbsp;';
			    echo $html->link($html->image("google.png", array("alt"=>"Send to Google Store",'style'=>'border:0px',)),array("controller"=>"products","action"=>"googlecontent",$product['Product']['id'], $params_url),array('escape'=>false,'title'=>'Send to Google Store'));?>
			</td>
		    </tr>
		<?php }?>
	      
		<tr>
		    <td colspan="9" style="padding-left:7px" valign="bottom" height="30">
			<?php echo $form->select('Product.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53')); ?>
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



<?php if(!empty($products)) {?>
<script type="text/javascript">
function save_displayhome(id){
	if(jQuery('#displayhome'+id).attr('checked')){
		var checked_val = 1;
	} else{
		var checked_val = 0;
	}
	jQuery('#preloader').show();
	var postUrl =  SITE_URL+'admin/products/savedisplayhomepage/'+id+'/'+checked_val;
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
			jQuery('#department_pagging').html(msg);
			jQuery('#preloader').hide();
		}
	});
}
</script>
<?php }?>