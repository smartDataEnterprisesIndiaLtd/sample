<?php ?>
<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether" style="margin-bottom:5px;">
			<h4 class="mid-gr-head blue-color"><span>Customers Viewing This Page May Be Interested in These Sponsored Links</span></h4>
		
			<div class="tec-details nopad_ltrt">
				<div class="ad300x250">
					<p>
						<script type="text/javascript"><!--
						google_ad_client = "pub-7745761219242437";
						/* 300x250, created 17/05/11 */
						google_ad_slot = "4673952244";
						google_ad_width = 300;
						google_ad_height = 250;
						//-->
						</script>
						<script type="text/javascript"
						src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
						<?php
						if(!empty($logg_user_id))
							$ad_feedback_link = '/products/ad_feedback/'.$product_details['Product']['quick_code'];
						else
							$ad_feedback_link = '/users/sign_in/';
						?>
					<p align="center">Advertisement | <?php echo $html->link('Ad feedback',$ad_feedback_link,array('escape'=>false,'class'=>'gray underline-link feedback-popup'));?></p>
				</div>
				
			</div>
		
		<!--FBTogether Closed-->
	</div>
		
