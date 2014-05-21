<?php //echo $javascript->link(array('jquery')); ?>

<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		if(jQuery("input[type=checkbox]:checked").length > 0)
		{
			jQuery('#frm1').submit();
			jQuery("#clickOnce").attr("disabled", "true");
		}
		
	});
});
</script>

<?php
echo $javascript->link('selectAllCheckbox'); 
$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;
$url = array(
	'keyword' =>$keyword,
	'showtype' =>$show,
	'searchin' =>$fieldname,
);

if($paginator->sortDir() == 'asc'){
	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>''));
}else{
	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>''));
}
?>

<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable" id="myTable" class="tablesorter">

<tr>
	<td colspan="10">
	 Total number of orders - <?php echo $totalorder; ?>
	</td></tr><tr>
	<td colspan="10">
	 Total mobile orders - <?php echo $mobileorder; ?>
	</td>
</tr>

<tr>
		<td colspan="10" >
		<?php
			/************** paging box ************/
			 echo $this->element('admin/paging_box');
			 ?>
		</td>
</tr>

<?php  if(!empty($ordersData)){ 
echo $form->create('Order',array('action'=>'cancelDeleteAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Order")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
?>
	
		<tr>
		<th width="5%"  align="center">
			<?php echo $form->checkbox('Order.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</th>
		<th width="20%" class="adminGridHeading" align="center">
			<?php  echo $paginator->sort('Order No.', 'OrderView.order_number');?>
			<?php if($paginator->sortKey() == 'OrderView.order_number'){
				echo ' '.$image; 
			} ?>
		</th>
		<th width="15%" class="adminGridHeading" align="left">
			<?php echo $paginator->sort('Customer Email', 'OrderView.user_email');?>
			<?php if($paginator->sortKey() == 'OrderView.user_email'){
				echo ' '.$image; 
			} ?>
		</th>
		
		<th width="5%"  class="adminGridHeading header" align="center">
			<?php echo $paginator->sort('Cost', 'OrderView.order_total_cost');
			ECHO  "(".CURRENCY_SYMBOL.")";
			?>			
			<?php if($paginator->sortKey() == 'OrderView.order_total_cost'){
				echo ' '.$image; 
			}?>
		</th>
		<th width="10%" align="center" class="adminGridHeading">
			<?php echo $paginator->sort('Payment', 'OrderView.payment_method');?>
			<?php if($paginator->sortKey() == 'OrderView.payment_method'){
				echo ' '.$image; 
			}?>
		</th>
		<th width="12%" align="center" class="adminGridHeading">
			<?php //echo $paginator->sort('Payment', 'Order.payment_method');?>
			<?php //if($paginator->sortKey() == 'Order.payment_method'){
				//echo ' '.$image; 
			//}?>
			<?php echo 'Seller Name';?>
		</th>
		<th width="10%"  class="adminGridHeading header" align="center">
			<?php echo $paginator->sort('Order Date', 'OrderView.order_date');?>
			<?php if($paginator->sortKey() == 'OrderView.order_date'){
				echo ' '.$image; 
			}?>
		</th>
		<th width="5%"  class="adminGridHeading header" align="center">
			<?php echo $paginator->sort('Order Status', 'OrderView.deleted'); ?>
			<?php if($paginator->sortKey() == 'OrderView.deleted'){
				echo ' '.$image; 
			}?>
		</th>
		
		<td class="adminGridHeading" align="left" width="9%">Product QCID</td>
		<td class="adminGridHeading" align="center" width="4%">Action</td>
	</tr>
		
	<?php
	$class= 'rowClassEven';
	$i = 0;
	//pr($ordersData);
	foreach ($ordersData as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		/*if($row['Order']['deleted'] == '2'){ // fraudlent order
			$bgcolor = "#FFE0DC"; // red
			$class =  'fraudClass' ;
		}*/
		/*else if($row['Order']['deleted'] == '3'){ // cancelled order
			$class =  'cancelledClass';
		}*/
			
			
		/*if(!empty($row['OrderStatus'])){
			$status_flag = array();
			if($row['Order']['deleted'] == 0){
				foreach($row['OrderStatus'] as $order_status){
					$status_flag[] = $order_status['shipping_status'];
				}
			} else if($row['Order']['deleted'] == 2) {
				$status = 'Fraudelent';
			}else if($row['Order']['deleted'] == 3) {  //Fro cancel Order bulk on 16-OCT-2012
				$status = 'Cancelled';
			}
			if(!empty($status_flag)){
				$status = '';
				if(in_array('Unshipped',$status_flag)){
					$status = 'Unshipped';
				}
				if(in_array('Shipped',$status_flag)){
					if($status == 'Unshipped')
						$status = 'Part Shipped';
					else
						$status = 'Shipped';
				}				
						
				if(in_array('Part Shipped',$status_flag)){
					$status = 'Part Shipped';
				}
				
				if(in_array( 'Cancelled', $status_flag)) {
				
				if($status == 'Unshipped' || $status == 'Part Shipped')
					$status = 'Part Shipped';
				else if($status == 'Shipped')
					$status = 'Shipped';
				else
					$status = 'Cancelled';
				}
				
				
				
			}
		}*/
			
		if(rtrim($row['OrderView']['shipping_status'],', ') == 'Cancelled'){
			$bgcolor = "#FF0000"; // red
			$class =  'cancelledClass' ;
		}else{
		 if($row['OrderView']['deleted'] == 2) {
				$class =  'fraudClass' ;
			}
		}
		$i++;
		?>
		<tr class="<?php echo $class ?>" bgcolor="<?php // echo $bgcolor; ?>">
			<td align="center">
				<?php
				//if($row['Order']['deleted'] != 3){
				echo $form->checkbox('select.'.$row['OrderView']['order_id'],array('value'=>$row['OrderView']['order_id'],'id'=>'select1','style'=>array('border:0')));
				echo $form->hidden('deleted.'.$row['OrderView']['order_id'],array('value'=>$row['OrderView']['deleted'],'id'=>'select1','style'=>array('border:0')));
				// } ?>
			</td>
			<td align="center" >
				<?php  echo $row['OrderView']['order_number']; ?>
			</td>
 			<td align="left">
				<?php
				$user_email = ucfirst( wordwrap( $row['OrderView']['user_email'], 25, '<br />', true));
				if(!empty($user_email)){
					echo '<a href="mailto:'.$user_email.'">'.$user_email.'</a>';
				} else { echo '-';}?>
			</td>
			
			<td align="center" >
				<?php  echo $row['OrderView']['order_total_cost'];?>
			</td>
			<td align="center">
				<?php
				if(!empty($row['OrderView']['payment_method'])){
					echo ucfirst($row['OrderView']['payment_method']);
				} else { echo '-';}
				?>
			</td>
			<td align="center">
				<?php
				if(!empty($row['OrderView']['payment_method'])){
					echo $this->Common->getAllSellerOrder($row['OrderView']['order_id']);
				} else { echo '-';}
				?>
			</td>
			<td align="center">
				<?php 
				if(!empty($row['OrderView']['order_date'])){
					echo date('d-M-Y',strtotime($row['OrderView']['order_date']));
				} else { echo '-';}?>
			</td>
			<td align="center">
				<?php 
				$str_status = rtrim($row['OrderView']['shipping_status'],', ');
				echo str_replace(",,", ',', $str_status);
				?>
			</td>
			<td align="left">
				
				<?php 
				echo $html->link($row['OrderView']['quick_code'],'/'.$this->Common->getProductUrl($row['OrderView']['product_id']).'/categories/productdetail/'.$row['OrderView']['product_id'],array('escape'=>false,'target'=>'_blank','class'=>"underline-link"));
				?>
				<?php
				/*$str='';
				foreach ($row['OrderItem'] as $orderitems)
				{	
				$str .= $html->link($orderitems['quick_code'],'/'.$this->Common->getProductUrl($orderitems['product_id']).'/categories/productdetail/'.$orderitems['product_id'],array('escape'=>false,'target'=>'_blank','class'=>"underline-link")).', ';		
				}
				echo rtrim($str,', ');
				*/
				?>
			</td>
			<td align="left" valign="bottom">
				<?php
				
					echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"orders","action"=>"order_detail",$row['OrderView']['order_id']),array('escape'=>false,'title'=>'View'));
					if($row['OrderView']['mobile_users'] ==1){
						echo '&nbsp;';
						echo $html->link($html->image("/img/images/mobile.png", array("alt"=>"Mobile",'style'=>'border:0px',)),"javascript:void('0')",array('escape'=>false,'title'=>'Mobile'));
						
					}
				?>
			</td>
		</tr>
	<?php
		unset($user_email);
	}
	?>
	<tr><td heigth="6" colspan=9></td></tr>
	<tr>
		<td colspan="3" style="padding-left:7px;" >
			<?php echo $form->select('Order.status',array('del'=>'Delete', 'fraud'=>'Fraudulent' ),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53','id'=>'clickOnce'));
			?>
		</td>
		<td colspan="4" align="right">
		</td>
	</tr>
	<?php 	echo $form->end();	?>
	<tr><td colspan="10" >
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