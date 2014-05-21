<?php
//$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;
?>
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
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
<tr><td>&nbsp;</td></tr>
<tr>
<td valign="top">
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
	<td colspan="2">
		<?php 
		if(isset($blogcomments) && is_array($blogcomments) && count($blogcomments) > 0){?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		  
<?php
echo $form->create('Blog',array('action'=>'multipleAction1/'.$blog_id,'method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"BlogComment")'));
?>					  
		  
		    <tr>
			<td width="3%" class="adminGridHeading" align="left">
			    <?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[faqListing][select]",this.form.select1)')); ?>
			</td>
			<td class="adminGridHeading" width="5%" align="center" > <?php echo $paginator->sort('Status', 'BlogComment.status'); ?><?php if($paginator->sortKey() == 'BlogComment.status'){
				echo ' '.$image; 
			    }?></td>
			
			<td align="center" class="adminGridHeading" width="10%" >
			    <?php echo $paginator->sort('Created', 'BlogComment.created'); ?><?php if($paginator->sortKey() == 'BlogComment.created'){
				echo ' '.$image; 
			    }?>
			</td>
			
			<td align="left" class="adminGridHeading" width="15%" >
			    <?php echo $paginator->sort('Name', 'BlogComment.name'); ?><?php if($paginator->sortKey() == 'BlogComment.name'){
				echo ' '.$image; 
			    }?>
			</td>
			<td align="left" class="adminGridHeading" width="25%" >
			    Comments
			</td>
			<td align="center" class="adminGridHeading" width="10%" >Modified</td>
			   
			</td>
		
			<td class="adminGridHeading" align="center" width="15%" >
			Action
			</td>
		    </tr>
		    <?php
		    $class= 'rowClassEven';
		    $i=0;
		    
		    foreach ($blogcomments as $blogcomments) {
			$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			/* status image */
			if($blogcomments['BlogComment']['status']){
			    $img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));$show_status = 'Deactivate';}
			else{
			    $img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive')); $show_status = 'Activate';
			}?>

			<tr class="<?php echo $class?>" align="left">
			    <td><?php echo $form->checkbox('select.'.$blogcomments['BlogComment']['id'],array('value'=>$blogcomments['BlogComment']['id'],'id'=>'select1')); ?></td>
			    <td align="center"><span id="active">
				<?php echo $html->link($img, '/admin/blogs/commentstatus/'.$blogcomments['BlogComment']['blog_id'].'/'.$blogcomments['BlogComment']['id'].'/'.$blogcomments['BlogComment']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
			    </span></td>
				
			    <td align="left">
				<?php
				if($blogcomments['BlogComment']['created'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else{
				    echo date(DATE_FORMAT,strtotime($blogcomments['BlogComment']['created']));
				}?>
			    </td>
			    
			    <td align="left">
				<?php  echo $blogcomments['BlogComment']['name'] ;?>
			    </td>
			    <td align="left">
				<?php echo $format->formatString($blogcomments['BlogComment']['comment'], 100 , '..');?>
			    </td>
			     
			    
			    <td align="center">
				<?php
				if($blogcomments['BlogComment']['modified'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else{
				    echo date(DATE_FORMAT,strtotime($blogcomments['BlogComment']['modified']));
				}?>
			    </td>
			    <td align="center">
				<?php
				
				echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"blogs","action"=>"commentdelete",$blogcomments['BlogComment']['blog_id'],$blogcomments['BlogComment']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp;';
				echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"blogs","action"=>"addcomment",$blogcomments['BlogComment']['blog_id'],$blogcomments['BlogComment']['id']),array('escape'=>false,'title'=>'Edit'));
				echo '&nbsp;';
				
				
				?>
			    </td>
			</tr>
		    <?php $i++;}?>

		    <tr>
			<td colspan="7" style="padding-left:7px" height="30">
			<?php echo $form->select('BlogComment.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));?>
			</td>
		    </tr>
		  <tr>
			
<?php
echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
echo $form->end();
?>
		<td colspan="7" >
		<?php
		/************** paging box ************/
		echo $this->element('admin/paging_box');
		?>
		</td></tr>
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
</td>
</tr>
</table>
</td>
</tr>
</table>
