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




	if ( isset($_POST["title"]))
		$title = $_POST["title"];
	else 
		$title = "";
	
	if ( isset($_POST["day"]))	
		$day = $_POST["day"];
	else 
		$day = "";
	
	if ( isset($_POST["month"]))	
		$month = $_POST["month"];
	else 
		$month = "";
	
	if ( isset($_POST["before_easter"]))	
		$before_easter = $_POST["before_easter"];
	else 
		$before_easter = "";
	
	if ( isset($_POST["after_easter"]))	
		$after_easter = $_POST["after_easter"];
	else 
		$after_easter = "";
	
	if ( isset($_POST["nth"]))	
		$nth = $_POST["nth"];
	else 
		$nth = "";
	
	if ( isset($_POST["nth_day"]))	
		$nth_day = $_POST["nth_day"];
	else 
		$nth_day = "";
	
	if ( isset($_POST["nth_month"]))	
		$nth_month = $_POST["nth_month"];
	else 
		$nth_month = "";
	
	if ( isset($_GET["type"]))	
		$type = $_GET["type"];
	else 
		$type = "";
	
	
	
if (isset($_POST["submit"])){
	if ($title == ""){
		$error_message = "<span style=\"color:red\">".translate('please enter a title')."</span>";
	}
	else{
		$sql= $mysql->prepare("INSERT INTO $almanak_holidays (type, title, day, month, before_easter, after_easter, nth, nth_day, nth_month) VALUES (?,?,?,?,?,?,?,?,?)");
		$sql->execute([$type, $title, $day, $month, $before_easter, $after_easter, $nth, $nth_day, $nth_month]);
		$succes_message = translate('the data has been added');
	}
}



echo "<div class=\"popup_box\">";
echo "<div id=\"hide_form\">";
echo "<h4>".translate('add holiday')."</h4>";
if (!isset($_POST["submit"])){

	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"get\">";
	echo translate('type').": ";
	echo "<select name=\"type\" onchange=\"this.form.submit();\">";
		echo "\n <option value=\"\" selected=\"selected\">".translate('select holiday type')."</option>";
		if ($type == 'date')
			echo "\n <option value=\"date\" selected=\"selected\">".translate('date')."</option>";
		else
			echo "\n <option value=\"date\" >".translate('date')."</option>";
		if ($type == 'before_easter')
			echo "\n <option value=\"before_easter\" selected=\"selected\">".translate('before easter')."</option>";
		else
			echo "\n <option value=\"before_easter\" >".translate('before easter')."</option>";
		if ($type == 'after_easter')
			echo "\n <option value=\"after_easter\" selected=\"selected\">".translate('after easter')."</option>";
		else
			echo "\n <option value=\"after_easter\" >".translate('after easter')."</option>";
		if ($type == 'nth')
			echo "\n <option value=\"nth\" selected=\"selected\">".translate('nth weekday of month')."</option>";
		else
			echo "\n <option value=\"nth\">".translate('nth weekday of month')."</option>";
	echo "</select></form><br>";
}

// form 1
if($type == 'date'){
echo "<div id=\"date_holiday\"><form action=\"".$_SERVER['PHP_SELF']."?type=$type\" method=\"post\">\n";
echo "<p>".translate('title').":<br>";
echo "<input type=\"text\" name=\"title\" value=\"$title\" size=\"40\"></p>\n";

echo translate('date').": ";
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
echo "</select><br>\n";
// echo " <input type=\"submit\" value=\"".translate('submit')."\" name=\"submit\" class=\"btn btn-danger btn-sm btn-block\" />";
echo "<hr><p id=\"popup_box_options\" class=\"popup_box_options\">";
echo " <input type=\"submit\" value=\" \" name=\"submit\" class=\"save_button\" title=\"".translate('opslaan')."\" /> &emsp;";
echo "&emsp;<a href=\"#\" onclick='Javascript:window.close();'><img src=\"img/application-exit-48.png\" alt=\"".translate('close')."\"   title=\"".translate('close')."\"></a></p>";
echo"</form></div>";
}

//form 2
if($type == 'before_easter'){
echo "<div id=\"before_easter_holiday\"><form action=\"".$_SERVER['PHP_SELF']."?type=$type\" method=\"post\">\n";
echo "<p>".translate('title').":<br>";
echo "<input type=\"text\" name=\"title\" value=\"$title\" size=\"40\"></p>\n";

echo "<select name=\"before_easter\">\n";
		for ($i = 0 ; $i <= 60 ; $i++) {
		if (($i) == $before_easter) 
			echo "<option value=\"$i\" selected=\"selected\">".$i."</option>\n";
		else
			echo "<option value=\"$i\">".$i."</option>\n";
	}
echo "</select>\n";
echo translate('days before easter')."<br>";

// echo " <input type=\"submit\" value=\"".translate('submit')."\" name=\"submit\" class=\"btn btn-danger btn-sm btn-block\" />";
echo "<hr><p id=\"popup_box_options\" class=\"popup_box_options\">";
echo " <input type=\"submit\" value=\" \" name=\"submit\" class=\"save_button\" title=\"".translate('opslaan')."\" /> &emsp;";
echo "&emsp;<a href=\"#\" onclick='Javascript:window.close();'><img src=\"img/application-exit-48.png\" alt=\"".translate('close')."\"   title=\"".translate('close')."\"></a></p>";
echo"</form></div>";
}

//form 3
if($type == 'after_easter'){
echo "<div id=\"after_easter_holiday\"><form action=\"".$_SERVER['PHP_SELF']."?type=$type\" method=\"post\">\n";
echo "<p>".translate('title').":<br>";
echo "<input type=\"text\" name=\"title\" value=\"$title\" size=\"40\"></p>\n";

echo "<select name=\"after_easter\">\n";
		for ($i = 0 ; $i <= 60 ; $i++) {
		if (($i) == $after_easter) 
			echo "<option value=\"$i\" selected=\"selected\">".$i."</option>\n";
		else
			echo "<option value=\"$i\">".$i."</option>\n";
	}
echo "</select>\n";
echo translate('days after easter')."<br>";

// echo " <input type=\"submit\" value=\"".translate('submit')."\" name=\"submit\" class=\"btn btn-danger btn-sm btn-block\" />";
echo "<hr><p id=\"popup_box_options\" class=\"popup_box_options\">";
echo " <input type=\"submit\" value=\" \" name=\"submit\" class=\"save_button\" title=\"".translate('opslaan')."\" /> &emsp;";
echo "&emsp;<a href=\"#\" onclick='Javascript:window.close();'><img src=\"img/application-exit-48.png\" alt=\"".translate('close')."\"   title=\"".translate('close')."\"></a></p>";
echo"</form></div>";
}

//form 4
if($type == 'nth'){
echo "<div id=\"nth_holiday\"><form action=\"".$_SERVER['PHP_SELF']."?type=$type\" method=\"post\">\n";
echo "<p>".translate('title').":<br>";
echo "<input type=\"text\" name=\"title\" value=\"$title\" size=\"40\"></p>\n";

echo "<select name=\"nth\">\n";
		for ($i = 1 ; $i <= 5 ; $i++) {
		if (($i) == $nth) 
			echo "<option value=\"$i\" selected=\"selected\">".$numbernames[$i]."</option>\n";
		else
			echo "<option value=\"$i\">".$numbernames[$i]."</option>\n";
	}
echo "</select>\n";
echo "<select name=\"nth_day\">\n";
		for ($i = 0 ; $i <= 6 ; $i++) {
		if (($i) == $nth_day) 
			echo "<option value=\"$i\" selected=\"selected\">".$daynames[$i]."</option>\n";
		else
			echo "<option value=\"$i\">".$daynames[$i]."</option>\n";
	}
echo "</select>\n";
echo " ".translate('of')." ";
echo "<select name=\"nth_month\">\n";
		for ($i = 1 ; $i <= 12 ; $i++) {
		if (($i) == $nth_month) 
			echo "<option value=\"$i\" selected=\"selected\">".$monthnames[$i]."</option>\n";
		else
			echo "<option value=\"$i\">".$monthnames[$i]."</option>\n";
	}
echo "</select><br>\n";

// echo " <input type=\"submit\" value=\"".translate('submit')."\" name=\"submit\" class=\"btn btn-danger btn-sm btn-block\" />";
echo "<hr><p id=\"popup_box_options\" class=\"popup_box_options\">";
echo " <input type=\"submit\" value=\" \" name=\"submit\" class=\"save_button\" title=\"".translate('opslaan')."\" /> &emsp;";
echo "&emsp;<a href=\"#\" onclick='Javascript:window.close();'><img src=\"img/application-exit-48.png\" alt=\"".translate('close')."\"   title=\"".translate('close')."\"></a></p>";
echo"</form></div>";
}


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
if(isset($succes_message)){
	echo "<p id=\"succes_message\">".$succes_message."</p>\n";
	echo 	"<script>	
				document.getElementById(\"hide_form\").style.display=\"none\";\n
				opener.location.reload(true);\n
				setTimeout(function () { self.close();}, 3000);\n
			</script>\n";
}



echo "</div>";

include ('popup_footer.php'); 

?>