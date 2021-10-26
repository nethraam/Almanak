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

echo "<div class=\"settings_h4\"><h4>".translate('general')."</h4></div>";
echo "<div class=\"settings\">";

	if ( isset($_GET["value"])){ 
		update_setting ($_GET['name'], $_GET['value']);
	}
	

	echo "<table class=\"settings_table\">";
	
	$name = 'language';
	$value = read_setting ($name);
	echo "<tr><td>";
	echo translate("$name")." : </td>";
	echo "<td><form action=\"".$_SERVER['PHP_SELF']."\" method=\"GET\" >\n<select name=\"value\" onchange=\"this.form.submit();\" >\n";
		foreach ($languages as $values) {
			if (strtolower($value) == strtolower($values))
				echo "<option value=\"".$values."\" selected=\"selected\" >".$values."</option>\n";
			else
				echo "<option value=\"".$values."\" >".$values."</option>\n";
		}
	echo "</select>";
	echo "<input type=\"hidden\" name=\"name\" value=\"".$name."\">";
	echo "</form></td></tr>";
	
	$name = 'starting year of the calendar';
	$value = read_setting ($name);
	echo "<tr><td>";
	echo translate("$name")." : </td>";
	echo "<td><form action=\"".$_SERVER['PHP_SELF']."\" method=\"GET\" >\n<select name=\"value\" onchange=\"this.form.submit();\" >\n";
		for($i = 1950 ; $i <= 2050 ; $i++){
			if ($value == $i )
				echo "<option value=\"".$i."\" selected=\"selected\" >".$i."</option>\n";
			else
				echo "<option value=\"".$i."\" >".$i."</option>\n";
		}
	echo "</select>";
	echo "<input type=\"hidden\" name=\"name\" value=\"".$name."\">";
	echo "</form></td></tr>";
	
	$name = 'future years of the calendar';
	$value = read_setting ($name);
	echo "<tr><td>";
	echo translate("$name")." : </td>";
	echo "<td><form action=\"".$_SERVER['PHP_SELF']."\" method=\"GET\" >\n<select name=\"value\" onchange=\"this.form.submit();\" >\n";
		for($i = 1 ; $i <= 25 ; $i++){
			if ($value == $i )
				echo "<option value=\"".$i."\" selected=\"selected\" >".$i."</option>\n";
			else
				echo "<option value=\"".$i."\" >".$i."</option>\n";
		}
	echo "</select>";
	echo "<input type=\"hidden\" name=\"name\" value=\"".$name."\">";
	echo "</form></td></tr>";
	
	
	$name = 'e-mail address';
	$value = read_setting ($name);
	echo "<tr><td>";
	echo translate("$name")." : </td>";
	echo "<td><form action=\"".$_SERVER['PHP_SELF']."\" method=\"GET\" >\n";
	echo "<input type=\"email\" name=\"value\" value=\"$value\" size=\"40\">\n";
	echo "<input type=\"hidden\" name=\"name\" value=\"".$name."\">";
	echo "<input type=\"submit\" value=\"\" name=\"submit\" class=\"save_button_22x22\" title=\"".translate('save')."\" /> &emsp;";	
	echo "</form></td></tr>";
	
	
	
	echo "</table>";
	
	
echo "</div>";

?>