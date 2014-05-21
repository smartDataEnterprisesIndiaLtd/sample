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
		 <td  class="adminGridHeading" align="left" width="10%">
			<?php echo $paginator->sort('Position', 'FooterBanner.position'); ?><?php if($paginator->sortKey() == 'FooterBanner.position'){
				echo ' '.$image; 
			}?>
		</td>
                 <td  width="10%" align="left" class="adminGridHeading">
			<?php echo $paginator->sort('Date Created', 'FooterBanner.created'); ?><?php if($paginator->sortKey() == 'FooterBanner.created'){
				echo ' '.$image; 
			}?>
		</td>
                <td  class="adminGridHeading" align="left" width="40%">
			<?php echo $paginator->sort('Name', 'FooterBanner.name'); ?><?php if($paginator->sortKey() == 'FooterBanner.name'){
				echo ' '.$image; 
			}?>
		</td>
                 <td  class="adminGridHeading" align="left" width="10%">
                    Thumbnail
			
		</td>
		 <td  class="adminGridHeading" align="left" width="10%">
                   ALT-Text
			
		</td>
               <td  width="10%" align="center" class="adminGridHeading">
			<?php echo $paginator->sort('Modified', 'FooterBanner.modified'); ?><?php if($paginator->sortKey() == 'FooterBanner.modified'){
				echo ' '.$image; 
			}?>
		</td>
		<td  class="adminGridHeading" align="center" width="5%">
			Action
		</td> 
	</tr>
	<?php
	$class= 'rowClassEven';
	foreach ($staticPages as $staticPage) {
		

		$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';?>
		<tr class="<?php echo $class?>">
			<td align="center">
			<?php echo wordwrap(strip_tags($staticPage['FooterBanner']['position']) , 50 , "<br>" , true  ); ?>
			
			</td>
			<td align="center">
			<?php echo $format->date_forma_custom(strip_tags($staticPage['FooterBanner']['created'])); ?>
			</td>
			<td align="left">
			<?php echo wordwrap(strip_tags($staticPage['FooterBanner']['name']) , 45 , "<br>" , true  ); ?>
			</td>
                        <td align="center">
			<?php
				$alt_text = isset($staticPage['FooterBanner']['alt_text'])?$staticPage['FooterBanner']['alt_text']:'';
                        if(isset($staticPage['FooterBanner']['flag']) && $staticPage['FooterBanner']['flag']== 0){
                            echo $html->image('banner/small/img_75_'.$staticPage['FooterBanner']['file'], array("alt" => $alt_text),array('escape' => false));
                        }else{ ?>
                     <?php //echo $this->element('admin/bannerscript');?>
                            <?php echo  html_entity_decode($staticPage['FooterBanner']['script']); ?>
                        <?php } ?>
			</td>
			<td>
				<?php echo wordwrap(strip_tags($staticPage['FooterBanner']['alt_text']) , 45 , "<br>" , true  ); 
				  ?>
			</td>
			<td align="center">
				<?php echo $format->date_format($staticPage['FooterBanner']['modified']); 
				  ?>
			</td>
			<td align="center">
				<?php
				echo $html->link($html->image('b_drop.png',array('border'=>0,'alt'=>'Delete','title'=>'Delete details')), array("controller"=>"pages","action"=>"deletebanner",base64_encode($staticPage['FooterBanner']['id'])),array('escape'=>false,'title'=>'View','onclick'=>"return confirm('Are you sure you want to delete this Banner?');"));
				echo '&nbsp;';
				//echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"pages","action"=>"delete",$staticPage['FooterBanner']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				echo '&nbsp;';
				echo '&nbsp;'.$html->link($html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit details')),'/admin/pages/addbanner/'.$staticPage['FooterBanner']['id'],array('escape'=>false,'title'=>'Edit'),false,false); ?>
			</td>
		</tr>
			
		<?php
		//$class = 
		} } else {?>
		<tr>
			<td colspan="5" align="center">No record found</td>
		</tr>
		<?php } ?>
</table>