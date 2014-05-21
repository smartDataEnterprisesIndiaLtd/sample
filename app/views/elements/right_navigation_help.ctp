<?php ?>
<!--Right Widget Start-->
<div class="right-widget">
	<?php echo $this->element('navigations/self_services');?>
<?php if(!empty($this->params)){
	if(!empty($this->params['pass'])) {
		if(!empty($this->params['pass']['0'])){
			if($this->params['pass']['0'] == 'contact-us') {?>
				<?php echo $this->element('navigations/service_metrics');
			} else{
				echo $this->element('navigations/contact_us');
			}
		} else{
			echo $this->element('navigations/contact_us');
		}
	} else{
		echo $this->element('navigations/contact_us');
	}
} else{
	echo $this->element('navigations/contact_us');
}?>
</div>
<!--Right Widget Closed-->