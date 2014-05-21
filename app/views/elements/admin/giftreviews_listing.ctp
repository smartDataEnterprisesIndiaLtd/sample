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

echo $form->create('Review',array('action'=>'certificate_multiplAction','method'=>'GET','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"CertificateReview")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
?>

	<tr>
		<td width="3%" class="adminGridHeading" align="center" style="padding-right:0px;">
			<?php echo $form->checkbox('CertificateReview.selectall',array('id'=>'selectAllChildCheckboxs' , 'value'=>'1','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>
		<td width="8%" class="adminGridHeading"  align="center" style="padding-right:0px;">
			<?php echo $paginator->sort('Status', 'CertificateReview.status');?>
			<?php if($paginator->sortKey() == 'CertificateReview.status'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="15%" class="adminGridHeading" align="left">
			<?php echo $paginator->sort('First Name', 'User.firstname');?>
			<?php if($paginator->sortKey() == 'User.firstname'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="15%" class="adminGridHeading"  align="left" >
			<?php echo $paginator->sort('Last Name', 'User.lastname');?>
			<?php if($paginator->sortKey() == 'User.lastname'){
				echo ' '.$image; 
			}?>
		</td>
		<td width="38%" class="adminGridHeading" align="left">Comments</td>
		<td width="12%"  class="adminGridHeading" align="center" style="padding-right:0px;">
			<?php echo $paginator->sort('Created On', 'CertificateReview.created');?>
			<?php if($paginator->sortKey() == 'CertificateReview.created'){
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
		if($row['CertificateReview']['status']){
			$img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));
			$show_status = 'Deactivate';
		} else{
			$img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive'));
			$show_status = 'Activate';
		}?>
		<tr class="<?php echo $class?>" align="center">
			<td>
				<?php echo $form->checkbox('select.'.$row['CertificateReview']['id'],array('value'=>$row['CertificateReview']['id'],'id'=>'select1','style'=>array('border:0'))); ?>
			</td>
			<td align="center"><span id="active">
				<?php echo $html->link($img, '/admin/reviews/certificate_status/'.$row['CertificateReview']['id'].'/'.$row['CertificateReview']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
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
				if(!empty($row['CertificateReview']['comments'])){
					echo $row['CertificateReview']['comments'];
				} else { echo '-';}?>
			</td>
			
			<td align="center">
				<?php 
				if(!empty($row['CertificateReview']['created'])){
					echo date(DATE_FORMAT,strtotime($row['CertificateReview']['created']));
				} else { echo '-';}?>
			</td>
			<td align="center">
				<?php echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px;')),array("controller"=>"reviews","action"=>"delete_certificate",$row['CertificateReview']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this review?');"));
				echo '&nbsp';
				echo $html->link($html->image("edit.png",array("alt"=>"Edit",'style'=>'border:0px', 'title'=>"Edit " )),array("controller"=>"reviews","action"=>"add_gift_certificate",$row['CertificateReview']['id']),array('escape'=>false));
				?>
			</td>
		</tr>
		<?php
	}
	?>
	
	<tr><td heigth="6" colspan=8></td></tr>
	<tr>
		<td colspan="3" style="padding-left:7px;" >
			<?php echo $form->select('CertificateReview.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?><!--&nbsp;&nbsp;-->
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