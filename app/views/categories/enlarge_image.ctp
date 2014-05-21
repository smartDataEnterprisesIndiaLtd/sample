<?php ?>
<div style=" width:100%;">
	<div style="font-size:11px;font-weight:bold;margin-left:15px"><?php echo $html->image('Choiceful-LO-FF_30.jpg', array('alt'=>""));?></div>
	<div style="font-size:11px;font-weight:bold;margin-top:10px;margin-left:15px"><?php echo $main_image['product_name'];?></div>
	<div style="border:1px solid #EFEFEF;text-align:center;padding:10px 10px;margin:0px 5px; min-height:200px">
	<?php
	if(!empty($main_image['image'])){
		$main_imagePath2 = WWW_ROOT.PATH_PRODUCT.'large/img_400_'.$main_image['image'];
		if(file_exists($main_imagePath2)){
			echo $html->image('/'.PATH_PRODUCT.'large/img_400_'.$main_image['image'],array('alt'=>""));
		}
	}else{
		echo $html->image('/img/no_image_200.jpg', array('alt'=>$main_image["Product"]["product_name"],'title'=>$main_image["Product"]["product_name"]));
	}
	
	?>
	</div>
</div>