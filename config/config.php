<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('error_reporting', E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
ini_set('log_errors', true);
ini_set('html_errors', true);
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'].'/data/logs/error_log.txt');
ini_set('display_errors', true);
date_default_timezone_set('Europe/Paris');
setlocale (LC_ALL, "fr_FR");
/** définition ROOT **/
$realpath = realpath(dirname(__FILE__));
define(ROOT, substr($realpath, 0, strpos($realpath, 'config')));
define(URL_BASE, 'http://' . $_SERVER['HTTP_HOST'] . '/');

define(URL_JS, 'http://' . $_SERVER['HTTP_HOST'] . '/');
define(URL_CSS, 'http://' . $_SERVER['HTTP_HOST'] . '/');
if(isset($_SERVER['HTTPS']))
	define(URL_STATIC, 'https://' . $_SERVER['HTTP_HOST'] . '/');
else
	define(URL_STATIC, 'http://' . $_SERVER['HTTP_HOST'] . '/');
define(URL_SSL, 'https://' . $_SERVER['HTTP_HOST'] . '/');
define(_RFO_THEME_DIR, 'default/');
define(_RBO_THEME_DIR, 'default/');
define(_RTEMPLATES_DIR, 'templates/');
define('SITE_MAIL_TPL_DIR', ROOT._RTEMPLATES_DIR.'mail/');
require_once(ROOT.'libs/smarty/Smarty.class.php');	

function  loadClass($className){
	if(is_file(ROOT."classes/$className.php"))
		require_once(ROOT."classes/$className.php");
}

//INSTANCES
$smarty = new Smarty;
spl_autoload_register('loadClass');

$_CONFIG['URL_BASE'] = URL_BASE;
$_CONFIG['db']['host']	= 'localhost';
$_CONFIG['db']['user']	= 'root';
$_CONFIG['db']['password']	= '';
$_CONFIG['db']['base'] = 'framework_db';

if($_SERVER['REMOTE_ADDR'] =='127.0.0.1'){
    $_CONFIG['db']['host']	= 'localhost';
	$_CONFIG['db']['user']	= 'root';
	$_CONFIG['db']['password']	= '';
	$_CONFIG['db']['base'] = 'framework_db';
}

$_BASE = new MySQL($_CONFIG['db']['host'], $_CONFIG['db']['user'], $_CONFIG['db']['password'], $_CONFIG['db']['base']);
$_CONFIG['usr'] = Config::getList(array('caching','memcache_servers'));
$_CONFIG['usr'] = Config::getAll();

$id_langue_default = Config::get('default_lang');
$langueObj = new Langues($id_langue_default);
$langueObj->setId($id_langue_default);
$langsite = $langueObj->Recherche();
$default_lang = strtolower($langsite['iso_code']);
		
if(!class_exists('Memcache'))
	$_CONFIG['usr']['caching'] == "disk";

//gestion des pages securisées
if(isset($_CONFIG['usr']['securepage'])&&!empty($_CONFIG['usr']['securepage'])){
    $_CONFIG['usr']['securepage'] = unserialize($_CONFIG['usr']['securepage']);
}else $_CONFIG['usr']['securepage']=array();

// Langues (La premiere étant celle par défaut)
$_CONFIG['lang'] = array('FR');

$_TEXT = array();



/** chemins templates **/
$_CONFIG['rootPath'] = ROOT;
$_CONFIG['templatesPath'] = ROOT.'views';
$_CONFIG['templatesCompilPath'] = ROOT.'data/cache/templates';

/** dossiers fichiers (BACK) **/
$_CONFIG['cacheDir']='data/cache/';
$_CONFIG['uploadDir']='data/tmp/';
$_CONFIG['imagesDir']='data/img/';
$_CONFIG['filesDir']='data/files/';
$_CONFIG['habillagesDir']='habillages/';
$_CONFIG['homeDir']='home/';

/** chemins fichiers (FRONT) **/
$_CONFIG['assetPath']='assets/';
$_CONFIG['imagesPath']='img/';

$_CONFIG['urlLang']['FR'] = array();
$_CONFIG['urlLang']['EN'] = array();


$_CONFIG['theme'] = (substr($_SERVER['REQUEST_URI'],0,14)=="/gestion")?'default':'default';
$_CONFIG['admin']['dir'] = '/gestion';
$_CONFIG['admin']['assets'] = $_CONFIG['admin']['dir'].'/assets';
$_CONFIG['admin']['css'] = $_CONFIG['admin']['assets'].'/css/';
$_CONFIG['admin']['js'] = $_CONFIG['admin']['assets'].'/js/';
$_CONFIG['admin']['lib'] = $_CONFIG['admin']['assets'].'/lib/';
$_CONFIG['admin']['img'] = $_CONFIG['admin']['assets'].'/img/';
$_CONFIG['admin']['fonts'] = $_CONFIG['admin']['assets'].'/fonts/';
$_CONFIG['js_plugins'] = 'assets/plugins/';

$session = new Session();
if($_GET['langsite']=="FR") {
	$_CONFIG['mailfrom'] = array('nepasrepondre@decanet.fr', "L'équipe DECANET");
	$_CONFIG['mailreply'] = array('nepasrepondre@decanet.fr', "L'équipe DECANET");
} else {
	$_CONFIG['mailfrom'] = array('nepasrepondre@decanet.fr', "The DECANET Team");
	$_CONFIG['mailreply'] = array('nepasrepondre@decanet.fr', 'The DECANET Team');
}
$_CONFIG['contactTo'] = 'mbidalucalfred@yahoo.fr';
?>