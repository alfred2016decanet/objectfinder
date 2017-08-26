<?php

$smarty->caching = false;
$smarty->setTemplateDir(_RTEMPLATES_DIR);
if(!is_dir(ROOT.'data/cache'))mkdir(ROOT.'data/cache/',0777);
if(!is_dir(ROOT.'data/cache/templates'))mkdir(ROOT.'data/cache/templates',0777);
if(!is_dir(ROOT.'data/cache/templates/admin_c'))mkdir(ROOT.'data/cache/templates/admin_c/',0777);
if(!is_dir(ROOT.'data/cache/templates/admin'))mkdir(ROOT.'data/cache/templates/admin/',0777);
$smarty->setCompileDir(ROOT.'data/cache/templates/admin_c/');

if(Tools::getIsset('debug'))$smarty->debugging = true;

require_once(ROOT.'config/smarty.plugins.php');
?>