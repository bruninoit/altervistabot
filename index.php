<?php
	
	require 'class-http-request.php';
	
	$api     = $_GET['api'];
	$idadmin = $_GET['admin'];
	$adminID = $idadmin;
	$userbot = $_GET['userbot'];
	
	
	$content = file_get_contents("php://input");
	$update  = json_decode($content, true);
	
	
	require '_config.php';
	require '_comandi.php';
	
	
	
	foreach ($plugins as $plugin => $active) {
					if ($active)
									include($plugin);
	}
	
	
	
	
	
	//creo un file input.json in cui salvo l'ultima chiamata inviata a me
	
	$file = "input.json";
	$f2   = fopen($file, 'w');
	fwrite($f2, $content);
	fclose($f2);
	
	
	
?>
