<?php
$this->Html->addCrumb('Product Management', ' ');
$this->Html->addCrumb('View All Products', 'javascript:void(0)');

/*
$product_fields = array() ;
$product_fields['books'] = array('author'=>'Author', 'publisher' => 'Publisher', "language", "isbn", "format", "pages", "publisher_review", "year_published");
$product_fields['music'] = "title";


//pr($product_fields);
*/
//$paginator->options(array('update'=>'pagging'));
$url = array(
	'keyword' =>$keyword,	
	'searchin' => $fieldname,
	'showtype' => $show
	);


$paginator->options(array('url' => $url));
echo $javascript->link('selectAllCheckbox');

?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $title_for_layout;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			<?php echo $html->link('<span>Add New</span>',array("controller"=>"products","action"=>"add") , array('escape'=>false,'class'=>'wt_btn','title'=>'Add New') ); ?>
			<?php //echo $html->link("Add New",array("controller"=>"products","action"=>"add")); ?>
		</td>
	</tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Search Product</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<?php echo $form->create("Product",array("action"=>"index","method"=>"Post", "id"=>"frmSearchadmin", "name"=>"frmSearchadmin"));?>

									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0" class="keywordtbl_search">
										<tr>
											<td align="left" width="60%">
												<div class="keyword_widget">
													<label>Keyword :</label>
													<div class="field_widget">
														<p class="pdrt2"><?php echo $form->input('Search.keyword',array('size'=>'53','class'=>'textbox fullwidth','label'=>false,'div'=>false,'maxlength'=>'53','value'=>$keyword));?></p>
												        </div>
												</div> </td>
											
											<td width="40%" class="select_input"><?php echo $form->select('Search.searchin',$options,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Field--'); ?>
												<?php echo $form->select('Search.show',$showArr,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Department--'); ?>
												<?php echo $form->submit('Search',array('alt'=>'Next','width'=>'38','height'=>'31','border'=>'0', "value"=>"search",'class'=>'btn_53'))?></td>
										</tr>
									</table>
									<?php echo $form->end();?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
 	<tr>
		<td colspan="2" valign="top" id="pagging">
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td >					
						<table   align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
							<tr>
								<td colspan="2" id = 'listing'>
									<?php echo $this->element('admin/products_listing');	?>
								</td>
							</tr>
						</table>
						 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="legends">
						<b>Legends:</b>
						<?php echo $html->image('cube_molecule.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')) ?>&nbsp;Assign multiple departments&nbsp;
						<?php echo $html->image('edit.png',array('border'=>0,'alt'=>'Edit','title'=>'Edit')) ?>&nbsp;Edit&nbsp;
						<?php echo $html->image('green2.jpg',array('border'=>0,'alt'=>'Active','title'=>'Active')); ?>&nbsp;Active&nbsp;
						<?php echo $html->image('red3.jpg',array('border'=>0,'alt'=>'In Active','title'=>'In Active')); ?>&nbsp;Inactive&nbsp;
						<?php echo $html->image('b_drop.png',array('border'=>0,'alt'=>'Delete','title'=>'Delete')); ?>&nbsp;Delete&nbsp;
						<?php echo $html->image('zoom.png',array('border'=>0,'alt'=>'View','title'=>'View')); ?>&nbsp;View&nbsp;
					</td>
				</tr>
				<tr>
					<td class="legends">
						<b>Product Conditions:</b>
						<?php
							foreach($conditions as $key=>$product_condtion){
								echo $key." = ".$product_condtion."&nbsp;&nbsp;&nbsp;";
							}
						?>
					</td>
				</tr>
				<!-- Legends -->
			</table>
			
		</td>		
	</tr>

</table>
