<?php //utf8 é//
/*
* Gestion utilisateurs site
* Nommé UserSite pour éviter conflit avec User de phpBB 
* TODO : utilisation des espaces de noms pour contoruner proprement ce conflit
*/

class UserSite extends Entite{
	var $dbtable='membre';
	
	var $sessionVariable = 'userSessionValue';
	
	var $session_id;
	
	/** Si l'utilisateur veut être mémorisé, temps de vie du cookie ? (secondes)
	* var int */
	var $remTime=31536000; //1 an
	
	/** Nom du cookie utilisé si l'utilisateur a demandé à être mémorisé
	* var string */
	var $remCookieName = 'ckSavePass';
	
	/** domaine du cookie
	* var string */
	var $remCookieDomain = '';
	
	
	/** Méthode utilisée pour crypter le password. sha1, md5 ou nothing (pas de cryptagen)
	* var string */
	var $passMethod = 'sha1';
	
	/**
	* Display errors? Pour debug
	* var bool
	*/
	var $displayErrors = false;
	
	/** erreur 
	* var string
	*/
	var $erreurs = '';
	
	/** Propriétés user
	* var string */
	var $userID;
	var $droits=array();
	var $userData=array();
        
    /* */
    var $uType = 'cafrintel';
    
    var $removeTablePrefix = true;
    
    /** Constructeur
	* 
	* @param string $dbConn
	* @param array $settings
	* @return void */
	public function UserSite($getuser=true, $type='cafrintel', $removeTablePrefix = true){
		$this->base = MySQL::getInstance();
        $this->removeTablePrefix = $removeTablePrefix;
		$this->uType = $type;
		if ( is_array($settings) ){
			foreach ( $settings as $k => $v ){
				if ( !isset( $this->{$k} ) ) die('Property '.$k.' does not exists. Check your settings.');
				$this->{$k} = $v;
			}
		}
		
		if($getuser){
			$this->remCookieDomain = $this->remCookieDomain == '' ? $_SERVER['HTTP_HOST'] : $this->remCookieDomain;
			
			if( !isset( $_SESSION ) ){
				ini_set("session.cookie_lifetime", "0");
				session_start();
			}
			
			if ( !empty($_SESSION[$this->sessionVariable.$this->uType]) ){
				$this->loadUser( $_SESSION[$this->sessionVariable.$this->uType] );
			}

			//Il y a  un cookie ?
			if ( isset($_COOKIE[$this->remCookieName]) && substr($_SERVER['REQUEST_URI'],0,6) != '/admin' && substr($_SERVER['REQUEST_URI'],0,8)!='/sitemap' && !$this->is_loaded()){
				// echo 'user trouvé<br />';
				$u = unserialize(base64_decode($_COOKIE[$this->remCookieName]));
				$this->login($u['login'], $u['password']);
			}
		}
	}
	
	/** Login
	* @param string $uname
	* @param string $password
	* @param bool $loadUser
	* @return bool 
	**/
    
    function getUserByEmail($email){
        $sql="SELECT * FROM `{$this->dbtable}` 
		WHERE {$this->dbtable}_identifiant ='".addslashes($email)."'";
        $res = $this->base->query_array($sql);
        return $res;
    }
    
    function getUserByInfoPerso(array $arrayInfos){
        $listUser = $this->Recherche();
        if(is_array($listUser) && count($listUser)){
            foreach ($listUser as $key => $user) {
                $found = true;
                foreach ($arrayInfos as $k => $v) {
                    if($v != $user['membre_info_perso'][$k]){
                        $found = false;
                        break;
                    }
                }
                
                if($found){
                    return $user;
                }
            }
        }
        return null;
    }
	function login($login, $password, $remember = false, $loadUser = true){
		global $_CONFIG, $session;
		
		$password = $originalPassword = $this->escape($password);
		switch(strtolower($this->passMethod)){
		case 'sha1':
			$password = "SHA1('$password')"; break;
		case 'md5' :
			$password = "MD5('$password')";break;
		case 'nothing':
			$password = "'".addslashes($password)."'";
		}
		
		$sql="SELECT * FROM `{$this->dbtable}` 
		WHERE {$this->dbtable}_identifiant LIKE '".addslashes($login)."'
		AND {$this->dbtable}_pass LIKE $password AND {$this->dbtable}_actif='1' LIMIT 1";
		$res = $this->base->query($sql);
		if ( $this->base->nombre_resultat($res) == 0)return false;
		
		if ( $loadUser ){
			$this->userData = $this->base->fetch_assoc($res);
			$this->userID = $this->userData['membre_id'];
			$droits = json_decode($this->userData['membre_droits']);
			if(count($droits)>0) {
			foreach($droits as $k=>$v)
				$this->droits[$k]=$v;
			}
			$session->ecrire($this->sessionVariable.$this->uType,$this->userID.';'.md5($this->userData['membre_identifiant']));
			
			if ( $remember == true ){
				// On récupère le cookie
				$tmp = array('login'=>$login,'password'=>$originalPassword);
				$cookie = base64_encode(serialize($tmp));
				$a = setcookie($this->remCookieName, $cookie,time()+$this->remTime, '/', $this->remCookieDomain);
			}	
			
			//on trace date dernière connexion + nbre connexions
			$sql="UPDATE `{$this->dbtable}` 
			SET {$this->dbtable}_connexion='".date('Y-m-d H:i:s')."' WHERE {$this->dbtable}_id='".$this->userData["{$this->dbtable}_id"]."'";
			$ret = $this->base->query($sql);
		}
		return true;
	}
	
	/*** Logout
	* param string $redirectTo
	* @return bool */
	function logout($redirectTo = ''){
		global $userdata;
		global $cookiename;
		global $db;
		global $board_config;
		global $_CONFIG;

		
		setcookie($this->remCookieName, '', time()-3600, '/', $this->remCookieDomain);
		$_SESSION[$this->sessionVariable.$this->uType]='';
		unset($_SESSION[$this->sessionVariable.$this->uType]);

		$this->userData = '';
		//$this->newSession();

		
		if ( $redirectTo != '' && !headers_sent()){
			header('Location: '.$redirectTo );
			exit;//To ensure security
		}
	}
	
	/** Verif si propriété true ou false
	* param string $prop
	* @return bool */
	function is($prop){
            return $this->get($prop)==1?true:false;
	}

	/** Get a property of a user. You should give here the name of the field that you seek from the user table
	* @param string $property
	* @return string */
	function get($property){
		if (empty($this->userID)) $this->error('No user is loaded', __LINE__);
		
		if (!isset($this->userData[$property])) $this->error('Unknown property <b>'.$property.'</b>', __LINE__);
		return $this->userData[$property];
	}
	
	/** Chargement des données d'un user
	* @access private
	* @param string $userID
	* @return bool */
	function loadUser($userID, $sess = true){
		global $session;
		$res = $this->base->query("SELECT * FROM `{$this->dbtable}` WHERE `{$this->dbtable}_id` = '".$this->escape($userID)."' LIMIT 1");
		if ( $this->base->nombre_resultat($res) == 0 )return false; 
		$this->userData = $this->base->fetch_array($res);
		$this->userID = $userID;
		if($sess)
            $session->ecrire($this->sessionVariable.$this->uType,$this->userID.';'.md5($this->userData['membre_identifiant']));

        // cargement des infos Personnelles de l'utilisateur
        if(!empty($this->userData['membre_info_perso']))
            $this->userData['membre_info_perso'] = unserialize($this->userData['membre_info_perso']);
        else
             $this->userData['membre_info_perso'] = array();
        if($this->userData["membre_type"] != "admin")
		$this->userData = $this->formatData($this->userData);
        if(!empty($this->userData['membre_droits']))
            foreach(json_decode($this->userData['membre_droits']) as $k=>$v)
                $this->droits[$k]=$v;
		return true;
	}
	
	/** Get an array of all the datas of a user. You should give here the name of the field that you seek from the user table
	* @param string $property
	* @return string */
	function getUser(){
		$datas=$this->userData;	
        if(!empty($datas['membre_droits']))
			foreach(json_decode($datas['membre_droits']) as $k=>$v)
				$datas['droits'][$k]=$v;
		return $datas;
	}
	
	
	/** Verif chargement user
	* @ return bool */
	function is_loaded(){
		return empty($this->userID) ? false : true;
	}
	
	
	public function getError(){
		return $this->erreurs;
	}
	
	/* * Création de compte. Array : 'database field' => 'value'
	* @param array $data
	
	* return int */  
	function insertUser($data){
		if (!is_array($data))$this->error('Data is not an array', __LINE__);
		/** VERIF PSEUDO DÉJÀ PRIS **/
		$sql="SELECT {$this->dbtable}_id FROM {$this->dbtable} WHERE {$this->dbtable}_identifiant='".addslashes($data['identifiant'])."'";
		$res=$this->base->query($sql);
		if($this->base->nombre_resultat($res)>0){
			$this->erreurs="pseudo_pris";
			return false;
		}
		
		switch(strtolower($this->passMethod)){
                    case 'sha1':
                       
                        $password = sha1($data['pass']); 
                        break;
                    case 'md5' :
                        $password = md5($data['pass']);
                        break;
                    case 'nothing':
			$password = "'".$data['pass']."'";
                        break;
		}
		
		$inserts=array();
                if(isset($data['pass']))
                    $data['pass'] = $password;
		
		foreach ($data as $k => $v){$inserts[$k] = "'".$this->escape($v)."'";}
		
                
		$SETS=array();
		foreach($inserts as $k=>$v){$SETS[]="membre_".$k."=$v";} //insertion avec tableau: clé valeur et chaque champ doit commencé par membre
		$SETS[]="{$this->dbtable}_connexion='".date('Y-m-d H:i:s')."'";  //l'ergtrment begin au nivo du tablo donc à "membre_identifiant"
		$SET=implode(', ', $SETS);
		
		//synchro ids tables user / phpbb_users//
		
		$sql="INSERT INTO `{$this->dbtable}` SET $SET, membre_type='{$this->uType}', membre_inscription='".date('Y-m-d H:i:s')."'";
		//print_r($sql); die();
		$res=$this->base->query($sql);
		
		$id_user=$this->base->derniere_entree();

		if($res){
                    return $id_user;
		}else{
                    return false;
		}			
	}
	

	/*
	* Update infos user (depuis formulaire front)
	*/
	function updateUser($data){
		/** Recup infos actuelles de l'utilisateur => verif changement email/password **/
		$curr_user=$this->getUser();
        
		//var_dump($curr_user); die();
		if (!is_array($data))$this->error('Data is not an array', __LINE__);
		
		/** SI CHANGEMENT MAIL => VERIF MAIL DÉJÀ PRIS **/
		if($data['email']!=$curr_user['membre_email']){
			$sql="SELECT {$this->dbtable}_id FROM {$this->dbtable} WHERE {$this->dbtable}_email='".$data['email']."'";
			$res=$this->base->query($sql);
			if($this->base->nombre_resultat($res)>0){
                            $this->erreurs="cet email est déjà existant";
                            //die('2');
                            return false;
			}	
		}
		
		/** SI CHANGEMENT LOGIN => VERIF LOGIN DÉJÀ PRIS **/
		if(!empty($data['identifiant'])){
			if($data['identifiant']!=$curr_user['membre_identifiant']){
				$sql="SELECT {$this->dbtable}_id FROM {$this->dbtable} WHERE {$this->dbtable}_identifiant='".$data['login']."'";
				$res=$this->base->query($sql);
				if($this->base->nombre_resultat($res)>0){
					$this->erreurs="login_pris";
					//die('2');
					return false;
				}	
			}
		}
		
		//foreach ($data as $k => $v){$data[$k] = "'".$this->escape($v)."'";}
		
		/** !! PASSWORD **/
		if((!empty($data['pass'])) && $data['pass']!=$curr_user['membre_pass']){
			switch(strtolower($this->passMethod)){
			case 'sha1':
                            $password = sha1($data['pass']); 
                            break;
                        case 'md5' :
                            $password = md5($data['pass']);
                            break;
                        case 'nothing':
                            $password = "'".$data['pass']."'";
                            break;
			}
		}

		$updates=array();
                if(isset($data['pass']))
                    $data['pass'] = $password;
		foreach($data as $k=>$v){$updates["membre_".$k]=$v;}
		//date maj user//
		$where=array('membre_id'=>$curr_user['id']);
        
		$res=$this->Update($updates, $where);
		
		if($res){
			return true;
		}else{
			return false;
		}	
		//return (int)$this->base->derniere_entree();
	}
	
	/* Créer password random
	* param int $length
	* param string $chrs
	* return string */
	function randomPass($length=10, $chrs = '1234567890qwertyuiopasdfghjklzxcvbnm'){
		for($i = 0; $i < $length; $i++) {
			$pwd .= $chrs{mt_rand(0, strlen($chrs)-1)};
		}
		return $pwd;
	}
	
	
	public function setId($user_id){
		$this->membre_id=intval($user_id);
	}
	public function setDatas($user) {
		$this->userData = $user;
	}
	
	public function setEmail($email){
            $this->email=Tools::escape($email);
	}

	public function setNom($nom){
		$this->nom=Tools::escape($nom);
	}
	
	public function setPrenom($prenom){
		$this->prenom=Tools::escape($prenom);
	}
	
	public function setLogin($login){
		$this->login=Tools::escape($login);
	}
        
	public function setUtype($utype){
		$this->uType = $utype;
	}
	
	/** Renvoi des entrées trouvées
	* @return array multi ou array simple si recherche par id (1 résultat) */
	public function Recherche(){
		$requete = $this->initRequete();
		$from = $requete->from;
		$join = $requete->join;
       
		$where = $requete->where;
		$groupby = '';
		$limit = '';
		$offset = '';
		$order_by='';
		
		$select = "SELECT DISTINCT membre.*";

		//$groupby="GROUP BY {$this->dbtable}.{$this->dbtable}_id";
		
		if($this->tri!='')$orderby = ' ORDER BY '.$this->tri.' '.$this->sens;
		else $orderby = " ORDER BY {$this->dbtable}_identifiant ASC ";
		
		if($this->limit!='')$limit = 'LIMIT '.$this->limit;
		
		if($this->groupby!='')$groupby = 'GROUP BY '.$this->groupby;
		
		if($this->orderby!='')$order_by = 'ORDER BY '.$this->orderby;

		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
		// echo "$sql<br /><br />"; die();

		$res=$this->base->query_array($sql);

		if($res){
			//on output les mêmes champs que pour getUser()//
			$this->liste=array();
			foreach($res as $user){
				$this->liste[]=$user;
			}
			
			// Données complémentaires
			foreach($this->liste as &$user) {
				if($user['email']!='') {
					$newsletterObj = new Newsletter($user['email']);
					$user['newsletter'] = $newsletterObj->registered;
				}
				if(!empty($user['membre_info_perso']))
					$user['membre_info_perso'] = unserialize($user['membre_info_perso']);
				else
					$user['membre_info_perso'] = array();
				$group_code = $user["group_code"];
				$group_nom  = $user["group_nom"];
				if($user["membre_type"] != "admin")
					$user = $this->formatData($user);
				$user["group_code"] = $group_code;
				$user["group_nom"]  = $group_nom;
			}
			//SI CIBLÉ PAR ID, ON A FORCEMENT QU'UNE ENTREE -> RETURN LIGNE SEULE//
			if(count($this->liste)==1 && $this->{$this->dbtable.'_id'}!=''){
				return $this->liste[0];
			}else{
				return $this->liste;
			}
		}
	}
	
	/** Nombre de resultats
	* @return int */
	public function getTotal(){
		$requete=$this->initRequete();
		
		$from=$requete->from;
		$join=$requete->join;
		$where=$requete->where;
		
		if($this->groupby!='')$groupby = "GROUP BY ".$this->groupby;
		
		$select = "SELECT (COUNT(DISTINCT {$this->dbtable}.{$this->dbtable}_id)) AS nbre";
		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
		$result=$this->base->query($sql);
		
		$row=$this->base->fetch_assoc($result);
		
		return (int)$row['nbre'];
	}
	
	public function Create(){	
		$sql="INSERT INTO membre SET membre_identifiant='', membre_connexion=NOW(), membre_inscription=NOW(), membre_type='{$this->uType}' ";
		// echo "$sql<br />";
		$res=$this->base->query($sql);
		
		return $this->base->derniere_entree();
	}
	
	////////////////////////////////////////////
	// PRIVATE FUNCTIONS
	////////////////////////////////////////////
	public function initRequete(){
		$requete = new stdClass();
		$requete->join='';
		 if($this->join != "")
             $requete->join .= $this->join;
        // var_dump($this->join);
		$tab_wheres= array();
		
		//FROM//
		$requete->from = "FROM {$this->dbtable} as membre";
		
		
		//PARAMS//
		if($this->{$this->dbtable.'_id'}!='')$tab_wheres[] = "{$this->dbtable}.{$this->dbtable}_id = '".$this->{$this->dbtable.'_id'}."'";
		
		if($this->email!='')$tab_wheres[] = "{$this->dbtable}.{$this->dbtable}_email = '".$this->email."'";
		
		if($this->pseudo!='')$tab_wheres[] = "{$this->dbtable}.{$this->dbtable}_identifiant LIKE '".$this->pseudo."'";
		if($this->prenom!='')$tab_wheres[] = "{$this->dbtable}.{$this->dbtable}_prenom = '".$this->prenom."'";
		
		if(!empty($this->where))$tab_wheres[]=$this->where;
		if(!empty($this->join))$requete->join=$this->join;

        $tab_wheres[] = "{$this->dbtable}_type ='{$this->uType}'";
        $tab_wheres[] = "{$this->dbtable}_deleted = 0";
		if(!empty($tab_wheres)){
			//A AMELIORER (AND/OR) ,//
			$requete->where.='WHERE '.implode(' AND ', $tab_wheres);
		}
		
		return $requete;
	}
	
	public function setPseudo($pseudo){
		$this->pseudo=Tools::escape($pseudo);
	}
	
	public function setSearchMail($mail) {
		$this->searchemail=$mail;
	}
	
	/** Equivalent addslashes() plus sûr
	* @access private
	* @param string $str
	* @return string */  
	function escape($str){
		$str = get_magic_quotes_gpc()?stripslashes($str):$str;
		$str = mysql_real_escape_string($str);
		return $str;
	}
	
	/** Gestionnaire d'erreurs pour la classe
	* @access private
	* @param string $error
	* @param int $line
	* @param bool $die
	* @return bool */  
	function error($error, $line = '', $die = false) {
		if ( $this->displayErrors )
		echo '<b>Error: </b>'.$error.'<br /><b>Line: </b>'.($line==''?'Unknown':$line).'<br />';
		if ($die) exit;
		return false;
	}
	
	
	function getAccount($n) {
		return $this->systemUsers[$n];
	}
	
	
	/*
	* détection des bots
	* méthode rudimentaire, si besoin améliorer :
	* - stocker bot_alias en BDD (avec liste full / updatable)
	* - recouper avec accès robots.txt
	* - etc...
	*
	* @return bool
	*/
	public static function isBot(){
		$output = false;
		
		$agents =array('Googlebot', 'Yahoo!', 'msnbot', 'bingbot',  'VoilaBot', 'Validator', 'Teoma','alexa','froogle', 'inktomi','looksmart','URL_Spider_SQL','Firefly','NationalDirectory','Ask Jeeves', 'TECNOSEEK', 'InfoSeek', 'WebFindBot', 'girafabot', 'crawler', 'www.galaxy.com', 'Scooter', 'Slurp', 'appie', 'FAST', 'WebBug', 'Spade', 'ZyBorg', 'rabaz', 'Baiduspider', 'Feedfetcher-Google', 'TechnoratiSnoop', 'Rankivabot',
		'Mediapartners-Google', 'Sogou web spider', 'WebAlta Crawler', 'Gigabot', 'Openfind', 'Naver', 'www.exabot.com');
		
		foreach($agents  as $agent) {
			$preg = '/' . $agent . '/'; 
			
			if (preg_match($preg, $_SERVER['HTTP_USER_AGENT'])){
				$filename = ROOT.'data/logs/bots.txt';
				$handle = fopen($filename, 'a+t');
				fwrite($handle, date( "Y-m-d H:i:s")." ".$_SERVER['HTTP_USER_AGENT']."\r\n");
				fclose($handle);

				$output = true;
				break;
			}
		}
		
		return $output;
	}
	
	
	/*
	* Retourne le nombre d'inscription de membres et à la newsletter sur les 30 derniers jours
	* @return array
	*/
	public function statInscriptions() {
		$date = date('Y-m-d', time()-3600*24*29);
		
		$this->liste=array();
		
		for($i=29; $i>=0; $i--) {
			$date = date('Y-m-d', time()-3600*24*$i);
			
			$sql = 'SELECT COUNT(*) AS membres FROM membre WHERE membre_inscription LIKE "'.$date.'%"';
			$res = $this->base->query_array($sql);
			
			foreach($res as $r){
				$this->liste[$date]['membres'] = $r['membres'];
			}
			
			$sql = 'SELECT COUNT(*) AS newsletters FROM newsletter WHERE newsletter_date LIKE "'.$date.'%"';
			$res = $this->base->query_array($sql);
			
			foreach($res as $r){
				$this->liste[$date]['newsletters'] = $r['newsletters'];
			}
		}
		
		return $this->liste;
	}
	
	/**
	* Retourne le nombre de membres inscrits à la newsletter
	* @return int
	*/
	public function statsNewsletter() {
		$sql = 'SELECT COUNT(*) AS total FROM membre WHERE membre_email IN (SELECT newsletter_email FROM newsletter)';
		$result=$this->base->query($sql);
		
		$row=$this->base->fetch_assoc($result);
		
		return $row['total'];
	}
        
	public function getCryptedPwd($pwd){
		switch(strtolower($this->passMethod)){
			case 'sha1':
			   return sha1($pwd); 
				break;
			case 'md5' :
				return md5($pwd);
				break;
			case 'nothing':
				return $pwd;
				break;
		}
		return $pwd;
	}
	

// Added for KMS users operation ************************************************************************************************************/

	
	public function formatData($data){
        if($this->removeTablePrefix)
            return array(
                        'id' 			=>  @$data['membre_id'],
                        'civilite' 		=>  @$data['membre_info_perso']['gender'],
                        'nom' 			=>  @$data['membre_info_perso']['nom'],
                        'prenom' 		=>  @$data['membre_info_perso']['prenom'],
                        'email' 		=>  @$data['membre_identifiant'],
                        'mdpass' 		=>  @$data['membre_pass'],
                        'date_naiss' 	=>  @$data['membre_info_perso']['dob'],
                        'ville' 		=>  @$data['membre_info_perso']['ville'],
                        'pays' 			=>  @$data['membre_info_perso']['pays'],
                        'nationalite' 	=>  @$data['membre_info_perso']['nationalite'],
                        'adr_postal' 	=>  @$data['membre_info_perso']['postal_address'],
                        'code_postal' 	=>  @$data['membre_info_perso']['postal_code'],
                        'tel' 			=>  @$data['membre_info_perso']['fix_tel'],
                        'telMobile' 	=>  @$data['membre_info_perso']['tel_mobile'],
                        'profession' 		=>  @$data['membre_info_perso']['profession'],
                        'groupe' 		=>  @$data['membre_group'],
                        'date_inscript'	=>  @$data['membre_inscription'],
                        'deleted' 		=>  @$data['membre_deleted'],
                        'state' 		=>  @$data['membre_actif'],
                
                        'solde_sms'	      =>  @$data['membre_solde_sms'],
                        'accept_info_kms' =>  @$data['membre_accept_info_kms'],
                        'accept_info_org' =>  @$data['membre_accept_info_org']
                    );
        return $data;
	}
	
	/**
	* Suppression d'un utilisateur existant
	*
	**/
	public function delete($where="",$table=null){	
		if(parent::has_content(array("id_respo"=>$this->userID),"equipe") > 0
		OR parent::has_content(array("id_participant"=>$this->userID),"inscription")  > 0
		OR parent::has_content(array("id_org"=>$this->userID),"course") > 0){
			return null;
		}
		Tools::videCache();
		return parent::flagDelete(array("membre_id"=>$this->userID),"membre");
	}
	
	public function is_deletable(){	
		if(parent::has_content(array("id_participant"=>$this->userID),"inscription"," OR coequipier LIKE '%".$this->userID."%' ")  > 0
		OR parent::has_content(array("id_respo"=>$this->userID),"equipe") > 0
		OR parent::has_content(array("id_org"=>$this->userID),"course") > 0){
			return false;
		}
		return true;
	}
	
	/**
	* Modifier l'etat d'un utilisateur existant
	*
	**/
	public function toggleState(){	
		$sql = "
			UPDATE kmsuser SET 
			membre_actif = IF(membre_actif=1, 0, 1)
			WHERE membre_id = $this->userID
		";
		$res = $this->base->query($sql);
		
		return ($res)?true:false;
	}
	
	/** 
	* Initialise et installe la table destiné à la gestion des groupes d'utilisateurs KMS
	* @return void
	**/
	static function init_kmsusergroup_dbtable(){
		$db = MySQL::getInstance();
		/* Création de la table des groupes d'utilisateurs KMS */
		$q = $db->query("			
			CREATE TABLE IF NOT EXISTS `kmsuser_group` (
			`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			`nom` VARCHAR(255) NOT NULL,
			`code` VARCHAR(5) NOT NULL,
			`desc` TEXT NOT NULL default '',
			PRIMARY KEY (`id`)
			) DEFAULT COLLATE=utf8_general_ci;
		");
		$qu = $db->query("
			SELECT * FROM `kmsuser_group` WHERE `id` = '1'
		");
		if($q and !$db->fetch_object($qu)){
			/* Insertion des valeurs des différents types de groupes */
			$qu = $db->query("
				INSERT INTO `kmsuser_group` (`id`, `nom`, `code`, `desc`) VALUES ('1', 'abonné', 'abo', '');
			"); //Abonné
			$qu = $db->query("
				INSERT INTO `kmsuser_group` (`id`, `nom`, `code`, `desc`) VALUES ('2','organisateur','org','')
			");//Organisateur
			$qu = $db->query("
				INSERT INTO `kmsuser_group` (`id`, `nom`, `code`, `desc`) VALUES ('3','responsable de groupe','rgr','')
			");//Responsable de groupe
			$qu = $db->query("
				INSERT INTO `kmsuser_group` (`id`, `nom`, `code`, `desc`) VALUES ('4','responsable de magasin','rma','')
			");//Responsable de magasin
			$qu = $db->query("
				INSERT INTO `kmsuser_group` (`id`, `nom`, `code`, `desc`) VALUES ('5','annonceur','ann','')
			");//Annonceur
			$qu = $db->query("
				INSERT INTO `kmsuser_group` (`id`, `nom`, `code`, `desc`) VALUES ('6','administrateur','adm','')
			");//Administrateur
		}
	}
	
	/**
	* Récupérer la liste des groupes disponibles
	**/
	static function getKmsUserGroups($id = null){
		$db = MySQL::getInstance();
		$qu = $db->query_array("
			SELECT * FROM `kmsuser_group` ".($id ? " WHERE id=$id" : ""));
		return $qu;
	}
	
	static function getKmsUserById($id, $as_array = false,$check_state = 1){
		if((int)$id <= 0){
			return false;
		}
		
		$user = new UserSite(false);
		if($as_array){
			$where = "";
			if($check_state){
				$where = " AND membre_actif = 1 ";
			}
			$user->setWhere(" membre_deleted = 0 AND `membre_id` = ".(int)$id.$where);
			$res = $user->Recherche();
			
			return (isset($res) and count($res)>0)?$res[0]:null;
		}
		
		$user->loadUser((int)$id,false);
		return $user;
	}
	
	static function getKmsUsersByGroup($id_group = 1, $wheres = null){
		$user = new UserSite(false);
		$where = "";
		if((int)$id_group > 0){
			$where = " AND `membre_group` = ".(int)$id_group;
		}
        
        if($wheres)
            $where .= " AND ".$wheres;
		$user->setWhere(" membre_deleted = 0 AND membre_actif = 1 ".$where);
		$res = $user->Recherche();
		return (isset($res) and count($res)>0)?$res:null;
	}
	

}
?>