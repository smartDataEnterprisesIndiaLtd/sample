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
<!--Right Content Start-->
<!--Search Starts-->
         <section class="topsearch">
         <?php echo $form->create("product",array("action"=>"/searchresult/","method"=>"get", "id"=>"frmSearchproduct", "name"=>"frmSearchproduct")); ?>
           <input type="submit" name="button" class="topsrchbtn" value="Submit" />
           <div class="overflow-h">
		<?php echo $form->hidden('Product.fhloc',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$fhloc));?>
		<?php echo $form->hidden('Product.ftitle',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$department_id));?>
		<?php echo $form->hidden('Product.fvalue',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$fvalue));?>
		<?php echo $form->hidden('Marketplace.department',array('class'=>'textfield','style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$fvalue));?>
		<?php //echo $form->input('Marketplace.keywords',array('id'=>'search_keywords', 'value'=>@$searchWord, 'class'=>'textfield', 'style'=>'width:78%', 'label'=>false,'div'=>false, 'escape'=>false));?>
           <?php //echo $form->input('Marketplace.keywords',array('class' => 'arialFont', 'id'=>'search_keywords', 'value'=>'Search Choiceful' , 'onfocus'=>'clearText(this)', 'onblur'=>'clearText(this)', 'label'=>false,'div'=>false, 'escape'=>false));?>
	   <?php
	   if(isset($this->params['named']['keywords']) && !empty($this->params['named']['keywords'])){
		$searchContent = $this->params['named']['keywords'];
	   }else{
		$searchContent = '';
	   }
	   ?>
	    <?php echo $form->input('Marketplace.keywords',array('class' => 'arialFont', 'id'=>'search_keywords', 'value' => $searchContent , 'placeholder' => 'Search Choiceful' , 'onclick' => "if (this.placeholder==this.placeholder) this.placeholder=''", 'onblur' => "if (this.placeholder=='') this.placeholder='Search Choiceful'", 'label'=>false,'div'=>false, 'escape'=>false));?>
	    
            </div>
           <?php  echo $form->end(); ?>
         </section>
          <!--Search End-->
	  
	  
<?php if($this->params['action'] != 'return_items' && $this->params['controller'] != 'orders') { ?>
<script type="text/javascript">
jQuery(document).ready( function(){
	document.getElementById('search_keywords').focus();
	 
} );

jQuery("#frmSearchproduct").submit(function() {
var search_keywords = jQuery('#search_keywords').val();
var department_id = jQuery('#MarketplaceDepartment').val();
var product_sort = jQuery('#ProductSort').val();

var url_fh = jQuery('#ProductFhloc').val();
var ftitle = jQuery('#ProductFtitle').val();
var fvalue = jQuery('#ProductFvalue').val();


var urls= "<?php echo SITE_URL;?>products/searchresult/";
	if((search_keywords != "")){
		urls= urls = urls+'keywords:'+search_keywords;
	if((department_id != "")){
		urls = urls+"/dept_id:"+department_id;
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
<!--BreadCrumb Starts-->
             <section class="breadcrumb prdctbrdcrmb">
                <ul class="brdcrmblist">
                  <li><?php echo $html->link('Home',SITE_URL,array('escape'=>false));?></li>
                  <li><?php echo $html->link('My Account',array('controller'=>'orders','action'=>'view_open_orders'), array('escape'=>false));?></li>
                  <li><?php echo $html->link('Help',array('controller'=>'pages','action'=>'view','help'),array('escape'=>false));?></li>
                </ul>
             </section>
<!--BreadCrumb End-->
