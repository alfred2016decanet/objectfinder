<?php
//INSERT INTO `cafrintel_db`.`config` (`name`, `value`) VALUES ('default_lang', '1'), ('default_idlang', 'fr');
if(Tools::getIsset('submitModules'))
{
	 Config::set('mod_actu', Tools::getValue('mod_actu'));
}
$ariane[] = array('lien'=>'', 'titre'=>"Modules", 'icon'=>'');
$categorieObj = new Category();
$arbrecat = $categorieObj->getArbreCategories(Config::get('default_lang'));
//var_dump($arbrecat); die();
$smarty->assign(array(
	'arbreCategories' => $arbrecat,
	'configs' =>  Config::getList(array('mod_actu')),
));
?>
