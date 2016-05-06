<?php
namespace Enigma\modules\ideias;
use \Enigma\brain as enigma;
use \Enigma\mysql as sql;

class main {
	#Implementation
	static $conditions = array(
		"commands" => "ideia, ideias",
		"safe" => true
	);

	function onCommand($nick, $host, $target, $args, $command) {
		$args = explode(" ", $args);
		switch($args[0]) {
			case "reset": $this->resetIdeas($target); break;
			case "list": $this->listIdeas($target); break;
			case "read": case "ler":
				if(isset($args[1])) $this->sendIdea($args[1], $target);
				else $this->listIdeas($target); break;

			case "del": case "delete": case "apagar":
				if(!isset($args[1])) enigma::message("Apagar qual ideia?", $target);
				else $this->deleteIdea($args[1], $target); break;

			case "add": case "adicionar":
				if(!isset($args[1])) enigma::message("Adicionar qual ideia?", $target);
				else { array_shift($args); $this->storeIdea(implode(" ", $args), $nick, $target); }
				break;			

			default:
				if(!$args[0]) $this->listIdeas($target);
				else {
					if($command == "ideias") $this->sendIdea($args[0], $target);
					else $this->storeIdea(implode(" ", $args), $nick, $target);
				}
		}
	}

	#Custom
	function readIdea($id) { return sql::search("enigma_ideas", "WHERE id='".intval($id)."'", true); }
	function sendIdea($id, $target) {
		if($idea = $this->readIdea($id))
			enigma::message("Ideia #".$idea["id"]." (".$idea["nick"].", ".$idea["date"]."): ".$idea["idea"], $target);
		else
			enigma::message("Ideia não encontrada.", $target);
	}

	function deleteIdea($id, $target) {
		if(!$this->readIdea($id)) enigma::message("Ideia não encontrada.", $target);
		else {
			sql::delete("enigma_ideas", "WHERE id='".intval($id)."'");
			enigma::message("Ideia #".intval($id)." apagada.", $target);
		}
	}

	function storeIdea($idea, $nick, $target) {
		sql::insert("enigma_ideas", array(null, $idea, date("d-m-Y"), $nick));
		enigma::message("Ideia guardada.", $target);
	}

	function listIdeas($target) {
		$ideas = sql::select("enigma_ideas");
		if(!$ideas) enigma::message("Sem ideias na minha base de dados.", $target);
		else foreach($ideas as $idea)
			enigma::message("Ideia #".$idea["id"]." (".$idea["nick"].", ".$idea["date"]."): ".$idea["idea"], $target);
	}

	function resetIdeas($target) {
		sql::delete("enigma_ideas");
		sql::resetIncrement("enigma_ideas");
		enigma::message("Ideias apagadas e contagem reiniciada.", $target);
	}
}
?>