<?php
//echo $javascript->link(array('jquery-1.3.2.min','lib/prototype','MultiFile'),false);
echo $javascript->link(array('jquery-1.9'));
echo $javascript->link(array('jquery.MultiFile'));
echo $javascript->link(array('behaviour','textarea_maxlen'));
?>



<!--mid Content Start-->
<div class="mid-content pad-rt-none inc-pad">
        	
        <?php echo $form->create('Marketplace',array('action'=>'create_product_step3','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace','enctype'=>'multipart/form-data'));?>    
            <!--Setting Tabs Widget Start-->
	<!--- <?php echo $this->element('marketplace/breadcrum'); ?> --->
          <div class="row-widget">
            
           	  <!--Tabs Widget Start-->
          		<?php echo $this->element('navigations/seller_heading_bar'); ?>
                <!--Tabs Widget Closed-->
                
                <!--Tabs Content Start-->
          		<div class="tabs-content">
                 <!--Choice Headding Start-->
                	<h2 class="choice_headding choiceful">Create New Product Listings</h2>
                 <!--Choice Headding Closed-->
                  <!--Discription Start-->
                  <div class="inner-content no_padd">
                    <p>Finally, complete the rest of your listing. Don't worry if you do not have this information as it's optional. However, adding information here improve the customers understanding of your product.</p>
                    <h4 class="choice_headding choiceful">Please enter as much product information as possible.</h4>
                    <p>You will not be able to edit this information later. Please ensure you are accurate with your details. The information you provide here may appear on the product detail page and will be used to help customers find this product in search results. Please supply as much specific detail as possible.</p>
                    <h4 class="ornge-cl-head">Step 3 of 3</h4>
                  </div>
                 <!--Discription Closed-->
                 
		<?php
		if(!empty($errors) || $this->Session->read('image_error') != ''){
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }?>
               	<!--Sample Bot Row Srart-->
                 <div class="department_selection_69">
                 	<ul>
                        <li>
                           <label class="red">Image:</label>
                            <div style="position: relative;" class="right_value">
				<!--<input name ="data[Product][product_image][]"  type="file" class="multi" accept="gif|jpg|jpeg" maxlength="4"/>-->
				<?php
					//if($session->check('image_error')){
					if($this->Session->read('image_error') != ''){
						$errorImage ='multi error_message_box';
					}else{
						$errorImage ='multi';
					}
				?>
				 <input name ="data[Product][product_image][]"  type="file" class="<?php echo $errorImage;?>" style="width:202px;" maxlength="4"/>
                             <!--<input type="text" class="medium"/><input type="file" class="file-input" size="2" name="fileField"/><img alt="" src="../img/browse_btn.gif"/>-->
				<?php //echo $form->input('Product.photo',array('class'=>'multi','accept'=>'gif|jpg','maxlength'=>'4', 'label'=>false,'div'=>false,'error'=>false,'type' => 'file'));?>
				<!--div class="error-message">
					<?php // display session error message
					//if ($session->check('image_error')){ 
						 //echo $session->read('image_error');
					//}
					?>
				</div-->
			    <span style="margin-top:6px;">Upload up to 4 product images.Only "GIF/JPEG/JPG" images are allowed.</span>
			    </div>
			    
                        </li>
                        <li>
                            <label>Key Features:</label>
                            <?php echo $form->input('ProductDetail.product_features1',array('maxlength'=>'100','class'=>'medium','label'=>false,'div'=>false));			    ?>
			    <span>Displayed on the product page and to aid search terms. Details about the product in short easy-to-read bullet format.</span>
                        </li>
                        <li>
                        	<label> </label> <div class="right_value">
				<?php	echo $form->input('ProductDetail.product_features2',array('maxlength'=>'100','class'=>'medium','label'=>false,'div'=>false));?>
					<span class="inc-mid">(Maximum 100 Characters perline)</span></div>
                        </li>
                        <li>
                        	<label> </label> <div class="right_value">
				<?php echo $form->input('ProductDetail.product_features3',array('maxlength'=>'100','class'=>'medium','label'=>false,'div'=>false));?>
				</div>
                        </li>
                        <li>
                        	<label> </label><?php echo $form->input('ProductDetail.product_features4',array('maxlength'=>'100','class'=>'medium','label'=>false,'div'=>false));?> 
                        </li>
                        
                        <li>
                        	<label class="red inc-top">Product Description:</label>
				<div class="right_value">
					<?php
						if(!empty($errors['description'])){
							$errorDescription ='textbox-l error_message_box';
						}else{
							$errorDescription ='textbox-l';
						}
					echo $form->input('ProductDetail.description',array('maxlength'=>'5000',  'rows'=>'5' , 'class'=>$errorDescription,'label'=>false,'div'=>false,'error'=>false));?>
					<div> &nbsp;&nbsp; Detaling the product in general. There is a 5,000 character limit.</div>
				</div>
                        </li>
                         <li>
                        	<label>Product Weight:</label>
				<?php echo $form->input('ProductDetail.product_weight',array('maxlength'=>'12','class'=>'very_small','label'=>false,'div'=>false));?>
				<div class="inc-mid">Boxed product weight in grams(g)</div>
                        </li>
                         <li>
                        	<label>Boxed Dimensions</label> 
                        </li>
                         <li>
                        	<label>Height(cm):</label>
				<?php echo $form->input('ProductDetail.product_height',array('maxlength'=>'12','type'=>'text','class'=>'very_small','label'=>false,'div'=>false));?>
                        </li>
                        <li>
                        	<label>Width(cm):</label>
				<?php echo $form->input('ProductDetail.product_width',array('maxlength'=>'12','type'=>'text','class'=>'very_small','label'=>false,'div'=>false));?>
                        </li>
                        <li>
                        	<label>Length(cm):</label>
				<?php echo $form->input('ProductDetail.product_length',array('maxlength'=>'12','type'=>'text','class'=>'very_small','label'=>false,'div'=>false));?>
                        </li>
                        
                         <li>
                            <label class="red">Search Terms/Tags:</label>
                            <div class="right_value">
			    <?php
			    if(!empty($errors['product_searchtag'])){
					$errorProductSearchtag ='medium error_message_box';
				}else{
					$errorProductSearchtag ='medium';
				}
			    echo $form->input('ProductDetail.product_searchtag',array('maxlength'=>'1000','type'=>'text', 'class'=>$errorProductSearchtag,'label'=>false,'div'=>false,'error'=>false));?>
                                <div class="clearer">Help customers find your products. Separate key-words relating to your product with commas,
                            	<span>Additional tags may be added by other users on choiceful.com</span>
                            </div></div>
                        </li>
                
                    </ul>
                    <br/>
                 <!--Discription Start-->
               		<p class="discription">Next enter your selling price, quantity and delivery information.</p>
                 <!--Discription Close-->
                 </div>
                 <!--Sample Bot Row Closed-->
                
                 <!--Sample Bot Row Srart-->
		  <div class="sample_bot_row">
                 	<span class="orange-sml-btn">
				<!--input type="button" alt="" class="orange-back" value="Back" onclick="history.back();" /-->
				<a href="<?php echo $_SERVER['HTTP_REFERER'];?>"><input type="button" alt="" class="orange-back" value="Back" /></a>
			</span>
			<?php echo $form->button('',array('type'=>'submit','div'=>false,'class'=>'continue'));?>
                 </div>
		  
                 <!--Sample Bot Row Closed-->
                 
                 
               </div>
                 <!--Tabs Content Closed-->
          </div>
            <!--Setting Tabs Widget Closed-->
          <?php echo $form->end(); ?>    
        </div>

<!--mid Content Closed-->