<?php
abstract class Config {
	static public function get($name) {
		$sql = MySQL::getInstance();
		$req = 'SELECT value FROM config WHERE name="'.mysql_real_escape_string($name).'"';
		$res = $sql->query($req);
		$ligne = $sql->fetch_assoc($res);
		return $ligne['value'];
	}

	static public function set($name, $value) {
		if(!self::get($name)) {
			$sql = MySQL::getInstance();
			$req = 'REPLACE INTO config (name, value) VALUES ("'.mysql_real_escape_string($name).'","'.mysql_real_escape_string($value).'")';
			//var_dump($req);die;
			$res = $sql->query($req);
			return $res;
		}
		$sql = MySQL::getInstance();
		$req = 'UPDATE config SET value="'.mysql_real_escape_string($value).'" WHERE name="'.mysql_real_escape_string($name).'"';
		$res = $sql->query($req);
		return $res;
	}
	
	static public function getList($liste) {
		$sql = MySQL::getInstance();
		$req = 'SELECT name, value FROM config WHERE name IN ("'.implode('","',$liste).'")';
		$ligne = $sql->query_array($req);
		$res=array();
		if(isset($ligne) and !empty($ligne))
			foreach($ligne as $l)
				$res[$l['name']] = $l['value'];
		return $res;
	}
	
	static public function getAll() {
		$sql = MySQL::getInstance();
		$req = 'SELECT name, value FROM config';
		$ligne = $sql->query_array_cache($req,3600,'conf.txt');
		$res=array();
		if(isset($ligne) and !empty($ligne))
			foreach($ligne as $l)
				$res[$l['name']] = $l['value'];
		return $res;
	}
}
?>