<?php 
$user_id = $this->Session->read('User.id');
App::import('Model','Message');
$this->Message = &new Message;
$user_unread_msgs = $this->Message->find('count',array('conditions'=>array('Message.to_user_id'=>$user_id,'Message.to_read_status'=>0)));
?>
<!--Messages Start-->
<div class="side-content">
	<h4 class="right-inner-gray-bg-head"><span>Messages</span></h4>
	<div class="gray-fade-bg-box padding">
		<ul class="inbox-info">
			<li>You are signed in.</li>
			<li class="inbox">
				<?php echo $html->image('inbox-icon.gif',array('width'=>"14", 'height'=>'11'));?>
				<?php echo $html->link("Inbox (".$user_unread_msgs.")","/orders/contact_sellers",array('escape'=>false));?> 
				<?php echo $html->image('right-sep.png',array('width'=>"1", 'height'=>'13'));?>
				<?php echo $html->link("Sign Out","/users/logout/",array('escape'=>false));?>  
			</li>
		</ul>
	</div>
</div>
<!--Messages Closed-->