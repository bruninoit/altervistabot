<?php

//comandi del bot


if ($msg == "/start") {
    sm($chatID, "Il Bot funziona!
Tastiera normale: /tastiera
Tastiera inline: /itastiera
Iscritti: /iscritti
Feedback: /feedback
Foto: /foto");
}

//tastiera normale

if ($msg == "/tastiera") {
    $menu[] = array(
        "voce 1"
    );
    $menu[] = array(
        "voce 2",
        "voce 3"
    );
    $menu[] = array(
        "voce 5"
    );


    $text = "Tastiera normale.
Nascondi tastiera: /nascondi";
    sm($chatID, $text, $menu, '', false, false, false);
}

if ($msg == "/nascondi") {
    $text = "Tastiera Nascosta.";
    sm($chatID, $text, 'nascondi');
}

//tastiera inline

if ($msg == "/itastiera") {
    $menu[] = array(
        array(
            "text" => "bottone1",
            "callback_data" => "/test1"
        ),
        array(
            "text" => "bottone2",
            "callback_data" => "/test2"
        )
    );
    $menu[] = array(
        array(
            "text" => "bottone3",
            "callback_data" => "/test3"
        )
    );
    sm($chatID, "Tastiera inline.", $menu, 'Markdown', false, false, true);
}


//funzionamento bottoni tastiera

if ($msg == "/test1") {
    cb_reply($cbid, "NOTIFICA TIPO 1", false);
}

if ($msg == "/test2") {
    cb_reply($cbid, "NOTIFICA TIPO 2", true);
}

if ($msg == "/test3") {
    cb_reply($cbid, "NOTIFICA TIPO 1", false, $cbmid, "Messaggio Modificato");
}


//foto

if ($msg == "/foto") {
    si($chatID, "foto.jpg", false, "questa è la didascalia");
}
	
	
	
