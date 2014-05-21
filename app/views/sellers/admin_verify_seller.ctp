<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		goBack('/admin/sellers/verify_seller/<?php echo $this->data['Seller']['id'] ?>/0/no');
		jQuery("#clickOnce").attr("disabled", "true");
	});
});
</script>

<?php ?>
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td id='listing'>
			<?php
			echo $form->create('Seller',array('action'=>'verify_seller/'.$this->data['Seller']['id'].'/3/yes','method'=>'POST','name'=>'frmVerify','id'=>'frmVerify'));
			?>
			<!--Tabs Content Start-->
			<table cellspacing ="0" cellpadding="0" border="0" width="100%">
				<?php if ($session->check('Message.flash')){ ?>
				<tr>
					<td>
						<div  class="messageBlock"><?php echo $session->flash();?></div>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td class="gray-bg-heading account-setting">
						<strong>Deposit amounts entered by seller:</strong>
					</td></tr>
					<tr><td>
						<table cellspacing ="1" cellpadding="1" border="0" width="100%" class="borderTable">
							<tr style="background:#fff;height:19px">
								<td width="30%">Number of Failed Attempt(s) :</td>
								<td><?php echo $this->data['Seller']['attempt_number'];?></td>
							</tr>
							<tr style="background:#fff;height:19px">
								<td>Deposit 1 :</td>
								<td><?php echo $this->data['Seller']['deposit_1'];?></td>
							</tr>
							<tr style="background:#fff;height:19px">
								<td>Deposit 2 :</td>
								<td><?php echo $this->data['Seller']['deposit_2'];?></td>
							</tr>
						</table>
					</td></tr>
					<tr><td>&nbsp;</td></tr>
					<?php 
					$dep_1 = $this->data['Seller']['deposit_1'];
					$dep_2 = $this->data['Seller']['deposit_2'];
					if($dep_1 != '0.00' && $dep_2 != '0.00'){ ?>
					<tr >
						<td><?php echo $form->hidden('SellerPayment.seller_id',array('size'=>'20','maxlength'=>'20','class'=>'textfield-input small-width','label'=>false,'div'=>false));?>
						<?php echo $form->button('Verify',array('type'=>'submit','class'=>'blk-bg-input-small','div'=>false));?>
						<?php echo $form->button('Fail Verification',array('type'=>'button','class'=>'blk-bg-input-small-long','div'=>false, 'id'=>'clickOnce', 'onClick'=>"goBack('/admin/sellers/verify_seller/".$this->data['Seller']['id']."/0/no')"));?></td>
					</tr>
					<?php } ?>
			</table>
			<?php echo $form->end();?>
		</td>
	</tr>
</table>