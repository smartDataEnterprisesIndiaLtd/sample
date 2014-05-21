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
		if(isset($blogquestions) && is_array($blogquestions) && count($blogquestions) > 0){?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		  
<?php
echo $form->create('Blog',array('action'=>'multipleAction2/','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"BlogQuestion")'));
?>					  
		  
		    <tr>
			<td width="3%" class="adminGridHeading" align="left">
			    <?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[faqListing][select]",this.form.select1)')); ?>
			</td>
			<td class="adminGridHeading" width="5%" align="center" > <?php echo $paginator->sort('Status', 'BlogQuestion.status'); ?><?php if($paginator->sortKey() == 'BlogQuestion.status'){
				echo ' '.$image; 
			    }?></td>
			
			<td align="center" class="adminGridHeading" width="10%" >
			    <?php echo $paginator->sort('Created', 'BlogQuestion.created'); ?><?php if($paginator->sortKey() == 'BlogQuestion.created'){
				echo ' '.$image; 
			    }?>
			</td>
			
			<td align="left" class="adminGridHeading" width="15%" >
			    <?php echo $paginator->sort('Question', 'BlogQuestion.question'); ?><?php if($paginator->sortKey() == 'BlogQuestion.question'){
				echo ' '.$image; 
			    }?>
			</td>
			<td align="left" class="adminGridHeading" width="15%" >
			    <?php echo $paginator->sort('Number of Answers', 'BlogQuestion.number_of_answers'); ?><?php if($paginator->sortKey() == 'BlogQuestion.number_of_answers'){
				echo ' '.$image; 
			    }?>
			</td>
			
			<td align="left" class="adminGridHeading" width="15%" >
				<?php echo $paginator->sort('Correct Answer', 'BlogQuestion.answer'); ?><?php if($paginator->sortKey() == 'BlogQuestion.answer'){
				echo ' '.$image; 
			    }?>
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
		    
		    foreach ($blogquestions as $blogquestion) {
			$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			/* status image */
			if($blogquestion['BlogQuestion']['status']){
			    $img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));$show_status = 'Deactivate';}
			else{
			    $img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive')); $show_status = 'Activate';
			}?>

			<tr class="<?php echo $class?>" align="left">
			    <td><?php echo $form->checkbox('select.'.$blogquestion['BlogQuestion']['id'],array('value'=>$blogquestion['BlogQuestion']['id'],'id'=>'select1')); ?></td>
			    <td align="center"><span id="active">
				<?php echo $html->link($img, '/admin/blogs/questionstatus/'.$blogquestion['BlogQuestion']['id'].'/'.$blogquestion['BlogQuestion']['status'],array('escape'=>false,'title'=>'Click to '.$show_status), false, false); ?>
			    </span></td>
				
			    <td align="left">
				<?php
				if($blogquestion['BlogQuestion']['created'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else{
				    echo date(DATE_FORMAT,strtotime($blogquestion['BlogQuestion']['created']));
				}?>
			    </td>
			    
			    <td align="left">
				<?php  echo $blogquestion['BlogQuestion']['question'] ;?>
			    </td>
			    
			    <td align="center">
				<?php  echo $blogquestion['BlogQuestion']['number_of_answers'] ;?>
			    </td>
			    
			    <td align="left">
				<?php echo $format->formatString($blogquestion['BlogQuestionAnswer'][0]['answer'], 100 , '..');?>
			    </td>
			     
			    
			    <td align="center">
				<?php
				if($blogquestion['BlogQuestion']['modified'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else{
				    echo date(DATE_FORMAT,strtotime($blogquestion['BlogQuestion']['modified']));
				}?>
			    </td>
			    <td align="center">
				<?php
				
				echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"blogs","action"=>"questionsdelete",$blogquestion['BlogQuestion']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp;';
				echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"blogs","action"=>"addquestion",$blogquestion['BlogQuestion']['id']),array('escape'=>false,'title'=>'Edit'));
				echo '&nbsp;';
				
				
				?>
			    </td>
			</tr>
		    <?php $i++;}?>

		    <tr>
			<td colspan="7" style="padding-left:7px" height="30">
			<?php echo $form->select('BlogQuestion.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));?>
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
