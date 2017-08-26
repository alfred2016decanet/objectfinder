<?php
	//Si modification d'un article, on récupère les infos.//
$id = isset($_GET['id']) ? $_GET['id'] : 0; 
if( ((($id >0) && (!isset($udroits['edit_7_1']))) || (($id == 0) && (!isset($udroits['add_7_1'])))) && !$currentuserinfos['access_all'])
	$s_page = $s_tpl = 'no-access-page';
else{
	
	$thumb_rep = ROOT . 'data/img/banieres';
    $image_path = $thumb_rep;
	$ariane[] = array('lien'=>'localistation.html', 'titre'=>"Localisation", 'icon'=>'globe');
	$ariane[] = array('lien'=>'', 'titre'=>"Langues", 'icon'=>'');
	
	$ariane[] = array('lien'=>'', 'titre'=>($id ? 'Modifier' : 'Ajouter'), 'icon'=>'edit');

	$langues =  Langues::getLangues(1);
	$urlObj = new URL();
	//var_dump($_POST); die();
	if (Tools::getIsset('submitUrl')){
		$recdata = Tools::getPOST();
		if(is_array($langues))
			foreach ($langues as $lang)
				$_POST['lang_'.$lang['id_lang'].'_url'] = Tools::nom_web(Tools::getValue('lang_'.$lang['id_lang'].'_name'));
		if(!$id){
			$id = $urlObj->Create();
			Tools::setAlert('Enregistrement effectué avec succès');
		}
		else
		{
			$recdata['date_upd'] = date('Y-m-d');
			Tools::setAlert('Mise à jour effectuée avec succès');
		}
		
		if(!empty($_FILES['baniere']['name']))
		{
			if (!is_dir($thumb_rep))
				$res = mkdir($thumb_rep, 0777, true);
				
			$image = Tools::addFile('baniere', $thumb_rep . '/', false, null, 'default', null);
			if (!is_array($image))
				$recdata['baniere'] = $image;
		}
		
		$urlObj->setId($id);
		$urlObj->Update($recdata, array('id_url' => $id));
		//mise à jour des positions en DB
		header('Location:liste-urls.html');
		die();
	} 
	if($id > 0){
		$urlObj->setId($id);
		$url = $urlObj->Recherche();
	}else{
		$url['id_url'] = 0;
		if(is_array($langues))
			foreach ($langues as $lang) {
				$url['name'][$lang['id_lang']] = '';
			}
		$url['page'] = '';
		$url['baniere'] = '';
	} 
	$pages = array();
	$pages[] = array('nom' => 'accueil');
	$pages[] = array('nom' => 'annuaire');
	$pages[] = array('nom' => 'accept-paiement');
	$pages[] = array('nom' => 'agenda');
	$pages[] = array('nom' => 'cancel-paiement');
	$pages[] = array('nom' => 'cipn-paiement');
	$pages[] = array('nom' => 'cms-article');
	$pages[] = array('nom' => 'cms-category');
	$pages[] = array('nom' => 'connexion');
	$pages[] = array('nom' => 'contact');
	$pages[] = array('nom' => 'formations');
	$pages[] = array('nom' => 'ipn-paiement');
	$pages[] = array('nom' => 'recrutements' );
	$pages[] = array('nom' => 'mon-compte');
	$pages[] = array('nom' => 'inscription');
	$pages[] = array('nom' => 'services' );
	$pages[] = array('nom' => 'staff' );
	
	//assigns smarty//
	$smarty->assign(array(
		'url' => $url,
		'langues' => $langues,
		'image_path' => URL_BASE . 'data/img/banieres',
		'default_lang' => Config::get('default_lang'),
		'pages' =>$pages));
}
?>