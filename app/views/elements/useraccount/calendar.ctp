<style type="text/css">
.event-ul a:hover{
text-decoration:underline;
}
</style>
<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#createevent').click(function(){
		if(jQuery("#EventMessage").val() != "")
		{
			jQuery("#createevent").attr("disabled", "true"); 
		}
	});
});
</script>

<?php
if ($session->check('Message.flash')){ ?>
<div >
	<div class="messageBlock"><?php echo $session->flash();?></div>
</div>
<?php } ?>
	<?php
	if(!empty($errors)){
		$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
		?>
		<div class="error_msg_box" style="margin-right: 2px;"> 
			<?php echo $error_meaasge;?>
		</div>
	<?php }?>
<div class="calendar">
<!-- 	<ul> -->
		<?php 
		$month_name = $month;
		$month_number = "";
		for($mi=1;$mi<=12;$mi++){
			if(strtolower(date("F", mktime(0, 0, 0, $mi, 1, 0))) == strtolower($month_name)){  
				$month_number = $mi;
				break;
			}  
		}
		  
		for($m2i=1;$m2i<=12;$m2i++){
			if(strtolower(date("M", mktime(0, 0, 0, $m2i, 1, 0))) == strtolower($month_name)){  
				$month2_number = $m2i;
				break;
			}
		}
		if(empty($month_number)){
			if(!empty($month2_number))
				$month_number = $month2_number;
		}
		$start_date = $year.'-'.$month_number.'-1';
		$end_date = $year.'-'.$month_number.'-31';
		?>
<!-- 		<li style="padding:0px"><?php echo $calendar->calendar($year, $month, null, $base_url,0);?></li> -->
		<?php echo $calendar->calendar($year, $month, null, $base_url,0);?>
<!-- 	</ul> -->
</div>
<!--Event Start-->

<?php echo $form->create('User',array('action'=>'add_event','method'=>'POST','name'=>'frmEvent','id'=>'frmEvent'));?>
<div class="event-widget">
	<h5>Event</h5>
	<ul class="event-ul">
		<li><label style="padding-top:5px">When:</label>
		<?php if(!empty($this->data)){
			if(!empty($this->data['Event']['event_date'])){
				$event_date_display = date(DISPLAY_CAL_DATE_YEAR, strtotime($this->data['Event']['event_date']));
				$event_date_database = date(Configure::read('date_Ymj'), strtotime($this->data['Event']['event_date']));
				
			} else{
				$event_date_display = '';
				$event_date_database = '';
			}
			} else{
				$event_date_display = '';
				$event_date_database = '';
			}
		?>
		<div class="rgt-col-wdgt" id="displaydate" style="padding-top:3px;font-size: 11px;font-weight:bold"><?php echo $event_date_display;?></div>
		<?php echo $form->hidden('Event.eventdate',array('size'=>'30','class'=>'form-textfield','maxlength'=>'30','label'=>false,'div'=>false,'error'=>false,'value'=>@$event_date_database));?>
		<?php if(!empty($this->data)) {
			if(empty($this->data['Event']['id']))
				$this->data['Event']['id']  = 0;
			 echo $form->input('Event.id',array('size'=>'30','class'=>'form-textfield','maxlength'=>'30','label'=>false,'div'=>false,'error'=>false,'value'=>$this->data['Event']['id']));}?></li>
		<li><label>What:</label>
			<div class="rgt-col-wdgt">
			<?php
				if(!empty($errors['message'])){
					$errorMessage='form-textfield error-right error_message_box';
				}else{
					$errorMessage='form-textfield error-right';
				}
			if(empty($this->data['Event']['message'])) echo $form->input('Event.message',array('size'=>'30','class'=>$errorMessage,'maxlength'=>'30','label'=>false,'div'=>false,'style'=>'width:95%;','value'=>'','error'=>false)); else  echo $form->input('Event.message',array('size'=>'30','class'=>'form-textfield','maxlength'=>'30','label'=>false,'div'=>false,'style'=>'width:95%;'));?>
			<strong>e.g. Kate's graduation!</strong></div></li>
		<li  style="float:right; padding-right:65px;"">
			<?php $options=array(
				"url"=>"/users/add_event","before"=>"",
				"update"=>"calendar_div",
				"loading"=>"Element.show('img/loading.gif');",
				"complete"=>"Element.hide('indicator');",
				"class" =>"green-button",
				"type"=>"Submit",
				"id"=>"createevent",
			);?>
			<span class="green-btn-widget" id='cnclBtn'>
			<?php echo $ajax->submit('Create Event',$options);?>
		</span></li>
	</ul>
</div>
<?php echo $form->end();?>
<!--Event Closed-->
<?php $events = array();
App::import('Model','Event');
$this->Event = &new Event;
$user_id  = $this->Session->read('User.id');
$events = $this->Event->find('all',array('conditions'=>array('Event.user_id'=>$user_id,'Event.event_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"'),'order'=>array('Event.event_date')));
?>
<!--Events this month Start-->
<div class="events-widget">
	<h5>Events this month</h5>
	<?php if(count($events)>0){ 
	$total_events = count($events);
	if($total_events > 4){ ?>
	<div style="overflow:scroll; height: 200px; overflow-x: hidden;">
	<?php }?>
	<ul class="event-ul">
		<?php 
		foreach($events as $event){ ?>
		<li><p><strong><?php if(!empty($event['Event']['event_date'])) echo date(DISPLAY_CAL_DATE, strtotime($event['Event']['event_date'])); else echo '-'; ?></strong></p>
			<p><?php if(!empty($event['Event']['message'])) echo $event['Event']['message']; else echo '-'; ?></p>
			<p><?php echo $ajax->link('Edit','', array('update' => 'calendar_div', 'url' => array('controller'=>'users','action'=>'add_event',$event['Event']['id'])), null,false);?> <?php echo $html->link('Delete','javascript:void(0)', array('escape'=>false,'onclick'=>"deletethis(".$event['Event']['id']."); "),null,false);?>
			</p>
		</li>
		<?php
		} ?>
	</ul>
	<?php if($total_events > 4){ ?>
	</div>
	<?php }?>
	<?php } else{ echo '<div class="event-ul" style="color:#ff0000;font-weight:bold">Currently no events added</div>';
	}?>
</div>
<!--Events this month Closed-->

<!-- <div class="clear"></div> -->
<script type="text/javascript">
function deletethis(eventId){
	var deletethis = confirm('Are you sure you want to delete this event?');
	if(deletethis == true){
		var postUrl = SITE_URL+'users/delete_event/'+eventId;
		jQuery.ajax({
			cache:false,
			async: false,
			type: "GET",
			url: postUrl,
			success: function(msg){
			/** Update the div**/		
			jQuery('#calendar_div').html(msg);
		}
		});
	} else{
		return false;
	}
}
	<?php 
	
	if(!empty($glb_year)){?>
		var glb_Year = '<?php  echo $glb_year;?>';
	<?php }?>

	<?php if(!empty($glb_month)){?>
		var glb_month = '<?php  echo $glb_month;?>';
	<?php }?>


	
	<?php //if(empty($this->data['Event']['id'])){
	$cur_date = date('d');
	$cur_mnt = strtolower(date('F'));
	$cur_yer = date('Y');
	?>
	var curDate = <?php echo $cur_date;?>;
	var curMonth = '<?php  echo $cur_mnt;?>';
	var curYear = '<?php echo $cur_yer;?>';
	var aaa=new Date()
	var cur_this_month = aaa.getMonth();
	var cur_this_year = aaa.getFullYear();

	<?php if(empty($this->data['Event']['id'])){ ?>
	if(curMonth == glb_month && curYear == glb_year){
		
		jQuery('#date_'+curDate).click();
	} else{
		
		jQuery('#date_1').click();
		if(glb_year < cur_this_year){
			//alert('ghgfh');
			//jQuery('#EventMessage'.attr('disabled',true));
	// 		$('#target').attr("disabled", true); 
		}
	}
	<?php } ?>
</script>