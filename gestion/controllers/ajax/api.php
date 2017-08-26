<?php

/*
 * api actions entités : suppression, changement ordre, toggle statut...
 */
require_once('../../../config/config.php');


//////////////////
// SUPPRESSIONS //
//////////////////
if ($_GET['action'] == 'supprime') {
    switch ($_GET['type']) {
        ////////////	
        //CONTENUS//
        ////////////
        case 'groupe':
            $myObj = new Groupe();
            $args = array('id' => $_GET['id']);
            break;
        case 'langue':
            $myObj = new Langues();
            $args = array('id_lang' => $_GET['id']);
            break;
        case 'gestionnaire':
            $myObj = new Administrateur(false);
            $args = array('id' => $_GET['id']);
            break;
        case 'service':
            $myObj = new Service();
            $args = array('id_service' => $_GET['id']);
            break;
        case 'url':
            $myObj = new URL();
            $args = array('id_url' => $_GET['id']);
            break;
        case 'article':
            $myObj = new Article();
            $args = array('id_artcle' => $_GET['id']);
            break;
        case 'category':
            $myObj = new Category();
            $args = array('id_category' => $_GET['id']);
            break;
        case 'formation':
            $myObj = new Formation();
            $args = array('id_formation' => $_GET['id']);
            break;
        case 'cible':
            $myObj = new Cible();
            $args = array('id_cible' => $_GET['id']);
            break;
        case 'formationSession':
            $myObj = new FormationSession();
            $args = array('id_session' => $_GET['id']);
            break;
        case 'annuaire':
            $myObj = new Annuaire();
            $args = array('id_annuaire' => $_GET['id']);
            break;
        case 'newsletters':
            $myObj = new Newsletter();
            $args = array('id_newsletter' => $_GET['id']);
            break;
        case 'agenda':
            $myObj = new Agenda();
            $args = array('id_agenda' => $_GET['id']);
            break;
        case 'inscriptions':
            $myObj = new UserSite();
            $args = array('id' => $_GET['id']);
            break;
        case 'recrutement':
            $myObj = new Recrutement();
            $args = array('id_recrutement' => $_GET['id']);
            break;
        case 'staff':
            $myObj = new Staff();
            $args = array('id_employe' => $_GET['id']);
            break;
        case 'agenda_general':
            $myObj = new AgendaGeneral();
            $args = array('id_agenda_general' => $_GET['id']);
            break;
    }

    $ret = $myObj->Delete($args);
    Tools::videCache();
    if ($ret)
        $return = 'ok';
}

//cache IE//
header("Pragma: no-cache");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
die("$return");
?>
