<?php
/**
* ProductRating Model class
*/
class ProductRating extends AppModel {
	var $name = 'ProductRating';
	var $assocs = array(
			'Product' => array(
				'type' => 'belongsTo',
				'className' => 'Product',
			),
		);	
			
			
	function get_avg_rating($product_id = null){
		$avg_rating = 0;
		$total_count = 1;
		$total_rating = 0;
		$full_stars = 0;
		$avg_rating_temp = 0;
		$all_ratings = $this->find('all',array('conditions'=>array('ProductRating.product_id'=>$product_id)));
		
		if(!empty($all_ratings)){
			foreach($all_ratings as $rating){
				$total_rating = $total_rating+$rating['ProductRating']['rating'];
			}
			$total_count = count($all_ratings);
		}
		$avg_rating_temp = $total_rating/$total_count;
		$avg_rating = round($avg_rating_temp, 1);
		$half_star = 0;
			
		if(!empty($avg_rating)){
			$avg_rate_arr = explode('.',$avg_rating);
			if(!empty($avg_rate_arr[1])){
				for($i = 0; $i < 1; $i++){
					if($avg_rate_arr[1][$i] >= 5){
						$half_star = 1;
					}
				}
			}
			$full_stars = $avg_rate_arr[0];
		}
		if(!empty($avg_rating_temp))
			$total_rating_reviewers = $total_count;
		else
			$total_rating_reviewers = 0;
		$avg_rate['save_avg'] = $avg_rating;
		$avg_rate['full_stars'] = $full_stars;
		$avg_rate['half_star'] = $half_star;
		$avg_rate['total_rating_reviewers'] = $total_rating_reviewers;
		return $avg_rate;
	}
}
?>