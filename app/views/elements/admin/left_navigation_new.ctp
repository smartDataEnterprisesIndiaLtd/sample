<script>jQuery.noConflict();</script>
<?php echo $javascript->link(array('menu/jMenu.jquery'));?>

<?php $adminuser_loggedin = $this->Session->read('SESSION_ADMIN');
$controller = $this->params['controller'];
$action = $this->params['action'];
if($controller == 'adminusers' && ($action == 'admin_updateprofile' || $action == 'admin_change_password'))
	$new_controller = 'editaccount';
elseif($controller == 'faqs' || $controller == 'pages')
	$new_controller = 'websites';
elseif($controller == 'advertisements' || $controller=='choiceful_favorites' || $controller=='coupons' || ( $controller == 'certificates' && ($action == 'admin_index' || $action == 'admin_add' || $action == 'admin_searchtags' || $action == 'admin_add_tags')))
	$new_controller = 'promotions';
elseif($controller == 'products' || $controller == 'homepage_products' || $controller == 'brands' || $controller == 'Brands')
	$new_controller = 'products';
elseif($controller == 'reviews' || $controller == 'product_questions' || (($controller == 'certificates' && $action == 'admin_questions') || ($controller == 'certificates' && $action == 'admin_add_question') || ($controller == 'certificates' && $action == "admin_answers") || ($controller == 'certificates' && $action == "admin_add_answer")))
	$new_controller = 'reviewsqa';
elseif(($controller == 'certificates' && $action == 'admin_total_outstandings') || ($controller == 'certificates' && $action == "admin_total_sales"))
	$new_controller = 'reports';
/*elseif(($controller == 'order_returns' && ($action == 'admin_view' || $action == "admin_index" || $action == 'admin_claims' || $action == "admin_claim_details"|| $action == "admin_reply_claim")))
	$new_controller = 'customer_services';*/

elseif(($controller == 'order_returns' && ($action == 'admin_view' || $action == "admin_index" || $action == 'admin_claims' || $action == "admin_claim_details"|| $action == "admin_reply_claim")))
	$new_controller = 'orders';


elseif(($controller == 'blogs' && ($action == 'admin_view' || $action == 'admin_index' || $action == 'admin_add' ||$action == 'admin_reviewcomments' || $action == 'admin_addcomment' || $action =='admin_reviewquestions' || $action =='admin_addquestion')))
	$new_controller = 'promotions';
	
else
	$new_controller = $controller;
if($adminuser_loggedin['type'] != 'Superadmin'){
	App::import("Model","AdminuserPermission");
	$this->AdminuserPermission=new AdminuserPermission();
	$permissions_adminuser = $this->AdminuserPermission->find('all',array('conditions'=>array('AdminuserPermission.adminuser_id'=>$adminuser_loggedin['id'])));
	$perArr = array();
	if(!empty($permissions_adminuser)){
		foreach($permissions_adminuser as $userperArr){
			$perArr[] = $userperArr['AdminuserPermission']['permission_id'];
		}
	}
} else{
	App::import("Model","Permission");
	$this->Permission=new Permission();
	$perArr = $this->Permission->find('list',array('fields'=>array('Permission.id')));
}
?>  
<style type="text/css">

</style>

  <!--Navigation Start-->
    <nav>
      <ul class="navigation" id="jMenu">
         
							<?php if(($controller == 'homes' && $action == 'admin_dashboard') || ($controller == 'adminusers'  && ($action == 'admin_index' || $action == 'admin_add' || $action == 'admin_change_password' || $action == 'admin_updateprofile')) || (($controller == 'settings') && ( in_array($action, array('admin_index', 'admin_delivery_destination','admin_changeurl','admin_addurl'))))){
								$class='linkcolor';
							} else{
								$class='';
							}?>
							<li class="firstnav singleLineLink">
								<div class="posRelDiv">
								<?php echo $html->link("Home <span class='downArrow'></span>", array("controller"=>"adminusers","action"=>"login"),array('class'=>$class,'id'=>"homes",'onClick'=>'displaydiv(this.id)','escape' => false)); ?>
                                                            <ul id="home-details" style="display:none;">
									<?php if(in_array(1,$perArr)){?>
							<?php if($controller == 'adminusers' && ($action == 'admin_index' || $action == 'admin_add')){
								$class='linkcolor';
							} else{
								$class='';
							}?>
							<li>
								<?php echo $html->link('Admin Users',array("controller"=>"adminusers","action"=>"index"), array('class'=>$class,'id'=>"adminusers",'escape' => false)); ?>
							</li>
							<?php }?>
                                                        <li>
								<?php if(($controller == 'adminusers') && ($action == 'admin_change_password' || $action == 'admin_updateprofile')){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<?php echo $html->link("Account Settings",'javascript:void(0)' , array('class'=>$class,'id'=>"editaccount",'onClick'=>'displaydiv(this.id)','escape' => false)); ?>
								<ul id="editaccount-details" style="display:none;">
									<?php if($controller == 'adminusers' && $action == 'admin_change_password'){
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li class="dotted" ><span class="topBordLine"></span><?php echo $html->link("Change Password", array("controller"=>"adminusers","action"=>"change_password"),array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'adminusers' && $action == 'admin_updateprofile'){
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li><?php echo $html->link("Edit Profile", array("controller"=>"adminusers","action"=>"updateprofile"), array('class'=>$class), null, false); ?>
									</li>
								</ul>
					
							</li>
							<?php if(in_array(15,$perArr)){?>
							<li>
								<?php if( ($controller == 'settings') && ( in_array($action, array('admin_index', 'admin_delivery_destination','admin_changeurl','admin_addurl'))  ) ){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<?php echo $html->link("Website Settings",'javascript:void(0)' , array('class'=>$class,'id'=>"settings",'onClick'=>'displaydiv(this.id)','escape' => false)); ?>
								<ul id="settings-details" style="display:none;">
									<?php if($controller == 'settings' && $action == 'admin_index'){
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li><span class="topBordLine"></span><?php echo $html->link("Settings", array("controller"=>"settings","action"=>"index"),array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'settings' && $action == 'admin_changeurl'){
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li><?php echo $html->link("Change Url", array("controller"=>"settings","action"=>"changeurl"),array('class'=>$class), null, false); ?></li>
									<!--<li><?php //echo $html->link("Set Minimum Price For All Products", '/crons/', null, false); ?></li>-->
									<?php if($controller == 'settings' && $action == 'admin_delivery_destination'){
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li><?php echo $html->link("Manage Delivery Destinations", '/admin/settings/delivery_destination', array('class'=>$class), null, false); ?></li>
								</ul>
							</li>
							<?php } ?>
                                                        
                                                            </ul>
								</div>
                                                        
                                                        </li>
							
							<?php if(in_array(2,$perArr)){?>
							<?php if($controller == 'users' && ($action == 'admin_index' || $action == 'admin_add' || $action == 'admin_user_changepassword' || $action == 'admin_view' )){
								$class='linkcolor';
							} else{
								$class='';
							}?>
							<li><div class="posRelDiv">
								<?php echo $html->link('Customer <span class="brLine">Management</span> <span class="downArrow"></span>','/admin/users', array('class'=>$class,'id'=>"users",'escape' => false)); ?> 
							</div></li>
							<?php }?>
							<?php if(in_array(3,$perArr)){?>
							<li>
								<?php if($controller == 'sellers'){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<div class="posRelDiv">
								<?php echo $html->link("Seller <span class='brLine'>Management</span> <span class='downArrow'></span>",'/admin/sellers' , array('class'=>$class,'id'=>"sellers",'onClick'=>'displaydiv(this.id)','escape' => false)); ?> 
								<ul id="sellers-details" style="display:none;">
									<?php if($controller == 'sellers' && $action == 'admin_index'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("View All Sellers", '/admin/sellers', array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'sellers' && $action == 'admin_view_bulk_listing'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("Volume Seller's Listing", '/admin/sellers/view_bulk_listing', array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'sellers' && ($action == 'admin_view_seller_payment_listing' || $action == 'admin_edit_account_detail')){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("Seller's Payment Listing", '/admin/sellers/view_seller_payment_listing', array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'sellers' && ($action == 'admin_feedback' || $action == 'admin_edit_feedback')){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li><?php echo $html->link("Seller Feedback", '/admin/sellers/feedback', array('class'=>$class), null, false); ?></li>
								</ul>
								</div>
							</li>
							<?php }?>
							<?php if(in_array(4,$perArr)){?>
							<li>
								<?php if($controller == 'departments' || $controller == 'categories'){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<div class="posRelDiv">
								<?php echo $html->link("Departments/Categories <span class='brLine'>Management</span> <span class='downArrow'></span>",'/admin/departments/home' , array('class'=>$class,'id'=>"departments",'escape' => false)); ?>
							
								</div></li>
							<?php }?>
							<?php if(in_array(5,$perArr)){ ?>
							<li>
								<?php if(($controller == 'products' || $controller == 'homepage_products' || $controller == 'brands' || $controller == 'Brands') || (($controller == 'reviews') && ($action == 'admin_index' || $action == 'admin_add'))|| ($controller == 'product_questions' && ($action == 'admin_index' || $action == 'admin_add' || $action == 'admin_answers' || $action == 'admin_add_answer')) || ($controller == 'products' && $action == 'admin_dataDownload') || ($controller == 'products' && $action == 'download_barcode')){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<div class="posRelDiv">
								<?php echo $html->link("Product <span class='brLine'>Management</span> <span class='downArrow'></span>",'/admin/products', array('class'=>$class,'id'=>"products",'onClick'=>'displaydiv(this.id)','escape' => false)); ?>
								<ul id="products-details" style="display:none;">
									
									<?php if($controller == 'products' && $action == 'admin_index'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									
									<li class="dotted"><?php echo $html->link("View All Products", '/admin/products', array('class'=>$class), null, false); ?></li>
									
									<?php if($controller == 'products' && $action == 'admin_newproducts'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("Seller's New Products", '/admin/products/newproducts', array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'brands' && $action == 'admin_index'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("Product Brands", '/admin/brands', array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'homepage_products' && ($action == 'admin_index' || $action == 'admin_editproducts') ){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("Homepage Products", '/admin/homepage_products', array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'products' && ($action == 'admin_searchtags' || $action == 'admin_add_tags')){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li><?php echo $html->link("Product's Search Tags", '/admin/products/searchtags', array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'products' && $action == 'admin_bulk_upload'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("Upload Products", '/admin/products/bulk_upload', array('class'=>$class), null, false); ?></li>
									<?php if(($controller == 'reviews') && ($action == 'admin_index' || $action == 'admin_add')){
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li class="dotted"><?php echo $html->link("Product Reviews", array("controller"=>"reviews","action"=>"index") , array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'product_questions' && ($action == 'admin_index' || $action == 'admin_add' || $action == 'admin_answers' || $action == 'admin_add_answer')) {
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li class="dotted"><?php echo $html->link("Product Question & Answers", array("controller"=>"product_questions","action"=>"admin_index") , array('class'=>$class), null, false); ?></li>
									
									<?php if($controller == 'products' && $action == 'admin_dataDownload'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									
									<li><?php echo $html->link("Download Data", '/admin/products/dataDownload', array('class'=>$class), null, false); ?></li>
									<!--- <?php if($controller == 'products' && $action == 'download_barcode'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("Barcode Download",'/admin/products/download_barcode' , array('class'=>$class), null, false); ?></li>--->

									
								</ul>
								</div>
							</li>
							<?php }?>
							<?php if(in_array(6,$perArr) || in_array(13,$perArr)){?>
							<li>
								<?php if(($controller == 'orders' || $controller == 'order_returns') || ($controller == 'messages' && ($action == 'admin_index' || $action == 'admin_download_delete_all_messages')) ){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<div class="posRelDiv">
								<?php echo $html->link("Orders <span class='brLine'>Management</span> <span class='downArrow'></span>",'/admin/orders' , array('class'=>$class,'id'=>"orders",'onClick'=>'displaydiv(this.id)','escape' => false)); ?> 
								<ul id="orders-details" style="display:none;">
									<?php if($controller == 'orders' && ($action == 'admin_index' || $action =='admin_order_detail')){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("View Orders", '/admin/orders', array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'orders' && $action == 'admin_search_order'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("Search Orders", '/admin/orders/search_order', array('class'=>$class), null, false); ?></li>
									
									<?php if($controller == 'orders' && $action == 'admin_download_orders'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("Downloads", '/admin/orders/download_orders', array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'orders' && $action == 'admin_refunded_orders'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li class="dotted"><?php echo $html->link("Refunded Orders", '/admin/orders/refunded_orders', array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'orders' && $action == 'admin_cancelled_orders'){
										$class='linkcolor';
									} else{
										$class='';
									} ?>
									<li><?php echo $html->link("Cancelled Orders", '/admin/orders/cancelled_orders', array('class'=>$class), null, false); ?></li>
									
									<?php 
									if($controller == 'order_returns' && ($action == 'admin_index' || $action == 'admin_view')){
										$class = 'linkcolor';
									} else {
										$class = '';
									}
									?>
									<li class="dotted"><?php echo $html->link("Returns management", array("controller"=>"order_returns","action"=>"admin_index") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'order_returns' && ($action == 'admin_claims' || $action == 'admin_claim_details' || $action == 'admin_reply_claim')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li><?php echo $html->link("Claims", array("controller"=>"order_returns","action"=>"admin_claims") , array('class'=>$class), null, false); ?></li>
                                                                        <?php
										if($controller == 'messages' && ($action == 'admin_index')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Monitor communication between buyers and sellers", '/admin/messages/', array('class'=>$class, null, false)); ?></li>
									<?php
										if($controller == 'messages' && ($action == 'admin_download_delete_all_messages')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class=""><?php echo $html->link("Delete Messages", array("controller"=>"messages","action"=>"admin_download_delete_all_messages") , array('class'=>$class), null, false); ?></li>
								
                                                                
                                                                
                                                                </ul>
								</div>
							</li>
							<?php }?>
							<?php if(in_array(7,$perArr)){?>
							<li>
								<?php if($controller == 'faqs' || $controller == 'pages'){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<div class="posRelDiv">
								<?php echo $html->link("Website <span class='brLine'>Pages</span> <span class='downArrow'></span>", array("controller"=>"faqs","action"=>"index") , array('class'=>$class,'id'=>"websites",'onClick'=>'displaydiv(this.id)','escape' => false)); ?>
								<ul id="websites-details" style="display:none;">
									<?php if($controller == 'faqs' && $action == 'admin_index'){
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li class="dotted"><?php echo $html->link("FAQs", array("controller"=>"faqs","action"=>"index") , array('class'=>$class), null,array('escape' => false)); ?></li>
									<?php if($controller == 'pages' && $action == 'admin_index'){
									$class='linkcolor';
									} else{
										$class='';
									}?>
									<li><?php echo $html->link("Static Pages", array("controller"=>"pages","action"=>"index") , array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'pages' && ($action == 'admin_footerdes' || $action == 'admin_adddesc') ){
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li><?php echo $html->link("Footer Description", array("controller"=>"pages","action"=>"footerdes") , array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'pages' && ($action == 'admin_footerbanner' || $action == 'admin_addbanner')){
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li><?php echo $html->link("Footer Scrolling Banners", array("controller"=>"pages","action"=>"footerbanner") , array('class'=>$class), null, false); ?></li>

								</ul>
								</div>
							</li>
							<?php }?>
							<?php if(in_array(8,$perArr)){?>
							<li>
								<?php if($controller == 'email_templates'){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<div class="posRelDiv">
								<?php echo $html->link("Email <span class='brLine'>Templates</span> <span class='downArrow'></span>", array("controller"=>"email_templates","action"=>"index") , array('class'=>$class,'escape' => false)); ?>
								</div></li>
							<?php }?>
							<?php if(in_array(9,$perArr)){?>
							<li class="singleLineLink">
								<?php if(($controller == 'advertisements' || $controller == 'choiceful_favorites' || $controller == 'coupons' || $controller == 'affiliates' || $controller == 'blogs') || ($controller == 'certificates' && ($action == 'admin_index' || $action == 'admin_add' || $action == 'admin_questions')) || ($controller == 'certificates' && ($action == 'admin_searchtags' || $action == 'admin_add_tags')) || ($controller == 'reviews' && ($action == 'admin_gift_certificate' || $action == 'admin_add_gift_certificate'))){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<div class="posRelDiv">
								<?php echo $html->link("Promotions <span class='downArrow'></span>",'/admin/certificates' , array('class'=>$class,'id'=>"promotions",'onClick'=>'displaydiv(this.id)','escape' => false)); ?>
								<ul id="promotions-details" style="display:none;">
									<?php
										$class = ($controller == 'advertisements') ?('linkcolor'):('');
									?>
									<li class="dotted"><?php echo $html->link("Advertisements", array("controller"=>"advertisements","action"=>"index") , array('class'=>$class), null, false); ?></li>
									<?php
										$class = ($controller == 'choiceful_favorites') ?('linkcolor'):('');
									?>
									<li class="dotted"><?php echo $html->link("Choiceful Favorites", array("controller"=>"choiceful_favorites","action"=>"index") , array('class'=>$class), null, false); ?></li>
									<?php
										$class = ($controller == 'coupons') ?('linkcolor'):('');
									?>
									<li class="dotted"><?php echo $html->link("Discount coupons", array("controller"=>"coupons","action"=>"index") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'certificates' && ($action == 'admin_index' || $action == 'admin_add')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Gift Certificates", array("controller"=>"certificates","action"=>"admin_index") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'certificates' && ($action == 'admin_searchtags' || $action == 'admin_add_tags')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Gift Certificate's Search Tags", array("controller"=>"certificates","action"=>"admin_searchtags") , array('class'=>$class), null, false); ?></li>
									
                                                                        <?php if($controller == 'reviews' && ($action == 'admin_gift_certificate' || $action == 'admin_add_gift_certificate')){
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li class="dotted"><?php echo $html->link("Gift Certificate Reviews", array("controller"=>"reviews","action"=>"admin_gift_certificate") , array('class'=>$class), null, false); ?></li>
									<?php if($controller == 'certificates' && ($action == 'admin_questions' || $action == 'admin_add_question' || $action == 'admin_answers' || $action == 'admin_add_answer')){
										$class='linkcolor';
									} else{
										$class='';
									}?>
									<li><?php echo $html->link("Gift Certificate Questions & Answers", array("controller"=>"certificates","action"=>"admin_questions") , array('class'=>$class), null, false); ?></li>
								
                                                                        <?php
                                                                                $class = ($controller == 'blogs') ?('linkcolor'):('');
									?>
									<li><?php echo $html->link("Blog Management", array("controller"=>"blogs","action"=>"index") , array('class'=>$class), null, false); ?></li>
                                                                    <?php if(in_array(10,$perArr)){?>
                                                                            <li>
                                                                                    <?php if($controller == 'affiliates'){
                                                                                            $class='linkcolor';
                                                                                    } else{
                                                                                            $class='';
                                                                                    }?>
                                                                                    <?php echo $html->link("Affiliates", array("controller"=>"affiliates","action"=>"index") , array('class'=>$class,'escape' => false)); ?>
                                                                            </li>
                                                                    <?php }?>
                                                                </ul>
								</div>
							</li>
							<?php }?>
							
							<?php /*if(in_array(13,$perArr)){?>
							<li>
								<?php if($controller == 'order_returns'){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<?php echo $html->link("Customer Service", 'javascript:void(0)', array('class'=>$class,'id'=>"customer_services",'onClick'=>'displaydiv(this.id)'), null, false); ?>
								<ul id="customer_services-details" >
									<?php 
									if($controller == 'order_returns' && ($action == 'admin_index' || $action == 'admin_view')){
										$class = 'linkcolor';
									} else {
										$class = '';
									}
									?>
									<li class="dotted"><?php echo $html->link("Returns management", array("controller"=>"order_returns","action"=>"admin_index") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'order_returns' && ($action == 'admin_claims' || $action == 'admin_claim_details' || $action == 'admin_reply_claim')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li><?php echo $html->link("Claims", array("controller"=>"order_returns","action"=>"admin_claims") , array('class'=>$class), null, false); ?></li>
								</ul>
							</li>
							<?php  } */?>
							<!--- <?php if(in_array(14,$perArr)){?>
							<li>
								<?php if($controller == 'messages'){
									$class='linkcolor';
								} else{
									$class='';
								}
								
								echo $html->link("Messages Management <span class='downArrow'></span>", 'javascript:void(0)', array('class'=>$class,'id'=>"messages",'onClick'=>'displaydiv(this.id)','escape' => false)); ?>
								<ul id="messages-details" style="display:none;">
									<?php
										if($controller == 'messages' && ($action == 'admin_index')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Monitor communication between buyers and sellers", '/admin/messages/', array('class'=>$class, null, false)); ?></li>
									<?php
										if($controller == 'messages' && ($action == 'admin_download_delete_all_messages')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class=""><?php echo $html->link("Delete Messages", array("controller"=>"messages","action"=>"admin_download_delete_all_messages") , array('class'=>$class), null, false); ?></li>
								</ul>
							</li>
							<?php }?>--->
							<?php if(in_array(11,$perArr)){?>
							<li class="singleLineLink" id="repT">
								<?php if(($controller == 'reports')  || ($controller == 'certificates' && ($action == 'admin_total_sales' || $action == 'admin_total_outstandings'))){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<div class="posRelDiv">
								<?php echo $html->link("Reports & Statistics <span class='downArrow'></span>", '/admin/reports/financial_accounting', array('class'=>$class,'id'=>"reports",'onClick'=>'displaydiv(this.id)','escape' => false)); ?>
								<ul id="reports-details" style="display:none;">
									<?php
										if($controller == 'reports' && ($action == 'admin_inventory') ){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Inventory", array("controller"=>"reports","action"=>"admin_inventory") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'reports' && ($action == 'admin_marketplace_highest_products')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Marketplace Seller Report", array("controller"=>"reports","action"=>"admin_marketplace_highest_products") , array('class'=>$class), null, false); ?></li>
									
									<?php
										if($controller == 'reports' && ($action == 'admin_marketplace_earners')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Marketplace Earners", array("controller"=>"reports","action"=>"admin_marketplace_earners") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'certificates' && ($action == 'admin_total_sales')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Gift Certificates Total Sales", array("controller"=>"certificates","action"=>"total_sales") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'certificates' && ($action == 'admin_total_outstandings')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Gift Certificates Total Outstanding", array("controller"=>"certificates","action"=>"total_outstandings") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'reports' && ($action == 'admin_financial_accounting')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Financials & Management A/c Report", array("controller"=>"reports","action"=>"admin_financial_accounting") , array('class'=>$class), null, false); ?></li>
									
									
									<?php
										if($controller == 'reports' && ($action == 'admin_most_viewed_departments')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Most Viewed Departments", array("controller"=>"reports","action"=>"admin_most_viewed_departments") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'reports' && ($action == 'admin_most_viewed_products')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Most Viewed Products", array("controller"=>"reports","action"=>"admin_most_viewed_products/1/total_visits/down") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'reports' && ($action == 'admin_product_reviewed')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Most Reviewed Products", array("controller"=>"reports","action"=>"admin_product_reviewed") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'reports' && ($action == 'admin_product_question')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Most Question/Answer Products", array("controller"=>"reports","action"=>"admin_product_question") , array('class'=>$class), null, false); ?></li>
									<?php
										if($controller == 'reports' && ($action == 'admin_seller_ratings')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<!--li class="dotted"><?php //echo $html->link("Best Seller Ratings", array("controller"=>"reports","action"=>"admin_seller_ratings") , array('class'=>$class), null, false); ?></li-->
									<?php
										if($controller == 'reports' && ($action == 'admin_bestselling_departments')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<li class="dotted"><?php echo $html->link("Bestselling Department", array("controller"=>"reports","action"=>"admin_bestselling_departments") , array('class'=>$class), null, false); ?></li>
									
									<?php
										if($controller == 'reports' && ($action == 'admin_preshipped_cancel_rates')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<!--li class="dotted"><?php //echo $html->link("Pre shipped cancel rates", array("controller"=>"reports","action"=>"admin_preshipped_cancel_rates") , array('class'=>$class), null, false); ?></li-->
										
									<?php
										if($controller == 'reports' && ($action == 'admin_late_shipped_rates')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<!--li class="dotted"><?php //echo $html->link("Late Shipped Rates", array("controller"=>"reports","action"=>"admin_late_shipped_rates") , array('class'=>$class), null, false); ?></li-->
										
									<?php
										if($controller == 'reports' && ($action == 'admin_refund_rates')){
											$class = 'linkcolor';
										} else {
											$class = '';
										}
									?>
									<!--li><?php //echo $html->link("Refunded Rates", array("controller"=>"reports","action"=>"admin_refund_rates") , array('class'=>$class), null, false); ?></li-->
								</ul>
								</div>
							</li>
							<?php  }?>
							
							<!--- <?php if(in_array(12,$perArr)){?>
							<li>
								<?php if($controller == 'reviews' || $controller == 'product_questions'){
									$class='linkcolor';
								} else{
									$class='';
								}?>
								<?php echo $html->link("Reviews &  Q&A Management <span class='downArrow'></span>",'javascript:void(0)' , array('class'=>$class,'id'=>"reviewsqa",'onClick'=>'displaydiv(this.id)','escape' => false)); ?>
								<ul id="reviewsqa-details" style="display:none;">
									</ul>
							</li>
							<?php }?> --->
							
						</ul>
      
    </nav>
    <script>
	
jQuery(document).ready(function() {
	
	jQuery("#jMenu").jMenu();
	
		var WidthSc = screen.availWidth;
		if(WidthSc < 1160){
			jQuery("#repT").removeClass('singleLineLink');
			jQuery("#reports-details").css({'left':'auto','right':'0','color':'red'});
		}
	
});



</script>