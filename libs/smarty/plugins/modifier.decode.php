<?php
/**
 * Smarty plugin
 * 
 * @package Smarty
 * @subpackage PluginsModifier
 */
 
/**
 * Smarty escape modifier plugin
 * 
 * Type:     modifier<br>
 * Name:     escape<br>
 * Purpose:  escape string for output
 * 
 * @link http://smarty.php.net/manual/en/language.modifier.count.characters.php count_characters (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com> 
 * @param string $string input string
 * @param string $esc_type escape type
 * @param string $char_set character set
 * @return string escaped input string
 */
function smarty_modifier_decode($string, $esc_type = 'html', $char_set = SMARTY_RESOURCE_CHAR_SET)
{
	if (preg_match('!!u', $string))
	{
	   return utf8_decode($string);
	}
	else 
	{
	   return $string;
	}
} 

?>