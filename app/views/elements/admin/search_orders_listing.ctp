<?php
echo $javascript->link('selectAllCheckbox'); 
$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;
$url = array(
	'keyword' =>$keyword,
	'showtype' =>$show,
	'searchin' =>$fieldname,
);
?>
<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable" id="myTable" class="tablesorter">
	<?php if(!empty($ordersData)){
	echo $form->create('Order',array('action'=>'SearchDeleteAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Order")'));
	echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
	echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));?><?php
	echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
	?>
	<thead>
		<tr>
			<th width="4%" class="tour-std-th" align="center">
				<?php echo $form->checkbox('Order.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
			</td>
			<th width="22%" class="tour-std-th" align="center"><b>Order No</b></th>
			<th width="20%" class="tour-std-th" align="left"><b>Customer Name</b></th>
			<th width="20%" class="tour-std-th" align="left"><b>Seller Name</b></th>
			<th width="12%" class="tour-std-th" align="center"><b>Order Cost</b></th>
			<th width="12%" class="tour-std-th" align="center"><b>Order Date</b></th>
			<th class="tour-std-th" align="center">Action</td>
		</tr>
	</thead>
	<tbody>
	<?php
	$class= 'rowClassEven';
	$i = 0;
	foreach ($ordersData as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		if($row['OrderView']['deleted'] == '2'){ // fraudlent offer
			$bgcolor = "#FFE0DC"; // red
			$class =  'fraudClass' ;
		}
		$i++;
		?>
		<tr class="<?php echo $class ?>" bgcolor="<?php // echo $bgcolor; ?>">
			<td align="center">
				<?php
				echo $form->checkbox('select.'.$row['OrderView']['order_id'],array('value'=>$row['OrderView']['order_id'] ,'id'=>'select1','style'=>array('border:0')));?>
			</td>
			<td align="center" >
				<?php  echo $row['OrderView']['order_number'];?>
			</td>
 			<td align="left">
				<?php 
				if(!empty($row['OrderView']['customer_name'])){
					echo ucfirst( wordwrap( $row['OrderView']['customer_name'], 25, '<br />', true));
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php
				if(!empty($row['OrderView']['seller_name'])){
					echo ucfirst( wordwrap( $row['OrderView']['seller_name'], 25, '<br />', true));
				} else { echo '-';}
				?>
			</td>
			<td align="center" >
				<?php  echo CURRENCY_SYMBOL.' '.$format->money($row['OrderView']['order_total_cost'],2);?>
			</td>
			<td align="center">
				<?php 
				if(!empty($row['OrderView']['order_date'])){
					echo date(DATE_FORMAT,strtotime($row['OrderView']['order_date']));
				} else { echo '-';}?>
			</td>
			<td align="center" valign="bottom">
				<?php
				   echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"orders","action"=>"order_detail",$row['OrderView']['order_id']),array('escape'=>false,'title'=>'View'));
				 ?>
			</td>
		</tr>
		<?php
	}
	?>
	</tbody>
	<tr><td heigth="6" colspan=7></td></tr>
	<tr>
		<td colspan="3" style="padding-left:7px;" >
			<?php echo $form->select('Order.status',array('del'=>'Delete', 'fraud'=>'Fraudulent' ),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));
			?>
		</td>
		<td colspan="4" align="right">
		</td>
	</tr>
	<?php 	echo $form->end();	?>
	<tr><td colspan="7" >
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

<script type="text/javascript">
jQuery(document).ready(function()
    { 
	jQuery("#myTable").tablesorter({widgets: ['zebra']});;
    }
);


</script>