<?php
namespace Enigma\modules\ocname;
use \Enigma\brain as enigma;

class main {
	#Implementation
	static $conditions = array(
		"commands" => "ocname"
	);

	function onCommand($nick, $host, $target, $args, $command) {
		$adjectives = explode("\n", file_get_contents("modules/adjectives"));
		$animals    = explode("\n", file_get_contents("modules/animals"));
		$word = array();
		$word[] = ucfirst($adjectives[rand(0,(count($adjectives) - 1))]);
		$word[] = ucfirst($adjectives[rand(0,(count($adjectives) - 1))]);
		$word[] = ucfirst($animals[rand(0,(count($adjectives) - 1))]);
		$word = implode("", $word);
		if($args) $city = $args; else $city = "detroit";
		enigma::message("Join: #oc.$city.$word", $target);
	}
}
?>