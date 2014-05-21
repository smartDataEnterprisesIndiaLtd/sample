<?php ?>
<!--Feedback recieved Start-->
<div class="border feedback-recieved">
	<h5 class="gray-heading">Feedback Received</h5>
	<div class="pdng"><?php if(!empty($order_details['Feedback'])) { ?>
		<table width = "100%" cellspacing="2" cellpadding="2" border="0">
			<?php foreach($order_details['Feedback'] as $feedback){ ?>
				<tr><td><?php 
					if(!empty($feedback['item_name']))
						echo "<b>".$feedback['item_name']."</b>";
					else
						echo '-'; ?> <br />
					<?php if(!empty($feedback['feedback']))
						echo $feedback['feedback'];
					else 
						echo '-';?>
				</td></tr>
			<?php } ?>
		</table>
	<?php } else { echo 'No feedback received'; }?></div>
</div>
<!--Feedback recieved Closed-->