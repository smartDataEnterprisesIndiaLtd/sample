<?php
if ($session->check('Message.flash')){ ?>
	<div class="messageBlock"><?php echo $session->flash();?></div>
<?php }
?>
<script type="text/javascript" language="javascript">
jQuery(document).ready(function(){
	jQuery('#SellerGiftService0').change(function() {
		jQuery("input[type=submit]").removeAttr("disabled");
		jQuery("input[type=submit]").css("cursor", "pointer");
	});
	jQuery('#SellerGiftService1').change(function() {
		jQuery("input[type=submit]").removeAttr("disabled");
		jQuery("input[type=submit]").css("cursor", "pointer");
	});
});
</script>
<!--Gift Options Start-->
<div class="account-setting">
<!--Gray Back heading Start-->
	<?php echo $form->create('Seller',array('action'=>'my_account','method'=>'POST','name'=>'frmSeller3','id'=>'frmSeller3'));?>
	<div class="gray-bg-heading">
		<ul>
			<li class="head"><strong>Gift Options</strong> <span class="padding-left">You can offer customers the option to gift-wrap and provide a message for products within an order.</span></li>
			<li class="closed-link"><?php $options3=array(
				"url"=>"/sellers/save_giftoptions","before"=>"",
				"update"=>"gift-options",
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"btn_blk-bg-link",
				"disabled"=>"disabled",
				"type"=>"Submit",
				"id"=>"testid3",
				"div"=>false,
   
			);?><?php echo $ajax->submit('Change',$options3);?></li>
		</ul>
	</div>
	<!--Gray Back heading Closed-->
	<!--Account Setting Fields Start-->
	<div class="account-setting-fields">
		<!--Account Setting Fields Rows Start-->
		<ul class="account-setting-fields-rows">
			<li>
				<div class="account-setting-fields-label">Gift Services:</div>
				<div class="account-setting-fields-field">
					<span class="pad-right">
					<?php
						$options_gift=array('0'=>' <strong>Disabled</strong></span><span class="pad-right">','1'=>' <strong>Enabled</strong></span>');
						$attributes_gift=array('legend'=>false,'label'=>false,'class'=>'adio v-align-middle');
						echo $form->radio('Seller.gift_service',$options_gift,$attributes_gift);
					?>
				</div>
			</li>
		</ul>
		<!--Account Setting Fields Rows Closed-->
	</div>
	<!--Account Setting Fields Closed-->
	<?php echo $form->end();?>
</div>
<!--Gift Options Closed-->