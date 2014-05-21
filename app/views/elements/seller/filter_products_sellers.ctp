<?php

if(!empty($brand_str)){
	$brandArr = explode(',',$brand_str);
} ?>
<style type="text/css">
	.priceclass{
		width: 30px; padding-left: 3px;
	}
	.go-btn {
height:25px;
}
</style>
<?php 
echo $form->create('Seller',array('action'=>'store','method'=>'POST','name'=>'frmfilter','id'=>'frmfilter'));?>
<!--Filter Search Start-->
<div class="side-content">
	<!--Right Box Start-->
	<div class="wt-top-widget"></div>
	<!-- White Box Start-->
	<div class="white-box">
		<?php if(!empty($dept_count_arr)){ ?>
		<!--Department Start-->
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head"><span>Department</span></h4>
			<ul class="filter-search">
				<?php foreach($dept_count_arr as $dept_id=>$dept_arr){?>
				<li><?php echo $html->link($dept_arr['name'],"javascript:void(0)",array('escape'=>false,'id'=>$dept_id,'onClick'=>'department(this.id);'));?> <span>(<?php echo $dept_arr['count'];?>)</span>
					<?php if(!empty($cate[$dept_id])) {?>
					<ul>
						<?php
						foreach($cate[$dept_id] as $cat_id=>$category){
						if(!empty($category['count'])) {
						?>
						<li><?php echo $html->link($category['name'],"javascript:void(0)",array('escape'=>false,'id'=>$cat_id,'onClick'=>'category(this.id);'));?><span>(<?php echo $category['count'];?>)</span></li>
						<?php } }?>
					</ul>
					<?php }?>
				</li>
				<?php }?>
			</ul>
		</div>
		<!--Department Closed-->
		<?php } ?>
		<?php if(!empty($brands)){ ?>
		<!--Brand Start-->	
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head"><span>Brand</span></h4>
			<ul class="filter-search">
				<?php echo $form->hidden('Seller.id',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$seller_id)); echo $form->hidden('Seller.department',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$department_id)); echo $form->hidden('Seller.category',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$category_id));
				$bra_count = 1;
				foreach($brands as $brand_id=>$brand){
					
					$check_brand = false;
					if(!empty($brandArr)){
						foreach($brandArr as $brandArr_id){
							if($brand_id == $brandArr_id){
								$check_brand = true;
								break;
							}
						}
					}
					
					if($bra_count < 9) { ?>
					<li><?php echo $form->checkbox('selectbrand_id.'.$brand_id,array('value'=>$brand_id,'id'=>'select1','onClick'=>'submitform();','checked'=>$check_brand)); ?> <?php echo  strtolower(ucwords($brand));?> <span>(<?php echo $brand_pro[$brand_id];?>)</span></li>
					<?php } else {
						if($bra_count == 9){?>
							<div style="display:none" id="brands">
						<?php }?>
							<li><?php echo $form->checkbox('selectbrand_id.'.$brand_id,array('value'=>$brand_id,'id'=>'select1','onClick'=>'submitform();','checked'=>$check_brand)); ?> <?php echo  strtolower(ucwords($brand));?> <span>(<?php echo $brand_pro[$brand_id];?>)</span></li>
						<?php if($bra_count == (count($brands))){ ?>
							</div>
						<?php }
					}
				$bra_count ++; } ?>
				<?php if(count($brands) >= 8){ ?>
					<li class="padding-left margin-top"><?php echo $html->link('See More',"javascript:void(0)",array('class'=>"see-more",'escape'=>false,'id'=>'see_more','onClick'=>'see_more(this.id);'));?></li><?php 
				}?>
			</ul>
		</div>
		<!--Brand Closed-->
		<?php }?>
		<!--Avg. Customer Review Start-->
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head"><span>Avg. Customer Review</span></h4>
			<ul class="filter-search">
				<li><?php echo $html->link($html->image('red-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('red-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('red-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('red-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).' &amp; Up ',"javascript:void(0)",array('escape'=>false,'id'=>4,'onClick'=>'return_rate(this.id);'));?><span>(<?php echo $four_rate;?>)</span></li>
				<li><?php echo $html->link($html->image('red-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('red-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('red-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).' &amp; Up ',"javascript:void(0)",array('escape'=>false,'id'=>3,'onClick'=>'return_rate(this.id);'));?><span>(<?php echo $three_rate;?>)</span></li>
				<li><?php echo $html->link($html->image('red-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('red-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).' &amp; Up ',"javascript:void(0)",array('escape'=>false,'id'=>2,'onClick'=>'return_rate(this.id);'));?><span>(<?php echo $two_rate;?>)</span></li>
				<li><?php echo $html->link($html->image('red-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).' &amp; Up ',"javascript:void(0)",array('escape'=>false,'id'=>1,'onClick'=>'return_rate(this.id);'));?><span>(<?php echo $one_rate;?>)</span></li>
				<li><?php echo $html->link($html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).$html->image('gray-star-rating.png',array('alt'=>"",'height'=>"12",'width'=>"12")).' &amp; Up',"javascript:void(0)",array('escape'=>false,'id'=>0,'onClick'=>'return_rate(this.id);'));?><span> (<?php echo $zero_rate;?>)</span><?php echo $form->hidden('Seller.rate',array('class'=>'textfield-input num-width','label'=>false,'div'=>false,'value'=>$rate));?></li>
			</ul>
		</div>
		<!--Avg. Customer Review Closed-->
		<!--Price Start-->	
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head"><span>Price</span></h4>
			<p><strong>Any Price</strong></p>
			<ul class="filter-search">
				<li><?php echo $html->link('£0 - £5',"javascript:void(0)",array('escape'=>false,'id'=>'0-5','onClick'=>'return_price(this.id);'));?> <span>(<?php echo $zero_to_five;?>)</span></li>
				<li><?php echo $html->link('£5 - £10',"javascript:void(0)",array('escape'=>false,'id'=>'5-10','onClick'=>'return_price(this.id);'));?> <span>(<?php echo $five_to_ten;?>)</span></li>
				<li><?php echo $html->link('£10 - £20',"javascript:void(0)",array('escape'=>false,'id'=>'10-20','onClick'=>'return_price(this.id);'));?> <span>(<?php echo $ten_twenty;?>)</span></li>
				<li><?php echo $html->link('£20 - £50',"javascript:void(0)",array('escape'=>false,'id'=>'20-50','onClick'=>'return_price(this.id);'));?> <span>(<?php echo $twenty_fifty;?>)</span></li>
				<li><?php echo $html->link('£50 - £100',"javascript:void(0)",array('escape'=>false,'id'=>'50-100','onClick'=>'return_price(this.id);'));?> <span>(<?php echo $fifty_hundred;?>)</span></li>
				<li><?php echo $html->link('£100 - £200',"javascript:void(0)",array('escape'=>false,'id'=>'100-200','onClick'=>'return_price(this.id);'));?> <span>(<?php echo $hundred_2hundred;?>)</span></li>
				<li><?php echo $html->link('£200 - £500',"javascript:void(0)",array('escape'=>false,'id'=>'200-500','onClick'=>'return_price(this.id);'));?> <span>(<?php echo $twohundred_5hundred;?>)</span></li>
				<li><?php echo $html->link('over 500',"javascript:void(0)",array('escape'=>false,'id'=>'500-','onClick'=>'return_price(this.id);'));?> <span>(<?php echo $fivehundred_above;?>)</span></li>
			</ul>
			<p class="to-from">£
				<?php echo $form->input('Seller.from_price',array('class'=>'textfield priceclass','label'=>false,'div'=>false,'value'=>$from_price));?> to £
				<?php echo $form->input('Seller.to_price',array('class'=>'textfield priceclass','label'=>false,'div'=>false,'value'=>$to_price));?> 
				<?php echo $form->hidden('Seller.sort1',array('class'=>'textfield priceclass','label'=>false,'div'=>false,'value'=>$sort));?>
				<?php echo $form->button('',array('alt'=>'Go','type'=>'submit','value'=>"",'border'=>'0','class'=>'go-btn','div'=>false)); ?>
			</p>
		</div>
		<!--Price Closed-->
	</div>
	<!-- White Box Closed-->
</div>
<!--Filter Search Closed-->
<?php echo $form->end();?>
<script type="text/javascript">
	function submitform(){
		document.frmfilter.submit();
	}

	function return_rate(rate){
		jQuery('#SellerRate').val(rate);
		document.frmfilter.submit();
	}
	
	function return_price(price){
		
		var priceArr = Array();
		priceArr = price.split('-');
		
		if(priceArr[0]){
			var from = priceArr[0];
		}
		if(priceArr[1]){
			var to = priceArr[1];
		} else{

			var to = 0;
		}

		jQuery('#SellerFromPrice').val(from);
		jQuery('#SellerToPrice').val(to);
		document.frmfilter.submit();
	}

	function see_more(){
		jQuery('#brands').css('display','block');
		jQuery('#see_more').css('display','none');
	}


	function category(cat_id){
// 		//alert(cat_id);
		jQuery('#SellerCategory').val(cat_id);
		document.frmfilter.submit();
	}

	function department(dept_id){
		jQuery('#SellerDepartment').val(dept_id);
		document.frmfilter.submit();
	}
</script>