<?php

App::import('Model','Category');
$Category = & new Category();
		
		

?>
<div class="mid-content pad-rt-none">

            
            <!--Highlights Start-->
           <h1 class="heading small-font-head">All Categories</h1>
           <!--Highlights Closed-->
           
           <!--Links Start-->
           <div class="row">
           		
                <!--Column1 Start-->
                <div class="column-links">
                	<?php
			//pr($departments); ?>
                    <!--Books Start-->
                    <div class="row">
                        <h4 class="choiceful"><?php  echo $departments[1];?></h4>
			<?php
			$CatArrayBooks = $Category->getTopCategory(1);
			($CatArrayBooks);
			?>
                        <ul>
			<?php
			if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
				foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
				<li>
				<?php	
				$dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[1], ENT_NOQUOTES, 'UTF-8'));
				
				$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
				</li>
				<?php  } ?>
			<?php }?>
                        </ul>
                    </div>
                    <!--Books Closed-->
                                    	 	
                </div>
                <!--Column1 Closed-->
                
                <!--Column2 Start-->
                <div class="column-links">
                	
                    <!--Computers & Office Start-->
                    <div class="row">
                        <h4 class="choiceful"><?php  echo $departments[3];?></h4>
			<?php
			$CatArrayBooks = $Category->getTopCategory(3);
			($CatArrayBooks);
			?>
                        <ul>
			<?php
			if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
				foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
				<li>
				<?php	
					$dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[3], ENT_NOQUOTES, 'UTF-8'));
					$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
				</li>
				<?php  } ?>
			<?php }?>
                        </ul>
                    </div>
                    <!--Computers & Office Closed-->
                    
                </div>
                <!--Column2 Closed-->
                
                <!--Column3 Start-->
                <div class="column-links">
                	
                    <!--Movies Start-->
                   <div class="row">
                        <h4 class="choiceful"><?php  echo $departments[2];?></h4>
			<?php
			$CatArrayBooks = $Category->getTopCategory(2);
			($CatArrayBooks);
			?>
                        <ul>
			<?php
			if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
				foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
				<li>
				<?php	
				$dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[2], ENT_NOQUOTES, 'UTF-8'));
				$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), 	html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
				</li>
				<?php  } ?>
			<?php }?>
                        </ul>
                    </div>
                    <!--Movies Closed-->
		    
		     <!--Movies Start-->
                   <div class="row">
                        <h4 class="choiceful"><?php  echo $departments[4];?></h4>
			<?php
			$CatArrayBooks = $Category->getTopCategory(4);
			($CatArrayBooks);
			?>
                        <ul>
			<?php
			if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
				foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
				<li>
				<?php
					$dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[4], ENT_NOQUOTES, 'UTF-8'));
					$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
				</li>
				<?php  } ?>
			<?php }?>
                        </ul>
                    </div>
                    <!--Movies Closed-->
		       <!--Movies Start-->
                   <div class="row">
                        <h4 class="choiceful"><?php  echo $departments[5];?></h4>
			<?php
			$CatArrayBooks = $Category->getTopCategory(5);
			($CatArrayBooks);
			?>
                        <ul>
			<?php
			if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
				foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
				<li>
				<?php
					$dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[5], ENT_NOQUOTES, 'UTF-8'));
					$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
				</li>
				<?php  } ?>
			<?php }?>
                        </ul>
                    </div>
                    <!--Movies Closed-->
		    
                    
                </div>
                <!--Column3 Closed-->
                
                <!--Column4 Start-->
                <div class="column-links">
                	
                    <!--Home & Beauty Start-->
                    <div class="row">
                        <h4 class="choiceful"><?php  echo $departments[6];?></h4>
			<?php
			$CatArrayBooks = $Category->getTopCategory(6);
			($CatArrayBooks);
			?>
                        <ul>
			<?php
			if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
				foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
				<li>
				<?php	
					$dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[6], ENT_NOQUOTES, 'UTF-8'));
					$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
					
					echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
				</li>
				<?php  } ?>
			<?php }?>
                        </ul>
                    </div>
                    <!--Home & Beauty Closed-->
		    <div class="row">
                        <h4 class="choiceful"><?php  echo $departments[7];?></h4>
			<?php
			$CatArrayBooks = $Category->getTopCategory(7);
			($CatArrayBooks);
			?>
                        <ul>
			<?php
			if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
				foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
				<li>
				<?php	
					$dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[7], ENT_NOQUOTES, 'UTF-8'));
					$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
				</li>
				<?php  } ?>
			<?php }?>
                        </ul>
                    </div>
		    
		    <div class="row">
                        <h4 class="choiceful"><?php  echo $departments[9];?></h4>
			<?php
			$CatArrayBooks = $Category->getTopCategory(9);
			($CatArrayBooks);
			?>
                        <ul>
			<?php
			if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
				foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
				<li>
				<?php	
					$dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[9], ENT_NOQUOTES, 'UTF-8'));
					$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
				</li>
				<?php  } ?>
			<?php }?>
                        </ul>
                    </div>
                                    	 	
                </div>
                <!--Column4 Closed-->
                
                <!--Column5 Start-->
                <div class="column-links">
                	
                    <!--Electronics Start-->
                    
                    <!--Electronics Closed-->
                    
                    <!--Mobile Start-->
                   <div class="row">
                        <h4 class="choiceful"><?php  echo $departments[8];?></h4>
			<?php
			$CatArrayBooks = $Category->getTopCategory(8);
			($CatArrayBooks);
			?>
                        <ul>
			<?php
			if(isset($CatArrayBooks)  &&  is_array($CatArrayBooks)  ){
				foreach($CatArrayBooks as $cat_id=>$cat_name){ ?>
				<li>
				<?php	
					$dept_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($departments[8], ENT_NOQUOTES, 'UTF-8'));
					$cat_atoz=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($cat_name, ENT_NOQUOTES, 'UTF-8'));
					echo $html->link('<span>'.$cat_name.' </span>',"/".$dept_atoz."/".$cat_atoz."/categories/index/".$cat_id ,array('escape'=>false));?>
				</li>
				<?php  } ?>
			<?php }?>
                        </ul>
                    </div>
                    <!--Mobile Closed-->
                                    	 	
                </div>
                <!--Column5 Closed-->
                
                <div class="clear"/>
                
           </div>
           <!--Links Closed-->
           
           
        </div>             <!--Column5 Closed-->
                
                <div class="clear"/>
                
           </div>
           <!--Links Closed-->
           
           
        </div>