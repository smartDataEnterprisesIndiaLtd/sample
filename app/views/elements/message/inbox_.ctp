<?php 
//if(isset(sellers)) {
$options = array('url'=>array('action'=>'msg_inbox'),'update'=>'inbox_msgs');
$paginator->options($options); ?>
<!--Messages Widget Start-->
			<div class="grid">
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
				if(!empty($seller_msgs)){
					foreach($seller_msgs AS $key=>$val){ //pr($val);
					
				?>
				<!--Messages Row Start-->
				<div class="message-row">
					<ul>
						<li class="date-col"><?php echo $html->link(date('d-m-Y', strtotime($val['Message']['created'])) ,'/messages/sellers/'.$val['User']['id'].'/'.$val['Message']['id'], array('escape'=>false,'title'=>'Click to see and reply to message'))?></li>
						<li class="from-col"><?php echo $html->link(ucwords($val['User']['firstname']." ".$val['User']['lastname']) ,'/messages/sellers/'.$val['User']['id'].'/'.$val['Message']['id'], array('escape'=>false,'title'=>'Click to see and to reply message'))?></li>
						<li class="message-col"><?php echo $html->link(substr($val['Message']['message'], 0, 25).'...' ,'/messages/sellers/'.$val['User']['id'].'/'.$val['Message']['id'], array('escape'=>false,'title'=>'Click to see and to reply message'))?></li>
						<li class="replied-col">
							<?php if($val['Message']['is_replied'] !='0'){ ?>
								<img height="14" width="17" alt="" src="/img/tick-icon.gif"/>
								<?php echo $html->image("tick-icon.gif" ,array('height'=>14 ,'width'=>17, 'escape'=>false ));?>
							<?php } ?>
						</li>
					</ul>
				</div>
				<!--Messages Row Closed-->
				<?php } }else{ ?>
				<div class="message-row">
					<ul>
						<li>You have no messages</li>
					</ul>
				</div>
				<?php } ?>
			
			</div>
			<!--Messages Widget Start-->
			<!--Paging Widget Start-->
			<div class="search-paging search-paging-lt-blu border-top-none">
			<ul>
				<li><strong><?php

				//pr($this->params['paging']['Message']['defaults']['limit']);
				echo count($seller_msgs); ?> messages</strong></li>
				<li class="paging-sec paging-sctn">
					<span class="padding-left">Pages</span>
					<?php
						echo $paginator->numbers(); echo '&nbsp;&nbsp;';
						echo $paginator->prev($html->image('arrow-disabled.gif',array('alt' => __('previous', true),'border' => 0)),array('escape' => false));
						echo $paginator->next($html->image('arrow-enabled.gif',array('alt' => __('next', true),'border' => 0)),array('escape' => false));
					?>
				</li>
			</ul>
			</div>
			<!--Paging Widget Closed-->
<?php //} ?>