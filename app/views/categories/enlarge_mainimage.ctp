<?php  ?>
<div style=" width:100%; margin:0px;">
	<!--<div style="font-size:11px;font-weight:bold;margin-left:15px;" >-->
	<div style="font-size:11px;" ><?php echo $html->image('Choiceful-LO-FF_30.jpg', array('alt'=>""));?></div>
	<!--<div style="font-size:11px;font-weight:bold;margin-top:10px;margin-left:15px">-->
	<div style="font-size:9px;font-family:arial; margin-top:5px;">
	<?php echo $main_image['Product']['product_name'];?></div>
	<!--<div style="border:1px solid #EFEFEF;text-align:center;padding:5px 5px;margin:0px 5px; min-height:200px">-->
	<div style="border:1px solid #EFEFEF;text-align:center;min-height:200px">
	<?php
	if(!empty($main_image['Product']['image'])){
		$main_imagePath2 = WWW_ROOT.PATH_PRODUCT.'large/img_400_'.$main_image['Product']['image'];
		if(file_exists($main_imagePath2)){
			echo $html->image('/'.PATH_PRODUCT.'large/img_400_'.$main_image['Product']['image'], array('alt'=>$main_image["Product"]["product_name"],'title'=>$main_image["Product"]["product_name"]));
		}else{
			echo $html->image('/img/no_image_400.jpg', array('alt'=>$main_image["Product"]["product_name"],'title'=>$main_image["Product"]["product_name"]));
		}
	}else{
		echo $html->image('/img/no_image_400.jpg', array('alt'=>$main_image["Product"]["product_name"],'title'=>$main_image["Product"]["product_name"]));
	}
	?>
	</div>
</div>