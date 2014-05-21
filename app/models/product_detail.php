<?php
/**
* Product Model class
*/
class ProductDetail extends AppModel {

	var $name = 'ProductDetail';
	var $validate = array(
		'condition' => array(
			'rule' => 'notEmpty',
			'message' => "Select product condition",
		),
		'brand_name' => array(
			'rule' => 'notEmpty',
			'message' => "Enter brand name",
		),
		'author_name' => array(
			'rule' => 'notEmpty',
			'message' => "Enter author name",
		),
		'publisher' => array(
			'rule' => 'notEmpty',
			'message' => "Enter publisher ",
		),
		'product_isbn' => array(
			'rule' => 'notEmpty',
			'message' => "Enter isbn ",
		),
		'format' => array(
			'rule' => 'notEmpty',
			'message' => "Enter format",
		),
		'artist_name' => array(
			'rule' => 'notEmpty',
			'message' => "Enter artist name",
		),
		'label' => array(
			'rule' => 'notEmpty',
			'message' => "Enter label ",
		),
		'rated' => array(
			'rule' => 'notEmpty',
			'message' => "Enter rated",
		),
		'studio' => array(
			'rule' => 'notEmpty',
			'message' => "Enter studio ",
		),
		'movie_language' => array(
			'rule' => 'notEmpty',
			'message' => "Enter language",
		),
		'plateform' => array(
			'rule' => 'notEmpty',
			'message' => "Enter plateform",
		),
		'region' => array(
			'rule' => 'notEmpty',
			'message' => "Enter region",
		),
		'suitable_for' => array(
			'rule' => 'notEmpty',
			'message' => "Enter suitable_for",
		),
		'hazard_caution' => array(
			'rule' => 'notEmpty',
			'message' => "Enter hazard caution",
		),
		'precautions' => array(
			'rule' => 'notEmpty',
			'message' => "Enter precautions",
		),
		'ingredients' => array(
			'rule' => 'notEmpty',
			'message' => "Enter ingredients",
		),		
		'description' => array(
			'rule' => 'notEmpty',
			'message' => "Enter product description",
			),
		'product_searchtag' => array(
			'rule' => 'notEmpty',
			'message' => "Enter search keywords",
			),
	);
/* ************************************************** */	
/* ************************************************** */
}
?>