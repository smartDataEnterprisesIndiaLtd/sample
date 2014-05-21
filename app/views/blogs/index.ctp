 <section class="right_widget">
        	<section class="box_gallery">
		    <div id="allComingPosts" class="showPostsHere clearfix">
<?php  $i=0;
		      if(!empty($blogs_main12) && is_array($blogs_main12) && count($blogs_main12) > 0) {
		      foreach ($blogs_main12 as $blog) { 
		      ?>	
	      <!--Box Frame Start-->
	      <section class="box box_frame getPosts">
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
		      
			  <h1><a href="/blog/blogdetails/<?php echo $blog['Blog']['slug'];?>" title="<?php echo $blog['Blog']['title'];?>" border="0"><?php echo $blog['Blog']['title'];?><span class="postpic">
			      
			      
			      <?php
			      # display current image preview 
			      $imagePath = WWW_ROOT.PATH_CHOICEFUL_BLOGS."medium/img_200_".$blog['Blog']['image'];
			      if(file_exists($imagePath)   && !empty($blog['Blog']['image']) ){
			        $image_title = substr($blog['Blog']['image'],0,-4);
				$image_title_new = substr($image_title,11);

					  $imgSizeArr = getimagesize($imagePath);
					  $height=$imgSizeArr[1];
	
			      ?>
			      
<img src="../../<?php echo PATH_CHOICEFUL_BLOGS."medium/img_200_".$blog['Blog']['image'];?>" width="279" height="<?php echo $height;?> "alt="<?php echo $image_title_new;?>" title="<?php echo $image_title_new;?>" border="0"/>
			      <?php } ?>
			      </span></a></h1>
			      
			     <?php  
				foreach($blog['Blog'] as $field_index => $info){
		      $blog['Blog'][$field_index] = html_entity_decode($info);
		      $blog['Blog'][$field_index] = str_replace('&#039;',"'",$blog['Blog'][$field_index]);
		      $blog['Blog'][$field_index] = str_replace('\n',"",$blog['Blog'][$field_index]);
				}
			?>
			  <section class="row">
		     <p class="posttext">
		     <?php echo $converted_text = $this->Common->printTruncated(200,$blog['Blog']['description'],true);?>
		  </p>
		     
			      <p class="posttext"></p>
			      
			      <p class="poston">
				      
				      <?php
			      if($blog['Blog']['created'] == '0000-00-00 00:00:00'){
				  echo 'NA';
			      } else { ?>
			      
			      Posted on <span class="line_break grcolor"><?php echo date(BLOG_DATE_FORMAT1,strtotime($blog['Blog']['created']));?></span>
			      <?php } ?>
			      </p>
			  </section>  
			  
			  <section class="row">                          
			      <p class="poston"><?php
			      $tags='';
			      foreach ($blog['BlogSearchtag'] as $searchtags )
			      {
			      $tags .= $searchtags['tags'].', ';
			      }
			      echo substr($tags,0,-2);
			      
		      ?></p>
			      <section class="buttons">
			      <?php echo $html->link('<span>Read Later</span>','javascript:',array('escape'=>false,'title'=>'Read Later','class'=>'gray_btn readlater','onclick'=>'showReadlater('.$blog['Blog']['id'].');')); ?>
				
				<?php echo $html->link("<span>Share</span>",'http://www.addthis.com/bookmark.php?v=250&amp;pubid=xa-4d882e8a367f2b78',array('escape'=>false,'title'=>"Share",'class'=>'addthis_button_compact gray_btn share')); ?>
				
		
				  <section class="clear"></section>
				  <!--Read Later Popup Start-->
				  <section class="popup_widget" id="readlater_<?php echo $blog['Blog']['id'];?>">
				      <section class="popupframe">
					  <p class="poparrow"><?php echo $this->Html->image('/img/images/blogs/popup_arrow.png', array('alt' =>'Read It Later'));?></p>
					  <section class="later_sec">
					      <p class="saveto">save to</p>
					  
					      <p>
					      <?php echo $html->link("Instapaper","http://www.instapaper.com/hello2?url=".Configure::read('siteUrl')."/blogs/blogdetails/".$blog['Blog']['slug']."&title=".$blog['Blog']['title'],array('escape'=>false,'title'=>"Instapaper")); ?>
					      
					      <span class="sep"></span>
					      <a href="http://www.addtoany.com/add_to/read_it_later?linkurl=<?php echo Configure::read('siteUrl');?>/blogs/blogdetails/<?php echo $blog['Blog']['slug'];?>&amp;linkname=<?php echo $blog['Blog']['title'];?>">Read It Later</a> 
					     </p>
					  </section>
				      </section>
				      <p class="popup_bottom"></p>
				  </section>
				  <!--Read Later Popup Closed-->
				  
				 
			      </section>
			      
			      <section class="links_sec">
			      
			       <?php  echo $html->link('Permalink',array("controller"=>"blogs","action"=>"blogdetails",$blog['Blog']['slug']),array('escape'=>false,'title'=>'Permalink','alt'=>'Permalink','class'=>'permalink')); ?>
				
				  
				  <?php if(count($blog['BlogComment']) > 1) {
			      
		      echo $html->link(count($blog['BlogComment']).' Comments',array("controller"=>"blogs","action"=>"blogdetails",$blog['Blog']['slug']),array('escape'=>false,'title'=>$blog['Blog']['title'],'alt'=>$blog['Blog']['title'],'class'=>'comments_link'));
			  }
			  
			  else {
			      echo $html->link(count($blog['BlogComment']).' Comment',array("controller"=>"blogs","action"=>"blogdetails",$blog['Blog']['slug']),array('escape'=>false,'title'=>$blog['Blog']['title'],'alt'=>$blog['Blog']['title'],'class'=>'comments_link'));
			  }
			  
			?>
			
			<?php
		      
			$shorturl= $this->Common->shorten_url(Configure::read('siteUrl').'/blogs/blogdetails/'.$blog['Blog']['slug'],$service='tinyurl.com');
			
			?>
			<?php echo $html->link('Short Url','javascript:',array('escape'=>false,'title'=>'Short Url','alt'=>'Short Url','class'=>'shorturl','onclick'=>'showShorturl('.$blog['Blog']['id'].');'));?>
				  
				 
				      <!--Shortlink Popup Start-->
				  <section class="popup_widget" style="margin-left:60px;" id="shortlink_<?php echo $blog['Blog']['id']; ?>">
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
			  </section> 
			  
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
	      
	       <?php $i++;} //foreach ends
		  } //if ends
		 // else{
		    //  echo 'No blogs found.';
		   //   }?>
		      </section>
		          </section>
		    </div>
	      <?php echo $this->element('blogs/right_panel');?>
	       <div id="largeData"></div>
<?php echo $javascript->link('jquery.masonry.min'); ?>
<?php echo $javascript->link('jquery-paged-scroll'); ?>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4d882e8a367f2b78"></script>
<script type="text/javascript">

function showReadlater(id)
{
jQuery("#readlater_"+id).slideToggle(500);
jQuery("#share_widget, #shortlink_"+id).hide(500);
jQuery(this).toggleClass("selected_link");
return false;
}


function showShorturl(id)
{
jQuery("#shortlink_"+id).slideToggle(500);
jQuery("#readlater_"+id).hide(500);
jQuery(this).toggleClass("selected_link");
return false;	      	
}
	
	
  jQuery(function(){
    jQuery('#allComingPosts').masonry({
      singleMode: false,
      columnHeight: 100,
      isFitHeight: true,
      resizeable: true,
      itemSelector: '.box'
    });
  });
</script>	     
<script type="text/javascript">
jQuery(document).ready(function(){
       var pount = parseInt(<?php echo $pCount; ?>);
	 var  countp = pount/10;
      var xhr = null;
	  var xhrll =null;
   /*  function abc(){
	 
	   jQuery('#mydiv').show();
	  jQuery('#loadPosts').hide();
	  var count = jQuery("section.getPosts").size();
	  var pCount = "<?php echo $pCount; ?>";
	// alert(count);
	 // var isGrid = "<?php //echo $isGrid; ?>";
	  //var passParamForPost = "<?php //echo $passPType; ?>";
	  if(count >= pCount){
	       jQuery('#mydiv').hide();
	       jQuery('#loadPosts').hide();
	       return false;
	  }
	  
	  if( xhrll != null ) {
	       xhrll.abort();
	       xhrll = null;
	  }
	  countN = count/10;
	  url_left = '/blogs/blog_left_more';
	  url_left = url_left + '/' +countN;
	  xhrll = jQuery.ajax({
	       category: "GET",
	       url:url_left,
	       async :true,
	       success: function(msg){
		  jQuery('.inspirational').append(msg);
		   
		 
		}
	  });
	  
	  /* if there is a previous ajax search, then we abort it and then set xhr to null 
	  if( xhr != null ) {
	       xhr.abort();
	       xhr = null;
	  }
	  
	  
     
	  /* and now we can saftely make another ajax call since the previous one is aborted 
	  url = '<?php echo $this->Html->url(array('controller'=>'blogs', 'action' => 'get_page_posts')) ?>';
	  url = url + '/' + count;
	  
	
	  xhr = jQuery.ajax({
	       category: "GET",
	       url:url,
	       async : true,
	       success: function(msg){
		  jQuery('.showPostsHere').append(msg).masonry('reload');
		  jQuery('#mydiv').hide();
		  jQuery('#loadPosts').show();
                  jQuery('#pagingcount').html('Displaying '+ count + ' of '+ pCount);
                  jQuery('#pagingcount').show();
		  
		  count_1 = jQuery("section.getPosts").size();
		  if(count_1 >= pCount){
		       jQuery('#loadPosts').show();
		    
		  }
		  //});
	       }
	  });
	  return 1;
     }
     var xhr = null;
     var xhrll =null;
     //var chkCnt = 1;
     jQuery("#more_posts").click(function() {
	
	  jQuery('#mydiv').show();
	  jQuery('#loadPosts').hide();
	  var count = jQuery("section.getPosts").size();
	  var pCount = "<?php echo $pCount; ?>";
	// alert(count);
	 // var isGrid = "<?php //echo $isGrid; ?>";
	  //var passParamForPost = "<?php //echo $passPType; ?>";
	  if(count >= pCount){
	       jQuery('#mydiv').hide();
	       jQuery('#loadPosts').hide();
	       return false;
	  }
	  
	  if( xhrll == null ) {
	     //  xhrll.abort();
	      // xhrll = null;
	     //  return false;
	  
	       countN = count/10;
	       url_left = '/blogs/blog_left_more';
	       url_left = url_left + '/' +countN;
	       xhrll = jQuery.ajax({
		    category: "GET",
		    url:url_left,
		    async :true,
		    success: function(msg){
		       jQuery('.inspirational').append(msg);
			
		      
		     }
	       });
	  }
	  /* if there is a previous ajax search, then we abort it and then set xhr to null 
	  if( xhr == null ) {
	      // xhr.abort();
	      // xhr = null;
	       
		
		
		
		/* and now we can saftely make another ajax call since the previous one is aborted 
		url = '<?php echo $this->Html->url(array('controller'=>'blogs', 'action' => 'get_page_posts')) ?>';
		url = url + '/' + count;
		
	      
		xhr = jQuery.ajax({
		     category: "GET",
		     url:url,
		     async : true,
		     success: function(msg){
			jQuery('.showPostsHere').append(msg).masonry('reload');
			jQuery('#mydiv').hide();
			jQuery('#loadPosts').show();
			jQuery('#pagingcount').html('Displaying '+ count + ' of '+ pCount);
			jQuery('#pagingcount').show();
			
			count_1 = jQuery("section.getPosts").size();
			if(count_1 >= pCount){
			     jQuery('#loadPosts').show();
			  
			}
			//});
		     }
		});
	   }
	  
	}); */
     
       
 
    jQuery(window).paged_scroll({
    
        handleScroll:function (page,container,doneCallback) {
          jQuery('#mydiv').show();
	  jQuery('#loadPosts').hide();
	  var count = jQuery("section.getPosts").size();
	  var pCount = "<?php echo $pCount; ?>";
	 var  countN = count*2;
	 if(pount <= countN ){}else{
	  url_left = '/blogs/blog_left_more';
	  url_left = url_left + '/' +countN;
	  xhrll = jQuery.ajax({
	       category: "GET",
	       url:url_left,
	       success: function(msg){
		  jQuery('.inspirational').append(msg);
		   
		 
		}
	  });
	 }
	 
	  url = '/blo' + '/' + count;
	  xhr = jQuery.ajax({
		category: "GET",
		url:url,
		
		success: function(msg){
		   jQuery('#allComingPosts').append(msg).masonry('reload');
		  jQuery('#mydiv').hide();
		  jQuery('#loadPosts').show();
		   jQuery('#pagingcount').html('Displaying '+ count + ' of '+ pCount);
		   jQuery('#pagingcount').show();
		   
		   count_1 = jQuery("section.getPosts").size();
		   if(count_1 >= pCount){
		   
			jQuery('#loadPosts').hide();
			 jQuery('#pagingcount').hide();
			 jQuery('#mydiv').hide();
			 
		     
		   }
		   //});
		}
	   });
	 
            //doneCallback();
            return true;
        },
        // Uncomment to enable infinite scroll
	  pagesToScroll:countp,
	  triggerFromBottom:'2%',
	  loader:null,
	  debug  : false,
	  targetElement : jQuery('#allComingPosts')

    });

     
     
    
    jQuery(window).scroll(function(){
          
	  var scroller_height = jQuery(window).scrollTop();
	  var page_height = jQuery(document).height() * 0.55 ;
	  
          if(scroller_height > page_height)
          {
			 
            jQuery('#linktop').show();
          }
          else
          {
            jQuery('#linktop').hide();
            
          }
        // var currentHeight = parseInt(jQuery(window).scrollTop()+jQuery(window).height())+868;
	// var HH = parseInt(jQuery(window).height())+1568;
	//if(jQuery(window).scrollTop() >= jQuery(document).height() -HH ){
	 // if(jQuery(document).height() <= currentHeight){

	      // show something, load content via ajax etc
	     // jQuery('#mydiv').show();
	// abc();
	       //jQuery("#more_posts").trigger("click");
	    
	 // }
     });
     
   //  jQuery("#more_posts").trigger("click");
     
     jQuery('#linktop').click(function(){
    jQuery('html, body').animate({scrollTop:0}, 'slow');
 });
     
});
</script>