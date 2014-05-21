<?php
/**
 *
* SpecialProduct Model class
*/
class HomepageProduct extends AppModel {
	var $name = 'HomepageProduct';
 	var $assocs = array(
 		'Department' => array(
 			'type' => 'belongsTo',
 			'className' => 'Department',
 			'foreignKey' => 'department_id',
 		)
 	);
	
	var $validate = array(
		'hot_pick' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'hot_product'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'day_pick_1'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'day_pick_2'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'day_pick_3'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading1'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter heading #1",
				'last' => true
			)
		),
		'heading1_product1'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading1_product2'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading2'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter heading #2",
				'last' => true
			)
		),
		'heading2_product1'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading2_product2'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading3'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter heading #3",
				'last' => true
			)
		),
		'heading3_product1'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading3_product2'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading3_product3'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading3_product4'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading4'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter heading #4",
				'last' => true
			)
		),
		'heading4_product1'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading4_product2'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading4_product3'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'heading4_product4'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'release1_product1'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			) 
		),
		'release1_product2'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			) 
		),
		'release1_product3'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'release1_product4'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'release2_product1'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			) 
		),
		'release2_product2'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			) 
		),
		'release2_product3'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'release2_product4'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'release3_product1'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			) 
		),
		'release3_product2'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			) 
		),
		'release3_product3'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'release3_product4'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'customer_product1'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'customer_product2'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'customer_product3'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'customer_product4'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'customer_product5'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'customer_product6'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		),
		'customer_product7'=> array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Enter quick code",
				'last' => true
			)
		)
		
	);
} /************************************ */ 
?>