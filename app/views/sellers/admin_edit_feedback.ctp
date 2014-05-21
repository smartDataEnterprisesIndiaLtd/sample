<?php

echo $javascript->link(array('lib/prototype'), false);
echo $javascript->link(array('behaviour','textarea_maxlen'));
echo $javascript->link(array('smartstars'), false);
?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td class="adminGridHeading heading"  height="25px" align="right"></td>
	</tr>
	<tr>
	<td colspan="2">
		<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
			<tr height="2">
				<td  align="right"></td>
				<td align="left"></td>
			</tr>
			<tr height="20px">
				<td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td>
			</tr>
			<tr>
				<td align="right" valign="top">Customer Name :</td>
				<td><?php if(!empty($this->data['User']['firstname'])) echo $this->data['User']['firstname']; if(!empty($this->data['User']['lastname'])) echo $this->data['User']['lastname'];?>
				</td>
			</tr>
			<tr>
				<td align="right" valign="top">Seller Name :</td>
				<td><?php if(!empty($this->data['SellerSummary']['firstname'])) echo $this->data['SellerSummary']['firstname']; if(!empty($this->data['SellerSummary']['lastname'])) echo $this->data['SellerSummary']['lastname'];?>
				</td>
			</tr>
			<tr>
				<td align="right" valign="top">Product:</td>
				<td><?php  if(!empty($this->data['OrderItem']['product_name'])) echo $this->data['OrderItem']['product_name'];?>
				</td>
			</tr>
			<tr>
				<td align="right" valign="top">Rate:</td>
				<td><?php /* if(!empty($this->data['Feedback']['rating'])) echo $this->data['Feedback']['rating'];*/?>
					<div id="rate_module">
						<style type='text/css'>
						a.SmartStarsLinks{padding:0px}
						.SmartStarsImages{margin:0px; border:none}
						</style>
						<p>
						<span id='stars' style="float:left;padding-right:10px"></span> 
						<div id="commentField" style="display: block;">Rate it</div>
						</p>
					</div>
				</td>
			</tr>

			<tr>

				<td></td><td><span id="stars"></span></td>
			</tr>
			<?php 
			echo $form->create('Seller',array('action'=>'edit_feedback/'.base64_encode($id),'method'=>'POST','name'=>'f','id'=>'f'));
			?>
			
			<input type="hidden" size="1" name="t" id="t" >
			
			<tr>
				<td align="right" valign="top">Comments:</td>
				<td>
				<p>
					<?php echo $form->input("Feedback.feedback",array("label"=>false,"div"=>false,'rows'=>5,'maxlength'=>400, 'cols'=>45, 'class'=>'form-textfield', 'showremain'=>"limitOne")); ?><?php echo $form->error('Order.feedback'); ?>
				</p>
				<p class="pad-tp smalr-fnt">Max. 400 characters, no HTML
				<br />
				Remaining characters: <span id ="limitOne"><?php if(!empty($this->data)){
					if(!empty($this->data['Feedback']['feedback'])) { 
						$remain = 400 - strlen($this->data['Feedback']['feedback']);
						echo $remain;
					} else {
						echo '400'; 
					} 
				} else { 
					echo '400'; } ?></span></p>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;<?php echo $form->hidden("User.firstname",array("label"=>false,"div"=>false)); ?>
				<?php echo $form->hidden("User.lastname",array("label"=>false,"div"=>false)); ?>
				<?php echo $form->hidden("SellerSummary.firstname",array("label"=>false,"div"=>false)); ?>
				<?php echo $form->hidden("SellerSummary.lastname",array("label"=>false,"div"=>false)); ?>
				<?php echo $form->hidden("OrderItem.product_name",array("label"=>false,"div"=>false)); ?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="left">
				<?php if(!empty($this->data['Feedback']['id'])) {
					echo $form->button('Update',array('type'=>'submit','class'=>'btn_53','div'=>false));
				} else {
					echo $form->button('Add',array('type'=>'submit','class'=>'btn_53','div'=>false));
				}?>
				<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/feedback')"));?>
				</td>
			</tr>
			<?php echo $form->end();?>
		</table>
	</td>
	</tr>
</table>

<script type='text/javascript'>
	
	//if(!empty($this->data['Feedback']['rating'])) 
	var start_star = <?php echo @$this->data['Feedback']['rating']; ?>;

	if(start_star == '')
		start_star = 0;

	document.getElementById('commentField').firstChild.nodeValue = "Rate it";
	function textDesc(idx)
	{
		var comments=
		['I would not recommend this seller', 'Some improvement required',
		'Satisfactory service','Good',
		'Excellent, would use again'];
		document.getElementById('commentField').firstChild.nodeValue=idx>-1 ? comments[idx] : "Rate it";
	}
	SmartStars.init('stars', document.forms.f.t, start_star, 5, "<?php echo SITE_URL;?>img/bl-start.png", "<?php echo SITE_URL;?>img/blue-star.png",textDesc );
</script>