<?php ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
	<td class="adminGridHeading heading"><?php echo $title_for_layout;?></td>
	<td class="adminGridHeading">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="left">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="vertical-align:top;" align="left">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
							<td colspan ="2" align="left">
								<table width="100%" cellspacing ="0" cellpadding = "3" border = "0" class="adminBox">
										
									<tr class="rowClassEven">
										<td width="33%" align="left" class="heading-text"> Total Registered Customers </td>
										<td align="left" class="heading-text-16">: <?php echo $total_users;?></td>
									</tr>
									<tr class="rowClassOdd">
										<td align="left" class="heading-text"> Total Registered Sellers</td>
										<td align="left"  class="heading-text-16">: <?php echo $total_sellers;?></td>
									</tr>
									<tr class="rowClassEven">
										<td align="left" class="heading-text"> Page Views</td>
										<td align="left" class="heading-text-16">: <?php echo $total_visitors;?></td>
									</tr>
									<tr class="rowClassOdd">
										<td align="left" class="heading-text"> Number of Products  on Website</td>
										<td align="left" class="heading-text-16" >: <?php echo $total_products;?></td>
									</tr>
								</table>
							</td>
							</tr>
							<tr><td colspan="2">&nbsp;</td></tr>
							<?php
								if($paginator->sortDir() == 'asc'){
									$image = $html->image('admin-arrow-top.gif',array('border'=>0,'alt'=>'','div'=>false));
								}
								else if($paginator->sortDir() == 'desc'){
									$image = $html->image('admin-arrow-bottom.gif',array('border'=>0,'alt'=>'','div'=>false));
								}
								else{
									$image = '';
								}
							
							if(!empty($all_sales)){ ?>
							<tr><td colspan="2">
								<table width="100%" cellspacing ="0" cellpadding = "0" border = "0">
								<tr>
									<td colspan ="2" align="left"><span class="linkcolor"><b>Sales for last month from <?php echo date(DATE_FORMAT,strtotime($from_date));?> to <?php echo date(DATE_FORMAT,(strtotime($to_date)-(60*60*24)));?></b></span></td>
								</tr>
								<tr>
									<td colspan ="2" align="left">
										<table width="100%" cellspacing ="0" cellpadding = "3" border = "0" class="adminBox">
											<tr>
												<td align="center" width="8%" class="adminGridHeading heading"><b>
												<?php echo $paginator->sort('Date', 'OrderNumber.created'); ?>
												<?php if($paginator->sortKey() == 'OrderNumber.created'){     echo $image; 	} ?>
												
												</b></td>
												<td align="center" width="20%" class="adminGridHeading heading"><b>
												<?php echo $paginator->sort('Total Amount', 'OrderNumber.total_sales'); ?>
												<?php if($paginator->sortKey() == 'OrderNumber.total_sales'){     echo $image; 	} ?>
												</b></td>
												<td  align="center" width="20%" class="adminGridHeading heading"><b>
												<?php echo $paginator->sort('Number of Orders', 'OrderNumber.total_number'); ?>
												<?php if($paginator->sortKey() == 'OrderNumber.total_number'){     echo $image; } ?>
												</b></td>
												<td  align="left" class="adminGridHeading heading"></td>
											</tr>
											<?php
											$class= 'rowClassEven';
											foreach($all_sales as $sales) {
												$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
											?>
											<tr class="<?php echo $class?>">
												<td  align="center"><?php echo date(DATE_FORMAT, strtotime($sales['OrderNumber']['created'])); ?></td>
												<td align="center"><?php echo CURRENCY_SYMBOL.' '.$format->money($sales['OrderNumber']['total_sales'],2); ?></td>
												<td  align="center"><?php echo $sales['OrderNumber']['total_number'];?></td>
												<td  align="left"></td>
											</tr>
				
											<?php }?>
										</table>
									</td>
								</tr>
								</table>
							</td></tr>
							<?php } else{ ?>
							<tr>
								<td colspan="2">
									<table width="100%" cellspacing ="0" cellpadding = "0" border = "0">
									<tr>
										<td><span class="linkcolor"><b>No product saled from <?php echo date(DATE_FORMAT,strtotime($from_date));?> to <?php echo date(DATE_FORMAT,(strtotime($to_date)-(60*60*24)));?></b></span></td>
									</tr>
									</table>
								</td>
							</tr>
							<?php }?>
							<!--<tr>
								<td> Total <span class="linkcolor"><b>online users</b></span></td>
								<td><span class="linkcolor"><b><?php //echo $total_online_users;?></b></span></td>
							</tr>-->
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>