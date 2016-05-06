<?php
namespace Enigma\modules\code;
use \Enigma\brain as enigma;

class main {
	#Implementation
	static $conditions = array(
		"commands" => "code",
		"safe" => true
	);

	function onCommand($nick, $host, $target, $args, $command) {
		enigma::message(eval($args), $target);
	}
}
?>