<?php ?>
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
margin: 5px; /*margin around each panel*/
width:20%; /*Width of each panel holding each content. If removed, widths should be individually defined on each content DIV then. */
padding-left:15px;
padding-right:15px;
}
.sellr-slides{width:100%}

.stepcarousel .panel1{
/*leave this value alone*/
overflow: hidden; /*clip content that go outside dimensions of holding panel DIV*/
margin: 5px; /*margin around each panel*/
width:30%; /*Width of each panel holding each content. If removed, widths should be individually defined on each content DIV then. */
padding-left:15px;
padding-right:15px;
}

</style>
<script type="text/javascript">

stepcarousel.setup({
	galleryid: 'mygallery', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'panel', //class of panel DIVs each holding content
	autostep: {enable:false, moveby:1, pause:3000},
	panelbehavior: {speed:500, wraparound:false, wrapbehavior:'slide', persist:true},
	defaultbuttons: {enable: true, moveby: 3, leftnav: ['<?php echo SITE_URL;?>img/mobile/seller_lft_arrow.gif', 0, 60], rightnav: ['<?php echo SITE_URL;?>img/mobile/seller_rgt_arrow.gif', -20, 60]},
	statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline'] //content setting ['inline'] or ['ajax', 'path_to_external_file']
})


$(document).ready(function(){
//alert(window.orientation);

    var onChanged = function() {
            if(window.orientation == 90 || window.orientation == -90){
                var cla = 'panel';
            }else{
                var cla = 'panel1';
            }
     }
        $(window).bind(orientationEvent, onChanged).bind('load', onChanged);
       $('#panels').addClass(cla); //won't update image
   });



</script>



<!--Seller Banner Starts-->
<section class="bannerseller">
<h4>Best Sellers</h4>
<div id="mygallery" class="stepcarousel">

<div class="belt">
<ul class="sellr-slides">
<li id="panels" class="panel">
		<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
		<span class="prdctname">Day Nurse <br />Liquid</span>
		<span class="priceold">RRP: &pound;3.72</span>
		<span class="pricenow">NOW: &pound;3.09</span>
</li>

<li id="panels" class="panel">
		<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
		<span class="prdctname">Day Nurse0 <br />Liquid</span>
		<span class="priceold">RRP: &pound;3.72</span>
		<span class="pricenow">NOW: &pound;3.09</span>
</li>
<li id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse1 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>

<li id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse2 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
<li id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse3 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
<li id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse4 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
<li id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse5 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
<li  id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse6 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
<li  id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse7 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
<li id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse8 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
<li id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse9 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
<li id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse10 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
<li id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse11 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
<li id="panels" class="panel">
<span class="prdctimg"><img src="<?php echo SITE_URL;?>img/mobile/bst_sellr_slide_3.gif" alt="" /></span>
                   <span class="prdctname">Day Nurse12 <br />Liquid</span>
                   <span class="priceold">RRP: &pound;3.72</span>
                   <span class="pricenow">NOW: &pound;3.09</span>
</li>
</ul>
</div>

</div>
 </section>
          <!--Seller Banner End-->