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
 <table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
	
	<?php if(!empty($certificate_tags)){ ?>
	
<?php 
echo $form->create('Certificate',array('action'=>'searchtag_multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"CertificateSearchtag")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
?>

	<tr>
		<td width="3%" class="adminGridHeading" align="center" style="padding-right:0px;">
			<?php echo $form->checkbox('CertificateSearchtag.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td width="4%" class="adminGridHeading" align="center" style="padding-right:0px;">
			<?php echo $paginator->sort('Status', 'CertificateSearchtag.status');?>
			<?php if($paginator->sortKey() == 'CertificateSearchtag.status'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="12%" class="adminGridHeading" align="left">
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
		<td width="17%" align="left" class="adminGridHeading">
			<?php echo $paginator->sort('Email', 'User.email');?>
			<?php if($paginator->sortKey() == 'User.email'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="20%"  class="adminGridHeading" align="left">Search Tag
			<?php //echo $paginator->sort('Search Tag', 'CertificateSearchtag.tags');?>
			<?php //if($paginator->sortKey() == 'CertificateSearchtag.tags'){
				//echo ' '.$image; 
			//}?>
		</td>
		
		<td width="10%"  class="adminGridHeading" align="left"  style="padding-right:0px;">
			<?php echo $paginator->sort('Created On', 'CertificateSearchtag.created');?>
			<?php if($paginator->sortKey() == 'CertificateSearchtag.created'){
				echo ' '.$image; 
			}?>
		</td>
		<td class="adminGridHeading" align="center" style="padding-right:0px;">Action</td>
	</tr>
	<?php
	
	$class= 'rowClassEven';
	foreach ($certificate_tags as $row) {
		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
		/* status image */
		if($row['CertificateSearchtag']['status']){
			$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));
			$show_status = 'Deactivate';
		} else{
			$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive'));
			$show_status = 'Activate';
		}?>
		<tr class="<?php echo $class?>">
			<td align="center">
				<?php echo $form->checkbox('select.'.$row['CertificateSearchtag']['id'],array('value'=>$row['CertificateSearchtag']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td align="center"><span id="active">
				<?php echo $html->link($img, '/admin/certificates/tagstatus/'.$row['CertificateSearchtag']['id'].'/'.$row['CertificateSearchtag']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false);?>
				</span>
			</td>
			<td align="left" >
				<?php 
				if(!empty($row['User']['firstname'])){
					echo ucfirst( wordwrap( $row['User']['firstname'] ,15, '<br />', true));
				} else { echo 'Admin';}?>
			</td>
 			<td align="left">
				<?php 
				if(!empty($row['User']['lastname'])){
					echo ucfirst( wordwrap( $row['User']['lastname'], 15, '<br />', true));
				} else { echo 'Admin';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['User']['email'])){
					echo  "<a href='mailto:".$row['User']['email']."' >".wordwrap($row['User']['email'], 30, '<br />', true). "</a>";
				} else { echo 'Admin';}?>
			</td>
			<td align="left">
				<?php 
				if(!empty($row['CertificateSearchtag']['tags'])){
					echo  $row['CertificateSearchtag']['tags'];
				} else { echo '-';}?>
			</td>
			
			<td align="center">
				<?php 
				if(!empty($row['CertificateSearchtag']['created'])){
					echo date(DATE_FORMAT,strtotime($row['CertificateSearchtag']['created']));
				} else { echo '-';}?>
			</td>
			<td align="center">
				<?php echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px;')),array("controller"=>"certificates","action"=>"delete_tags",$row['CertificateSearchtag']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp';
				echo $html->link($html->image("edit.png",array("alt"=>"Edit",'style'=>'border:0px', 'title'=>"Edit " )),array("controller"=>"certificates","action"=>"add_tags",$row['CertificateSearchtag']['id']),array('escape'=>false));
				?></td>
		</tr>
		<?php
	} ?>
	<tr><td heigth="6" colspan=8></td></tr>
	<tr>
		<td colspan="6" style="padding-left:7px;" >
			<?php echo $form->select('CertificateSearchtag.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
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