<?php	
 
/**
* Calendar Helper for CakePHP
*
* Copyright 2007-2008 John Elliott
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
*
* @author John Elliott
* @copyright 2008 John Elliott
* @link http://www.flipflops.org More Information
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
*
*/
 
class CalendarHelper extends Helper
{
 
	var $helpers = array('Html', 'Form');
 
/**
* Generates a Calendar for the specified by the month and year params and populates it with the content of the data array
*
* @param $year string
* @param $month string
* @param $data array
* @param $base_url
* @return string - HTML code to display calendar in view
*
*/
 
function calendar($year = '', $month = '', $data = '', $base_url ='')
{

	$str = '';
	$month_list = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
	$day_list = array('Sun','Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
	$day = 1;
	$today = 0;
 
	if($year == '' || $month == '') { // just use current yeear & month
		$year = date('Y');
		$month = date('M');
	}
 
 
 
	$flag = 0;
 
	for($i = 0; $i < 12; $i++) {
		if(strtolower($month) == $month_list[$i]) {
			if(intval($year) != 0) {
				$flag = 1;
				$month_num = $i + 1;
				break;
			}
		}
	}
 
 
	if($flag == 0) {
		$year = date('Y');
		$month = date('F');
		$month_num = date('m');
	}
 
	$next_year = $year;
	$prev_year = $year;
 
	$next_month = intval($month_num) + 1;
	$prev_month = intval($month_num) - 1;
 
	if($next_month == 13) {
		$next_month = 'january';
		$next_year = intval($year) + 1;
	} else {
		$next_month = $month_list[$next_month -1];
	}
 
	if($prev_month == 0) {
		$prev_month = 'december';
		$prev_year = intval($year) - 1;
	} else {
		$prev_month = $month_list[$prev_month - 1];
	}
 
	if($year == date('Y') && strtolower($month) == strtolower(date('F'))) {	
	// set the flag that shows todays date but only in the current month - not past or future...
		$today = date('j');
	}
 
	$days_in_month = date("t", mktime(0, 0, 0, $month_num, 1, $year));
 
	$first_day_in_month = date('D', mktime(0,0,0, $month_num, 1, $year));
	


	$str=$this->EventCalender($data,$base_url,$prev_year,$prev_month,$month,$year,$next_year,$next_month,$day_list,$days_in_month,$day,$day_list,$first_day_in_month,$days_in_month,$month_num);
		
		echo $str;
// 		die(__FILE__);
	}


	/**
	@function	:	EventCalender
	@description	:	Display parent calendar in message
	@params		:	null
	@return		:	string
	@created	:	28-01-2010
	@credated by	:	Ramanpreet Pal Kaur
	**/

	function EventCalender($data,$base_url,$prev_year,$prev_month,$month,$year,$next_year,$next_month,$day_list,$days_in_month,$day,$day_list,$first_day_in_month,$days_in_month,$month_num){
	$current_date = date('d-F-Y');
	$current_date = explode('-',$current_date);
	$currentday = $current_date[0];
	$currentmonth = $current_date[1];
	$currentyear = $current_date[2];
	$total_week=0;	
	$str='<div class="messagebox-calender" id="calender">';
		$str .= '<div class="cal-month" style="width:98%; ">';
			$str .= '<div style="width:60%; text-align:left;padding-left:5px;float:left;font-weight:bold;">';
			$str .= ucfirst($month).' ' . $year . ' ';
			$str .= '</div>';
		
		if($currentyear == $year){
			if($currentmonth == ucfirst($month)){
				$this_month = true;
			} else{
				$this_month = false;
			}
		} else{
			$this_month = false;
		}
		
			$str .= '<div style="width:35%; text-align:right;float:right">';
			$str .= $this->Html->link($this->Html->image('cal-pre-btn.png',array('border'=>0)), 'javascript:void(0)',array('onClick'=>'return updateCalender('.$prev_year.',\''.$prev_month.'\')','escape'=>false,'alt'=>'Previous','title'=>'Click to previous month'),false,false).'&nbsp;&nbsp;';

			$str .= $this->Html->link($this->Html->image('cal-next-btn.png',array('border'=>0)), 'javascript:void(0)',array('onClick'=>'return updateCalender('.$next_year.',\''.$next_month.'\')','escape'=>false,'alt'=>'Next','title'=>'Click to next month'),false,false);
		
			$str .= '</div>';
		$str.='	</div>';
		
		$str .='<div style="height:15px"></div>';
		$str .='<div class="cal-week">';
			$str.='<ul>';
			for($i = 0; $i < 7;$i++) {
			$str.='<li>'.$this->Html->link(substr($day_list[$i],0,1), 'javascript:void(0)',array('onClick'=>'return updateCalender('.$prev_year.',"'.$prev_month.'")','alt'=>'Next','title'=>'Click to next month'),false,false).'</li>';
			}
			$str.= '</ul>';
		$str .= '</div>';
		$str .= '<div class="cal-date">';
// 			$str .= '<ul>';
			$today=date('d');
			//$month=date('m');
			$total_week=0;
			$month_name = $month;
			$month_number = "";
			for($mi=1;$mi<=12;$mi++){  
				if(strtolower(date("F", mktime(0, 0, 0, $mi, 1, 0))) == strtolower($month_name)){
					$month_number = $mi;
					break;
				}
			}
			while($day <= $days_in_month) {
			$total_week++;
			$str .= '<div class="clear"></div><ul class="date">';	
			for($i = 0; $i < 7; $i ++) {
				$cell = '&nbsp;';
				if(isset($data[$day])) {
					$cell = $data[$day];
				}
				$class = '';
				if(($first_day_in_month == $day_list[$i] || $day > 1) && ($day <= $days_in_month)) {
					$class = '';
					if($this_month){
						if($currentday == $day){
							$class = 'current';
						}
					}
				$str.='<li class="'.$class.'">';
// 					$str.=$day;
					$str .= $this->Html->link($day, 'javascript:void(0)',array('onClick'=>'return updateDate(this.innerHTML,"'.ucfirst($month).'",'.$year.','.$i.','.$month_number.')', 'id'=>"date_".$day),false,false);
					$str.='</li>';
					$str.=				'
								';
					
					$day++;
				} else { 
					$str .='<li>&nbsp; </li>';
					
				}

			}
			$str .= '</ul>';
			}
		
// 		$str.='	</ul>
		$str .= '<div class="clear"></div>';
		$str .= '</div>';
	$str .= '</div>';

		$str=str_replace('cal-date','cal-date cal-date_'.$total_week,$str);
// 	echo $str;

		return $str;
	}
}
?>