 <?php
 $last_page_url = $this->Session->read('last_page_url');
 //pr($last_page_url);
 //create_product_step3
 if($last_page_url == 'sign_up' ){ // show 5 steps navigation ?>
<div class="side-content">
	<h4 class="inner-gr-bg-head"><span>Join &amp; List Products Free!</span></h4>
	<div class="gray-fade-bg-box padding white-bg-box">
		<ul class="steps-widget">
			<li><strong>Steps to Start Selling</strong></li>
			<li>
				<h3 class="orange-col-head">Step 1</h3>
				<?php
				if($this->params['controller'] == 'sellers' &&  ($this->params['action'] == 'sign_up' || $this->params['action'] == 'review_listing' )){ ?>
				<p class="arrow-bg">Register as a Seller</p>
				<?php }else{ ?>
				<p >Register as a Seller</p>
				<?php }?>
			</li>
			<li>
				<h3 class="orange-col-head">Step 2</h3>
				<?php
				if($this->params['controller'] == 'marketplaces' &&  ($this->params['action'] == 'search_results')){ ?>
					<p class="arrow-bg">Find your product.</p>
				<?php }else{ ?>
					<p>Find your product.</p>
				<?php }	?>

			</li>
			<li>
				<h3 class="orange-col-head">Step 3</h3>
				<?php
				if($this->params['controller'] == 'marketplaces' &&  $this->params['action'] == 'create_listing' ){
					echo '<p class="arrow-bg">Enter the price, and quantity you have for sale, and select the delivery method.</p>';
				}else{
					echo '<p>Enter the price, and quantity you have for sale, and select the delivery method.</p>';	
				}
				?>
				
			</li>
			<li>
				<h3 class="orange-col-head">Step 4</h3>
				<?php
				if($this->params['controller'] == 'marketplaces' &&  ($this->params['action'] == 'confirm_listing' || $this->params['action'] == 'review_listing' )){ ?>
					<p class="arrow-bg">Finally review and confirm your product before it's listed.</p>
				<?php }else{ ?>
					<p>Finally review and confirm your product before it's listed.</p>
				<?php }	?>
				
			</li>
			<li>
				<h3 class="orange-col-head">Step 5</h3> 
				<p>Enter your payment setting so that we can send you your money.</p>
			</li>
		</ul>
	</div>
</div>

 <?php  }else{  // show 5 steps navigation ?>
<div class="side-content">
	<h4 class="inner-gr-bg-head"><span>Complete your Listing</span></h4>
	<div class="gray-fade-bg-box padding white-bg-box">
		<ul class="steps-widget">
			<li><strong>Tell us about your Product</strong></li>
			<li>
				<h3 class="orange-col-head">Step 1</h3>
				<?php
				if($this->params['controller'] == 'marketplaces' &&  $this->params['action'] == 'create_listing' ){
					echo '<p class="arrow-bg">Enter the price, and quantity you have for sale, and select the delivery method.</p>';
				}else{
					echo '<p>Enter the price, and quantity you have for sale, and select the delivery method.</p>';	
				}
				?>
				
			</li>
			<li>
				<h3 class="orange-col-head">Step 2</h3>
				<?php
				if($this->params['controller'] == 'marketplaces' &&  ($this->params['action'] == 'confirm_listing' || $this->params['action'] == 'review_listing' )){ ?>
					<p class="arrow-bg">Finally review and confirm your product before it's listed.</p>
				<?php }else{ ?>
					<p>Finally review and confirm your product before it's listed.</p>
				<?php }	?>
				
			</li>
			<li>
				<h3 class="orange-col-head">Step 3</h3> 
				<p>Enter your payment setting so that we can send you your money.</p>
			</li>
		</ul>
	</div>
</div>

<?php  } ?>
<!--Choiceful Services Closed-->
