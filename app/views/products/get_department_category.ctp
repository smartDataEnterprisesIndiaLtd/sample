<?php
function getChildCategories($parent_id){
	App::import('Model', 'Category');
	$Category = & new Category();
	$conditions = array('Category.parent_id ='.$parent_id);
	$child_cat_array = $Category->find('list', array('conditions'=>  $conditions,
		'fields'=>array('Category.id', 'Category.cat_name'),
		'order' => 'Category.parent_id ASC'
	) );
	return $child_cat_array;
}

function checkSelectedCategory($cate_id = null,$categories_array){
	$checked_cat = '';
	if(!empty($categories_array)){
		if(in_array($cate_id,$categories_array)){
			$checked_cat = "checked = true";
		} else{
			$checked_cat ='';
		}
	}
	return $checked_cat;
}
$checkbox = false;
if(!empty($dep_category_array)) {?>

<div style="background:#D6CEC6;padding:10px 0px 10px 10px">
<div style="height:250px;overflow-y: scroll; ">
<table cellspacing="5" cellpadding="1" border="0" width="98%"  align="left" >
<?php
set_time_limit(0);
//pr($departments);
//foreach($departments as $dep_id =>$dep_name){
	//echo '<tr><td align="left" style="background:#FFFFFF;" >'.$dep_name.'</td></tr>';
	
	//$dep_category_array = $common->getDepartmentCategories($dep_id);
	
	if(count($dep_category_array) > 0 ){  
		foreach($dep_category_array as $cat_id_0 => $cat_name_0){
			
		echo '<tr><td class="note_" align="left" >';
		echo "<b>";echo ucwords($cat_name_0); echo "&nbsp; &raquo;</b> <br />";
		$cat_array_1 = getChildCategories($cat_id_0);
		//echo count($cat_array);
		if(count($cat_array_1) > 0 ){ 
			echo '<div style="padding: 5px 0px 5px 10px;" id='.$cat_id_0.'>';
			//////////////////////////////////////// 1st level ////////////////////////////////////////
			$j = 0;
			foreach($cat_array_1 as $cat_id_1 => $cat_name_1){
				$cat_array_2 = getChildCategories($cat_id_1);
				//echo count($cat_array);
				if(count($cat_array_2) > 0 ){
					echo "<br><b>";echo ucwords($cat_name_1); echo "&nbsp; &raquo;</b>";
					echo '<div style="padding-left:20px;min-height:2px;">';
				//////////////////////////////////////// 2nd level ////////////////////////////////////////	
					$k = 0;
					foreach($cat_array_2 as $cat_id_2 => $cat_name_2){
						$cat_array_3 = getChildCategories($cat_id_2);
						if(count($cat_array_3) > 0 ){
							echo "<br><b>";echo ucwords($cat_name_2); echo "&nbsp; &raquo;</b><br>";
							echo '<div style="padding-left:20px;padding-bottom:5px;min-height:2px;">';
							//////////////////////////////////////// 3nd level ////////////////////////////////////////
							$l = 0;
							foreach($cat_array_3 as $cat_id_3 => $cat_name_3){
								$cat_array_4 = getChildCategories($cat_id_3);
			if(count($cat_array_4) > 0 ){
				echo '<div style="padding-top:5px;min-height:2px;">';
				echo "<br><b>";echo ucwords($cat_name_3); echo " &raquo;</b><br>";
				echo '<div style="padding-left:20px;padding-bottom:5px;min-height:2px;">';
		//////////////////////////////////////// 4nd level ////////////////////////////////////////
			$m=0;
			foreach($cat_array_4 as $cat_id_4 => $cat_name_4){
					 $m++;
					if($m%5 == 0){ echo "<br />";}
					$checked_category4 = checkSelectedCategory($cat_id_4,$categories_array);
					//echo "<input type=\"checkbox\" value=\"$cat_id_4\" name=\"data[ProductCategory][] \"  onclick=\"showSelectedCats(); \" $checked_category4 >";
					echo "<input type=\"checkbox\" value=\"$cat_id_4\" name=\"data[ProductCategory][] \"  class=\"input-btn-last \" $checked_category4 >";
					echo "&nbsp;<span id=selected_".$cat_id_4.">";echo ucwords($cat_name_4); echo "</span>&nbsp;";
					echo "&nbsp;&nbsp;&nbsp;";
				
			}// 4rd foreach
								//////////////////////////////////////// 4nd level ends  ////////////////////////////////////////	
								echo "</div></div>";
								 }else{
			//$arr3[$cat_id_3] = $cat_name_3;
			 $l++;
			if($l%6 == 0){ echo "<br />";}
			$checked_category3 = checkSelectedCategory($cat_id_3,$categories_array);
			echo "<input type=\"checkbox\" value=\"$cat_id_3\" name=\"data[ProductCategory][] \" class=\"input-btn-last \"  $checked_category3>";
			echo "&nbsp;<span id=selected_".$cat_id_3.">";echo ucwords($cat_name_3); echo "</span>&nbsp;";
			echo "&nbsp;&nbsp;&nbsp;"; 
		} 
					}// 3rd foreach
					echo '</div>';
					//////////////////////// 3nd level ends  //////////////////////////
				}else{
					$k++;
			
			if($k%6 == 0){ echo "<br />";}
			$checked_category2 = checkSelectedCategory($cat_id_2,$categories_array);
			echo "<input type=\"checkbox\" value=\"$cat_id_2\" name=\"data[ProductCategory][] \" class=\"input-btn-last \" $checked_category2>";
			echo "&nbsp;<span id=selected_".$cat_id_2.">";echo ucwords($cat_name_2); echo "</span>&nbsp;";
			echo "&nbsp;&nbsp;&nbsp;";
						}
					} // 2ndst foreach 
					echo "</div>";	
				//////////////////////////////////////// 2nd level  ends ////////////////////////////////////////	
				}else{
					$j++;
					
					$checked_category1 = checkSelectedCategory($cat_id_1,$categories_array);
					echo "<input type=\"checkbox\" value=\"$cat_id_1\" name=\"data[ProductCategory][] \" class=\"input-btn-last \" $checked_category1>";
					echo "&nbsp;<span id=selected_".$cat_id_1.">";echo ucwords($cat_name_1); echo "</span>&nbsp;";
					echo "&nbsp;&nbsp;&nbsp;";
					//if($j%5 == 0){ echo "<br />";}
				}
			} //// ist foreach 
			//////////////////////////////////////// 1st level ends ////////////////////////////////////////	
			echo "</div>";	 
		}else{
			
			$checked_category0 = checkSelectedCategory($cat_id_0,$categories_array);
			echo "<input type=\"checkbox\" value=\"$cat_id_0\" name=\"data[ProductCategory][] \"  class=\"input-btn-last \" $checked_category0 >";
			echo "&nbsp;<span id=selected_".$cat_id_0.">";echo ucwords($cat_name_0); echo "</span>&nbsp;";
			echo "&nbsp;&nbsp;&nbsp;";
					
	
		}
		echo "</td></tr>";
		} // 0th foreach
	}
// } // department foreach 
	?>
</table>
</div>
</div>
<?php
} else{
	//echo '<span style="text-align:center;">No Category Found</span>';
}
?>