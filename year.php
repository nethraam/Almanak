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


include 'header.php';
include "menu.php"; 

if(isset($_GET['year']))
	$year = $_GET['year'];
else
	$year=date("Y");

$prev_year = $year - 1;
$next_year = $year + 1;



echo"<div class=\"year_calendar\">\n";

echo "<div class=\"year_title\">";
echo "<h3><a class=\"link_button\" href=\"".$_SERVER['PHP_SELF']."?year=$prev_year\"><img src=\"img/prev-o.png\" alt=\"".translate('goto previous year')."\" title=\"".translate('go to previous year')."\"></a>";
echo " $year ";
echo "<a class=\"link_button\" href=\"".$_SERVER['PHP_SELF']."?year=$next_year\"><img src=\"img/next-o.png\" alt=\"".translate('goto next year')."\" title=\"".translate('go to next year')."\"></a></h3>";
echo "</div>";


for ($month = 1 ; $month <= 12 ; $month++){ 
echo "<div class=\"year_calendar_month\">\n";
echo $monthnames[$month].'<br>';

$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
$start_day = date('N',mktime(0,0,0,$month,1,$year));
	
if (($start_day + $days_in_month-1) <= 35) 				//calculate number of cells in table
		$end_cell=35;
	 else 
		$end_cell=42;

// start table of calendar
echo "\n <table class=\"year_calendar_month\">\n";
	echo "<tr>";
		foreach ($daynames as $dayname) {
			
			echo "<th> ".substr("$dayname",0 ,2)." </th>";
			
		}
	echo "</tr>";
	echo "<tr>";
for ($i=1 ; $i < $start_day ; $i++)
	echo "<td class=\"year_calendar_empty\">"." "."</td>\n";								//draw empty cells
		
for ($i = 1 ; $i<=$days_in_month; $i++){
		$sql = get_events($i, $month, $year);
		$holiday = get_holidays($i, $month, $year);
		// $j = 0;
		$tooltip = "";
		foreach ($sql as $row) {	
		// $j++;
		$tooltip.= $row['title'].'<br>';
		}
		
		
		if ($tooltip == ""){
			echo "\n <td class=\" year_calendar_no_event ";
				if (($i == date("d")) && ($month == date("n")) && ($year == date("Y")))
					echo "today ";
				if ($holiday != "")
					echo "holiday";
				echo " \"> $i<br></td>";
		}
		else  {
			echo " <td class=\"year_calendar_event event_link ";
				if (($i == date("d")) && ($month == date("n")) && ($year == date("Y")))
					echo "today ";
				if ($holiday != "")
					echo "holiday";
			echo "\"><a href=\"#\" data-toggle=\"tooltip\" data-placement=\"top\" data-html=\"true\" title=\"$tooltip\" >$i<br></a></td>";
		}
		
		
		
		
		// if ($j >=1){
			// echo "\n <td class=\"year_calendar_event\"> ";
			// if (($i == date("d")) && ($month == date("n")) && ($year == date("Y")))
				// echo "<a  class=\"event_link today\" href=\"#\" data-toggle=\"tooltip\" data-placement=\"top\" data-html=\"true\" title=\"$tooltip\">$i<br></a>";
			// else
				// echo "<a  class=\"event_link\" href=\"#\" data-toggle=\"tooltip\" data-placement=\"top\" data-html=\"true\" title=\"$tooltip\">$i<br></a>";
		// }
		// else{
			// if (($i == date("d")) && ($month == date("n")) && ($year == date("Y")))
				// echo "\n <td class=\"year_calendar_no_event today\"> $i<br>";
			// else
				// echo "\n <td class=\"year_calendar_no_event\"> $i<br>";
		// }
			
	// echo "</td>";
	
	if (($i+$start_day-1)%7==0) 							
	echo "</tr> \n <tr>";				//create new row after 7 days
	}	
	
for ($i=($start_day+$days_in_month); $i<=$end_cell; $i++)
	echo "<td class=\"year_calendar_empty\">"." "."</td>\n";								//draw empty cells
	
echo "</tr>\n</table>\n</div>\n";
}

// echo "<table><tr><td class=\"holiday\">".translate('holiday')."</td><tr><td class=\"today\">".translate('today')."</td>";

echo '</div>';


echo ' <script>
$(document).ready(function(){
  $(\'[data-toggle=\"tooltip\"]\').tooltip();   
});
</script>';

include 'footer.php';




?>
