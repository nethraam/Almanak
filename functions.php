<?php
#    Almanak is en php and MySql based calendar to use on a web server or to incorporate in a website
#    Copyright (C) <2021>  <Maarten Verest>
#
#    This program is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program.  If not, see <https://www.gnu.org/licenses/>.


/***functions**********************************************************************************************/


	
function get_events($day, $month, $year){
	global $mysql;
	global $almanak_events ;
	
	$sql = $mysql->prepare("SELECT * FROM $almanak_events WHERE day=? AND month=? AND year=?");
	$sql->execute([$day, $month, $year]);

	return $sql;
}

function repeat_add_event($title, $description, $day, $month, $year, $starttime, $endtime, $username, $repeat_times, $repeat_days){
	global $mysql;
	global $almanak_events ;
	
	for ( $i = 1 ; $i <= $repeat_times; $i++){
		$day = $day + $repeat_days;
		$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			
			if ($day > $days_in_month){
				$day = $day - $days_in_month;
				$month++;
			}
			if ($month > 12){
				$month = 1;
				$year++;
			}
		
		$sql= $mysql->prepare("INSERT INTO $almanak_events (title, description, day, month, year, starttime, endtime, user) VALUES (?,?,?,?,?,?,?,?)");
		$sql->execute([$title, $description, $day, $month, $year, $starttime, $endtime, $username]);
	}
}

function email_add_update_event($title, $description, $day, $month, $year, $starttime, $endtime, $username, $update){
		global $mysql;
		global $almanak_settings ;
		$address = read_setting('e-mail address');
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers.= "Content-Type: text/html; charset=UTF-8\r\n";
		$headers.= "Reply-To: <>\r\n"; 
		$headers.= "From: almanak <>\r\n";
		$headers.= "X-Priority: 3\r\n";
		$headers.= "X-Mailer: PHP". phpversion() ."\r\n";
		
		$subject = translate('new event: ').$description;
		
		if ($update == 0){
			$subject = translate('new event: ').$description;
			$message = '<h2>'.translate('event added').'</h2><br>';
		}
		else{
			$subject = translate('updated event: ').$description;
			$message = '<h2>'.translate('event updated').'</h2><br>';
		}
		
		$message .= translate('title').": $title<br>"; 
		$message .= translate('description').": $description<br>"; 
		$message .= translate('date').": ".$day." ".$monthnames[$month]." ".$year."<br>";
		$message .= translate('starttime').": ".$starttime."&emsp;";
		$message .= "  ".translate('endtime').": ".$endtime."<br>";
		$message .= translate('user').": ".$user;
		
		mail($address, $subject, $message, $headers);
}	
	
function update_setting ($name, $value) {
		global $mysql;
		global $almanak_settings ;
	
		$sql= $mysql->prepare("UPDATE $almanak_settings SET value=? WHERE name=?");
		$sql->execute([$value, $name]); 
		header('Location: settings.php');
}
	
function read_setting ($name) {	
		global $mysql;
		global $almanak_settings ;

		$sql = $mysql->prepare("SELECT * FROM $almanak_settings WHERE name=?"); 
		$sql->execute([$name]);
		
		if ($row = $sql->fetch(PDO::FETCH_ASSOC)){ 
		$id = $row['id'];
		$value = $row['value'];
		}
		
		return $value;
}

function get_holidays ($day, $month, $year){
		
		global $mysql;
		global $almanak_holidays ;
		$holiday = "";
		
		// date holiday
		$sql = $mysql->prepare("SELECT * FROM $almanak_holidays WHERE day=? AND month=?"); 
		$sql->execute([$day, $month]);
		
		
		if ($row = $sql->fetch(PDO::FETCH_ASSOC)){
			$holiday .= " ".$row['title']."  ";
		} 
		
		//before easter holiday
		$easter = strtotime(date("Y-M-d", easter_date($year)));
		$current_date =strtotime("$year-$month-$day");  
		$before_easter = round(($easter - $current_date)/60/60/24)+1; 
		
		$sql = $mysql->prepare("SELECT * FROM $almanak_holidays WHERE type=? AND before_easter=? "); 
		$sql->execute(['before_easter', $before_easter]);
		
		if ($row = $sql->fetch(PDO::FETCH_ASSOC)){			
			$holiday .=  " ".$row['title']."  ";
		} 
		
		//after easter holiday
		$easter = strtotime(date("Y-M-d", easter_date($year)));
		$current_date =strtotime("$year-$month-$day");  
		$after_easter = round(($current_date - $easter)/60/60/24)-1; 
		
		$sql = $mysql->prepare("SELECT * FROM $almanak_holidays WHERE type=? AND after_easter=? "); 
		$sql->execute(['after_easter', $after_easter]);
		
		if ($row = $sql->fetch(PDO::FETCH_ASSOC)){			
			$holiday .=  " ".$row['title']."  ";
		} 
		
		//nth dat of month holiday
		$nth_month = $month;					
		$start_day = date('N',mktime(0,0,0,$month,1,$year));   		//calculate start day of month
		$nth_day = date('N',mktime(0,0,0,$month,$day,$year))-1;		//calculate number of day 0= monday 6=sunday
		$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
		
		$nth = ceil($day/7);
		
		if ($nth <= 4){
			$sql = $mysql->prepare("SELECT * FROM $almanak_holidays WHERE nth=? AND nth_day=? AND nth_month=?"); 
			$sql->execute([$nth, $nth_day, $nth_month]);
			if ($row = $sql->fetch(PDO::FETCH_ASSOC)){			
				$holiday .=  " ".$row['title']."  ";
			} 
		}
		
		if ($day >= ($days_in_month-6)){
			$nth=5;
		
			$sql = $mysql->prepare("SELECT * FROM $almanak_holidays WHERE nth=? AND nth_day=? AND nth_month=?"); 
			$sql->execute([$nth, $nth_day, $nth_month]);
			if ($row = $sql->fetch(PDO::FETCH_ASSOC)){			
				$holiday .=  " ".$row['title']."  ";
			} 
		}

	return $holiday;
		
}
?>