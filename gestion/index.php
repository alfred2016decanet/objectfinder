<?php //utf8 é//
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
$timestart = microtime();

require_once('../config/config.php');
require_once('../config/smarty.admin.conf.php');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=utf-8'); 

/** CONNEXION BDD **/
if(!empty($_GET['page']))
	$s_page=$s_tpl=$_GET['page'];
else
	$s_page=$s_tpl='accueil';
require_once("controllers/ctrl/login.php");

//CSS//
$cssObj=new Css();
$cssObj->addFichiers(array(
	$_CONFIG['admin']['lib'].'fontawesome/css/font-awesome.css',
 	$_CONFIG['admin']['lib'].'select2/select2.css',
	$_CONFIG['admin']['css'].'quirk.css'
));

//JS//
//js de base du site en dur dans le header.tpl//
$jsObj=new Javascript();

if($s_page != "login") {
	$cssObj->addFichiers(array(
		 $_CONFIG['admin']['lib'].'Hover/hover.css',
		 $_CONFIG['admin']['lib'].'ionicons/css/ionicons.css',
		 $_CONFIG['admin']['lib'].'jquery-toggles/toggles-full.css',
		 $_CONFIG['admin']['lib'].'datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css',
		$_CONFIG['admin']['lib'].'jquery.gritter/jquery.gritter.css'
	));
	$jsObj->addFichiers(array(
		$_CONFIG['admin']['lib'].'jquery/jquery.js',
		$_CONFIG['admin']['lib'].'jquery-ui/jquery-ui.js',
		$_CONFIG['admin']['lib'].'bootstrap/js/bootstrap.js',
		$_CONFIG['admin']['lib'].'jquery-toggles/toggles.js',
		$_CONFIG['admin']['lib'].'jquery.gritter/jquery.gritter.js',
		$_CONFIG['admin']['lib'].'raphael/raphael.js',
		$_CONFIG['admin']['lib'].'datatables/jquery.dataTables.js',
		$_CONFIG['admin']['lib'].'datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js',
		$_CONFIG['admin']['lib'].'select2/select2.js',
		$_CONFIG['admin']['lib'].'flot/jquery.flot.js',
		$_CONFIG['admin']['lib'].'flot/jquery.flot.resize.js',
		$_CONFIG['admin']['lib'].'flot-spline/jquery.flot.spline.js',
		$_CONFIG['admin']['lib'].'jquery-knob/jquery.knob.js',
		$_CONFIG['admin']['js'].'quirk.js',
        'assets/js/fonctions.js',
	));
}
$jsObj->addFichiers(_RTEMPLATES_DIR._RBO_THEME_DIR.'js/commun.js');
$jsObj->addFichiers($_CONFIG['admin']['js'].'init-plugins.js');
ob_end_clean();
//INCLUDE DU CONTROLLEUR PHP//
$ariane = array();
//if($s_page == 'accueil')
$ariane[] = array('lien'=>'index.php', 'titre'=>"Accueil", 'icon'=>'dashboard');

$smarty->assign('s_config', $_CONFIG);
if (is_file('controllers/ctrl/'.$s_page.'.php'))
	require_once('controllers/ctrl/'.$s_page.'.php');

//DERNIER CSS//
if (is_file(ROOT.'gestion/assets/css/'.$s_tpl.'.css'))
	$smarty->assign('include_css',$_CONFIG['admin']['css'].$s_tpl.'.css');
//ON INCLUT LES JS DE PAGES (ACTIONS) EN DERNIER//
if (is_file(ROOT.'gestion/assets/js/'.$s_tpl.'.js'))
		$smarty->assign('include_js',$_CONFIG['admin']['js'].$s_tpl.'.js');

// detection des messages d'alertes
if(!empty($_SESSION['alert']))
{
	$smarty->assign('msg_alert', $_SESSION['alert']);
	$_SESSION['alert'] = '';
}

if (count($scriptsJS)>0){foreach($scriptsJS as $script){$JS.=$script;}}
$smarty->assign('s_config', $_CONFIG);
if(!$smarty->isCached(_RBO_THEME_DIR.'header.tpl', $s_tpl) || !$smarty->isCached(_RBO_THEME_DIR.'footer.tpl', $s_tpl)
		|| $_CONFIG['usr']['smarty_cache']==0) {
   $smarty->assign('URL_BASE', URL_BASE);
	$smarty->assign('liste_js', $jsObj->getFichiers());
	if($_CONFIG['usr']['unifycss']==1)
		$smarty->assign('liste_css', $cssObj->getUnify());
	else
		$smarty->assign('liste_css', $cssObj->getFichiers());
	$smarty->assign('scripts_js', $jsObj->getScripts());
	$smarty->assign('JS', $JS);
	$smarty->assign('s_page', $s_page);
	$smarty->assign('s_tpl', $s_tpl);
}

//SI POPUP, ON AFFICHE MAINTENANT//
if($_GET['popup']==1){
	$smarty->assign('popup', 1);
	// $output=$smarty->fetch('header-popup.tpl');
	$output.=$smarty->fetch($s_tpl.".tpl");
	// $output.=$smarty->fetch('footer-popup.tpl');
	
	die(($output));
}

$smarty->assign('ariane', $ariane);
$smarty->display(_RBO_THEME_DIR.'header.tpl', $s_tpl);
$smarty->display(_RBO_THEME_DIR.$s_tpl.'.tpl');
$smarty->display(_RBO_THEME_DIR.'footer.tpl', $s_tpl);
//echo Tools::test_speed();

?>