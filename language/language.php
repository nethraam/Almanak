<?php
	$languages = [('English'), ('Nederlands'), ('Français')];
	
	$name = 'language';
	$sql = $mysql->prepare("SELECT * FROM $almanak_settings WHERE name=?"); 
	$sql->execute([$name]);

	if ($row = $sql->fetch(PDO::FETCH_ASSOC)){ 
		$id = $row['id'];
		$value = $row['value'];
	}
	

	switch (strtolower($value)) {
		
	case "nederlands": include 'nl.php'; break; 
	case "english": include 'en.php'; break; 
	case strtolower("français"): include 'fr.php'; break; 
	
	default: include 'en.php';
	}
?>