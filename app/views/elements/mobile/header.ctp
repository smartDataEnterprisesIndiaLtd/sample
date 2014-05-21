<?php
$user_session = $this->Session->read('User');
	$ip=$_SERVER['REMOTE_ADDR'];
	App::import('Model','Visitor');
	$this->Visitor = & new Visitor();
	
	$this->data['Visitor']['ip_add'] = $ip;
	$ip_visitor_info = $this->Visitor->find('first',array('conditions'=>array('Visitor.ip_add'=>$ip)));
	if(!empty($ip_visitor_info)){
		$ip_visitor_time = strtotime($ip_visitor_info['Visitor']['created']);
	} else{
		$ip_visitor_time = 0;
	}
	
	$current_time = strtotime(date('d-m-Y H:i:s'));
	if(($current_time - $ip_visitor_time) >= (15*60)){
		if(!empty($ip_visitor_info)){
			$this->Visitor->id = $ip_visitor_info['Visitor']['id'];
			$this->Visitor->delete();
		}
		$insert_flag = 0;
	} else{
		$insert_flag = 1;
	}
	
	if($insert_flag == 0){
		$this->data['Visitor']['id'] = 0;
		$this->data['Visitor']['ip_add'] = $ip;
		$this->Visitor->set($this->data);
		$this->Visitor->save();
	}
?>
<script type="text/javascript">
	var SITE_URL = "<?php echo SITE_URL?>";
/** function to show updated cart in header**/
	jQuery(document).ready(function()  {
		showUpdatedCart();
	});





// function to show updated mini shopping cart on the page
function showUpdatedCart(){
	var postUrl = SITE_URL+'baskets/minibasket/2'
	//alert(postUrl);
	jQuery.ajax({
		cache: false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#shopping_basket_id').html(msg);
	}
	});		  
}

// function to add item to cart
function addToBasket(product_id, qty_field_id,price,seller_id,condition){
	//alert(product_id);
	
	//price = 1450;
	if(qty_field_id == 1 ){ 
		var qty = '1';
	} else if( parseInt(qty_field_id) > 0 ){
		var qty = qty_field_id; 
	}else{
		var quantity_field_id = "#"+qty_field_id ;
		var qty = jQuery(quantity_field_id).val();
		if(qty == '' ||  qty == '0'){ // skip the action if qty is not proper 
			return false;
			//qty = 1;
		}
	}
	var postUrl = SITE_URL+'baskets/add_to_basket/'+product_id+'/'+qty+'/'+price+'/'+seller_id+'/'+condition;
	//alert(postUrl);
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#shopping_basket_id').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}


</script>
	<!--Header Starts-->
             <header id="header">
			<h1 class="site-logo"><?php echo  $html->link('choiceful.com','/',array('escape'=>false));?></h1>
			<!---->
			<?php
			
				echo $this->element('mobile/basket/header_minibasket');
			?> 
             </header>
          <!--Header End-->
