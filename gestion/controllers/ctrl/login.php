<?php
setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');
//echo strftime("%A %d %B %Y."); die();
$adminObj = new Administrateur(false);
if(Tools::getIsset('email')) {

	if($adminObj->login(Tools::getSValue('email'), Tools::getSValue('mdpasse'))) {
		$udroits = $adminObj->getGroupAdminAccess($adminObj->userData['id']);
		$usalles = $adminObj->getGroupAdminSalles($adminObj->userData['id']);
		if(count($udroits)|| (int)$adminObj->userData['access_all'])
		{
			$currentuserinfos = $adminObj->userData;
			$smarty->assign('udroits', $udroits);
			$smarty->assign('usalles', $usalles);
			$smarty->assign('currentuserinfos', $currentuserinfos);
			$smarty->assign('logged', 1);
		}
		else {
			$s_page = $s_tpl = 'login';
			$smarty->assign('logged', 0);
		}
	}
	else {
		$s_page = $s_tpl = 'login';
		$smarty->assign('logged', 0);
	}
}elseif (strlen($session->lire($adminObj->sessionVariable.$adminObj->uType))>0){
	$data = explode(';',$session->lire($adminObj->sessionVariable.$adminObj->uType));
	$adminObj->loadAdmin($data[0]);
	$udroits = $adminObj->getGroupAdminAccess($data[0]);
	$usalles = $adminObj->getGroupAdminSalles($data[0]);
	if((count($udroits) > 0) || (int)$adminObj->userData['access_all']) {
		$currentuserinfos = $adminObj->userData;
		//var_dump($currentuserinfos); die();
		$smarty->assign('udroits', $adminObj->droits);
		$smarty->assign('usalles', $usalles);
		$smarty->assign('currentuserinfos', $currentuserinfos);
		$smarty->assign('logged', 1);
	}
	else{
		$s_page = $s_tpl = 'login';
		$smarty->assign('logged', 0);
	}
	
} else{
	$s_page = $s_tpl = 'login';
	$smarty->assign('logged', 0);
}

?>
