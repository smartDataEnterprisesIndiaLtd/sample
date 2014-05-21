<?php
App::import('Model','Page');
$this->Page = & new Page();
App::import('Model','FaqCategory');
$this->FaqCategory = & new FaqCategory();
?>
<!--Left Content Start-->
<div class="left-content">
	<h4 class="gray-bg-head"><span>Help Topics</span></h4>
	<div class="gray-fade-bg-box padding">
		<!--Ordering Start-->
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head">Ordering</h4>
			<ul class="help-links">
			<?php
			$ordering_id_str = '';
			$pages_ordering = $this->Page->find('all',array('conditions'=>array('Page.sequence Between 1 AND 7','Page.pagegroup'=>'ordering' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence'),'limit'=>7));
			if(!empty($pages_ordering)){
			foreach($pages_ordering as $order_page){ ?>
				<li><?php echo $html->link(strip_tags($order_page['Page']['title']),"/pages/view/".$order_page['Page']['pagecode'],array('escape'=>false));?></li>
				<?php if(empty($ordering_id_str))
					$ordering_id_str = $order_page['Page']['id'];
				else
					$ordering_id_str = $ordering_id_str.','.$order_page['Page']['id'];
			} }?>
			</ul>
			<ul class="help-links" id="orderingall" style="display:none">
			<?php
			if(!empty($ordering_id_str)){
				$pages_ordering_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'ordering','Page.id NOT IN ('.$ordering_id_str.')'),'order'=>array('Page.sequence','Page.id')));
			} else {
				$pages_ordering_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'ordering'),'order'=>array('Page.sequence','Page.id')));
			}
			if(!empty($pages_ordering_other)){
			foreach($pages_ordering_other as $order_other_page){ ?>
				<li><?php echo $html->link(strip_tags($order_other_page['Page']['title']),"/pages/view/".$order_other_page['Page']['pagecode'],array('escape'=>false));?></li>
			<?php } }?>
			</ul>
			<p class = "padding-left margin-top" id="all-ordering">
				<?php echo $html->link('Show all','javascript:void(0)',array('onClick'=>'displaydiv("orderingall","all-ordering")','class'=>'show-all underline-link'),false,false);?>
			</p>
		</div>
		<!-- Ordering Closed -->
		<!-- Dispatch and Delivery Start -->
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head">Dispatch and Delivery</h4>
			<ul class="help-links">
			<?php
			$delivery_id_str = '';
			$pages_delivery = $this->Page->find('all',array('conditions'=>array('Page.sequence Between 1 AND 7','Page.pagegroup'=>'delivery' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence'),'limit'=>7));
			if(!empty($pages_delivery)){
			foreach($pages_delivery as $paged){ ?>
				<li><?php echo $html->link(strip_tags($paged['Page']['title']),"/pages/view/".$paged['Page']['pagecode'],array('escape'=>false));?></li>
				<?php if(empty($delivery_id_str))
					$delivery_id_str = $paged['Page']['id'];
				else
					$delivery_id_str = $delivery_id_str.','.$paged['Page']['id'];
			} }?>
			</ul>
			<ul class="help-links" id="deliveryall" style="display:none">
			<?php
			if(!empty($delivery_id_str)){
				$pages_delivery_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'delivery','Page.id NOT IN ('.$delivery_id_str.')'),'order'=>array('Page.sequence','Page.id')));
			} else {
				$pages_delivery_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'delivery'),'order'=>array('Page.sequence','Page.id')));
			}
			if(!empty($pages_delivery_other)){
			foreach($pages_delivery_other as $pageod){ ?>
				<li><?php echo $html->link(strip_tags($pageod['Page']['title']),"/pages/view/".$pageod['Page']['pagecode'],array('escape'=>false));?></li>
			<?php } } ?>
			</ul>
			<p class="padding-left margin-top" id="alldelivery">
				<?php echo $html->link('Show all','javascript:void(0)',array('onClick'=>'displaydiv("deliveryall","alldelivery")','class'=>'show-all underline-link'),false,false);?>
			</p>
		</div>
		<!--Dispatch and Delivery Closed-->
		<!--Returns and Refunds Start-->
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head">Returns and Refunds</h4>
			<ul class="help-links" >
			<?php
			$returns_id_str = '';
			$pages_return = $this->Page->find('all',array('conditions'=>array('Page.sequence Between 1 AND 7','Page.pagegroup'=>'returns' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence'),'limit'=>7));
			if(!empty($pages_return)){
			foreach($pages_return as $pager){ ?>
				<li><?php echo $html->link(strip_tags($pager['Page']['title']),"/pages/view/".$pager['Page']['pagecode'],array('escape'=>false));?></li>
				<?php if(empty($return_id_str))
					$return_id_str = $pager['Page']['id'];
				else
					$return_id_str = $return_id_str.','.$pager['Page']['id'];
			} }?>
			</ul>
			<ul class="help-links" id="returnlinks" style="display:none">
			<?php
			if(!empty($return_id_str)){
				$pages_return_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'returns','Page.id NOT IN ('.$return_id_str.')'),'order'=>array('Page.sequence','Page.id')));
			} else {
				$pages_return_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'returns'),'order'=>array('Page.sequence','Page.id')));
			}
			if(!empty($pages_return_other)){
			foreach($pages_return_other as $pageor){ ?>
				<li><?php echo $html->link(strip_tags($pageor['Page']['title']),"/pages/view/".$pageor['Page']['pagecode'],array('escape'=>false));?></li>
			<?php } } ?>
			</ul>
			<p class="padding-left margin-top" id="allreturn">
				<?php echo $html->link('Show all','javascript:void(0)',array('onClick'=>'displaydiv("returnlinks","allreturn")','class'=>'show-all underline-link'),false,false);?>
			</p>
		</div>
		<!--Returns and Refunds Closed-->
		<!--Choiceful Marketplace Start-->
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head">Choiceful Marketplace</h4>
			<ul class="help-links">
			<?php
			$marketplace_id_str = '';
			$pages_marketplace = $this->Page->find('all',array('conditions'=>array('Page.sequence Between 1 AND 7','Page.pagegroup'=>'marketplace' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence'),'limit'=>7));
			if(!empty($pages_marketplace)){
			foreach($pages_marketplace as $pagemp){ ?>
				<?php if($pagemp['Page']['id']==94){?>
				<li><?php echo $html->link(strip_tags($pagemp['Page']['title']),array('controller'=>'sellers','action'=>'sign_up'),array('escape'=>false));?></li>
				<?php }else{?>
				<li><?php echo $html->link(strip_tags($pagemp['Page']['title']),"/pages/view/".$pagemp['Page']['pagecode'],array('escape'=>false));?></li>
				<?php }?>
				<?php if(empty($marketplace_id_str))
					$marketplace_id_str = $pagemp['Page']['id'];
				else
					$marketplace_id_str = $marketplace_id_str.','.$pagemp['Page']['id'];
			} }?>
			</ul>
			<ul class="help-links" id="marketplacelinks" style="display:none">
			<?php
			if(!empty($marketplace_id_str)){
				$pages_marketplace_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'marketplace','Page.id NOT IN ('.$marketplace_id_str.')'),'order'=>array('Page.sequence','Page.id')));
			} else {
				$pages_marketplace_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'marketplace'),'order'=>array('Page.sequence','Page.id')));
			}
			if(!empty($pages_marketplace_other)){
			foreach($pages_marketplace_other as $pageomp){ ?>
				<li><?php echo $html->link(strip_tags($pageomp['Page']['title']),"/pages/view/".$pageomp['Page']['pagecode'],array('escape'=>false));?></li>
			<?php } } ?>
			<li><?php echo $html->link('Marketplace Buying FAQs','/faqs/view/9',array('escape'=>false));?></li>
			<li><?php echo $html->link('Marketplace Selling FAQs','/faqs/view/10',array('escape'=>false));?></li>
			</ul>
			<p class="padding-left margin-top" id="allmarketplace">
				<?php echo $html->link('Show all','javascript:void(0)',array('onClick'=>'displaydiv("marketplacelinks","allmarketplace")','class'=>'show-all underline-link'),false,false);?>
			</p>
		</div>
		<!--Choiceful Marketplace Closed-->
		<!--Make me an Offer&trade; Start-->
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head">Make me an Offer&trade;</h4>
			<ul class="help-links">
			<?php
			$offer_id_str = '';
			$pages_offer = $this->Page->find('all',array('conditions'=>array('Page.sequence Between 1 AND 4','Page.pagegroup'=>'offer' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence'),'limit'=>4));
			if(!empty($pages_offer)){
			foreach($pages_offer as $pageoffer){ ?>
				<li><?php echo $html->link(strip_tags($pageoffer['Page']['title']),"/pages/view/".$pageoffer['Page']['pagecode'],array('escape'=>false));?></li>
				<?php if(empty($offer_id_str))
					$offer_id_str = $pageoffer['Page']['id'];
				else
					$offer_id_str = $offer_id_str.','.$pageoffer['Page']['id'];
			} }?>
			</ul>
			<ul class="help-links" id="offerlinks" style="display:none">
			<?php
			if(!empty($offer_id_str)){
				$pages_offer_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'offer','Page.id NOT IN ('.$offer_id_str.')'),'order'=>array('Page.sequence','Page.id')));
			} else {
				$pages_offer_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'offer'),'order'=>array('Page.sequence','Page.id')));
			}
			if(!empty($pages_offer_other)){
			foreach($pages_offer_other as $pageooffer){ ?>
				<li><?php echo $html->link(strip_tags($pageooffer['Page']['title']),"/pages/view/".$pageooffer['Page']['pagecode'],array('escape'=>false));?></li>
			<?php } } ?>
			</ul>
			<p class="padding-left margin-top" id="alloffer">
				<?php echo $html->link('Show all','javascript:void(0)',array('onClick'=>'displaydiv("offerlinks","alloffer")','class'=>'show-all underline-link'),false,false);?>
			</p>
		</div>
               <!--Make me an Offer&trade; Closed-->
		<!--Manage Your Account Start-->
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head">Manage Your Account</h4>
			<ul class="help-links">
			<?php
			$account_id_str = '';
			$pages_account = $this->Page->find('all',array('conditions'=>array('Page.sequence Between 1 AND 6','Page.pagegroup'=>'account' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence'),'limit'=>6));
			if(!empty($pages_account)){
			foreach($pages_account as $pageaccount){ ?>
				<li><?php echo $html->link(strip_tags($pageaccount['Page']['title']),"/pages/view/".$pageaccount['Page']['pagecode'],array('escape'=>false));?></li>
				<?php if(empty($account_id_str))
					$account_id_str = $pageaccount['Page']['id'];
				else
					$account_id_str = $account_id_str.','.$pageaccount['Page']['id'];
			} }?>
			</ul>
			<ul class="help-links" id="accountlinks" style="display:none">
			<?php
			if(!empty($account_id_str)){
				$pages_account_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'account','Page.id NOT IN ('.$account_id_str.')'),'order'=>array('Page.sequence','Page.id')));
			} else {
				$pages_account_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'account'),'order'=>array('Page.sequence','Page.id')));
			}
			if(!empty($pages_account_other)){
			foreach($pages_account_other as $pageoaccount){ ?>
				<li><?php echo $html->link(strip_tags($pageoaccount['Page']['title']),"/pages/view/".$pageoaccount['Page']['pagecode'],array('escape'=>false));?></li>
			<?php } } ?>
			</ul>
			<p class="padding-left margin-top" id="allaccount">
				<?php echo $html->link('Show all','javascript:void(0)',array('onClick'=>'displaydiv("accountlinks","allaccount")','class'=>'show-all underline-link'),false,false);?>
			</p>
		</div>
		<!--Manage Your Account Closed-->
		<!--Gift Certificates Start-->
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head">Gift Certificates</h4><ul class="help-links">
			<?php
			$certificate_id_str = '';
			$pages_certificate = $this->Page->find('all',array('conditions'=>array('Page.sequence Between 1 AND 5','Page.pagegroup'=>'certificate' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence'),'limit'=>5));
			if(!empty($pages_certificate)){
			foreach($pages_certificate as $pagecertificate){ ?>
				<li><?php echo $html->link(strip_tags($pagecertificate['Page']['title']),"/pages/view/".$pagecertificate['Page']['pagecode'],array('escape'=>false));?></li>
				<?php if(empty($certificate_id_str))
					$certificate_id_str = $pagecertificate['Page']['id'];
				else
					$certificate_id_str = $certificate_id_str.','.$pagecertificate['Page']['id'];
			} }?>
			</ul>
			<ul class="help-links" id="certificatelinks" style="display:none">
			<?php
			if(!empty($certificate_id_str)){
				$pages_certificate_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'certificate','Page.id NOT IN ('.$certificate_id_str.')'),'order'=>array('Page.sequence','Page.id')));
			} else {
				$pages_certificate_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'certificate'),'order'=>array('Page.sequence','Page.id')));
			}
			if(!empty($pages_certificate_other)){
			foreach($pages_certificate_other as $pageocertificate){ ?>
				<li><?php echo $html->link(strip_tags($pageocertificate['Page']['title']),"/pages/view/".$pageocertificate['Page']['pagecode'],array('escape'=>false));?></li>
			<?php } } ?>
			</ul>
			<p class="padding-left margin-top" id="allcertificate">
				<?php echo $html->link('Show all','javascript:void(0)',array('onClick'=>'displaydiv("certificatelinks","allcertificate")','class'=>'show-all underline-link'),false,false);?>
			</p>
		</div>
		<!--Gift Certificates Closed-->

		<?php 
		$allfaq_categories = $this->FaqCategory->find('list',array('conditions'=>array('FaqCategory.title != "Affiliates Q & A"'),'fields'=>array('id','title')));
		if(!empty($allfaq_categories)){
		?>
		<!--FAQs Start-->
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head">FAQs</h4>
			<ul class="help-links">
				<?php foreach($allfaq_categories as $faq_cat_id =>$faq_cat){?>
				<li><?php echo $html->link($faq_cat,'/faqs/view/'.$faq_cat_id,array('escape'=>false));?></li>
				<?php }?>
			</ul>
		</div>
		<!--FAQs Closed-->
		<?php }?>
		<div class="side-content">
			<h4 class="orange-col-head help-topic-head">Choiceful.com Policies</h4>
			<ul class="help-links" >
			<?php
			$policy_id_str = '';
			$pages_policy = $this->Page->find('all',array('conditions'=>array('Page.sequence Between 1 AND 5','Page.pagegroup'=>'policy' ),'fields'=>array('Page.id','Page.title','Page.pagecode','Page.pagegroup','Page.sequence','Page.id'),'order'=>array('Page.sequence'),'limit'=>5));
			if(!empty($pages_policy)){
			foreach($pages_policy as $pagepolicy){ ?>
				<li><?php echo $html->link(strip_tags($pagepolicy['Page']['title']),"/pages/view/".$pagepolicy['Page']['pagecode'],array('escape'=>false));?></li>
				<?php if(empty($policy_id_str))
					$policy_id_str = $pagepolicy['Page']['id'];
				else
					$policy_id_str = $policy_id_str.','.$pagepolicy['Page']['id'];
			} }?>
			</ul>
			<ul class="help-links" id="policylinks" style="display:none">
			<?php
			if(!empty($policy_id_str)){
				$pages_policy_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'policy','Page.id NOT IN ('.$policy_id_str.')'),'order'=>array('Page.sequence','Page.id')));
			} else {
				$pages_policy_other = $this->Page->find('all',array('conditions'=>array('Page.pagegroup'=>'policy'),'order'=>array('Page.sequence','Page.id')));
			}
			if(!empty($pages_policy_other)){
			foreach($pages_policy_other as $pageopolicy){ ?>
				<li><?php echo $html->link(strip_tags($pageopolicy['Page']['title']),"/pages/view/".$pageopolicy['Page']['pagecode'],array('escape'=>false));?></li>
			<?php } } ?>
			</ul>
			<p class="padding-left margin-top" id="allpolicy">
				<?php echo $html->link('Show all','javascript:void(0)',array('onClick'=>'displaydiv("policylinks","allpolicy")','class'=>'show-all underline-link'),false,false);?>
			</p>
		</div>
	</div>
</div>
<!--Left Content Closed-->
<script type="text/javascript">
function displaydiv(showdiv,hidediv){
	jQuery('#'+showdiv).css('display','block');
	jQuery('#'+hidediv).css('display','none');
}
</script>