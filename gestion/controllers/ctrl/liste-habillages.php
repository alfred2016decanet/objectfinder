<?php //utf8 é//
if(!isset($usrObj->droits['2_1'])) die("Vous n'avez pas les droits d'accès à cette page");

$habObj=new Habillage();
$habObj->setMode('admin');
$habObj->setTri('habillage.habillage_date_fin DESC');
$habillages=$habObj->Recherche();

$smarty->assign('habillages', $habillages);
?>