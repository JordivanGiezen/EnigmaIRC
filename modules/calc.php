<?php
namespace Enigma\modules\calc;
use \Enigma\brain as enigma;

class main {
	#Implementation
	static $conditions = array(
		"commands" => "calc",
		"safe" => true
	);

	function onCommand($nick, $host, $target, $args, $command) {
		enigma::message(eval("return " . $args . ";"), $target);
	}
}
?>