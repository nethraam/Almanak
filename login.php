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


session_name("almanak");
session_start(); 

include "mysql_connect.php";
include "language/language.php";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="utf-8">
	<meta name="description" content="almanak">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<link rel="stylesheet" href="scripts/bootstrap.min.css">
	<script src="scripts/jquery.min.js"></script>
	<script src="scripts/bootstrap.min.js"></script>
	
	<link rel="stylesheet" href="almanak.css">
	
</head>

<body>

<?php



if (isset($_POST['submit'])){
	$username = $_POST['username'];
	$password = SHA1($_POST['password']);
	$_SESSION['login'] = false;
}
else{
	$username = "";
	$password = "";
}


if ($username != '' AND $password !=''){
	$sql = $mysql->prepare("SELECT * FROM $almanak_users WHERE username=? AND password=?");
	$sql->bindparam(1, $username);
	$sql->bindparam(2, $password);
	$sql->execute();
	
	if ($row = $sql->fetch(PDO::FETCH_ASSOC)){
		if ($username == $row['username'] AND $password == $row['password']){
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['password'] = $row['password'];
			$_SESSION['description'] = $row['description'];
			$_SESSION['group_id'] = $row['group_id'];
			$_SESSION['login'] = true;
		}
	}
}	


	if (isset($_SESSION['login'])){
			if ($_SESSION['login']==true){
				echo "<script> window.location.href = \"month.php\";</script>";
		}
	}



echo "<div id=\"login_form\">";

echo "<img src=\"img/almanak_300.png\" alt=\"logo\" >";

if (($username == '' AND $password =='') || $_SESSION['login'] == false){
	echo "<form action=\"login.php\" method=\"post\">";
	echo translate('username').":<br>";
	echo "<input type=\"text\" name=\"username\"><br>";
	echo translate('password').":<br>";
	echo "<input type=\"password\" name=\"password\"><br>";
	echo "<input type=\"submit\" name=\"submit\" value=\"".translate('login')."\" class=\"btn btn-danger\">";
	echo"</form>";

	
	if (isset($_POST['submit'])){
		$error_message = translate('wrong username or password');
		echo "<p id=\"error_message\"><small><small>".$error_message."</small></small></p>\n";
	}
}


echo "</div>";

?>
</body>
</html>

