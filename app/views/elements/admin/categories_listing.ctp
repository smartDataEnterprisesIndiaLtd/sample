<?php
echo $javascript->link('selectAllCheckbox');
$add_url_string="/".$department_id."/".$parent_id."/keyword:".$keyword."/searchin:".$fieldname;

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
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td colspan=2>&nbsp;</td></tr>
<tr>
<td colspan="2">
	<table width="100%" cellpadding="2" cellspacing="0" border="0" >
		<tr>
			<td>
				<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
					<?php 
					if(isset($categories) && is_array($categories) && count($categories) > 0){
					echo $form->create('Category',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Category")'));
					echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
					echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
					?>
					<tr>
						<td width="4%"  align="center">
							<?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[departmentListing][select]",this.form.select1)')); ?>
						</td>
						<td class="adminGridHeading" width="10%"  align="center">Image</td>
						<td class="adminGridHeading" width="5%" align="center" >Status</td>
						<td class="adminGridHeading" width="10%" align="center" >Category ID</td>
						<td class="adminGridHeading"   align="left">
							<?php echo $paginator->sort('Title', 'Category.cat_name'); ?><?php if($paginator->sortKey() == 'Category.cat_name'){
								echo ' '.$image;
							}?>
						</td>
						<td class="adminGridHeading" align="center" style="padding:0px">
							<?php echo $paginator->sort('Rank', 'Category.cat_rank'); ?><?php if($paginator->sortKey() == 'Category.cat_rank'){
								echo ' '.$image;
							}?>
						</td>
						<td align="center" class="adminGridHeading" width="12%" >
							<?php echo $paginator->sort('Modified On', 'Category.modified'); ?><?php if($paginator->sortKey() == 'Category.modified'){
							echo ' '.$image; 
							}?>
						</td>
						<td class="adminGridHeading" align="center" width="15%" >
							Action
						</td>
					</tr>
					<?php
					$class= 'rowClassEven';
					foreach ($categories as $category) {
					$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
					/* status image */
					if($category['Category']['status']){
						$img = $html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));$show_status = 'Deactivate';}
					else{
						$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive')); $show_status = 'Activate';
					}?>
					<tr class="<?php echo $class?>">
						<td align="center"><?php echo $form->checkbox('select.'.$category['Category']['id'],array('value'=>$category['Category']['id'],'id'=>'select1')); ?></td>
						<td align="center">
							<?php
							# display current image preview 
							$imagePath = WWW_ROOT.PATH_CATEGORY.$category['Category']['cat_image'];
							$arrImageDim = $format->custom_image_dimentions($imagePath, 50, 40);
							//pr($arrImageDim);
							if(file_exists($imagePath) && !empty($category['Category']['cat_image']) ){
								echo $html->image('/'.PATH_CATEGORY.$category['Category']['cat_image'], array('border'=>'0','height'=>$arrImageDim['height'],'style'=>'border:0px;'));
							}else{
								echo $html->image('no_image.jpeg', array('height'=>$arrImageDim['height'], 'border'=>'0', 'style'=>'border:0px;'));
							}?>
						</td>
						<td align="center"><span id="active"><?php echo  $img ;  ?></span></td>
						<td align="center"><?php echo $category['Category']['id']; ?></td>
						<td align="left">
						<?php 
							echo $html->link($category['Category']['cat_name'],'/admin/categories/index/'.base64_encode($category['Category']['department_id']).'/'.base64_encode($category['Category']['id']), array('class'=>''));
						?>
						</td>
						<td align="center">
							<?php echo $category['Category']['cat_rank']; ?>
						</td>
						<td align="center">
							<?php
							if($category['Category']['modified'] == '0000-00-00 00:00:00'){
								echo 'NA';
							} else{
								echo date(DATE_FORMAT,strtotime($category['Category']['modified']));
							}?>
						</td>
						<td align="center">
							<?php
							echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"categories","action"=>"delete",$category['Category']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
							echo '&nbsp;';
							if(!empty($category['Category']['parent_id'])){
								$parent_id = base64_encode($category['Category']['parent_id']);
							} else{
								$parent_id = 0;
							}
							echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"categories","action"=>"add",base64_encode($category['Category']['department_id']),$parent_id,$category['Category']['id']),array('escape'=>false,'title'=>'Edit'));?>
						</td>
					</tr>
					<?php }?>
					<tr>
						<td colspan="7" style="padding-left:7px" height="30">
							<?php echo $form->select('Category.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));?>
						</td>
					</tr>
					<?php
					echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
					echo $form->end();
					?>
					<tr>
						<td  align="center" colspan="7">
						<?php
						/************** paging box ************/
						echo $this->element('admin/paging_box');
						?>
						</td>
					</tr>
				</table>
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