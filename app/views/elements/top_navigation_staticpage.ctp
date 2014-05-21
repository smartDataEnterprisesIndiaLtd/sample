
<li><?php echo $html->link('Choiceful', '/', array('alt'=>'') );?> </li>
<?php 
    $style = "style='background:none;'";
    $lastElement =''
?> 
		<li><?php echo $html->link('Online Shopping',"/homes",array('escape'=>false ));?> </li>
                <?php if(!empty($this->data['Page']['title']) && $this->data['Page']['pagecode']!="help"){
                          $lastElement =  strip_tags($this->data['Page']['title']);
                            $style="";
                        }
                
                ?>
                
                <li <?php echo $style; ?>><?php echo $html->link('Help',"/pages/view/help",array('escape'=>false,'class'=>'active'));?> </li>
             <?php if(!empty($lastElement)){ ?>
		<li class="last"><span class="choiceful"><?php echo ucwords($lastElement); ?></strong></li>
             <?php } ?>
