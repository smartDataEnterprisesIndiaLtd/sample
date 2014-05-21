<?php
$this->Html->addCrumb('Seller Management', ' ');
$this->Html->addCrumb(' Manage Sellers Payment Information', 'javascript:void(0)');
echo $javascript->link('lib/prototype');
//e($html->script('jquery-1.4.3.min',false));
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
?>
<script language="JavaScript">
	jQuery(document).ready(function()  { // for writing a review
		jQuery("a.vac").fancybox({
			'titlePosition': 'inside',
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : 500,
			'height' : 160,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
				//parent.location.reload(true);
			}
		});
});
</script>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $title_for_layout;?></td>
		<td class="adminGridHeading" height="25px" align="right"></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading" colspan = "3">Search Volume </td>
				</tr>
				<tr>
					<td>
						<?php echo $form->create("Seller",array("action"=>"view_seller_payment_listing","method"=>"Post", "id"=>"frmViewSellerPaymentListing", "name"=>"frmViewSellerPaymentListing"));?>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0" class="keywordtbl_search">
							<tr>
								<td align="left" width="60%">
									<div class="keyword_widget">
										<label>Keyword :</label>
										<div class="field_widget">
											<p class="pdrt2"><?php echo $form->input('Search.keyword',array('size'=>'53','class'=>'textbox','label'=>false,'div'=>false,'maxlength'=>'53','value'=>$keyword));?></p>
										</div>
									</div>
								</td>
											
									<td width="40%" class="select_input">
									<?php echo $form->select('Search.searchin',$options,null,array('type'=>'select','class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select Field--'); ?>
								
									<?php echo $form->submit('Search',array('alt'=>'Next','width'=>'38','height'=>'31','border'=>'0', "value"=>"search",'class'=>'btn_53'))?>
								</td>
							</tr>
						</table>
						<?php echo $form->end();?>
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
					<td  id='listing'>
						<?php  echo $this->element('admin/seller_payment_listing');	?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
