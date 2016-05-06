<?php
namespace Enigma;

function debug($msg, $type=null, $arg=false) {
	$msg = trim($msg); if(!$msg) return; else $msg .= "\n";
	$now = date("H:i:s")." ";
	switch($type) {
		case "fatal":
			echo $now . ($arg?$arg:"[---]") . " FATAL ERROR: " . $msg;
			exit();

		case "irc":
			$irclog = __DIR__ . "/irclog.txt";
			switch($arg) {
				case "input": file_put_contents($irclog, $now . "[<<] " . $msg, FILE_APPEND); break;
				case "output": file_put_contents($irclog, $now . "[>>] " . $msg, FILE_APPEND); break;
				case "start": echo $now . "[IRC] " . $msg; unlink($irclog); break;
				case "error": echo $now . "[IRC] ERROR: " . $msg;
				default: echo $now . "[IRC] " . $msg;
			} break;

		case "module":
			if(!$arg) echo $now . "[MOD] " . $msg;
			else echo $now . "[MOD] ERROR: " . $msg;
			break;

		case "mysql":
			if(!$arg) echo $now . "[SQL] " . $msg;
			else echo $now . "[SQL] ERROR: ";
			break;

		default: echo $now . "=> " . $msg;
	}
}
?>