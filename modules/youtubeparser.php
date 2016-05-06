<?php
namespace Enigma\modules\youtubeparser;
use \Enigma\brain as enigma;

class main {
	#Implementation
	static $conditions = array(
		"message" => "/(http(s?):\/\/((www\.)?)youtube.com\/([a-zA-Z0-9&#?=_\-\/]+))/"
	);

	function onMessage($nick, $host, $target, $message) {
		preg_match(self::$conditions["message"], $message, $youtube);
		if($youtube = @file_get_contents($youtube[1])) {
			preg_match("/\<title\>(.+)\<\/title\>/", $youtube, $title);
			if(isset($title[1])) {
				$title[1] = str_replace(" - Youtube", "", $title[1]); //remove the end of the title and parse html dec entities
				$title[1] = preg_replace_callback("/&#([0-9]+);/", create_function('$dec', 'return chr($dec[1]);'), $title[1]);
				enigma::message("Youtube: " . str_replace(" - YouTube", "", $title[1]), $target);
			}
		}
	}
}
?>