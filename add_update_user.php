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



if (isset($_GET["user_id"]))
	$user_id= $_GET['user_id'];
else 
	$user_id="";

if (($_SESSION['user_id'] == $user_id) || ($_SESSION['group_id'] == 2)){
	
if ($user_id != ""){
	$sql = $mysql->prepare("SELECT * FROM $almanak_users WHERE user_id=? "); 
	$sql->execute([$user_id]);
	
	if ($row = $sql->fetch(PDO::FETCH_ASSOC)){ 
		$username = $row['username'];
		$password = $row['password'];
		$password_old  = $row['password'];
		$description = $row['description'];
		$group_id = $row['group_id'];
	}
}
else {
	$username = "";
	$password = "";
	$password_old = "";
	$description = "";
	$group_id = "";
}


	
if ( isset($_POST["submit"])){
	$username = $_POST["username"];
	$description = nl2br($_POST["description"]);
	if ( $_SESSION['group_id'] == 2)	
		$group_id = $_POST["group_id"];
	if ( ($_POST["username"]!="") && ($_POST["password"]!="") ){
		if ( $_POST["password"] == $_POST["password_check"]){
			$password = $_POST["password"];
			if (($password_old != $_POST['password'])||($user_id=="")){
				$password = SHA1($_POST["password"]);
			}			
			
				if ($user_id==""){
					$sql = $mysql->prepare("SELECT * FROM $almanak_users WHERE username=? "); 
					$sql->execute([$username]);
						if($sql->rowCount() == 0) {
							$sql= $mysql->prepare("INSERT INTO $almanak_users (username, password, description, group_id) VALUES (?,?,?,?)");
							$sql->execute([$username, $password, $description, $group_id]);
							$succes_message = translate('the data has been added');
							}
						else{
						$error_message = translate('username already exist, please choose another one!');
						$password="";
						}
				}	
				else{
					$sql= $mysql->prepare("UPDATE $almanak_users SET username=?, password=?, description=?, group_id=? WHERE user_id=?");
					$sql->execute([$username, $password, $description, $group_id, $user_id]);
					$succes_message = translate("your data is updated");
				}
		}
		else{
			$error_message = translate('you entered two different passwords');
		}
	}
	else{
		$error_message = translate('please enter a username and a password');
	}
}

echo "<div class=\"popup_box\">";
echo "<div id=\"hide_form\">";


if ($user_id == "")
	echo "<h4>".translate('add user')."</h4>";
else
	echo "<h4>".translate('update user')."</h4>";


if ($user_id == "")
	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">\n";	
else 	
	echo "<form action=\"".$_SERVER['PHP_SELF']."?user_id=$user_id"."\" method=\"post\">\n";

echo "<p>".translate('username').":<br>";
echo "<input type=\"text\" name=\"username\" value=\"$username\" size=\"40\" ></p>\n";

echo "<p>".translate('password').":<br>";
echo "<input type=\"password\" name=\"password\" value=\"$password\" size=\"40\" ><br>\n";

echo translate('confirm password').":<br>";
echo "<input type=\"password\" name=\"password_check\" value=\"$password\" size=\"40\" ></p>\n";

echo "<p>".translate('description').":<br>";
echo "<textarea name=\"description\" rows=\"2\" cols=\"40\">".str_replace('<br />', "", $description)."</textarea></p>\n";

if ( $_SESSION['group_id'] == 2){
	echo "<p>".translate('user group').":<br>";
	echo "<select name=\"group_id\">\n";
			for ($i = 0 ; $i <= 2 ; $i++) {
				if ($i == $group_id)
					echo "<option value=\"$i\" selected>".$usergroups["$i"]."</option>\n";
				else
					echo "<option value=\"$i\">".$usergroups["$i"]."</option>\n";
		}
	echo "</select></p>";
}
	
// echo " <p><input type=\"submit\" name=\"submit\" value=\"".translate('submit')."\" class=\"btn btn-danger btn-sm btn-block\"></p>\n";
echo "<p id=\"popup_box_options\" class=\"popup_box_options\">";
echo " <input type=\"submit\" value=\" \" name=\"submit\" class=\"save_button\" title=\"".translate('opslaan')."\" /> &emsp;";
echo "&emsp;<a href=\"#\" onclick='Javascript:window.close();'><img src=\"img/application-exit-48.png\" alt=\"".translate('close')."\"   title=\"".translate('close')."\"></a></p>";
echo"</form></div>\n";

}
else {
	$error_message = translate ('Sorry, you are not allowed to access this page.'); 
}

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