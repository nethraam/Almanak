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

$id=$_GET["id"];

	$sql = $mysql->prepare("SELECT * FROM $almanak_events WHERE id=?");
	//$sql->bindparam(1, $id);
	$sql->execute([$id]);
	
if ($row = $sql->fetch(PDO::FETCH_ASSOC)){ 
	$title = $row['title'];
	$description = $row['description'];
	$day = $row['day'];
	$month = $row['month'];
	$year = $row['year'];
	$starttime = $row['starttime'];
	$endtime = $row['endtime'];
	$user = $row['user'];
}

echo "<div class=\"popup_box\">";
echo "<h4>".($title)."</h4>";

echo "<h7>".translate('description').":</h7><p>". $description."</p>";
echo "<h7>".translate('date').":</h7><p>".$day." ".$monthnames[$month]." ".$year."</p>";

echo "<p>";
if ( $starttime != "")
	echo "".translate('starttime').": ".$starttime."&emsp;";

if ( $endtime != "")
	echo "  ".translate('endtime').": ".$endtime;
echo "</p>";

echo "<h7>".translate('user').":</h7><p>".$user."</p>";

echo "<hr>";

echo "<p id=\"popup_box_options\" class=\"popup_box_options\"><a href=\"add_update_event.php?id=$id\"><img src=\"img/edit-48.png\" alt=\"".translate('change event')."\"   title=\"".translate('change event')."\"></a> &emsp;";
echo "&emsp;<a href=\"#\"   onclick=\"Show('confirm'); Hide('popup_box_options'); return false;\"><img src=\"img/edit-delete-48.png\" alt=\"".translate('delete event')."\"   title=\"".translate('delete event')."\"></a> &emsp;";
echo "&emsp;<a href=\"#\" onclick='Javascript:window.close();'><img src=\"img/application-exit-48.png\" alt=\"".translate('close')."\"   title=\"".translate('close')."\"></a></p>";



echo "<div id=\"confirm\" style=\"display: none;\">";
echo translate('Are you sure you want to delete this activity?')."<br>";
echo "<a href=\"#\" onclick=\"Hide('confirm'); Show('popup_box_options'); return false;\" class=\"btn btn-default btn-ok\">".translate('cancel')." </a>&emsp;&emsp;
	<a href=\"delete_event.php?id=$id\" class=\"btn btn-danger btn-ok\">".translate('delete')." </a>
	</div>";


echo "</div></div>";

?>

<script>
	function Show(id) {
		document.getElementById(id).style.display = 'block';
	}
	function Hide(id) {
		document.getElementById(id).style.display = 'none';
	}
</script>



</body>
</html>
