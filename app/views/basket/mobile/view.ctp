<?php
//echo $javascript->link(array('lib/prototype','selectAllCheckbox_front',''));
echo $javascript->link(array('lib/prototype'));
?>
<!--Right Section Start-->
 <!--Main Content Starts--->
             <section class="maincont nopadd">
                <!--Product Detail Box Starts-->
                 <section class="prdctboxdetal">
                 <!--Product Preview Widget Start-->
                    <div class="product-preview-widget">
                        <ul>
                          <li class="mybasktspng"><img src="<?php echo SITE_URL;?>img/mobile/my_shoppng_baskt.gif" alt="" />
                          <span>My Shopping Basket</span>
                          <a href="<?php echo SITE_URL;?>"><input type="button" value="Back to shop" class="darkorngbtn" /></a>
                          </li>
                        </ul>
                     <!--Seller BreadCumb End-->
                     <!-- Start Shopping list -->
                        <?php echo $this->element('/basket/mobile/basket_listing');?>
                     <!--End Shopping list-->
                     <!---->
                     <!--Seller Banner Starts-->
                       <?php //echo $this->element('/mobile/basket/seller_banner')?>
                     <!--Seller Banner End-->
                    <!--Product details Section Closed-->	
                </div>
                 <!--Product Preview Widget Closed-->
                  </section>
                <!--Product Detail Box Starts-->
             </section>
          <!--Main Content End--->
<script>
var width_pre_div = 799;
</script>
<?php echo $javascript->link(array('change_resolution_basket'));?>
<!--mid Content Closed-->