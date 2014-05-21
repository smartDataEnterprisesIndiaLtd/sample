<?php $billing = $this->Session->read('billing_add'); ?>
<p><span class="gray smalr-fnt"><strong>Your Billing address is:</strong></span></p>
<p><?php
if(!empty($billing['Address']['title']) || !empty($billing['Address']['add_firstname']) || !empty($billing['Address']['add_lastname'])){
if(!empty($billing['Address']['title'])) echo $billing['Address']['title'];
if(!empty($billing['Address']['add_firstname'])) echo ' '.$billing['Address']['add_firstname'];
if(!empty($billing['Address']['add_lastname'])) echo ' '.$billing['Address']['add_lastname'];
}?></p>
<p><?php if(!empty($billing['Address']['add_address1'])) echo $billing['Address']['add_address1'];?></p>
<p><?php if(!empty($billing['Address']['add_address2'])) echo $billing['Address']['add_address2'];?></p>
<p><?php if(!empty($billing['Address']['add_city'])) echo $billing['Address']['add_city'];?></p>
<p><?php if(!empty($billing['Address']['add_state'])) echo $billing['Address']['add_state'];?></p>
<p><?php if(!empty($billing['Address']['country'])) echo $billing['Address']['country'];?></p>
<p>
<?php if(!empty($billing['Address']['add_postcode'])) echo $billing['Address']['add_postcode'];?> 
<?php echo $ajax->link($html->image("checkout/change-btn.gif" ,array('alt'=>"Loading",'height'=>14,'width'=>46,'class'=>'v-align-middle margn-lt')),'', array('escape'=>false,'update' => 'updateaddchange', 'id'=>'changeaddress_btn','url' =>'/checkouts/change_add/','class'=>'',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading()"), null,false);?>
<?php echo $html->link('','javascript:void(0)',array('id'=>'linkId','onClick'=>'display_add()'));?>

<script type="text/javascript">
function display_add(){/** update the agenda div **/
	var postUrl =  SITE_URL+'checkouts/change_add/';
  	jQuery.ajax({
    	cache:false,
    	async: false,
    	type: "GET",
    	url: postUrl,
    	success: function(msg){	
	jQuery('#updateaddchange').html(msg);
    }

  });
}
</script>