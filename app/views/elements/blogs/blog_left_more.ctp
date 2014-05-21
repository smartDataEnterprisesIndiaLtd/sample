<?php if(!empty($blogs_left) && is_array($blogs_left) && count($blogs_left) > 0) {
    $i=0;
			foreach ($blogs_left as $blog) { 
			?>
                	<li  class="blogMore">
                    	<section class="inspimage">
				<?php
				# display current image preview 
				$imagePath = WWW_ROOT.PATH_CHOICEFUL_BLOGS."small/img_75_".$blog['Blog']['image'];
				
				if(file_exists($imagePath)   && !empty($blog['Blog']['image']) ){
				$arrImageDim = $format->custom_image_dimentions($imagePath, 100, 50);
				$image_title = substr($blog['Blog']['image'],0,-4);
				$image_title_new = substr($image_title,11);
				echo $html->link($html->image('/'.PATH_CHOICEFUL_BLOGS."small/img_75_".$blog['Blog']['image'], array("alt"=>"Blog Details",'style'=>'border:0px','width'=>77,'height'=>77)),'/blog/blogdetails/'.$blog['Blog']['slug'],array('escape'=>false,'title'=>$image_title_new,'alt'=>$image_title_new));
			
				}else{
					echo $html->image('/img/no_image.jpeg', array('width'=>77,'height'=>77, 'border'=>'0', 'style'=>'border:0px;'));
				}
		    
				?>
				
			
			</section>
                        <section class="inspcontent">
                        	<h5>
				<?php
				//
				echo $html->link($blog['Blog']['title'],'/blogs/blogdetails/'.$blog['Blog']['slug'],array('escape'=>false,'title'=>$blog['Blog']['title'])); ?>
				
				</h5>
                            <p class="graytext">By <?php echo html_entity_decode($blog['Blog']['publisher_name']);?> <span class="line_break"><?php
				if($blog['Blog']['created'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else {
				    echo 'Published: '.date(BLOG_DATE_FORMAT,strtotime($blog['Blog']['created']));
				}?></span></p>
                            <p><?php if(count($blog['BlogComment']) > 1) {
				
			echo $html->link(count($blog['BlogComment']).' Comments','/blogs/blogdetails/'.$blog['Blog']['slug'],array('escape'=>false,'title'=>$blog['Blog']['title']));
			    }
			    
			    else if(count($blog['BlogComment']) == 1){
				echo $html->link(count($blog['BlogComment']).' Comment','/blogs/blogdetails/'.$blog['Blog']['slug'],array('escape'=>false,'title'=>$blog['Blog']['title']));
			    }
			    
			  ?> </a></p>
                        </section>
                    </li>
                   
                   
                    <?php $i++;} //foreach ends
 		    } //if ends
		    else{
			echo '<li> No blogs found.</li>';
			}?>