 <?php

		      $i=0;
		      if(!empty($blogs) && is_array($blogs) && count($blogs) > 0) {
		      foreach ($blogs as $blog) { 
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
		     <?php echo $converted_text = $this->Common->printTruncated(200,$blog['Blog']['description'],true);?></p>
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
		//  else{
		   //   echo 'No blogs found.';
		  //    }?>
	      
<?php echo $javascript->link('jquery.masonry.min.js'); ?>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4d882e8a367f2b78"></script>
<script type="text/javascript">

function showReadlater(id)
{
$("#readlater_"+id).slideToggle(500);
$("#share_widget, #shortlink_"+id).hide(500);
$(this).toggleClass("selected_link");
return false;
}


function showShorturl(id)
{
$("#shortlink_"+id).slideToggle(500);
$("#readlater_"+id).hide(500);
$(this).toggleClass("selected_link");
return false;	      	
}
	
	
  $(function(){
    $('#allComingPosts').masonry({
      singleMode: false,
      columnHeight: 100,
      isFitHeight: true,
      resizeable: true,
      itemSelector: '.box'
    });
  });
</script>	     