<?php
	
	echo "Versione AltervistaBot: 3.0";
	
	
	
	
	if ($config['funziona_nei_canali']) {
		if ($update["channel_post"]) {
			$update["message"] = $update["channel_post"];
			$canale = true;
		}
	}
	
	if ($config['funziona_messaggi_modificati']) {
		if ($update["edited_message"]) {
			$update["message"] = $update["edited_message"];
			$editato = true;
		}
	}
	
	if ($config['funziona_messaggi_modificati_canali']) {
		if ($update["edited_channel_post"]) {
			$update["message"] = $update["edited_channel_post"];
			$editato           = true;
			$canale            = true;
		}
	}
	
	if(isset($update["message"])) {
		$chatID   = $update["message"]["chat"]["id"];
		$userID   = $update["message"]["from"]["id"];
		$msg      = $update["message"]["text"];
		$username = $update["message"]["from"]["username"];
		$nome     = $update["message"]["from"]["first_name"];
		$cognome  = $update["message"]["from"]["last_name"];
		if ($chatID < 0) {
			$titolo       = $update["message"]["chat"]["title"];
			$usernamechat = $update["message"]["chat"]["username"];
		}

		$voice    = $update["message"]["voice"]["file_id"];
		$photo    = $update["message"]["photo"][0]["file_id"];
		$document = $update["message"]["document"]["file_id"];
		$audio    = $update["message"]["audio"]["file_id"];
		$sticker  = $update["message"]["sticker"]["file_id"];
	}
	
	//tastiere inline
	if ($update["callback_query"]) {
		$cbid     = $update["callback_query"]["id"];
		$cbdata   = $update["callback_query"]["data"];
		$msg      = $cbdata;
		$cbmid    = $update["callback_query"]["message"]["message_id"];
		$chatID   = $update["callback_query"]["message"]["chat"]["id"];
		$userID   = $update["callback_query"]["from"]["id"];
		$nome     = $update["callback_query"]["from"]["first_name"];
		$cognome  = $update["callback_query"]["from"]["last_name"];
		$username = $update["callback_query"]["from"]["username"];
	}
	
	
	
	require 'database.php';
	
	
	
	
	function sm($chatID, $text, $rmf = false, $pm = 'pred', $dis = false, $replyto = false, $inline = 'pred')
	{
					global $api;
					global $userID;
					global $update;
					global $config;
					
					
					if ($pm == 'pred')
									$pm = $config["formattazione_predefinita"];
					
					if ($inline == 'pred') {
									if ($config["tastiera_predefinita"] == "inline")
													$inline = true;
									elseif ($config["tastiera_predefinita"] == "normale")
													$inline = false;
					}  elseif ($inline == 'inline') 
									$inline = true;
					else 
									$inline = false;
	
		
					if ($rmf == "nascondi")
									$inline = false;
					
					
					$dal = $config["nascondi_anteprima_link"];
					
					if (!$inline) {
									if ($rmf == 'nascondi') {
													$rm = array(
																	'hide_keyboard' => true
													);
									} else {
													$rm = array(
																	'keyboard' => $rmf,
																	'resize_keyboard' => true
													);
									}
					} else {
									$rm = array(
													'inline_keyboard' => $rmf
									);
					}
					$rm = json_encode($rm);
					
					$args = array(
									'chat_id' => $chatID,
									'text' => $text,
									'disable_notification' => $dis,
									'parse_mode' => $pm
					);
					if ($dal)
									$args['disable_web_page_preview'] = $dal;
					if ($replyto)
									$args['reply_to_message_id'] = $replyto;
					if ($rmf)
									$args['reply_markup'] = $rm;
					if ($text) {
									$r    = new HttpRequest("post", "https://api.telegram.org/$api/sendmessage", $args);
									$rr   = $r->getResponse();
									$ar   = json_decode($rr, true);
									$ok   = $ar["ok"]; //false
									$e403 = $ar["error_code"];
									if ($e403 == "403") {
													return false;
									} elseif ($e403) {
													return false;
									} else {
													return true;
									}
					}
	}
	
	
	function si($chatID, $img, $rmf = false, $cap = '')
	{
					global $api;
					global $userID;
					global $update;
					
					
					
					$rm = array(
									'inline_keyboard' => $rmf
					);
					$rm = json_encode($rm);
					
					
					if (strpos($img, ".")) {
									$img = str_replace("index.php", "", $_SERVER['SCRIPT_URI']) . $img;
					}
					$args = array(
									'chat_id' => $chatID,
									'photo' => $img,
									'caption' => $cap
					);
					if ($rmf)
									$args['reply_markup'] = $rm;
					$r = new HttpRequest("post", "https://api.telegram.org/$api/sendPhoto", $args);
					
					
					
					
					$rr   = $r->getResponse();
					$ar   = json_decode($rr, true);
					$ok   = $ar["ok"]; //false
					$e403 = $ar["error_code"];
					if ($e403 == "403") {
									return false;
					} elseif ($e403) {
									return false;
					} else {
									return true;
					}
	}
	
	
	
	function cb_reply($id, $text, $alert = false, $cbmid = false, $ntext = false, $nmenu = false, $npm = "pred")
	{
					global $api;
					global $chatID;
					global $config;
					
					if ($npm == 'pred')
									$npm = $config["formattazione_predefinita"];
					
					
					
					$args = array(
									'callback_query_id' => $id,
									'text' => $text,
									'show_alert' => $alert
									
					);
					$r    = new HttpRequest("get", "https://api.telegram.org/$api/answerCallbackQuery", $args);
					
					if ($cbmid) {
									if ($nmenu) {
													$rm = array(
																	'inline_keyboard' => $nmenu
													);
													$rm = json_encode($rm);
													
									}
									
									
									$args = array(
													'chat_id' => $chatID,
													'message_id' => $cbmid,
													'text' => $ntext,
													'parse_mode' => $npm
									);
									if ($nmenu)
													$args["reply_markup"] = $rm;
									$r = new HttpRequest("post", "https://api.telegram.org/$api/editMessageText", $args);
									
									
					}
	}
	
	
	function addcron($time, $msg)
	{
					global $api;
					$args = array(
									'api' => $api,
									'time' => $time,
									'msg' => $msg
					);
					$rp   = new HttpRequest("post", "https://httpsfreebot.ssl.altervista.org/bot/httpsfree/addcron.php", $args);
	}
	
	
	function ban($chatID, $userID)
	{
					global $api;
					$args = array(
									'chat_id' => $chatID,
									'user_id' => $userID
					);
					$r    = new HttpRequest("get", "https://api.telegram.org/$api/kickChatMember", $args);
					
	}
	
	function unban($chatID, $userID)
	{
					global $api;
					$args = array(
									'chat_id' => $chatID,
									'user_id' => $userID
					);
					$r    = new HttpRequest("get", "https://api.telegram.org/$api/unbanChatMember", $args);
					
	}
	
	
	
	
	
	
