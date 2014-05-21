<!--Right Start-->

        <section class="right_widget">
        	<section class="box_gallery">
		
		<div id="allComingPosts" class="showPostsHere clearfix"></div>
            </section>
	    <section class="ajaxloader" id="loadPosts">
	      <?php echo $html->link('','javascript:void(0)', array('class'=>'button','id'=>'more_posts')); ?>
	      </section>
            <section class="ajaxloader" id="mydiv" style="text-align: center;display:none;">
	   
            	<p class="loding_sec" ><span>
		<?php echo $html->image('images/blogs/loading_more.gif',array('alt'=>'Loading...','width'=>16,'height'=>16)); ?>
		</span></p>
		<?php if($pCount > 10) {
			$showcount =10;
		}
			else {
			$showcount = $pCount;	
			}
			
			
			?>
                <h4 id="pagingcount">Displaying <?php echo $showcount; ?> of <?php echo $pCount; ?></h4>
            </section>
            <p class="rightposbtn" style="display:none;" id="linktop"><a href="javascript:" class="graybutton"><span>Back to the top</span></a></p>
        </section>
        <!--Right Closed-->
	
         