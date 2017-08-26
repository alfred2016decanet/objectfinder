<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0; 
if( ((($id >0) && (!isset($udroits['edit_7_2']))) || (($id == 0) && (!isset($udroits['add_7_2'])))) && !$currentuserinfos['access_all'])
	$s_page = $s_tpl = 'no-access-page';
else{
	$ariane[] = array('lien'=>'localistation.html', 'titre'=>"Localisation", 'icon'=>'globe');
	$ariane[] = array('lien'=>'', 'titre'=>"Langues", 'icon'=>'');
	
	
	$ariane[] = array('lien'=>'', 'titre'=>($id ? 'Modifier' : 'Ajouter'), 'icon'=>'edit');

	$langueObj = new Langues();
	//var_dump($_POST); die();
	if (Tools::getIsset('submitLangue')){
		$recdata = Tools::getPOST();
		if(!$id)
			$id = $langueObj->Create();
		$langueObj->setId($id);
		$langue = $langueObj->Recherche();

		if(isset($_FILES)){    
			if(!is_dir(ROOT.'data/img/l'))
				mkdir(ROOT.'data/img/l', 0777);
			foreach ($_FILES as $source => $value) {
				$srcname = Tools::addFile($source, ROOT.'data/tmp/',false);
				Tools::imageResize(ROOT.'data/tmp/'.$srcname, ROOT.'data/img/l/'.$id.'.jpg', 16, 11);
				unlink(ROOT.'data/tmp/'.$srcname);
			}   
		}
		
		$langueObj->Update($recdata, array('id_lang' => $id));   
		header('Location:langues.html');
		die();
		
	} 
	if($id > 0){
		$langueObj->setId($id);
		$langue = $langueObj->Recherche();
	}else{
		$langue['id'] = 0;
		$langue['name'] = '';
		$langue['iso_code'] = '';
		$langue['language_code'] = '';
		$langue['date_format_lite'] = '';
		$langue['date_format_full'] = '';
	} 
	$groupeObj = new Groupe();
	$smarty->assign('langue', $langue);
	$smarty->assign('groupes', $groupeObj->Recherche());
}
