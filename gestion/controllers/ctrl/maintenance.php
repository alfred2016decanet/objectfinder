<?php
//if(!isset($usrObj->droits['14_1'])) die("Vous n'avez pas les droits d'accès à cette page");
if(Tools::getIsset('clearcache')) {
	Tools::videCache();
}
if(Tools::getIsset('Enregistrer')) {
	foreach(Tools::getPOST('conf_') as $c=>$v) {
		Config::set($c,$v);
		$_CONFIG['usr'][$c]=$v;
	}
	if(is_file(ROOT.'data/cache/sql/conf.txt'))
		unlink(ROOT.'data/cache/sql/conf.txt');
//	if(count($_CONFIG['usr']['memcache_servers'])>0) {
//		$mem = new Mem('global');
//		$mem->supprime('sql_'.md5(ROOT.'data/cache/sql/conf.txt'));
//		$mem->supprime('sqlt_'.md5(ROOT.'data/cache/sql/conf.txt'));
//	}
	$smarty->assign('s_config', $_CONFIG);
}

?>