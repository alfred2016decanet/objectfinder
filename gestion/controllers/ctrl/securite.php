<?php
if(!$currentuserinfos['access_all'])
    $s_page = $s_tpl = 'no-access-page';
	
if(Tools::getIsset('Enregistrer')) {
	foreach(Tools::getPOST('conf_') as $c=>$v) {
        if(is_array($v))
            Config::set($c,serialize($v));
        else
            Config::set($c,$v);
		$_CONFIG['usr'][$c]=$v;
	}
	if(is_file(ROOT.'data/cache/sql/conf.txt'))
		unlink(ROOT.'data/cache/sql/conf.txt');
	
	$smarty->assign('s_config', $_CONFIG);
}
$pages = array();
$except = array('header','footer');
foreach(glob(dirname(__FILE__).'/../../../templates/*.tpl') as $file) {
    $namefile = str_replace(dirname(__FILE__).'/../../../templates/', '', substr($file,0,-4));
    if(!in_array($namefile, $except))
        $pages[] = array('nom'=>$namefile);
}
// die(var_dump($referencement[0]));

//assigns smarty//
$smarty->assign('pages', $pages);
?>