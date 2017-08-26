<?php
if(!isset($udroits['view_2_2']) && !$currentuserinfos['access_all'])
	$s_page = $s_tpl = 'no-access-page';
else{
	$ariane[] = array('lien'=>'localisation.html', 'titre'=>"Localisation", 'icon'=>'globe');
	$ariane[] = array('lien'=>'', 'titre'=>"Langues", 'icon'=>'');
	$langueObj = new Langues();

	if(isset($_GET['action']) ){
	   if($_GET['action']=='toggleActive')
		   $langueObj->toggleActive(Tools::getValue('id'), 'id_lang');  
		die('ok');
	}

	$p = Tools::getIsset('p') ? Tools::getValue('p') : 1;
	$langueObj->setLimit((($p-1) * 100).',100');

	$Total = $langueObj->getTotal();
	$nbpages = ceil($Total/100);

	$smarty->assign('langues', $langueObj->Recherche());
	$smarty->assign('totalLangues', $Total);
	$smarty->assign('currpage', $p);
	$smarty->assign('nbpages', $nbpages);
}
