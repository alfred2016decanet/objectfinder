<?php //utf8 é//
/*
* Gestion utilisateurs site
* Nommé AdminSite pour éviter conflit avec Admin de phpBB 
* TODO : utilisation des espaces de noms pour contoruner proprement ce conflit
*/

class Administrateur extends Entite{
	var $dbtable='administrateur';
	var $sessionVariable = 'adminSessionValue';
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
	var $access=array();
	var $userData=array();  
    var $removeTablePrefix = true;
    
    /** Constructeur
	* 
	* @param string $dbConn
	* @param array $settings
	* @return void */
	public function Administrateur($getuser=true){
		$this->base = MySQL::getInstance();
		if($getuser){
			$this->remCookieDomain = $this->remCookieDomain == '' ? $_SERVER['HTTP_HOST'] : $this->remCookieDomain;			
			if( !isset( $_SESSION ) ){
				ini_set("session.cookie_lifetime", "0");
				session_start();
			}
			if ( !empty($_SESSION[$this->sessionVariable]) )
				$this->loadAdmin( $_SESSION[$this->sessionVariable] );

			//Il y a  un cookie ?
			if ( isset($_COOKIE[$this->remCookieName]) && substr($_SERVER['REQUEST_URI'],0,6) != '/gestion' && substr($_SERVER['REQUEST_URI'],0,8)!='/sitemap' && !$this->is_loaded()){
				// echo 'user trouvé<br />';
				$u = unserialize(base64_decode($_COOKIE[$this->remCookieName]));
				$this->login($u['login'], $u['password']);
			}
		}
	}
    
	function login($login, $password, $remember = false){
		global $session;
		$password = $originalPassword = $this->escape($password);
		switch(strtolower($this->passMethod)){
            case 'sha1':
                $password = "SHA1('$password')";
                break;
            case 'md5' :
                $password = "MD5('$password')";
                break;
            case 'nothing':
                $password = "'".addslashes($password)."'";
                break;
		}
		
		// on détermin d'abord si l'utilisateur est un super administrateur
		$sql = "
			SELECT a.* FROM `{$this->dbtable}` AS a
			WHERE a.`identifiant`='".addslashes($login)."'
			AND a.`mdp`=$password AND a.`active`=1 AND a.`access_all`=1 LIMIT 1";
		$res = $this->base->query($sql);
		if ($this->base->nombre_resultat($res) == 0)
		{
			$sql = "
				SELECT a.*, ag.`id_groupe` FROM `{$this->dbtable}` AS a
				INNER JOIN `admin_groupe` ag ON (ag.`id_administrateur` = a.`id`)
				INNER JOIN `groupe` g ON (g.`id` = ag.`id_groupe`)
				WHERE a.`identifiant`='".addslashes($login)."'
				AND a.`mdp`=$password AND a.`active`=1 LIMIT 1";
			$res = $this->base->query($sql);
		}
		if ($this->base->nombre_resultat($res) == 0)
            return false;
		else{
			$this->userData = $this->base->fetch_assoc($res);
			$this->userID = $this->userData['id'];
			$access = json_decode($this->userData['access']);
			if(count($access)>0) {
                foreach($access as $k=>$v)
                    $this->access[$k]=$v;
			}
			$session->ecrire($this->sessionVariable,$this->userID.';'.md5($this->userData['identifiant']));
			
			if ( $remember == true ){
				// On récupère le cookie
				$tmp = array('login'=>$login,'password'=>$originalPassword);
				$cookie = base64_encode(serialize($tmp));
				$a = setcookie($this->remCookieName, $cookie,time()+$this->remTime, '/', $this->remCookieDomain);
			}	
			//on trace date dernière connexion + nbre connexions
			$sql="UPDATE `{$this->dbtable}` 
			SET connexion='".date('Y-m-d H:i:s')."' WHERE id='".$this->userData["id"]."'";
			$ret = $this->base->query($sql);
		}
		return true;
	}
	
	/*** Logout
	* param string $redirectTo
	* @return bool */
	function logout($redirectTo = ''){	
		setcookie($this->remCookieName, '', time()-3600, '/', $this->remCookieDomain);
		$_SESSION[$this->sessionVariable]='';
		unset($_SESSION[$this->sessionVariable]);
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
	function loadAdmin($userID, $sess = true){
		global $session;
		$res = $this->base->query("SELECT * FROM `{$this->dbtable}` WHERE `id` = '".$this->escape($userID)."' LIMIT 1");
		if ( $this->base->nombre_resultat($res) == 0 )return false; 
		$this->userData = $this->base->fetch_array($res);
		$this->userID = $userID;
		if($sess)
            $session->ecrire($this->sessionVariable,$this->userID.';'.md5($this->userData['identifiant']));

        if(!empty($this->userData['access']))
            foreach(json_decode($this->userData['access']) as $k=>$v)
                $this->access[$k]=$v;
		return true;
	}
	
	function getGroupAdminAccess($userID){
		$sql = "
			SELECT g.* FROM  groupe AS g
			INNER JOIN `admin_groupe` ag ON (g.`id` = ag.`id_groupe`)
			WHERE ag.`id_administrateur` = $userID LIMIT 1";
		$res = $this->base->query($sql);
		if ($this->base->nombre_resultat($res) == 0)
            return array();
		else{
			$data = $this->base->fetch_array($res);
			$access = $data['access'];
			$data['access'] = array();
			// transformation des accès en tableau
			foreach (json_decode($access) as $k=>$v)
				$data['access'][$k] = $v; 
			return $data['access'];
		}
	}
	
	function getGroupAdminSalles($userID){
		$sql = "
			SELECT g.* FROM  groupe AS g
			INNER JOIN `admin_groupe` ag ON (g.`id` = ag.`id_groupe`)
			WHERE ag.`id_administrateur` = $userID LIMIT 1";
		$res = $this->base->query($sql);
		if ($this->base->nombre_resultat($res) == 0)
            return array();
		else{
			$data = $this->base->fetch_array($res);
			$salles = $data['salles'];
			$data['salles'] = array();
			// transformation des accès en tableau
			foreach (json_decode($salles) as $k=>$v)
				$data['salles'][] = $v; 
			return $data['salles'];
		}
	}
	/** Get an array of all the datas of a user. You should give here the name of the field that you seek from the user table
	* @param string $property
	* @return string */
	function getAdmin(){
		$datas=$this->userData;	
        if(!empty($datas['access']))
			foreach(json_decode($datas['access']) as $k=>$v)
				$datas['access'][$k]=$v;
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
	function insertAdmin($data){
		if (!is_array($data))$this->error('Data is not an array', __LINE__);
		/** VERIF PSEUDO DÉJÀ PRIS **/
		$sql="SELECT id FROM {$this->dbtable} WHERE identifiant='".addslashes($data['identifiant'])."'";
		$res=$this->base->query($sql);
		if($this->base->nombre_resultat($res)>0){
			$this->erreurs="pseudo_pris";
			return false;
		}

		switch(strtolower($this->passMethod)){
            case 'sha1':

                $password = sha1($data['mdp']); 
                break;
            case 'md5' :
                $password = md5($data['mdp']);
                break;
            case 'nothing':
                $password = "'".$data['mdp']."'";
                break;
		}
		
		$inserts=array();
            if(isset($data['mdp']))
                $data['mdp'] = $password;
		
		foreach ($data as $k => $v)
            $inserts[$k] = "'".$this->escape($v)."'";		
                
		$SETS=array();
		foreach($inserts as $k=>$v)
            $SETS[] = $k."=$v"; //insertion avec tableau: clé valeur et chaque champ doit commencé par {$this->dbtable}
		$SETS[] = "connexion='".date('Y-m-d H:i:s')."'";  //l'ergtrment begin au nivo du tablo donc à "identifiant"
		$SET = implode(', ', $SETS);
		
		//synchro ids tables user / phpbb_users//
		
		$sql="INSERT INTO `{$this->dbtable}` SET $SET, create_date='".date('Y-m-d H:i:s')."'";
		$res=$this->base->query($sql);
		$id_user=$this->base->derniere_entree();

		if($res)
            return $id_user;
		else
            return false;		
	}

	/*
	* Update infos user (depuis formulaire front)
	*/
	function updateAdmin($data){
		/** Recup infos actuelles de l'utilisateur => verif changement email/password **/
		$curr_user = $this->getAdmin();
        
		//var_dump($curr_user); die();
		if (!is_array($data))$this->error('Data is not an array', __LINE__);

		/** SI CHANGEMENT LOGIN => VERIF LOGIN DÉJÀ PRIS **/
		if(!empty($data['identifiant'])){
			if($data['identifiant']!=$curr_user['identifiant']){
				$sql="SELECT id FROM {$this->dbtable} WHERE identifiant='".$data['login']."'";
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
		if((!empty($data['mdp'])) && $data['mdp']!=$curr_user['mdp']){
			switch(strtolower($this->passMethod)){
                case 'sha1':
                    $password = sha1($data['mdp']); 
                    break;
                case 'md5' :
                    $password = md5($data['mdp']);
                    break;
                case 'nothing':
                    $password = "'".$data['mdp']."'";
                    break;
			}
		}
		$updates=array();
        if(isset($data['mdp']))
            $data['mdp'] = $password;
		foreach($data as $k=>$v){$updates["".$k]=$v;}
		//date maj user//
		$where=array('id'=>$curr_user['id']);
		$res=$this->Update($updates, $where);
		if($res)
			return true;
		else
			return false;
	}
	
	/* Créer password random
	* param int $length
	* param string $chrs
	* return string */
	function randomPass($length=10, $chrs = '1234567890qwertyuiopasdfghjklzxcvbnm'){
		for($i = 0; $i < $length; $i++) 
			$pwd .= $chrs{mt_rand(0, strlen($chrs)-1)};
		return $pwd;
	}
	
	
	public function setId($user_id){
		$this->id=intval($user_id);
	}
	public function setDatas($user) {
		$this->userData = $user;
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
		
		$select = "SELECT DISTINCT {$this->dbtable}.*, ag.`id_groupe`";

		//$groupby="GROUP BY {$this->dbtable}.id";
		
		if($this->tri!='')$orderby = ' ORDER BY '.$this->tri.' '.$this->sens;
		else $orderby = " ORDER BY  {$this->dbtable}.identifiant ASC ";
		if($this->limit!='')$limit = 'LIMIT '.$this->limit;
		if($this->groupby!='')$groupby = 'GROUP BY '.$this->groupby;
		if($this->orderby!='')$order_by = 'ORDER BY '.$this->orderby;
		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
		// echo "$sql<br /><br />"; die();
		$this->liste = $this->base->query_array($sql);
        //SI CIBLÉ PAR ID, ON A FORCEMENT QU'UNE ENTREE -> RETURN LIGNE SEULE//
        if(count($this->liste)==1 && $this->id!='')
            return $this->liste[0];
        else
            return $this->liste;
	}
	
	/** Nombre de resultats
	* @return int */
	public function getTotal(){
		$requete=$this->initRequete();
		$from=$requete->from;
		$join=$requete->join;
		$where=$requete->where;
		if($this->groupby!='')$groupby = "GROUP BY ".$this->groupby;
		$select = "SELECT (COUNT(DISTINCT {$this->dbtable}.id)) AS nbre";
		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
		$result=$this->base->query($sql);
		$row=$this->base->fetch_assoc($result);
		return (int)$row['nbre'];
	}
	
	public function Create(){	
		$sql="INSERT INTO {$this->dbtable} SET connexion=NOW(), create_date=NOW()";
		$res=$this->base->query($sql);
		
		return $this->base->derniere_entree();
	}
	
	////////////////////////////////////////////
	// PRIVATE FUNCTIONS
	////////////////////////////////////////////
	public function initRequete(){
		$requete = new stdClass();
		$requete->join  = "
			LEFT JOIN `admin_groupe` ag ON (ag.`id_administrateur` = {$this->dbtable}.`id`)
			LEFT JOIN `groupe` g ON (g.`id` = ag.`id_groupe`)";
		if($this->join != "")
             $requete->join .= $this->join;
        // var_dump($this->join);
		$tab_wheres= array();	
		//FROM//
		$requete->from = "FROM {$this->dbtable} as {$this->dbtable}";
		//PARAMS//
		if($this->id != '')
            $tab_wheres[] = "{$this->dbtable}.id = {$this->id}";

		if(!empty($this->where))$tab_wheres[]=$this->where;
		if(!empty($this->join))$requete->join=$this->join;

		if(!empty($tab_wheres))
			$requete->where.='WHERE '.implode(' AND ', $tab_wheres);

		return $requete;
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
		return $this->systemAdmins[$n];
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
}
?>