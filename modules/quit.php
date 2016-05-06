<?php
namespace Enigma\modules\quit;
use \Enigma\brain as enigma;

class main {
	#Implementation
	static $conditions = array(
		"commands" => "quit",
		"host" => true
	);

	function onCommand($nick, $host, $target, $args, $command) {
		enigma::message("See ya*", $target);
		enigma::disconnect();
	}
}
?>