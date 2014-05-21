<?php echo $javascript->link(array('caroul/jquery.carouFredSel-6.2.1-packed')); ?>
<?php echo $javascript->link(array('caroul/helper-plugins/jquery.mousewheel.min')); ?>
<?php echo $javascript->link(array('caroul/helper-plugins/jquery.touchSwipe.min')); ?>
<?php
$countryID ='';
$countryID  =  $this->Session->read('countryID');

if(!empty($countryID) && $countryID !=''){
		$countryName  =  $this->Session->read('countryName');
		$countryImage = $this->Session->read('countryImage');
		?>
		<style>
				
				/*#upperCountry{
						margin: 0 !important;
						visibility: visible !important;
				}
				*/
		</style>
		<script>
		jQuery(document).ready(function() {
				var country = '<?php echo $countryName;?>';
				//jQuery("#upperCountry").addClass('new_Slider');
				//jQuery("#countryDisplay").addClass('active');
				jQuery("#dynamic_Coun").text(country);
				
		});
		
		
		</script>
		
		<?php
		
		
}else{
		
		$countryName = 'United Kingdom';
		$countryImage = 'uk.png';
}
?>
<section class="countries" style="display:none; " >
		
        	
		

            <a href="javascript:void('0')" id="foo2_next" class="next">Next</a>
	    <a href="#" id="foo2_prev12" class="prev prevab">Previous</a>
	    <a class="pre_ctive"><?php echo $html->image("/img/new/images/flags/$countryImage" ,array('alt'=>"" )); ?><span class="valign"><?php echo $countryName;?></span></a>
            <div class="country-scroll list_carousel">
                <ul class="countries_list" id="foo2">
				<!-- ,"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')",  -->
				<?php
				$countryDetail =array();
				
				$countryDetail = array('1'=>array('name'=>'Australia','img'=>'australia.png'),
							     '2'=>array('name'=>'Argentina','img'=>'argentina.png'),
							     '3'=>array('name'=>'Austria','img'=>'austria.png'),
							     '4'=>array('name'=>'Bahrain','img'=>'bahrain.png'),
							     '5'=>array('name'=>'Brazil','img'=>'brazil.png'),
							     '6'=>array('name'=>'Canada','img'=>'canada.png'),
							     '7'=>array('name'=>'China','img'=>'china.png'),
							     '8'=>array('name'=>'Colombia','img'=>'colombia.png'),
							     '9'=>array('name'=>'Czech Republic','img'=>'czech_republic.png'),
							     '10'=>array('name'=>'Denmark','img'=>'denmark.png'),
							     '11'=>array('name'=>'Egypt','img'=>'egypt.png'),
							     '12'=>array('name'=>'Finland','img'=>'finland.png'),
							     '13'=>array('name'=>'France','img'=>'france.png'),
							     '14'=>array('name'=>'Germany','img'=>'germany.png'),
							     '15'=>array('name'=>'Hong Kong','img'=>'hongkong.png'),
							     '16'=>array('name'=>'India','img'=>'india.png'),
							     '17'=>array('name'=>'Indonesia','img'=>'indonesia.png'),
							     '18'=>array('name'=>'Iran','img'=>'iran.png'),
							     '19'=>array('name'=>'Ireland','img'=>'ireland.png'),
							     '20'=>array('name'=>'Israel','img'=>'israel.png'),
							     '21'=>array('name'=>'Italy','img'=>'italy.png'),
							     '22'=>array('name'=>'Japan','img'=>'japan.png'),
							     '23'=>array('name'=>'Jordan','img'=>'jordan.png'),
							     '24'=>array('name'=>'Kuwait','img'=>'kuwait.png'),
							     '25'=>array('name'=>'Luxembourg','img'=>'luxembourg.png'),
							     '26'=>array('name'=>'Malaysia','img'=>'malaysia.png'),
							     '27'=>array('name'=>'Malta','img'=>'malta.png'),
							     '28'=>array('name'=>'Mexico','img'=>'mexico.png'),
							     '29'=>array('name'=>'Morocco','img'=>'morocco.png'),
							     '30'=>array('name'=>'Netherlands','img'=>'netherlands.png'),
							     '31'=>array('name'=>'New Zealand','img'=>'new_zealand.png'),
							     '32'=>array('name'=>'Norway','img'=>'norway.png'),
							     '33'=>array('name'=>'Pakistan','img'=>'pakistan.png'),
							     '34'=>array('name'=>'Philippines','img'=>'philippines.png'),
							     '35'=>array('name'=>'Poland','img'=>'poland.png'),
							     '36'=>array('name'=>'Qatar','img'=>'qatar.png'),
							     '37'=>array('name'=>'Russia','img'=>'russia.png'),
							     '38'=>array('name'=>'Saudia Arabia','img'=>'saudi_arabia.png'),
							     '39'=>array('name'=>'South Africa','img'=>'south_africa.png'),
							     '40'=>array('name'=>'South Korea','img'=>'south_korea.png'),
							     '41'=>array('name'=>'Spain','img'=>'spain.png'),
							     '42'=>array('name'=>'Sri Lanka','img'=>'srilanka.png'),
							     '43'=>array('name'=>'Sweden','img'=>'sweden.png'),
							     '44'=>array('name'=>'Switzerland','img'=>'switzerland.png'),
							     '45'=>array('name'=>'Taiwan','img'=>'taiwan.png'),
							     '46'=>array('name'=>'Thailand','img'=>'thailand.png'),
							     '47'=>array('name'=>'Turkey','img'=>'turkey.png'),
							     '48'=>array('name'=>'United Kingdom','img'=>'uk.png'),
							     '49'=>array('name'=>'Ukraine','img'=>'ukraine.png'),
							     '50'=>array('name'=>'United Arab Emirates','img'=>'uae.png'),'51'=>array('name'=>'United Arab Emirates','img'=>'uae.png'));
				foreach($countryDetail as $k=>$val){
						$img= $val['img'];
						$name = $val['name'];
						if($k ==48){
				?>
	

		<li id="country_<?php echo $k; ?>"><?php echo $ajax->link($html->image("/img/new/images/flags/$img" ,array('alt'=>"" ))."<span class='valign'>$name</span>",'javascript::void(0)', array('update' => "country_2$k",'url' => "/homes/setcountry/$k/$img/$name","complete"=>"window.location.reload();",'escape'=>false), null,false);?></li>
		<?php } else {?>
				<li id="country_<?php echo $k; ?>"><?php echo $html->link($html->image("/img/new/images/flags/$img" ,array('alt'=>"" ))."<span class='valign'>$name</span>",'javascript::void(0)', array('update' => "country_2$k",'url' => "javascript:void('0')",'escape'=>false), null,false);?></li>

		
		<?php }?>
		
		<?php } //foreach end  ?>
		
	   </ul>
		<!-- <div id="pager2" class="pager"></div> --->
            </div>
	    <!--<li id='country_2'><?php echo $ajax->link($html->image("/img/new/images/flags/argentina.png" ,array('alt'=>"" ))."<span class='valign'>Argentina</span>",'javascript::void(0)', array('update' => 'country_21', 'url' => '/homes/setcountry/2/argentina.png/Argentina',"complete"=>"window.location.reload();",'escape'=>false), null,false);?></li>
		
                <li id='country_3'><?php echo $ajax->link($html->image("/img/new/images/flags/austria.png" ,array('alt'=>"" ))."<span class='valign'>Austria</span>",'javascript::void(0)', array('update' => 'country_31', 'url' => '/homes/setcountry/3/austria.png/Austria',"complete"=>"window.location.reload();",'escape'=>false), null,false);?></li>
		
		<li id='country_4'><?php echo $ajax->link($html->image("/img/new/images/flags/bahrain.png" ,array('alt'=>"" ))."<span class='valign'>Bahrain</span>",'javascript::void(0)', array('url' => '/homes/setcountry/4/bahrain.png/Bahrain',"complete"=>"window.location.reload();",'escape'=>false), null,false);?></li>-->
		
</section>
<script>
	
jQuery(document).ready(function() {
		jQuery("#country_2").click(function(){
				var selct = jQuery(this).html();
				var preSelct = jQuery('.pre_ctive').html();
		
		});
		

	jQuery("#countryDisplay").click(function(){
            var ee = '300';
            
            if(!jQuery("#upperCountry").hasClass('new_Slider')){
                if(jQuery("#upperCountry").is(':visible')){
                        ee ='fast';
                        jQuery('#upperCountry').css('display','hidden');
                }
            }
          
            jQuery("#upperCountry").slideToggle(ee,function() {
                jQuery('#upperCountry').css({'visibility':'visible','margin-top':'0px'});
                
                if(!jQuery("#upperCountry").hasClass('new_Slider')){
                        if(!jQuery("#upperCountry").is(':visible'))
                        {
                                jQuery('#upperCountry').css('display','none');
                        }
                }
                
                if(!jQuery("#countryDisplay").hasClass('active')){
                        if(jQuery("#upperCountry").is(':visible')) {
                            jQuery("#countryDisplay").addClass('active');
                        }
                }
                
                if(jQuery("#countryDisplay").hasClass('active')){
                    if(!jQuery("#upperCountry").is(':visible')){
                        jQuery("#countryDisplay").removeClass('active');
                    }
                }
                
                
                jQuery("#upperCountry").addClass('new_Slider');
               
                    // Animation complete.
            });
			return false;
	});
        
	jQuery("#content-NEW").click(function(){
		if(jQuery("#upperCountry").hasClass('new_Slider')){
				if(jQuery("#upperCountry").is(':visible')){
					
					jQuery('#upperCountry').css({'display':''});
					jQuery('#upperCountry').css({'visibility':'hidden','margin-top':'-68px'});
						jQuery("#countryDisplay").removeClass('active');
						jQuery("#upperCountry").removeClass('new_Slider');
				}
                }
		
		
          
           /* jQuery("#upperCountry").slideToggle(ee,function() {
                jQuery('#upperCountry').css({'visibility':'visible','margin-top':'0px'});
                
                if(!jQuery("#upperCountry").hasClass('new_Slider')){
                        if(!jQuery("#upperCountry").is(':visible'))
                        {
                                jQuery('#upperCountry').css('display','block');
                        }
                }
                
                if(!jQuery("#countryDisplay").hasClass('active')){
                        if(jQuery("#upperCountry").is(':visible')) {
                            jQuery("#countryDisplay").addClass('active');
                        }
                }
                
                if(jQuery("#countryDisplay").hasClass('active')){
                    if(!jQuery("#upperCountry").is(':visible')){
                        jQuery("#countryDisplay").removeClass('active');
                    }
                }
                
                
                jQuery("#upperCountry").addClass('new_Slider');
               
                    // Animation complete.
            });*/
			
	});
	
	
        jQuery('#foo2').carouFredSel({
		auto: false,
                circular: false,
                infinite: false,
		
	    next    : {
	        button  : "#foo2_next",
	        key     : "right",
		items    : 5
	    },
	    prev    : {
		 key     : "left",
		items    : 5,
	        button  : "#foo2_prev12"
	    }
		/*prev: '#prev2',
		next: '#next2',*/
		/*pagination: "#pager2",*/
		/*mousewheel: true,
		swipe: {
			onMouse: true,
			onTouch: true
		}*/
		
	});
	
	
	
	jQuery("#foo2_prev12").click(function() {
		jQuery("#foo2").trigger("prev", 5);
	});
    });

</script>
<?php 
if(!empty($countryID)){
		//$countryName  =  $this->Session->read('countryName');
		//$countryImage = $this->Session->read('countryImage');
		?>
		<style>
				#country_<?php echo $countryID ?>{
						visibility: hidden;
						width: 0px;
				}
		</style>
		<?php } ?>