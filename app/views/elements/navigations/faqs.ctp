<?php 
App::import('Model','FaqCategory');
$this->FaqCategory = & new FaqCategory();

$faqs = $this->FaqCategory->find('list');
?>

<!--Choiceful Services Start-->
<div class="side-content">
	<h4 class="blue-head"><span>Choiceful Services</span></h4>
	<ul class="links">
		<?php if(!empty($faqs)){?>
 		<?php foreach($faqs as $faqs_id => $faq) {?>
		<li><?php echo $html->link($faq,array("controller"=>"Faq","action"=>"view",$faqs_id),array('escape'=>false));?></li>
		<?php }}?>
	</ul>
</div>
<!--Choiceful Services Closed-->