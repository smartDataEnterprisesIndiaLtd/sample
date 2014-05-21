<!--Left Start-->
    	<aside>
        	<!--Search Choiceful Start-->
        	<section class="module">
            	<h4>Search Choiceful.com</h4>
                <section class="search_choiceful">
		
		<?php
		/* if(isset($this->params['pass'][0]) && !empty($this->params['pass'][0])) {
		echo $this->Form->create('blogsearch', array('url' => array('controller' => 'blogs', 'action' => 'blogdetails/'.$this->data['Blog']['slug'])));
		 }
		 else {*/

	echo $form->create("Blog",array("action"=>"/blogsearch","method"=>"post", "id"=>"frmSearchproduct", "name"=>"frmSearchproduct"));
		 //}
	?>
                	<span class="bluebtn right_btn">
			<?php echo $form->submit('Search',array("label" => false, "div" => false,'class'=>"button", 'name' => 'button', ));?>
			
			<!--<input type="submit" name="button" class="button" value="Search" />--></span>
                    <section class="leftfield"><p class="pdrt">
		    
		    <?php echo $form->input('Blog.keywords',array('id'=>'search_keywords', 'value'=>@$searchWord, 'class'=>'textfield fullwidth', 'label'=>false,'div'=>false, 'escape'=>false));?>
		    
		   <!-- <input type="text" name="textfield" class="textfield fullwidth" /></p>-->
		     <?php echo $form->end(); ?>
		    </section>
                </section>
                
                <!--Browse Start-->
                <section class="browse_widget">
                	<a href="#" class="browse">Browse</a>
                    <section class="browsecontent">
                    	<p class="up_arrow">
			<?php echo $html->image('/img/images/blogs/uparrow.png', array('width'=>18,'height'=>9, 'border'=>'0', 'style'=>'border:0px;')); ?>
				</p>
                        <section class="grayframe">
                            <ul class="menulinks">
                                <li><?php echo $html->link('Books',
				   array('controller'=>'Books','action'=>'departments', 'index', '1'),
				   array('escape'=>false,'title'=>'Books')
				   );?></li>
				   
				   <li><?php echo $html->link('Music',
				   array('controller'=>'Music','action'=>'departments', 'index', '2'),
				   array('escape'=>false,'title'=>'Music')
				   );?></li>
				   <li><?php echo $html->link('Movies',
				   array('controller'=>'Movies','action'=>'departments', 'index', '3'),
				   array('escape'=>false,'title'=>'Movies')
				   );?></li>
				   <li><?php echo $html->link('Games',
				   array('controller'=>'Games','action'=>'departments', 'index', '4'),
				   array('escape'=>false,'title'=>'Games')
				   );?></li>
				   <li><?php echo $html->link('Electronics',
				   array('controller'=>'Books','action'=>'departments', 'index', '5'),
				   array('escape'=>false,'title'=>'Electronics')
				   );?></li>
				   <li><?php echo $html->link('Office &amp; Computing',
				   array('controller'=>'Office-and-Computing','action'=>'departments', 'index', '6'),
				   array('escape'=>false,'title'=>'Office-and-Computing')
				   );?></li>
				   <li><?php echo $html->link('Mobile',
				   array('controller'=>'Mobile','action'=>'departments', 'index', '7'),
				   array('escape'=>false,'title'=>'Mobile')
				   );?></li>
				   <li><?php echo $html->link('Home &amp; Garden',
				   array('controller'=>'Home-and-Garden','action'=>'departments', 'index', '8'),
				   array('escape'=>false,'title'=>'Home-and-Garden')
				   );?></li>
				   <li><?php echo $html->link('Health &amp; Beauty',
				   array('controller'=>'Health-and-Beauty','action'=>'departments', 'index', '9'),
				   array('escape'=>false,'title'=>'Health-and-Beauty')
				   );?></li>
				   <li><?php echo $html->link('Sell Your Stuff',
				   array('controller'=>'marketplaces','action'=>'view', 'how-it-works'),
				   array('escape'=>false,'title'=>'Sell Your Stuff')
				   );?></li>
		            </ul>
                            <p class="aligncenter">
				<?php echo $html->link('More','javascript:',array('escape'=>false,'title'=>'More','class'=>'more','id'=>'close_links'));?>
				</p>
                        </section>
                    </section>
                </section>
                <!--Browse Closed-->
            </section>
            <!--Search Choiceful Closed-->
            
            <!--What's Inspirational Start-->
        	<section class="module">
            	<h4>What's Inspirational</h4>
                <ul class="inspirational">
			
			<?php
			$i=0;
			if(!empty($blogs_left) && is_array($blogs_left) && count($blogs_left) > 0) {
			foreach ($blogs_left as $blog) { 
			?>
                	<li class="blogMore">
                    	<section class="inspimage">
				<?php
				# display current image preview 
				$imagePath = WWW_ROOT.PATH_CHOICEFUL_BLOGS."small/img_75_".$blog['Blog']['image'];
				
				if(file_exists($imagePath)   && !empty($blog['Blog']['image']) ){
				$arrImageDim = $format->custom_image_dimentions($imagePath, 100, 50);
				$image_title = substr($blog['Blog']['image'],0,-4);
				$image_title_new = substr($image_title,11);
				echo $html->link($html->image('/'.PATH_CHOICEFUL_BLOGS."small/img_75_".$blog['Blog']['image'], array("alt"=>"Blog Details",'style'=>'border:0px','width'=>77,'height'=>77)),array("controller"=>"blogs","action"=>"blogdetails",$blog['Blog']['slug']),array('escape'=>false,'title'=>$image_title_new,'alt'=>$image_title_new));
			
				}else{
					echo $html->image('/img/no_image.jpeg', array('width'=>77,'height'=>77, 'border'=>'0', 'style'=>'border:0px;'));
				}
		    
				?>
				
			
			</section>
                        <section class="inspcontent">
                        	<h5>
				<?php
				//array("controller"=>"blogs","action"=>"blogdetails",$blog['Blog']['slug'])
				echo $html->link($blog['Blog']['title'],array("controller"=>"blogs","action"=>"blogdetails",$blog['Blog']['slug']),array('escape'=>false,'title'=>$blog['Blog']['title'])); ?>
				
				</h5>
                            <p class="graytext">By <?php echo html_entity_decode($blog['Blog']['publisher_name']);?> <span class="line_break"><?php
				if($blog['Blog']['created'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else {
				    echo 'Published: '.date(BLOG_DATE_FORMAT,strtotime($blog['Blog']['created']));
				}?></span></p>
                            <p><?php if(count($blog['BlogComment']) > 1) {
				
			echo $html->link(count($blog['BlogComment']).' Comments',array("controller"=>"blogs","action"=>"blogdetails",$blog['Blog']['slug']),array('escape'=>false,'title'=>$blog['Blog']['title']));
			    }
			    
			    else if(count($blog['BlogComment']) == 1){
				echo $html->link(count($blog['BlogComment']).' Comment',array("controller"=>"blogs","action"=>"blogdetails",$blog['Blog']['slug']),array('escape'=>false,'title'=>$blog['Blog']['title']));
			    }
			    
			  ?> </a></p>
                        </section>
                    </li>
                   
                   
                    <?php $i++;} //foreach ends
 		    } //if ends
		    else{
			echo '<li> No blogs found.</li>';
			}?>
                   
                </ul>
                
            </section>
            <!--What's Inspirational Closed-->
            
            <!--Stores Start-->
            
	    
        	<section class="module">
            	<h4>Other Choiceful.com Stores <?php echo $html->link('See all locations',array("controller"=>"homes","action"=>"international-websites"),array('escape'=>false,'title'=>'See all locations','class'=>'all_laction fl-rt'));?></h4>
                <ul class="stores_loc">
                <li>
			
			<a href="/homes/international-websites"><span class="flagpic"><img src="../../img/images/blogs/aus.png" alt="" /></span><span class="cont_name">Australia</span></a></li>
                <li><a href="/homes/international-websites"><span class="flagpic"><img src="../../img/images/blogs/brazil.png" alt="" /></span><span class="cont_name">Brazil</span></a></li>
                <li><a href="/homes/international-websites"><span class="flagpic"><img src="../../img/images/blogs/canada.png" alt="" /></span><span class="cont_name">Canada</span></a></li>
		<li><a href="/homes/international-websites"><span class="flagpic"><img src="../../img/images/blogs/china.png" alt="" /></span><span class="cont_name">China</span></a></li>
		<li><a href="/homes/international-websites"><span class="flagpic"><img src="../../img/images/blogs/germany.png" alt="" /></span><span class="cont_name">Germany</span></a></li>
		<li><a href="/homes/international-websites"><span class="flagpic"><img src="../../img/images/blogs/france.png" alt="" /></span><span class="cont_name">France</span></a></li>
		<li><a href="/homes/international-websites"><span class="flagpic"><img src="../../img/images/blogs/ireland.png" alt="" /></span><span class="cont_name">Ireland</span></a></li>
		<li><a href="/homes/international-websites"><span class="flagpic"><img src="../../img/images/blogs/india.png" alt="" /></span><span class="cont_name">India</span></a></li>
		<li><a href="/homes/international-websites"><span class="flagpic"><img src="../../img/images/blogs/japan.png" alt="" /></span><span class="cont_name">Japan</span></a></li>
		<li><a href="/homes/international-websites"><span class="flagpic"><img src="../../img/images/blogs/uk.png" alt="" /></span><span class="cont_name">UK</span></a></li>
		<li><a href="/homes/international-websites"><span class="flagpic"><img src="../../img/images/blogs/usa.png" alt="" /></span><span class="cont_name">USA</span></a></li>
                </ul>
            </section>
            <!--Stores Closed-->
            
            <!--Testimonial Start-->
        	<section class="module">
            	<h4>What You're Saying</h4>
                <section class="testimonial_widget">
                	<section class="testi_top">
                    	<section class="clientname">
				
			<?php echo $html->link('<strong>'.$testimonials['Testimonial']['name'].'</strong>','javascript:',array('escape'=>false,'title'=>$testimonials['Testimonial']['name']));?>
			 says:</section>
                        
                    </section>
                    
                    <section class="testi_text">
                    	<section class="quote_left">
				<?php echo $html->image('/img/images/blogs/quote.png', array('border'=>'0', 'style'=>'border:0px;')); ?>
				</section>
                        <section class="testi"><?php echo $testimonials['Testimonial']['comment'];?><?php echo $html->link('Read more','javascript:',array('escape'=>false,'title'=>'Read more','class'=>'fl-rt','style'=>'padding-top:5px;'));?></section>
                    </section>
                </section>
                
            </section>
            <!--Testimonial Closed-->
            
            <!--Stores Start-->
        	<section class="module">
            	<h4>Stay in Touch</h4>
                <ul class="stores_loc stayintouch">
                    <li id="facebook">
		    <?php echo $html->link("<span></span>Facebook",'https://facebook.com/choiceful',array('escape'=>false,'title'=>'Facebook','target'=>'_blank'));?></li>
		    
		    </li>
                    <li id="pinterest">
		    <?php echo $html->link("<span></span>Pinterest",'http://pinterest.com/choiceful',array('escape'=>false,'title'=>'Pinterest','target'=>'_blank'));?>
		 </li>
                    <li id="twitter">
		     <?php echo $html->link("<span></span>Twitter",'https://twitter.com/Choicefulcom',array('escape'=>false,'title'=>'Twitter','target'=>'_blank'));?>
		  </li>
                    <li id="gplus">
		     <?php echo $html->link("<span></span>Google Plus",'https://plus.google.com/105885727970905038288',array('escape'=>false,'title'=>'Google Plus','target'=>'_blank'));?>
		 </li>
                </ul>
            </section>
            <!--Stores Closed-->
            
        </aside>
	
        <!--Left Closed-->  