<?php

if(Tools::getIsset('submitMail') || Tools::getIsset('submitMailAndTest'))
{
	Config::set('mail_serveur', Tools::getValue('mail_serveur'));
	Config::set('mail_sitemail', Tools::getValue('mail_sitemail'));
	Config::set('mail_sitemailname', Tools::getValue('mail_sitemailname'));
	Config::set('mail_authentification', Tools::getValue('mail_authentification'));
	Config::set('mail_sercure', Tools::getValue('mail_sercure', 0));
	Config::set('mail_port', Tools::getValue('mail_port'));
	Config::set('mail_user', Tools::getValue('mail_user'));
	Config::set('mail_pwd', Tools::getValue('mail_pwd'));
	Config::set('mail_host', Tools::getValue('mail_host'));
	Tools::setAlert('Mises à jour effectuées avec succès!');
	$to = array();
	$to[] = array('email' => 'mbidalucalfred@yahoo.fr', 'name' => 'MBIDA LUC ALFRED');
	if(Tools::getIsset('submitMailAndTest'))
		if(Mailer::send (null, $to, 'test', 'test du message'))
			Tools::setAlert('La mail test a été envoyé avec succès');
		else
			Tools::setAlert('La mail test a échoué!', 'error');
	//die();
}

$ariane[] = array('lien'=>'', 'titre'=>"Localisation", 'icon'=>'globe');
$langues = Langues::getLangues(1); // sélection des langues actives
$smarty->assign(array(
	'langues' => $langues,
	'configs' =>  Config::getList(array( 'mail_serveur', 'mail_sitemail', 'mail_sitemailname',
		'mail_authentification', 'mail_sercure', 'mail_port', 'mail_user', 'mail_pwd', 'mail_host')),
	));
?>
