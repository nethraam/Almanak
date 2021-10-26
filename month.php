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


include "header.php";
include "menu.php"; 

//check if variables are empty
if(isset($_GET["month"]))
	$month = $_GET["month"];
else
	$month = date("n");

if(isset($_GET["year"]))
	$year = $_GET["year"];
else
	$year = date("Y");

//form to select month and year
$prev_month = $month-1;
$next_month = $month+1;

if ($month == 1){
	$prev_month = 12;
	$prev_year = $year-1;
} else {
	$prev_month = $month-1;
	$prev_year = $year;
}

if ($month == 12 ){
	$next_month = 1;
	$next_year = $year+1;
} else {
	$next_month = $month+1;
	$next_year = $year;
}


echo "<div class=\"month_calendar\">" ;

echo "<div class=\"month_title\"><h3>";
echo "<a class=\"link_button\" href=\"".$_SERVER['PHP_SELF']."?month=$prev_month&year=$prev_year\"><img src=\"img/prev-o.png\" alt=\"".translate('goto previous month')."\"></a>  ";
echo $monthnames[$month]."  ".$year;
echo "  <a class=\"link_button\" href=\"".$_SERVER['PHP_SELF']."?month=$next_month&year=$next_year\"><img src=\"img/next-o.png\" alt=\"".translate('goto next month')."\"></a>";
echo "</h3></div>";

echo "<div class=\"month_select\">";
echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"get\">";
echo "<select name=\"month\" onchange=\"this.form.submit();\">";
	for ($i = 1 ; $i <= 12 ; $i++) {
		if (($i) == $month) 
			echo "\n <option value=\"$i\" selected=\"selected\">".$monthnames[$i]."</option>";
		else
			echo "\n <option value=\"$i\">".$monthnames[$i]."</option>";
	}
echo "</select>";
echo "<select name=\"year\" onchange=\"this.form.submit();\">";
	for ($i = ($start_year) ; $i <= (date("Y") + $future_years) ; $i++) {
		if (($i) == $year) 
			echo "\n <option value=\"$i\" selected=\"selected\">".$i."</option>";
		else
			echo "\n <option value=\"$i\">".$i."</option>";
	}
echo "</select>";	
echo "</form>";
echo '</div>';





//get the number of days in month, the number of the first day and the number of cells needed
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
$start_day = date('N',mktime(0,0,0,$month,1,$year));
	
if (($start_day + $days_in_month-1) <= 35) 				//calculate number of cells in table
		$end_cell=35;
	 else 
		$end_cell=42;

// start table of calendar
echo "\n <table class=\"month_calendar\">";
	echo "<tr>";
		foreach ($daynames as $dayname) {
			echo "<th>$dayname</th>";
		}
	echo "</tr>";
	echo "<tr>";
for ($i=1 ; $i < $start_day ; $i++)
	echo '<td>'.' '.'</td>';								//draw empty cells
		
for ($i = 1 ; $i<=$days_in_month; $i++){
	$holiday = get_holidays($i, $month, $year);
	
	// if (($i == date("d")) && ($month == date("n")) && ($year == date("Y")))
		// echo "\n <td> <div data-toggle=\"tooltip\" data-placement=\"top\" data-html=\"true\" class=\"today day_number\" title=\"".translate('today')."\">".$i."</div>";									//echo day number and class today
	// elseif ($holiday != "")
		// echo "\n <td> <div class=\"holiday day_number\" >".$i."</div>";									//echo day number and class holiday
	// else
		// echo "\n <td> <div class=\"day_number\">".$i."</div>";									//echo day number
		// echo "<span data-toggle=\"tooltip\" data-placement=\"top\" data-html=\"true\" title=\"$holiday\"> $holiday </span>"; //echo holiday
	// echo "<a class=\"add_event_icon\" href=\"add_update_event.php?day=$i&month=$month&year=$year\" onclick=\"window.open('add_update_event.php?day=$i&month=$month&year=$year','add event', 'width=400,height=425,top=100,left=100,scrollbars=no,toolbar=no,location=no'); return false\">
		// <img src=\"img/appointment-new-4.png\" class=\"add_event_icon\" alt=\"".translate('add event on')." $i $monthnames[$month]\" title=\"".translate('add event on')." $i $monthnames[$month] \">
		// </a><br>"; //echo add event link
		
	echo "\n <td> <div data-toggle=\"tooltip\" data-placement=\"top\" data-html=\"true\" class=\"day_number";
		if (($i == date("d")) && ($month == date("n")) && ($year == date("Y"))){echo " today";}
		if ($holiday != "") {echo " holiday";}
	echo "\" ";
		if (($i == date("d")) && ($month == date("n")) && ($year == date("Y"))){echo "title=\"".translate('today')."\"";}
		if ($holiday != "") {echo "title=\"$holiday\"";}
	echo ">";
	echo "<div class=\"day_number_holiday\">$i  $holiday</div>" ;
	echo "<a class=\"add_event_icon\" href=\"add_update_event.php?day=$i&month=$month&year=$year\" onclick=\"window.open('add_update_event.php?day=$i&month=$month&year=$year','add event', 'width=400,height=425,top=100,left=100,scrollbars=no,toolbar=no,location=no'); return false\">
		<img src=\"img/appointment-new-4.png\" class=\"add_event_icon\" alt=\"".translate('add event on')." $i $monthnames[$month]\" title=\"".translate('add event on')." $i $monthnames[$month] \">
		</a></div>"; //echo add event link	

	echo "<div class=\"month_events\">";
		$sql = get_events($i, $month, $year);
		foreach ($sql as $row) {
			echo "\n\t <a href=\"view_event.php?id=".$row['id']."\" onclick=\"window.open('view_event.php?id=".$row['id']."','".$row['title']."', 'width=400,height=425,scrollbars=no,toolbar=no,location=no'); return false\">".$row['title']."</a><br>"; //echo event title and make link to event with event id
		}		
	echo "</div></td>";
	
	if (($i+$start_day-1)%7==0) 							
	echo "</tr> \n <tr>";				//create new row after 7 days
	}	
	
for ($i=($start_day+$days_in_month); $i<=$end_cell; $i++)
	echo '<td>'.' '.'</td>';								//draw empty cells
	
echo "</tr> </table>";
echo "</div>";

echo ' <script>
$(document).ready(function(){
  $(\'[data-toggle=\"tooltip\"]\').tooltip();   
});
</script>';


include "footer.php";






?>