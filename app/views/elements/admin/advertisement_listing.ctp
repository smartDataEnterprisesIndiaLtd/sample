<?php
echo $javascript->link('selectAllCheckbox'); 
$add_url_string="";
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

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
	<td colspan="2">
		<?php 
		if(isset($advertisements) && is_array($advertisements) && count($advertisements) > 0){?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
<?php
echo $form->create('Advertisement',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Advertisement")'));
echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
?>
		    <tr>
			<td width="2%" class="adminGridHeading" align="left">
			    <?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[faqListing][select]",this.form.select1)')); ?>
			</td>
			<td class="adminGridHeading" width="5%" >Status</td>
			
			<td class="adminGridHeading" width="20%"  align="left">Name
			    <?php //echo $paginator->sort('Label', 'Advertisement.label'); ?><?php /* if($paginator->sortKey() == 'Advertisement.label'){
				echo ' '.$image; 
			    }*/?>
			</td>
			<td align="left" class="adminGridHeading" width="30%" >
			    Url
			</td>
			<td align="left" class="adminGridHeading" width="20%" >
			    Image
			</td>
			<td align="center" class="adminGridHeading" width="10%" >Modified
			    <?php /*echo $paginator->sort('Modified', 'Advertisement.modified'); ?><?php if($paginator->sortKey() == 'Advertisement.modified'){
				echo ' '.$image; 
			    }*/?>
			</td>
			<td class="adminGridHeading" align="center" width="10%" >
				Action
			</td>
		    </tr>
		    <?php
		    $class= 'rowClassEven';
		    foreach ($advertisements as $advertisement) {
			$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			/* status image */
			if($advertisement['Advertisement']['status']){
			    $img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));$show_status = 'Deactivate';}
			else{
			    $img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive')); $show_status = 'Activate';
			}?>

			<tr class="<?php echo $class?>">
			    <td><?php echo $form->checkbox('select.'.$advertisement['Advertisement']['id'],array('value'=>$advertisement['Advertisement']['id'],'id'=>'select1')); ?></td>
			    <td><span id="active">
				<?php echo $html->link($img, '/admin/advertisements/status/'.$advertisement['Advertisement']['id'].'/'.$advertisement['Advertisement']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
			    </span></td>
				
				
			    <td align="left">
				<?php echo $format->formatString($advertisement['Advertisement']['bannerlabel'], 30);?>
			    </td>
			    <td align="left">
				<?php echo $format->formatString($advertisement['Advertisement']['bannerurl'], 30);?>
			    </td>
			    <td align="left">
				<?php
				# display current image preview 
				$imagePath = WWW_ROOT.PATH_ADVERTISEMENTS.$advertisement['Advertisement']['banner_image'];
				$arrImageDim = $format->custom_image_dimentions($imagePath, 150, 50);
				if(file_exists($imagePath)){
					echo $html->image('/'.PATH_ADVERTISEMENTS.$advertisement['Advertisement']['banner_image'], array('border'=>'0','height'=>$arrImageDim['height'],'style'=>'border:0px;'));
				}else{
					echo $html->image('/img/no_image.jpeg', array('height'=>$arrImageDim['height'], 'border'=>'0', 'style'=>'border:0px;'));
				}?>
				
				</td>
			    <td align="center">
				<?php
				if($advertisement['Advertisement']['modified'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else{
				    echo date(DATE_FORMAT,strtotime($advertisement['Advertisement']['modified']));
				}?>
			    </td>
			    <td align="center">
				<?php echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"advertisements","action"=>"view",$advertisement['Advertisement']['id']),array('escape'=>false,'title'=>'View')); echo '&nbsp';
				//echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"advertisements","action"=>"delete",$advertisement['Advertisement']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"advertisements","action"=>"add",$advertisement['Advertisement']['id']),array('escape'=>false,'title'=>'Edit'));?>
			    </td>
			</tr>
		    <?php }?>
		  
		    <tr>
			<td colspan="7" style="padding-left:7px" height="30">
			<?php echo $form->select('Advertisement.status',array('active'=>'Active','inactive'=>'Inactive'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));?>
			</td>
		    </tr>
			<?php echo $form->end(); ?>
			
			<tr><td colspan="7" >
			<?php
			/************** paging box ************/
			echo $this->element('admin/paging_box');
			?>
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
