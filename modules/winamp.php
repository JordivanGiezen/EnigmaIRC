<?php
namespace Enigma\modules\winamp;
use \Enigma\brain as enigma;

class main {
	#Implementation
	static $conditions = array(
		"commands" => "winamp"
	);

	function onCommand($nick, $host, $target, $args, $command) {
		switch($args) {
			case "stop": exec('"'.$this->winamp.'" /stop'); break;
			case "pause": exec('"'.$this->winamp.'" /pause'); break;
			case "play": exec('"'.$this->winamp.'" /play'); $this->sendTitle($target); break;
			case "next": exec('"'.$this->winamp.'" /next'); $this->sendTitle($target); break;
			case "prev": exec('"'.$this->winamp.'" /prev'); $this->sendTitle($target); break;
			case "title": $this->sendTitle($target); break;
		}
	}

	#Custom
	private $winamp = "C:\Program Files (x86)\Winamp\CLAmp.exe";
	function sendTitle($target) {
		$title = exec('"'.$this->winamp.'" /title');
		enigma::message("Playing: ".$title, $target);
	}
}
?>