<?php
App::import('Model','Category');
$Category = & new Category();		
App::import('Model','Page');
$this->Page = & new Page();
App::import('Model','FaqCategory');
$this->FaqCategory = & new FaqCategory();
?>

<!--mid Content Start-->
    
			
		</div>
           <div class="site_map">
                <!--All Categories Start-->
                <h1 class="heading all_cat">All Categories</h1>
                <div class="row">
                    <div class="column-links col_links">                	
                        <!--Books Start-->
                        <div class="row">
                        <h5><?php
                $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[1], ENT_NOQUOTES, 'UTF-8'));
                echo $html->link($departments[1],"/".$dept_atoz."/departments/index/1" ,array('escape'=>false));?></h5>
                <?php
                $CatArrayBooks = $Category->getTopCategory(1);
                ($CatArrayBooks);
                ?>
                          <ul>
                           <?php
                if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
                    foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
                    <li>
                    <?php	
                    $cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
                        echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
                    </li>
                    <?php  } ?>
                <?php }?>
                          </ul>
                        </div>
                        <!--Books Closed-->
                    </div>
                    
                    <div class="column-links col_links">                	
                        <!--Movies Start-->
                        <div class="row">
                        <h5><?php
                $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[3], ENT_NOQUOTES, 'UTF-8'));
                echo $html->link($departments[3],"/".$dept_atoz."/departments/index/3" ,array('escape'=>false));?></h5>
                <?php
                $CatArrayBooks = $Category->getTopCategory(3);
                ($CatArrayBooks);
                ?>
                        <ul>
                            <?php
                if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
                    foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
                    <li>
                    <?php	
                    
                    $cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), 	html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
                        echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
                    </li>
                    <?php  } ?>
                <?php }?>
                        </ul>
                        </div>
                        <!--movies Closed-->
                    </div>
                    
                    <div class="column-links col_links">                	
                        <!--Games Start-->
                        <div class="row">
                            <h5><?php
                $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[4], ENT_NOQUOTES, 'UTF-8'));
                echo $html->link($departments[4],"/".$dept_atoz."/departments/index/4" ,array('escape'=>false));?></h5>
                <?php
                $CatArrayBooks = $Category->getTopCategory(4);
                ($CatArrayBooks);
                ?>
                            <ul>
                               <?php
                if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
                    foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
                    <li>
                    <?php
                        
                        $cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
                        echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
                    </li>
                    <?php  } ?>
                <?php }?>
                            </ul>
                        </div>
                        <!--Games Closed-->
                        
                        <!--Electronics Start-->
                      <div class="row">
                        <h5><?php
                $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[5], ENT_NOQUOTES, 'UTF-8'));
                echo $html->link($departments[5],"/".$dept_atoz."/departments/index/5" ,array('escape'=>false));?></h5>
                <?php
                $CatArrayBooks = $Category->getTopCategory(5);
                ($CatArrayBooks);
                ?>
                          <ul>
                              <?php
                if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
                    foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
                    <li>
                    <?php
                        
                        $cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
                        echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
                    </li>
                    <?php  } ?>
                <?php }?>
                          </ul>
                        </div>
                        <!--Electronics Closed-->
                        
                        <!--Office &amp; Computing Start-->
                        <div class="row">
                            <h5><?php
                
                $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[6], ENT_NOQUOTES, 'UTF-8'));
                echo $html->link($departments[6],"/".$dept_atoz."/departments/index/6" ,array('escape'=>false));?></h5>
                <?php
                $CatArrayBooks = $Category->getTopCategory(6);
                ($CatArrayBooks);
                ?>
                            <ul>
                                <?php
                if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
                    foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
                    <li>
                    <?php	
                        
                        $cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
                        
                        echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
                    </li>
                    <?php  } ?>
                <?php }?>
                            </ul>
                        </div>
                        <!--Office &amp; Computing Closed-->
                        
                        <!--Mobile Start-->
                      <div class="row">
                        <h5><?php
                $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[7], ENT_NOQUOTES, 'UTF-8'));
                echo $html->link($departments[7],"/".$dept_atoz."/departments/index/7" ,array('escape'=>false));?></h5>
                <?php
                $CatArrayBooks = $Category->getTopCategory(7);
                ($CatArrayBooks);
                ?>
                          <ul>
                              <?php
                if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
                    foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
                    <li>
                    <?php	
                        
                        $cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
                        echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
                    </li>
                    <?php  } ?>
                <?php }?>
                          </ul>
                        </div>
                        <!--Mobile Closed-->
                    </div>
                    
                    <div class="column-links col_links">                	
                        <!--Home &amp; Garden Start-->
                      <div class="row">
                        <h5><?php
                $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[8], ENT_NOQUOTES, 'UTF-8'));
                echo $html->link($departments[8],"/".$dept_atoz."/departments/index/8" ,array('escape'=>false));?></h5>
                <?php
                $CatArrayBooks = $Category->getTopCategory(8);
                ($CatArrayBooks);
                ?>
                        <ul>
                          <?php
                if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
                    foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
                    <li>
                    <?php	
                        
                        $cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
                        echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
                    </li>
                    <?php  } ?>
                <?php }?>
                        </ul>
                      </div>
                        <!--Home &amp; Garden Closed-->
                    </div>
                    
                    <div class="column-links col_links">                	
                        <!--Health &amp; Beauty Start-->
                        <div class="row">
                          <h5><?php
                  $dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[9], ENT_NOQUOTES, 'UTF-8'));
                  echo $html->link($departments[9],"/".$dept_atoz."/departments/index/9" ,array('escape'=>false));?></h5>
                  <?php
                $CatArrayBooks = $Category->getTopCategory(9);
                ($CatArrayBooks);
                ?>
                            <ul>
                                <?php
                if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
                    foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
                    <li>
                    <?php	
                        
                        $cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
                        echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
                    </li>
                    <?php  } ?>
                <?php }?>
                            
                            </ul>
                        </div>
                        <!--Health &amp; Beauty Closed-->
                        
                        <!--Bestsellers Start-->
                    <!---     <div class="row">
                          <h5><?php echo $html->link('Bestsellers',"/products/all-department-topsellers" ,array('escape'=>false));?></h5>
                            <ul>	
                <?php
                for ($i=1; $i<=count($departments); $i++)
                {
                $dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($departments[$i], ENT_NOQUOTES, 'UTF-8')); ?>
                <li>
                 <?php echo $html->link($departments[$i].' Bestsellers','/'.$dept_url_name.'-topsellers-top-100/products/bestseller_products/'.base64_encode($i),array('escape'=>false));?>
                 </li>
                            
                <?php } ?>
        
                            </ul>
                        </div> --->
                        <!--Bestsellers Closed-->
                        
                    </div>
                    <div class="clear"></div>     
                </div>
                <!--All Categories Closed-->
                
                <!--Help &amp; Imformation Start-->
                <h1 class="heading all_cat">Help &amp; Information</h1>
                <div class="row">
                    <div class="column-links col_links help_info">                	
                        <!--Ordering Start-->
                        <div class="row">
                
                            <h5>Ordering</h5>
                            <ul>
                            <?php
                $pages_ordering = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'ordering' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
                if(!empty($pages_ordering)){
                foreach($pages_ordering as $order_page){ ?>
                    <li><?php echo $html->link(strip_tags($order_page['Page']['title']),"/pages/view/".$order_page['Page']['pagecode'],array('escape'=>false));?></li>
                    <?php } }?>
                            </ul>
                        </div>
                        <!--Ordering Closed-->
                        
                        <!--Dispatch and Delivery Start-->
                      <div class="row">
                        <h5>Dispatch and Delivery</h5>
                          <ul>
                              <?php
                $pages_delivery = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'delivery' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
                if(!empty($pages_delivery)){
                foreach($pages_delivery as $paged){ ?>
                    <li><?php echo $html->link(strip_tags($paged['Page']['title']),"/pages/view/".$paged['Page']['pagecode'],array('escape'=>false));?></li>
                    <?php 
                } }?>
                          </ul>
                        </div>
                        <!--Dispatch and Delivery Closed-->
                        
                        <!--Returns and Refunds Start-->
                      <div class="row">
                        <h5>Returns and Refunds</h5>
                          <ul>
                              <?php
                $pages_return = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'returns' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
                if(!empty($pages_return)){
                foreach($pages_return as $pager){ ?>
                    <li><?php echo $html->link(strip_tags($pager['Page']['title']),"/pages/view/".$pager['Page']['pagecode'],array('escape'=>false));?></li>
                    <?php 
                } }?>
                          </ul>
                        </div>
                        <!--Returns and Refunds Closed-->
                        
                  </div>              
                    <div class="column-links col_links help_info">                	
                    <!--Choiceful Marketplace Start-->
                    <div class="row">
                      <h5>Choiceful Marketplace</h5>
                            <ul>
                                <?php
                $pages_marketplace = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'marketplace' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
                if(!empty($pages_marketplace)){
                foreach($pages_marketplace as $pagemp){ ?>
                    <?php if($pagemp['Page']['id']==94){?>
                    <li><?php echo $html->link(strip_tags($pagemp['Page']['title']),array('controller'=>'sellers','action'=>'sign_up'),array('escape'=>false));?></li>
                    <?php }else{?>
                    <li><?php echo $html->link(strip_tags($pagemp['Page']['title']),"/pages/view/".$pagemp['Page']['pagecode'],array('escape'=>false));?></li>
                    <?php }?>
                    <?php
                } }?>
                            </ul>
                        </div>
                        <!--Choiceful Marketplace Closed-->
                        
                        <!--Choiceful Marketplace Start-->
                        <div class="row">
                          <h5>Make me an Offer?</h5>
                          <ul>
                            <?php
                $pages_offer = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'offer' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
                if(!empty($pages_offer)){
                foreach($pages_offer as $pageoffer){ ?>
                    <li><?php echo $html->link(strip_tags($pageoffer['Page']['title']),"/pages/view/".$pageoffer['Page']['pagecode'],array('escape'=>false));?></li>
                    <?php 
                } }?>
                          </ul>
                       </div>
                        <!--Choiceful Marketplace Closed-->
                  </div>
                    <div class="column-links col_links help_info">                	
                    <!--Manage Your Account Start-->
                    <div class="row">
                      <h5>Manage Your Account</h5>
                            <ul>
                               <?php
                $pages_account = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'account' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
                if(!empty($pages_account)){
                foreach($pages_account as $pageaccount){ ?>
                    <li><?php echo $html->link(strip_tags($pageaccount['Page']['title']),"/pages/view/".$pageaccount['Page']['pagecode'],array('escape'=>false));?></li>
                    <?php 
                } }?>
                            </ul>
                        </div>
                        <!--Manage Your Account Closed-->
                        
                      <!--Gift Certificates Start-->
                        <div class="row">
                          <h5>Gift Certificates</h5>
                          <ul>
                           <?php
                $pages_certificate = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'certificate' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
                if(!empty($pages_certificate)){
                foreach($pages_certificate as $pagecertificate){ ?>
                    <li><?php echo $html->link(strip_tags($pagecertificate['Page']['title']),"/pages/view/".$pagecertificate['Page']['pagecode'],array('escape'=>false));?></li>
                    <?php 
                } }?>
                          </ul>
                       </div>
                        <!--Gift Certificates Closed-->
                        
                        <!--FAQs Start-->
                    <div class="row">
                <?php 
            $allfaq_categories = $this->FaqCategory->find('list',array('conditions'=>array('FaqCategory.title != "Affiliates Q & A"'),'fields'=>array('id','title')));
            if(!empty($allfaq_categories)){
            ?>
                      <h5>FAQs</h5>
                      <ul>
                       <?php foreach($allfaq_categories as $faq_cat_id =>$faq_cat){?>
                    <li><?php echo $html->link($faq_cat,'/faqs/view/'.$faq_cat_id,array('escape'=>false));?></li>
                    <?php }?>
                      </ul>
              <?php }?>
                      </div>
                        <!--FAQs Closed-->
                
                  </div>              
                    <div class="column-links col_links help_info">                	
                    <!--Choiceful.com Policies Start-->
                    <div class="row">
                      <h5>Choiceful.com Policies</h5>
                            <ul>
                               <?php
                $pages_policy = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'policy'),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence')));
                if(!empty($pages_policy)){
                foreach($pages_policy as $pagepolicy){ ?>
                    <li><?php echo $html->link(strip_tags($pagepolicy['Page']['title']),"/pages/view/".$pagepolicy['Page']['pagecode'],array('escape'=>false));?></li>
                    <?php 
                } }?>
                            </ul>
                        </div>
                        <!--Choiceful.com Policies Closed-->
                        
                      <!--Choiceful MarketPlace Start-->
                    <div class="row">
                      <h5>Choiceful MarketPlace</h5>
                      <ul>
                        <li><?php echo $html->link('How it works?',"/marketplaces/view/how-it-works",array('escape'=>false));?></li>
                        <li><?php echo $html->link('Pricing',"/marketplaces/view/choiceful-marketplace-marketplace-pricing",array('escape'=>false));?></li>
                        <li><?php echo $html->link('International Sellers',"/marketplaces/view/choiceful-marketplace-international-sellers",array('escape'=>false));?></li>
                        <li><?php echo $html->link('Seller User Agreement',"/marketplaces/view/choiceful-marketplace-user-agreement",array('escape'=>false));?></li>
                        <li><?php echo $html->link("FAQ's","/marketplaces/view/choiceful-marketplace-faqs",array('escape'=>false));?></li>
                      </ul>
                      </div>
                        <!--Choiceful MarketPlace Closed-->
                        
                        <!--Choiceful Services Start-->
                        <div class="row">
                            <h5>Choiceful Services</h5>
                            <ul>
                    
                                <li><?php echo $html->link('Choiceful Mobile',"/homes/choiceful-mobile",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Gift Certificates',"/certificates/buy-choiceful-gift-certificates-the-gift-of-choice",array('escape'=>false)); ?></li>
                            </ul>
                        </div>
                        <!--Choiceful Services Closed-->
                        
                        <!--Choiceful for Business Start-->
                    <div class="row">
                      <h5>Choiceful for Business</h5>
                        <ul>
                            <li><?php echo $html->link('Advertising With Us',"/advertise-on-choiceful",array('escape'=>false)); ?></li>
                            <li><?php echo $html->link('Affiliate program',"/affiliates/view/make-money-advertising-choiceful-using-our-affiliate-programme/1",array('escape'=>false)); ?></li>
                            <li><?php echo $html->link('Volume Selling',"/pages/view/volume-sellers",array('escape'=>false)); ?></li>
                            <li><?php echo $html->link('Marketplace',"/marketplaces/view/choiceful-marketplace-how-it-works",array('escape'=>false)); ?></li>
                        </ul>
                      </div>
                        <!--Choiceful for Business Closed-->
                        
                        <!--Company Information Start-->
                    <div class="row">
                      <h5>Company Information</h5>
                        <ul>
                
                            <li><?php echo $html->link('About Choiceful',"/pages/view/about-choiceful",array('escape'=>false)); ?></li>
                            <li><?php echo $html->link('About our Website',"/pages/view/about-choiceful",array('escape'=>false)); ?></li>
                            <li>
                <span class="livehelplink"><script  type="text/javascript"  src="<?php echo SITE_URL;?>/app/webroot/phplive/js/phplive.js.php?d=0&base_url=%2F%2Fchoiceful.com%2Fapp%2Fwebroot%2Fphplive&text=Live Help"></script></span>
                <?php //echo $html->link('Live Help',"javascript:",array('escape'=>false,'onclick'=>'phplive_launch_chat_72164851(0)','id'=>'phplive_btn_72164851')); ?></li>
                
                        </ul>
                      </div>
                        <!--Company Information Closed-->
                  </div>
                    <div class="column-links col_links help_info">                	
                        <!--My Account Start-->
                        <div class="row">
                            <h5>My Account</h5>
                            <ul>
                                <li><?php echo $html->link('View Open Orders',"/orders/view_open_orders",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Order History',"/orders/order_history",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Return Items',"/orders/return_items",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Contact Sellers',"/orders/contact_sellers",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Leave Seller Feedback',"/orders/leave_seller_feedback",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Manage My Offers',"/offers/manage_offers",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('View Accepted Offers',"/offers/accepted_offers",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('View Rejected Offers',"/offers/rejected_offers",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('See All My Reviews',"/products/my_reviews",array('escape'=>false)); ?></li>
                                <!--<li><?php //echo $html->link('Leave Seller Feedback',"/orders/leave_seller_feedback",array('escape'=>false)); ?></li> -->
                                <li><?php echo $html->link('What is Choiceful MarketPlace?',"/pages/view/what-is-choiceful",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Join Choiceful MarketPlace',"/sellers/choiceful-marketplace-sign-up",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Manage Listings',"/marketplaces/manage_listing",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('View Orders',"/sellers/orders",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Buyer Communication',"/messages/sellers",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Sales Reports',"/marketplaces/sales_report",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Payment Settings',"/sellers/payment_settings",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Account Setting',"/sellers/my_account",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('MarketPlace Help',"/pages/view/marketplace-buyer-guide",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Purchase a Gift Certificate',"/certificates/buy-choiceful-gift-certificates-the-gift-of-choice",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('View Gift Certificate Balance',"/certificates/gift_balance",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Apply a Gift Certificate',"/certificates/apply_gift",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Change name, E-Mail Address or Password',"/users/my_account",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Manage Address Book',"/users/manage_addresses",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Add New Address',"/users/add_address",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Manage E-Mail Preferences &amp; Alerts',"/users/email_alerts",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Special Occasion Calendar',"/users/events_calendar",array('escape'=>false)); ?></li>
                            </ul>
                        </div>
                        <!--My Account Closed-->
                    </div>               
                    <div class="clear"></div>     
              </div>
                <!--Help &amp; Imformation Closed-->
                
                <!--Choiceful.com Stores Start-->
                <h1 class="heading all_cat">Choiceful.com Stores</h1>
                <div class="row">
                    <div class="column-links col_links help_info">                	
                        <div class="row">
                            <ul>
                            
                                            <?php
                    $countryDetail =array();
                    
                    $countryDetail = array('1'=>array('name'=>'Australia','img'=>'australia.png'),
                                     '2'=>array('name'=>'Argentina','img'=>'argentina.png'),
                                     '3'=>array('name'=>'Austria','img'=>'austria.png'),
                                     '4'=>array('name'=>'Bahrain','img'=>'bahrain.png'),
                                     '5'=>array('name'=>'Brazil','img'=>'brazil.png'),
                                     '6'=>array('name'=>'Canada','img'=>'canada.png'),
                                     '7'=>array('name'=>'China','img'=>'china.png'),
                                     '8'=>array('name'=>'Colombia','img'=>'colombia.png'),
                                     '9'=>array('name'=>'Czech Republic','img'=>'czech_republic.png'),
                                     '10'=>array('name'=>'Denmark','img'=>'denmark.png'),
                                     '11'=>array('name'=>'Egypt','img'=>'egypt.png'),
                                     '12'=>array('name'=>'Finland','img'=>'finland.png'),
                                     '13'=>array('name'=>'France','img'=>'france.png'),
                                     '14'=>array('name'=>'Germany','img'=>'germany.png'),
                                     '15'=>array('name'=>'Hong Kong','img'=>'hongkong.png'),
                                     '16'=>array('name'=>'India','img'=>'india.png'),
                                     '17'=>array('name'=>'Indonesia','img'=>'indonesia.png'),
                                     '18'=>array('name'=>'Iran','img'=>'iran.png'),
                                     '19'=>array('name'=>'Ireland','img'=>'ireland.png'),
                                     '20'=>array('name'=>'Israel','img'=>'israel.png'),
                                     '21'=>array('name'=>'Italy','img'=>'italy.png'),
                                     '22'=>array('name'=>'Japan','img'=>'japan.png'),
                                     '23'=>array('name'=>'Jordan','img'=>'jordan.png'),
                                     '24'=>array('name'=>'Kuwait','img'=>'kuwait.png'),
                                     '25'=>array('name'=>'Luxembourg','img'=>'luxembourg.png'),
                                     '26'=>array('name'=>'Malaysia','img'=>'malaysia.png'),
                                     '27'=>array('name'=>'Malta','img'=>'malta.png'),
                                     '28'=>array('name'=>'Mexico','img'=>'mexico.png'),
                                     '29'=>array('name'=>'Morocco','img'=>'morocco.png'),
                                     '30'=>array('name'=>'Netherlands','img'=>'netherlands.png'),
                                     '31'=>array('name'=>'New Zealand','img'=>'new_zealand.png'),
                                     '32'=>array('name'=>'Norway','img'=>'norway.png'),
                                     '33'=>array('name'=>'Pakistan','img'=>'pakistan.png'),
                                     '34'=>array('name'=>'Philippines','img'=>'philippines.png'),
                                     '35'=>array('name'=>'Poland','img'=>'poland.png'),
                                     '36'=>array('name'=>'Qatar','img'=>'qatar.png'),
                                     '37'=>array('name'=>'Russia','img'=>'russia.png'),
                                     '38'=>array('name'=>'Saudia Arabia','img'=>'saudi_arabia.png'),
                                     '39'=>array('name'=>'South Africa','img'=>'south_africa.png'),
                                     '40'=>array('name'=>'South Korea','img'=>'south_korea.png'),
                                     '41'=>array('name'=>'Spain','img'=>'spain.png'),
                                     '42'=>array('name'=>'Sri Lanka','img'=>'srilanka.png'),
                                     '43'=>array('name'=>'Sweden','img'=>'sweden.png'),
                                     '44'=>array('name'=>'Switzerland','img'=>'switzerland.png'),
                                     '45'=>array('name'=>'Taiwan','img'=>'taiwan.png'),
                                     '46'=>array('name'=>'Thailand','img'=>'thailand.png'),
                                     '47'=>array('name'=>'Turkey','img'=>'turkey.png'),
                                     '48'=>array('name'=>'United Kingdom','img'=>'uk.png'),
                                     '49'=>array('name'=>'Ukraine','img'=>'ukraine.png'),
                                     '50'=>array('name'=>'United Arab Emirates','img'=>'uae.png'),'51'=>array('name'=>'United Arab Emirates','img'=>'uae.png'));
                            $j =1;
                        foreach($countryDetail as $k=>$val){
                                        $img= $val['img'];
                                    
                                        $name = $val['name'];
                                        $link = $html->link($name,"/homes/international-websites",array('escape'=>false));
                                        if((10/$j) === 1 ){
                                               $j=1; 
                        ?>
                            </ul>
                        </div>
                    </div> 
                    <div class="column-links col_links help_info">                	
                        <div class="row">
                            <ul>
                          <?php  }
                          
                                        echo "<li> $link </li>";
                                            $j++;
                             }              
                    ?>
        
    
    
            
                            
                            
                            
                           <!---     <li><?php echo $html->link('Australia',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Brazil',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Canada',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Czech Republic',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Germany',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Spain',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('France',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('UK',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Hong Kong',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Ireland',"/homes/international-websites",array('escape'=>false)); ?></li>
                          --- </ul>
                        </div>
                    </div> 
                    <div class="column-links col_links help_info">                	
                        <div class="row">
                            <ul>
                                <li><?php echo $html->link('India',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Italy',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Japan',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('South Korea',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Mexico',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Netherlands',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('New Zealand',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Poland',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Russia',"/homes/international-websites",array('escape'=>false)); ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="column-links col_links help_info">                	
                        <div class="row">
                            <ul>
                                <li><?php echo $html->link('Sweden',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('Taiwan',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('South Africa',"/homes/international-websites",array('escape'=>false)); ?></li>
                                <li><?php echo $html->link('USA',"/homes/international-websites",array('escape'=>false)); ?></li>
                            </ul>
                        </div>
                    </div>    --->
                      </ul>
                        </div>
                    </div>          
                    <div class="clear"></div>     
              </div>
                <!--Choiceful.com Stores Closed-->
                
                <!--Choiceful.com Social Media Start-->
                <h1 class="heading all_cat">Choiceful.com Social Media</h1>
            
                <div class="row">
            <?php if(!empty($blogs) && count($blogs) > 0) {
            $loopcounter = round(count($blogs) / 4 ) ;	
            ?>
                    <div class="column-links col_links help_info">                	
                        <div class="row">
                            <ul>
                <li><?php echo $html->link('CHOICEFUL.COM BLOG',"/blog",array('escape'=>false)); ?></li>
                <?php
                /*$count= 1;
                foreach ($blogs as $blog){
                    $show =round(count($blogs)/4);
                    
                    ?>
                            
                    <li><?php echo $html->link($blog['Blog']['title'],"/blogs/blogdetails/".$blog['Blog']['slug'],array('escape'=>false)); ?></li>
                    <?php if($count%$show==0){
                    echo '</ul></div></div><div class="column-links col_links help_info"><div class="row"><ul>';}  $count++;}*/
                   ?>
                   
                   <?php for ($i=0; $i < ($loopcounter-1); $i++ ){ ?>
                  <li><?php echo $html->link($blogs[$i]['Blog']['title'],"/blogs/blogdetails/".$blogs[$i]['Blog']['slug'],array('escape'=>false)); ?></li> 
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
            
            <div class="column-links col_links help_info">                	
                        <div class="row">
                            <ul>
                <?php $end = (($loopcounter*2)-1);
                   for ($i=($loopcounter-1); $i < ($end); $i++ ){ ?>
                  <li><?php echo $html->link($blogs[$i]['Blog']['title'],"/blogs/blogdetails/".$blogs[$i]['Blog']['slug'],array('escape'=>false)); ?></li> 
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
            
            <div class="column-links col_links help_info">                	
                        <div class="row">
                            <ul>
                <?php
                $start = (($loopcounter*2)-1);
                $end = (($loopcounter*3)-1);
                   for ($i=$start; $i < ($end); $i++ ){ ?>
                  <li><?php echo $html->link($blogs[$i]['Blog']['title'],"/blogs/blogdetails/".$blogs[$i]['Blog']['slug'],array('escape'=>false)); ?></li> 
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
            
            <div class="column-links col_links help_info">                	
                        <div class="row">
                            <ul>
                <?php
                $start = (($loopcounter*3)-1);
                $end = count($blogs);
                
                   for ($i=$start; $i < ($end); $i++ ){ ?>
                  <li><?php echo $html->link($blogs[$i]['Blog']['title'],"/blogs/blogdetails/".$blogs[$i]['Blog']['slug'],array('escape'=>false)); ?></li> 
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
            
            <?php } else {
                
                echo 'No records found';
                } ?>
            <div class="column-links col_links help_info">                	
                        <div class="row">
                            <ul>
                                <!--<li><?php //echo $html->link('Choiceful.com Blog',"/blog",array('escape'=>false)); ?></li>-->
                                <li><?php echo $html->link('Choiceful.com Facebook',"https://www.facebook.com/choiceful",array('escape'=>false,'target'=>'_blank')); ?></li>
                                <li><?php echo $html->link('Choiceful.com Google+',"https://plus.google.com/105885727970905038288",array('escape'=>false,'target'=>'_blank')); ?></li>
                                <li><?php echo $html->link('Choiceful.com Twitter',"https://twitter.com/Choicefulcom",array('escape'=>false,'target'=>'_blank')); ?></li>
                                <li><?php echo $html->link('Choiceful.com Pinterest',"http://pinterest.com/choiceful",array('escape'=>false,'target'=>'_blank')); ?></li>
                                <li><?php echo $html->link('Choiceful.com LinkedIn',"http://in.linkedin.com/in/choiceful",array('escape'=>false,'target'=>'_blank')); ?></li>
                            </ul>
                        </div>
                    </div> 
                    <div class="clear"></div>     
              </div>
                <!--Choiceful.com Social Media Closed-->
                
                <!--Product Directories Start-->
                <h1 class="heading all_cat">Product Directories</h1>
                <div class="row">
                    <div class="column-links col_links help_info">                	
                        <div class="row">
                            <ul>
                                <li>
                    <?php echo $html->link('Product Categories A to Z',"/sitemaps/product_categories/A",array('escape'=>false)); ?>
                   </li>
                                <li><?php echo $html->link('Product Map',"/sitemaps/product_map",array('escape'=>false)); ?></li>
                            </ul>
                        </div>
                    </div> 
                    <div class="clear"></div>     
              </div>
                <!--Product Directories Closed-->
            </div> 
        </div>
        <!--mid Content Closed-->