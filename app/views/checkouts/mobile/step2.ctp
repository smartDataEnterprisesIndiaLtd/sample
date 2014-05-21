<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);?>

<script type="text/javascript" language="javascript">
function giftname(values,loopName){
	if(values=='yes'){
		document.getElementById('gftnote'+loopName).style.display = 'block';
	}else{
		document.getElementById('gftnote'+loopName).style.display = 'none';
	}
}
//jQuery(document).ready(function(){
//	
//});
</script>
<style>
.cntnuchkot{
	width:150px;
}
</style>

 <!--Main Content Starts--->
             <section class="maincont nopadd">
			<?php
			if ($session->check('Message.flash')){ ?>
				<div class="messageBlock">
				<?php echo $session->flash();?>
				</div>
			<?php } ?>
                <section class="prdctboxdetal">
                	<h4 class="diff-blu">Checkout Choiceful: Swift, Simple & Secure</h4>
                    <h4 class="orng-clr"><span class="gray-color">Step 2 of 5</span> Gift-Wrap</h4>
                    <p class="lgtgray applprdct">Select the products you would like to Gift-Wrap. Please note not all sellers offer gift options.</p>
                    <?php echo $form->create("Checkout", array('action'=>'step2','default' => true,'name'=>'frmCheckout'));?>
                    
                    <section class="prdctchkot">
                    
                    <?php
			if(is_array($cData)  && count($cData) > 0){
				$i=0;
			    foreach($cData as $cart){
			    $i++;
				$prodId = $cart['Basket']['product_id'];
				$cartId = $cart['Basket']['id'];
				$sellerInfo = $this->Common->getsellerInfo($cart['Basket']['seller_id']);
				
				$prodSellerInfo = $common->getProductSellerInfo($prodId,$cart['Basket']['seller_id'], $cart['Basket']['condition_id'] );
				$totalQty = $prodSellerInfo['ProductSeller']['quantity'];
				if($totalQty <= 0){
					continue;
				}
						
				if($sellerInfo['Seller']['gift_service'] == 1) { // if gift service provided
					
					$loopName = "Product$cartId";
					
					echo $form->hidden("$loopName.cartid", array('value'=>$cartId) );
					
					if($this->data[$loopName][$prodId] == 'yes' || strtolower($cart['Basket']['giftwrap']) == 'yes' ){
						$gschecked_y = "checked=checked";
						$gschecked_n = "";
					}else{
						$gschecked_y = '';
						$gschecked_n = "checked=checked";
					}
					
					#########
					if(strtolower($cart['Basket']['giftwrap']) == 'yes'){  
						//$gw_message_arr = array();
						$gw_message_arr[0] =''; $gw_message_arr[1] = ''; $gw_message_arr[2] = ''; $gw_message_arr[3] = '';
						$gw_message =  $cart['Basket']['giftwrap_message'];
						$gw_message_arr = explode("#--#",$gw_message ) ;
						//pr($gw_message_arr);
						if(empty($gw_message_arr[0]) ){ $gw_message_arr[0] = '';}
						if(empty($gw_message_arr[1]) ){ $gw_message_arr[1] = '';}
						if(empty($gw_message_arr[2]) ){ $gw_message_arr[2] = '';}
						if(empty($gw_message_arr[3]) ){ $gw_message_arr[3] = '';}
						
					}else{
						$gw_message_arr[0] = $gw_message_arr[1] = $gw_message_arr[2] = $gw_message_arr[3] = '';
					}
					
					##########
				?>
                    		<?php 
                    		if($i==1){
					$className='chktlst2';
					}else{
					$className='chktlst2 toppadd';
				}
                    		?>
                    	
                        <ul class="<?php echo $className;?>">
                           <li class="boldr chkthdng">
                           <?php echo  $html->link($cart['Product']['product_name'],'/'.$this->Common->getProductUrl(@$prodId).'/categories/productdetail/'.@$prodId,array('escape'=>false,'class'=>"underline-link"));?>
                           
                           <?php //echo $cart['Product']['product_name'] ;?></li>
                           <li>
                           	<div class="gftwrplft">
                           	<input <?php echo $gschecked_n; ?> type="radio" checked="checked" value="no" name="data[<?=$loopName?>][giftwrap]" id="data[<?=$loopName?>][giftwrap]" onChange="giftname(this.value,'<?php echo $loopName?>')"  />
                           </div>
                           <div class="gftwrprgt"><span>Don't gift-wrap this item.</span></div></li>
                           <li><div class="gftwrplft">
                           	<input <?php echo $gschecked_y; ?> type="radio" value="yes" name="data[<?=$loopName?>][giftwrap]" id="data[<?=$loopName?>][giftwrap]" onChange="giftname(this.value,'<?php echo $loopName?>')" />
                           </div>
                           <div class="gftwrprgt"><span>Gift-wrap this item. Please Note: Large or irregular-shaped items may be placed in a gift-bag - &pound;0.95</span>
                                <div class="gftnote" id="gftnote<?php echo $loopName?>">
                                   Enter your free gift note for this item here:
                                   <p><?php echo $form->input("$loopName.message1",array('value'=>$gw_message_arr[0],'maxlength'=>'50','class'=>'form-textfield smallr-width','label'=>false,'div'=>false));?></p>
                                   <p><?php echo $form->input("$loopName.message2",array('value'=>$gw_message_arr[1],'maxlength'=>'50','class'=>'form-textfield smallr-width','label'=>false,'div'=>false));?></p>
                                   <p><?php echo $form->input("$loopName.message3",array('value'=>$gw_message_arr[2],'maxlength'=>'50','class'=>'form-textfield smallr-width','label'=>false,'div'=>false));?></p>
                                   <p><?php echo $form->input("$loopName.message4",array('value'=>$gw_message_arr[3],'maxlength'=>'50','class'=>'form-textfield smallr-width','label'=>false,'div'=>false));?></p>  
                                   <p class="checkcenter" style="width:220px; text-align:justify;">Your message will be formatted and printed on a gift card. Prices for these gifts will not appear on the delivery note.</p>
                             </div>
			     </div>
			    
			     </li>
			</ul>
                           	<?php } else{  // else show the service not available 	?>
				
				<?php 
                    		if($i==1){
					$className='chktlst2';
					}else{
					$className='chktlst2 toppadd';
				}
                    		?>
				<ul class="<?php echo $className;?>">
                           	<li>
				<div class="checkout-pro-widget chkthdng">
					<p><strong><?php echo  $html->link($cart['Product']['product_name'],'/'.$this->Common->getProductUrl(@$prodId).'/categories/productdetail/'.@$prodId,array('escape'=>false,'class'=>"underline-link"));?></strong>
					    <span class="red-color padding-left">
					     <?php echo $html->image('checkout/gift-icon.gif',  array('width'=>13, 'height'=>13, 'alt'=>'', 'class'=>'v-align-middle' ) );?>
					    <strong>Not available</strong>
					    </span></p>
					<p><span class="sml-fnt"><strong>Seller</strong></span> <?php echo $sellerInfo['Seller']['business_display_name'] ;?> does not offer a gift-wrapping service</p>
				</div>
				</li>
				</ul>
				<?php } ?>
				
			<?php if(count($cData)!=$i){?>
				<div class="dsdbrdr"></div>
		        <?php }?>
				
                         <?php  }
			 //Close for loop
			 } ?>
                         <ul class="chktlst2">
                           <li><!--<input type="button" class="signinbtnwhyt cntnuchkot" value="Continue">-->
				<?php  echo $form->submit('Continue',  array('type'=>'submit', 'name'=>'button2', 'class' => 'signinbtnwhyt cntnuchkot') ); ?>
			</li>
			 <li>&nbsp;</li>
                        </ul>
                     </section>
                     <?php echo $form->end(); ?>
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
<!--Content Closed-->
