<?php
namespace Enigma\modules\stream;
use \Enigma\brain as enigma;

class main {
	#Implementation
	static $conditions = array(
		"commands" => "stream"
	);

	function onCommand($nick, $host, $target, $args, $command) {
		enigma::message("Stream: http://www.nellyath.com/stream", $target);
	}
}
?>