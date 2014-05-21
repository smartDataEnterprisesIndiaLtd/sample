<?php
header("Cache-Control: no-cache");
header("Expires: -1");
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);


e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
?>
<!-- Google Code for Purchase/Sale Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1063747748;
var google_conversion_language = "en";
var google_conversion_format = "1";
var google_conversion_color = "ffffff";
var google_conversion_label = "ebmrCIbFRxCkgZ77Aw";
var google_conversion_value = 0;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1063747748/?value=0&amp;label=ebmrCIbFRxCkgZ77Aw&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<script language="JavaScript">

	function open_window(url,win_height,win_width){
		window.open(url,"Print Order Summary","scrollbars=yes,menubar=NO,width="+win_width+",height="+win_height+",screenX=50,left=80,screenY=50,top=100");
	}
	/*jQuery(document).ready(function()  { // for writing a review
		jQuery("a.business_invoice_link").fancybox({
			'titlePosition': 'inside',
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : 850,
			'height' : 500,
			'padding':0,'overlayColor':'#DFDFDF',
			'overlayOpacity':0.8,
			'hideOnOverlayClick':false,
			'opacity':	true,
			'type' : 'iframe',
			'autoDimensions': false,
		});
	});*/
</script>

<!--Content Start-->
<div id="checkout-content">
	<!--Left Content Start-->
	<?php echo $this->element('checkout/left');?>
	<!--Left Content Closed-->
	<!--Right Content Start-->
	<!--Left Content Closed-->
        <div class="right-con">&nbsp;</div>
         <!--Right Content Start-->
         <div class="checkout-right-content1">
         
         	<!--Top Content Start-->
           <div class="inner-content">
			<li>
				<?php
				if ($session->check('Message.flash')){ ?>
					<div  class="messageBlock">
						<?php echo $session->flash();?>
					</div>
				<?php } ?>
			</li>
			<!--<h2 class="bl-diffrnt pad-top-bottom25 border-btm-blue">Your order has been submitted successfully!</h2>-->
			<h2 class="bl-diffrnt border-btm-blue" style="padding-bottom:10px;">Your order has been submitted successfully!</h2>
			<div class="order-number-widget">Your order number is: <?php echo $ordData['Order']['order_number']; ?>
				<span class="line-break">Your Transaction ID is:  <?php echo $ordData['Order']['tranx_id']; ?></span>
			</div>
			<p class="margin-top"><br>
				<strong> Thank you for your order.</strong>
			</p>
			<p>We will send you an e-mail confirmation shortly.</p>
			<p>Subject to final confirmation for your credit card and product availability it will be delivered to address below.</p>
			<p class="smalr-fnt"><strong>Please note:</strong> If you are ordering from multiple sellers and wish to edit your order please contact each seperately.You will find their contact details in the open orders section of your account.</p>
		</div>
		<!--Top Content Closed-->
		<!--Dispatched Order Start-->
		<div class="dispatched-order border">
			<h5 class="bl-background-head smalr-fnt">Your order will be dispatched to the following address:</h5>
			<!--Row Start-->
			<div class="padding-row overflow-h">
				<!--Left Start-->
				<div class="left-address-widget">
				<ul>
					<li class="left-icon"><?php echo $html->image("checkout/d-arrow-icon-red.png" ,array('width'=>"7",'height'=>"7", 'alt'=>"" )); ?></li>
					<li><p><?php echo $ordData['Order']['shipping_firstname'];?></p>
					<p><?php echo $ordData['Order']['shipping_address1'];?></p>
					<p><?php echo $ordData['Order']['shipping_address2'];?></p>
					<p><?php echo $ordData['Order']['shipping_city'];?></p>
					<p><?php echo $ordData['Order']['shipping_state'];?></p>
					<p><?php echo $ordData['Order']['shipping_postal_code'];?></p>
					<p><?php echo $countries[$ordData['Order']['shipping_country']];?></p>
					<p>Phone: <?php echo $ordData['Order']['shipping_phone'];?></p>
					</li>
				</ul>
				</div>
				<!--Left Closed-->
				<!--Right Start-->
				<div class="right-links-widget">
					<ul class="lt-arrow-links">
						<li><?php echo $html->link("Track the status of this order",'/orders/view_open_orders',array('escape'=>false));?></li>
						<li><?php echo $html->link("Click here to return to homepage",'/',array('escape'=>false));?></li>
						<li><?php $print_orderId = $ordData['Order']['id']; echo $html->link("Print order summary",'javascript:void(0);',array('class'=>'business_invoice_link' , 'onclick' => "open_window('".SITE_URL."orders/purchaseorder_slip/$print_orderId',500,850)" ));?></li>
					</ul>
				</div>
				<!--Right Closed-->
			</div>
			<!--Row Closed-->
		</div>
		<!--Dispatched Order Closed-->
	</div>
	</div>
	<!--Right Content Closed-->
</div>

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