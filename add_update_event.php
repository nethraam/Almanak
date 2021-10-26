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

if(isset ($_GET['id']))
	$id=$_GET['id'];
else
	$id="";


if ( isset($_POST["submit"])){
	$title = $_POST["title"];
	$description = nl2br($_POST["description"]);
	$day = $_POST["day"];
	$month = $_POST["month"];
	$year = $_POST["year"];
	$username = $_SESSION['username'];
		if (($_POST["starttime_h"] != "  ") && ($_POST["starttime_m"] != "  "))
			$starttime = $_POST["starttime_h"].":".$_POST["starttime_m"];
		elseif(($_POST["starttime_h"] != "  ") && ($_POST["starttime_m"] == "  "))
			$starttime = $_POST["starttime_h"].":00";
		else
			$starttime = "";
		if (($_POST["endtime_h"] != "  ") && ($_POST["endtime_m"] != "  "))
			$endtime = $_POST["endtime_h"].":".$_POST["endtime_m"];
		elseif (($_POST["endtime_h"] != "  ") && ($_POST["endtime_m"] == "  "))
			$endtime = $_POST["endtime_h"].":00";
		else 
			$endtime = "";
	$starttime_h = $_POST["starttime_h"];
	$starttime_m = $_POST["starttime_m"];
	$endtime_h = $_POST["endtime_h"];
	$endtime_m = $_POST["endtime_m"];
	
	if (isset($_POST["repeat_days"]))
		$repeat_days = $_POST["repeat_days"];
	else 
		$repeat_days = 0;
	
	if (isset($_POST["repeat_times"]))
		$repeat_times = $_POST["repeat_times"];
	else 
		$repeat_times = 0;
	

	
	
	if ($id==""){
			if ($title == ""){
				$error_message = "<span style=\"color:red\">".translate('please enter a title')."</span>";
			}
			else{
				$sql= $mysql->prepare("INSERT INTO $almanak_events (title, description, day, month, year, starttime, endtime, user) VALUES (?,?,?,?,?,?,?,?)");
				$sql->execute([$title, $description, $day, $month, $year, $starttime, $endtime, $username]);
					//if repeat is set
					if (($repeat_days != 0) && ($repeat_times != 0)){
						repeat_add_event($title, $description, $day, $month, $year, $starttime, $endtime, $username, $repeat_times, $repeat_days);
					}
				$succes_message = translate('the data has been added');
				
			}
	}
	else{
		$sql= $mysql->prepare("UPDATE $almanak_events SET title=?, description=?, day=?, month=?, year=?, starttime=?, endtime=?, user=? WHERE id=?");
		$sql->execute([$title, $description, $day, $month, $year, $starttime, $endtime, $username, $id]);
		$succes_message = translate('the data has been updated');
	}	
}
else{
	$title = "";
	$description = "";
	$day = date("d");
	$month = date("n");
	$year = date("Y");
	$starttime_h = "";
	$starttime_m = "";
	$endtime_h = "";
	$endtime_m = "";
	$starttime= "";
	$endtime = "";
}

if ( isset($_GET["day"]) && isset($_GET["month"]) && isset($_GET["year"])){
	$day = $_GET["day"];
	$month = $_GET["month"];
	$year = $_GET["year"];
}

if ($id != ""){
	$sql = $mysql->prepare("SELECT * FROM $almanak_events WHERE id=?");
	$sql->execute([$id]);

	if ($row = $sql->fetch(PDO::FETCH_ASSOC)){ 
		$title = $row['title'];
		$description = $row['description'];
		$day = $row['day'];
		$month = $row['month'];
		$year = $row['year'];
		$starttime = $row['starttime'];
		$starttime_h = substr($starttime, 0, 2);
		$starttime_m = substr($starttime, 3, 2);
		$endtime = $row['endtime'];
		$endtime_h = substr($endtime, 0, 2);
		$endtime_m = substr($endtime, 3, 2);
	}
}

echo "<div class=\"popup_box\">";
echo "<div id=\"hide_form\">";

if ($id == "")
	echo "<h4>".translate('add event')."</h4>";
else
	echo "<h4>".translate('update event')."</h4>";


if ($id == "")
	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">\n";
else 
	echo "<form action=\"".$_SERVER['PHP_SELF']."?id=$id\" method=\"post\">\n";



echo "<p>".translate('title').":<br>";
echo "<input type=\"text\" name=\"title\" value=\"$title\" size=\"40\"></p>\n";
echo "<p>".translate('description').":<br>\n";
echo "<textarea name=\"description\" rows=\"4\" cols=\"40\">".str_replace('<br />', "", $description)."</textarea></p>\n";

echo translate('date').": <br>";
echo "<select name=\"day\">\n";
		for ($i = 1 ; $i <= 31 ; $i++) {
		if (($i) == $day) 
			echo "<option value=\"$i\" selected=\"selected\">".$i."</option>\n";
		else
			echo "<option value=\"$i\">".$i."</option>\n";
	}
echo "</select>\n";
echo "<select name=\"month\">\n";
		for ($i = 1 ; $i <= 12 ; $i++) {
		if (($i) == $month) 
			echo "<option value=\"$i\" selected=\"selected\">".$monthnames[$i]."</option>\n";
		else
			echo "<option value=\"$i\">".$monthnames[$i]."</option>\n";
	}
echo "</select>\n";
echo "<select  name=\"year\">\n";
	for ($i = ($start_year) ; $i <= (date("Y") + $future_years) ; $i++) {
		if (($i) == $year) 
			echo "<option value=\"$i\" selected=\"selected\">".$i."</option>\n";
		else
			echo "<option value=\"$i\">".$i."</option>\n";
	}
echo "</select><br><br>\n";


echo "<p style='float: left'>".translate('starttime').": ";
echo "\n<select title=\"".translate('starttime hours')."\" name=\"starttime_h\">";
	echo "<option value=\"  \">  </option>\n";
	for ($i = 0 ; $i <= 23; $i++ ){
		if (($i == $starttime_h) && ($i != '  ')) 
			echo "<option value=\"".sprintf('%02d', $i)."\" selected=\"selected\">".$i."</option>\n";
		else
			echo "<option value=\"".sprintf('%02d', $i)."\">".$i."</option>\n";
	}
echo "</select>\n";
echo " :";
echo "\n<select title=\"".translate('starttime minutes')."\"  name=\"starttime_m\">";
	echo "<option value=\"  \">  </option>";
	for ($i = 0 ; $i <= 55; $i+=5 ){
		if (($i == $starttime_m) && ($i != '  ')) 
			echo "<option value=\"".sprintf('%02d', $i)."\"  selected=\"selected\">".sprintf('%02d', $i)."</option>\n";
		else
			echo "<option value=\"".sprintf('%02d', $i)."\">".sprintf('%02d', $i)."</option>\n";
	}
echo "</select>&emsp;</p>   ";

echo "<p style='float: left'>".translate('endtime').": ";
echo "\n<select title=\"".translate('endtime hours')."\"  name=\"endtime_h\" >";
	echo "<option value=\"  \">  </option>";
	for ($i = 0 ; $i <= 23; $i++ ){
		if (($i == $endtime_h) && ($i != '  ')) 
			echo "<option value=\"".sprintf('%02d', $i)."\" selected=\"selected\">".$i."</option>\n";
		else
			echo "<option value=\"".sprintf('%02d', $i)."\">".$i."</option>\n";
	}
echo "</select>";
echo " :";
echo "\n<select title=\"".translate('endtime minutes')."\" name=\"endtime_m\">";
	echo "<option value=\"  \">  </option>";
	for ($i = 0 ; $i <= 55; $i+=5 ){
		if (($i == $endtime_m) && ($i != '  ')) 
			echo "<option value=\"".sprintf('%02d', $i)."\"  selected=\"selected\">".sprintf('%02d', $i)."</option>\n";
		else
			echo "<option value=\"".sprintf('%02d', $i)."\">".sprintf('%02d', $i)."</option>\n";
	}
echo "</select></p>";

echo "<div id=\"more_options\" style=\"display: none; clear: both;\"><p style='float: left'>";
echo translate('repeat')." ";
	echo "<select name=\"repeat_times\">\n";
			for ($i = 0 ; $i <= 50 ; $i++) {
			if (($i) == $repeat_times) 
				echo "<option value=\"$i\" selected=\"selected\">".$i."</option>\n";
			else
				echo "<option value=\"$i\">".$i."</option>\n";
		}
	echo "</select>\n";
echo translate('times')."&emsp;&emsp;</p><p style='float: left'>".translate('repeat every')." ";
	echo "<select name=\"repeat_days\">\n";
			for ($i = 0 ; $i <= 14 ; $i++) {
			if (($i) == $repeat_days) 
				echo "<option value=\"$i\" selected=\"selected\">".$i."</option>\n";
			else
				echo "<option value=\"$i\">".$i."</option>\n";
		}		
	echo "</select>\n";
echo translate('days');	
echo "</p></div>\n<br><hr style=\"clear:both; \">";



echo "<p id=\"popup_box_options\" class=\"popup_box_options\">";
echo " <input type=\"submit\" value=\"submit\" name=\"submit\" class=\"save_button\" title=\"".translate('save')."\" /> &emsp;";
echo "<span id=\"copy_button\" style=\"display: none;\"> &emsp;<input type=\"submit\" value=\"copy\" name=\"submit\" class=\"copy_button\" title=\"".translate('save and copy')."\" /> &emsp;</span>";
echo "&emsp;<a href=\"#\" onclick='Javascript:window.close();'><img src=\"img/application-exit-48.png\" alt=\"".translate('close')."\"   title=\"".translate('close')."\"></a>&emsp;";
if ($id=="")
echo "&emsp;<a href=\"#\" onclick=\"Show_block('more_options'); Show('copy_button'); return false;\"><img src=\"img/preferences-desktop.png\" alt=\"".translate('more options')."\"   title=\"".translate('more options')."\"></a></p>";

echo"</form>";
echo "</div>\n";

if(isset($error_message)){ 
	echo "<p id=\"error_message\"><img src=\"img/dialog-warning-2.png\" alt=\"".translate('error')."\"   title=\"".translate('error')."\"><br>".$error_message."</p>\n";
	echo "<script>	
			document.getElementById(\"hide_form\").style.display=\"none\";\n
			setTimeout(function () { 
					document.getElementById(\"hide_form\").style.display=\"initial\";
					document.getElementById(\"error_message\").style.display=\"none\";
			}, 4000);\n
			
		</script>";
}

if(isset($succes_message)&&($_POST['submit'] == 'submit')){
	echo "<p id=\"succes_message\">".$succes_message."</p>\n";
	echo 	"<script>	
				document.getElementById(\"hide_form\").style.display=\"none\";\n
				opener.location.reload(true);\n
				setTimeout(function () { self.close();}, 3000);\n
			</script>\n";
}


if(isset($succes_message)&&($_POST['submit'] == 'copy')){
	echo "<p id=\"succes_message\">".$succes_message."</p>\n";
	echo 	"<script>	
				document.getElementById(\"hide_form\").style.display=\"none\";\n
				opener.location.reload(true);\n
				setTimeout(function () {
					document.getElementById(\"hide_form\").style.display=\"initial\";
					document.getElementById(\"copy_button\").style.display=\"initial\";
					document.getElementById(\"succes_message\").style.display=\"none\";
				}, 2000);\n
			</script>\n";
}

echo "</div>";

 


include ('popup_footer.php'); 

?>



<script>
	function Show(id) {
		document.getElementById(id).style.display = 'initial';
	}
		function Show_block(id) {
		document.getElementById(id).style.display = 'block';
	}
	function Hide(id) {
		document.getElementById(id).style.display = 'none';
	}
</script>
