<?php $billing = $this->Session->read('billing_add'); ?>
<h4 class="orng-clr">Your Billing Address</h4>
<div class="row padding0">
	<div class="arrow_div">
		<?php 
			echo $html->image("mobile/yr_prdcts_grayarrow.png" ,array('alt'=>"", 'class'=>'myprdctgft'));
		?>
	</div>
	<div class="chk_info">
		<p>
			<?php
			if(!empty($billing['Address']['title']) || !empty($billing['Address']['add_firstname']) || !empty($billing['Address']['add_lastname'])){
			if(!empty($billing['Address']['title'])) echo $billing['Address']['title'];
			if(!empty($billing['Address']['add_firstname'])) echo ' '.$billing['Address']['add_firstname'];
			if(!empty($billing['Address']['add_lastname'])) echo ' '.$billing['Address']['add_lastname'];
			}?>
		</p>
		<p>
			<?php if(!empty($billing['Address']['add_address1'])) 
			echo $billing['Address']['add_address1'];?>
		</p>
		<p>
			<?php if(!empty($billing['Address']['add_address2'])) 
			echo $billing['Address']['add_address2'];?>
		</p>
		<p>
			<?php if(!empty($billing['Address']['add_city'])) 
			echo $billing['Address']['add_city'];?>
		</p>
		<p>
			<?php if(!empty($billing['Address']['add_state'])) 
			echo $billing['Address']['add_state'];?>
		</p>
		<p>
			<?php if(!empty($billing['Address']['country'])) 
			echo $billing['Address']['country'];?>
		</p>
		
		<p>
			<?php if(!empty($billing['Address']['add_postcode']))
				echo $billing['Address']['add_postcode'];?>
		
		<?php 
			//Fro change the address
			//echo $html->image("checkout/change-btn.gif" ,array('alt'=>"Loading",'height'=>14,'width'=>46,'class'=>'','onClick'=>'display_add()'));
		?>
	</div>
</div>
<script defer="defer" type="text/javascript">
function display_add(){/** update the agenda div **/
	
	var postUrl =  SITE_URL+'checkouts/change_add/';
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
	cache:false,
	async: false,
	type: "GET",
	url: postUrl,
	success: function(msg){	
	jQuery('#updateaddchange').html(msg);
	jQuery('#plsLoaderID').hide();
    }

  });
}
</script>