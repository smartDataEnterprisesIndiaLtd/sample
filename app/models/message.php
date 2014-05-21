<?php
/**
* Message Model class
*/
class Message extends AppModel {
	var $name = 'Message';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'from_user_id',
			'fields'=>array('User.id', 'User.firstname', 'User.lastname'),
		),
		'UserSeller' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'to_user_id',
			'fields'=>array('UserSeller.id', 'UserSeller.firstname', 'UserSeller.lastname'),
		),
		'UserSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'to_user_id',
		),
		'FromUserSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'from_user_id',
		),
		'ToUserSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'to_user_id',
		),
		'OrderItem' => array(
			'type' => 'belongsTo',
			'className' => 'OrderItem',
			'foreignKey' => 'order_item_id',
		),
	);
	var $validate = array(
		'message' => array(
			'rule' => 'notEmpty',
			'message' => "Enter message",
		),
		'action' => array(
			'rule' => 'notEmpty',
			'message' => "Enter action",
		),
	);

// 	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
// 		$sql = "SELECT DISTINCT ON(week, home_team_id, away_team_id) week, home_team_id, away_team_id FROM games";
// 		$this->recursive = $recursive;
// 		$results = $this->query($sql);
// 		return count($results);
// 	}
	
	
// 	function paginateCount1($conditions = null, $recursive = 0, $extra = array()) {
// 
// 		$sql = "SELECT DISTINCT ON(week, home_team_id, away_team_id) week, home_team_id, away_team_id FROM games";
// 		
// 		$sql = "SELECT DISTINCT to_user_id,from_user_id FROM `messages` AS `Message` LEFT JOIN `users` AS `FromUserSummary` ON (`Message`.`from_user_id` = `FromUserSummary`.`id`) LEFT JOIN `users` AS `ToUserSummary` ON (`Message`.`to_user_id` = `ToUserSummary`.`id`) WHERE ((`Message`.`to_user_id` = 2) OR (`Message`.`from_user_id` = 2))";
// // 		$this->recursive = $recursive;
// 		$results = $this->query($sql);
// 		return count($results);
// 	}


// 	function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
// 		$recursive = -1;
// 		$group = $fields = array('week', 'away_team_id', 'home_team_id');
// 		return $this->find('all', compact('conditions', 'fields', 'order', 'limit', 'page', 'recursive', 'group'));
// 	}


	
// 	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
// 		pr($extra);
// 		if(empty($extra))
// 			return parent::paginateCount($conditions, $recursive);
// 		else {
// 			if(!empty($extra['useCustom'])){
// 				$sql = "SELECT `Message`.`to_user_id`, `Message`.`from_user_id`, `FromUserSummary`.`id`, `FromUserSummary`.`firstname`, `FromUserSummary`.`lastname`, `FromUserSummary`.`email`, `ToUserSummary`.`id`, `ToUserSummary`.`firstname`, `ToUserSummary`.`lastname`, `ToUserSummary`.`email` FROM `messages` AS `Message` LEFT JOIN `users` AS `FromUserSummary` ON (`Message`.`from_user_id` = `FromUserSummary`.`id`) LEFT JOIN `users` AS `ToUserSummary` ON (`Message`.`to_user_id` = `ToUserSummary`.`id`) WHERE ((`Message`.`to_user_id` = 2) OR (`Message`.`from_user_id` = 2)) GROUP BY `Message`.`to_user_id`, `Message`.`from_user_id`";
// 				$this->recursive = $recursive;
// 				$results = $this->query($sql);
// 				return count($results);
// 			} else{
// 				return parent::paginateCount($conditions, $recursive);
// 			}
// 		}
// 		// code to handle custom paginate count here
// 	}

}
?>