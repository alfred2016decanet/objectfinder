<?php
##### CLASSE MySQL #####
class MySQL/* implements BaseDeDonnee PHP5 */{
	public $db_host;
	public $db_user;
	public $db_pass;
	public $db_base;
	
	var $charset;
	
	var $nb_requetes;
	var $tab_requete;
	var $path_cache='data/cache/sql/';
	var $time_connect;
	
	/** mails à alerter si erreur SQL **/
	var $mails_errors = array(
		'mbidalucalfred@yahoo.fr',
        //'ambida@crystals-services.com'
	);
	
	static $instance;
	
	function __construct($host, $user, $pass, $base, $charset='utf8'){
		self::$instance=$this;
		$this->db_host=$host;
		$this->db_user=$user;
		$this->db_pass=$pass;
		$this->db_base=$base;
		$this->charset=$charset;
		
		$this->connecter();
	}
	
	function setCharset($charset){
		$this->charset=$charset;
	}
	
	/* public */ 
	function connecter(){
		@mysql_connect($this->db_host,$this->db_user,$this->db_pass)or $this->erreur( "Mauvais utilisateur ou mauvais mot de passe -- Connection à la base de donnée MySQL ECHEC" );
		@mysql_select_db($this->db_base) or $this->erreur( "MySQL - Pas de Base trouve -- Mauvais nom de base --- Base de donnee ECHEC" );

		$this->query("SET NAMES '".$this->charset."'");
		
		$this->nb_requetes=0;
		
		$this->time_connect=microtime(true); 
	}
	
	// La méthode singleton
    public static function getInstance() {
        if (!isset(self::$instance)){
			global $_CONFIG;
			
			if(!empty($_CONFIG)){
				self::$instance = new MySQL($_CONFIG['db']['host'], $_CONFIG['db']['user'], $_CONFIG['db']['password'], $_CONFIG['db']['base']);
			}else{
				die('config manquante !');
			}	
        }

        return self::$instance;
    }
	
	/* public */ function deconnecter(){
		mysql_close();
	}

	function erreur($sql) {
		global $_CONFIG;
		$h = fopen(dirname(__FILE__).'/../../../logs/sql_error.log', 'a+');
		fwrite($h,date('Y-m-d H:i:s').';'.$sql.';'.mysql_error()."\n");
		fclose($h);
		
		//if (strpos(mysql_error(), 'server has gone away') === false && strpos(mysql_error(), 'Too many connections') === false) {
			$message = '<pre>'.
				'Query : '.$sql."\r\n\r\n------------------------\r\n".
				'Error : '.mysql_error()."\r\n\r\n------------------------\r\n".
				'Page  : '.$_SERVER['REQUEST_URI']."\r\n\r\n------------------------\r\n".
				(isset($_SERVER['HTTP_REFERER']) ? 'Referer : '.$_SERVER['HTTP_REFERER']."\r\n\r\n------------------------\r\n" : '').
				'Trace : '."\r\n".print_r(debug_backtrace(), true).
				'</pre>';
			if(substr($_SERVER['HTTP_HOST'],0,3)=="dev" || $_SERVER['HTTP_HOST']=="kms.decanet.fr")
				echo $message;
			foreach($this->mails_errors as $mail) {
				Tools::sendMail($mail, 'Erreur sql http://'.$_SERVER['HTTP_HOST'], $message, 0);
			}
			
		//}
		//debug_print_backtrace();
		//die(mysql_error().' - '.$sql);
		
		$content = file_get_contents(ROOT.'maintenance.html');
		if ($content !== false) {
			die($content);
		}
		die("<p align=\"center\">Une erreur s'est produite sur le site.<br><br>Veuillez <a href=\"/\">cliquer ici pour continuer</a>.</p>");
	}

	/* public */ function query($sql) {
		$md5SQL = md5($sql);
		
		if (isset($this->tab_requete[$md5SQL])) {
			$this->tab_requete[$md5SQL]['nbr']++;
			@mysql_data_seek($this->tab_requete[$md5SQL]['result'], 0);
			return $this->tab_requete[$md5SQL]['result'];
		}
		$befor = -microtime(true);
		if ($result = mysql_query($sql)) {
			$tps = (round(1000*($befor + microtime(true)))/1000);
			
			$this->tab_requete[$md5SQL] = array(
				'num' => $this->num_requetes++,
				'sql' => $sql,
				'tps' => $tps,
				'result' => $result,
				'nbr' => 1,
			);
			return $result;
		} else {
			$this->erreur($sql);
		}
	}
	
	// Retourne tout les résultats dans un tableau
	function query_array($sql) {
		global $_CONFIG;
		
		//if(intval($_CONFIG['usr']['db_cache'])==1)
		//	return $this->query_array_cache($sql);
		
		$rq=$this->query($sql);
		$i=0;
		while($c=mysql_fetch_assoc($rq)){
			foreach($c as $k=>$v){$c[$k]=stripslashes($v);}
			$res[$i++]=$c;
		}
		return $res;
	}	

	// Retourne tout les résultats dans un tableau
	function query_array_cache($sql, $seconde=3600, $fic=false) {
		global $_CONFIG;
		
		if(intval($_CONFIG['usr']['db_cache'])==0)
			return $this->query_array($sql);
		if(!is_dir(ROOT.$this->path_cache))mkdir(ROOT.$this->path_cache,0777);
		if(!$fic)
			$fic=ROOT.$this->path_cache.md5($sql).'.txt'; //$this->path_cache.
		else
			$fic=ROOT.$this->path_cache.$fic;
		//echo time() - filectime($fic);
		if($_CONFIG['usr']['caching']=="disk" || !isset($_CONFIG['usr']['caching'])) {
			if (is_file($fic) and (time() - filectime($fic))< $seconde) {
				//echo "cache ";
				return unserialize(file_get_contents($fic));
			}
			else {
				//echo "pascache ";
				$rq=$this->query($sql);
				$i=0;
				while($c=$this->fetch_assoc($rq)){
					foreach($c as $k=>$v){$c[$k]=stripslashes($v);}
					$res[$i++]=$c;
				}
				
				if (($h=fopen($fic, 'w+'))==true) {
					fwrite($h, serialize($res));
					fclose($h);	
				} else $this->erreur("pb cache $sql");
			}
		} else {
			$mem = new Mem('sql');
			if (strlen($mem->lire('sql_'.md5($fic)))>0 && (time() - $mem->lire('sqlt_'.md5($fic)))< $seconde) {
				//echo "cache ";
				return unserialize($mem->lire('sql_'.md5($fic)));
			}
			else {
				//echo "pascache ";
				$rq=$this->query($sql);
				$i=0;
				while($c=$this->fetch_assoc($rq)){
					foreach($c as $k=>$v){$c[$k]=stripslashes($v);}
					$res[$i++]=$c;
				}
				
				$mem->ecrire('sql_'.md5($fic), serialize($res));
				$mem->ecrire('sqlt_'.md5($fic), time());
			}
		}
		return $res;
	}	

	/* public */ function fetch_array( $result )
	{
		return mysql_fetch_array( $result );
	}
	
	/* public */ function fetch_assoc( $result )
	{
		return mysql_fetch_assoc( $result );
	}
	
	/* public */ function fetch_object( $result )
	{
		return mysql_fetch_object( $result );
	}
	
	/* public */ function free_mem($result)
	{
		mysql_free_result($result);
	}

	/* public */ function nombre_resultat($result)
	{
		return mysql_num_rows($result);
	}

	/* public */ function nombre_affectees()
	{
		return mysql_affected_rows();
	}

	/* public */ function derniere_entree()
	{
		return mysql_insert_id();
	}

	/**
	* Vérifier si $table est dans la BD
	*
	* @param table $table
	* @return booléen
	**/
	static function is_table_instaled($table){
		$db = MySQL::getInstance();
		
		$query = "SHOW TABLES FROM ".$db->db_base;
		$tables = $db->query_array($query);
		foreach($tables as $tab){
			if($tab["Tables_in_kms"] == $table){
				return true;
			}
		}
		return false;
	}
	
	static function is_row_in_table($row,$table){
		$db = MySQL::getInstance();
		
		$query = "SHOW COLUMNS FROM ".$table." like '".$row."'";
		$res = $db->query_array($query);
		
		return isset($res);
	}
	
	/* public */ function debug()
	{
		$html = array();
		
		$html[] = '<table cellspacing="2" style="font-family:monospace;">';
		$html[] = '	<thead>';
		$html[] = '		<tr bgcolor="#d0d0d0">';
		$html[] = '			<th>n°</th><th>tps</th><th>sql</th><th>nbr</th>';
		$html[] = '		</tr>';
		$html[] = '	</thead>';
		$html[] = '	<tbody>';
		
		$tps = 0;
		$odd = true;
		$nbrTotal = 0;
		
		foreach($this->tab_requete as $queryInfos) {
			
			$tps += $queryInfos['tps'];
			
			$odd = !$odd;
			
			$num  = $queryInfos['num'];
			$time = (1000 * $queryInfos['tps']);
			$nbr  = $queryInfos['nbr'];
			$nbrTotal += $nbr;
			
			$html[] = '		<tr bgcolor="'.($odd ? '#eeeeee' : '#dddddd').'">';
			$html[] = '			<td align="right" style="color:#666666">'.$num.'</td>';
			$html[] = '			<td align="right"'.($time > 0 ? ' style="color:#AA0000">'.$time.'ms': '').'</td>';
			$html[] = '			<td style="padding:2px;color:'.($nbr == 1 && $time == 0 ? '#666666': '#000000').'">'.$queryInfos['sql'].'</td>';
			$html[] = '			<td '.($nbr > 1 ? ' style="color:#AA3333">x'.$nbr : '').'</td>';
			$html[] = '		</tr>';
		}
		$html[] = '	<thead>';
		$html[] = '		<tr bgcolor="#d0d0d0">';
		$html[] = '			<th></th><th>'.(1000 * $tps).'ms</th><th>'.$num.' distinct</th><th>'.$nbrTotal.'</th>';
		$html[] = '		</tr>';
		$html[] = '	</thead>';
		$html[] = '	</tbody>';
		$html[] = '</table>';
		$html[] = '<b>Temps total : '.$tps.' s</b>';
		
		$str.="<br />Temps d'exécution : ".(microtime(true) - $this->time_connect);
		
		return implode("\n", $html);
	}
	
	
	function last_error() {
		return mysql_error();
	}

	function fetchall() {
		
	}
	
	function extract_enum($nom_de_la_table, $nom_du_champ){
		$sql_liste_type = "SHOW COLUMNS FROM ".$nom_de_la_table." like '".$nom_du_champ."'";
		$resultat_liste_type = $this->query($sql_liste_type);
		$info_liste_type = $this->fetch_assoc($resultat_liste_type);

		$chaine_tmp_1 = substr($info_liste_type['Type'],5,strlen($info_liste_type['Type']));
		$chaine_tmp_2 = substr($chaine_tmp_1,0,strlen($chaine_tmp_1)-1);
		$t_tmp_1 = explode(",",$chaine_tmp_2);
		$t_info_enum = array();
		
		foreach ($t_tmp_1 as $cle => $valeur){
			$t_info_enum[$cle] = substr($valeur,1,strlen($valeur)-2);
		}
		
		return $t_info_enum;
	}
}
?>