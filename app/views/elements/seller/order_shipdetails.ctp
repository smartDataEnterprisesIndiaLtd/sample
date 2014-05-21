<?php ?>
<ul class="order-information">
	<li><strong>Expected Ship Date:</strong>
		<?php
		if(!empty($order_details['Items'])){
			$estimated_dd = '';
			foreach($order_details['Items'] as $order_item){
				if(empty($estimated_dd)){
					$estimated_dd = $order_item['OrderItem']['estimated_dispatch_date'];
				} else{
					if(strtotime($estimated_dd) < strtotime($order_item['OrderItem']['estimated_dispatch_date']))
						$estimated_dd = $order_item['OrderItem']['estimated_dispatch_date'];
				}
			/*For Comdind shiping Service*/	
				if($order_item['OrderItem']['delivery_method'] == 'E'){
					$shiping_service = 'Express';
				} else {
					$shiping_service = 'Standard';
				}
				$shiping_service_array[$order_item['OrderItem']['id']] = $shiping_service;
			}
			$shiping_service_arrayunique = array_unique($shiping_service_array);
			$shiping_services =  implode(',',$shiping_service_arrayunique);
			/* End For Comdind shiping Service*/
			
		} if(!empty($estimated_dd)) echo date(FULL_DATE_FORMAT,strtotime($estimated_dd)); else echo '-';?></li>
	<li><strong>Shipping Service: </strong><?php if(!empty($order_details['Items'])){
				
						/*if($order_details['Items'][0]['OrderItem']['delivery_method'] == 'E'){
							$shiping_service = 'Express';
						} else {
							$shiping_service = 'Standard';
						}
						echo $shiping_service;*/
						echo $shiping_services;
	
					
				} else { echo '-';} //pr($order_details); //echo $delivery_method;?></li>
	<li><strong>Status:</strong> <span class="red-color"><strong><?php if(!empty($order_details['OrderSeller']['shipping_status'])) { echo $order_details['OrderSeller']['shipping_status']; } else echo '-';?> </strong></span></li>
	<li><strong>Contact Buyer:</strong> <?php 
		if((!empty($order_details['Order']['UserSummary']['firstname'])) || (!empty($order_details['Order']['UserSummary']['lastname'])) || (!empty($order_details['Order']['UserSummary']['email']))) {
			$username = '';
			if((!empty($order_details['Order']['UserSummary']['firstname']))){
				$username = $username.ucwords(strtolower($order_details['Order']['UserSummary']['firstname'])).' ';
			}
			if((!empty($order_details['Order']['UserSummary']['lastname']))){
				$username = $username.ucwords(strtolower($order_details['Order']['UserSummary']['lastname']));
			}
			if((!empty($order_details['Order']['UserSummary']['email']))){
				//echo $html->link($username,'/messages/sellers/user_id:'.$order_details['Order']['user_id'],array('escape'=>false));
				// REF #F1324
				echo $html->link($username,'/messages/sellers/'.$order_details['Items']['0']['OrderItem']['id'],array('escape'=>false));
			} else{
				echo $username;
			}
		} else echo '-'; ?>
	</li>
</ul>