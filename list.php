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

$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year); 


echo "<div class=\"list_calendar\">" ;

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



echo "<div class=\"events_table\">"; ;
$j=0;
for ($i = 1 ; $i<=$days_in_month; $i++){
	$sql = $mysql->prepare("SELECT * FROM $almanak_events where day=? AND month=? AND year=? "); 
	$sql->execute([$i, $month, $year]);
	
	if($sql->rowCount() != 0) {
			$daynumber = (date("N", strtotime("$month/$i/$year"))-1);
		if (($i == date("d")) && ($month == date("n")) && ($year == date("Y")))		
			echo "<div class=\"events_table_events\"><h5>".translate('today')." ".$daynames[$daynumber]." ".$i." ".$monthnames[$month]." ".$year."</h5>";
		else
			echo "<div class=\"events_table_events\"><h5>".$daynames[$daynumber]." ".$i." ".$monthnames[$month]." ".$year."</h5>";
		
	
		while ($row = $sql->fetch()) {
			echo "\n\t <a href=\"view_event.php?id=".$row['id']."\" onclick=\"window.open('view_event.php?id=".$row['id']."','".$row['title']."', 'width=400,height=425,scrollbars=no,toolbar=no,location=no'); return false\">".$row['title']." "."</a>"; //echo event title and make link to event with event id
			// if ($row['starttime'] != "")
				// echo translate('from')." ".$row['starttime']." ";
			// if ($row['endtime'] != "")
				// echo translate('to')." ".$row['endtime'];
			echo "<br>";
			$j++;
		}
	echo "</div>\n";
	}
}	
if ($j == 0)
	echo translate("there are no activities in")." ".$monthnames[$month]." ".$year;

echo "</div></div>";

	
include 'footer.php';

?>