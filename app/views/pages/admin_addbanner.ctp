<?php
$this->Html->addCrumb('Website Pages', '/admin/faqs');
if(!empty($id)){
$this->Html->addCrumb('Edit Banner', 'javascript:void(0)');
}else{
$this->Html->addCrumb('Add Banner', 'javascript:void(0)');	
}


//$javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
<?php  echo $form->create('Pages',array('action'=>'addbanner/'.$id,'method'=>'POST','name'=>'frmFooterBanners','id'=>'frmFooterBanners','enctype' => 'multipart/form-data'));
	echo $javascript->link('fckeditor');
?>
<style>
    .iRadio{
    }
    .iRadio input{
        vertical-align : middle;
    }

</style>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
						<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
						<td class="adminGridHeading"></td>
			       </tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="adminBox">
				<!--<tr>
					<td colspan="2">
						<div class="errorlogin_msg">
							<?php //echo $this->element('errors'); ?>
						</div> 
					</td>
				</tr>-->
				
				<tr height="20px">
					<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<!--<tr>
				<td colspan="2">
					<div id="jsErrors"></div>
				</td>
				</tr>-->
                                
                                <tr>
					<td valign="top" align="right"><span class="error_msg">*</span>Position : </td>
					<!-- <?php  //if(!empty($id)) {?> --->
                                        <td>
                                            <?php $selectedPosition = isset($this->data['FooterBanner']['position'])?$this->data['FooterBanner']['position']:'';?>
						<?php echo $form->select('FooterBanner.position',$baner_position,$selectedPosition,array('type'=>'select','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1),'Select Position'); ?>
						<?php echo $form->error('FooterBanner.position'); ?>
					</td>
                                        <!-- <?php //} else{ ?> --->
                                        <td>
						<?php //echo $form->input("FooterBanner.position",array("label"=>false,"div"=>false, 'class'=>'textbox-m')); ?>
						<?php //echo $form->error('FooterBanner.position'); ?>
					</td>
                                        
                                       <!--- <?php// }?> --->
				</tr>
				<tr>
					<td valign="top" align="right"><span class="error_msg">*</span>Name : </td>
					<td>
						<?php echo $form->input("FooterBanner.name",array("label"=>false,"div"=>false, 'class'=>'textbox-m')); ?>
						<?php //echo $form->error('FooterBanner.name'); ?>
					</td>
				</tr>
				
				 <tr>
					<td valign="top" align="right"></td>
					<td   align="left" class="iRadio">
                                            
						<?php
                                                $option = array('0'=>'<span class="RsW">Image</span>', '1'=>'<span class="RsW">Script</span>');
                                                echo $form->radio('FooterBanner.flag',$option,array('default'=>'0',"label"=>false,"div"=>false,'legend'=>false,'class'=>'choiceR','id'=>'RadioChoice','onChange'=>'choice(this.value);'));
						?>
					</td>
				</tr>
                                 <tr id="imageID">
					<td valign="top" align="right"><span class="error_msg">*</span>Image : </td>
					<td   align="left">
						<?php 
                                                  echo $form->input('FooterBanner.file',array('class'=>'textbox','label'=>false,'div'=>false,'type' => 'file'));
						//echo $form->error('FooterBanner.file'); 
                                                //echo $fck->load('FooterBanner/answer','Default'); ?>
					</td>
				</tr>
                                 <?php
				 $error =0;
				$postError = $form->error('FooterBanner.position');
				$nameError = $form->error('FooterBanner.name');
				$altError = $form->error('FooterBanner.alt_text');
				$fileError = $form->error('FooterBanner.file');
				$image ='';
				  if((empty($postError) && empty($nameError) && empty($altError) && empty($fileError))){
					
					 $image = isset($this->data['FooterBanner']['file'])?$this->data['FooterBanner']['file']:'';
					}
				 $flag = isset($this->data['FooterBanner']['flag'])?$this->data['FooterBanner']['flag']:'';
                                 $alt_text = isset($this->data['FooterBanner']['alt_text'])?$this->data['FooterBanner']['alt_text']:'';
				
 				 if(((!empty($postError) || !empty($nameError) || !empty($altError) || !empty($fileError))  && (!is_array($image)))) {
					
					$image = isset($this->data['FooterBanner']['previousImage'])?$this->data['FooterBanner']['previousImage']:'';;
				 }
				
				 
				 if(isset($this->data['FooterBanner']['file']['error'])){
					if($this->data['FooterBanner']['file']['error'] == 0){
					       $error	=1;
					}
				 }else{
					$image = isset($this->data['FooterBanner']['previousImage'])?$this->data['FooterBanner']['previousImage']:'';
				 }
				
			
				 if((isset($flag) && $flag ==0) && (!empty($image) && !is_array($image))){
                                 //&& !$form->error('FooterBanner.file') 
                                 ?>
                                 <tr id="viewImage">
					<td valign="top" align="right"></td>
					<td   align="left">
				<?php echo $form->hidden('FooterBanner.previousImage',array('value'=>$image, 'type' => 'text')); ?>
						
				<?php echo $html->image('banner/small/img_75_'.$image, array("alt" => $alt_text),array('escape' => false));?>
                                        </td>
				</tr>
                                 <?php } ?>
                                <tr id="scriptID" style="display:none;">
					<td valign="top" align="right">Script : </td>
					<td   align="left">
						<?php 
						echo $form->textarea("FooterBanner.script",array('class'=>'textbox-m',"label"=>false,"div"=>false,"id"=>"FooterBannerAnswer"));
						//echo $form->error('FooterBanner.script'); 
                                                //echo $fck->load('FooterBanner/answer','Default'); ?>
					</td>
				</tr>
                                <tr>
					<td valign="top" align="right"><span class="error_msg">*</span>ALT-Text : </td>
					<td   align="left">
						<?php 
						echo $form->input("FooterBanner.alt_text",array('class'=>'textbox-m',"label"=>false,"div"=>false,"id"=>"FooterBannerAnswer"));
						//echo $form->error('FooterBanner.alt_text'); 
                                                //echo $fck->load('FooterBanner/answer','Default'); ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="center"></td>
                                        <td align="left">
						<?php 
						if(empty($this->data['FooterBanner']['id']))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";

						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/pages/footerbanner')"));?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>
<?php
echo $form->hidden("FooterBanner.id",array("value"=>$id));
echo $form->end();
//echo $validation->rules('FooterBanner',array('formId'=>'frmFooterBanners'));
?>
<script>
    window.onload = choice();
   function choice()
   {
        var ch = jQuery("input:radio:checked").val();
        if(ch == 0){
            jQuery("#imageID").show();
            jQuery("#scriptID").hide();
            jQuery("#viewImage").show();
        }
        if(ch == 1){
            
            jQuery("#viewImage").hide();
            jQuery("#imageID").hide();
            jQuery("#scriptID").show();
        }
   }
</script>