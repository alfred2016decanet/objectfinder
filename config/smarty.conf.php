<?php
if(intval($_CONFIG['usr']['smarty_cache'])==1) {
	$smarty->caching = intval($_CONFIG['usr']['smarty_cache']);
	$smarty->setCaching(Smarty::CACHING_LIFETIME_SAVED);
	$smarty->cache_lifetime = (intval($_CONFIG['usr']['smarty_cachetime'])>0) ? intval($_CONFIG['usr']['smarty_cachetime']) : 3600;
	$smarty->setCompileCheck(false);
} else
	$smarty->setCaching(Smarty::CACHING_OFF);
$smarty->setTemplateDir(_RTEMPLATES_DIR);
if(!is_dir(ROOT.'data/cache'))mkdir(ROOT.'data/cache/', 0777);
if(!is_dir(ROOT.'data/cache/templates'))mkdir(ROOT.'data/cache/templates', 0777);
if(!is_dir(ROOT.'data/cache/templates/front_c'))mkdir(ROOT.'data/cache/templates/front_c/', 0777);
if(!is_dir(ROOT.'data/cache/templates/front'))mkdir(ROOT.'data/cache/templates/front/', 0777);
$smarty->setCompileDir(ROOT.'data/cache/templates/front_c/');
$smarty->setCacheDir(ROOT.'data/cache/templates/front/');
if($_CONFIG['usr']['caching']=="memcache") {
	$smarty->registerCacheResource('memcache', new Memcache_Smarty());
	$smarty->caching_type = 'memcache';
}
if(Tools::getIsset('debug'))$smarty->debugging = true;
$smarty->force_compile = intval($_CONFIG['usr']['smarty_forcecompile']);
require_once(dirname(__FILE__).'/smarty.plugins.php');
?>