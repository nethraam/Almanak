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

if (isset($_GET["id"])){
	$sql = $mysql->prepare("DELETE from $almanak_events WHERE id=?");
	$sql->execute([$_GET["id"]]);
}

echo "<div class=\"popup_box\">";

$error_message = translate('the activity has been deleted!');
echo "<p id=\"error_message\">".$error_message."</p>\n";
echo "</div>";

echo 	"<script>
			opener.location.reload(true);\n
			setTimeout(function () { self.close();}, 3000);\n
		</script>\n";
		
		

include 'footer.php';

?>