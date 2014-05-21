<?php ?>
<ul class="pop-con-list">
<!-- 	<li><h4 class="dif-blue-color">Video</h4></li> -->
	<li>
		<?php if(!empty($video_src['Product']['product_video'])) { 
			//$video_src['Product']['product_video'] = 'http://www.youtube.com/embed/MbO3o2_IWRg';
			$src = str_replace('embed','v',$video_src['Product']['product_video']);
			?>
			<!--<iframe src="<?php //echo $video_src['Product']['product_video'];?>&ap=%2526fmt%3D18&autoplay=1&rel=0&fs=1" width="610px" height="360px" scrolling="no" style="border-width: 0px;">Your browser does not support iframes.</iframe>-->

			<object height="400" width="640" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
				<param value="true" name="allowFullScreen"></param>
				<param value="always" name="allowscriptaccess"></param>
				<param value="<?php echo $video_src['Product']['product_video'];?>&amp;hl=en_US&amp;fs=0&amp;autoplay=1&amp;rel=0&amp;hd=1&amp;loop=1&amp;showinfo=0&amp;cc_load_policy=1&amp;showsearch=0" name="src"></param>
				<param value="true" name="allowfullscreen"></param>
				<embed height="400" width="640" allowfullscreen="true" allowscriptaccess="always" src="<?php echo $video_src['Product']['product_video'];?>&amp;hl=en_US&amp;fs=1&amp;autoplay=1&amp;rel=0&amp;hd=1&amp;loop=1&amp;showinfo=0&amp;cc_load_policy=1&amp;showsearch=0" type="application/x-shockwave-flash"></embed>
			</object>


		<?php } else{ echo 'No video available'; } ?>
	</li>
</ul>