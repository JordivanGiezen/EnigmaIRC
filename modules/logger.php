<?php
namespace Enigma\modules\logger;
use \Enigma\brain as enigma;
use \Enigma\mysql as sql;

class main {
	#Implementation
	static $conditions = array(
		"safe" => true
	);

	function onMessage($nick, $host, $target, $message) {
		//check if the logger is activated for this channel
		if(!in_array($target, self::$logger)) return;

		//insert a new message with the list of everyone that saw the message
		$hostlist = array();
		foreach(enigma::$userlist[$target] as $user) $hostlist[] = $user[1];
		sql::insert("enigma_logs", array(null, $target, $nick, $message, date("y-m-d@H:i"), implode(",", $hostlist), null));

		//if this is not the main channel, send the message there and log as part of it
		if($target != \Enigma\channel) {
			$date = date("y-m-d@H:i"); $hostlist = array();
			foreach(enigma::$userlist[\Enigma\channel] as $user) $hostlist[] = $user[1];
			sql::insert("enigma_logs", array(null, \Enigma\channel, $nick, $message, $date, implode(",", $hostlist), $target));
			enigma::message("10[".$target."] ".$date." »» 7".$nick."10: ".$message, \Enigma\channel);
		}
	}

	function onJoin($nick, $host, $target) {
		//check if the user who joined has messages pending
		$entries = sql::search("enigma_logs", "WHERE channel = '".$target."' AND seenby NOT LIKE '%".$host."%'");
		if($entries) {
			$log = array();
			foreach($entries as $entry) {
				$log[] = "10".($entry['spiedfrom']?("[".$entry['spiedfrom']."] "):"").$entry['date']." »» 7".$entry['nickname']."10: ".$entry['message'];
				$seenby = explode(",", $entry['seenby']);
				$seenby[] = $host;
				sql::update("enigma_logs", "seenby", implode(",", $seenby), "WHERE id='".$entry['id']."'");
			} foreach($log as $message) enigma::message($message, $target);
		}
	}

	function onNicklist($channel) {
		//activate channel for logging when we get the entire nicklist for it
		self::$logger[] = $channel;
	}

	#Custom
	static $logger = array();
}
?>