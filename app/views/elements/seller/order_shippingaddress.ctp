<?php ?>
<p><strong>Shipping Address</strong></p>
<p>
<?php if((!empty($order_details['Order']['shipping_firstname'])) || (!empty($order_details['Order']['shipping_lastname']))) {
	if((!empty($order_details['Order']['shipping_user_title']))){
		echo ucwords(strtolower($order_details['Order']['shipping_user_title'])).' ';
	}
	if((!empty($order_details['Order']['shipping_firstname']))){
		echo ucwords(strtolower($order_details['Order']['shipping_firstname'])).' ';
	}
	if((!empty($order_details['Order']['shipping_lastname']))){
		echo ucwords(strtolower($order_details['Order']['shipping_lastname'])).' ';
	}
} else echo '-'; ?>
</p>
<p><?php if((!empty($order_details['Order']['shipping_address1']))){
	echo ucwords(strtolower($order_details['Order']['shipping_address1']));
};?></p>
<p><?php if((!empty($order_details['Order']['shipping_address2']))){
	echo ucwords(strtolower($order_details['Order']['shipping_address2']));
};?></p>
<p><?php if((!empty($order_details['Order']['shipping_city']))){
	echo ucwords(strtolower($order_details['Order']['shipping_city']));
};?></p>
<p><?php if((!empty($order_details['Order']['shipping_postal_code']))){
	echo ucwords($order_details['Order']['shipping_postal_code']);
};?></p>
<p><?php if((!empty($order_details['Order']['shipping_country']))) {
	echo ucwords(strtolower($countries[$order_details['Order']['shipping_country']]));
};?></p>
<p>Phone:<?php if((!empty($order_details['Order']['shipping_phone']))) {
	echo $order_details['Order']['shipping_phone'];
};?></p>