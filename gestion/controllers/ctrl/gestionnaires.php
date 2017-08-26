<?php

if(!isset($udroits['view_2_2']) && !$currentuserinfos['access_all'])
	$s_page = $s_tpl = 'no-access-page';
else{
	$ariane[] = array('lien'=>'gestionnaires.html', 'titre'=>"Utilisateurs", 'icon'=>'user');
	$ariane[] = array('lien'=>'', 'titre'=>"Gestionnaires", 'icon'=>'');
	$gestionnaireObj = new Administrateur(false);

	if(isset($_GET['action']) ){
	   if($_GET['action']=='toggleActive')
		   $gestionnaireObj->toggleActive(Tools::getValue('id'));  
		die('ok');
	}

	$wheres = array();

	if(Tools::getIsset('submitFilter')){
		$search = Tools::getValue('search');
		if(trim($search) != '')
			$wheres[] = 'administrateur.nom LIKE "'.$search.'%" OR administrateur.prenom LIKE "'.$search.'%"';      
		$smarty->assign('filters', $_POST);
	}

	$p = Tools::getIsset('p') ? Tools::getValue('p') : 1;
	$gestionnaireObj->setLimit((($p-1) * 100).',100');
	$gestionnaireObj->setWhere(implode(' AND ', $wheres));  

	$Total = $gestionnaireObj->getTotal();
	$nbpages = ceil($Total/100);
    
	$smarty->assign('gestionnaires', $gestionnaireObj->Recherche());
	$smarty->assign('totalGestionnaires', $Total);
	$smarty->assign('currpage', $p);
	$smarty->assign('nbpages', $nbpages);
}
