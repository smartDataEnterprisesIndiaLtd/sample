<?php
echo $javascript->link('selectAllCheckbox'); ?>
<?php 
$add_url_string="/keyword:".$keyword."/searchin:".$fieldname;?>
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
	<?php if(!empty($volumeArr)){
	?>
<?php
echo $form->create('Seller',array('action'=>'multiplAction_volumefile','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"BulkUpload")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
?>
	<tr>
		<td width="3%" class="adminGridHeading" align="left" >
			<?php echo $form->checkbox('BulkUpload.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td class="adminGridHeading" align="left" width="15%">
			<?php echo $paginator->sort('First Name', 'User.firstname');?>
			<?php if($paginator->sortKey() == 'User.firstname'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="left" width="15%">
			<?php echo $paginator->sort('Last Name', 'User.lastname');?>
			<?php if($paginator->sortKey() == 'User.lastname'){
				echo ' '.$image; 
			}?>
		</td>
		<td align="left" class="adminGridHeading" width="20%">
			<?php echo $paginator->sort('Email', 'User.email');?>
			<?php if($paginator->sortKey() == 'User.email'){
				echo ' '.$image; 
			}?>
		</td>
		<td align="left" class="adminGridHeading" width="25%">
			<?php echo $paginator->sort('File Name', 'BulkUpload.sample_file');?>
			<?php if($paginator->sortKey() == 'BulkUpload.sample_file'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="left" width="10%">
			<?php echo $paginator->sort('Created On', 'BulkUpload.created');?>
			<?php if($paginator->sortKey() == 'BulkUpload.created'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="center" width="">Action</td>
	</tr>
	<?php
	//pr($volumeArr);
	$class= 'rowClassEven';
	foreach ($volumeArr as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		?>
		<tr class="<?php echo $class?>">
			<td>
				<?php echo $form->checkbox('select.'.$row['BulkUpload']['id'],array('value'=>$row['BulkUpload']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td align="left" >
				<?php 
				if(!empty($row['User']['firstname'])){
					echo ucfirst( wordwrap($row['User']['firstname'], 20 ,"<br>", true ) );
				} else { echo '-';}?>
			</td>
 			<td align="left">
				<?php 
				if(!empty($row['User']['lastname'])){
					echo ucfirst( wordwrap($row['User']['lastname'], 20, "<br>", false) );
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['User']['email'])){
					echo  "<a href='mailto:".$row['User']['email']."' >".wordwrap($row['User']['email'], 25, '<br />', true). "</a>";
				} else { echo '-';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['BulkUpload']['sample_file'])){
					echo  $row['BulkUpload']['sample_file'];
				} else { echo '-';}?>
			</td>
			<td align="center">
				<?php 
				if(!empty($row['BulkUpload']['created'])){
					//echo date(DATE_FORMAT,strtotime($row['BulkUpload']['created']));
					echo date('d/m/Y H:i:s',strtotime($row['BulkUpload']['created']));
				} else { echo '-';}
				?>
			</td>
			<td align="center">
				<?php echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"sellers","action"=>"delete_volumefile",$row['BulkUpload']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp;&nbsp;';
				if( file_exists(WWW_ROOT.PATH_BULKUPLOADS.$row['BulkUpload']['sample_file']) ){
					echo $html->link('Download',"/admin/sellers/download_bulk_files/".$row['BulkUpload']['sample_file'],array('escape'=>false,'title'=>'Download' ,'style'=>'vertical-align:top'));
				}
				echo '&nbsp;&nbsp;';
				echo $html->link('Upload',"/admin/sellers/upload_bulk_listing/".$row['BulkUpload']['user_id'],array('escape'=>false,'title'=>'upload','style'=>'vertical-align:top'));
				?>
			</td>
		</tr>
		<?php
	}
	?>
	<tr><td heigth="6" colspan="7"></td></tr>
	<tr>
		<td colspan="3" style="padding-left:7px;">
			<?php echo $form->select('BulkUpload.status',array('del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));
			?>
		</td>
		<td colspan="5" align="right">
		</td>
	</tr>
	<?php 	echo $form->end();	?>
	<tr>
	<td colspan="7" style="padding-left:7px;" ></td>
		<?php
		/************** paging box ************/
		echo $this->element('admin/paging_box');
		?>
	</tr>

	<?php } else {?>
		<tr>
			<td colspan="4" align="center">No record found</td>
		</tr>
	<?php } ?>
</table>