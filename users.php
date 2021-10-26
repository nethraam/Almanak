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



if ($_SESSION['group_id'] == '2' ){ 
	
	if (isset($_GET["delete_id"])){
	$sql = $mysql->prepare("DELETE from $almanak_users WHERE user_id=?");
	//$sql->bindparam(1, $_GET["delete_id"]);
	$sql->execute([$_GET["delete_id"]]);
	echo "<script> window.location.href = \"users.php\";</script>";
	}


	$sql = $mysql->prepare("SELECT * FROM $almanak_users"); 
	$sql->execute();
	
	
	echo "<div class=\"user_table\">";
	echo "<table class=\"user_table\">\n<tr><th class=\"td_hide\">".translate('user id')."</th><th>".translate('username')."</th><th class=\"td_hide\">".translate('description')."</th><th class=\"td_hide\">".translate('user group')."</th><th></th><th></th></tr>";
	
	foreach ($sql as $row) {
			echo "<tr><td class=\"td_hide\">".$row['user_id']."</td>\n";
			echo "<td>".$row['username']."</td>\n";
			echo "<td class=\"td_hide\">".$row['description']."</td>\n";
			echo "<td class=\"td_hide\">".$usergroups[$row['group_id']]."</td>\n";
			echo "<td><a href=\"#\" onclick=\"Show('confirm".$row['user_id']."'); return false;\"><img src=\"img/delete.png\" alt=\"".translate('delete user')."\" title=\"".translate('delete user')."\" /></a>\n";
						echo "<div id=\"confirm".$row['user_id']."\" style=\"display: none; \">";
						echo "<a href=\"#\"  onclick=\"Hide('confirm".$row['user_id']."'); return false;\"><img src=\"img/edit-undo-5.png\" alt=\"".translate('cancel')."\" title=\"".translate('cancel')."\" /></a>\n";
						echo "<a href=\"users.php?delete_id=".$row['user_id']."\" ><img src=\"img/edit-delete-6.png\" alt=\"".translate('delete')."\" title=\"".translate('delete')."\" /></a>\n";
						echo "</div></td>\n";
			echo "<td><a href=\"add_update_user.php?user_id=".$row['user_id']."\" onclick=\"window.open('add_update_user.php?user_id=".$row['user_id']."','update user', 'width=400,height=425,top=100,left=100,scrollbars=no,toolbar=no,location=no'); return false\"><img src=\"img/edit.png\" alt=\"".translate('update user')."\" title=\"".translate('update user')."\"></a></td></tr>\n";
	}
	
	echo "</table>";
	echo "</div>"	;
	echo "<div id=\"add_user\"><a class=\"btn btn-danger\" role=\"button\" href=\"add_update_user.php?\" onclick=\"window.open('add_update_user.php','".translate('add user')."', 'width=400,height=425,scrollbars=no,toolbar=no,location=no'); return false\">".translate('add user')."</a></div>"; //echo add user link

}

else{
	echo translate('Sorry, you are not allowed to access this page.');
}	

echo "	<script>
		function Show(id) {
			document.getElementById(id).style.display = 'inline-block';
		}
		function Hide(id) {
			document.getElementById(id).style.display = 'none';
		}
		</script>";
	
include 'footer.php';
?>







