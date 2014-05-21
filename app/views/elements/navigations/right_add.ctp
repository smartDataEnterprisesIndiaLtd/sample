<?php 
App::import('Model','Advertisement');
$this->Advertisement = & new Advertisement();
$AdsData = $this->Advertisement->getAdvertisementsList(); ?>
<div class="side-content">
<?php
/******** Right Side Banner # 2 section start here ********/
// show main banner with id = 1
	if(is_array($AdsData) &&  count($AdsData) > 0 ){
		if($AdsData[1]['Advertisement']['status'] == 1){
			if( !empty($AdsData[1]['Advertisement']['banner_image']) || $AdsData[1]['Advertisement']['banner_image'] != 'no_image.gif'){
				$AdsImage = "/".PATH_ADVERTISEMENTS.$AdsData[1]['Advertisement']['banner_image'];
				$adsLabel = ( !empty($AdsData[1]['Advertisement']['bannerlabel']) )?($AdsData[1]['Advertisement']['bannerlabel']):('');
				$adsUrl = ( !empty($AdsData[1]['Advertisement']['bannerurl']) )?($AdsData[1]['Advertisement']['bannerurl']):('#');
				
				echo $html->link($html->image($AdsImage, array('width'=>'168' ,'height'=>'123','border'=>'0' ) ), $adsUrl, array('escape'=>false, 'target'=>'_blank'));
			}
			
		}
	}
/******** Right Side Banner # 2 section End here  ********/
// echo $html->image("subscribe-save-banner.png",array( 'width'=>"168", 'height'=>"123",'alt'=>""));
?>
</div>