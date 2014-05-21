<?php
echo $javascript->link(array('behaviour','textarea_maxlen')); //,'jquery_cookies' ?> 

<!--Right Start-->
        <section class="right_widget minheight">
        	<section class="article_widget">
            	<!--Box Frame Start-->
            	<section class="box_frame articlebox" id="myID">
                	<!--Box Top Start-->
                	<section class="box_top">
                    	<span class="boxtop_left"></span>
                        <span class="boxtop_right"></span>
                    </section>
                    <!--Box Top Closed-->
                    
                    <!--Box Middle Start-->
                	<section class="box_mid">
                    	<span class="boxleftcorner"></span>
                        <span class="boxrightcorner"></span>
                    	<section class="boxmiddle">
                        	<!--Article Start-->
                        	<section class="article">
                            	<h1><span><?php echo $this->Common->currencyEnter($this->data['Blog']['title']);?></span></h1>
				<section class="share_widget">
                                	<ul class="sharelinks_sec fl-lt">
					<li style="color:#AEACAD;"> SHARE</li>
					 <li><a class="addthis_button_facebook_like"><?php //echo $html->image('/img/images/blogs/facebook_like.png', array("alt"=>"Facebook Share",'style'=>'border:0px'));?></a></li>
					 
                                    	<li><a class="addthis_button_twitter"><?php echo $html->image('/img/images/blogs/tweets.png', array("alt"=>"Twitter tweets",'style'=>'border:0px'));?></a></li>
					
					<li> <!-- Place this tag where you want the +1 button to render. -->
<div class="g-plusone" data-size="tall" data-annotation="none"></div>

<!-- Place this tag after the last +1 button tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
					
					
					
					
					<!--<a class="addthis_button_WHAT IS GOOGLE+???"><?php //echo $html->image('/img/images/blogs/g_plus.png', array("alt"=>"Google Plus",'style'=>'border:0px'));?></a> --></li>
					
					<li><a class="addthis_button_tumblr"><?php echo $html->image('/img/images/blogs/tumblr.png', array("alt"=>"Tumblr",'style'=>'border:0px'));?></a></li>
					
					  <li>
						<a class="addthis_button_pinterest_pinit"><?php echo $html->image('/img/images/blogs/pin_it.png', array("alt"=>"Pin it",'style'=>'border:0px'));?></a></li>
                                        
                                    </ul>
                                    <section class="links_sec rightposlink">
			
                                    	
					
                                    </section>
                                    <section class="clear"></section>
                                </section>
                                <p class="articlepic"> <?php
				# display current image preview 
				$imagePath = WWW_ROOT.PATH_CHOICEFUL_BLOGS."large/img_400_".$this->data['Blog']['image'];
				
				if(file_exists($imagePath)   && !empty($this->data['Blog']['image']) ){
				$image_title = substr($this->data['Blog']['image'],0,-4);
				$image_title_new = substr($image_title,11);
					
                                echo $html->image('/'.PATH_CHOICEFUL_BLOGS."large/img_400_".$this->data['Blog']['image'], array('border'=>'0','style'=>'border:0px;','alt'=>$image_title_new,'title'=>$image_title_new));
				}
		    
				?></p>
				
				 <?php if(isset($this->data['Blogimage']) && !empty($this->data['Blogimage']) && count($this->data['Blogimage']) > 0) { ?>
				  
				<?php
				foreach ($this->data['Blogimage'] as $blogimages){
				$imagePath = WWW_ROOT.PATH_CHOICEFUL_BLOGS."large/img_400_".$blogimages['image'];
				if(file_exists($imagePath)   && !empty($blogimages['image']) ){
					$image_title = substr($blogimages['image'],0,-4);
				$image_title_new = substr($image_title,11);
				
				?>
				 <p class="articlepic">
				<?php echo $html->image('/'.PATH_CHOICEFUL_BLOGS."large/img_400_".$blogimages['image'], array('border'=>'0','style'=>'border:0px;','alt'=>$image_title_new,'title'=>$image_title_new));?>
				</p>
					<?php }
					}
				   }
					?>
                                
                                <!--Article Content Start-->
                                <section class="art_content">
                                    <p class="published"><?php echo $this->data['Blog']['publisher_name'];?> <span>/ Published on <?php
				if($this->data['Blog']['created'] == '0000-00-00 00:00:00'){
				    echo 'NA';
				} else {
				    echo date(BLOG_DATE_FORMAT,strtotime($this->data['Blog']['created']));
				}?></span></p>
                                    <?php echo $this->data['Blog']['description'];?>
                                   <p></p>
                                </section>
                                <!--Article Content Closed-->
                                
                                <!--Article Video Start-->
                                <?php
				if(!empty($this->data['Blog']['blog_video'])) {
				$videotype = strstr($this->data['Blog']['blog_video'], '.com', true);
				if($videotype=='https://www.youtube') {
				$videoid = substr($this->data['Blog']['blog_video'],32);	
				?>
                                <section class="articlevideo">
				<iframe width="100%" height="400" src="https://www.youtube.com/embed/<?php echo $videoid.'?autoplay=0';?>" frameborder="0" allowfullscreen> </iframe>
				
				
				
				</section>
				<?php } else if($videotype=='http://vimeo') {
				$videoid = substr($this->data['Blog']['blog_video'],17);
				?>
				<iframe width="100%" height="400" src="http://player.vimeo.com/video/<?php echo $videoid.'?autoplay=0';?>" frameborder="0" allowfullscreen> </iframe>
				<section class="articlevideo">
				
				</section>
				<?php } }?>
                                <!--Article Video Closed-->
                                
                            </section>
                            <!--Article Closed-->
                            
                            <!--Share & Tags Start-->
                            <section class="sharetags">
                            	<section class="share_widget">
					 
				  <!--Read Later Popup Start-->
				  <section class="popup_widget" id="readlater" style="margin-top:28px;">
				      <section class="popupframe">
					  <p class="poparrow"><?php echo $this->Html->image('/img/images/blogs/popup_arrow.png', array('alt' =>'Read It Later'));?></p>
					  <section class="later_sec">
					      <p class="saveto">save to</p>
					  
					      <p>
					      <?php echo $html->link("Instapaper","http://www.instapaper.com/hello2?url=".Configure::read('siteUrl')."/blogs/blogdetails/".$this->data['Blog']['slug']."&title=".$this->data['Blog']['title'],array('escape'=>false,'title'=>"Instapaper")); ?>
					      
					      <span class="sep"></span>
					      <a href="http://www.addtoany.com/add_to/read_it_later?linkurl=<?php echo Configure::read('siteUrl');?>/blogs/blogdetails/<?php echo $this->data['Blog']['slug'];?>&amp;linkname=<?php echo $this->data['Blog']['title'];?>">Read It Later</a> 
					     </p>
					  </section>
				      </section>
				      <p class="popup_bottom"></p>
				  </section>
				  <!--Read Later Popup Closed-->
                                	<ul class="sharelinks_sec fl-lt">
						
				<li> <?php echo $html->link('<span>Read Later</span>','javascript:',array('escape'=>false,'title'=>'Read Later','class'=>'gray_btn readlater','onclick'=>'showReadlater();')); ?></li>
				
				<li><p><?php echo $html->link("<span>Share</span>",'http://www.addthis.com/bookmark.php?v=250&amp;pubid=xa-4d882e8a367f2b78',array('escape'=>false,'title'=>"Share",'class'=>'addthis_button_compact share_lnk')); ?></p></li>
                                
                                    </ul>
                                    
				   
				  
                                    <section class="links_sec rightposlink">
					
					<?php
			$shorturl= $this->Common->shorten_url(Configure::read('siteUrl').'/blogs/blogdetails/'.$this->data['Blog']['slug'],$service='tinyurl.com');
			
			?>
			<?php echo $html->link('Short Url','javascript:',array('escape'=>false,'title'=>'Short Url','alt'=>'Short Url','class'=>'shorturl'))?>
			
			
					
                                    	<!--Shortlink Popup Start-->
                                      <section class="popup_widget" style="margin-left:60px;" id="shortlink">
				      <section class="popupframe">
					 <p class="poparrow" style="margin-left: 147px;"><?php echo $this->Html->image('/img/images/blogs/popup_arrow.png', array('alt' =>'Short Url'));?></p>
					  <section class="urlsec">
					       <p class="pdrt"> <?php echo $form->input('Blog.tinyurl',array('size'=>'12','class'=>'textfield fullwidth','label'=>false,'div'=>false,'value'=>$shorturl));?></p>                                          
					  </section>
				      </section>
				      <p class="popup_bottom"></p>
				  </section>
                                        <!--Shortlink Closed-->
					
					
                                    </section>
                                    <section class="clear"></section>
                                </section>
                                
                                <!--Tags Start-->
                                <section class="tags"><span><strong>Search Tags:</strong></span> <?php
				$tags='';
				foreach ($this->data['BlogSearchtag'] as $searchtags )
				{
				$tags .= '<span style="color: #6BA03D">'.$searchtags['tags'].'</span>';
				$tags .= ', ';
				}
			echo substr($tags,0,-2);
				
				
			?>
				</section>
                                <!--Tags Closed-->
                            </section>
                            <!--Share & Tags Closed-->
                            
                            <!--Comment Widget Start-->
                            <section class="row_widget comment_widget">
			<?php //echo  $form->create('Blog',array('action'=>'blogdetails','method'=>'POST','name'=>'frmBlog','id'=>'frmBlogComment'));
			
			echo $this->Form->create('blocomment', array('url' => array('controller' => 'blog', 'action' => '/blogdetails/'.$this->data['Blog']['slug'])));
			
			 echo $form->hidden('BlogComment.blog_id',array('class'=>'textbox','label'=>false,'div'=>false,'value'=>$this->data['Blog']['id']));
			?>	
                        <h4 class="head">Add your Comment <span class="sml-font">No sign in required</span></h4>
			
			<?php if(!empty($errors)){?>
                                <section class="error_msg">
                                	<section class="errorpic">
						
					<?php  echo $html->image('/img/images/blogs/error_icon.png', array('border'=>'0','style'=>'border:0px;','alt'=>'','title'=>''));?>
			
						</section>
                                    <section class="error_message">Please add some information in the mandatory fields highlighted red below</section>
                                </section>
				<?php }?>
				
				
		<?php if(isset($qerrors) && !empty($qerrors) && $qerrors=='wrong-answer'){?>
		
		<section class="error_msg">
                                	<section class="errorpic">
						
					<?php  echo $html->image('/img/images/blogs/error_icon.png', array('border'=>'0','style'=>'border:0px;','alt'=>'','title'=>''));?>
			
						</section>
                                    <section class="error_message">You answered our security question incorrectly. Please try again.</section>
                                </section>
								
		<?php } ?>		
                                <ul class="form_widget">
                                	<li>
                                    	<label>What's your name?</label>
					<?php
				
					if(!empty($errors['name'])){
								$errorname='textfield_input error_field';
							}else{
								$errorname='textfield_input';
							}
						?>
                                        <section class="input_field"><?php echo $form->input('BlogComment.name',array('size'=>'30','class'=>$errorname,'label'=>false,'div'=>false,'maxlength'=>80));?> <span class="inst">This will displayed</span></section>
                                    </li>
                                    <li>
                                    	<label>Add your comment</label>
					<?php if(!empty($errors['comment'])){
								$errorcomment='textfield_input error_field';
							}else{
								$errorcomment='textfield_input larger_width';
							}
						?>
                                        <section class="input_field"><?php echo $form->input('BlogComment.comment',array('class'=>$errorcomment,'cols'=>'15','rows'=>'6','showremain'=>'limitOne','label'=>false,'div'=>false,'maxlength'=>1000));?></section>
                                    </li>
				    
				    
				     <li>
                                    	<label>Please Answer the Question Below</label>
					<span>We just want to make sure that you're not a machine, if you don't know the answer you can change the question.</span>
					
						
						
                                        <section class="input_field" id="showquestion">
					    
					    <span class="line_break_new graytext"><?php echo $questions['BlogQuestion']['question'];?> <?php echo $html->link("Show me a different question","javascript:",array("escape"=>false,"title"=>"Show me a different question","id"=>"diff_question","onclick"=>"showDifferentQuestion(".$questions['BlogQuestion']['id'].");",'class'=>'queslink')); ?></span>
					    <section class="select_ans_widget" >
					    <section class="leftoptions">						
						<?php
						foreach ($questions['BlogQuestionAnswer'] as $key=>$data)
						{?>
						<section class="sel_ans">
						      <span class="rdo_opt"><input type="radio" name="data[BlogQuestionAnswer][correct_answer]" value="<?php echo $data['answer'];?>" ></span>
						     <span class="anstxt"> <?php echo $data['answer'];?> </span>
								
							<?php /*$options[$key] = $data['answer'];	
							}
						
							$attributes = array('legend' => false,'value'=>false);
						echo $form->radio('type', $options, $attributes,false);*/?>
						</section>
						<?php } ?>
						
					   </section>
					<section class="choose_ans"><?php echo $this->Html->image('/img/choose_answer.png', array('alt' => 'Choose Answer','title'=>'Choose Answer'))?></section>
					
					</section>
					    <section class="clear"></section>
					</section>
                                    </li>
                                </ul>
                                <p class="formbutton padtop"><span class="bluebtn"><input type="submit" value="Add Your Comment" class="button" name="button"></span> <span class="inst" > <span id ="limitOne">1000</span> characters left.</span> </p>
				<?php echo $form->hidden('BlogQuestion.id',array('class'=>'textbox','label'=>false,'div'=>false,'value'=>$questions['BlogQuestion']['id']));
				
				  echo $form->hidden('BlogQuestion.checkcount',array('class'=>'textbox','label'=>false,'div'=>false,'value'=>1,'id'=>'checkcount'));
				
				?>
				<?php echo $form->end(); ?>
                            </section>
                            <!--Comment Widget Closed-->
                            
                            <!--Comments Start-->
                            <section class="row_widget comments">
                            	<section class="title_widget">
                                	<h4 class="head"><?php if(count($this->data['BlogComment']) > 1) {
			echo count($this->data['BlogComment']).' Comments';
			    }
			    
			    else {
				echo count($this->data['BlogComment']).' Comment';
			    }
			    
			  ?></h4>
					
				<?php if(count($this->data['BlogComment']) >0) {?>
                                    <section class="sorting fl-rt">Sort:   <?php echo $html->link("Newest","javascript:",array("escape"=>false,"title"=>"Newest","onclick"=>"showComments(".$this->data['Blog']['id'].",'new');","class"=>"active")); ?>
				    | <?php echo $html->link("Oldest","javascript:",array("escape"=>false,"title"=>"Oldest","onclick"=>"showComments(".$this->data['Blog']['id'].",'old');")); ?>
				    <?php } ?>
				</section>
                                </section>
				
				
                                <section class="loading_sec">
					<?php if(count($this->data['BlogComment']) >0) {?>
				 <?php echo $html->link("<span>Load Comments</span>","javascript:",array("escape"=>false,"title"=>"Load Comments","id"=>"showComlink","onclick"=>"showComments('".$this->data['Blog']['id']."','new');")); ?>
				 second argument to Function.prototype.apply must be an array
[Break On This Error] 	

(31 out of range 21)
		<?php echo $html->link("<span style='padding-top:12px;'>".$this->Html->image('/img/images/blogs/Loading_comments.gif', array('alt' => 'Loading Comments'))."</span>","javascript:",array("escape"=>false,"title"=>"Load Comments","id"=>"LoadingComments","style"=>"display:none;")); ?>		
			 
			 <?php } ?>
				
				</section>
                                <div id="showcomments"></div>
                            </section>
                            <!--Comments Closed-->
                            
                        </section>
                    </section>
                    <!--Box Middle Closed-->
                    
                    <!--Box Bottom Start-->
                	<section class="box_bottom">
                    	<span class="boxbottom_left"></span>
                        <span class="boxbottom_right"></span>
                    </section>
                    <!--Box Bottom Closed-->
                </section>
                <!--Box Frame Closed-->
                
                
            </section>
            
          <?php
	    $allblogIds = array();
	    foreach ($blogs_left as $blog){
		$allblogIds[] = $blog['Blog']['slug'];
	    }
	  
	    if(count($allblogIds) > 1)
	    {
	    $next_blog_id = (next($allblogIds));
	    $pre_blog_id = (prev($allblogIds));
	    }
	    else {
		$next_blog_id = $allblogIds[0];
		$pre_blog_id = $allblogIds[0];
	    }
	    
	    ?>
	<p class="rightposbtn" style="display:none;" id="linktop"><a href="javascript:" class="graybutton"><span>Back to the top</span></a></p>

            <p class="rightposbtn" id="next" style="display:none;">
	    <?php echo $html->link("<span>What's up next</span>",array("controller"=>"blogs","action"=>"blogdetails",$next_blog_id),array('escape'=>false,'title'=>"What's up next",'class'=>'graybutton'));?>
	    </p>
	    <p class="leftposbtn" id="prev" style="display:none;">
	     <?php echo $html->link("<span>Previous article</span>",array("controller"=>"blogs","action"=>"blogdetails",$pre_blog_id),array('escape'=>false,'title'=>"Previous article",'class'=>'graybutton'));?>
	    </p>
        </section>
        <!--Right Closed-->
	
	<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4d882e8a367f2b78"></script>
<?php echo $javascript->link('jquery-paged-scroll'); ?>
	<script type="text/javascript">
	
	function showDifferentQuestion(question_id)
	{
		var checkcount =jQuery("#checkcount").val();
		jQuery.ajax({
		type: "POST",
		url: "/blogs/displayquestion/"+checkcount,
		/*data:question_id,*/
		beforeSend: function(html) {
			jQuery("#showquestion").html('<span style=color:red>Loading... Please wait</span>');
            },
            success: function(response){ // this happen after we get result
			jQuery("#showquestion").show();
			jQuery("#showquestion").html(response);
			jQuery("#checkcount").val(parseInt(checkcount)+1);
			
			
            }
	    
        });
		
	}
	
	function showReadlater()
	{
	jQuery("#readlater").slideToggle(500);
	jQuery("#share_widget, #shortlink").hide(500);
	jQuery(this).toggleClass("selected_link");
	return false;
	}
	
	function showComments(blog_id, sortby)
	{
	    jQuery.ajax({
            type: "POST",
            url: "/blogs/getcomments/"+blog_id+'/'+sortby,
            data:blog_id,
            beforeSend: function(html) { // this happen before actual call
                jQuery("#showcomments").html('');
		jQuery("#LoadingComments").show();
		jQuery("#showComlink").hide();
		
            },
            success: function(response){ // this happen after we get result
		        jQuery("#LoadingComments").hide();
			jQuery("#showComlink").hide();
			jQuery("#showcomments").show();
			jQuery("#showcomments").html(response);
            }
        });
	    
	}
	
	function myfunction(){
	var right_height = jQuery('.articlebox').height();
		//alert(right_height);
	
		var countp12 = 1;
		if(right_height >= 5300){
				var countp12 = 5;
		}
		else if(right_height >= 4400){
				var countp12 = 4;
		}
		else if(right_height >= 3500){
				var countp12 = 3;
		}
		else if(right_height > 2600){
				var countp12 = 2;
		}
		var pount = parseInt(<?php echo $pCount; ?>);
	
      var xhr = null;
	  var xhrll =null;
	var checkcount =jQuery("#checkcount").val(1);
	jQuery(window).scroll(function(){
          
	var scroller_height = jQuery(window).scrollTop();
	var page_height = jQuery(document).height() * 0.50 ;
	  
          if(scroller_height > page_height)
		{
		//  jQuery('#next').show();
		//  jQuery('#prev').show();
		}
		else
		{
		  jQuery('#next').hide();
		  jQuery('#prev').hide();
		  
		}
		});
	jQuery(window).scroll(function(){
          
	  var scroller_height = jQuery(window).scrollTop();
	  var page_height = jQuery(document).height() * 0.45 ;
	
		if(scroller_height > page_height){
		      jQuery('#linktop').show();
		}
		else{
			jQuery('#linktop').hide();
		}
	 });
	   
     jQuery('#linktop').click(function(){
    jQuery('html, body').animate({scrollTop:0}, 'slow');
 });
     
     
	//alert(right_height);
	if(right_height >= 1800){
	
jQuery(window).paged_scroll({
    
        handleScroll:function (page,container,doneCallback) {
          jQuery('#mydiv').show();
	  jQuery('#loadPosts').hide();
	  var count = jQuery(".inspirational li").size();
	  var pCount = "<?php echo $pCount; ?>";
	 var  countN = count;
	  url_left = '/blogs/blog_left_more_detail';
	  url_left = url_left + '/' +countN;
	  xhrll = jQuery.ajax({
	       category: "GET",
	       url:url_left,
	       async :true,
	       success: function(msg){
		  jQuery('.inspirational').append(msg);
		   
		 
		}
	  });
	  
	  return true;
        },
        // Uncomment to enable infinite scroll
	  pagesToScroll: countp12,
	  triggerFromBottom:'1%',

	  debug  : false,
	  targetElement : jQuery('.inspirational')
	  
	 });  
	}
	}
	
	</script>