
<?php
App::import('Model','Department');
$this->Department = &new Department;
$departments_list = $this->Department->find('list');
if(!isset($department_id)){
	$department_id = '';
}
if(!isset($sort)){
	$sort = "";
}
if(!isset($fhloc)){
	$fhloc = "";
}
if(!isset($ftitle)){
	$ftitle = "";
	$fvalue = "";	
}
?>


  <!--Search Start-->
            <section class="search_widget">
		<?php
	//Comented on 26 Apr on 2012 passing the keyword work on url.
	echo $form->create("product",array("action"=>"/searchresult/","method"=>"get", "id"=>"frmSearchproduct", "name"=>"frmSearchproduct")); ?>
            	<?php //echo $form->button('Search',array('type'=>'submit','class'=>'orange-btn', 'label'=>false,'div'=>false, 'escape'=>false) );
			$selected_department = '';  ?>
			<section id="ser_comm">
			<section id="sel_act" class="search_select"><input type="text" readonly class="selectlink" id="MarketplaceDepartment" name="data[Marketplace][department]" value="Choiceful.com"> <span class="selarrow"></span></section>
		<section class="search_section">
			<span id="whitSpa" class="srchtoparrow" style="display:none;"></span>
			<ul class="menulinks"  style="display:none; border :1px solid #D0D5CB;">
				<li class="sel" id="Choiceful_com"><a href="javascript:void('0')" onclick=fill("Choiceful.com");>Choiceful.com</a></li>
				<?php foreach($departments_list as $key=>$val){
					 $val1 =str_replace(' & ','-and-',$val); 
					?>
				<li id="<?php echo $val1; ?>"><a title="<?php echo $val; ?>" id="close_links" href="javascript:void('0')" onclick=fill("<?php echo $val1; ?>");><?php echo $val; ?></a></li>
			
				<?php } ?>
			</ul>
			<?php //echo $form->select('Marketplace.department',$departments_list,$selected_department,array('class'=>'','type'=>'select'),'Choiceful.com'); ?>
		</section>
		</section>
                <section class="searchbtn"><input type="submit" id="submit" name="button" class="orange-btn" value="Search" />
			
				<?php echo $form->hidden('Product.sort',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$sort));?>
				<?php echo $form->hidden('Product.fhloc',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$fhloc));?>
				<?php echo $form->hidden('Product.ftitle',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$ftitle));?>
				<?php echo $form->hidden('Product.fvalue',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$fvalue));?>
			
                     
                </section>
                <section class="searchinput">
                    <p class="srchinputpad"><?php echo $form->input('Marketplace.keywords',array('id'=>'search_keywords', 'value'=>@$searchWord, 'class'=>'textfield', 'style'=>'width:100%', 'label'=>false,'div'=>false, 'escape'=>false,'maxlength'=>1000));?>
</p>
                </section>
		<?php  echo $form->end(); ?>
            </section>        
            <!--Search Closed-->
<script>
	function fill(dep){
		
		n=dep.replace("-and-"," & ");
		dep=dep.replace(".","_");
		if(dep !='Choiceful_com'){
			jQuery("#whitSpa").removeClass('srchtoparrow');
			jQuery("#whitSpa").addClass('sel_white');
		}else{
			jQuery("#whitSpa").removeClass('sel_white');
			jQuery("#whitSpa").addClass('srchtoparrow');
		}
		jQuery('#MarketplaceDepartment').val(n);
		jQuery('.menulinks').slideUp();
		jQuery('.sel_white').hide();
		jQuery('.srchtoparrow').hide();
		jQuery(".search_select").removeClass("active");
		jQuery(".menulinks li").removeClass('sel');
		
		jQuery('#'+dep).addClass('sel');
		
		
	}
	function idPass(id){
		
	//jQuery("#department_"+id).mouseover(function(){
			jQuery("#haederCatIdUl_"+id).css('visibility','visible');
			//jQuery(this).toggleClass("active");
			return false;
		// });
	
	}
	function idleave(id){
		
	//jQuery("#department_"+id).mouseover(function(){
			jQuery("#haederCatIdUl_"+id).css('visibility','hidden');
			//jQuery(this).toggleClass("active");
			return false;
		// });
	
	}
	
	jQuery(document).ready(function()  {
		
		jQuery(".toplist").click(function(){
			jQuery(".search_select").removeClass("active");
			jQuery('.menulinks').hide();
			jQuery('.srchtoparrow').hide();
			jQuery('.sel_white').hide();
			return false;
		 });
		
		 jQuery("#ser_comm").mouseover(function(){
			
			jQuery(".menulinks").show();
			jQuery('.srchtoparrow').show();
			jQuery('.sel_white').show();

			jQuery('#sel_act').addClass("active");
			
			
			return false;
		 });
		  jQuery("#ser_comm").mouseout(function(){
			
			jQuery(".menulinks").hide();
			jQuery('.srchtoparrow').hide();
			jQuery('.sel_white').hide();
			
			jQuery('#sel_act').removeClass("active");
			
			
			return false;
		 });
		 
		 jQuery("#close_links1").click(function(){
			jQuery("#sel_act").slideToggle(500);
			
			return false;
		 });
	});
</script>
<?php if($this->params['action'] != 'return_items' && $this->params['controller'] != 'orders') { ?>
<script type="text/javascript">
jQuery(document).ready( function(){
	document.getElementById('search_keywords').focus();
	 
} );

jQuery("#frmSearchproduct").submit(function() {
var search_keywords = jQuery('#search_keywords').val();
var search_keywords = search_keywords.replace(/[^A-Za-z0-9\-\s]/g, "");
var department_id = jQuery('#MarketplaceDepartment').val();
var product_sort = jQuery('#ProductSort').val();

var url_fh = jQuery('#ProductFhloc').val();
var ftitle = jQuery('#ProductFtitle').val();
var fvalue = jQuery('#ProductFvalue').val();


var urls= "<?php echo SITE_URL;?>products/searchresult/";
	if((search_keywords != "")){
		urls= urls = urls+'keywords:'+search_keywords+'?q='+search_keywords;
		
	/*if((department_id != "")){
		urls = urls+"/dept_id:"+department_id;
	}*/

	if((product_sort != "")){
		urls = urls+"/sort_by:"+product_sort+'?q='+search_keywords;
	}
	if((url_fh != "")){
			urls = urls+"/fh_loc:"+url_fh;
		}
	if((ftitle != "")){
		urls = urls+"/ftitle:"+ftitle;
	}
	if((fvalue != "")){
		urls = urls+"/fvalue:"+fvalue.replace("<","%3C");
	}
	}
	window.location.href = urls;
	return false;
});


</script>

<?php }?>

