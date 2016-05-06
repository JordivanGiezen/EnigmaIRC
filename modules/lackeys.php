<?php
namespace Enigma\modules\lackeys;
use \Enigma\brain as enigma;

class main {
	#Implementation
	static $conditions = array(
		"commands" => "lackeys"
	);

	function onCommand($nick, $host, $target, $args, $command) {
		//Parse arguments
		if(!preg_match("/^([0-9]*\.?[0-9]+)( [0-9]*\.?[0-9]+)?( [0-9]*\.?[0-9]+)?( (Godfather|First Lady|Capodecina|Bruglione|Chief|Local Chief|Assassin|Swindler|Soldier|Mobster|Associate|Thief|Pickpocket|Shoplifter|Picciotto|Delivery Boy|Delivery Girl|Empty-suit))?( (Rookie|Co-Driver|Driver|Advanced Driver|Master Driver|Chauffeur|Advanced Chauffeur|Master Chauffeur|Racing Driver|Race Supremo|Champion))?$/i", $args, $matches)) {
			enigma::message("Invalid arguments. Use !lackeys <crime hours> (<drug hours>) (<bullet purchases>) (<rank>) (<race rank>).", $target);
		} else {
			//Arguments
			$crimehours  = @trim($matches[1]);                                                             //crime hours is the first numeric argument
			$drughours   = @trim(($matches[3] ? $matches[2] : $matches[1]));                               //drug hours can only be given as the 2nd numeric value if there's 3 numeric values, otherwise the second numeric value is bullets and drug hours can't be given+
			$bullethours = @trim(($matches[3] ? $matches[3] : ($matches[2] ? $matches[2] : $matches[1]))); //bullet hours can either be the 2nd numeric value if only 2 numeric values are given or the 3rd numeric value if all 3 numeric values are given
			$rank        = @trim($matches[5]);                                                             //rank is the first non-numeric value
			$racerank    = @trim($matches[7]);                                                             //racerank is the second non-numeric value
			if(!$rank) $rank = "Local Chief";       //assumed rank if none is given
			if(!$racerank) $racerank = "Rookie";    //assumed rank if none is given
			$bulletprice = "350";                   //maximum bullet price for sluggs | TODO: possibility to also give it a bullet price
			$bulletcost = self::RankBulletMoney($racerank, $bulletprice);

			//Variables
			$spats       = array((($crimehours * 60) / 1.5), 0);
			$noodles     = array((($crimehours * 60) / 5  ), 0);
			$orourke     = array(($drughours * 20), self::RankBNMoney($rank, "B")); //assuming worst case scenarios at 18 attempts and 2 travels per hour
			$freekowtski = array(($drughours * 40), self::RankBNMoney($rank, "N")); //assuming worst case scenarios at 38 attempts and 2 travels per hour
			$sluggs      = array(($bullethours * 6), ($bullethours * $bulletcost)); //extra credit per hour for unknown circumstances
			$crimes      = array((     $spats[0] +     $noodles[0]), (     $spats[1] +     $noodles[1])); //crimes are spats and noodles
			$drugs       = array((   $orourke[0] + $freekowtski[0]), (   $orourke[1] + $freekowtski[1])); //drugs are orourke and freekowtski
			$drugcrimes  = array((    $crimes[0] +       $drugs[0]), (    $crimes[1] +       $drugs[1])); //drugcrimes are crimes and drugs
			$total       = array(($drugcrimes[0] +      $sluggs[0]), ($drugcrimes[1] +      $sluggs[1])); //total are drugcrimes and sluggs

			//Output
			enigma::message("Spats (Crimes): " . ceil($spats[0]) . " credits.", $target);
			enigma::message("Noodles (Cars): " . ceil($noodles[0]) . " credits.", $target);
			enigma::message("O'Rourke (Booze): " . ceil($orourke[0]) . " credits and $" . number_format($orourke[1], 0) . " ($rank).", $target);
			enigma::message("Freekowtski (Narcs): " . ceil($freekowtski[0]) . " credits and $" . number_format($freekowtski[1], 0) . " ($rank).", $target);
			enigma::message("Sluggs (Bullets): " . ceil($sluggs[0])  . " credits and $" . number_format($sluggs[1], 0) . " ($racerank at $bulletprice).", $target);
			enigma::message("Basic: " . $crimes[0] . " credits (" . self::Credits2Money($crimes[0]) . "€).", $target);
			enigma::message("Drugs: " . $drugs[0] . " credits (" . self::Credits2Money($drugs[0]) . "€) and $" . number_format($drugs[1], 0) . ".", $target);
			enigma::message("Newbie: " . $drugcrimes[0] . " credits (" . self::Credits2Money($drugcrimes[0]) . "€) and $" . number_format($drugcrimes[1], 0) . ".", $target);
			enigma::message("Complete: " . $total[0] . " credits (" . self::Credits2Money($total[0]) . "€) and $" . number_format($total[1], 0) . ".", $target);
		}
	}

	#Custom
	private function Credits2Money($credits) { return number_format((($credits/5000) * 3.6),2); }
	private function RankBNMoney($rank, $BN) {
		$ranks = array(
			  "Godfather" => array(70, 20),
			 "First Lady" => array(70, 20), 
			 "Capodecina" => array(70, 20), 
			  "Bruglione" => array(60, 17), 
			      "Chief" => array(50, 16), 
			"Local Chief" => array(45, 14),
			   "Assassin" => array(40, 13), 
			   "Swindler" => array(35, 11), 
			    "Soldier" => array(30, 10), 
			    "Mobster" => array(25,  8), 
			  "Associate" => array(20,  7), 
			      "Thief" => array(15,  5), 
			 "Pickpocket" => array(10,  4), 
			 "Shoplifter" => array( 7,  2), 
		      "Picciotto" => array( 5,  1), 
		   "Delivery Boy" => array( 2,  0),
		  "Delivery Girl" => array( 2,  0), 
		     "Empty-suit" => array( 1,  0)
		);

		//assume worst case scenario for alcohol to be at 3000 a unit, and drugs 16000 a unit
		return ($BN == "B" ? ($ranks[$rank][0] * 3000) : ($ranks[$rank][1] * 17000));
	}
	private function RankBulletMoney($rank, $bulletprice) {
		$ranks = array(
			            "Rookie" => 400,
			         "Co-Driver" => 460,
			            "Driver" => 520,
			   "Advanced Driver" => 580,
			     "Master Driver" => 640,
			         "Chauffeur" => 700,
			"Advanced Chauffeur" => 760,
			  "Master Chauffeur" => 820,
			     "Racing Driver" => 880,
			      "Race Supremo" => 940,
			          "Champion" => 1000
		);

		//assume worst case scenario for alcohol to be at 3000 a unit, and drugs 16000 a unit
		return $ranks[$rank] * $bulletprice;
	}
}
?>