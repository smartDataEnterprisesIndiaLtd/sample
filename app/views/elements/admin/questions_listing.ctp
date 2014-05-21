<?php
$controller = $this->params['controller'];
echo $javascript->link('selectAllCheckbox');
$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;
if($paginator->sortDir() == 'asc'){
	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>''));
} else if($paginator->sortDir() == 'desc'){
	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>''));
} else{
	$image = '';
}
?>
<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
<?php if(!empty($questions)){
echo $form->create('ProductQuestion',array('action'=>'multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"ProductQuestion")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
?>
	<tr>
		<td width="5%" class="adminGridHeading" align="center" style="padding-right:0px">
			<?php echo $form->checkbox('ProductQuestion.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td width="5%" class="adminGridHeading" align="center" style="padding-right:0px">
			<?php echo $paginator->sort('Status', 'ProductQuestion.status');?>
			<?php if($paginator->sortKey() == 'ProductQuestion.status'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="36%" align="center" class="adminGridHeading">
			<?php echo $paginator->sort('Product', 'Product.product_name');?>
			<?php if($paginator->sortKey() == 'Product.product_name'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="13%" align="center" class="adminGridHeading" style="padding-right:0px">
			<?php echo $paginator->sort('Quick Code', 'Product.quick_code');?>
			<?php if($paginator->sortKey() == 'Product.quick_code'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="20%" align="center" class="adminGridHeading">
			<?php echo $paginator->sort('Question', 'ProductQuestion.question');?>
			<?php if($paginator->sortKey() == 'ProductQuestion.question'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="10%"  class="adminGridHeading" align="center" style="padding-right:0px">
			<?php echo $paginator->sort('Created On', 'ProductQuestion.created');?>
			<?php if($paginator->sortKey() == 'ProductQuestion.created'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="center">Action</td>
	</tr>
	<?php
	
	$class= 'rowClassEven';
	foreach ($questions as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		/* status image */
		if($row['ProductQuestion']['status']){
			$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));
$show_status = 'Deactivate';}
		else{
			$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive'));
$show_status = 'Activate';
		}?>
		<tr class="<?php echo $class?>">
			<td align="center">
				<?php echo $form->checkbox('select.'.$row['ProductQuestion']['id'],array('value'=>$row['ProductQuestion']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td align="center" ><span id="active">
				<?php echo $html->link($img, '/admin/product_questions/status/'.$row['ProductQuestion']['id'].'/'.$row['ProductQuestion']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false);?>
				</span>
			</td>
			<td align="left">
				<?php if(!empty($row['Product']['product_name'])){
					echo  $row['Product']['product_name'];
				} else { echo '-';}?>
			</td>
			<td align="center">
				<?php if(!empty($row['Product']['quick_code'])){
					echo  $row['Product']['quick_code'];
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php if(!empty($row['ProductQuestion']['question'])){
					echo $html->link($format->formatString($this->Common->currencyEnter($row['ProductQuestion']['question']),50), '/admin/product_questions/answers/'.$row['ProductQuestion']['id'],array('escape'=>false,'title'=>'Click to view available answers'), false, false);
					//echo $html->link($format->formatString($row['ProductQuestion']['question'],50), '/admin/product_questions/answers/'.$row['ProductQuestion']['id'],array('escape'=>false,'title'=>'Click to view available answers'), false, false);
				} else { echo '-';}?>
			</td>
			<td align="center">
				<?php if(!empty($row['ProductQuestion']['created'])){
					echo date(DATE_FORMAT,strtotime($row['ProductQuestion']['created']));
				} else { echo '-'; }?>
			</td>
			<td align="center" valign="bottom">
				<?php echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px;')),array("controller"=>"product_questions","action"=>"delete",$row['ProductQuestion']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this question?');"));
				echo '&nbsp';
				echo $html->link($html->image("edit.png",array("alt"=>"Edit",'style'=>'border:0px', 'title'=>"Edit " )),array("controller"=>"product_questions","action"=>"add",$row['ProductQuestion']['id']),array('escape'=>false));
				echo '&nbsp';
				echo $html->link('Add Answers',array("controller"=>"product_questions","action"=>"answers",$row['ProductQuestion']['id']),array('escape'=>false));
				?>
			</td>
		</tr>
		<?php
	}
	?>
	
	<tr><td heigth="6" colspan=8></td></tr>
	<tr>
		<td colspan="3" style="padding-left:7px;" >
			<?php echo $form->select('ProductQuestion.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			
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