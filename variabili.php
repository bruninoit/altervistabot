<?php

if ($config['funziona_nei_canali'] and isset($update["channel_post"])) {
    $update["message"] = $update["channel_post"];
    $canale = true;
}

if ($config['funziona_messaggi_modificati'] and isset($update["edited_message"])) {
    $update["message"] = $update["edited_message"];
    $editato = true;
}

if ($config['funziona_messaggi_modificati_canali'] and isset($update["edited_channel_post"])) {
    $update["message"] = $update["edited_channel_post"];
    $editato = true;
    $canale = true;
}

if (isset($update["message"])) {
    $chatID = $update["message"]["chat"]["id"];
    $userID = $update["message"]["from"]["id"];
    $msg = $update["message"]["text"];
    $username = $update["message"]["from"]["username"];
    $nome = $update["message"]["from"]["first_name"];
    $cognome = $update["message"]["from"]["last_name"];
    $voice = $update["message"]["voice"]["file_id"];
    $photo = $update["message"]["photo"][0]["file_id"];
    $document = $update["message"]["document"]["file_id"];
    $audio = $update["message"]["audio"]["file_id"];
    $sticker = $update["message"]["sticker"]["file_id"];
    if ($chatID < 0) {
        $titolo = $update["message"]["chat"]["title"];
        $usernamechat = $update["message"]["chat"]["username"];
    }
}

//tastiere inline
if (isset($update["callback_query"])) {
    $cbid = $update["callback_query"]["id"];
    $cbdata = $update["callback_query"]["data"];
    $cbmid = $update["callback_query"]["message"]["message_id"];
    $chatID = $update["callback_query"]["message"]["chat"]["id"];
    $userID = $update["callback_query"]["from"]["id"];
    $nome = $update["callback_query"]["from"]["first_name"];
    $cognome = $update["callback_query"]["from"]["last_name"];
    $username = $update["callback_query"]["from"]["username"];
    $msg = $cbdata;
}
