<?php

/**

 * Smarty plugin

 * @package Smarty

 * @subpackage plugins

 */





/**

 * Smarty {math} function plugin

 *

 * Type:     function<br>

 * Name:     math<br>

 * Purpose:  handle math computations in template<br>

 * @link http://smarty.php.net/manual/en/language.function.math.php {math}

 *          (Smarty online manual)

 * @author   Monte Ohrt <monte at ohrt dot com>

 * @param array

 * @param Smarty

 * @return string

 */

function smarty_function_html_flash($params, &$smarty){

	foreach($params as $_key => $_val) {

		switch($_key){

		case 'width':

		case 'height':

			$$_key = (int)$_val;

			break;



		case 'wmode':

		case 'flashvars':

		case 'file':

			$$_key = (string)$_val;

			break;

			

		default:

			if(!is_array($_val)) {

				$extra .= ' '.$_key.'="'.smarty_function_escape_special_chars($_val).'"';

			} else {

				$smarty->trigger_error("html_options: extra attribute '$_key' cannot be an array", E_USER_NOTICE);

			}

			break;

		}

	}





	//TODO : GESTION JS//

	$output='<object height="'.$height.'" width="'.$width.'">

		<param value="'.$file.'" name="movie" />

		<param name="allowFullScreen" value="true" />

		<param  name="allowScriptAccess" value="always" />';

		if(!empty($wmode))$output.='<param  name="mode" value="'.$wmode.'" />';

		$output.='<embed height="'.$height.'" width="'.$width.'"';

		if(!empty($wmode))$output.=' wmode="'.$wmode.'"' ;

		$output.=' allowscriptaccess="always" allowfullscreen="true" src="'.$file.'" type="application/x-shockwave-flash">

	</object>';

		

	return $output;

}

?>

