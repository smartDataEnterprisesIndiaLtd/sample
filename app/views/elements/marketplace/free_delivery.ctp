<?php
if ($session->check('Message.flash')){ ?>
	<div class="messageBlock"><?php echo $session->flash();?></div>
<?php }?>
<script type="text/javascript" language="javascript">
jQuery('#SellerThresholdOrderValue').ready(function(){
	jQuery('#SellerThresholdOrderValue').bind('keyup',function() {
		if((jQuery(this).val()) < 0){
		      jQuery(this).val(parseFloat(Math.abs(jQuery(this).val())).toFixed(2));
		}
	  
	});
});

jQuery(document).ready(function(){
	jQuery('#SellerFreeDelivery0').change(function() {
		jQuery("input[type=submit]").removeAttr("disabled");
		jQuery("input[type=submit]").css("cursor", "pointer");
	});
	jQuery('#SellerFreeDelivery1').change(function() {
		jQuery("input[type=submit]").removeAttr("disabled");
		jQuery("input[type=submit]").css("cursor", "pointer");
	});
	jQuery('#SellerThresholdOrderValue').change(function() {
		jQuery("input[type=submit]").removeAttr("disabled");
		jQuery("input[type=submit]").css("cursor", "pointer");
	});
});
</script>
<!--Free Delivery Option Start-->
		<?php
		
		if(!empty($errors)){
			$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
		?>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }?>
<div class="account-setting">
	<!--Gray Back heading Start-->
	<?php echo $form->create('Seller',array('action'=>'save_freedelivery','method'=>'POST','name'=>'frmSeller2','id'=>'frmSeller2'));?>
	<div class="gray-bg-heading">
		<ul>
			<li class="head"><strong>Free Delivery Option</strong> <span class="padding-left">Offer a Free delivery threshold to improve average order values.</span></li>
			<li class="closed-link"><?php $options2=array(
				"url"=>"/sellers/save_freedelivery","before"=>"",
				"update"=>"free-delivery",
				"indicator"=>"plsLoaderID",
				'loading'=>"showloading()",
				"complete"=>"hideloading()",
				//'loading'=>"Element.show('plsLoaderID')",
				//"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"btn_blk-bg-link",
				"type"=>"Submit",
				"id"=>"testid2",
				"div"=>false,
				"disabled"=>"disabled"
				// "style"=>"cursor:pointer"
			);?><?php echo $ajax->submit('Change',$options2);?></li>
		</ul>
	</div>
	<!--Gray Back heading Closed-->
	<!--Account Setting Fields Start-->
	<div class="account-setting-fields">
		<!--Account Setting Fields Rows Start-->
		<ul class="account-setting-fields-rows">
			<li>
				<div class="account-setting-fields-label">Enter Order Value:</div>
				<div class="account-setting-fields-field">
					<span class="pad-right">
					<?php
						if(!empty($this->data['Seller']['free_delivery'])){
							$values = $this->data['Seller']['free_delivery'];
						}else{
							$values = 0;
						}
						$options_delivery=array('0'=>' <strong>Disabled</strong></span><span class="pad-right">','1'=>' <strong>Enabled</strong></span>');
						$attributes_delivery=array('legend'=>false,'label'=>false,'value'=>$values,'class'=>'adio v-align-middle');
						echo $form->radio('Seller.free_delivery',$options_delivery,$attributes_delivery);
					?><!--<span class="pad-right"><input type="radio" name="radio" class="radio v-align-middle" value="radio" />
					<strong>Disabled</strong></span>
					<span class="pad-right"><input type="radio" name="radio" class="radio v-align-middle" value="radio" />
					<strong>Enabled</strong></span>
					<span class="pad-right">--><span class="larger-fnt" style="line-height:14px;"><strong>&pound;</strong></span> <?php echo $form->input('Seller.threshold_order_value',array('size'=>'30','class'=>'textfield small-width inc-mar','maxlength'=>'8','label'=>false,'div'=>false,'error'=>false)); ?> e.g. 35.00</span><?php //echo $form->error('Seller.threshold_order_value');?>
				</div>
			</li>
		</ul>
		<!--Account Setting Fields Rows Closed-->
	</div>
	<?php echo $form->end();?>
	<!--Account Setting Fields Closed-->
</div>
<!--Free Delivery Option Closed-->