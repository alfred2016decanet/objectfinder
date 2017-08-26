<?php

//if(!isset($usrObj->droits['12_0'])) die("Vous n'avez pas les droits d'accès à cette page");
function writeTranslationFile($lang) {
    if (!is_dir(ROOT . 'data/lang'))
        mkdir(ROOT . 'data/lang/', 0777);
    if ($fd = fopen(ROOT . 'data/lang/' . $lang . '.php', 'w')) {
        $toInsert = array();
        foreach ($_POST as $key => $value)
            if (!empty($value) && $key != "envoi")
                $toInsert[$key] = /* htmlentities( */$value/* , ENT_COMPAT, 'UTF-8') */;
        fwrite($fd, "<?php\n\nglobal " . '$_TEXT' . ";\n\n");
        foreach ($toInsert as $key => $value)
            fwrite($fd, '$_TEXT[\'' . $key . '\'] = ' . var_export(str_replace("\n", "<br>", $value), true) . ';' . "\n");
        fwrite($fd, "\n?>");
        fclose($fd);
        Tools::videCache();
    } else
        die('Cannot write language file');
}

function getTranslations($lang) {
    $translations = array();

    if (file_exists(ROOT . 'data/lang/' . $lang . '.php'))
        include_once(ROOT . 'data/lang/' . $lang . '.php');
    $dirname = array();
    $dirname[] = ROOT . 'templates/';
    $dirname[] = ROOT . 'templates/popup/';
    $dirname[] = ROOT . 'templates/default/';
    $dirname[] = ROOT . 'templates/ajax/';
    $dirname[] = ROOT . 'templates/mail/';
    $dirname[] = ROOT . 'templates/rss/';
	$dataexistkey = array();
    foreach ($dirname as $d) {
        $dir = @opendir($d);
        while ($file = @readdir($dir)) {
            if ($file != '.' && $file != '..' && !is_dir($dirname . $file)) {
                $readFd = @fopen($d . $file, 'r');
                $content = (filesize($d . $file) ? @fread($readFd, filesize($d . $file)) : '');
                preg_match_all('/\{l s=[\'"](.*[^\\\\])[\'"]\}/U', $content, $matches);
                @fclose($readFd);
                foreach ($matches[1] as $key) {
					$lacle = md5(addslashes($key));
					if(!in_array($lacle, $dataexistkey))
					{
						if (!is_array($translations[$file][$lacle]))
							$translations[$file][$lacle] = array('nom' => $lacle, 'text' => utf8_decode($key), 'trad' => str_replace("<br>", "\n", $_TEXT[$lacle]));
						$dataexistkey[] = $lacle;
					}
                }
            }
        }
        @closedir($dir);
    }
    $dirname = array();
    $dirname[] = ROOT;
    $dirname[] = ROOT . 'php/ctrl/';
    foreach ($dirname as $d) {
        $dir = @opendir($d);
        while ($file = @readdir($dir)) {
            if ($file != '.' && $file != '..' && !is_dir($d . $file) && Tools::getFileExtension($d . $file) == "php") {
                $readFd = fopen($d . $file, 'r');
                $content = (filesize($d . $file) ? fread($readFd, filesize($d . $file)) : '');
                preg_match_all('/Lang::l\([\'"]([^\']+)[\'"]\)/', $content, $matches);
                @fclose($readFd);
                foreach ($matches[1] as $key) {
                    if (!is_array($translations[$file][md5(addslashes($key))]))
                        $translations[$file][md5($key)] = array('nom' => md5($key), 'text' => $key, 'trad' => str_replace("<br>", "\n", $_TEXT[md5($key)]));
                }
            }
        }
        @closedir($dir);
    }
    return $translations;
}

$smarty->assign('langues', Langues::getLangues());
if (Tools::getIsset('lang')) {
    if (isset($_POST['envoi'])) {
        writeTranslationFile(Tools::getValue('lang'));
    }
    $smarty->assign('lang', Tools::getValue('lang'));
    $smarty->assign('translations', getTranslations(Tools::getValue('lang')));
}
?>