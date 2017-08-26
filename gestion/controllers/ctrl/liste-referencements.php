<?php
if(!isset($usrObj->droits['12_1'])) die("Vous n'avez pas les droits d'accès à cette page");
//Récupération de la liste des référencements
$pageObj=new Referencement();
$pageObj->setMode('admin');

$id=intval($_GET['id']);
// Si l'id est renseigné on supprime le référencement
if($id>0) {
	$pageObj->delReferencement($id);
	Tools::videCache();
}
$referencements=$pageObj->getReferencement();

$smarty->assign('referencements', $referencements);



?>