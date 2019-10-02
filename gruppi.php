<?php

/*
PLUGIN GRUPPI
Versione 3.0
*/
echo "<br>Plugin Gruppi: 3.0";

$replyID = $update["message"]["reply_to_message"]["from"]["id"];
$replyNome = $update["message"]["reply_to_message"]["from"]["first_name"];


//lasciare questo codice immutato
$args = array(
'chat_id' => $chatID
);
$add = new HttpRequest("get", "https://api.telegram.org/$api/getChatAdministrators", $args);
$ris = $add->getResponse();
$admins = json_decode($ris, true);
foreach($admins['result'] as $adminsa)
{
if($adminsa['user']['id'] == $userID)
$isadmin = true;

if($adminsa["user"]["id"] == $userID and $adminsa["status"]=="creator")
$isfounder=true;
}


/*
Nelle condizioni if sarà possibile mettere 
$isadmin per verificare che solo gli Admin
possano usare tale comando.

esempio

if(strpos(....) and $isadmin)
{
sm();
//altri comandi
}
*/



//lista Admin
if(strpos(" ".$msg, "/admins"))
{
$shish = "Admin:";
foreach($admins[result] as $ala)
{
if($ala[status] == "creator")
{
$shish .= "
@".$ala[user][username]." [FONDATORE]";
}else{
$shish .= "
@".$ala[user][username];
}
}
sm($chatID, $shish);
}




if($update["message"]["new_chat_member"])
{
$nome = $update["message"]["new_chat_member"]["first_name"];
$username = $update["message"]["new_chat_member"]["username"];
$id = $update["message"]["new_chat_member"]["id"];

$text = "Ciao $nome @$username $id, benvenuto nel gruppo. Per vedere le regole premi /regole";
sm($chatID, $text);
}


if($update["message"]["left_chat_member"])
{
$nome = $update["message"]["left_chat_member"]["first_name"];
$username = $update["message"]["left_chat_member"]["username"];
$id = $update["message"]["left_chat_member"]["id"];

$text = "Arrivederci $nome @$username $id.";
sm($chatID, $text);
}

if($update["message"]["new_chat_title"])
{
$nuovo_nome = $update["message"]["new_chat_title"];

$text = "Nuovo nome gruppo: $nuovo_nome";
sm($chatID, $text);
}



if(strpos($msg, "/ban")===0 and $isadmin)
{
if($replyID)
{
sm($chatID, "Ho bannato $replyNome.");
ban($chatID, $replyID);
}
}

if(strpos($msg, "/kick")===0 and $isadmin)
{
if($replyID)
{
sm($chatID, "Ho kickato $replyNome.");
ban($chatID, $replyID);
unban($chatID, $replyID);
}
}

if(strpos($msg, "/unban")===0 and $isadmin)
{
if($replyID)
{
sm($chatID, "Ho sbannato $replyNome.");
unban($chatID, $replyID);
}
}




?>