<!--Footer Start-->
    <footer>
    	<section class="footer">
        	<section class="footer_left">
            	<h2>Connect with Choiceful</h2>
                <ul class="followus">
		<li class="addthis_toolbox addthis_default_style">
		    
		 <!-- AddThis Button BEGIN -->
	   
	    <a class="addthis_button_email">
		<?php echo $html->image('/img/images/blogs/mail_icon.png', array("alt"=>"Mail",'style'=>'border:0px'));?>
	    </a>
	    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4d882e8a367f2b78"></script>
	 
<!-- AddThis Button END -->   
		<?php 
		// echo $html->link($html->image('/img/images/blogs/mail_icon.png', array("alt"=>"Mail",'style'=>'border:0px')),array("controller"=>"blogs","action"=>"#"),array('escape'=>false)); ?>
		</li>
                    <li><?php 
		echo $html->link($html->image('/img/images/blogs/url_icon.png', array("alt"=>"Mail",'style'=>'border:0px')),'javascript:',array('escape'=>false,'onclick'=>'location.reload();')); ?></li>
                    <li><?php 
		echo $html->link($html->image('/img/images/blogs/fb_icon.png', array("alt"=>"Mail",'style'=>'border:0px')),'https://www.facebook.com/choiceful',array('escape'=>false,'target'=>'_balnk')); ?></li>
                </ul>
            </section>
            
            <!--Tweets Start-->
            <section class="footer_right">
            	<h2>Recent Tweets</h2>
                <ul class="tweets">    
		<?php
		    $eventHappen = '';
		
		    $tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		    );
		foreach($content as $key=>$val){
		    
		    if($key <=4){
			    if(isset($val->created_at)){
			    $time = strtotime(@$val->created_at);
			    $time = time()-$time; // to get the time since that moment
			    
			    foreach ($tokens as $unit => $text) {
				
				if($time < $unit){}else{
				    $numberOfUnits = floor($time/$unit);
				       $time = floor($time%$unit);
				    $eventHappen .= " ".$numberOfUnits.' '.$text;
				    $eventHappen .= ($numberOfUnits>1)?'s':'';
				    
				   
				}
			    }
			    echo "<li>";
			    echo "<p style='padding-bottom:5px;word-wrap: break-word;'>@ <a target='_blank' href='https://twitter.com/{$val->user->screen_name}'>{$val->user->name}</a>"." ".$val->text."</p>";
			    echo  "<p><a href='javascript(void(0))'>{$eventHappen}</a> ago</p>"; 
			    echo "</li>";
			    $eventHappen = '';
			}
		    }
		}
		 ?>  
<!-- <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
            new TWTR.Widget({
              version: 2,
              type: 'profile',
              rpp: 3,
              interval: 30000,
              theme: {
                shell: {
                  background: '#272727',
                  color: '#B4B4B4'
                },
                tweets: {
                  background: '#272727',
                  color: '#B4B4B4',
                  links: '#7A7A7A'
                }
              },
              features: {
                scrollbar: false,
                loop: false,
                live: false,
                behavior: 'all'
              }
            }).render().setUser('Choicefulcom').start().delay(4000);
            $('.twtr-join-conv').delay(2000).css('color','#397BA5');
</script> --->

<style type="text/css">
    
    .twtr-hd, .twtr-ft
{
display: none;
}

</style>
                </ul>
                <p style="margin-top:10px; ">
		<?php echo $html->link($html->image('/img/images/blogs/followtweets.png', array("alt"=>"Blog Details",'style'=>'border:0px','width'=>129,'height'=>20)),'http://twitter.com/Choicefulcom',array('escape'=>false,'title'=>'','alt'=>'','target'=>'_blank')); ?>
		
		</p>
            </section>
            <!--Tweets Closed-->
        </section>
        <!--Bottom start-->
        <section class="bottom">
        	<section class="copyright">&copy; 2013 Choiceful.com</section>
            <section class="footer_links">
	   <?php echo $html->link('Contact',array("controller"=>"pages","action"=>"view/contact-us"),array('escape'=>false,'title'=>'Contact'));?>
	   
	   <?php echo $html->link('Terms',array("controller"=>"pages","action"=>"view/terms-and-conditions"),array('escape'=>false,'title'=>'Terms'));?>
	   
	    <?php echo $html->link('Privacy',array("controller"=>"pages","action"=>"view/privacy-policy"),array('escape'=>false,'title'=>'Privacy'));?>
	    
	     <?php echo $html->link('Copyright',array("controller"=>"pages","action"=>"view/conditions-of-use"),array('escape'=>false,'title'=>'Copyright'));?>
	   
	    
	    </section>
        </section>
        <!--Bottom Closed-->
    </footer>
    <!--Footer Closed-->
  