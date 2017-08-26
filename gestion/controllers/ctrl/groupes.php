<?php
if(!isset($udroits['view_2_3']) && !$currentuserinfos['access_all'])
	$s_page = $s_tpl = 'no-access-page';
else{
	$ariane[] = array('lien'=>'gestionnaires.html', 'titre'=>"Utilisateurs", 'icon'=>'user');
	$ariane[] = array('lien'=>'', 'titre'=>"Groupes", 'icon'=>'');
	$groupeObj = new Groupe();
	if(isset($_GET['action']) ){
	   if($_GET['action']=='toggleActive')
		   $groupeObj->toggleActive(Tools::getValue('id'));  
		die('ok');
	}
	$wheres = array();
	if(Tools::getIsset('submitFilter')){
		$search = Tools::getValue('search');
		if(trim($search) != '')
			$wheres[] = 'nom LIKE "'.$search.'%"';      
		$smarty->assign('filters', $_POST);
	}
	$p = Tools::getIsset('p') ? Tools::getValue('p') : 1;
	$groupeObj->setLimit((($p-1) * 100).',100');
	$groupeObj->setWhere(implode(' AND ', $wheres));  
	$Total = $groupeObj->getTotal();
	$nbpages = ceil($Total/100);
	$smarty->assign('groupes', $groupeObj->Recherche());
	$smarty->assign('totalGroupes', $Total);
	$smarty->assign('currpage', $p);
	$smarty->assign('nbpages', $nbpages);
}

