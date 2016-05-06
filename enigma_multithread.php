<?php
namespace Enigma;
use \Enigma\brain as enigma;

class multithreading extends \Thread {
	public $eval;
	function __construct($eval) { $this->eval = $eval; }
	function run() { eval($this->eval); }
	function output($msg, $target=false) {
		$target = $target?$target:channel;
		$dir = __DIR__."\\buffer\\";
		$scandir = scandir($dir, SCANDIR_SORT_NONE);
		file_put_contents($dir.$target."-".(count($scandir)-2).".txt", $msg);
	}

	static function checkBuffer() {
		$dir = __DIR__."\\buffer\\";
		$scandir = scandir($dir, SCANDIR_SORT_NONE);
		if(count($scandir)<=2) return;
		else {
			unset($scandir[0], $scandir[1]);
			foreach($scandir as $buffer) {
				$target = substr($buffer, 0, strpos($buffer, "-"));
				enigma::message(file_get_contents($dir.$buffer), $target);
				unlink($dir.$buffer);
			}
		}
	}
}
?>