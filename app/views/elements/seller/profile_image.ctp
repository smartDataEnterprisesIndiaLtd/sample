<?php
if($seller_info['Seller']['image'] == 'no_image.gif' || $seller_info['Seller']['image'] == 'no_image.jpeg'){
	
} else{
    
    $image_path = 'sellers/'.$seller_info['Seller']['image'];
	$imagePath = SITE_URL.'img/'.$image_path ;
        if(file_get_contents($imagePath)){
       
        ?>
	<div class="right-content-img-sec"><?php echo $html->link($html->image($image_path,array('alt'=>"",'width'=>100,'height'=>30)),'/sellers/store/'.$seller_id,array('escape'=>false,'class'=>'underline-link'));?></div>
<?php } }
?>