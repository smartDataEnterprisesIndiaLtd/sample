<?php ?>
<ul class="confirm-request">
	<li>View your seller performance and reports that indicate how you are doing with respect to customer satisfation.</li>
	<li>
		<p>
			<span class="font16 green-color">
				<strong>Positive Feedback:</strong>
			</span> 
			<span class="font16">
				<strong>
					<?php if(!empty($positive_percentage)) echo $positive_percentage.'%'; else echo '-';?>
				</strong>
			</span>
			<?php if(!empty($seller_info['Seller']['user_id'])) echo $html->link('View Feedback','/sellers/feedback/'.$seller_info['Seller']['user_id'],array('escape'=>false));?>
		</p>
		<p>Seller since:
			<strong>
			<?php if(!empty($seller_info['Seller']['created'])) echo date('d/m/Y', strtotime($seller_info['Seller']['created'])); else echo '-'; ?>
			</strong>
		</p>
	</li>
	
	<li>
		<table width="100%" border="1" bordercolor="#cccccc" rules="all" frame="void" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" class="seller-listings border">
		<tr>
		<td width="40%" align="left"><strong>Customer Service</strong></td>
		<td width="18%"><strong>30 Days</strong></td>
		<td width="20%"><strong>6 Months</strong></td>
		<td width="22%"><strong>All History</strong></td>
		</tr>
		
		<tr class="odd">
			<td align="left"><strong>Number of Orders</strong></td>
			<td class="larger-fnt">
				<?php if(!empty($number_of_orders_30day)) echo $number_of_orders_30day; else echo '-'; ?>
			</td>
			<td>
				<?php if(!empty($number_of_orders_6month)) echo $number_of_orders_6month; else echo '-'; ?>
			</td>
			<td>
				<?php if(!empty($number_of_orders_history)) echo $number_of_orders_history; else echo '-'; ?>
			</td>
		</tr>
		
		<tr class="even">
			<td align="left"><strong>Pre-Shipped Cancel</strong></td>
			<td><?php echo round($rate_preship_cancel_30day, 1).'%';?></td>
			<td><?php echo round($rate_preship_cancel_6month, 1).'%';?></td>
			<td><?php echo round($rate_preship_cancel, 1).'%';?></td>
		</tr>
		
		<tr class="odd">
			<td align="left"><strong>Late Shipment Rate</strong></td>
			<td><?php echo round($lateship_30day_rate, 1);?>%</td>
			<td><?php echo round($lateship_6month_rate, 1);?>%</td>
			<td><?php echo round($lateship_rate, 1);?>%</strong></td>
		</tr>
		
		<tr class="odd">
		<td align="left"><strong>Refund Rate</strong></td>
		<td>10.4%</td>
		<td>10.4%</td>
		<td>10.4%</td>
		</tr>
		
		</table>
	</li>
	<li>As a seller on Choiceful.com Marketplace our target rates offer guidance of what we expect our sellers to maintain. If you are above our target percentages your account will be frozen and could be permanently closed if unresolved.</li>
	
	<li><p class="orng-clr"><strong>Target rates:</strong></p>
	<p>Pre-shipped cancel &lt; 2.5%</p>
	<p>Late Shipment Rate &lt; 5%</p>
	<p>Refund rate &lt; 5%</p>
	</li>
	
	<li>
		<table width="100%" border="1" bordercolor="#cccccc" rules="all" frame="void" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" class="seller-listings border">
			<tr>
			<td width="81%" align="left"><strong>Best Seller Products</strong></td>
			<td width="19%"><strong>Units</strong></td>
			</tr>
			
			<?php $i = 0;
				foreach($bestSelling_products as $bestSelling_product){
				if($i%2 == 0){
					$class = 'odd';
				} else {
					$class ='even';
				}
				?>
				<tr class="<?php echo $class;?>">
					<td align="left">
						<p>
							<?php if(!empty($bestSelling_product['OrderItem']['product_name'])) echo $html->link($bestSelling_product['OrderItem']['product_name'],'/'.$this->Common->getProductUrl($bestSelling_product['OrderItem']['product_id']).'/categories/product_detail/'.$bestSelling_product['OrderItem']['product_id'],array('escape'=>false,'class'=>"underline-link")); else echo '-'; ?>
						</p>
					<td>
						<strong>
							<?php if(!empty($bestSelling_product[0]['total_units'])) echo $bestSelling_product[0]['total_units']; else echo '-'; ?>
						</strong>
					</td>
				</tr>
			<?php $i++; } ?>
		</table>
	</li>
	
	<li>
	<table width="100%" border="1" bordercolor="#cccccc" rules="all" frame="void" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" class="seller-listings border">
		<tr>
		<td width="81%" align="left"><strong>Best Seller Products</strong></td>
		<td width="19%"><strong>Units</strong></td>
		</tr>
		
		<?php $j = 0;
			foreach($viewed_products as $viewed_product){
			if($j%2 == 0){
				$class = 'odd';
			} else {
				$class ='even';
			}?>
			<tr class="<?php echo $class; ?> ">
				<td align="left">
					<p>
						<?php if(!empty($viewed_product['Product']['product_name'])) echo $html->link($viewed_product['Product']['product_name'],'/'.$this->Common->getProductUrl($viewed_product['ProductVisit']['product_id']).'/categories/productdetail/'.$viewed_product['ProductVisit']['product_id'],array('escape'=>false,'class'=>"underline-link")); else echo '-'; ?>
					</p>
				</td>
				<td>
					<strong>
						<?php if(!empty($viewed_product[0]['total_visits'])) echo $viewed_product[0]['total_visits']; else echo '-'; ?>
					</strong>
				</td>
			</tr>
		<?php $j++; } ?>
		
	</table>
	</li>
</ul>