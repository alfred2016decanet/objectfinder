<?php
//INSERT INTO `cafrintel_db`.`config` (`name`, `value`) VALUES ('default_lang', '1'), ('default_idlang', 'fr');
if(Tools::getIsset('submitLocalisation'))
{
	 Config::set('default_lang', Tools::getValue('conf_default_lang'));
	 Config::set('default_idlang', Tools::getValue('conf_default_idlang'));
}

$ariane[] = array('lien'=>'', 'titre'=>"Localisation", 'icon'=>'globe');
$langues = Langues::getLangues(1); // sélection des langues actives
$smarty->assign(array(
	'langues' => $langues,
	'configs' =>  Config::getList(array('default_lang', 'default_idlang')),
	));
?>
