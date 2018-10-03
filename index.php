<?php

isset($_GET['api']) ? $api = $_GET['api'] : exit;
isset($_GET['admin']) ? $adminID = $_GET['admin'] : exit;
isset($_GET['userbot']) ? $userbot = $_GET['userbot'] : exit;

$content = file_get_contents("php://input");
$update = json_decode($content, true);


//non toccare
require 'class-http-request.php';
require 'functions.php';
require 'database.php';
require '_config.php';
//per l'utente
include '_comandi.php';
include 'utenti.php';
include 'feedback.php';
include 'inline.php';
include 'gruppi.php';


//creo un file input.json in cui salvo l'ultima chiamata inviata a me
$file = "input.json";
$f2 = fopen($file, 'w');
fwrite($f2, $content);
fclose($f2);

