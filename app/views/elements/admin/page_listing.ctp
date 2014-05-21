<?php
echo $javascript->link('selectAllCheckbox');
$add_url_string ="/keyword:".$keyword."/searchin:".$fieldname; ?>
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
	<?php if(!empty($staticPages)){ ?>
	<tr>
		<!--<td width="5%" class="adminGridHeading" align="left">
			<?php //echo $form->checkbox('Page.selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[pageListing][select]",this.form.select1)')); ?>
		</td>-->
		<!--<td class="adminGridHeading" align="left"><?php //echo $paginator->sort('Status', 'Page.status'); ?><?php /*if($paginator->sortKey() == 'Page.status'){
			echo ' '.$image; 
		}*/?></td>-->
		<td  class="adminGridHeading" align="left" width="45%">
			<?php echo $paginator->sort('Title', 'Page.title'); ?><?php if($paginator->sortKey() == 'Page.title'){
				echo ' '.$image; 
			}?>
		</td> 
		<td  width="25%" align="left" class="adminGridHeading">
			<?php echo $paginator->sort('Page code', 'Page.pagecode'); ?><?php if($paginator->sortKey() == 'Page.pagecode'){
				echo ' '.$image; 
			}?>
		</td>
		<td  width="15%" align="left" class="adminGridHeading">
			<?php echo $paginator->sort('Page Group', 'Page.pagegroup'); ?><?php if($paginator->sortKey() == 'Page.pagegroup'){
				echo ' '.$image; 
			}?>
		</td>
		<td  width="10%" align="center" class="adminGridHeading">
			<?php echo $paginator->sort('Modified', 'Page.modified'); ?><?php if($paginator->sortKey() == 'Page.modified'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="center">
			Action
		</td> 
	</tr>
	<?php
	$class= 'rowClassEven';
	foreach ($staticPages as $staticPage) {

		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';?>
		<tr class="<?php echo $class?>">
			<td align="left">
			<?php echo wordwrap(strip_tags($staticPage['Page']['title']) , 50 , "<br>" , true  ); ?>
			
			</td>
			<td align="left">
			<?php echo wordwrap(strip_tags($staticPage['Page']['pagecode']) , 45 , "<br>" , true  ); ?>
			</td>
			<td align="left">
			<?php echo wordwrap(strip_tags($staticPage['Page']['pagegroup']) , 45 , "<br>" , true  ); ?>
			</td>
			<td align="center">
				<?php echo $format->date_format($staticPage['Page']['modified']); 
				  ?>
			</td>
			<td align="center">
				<?php
				echo $html->link($html->image('zoom.png',array('border'=>0,'alt'=>'View','title'=>'View details')), '/admin/pages/view/'.$staticPage['Page']['id'],array('escape'=>false,'title'=>'View'), false, false);
				echo '&nbsp;';
				//echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"pages","action"=>"delete",$staticPage['Page']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp;';
				echo '&nbsp;'.$html->link($html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit details')),'/admin/pages/add/'.$staticPage['Page']['id'],array('escape'=>false,'title'=>'Edit'),false,false); ?>
			</td>
		</tr>
			
		<?php
		//$class = 
		}?>
		
		<tr><td height="8" colspan="5"></td></tr>
		<tr>
			<td colspan="5" align="center">
			<?php  echo $this->element('admin/paging_box');?>
			</td>
		</tr>	
		<?php } else {?>
		<tr>
			<td colspan="5" align="center">No record found</td>
		</tr>
		<?php } ?>
</table>