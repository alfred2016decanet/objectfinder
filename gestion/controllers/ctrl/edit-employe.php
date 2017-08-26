<?php

$id = isset($_GET['id']) ? $_GET['id'] : 0;

if (((($id > 0) && (!isset($udroits['edit_13_1']))) || (($id == 0) && (!isset($udroits['add_13_1'])))) && !$currentuserinfos['access_all'])
    $s_page = $s_tpl = 'no-access-page';
else {
    $ariane[] = array('lien' => 'index.php', 'titre' => "Accueil", 'icon' => 'home');
    $ariane[] = array('lien' => 'employes.html', 'titre' => "Employés", 'icon' => '');
    $ariane[] = array('lien' => '', 'titre' => ($id ? 'Modifier' : 'Ajouter'), 'icon' => 'edit');

    $langues = Langues::getLangues(1);
    $employeObj = new Staff();
    $thumb_rep = ROOT . 'data/uploads/images/staff';
    $image_path = $thumb_rep;

    if (Tools::getIsset('submitEmploye')) {

        $recdata = Tools::getPOST();
        $recdata['photo'] = Tools::getFileExtension($_FILES['thumbphto']['name']);
        if (!$id) {
            $id = $employeObj->Create();
            $recdata['position'] = Service::getLastPosition((int) $recdata['id_parent']);
            Tools::setAlert('Enregistrement effectué avec succès');
        } else {
            $recdata['date_upd'] = date('Y-m-d');
            Tools::setAlert('Mise à jour effectuée avec succès');
        }
        $employeObj->setId($id);
        $recdata['photo'] = Tools::getFileExtension($_FILES['thumbphto']['name']);
        if ($recdata['photo'])
            upload_thumb($id, $thumb_rep);
        else
            unset ($recdata['photo']);
        $employeObj->Update($recdata, array('id_employe' => $id));
        //mise à jour des positions en DB
        $employeObj->cleanPositions($recdata['id_parent'], $current_etsh);
        header('Location:staff.html');
        die();
    }
    if ($id > 0) {
        $employeObj->setId($id);
        $employe = $employeObj->Recherche();
    } else {
        $employe['id_employe'] = 0;
        if (is_array($langues))
            foreach ($langues as $lang) {
                $employe['biographie'][$lang['id_lang']] = '';
            }
        $employe['active'] = '1';
    }

    $smarty->assign(array(
        'langues' => $langues,
        'default_lang' => Config::get('default_lang'),
        'employe' => $employe,
        'image_path' => URL_BASE . 'data/uploads/images/staff',
    ));
}

function upload_thumb($id, $thumb_rep) {
    $extension_upload = Tools::getFileExtension($_FILES['thumbphto']['name']);
    if (!is_dir($thumb_rep)) {
        $res = mkdir($thumb_rep);
        if (!$res) {
            Tools::setAlert('Erreur lors de la création du repertoire formations', 'error');
            return FALSE;
        }
    }
    $resultat = Tools::addFile('thumbphto', $thumb_rep . '/', true, null, 'default', $id);
    if (!$resultat) {
        Tools::setAlert('Erreur lors du deplacement de l\'image', 'error');
        return FALSE;
    }
}
