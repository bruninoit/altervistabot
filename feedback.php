<?php

echo "<br>Plugin Feedback: 2.0";


$admin_list = array(
$adminID, //questo lascialo
14924659,
);
//aggiungi altri eventuali admin


$replyText = $update["message"]["reply_to_message"]["text"];

if(strpos($msg, "/feedback")===0 and $chatID>0)
{
$e = explode(" ", $msg, 2);
$text = $e[1];

if($text)
{
foreach($admin_list as $ad)
{
sm($ad, "#Feedback

<b>Utente:</b> $nome (@$username) [$userID]

<b>Messaggio:</b> ".$text."

<i>Per rispondere, rispondi a questo messaggio</i>");
}
sm($chatID, "Grazie per il Feedback.");
}else{
sm($chatID, "Per inviare un Feedback scrivi
<code>/feedback testo da inviare</code>");
}
}

if(strpos($replyText, "#Feedback")===0 and in_array($userID, $admin_list) and $msg)
{
preg_match_all("#\[(.*?)\]#", $replyText, $nomea);
$replyToID = $nomea[1][0];

sm($replyToID, "<b>Risposta al Feedback</b>

".$msg);
sm($chatID, "Inviato.");
}

