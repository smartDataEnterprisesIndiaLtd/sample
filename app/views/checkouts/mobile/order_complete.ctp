<?php
header("Cache-Control: no-cache");
header("Expires: -1");
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);

?>
<style>
.prdctbrdcrmb{
	padding-bottom: 0;
}
</style>
<script language="JavaScript">

	function open_window(url,win_height,win_width){
		var site_url="<?php echo SITE_URL?>"+url;
		window.open(site_url,"Print Order Summary","scrollbars=yes,menubar=NO,width="+win_width+",height="+win_height+",screenX=50,left=80,screenY=50,top=100");
	}
</script>

<!--Main Content Starts--->
<section class="maincont nopadd">
<?php
	if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock">
			<?php echo $session->flash();?>
		</div>
<?php } ?>
<section class="prdctboxdetal margin-top">
	<h4 class="diff-blu font13">Checkout Choiceful: Swift, Simple & Secure</h4>
	<h4 class="orng-clr font13"><span class="gray-color">Step 5 of 5</span> Order Confirmation</h4>
	
	<!--Thanks Start-->
	<div class="thanks-widget">
	<p><strong>Thanks you for your order.</strong></p>
	<p>We will send you an e-mail confirmation shortly.</p>
	</div>
	<!--Thanks Closed-->
	
	<!--Listing Start-->
	<ul class="listing font11">
	<li><strong>Your order number is: <?php echo $ordData['Order']['order_number']; ?></strong></li>
	<li>
		<p><strong>Your Transaction ID is:</strong></p>
		<p><strong><?php echo $ordData['Order']['tranx_id']; ?></strong></p>
	</li>
	</ul>
	<!--Listing Closed-->
	
	
	<!--Checkout info Start-->
	<ul class="chkout_info border-top-dashed">
	<li>
	<p>Subject to final confirmation for your credit card and product availability it will be delivered to the address below.</p>
	<div class="row padding5">
		<div class="arrow_div">
		<?php echo $html->image("checkout/d-arrow-icon-red.png" ,array('width'=>"7",'height'=>"7", 'alt'=>"" )); ?>
		</div>
		<div class="chk_info font11">
			<p><?php echo $ordData['Order']['shipping_firstname'];?></p>
			<p><?php echo $ordData['Order']['shipping_address1'];?></p>
			<p><?php echo $ordData['Order']['shipping_address2'];?></p>
			<p><?php echo $ordData['Order']['shipping_city'];?></p>
			<p><?php echo $ordData['Order']['shipping_state'];?></p>
			<p><?php echo $ordData['Order']['shipping_postal_code'];?></p>
			<p><?php echo $countries[$ordData['Order']['shipping_country']];?></p>
			<p>Phone: <?php echo $ordData['Order']['shipping_phone'];?></p>
		</div>
		</div>
		<p class="font11"><strong>Please note:</strong> If you are ordering from multiple sellers and wish to edit your order please contact each seller separately. You will find their contact details in the open orders section of your account.</p>
	</li>
	
	<li class="brdr-none buttons-widget padding-top15">
		<p style="width:205px;">
				<?php 
				$print_orderId = $ordData['Order']['id'];
				echo $html->link('<input type="button" align="left" value="Print business tax invoice" class="signinbtnwhyt cntnuchkot" style="margin-bottom:5px">','javascript:void(0);',array('escape'=>false, 'onclick'=>"open_window('orders/purchaseorder_slip/$print_orderId',500,850)"));?>
				<?php echo $html->link('<input type="button" align="left" value="Change this order" class="signinbtnwhyt cntnuchkot" style="margin-bottom:5px">','/orders/view_open_orders',array('escape'=>false));?>
				<?php echo $html->link('<input type="button" align="left" value="Continue to Homepage" class="signinbtnwhyt cntnuchkot">','/',array('escape'=>false));?>
				
		<!--<input type="button" align="left" value="Print business tax invoice" class="signinbtnwhyt cntnuchkot"></p>
		<p><input type="button" align="left" value="Change this order" class="signinbtnwhyt cntnuchkot"></p>
		<p><input type="button" align="left" value="Continue to Homepage" class="signinbtnwhyt cntnuchkot">--></p>
	</li>
	</ul>
	<!--Checkout info Closed-->
	
</section>
</section>
<!--Main Content End--->
<!--Navigation Starts-->
<section class="maincont">
<nav class="nav">
	<ul class="maincategory yellowlist">
		<?php echo $this->element('mobile/nav_footer');?>
	</ul>
</nav>
</section>
<!--Navigation End-->


<?php
$logged_in_user = $this->Session->read('User');
$email = $logged_in_user['email'];
$total_amount = $ordData['Order']['order_total_cost'];
$currency = CURRENCY_CODE;

?>
<!--<script src="http://75.125.190.162:9180/users/getdata/6/emailaddress/amount/currency" type="text/javascript">-->
<!--Please fill the <emailaddress>, <amount> and <currencycode> values that we use in our web code.-->
<script src="<?php echo SITE_URL;?>users/getdata/6/<?php echo $email.'/'.$total_amount.'/'.$currency;?>" type="text/javascript">
</script>

<!--Content Closed-->
<!--affiliate project as per client request on mail "Affiliate script test"-->
<!--<form  action='http://75.125.190.162:9180/users/thirdparty' method='post' target='formresponse' name='thirdpartyform'> -->
<!--<input type='hidden' name='amount' value='2000'/>--><!-- Enter order amount like 2000 -->
<!--<input type='hidden' name='currency' value='USD'/>--><!-- Use standard code for currency like USD -->
<!--<input type='hidden' name='websiteid' value='6'/>-->  <!-- Dont modify -->
<!--<input type='hidden' name='emailid' value='sanjivk@smartdatainc.net' />--><!-- Enter customer email id --> 
<!--</form> 
<iframe name='formresponse' frameborder='0' style="visibility:hidden"></iframe>
<script type="text/javascript">
window.onload = function () {document.thirdpartyform.submit();}
</script> -->
<!-- End affiliate project as per client request on mail "Affiliate script test"-->		

<!-- add for ecommerce tracking on 05_Mar_2013-->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-629547-1']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_addTrans',
    '<?php echo $ordData['Order']['order_number']; ?>',               	// transaction ID -required (OrderID)
    '',  						         	// affiliation or store name
    '<?php echo $ordData['Order']['order_total_cost']; ?>',      	// total - required
    '<?php echo $ordData['Order']['tax_amount']; ?>',            	// tax
    '<?php echo $ordData['Order']['shipping_total_cost']; ?>',    	// shipping
    '<?php echo $ordData['Order']['billing_city']; ?>',          	// city
    '<?php echo $ordData['Order']['billing_state']; ?>',        	// state or province
    ''                                                                  // country
  ]);

   // add item might be called for every item in the shopping cart
   // where your ecommerce engine loops through each item in the cart and
   // prints out _addItem for each
   <?php foreach ($ordData['OrderItem'] as $data) {?>
  _gaq.push(['_addItem',
    '<?php echo $ordData['Order']['order_number']; ?>',            	// transaction ID - required (OrderId)
    '<?php echo $data['quick_code']?>',           			// SKU/code - required
    '<?php echo $data['product_name']?>',        			// product name
    '',   								// category or variation
    '<?php echo $data['price']?>',          				// unit price - required
    '<?php echo $data['quantity']?>'               			// quantity - required
  ]);
  <?php } ?>
  _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!--Ends-->