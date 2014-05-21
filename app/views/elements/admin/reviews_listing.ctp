<?php
$controller = $this->params['controller'];
echo $javascript->link('selectAllCheckbox');
$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;?>
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
	
	<?php if(!empty($reviews)){ 

echo $form->create('Review',array('action'=>'multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Review")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
?>

	<tr>
		<td width="3%" class="adminGridHeading" align="left">
			<?php echo $form->checkbox('Review.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td width="5%" class="adminGridHeading" align="left">
			<?php echo $paginator->sort('Status', 'Review.status');?>
			<?php if($paginator->sortKey() == 'Review.status'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="13%" class="adminGridHeading" align="left">
			<?php echo $paginator->sort('First Name', 'User.firstname');?>
			<?php if($paginator->sortKey() == 'User.firstname'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="12%" class="adminGridHeading" align="left">
			<?php echo $paginator->sort('Last Name', 'User.lastname');?>
			<?php if($paginator->sortKey() == 'User.lastname'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="32%" align="left" class="adminGridHeading">
			<?php echo $paginator->sort('Product', 'Product.product_name');?>
			<?php if($paginator->sortKey() == 'Product.product_name'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="20%" align="left" class="adminGridHeading">
			<?php echo $paginator->sort('Quick Code', 'Product.quick_code');?>
			<?php if($paginator->sortKey() == 'Product.quick_code'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="10%"  class="adminGridHeading" align="left">
			<?php echo $paginator->sort('Created On', 'Review.created');?>
			<?php if($paginator->sortKey() == 'Review.created'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="center">Action</td>
	</tr>
	<?php
	
	$class= 'rowClassEven';
	foreach ($reviews as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		/* status image */
		if($row['Review']['status']){
			$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));
$show_status = 'Deactivate';}
		else{
			$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive'));
$show_status = 'Activate';
		}?>
		<tr class="<?php echo $class?>">
			<td>
				<?php echo $form->checkbox('select.'.$row['Review']['id'],array('value'=>$row['Review']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td><span id="active">
				<?php echo $html->link($img, '/admin/reviews/status/'.$row['Review']['id'].'/'.$row['Review']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
				</span>
			</td>
			<td align="left" >
				<?php 
				if(!empty($row['User']['firstname'])){
					echo ucfirst( wordwrap( $row['User']['firstname'] ,15, '<br />', true));
				} else { echo '-';}?>
			</td>
 			<td align="left">
				<?php 
				if(!empty($row['User']['lastname'])){
					echo ucfirst( wordwrap( $row['User']['lastname'], 15, '<br />', true));
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['Product']['product_name'])){
					echo  $row['Product']['product_name'];
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['Product']['quick_code'])){
					echo  $row['Product']['quick_code'];
				} else { echo '-';}?>
			</td>
			
			<td align="left">
				<?php 
				if(!empty($row['Review']['created'])){
					echo date(DATE_FORMAT,strtotime($row['Review']['created']));
				} else { echo '-';}?>
			</td>
			<td align="center" valign="bottom">
				<?php //echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"reviews","action"=>"view",$row['Review']['id']),array('escape'=>false,'title'=>'View')); echo '&nbsp';
				echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px;')),array("controller"=>"reviews","action"=>"delete",$row['Review']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this review?');"));
				echo '&nbsp';
				echo $html->link($html->image("edit.png",array("alt"=>"Edit",'style'=>'border:0px', 'title'=>"Edit " )),array("controller"=>"reviews","action"=>"add",$row['Review']['id']),array('escape'=>false));
				?></td>
		</tr>
		<?php
	}
	?>
	
	<tr><td heigth="6" colspan=8></td></tr>
	<tr>
		<td colspan="3" style="padding-left:7px;" >
			<?php echo $form->select('Review.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?><!--&nbsp;&nbsp;-->
			<?php //echo $form->select('Review.status',array('del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));
			?>
		</td>
		<td colspan="5" align="right">
		</td>
	</tr>
	<?php 	echo $form->end();	?>
	<tr><td colspan="8" >
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