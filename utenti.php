<?php

echo "<br>Plugin Utenti 1.0";

//iscritti
if (strpos($msg, "/iscritti") === 0 and $userID == $adminID) {
    $qcp = mysql_query("select * from $tabella where not page = 'disable' and chat_id>0 group by chat_id");
    $qcg = mysql_query("select * from $tabella where not page = 'disable' and chat_id<0 group by chat_id");
    $cp = mysql_num_rows($qcp);
    $cg = mysql_num_rows($qcg);

    //morti
    $mqcp = mysql_query("select * from $tabella where page = 'disable' and chat_id>0 group by chat_id");
    $mqcg = mysql_query("select * from $tabella where page = 'disable' and chat_id<0 group by chat_id");
    $mcp = mysql_num_rows($mqcp);
    $mcg = mysql_num_rows($mqcg);


    $iscritti = "🔈*ISCRITTI AL BOT*";
    $iscritti .= "\n  👤 Chat Private: $cp";
    $iscritti .= "\n  👥 Chat Gruppi: $cg";

    $iscritti .= "\n\n🔇*MORTI*";
    $iscritti .= "\n  👤 Chat Private: $mcp";
    $iscritti .= "\n  👥 Chat Gruppi: $mcg";

    sm($chatID, $iscritti, false, 'Markdown');
}


//post globali
if (strpos($msg, "/post") === 0 and $adminID == $chatID) {
    $t = [
        [
            [
                "text"          => "馃懁 Utenti",
                "callback_data" => "/2post 1"
            ],
            [
                "text"          => "Gruppi 馃懃",
                "callback_data" => "/2post 2"
            ]
        ],
        [
            [
                "text"          => "馃懁 Utenti e Gruppi 馃懃",
                "callback_data" => "/2post 3"
            ]
        ]
    ];
    sm($chatID, "Ok $nome, dove vuoi inviare il messaggio globale?

_Se selezioni gruppi, invia anche nei canali conosciuti._", $t, 'Markdown', false, false, true);
}


if (strpos($msg, "/2post") === 0 and $adminID == $chatID) {
    $campo = explode(" ", $msg);
    mysql_query("update $tabella set page = 'post $campo[1]' where chat_id = $chatID");

    $t = [
        [
            [
                "text"          => "鉂� Annulla",
                "callback_data" => "/apostannulla"
            ]
        ]
    ];

    cb_reply($cbid, "Ok!", false, $cbmid, "Ok $nome, invia ora il post globale che vuoi inviare.
Formattazione: " . $config['formattazione_messaggi_globali'], $t);
}


if (strpos($msg, "/apostannulla") === 0 and $adminID == $chatID) {
    cb_reply($cbid, "Ok!", false, $cbmid, "Invio Post annullato");
    mysql_query("update $tabella set page = '' where chat_id = $chatID");
    exit;
}


if (strpos($u['page'], "post") === 0) {
    if ($msg) {
        //eseguo
        $s = explode(" ", $u['page']);
        $achi = $s[1];

        if ($achi == 1) {
            $q = "where chat_id>0";
        }
        if ($achi == 2) {
            $q = "where chat_id<0";
        }
        if ($achi == 3) {
            $q = " where 1";
        }
        sm($chatID, "Post in viaggio verso gli utenti.");

        //salvo post in file
        $file = "lastpost.json";
        $f2 = fopen($file, 'w');
        fwrite($f2, $msg);
        fclose($f2);

        //invio
        $s = mysql_query("select * from $tabella $q group by chat_id");
        mysql_query("update $tabella set page = '' where chat_id = $chatID");
        mysql_query("update $tabella set page = 'inviapost' $q");
        while ($b = mysql_fetch_assoc($s)) {
            if (sm($b[chat_id], $msg, false, $config['formattazione_messaggi_globali'])) {
                mysql_query("update $tabella set page = '' where chat_id = $b[chat_id]");
            } else {
                mysql_query("update $tabella set page = 'disable' where chat_id = $b[chat_id]");
            }
        }
    } else {
        sm($chatID, "Solo messaggi testuali.");
    }
}


//post out loop
$text = file_get_contents("lastpost.json");
$s = mysql_query("select * from $tabella $q where page = 'inviapost' group by chat_id limit 0,5");
while ($b = mysql_fetch_assoc($s)) {
    mysql_query("update $tabella set page = '' where chat_id = $b[chat_id]");
    if (sm($b[chat_id], $msg, false, $config['formattazione_messaggi_globali'])) {
        mysql_query("update $tabella set page = '' where chat_id = $b[chat_id]");
    } else {
        mysql_query("update $tabella set page = 'disable' where chat_id = $b[chat_id]");
    }
}


//ban unban dal bot

if (strpos($msg, "/ban ") === 0 and $adminID == $chatID) {
    $campo = explode(" ", $msg);
    mysql_query("update $tabella set page = 'ban' where chat_id = \"$campo[1]\" or username = \"" . str_replace("@", "",
            $campo[1]) . "\"");
    sm($chatID, "Ho bannato $campo[1] dal bot");
}

if (strpos($msg, "/unban ") === 0 and $adminID == $chatID) {
    $campo = explode(" ", $msg);
    mysql_query("update $tabella set page = '' where chat_id = \"$campo[1]\" or username = \"" . str_replace("@", "",
            $campo[1]) . "\"");
    sm($chatID, "Ho sbannato $campo[1] dal bot");
}
