<?php ?>
<!--Main Content Starts--->
             <section class="maincont nopadd">
                <!--Steps Starts--> 
                  <ul class="steps stepshelp">
                     <li><a href="#">Mobile Shopping</a></li>
                     <li><a href="#">Help</a></li>
                  </ul>
                <!--Steps Starts-->
                <!--Content Section Starts-->
                   <section class="mobylspng">
                      <b>Frequently Asked Questions</b>
                           <!----->
                           <section class="helpmenu">
			     <?php if(!empty($allfaqs)){?>
                              <ul>
				<?php foreach($allfaqs as $faq){
				$divid = "answer_".$faq['Faq']['id'];
				$question = $faq['Faq']['question'];
				?>
                                 <li>
					<?php echo $html->link($question,"javascript:void(0);",array('onclick'=>"displayanswer('".$divid."')",'escape'=>false));?>
					<div style="display:none" id = "<?php echo 'answer_'.$faq['Faq']['id'];?>">
					<div class="ans">
					<div class="content-list faq_ans">
						<?php echo $faq['Faq']['answer']?></div>
					</div>
					<div class="x-closed"><?php echo $html->link('x close',"javascript:void(0);",array('onClick'=>'hideanswer("answer_'.$faq['Faq']['id'].'")'));?></div>
					</div>
				 </li>
                                 <?php }?>
                              </ul>
			      <?php }?>
			      
			      <?php
				if(!empty($faqCategoryArr)){ ?>
					<h4 class="orng-clr" style="padding-top:5px;">FAQs</h4>
					<ul>
						<?php foreach($faqCategoryArr as $faq_cat_id =>$faq_cat){ ?>
							<li><?php echo $html->link($faq_cat,'/faqs/view/'.$faq_cat_id,array('escape'=>false));?></li>
						<?php }?>
					</ul>
				<?php } ?>
				
                           </section>
                           <!----> 
                      </section>
             </section>
          <!--Main Content End--->
<!--mid Content Closed-->
<script type="text/javascript">
	function displayanswer(answerid){
		jQuery('#'+answerid).css('display','block');
	}

	function hideanswer(answerid){
		jQuery('#'+answerid).css('display','none');
	}
</script>