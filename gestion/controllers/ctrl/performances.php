<?php
if(!$currentuserinfos['access_all'])
    $s_page = $s_tpl = 'no-access-page';
if(Tools::getIsset('Enregistrer')) {
	foreach(Tools::getPOST('conf_') as $c=>$v) {
		Config::set($c,$v);
		$_CONFIG['usr'][$c]=$v;
	}
	if(count($_POST['memcache'])>0) {
		Config::set('memcache_servers', json_encode($_POST['memcache']));
	}
	if(is_file(ROOT.'data/cache/sql/conf.txt'))
		unlink(ROOT.'data/cache/sql/conf.txt');
	if(count($_CONFIG['usr']['memcache_servers'])>0) {
		$mem = new Mem('sql');
		$mem->supprime('sql_'.md5(ROOT.'data/cache/sql/conf.txt'));
		$mem->supprime('sqlt_'.md5(ROOT.'data/cache/sql/conf.txt'));
	}
	$smarty->assign('s_config', $_CONFIG);
}
if(isset($_CONFIG['usr']['memcache_servers'])) {
	if(!is_array($_CONFIG['usr']['memcache_servers']))
		$smarty->assign('memcache_servers', json_decode($_CONFIG['usr']['memcache_servers']));
	else
		$smarty->assign('memcache_servers', $_CONFIG['usr']['memcache_servers']);
}
?>