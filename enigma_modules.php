<?php
namespace Enigma;
use \Enigma\brain as enigma;
use \Enigma\multithreading as multithread;

class modules {
	static $modules = array();
	static function load() {
		debug("Loading modules.", "module");
		$modules = file("modules.ini", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		foreach($modules as $module) {
			if($module[0]==";") continue;
			self::$modules[] = $module;
			require(__DIR__."/modules/".$module.".php");
		} debug("All modules loaded (" . count(self::$modules) . ").", "module");
	}

	static function event($event, $nick=false, $host=false, $target=false, $content=false, $command=false) {
		foreach(self::$modules as $name) {
			$module = "\\Enigma\\modules\\".$name."\\main";
			if(method_exists($module, $event)) {
				if(self::checkConditions($event, $module, $nick, $host, $target, $content, $command)) {
					$main = new $module;
					if(@$main->multithread) {
						debug("Sending execution of event " . $event . " for module " . $name . " to it's own thread.", "module");
						$reflection = new \ReflectionMethod($module, $event);
						$eval = implode("", array_slice(
							file($reflection->getFileName()),
							$reflection->getStartLine(),
							($reflection->getEndLine() - $reflection->getStartLine() - 1)
						)); $thread = new multithread($eval); $thread->start();
					} else {
						debug("Executing event " . $event . " for module " . $name . ".", "module");
						$main->$event($nick, $host, $target, $content, $command);
					}
				}
			}
		}
	}

	static function inString($needle, $haystack) { return in_array($needle, array_map("trim", explode(",", $haystack))); }
	static function checkConditions($event, $module, $nick, $host, $target, $content, $command) {
		if(isset($module::$conditions)) {
			if($event != "onNicklist" && @$module::$conditions["host"]) if($host != enigmahost) return false;
			if($event != "onNicklist" && @$module::$conditions["safe"]) if(!enigma::isSafe($host)) return false;
			if($event == "onMessage" && isset($module::$conditions["message"])) if(!preg_match($module::$conditions["message"], $content)) return false;
			if($event == "onCommand" && isset($module::$conditions["commands"])) if(!self::inString($command, $module::$conditions["commands"])) return false;
			if($event == "onCommand" && isset($module::$conditions["channel"])) if(!enigma::isSafe($host) && ($target != $module::$conditions["channel"])) return false;
			if(isset($module::$conditions["custom"])) foreach($module::$conditions["custom"] as $condition) if(!eval("return ".$condition.";")) return false;
			if(isset($module::$conditions["variable"])) if(self::inString($event, $module::$conditions["events"])) if(!$module::${$module::$conditions["variable"]}) return false;
		} return true;
	}
}
?>