<!--Service Metrics Start-->
	<div class="side-content">
		<h4 class="gray-bg-head"><span>Service Metrics</span></h4>
		<div class="gray-fade-bg-box padding">
		
			<ul class="service-metrics-widget">
				<li>
					<h5>Average number of agents:</h5>
					<p><span>There are currently <?php echo $metrics_service['MetricsService']['service_agent'];?> customer service agents on call</span></p>
				</li>
				<li>
					<h5>Volume of emails per hour:</h5>
					<p><span><?php echo $metrics_service['MetricsService']['emails_per_hour'];?> emails</span></p>
				</li>
				<li>
					<h5>Average email response time:</h5>
					<p>
					<span>
						<?php $email_response_time = explode(':',$metrics_service['MetricsService']['email_response_time']);
							echo $email_response_time[0].' hour '.$email_response_time[1].' minutes';
						?>
						
					</span>
					</p>
				</li>
				<li>
					<h5>Average wait for help desk:</h5>
					<p><span>
						<?php $help_desk = explode(':',$metrics_service['MetricsService']['help_desk']);
							echo $help_desk[0].' minute '.$help_desk[1].' secouds';
						?>
					</span></p>
				</li>
				<li>
					<h5>Last updated:</h5>
				<p><span><?php echo date("m/d/y", mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));?> 12:00 GMT</span></p>
				<p><span>Statistics are based on data captured in the last 24-hours. They may not represent your actual experience.</span></p>
				<p><span>All figures are based on working hour practices.</span></p>
				</li>
			</ul>
			
		</div>
	</div>
	<!--Service Metrics Closed-->