<?php

	abstract class Tools 
	{
		static $errors=array();
		function ChaineAleatoire($nbcar)
		{
			$chaine = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			srand((double)microtime()*1000000);
			$variable='';
			for($i=0; $i<$nbcar; $i++) $variable .= $chaine{rand()%strlen($chaine)};
			return $variable;
		}

		static public function get_ip()
		{
			if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){ 
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];} 
			elseif(isset($_SERVER['HTTP_CLIENT_IP'])){ 
				$ip = $_SERVER['HTTP_CLIENT_IP'];} 
			else
			{
				$ip = $_SERVER['REMOTE_ADDR'];
			} 
			if(strpos($ip,','))
				$ip = trim(substr($ip,strpos($ip,',')+1));
			return $ip;
		}

		static public function Tronquer_Texte($texte, $longeur_max)
		{
			if (strlen($texte) > $longeur_max) 
			{ 
				$texte = substr($texte, 0, $longeur_max); 
				$dernier_espace = strrpos($texte, " "); 
				$texte = substr($texte, 0, $dernier_espace)."..."; 
			} 
			return $texte;
		}

		static public function go($url)
		{
			header('Location: '.$url);
			exit;
		}

		static public function goPerm($url)
		{
			header("Status: 301 Moved Permanently", false, 301);
			header("location: ".$url);
			exit();
		}

		static public function getValue($key, $defaultValue = false)
		{
			if (!isset($key) OR empty($key) OR !is_string($key))
				return false;
			$ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $defaultValue));

			if (is_string($ret) === true)
				$ret = urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret)));
			return !is_string($ret)? $ret : stripslashes($ret);
		}

		static public function getSValue($key)
		{
			$string = self::getValue($key);
			$string = addslashes($string);
			$string = strip_tags($string);
			$string = str_replace(array("\r\n", "\r", "\n"), '<br>', $string);
			return $string;
		}

		static public function getIsset($key)
		{
			if (!isset($key) OR empty($key) OR !is_string($key))
				return false;
			return isset($_POST[$key]) ? true : (isset($_GET[$key]) ? true : false);
		}

		static public function erreur($string)
		{
			$string = "<pre>ERREUR : ".$string."</pre>";
			return $string;
		}

		static public function test() {
			echo "<script>alert('ok');</script>";	
		}

		static public function error($string) {
			global $smarty;
			$smarty->assign('resultat',Tools::erreur($string));
		}

		static public function ok($string) {
			global $smarty;
			$smarty->assign('resultat',"<pre class='ok'>".$string."</pre>");
		}

		static public function checkMail($mail) {
			return filter_var($mail, FILTER_VALIDATE_EMAIL);	
		}

		static public function getURL($str) {
			$str = strtr($str, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"); 
			return mb_strtolower(preg_replace(array('/[^a-zA-Z0-9 \'-]/', '/[ -\']+/', '/^-|-$/'), array('', '-', ''), $str));
		}

		static public function minifyCSS( $css ){
			/* remove comments */
			$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
			/* remove tabs, spaces, newlines, etc. */
			$css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
			return $css;
		}

		static public function minifyJS($js) {
			$jsmin = new JSMin($js);
			return $jsmin->min();
		}

		public static function sendMail($email, $sujet, $message, $template = 1, $from=false, $replyTo=false)
		{
			global $_CONFIG;

			if(!$from)
				$from = $_CONFIG['mailfrom'];
			if(!$replyTo)
				$replyTo = $_CONFIG['mailreply'];

			if(PHPMailer::ValidateAddress($email)){
				$smarty = new Smarty;
				$smarty->template_dir=$_CONFIG['templatesPath'];
				$smarty->compile_dir=$_CONFIG['templatesCompilPath'];

				$smarty->assign('contenu_mail', $message);
				$smarty->assign('base_url', 'http://'.$_SERVER['HTTP_HOST']);

				if($template==1)$html=$smarty->fetch(ROOT.'/templates/mail/email.tpl');
				else $html=$message;

				$mail = new PHPMailer(false);
				
				if(!empty($_CONFIG['mail']['secure']))
					$mail->SMTPSecure = $_CONFIG['mail']['secure'];
				$mail->AddReplyTo($replyTo[0], $replyTo[1]);
				$mail->SetFrom($from[0], $from[1]);
				$mail->AddAddress($email);
				$mail->Subject = $sujet;
				
				$mail->MsgHTML($html);
				if($mail->Send()) return true; else return false;
			}
			return false;
		}

		static public function nettoieTxt($string) {
			$string = trim($string);
			$string = preg_replace("/\x92/", "'",$string);
			$string = preg_replace("/\x93/", '"',$string);
			$string = preg_replace("/\x94/", '"',$string);
			//$string = preg_replace("/style=\"[^\"]+\"/", "",$string);
			$string = str_replace('“', '"', $string);
			$string = str_replace('”', '"', $string);
			$string = str_replace('’', '"', $string);
			$string = str_replace('
			', '', $string);
		//	$string = str_replace('&nbsp;', ' ', $string);
			$string = preg_replace('#[[:space:]]{2,}#i', ' ', $string);
			$string = preg_replace('#<p[^>]+>#', '<p>', $string);
			if(strpos(substr($string, 0,14), '&nbsp;'))
			$string = substr($string, 14);
			return trim($string);
		}

		public static function nom_web($s, $sep="-"){
			if (trim($s) != ''){
				$s=str_replace('&','et', $s);
				$s=str_replace('+','plus', $s);
				$s=Tools::vire_ponctuation($s);

				$exclu=array('de', 'le', 'la', 'les', 'un', 'une', 'des', 'du', 'au', 'à', 'en', 'the', '.', 'l');

				$lettreok=" abcdefghijklmnopqrstuvwxyz0123456789";   

				/*$s=strtr(strtolower($s), "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
			"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");*/

				$tab2replace=array('À','Á','Â','Ã','Ä','Å','à','á','â','ã','ä','å','Ò','Ó','Ô','Õ','Ö','Ø','ò','ó','ô','õ','ö','ø','È','É','Ê','Ë','è','é','ê','ë','Ç','ç','Ì','Í','Î','Ï','ì','í','î','ï','Ù','Ú','Û','Ü','ù','ú','û','ü','ÿ','Ñ','ñ', 'œ');
				$tab_replace=array('a','a','a','a','a','a','a','a','a','a','a','a','o','o','o','o','o','o','o','o','o','o','o','o','e','e','e','e','e','e','e','e','c','c','i','i','i','i','i','i','i','i','u','u','u','u','u','u','u','u','y','n','n', 'oe');
				$s=str_replace($tab2replace, $tab_replace, $s);

				$s=strtolower($s);

				$r="";

				$s=str_replace('  ', ' ', $s);

				for ($i=0;$i<strlen($s);$i++) if (strpos($lettreok, $s[$i])>0) $r.=$s[$i]; else $r.=' ';

				$e1=explode(' ', $r);

				foreach($e1 as $v){
					if ($v<>'' and !in_array($v, $exclu)) $e2[]=$v;
				}

				if(count($e2)>0){
					return implode($sep,$e2);
				}else{
					return '';
				}
			}else{
				return '';
			}

		} 

		public static function vire_accents($str) {
			$tab2replace=array('À','Á','Â','Ã','Ä','Å','à','á','â','ã','ä','å','Ò','Ó','Ô','Õ','Ö','Ø','ò','ó','ô','õ','ö','ø','È','É','Ê','Ë','è','é','ê','ë','Ç','ç','Ì','Í','Î','Ï','ì','í','î','ï','Ù','Ú','Û','Ü','ù','ú','û','ü','ÿ','Ñ','ñ', 'œ');
			$tab_replace=array('a','a','a','a','a','a','a','a','a','a','a','a','o','o','o','o','o','o','o','o','o','o','o','o','e','e','e','e','e','e','e','e','c','c','i','i','i','i','i','i','i','i','u','u','u','u','u','u','u','u','y','n','n', 'oe');
			return str_replace($tab2replace, $tab_replace, $str);
		}

		public static function vire_ponctuation($str){
			$tab_ponct=array('.', ',','?','?',':','!','%',';','«','»');

			return str_replace($tab_ponct, '', $str);
		}

		public static function getFileExtension($fic){
			return substr($fic, strrpos($fic, '.')+1);
		}

		public static function getNomWebFile($fic){
			$ext=self::getFileExtension($fic);

			$nom_web=self::nom_web(substr($fic, 0, strripos($fic, ".$ext"))).'.'.strtolower($ext);
			return $nom_web;
		}

		public static function getPOST($prefix="form_") {
			$updates = array();
			foreach($_POST as $k=>$v) {
				if(substr($k,0,strlen($prefix))==$prefix)
					$updates[str_replace($prefix,'',$k)] = $v;
			}
			return $updates;
		}

		public static function getGET($prefix="form_") {
			$updates = array();
			foreach($_GET as $k=>$v) {
				if(substr($k,0,strlen($prefix))==$prefix)
					$updates[str_replace($prefix,'',$k)] = $v;
			}
			return $updates;
		}	

		public static function microtime_float($micro = false)
		{
			if(!$micro)
			$micro = microtime();
			list($usec, $sec) = explode(" ", $micro);
			return ((float)$usec + (float)$sec);
		}

		public static function escape($str) {
			$str = get_magic_quotes_gpc()?stripslashes($str):$str;
			$str = mysql_real_escape_string($str);
			return $str;
		}

		public static function test_speed() {
			global $timestart;
			return round(((Tools::microtime_float()-Tools::microtime_float($timestart))*100),5).' ms';
		}

		public static function Array2Select($input, $key, $value, $zero=true, $sep=' -> ', $zero_value='---'){
			$output=array();
			if($zero){$output['']=$zero_value;}
			if(count($input)>0){
				foreach($input as $data){
					if($data[$key]=='')continue;
					if(is_array($value)){
						$tab=array();
						foreach($value as $val){$tab[]=$data[$val];}
						$v=implode($sep, $tab);
					}
					else{
						$v=$data[$value];
					}
					$output[$data[$key]]=$v;
				}
			}

			return $output;
		}

		static public function videCache() {
			global $smarty, $_CONFIG;
			$smarty->clearAllCache();
			if($_CONFIG['usr']['caching']=="disk") {
				$files = glob(ROOT.'/data/cache/sql/*');
				if(is_array($files) && count($files)>0) {
				foreach($files as $file){
				  if(is_file($file))
					@unlink($file);
				}
				}
				$files = glob(ROOT.'/data/cache/templates/front/*');
				if(is_array($files) && count($files)>0) {
				foreach($files as $file){
				  if(is_file($file))
					@unlink($file);
				}
				}
				$files = glob(ROOT.'/data/cache/templates/front_c/*');
				if(is_array($files) && count($files)>0) {
				foreach($files as $file){
				  if(is_file($file))
					@unlink($file);
				}
				}
				$files = glob(ROOT.'/data/cache/templates/admin/*');
				if(is_array($files) && count($files)>0) {
				foreach($files as $file){
				  if(is_file($file))
					@unlink($file);
				}
				}
				$files = glob(ROOT.'/data/cache/templates/admin_c/*');
				if(is_array($files) && count($files)>0) {
				foreach($files as $file){
				  if(is_file($file))
					@unlink($file);
				}
				}
			}
			else 
			{
				if(count($_CONFIG['usr']['memcache_servers'])>0) {
					$mem = new Mem('smarty');
					$mem->deconnecter();
					$mem = new Mem('sql');
					$mem->deconnecter();
				}
			}
		}

		static public function getBrowser() 
		{ 
			$u_agent = $_SERVER['HTTP_USER_AGENT']; 
			$bname = 'Unknown';
			$platform = 'Unknown';
			$version= "";

			//First get the platform?
			if (preg_match('/linux/i', $u_agent)) {
				$platform = 'linux';
			}
			elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
				$platform = 'mac';
			}
			elseif (preg_match('/windows|win32/i', $u_agent)) {
				$platform = 'windows';
			}

			// Next get the name of the useragent yes seperately and for good reason
			if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
			{ 
				$bname = 'Internet Explorer'; 
				$ub = "MSIE"; 
			} 
			elseif(preg_match('/Firefox/i',$u_agent)) 
			{ 
				$bname = 'Mozilla Firefox'; 
				$ub = "Firefox"; 
			} 
			elseif(preg_match('/Chrome/i',$u_agent)) 
			{ 
				$bname = 'Google Chrome'; 
				$ub = "Chrome"; 
			} 
			elseif(preg_match('/Safari/i',$u_agent)) 
			{ 
				$bname = 'Apple Safari'; 
				$ub = "Safari"; 
			} 
			elseif(preg_match('/Opera/i',$u_agent)) 
			{ 
				$bname = 'Opera'; 
				$ub = "Opera"; 
			} 
			elseif(preg_match('/Netscape/i',$u_agent)) 
			{ 
				$bname = 'Netscape'; 
				$ub = "Netscape"; 
			} 

			// finally get the correct version number
			$known = array('Version', $ub, 'other');
			$pattern = '#(?<browser>' . join('|', $known) .
			')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
			if (!preg_match_all($pattern, $u_agent, $matches)) {
				// we have no matching number just continue
			}

			// see how many we have
			$i = count($matches['browser']);
			if ($i != 1) {
				//we will have two since we are not using 'other' argument yet
				//see if version is before or after the name
				if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
					$version= $matches['version'][0];
				}
				else {
					$version= $matches['version'][1];
				}
			}
			else {
				$version= $matches['version'][0];
			}

			// check if we have a number
			if ($version==null || $version=="") {$version="?";}

			return array(
				'userAgent' => $u_agent,
				'name'      => $bname,
				'version'   => $version,
				'platform'  => $platform,
				'pattern'    => $pattern
			);
		} 

		static public function decode($string) {
			if (preg_match('!!u', $string))
			{
			   return utf8_decode($string);
			}
			else 
			{
			   return $string;
			}
		}

		static public function encode($string)
		{
			if (preg_match('!!u', $string))
			{
			   return $string;
			}
			else 
			{
			   return utf8_encode($string);
			}
		} 

		static public function est_requete_ajax(){
			return isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
		}

		public static function addFile($source, $destination = null, $multiple=true, $filePost=null,$type='default',$namefinal=null)
		{     
			 if(!is_dir(dirname(__FILE__).'/../../data/tmp/'))@mkdir(dirname(__FILE__).'/../../data/tmp/',0777);
			 if(!$destination)$destination=dirname(__FILE__).'/../../data/tmp/';
			 if(!is_dir(dirname(__FILE__).'/../../data/img/'))@mkdir(dirname(__FILE__).'/../../data/img/',0777);
			 if(!is_dir(dirname(__FILE__).'/../../data/img/actualite/'))@mkdir(dirname(__FILE__).'/../../data/img/actualite/',0777);
			 if(!is_dir(dirname(__FILE__).'/../../data/img/courses/'))@mkdir(dirname(__FILE__).'/../../data/img/courses/',0777);
			 if(!is_dir(dirname(__FILE__).'/../../data/users/'))@mkdir(dirname(__FILE__).'/../../data/users/',0777);
			 if(!is_dir(dirname(__FILE__).'/../../data/resultats/'))@mkdir(dirname(__FILE__).'/../../data/resultats/',0777);
			 if(!is_dir($destination))@mkdir($destination,0777);
			if(empty($_FILES[$source]['tmp_name'])){
				if(isset($_POST[$filePost]))
					return $_POST[$filePost];
				return false ;
			}
			$fichier = basename($_FILES[$source]['name']);
			$path_parts = pathinfo($_FILES[$source]['tmp_name']);
			$filename = $path_parts['filename'];
			$taille_maxi = 20971520; //2Mo
			$taille = filesize($_FILES[$source]['tmp_name']);
			$extensions = array('.GIF','.JPEG','.JPG','.PNG','.png', '.gif', '.jpg', '.jpeg');
			$extensions_otherFile = array('.SWF','.swf','.PDF','.pdf','.CSV','.csv');
			$extension = strrchr($_FILES[$source]['name'], '.');
			//Début des vérifications de sécurité...
			if((!in_array($extension, $extensions) && !in_array($extension, $extensions_otherFile)))
				self::$errors[] = 'Aucune xtension trouvée';
			if($taille>$taille_maxi)
				 self::$errors[] = 'fichier trop volumineux  doit être <= 20Mo';
			if(!sizeof(self::$errors)){

				$fichier = date('dmYHis').strtr($fichier,'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
				$fichier = preg_replace('/([^.a-z0-9]+)/i', '', $fichier);
				if($namefinal!=null)
					$fichier = $namefinal.substr($fichier, strlen($fichier)-4);
				if(file_exists($destination . $fichier))@unlink($destination . $fichier);
				if(move_uploaded_file($_FILES[$source]['tmp_name'], $destination . $fichier)){
					//si c'est une image et que l'on souhaite créé les miniatures
					if(in_array($extension, $extensions) && $multiple){
						$tabArrayVal = self::getArrayWidthHeight($type);
						foreach ($tabArrayVal as $key => $value)
							self::imageResize($destination . $fichier, $destination . $key.$fichier, $value['width'], $value['height']);
					}
					return $fichier ;
				}else
					return self::$errors[] = _ERROR_UPLOADING_;                
			}else
				return self::$errors;
		}

		/**
		 *
		 * @param type $sourceFile
		 * @param type $destFile
		 * @param type $destWidth
		 * @param type $destHeight
		 * @param string $fileType
		 * @return boolean 
		 */
		public static function imageCrop($sourceFile, $destFile, $destWidth, $destHeight, $fileType = 'jpg', $Xcord, $Ycoord, $Wcoord, $Hcoord )
		{
			if (!file_exists($sourceFile))
				return false;
			list($sourceWidth, $sourceHeight, $type, $attr) = getimagesize($sourceFile);

			if ($type == IMAGETYPE_PNG)
				$fileType = 'png';
			$sourceImage = self::createSrcImage($type, $sourceFile);
			$destImage = imagecreatetruecolor($destWidth, $destHeight);  
			imagecopyresampled($destImage, $sourceImage, 0, 0, $Xcord, $Ycoord, $destWidth, $destHeight, $Wcoord, $Hcoord);
			return (self::returnDestImage($fileType, $destImage, $destFile));
		}
		public static function imageResize($sourceFile, $destFile, $destWidth = NULL, $destHeight = NULL, $fileType = 'jpg')
		{
			if (!file_exists($sourceFile))
				return false;
			list($sourceWidth, $sourceHeight, $type, $attr) = getimagesize($sourceFile);
			// If PS_IMAGE_QUALITY is activated, the generated image will be a PNG with .jpg as a file extension.
			// This allow for higher quality and for transparency. JPG source files will also benefit from a higher quality
			// because JPG reencoding by GD, even with max quality setting, degrades the image.
			if ($type == IMAGETYPE_PNG)
				$fileType = 'png';

			if (!$sourceWidth)
				return false;
			if ($destWidth == NULL) $destWidth = $sourceWidth;
			if ($destHeight == NULL) $destHeight = $sourceHeight;

			$sourceImage = self::createSrcImage($type, $sourceFile);
			$widthDiff = $destWidth / $sourceWidth;
			$heightDiff = $destHeight / $sourceHeight;

			if ($widthDiff > 1 AND $heightDiff > 1)
			{
				$nextWidth = $sourceWidth;
				$nextHeight = $sourceHeight;
			}
			else
			{
				if ($widthDiff > $heightDiff)
				{
					$nextHeight = $destHeight;
					$nextWidth = round(($sourceWidth * $nextHeight) / $sourceHeight);
					//$destWidth =  $nextWidth;
		//                var_dump($nextWidth);
		//                var_dump($nextHeight); die();
				}
				else
				{
					$nextWidth = $destWidth;
					$nextHeight = round($sourceHeight * $destWidth / $sourceWidth);
					//$destHeight = $nextHeight;
				}
			}



			$destImage = imagecreatetruecolor($destWidth, $destHeight);

			// If image is a PNG and the output is PNG, fill with transparency. Else fill with white background.
			if ($fileType == 'png' && $type == IMAGETYPE_PNG)
			{
				imagealphablending($destImage, false);
				imagesavealpha($destImage, true);	
				$transparent = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
				imagefilledrectangle($destImage, 0, 0, $destWidth, $destHeight, $transparent);
			}else
			{
				$white = imagecolorallocate($destImage, 255, 255, 255);
				imagefilledrectangle($destImage, 0, 0, $destWidth, $destHeight, $white);
			}      

			imagecopyresampled($destImage, $sourceImage, (int)(($destWidth - $nextWidth) / 2), (int)(($destHeight - $nextHeight) / 2),  0, 0, $nextWidth, $nextHeight, $sourceWidth, $sourceHeight);

			return (self::returnDestImage($fileType, $destImage, $destFile));
		}

		/**
		 * generate image
		 * @param type $type
		 * @param type $ressource
		 * @param type $filename
		 * @return type 
		 */
		public static function returnDestImage($type, $ressource, $filename)
		{
			$flag = false;
			switch ($type)
			{
				case 'gif':
					$flag = imagegif($ressource, $filename);
					break;
				case 'png':
					$quality = 7 ;
					$flag = imagepng($ressource, $filename, (int)$quality);
					break;		
				case 'jpg':
				case 'jpeg':
				default:
					$quality = 90 ;
					$flag = imagejpeg($ressource, $filename, (int)$quality);
					break;
			}
			imagedestroy($ressource);
			@chmod($filename, 0664);
			return $flag;
		}

		/**
		 *
		 * @param type $type
		 * @param type $filename
		 * @return type 
		 */
		public static function createSrcImage($type, $filename)
		{
			switch ($type)
			{
				case 1:
					return imagecreatefromgif($filename);
					break;
				case 3:
					return imagecreatefrompng($filename);
					break;
				case 2:
				default:
					return imagecreatefromjpeg($filename);
					break;
			}
		}

		 /**
		 * return array of differents value of image width
		 * @return int 
		 */
		public static function getArrayWidthHeight($type){
			$out = array();
			switch ($type) {
				case 'actualite':
					$out = array('actualite'=>array('width'=>1000,'height'=>1000));
					break;
				case 'encartpub':
					$out = array('encartpub'=>array('width'=>1000,'height'=>1000));
					break;
				case 'slider':
					$out = array('slider'=>array('width'=>800,'height'=>800));
					break;
				case 'membre':
					$out = array('membre'=>array('width'=>300,'height'=>400));
					break;
				case 'slide':
					$out = array('slide'=>array('width'=>900,'height'=>900));
					break;
				default:
					$out = array('actualite'=>array('width'=>600,'height'=>374));
					break;
			}
			return $out;
		}
		
		/**
		 * Helper displaying error message(s)
		 * @param string|array $error
		 * @return string
		 */
		public static function displayError($error)
		{

			$output = '
			<div class="bootstrap">
			<div class="module_error alert alert-danger" >
				<button type="button" class="close" data-dismiss="alert">&times;</button>';

			if (is_array($error))
			{
				$output .= '<ul>';
				foreach ($error as $msg)
					$output .= '<li>'.$msg.'</li>';
				$output .= '</ul>';
			}
			else
				$output .= $error;

			// Close div openned previously
			$output .= '</div></div>';
			return $output;
		}

		/**
		* Helper displaying warning message(s)
		* @param string|array $error
		* @return string
		*/
		public static function displayWarning($warning)
		{
			$output = '
			<div class="bootstrap">
			<div class="module_warning alert alert-warning" >
				<button type="button" class="close" data-dismiss="alert">&times;</button>';

			if (is_array($warning))
			{
				$output .= '<ul>';
				foreach ($warning as $msg)
					$output .= '<li>'.$msg.'</li>';
				$output .= '</ul>';
			}
			else
				$output .= $warning;

			// Close div openned previously
			$output .= '</div></div>';

			return $output;
		}
		
		public static function displayConfirmation($string)
		{
			$output = '
			<div class="bootstrap">
			<div class="module_confirmation conf confirm alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				'.$string.'
			</div>
			</div>';
			return $output;
		}
		
		/**
		 * 
		 * @param type $string
		 * @param type $type (confirmation, warning, error)
		 * set au session alert when you leave a page!
		 */
		public static function setAlert($string, $type = 'confirmation')
		{
			switch ($type)
			{
				case 'confirmation':
					$_SESSION['alert'] = self::displayConfirmation($string);
					break;
				case 'warning':
					$_SESSION['alert'] = self::displayWarning($string);
					break;
				case 'error':
					$_SESSION['alert'] = self::displayError($string);
					break;
				default :
					$_SESSION['alert'] = self::displayConfirmation($string);
					break;
			}
		}
		
		/**
		* Helper validating the adress email
		* @return boolean
		*/
		public static function validateEmail($email)
		{
			return filter_var($email, FILTER_VALIDATE_EMAIL);
		}
		/**
		* Helper validating the adress email
		* @param string|array $error
		* @return boolean
		*/
		public static function fct_isphone($str)
		{
			return preg_match("#^\+?[0-9\./, -]{6,20}$#", $str) > 0 ? true : false;
		}
		
		/**
		* Helper formating string into utf-8
		* @return string
		*/
		public static function htmlentitiesSCL($chaine)
		{
			$chaine=htmlentities($chaine,ENT_QUOTES,'UTF-8');
			return $chaine;
		}
	}
?>