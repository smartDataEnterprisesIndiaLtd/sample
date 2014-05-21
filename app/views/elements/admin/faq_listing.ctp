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
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		    <td>
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
			    <tr>
				<td colspan="2">
					<?php 
					if(isset($resultData) && is_array($resultData) && count($resultData) > 0){?>
					 <table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
					   
<?php
	echo $form->create('Faq',array('action'=>'multiplAction','method'=>'POST','name'=>'frm1','id'=>'frm1','onSubmit'=>'return ischeckboxSelected(frm1,frm1.select1,"Faq")'));
	echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$fieldname,'div'=>false,'maxlength'=>'50'));?><?php
	echo $form->hidden('Search.show',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$show,'div'=>false,'maxlength'=>'50'));?><?php
	echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>$keyword,'div'=>false,'maxlength'=>'50'));
	echo $form->hidden('submit',array('id'=>'submit','value'=>'1'));
?>
					    <tr>
						<td width="2%" class="adminGridHeading" align="left">
						    <?php echo $form->checkbox('selectall',array('value'=>'1','id'=>'selectAllChildCheckboxs','onClick'=>'return GetAction(this.checked,"this.form.data[faqListing][select]",this.form.select1)')); ?>
						</td>
						<td width="5%" class="adminGridHeading">
						    <?php echo $paginator->sort('Status', 'Faq.status'); ?><?php if($paginator->sortKey() == 'Faq.status'){
							echo ' '.$image; 
						    }?>
						</td>
						<td  width="44%" class="adminGridHeading" align="left">
						    <?php echo $paginator->sort('Question', 'Faq.question'); ?><?php if($paginator->sortKey() == 'Faq.question'){
							echo ' '.$image; 
						    }?>
						</td><td  width="20%" align="left" class="adminGridHeading">
						    <?php echo $paginator->sort('Answer', 'Faq.answer'); ?><?php if($paginator->sortKey() == 'Faq.answer'){
							echo ' '.$image; 
						    }?>
						    
						</td>
						<td align="left" class="adminGridHeading"  width="15%">
						    <?php echo $paginator->sort('Type', 'Faq.faq_category_id'); ?><?php if($paginator->sortKey() == 'Faq.faq_category_id'){
							echo ' '.$image; 
						    }?>
						</td>
						
						<td  width="8%" align="center" class="adminGridHeading">
						    <?php echo $paginator->sort('Created', 'Faq.created'); ?><?php if($paginator->sortKey() == 'Faq.created'){
							echo ' '.$image; 
						    }?>
						</td>
						<td class="adminGridHeading" align="center"  width="14%">
							Action
						</td>
					    </tr>
					    <?php
					    $class= 'rowClassEven';
					    foreach ($resultData as $faq) {
						$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
						/* status image */
						if($faq['Faq']['status']){
						    $img =$html->image('green2.jpg',array('border'=>0,'alt'=>'Active'));$show_status = 'Deactivate';}
						else{
						    $img = $html->image('red3.jpg',array('border'=>0,'alt'=>'Inactive')); $show_status = 'Activate';
						}?>

						<tr class="<?php echo $class?>">
						    <td><?php echo $form->checkbox('select.'.$faq['Faq']['id'],array('value'=>$faq['Faq']['id'],'id'=>'select1')); ?></td>
						    <td><span id="active">
							<?php echo $html->link($img, '/admin/faqs/status/'.$faq['Faq']['id'].'/'.$faq['Faq']['status'],array('escape'=>false,'title'=>'Click to'.$show_status), false, false); ?>
						    </span></td>
						    <td align="left">
							<?php  if(!empty($faq['Faq']['question']))
								echo wordwrap($faq['Faq']['question'], 45 , "<br>",true);
							else
								echo '-';
							?>
						    </td>
						    <td align="left">
							<?php  if(!empty($faq['Faq']['answer']))
								echo $format->formatString( strip_tags($faq['Faq']['answer']),35);
							else
								echo '-';
							?>
						    </td>
						    <td>
							<?php //echo $form->select('Faq.sequence',array(array_combine(range(1,$total_questions),range(1,$total_questions))),$faq['Faq']['sequence'],array('type'=>'select', 'label'=>false,'div'=>false,'error'=>false,'size'=>1,'class'=>'textbox','onChange'=>'save_sequence(this.value,'.$faq['Faq']['id'].')'),'-');?>
							<?php if(!empty($faq['FaqCategory']['title']))
								echo $format->formatString($faq['FaqCategory']['title'],25);
							else
								echo '-';
							?>
						    </td>
						    <td align="center">
							
							<?php echo $format->date_format($faq['Faq']['created']);
							?>
						    </td>
						    <td align="center">
							<?php
							echo $html->link($html->image("zoom.png", array("alt"=>"View",'style'=>'border:0px',)),array("controller"=>"faqs","action"=>"view",$faq['Faq']['id']),array('escape'=>false,'title'=>'View'));
							echo '&nbsp;';
							echo $html->link($html->image("b_drop.png", array("alt"=>"Delete",'style'=>'border:0px',)),array("controller"=>"faqs","action"=>"delete",$faq['Faq']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this record?');"));
							echo '&nbsp;';
							echo $html->link($html->image("edit.png", array("alt"=>"Edit",'style'=>'border:0px',)),array("controller"=>"faqs","action"=>"add",$faq['Faq']['id']),array('escape'=>false,'title'=>'Edit'));?>
						    </td>
						</tr>
					    <?php }?>
					 
					    <tr>
						<td style="padding-left:7px" colspan="7" height="30">
						<?php echo $form->select('Faq.status',array('active'=>'Active','inactive'=>'Inactive','del'=>'Delete'),null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'-- Select --');?>&nbsp;&nbsp;<?php echo $form->submit('Submit',array('div'=>false,'alt'=>'Multiple Status','type'=>'Submit','title'=>'Multiple Status','class'=>'btn_53'));?>
						</td>
						
					    </tr>
					 
					    
					    
	  </tr>
	<?php 	echo $form->end();	?>
	<tr><td colspan="8" >
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
	
<?php if(!empty($resultData)) {?>
<script type="text/javascript">
function save_sequence(sequence,id){
	
	jQuery('#preloader').show();
	var postUrl = SITE_URL+'admin/faqs/savesequense/'+id+'/'+sequence;
	jQuery.ajax({
	cache:false,
	async: false,
	type: "GET",
	url: postUrl,
	success: function(msg){
		jQuery('#faq_pagging').html(msg);
		jQuery('#preloader').hide();
	}
	 });
}
</script>
<?php }?>