<?php
$this->Html->addCrumb('Seller Management', ' ');
$this->Html->addCrumb('View Seller Details', 'javascript:void(0)');
$states = $this->Common->getStates();
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="top">
<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
	<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="adminBoxHeading">
			<td class="adminGridHeading heading"><?php echo $list_title; ?></td>
			<td class="adminGridHeading heading" height="25px" align="right">
			<?php echo $html->link('Back',array('controller'=>'sellers','action'=>'index'));    ?>
			</td>
		</tr>
		<tr>
		<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<table class="adminBox" border="0" cellpadding="2" cellspacing="0" width="100%">
					<tr class="adminGridHeading heading">
						<td colspan="4"><strong>Personal Details</strong></td>
					</tr>
					<tr height="15">
						<td width="1%"></td>
						<td width="20%" align="right"></td>
						<td width="3%" align="left"></td>
						<td align="left"></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Title</td>
						<td align="left" valign="top">:</td>
						<td align="left"> <?php echo ucfirst($this->data['User']['title']); ?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Name</td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php
						echo ucfirst($this->data['User']['firstname']).' '.ucfirst($this->data['User']['lastname']); ?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Email</td>
						<td align="left" valign="top">:</td>
						<td align="left"><?php echo $this->data['User']['email'];   ?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Address 1</td>
						<td align="left" valign="top">:</td>
						<td align="left"><?php echo $this->data['User']['address1'];   ?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Address 2</td>
						<td align="left" valign="top">:</td>
						<td align="left"><?php echo $this->data['User']['address2'];   ?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">City </td>
						<td align="left" valign="top">:</td>
						<td align="left"><?php echo $this->data['User']['city'];   ?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">State/County </td>
						<td align="left" valign="top">:</td>
						<td align="left"><?php
							if(isset($states[$this->data['User']['state']]) ){
								echo $states[$this->data['User']['state']];
							}else{
								echo $this->data['User']['state'];
							}?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Postcode </td>
						<td align="left" valign="top">:</td>
						<td align="left"><?php echo $this->data['User']['postcode'];   ?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Country </td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php if(!empty($this->data['Country']['country_name'])){
							echo $this->data['Country']['country_name'];
						} else{ echo '-'; }?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Phone</td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php echo $this->data['User']['phone']; ?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Contact By Phone </td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php 
							if( $this->data['User']['contact_by_phone'] == '1'){ // 1 for yes 0 for no 
								echo 'Yes' ;
							} else {
								echo 'No';
							} ?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Contact By Partner. </td>
						<td align="left" valign="top">:</td>
						<td align="left">
							<?php 
							if( $this->data['User']['contact_by_partner']  == '1'){ 
								echo 'Yes' ;
							} else { echo 'No'; } ?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Status  </td>
						<td align="left" valign="top">:</td>
						<td align="left">
							<?php echo ( $this->data['User']['status']  == '1') ?('Active'):('In Active');
						?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Created on</td>
						<td align="left" valign="top">:</td>
						<td align="left"><?php echo $format->date_format($this->data['User']['created']);
						?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Modified on</td>
						<td align="left" valign="top">:</td>
						<td align="left"><?php echo $format->date_format($this->data['User']['modified']);   ?></td>
					</tr>
					<tr class="adminGridHeading heading">
						<td colspan="4"><strong>Business Details</strong></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Business Name</td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php
						if($this->data['Seller']['business_name'] != ''){
						echo $this->data['Seller']['business_name'];
						}else{ echo '-'; }
						?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Business Display Name</td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php
						if($this->data['Seller']['business_display_name'] != ''){
						echo $this->data['Seller']['business_display_name'];
						}else{ echo '-'; }
						?>
						</td>
					</tr>
					
					<tr>
						<td></td>
						<td align="right" valign="top">Secret Question</td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php
						if($this->data['Seller']['secret_question'] != ''){
						echo $this->data['Seller']['secret_question'];
						}else{ echo '-'; }
						?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Answer </td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php
						if($this->data['Seller']['secret_answer'] != ''){
						echo $this->data['Seller']['secret_answer'];
						}else{ echo '-'; }
						?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Seller Email</td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php
						if($this->data['Seller']['service_email'] != ''){
						echo $this->data['Seller']['service_email'];
						}else{ echo '-'; }
						?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Bank Sort Code</td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php
						if($this->data['Seller']['bank_sort_code'] != ''){
						echo $this->data['Seller']['bank_sort_code'];
						}else{ echo '-'; }
						?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Bank Account Number</td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php
						if($this->data['Seller']['bank_account_number'] != ''){
						echo $this->data['Seller']['bank_account_number'];
						}else{ echo '-'; }
						?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Account Holder Name</td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php
						if($this->data['Seller']['account_holder_name'] != ''){
						echo $this->data['Seller']['account_holder_name'];
						}else{ echo '-'; }
						?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Paypal Account Email</td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php
						if($this->data['Seller']['paypal_account_mail'] != ''){
						echo $this->data['Seller']['paypal_account_mail'];
						}else{ echo '-'; }
						?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Account Holder Name</td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php
						if($this->data['Seller']['account_holder_name'] != ''){
						echo $this->data['Seller']['account_holder_name'];
						}else{ echo '-'; }
						?></td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Free Delivery  </td>
						<td align="left" valign="top">:</td>
						<td align="left">
							<?php 
							echo ( $this->data['Seller']['free_delivery']  == '1') ?('Yes'):('No');
							?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Free Delivery Threshold  </td>
						<td align="left" valign="top">:</td>
						<td align="left">
							<?php
							echo $this->data['Seller']['threshold_order_value']; ?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Gift Service   </td>
						<td align="left" valign="top">:</td>
						<td align="left">
						<?php echo ( $this->data['Seller']['gift_service']  == '1') ?('Yes'):('No');
						?> </td>
					</tr>
					<tr>
						<td></td>
						<td align="right" valign="top">Created on</td>
						<td align="left" valign="top">:</td>
						<td align="left"><?php echo $format->date_format($this->data['Seller']['created']);
						?></td>
					</tr>
						<tr class="adminGridHeading heading">
							<td colspan="4"><strong>Wants email alerts for following departments:</strong></td>
						</tr>
						<?php
						if(!empty($departments)){ ?>
							<?php foreach($departments as $dept_id => $department) {
								$display = $html->image('negative-icon.png',array('border'=>0,'alt'=>'No'));
								if(!empty($this->data['UserDepartment'])){
									foreach ($this->data['UserDepartment'] as $user_department){
										if($user_department['department_id']==$dept_id){
											$display = $html->image('positive-icon.png',array('border'=>0,'alt'=>'Yes'));
											break;
										}else
											$display = $html->image('negative-icon.png',array('border'=>0,'alt'=>'No'));
									}?>
								<?php } ?>
								<tr>
									<td></td>
									<td align="right" valign="top"><?php echo $department;?></td>
									<td align="left" valign="top">:</td>
									<td align="left"><?php echo $display;?></td>
								</tr>
							<?php }?>
						<?php }?>
				</table>
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>
</td>
</tr>
</table>