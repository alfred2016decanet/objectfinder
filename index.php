<?php //utf8 ?//
$timestart = microtime();
/**

* Fichier central du site

**/

header('Access-Control-Allow-Origin: *');
require_once('config/config.php');
require_once('config/smarty.conf.php');

Tools::videCache();
if (empty($_GET['langsite'])) {
	
	// on tente de prendre la langue de l'ordi du user
	$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$language = strtolower($language{0}.$language{1});
	
	// si le navigateur n'a pas de lange, alos on va prendre la langue par défaut du site
	if (!in_array($language, $_CONFIG['lang'])) {
		$id_langue_default = Config::get('default_lang');
		$langueObj = new Langues($id_langue_default);
		$langueObj->setId($id_langue_default);
		$langsite = $langueObj->Recherche();
		$language = strtolower($langsite['iso_code']);
	}
	// pas de langue definie (ou hors des possibles), on prend la premiere de la liste
	header('Location:'.URL_BASE.$language.'/');
	die();
}

if(in_array(substr($_SERVER['REQUEST_URI'], 1), array('index', 'index.php', 'index.html'))){
	header("HTTP/1.1 301 Moved Permanently");
	header('Location:'.URL_BASE);
	die();
}

//gestion page => controleurs/views//
if($_GET['page'])
	$s_page=$s_tpl=$_GET['page'];
else $s_page=$s_tpl='index';

//on teste pour la redirection https
if($_CONFIG['usr']['securite']==1 && in_array($s_page, $_CONFIG['usr']['securepage'])&&  !isset($_SERVER['HTTPS'])){
    Tools::videCache();
    header('Location:'.URL_SSL.substr($_SERVER['REQUEST_URI'], 1));
	die();
}

if(Tools::getIsset('url_back'))
	$url_back = Tools::getSValue('url_back');
elseif(!empty($_SERVER['HTTP_REFERER']))
	$url_back = $_SERVER['HTTP_REFERER'];

$smarty->assign('url_back', $url_back);

Tools::videCache();
/////////////
// LANGUES //
/////////////

$lang = $_GET['langsite'];;
$linkObj = new URL();

/*$link = $linkObj->pageUrl('inscription', $lang);
die(var_dump($link));*/
$smarty->assign('s_config', $_CONFIG);
$smarty->assign('URL_BASE', URL_BASE);
$smarty->assign('URL_JS', URL_JS);
$smarty->assign('URL_CSS', URL_CSS);
$smarty->assign('URL_STATIC', URL_STATIC);
$smarty->assign('URL_SSL', URL_SSL);
$smarty->assign('lang', $lang);
$smarty->assign('linkObj', $linkObj);

// detection des messages d'alertes
if(!empty($_SESSION['alert']))
{
	$smarty->assign('msg_alert', $_SESSION['alert']);
	$_SESSION['alert'] = '';
}

if(isset($_GET['urlBack'])) 
	$smarty->assign('urlBack', $_GET['urlBack']);

$_BASE = new MySQL($_CONFIG['db']['host'], $_CONFIG['db']['user'], $_CONFIG['db']['password'], $_CONFIG['db']['base']);
$_CONFIG['db']=Config::getAll();

$jsObj=new Javascript();
$jsObj->addFichiers(array(
	'assets/js/jquery-1.9.1.js',
	'assets/plugins/bootstrap/js/bootstrap.js',
	'assets/plugins/fancybox/jquery.fancybox.js',
	'assets/js/jquery.bxslider.min.js',
	'assets/js/script.js',
));

$cssObj=new Css();
$cssObj->addFichiers(array(
	'assets/plugins/bootstrap/css/bootstrap.css',
	'assets/plugins/bootstrap/css/bootstrap-theme.css',
	'assets/plugins/fancybox/jquery.fancybox.css',
	'assets/css/jquery.bxslider.css',
	'assets/css/style.css',
	'assets/css/responsive.css',
	));
//$cssObj->addFichiers('assets/css/print.css', 'print');

$isLoggued=(strlen($session->lire('userSessionValue'))>3)?1:0;
$logged=($isLoggued==1)?$session->lire('userSessionValue'):0;
$url = explode('/',substr($_SERVER['REQUEST_URI'],4));
//$url[0] = (strpos($url[0],'?')!==false)?substr($url[0],0,strpos($url[0],'?')):$url[0];
	
//var_dump($url);
if(isset($url[1]) && !empty($url[1]))
	if(!empty($url[0]))
		$s_page = $s_tpl = $url[0];
$pagesObj = new URL();
$lespages = $pagesObj->Recherche();
$idlangbyisocode = Langues::getIdLang($lang);
$pageurl = URL::getPageByRewriteName($s_page);
$page_baniere = URL::getPageBaniere($s_page);

$smarty->assign(array('page_baniere' =>$page_baniere, 'img_bannerpath' => URL_BASE . 'data/img/banieres'));
if($pageurl) {
	$s_page = $s_tpl = $pageurl;
	if(isset($url[1]) && !empty($url[1]))//genre: services/1-blablablabla
	{
		if(!empty($url[0]))
		{
			$s_page = $s_tpl = $pageurl.'-detail';
			$elt = explode('-', $url[1]);
			$_GET['id'] = $elt[0];
			$_GET['linkrewritre'] = $elt[1];
		}
	}
}
elseif(!is_file(_RTEMPLATES_DIR._RFO_THEME_DIR.$s_page.'.tpl') && $s_page!='')
	$s_page=$s_tpl='404';


// Maintenance
foreach(explode("\n",$_CONFIG['usr']['maintenance_ip']) as $c){
    if(trim(Tools::get_ip())==trim($c))
		$_CONFIG['usr']['maintenance']=0;
}

if(($_CONFIG['usr']['maintenance']==1) && (($s_page != 'ipn-paiement') && ($s_page != 'cipn-paiement'))){
	$smarty->display('maintenance.tpl');
	die();
}
	
$p = Tools::getIsset('p')?(int)Tools::getValue('p'):1;
$id = Tools::getIsset('id')?Tools::getSValue('id'):0;
$ariane = array(array('lien'=>'/', 'titre'=>Lang::l('Page d\'accueil')));
$cacheid = $lang.$s_tpl.$loggued.$p.$id;
require_once('controllers/ctrl/header.php');

if($s_page=='404') $ariane[] = Lang::l('Erreur 404');
if(file_exists('controllers/ctrl/'.$s_page.'.php'))
	require_once('controllers/ctrl/'.$s_page.'.php');
require_once('controllers/ctrl/footer.php');

if(!$smarty->isCached('header.tpl', $lang.$s_tpl.$id.$p) || !$smarty->isCached('footer.tpl', $lang.$s_tpl.$id.$p) || $_CONFIG['usr']['smarty_cache']==0) {
	if(is_file(ROOT.$_CONFIG['assetPath'].'css/'.$s_tpl.'.css'))
		$smarty->assign('include_css',$_CONFIG['assetPath'].'css/'.$s_tpl.'.css');

	if (is_file(ROOT.$_CONFIG['assetPath'].'js/'.$s_tpl.'.js'))
		$smarty->assign('include_js',$_CONFIG['assetPath'].'js/'.$s_tpl.'.js');
        
	$smarty->assign('s_page', $s_page);

	//ASSIGNS SMARTY//
	if($_CONFIG['usr']['unifyjs']==1)
		$smarty->assign('liste_js', $jsObj->getUnify());
	else
		$smarty->assign('liste_js', $jsObj->getFichiers());
	if($_CONFIG['usr']['unifycss']==1)
		$smarty->assign('liste_css', $cssObj->getUnify());
	else
		$smarty->assign('liste_css', $cssObj->getFichiers());
	$smarty->assign('scripts_js', $jsObj->getScripts());
	$smarty->assign('ariane', $ariane);
    
    $smarty->assign('session', $session);
}

//TOUT SITE HORS FORUM : DISPLAY DU TOUT//
if($s_tpl!="maintenance")$smarty->display(_RFO_THEME_DIR.'header.tpl', $cacheid);
$smarty->display(_RFO_THEME_DIR.$s_page.'.tpl', $cacheid);

if($s_tpl!="maintenance")$smarty->display(_RFO_THEME_DIR.'footer.tpl', $cacheid);

if(Tools::getIsset('showtime'))
    echo Tools::test_speed();
?>