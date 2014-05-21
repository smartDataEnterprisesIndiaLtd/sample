<?php ?>
<!--mid Content Start-->
<div class="mid-content">


		<!--Tabs Start-->
	<div class="tbs-widget mrgn-tp">
	<ul>
		<li><?php echo $html->link("Make Money Advertising Choiceful",'/affiliates/view/make-money-advertising-choiceful-using-our-affiliate-programme/1',array('escape'=>false,'class'=>(($id == 1)?('active'):(''))));?></li>
		<li><?php echo $html->link("Join Us",'/affiliates/view/join-choiceful-affiliate/2',array('escape'=>false,'class'=>(($id == 2)?('active'):(''))));?></li> 
		<li><?php echo $html->link("FAQs",'/affiliates/view/choiceful-affiliate-faq/faq',array('escape'=>false,'class'=>(($id == 'faq')?('active'):(''))));?></li> 
		<li><?php echo $html->link("Contact Affiliates",'/affiliates/view/contact-choiceful-affiliate/3',array('escape'=>false,'class'=>(($id == 3)?('active'):(''))));?></li>
	</ul>
	</div>
	<!--Tabs Closed-->

	
	<!--Tabs Content Widget Start-->
	<div class="tbs-con-widget">
		<?php
		if($id == 'faq'){ ?> 
			<p class="gray larger-font"><strong>Top Affiliate Questions</strong></p>
			<?php if(!empty($this->data)){?>
			<ul class="help-links">
				<?php foreach($this->data as $faq){?>
					<li><?php echo $html->link($faq['Faq']['question'],"javascript:void(0);",array('onClick'=>'displayanswer("answer_'.$faq['Faq']['id'].'")'));?>
					<div style="display:none;" id = "<?php echo 'answer_'.$faq['Faq']['id'];?>">
						<div class="ans faq_ans" style="padding-bottom:0px!important">
							<?php echo $faq['Faq']['answer']?>
						</div>
						<div class="x-closed"><?php echo $html->link('x close',"javascript:void(0);",array('onClick'=>'hideanswer("answer_'.$faq['Faq']['id'].'")'));?></div>
					</div>
					</li>
				<?php }?>
			</ul>
			
			<?php }?>
		<?php }else { // display affiliates pages
			if( is_array($this->data['Affiliate'])  && count($this->data['Affiliate']) > 0 ){
				echo $this->data['Affiliate']['content'];
			}
		}
		?>
		
		
	</div>
	<!--Tabs Content Widget Closed-->
	
</div>
<!--mid Content Closed-->
<script type="text/javascript">
	function displayanswer(answerid){
		jQuery('#'+answerid).css('display','block');
	}

	function hideanswer(answerid){
		jQuery('#'+answerid).css('display','none');
	}
</script>