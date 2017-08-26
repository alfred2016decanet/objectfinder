<?php

$id = isset($_GET['id']) ? $_GET['id'] : 0; 
if( ((($id >0) && (!isset($udroits['edit_2_3']))) || (($id == 0) && (!isset($udroits['add_2_3'])))) && !$currentuserinfos['access_all'])
	$s_page = $s_tpl = 'no-access-page';
else{
	$ariane[] = array('lien'=>'gestionnaires.html', 'titre'=>"Utilisateurs", 'icon'=>'user');
	$ariane[] = array('lien'=>'groupes.html', 'titre'=>"Groupes", 'icon'=>'');
	$ariane[] = array('lien'=>'', 'titre'=>($id ? 'Modifier' : 'Ajouter'), 'icon'=>'');

	$groupeObj = new Groupe();
	if (Tools::getIsset('submitGroupe')){
		$recdata = Tools::getPOST();
		if(!$id)
			$id = $groupeObj->Create();
		
		if(isset($recdata['access'])){
			$access = $recdata['access'];
			$recdata['access'] = array();
			foreach($access as $d)
				$recdata['access'][$d] = 1;
			$recdata['access'] = json_encode ($recdata['access']);
		}else{
			$recdata['access']['none'] = 1;
		}

		$groupeObj->Update($recdata, array('id' => $id));       
		header('Location:groupes.html');
		die();
	} 
	if($id > 0){
		$groupeObj->setId($id);
		$groupe = $groupeObj->Recherche();
	}else{
		$groupe['id'] = 0;
		$groupe['nom'] = '';
		$groupe['access'] = array();
		$groupe['id_ets'] = 0;
	}
	//var_dump($groupe); die();
	$smarty->assign('groupe', $groupe);
}
