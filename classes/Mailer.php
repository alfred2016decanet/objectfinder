<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Mailer
{
    public static function send($from=null, array $to, $subject='', $message='', $template = "default.html", $directory = SITE_MAIL_TPL_DIR)
	{
		global $_CONFIG;

		//var_dump($directory); die();
		$mailconfig = $_CONFIG['usr'];
		//var_dump($_CONFIG);
		if(file_exists($directory.$template))
            $body = file_get_contents($directory.$template);
        else 
            $body = file_get_contents($directory.'email.html');
        
        $body = str_replace('{MSG}', $message, $body);
        $body = str_replace('{TITRE}', htmlentities($subject), $body);

        $monmailer = new PHPMailer();
        $subject = Tools::decode($subject);
		//die(var_dump($mailconfig['mail_serveur']));
        switch ($mailconfig['mail_serveur'])
        {
            case 'phpmail':
                $monmailer->isMail();
                break;
            case 'sendmail':
                $monmailer->isSendmail();
                break;
            case 'smtp':
                $monmailer->isSMTP();
				//$monmailer->SMTPDebug = 2;
                break;
        }

        if($mailconfig['mail_authentification'])
        {
            $monmailer->SMTPAuth = true;
            $monmailer->Username = $mailconfig['mail_user'];
            $monmailer->Password = $mailconfig['mail_pwd'];
        }

        if(!empty($mailconfig['mail_sercure']))
            $monmailer->SMTPSecure = $mailconfig['mail_sercure'];

        $monmailer->Host = $mailconfig['mail_host'];
        $monmailer->Port = $mailconfig['mail_port'];
		
		if($from)
		{
			$monmailer->From = $from['email'];
			$monmailer->FromName = $from['name'];
		}
		else{
			$monmailer->From = $mailconfig['mail_sitemail'];
			$monmailer->FromName = $mailconfig['mail_sitemailname'];
		}
        
        $monmailer->Subject = $subject;

        $monmailer->WordWrap = 50;

		//var_dump($monmailer); die();
        $monmailer->msgHTML($body);
        //var_dump($body); die();
        $monmailer->addReplyTo('mbidalucalfred@yahoo.fr', 'Luc Alfred mbida');
        
        foreach ($to as $dest)
            $monmailer->addAddress($dest['email'], $dest['name']);

        $monmailer->isHTML(true);

        if(!$monmailer->send())
            return 0;
        else
            return 1;
    }
}