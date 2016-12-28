<?php
	
	
	//configurazioni
	$config = array(
					
					"formattazione_predefinita" => "HTML",
					//o "Markdown" o "" per nulla
					
					
					"formattazione_messaggi_globali" => "HTML",
					
					
					
					"nascondi_anteprima_link" => true,
					
					
					"tastiera_predefinita" => "inline",
					//metti "normale" per mettere le tastiere vecchie
					
					
					"funziona_nei_canali" => true,
					"funziona_messaggi_modificati" => true,
					"funziona_messaggi_modificati_canali" => true
					
					
	);
	
	
	//non toccare
	require 'functions.php';
	
	
	
	//plugins
	
	$plugins = array(
					
					"inline.php" => true,
					"gruppi.php" => true,
					"feedback.php" => true,
					"utenti.php" => true
					
	);
	
	
	
	
