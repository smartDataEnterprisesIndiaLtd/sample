<?php ?>
<div id="proadd">
<?php 
echo  $javascript->link('uploadmultiplephoto');
echo $javascript->link('fckeditor');

echo $javascript->link(array('jquery-1.3.2.min'));
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');

$dep_temp_code_arry = array();
$dep_temp_code_arry[1] = 'book';
$dep_temp_code_arry[2] = 'music';
$dep_temp_code_arry[3] = 'movie';
$dep_temp_code_arry[4] = 'game';
$dep_temp_code_arry[5] = 'electronic';
$dep_temp_code_arry[6] = 'office_computing';
$dep_temp_code_arry[7] = 'mobile';
//$dep_temp_code_arry[8] = 'home_garden';
//$dep_temp_code_arry[5] = 'common';
//$dep_temp_code_arry[6] = 'common';
//$dep_temp_code_arry[7] = 'common';
$dep_temp_code_arry[8] = 'common';
$dep_temp_code_arry[9] = 'health_beauty';
?>
<script type="text/javascript" language="javascript">	


</script>
<?php
echo $form->create('Product',array('action'=>'add_step2/'.$id ,'method'=>'POST','name'=>'frmProduct','id'=>'frmProduct','enctype'=>'multipart/form-data'));
echo $form->hidden('ProductDetail.id');
echo $form->hidden('ProductDetail.product_id',array('value'=>$id));
echo $form->hidden('Product.id',array('value'=>$id));

?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
<tr>
<td valign="top">
<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading" align="right">
			<?php
			     	echo $html->link('Back ', '/admin/products/add/'.$id.'/'.$new_product_id);
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
				<tr height="20px">
					<td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<?php
				
				
				if( isset($dep_temp_code_arry[$department_id]) ){
					$department_temp_code =  $dep_temp_code_arry[$department_id];
					echo $this->element('admin/product_templates/'.$department_temp_code);
				}else{
					echo "";
				}
				
				?>
				<tr>
					<td align="right">Worldwide Compatibility :</td>
					<td align="left">
						<?php $checkbox = '';
							if($this->data['ProductDetail']['worldwide_compatibility']=='1'){
								$checkboxc = true;
							}else{
								$checkboxc = false;
							}
						?>
						<?php echo $form->checkbox('ProductDetail.worldwide_compatibility',array("checked"=>$checkboxc,'style'=>array('border:0'))); ?>
					</td>
				</tr>
				<tr>
					<td align="right">Product Weight :</td>
					<td align="left">
						<?php echo $form->input('ProductDetail.product_weight',array('class'=>'textbox-s','label'=>false,'div'=>false));?>
						<span class="note" >Boxed product weight in grams (g)</span>
					</td>
				</tr>
				<tr>
					<td align="right"><strong>Dimensions :</strong></td>
					<td></td>
				</tr>
				<tr>
					<td align="right">Height(cm) :</td>
					<td align="left">
						<?php echo $form->input('ProductDetail.product_height',array('class'=>'textbox-s','label'=>false,'div'=>false));?>
					</td>
				</tr>
				<tr>
					<td align="right">Width(cm) :</td>
					<td align="left">
						<?php echo $form->input('ProductDetail.product_width',array('class'=>'textbox-s','label'=>false,'div'=>false));?>
					</td>
				</tr>
				<tr>
					<td align="right">Length(cm) :</td>
					<td align="left">
						<?php echo $form->input('ProductDetail.product_length',array('class'=>'textbox-s','label'=>false,'div'=>false));?>
					</td>
				</tr>
				
				<?php  ?>
				<tr>
					<td align="right"><span class="error_msg">*</span>Search Terms/Tags:</td>
					<td align="left">
						<?php echo $form->input('ProductDetail.product_searchtag',array('rows'=>'5','class'=>'textbox-l','label'=>false,'div'=>false));?>
					</td>
				</tr>
				<!--<tr>
					<td align="right">Technical Details  :</td>
					<td align="left">
				<?php  //echo $form->input('ProductDetail.technical_details',array( 'rows'=>'5' , 'class'=>'textbox-l','label'=>false,'div'=>false));?>
					</td>
				</tr>-->
				<tr>
					<td align="right">Key Features :</td>
					<td align="left">
					<?php	Configure::write('debug',3);

					echo $this->data['ProductDetail']['product_features'];
					echo $form->textarea('ProductDetail.product_features',array('id'=>'ProductDetailProduct_features' , 'rows'=>'10','cols'=>'24')); 
					echo $fck->load('ProductDetail/product_features'); 
					//echo $form->error('ProductDetail.product_features',array('class'=>'error_msg'));
					?>
					</td>
				</tr>
				<tr>
					<td align="right"><span class="error_msg">*</span> Product Description :</td>
					<td align="left">
				<?php
				echo $this->data['ProductDetail']['description'];
				echo $form->textarea('ProductDetail.description',array('id'=>'ProductDetailDescription', 'rows'=>'10','cols'=>'24')); 
				echo $fck->load('ProductDetail/description'); 
				//echo $form->error('ProductDetail.description',array('class'=>'error_msg'));
			?>
					</td>
				</tr>
				
			<tr>
				<td align="right"> <span class="error_msg"></span> Meta Title:</td>
				<td align="left">
					<?php echo $form->input('ProductDetail.meta_title',array('cols'=>'40','rows'=>'1','class'=>'textbox-l','label'=>false,'div'=>false));?>
				</td>
			</tr>
			<tr>
				<td align="right"> <span class="error_msg"></span> Meta Keywords:</td>
				<td align="left">
					<?php echo $form->input('ProductDetail.meta_keywords',array('cols'=>'50','rows'=>'4','class'=>'textbox-l','label'=>false,'div'=>false));?>
				</td>
			</tr>
			<tr>
				<td align="right"> <span class="error_msg"></span> Meta Description:</td>
				<td align="left">
					<?php echo $form->input('ProductDetail.meta_description',array('cols'=>'50','rows'=>'4','class'=>'textbox-l','label'=>false,'div'=>false));?>
				</td>
			</tr>
<?php  ?>
			
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td >&nbsp;</td>
				<td align="left" >
				<?php if(!empty($this->data['Product']['id'])) {
					echo $form->button('Update',array('type'=>'submit','class'=>'btn_53','div'=>false));
				} else {
					echo $form->button('Save',array('type'=>'submit','class'=>'btn_53','div'=>false));
				}?>
				<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/Products/index')"));?>
				</td>
			</tr>
			</table>
		</td>
	</tr>
</table>
</td>
</tr>
</table>


</div>