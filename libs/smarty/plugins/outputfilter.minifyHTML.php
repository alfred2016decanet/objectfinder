<?php
/**
 * Smarty shared plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty minifyHTML postfilter plugin
 *
 * File:     outputfilter.minifyHTML.php<br>
 * @param string
 * @param Smarty
 */
  function smarty_outputfilter_minifyHTML($html, Smarty_Internal_Template $template)
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
 
 ?>