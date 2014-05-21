<?php

$sortByArr = array('sale'=>'Bestselling', 'date'=>'Relevence');

?>

        
	<!--Breadcrumb Closed-->     
	<div class="breadcrumb-widget">
		<?php //echo $breadcrumb_string; ?>
	</div>
	<!--Breadcrumb Closed-->     
		
	<!--Sorting Start-->
	<div class="sorting-widget">
		<div class="showing-widget">Showing 1-24 of 397 Products</div>
		<div class="sort-by">Sort by:
		<?php echo $form->select('Search.sortby',$sortByArr,null,array('onchange'=>'FilterProducts()', 'class'=>'select','label'=>false,'div'=>false,'error'=>false,'size'=>1),'--Select--'); ?>
		</div>
		<div class="clear"></div>
	</div>
	<!--Sorting Closed-->     
	   
	    
	     <!--Product Listings Widget Start-->
            <div class="products-listings-widget">
	
		<?php
		echo $form->create("Category",array("action"=>"/viewproducts/","method"=>"get", "id"=>"frmSearchproduct", "name"=>"frmSearchproduct"));
		echo $form->hidden('Search.brands',array('value'=>$brands,'div'=>false));
		echo $form->hidden('Search.reviews',array('value'=>$reviews,'div'=>false));
		echo $form->hidden('Search.pricerange',array('value'=>$pricerange,'div'=>false));
		echo $form->hidden('Search.seller',array('value'=>$seller,'div'=>false));
		echo $form->hidden('Search.sortby',array('value'=>$sortby,'div'=>false));
	?>
	    
	<?php echo $form->end();?>
	
	<!--Left Widget Start-->
                        <div class="product-listings-wdgt">
			<!--Row1 Start-->
                <?php
		if( is_array($arrcategoryProducts) && count($arrcategoryProducts) > 0){
			foreach($arrcategoryProducts  as $key => $value){
					
			# display current image preview
			$prodImagePath = WWW_ROOT.PATH_PRODUCT.$value['Product']['product_image'];
			
			if(file_exists($prodImagePath) && !empty($value['Product']['product_image']) ){
				$arrImageDim = $format->custom_image_dimentions($prodImagePath, 135, 135);
				$ImageName  = "/".PATH_PRODUCT."/".$value['Product']['product_image'];
			}else{
				$ImageName  ="/img/no_image.jpeg";
			}
			?>
                        
                            <div class="pro-listing-row">
                                <div class="pro-img">
				<?php echo $html->image($ImageName , array( 'width'=>$arrImageDim['width'],"alt" => "", "border" => "0"  )); ?>
				</div>
                                <div class="numric-widget">1.</div>
                                <div class="product-details-widget">
                                  <h4><a href="#" class="underline-link"><strong><?php  echo $value['Product']['product_name']; ?></strong></a></h4>
                                  <p class="used-from pad-tp">New from <span class="price larger-font"><strong>&pound;12.99</strong></span> Used from <span class="price larger-font"><strong>&pound;2.99</strong></span></p>
                                  <p>RRP: <span class="gray-color"><s><?php echo CURRENCY_SYMBOL; ?><?php  echo $value['Product']['product_rrp']; ?></s></span> | You save: <span class="yellow"><strong>£7.04 (44%)</strong></span></p>
                                  <p><strong>In stock</strong> | Usually dispatched within 24 hours <img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/red-star-rating.png" width="12" height="12" alt="" /><img src="images/red-star-rating.png" width="12" height="12" alt="" /> <span class="pad-rt">(<a href="#">604</a>)</span></p>
                                  <p>Get it by <strong>Thursday, Jun 24</strong> if you order in the next <span class="green-color"><strong>5 hours</strong></span> and choose express delivery.</p>
                                  <p class="rates">Eligible for <strong>FREE</strong> Money Saver Delivery &amp; <span class="rate"><strong>Make me an offer&trade;</strong></span></p>
                                </div>
                                <div class="clear"></div>
                            </div>
			    
			<?php  } // foreach ens
			
		}else{ //  no records found 
				echo '<div style="text-align:center;">';
				echo "No Record Found";
				echo '</div>';
		}
			?>
                            <!--Row1 Closed-->
			    
			 </div>
			
            </div>
	
             <!--Product Listings Widget Closed-->
		
	
		
		   <!--Sorting Start-->
                <div class="paging border-top">
                    <ul>
			<?php if( is_array($arrcategoryProducts) && count($arrcategoryProducts) > 0){ ?>
			<li><strong>Page</strong></li>
			<?php
			//echo $paginator->first('First', array('class'=>"homeLink"));echo '&nbsp;&nbsp;';
			//echo $paginator->prev('Previous',array('class'=>"homeLink"));  echo '&nbsp;&nbsp;';
			echo $paginator->numbers(); echo '&nbsp;&nbsp;';
			echo $paginator->next('Next',array('class'=>"active")); echo '&nbsp;';
			//echo $paginator->last('Last',array('class'=>"active"));
			}
			?>
			<!--<li><strong>Page</strong></li>
			<li><a href="#" class="active">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">Next</a></li>-->
                    </ul>
                    <div class="clear"></div>
                </div>
                <!--Sorting Closed-->
