<?php
echo $javascript->link('selectAllCheckbox');
$add_url_string="/keyword:".$keyword."/showtype:".$show."/searchin:".$fieldname;
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
		if(isset($blogs) && is_array($blogs) && count($blogs) > 0){?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		  
<?php
echo $form->create('Blog',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return isBlogcheckboxSelected(frm1,frm1.select1,"Blog")'));
?>					  
		   <tr>
			<td width="3%" class="adminGridHeading" align="left">
			    <?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[faqListing][select]",this.form.select1)')); ?>
			</td>
			<td class="adminGridHeading" width="5%" align="center" > <?php echo $paginator->sort('Status', 'Blog.status'); ?><?php if($paginator->sortKey() == 'Blog.status'){
				echo ' '.$image; 
			    }?></td>
			<td align="left" class="adminGridHeading" width="15%" >
			    Image
			</td>
			<td class="adminGridHeading" width="20%"  align="left">
			    <?php echo $paginator->sort('Title', 'Blog.title'); ?><?php if($paginator->sortKey() == 'Blog.title'){
				echo ' '.$image; 
			    }?>
			</td>
			<td align="left" class="adminGridHeading" width="10%" >
			    Comments
			</td>
			<td align="left" class="adminGridHeading" width="10%" >
			    
			    <?php echo $paginator->sort('Views', 'Blog.views'); ?><?php if($paginator->sortKey() == 'Blog.views'){
				echo ' '.$image; 
			    }?>
			</td>
			<td align="left" class="adminGridHeading" width="10%" >
			   <?php echo $paginator->sort('Publisher', 'Blog.publisher_name'); ?><?php if($paginator->sortKey() == 'Blog.publisher_name'){
				echo ' '.$image; 
			    }?>
			</td>
			<td align="center" class="adminGridHeading" width="10%" >
			    <?php echo $paginator->sort('Created', 'Blog.created'); ?><?php if($paginator->sortKey() == 'Blog.created'){
				echo ' '.$image; 
			    }?>
			</td>
			<td align="center" class="adminGridHeading" width="10%" >
			    <?php echo $paginator->sort('Modified', 'Blog.modified'); ?><?php if($paginator->sortKey() == 'Blog.modified'){
				echo ' '.$image; 
			    }?>
			</td>
			<td class="adminGridHeading" align="center" width="15%" >
			Action
			</td>
		    </tr>
		    <?php
		    $class= 'rowClassEven';
		    $i =0;
		    foreach ($blogs as $blog) {
			$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			/* status image */
			if($blog['Blog']['status']){
			    $img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));$show_status = 'Deactivate';}
			else{
			    $img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive')); $show_status = 'Activate';
			}?>

			<tr class="<?php echo $class?>" align="left">
			    <td><?php echo $form->checkbox('select.'.$blog['Blog']['id'],array('value'=>$blog['Blog']['id'],'id'=>'select1')); ?></td>
			    <td align="center"><span id="active">
				<?php echo $html->link($img, '/admin/blogs/status/'.$blog['Blog']['id'].'/'.$blog['Blog']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
			    </span></td>
				<td align="center">
					
				<?php
				# display current image preview 
				$imagePath = WWW_ROOT.PATH_CHOICEFUL_BLOGS."small/img_75_".$blog['Blog']['image'];
				
				if(file_exists($imagePath)   && !empty($blog['Blog']['image']) ){
					$arrImageDim = $format->custom_image_dimentions($imagePath, 100, 50);
					echo $html->image('/'.PATH_CHOICEFUL_BLOGS."small/img_75_".$blog['Blog']['image'], array('border'=>'0','height'=>$arrImageDim['height'],'style'=>'border:0px;'));
				}else{
					echo $html->image('/img/no_image.jpeg', array('height'=>40, 'border'=>'0', 'style'=>'border:0px;'));
				}
		    
				?>
				</td>
			    <td align="left">
				<?php echo $format->formatString($blog['Blog']['title'], 25 , '..');?>
			    </td>
			    <td align="left">
				<?php 
				echo count($blog['BlogComment']);
				?>
			    </td>
			    <td align="left">
				<?php  echo $blog['Blog']['views'] ;?>
			    </td>
			    <td align="left">
				<?php echo $format->formatString($blog['Blog']['publisher_name'], 25 , '..');?>
			    </td>
			     
			     <td align="center">
				<?php
				if($blog['Blog']['created'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else{
				    echo date(DATE_FORMAT,strtotime($blog['Blog']['created']));
				}?>
			    </td>
			    <td align="center">
				<?php
				if($blog['Blog']['modified'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else{
				    echo date(DATE_FORMAT,strtotime($blog['Blog']['modified']));
				}?>
			    </td>
			    <td align="center">
				<?php
				echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"blogs","action"=>"view",$blog['Blog']['id']),array('escape'=>false,'title'=>'View'));
				echo '&nbsp;';
				echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"blogs","action"=>"delete",$blog['Blog']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp;';
				echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"blogs","action"=>"add",$blog['Blog']['id']),array('escape'=>false,'title'=>'Edit'));
				echo '&nbsp;';
				echo $html->link($html->image("review_comment.png", array("alt"=>"Review Comments",'style'=>'border:0px',)),array("controller"=>"blogs","action"=>"reviewcomments",$blog['Blog']['id']),array('escape'=>false,'title'=>'Review Comments'));
				
				?>
			    </td>
			</tr>
		    <?php $i++;}?>

		    <tr>
			<td colspan="7" style="padding-left:7px" height="30">
			<?php echo $form->select('Blog.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));?>
			</td>
		    </tr>
		  <tr>
			
<?php
echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
echo $form->end();
?>
		<td colspan="10" >
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
