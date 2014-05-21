<?php
//pr($this->params['named']);
//echo $seller_id = $this->params['named']['user_id'];
//echo $buyer_id = $this->params['named']['user_id'];

//echo $last_msg_id = $this->Common->lastMsgBuyer($buyer_id = null);
//$last_msg_id = 1852;
?>
<script>
/*jQuery(document).ready(function(){
    // load home page when the page loads
    jQuery("#msg_area").load("http://212.64.145.207/messages/item_msgs/0/<?php //echo $last_msg_id;?>");
});*/</script>

<?php
if(empty($seller_msgs)){
?>
<style language="text/css">
.search-paging-lt-blu {
border : none;
}
.search-paging {
border : none;
border-bottom:1px solid #CCCCCC;
}
</style>
<?php }?>
<?php 
if(!empty($seller_msgs)) { ?>
<!--Messages Widget Start-->
<div id="ClientListID" class="grid">
	<!--Messages Heading Start-->
	<div class="grid-head">
		<ul>
			<li class="date-col"><strong>Date</strong></li>
			<li class="from-col"><strong>From</strong></li>
			<li class="message-col"><strong>Message</strong></li>
			<li class="replied-col"><strong>Replied</strong></li>
		</ul>
	</div>
	<!--Messages Heading Closed-->
	<?php
	foreach($seller_msgs AS $key=>$val){ ?>
	<!--Messages Row Start-->
	<?php $idcolor= 'link'.$val['Message']['id'];?>
	<?php $idimg= 'img'.$val['Message']['id'];?>
	<ul id="<?php echo $idcolor;?>" class="bcolor_remove">
		<li class="date-col">
		<?php if(!empty($val['Message']['is_replied']) || $val['Message']['from_user_id'] == -1){
			//echo date('d F, Y', strtotime($val['Message']['created']));
			echo $ajax->link(date('d F, Y', strtotime($val['Message']['created'])),'', array('escape'=>false,'update' => 'msg_area', 'url' => '/messages/item_msgs/0/'.$val['Message']['id'],'class'=>'underline-link buyerCommunication',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading(),chnageColor('$idcolor','$idimg')"), null,false);
		} else {
			echo $ajax->link(date('d F, Y', strtotime($val['Message']['created'])),'', array('escape'=>false,'update' => 'msg_area', 'url' => '/messages/item_msgs/0/'.$val['Message']['id'],'class'=>'underline-link buyerCommunicationbold',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading(),chnageColor('$idcolor','$idimg')"), null,false);
		}?></li>
		<li class="from-col">
		<?php if($val['Message']['from_user_id'] == -1){
			echo 'Choiceful.com';
		} else if(!empty($val['Message']['is_replied'])){
			//echo ucwords($val['User']['firstname']." ".$val['User']['lastname']);
			echo $ajax->link(ucwords($val['User']['firstname']." ".$val['User']['lastname']),'', array('escape'=>false,'update' => 'msg_area', 'url' => '/messages/item_msgs/0/'.$val['Message']['id'],'class'=>'underline-link buyerCommunication',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading(),chnageColor('$idcolor','$idimg')"), null,false);
		} else {
			echo $ajax->link(ucwords($val['User']['firstname']." ".$val['User']['lastname']),'', array('escape'=>false,'update' => 'msg_area', 'url' => '/messages/item_msgs/0/'.$val['Message']['id'],'class'=>'underline-link buyerCommunicationbold',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading(),chnageColor('$idcolor','$idimg')"), null,false);
		} ?></li>
		<li class="message-col" style="overflow:hidden; height:25px;">
		<?php if(!empty($val['Message']['is_replied']) || $val['Message']['from_user_id'] == -1){
			echo $ajax->link($this->Common->currencyEnter($format->formatString($val['Message']['message'],200,'...')),'', array('escape'=>false,'update' => 'msg_area', 'url' => '/messages/item_msgs/0/'.$val['Message']['id'],'class'=>'underline-link buyerCommunication',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading(),chnageColor('$idcolor','$idimg')"), null,false);
			//echo $format->formatString($val['Message']['message'],32,'....');
		} else {
			echo $ajax->link($this->Common->currencyEnter($format->formatString($val['Message']['message'],200,'...')),'', array('escape'=>false,'update' => 'msg_area', 'url' => '/messages/item_msgs/0/'.$val['Message']['id'],'class'=>'underline-link buyerCommunicationbold',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading(),chnageColor('$idcolor','$idimg')"), null,false);
		} ?></li>
		<li class="replied-col">
			<?php if($val['Message']['is_replied'] !='0'){
				echo '<span>'.$html->image('tick-icon.gif',array('height'=>14,'width'=>17,'alt'=>'','class'=>'img123','id'=>$idimg)).'</span>';
			} ?>
		</li>
	</ul>
	<!--Messages Row Closed-->
	<?php } ?>

<!--Messages Widget Start-->
<!--Paging Widget Start-->
<div class="search-paging search-paging-lt-blu ">
	<ul>
		<li>
			<strong><?php
				//pr($this->params['paging']['Message']['defaults']['limit']);
				echo count($seller_msgs); ?> messages
			</strong>
		</li>
		<!--li class="paging-sec paging-sctn" id="messaging_div_here"-->
			<!--span class="padding-left">Pages</span-->
			<?php
				//echo $this->Paginator->numbers(array('Model'=>'Message')); echo '&nbsp;&nbsp;';
				//echo $this->Paginator->prev($html->image('arrow-disabled.gif',array('alt' => __('previous', true),'border' => 0)),array('escape' => false,'Model'=>'Message'));echo '&nbsp;';
				//echo $this->Paginator->next($html->image('arrow-enabled.gif',array('alt' => __('next', true),'border' => 0)),array('escape' => false,'Model'=>'Message'));
			?>
		<!--/li-->
		
	</ul>
	
	<div class="pagingdef" id="inboxid" style="margin-top: -23px; position: relative;">
		<ul>
			<?php echo $this->Paginator->prev('Prev',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
			<?php echo $this->Paginator->numbers(array('separator'=>'','tag' => 'li')); ?>
			<?php echo $this->Paginator->next('Next',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
		</ul>
	</div>
	
	
</div>
</div>
<!--Paging Widget Closed-->
<?php } else{ ?>
<div class="grid">
	<!--Messages Heading Start-->
	<div class="grid-head" style="height:25px;">
		<ul>
			<li class="date-col"><strong></strong></li>
			<li class="from-col"><strong></strong></li>
			<li class="message-col"><strong></strong></li>
			<li class="replied-col"><strong></strong></li>
		</ul>
	</div>
	<ul>
		<li>You have no messages</li>
	</ul>
	<div class="search-paging search-paging-lt-blu ">
		<ul>
			<li>
				<strong><?php
				//pr($this->params['paging']['Message']['defaults']['limit']);
				//echo count($seller_msgs).'messages'; ?> </strong>
			</li>
		</ul>
	</div>
</div>
<?php } ?>
<?php //echo $js->writeBuffer(); ?>

<script type="text/javascript">
jQuery(document).ready(function(){
jQuery('#inboxid li').css("padding","0");
jQuery('.current').css("padding","0 7px");
jQuery('#inboxid li a').css("padding","0 7px");
jQuery('#inboxid li a').css("text-decoration","none");

jQuery('li#messaging_div_here span a').click(function(){
	var ajax_url= jQuery(this).attr('href');
		
	jQuery.ajax({
		url: ajax_url,
		success: function(msg){
		jQuery('div#messageinbox_id').html(msg);
			
		//$(this).addClass("done");
  	}
	});
	return false;
	
	});
});


jQuery('#inboxid li a').click(function(){
	var ajax_url= jQuery(this).attr('href');
	var return_homeURL = SITE_URL+'users/sign-in';
	jQuery('#plsLoaderID').show();
	jQuery('#fancybox-overlay-header').show();
	jQuery.ajax({
		url: ajax_url,
		success: function(msg){
		jQuery('#plsLoaderID').hide();
		if(msg == 'SessionExpired'){
			window.location.assign(return_homeURL);
			return false;
		}
		jQuery('#ClientListID').html(msg);		
		jQuery('#fancybox-overlay-header').hide();
  	}
	});
	return false;
	
	});


function chnageColor(id, imgid)
{
	jQuery('.bcolor_remove').css({'background-color':'#FFFFFF'});
	jQuery('#'+id).css({'background-color':'#ABBE52'});
	jQuery('.img123').attr('src', '/img/tick-icon.gif');
	jQuery('#'+imgid).attr('src', '/img/tick-icon-select.gif');
	//jQuery('#'+id).css({'background-image': 'url("../img/tick-icon-select.gif")'});
	//jQuery('#'+id).css({'background-image:url("tick-icon.gif")'});
}

</script>