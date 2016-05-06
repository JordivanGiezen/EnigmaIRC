<?php
namespace Enigma {
	/* Configuration */
	//database
	const mysql_server = "localhost:3306";
	const mysql_user = "root";
	const mysql_pass = "";
	const mysql_db = "enigma";

	//irc
	const hostname = "irc.barafranca.com";
	const port = "6667";
	const nick = "LovelyAelBot";
	const commchar = "!";
	const pvtonly = false;
	const safeonly = false;
	const ignorebuffer = true;
	const channel = "#InsomniacGoddess";
	define("channels", serialize(array(
		'#InsomniacGoddess',
		"#cartella.member"
	)));

	//user configuration
	date_default_timezone_set("Europe/Lisbon");
	const enigmahost = 'Aelandra.users.omerta';
	define("safelist", serialize(array(
		'Miller.users.omerta',
		'Aelandra.users.omerta'
	)));

	/* Dependencies */
	require("enigma_brain.php");
	require("enigma_debug.php");
	require("enigma_modules.php");
	//require("enigma_multithread.php");
	require("enigma_mysql.php");
}
?>