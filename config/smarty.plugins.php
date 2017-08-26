<?php
function smartyTranslate($params, &$smarty)
{
	global $default_lang, $s_tpl, $_TEXT;
	$string = $params['s'];
	$file = ROOT.'data/lang/'.$default_lang.'.php';
	if (file_exists($file))
		include_once($file);		
	$string2 = str_replace('\'', '\\\'', $string);
	$defaultKey = '<'.$page.'>'.md5($string2);
	if (is_array($_TEXT) && key_exists($defaultKey, $_TEXT))
		$ret = stripslashes($_TEXT[$defaultKey]);
	else
	{
//		$file = ROOT.'data/lang/'.$default_lang.'.php';
//		if (file_exists($file))
//			include_once($file);

//		if (!is_array($_TEXT))
//			return (str_replace('"', '&quot;', $string));
//
//		$string2 = str_replace('\'', '\\\'', $string);
//		$defaultKey = '<default>'.md5($string2);
//		if (key_exists($defaultKey, $_TEXT))
//			$ret = stripslashes($_TEXT[$defaultKey]);
//		else
			$ret = $string;
	}
	return str_replace('"', '&quot;', $ret);
}

function minifyHTML($html, Smarty_Internal_Template $template)
 {
     // remove HTML comments (but not IE conditional comments).
    $html = preg_replace('/<!--[^\\[][\\s\\S]*?-->/', '', $html);

	// trim each line.
    // @todo take into account attribute values that span multiple lines.
	$html = preg_replace('/^\\s+|\\s+$/m', '', $html);
	
	// remove ws around block/undisplayed elements
    $html = preg_replace('/\\s+(<\\/?(?:area|base(?:font)?|blockquote|body'
            .'|caption|center|cite|col(?:group)?|dd|dir|div|dl|dt|fieldset|form'
            .'|frame(?:set)?|h[1-6]|head|hr|html|legend|li|link|map|menu|meta'
            .'|ol|opt(?:group|ion)|p|param|t(?:able|body|head|d|h||r|foot|itle)'
            .'|ul)\\b[^>]*>)/i', '$1', $html);
	
	return $html;
 }



//$smarty->registerPlugin("function","l", "smartyTranslate");
$smarty->registerPlugin("modifier","html", "htmlentities");
//if($_CONFIG['usr']['minifyhtml']==1)
//$smarty->registerFilter('output', 'minifyHTML');
$smarty->setPluginsDir(ROOT.'libs/smarty/plugins');
?>