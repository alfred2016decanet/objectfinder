<?php
//if(!isset($usrObj->droits['12_2'])) die("Vous n'avez pas les droits d'accès à cette page");
//Récupération de la liste des référencements

$ariane[] = array('lien'=>'localisation.html', 'titre'=>"Localisation", 'icon'=>'globe');
$ariane[] = array('lien'=>'', 'titre'=>"SEO et URLs", 'icon'=>'');
$id_lang = Config::get('default_lang');
$urlObj=new URL($id_lang);
$urlObj->setMode('admin');

$urls = $urlObj->Recherche();
$nbr_url = count($urls);

$smarty->assign('urls', $urls);
$smarty->assign('nbr_url', $nbr_url);



?>