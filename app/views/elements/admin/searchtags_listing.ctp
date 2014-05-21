<?php
$controller = $this->params['controller'];
echo $javascript->link('selectAllCheckbox');
$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;?>
<?php
if($paginator->sortDir() == 'asc'){
	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>''));
} else if($paginator->sortDir() == 'desc'){
	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>''));
} else{
	$image = '';
}
?>
<p style="float:right; margin-right:5px;">
	<?php echo "Total Records: ".$this->Paginator->counter(array('format' => __('%count%', true)));?>
	&nbsp; &nbsp;
	<?php echo "Total Tags: ".$total_tag;?>
</p>
 <table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
	
	<?php if(!empty($product_tags)){ ?>
	
<?php 
echo $form->create('Product',array('action'=>'searchtag_multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"ProductSearchtag")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
?>

	<tr>
		<td width="3%" class="adminGridHeading" align="center" style="padding-right:0px;">
			<?php echo $form->checkbox('ProductSearchtag.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td width="4%" class="adminGridHeading" align="center" style="padding-right:0px;">
			<?php echo $paginator->sort('Status', 'ProductSearchtag.status');?>
			<?php if($paginator->sortKey() == 'ProductSearchtag.status'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="10%" class="adminGridHeading" align="left">
			<?php echo $paginator->sort('First Name', 'User.firstname');?>
			<?php if($paginator->sortKey() == 'User.firstname'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="10%" class="adminGridHeading" align="left">
			<?php echo $paginator->sort('Last Name', 'User.lastname');?>
			<?php if($paginator->sortKey() == 'User.lastname'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="15%" align="left" class="adminGridHeading">
			<?php echo $paginator->sort('Email', 'User.email');?>
			<?php if($paginator->sortKey() == 'User.email'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="15%" align="left" class="adminGridHeading">
			<?php echo $paginator->sort('Product', 'Product.product_name');?>
			<?php if($paginator->sortKey() == 'Product.product_name'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="9%" align="left" class="adminGridHeading">
			<?php echo $paginator->sort('Product QCID', 'Product.quick_code');?>
			<?php if($paginator->sortKey() == 'Product.quick_code'){
				echo ' '.$image; 
			}?>
		</td>
		
		<td width="20%"  class="adminGridHeading" align="left">Search Tag
			<?php //echo $paginator->sort('Search Tag', 'ProductSearchtag.tags');?>
			<?php //if($paginator->sortKey() == 'ProductSearchtag.tags'){
				//echo ' '.$image; 
			//}?>
		</td>
		
		<td width="10%"  class="adminGridHeading" align="left"  style="padding-right:0px;">
			<?php echo $paginator->sort('Created On', 'ProductSearchtag.created');?>
			<?php if($paginator->sortKey() == 'ProductSearchtag.created'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="center" style="padding-right:0px;">Action</td>
	</tr>
	<?php
	
	$class= 'rowClassEven';
	foreach ($product_tags as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		/* status image */
		if($row['ProductSearchtag']['status']){
			$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));
			$show_status = 'Deactivate';
		} else{
			$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive'));
			$show_status = 'Activate';
		}?>
		<tr class="<?php echo $class?>">
			<td align="center">
				<?php echo $form->checkbox('select.'.$row['ProductSearchtag']['id'],array('value'=>$row['ProductSearchtag']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td align="center"><span id="active">
				<?php echo $html->link($img, '/admin/products/tagstatus/'.$row['ProductSearchtag']['id'].'/'.$row['ProductSearchtag']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false);?>
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
				if(!empty($row['User']['email'])){
					echo  "<a href='mailto:".$row['User']['email']."' >".wordwrap($row['User']['email'], 30, '<br />', true). "</a>";
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
				if(!empty($row['Product']['quick_code'])){?>
					<?php //echo  $row['Product']['quick_code']; ?>
			<?php echo $html->link($row['Product']['quick_code'],'/'.$this->Common->getProductUrl($row['Product']['id']).'/categories/productdetail/'.$row['Product']['id'],array('escape'=>false,'target'=>'_blank','class'=>"underline-link"));?>

			<?php	} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['ProductSearchtag']['tags'])){
					echo  $row['ProductSearchtag']['tags'];
				} else { echo '-';}?>
			</td>
			
			<td align="center">
				<?php 
				if(!empty($row['ProductSearchtag']['created'])){
					echo date(DATE_FORMAT,strtotime($row['ProductSearchtag']['created']));
				} else { echo '-';}?>
			</td>
			<td align="center" valign="bottom">
				<?php
		
				echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px;')),array("controller"=>"products","action"=>"delete_tags",$row['ProductSearchtag']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				
				if($row['ProductSearchtag']['status'] ==0){
					echo '&nbsp';
					echo $html->link($html->image("edit.png",array("alt"=>"Edit",'style'=>'border:0px', 'title'=>"Edit " )),array("controller"=>"products","action"=>"add_tags",$row['ProductSearchtag']['id']),array('escape'=>false));
				}
				?>
				</td>
		</tr>
		<?php
	} ?>
	<tr><td heigth="6" colspan=8></td></tr>
	<tr>
		<td colspan="6" style="padding-left:7px;" >
			<?php echo $form->select('ProductSearchtag.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));
			?>
		</td>
		<td colspan="8" align="right">
		</td>
	</tr>
	<?php echo $form->end();?>
	<tr><td colspan="8" >
	<?php echo $this->element('admin/paging_box');?>
	</td></tr>
	<?php } else {?>
		<tr>
			<td colspan="4" align="center">No record found</td>
		</tr>
	<?php } ?>
</table>