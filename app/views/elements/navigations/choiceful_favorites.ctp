<?php

# get a list of all active choiceful favorites
App::import('Model','ChoicefulFavorite');
$this->ChoicefulFavorite = & new ChoicefulFavorite();
$CFData = $this->ChoicefulFavorite->find('all', array('conditions'=> array('status'=>1)  ) );

// pr($CFData); ?>
<!--Choiceful Favorites Start-->
<div class="side-content">
	<h4 class="gray-bg-head"><span class="choco-colr">Choiceful Favorites</span></h4>
	<div class="gray-fade-bg-box">
		<ul class="ads">
		<?php
		if(is_array($CFData) &&  count($CFData) > 0 ){
			foreach($CFData as $key=>$value){
				if($value['ChoicefulFavorite']['image'] != 'no_image.gif'){
					if($value['ChoicefulFavorite']['image'] == 'no_image.gif' || $value['ChoicefulFavorite']['image'] == 'no_image.jpeg'){
						$image_path = 'no_image.jpeg';
						$CFUrl = "#";
					} else{
						$image_path = '/'.PATH_CHOICEFUL_FAVORITE.$value['ChoicefulFavorite']['image'];
						$CFUrl = $value['ChoicefulFavorite']['favorite_url'];
					}
					$imagePath = WWW_ROOT.$image_path;
					
					if(file_exists($imagePath)){
						$arrImageDim = $format->custom_image_dimentions($imagePath, 150, 35);
					}?>
					<li>
					<?php echo $html->link($html->image($image_path, array('width'=>$arrImageDim['width'] ,'border'=>'0' ) ), $CFUrl, array('escape'=>false,'target'=>'_blank')); ?>
					</li>
				<?php }
			}
			unset($value);
		}
		?>
		</ul>
	</div>
</div>
<!--Choiceful Favorites Closed-->