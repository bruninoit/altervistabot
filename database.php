<?php
	
	echo "<br>Plugin Database: 2.0";
	
	
	if ($_GET['install'] and $_GET['userbot']) {
					$url = explode(".", $_SERVER["HTTP_HOST"]);
					$dir = dirname($_SERVER["PHP_SELF"]);
					$dir = substr($dir, 1);
					$dbh = new PDO("mysql:host=localhost;dbname=my_" . $url[0], $url[0], "");
					$dbh->query("CREATE TABLE IF NOT EXISTS " . $_GET['userbot'] . " (
id int(0) AUTO_INCREMENT,
chat_id bigint(0),
username varchar(200),
page varchar(200),
PRIMARY KEY (id))");
					echo "<br>HO INSTALLATO IL DATABASE";
	}
	
	
	$ex       = explode(".", $_SERVER['SERVER_NAME']);
	$nomesito = $ex[0];
	mysql_select_db("my_" . $nomesito);
	$tabella = $userbot;
	
	if ($chatID) {
					$q = mysql_query("select * from $tabella where chat_id = $chatID");
					if (!mysql_num_rows($q)) {
									mysql_query("insert into $tabella (chat_id, page, username) values ($chatID, '', \"" . $username . "\")");
					} else {
									$u = mysql_fetch_assoc($q);
									
									if ($u['page'] == "disable") {
													mysql_query("update $tabella set page = '' where chat_id = $chatID");
									}
									if ($u['page'] == "ban") {
													sm($chatID, "Sei bannato dall'utilizzo del Bot.");
													exit;
									}
					}
	}
