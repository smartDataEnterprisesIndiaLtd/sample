<?php
App::import('Model','Department');
$this->Department = &new Department;
$departments_list = $this->Department->find('list');
if(!isset($department_id)){
	$department_id = '';
}
?>
<!--Right Content Start-->
<!--Search Starts-->
         <section class="topsearch">
         <?php echo $form->create("product",array("action"=>"/searchresult/","method"=>"get", "id"=>"frmSearchproduct", "name"=>"frmSearchproduct")); ?>
           <input type="submit" name="button" class="topsrchbtn" value="Submit" />
           <div class="overflow-h">
		 <?php
	   if(isset($this->params['named']['keywords']) && !empty($this->params['named']['keywords'])){
		$searchContent = $this->params['named']['keywords'];
	   }else{
		$searchContent = '';
	   }
	   ?>
	    <?php echo $form->input('Marketplace.keywords',array('class' => 'arialFont', 'id'=>'search_keywords', 'value' => $searchContent , 'placeholder' => 'Search Choiceful' , 'onclick' => "if (this.placeholder==this.placeholder) this.placeholder=''", 'onblur' => "if (this.placeholder=='') this.placeholder='Search Choiceful'", 'label'=>false,'div'=>false, 'escape'=>false));?>
           <?php //echo $form->input('Marketplace.keywords',array('id'=>'search_keywords', 'value'=>'Search Choiceful' , 'onfocus'=>'clearText(this)', 'onblur'=>'clearText(this)', 'label'=>false,'div'=>false, 'escape'=>false));?>
            </div>
           <?php  echo $form->end(); ?>
         </section>
          <!--Search End-->
<?php if($this->params['action'] != 'return_items' && $this->params['controller'] != 'orders') { ?>
<script type="text/javascript">
// jQuery(document).ready( function(){
// 	document.getElementById('search_keywords').focus();
// 		
// } );
</script>
<?php }?>
<!--BreadCrumb Starts-->
             <section class="breadcrumb">
                <ul class="brdcrmblist">
                  <li><?php echo $html->link('Home',SITE_URL,array('escape'=>false,'class'=>'myunderline'));?></li>
                  <li><?php echo $html->link('My Account',array('controller'=>'orders','action'=>'view_open_orders'), array('escape'=>false,'class'=>'myunderline'));?></li>
                  <li><?php echo $html->link('Help',array('controller'=>'pages','action'=>'view','help'),array('escape'=>false,'class'=>'myunderline'));?>
                  </li>
                </ul>
             </section>
<!--BreadCrumb End-->