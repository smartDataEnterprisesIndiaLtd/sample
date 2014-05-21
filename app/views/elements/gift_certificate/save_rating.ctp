<?php
	$saveRating = 'saveRating_giftcertificate';
	$rating_value = 'giftRating_value';
	$ratingSession = $this->Session->read($saveRating);
	$ratingValueSession = $this->Session->read($rating_value);
	$saved_rating = $ratingValueSession;
?>
<p><?php
	if(!empty($full_stars)){
		for($avgrate = 0;  $avgrate < $full_stars; $avgrate++){
			echo $html->image("orang-star.png",array('width'=>"21",'height'=>"21", 'alt'=>"" ));
		}
		if(!empty($half_star)){
			echo $html->image("orng-star-half.png",array('width'=>"21",'height'=>"21", 'alt'=>"" ));
			$avg_rating = $full_stars + 1;
		} else{
			$avg_rating = $full_stars;
		}
		for($avgrate_white = 0;  $avgrate_white < (5-$avg_rating); $avgrate_white++){
			echo $html->image("gry-star.png",array('width'=>"21",'height'=>"21", 'alt'=>"" ));
		}
	} else{
		for($avgrate_white = 0;  $avgrate_white < 5; $avgrate_white++){
			echo $html->image("gry-star.png",array('width'=>"21",'height'=>"21", 'alt'=>"" ));
		}
	}
?></p>
<ul><li class="gray smalr-fnt">Average Rating (<?php echo $total_rating_reviewers;?> reviews)</li> <li><?php if(empty($ratingSession)) { ?>  <?php 
echo $html->link("x","javascript:void(0)",array('escape'=>false,'title'=>'unrate','alt'=>'unrated','onMouseover'=>'change_star(\'0\');','onMouseout'=>'change_toblstar(\'0\');','onClick'=>'save_rating(\'0\');'));?> | <?php 
echo $html->link($html->image("bl-start.png",array('alt'=>'I hate it','id'=>'s_1','width'=>"12",'height'=>"12", 'alt'=>"I hate it" )),"javascript:void(0)",array('escape'=>false,'title'=>'I hate it','alt'=>'1 star','onMouseover'=>'change_star(\'1\');','onMouseout'=>'change_toblstar(\'1\');','onClick'=>'save_rating(\'1\');'));?><?php echo $html->link( $html->image("bl-start.png",array('id'=>'s_2','alt'=>'I don\'t like it','width'=>"12",'height'=>"12", 'alt'=>"I don\'t like it" )),"javascript:void(0)",array('escape'=>false,'title'=>'I don\'t like it','alt'=>'I don\'t like it','onMouseover'=>'change_star(\'2\');','onMouseout'=>'change_toblstar(\'2\');','onClick'=>'save_rating(\'2\');'));?><?php echo $html->link($html->image("bl-start.png",array('id'=>'s_3','width'=>"12",'height'=>"12", 'alt'=>"It\'s ok" )),"javascript:void(0)",array('escape'=>false,'title'=>'It\'s ok','alt'=>'It\'s ok','onMouseover'=>'change_star(\'3\');','onMouseout'=>'change_toblstar(\'3\');','onClick'=>'save_rating(\'3\');'));?><?php echo $html->link($html->image("bl-start.png",array('id'=>'s_4','width'=>"12",'height'=>"12", 'alt'=>"I like it" )),"javascript:void(0)",array('escape'=>false,'title'=>'I like it','alt'=>'I like it','onMouseover'=>'change_star(\'4\');','onMouseout'=>'change_toblstar(\'4\');','onClick'=>'save_rating(\'4\');'));?><?php echo $html->link($html->image("bl-start.png",array('id'=>'s_5','width'=>"12",'height'=>"12", 'alt'=>"I couldn't be happy without it" )),"javascript:void(0)",array('escape'=>false,'title'=>'I love it','alt'=>'I love it it','onMouseover'=>'change_star(\'5\');','onMouseout'=>'change_toblstar(\'5\');','onClick'=>'save_rating(\'5\');'));?>    <span id="ratetext" class="rate-it-text" style="padding-left:15px">Rate it</span> </li></ul><?php } else { for($s_i = 1; $s_i <= $saved_rating; $s_i++){ 
if($s_i == 1){
$text = 'I hate it';
} else if($s_i == 2){
$text = 'I don\'t like it';
}  else if($s_i == 3){
$text = 'It\'s ok';
}  else if($s_i == 4){
$text = 'I like it';
}  else if($s_i == 5){
$text = 'I love it';
}
echo $html->image("blue-star.png",array('id'=>'s_'.$s_i,'width'=>"12",'height'=>"12", 'alt'=>$text ));
//echo $html->link($html->image("blue-star.png",array('id'=>'s_'.$s_i,'width'=>"12",'height'=>"12", 'alt'=>$text )),"javascript:void(0)",array('escape'=>false,'title'=>$text,'alt'=>$text,'onMouseover'=>'change_star(\''.$s_i.'\',\'1\');','onMouseout'=>'change_toblstar(\''.$s_i.'\',\'1\','.$saved_rating.');','onClick'=>'save_rating(\''.$s_i.'\');'));
}
for($s_j = $s_i; $s_j <= 5; $s_j++){
if($s_j == 1){
$textj = 'I hate it';
} else if($s_j == 2){
$textj = 'I don\'t like it';
}  else if($s_j == 3){
$textj = 'It\'s ok';
}  else if($s_j == 4){
$textj = 'I like it';
}  else if($s_j == 5){
$textj = 'I love it';
}
echo $html->image("bl-start.png",array('id'=>'s_'.$s_j,'alt'=>$textj,'width'=>"12",'height'=>"12", 'alt'=>$textj ));
//echo $html->link( $html->image("bl-start.png",array('id'=>'s_'.$s_j,'alt'=>$textj,'width'=>"12",'height'=>"12", 'alt'=>$textj )),"javascript:void(0)",array('escape'=>false,'title'=>$textj,'alt'=>$textj,'onMouseover'=>'change_star(\''.$s_j.'\',\'1\');','onMouseout'=>'change_toblstar(\''.$s_j.'\',\'1\',\''.$saved_rating.'\');','onClick'=>'save_rating(\''.$s_j.'\');'));
}
echo ' <span style="color:red">Saved</span>'; ?> </span> </p> <?php } ?>
<p id ="giftVoteId">
<?php echo $this->element('gift_certificate/certificate_vote');?>
</p>