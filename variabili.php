<?php

$canale = false;
$editato = false;

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
    $chatID = isset($update["message"]["chat"]["id"]) ? $update["message"]["chat"]["id"] : false;
    $userID = isset($update["message"]["from"]["id"]) ? $update["message"]["from"]["id"] : false;
    $msg = isset($update["message"]["text"]) ? $update["message"]["text"] : false;
    $username = isset($update["message"]["from"]["username"]) ? $update["message"]["from"]["username"] : false;
    $nome = isset($update["message"]["from"]["first_name"]) ? $update["message"]["from"]["first_name"] : false;
    $cognome = isset($update["message"]["from"]["last_name"]) ? $update["message"]["from"]["last_name"] : false;

    if (isset($update["message"]["photo"]) and is_array($update["message"]["photo"])) {
        $photo = isset(end($update["message"]["photo"])["file_id"]) ? end($update["message"]["photo"])["file_id"] : false;
    } else {
        $photo = false;
    }
    $voice = isset($update["message"]["voice"]["file_id"]) ? $update["message"]["voice"]["file_id"] : false;
    $document = isset($update["message"]["document"]["file_id"]) ? $update["message"]["document"]["file_id"] : false;
    $audio = isset($update["message"]["audio"]["file_id"]) ? $update["message"]["audio"]["file_id"] : false;
    $sticker = isset($update["message"]["sticker"]["file_id"]) ? $update["message"]["sticker"]["file_id"] : false;

    $replyText = isset($update["message"]["reply_to_message"]["text"]) ? $update["message"]["reply_to_message"]["text"] : false;

    if ($chatID < 0) {
        $titolo = isset($update["message"]["chat"]["title"]) ? $update["message"]["chat"]["title"] : false;
        $usernamechat = isset($update["message"]["chat"]["username"]) ? $update["message"]["chat"]["username"] : false;
    }
}

//tastiere inline
if (isset($update["callback_query"])) {
    $cbid = isset($update["callback_query"]["id"]) ? $update["callback_query"]["id"] : false;
    $cbdata = isset($update["callback_query"]["data"]) ? $update["callback_query"]["data"] : false;
    $cbmid = isset($update["callback_query"]["message"]["message_id"]) ? $update["callback_query"]["message"]["message_id"] : false;
    $chatID = isset($update["callback_query"]["message"]["chat"]["id"]) ? $update["callback_query"]["message"]["chat"]["id"] : false;
    $userID = isset($update["callback_query"]["from"]["id"]) ? $update["callback_query"]["from"]["id"] : false;
    $nome = isset($update["callback_query"]["from"]["first_name"]) ? $update["callback_query"]["from"]["first_name"] : false;
    $cognome = isset($update["callback_query"]["from"]["last_name"]) ? $update["callback_query"]["from"]["last_name"] : false;
    $username = isset($update["callback_query"]["from"]["username"]) ? $update["callback_query"]["from"]["username"] : false;
    $msg = $cbdata;
}

//inline mode
if (isset($update["inline_query"])) {
    $inline = isset($update["inline_query"]["id"]) ? $update["inline_query"]["id"] : false;
    $msg = isset($update["inline_query"]["query"]) ? $update["inline_query"]["query"] : false;
    $userID = isset($update["inline_query"]["from"]["id"]) ? $update["inline_query"]["from"]["id"] : false;
    $username = isset($update["inline_query"]["from"]["username"]) ? $update["inline_query"]["from"]["username"] : false;
    $name = isset($update["inline_query"]["from"]["first_name"]) ? $update["inline_query"]["from"]["first_name"] : false;
}