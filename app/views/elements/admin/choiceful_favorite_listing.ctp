<?php
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
		if(isset($choiceful_favorites) && is_array($choiceful_favorites) && count($choiceful_favorites) > 0){?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		  
<?php
echo $form->create('ChoicefulFavorite',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"ChoicefulFavorite")'));
echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));?><?php
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
?>					  
		  
		    <tr>
			<td width="3%" class="adminGridHeading" align="left">
			    <?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[faqListing][select]",this.form.select1)')); ?>
			</td>
			<td class="adminGridHeading" width="5%" align="center" >Status</td>
			<td align="center" class="adminGridHeading" width="15%" >
			    Image
			</td>
			<td class="adminGridHeading" width="20%"  align="left">
			    <?php echo $paginator->sort('Title', 'ChoicefulFavorite.title'); ?><?php if($paginator->sortKey() == 'ChoicefulFavorite.title'){
				echo ' '.$image; 
			    }?>
			</td>
			<td align="left" class="adminGridHeading" width="20%" >
			    Url
			</td>
			<td align="center" class="adminGridHeading" width="10%" >
			    <?php echo $paginator->sort('Modified', 'ChoicefulFavorite.modified'); ?><?php if($paginator->sortKey() == 'ChoicefulFavorite.modified'){
				echo ' '.$image; 
			    }?>
			</td>
			<td class="adminGridHeading" align="center" width="5%" >
				Action
			</td>
		    </tr>
		    <?php
		    $class= 'rowClassEven';
		    foreach ($choiceful_favorites as $choiceful_favorite) {
			$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			/* status image */
			if($choiceful_favorite['ChoicefulFavorite']['status']){
			    $img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));$show_status = 'Deactivate';}
			else{
			    $img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive')); $show_status = 'Activate';
			}?>

			<tr class="<?php echo $class?>" align="left">
			    <td><?php echo $form->checkbox('select.'.$choiceful_favorite['ChoicefulFavorite']['id'],array('value'=>$choiceful_favorite['ChoicefulFavorite']['id'],'id'=>'select1')); ?></td>
			    <td align="center"><span id="active">
				<?php echo $html->link($img, '/admin/choiceful_favorites/status/'.$choiceful_favorite['ChoicefulFavorite']['id'].'/'.$choiceful_favorite['ChoicefulFavorite']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
			    </span></td>
				<td align="center">
					
				<?php
				# display current image preview 
				$imagePath = WWW_ROOT.PATH_CHOICEFUL_FAVORITES.$choiceful_favorite['ChoicefulFavorite']['image'];
				
				if(file_exists($imagePath)   && !empty($choiceful_favorite['ChoicefulFavorite']['image']) ){
					$arrImageDim = $format->custom_image_dimentions($imagePath, 100, 50);
					echo $html->image('/'.PATH_CHOICEFUL_FAVORITES.$choiceful_favorite['ChoicefulFavorite']['image'], array('border'=>'0','height'=>$arrImageDim['height'],'style'=>'border:0px;'));
				}else{
					echo $html->image('/img/no_image.jpeg', array('height'=>40, 'border'=>'0', 'style'=>'border:0px;'));
				}
		    
				?>
				</td>
			    <td align="left">
				<?php echo $format->formatString($choiceful_favorite['ChoicefulFavorite']['title'], 25 , '..');?>
			    </td>
			    <td align="left">
				<?php echo $format->formatString($choiceful_favorite['ChoicefulFavorite']['favorite_url'], 30 , '..');?>
			    </td>
			    <td align="center">
				<?php
				if($choiceful_favorite['ChoicefulFavorite']['modified'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else{
				    echo date(DATE_FORMAT,strtotime($choiceful_favorite['ChoicefulFavorite']['modified']));
				}?>
			    </td>
			    <td align="center">
				<?php
				echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"choiceful_favorites","action"=>"view",$choiceful_favorite['ChoicefulFavorite']['id']),array('escape'=>false,'title'=>'View'));
				echo '&nbsp;';
				echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"choiceful_favorites","action"=>"delete",$choiceful_favorite['ChoicefulFavorite']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp;';
				echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"choiceful_favorites","action"=>"add",$choiceful_favorite['ChoicefulFavorite']['id']),array('escape'=>false,'title'=>'Edit'));?>
			    </td>
			</tr>
		    <?php }?>

		    <tr>
			<td colspan="7" style="padding-left:7px" height="30">
			<?php echo $form->select('ChoicefulFavorite.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));?>
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
