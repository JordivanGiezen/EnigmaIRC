<?php
namespace Enigma;
use \Enigma\modules as module;
use \Enigma\multithreading as multithread;

class brain {
	#Supplementary functions
	static function isSafe($host) { return in_array($host, self::$safelist); }
	
	static $spam = array("last" => 0, "count" => 1);
	static function spamcontrol(&$cmd) {
		//we need to make sure we don't trigger the server's flood protection
		//setting a command limit of a thousand
		if(strlen($cmd) >= 1000) {
			debug("A command was too big to send.", "irc", "error");
			$cmd = substr($cmd, 0, 1000);
		}

		//delay consecutive messages significantly
		if(self::$spam["last"] == time()) {
			self::$spam["count"]++;
			if(self::$spam["count"] > 10) { sleep(1); self::$spam["last"] = time() + 1; }
			elseif(self::$spam["count"] > 20) { sleep(2); self::$spam = array("last" => 0, "count" => 1); }
		} else self::$spam = array("last" => time(), "count" => 1);

		//prepare to send
		$cmd .= "\r\n";
	}

	#Events
	static function onCommand($args) {
		$nick = $args[1]; $host = $args[2];
		$target = ($args[3] == nick ? $nick : $args[3]);
		$rawcomm = explode(" ", trim(str_replace(chr(15), "", $args[4])));
		$command = $rawcomm[0]; array_shift($rawcomm);
		$args = implode(" ", $rawcomm);
		module::event("onCommand", $nick, $host, $target, $args, $command);
	}

	static function onMessage($args) {
		$nick = $args[1]; $host = $args[2]; $message = $args[4];
		$target = ($args[3] == nick ? $nick : $args[3]);
		module::event("onMessage", $nick, $host, $target, $message);
	}

	static function onJoin($nick, $host, $channel) {
		if($nick == nick) {
			debug("Successfully joined: ".$channel, "irc");
			self::$userlist[$channel] = array();
			self::write("WHO " . $channel);
		} else {
			self::$userlist[$channel][] = array($nick, $host);
			module::event("onJoin", $nick, $host, $channel);
		}
	}

	static function onPart($nick, $host, $channel) {
		if($nick == nick) { unset(self::$userlist[$channel]); return; }
		$key = array_search(array($nick, $host), self::$userlist[$channel]);
		unset(self::$userlist[$channel][$key]);
		module::event("onPart", $nick, $host, $channel);
	}

	static function onNick($previousNick, $host, $newNick) {
		foreach(self::$userlist as $channel=>$users) {
			$key = array_search(array($previousNick, $host), self::$userlist[$channel]);
			if($key !== false) {
				self::$userlist[$channel][$key] = array(trim($newNick), $host);
				module::event("onNick", $newNick, $host, $channel, $previousNick);
			}
		}
	}

	static function onKick($channel, $kickedNick) {
		foreach(self::$userlist[$channel] as $key=>$user)
			if($kickedNick == $user[0])
				self::onPart($user[0], $user[1], $channel);
	}

	static function onQuit($nick, $host) {
		foreach(self::$userlist as $channel=>$users) {
			$key = array_search(array($nick, $host), self::$userlist[$channel]);
			if($key !== false) self::onPart($nick, $host, $channel);
		}
	}

	static function onNicklist($channel, $nicklist, $end=false) {
		if(!$end) {
			preg_match("/(~?)[^ ]+ ([^ ]+) [^ ]+ ([^ ]+)/", $nicklist, $args);
			if($args[3] != nick) self::onJoin($args[3], $args[2], $channel);
		} else module::event("onNicklist", $channel);
	}

	static function onInviteOnly($channel) {
		debug("Requesting invite to channel: ".$channel, "irc");
		self::message("INVITE ".$channel, "ChanServ");
		self::joinchan($channel);
	}

	static function onConnect() {
		debug("Connected.", "irc");
		self::message("IDENTIFY Tibot CAM90", "NickServ");
		self::$channels = unserialize(channels);
		foreach(self::$channels as $channel)
			self::joinchan($channel);
	}

	#Core functions
	static $buffer, $socket, $userlist, $safelist, $channels;
	static function start() { self::$safelist = unserialize(safelist); self::socketCreate(); self::connect(); self::listen(); }
	static function socketCreate() { self::$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); self::socketConnect(); }
	static function socketConnect() { debug("Connecting.", "irc", "start"); socket_connect(self::$socket, hostname, port); }
	static function listen() { while(self::$buffer = @socket_read(self::$socket, 1024, PHP_NORMAL_READ)) { self::read(self::$buffer); } }
	static function write($cmd) { debug($cmd, "irc", "output"); self::spamcontrol($cmd); socket_write(self::$socket, $cmd); }
	static function read($buffer) { debug($buffer, "irc", "input"); self::parse($buffer); }
	static function connect() { self::write("PASS NOPASS"); self::write("NICK " . nick); self::write("USER Enigma - Artificial Intelligence"); }
	static function disconnect() { self::write("QUIT"); debug("Disconnecting.", "irc"); }
	static function joinchan($channel) { if(!strstr($channel, "#")) $channel = "#".$channel; self::write("JOIN ".$channel); }
	static function message($message, $target=null) { $target=$target?$target:channel; self::write("PRIVMSG ".$target." :".$message); }
	static function notice($message, $target) { self::write("NOTICE ".$target." :".$message); }
	static function mode($mode, $user, $channel) { self::write("MODE ".$channel." ".$mode." ".$user); }
	static function op($nick, $channel=null) { $channel=$channel?$channel:channel; self::mode("+o", $nick, $channel); }
	static function deop($nick, $channel=null) { $channel=$channel?$channel:channel; self::mode("-o", $nick, $channel); }
	static function voice($nick, $channel=null) { $channel=$channel?$channel:channel; self::mode("+v", $nick, $channel); }
	static function devoice($nick, $channel=null) { $channel=$channel?$channel:channel; self::mode("-v", $nick, $channel); }
	static function parse($buffer) {
		if(!ignorebuffer) multithread::checkBuffer();
		if(preg_match("/^PING :([0-9]{9,10}|)/", $buffer, $pingcode)) self::write("PONG :" . $pingcode[1]);
		if(preg_match("/^:irc.barafranca.com (422|376)/", $buffer)) self::onConnect();
		if(preg_match("/^:irc.barafranca.com 352 ".nick." (#[^ ]+) (.+)/", $buffer, $args)) self::onNicklist($args[1], $args[2]);
		if(preg_match("/^:irc.barafranca.com 315 ".nick." (#[^ ]+)/", $buffer, $args)) self::onNicklist($args[1], null, true);
		if(preg_match("/^:irc.barafranca.com 473 ".nick." (#[^ ]+)/", $buffer, $args)) self::onInviteOnly($args[1]);
		if(preg_match("/^:([^@ !]+)![^@ ]+@([^ ]+) QUIT :/", $buffer, $args)) self::onQuit($args[1], $args[2]);
		if(preg_match("/^:([^@ !]+)![^@ ]+@([^ ]+) NICK ([^\r\n]+)/", $buffer, $args)) self::onNick($args[1], $args[2], $args[3]);
		if(preg_match("/^:([^@ !]+)![^@ ]+@([^ ]+) KICK (#[^ ]+) ([^ ]+) :/", $buffer, $args)) self::onKick($args[3], $args[4]);
		if(preg_match("/^:([^@ !]+)![^@ ]+@([^ ]+) JOIN :(#[^\r\n]+)/", $buffer, $args)) self::onJoin($args[1], $args[2], $args[3]);
		if(preg_match("/^:([^@ !]+)![^@ ]+@([^ ]+) PART (#[^\r\n]+)/", $buffer, $args)) self::onPart($args[1], $args[2], $args[3]);
		if(preg_match("/^:([^@ !]+)![^@ ]+@([^ ]+) PRIVMSG (".nick."|#[^ ]+) :([^".commchar."].*)/", $buffer, $args)) self::onMessage($args);
		if(preg_match("/^:([^@ !]+)![^@ ]+@([^ ]+) PRIVMSG (".nick."|#[^ ]+) :". commchar."(\w[^\r\n]*)/", $buffer, $args)) self::onCommand($args);
	}
}
?>