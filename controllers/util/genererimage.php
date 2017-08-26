<?php
require_once('../../config/config.php');
require_once('../../libs/smarty/Smarty.class.php');
require_once('../inc/autoload.php');

$userObj=new UserSite();
$userDatas=$userObj->getUser(); 

$font = ROOT.$_CONFIG['assetPath'].'css/cabin-regular-webfont.ttf';
$font_bold = ROOT.$_CONFIG['assetPath'].'css/cabin-bold-webfont.ttf';

header("Content-type: image/png"); 


if($_GET['type']==1){
	$img = imagecreatetruecolor (574,408);
	$grey = imagecolorallocate($img, 91, 91, 91);
	$from = imagecreatefrompng(ROOT.$_CONFIG['assetPath'].'img/fond_574_408.png');
	imagecopy($img, $from, 0,0,0,0,574,408);
	imagedestroy($from);
	$avatar = imagecreatefromjpeg(ROOT.$_CONFIG['imagesDir'].$_CONFIG['avatarDir'].$userDatas['avatar']);
	$avatar = imagerotate($avatar, -5, -1);
	imagecopyresampled($img,$avatar,30,50,0,0,218,291,289,387);
	imagedestroy($avatar);
	imagettftext($img, 14, -5, 80, 350, $grey, $font_bold, $userDatas['login']);
	imagettftext($img, 30, 10, 270, 200, $grey, $font_bold, 'REJOINS - MOI');
	imagettftext($img, 20, 7, 360, 220, $grey, $font_bold, 'SUR');
	$logo = imagecreatefrompng(ROOT.$_CONFIG['assetPath'].'img/Bonus/logo_mail_incline.png');
	imagecopy($img, $logo, 280,210,0,0,253,79);
	imagedestroy($logo);
}
elseif($_GET['type']==2){
	$img = imagecreatefromjpeg(ROOT.$_CONFIG['assetPath'].'img/fond.jpg');
	$avatar = imagecreatefromjpeg(ROOT.$_CONFIG['imagesDir'].$_CONFIG['avatarDir'].$userDatas['avatar']);
	imagecopyresampled($img,$avatar,543,150,0,0,355,500,259,365);
	imagedestroy($avatar);
	$logo = imagecreatefrompng(ROOT.$_CONFIG['assetPath'].'img/Bonus/logo_mail.png');
	imagecopy($img, $logo, 600,700,0,0,250,41);
	imagedestroy($logo);
}
else {
	$img = imagecreatetruecolor (574,408);
	$grey = imagecolorallocate($img, 91, 91, 91);
	$from = imagecreatefrompng(ROOT.$_CONFIG['assetPath'].'img/fond_574_408.png');
	imagecopy($img, $from, 0,0,0,0,574,408);
	imagedestroy($from);
	$avatar = imagecreatefromjpeg(ROOT.$_CONFIG['imagesDir'].$_CONFIG['avatarDir'].$userDatas['avatar']);
	imagecopyresampled($img,$avatar,90,70,0,0,195,275,259,365);
	imagedestroy($avatar);
	$logo = imagecreatefrompng(ROOT.$_CONFIG['assetPath'].'img/Bonus/logo_mail_mini.png');
	imagecopy($img, $logo, 340,367,0,0,200,33);
	imagedestroy($logo);
	
	imagettftext($img, 20, 0, 310, 200, $grey, $font_bold, $userDatas['login']);
	imagettftext($img, 18, 0, 310, 230, $grey, $font, $userDatas['pass']);

}
imagepng($img);
imagedestroy($img);
?>