<style>
.loader-img {
    top: 3px;
}
.row-sec{
	padding: 2px 0;
}
</style>
<!--Tabs Start-->
             <?php echo $this->element('mobile/orders/tab');?>
             <!--Tbs Closed-->
             <!--Tbs Cnt start-->
             <section class="tab-content padding0">
             	<!--Manage Listings Start-->
             	<section class="offers">                	
                	<section class="gr_grd brd-tp0">
                    	<h4>Order: <?php echo $order_details['Order']['order_number'];?></h4>
                        <div class="loader-img"><img src="/img/mobile/loader.gif" width="22" height="22" alt="" /></div>
                    </section>
                     <!--mid Content Start-->
                    <div class="mid-content">
                        <!--Form Widget Start-->
                        <div class="form-widget row-sec">
                            <ul>
                              <li>
                                <p style="padding-bottom:3px;"><strong>Order Date:</strong> <?php echo date('j M Y H:i:s',strtotime($order_details['Order']['created']));?><!--2 August 2010 19:31:18--></p>
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
                                <p>	<?php if((!empty($order_details['Order']['shipping_address1']))){
						echo ucwords(strtolower($order_details['Order']['shipping_address1']));
					};?>
				</p>
				<p>
					<?php if((!empty($order_details['Order']['shipping_address2']))){
						echo ucwords(strtolower($order_details['Order']['shipping_address2']));
					};?>
				</p>
				<p>
					<?php if((!empty($order_details['Order']['shipping_city']))){
						echo ucwords(strtolower($order_details['Order']['shipping_city']));
					};?>
				</p>
				<p>
					<?php if((!empty($order_details['Order']['shipping_postal_code']))){
						echo ucwords($order_details['Order']['shipping_postal_code']);
					};?>
				</p>
				<p>
					<?php if((!empty($order_details['Order']['shipping_country']))) {
						echo ucwords(strtolower($countries[$order_details['Order']['shipping_country']]));
					};?>
				</p>
				<p>Phone:
					<?php if((!empty($order_details['Order']['shipping_phone']))) {
						echo $order_details['Order']['shipping_phone'];
					};?>
				</p>
                              </li>
			      
                              <li>
				<p class="margin"><strong>Expected Ship Date:</strong>
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
							
						}
						if(!empty($estimated_dd)) echo date('j F Y',strtotime($estimated_dd)); else echo '-';?>
				</p>
                                <p class="margin-tp-btm"><strong>Shipping Service:</strong>
					<?php if(!empty($order_details['Items'])){
						echo $shiping_services;
					} else { echo '-';}
				?>
				</p>
                                <p class="margin"><strong>Status:</strong>
					<span class="redcolor"><strong><?php if(!empty($order_details['OrderSeller']['shipping_status'])) { echo $order_details['OrderSeller']['shipping_status']; } else echo '-';?></strong></span>
				</p>
                                <p class="margin-top">
					<strong>Buyer:</strong>
					<?php 
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
								//echo $html->link($username,'/messages/sellers/'.$order_details['Items']['0']['OrderItem']['id'],array('escape'=>false));
								echo $username;
							} else{
								echo $username;
							}
						} else echo '-';
					?>
					
				</p>
                              </li>
			      
                              <li><h4 class="orng-clr">Items Ordered</h4></li>
				<?php
				if(!empty($order_details['Items'])) {
				$total_order_cost = 0;
				foreach($order_details['Items'] as $od_itms) {
				?>
                              <li>
                              	<p><?php echo $html->link($od_itms['OrderItem']['product_name'],"/".$this->Common->getProductUrl($od_itms['OrderItem']['product_id'])."/categories/productdetail/".$od_itms['OrderItem']['product_id'],array('escape'=>false,'class'=>''));?></p>
                                <p><span class="green-color">Quantity Ordered:</span>
				<?php echo $od_itms['OrderItem']['quantity'];?></p>
				<p><span class="green-color">Quantity Shipped:</span>
					<?php
						$dis_quantity = 0;
						if(!empty($od_itms['DispatchedItem'])){
						foreach($od_itms['DispatchedItem'] as $dispatched_items){
							if(!empty($dispatched_items['quantity'])){
							$dis_quantity = $dis_quantity + $dispatched_items['quantity'];
							}
						}
					}?>
				<?php echo $dis_quantity;?></p>
                                <p><b>Price: </b><?php echo CURRENCY_SYMBOL.''.$format->money($od_itms['OrderItem']['price'],2);?></p>
                                <p><b>Delivery: </b><?php echo CURRENCY_SYMBOL.''.$format->money($od_itms['OrderItem']['delivery_cost'],2);?></p>
                                <p><b>Subtotal: </b><?php echo CURRENCY_SYMBOL.''.$format->money((($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['price']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity'])),2);?></p>
                                <p class="lgtgray"><b>Condition:</b> <?php echo $pro_conditions[$od_itms['OrderItem']['condition_id']];?></p>
                                <p class="lgtgray"><b>Comments:</b> <?php echo $od_itms['ProductSeller']['notes'];?></p>
                                <p><b>Your Code:</b> <?php echo $od_itms['ProductSeller']['reference_code'];?></p>
                                <p><b>Quick Code:</b> <span class="lgtgray"><?php echo $od_itms['OrderItem']['quick_code'];?></span></p>
                              </li>
				<?php $total_order_cost = round(($total_order_cost + ($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['price'] * $od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity'])),2);?>
			      <?php }}?>
                            </ul>
                        </div>
                        <!--Form Widget Closed-->
                        <!---->
                        <div class="custmrpayd">Customer Paid: <?php echo CURRENCY_SYMBOL.''.$format->money($total_order_cost,2);?></div>
                        <!--Shipment Information Starts-->
                        <section class="shypmntnfo">
                            <section class="gr_grd brd-tp0">
                                <h4>Shipment Information</h4>
                                <div class="loader-img"><img src="/img/mobile
				/loader.gif" width="22" height="22" alt="" /></div>
                            </section>
                            <!---->
			    <?php if(!empty($order_details['Dispatched_Items'])) { ?>
                            <ul>
				<?php $ship_number = 1;
				foreach($order_details['Dispatched_Items'] as $ship_item){ ?>
                              <li class="margin-top">
                                <p class="grn-clr boldr">Shipment Number
						<?php 
							echo $ship_number;
						?>
				</p>
                                <p>
					<?php if(!empty($ship_item['DispatchedItem']['item_name'])) {
						echo $ship_item['DispatchedItem']['item_name'];
						}
						else { 
						echo '-';
						}
					?>
				</p>
                                <!--p>Dustbuster Extreme Vac <b>x 1</b></p-->
                                <p>Shipped on
				<?php if(!empty($ship_item['DispatchedItem']['shipping_date'])) {
							echo date(FULL_DATE_FORMAT,strtotime($ship_item['DispatchedItem']['shipping_date']));
						} else {
							echo '<span class="red-color">Not available</span>';
						} ?>
				</p>
                                <p>Using carrier: <b>
					<?php if(!empty($ship_item['DispatchedItem']['shipping_carrier'])) { 
							echo $carriers[$ship_item['DispatchedItem']['shipping_carrier']];
							if($ship_item['DispatchedItem']['shipping_carrier'] == 8 || $ship_item['DispatchedItem']['shipping_carrier'] == 9){
								echo ' ('.$ship_item['DispatchedItem']['other_carrier'].')';
							}
						} else {
							echo '<span class="red-color">Not available</span>';
						} ?>
				</b></p>
                                <p>Service:
				
				<?php if(!empty($ship_item['DispatchedItem']['shipping_service'])) {
							echo $ship_item['DispatchedItem']['shipping_service'];
						} else {
							echo '<span class="drkred">Not available</span>';
						} ?>
				</p>
                                <p>Tracking ID:
					<?php if(!empty($ship_item['DispatchedItem']['tracking_id'])) { 
							echo $ship_item['DispatchedItem']['tracking_id']; 
						} else { 
							echo '<span class="drkred">Not available</span>';
						} ?>
				</p>
                              </li>
			      <?php  $ship_number++; } ?>
                           </ul>
			    <?php }?>
                            <!---->
                            <!--ul class="toppadd">
                              <li>
                                <p class="grn-clr boldr">Shipment Number 2</p>
                                <p>Harry Potter And The Half-Blood Prince [DVD][2009] <b>x 1</b></p>
                                <p>Shipped on February 25, 2011</p>
                                <p>Using carrier: <b>DHL</b></p>
                                <p>Service: First Class Mail</p>
                                <p>Tracking ID: FC-555520011/12</p>
                              </li>
                           </ul-->
                       </section>
                        <!--Shipment Information End-->
                        <!--Shipment Information Starts-->
                        <section class="shypmntnfo">
                            <section class="gr_grd brd-tp0">
                                <h4>Feedback Received</h4>
                                <div class="loader-img"><img src="/img/mobile/loader.gif" width="22" height="22" alt="" /></div>
                            </section>
                            <!---->
				<ul>
					<?php if(!empty($order_details['Feedback'])) { ?>
						<?php foreach($order_details['Feedback'] as $feedback){ ?>
							<li>
							  <p><?php 
								if(!empty($feedback['item_name']))
									echo "<b>".$feedback['item_name']."</b>";
								else
									echo '-'; ?> <br />
								<?php if(!empty($feedback['feedback']))
									echo $feedback['feedback'];
								else 
									echo '-';
								?>
							  </p>
							</li>
						<?php }?>
					<?php }else{?>
						<li>
							<p>None left</p>
						</li>
					<?php }?>
			        </ul>			
					
                            <!---->
                       </section>
                        <!--Shipment Information End-->
                        <!--Shipment Information Starts-->
			<?php if(!empty($order_details['Refunds'])){ ?>
                       <section class="shypmntnfo">
                            <section class="gr_grd brd-tp0">
                                <h4>Refunds</h4>
                                <div class="loader-img"><img src="/img/mobile/loader.gif" width="22" height="22" alt="" /></div>
                            </section>
                            <!---->
			    
                            <ul>
                              <li>
					<?php foreach($order_details['Refunds'] as $refund){ ?>
					<p><?php if(!empty($refund['OrderRefund']['created'])) echo date('d-m-Y',strtotime($refund['OrderRefund']['created'])); else echo '-';?> <span class="pad-left">Refund - <?php if(!empty($refund['OrderRefund']['amount'])) echo CURRENCY_SYMBOL.$format->money($refund['OrderRefund']['amount'],2); else echo '-';?></span></p>
					<?php }?>
                              </li>
                           </ul>
                            <!---->
                       </section>
		       <?php }?>
                        <!--Shipment Information End-->
                    <!--mid Content Closed-->
                   </div>
                    </section>
                    <!--Manage Listings Closed-->
           </section>
           <!--Tbs Cnt closed-->