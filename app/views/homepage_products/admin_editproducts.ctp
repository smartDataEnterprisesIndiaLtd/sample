<?php
$this->Html->addCrumb('Product Management', '/admin/products');
$this->Html->addCrumb('Edit Products for Home Page', 'javascript:void(0)');


//$javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); ?>
<?php echo  $form->create('homepage_products',array('action'=>'editproducts/'.$id. '/'.$pageName,'method'=>'POST','name'=>'frmSpecialProduct','id'=>'frmSpecialProduct'));?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" class="adminBox">
<tr class="adminBoxHeading reportListingHeading">
<td class="adminGridHeading heading" ><?php echo $listTitle; ?></td>
<td height="25" align="right" class="adminGridHeading heading">
	<?php echo $html->link('Back', '/admin/homepage_products', array() );?>
	
</td>
</tr>
<tr>

<td colspan="2">
<table width="100%" border="0" cellspacing="1" cellpadding="3" > 
	<tr height="20px" colspan="2">
		<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
	</tr><!--
	<tr>
		<td colspan="2">
			<div class="errorlogin_msg" id="jsErrors">
				<?php //echo $this->element('errors'); ?>
		</div>
		</td>
	</tr>-->
	
	<!--<tr>
		<td align="right" width="25%"><span class="error_msg">*</span> Enter Hot Product Quick Code: 
		</td><td>
			<?php echo $form->input('HomepageProduct.hot_product',array('size'=>'20','class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?>
		</td>
	</tr>-->
	<tr>
		<td align="right" width="25%"><span class="error_msg">*</span> Enter Hot Pic Quick Code: 
		</td><td>
			<?php echo $form->input('HomepageProduct.hot_pick',array('size'=>'20','class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?>
		</td>
	</tr>

	<tr>
		<td align="center" colspan="2">
			<fieldset style="border:1px dashed;">
			 <legend><b>Pick of the Day Products</b></legend>
			 
		<table width="100%" border="0" cellspacing="1" cellpadding="3" >
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #1: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.day_pick_1',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #2: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.day_pick_2',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #3: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.day_pick_3',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #4: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.day_pick_4',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		</table>
			 </fieldset>
			</td>
	</tr>
	
		<tr>
		<td align="center" colspan="2">
			<fieldset style="border:1px dashed;">
			 <legend><b>New Release #1</b></legend>
		<table width="100%" border="0" cellspacing="1" cellpadding="3" >
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #1: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release1_product1',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #2: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release1_product2',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #3: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release1_product3',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #4: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release1_product4',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #5: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release1_product5',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #6: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release1_product6',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #7: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release1_product7',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #8: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release1_product8',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		</table>
			 </fieldset>
			</td>
	</tr>

	
	
	<tr>
		<td align="center" colspan="2" >
			<fieldset style="border:1px dashed;">
			 <legend><b>Heading #1 Products</b></legend>
			 
		<table width="100%" border="0" cellspacing="1" cellpadding="3" >
		<tr>
		<td align="left" width="100%" colspan="4" >
			<table width="100%" border="0" cellspacing="1" cellpadding="0" >
			<tr>
				<td align="left" width="15%"><span class="error_msg">*</span> Select Heading 1: 
				</td><td>
				<?php
				if($id >1){ // deparetmen wise pag
					echo $form->select('HomepageProduct.heading1',$topcategories, null, array('class'=>'textbox', 'type'=>'select'),'Select ..');
				}else{ // home page
					echo $form->select('HomepageProduct.heading1',$departments, null, array('class'=>'textbox', 'type'=>'select'),'Select ..');
				}
				echo $form->error('HomepageProduct.heading1');
				?>
				</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #1: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading1_product1',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #2: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading1_product2',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #3: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading1_product3',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #4: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading1_product4',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #5: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading1_product5',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #6: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading1_product6',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #7: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading1_product7',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #8: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading1_product8',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		</table>
			 
			 </fieldset>
			
			</td>
	</tr>
	
			<tr>
		<td align="center" colspan="2"  >
			<fieldset style="border:1px dashed;">
			 <legend><b>New Release #2</b></legend>
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #1: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release2_product1',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #2: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release2_product2',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #3: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release2_product3',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #4: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release2_product4',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #5: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release2_product5',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #6: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release2_product6',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #7: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release2_product7',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #8: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release2_product8',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		</table>
			 </fieldset>
			</td>
	</tr>
	
	<tr>
		<td align="center" colspan="2"  >
			<fieldset style="border:1px dashed;">
			 <legend><b>Heading #2 Products</b></legend>
			 
		<table width="100%" border="0" cellspacing="1" cellpadding="3" >
		<tr>
		<td align="left" width="100%" colspan="4">
			<table width="100%" border="0" cellspacing="1" cellpadding="0" >
			<tr>
				<td align="left" width="15%"><span class="error_msg">*</span> Select Heading 2: 
				</td><td>
				<?php
				if($id >1){ // deparetmen wise pag
					echo $form->select('HomepageProduct.heading2',$topcategories, null, array('class'=>'textbox', 'type'=>'select'),'Select ..');
				}else{ // home page
					echo $form->select('HomepageProduct.heading2',$departments, null, array('class'=>'textbox', 'type'=>'select'),'Select ..');
				}
				echo $form->error('HomepageProduct.heading2');
				?>
				</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #1: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading2_product1',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #2: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading2_product2',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #3: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading2_product3',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #4: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading2_product4',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #5: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading2_product5',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #6: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading2_product6',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #7: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading2_product7',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #8: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading2_product8',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		</table>
			 </fieldset>
			</td>
	</tr>
	
	
	<tr>
		<td align="center" colspan="2"  >
			<fieldset style="border:1px dashed;">
			 <legend><b>New Release #3</b></legend>
		<table width="100%" border="0" cellspacing="1" cellpadding="3" >
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #1: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release3_product1',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #2: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release3_product2',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #3: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release3_product3',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #4: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release3_product4',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #5: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release3_product5',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #6: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release3_product6',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #7: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release3_product7',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #8: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.release3_product8',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		</table>
			 </fieldset>
			</td>
	</tr>
	
	<tr>
		<td align="center" colspan="2">
			<fieldset style="border:1px dashed;">
			 <legend> <b>Heading #3 Products</b></legend>
			 
		<table width="100%" border="0" cellspacing="1" cellpadding="3" >
		<tr>
		<td align="left" width="100%" colspan="4">
			<table width="100%" border="0" cellspacing="1" cellpadding="0" >
			<tr>
				<td align="left" width="15%"><span class="error_msg">*</span> Select Heading 3: 
				</td><td>
				<?php
				if($id >1){ // deparetmen wise pag
					echo $form->select('HomepageProduct.heading3',$topcategories, null, array('class'=>'textbox', 'type'=>'select'),'Select ..');
				}else{ // home page
					echo $form->select('HomepageProduct.heading3',$departments, null, array('class'=>'textbox', 'type'=>'select'),'Select ..');
				}
				echo $form->error('HomepageProduct.heading3');
				?>
				</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #1: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading3_product1',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #2: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading3_product2',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #3: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading3_product3',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #4: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading3_product4',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #5: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading3_product5',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #6: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading3_product6',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #7: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading3_product7',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #8: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading3_product8',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		</table>
			 </fieldset>
			</td>
	</tr>
	<tr>
		<td align="center" colspan="2" >
			<fieldset style="border:1px dashed;">
			 <legend><b>Heading #4 Products</b></legend>
			 
		<table width="100%" border="0" cellspacing="1" cellpadding="3" >
		<tr>
		<td align="left" width="100%" colspan="4">
			<table width="100%" border="0" cellspacing="1" cellpadding="0" >
			<tr>
				<td align="left" width="15%"><span class="error_msg">*</span> Select Heading 4: 
				</td><td>
				<?php
				if($id >1){ // deparetmen wise pag
					echo $form->select('HomepageProduct.heading4',$topcategories, null, array('class'=>'textbox', 'type'=>'select'),'Select ..');
				}else{ // home page
					echo $form->select('HomepageProduct.heading4',$departments, null, array('class'=>'textbox', 'type'=>'select'),'Select ..');
				}
				echo $form->error('HomepageProduct.heading4');
				?>
				</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #1: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading4_product1',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #2: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading4_product2',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #3: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading4_product3',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #4: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading4_product4',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #5: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading4_product5',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #6: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading4_product6',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #7: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading4_product7',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #8: </td>
			<td align="left"><?php echo $form->input('HomepageProduct.heading4_product8',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));?></td>
		</tr>
		</table>
		 </fieldset>
			</td>
	</tr>
		
	<!--
	<tr>
		<td align="center" colspan="2">
			<fieldset style="border:1px dashed;">
			 <legend><b>Customers who viewed this item also viewed</b></legend>
			 
		<table width="100%" border="0" cellspacing="1" cellpadding="3" >
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #1: </td>
			<td align="left"><?php/* echo $form->input('HomepageProduct.customer_product1',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));*/?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #2: </td>
			<td align="left"><?php /*echo $form->input('HomepageProduct.customer_product2',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));*/?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #3: </td>
			<td align="left"><?php /* echo $form->input('HomepageProduct.customer_product3',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));*/?></td>
			<td align="right" width="10%"><span class="error_msg">*</span> Product #4: </td>
			<td align="left"><?php /*echo $form->input('HomepageProduct.customer_product4',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));*/?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #5: </td>
			<td align="left"><?php /*echo $form->input('HomepageProduct.customer_product5',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));*/?></td>
			<td align="right" width="10%"><span class="error_msg"></span> Product #6: </td>
			<td align="left"><?php /*echo $form->input('HomepageProduct.customer_product6',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));*/?></td>
		</tr>
		<tr>
			<td align="right" width="10%"><span class="error_msg"></span> Product #7: </td>
			<td align="left"><?php /*echo $form->input('HomepageProduct.customer_product7',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>20));*/?></td>
			<td align="right" width="10%"><span class="error_msg"></span> </td>
			<td align="left">&nbsp;</td>
		</tr>
		</table>
			 </fieldset>
			</td>
	</tr>-->
	
	<tr>
		<td align="center"></td>
		<td align="left">
			<?php 
			echo $form->button("Submit",array('type'=>'submit','class'=>'btn_53','div'=>false));
			echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/homepage_products/')"));?>
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
echo $form->hidden("HomepageProduct.id",array("value"=>$id));
echo $form->end();
//echo $validation->rules('SpecialProduct',array('formId'=>'frmSpecialProduct'));
?>