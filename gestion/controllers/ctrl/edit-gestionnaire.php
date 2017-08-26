<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0; 
if( ((($id >0) && (!isset($udroits['edit_2_2']))) || (($id == 0) && (!isset($udroits['add_2_2'])))) && !$currentuserinfos['access_all'])
	$s_page = $s_tpl = 'no-access-page';
else{
	$ariane[] = array('lien'=>'gestionnaires.html', 'titre'=>"Utilisateurs", 'icon'=>'user');
	$ariane[] = array('lien'=>'', 'titre'=>"Gestionnaires", 'icon'=>'');
	$jsObj->addFichiers(array(
			'gestion/assets/js/jQuery-File-Upload-master/js/vendor/jquery.ui.widget.js',
			'gestion/assets/js/jQuery-File-Upload-master/js/jquery.iframe-transport.js',
			'gestion/assets/js/jQuery-File-Upload-master/js/jquery.fileupload.js'));
	if(isset($_FILES) && !Tools::getIsset('submitGestionnaire')){    
		if(!is_dir(ROOT.'data/img/gestionnaires'))
			mkdir(ROOT.'data/img/gestionnaires', 0777);
		foreach ($_FILES as $source => $value) {
			$photo = Tools::addFile($source, ROOT.'data/tmp/',false);
			echo '/data/tmp/'.$photo;
			die();
		}   
	}
	$ariane[] = array('lien'=>'', 'titre'=>($id ? 'Modifier' : 'Ajouter'), 'icon'=>'edit');

	$gestionnaireObj = new Administrateur(false);
	//var_dump($_POST); die();
	if (Tools::getIsset('submitGestionnaire')){
		if(((int)Tools::getValue('groupe') == 0) && !(int)$currentuserinfos['access_all']){
			$smarty->assign('errors', "Assigner ce gestionnaire à un groupe au moins!");
		}else{
			$recdata = Tools::getPOST();
			if(!$id)
				$id = $gestionnaireObj->Create();
			$gestionnaireObj->setId($id);
			$gestionnaire = $gestionnaireObj->Recherche();

			
			if($recdata['photo'] != '') {
				$src = $recdata['photo']; 
				$srcname = str_replace('/data/tmp/', '', $src);
				if(!is_dir(ROOT.'data/img/gestionnaires/'.$id))
					mkdir(ROOT.'data/img/gestionnaires/'.$id, 0777);
				copy(ROOT.'data/tmp/'.$srcname, ROOT.'data/img/gestionnaires/'.$id.'/'.$srcname);
				
				unlink(ROOT.'data/tmp/'.$srcname);
				if(!empty($gestionnaire['photo']) && $gestionnaire['photo'] != $srcname)
					if(file_exists(ROOT.'data/img/gestionnaires/'.$id.'/'.$gestionnaire['photo']))
						unlink(ROOT.'data/img/gestionnaires/'.$id.'/'.$gestionnaire['photo']);
				$recdata['photo'] = $srcname;
			}else
				$recdata['photo'] = $gestionnaire['photo'];

			if(!empty($recdata['mdp']))
				$recdata['mdp'] =  $gestionnaireObj->getCryptedPwd($recdata['mdp']);
			else
				unset($recdata['mdp']);
			$gestionnaireObj->Update($recdata, array('id' => $id));   
			$gestionnaireObj->delete(array('id_administrateur' => $id), 'admin_groupe');
			if((int)Tools::getValue('groupe'))
				$gestionnaireObj->InsertData(array('id_administrateur' => $id, 'id_groupe' => Tools::getValue('groupe')), 'admin_groupe');
			header('Location:gestionnaires.html');
			die();
		}
	} 
	if($id > 0){
		$gestionnaireObj->setId($id);
		$gestionnaire = $gestionnaireObj->Recherche();
	}else{
		$gestionnaire['id'] = 0;
		$gestionnaire['nom'] = '';
		$gestionnaire['prenom'] = '';
		$gestionnaire['photo'] = '';
		$gestionnaire['identifiant'] = '';
		$gestionnaire['access_all'] = 0;
	} 
	$groupeObj = new Groupe();
	$smarty->assign('gestionnaire', $gestionnaire);
	$smarty->assign('groupes', $groupeObj->Recherche());
}
