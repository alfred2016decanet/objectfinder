<?php

/**

 * Smarty plugin

 * @package Smarty

 * @subpackage plugins

 */



function smarty_modifier_geturlimg($img, $h, $l, $mode="resize", $output_format='', $force=false, $filigrane=false){

	//SILVIO 2009-10-23
	$c_img = new Image();

	return $c_img->getURL($img, $h, $l, $mode, $output_format, $force, $filigrane);

}

?>

