<?php if(!empty($bcomments) && count($bcomments) >0) {
			
			?>
<ul class="commentsection">	
			<?php
		    foreach ($bcomments as $blogcomments) {?>
			
			<li>
			<h5>
			<?php echo $html->link($blogcomments['BlogComment']['name'],'javascript:',array('escape'=>false,'title'=>$blogcomments['BlogComment']['name']));?>
			<span class="graytext">says:</span></h5>
			<?php if( $blogcomments['BlogComment']['status']==1) {		
			?>
		        <p><?php echo $blogcomments['BlogComment']['comment'];?></p>
			<?php } else {?>
			<p><i>We have removed this comment as it against our <?php echo $html->link("conditions of use",array("controller"=>"pages","action"=>"view/conditions-of-use"),array('escape'=>false,'title'=>'conditions of use','class'=>'','target'=>'_blank'));?></i></p>
			<?php }?>
			<p class="date_col"><?php
				if($blogcomments['BlogComment']['created'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else {
				    echo date(BLOG_DATE_FORMAT,strtotime($blogcomments['BlogComment']['created']));
				}?>
			</p>
			</li>
			
		    <?php }
				}
				
				else  {
					
					echo '<li>No records found.</li>';
				}
			?>
                                	
                                
                                </ul>