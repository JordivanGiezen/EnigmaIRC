<?php
namespace Enigma;

class mysql {
	static $connection;

	static function ping() { if(!self::$connection->ping()) self::connect(); }
	static function connect() {
		self::$connection = @new \mysqli(mysql_server, mysql_user, mysql_pass, mysql_db);
		if(self::$connection->connect_error)
			debug("Couldn't connect to the database: " . self::$connection->connect_error, "fatal", "[SQL]");
		else
			debug("Connected to the database.", "mysql");
	}

	static function insert($table, $values) {
		self::ping();
		foreach($values as $key=>$value)
			if($value !== null) $values[$key] = "'" . self::$connection->real_escape_string($value) . "'";
			else $values[$key] = "null";

		$values = implode(", ", $values);
		$query = self::$connection->query("INSERT INTO ".$table." VALUES (".$values.")");
		if(!$query) debug("An insert query was unsuccessful: " . self::$connection->error, "mysql");
	}

	static function select($table) {
		self::ping();
		$output = false;
		$query = self::$connection->query("SELECT * FROM ".$table);
		if($query) { $output = $query->fetch_all(MYSQLI_ASSOC); $query->free(); }
		else debug("A select query was unsuccessful: " . self::$connection->error, "mysql");
		return $output;
	}

	static function search($table, $condition, $one=false) {
		self::ping();
		$output = false;
		$query = self::$connection->query("SELECT * FROM ".$table." ".$condition);
		if($query) { $output = $query->fetch_all(MYSQLI_ASSOC); $query->free(); }
		else debug("A search query was unsuccessful: " . self::$connection->error, "mysql");
		if(!$one) return $output; else return @$output[0];
	}

	static function delete($table, $condition=false) {
		self::ping();
		$query = self::$connection->query("DELETE FROM ".$table.($condition?(" ".$condition):''));
		if(!$query) debug("A delete query was unsuccessful: " . self::$connection->error, "mysql");
	}

	static function update($table, $column, $value, $condition) {
		self::ping();
		$value = ($value === null) ? "null" : ("'" . $value . "'");
		$query = self::$connection->query("UPDATE ".$table." SET ".$column."=".$value." ".$condition);
		if(!$query) { debug("An update query was unsuccessful: " . self::$connection->error, "mysql"); return false; }
		else return true;
	}

	static function resetIncrement($table) {
		self::ping();
		$query = self::$connection->query("TRUNCATE TABLE " . $table);
		if($query) debug("A reset increment request was successful.", "mysql");
		else debug("A reset increment request was unsuccessful: " . self::$connection->error, "mysql");
	}
}
?>