<?php ?>
<!--mid Content Start-->
<div class="mid-content pad-rt-none">
	<!---<?php //echo $this->element('marketplace/breadcrum'); ?> --->
	<!--Setting Tabs Widget Start-->
	<div class="row-widget">
		<!--Tabs Widget Start-->
		<?php echo $this->element('navigations/seller_heading_bar'); ?>
		
		<!--Tabs Widget Closed-->
		<!--Tabs Content Start-->
		<div class="tabs-content">
			<!--Discription Start-->
			<div class="inner-content">
				<p>View your seller performance and reports that indicate how you are doing with respect to customer satisfation.</p>
				<p><span class="green-color larger-fnt"><strong>Positive Feedback:</strong></span> <span class="larger-fnt"><strong><?php if(!empty($positive_percentage)) echo round($positive_percentage).'%'; else echo '-';?></strong></span> <?php if(!empty($seller_info['Seller']['user_id'])) echo $html->link('View Feedback','/sellers/feedback/'.$seller_info['Seller']['user_id'],array('escape'=>false,'class'=>'underline-link'));?> <span class="line-break">Seller since: <strong><?php if(!empty($seller_info['Seller']['created'])) echo date('d/m/Y', strtotime($seller_info['Seller']['created'])); else echo '-'; ?> </strong></span></p>
			</div>
			<!--Discription Closed-->
		</div>
		<!--Tabs Content Closed-->
	</div>
	<!--Setting Tabs Widget Closed-->
</div>
<!--mid Content Closed-->

<!--Search Results Start-->
<div class="search-results-widget" style="overflow:visible;">
	<!--Monthly Sales Performance Widget Start-->
	<div class="row pad-right50" style="clear:left;">
		<ul>
			<li class="margin-bottom"><h2 class="font-size20">Monthly Sales Performance</h2></li>
			<li class="border" style="text-align:center;"><?php //echo $html->image('monthly-sales-performance-graph.gif',array('class'=>'display-bl','alt'=>''));?>
			<?php echo $html->image("/".PATH_GRAPH."/seller/sales-order-graph_".$seller_id.".png",array(' alt'=>""));?>

			</li>
		</ul>
	</div>
	<!--Monthly Sales Performance Widget Closed-->
	<!--Search Products Start-->
	<div class="row overflow-h">
		<?php if(!empty($bestSelling_products)) { ?>
		<!--Left Grid Start-->
		<div class="left-grid" style="padding-right:2%">
			<div class="border">
				<table width="100%" border="1" bordercolor="#cccccc" rules="all" frame="void" cellspacing="0" cellpadding="5" style="border-collapse:collapse;" class="seller-listings">
					<tr>
						<td width="75%" align="left"><strong>Bestselling Products</strong></td>
						<td width="25%"><strong>Units Sold</strong></td>
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
						<td align="left"><p><?php if(!empty($bestSelling_product['OrderItem']['product_name'])) echo $html->link($bestSelling_product['OrderItem']['product_name'],'/'.$this->Common->getProductUrl($bestSelling_product['OrderItem']['product_id']).'/categories/productdetail/'.$bestSelling_product['OrderItem']['product_id'],array('escape'=>false,'class'=>"underline-link")); else echo '-'; ?></p>
						<td><strong><?php if(!empty($bestSelling_product[0]['total_units'])) echo $bestSelling_product[0]['total_units']; else echo '-'; ?></strong></td>
					</tr>
					<?php $i++; } ?>
				</table>
			</div>
		</div>
		<!--Left Grid Closed-->
		<?php }
		if(!empty($viewed_products)){
		?>
		<!--Right Grid Start-->
		<div class="right-grid">
			<div class="border">
				<table width="100%" border="1" bordercolor="#cccccc" rules="all" frame="void" cellspacing="0" cellpadding="5" style="border-collapse:collapse;" class="seller-listings">
					<tr>
						<td width="75%" align="left"><strong>Most Viewed Products</strong></td>
						<td width="25%"><strong>Page Views</strong></td>
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
						<td>
							<strong>
								<?php if(!empty($viewed_product[0]['total_visits'])) echo $viewed_product[0]['total_visits']; else echo '-'; ?>
							</strong>
						</td>
					</tr>
					<?php $j++; } ?>
				</table>
			</div>
		</div>
		<!--Right Grid Closed-->
		<?php } ?>
	</div>
	<!--Search Products Closed-->
	<!--Customer Service History Widget Start-->
	<div class="row overflow-h">
		<!--Customer Service History Start-->
		<div class="left-history-grid">
			<h2 class="gr-heading">Customer Service History</h2>
			<div class="border">
				<table width="100%" border="1" bordercolor="#cccccc" rules="all" frame="void" cellspacing="0" cellpadding="5" style="border-collapse:collapse;" class="seller-listings">
					<tr>
						<td width="34%" align="left">&nbsp;</td>
						<td width="25%" class="larger-fnt"><strong>Last 30 Days</strong></td>
						<td width="21%" class="larger-fnt"><strong>Last 6 Months</strong></td>
						<td width="20%" class="larger-fnt"><strong>All History</strong></td>
					</tr>
					<tr class="odd">
						<td align="left" valign="top"><strong>Number of Orders</strong></td>
						<td class="larger-fnt"><strong><?php if(!empty($number_of_orders_30day)) echo $number_of_orders_30day; else echo '-'; ?></strong></td>
						<td class="larger-fnt"><strong><?php if(!empty($number_of_orders_6month)) echo $number_of_orders_6month; else echo '-'; ?></strong></td>
						<td class="larger-fnt"><strong><?php if(!empty($number_of_orders_history)) echo $number_of_orders_history; else echo '-'; ?></strong></td>
					</tr>
					<tr class="odd">
						<td align="left" valign="top"><strong>Pre-Shipped Cancel Rate</strong></td>
						<td class="larger-fnt"><strong><?php echo round($rate_preship_cancel_30day).'%';?></strong></td>
						<td class="larger-fnt"><strong><?php echo round($rate_preship_cancel_6month).'%';?></strong></td>
						<td class="larger-fnt"><strong><?php echo round($rate_preship_cancel).'%';?></strong></td>
					</tr>
					<tr class="odd">
						<td align="left" valign="top"><strong>Late Shipment Rate</strong></td>
						<td class="larger-fnt"><strong><?php echo round($lateship_30day_rate);?>%</strong></td>
						<td class="larger-fnt"><strong><?php echo round($lateship_6month_rate);?>%</strong></td>
						<td class="larger-fnt"><strong><?php echo round($lateship_rate);?>%</strong></td>
					</tr>
					<tr class="odd">
						<td align="left" valign="top"><strong>Refund Rate</strong></td>
						<td class="larger-fnt"><strong><?php echo round($rate_refund_30day);?>%</strong></td>
						<td class="larger-fnt"><strong><?php echo round($rate_refund_6month);?>%</strong></td>
						<td class="larger-fnt"><strong><?php echo round($rate_refund_history);?>%</strong></td>
					</tr>
				</table>
			</div>
		</div>
		<!--Customer Service History Closed-->
		<!--Right History Start-->
		<div class="right-history-widget">
			<ul class="target">
				<li>As a seller on Choiceful.com we would like you to maintain a consistently good level of service to ensure the best customer experience.You must keep your service levels within the target levels,failure to do so may result in seller account restrictions.</li>
				<!--<li style="padding-bottom:2px;padding-left:3px;padding-right:3px;padding-top:2px;">&nbsp;</li>-->
				<li>Target &lt; 2.5%</li>
				<li>Target &lt; 5%</li>
				<li>Target &lt; 5%</li>
			</ul>
		</div>
		<!--Right History Closed-->
	</div>
	<!--Customer Service History Widget Closed-->
</div>
<!--Search Results Closed-->