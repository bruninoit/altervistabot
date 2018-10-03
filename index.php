<?php

require 'class-http-request.php';

if (isset($_GET['api']) and ctype_digit($_GET['api'])) {
    $api = $_GET['api'];
} else {
    exit;
}
if (isset($_GET['admin']) and ctype_digit($_GET['admin'])) {
    $adminID = $_GET['admin'];
} else {
    exit;
}
if (isset($_GET['userbot']) and ctype_digit($_GET['userbot'])) {
    $userbot = $_GET['userbot'];
} else {
    exit;
}

$content = file_get_contents("php://input");
$update = json_decode($content, true);


require '_config.php';
require '_comandi.php';


foreach ($plugins as $plugin => $active) {
    if ($active) {
        include($plugin);
    }
}


//creo un file input.json in cui salvo l'ultima chiamata inviata a me

$file = "input.json";
$f2 = fopen($file, 'w');
fwrite($f2, $content);
fclose($f2);

