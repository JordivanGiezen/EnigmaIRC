<?php
namespace Enigma\modules\fun;
use \Enigma\brain as enigma;

class main {
	#Implementation
	static $conditions = array(
		"commands" => "ty4bo, tybo, bo, bos"
	);

    function onCommand($nick, $host, $target, $args, $command) {
		if(!$args) $args = \Enigma\nick;
		switch($command) {
			case "ty4bo":
			case "tybo":
				if($args == \Enigma\nick) { enigma::message(self::color("nick", $nick) . self::color("msg", " is thankful for the bustout!"), $target); }
				else { enigma::message(self::color("nick", $nick) . self::color("msg", " thanks ") . self::color("nick", $args) . self::color("msg", " for the bustout!"), $target); }
				break;
			case "bo": enigma::message(self::color("nick", $nick) . self::color("msg", " needs to be busted out of jail!")); break;
			case "bos":
				if($args == \Enigma\nick) { enigma::message(self::color("nick", $nick) . self::color("msg", " successfully got someone out of jail!"), $target); }
				else { enigma::message(self::color("nick", $nick) . self::color("msg", " successfully got ") . self::color("nick", $args) . self::color("msg", " out of jail!"), $target); }
				break;
		}
	}

	#Custom
	function color($tipo, $msg) {
		switch($tipo) {
			case "nick": return "13,1" . $msg . "";
			case "msg": return "7,1" . $msg . "";
		}
	}
}
?>