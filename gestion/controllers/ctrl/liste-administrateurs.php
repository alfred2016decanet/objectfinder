<?php
if(!isset($usrObj->droits['13_0'])) die("Vous n'avez pas les droits d'accès à cette page");

$usrObj = new UserSite(false);
$usrObj->setUtype('admin');
if(Tools::getIsset('del')) {
	$usrObj->Delete(array('membre_id'=>(int)Tools::getValue('del')));
	Tools::videCache();
}

$admins = $usrObj->Recherche();
$smarty->assign('admins', $admins);
?>