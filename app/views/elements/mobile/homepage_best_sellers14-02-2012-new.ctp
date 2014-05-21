<style type="text/css" media="screen">

.infiniteCarousel {
  width: 85%;
}


.infiniteCarousel ul a img {
  border: 5px solid #000;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
}

.infiniteCarousel .wrapper ul {
  width: 9999px;
}

.infiniteCarousel ul li {
  display:block;
  float:left;
  padding: 10px 10px 10px 65px;
  width: 200px;
}

.infiniteCarousel ul li a img {
  display:block;
}

.infiniteCarousel .arrow {
  height: 36px;
  width: 37px;
  position: absolute;
  top: 207px;
  cursor: pointer;
}

.infiniteCarousel .forward {
  background-position: 0 0;
  right: 2%;
}

.infiniteCarousel .back {
  background-position: 0 -72px;
  left: 2%;
}

</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>


<script type="text/javascript">

$.fn.infiniteCarousel = function () {

    function repeat(str, num) {
        return new Array( num + 1 ).join( str );
    }
  
    return this.each(function () {
        var $wrapper = $('> div', this).css('overflow', 'hidden'),
            $slider = $wrapper.find('> ul'),
            $items = $slider.find('> li'),
            $single = $items.filter(':first'),
            
            singleWidth = $single.outerWidth(), 
            visible = Math.ceil($wrapper.innerWidth() / singleWidth), // note: doesn't include padding or border
            currentPage = 1,
            pages = Math.ceil($items.length / visible);            


        // 1. Pad so that 'visible' number will always be seen, otherwise create empty items
        if (($items.length % visible) != 0) {
            $slider.append(repeat('<li class="empty" />', visible - ($items.length % visible)));
            $items = $slider.find('> li');
        }

        // 2. Top and tail the list with 'visible' number of items, top has the last section, and tail has the first
        $items.filter(':first').before($items.slice(- visible).clone().addClass('cloned'));
        $items.filter(':last').after($items.slice(0, visible).clone().addClass('cloned'));
        $items = $slider.find('> li'); // reselect
        
        // 3. Set the left position to the first 'real' item
        $wrapper.scrollLeft(singleWidth * visible);
        
        // 4. paging function
        function gotoPage(page) {
            var dir = page < currentPage ? -1 : 1,
                n = Math.abs(currentPage - page),
                left = singleWidth * dir * visible * n;
            
            $wrapper.filter(':not(:animated)').animate({
                scrollLeft : '+=' + left
            }, 500, function () {
                if (page == 0) {
                    $wrapper.scrollLeft(singleWidth * visible * pages);
                    page = pages;
                } else if (page > pages) {
                    $wrapper.scrollLeft(singleWidth * visible);
                    // reset back to start position
                    page = 1;
                } 

                currentPage = page;
            });                
            
            return false;
        }
        
        $wrapper.after('<a class="arrow back"><img src="<?php echo SITE_URL;?>img/mobile/seller_lft_arrow.gif" alt="" /></a><a class="arrow forward"><img src="<?php echo SITE_URL;?>img/mobile/seller_rgt_arrow.gif" alt="" /></a>');
        
        // 5. Bind to the forward and back buttons
        $('a.back', this).click(function () {
            return gotoPage(currentPage - 1);                
        });
        
        $('a.forward', this).click(function () {
            return gotoPage(currentPage + 1);
        });
        
        // create a public interface to move to a specific page
        $(this).bind('goto', function (event, page) {
            gotoPage(page);
        });
    });  
};

$(document).ready(function () {
  $('.infiniteCarousel').infiniteCarousel();
});
</script>
<section class="bannerseller">
<h4>Best Sellers</h4>
<div id="mygallery" class="stepcarousel">
<div class="belt">
    
    <div class="infiniteCarousel">
      <div class="wrapper">
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

</div>
</div>
 </section>