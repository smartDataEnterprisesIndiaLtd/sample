<!--<div style="height:250px;width:250px; overflow-y: scroll; ">-->
<?php

if(isset($selectedcats) && !empty($selectedcats)) {
	        $link_seperator = " > " ;
		$strLink = '';
		foreach ($selectedcats as $finalArr){
			
			$totalCount = count($finalArr);
			
			if( is_array($finalArr) ){
				$j = 0;
				$strLink .= $departmentname.$link_seperator;
				foreach($finalArr as $key=>$value){
										
					$j++;
					
					if($j == $totalCount){
						
						$strLink .= '<span class="lastcat">'.$value.'</span>';	
					}else{
						
					$strLink .= $value;
					$strLink .= $link_seperator;
					}
				}
			}
		$strLink .= '<br/><br/>';
		
		}
		
		echo $strLink;
		
		
	}
	?>


<!--</div>-->

