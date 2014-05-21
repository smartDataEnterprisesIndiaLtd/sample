
  <?php
  echo $javascript->link(array('lib/prototype')); ?>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script>jQuery.noConflict();</script><!--Header Start-->
<?php
/*$allblogsid = array();
foreach ($blogs as $blog){
$allblogsid[] = $blog['Blog']['slug'];
}

if(count($allblogsid) <3 ) {
$test = array_rand($allblogsid,2);
}

else {
$test = array_rand($allblogsid,5);
}



$result = array();
foreach( $test as $k ) {
  $result[] = $allblogsid[$k];
}*/

?>
	<header>
	  
    
    	<!--Logo Start-->
    	<section class="logo">
		<?php echo $html->link('choiceful.com',"/blog",array('escape'=>false,'title'=>'Choiceful.com')); ?>
		</section>
        <!--Logo Closed-->
        
        <nav>
        	<ul class="menu">
            	<li><?php echo $html->link("<span>About</span>",array("controller"=>"pages","action"=>"view/about-choiceful"),array('escape'=>false,'title'=>'About'));?></li>
                <li><?php echo $html->link("<span>Buy</span>",'/',array('escape'=>false,'title'=>'Buy'));?></li>
                <li><?php echo $html->link("<span>Sell</span>",array("controller"=>"marketplaces","action"=>"view/how-it-works"),array('escape'=>false,'title'=>'Sell'));?>
		</li>
                <li><?php echo $html->link("<span>Mobile</span>",array("controller"=>"homes","action"=>"choiceful-mobile"),array('escape'=>false,'title'=>'Mobile'));?>
		</li>
                <li><?php echo $html->link("<span>Random</span>",array("controller"=>"blogs","action"=>"blogdetails",$randomblog['Blog']['slug']),array('escape'=>false,'title'=>'Random'));?></li>
                <li class="last">
		<?php echo $html->link("<span>Help</span>",array("controller"=>"pages","action"=>"view/help"),array('escape'=>false,'title'=>'Help'));?>
		</li>
            </ul>
        </nav>
        
        <section class="slogan">Love Choice, Love Choiceful</section>
        
    </header>
    <!--Header Closed-->