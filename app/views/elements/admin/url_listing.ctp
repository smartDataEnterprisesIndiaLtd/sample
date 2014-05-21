<?php
echo $javascript->link('selectAllCheckbox'); 
$add_url_string="";

if($paginator->sortDir() == 'asc'){
	$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>''));
}
else if($paginator->sortDir() == 'desc'){
	$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>''));
}
else{
	$image = '';
}

//pr($arrBrands);
?>


<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
	<td colspan="2">
		<?php 
		if(isset($arrChangeUrl) && is_array($arrChangeUrl) && count($arrChangeUrl) > 0){?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
		    
		<?php
		echo $form->create('ChangeUrl',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Brand")'));
		echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
		?>
		    <tr>
			<td class="adminGridHeading" align="left" width="40%" >Current Url</td>
			<td align="left" class="adminGridHeading" width="50%" >Change Url</td>
			<td class="adminGridHeading" align="center" width="10%">Action</td>
		    </tr>
		    <?php
		    $class= 'rowClassEven';
		    foreach ($arrChangeUrl as $changeUrl) {
			$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			?>
			<tr class="<?php echo $class?>">
			  <!--  <td align="center"> <?php  // echo $form->checkbox('select.'.$brand['Brand']['id'],array('value'=>$brand['Brand']['id'],'id'=>'select1')); ?></td>-->
			    <td align="left">&nbsp;<?php echo  $changeUrl['ChangeUrl']['current_url'];?> </td>
			    <td align="left"><?php echo wordwrap($changeUrl['ChangeUrl']['change_url'],60, "<br>", true);?> </td>
			    <td align="center">
				<?php
				 echo $html->link($html->image("edit.png",array("alt"=>"Edit",'style'=>'border:0px', 'title'=>"Edit " )),array("controller"=>"settings","action"=>"addurl",$changeUrl['ChangeUrl']['id']),array('escape'=>false,'title'=>'Edit')); ?> &nbsp;&nbsp;&nbsp;
				 <?php echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"Settings","action"=>"deleteurl",$changeUrl['ChangeUrl']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
				?>
			    </td>
			</tr>
		    <?php }?>
		  
		   <!-- <tr>
			<td colspan="7" style="padding-left:7px;" height="30">
			<?php // echo $form->select('Brand.status',array('del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;
			<?php // echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));?>
			</td>
		    </tr>-->
			<?php echo $form->end(); ?>
			
			<tr><td colspan="3" >
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
