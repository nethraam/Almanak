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
include 'check_login.php';
include 'functions.php';
include 'arrays_and_settings.php';


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
	<link rel="stylesheet" href="menu.css">

<script>
$(function() {
	var url = window.location.href;
	var filename = url.split('/').pop().split('#')[0].split('?')[0];
	$('#menu a[href$="' + filename + '"]').parent().attr('class', 'active');
});
</script>
	
</head>

<body>
<div id="wrapper">


