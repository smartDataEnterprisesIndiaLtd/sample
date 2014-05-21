
  <?php
  echo $javascript->link(array('lib/prototype')); ?>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script>jQuery.noConflict();</script>
<?php
$countryID ='';
$countryID  =  $this->Session->read('countryID');

if(!empty($countryID) && $countryID !=''){
		$countryName  =  $this->Session->read('countryName');
		$countryImage = $this->Session->read('countryImage');
		}else{
		
		$countryName = 'United Kingdom';
		$countryImage = 'uk.png';
}
		?>

  <?php
  echo $this->element('country_slider');
  
  ?>

    <?php
    $user_session = $this->Session->read('User');
		$selectedM='';
		$selectedP='';
		$selectedB='';
		$selectedD='';
		$pagecontroler = $this->params['controller'];
		$pageaction     = $this->params['action'];
               
		//$controllerPerm = array('marketplaces','pages','blog');
		switch($pagecontroler){
			case 'marketplaces':
				$selectedM = 'selected';
				break;
			case 'pages':
				$selectedP = 'selected';
				break;
			case 'blogs':
				$selectedB = 'selected';
				break;
			default:
				$selectedD = 'selected';
				break;
		}
		
	?>
    <!--Top Bar Start-->
    <section class="topbar">
        <section class="toplinks_widget">
            	<ul class="toplinks">
                	<li><?php echo $html->link('<span>Choiceful</span>',"/",array('class'=>$selectedD,'escape'=>false));?></li>
                    <li><?php echo $html->link('<span>Sell</span>',"/marketplaces/view/how-it-works",array('class'=>$selectedM,'escape'=>false));?></li>
                    <li><?php echo $html->link('<span>Help</span>',"/pages/view/help",array('class'=>$selectedP,'escape'=>false));?></li>
                    <li><?php echo $html->link('<span>Blog</span>',"/blog",array('class'=>$selectedB,'escape'=>false));?></li>
                </ul>
            </section>
        
         <section class="headerright">
            	<ul class="topright_links">
                	<li class="my_choiceful"><div>
			
			<?php echo $html->link('My Choiceful','/orders/view_open_orders',array('escape'=>false));?>
			<?php if(!empty($user_session)){ ?>|
			<?php echo $html->link('Log out',array('controller'=>'users','action'=>'logout'),null);?>
			<?php } ?>
			<!--| <a href="#">Logout</a>-->
			
			</div></li>
                    <li class="livehelpC"><script  type="text/javascript"  src="<?php echo SITE_URL;?>/app/webroot/phplive/js/phplive.js.php?d=0&base_url=%2F%2Fchoiceful.com%2Fapp%2Fwebroot%2Fphplive&text=Live Help"></script></li>
                    <li class="country"><a href="#" id="countryDisplay">Store: <span id="dynamic_Coun"><?php echo $countryName;?></span></a></li>
                    <li class="cart" id="shopping_basket_id"><?php
					// include the mini basket for header 
					echo $this->element('basket/header_minibasket');
					?>
		    </li>
					<!--<a href="#">0 items - &pound;0.00</a>-->
                </ul>
            </section>
    </section>
    <!--Top Bar Closed-->

	<!--Header Start-->
	<header>
    
    	<!--Logo Start-->
    	<section class="logo"><?php echo $html->link('choiceful.com',"/blog",array('escape'=>false,'title'=>'Choiceful.com')); ?></section>
        <!--Logo Closed-->
       
    </header>
    <!--Header Closed-->
    <?php
             //starts bread crumb here
    if(isset($this->params['pass'][0]) && !empty($this->params['pass'][0])) { ?>
    <section class="breadcrumb">
        <ul>
            <li><?php echo $html->link('Choiceful',"/",array('escape'=>false,'title'=>'Choiceful.com')); ?></li>
    <!---<li><?php echo $html->link('Online Shopping',"/",array('escape'=>false,'title'=>'Choiceful.com')); ?></li>--->
    <li> <?php echo $html->link('Choiceful.com Blog',"/blog",array('escape'=>false,'title'=>'Choiceful.com Blog'));?> </li><li class="last"><span><?php // $breadcrm = str_replace("_"," ",$this->params['pass'][0]);
     echo ucwords($arctile_title);
     ?></span></li></section>
    <?php } else { ?>
    
    <section class="breadcrumb">
        <ul>
            <li><?php echo $html->link('Choiceful',"/",array('escape'=>false,'title'=>'Choiceful.com')); ?></li>
           <!--- <li> <?php echo $html->link('Online Shopping',"/",array('escape'=>false,'title'=>'Choiceful.com')); ?></li> ---><li class="last"><span>Choiceful.com Blog</span></li>
        </ul>
    </section>
    
    <?php } ?>
    <script>
  jQuery(document).ready(function() {
	
    jQuery('#upperCountry').css('margin-top','-68px');
	
    });
  </script>