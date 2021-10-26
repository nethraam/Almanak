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


// include 'header.php';
// include "menu.php"; 

// if ($_SESSION['group_id'] == '2' ){ 

	if (isset($_GET["delete_id"])){
	$sql = $mysql->prepare("DELETE from $almanak_holidays WHERE id=?");
	$sql->execute([$_GET["delete_id"]]);
		echo "<script> window.location.href = \"settings.php\";</script>";
	}
	
echo "<div class=\"settings_h4\"><h4>".translate('holidays')."</h4></div>";
	echo "<div class=\"settings\">";

		$sql = $mysql->prepare("SELECT * FROM $almanak_holidays"); 
		$sql->execute();


	echo "<table class=\"settings_table\">";

		foreach ($sql as $row) {
			echo"<tr>";
			if ($row['type'] == 'date'){
				echo "<td>".$row['title'].":</td>\n";
				echo "<td>".$row['day']." ".$monthnames [$row['month']]."</td>\n";
			}
			if ($row['type'] == 'before_easter'){
				echo "<td>".$row['title'].":</td>\n";
				echo "<td>".$row['before_easter']." ".translate('days before easter')."</td>\n";
			}	
			if ($row['type'] == 'after_easter'){
				echo "<td>".$row['title'].":</td>\n";
				echo "<td>".$row['after_easter']." ".translate('days after easter')."</td>\n";
			}
			if ($row['type'] == 'nth'){
				echo "<td>".$row['title'].":</td>\n";
				echo "<td>".$numbernames[$row['nth']]." ".$daynames[$row['nth_day']]." ".translate('of')." ".$monthnames[$row['nth_month']]."</td>\n";
			}
			echo "<td><a href=\"#\" onclick=\"Show('confirm".$row['id']."'); return false;\"><img src=\"img/delete.png\" alt=\"".translate('delete holiday')."\" title=\"".translate('delete holiday')."\" /></a>\n";
						echo "<div id=\"confirm".$row['id']."\" style=\"display: none; \">";
						echo "<a href=\"#\"  onclick=\"Hide('confirm".$row['id']."'); return false;\"><img src=\"img/edit-undo-5.png\" alt=\"".translate('cancel')."\" title=\"".translate('cancel')."\" /></a>\n";
						echo "<a href=\"".$_SERVER['PHP_SELF']."?delete_id=".$row['id']."\" ><img src=\"img/edit-delete-6.png\" alt=\"".translate('delete')."\" title=\"".translate('delete')."\" /></a>\n";
						echo "</div></td>\n";
				echo"</tr>";
		}

	echo "</table>";
	echo "</div>";
	echo "<div id=\"add_user\"><a class=\"btn btn-danger\" role=\"button\" href=\"add_update_holiday.php?\" onclick=\"window.open('add_update_holiday.php','".translate('add holiday')."', 'width=400,height=425,top=100,left=100,scrollbars=no,toolbar=no,location=no'); return false\">".translate('add holiday')."</a></div>"; //echo add holiday link


// }

// else{
	// echo translate('Sorry, you are not allowed to access this page.');
// }	


echo "	<script>
		function Show(id) {
			document.getElementById(id).style.display = 'inline-block';
		}
		function Hide(id) {
			document.getElementById(id).style.display = 'none';
		}
		</script>";
	
// include 'footer.php';

?>