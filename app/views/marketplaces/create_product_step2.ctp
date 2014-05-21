<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');

?>

<!--mid Content Start-->

<div class="mid-content pad-rt-none inc-pad">
		
        <?php echo $form->create('Marketplace',array('action'=>'create_product_step2','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));?>    
            <!--Setting Tabs Widget Start-->
     <!---    <?php echo $this->element('marketplace/breadcrum'); ?> -->
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
                  <div class="inner-content">
                    <p>Now provide the product detail, i.e. name, brand. So that customers can recognize your product easily.</p>
                    <p>Please enter all mandatory fields highlighted red.</p>
                    
		    <?php
			if(!empty($errors) || !empty($errorsd)){	
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
			<div class="error_msg_box" style="overflow: hidden;"> 
				<?php echo $error_meaasge;?>
			</div>
			<?php }?>
		    
		    <h4 class="ornge-cl-head">Step 2 of 3</h4>
                  </div>
                 <!--Discription Closed-->
                
               	<!--Sample Bot Row Srart-->
                 <div class="department_selection_68">
				<ul>
		<li>
			<label class="red">Product Name:</label>
			<div class="right_value">
			<?php
			if(!empty($errors['product_name'])){
				$errorProductName ='large error_message_box';
			}else{
				$errorProductName ='large';
			}
			echo $form->input('Product.product_name',array('maxlength'=>'500', 'class'=>$errorProductName,'label'=>false,'div'=>false,'error'=>false));?>
			<span class="line-break instructions-line">(Include brand name and any details specific to the product, for example colour or size)</span>
			</div>
		</li>
		<li>
		<label class="red">Brand Name:</label>
		<?php
			if(!empty($errors['brand_name'])){
				$errorBrandName ='medium error_message_box';
			}else{
				$errorBrandName ='medium';
			}
		echo $form->input('Product.brand_name',array('maxlength'=>'40','class'=>$errorBrandName,'label'=>false,'div'=>false,'error'=>false));?>
		<span class="smalr-fnt">&nbsp;For example: Sony </span>
		</li>
		<li>
		<label class="red">EAN/UPC:</label>
    <span class="smalr-fnt">&nbsp;Enter the barcode number here</span>
		<?php
		if(!empty($errors['barcode'])){
				$errorBarcode ='small error_message_box';
			}else{
				$errorBarcode ='small';
			}
		echo $form->input('Product.barcode',array('maxlength'=>'30','class'=>$errorBarcode,'label'=>false,'div'=>false,'error'=>false));?>
		<span class="smalr-fnt"></span>
		</li>
			
		<?php
		//echo $department_id ;
		switch($department_id):
				case '1': // books
				?>
				<li>
				<label class="red">Author:</label>
				<?php
					if(!empty($errorsd['author_name'])){
						$errorAuthorName ='medium error_message_box';
					}else{
						$errorAuthorName ='medium';
					}
				echo $form->input('ProductDetail.author_name',array('maxlength'=>'80','class'=>$errorAuthorName,'label'=>false,'div'=>false,'error'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red">Publisher:</label>
				<?php
				if(!empty($errorsd['publisher'])){
						$errorPublisher ='medium error_message_box';
					}else{
						$errorPublisher ='medium';
					}
				echo $form->input('ProductDetail.publisher',array('maxlength'=>'80','class'=>$errorPublisher,'label'=>false,'error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label >Language:</label>
				<?php
				
				if(!empty($errorsd['language'])){
						$errorlanguage ='small error_message_box';
					}else{
						$errorlanguage ='small';
					}
				echo $form->input('ProductDetail.language',array('maxlength'=>'120','class'=>$errorlanguage,'label'=>false,'type'=>'text','error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red">ISBN:</label>
				<?php
				if(!empty($errorsd['product_isbn'])){
						$errorProduct_isbn ='small error_message_box';
					}else{
						$errorProduct_isbn ='small';
					}
				echo $form->input('ProductDetail.product_isbn',array('maxlength'=>'80','class'=>$errorProduct_isbn,'label'=>false,'error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red">Format:</label>
				<?php
				if(!empty($errorsd['format'])){
						$errorFormat ='small error_message_box';
					}else{
						$errorFormat ='small';
					}
				echo $form->input('ProductDetail.format',array('maxlength'=>'120','class'=>$errorFormat,'type'=>'text','label'=>false,'error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label>Pages:</label>
				<?php echo $form->input('ProductDetail.pages',array('maxlength'=>'80','class'=>'small','label'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label >Publisher Review:</label>
				<?php echo $form->input('ProductDetail.publisher_review',array('maxlength'=>'1000','label'=>false,'div'=>false,'cols'=>50,'rows'=>10));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label >Year Published:</label>
				<?php echo $form->input('ProductDetail.year_published',array('maxlength'=>'20','class'=>'small','label'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
		 <?php
			break;
			case '2': // music
		 ?>
				<li>
				<label class="red">Artist:</label>
				<?php
				if(!empty($errorsd['artist_name'])){
						$errorArtist_name ='medium error_message_box';
					}else{
						$errorArtist_name ='medium';
					}
				echo $form->input('ProductDetail.artist_name',array('maxlength'=>'80','class'=>$errorArtist_name,'label'=>false,'error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red">Label:</label>
				<?php
				if(!empty($errorsd['label'])){
						$errorLabel ='medium error_message_box';
					}else{
						$errorLabel ='medium';
					}
				echo $form->input('ProductDetail.label',array('maxlength'=>'80','class'=>$errorLabel,'label'=>false,'error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red">Format:</label>
				<?php
				if(!empty($errorsd['format'])){
						$errorformat ='small error_message_box';
					}else{
						$errorformat ='small';
					}
				echo $form->input('ProductDetail.format',array('maxlength'=>'120','class'=>$errorformat,'type'=>'text','label'=>false,'error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label>Rated:</label>
				<?php
				if(!empty($errorsd['music_rated'])){
						$errorMusicRated ='small error_message_box';
					}else{
						$errorMusicRated ='small';
					}
				echo $form->input('ProductDetail.music_rated',array('maxlength'=>'80','class'=>$errorMusicRated,'label'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label >Number of Discs:</label>
				<?php
				if(!empty($errorsd['number_of_disk'])){
						$errorNumberofDisk='small error_message_box';
					}else{
						$errorNumberofDisk ='small';
					}
				echo $form->input('ProductDetail.number_of_disk',array('maxlength'=>'5','class'=>$errorNumberofDisk,'label'=>false,'div'=>false,'error'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label >Track List:</label>
				<?php
				if(!empty($errorsd['number_of_disk'])){
						$errorRrackList ='error_message_box';
					}else{
						$errorRrackList ='';
					}
				echo $form->input('ProductDetail.track_list',array('maxlength'=>'5000','class'=>$errorRrackList,'label'=>false,'div'=>false,'cols'=>50,'rows'=>10));?>
				
				<?php //echo $form->input('ProductDetail.track_list',array('maxlength'=>'80','class'=>'small','label'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label >Release Date:</label>
				<?php
				echo $form->input('ProductDetail.release_date',array('autocomplete'=>'off','type'=>'text','label'=>false,'div'=>false,'maxlength'=>'50','class'=>'small','readonly'=>'readonly')); 									
				echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.frmMarketplace.ProductDetailReleaseDate,'dd/mm/yyyy',this)"));
				?>
				<span class="smalr-fnt"></span>
				</li>
		<?php
			break;
			case '3': // movie
				
		 ?>
				<li>
				<label >Starring:</label>
				<?php echo $form->input('ProductDetail.star_name',array('maxlength'=>'1000','class'=>'medium','label'=>false,'type'=>'text','div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label >Directed By:</label>
				<?php echo $form->input('ProductDetail.directedby',array('maxlength'=>'1000','class'=>'medium','label'=>false,'type'=>'text','div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red">Format:</label>
				<?php
				if(!empty($errorsd['format'])){
						$errorFormat ='small error_message_box';
					}else{
						$errorFormat ='small';
					}
				echo $form->input('ProductDetail.format',array('maxlength'=>'1000','class'=>$errorFormat,'label'=>false,'type'=>'text','div'=>false,'error'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label >Number of Discs:</label>
				<?php echo $form->input('ProductDetail.number_of_disk',array('maxlength'=>'30','class'=>'small','label'=>false,'type'=>'text','div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red">Rated:</label>
				<?php
				if(!empty($errorsd['rated'])){
						$errorRated ='small error_message_box';
					}else{
						$errorRated ='small';
					}
				echo $form->input('ProductDetail.rated',array('maxlength'=>'1000','class'=>$errorRated,'label'=>false,'type'=>'text','error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red">Language:</label>
				<?php
				if(!empty($errorsd['movie_language'])){
						$errorMovieLanguage ='small error_message_box';
					}else{
						$errorMovieLanguage ='small';
					}
				echo $form->input('ProductDetail.movie_language',array('maxlength'=>'1000','class'=>$errorMovieLanguage,'label'=>false,'type'=>'text','error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red">Studio:</label>
				<?php
				if(!empty($errorsd['studio'])){
						$errorStudio ='small error_message_box';
					}else{
						$errorStudio ='small';
					}
				echo $form->input('ProductDetail.studio',array('maxlength'=>'1000','class'=>$errorStudio,'label'=>false,'type'=>'text','div'=>false,'error'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label>Run Time:</label>x
				<?php echo $form->input('ProductDetail.run_time',array('maxlength'=>'80','class'=>'small','label'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label >Release Date:</label>
				<?php
				echo $form->input('ProductDetail.release_date',array('autocomplete'=>'off','type'=>'text','size'=>'15','label'=>false,'div'=>false,'maxlength'=>'50','class'=>'small','readonly'=>'readonly'));
				echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.frmMarketplace.ProductDetailReleaseDate,'dd/mm/yyyy',this)"));
				?>
				<span class="smalr-fnt"></span>
				</li>
		<?php
			break;
			case '4': // games
				
		 ?>
		 
				<li>
				<label class="red" >Platform:</label>
				<?php
				if(!empty($errorsd['plateform'])){
						$errorPlateform ='small error_message_box';
					}else{
						$errorPlateform ='small';
					}
				echo $form->input('ProductDetail.plateform',array('maxlength'=>'80','class'=>$errorPlateform,'label'=>false,'error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red">Rated:</label>
				<?php
				if(!empty($errorsd['rated'])){
						$errorRated ='small error_message_box';
					}else{
						$errorRated ='small';
					}
				echo $form->input('ProductDetail.rated',array('maxlength'=>'80','class'=>$errorRated,'label'=>false,'error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				
				<li>
				<label >Release Date:</label>
				<?php
				echo $form->input('ProductDetail.release_date',array('autocomplete'=>'off','type'=>'text','size'=>'15','label'=>false,'div'=>false,'maxlength'=>'50','class'=>'small','readonly'=>'readonly')); 									
				echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.frmMarketplace.ProductDetailReleaseDate,'dd/mm/yyyy',this)"));
				?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red" >Reason:</label>
				<?php
				if(!empty($errorsd['region'])){
						$errorRegion ='small error_message_box';
					}else{
						$errorRegion ='small';
					}
				echo $form->input('ProductDetail.region',array('maxlength'=>'80','class'=>$errorRegion,'label'=>false,'error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				
		<?php
			break;
				case '5': // electronics
				case '6': // office and computing
				case '7': // mobile
				case '8': //  home and garden
				
		 ?>
				<li>
				<label  >Manufacturer:</label>
        <span class="smalr-fnt">The manufacturing company for this product</span>
				<?php echo $form->input('Product.manufacturer',array('maxlength'=>'100','class'=>'small','label'=>false,'div'=>false));?>
				
				</li>
				<li>
				<label class="red">Model Number:</label>
        <span class="smalr-fnt">The product code assigned by the manufacturer,can be letters or number both</span>
				<?php
				if(!empty($errors['model_number'])){
						$errorModelNumber ='small error_message_box';
					}else{
						$errorModelNumber ='small';
					}
				echo $form->input('Product.model_number',array('maxlength'=>'100','class'=>$errorModelNumber,'label'=>false,'error'=>false,'div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
		<?php
		break;
		case '9': // Health & Beauty
		?>

	<li>
				<label class="red" >Suitable For:</label>
				<?php
				if(!empty($errorsd['suitable_for'])){
						$errorSuitableFor ='large error_message_box';
					}else{
						$errorSuitableFor ='large';
					}
				echo $form->input('ProductDetail.suitable_for',array('maxlength'=>'5000','class'=>$errorSuitableFor,'label'=>false,'type'=>'text','div'=>false,'error'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label >How to Use:</label>
				<?php
				echo $form->input('ProductDetail.how_to_use',array('maxlength'=>'5000','class'=>'large','label'=>false,'type'=>'text','div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red" >Hazards & Cautions:</label>
				<?php
				if(!empty($errorsd['hazard_caution'])){
						$errorHazardCaution ='large error_message_box';
					}else{
						$errorHazardCaution ='large';
					}
				echo $form->input('ProductDetail.hazard_caution',array('maxlength'=>'5000','class'=>$errorHazardCaution,'label'=>false,'error'=>false,'type'=>'text','div'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red" >Precautions:</label>
				<?php
				if(!empty($errorsd['precautions'])){
						$errorPrecautions ='large error_message_box';
					}else{
						$errorPrecautions ='large';
					}
				echo $form->input('ProductDetail.precautions',array('maxlength'=>'5000','class'=>$errorPrecautions,'label'=>false,'div'=>false,'type'=>'text','error'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				<li>
				<label class="red" >Ingredients:</label>
				<?php
				if(!empty($errorsd['ingredients'])){
						$errorIngredients ='large error_message_box';
					}else{
						$errorIngredients ='large';
					}
				echo $form->input('ProductDetail.ingredients',array('maxlength'=>'5000','class'=>$errorIngredients,'label'=>false,'type'=>'text','div'=>false,'error'=>false));?>
				<span class="smalr-fnt"></span>
				</li>
				
				<?php
				break;
				default:
						echo '';
						break;
		endswitch;
		?>
		</ul>
                 	

  
                   
                 </div>
                 <!--Sample Bot Row Closed-->
               
                 <!--Sample Bot Row Srart-->
		 <div class="sample_bot_row">
                 	<span class="orange-sml-btn">
				<!--input type="button" alt="" class="orange-back" value="Back" onclick="goBack('/marketplaces/create_product_step1')"/-->
				<!--input type="button" alt="" class="orange-back" value="Back" onclick="history.back();"/-->
				<a href="<?php echo $_SERVER['HTTP_REFERER'];?>"><input type="button" alt="" class="orange-back" value="Back" /></a>
			</span>
			<?php echo $form->button('',array('type'=>'submit','div'=>false,'maxlength'=>'50','class'=>'save-continue'));?>
                 </div>
                 <!--Sample Bot Row Closed-->
         
                 
               </div>
                 <!--Tabs Content Closed-->
          </div>
            <!--Setting Tabs Widget Closed-->
       <?php echo $form->end(); ?>       
        </div>


<!--mid Content Closed-->