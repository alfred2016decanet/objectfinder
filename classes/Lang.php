<?php

abstract class Lang {
	static public function l($string, $specific = false)
	{	
		global $lang, $s_tpl, $_TEXT;
		$file = ROOT.'data/lang/'.$lang.'.php';
		if (file_exists($file))
			include_once($file);		
		$string2 = str_replace('\'', '\\\'', $string);
		$defaultKey = md5($string2);
		if (is_array($_TEXT) && key_exists($defaultKey, $_TEXT))
			$ret = stripslashes($_TEXT[$defaultKey]);
		else
			$ret = $string;
		return str_replace('"', '&quot;', $ret);
	}
}
?>