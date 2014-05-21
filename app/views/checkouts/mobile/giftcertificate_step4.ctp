<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);?>
<!--Content Start-->
<!--Main Content Starts--->
             <section class="maincont nopadd">
                <section class="prdctboxdetal margin-top">
                	<h4 class="diff-blu">Checkout Choiceful: Swift, Simple & Secure</h4>
                    <h4 class="orng-clr"><span class="gray-color">Step 3 of 3</span> Order Confirmation</h4>
                    
                    
                    <!--Thanks Start-->
                    <div class="thanks-widget">
                      <p><strong>Thank you for your order.</strong></p>
                      <p>We will send you an e-mail confirmation shortly.</p>
                    </div>
                    <!--Thanks Closed-->
                    
                    <!--Listing Start-->
                      <ul class="listing font11">
			<li>	<strong>
					Your order number is: 
					<?php $order_is = $this->Session->read('giftcertificate_orderId');
					 if(!empty($order_is)) echo $order_is?>
                        	</strong>
                        </li>
                        <li>
                            <p><strong>Your Transaction ID is:</strong></p>
                            <p><strong><?php  if(!empty($trans_is)) echo $trans_is; ?></strong></p>
                        </li>
                       </ul>
                       <!--Listing Closed-->
                        
                   
                  <!--Checkout info Start-->
                    <ul class="chkout_info border-top-dashed">
                      <li>
                      	<p>Subject to final confirmation for your credit card and product availability it will be emailed to the following:</p>
                      	
                      	<?php  foreach($users as $user){?>
				<div class="row padding5">
					<div class="arrow_div">
						<?php echo $html->image("checkout/d-arrow-icon-red.png" ,array('width'=>"7",'height'=>"7", 'alt'=>"" )); ?>
					</div>
					<div class="chk_info font11">
						<p><?php echo $user;?></p>
					</div>
				
				</div>
                         <?php }?>
                         
                      </li>
                        
                      <li class="brdr-none buttons-widget padding-top15">
                      
                            <p>
                            	<?php //echo $html->link($form->button('Print business tax invoice',array('type'=>'button','class'=>'signinbtnwhyt cntnuchkot','div'=>false, 'style'=>'cursor:pointer;cursor:hand')),'#',array('escape'=>false));?>
                            	<!--<input type="button" align="left" value="Print business tax invoice" class="signinbtnwhyt cntnuchkot">-->
                            </p>
                            
                            <p>
                            	<?php echo $html->link($form->button('Continue to Homepage',array('type'=>'button','class'=>'signinbtnwhyt cntnuchkot','div'=>false, 'style'=>'cursor:pointer;cursor:hand')),'/',array('escape'=>false));?>
                            	<!--<input type="button" align="left" value="Continue to Homepage" class="signinbtnwhyt cntnuchkot">-->
                            </p>
                        </li>
                    </ul>
                    <!--Checkout info Closed-->
                    
                </section>
             </section>
          <!--Main Content End--->
          <!--Navigation Starts-->
             <nav class="nav">
                 <ul class="maincategory yellowlist">
                         <?php echo $this->element('mobile/nav_footer');?>
                      </ul>
             </nav>              
          <!--Navigation End-->
<!--Content Closed-->
<?php $this->Session->delete('giftcertificate_orderId'); $this->Session->delete('giftcertificate_tranx_id'); ?>