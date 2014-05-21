<?php $this->Html->addCrumb('Promotions', '/admin/certificates');
	$this->Html->addCrumb('Manage Affiliates Pages', 'javascript:void(0)');?>
	
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" >
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" height="25px" align="right"></td>
	</tr>
	<tr>
		<td colspan="2" id="pagging">

			<?php
			if($paginator->sortDir() == 'asc'){
				$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>''));
			}
			else if($paginator->sortDir() == 'desc'){
				$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>''));
			}
			else{
				$image = '';
			}?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
    <tr><td>&nbsp;</td></tr>
    <tr>
	<td valign="top">
	    
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
			    <tr>
				<td colspan="2">
					<?php
					if(isset($affiliatesPages) && is_array($affiliatesPages) && count($affiliatesPages) > 0){?>
					<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
					     <tr>
						
						<td class="adminGridHeading" align="left" width="25%">
						    <?php echo $paginator->sort('Title', 'title'); ?><?php if($paginator->sortKey() == 'Affiliates.title'){
							echo ''.$image; 
						    }?>
						</td>
						<td align="left" class="adminGridHeading" width="40%">
						    <?php echo $paginator->sort('Description', 'content'); ?><?php if($paginator->sortKey() == 'Affiliates.content'){
							echo ''.$image; 
						    }?>
						</td>
						<td align="center" class="adminGridHeading" width="10%">
						    <?php echo $paginator->sort('Modified', 'modified'); ?><?php if($paginator->sortKey() == 'Affiliates.modified'){
							echo ''.$image; 
						    }?>
						</td>
						<td class="adminGridHeading" align="center" width="4%">
							Action
						</td>
					    </tr>
					    <?php
					    $class= 'rowClassEven';
					    //pr($affiliatesPages);
					    foreach ($affiliatesPages as $key=>$affiliatePage) {
						$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
						?>

						<tr class="<?php echo $class?>">
						<!-- <td align="center">-->
						<!--	<?php //echo $key+1;?>-->
						<!--    </td>-->
						    <td align="left">
							<?php echo wordwrap($affiliatePage['Affiliate']['title'] ,45 , "<br>", true);?>
						    </td>
						    <td align="left">
							<?php echo (strlen($affiliatePage['Affiliate']['content']) > 50)?substr(strip_tags($affiliatePage['Affiliate']['content']),0,50)."...":strip_tags($affiliatePage['Affiliate']['content']);?>
						    </td>
						    <td align="center">
							<?php
							if( is_null($affiliatePage['Affiliate']['modified'])  || $affiliatePage['Affiliate']['modified'] == '0000-00-00 00:00:00'){
							    echo 'NA';
							} else{
							    echo date(DATE_FORMAT,strtotime($affiliatePage['Affiliate']['modified']));
							}?>
						    </td>
						    <td align="center">
							<?php
							echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"affiliates","action"=>"view",$affiliatePage['Affiliate']['id']),array('escape'=>false,'title'=>'View'));
							echo '&nbsp;';
							echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"affiliates","action"=>"edit",$affiliatePage['Affiliate']['id']),array('escape'=>false,'title'=>'Edit'));?>
						    </td>
						</tr>
					    <?php }?>					   
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
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td class="legends">
			<b>Legends:</b>
			<?php echo $html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')) ?>&nbsp;Edit&nbsp;
			<?php echo $html->image('zoom.png',array('border'=>0,'alt'=>'Active','title'=>'Active')); ?>&nbsp;View&nbsp;
		</td>
	</tr>
	<!-- Legends -->
	</table>
