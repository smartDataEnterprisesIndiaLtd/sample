<?php
// this all data coming from index.ctp of homes 
if(count($release1_field_ids) > 0){
	if(count($release1_Products) > 0){
		foreach($release1_field_ids as $ProdId):
			if(isset($release1_Products[$ProdId])){
				$pos1_newreleases[] = $release1_Products[$ProdId];
			}
		endforeach;
	}
}

if(count($release2_field_ids) > 0){
	if(count($release2_Products) > 0){
		foreach($release2_field_ids as $ProdId):
			if(isset($release2_Products[$ProdId])){
				$pos2_newreleases[] = $release2_Products[$ProdId];
			}
		endforeach;
	}
}

if(count($release3_field_ids) > 0){
	if(count($release3_Products) > 0){
		foreach($release3_field_ids as $ProdId):
			if(isset($release3_Products[$ProdId])){
				$pos3_newreleases[] = $release3_Products[$ProdId];
			}
		endforeach;
	}
}

if(count($release3_field_ids) > 0){
	if(count($release3_Products) > 0){
		foreach($release3_field_ids as $ProdId):
			if(isset($release3_Products[$ProdId])){
				$pos3_newreleases[] = $release3_Products[$ProdId];
			}
		endforeach;
	}
}

########################################## Heading Departments #############################
if(count($department1_field_ids) > 0){
	if(count($department1_Products) > 0){
		foreach($department1_field_ids as $ProdId):
			if(isset($department1_Products[$ProdId])){
				$pos1_dept_products[] = $department1_Products[$ProdId];
			}
		endforeach;
	}
}
if(count($department2_field_ids) > 0){
	if(count($department2_Products) > 0){
		foreach($department2_field_ids as $ProdId):
			if(isset($department2_Products[$ProdId])){
				$pos1_dept_products[] = $department2_Products[$ProdId];
			}
		endforeach;
	}
}
if(count($department3_field_ids) > 0){
	if(count($department3_Products) > 0){
		foreach($department3_field_ids as $ProdId):
			if(isset($department3_Products[$ProdId])){
				$pos3_dept_products[] = $department3_Products[$ProdId];
			}
		endforeach;
	}
}
if(count($department4_field_ids) > 0){
	if(count($department4_Products) > 0){
		foreach($department4_field_ids as $ProdId):
			if(isset($department4_Products[$ProdId])){
				$pos4_dept_products[] = $department4_Products[$ProdId];
			}
		endforeach;
	}
}
//pr($pos1_newreleases);
?>
<div class="row">
<?php // pr($pos1_newreleases);?>

<link rel="stylesheet" type="text/css" href="http://172.24.0.9:9441/css/resize/s9-widget-combined-min.css">
<?php   /******************** RELEASE 1 PRODUCTS  STARTS **************************************/
//pr($pos1_newreleases); exit;
if(!empty($pos1_newreleases)){ 	?>
<!--New Releases Start-->
<h4 class="mid-gr-head">
	<span>New Releases</span>
</h4>
<!--Products Widget Start-->
<div style="clear: left;width:100%;" class="amabot_center" id="centercol">
<script type="text/javascript" src="http://172.24.0.9:9441/js/resize/site-wide-13640146130.js"></script>
<script type="text/javascript">
	amznJQ.addLogical('ClientLogImpl', ["http://172.24.0.9:9441/js/resize/clog/clog-platform._V213973670_.js"]);
	var CLOG_Scaffold = {
	_spArgs : [], _sArgs : [], debugCallbacks : [],
	version : '1.0.1',
	sequenceID : 1,
	getSessionID : function() {
		return "177-0472960-6470558";
	},
	getRequestID : function() {
		return "0Y595RES16SQACSSFH67";
	},
	getMarketplaceID : function() {
		return "ATVPDKIKX0DER";
	},
	getBaseURL : function() {
		return "http://client-log.amazon.com/clog";
	},
	
	epoch : 0,
	
	debug: function(msg) {
		for( var i = 0; i < this.debugCallbacks.length; i++ ) {
		this.debugCallbacks[i](msg);
		}
	},
	addDebugCallback: function(func) {
		this.debugCallbacks.push(func);
	},
	sendPreparedCLOGEntry: function(clientId, namespace, params) {
		var args = new Array(clientId, namespace, params, (new Date()).getTime() );
		this._spArgs.push(args);
	
	},
	sendCLOGEntry: function(clientId, namespace, params) {
		var args = new Array(clientId, namespace, params, (new Date()).getTime() );
		this._sArgs.push(args);
	},
	initialize : function() {
		this.epoch = +new Date;
	}
	};
	
	if( window.CLOG_Scaffold  && !clientLogger ){ var clientLogger = CLOG_Scaffold; clientLogger.initialize(); }
	amznJQ.onReady('ClientLogImpl', function() {});
</script>

<!-- <div class="products-widget"> -->
<!-- 	<ul class="products"> -->
		<div class="row s9m4" id="ns_0Y595RES16SQACSSFH67_3642_r0ItemRow">
			<div class="s9OtherItems" id="ns_0Y595RES16SQACSSFH67_3642_r0OtherItems">
				<?php //foreach($pos1_newreleases as $pos1_newreleases[$i]) {
				for($i=0;$i< 6;$i++){
					if(!empty($pos1_newreleases[$i])){
						
					if($pos1_newreleases[$i]['Product']['product_image'] == 'no_image.gif' || $pos1_newreleases[$i]['Product']['product_image'] == 'no_image.jpeg'){
						$image_path = '/img/no_image.jpeg';
					} else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$pos1_newreleases[$i]['Product']['product_image'];
					}
					$rating = $common->displayProductRating($pos1_newreleases[$i]['Product']['avg_rating'],$pos1_newreleases[$i]['Product']['id']);
				?>
				<div class="fluid asin s9a<?php echo $i; ?>" id="ns_0Y595RES16SQACSSFH67_3642_r0ItemElement<?php echo $i; ?>" style="">
					<div class="inner">
						<div id="ns_0Y595RES16SQACSSFH67_3642_r0TitleContainer<?php echo $i; ?>" class="s9hl" style="position: relative;">
							<div id="ns_0Y595RES16SQACSSFH67_3642_r0Title<?php echo $i; ?>">
<!-- 								<li> -->
									<span id="ns_0Y595RES16SQACSSFH67_3644_r0ImageContainer<?php echo $i; ?>">
<!-- 									<p class="image-sec" style="min-height:87px;"> -->
										<?php  echo $html->link('<div class="imageContainer">'.$html->image($image_path,array('alt'=>"", 'id'=>"ns_0Y595RES16SQACSSFH67_3644_r0Image".$i,'style'=>"margin-top: 3px; margin-bottom: 2px;")).'</div>', '/categories/productdetail/'.$pos1_newreleases[$i]['Product']['id'],array('escape'=>false,));?>
<!-- 									</p> --><!--
									<p style="min-height:28px;">
										<?php //echo $html->link($format->formatString($pos1_newreleases[$i]['Product']['product_name'],40),'/categories/productdetail/'.$pos1_newreleases[$i]['Product']['id'],array('escape'=>false,));?>
									</p>
									<p class="star-rating">
										<span class="pad-rt pad-tp"><?php  //echo $rating; ?></span>
										<span class="price">
											<strong> <s><?php //echo CURRENCY_SYMBOL.$format->money($pos1_newreleases[$i]['Product']['product_rrp'],2);?> </s>
											</strong>
										</span>
									</p>-->
										<?php
										/*if(!empty($pos1_newreleases[$i]['Product']['minimum_price_value']) ){ 
											echo '<p><span >New from</span><span class="price-blue"> ';
											echo CURRENCY_SYMBOL.$format->money($pos1_newreleases[$i]['Product']['minimum_price_value'],2);
											echo '<span></p>';
										}
										if(!empty($pos1_newreleases[$i]['Product']['minimum_price_used']) ){
											echo '<p><span class="used-from">Used from</span><span class="price-blue">';
											echo CURRENCY_SYMBOL.$format->money($pos1_newreleases[$i]['Product']['minimum_price_used'],2);
											echo '</span></p>';
										}*/ ?>
									
<!-- 								</li> -->
							</div>
						</div>
					</div>
				</div>
				<?php }
				}?>
			</div>
		</div>
<!-- 	</ul> -->
<!-- </div> -->
</div>

		<script type="text/javascript">
			if (typeof S9Multipack == "undefined") {
			document.write('<scr' + 'ipt src="http://172.24.0.9:9441/js/resize/s9-multipack-min._V171170235_.js"></scr' + 'ipt>');
			}
		</script>
<!--Products Widget Closed-->
<!--New Releases Closed-->
<?php } /** ********************** RELEASE 1 PRODUCTS  STARTS ********************************/ ?>
</div>


<div class="row">
<?php
/** ********************** DEPARTMENT 1 PRODUCTS  STARTS  ********************************/
if(!empty($pos1_dept_products)) {?>
	<div class="pick-of-week">
		<h2 class="heading"><?php if(!empty($hm_products['HomepageProduct']['heading1'])) echo $hm_products['HomepageProduct']['heading1'];?></h2>
		<div class="products-widget">
			<!--Column One Start-->
			<?php
			for($w = 0;$w<2; $w++) {
			if(!empty($pos1_dept_products[$w])) { ?>
			<div class="colum-one">
				<div class="left-product-img">
				<?php 
				if($pos1_dept_products[$w]['Product']['product_image'] == 'no_image.gif' || $pos1_dept_products[$w]['Product']['product_image'] == 'no_image.jpeg'){
					$pos1_image_path1 = '/img/no_image.jpeg';
				} else{
					$pos1_image_path1 = '/'.PATH_PRODUCT.'small/img_100_'.$pos1_dept_products[$w]['Product']['product_image'];
				}
				echo $html->link($html->image($pos1_image_path1,array('alt'=>"")), '/categories/productdetail/'.$pos1_dept_products[$w]['Product']['id'],array('escape'=>false,));?>
				</div>
				<!--Right COntent Start-->
				<div class="left-product-content">
					<ul class="pick-of-week-content">
						<li>
						<p><?php echo $html->link('<strong>'.$pos1_dept_products[$w]['Product']['product_name'].'</strong>','/categories/productdetail/'.$pos1_dept_products[$w]['Product']['id'],array('escape'=>false,));?></p>	
						<?php  if(!empty($pos1_dept_products[$w]['Product']['minimum_price_value']) ){
							if($pos1_dept_products[$w]['Product']['product_rrp'] > $pos1_dept_products[$w]['Product']['minimum_price_value']){ //saving 
								$saving = ($pos1_dept_products[$w]['Product']['product_rrp'] - $pos1_dept_products[$w]['Product']['minimum_price_value']);
							}else{
								$saving = '';
							}
							$delivery_charges = $common->getDeliveryCharges($pos1_dept_products[$w]['Product']['id'],$pos1_dept_products[$w]['Product']['minimum_price_seller'], $pos1_dept_products[$w]['Product']['new_condition_id']);
							if($delivery_charges != ''){
								if($delivery_charges == '0.00'){
									$delivery = 'Free Delivery';
								}else{
									$delivery = "+&nbsp;".CURRENCY_SYMBOL.$delivery_charges."&nbsp;delivery";
								}
							}
						?>
							<p class="rates" >
							<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos1_dept_products[$w]['Product']['minimum_price_value'],2);  ?></strong></span>
							<span class="rate"><?php echo $delivery; ?></span>
							| RRP: <span class="yellow"><s><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos1_dept_products[$w]['Product']['product_rrp'],2);?></s>
								<?php if(!empty($saving)){?>
								( <?php	  echo $format->money($saving/$pos1_dept_products[$w]['Product']['product_rrp']*100,2);?> %)
								<?php } ?>
								</span>
							</p>
							<p>In stock <strong>New</strong> | Usually dispatched within 24 hours</p>
							<div class="button-widget float-left" >
							<?php echo $form->button('BUY',array('type'=>'button','class'=>'orange-btn','div'=>false,'escape'=>false,'onClick'=>'addToBasket('.$pos1_dept_products[$w]['Product']['id'].',1,'.$pos1_dept_products[$w]['Product']['minimum_price_value'].','.$pos1_dept_products[$w]['Product']['minimum_price_seller'].','.$pos1_dept_products[$w]['Product']['new_condition_id'].');')); ?>
							</div>
						
						<?php  } else if(!empty($pos1_dept_products[$w]['Product']['minimum_price_used']) ){
							
							if($pos1_dept_products[$w]['Product']['product_rrp'] > $pos1_dept_products[$w]['Product']['minimum_price_used']){ //saving 
								$saving = ($pos1_dept_products[$w]['Product']['product_rrp'] - $pos1_dept_products[$w]['Product']['minimum_price_used']);
							}else{
								$saving = '';
							}
							$delivery_charges = $common->getDeliveryCharges($pos1_dept_products[$w]['Product']['id'],$pos1_dept_products[$w]['Product']['minimum_price_used_seller'], $pos1_dept_products[$w]['Product']['used_condition_id']);
							if($delivery_charges != ''){
								if($delivery_charges == '0.00'){
									$delivery = 'Free Delivery';
								}else{
									$delivery = "+&nbsp;".CURRENCY_SYMBOL.$delivery_charges."&nbsp;delivery";
								}
							}
							
							?>
							<p class="rates">
							<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos1_dept_products[$w]['Product']['minimum_price_used'],2);  ?></strong></span>
							<span class="rate"><?php echo $delivery; ?></span>
							| RRP: <span class="yellow"><s><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos1_dept_products[$w]['Product']['product_rrp'],2);?></s>
								<?php if(!empty($saving)){?>
								( <?php	  echo $format->money($saving/$pos1_dept_products[$w]['Product']['product_rrp']*100,2);?> %)
								<?php } ?>
								</span>
							</p>
							<p>In stock <strong>Used</strong> | Usually dispatched within 24 hours</p>
							<div class="button-widget float-left">
							<?php echo $form->button('BUY',array('type'=>'button','class'=>'orange-btn','div'=>false,'escape'=>false,'onClick'=>'addToBasket('.$pos1_dept_products[$w]['Product']['id'].',1,'.$pos1_dept_products[$w]['Product']['minimum_price_used'].','.$pos1_dept_products[$w]['Product']['minimum_price_used_seller'].','.$pos1_dept_products[$w]['Product']['used_condition_id'].');')); ?>
							</div>
	
						<?php  } else{ ?>
							
							<p class="rates">
							<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos1_dept_products[$w]['Product']['product_rrp'],2);  ?></strong></span>
							</p>
							<!--Button Start-->
							<div class="button-widget float-left">
							<?php echo $form->button('BUY',array('type'=>'button','class'=>'orange-btn','div'=>false));?>
							</div>
						<?php  }  ?>
							<!--Button Closed-->
						</li>
					</ul>
				</div>
				<!--Right COntent Start-->
				<div class="clear"></div>
				<!--<p class="bottom-con">-->
				
				<?php //echo $pos1_dept_products[$w]['ProductDetail']['description'];?>
				<?php //echo $html->link('<strong>more &raquo;</strong>','/categories/productdetail/'.$pos1_dept_products[$w]['Product']['id'],array('escape'=>false,));?><!--</p>-->
			</div>
			<!--Column One Closed-->
			<?php }?>
			<?php }?>
		</div>
	</div>
<?php } /** ********************** DEPARTMENT 1 PRODUCTS  ENDS  ********************************/ ?>



<?php
/** ********************** NEWRELASE 2 PRODUCTS  STARTS  ********************************/ 
if(!empty($pos2_newreleases)){
?>
<!--New Releases Start-->
<h4 class="mid-gr-head">
	<span>New Releases</span>
</h4>
<!--Products Widget Start-->
<div class="products-widget">
	<ul class="products">
		<?php //foreach($pos2_newreleases as $pos2_newreleases[$j]) {
			for($j=0;$j<4;$j++){

			if(!empty($pos2_newreleases[$j])){
				$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$pos2_newreleases[$j]['Product']['product_image'];
			if($pos2_newreleases[$j]['Product']['product_image'] != 'no_image.gif' && file_exists($image_path)  ){
				$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$pos2_newreleases[$j]['Product']['product_image'];
			} else{
				$image_path = '/img/no_image.jpg';
			}
			
			$rating = $common->displayProductRating($pos2_newreleases[$j]['Product']['avg_rating'],$pos2_newreleases[$j]['Product']['id']);
		?>
		<li>
			<p class="image-sec" style="min-height:109px;">
				<?php echo $html->link($html->image($image_path,array('alt'=>"")), '/categories/productdetail/'.$pos2_newreleases[$j]['Product']['id'],array('escape'=>false,));?>
			</p>
			<p style="min-height:28px;">
				<?php echo $html->link($format->formatString($pos2_newreleases[$j]['Product']['product_name'],40),'/categories/productdetail/'.$pos2_newreleases[$j]['Product']['id'],array('escape'=>false,));?>
			</p>
			<p class="star-rating">
				<span class="pad-rt pad-tp"><?php  echo $rating; ?></span>
				<span class="price">
					<strong> <s><?php echo CURRENCY_SYMBOL.$format->money($pos2_newreleases[$j]['Product']['product_rrp'],2);?> </s>
					</strong>
				</span>
			</p>
			<p>	<?php
				if(!empty($pos2_newreleases[$j]['Product']['minimum_price_value']) ){ 
					echo '<p><span >New from</span><span class="price-blue"> ';
					echo CURRENCY_SYMBOL.$format->money($pos2_newreleases[$j]['Product']['minimum_price_value'],2);
					echo '<span></p>';
				}
				if(!empty($pos2_newreleases[$j]['Product']['minimum_price_used']) ){
					echo '<p><span class="used-from">Used from</span><span class="price-blue">';
					echo CURRENCY_SYMBOL.$format->money($pos2_newreleases[$j]['Product']['minimum_price_used'],2);
					echo '</span></p>';
				} ?>
			</p>
		</li>
		<?php }
		}?>
	</ul>
</div>
<!--Products Widget Closed-->
<!--New Releases Closed-->
<?php } /** ********************** NEWRELASE 2 PRODUCTS  ENDS HERER********************************/ ?>
</div>



<div class="row">
<?php  /** ********************** DEPARTMENT 2 PRODUCTS  STARTS  ********************************/ 
if(!empty($pos2_dept_products)) {?>
	<div class="pick-of-week">
		<h2 class="heading"><?php if(!empty($hm_products['HomepageProduct']['heading2'])) echo $hm_products['HomepageProduct']['heading2'];?></h2>
		<div class="products-widget">
			<!--Column One Start-->
			<?php for($w = 0;$w<2; $w++) {
			if(!empty($pos2_dept_products[$w])) { ?>
			<div class="colum-one">
				<div class="left-product-img">
				<?php 
				if($pos2_dept_products[$w]['Product']['product_image'] == 'no_image.gif' || $pos2_dept_products[$w]['Product']['product_image'] == 'no_image.jpeg'){
					$pos1_image_path1 = '/img/no_image.jpeg';
				} else{
					$pos1_image_path1 = '/'.PATH_PRODUCT.'/small/img_100_'.$pos2_dept_products[$w]['Product']['product_image'];
				}
				echo $html->link($html->image($pos1_image_path1,array('alt'=>"")), '/categories/productdetail/'.$pos2_dept_products[$w]['Product']['id'],array('escape'=>false,));?>
				</div>
				<!--Right COntent Start-->
				<div class="left-product-content">
					<ul class="pick-of-week-content">
						<li>
						<p><?php echo $html->link('<strong>'.$pos2_dept_products[$w]['Product']['product_name'].'</strong>','/categories/productdetail/'.$pos2_dept_products[$w]['Product']['id'],array('escape'=>false,));?></p>	
						<?php  if(!empty($pos2_dept_products[$w]['Product']['minimum_price_value']) ){
							if($pos2_dept_products[$w]['Product']['product_rrp'] > $pos2_dept_products[$w]['Product']['minimum_price_value']){ //saving 
								$saving = ($pos2_dept_products[$w]['Product']['product_rrp'] - $pos2_dept_products[$w]['Product']['minimum_price_value']);
							}else{
								$saving = '';
							}
							$delivery_charges = $common->getDeliveryCharges($pos2_dept_products[$w]['Product']['id'],$pos2_dept_products[$w]['Product']['minimum_price_seller'], $pos2_dept_products[$w]['Product']['new_condition_id']);
							if($delivery_charges != ''){
								if($delivery_charges == '0.00'){
									$delivery = 'Free Delivery';
								}else{
									$delivery = "+&nbsp;".CURRENCY_SYMBOL.$delivery_charges."&nbsp;delivery";
								}
							}
						?>
							<p class="rates" >
							<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos2_dept_products[$w]['Product']['minimum_price_value'],2);  ?></strong></span>
							<span class="rate"><?php echo $delivery; ?></span>
							| RRP: <span class="yellow"><s><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos2_dept_products[$w]['Product']['product_rrp'],2);?></s>
								<?php if(!empty($saving)){?>
								( <?php	  echo $format->money($saving/$pos2_dept_products[$w]['Product']['product_rrp']*100,2);?> %)
								<?php } ?>
								</span>
							</p>
							<p>In stock <strong>New</strong> | Usually dispatched within 24 hours</p>
							<div class="button-widget float-left" >
							<?php echo $form->button('BUY',array('type'=>'button','class'=>'orange-btn','div'=>false,'escape'=>false,'onClick'=>'addToBasket('.$pos2_dept_products[$w]['Product']['id'].',1,'.$pos2_dept_products[$w]['Product']['minimum_price_value'].','.$pos2_dept_products[$w]['Product']['minimum_price_seller'].','.$pos2_dept_products[$w]['Product']['new_condition_id'].');')); ?>
							</div>
						
						<?php  } else if(!empty($pos2_dept_products[$w]['Product']['minimum_price_used']) ){
							
							if($pos2_dept_products[$w]['Product']['product_rrp'] > $pos2_dept_products[$w]['Product']['minimum_price_used']){ //saving 
								$saving = ($pos2_dept_products[$w]['Product']['product_rrp'] - $pos2_dept_products[$w]['Product']['minimum_price_used']);
							}else{
								$saving = '';
							}
							$delivery_charges = $common->getDeliveryCharges($pos2_dept_products[$w]['Product']['id'],$pos2_dept_products[$w]['Product']['minimum_price_used_seller'], $pos2_dept_products[$w]['Product']['used_condition_id']);
							if($delivery_charges != ''){
								if($delivery_charges == '0.00'){
									$delivery = 'Free Delivery';
								}else{
									$delivery = "+&nbsp;".CURRENCY_SYMBOL.$delivery_charges."&nbsp;delivery";
								}
							}
							
							?>
							<p class="rates">
							<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos2_dept_products[$w]['Product']['minimum_price_used'],2);  ?></strong></span>
							<span class="rate"><?php echo $delivery; ?></span>
							| RRP: <span class="yellow"><s><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos2_dept_products[$w]['Product']['product_rrp'],2);?></s>
								<?php if(!empty($saving)){?>
								( <?php	  echo $format->money($saving/$pos2_dept_products[$w]['Product']['product_rrp']*100,2);?> %)
								<?php } ?>
								</span>
							</p>
							<p>In stock <strong>Used</strong> | Usually dispatched within 24 hours</p>
							<div class="button-widget float-left">
							<?php echo $form->button('BUY',array('type'=>'button','class'=>'orange-btn','div'=>false,'escape'=>false,'onClick'=>'addToBasket('.$pos2_dept_products[$w]['Product']['id'].',1,'.$pos2_dept_products[$w]['Product']['minimum_price_used'].','.$pos2_dept_products[$w]['Product']['minimum_price_used_seller'].','.$pos2_dept_products[$w]['Product']['used_condition_id'].');')); ?>
							</div>
	
						<?php  } else{ ?>
							
							<p class="rates">
							<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos2_dept_products[$w]['Product']['product_rrp'],2);  ?></strong></span>
							</p>
							<p>Out stock </p>
							<!--Button Start-->
							<div class="button-widget float-left">
							<?php echo $form->button('BUY',array('type'=>'button','class'=>'orange-btn','div'=>false));?>
							</div>
						<?php  }  ?>
							<!--Button Closed-->
						</li>
					</ul>
				</div>
				<!--Right COntent Start-->
				<div class="clear"></div>
				<p class="bottom-con">
				<?php echo strip_tags($pos2_dept_products[$w]['ProductDetail']['description']);?>
				<?php echo $html->link('<strong>more &raquo;</strong>','/categories/productdetail/'.$pos2_dept_products[$w]['Product']['id'],array('escape'=>false,));?></p>
			</div>
			<!--Column One Closed-->
			<?php }?>
			<?php }?>
		</div>
	</div>
<?php } /** ********************** DEPARTMENT 2 PRODUCTS  ENDS  ********************************/ ?>

<?php  /** ********************** NEWRELASE 3 PRODUCTS  STARTS********************************/ 
if(!empty($pos3_newreleases)){
?>
<!--New Releases Start-->
<h4 class="mid-gr-head">
	<span>New Releases</span>
</h4>
<!--Products Widget Start-->
<div class="products-widget">
	<ul class="products">
		<?php //foreach($pos3_newreleases as $pos3_newreleases[$k]) {
		for($k=0;$k<4;$k++){
			if(!empty($pos3_newreleases[$k])){
			if($pos3_newreleases[$k]['Product']['product_image'] == 'no_image.gif' || $pos3_newreleases[$k]['Product']['product_image'] == 'no_image.jpeg'){
				$image_path = '/img/no_image.jpeg';
			} else{
				$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$pos3_newreleases[$k]['Product']['product_image'];
			}
			$rating = $common->displayProductRating($pos3_newreleases[$k]['Product']['avg_rating'],$pos3_newreleases[$k]['Product']['id']);
				
		?>
		<li>
			<p class="image-sec" style="min-height:103px;">
				<?php echo $html->link($html->image($image_path,array('alt'=>"" )), '/categories/productdetail/'.$pos3_newreleases[$k]['Product']['id'],array('escape'=>false,));?>
			</p>
			<p style="min-height:28px;">
			<?php echo $html->link($format->formatString($pos3_newreleases[$k]['Product']['product_name'],40),'/categories/productdetail/'.$pos3_newreleases[$k]['Product']['id'],array('escape'=>false,));?>
			</p>
			<p class="star-rating">
				<span class="pad-rt pad-tp"><?php  echo $rating; ?></span>
				<span class="price">
					<strong> <s><?php echo CURRENCY_SYMBOL.$format->money($pos3_newreleases[$k]['Product']['product_rrp'],2);?> </s>
					</strong>
				</span>
			</p>
				<?php
				if(!empty($pos3_newreleases[$k]['Product']['minimum_price_value']) ){ 
					echo '<p><span >New from</span><span class="price-blue"> ';
					echo CURRENCY_SYMBOL.$format->money($pos3_newreleases[$k]['Product']['minimum_price_value'],2);
					echo '<span></p>';
				}
				if(!empty($pos3_newreleases[$k]['Product']['minimum_price_used']) ){
					echo '<p><span class="used-from">Used from</span><span class="price-blue">';
					echo CURRENCY_SYMBOL.$format->money($pos3_newreleases[$k]['Product']['minimum_price_used'],2);
					echo '</span></p>';
				} ?>
			
		</li>
		<?php }
		}?>
	</ul>
</div>
<!--Products Widget Closed-->
<!--New Releases Closed-->
<?php } /** ********************** NEWRELASE 3 PRODUCTS  ENDS HERER********************************/ ?>
</div>


<?php /** ********************** DEPARTMENT 3 PRODUCTS  STARTS ********************************/ ?>
<?php
if(!empty($pos3_dept_products)) {?>
<!--Home & Garden Start-->
<div class="row">
	<h2 class="heading"><?php if(!empty($hm_products['HomepageProduct']['heading3'])) echo $hm_products['HomepageProduct']['heading3'];?></h2>
	<!--Products Widget Start-->
	<div class="products-widget">
		
		<ul class="products">
			<?php //foreach($pos3_dept_products[$x]s as $pos3_dept_products[$x]){ 
				for($x=0; $x<4; $x++){
				if(!empty($pos3_dept_products[$x])){
			?>
			<li>
				<p class="image-sec" style="height:109px;"><?php 
					if($pos3_dept_products[$x]['Product']['product_image'] == 'no_image.gif' || $pos3_dept_products[$x]['Product']['product_image'] == 'no_image.jpeg'){
						$pos3_image_path = '/img/no_image.jpeg';
					} else{
						$pos3_image_path = '/'.PATH_PRODUCT.'small/img_100_'.$pos3_dept_products[$x]['Product']['product_image'];
					}
					$pos3_imagePath = WWW_ROOT.$pos3_image_path;
				$rating = $common->displayProductRating($pos3_dept_products[$x]['Product']['avg_rating'],$pos3_dept_products[$x]['Product']['id']);
				echo $html->link($html->image($pos3_image_path,array('alt'=>"")), '/categories/productdetail/'.$pos3_dept_products[$x]['Product']['id'],array('escape'=>false,));?></p>
				<p style="height:28px">
				<?php echo $html->link($format->formatString($pos3_dept_products[$x]['Product']['product_name'],40),'/categories/productdetail/'.$pos3_dept_products[$x]['Product']['id'],array('escape'=>false,));?></p>
				
				
				<p class="star-rating">
					<span class="pad-rt pad-tp"><?php  echo $rating; ?></span>
					<span class="price">
						<strong> <s><?php echo CURRENCY_SYMBOL.$format->money($pos3_dept_products[$x]['Product']['product_rrp'],2);?> </s>
						</strong>
					</span>
				</p>
				<?php
				if(!empty($pos3_dept_products[$x]['Product']['minimum_price_value']) ){ 
					echo '<p><span >New from</span><span class="price-blue"> ';
					echo CURRENCY_SYMBOL.$format->money($pos3_dept_products[$x]['Product']['minimum_price_value'],2);
					echo '<span></p>';
				}
				if(!empty($pos3_dept_products[$x]['Product']['minimum_price_used']) ){
					echo '<p><span class="used-from">Used from</span><span class="price-blue">';
					echo CURRENCY_SYMBOL.$format->money($pos3_dept_products[$x]['Product']['minimum_price_used'],2);
					echo '</span></p>';
				} ?>
				
			</li>
			<?php } }?>
		</ul>
		
	</div>
	<!--Products Widget Closed-->
</div>
<!--Home & Garden Closed-->
<?php } ?>
<?php /** ********************** DEPARTMENT 3 PRODUCTS  ENDS **********************************/ ?>

<?php /** ********************** DEPARTMENT 4 PRODUCTS  STARTS ********************************/ ?>
<?php
if(!empty($pos4_dept_products)) {?>
<!--Home & Garden Start-->
<div class="row">
	<h2 class="heading"><?php if(!empty($hm_products['HomepageProduct']['heading4'])) echo $hm_products['HomepageProduct']['heading4'];?></h2>
	<!--Products Widget Start-->
	<div class="products-widget">
		
		<ul class="products">
			<?php //foreach($pos4_dept_products[$y]s as $pos4_dept_products[$y]){ 
			for($y=0; $y<4; $y++){
				if(!empty($pos4_dept_products[$y])){
			?>
			<li>
				<p class="image-sec" style="height:109px;"><?php 
					if($pos4_dept_products[$y]['Product']['product_image'] == 'no_image.gif' || $pos4_dept_products[$y]['Product']['product_image'] == 'no_image.jpeg'){
						$pos3_image_path = '/img/no_image.jpeg';
					} else{
						$pos3_image_path = '/'.PATH_PRODUCT.'small/img_100_'.$pos4_dept_products[$y]['Product']['product_image'];
					}
					$pos3_imagePath = WWW_ROOT.$pos3_image_path;
					$rating = $common->displayProductRating($pos4_dept_products[$y]['Product']['avg_rating'],$pos4_dept_products[$y]['Product']['id']);
					echo $html->link($html->image($pos3_image_path,array('alt'=>"")), '/categories/productdetail/'.$pos4_dept_products[$y]['Product']['id'],array('escape'=>false,));?></p>
				<p style="height:28px"><?php echo $html->link($format->formatString($pos4_dept_products[$y]['Product']['product_name'],40),'/categories/productdetail/'.$pos4_dept_products[$y]['Product']['id'],array('escape'=>false,));?></p>
				<p class="star-rating">
					<span class="pad-rt pad-tp"><?php  echo $rating; ?></span>
					<span class="price">
						<strong> <s><?php echo CURRENCY_SYMBOL.$format->money($pos4_dept_products[$y]['Product']['product_rrp'],2);?> </s>
						</strong>
					</span>
				</p>
					<?php
					if(!empty($pos4_dept_products[$y]['Product']['minimum_price_value']) ){ 
						echo '<p><span >New from</span><span class="price-blue"> ';
						echo CURRENCY_SYMBOL.$format->money($pos4_dept_products[$y]['Product']['minimum_price_value'],2);
						echo '<span></p>';
					}
					if(!empty($pos4_dept_products[$y]['Product']['minimum_price_used']) ){
						echo '<p><span class="used-from">Used from</span><span class="price-blue">';
						echo CURRENCY_SYMBOL.$format->money($pos4_dept_products[$y]['Product']['minimum_price_used'],2);
						echo '</span></p>';
					} ?>
				
			</li>
			<?php } }?>
		</ul>
		
	</div>
	<!--Products Widget Closed-->
</div>
<!--Home & Garden Closed-->
<?php } ?>
<?php /** ********************** DEPARTMENT 4 PRODUCTS  ENDS **********************************/ ?>
