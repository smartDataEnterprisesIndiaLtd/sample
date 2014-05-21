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
		 <td  class="adminGridHeading" align="left" width="35%">
			<?php echo $paginator->sort('Title', 'FooterDescription.name'); ?><?php if($paginator->sortKey() == 'FooterDescription.name'){
				echo ' '.$image; 
			}?>
		</td>
                 <td  width="45%" align="left" class="adminGridHeading">
			Footer Description
		</td>
               
               <td  width="15%" align="center" class="adminGridHeading">
			<?php echo $paginator->sort('Modified', 'FooterDescription.modified'); ?><?php if($paginator->sortKey() == 'FooterDescription.modified'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="center" width="15%">
			Action
		</td> 
	</tr>
	<?php
	$class= 'rowClassEven';
	foreach ($staticPages as $staticPage) {
		

		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';?>
		<tr class="<?php echo $class?>">
			<td align="left">
			<?php echo wordwrap(strip_tags($staticPage['FooterDescription']['name']) , 50 , "<br>" , true  ); ?>
			
			</td>
			<td align="left">
			<?php 
                        if(strlen($staticPage['FooterDescription']['desc'])>93){
                        echo substr(strip_tags($staticPage['FooterDescription']['desc']),0,90)."....";
                        }else{
                            echo substr(strip_tags($staticPage['FooterDescription']['desc']),0,90);
                        }?>
			</td>
			<td align="center">
				<?php echo $format->date_format($staticPage['FooterDescription']['modified']); 
				  ?>
			</td>
			<td align="center">
				<?php
				echo $html->link($html->image('b_drop.png',array('border'=>0,'alt'=>'Delete','title'=>'Delete details')), array("controller"=>"pages","action"=>"deletedesc",base64_encode($staticPage['FooterDescription']['id'])),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this Title?');"));
				echo '&nbsp;';
				//echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"pages1","action"=>"deletedesc",base64_encode($staticPage['FooterDescription']['id'])),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp;';
				echo '&nbsp;'.$html->link($html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit details')),'/admin/pages/adddesc/'.$staticPage['FooterDescription']['id'],array('escape'=>false,'title'=>'Edit'),false,false); ?>
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