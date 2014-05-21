<style type="text/css">
.stepcarousel{
position: relative; /*leave this value alone*/
overflow: scroll; /*leave this value alone*/
width: 100%; /*Width of Carousel Viewer itself*/
height: 125px; /*Height should enough to fit largest content's height*/

}
.stepcarousel .belt{
position: absolute; /*leave this value alone*/
left: 0;
top: 0;
}
.stepcarousel .panel{
/*leave this value alone*/
overflow: hidden; /*clip content that go outside dimensions of holding panel DIV*/
margin: 10px; /*margin around each panel*/
width: 195px; /*Width of each panel holding each content. If removed, widths should be individually defined on each content DIV then. */
padding-left:110px;
}

</style>
<script type="text/javascript">

stepcarousel.setup({
	galleryid: 'mygallery', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'panel', //class of panel DIVs each holding content
	autostep: {enable:false, moveby:1, pause:3000},
	panelbehavior: {speed:500, wraparound:false, wrapbehavior:'slide', persist:true},
	defaultbuttons: {enable: true, moveby: 1, leftnav: ['<?php echo SITE_URL;?>img/mobile/seller_lft_arrow.gif', -5, 80], rightnav: ['<?php echo SITE_URL;?>img/mobile/seller_rgt_arrow.gif', -20, 80]},
	statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline'] //content setting ['inline'] or ['ajax', 'path_to_external_file']
})
</script>
<!--Seller Banner Starts-->
<section class="bannerseller">
<h4>Best Sellers</h4>
<div id="mygallery" class="stepcarousel">
<div class="belt">

<ul class="sellr-slides">
<li  class="panel">
		<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
		<span class="prdctname">Day Nurse <br />Liquid</span>
		<span class="priceold">RRP: &pound;3.72</span>
		<span class="pricenow">NOW: &pound;3.09</span>
</li>

<li  class="panel">
		<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
		<span class="prdctname">Day Nurse <br />Liquid</span>
		<span class="priceold">RRP: &pound;3.72</span>
		<span class="pricenow">NOW: &pound;3.09</span>
</li><li  class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li><li  class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li><li  class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li><li  class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
</ul>


</div>
</div>
 </section>
          <!--Seller Banner End-->