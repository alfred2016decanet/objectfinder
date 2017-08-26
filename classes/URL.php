<?php //utf8 é//
/*
*
*/

class URL extends Entite{
	var $dbtable='url';

	public function __construct($id_lang=null){
		$this->base = MySQL::getInstance();
		$this->default_langid = $id_lang;
		$this->lang_fields = array('name', 'url');
		$this->have_table_lang = 1;
	}
	
	public function setId($id){
		$this->id=intval($id);
	}
	
	public function setLang($lang){
		$this->lang=$lang;
	}
	
	public function initRequete(){
		$requete = new stdClass();
		$requete->join = '';
		$tab_wheres= array();		
		//FROM//
		$requete->from = 'FROM '.$this->dbtable.' AS t';
				
		//WHERE//
		if($this->id!='')$tab_wheres[] = "t.id_url = ".$this->id;			
		if(!empty($this->where))
			$tab_wheres[]=$this->where;
		if($this->have_table_lang)
			if($this->default_langid)
			{
				$requete->join.=' LEFT JOIN '.$this->dbtable.'_lang tl ON (t.id_url=tl.id_url)';
				$tab_wheres[] = 'tl.id_lang='.$this->default_langid;
			}
		if(!empty($tab_wheres))
			$requete->where.='WHERE '.implode(' AND ', $tab_wheres);		
		return $requete;
	}
	
	/*
	* Récupération des entrées correspondant aux critères de recherche
	* 
	* @return array (simple si id, id_IWC ou ean indiqué, sinon multi-entrées)
	*/
	public function Recherche(){
		$requete=$this->initRequete();	
		$from=$requete->from;
		$join=$requete->join;
		$where=$requete->where;
		$limit='';
		$offset='';
		$order_by='';
		$select = 'SELECT DISTINCT t.*';
		$groupby='';
		if($this->tri!='')
			$orderby = " ORDER BY ".$this->tri." ".$this->sens;
		else 
			$orderby = " ORDER BY t.page ASC ";
		
		if($this->limit!='')
			$limit = "LIMIT ".$this->limit;
		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
		//echo htmlentities($sql); die();
		$this->liste=$this->base->query_array($sql);
		
		if($this->liste)
		{
			$this->regenerateFields('id_url');
			//SI CIBLÉ PAR ID, ON A FORCEMENT QU'UNE ENTREE -> RETURN LIGNE SEULE//
			if(count($this->liste)==1 && ($this->id!='')){
				return $this->liste[0];
			}else{
				return $this->liste;
			}
		}
	}
	
	/*
	* Nombre d'entrées correpondant aux critères de recherche en cours
	* 
	* @return int
	*/
	public function getTotal(){
		$requete=$this->initRequete();
		$from=$requete->from;
		$join=$requete->join;
		$where=$requete->where;
		$select = "SELECT (COUNT(DISTINCT t.id_url)) AS nbre";
		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
		$result=$this->base->query($sql);	
		$row=$this->base->fetch_assoc($result);
		return $row['nbre'];
	}
	
	/***************GESTION****************/
	public function Create(){	
		$sql="INSERT INTO {$this->dbtable} (date_add, date_upd) VALUES('".date('Y-m-d')."', '".date('Y-m-d')."')";
        $res=$this->base->query($sql);
		$id = $this->base->derniere_entree();
		return $id;
	}
	
	 public function Update($updates, $where,$table=null, $fieldprefix = ''){
		 parent::Update($updates, $where,$table, $fieldprefix);
		 
		 if($this->have_table_lang)
		 {
			 $langues = Langues::getLangues(1);
			 $this->delete(array('id_url' =>$this->id), "{$this->dbtable}_lang");
			 foreach ($langues as $lang)
			 {
				 $recdata = Tools::getPOST('lang_'.$lang['id_lang'].'_');
				 $recdata['id_lang'] = $lang['id_lang'];
				 $recdata['id_url'] = $this->id;
				 parent::InsertData($recdata, "{$this->dbtable}_lang");
			 }
		 }
    }
	
	public function getURL($lang = 1, $nom = ''){
		$sql = "SELECT url_url AS url, url_nom AS nom, url_lang AS lang FROM url WHERE 1";
		if($lang != '')$sql .= ' AND url_lang = "'.$lang.'"';
		if($nom != '')$sql .= '  AND url_nom = "'.$nom.'"';
		$sql .= " ORDER BY url_nom ASC";
		$contenus = $this->base->query_array($sql);
		return $contenus;
	}
	
	public function pageUrl($page, $iso_code)
	{
		$id_lang = Langues::getIdLang($iso_code);
		
		if($id_lang)
		{
			$db = MySQL::getInstance();
			$sql = "SELECT name FROM url
			INNER JOIN url_lang ON(url.id_url = url_lang.id_url)
			WHERE url_lang.id_lang='$id_lang' AND page='$page' LIMIT 1";
			$result = $db->query($sql);	
			$row = $db->fetch_assoc($result);
			$pagef = $row['name'];
			if($pagef)
				return '/'.$iso_code.'/'.Tools::nom_web($pagef);
			else
				return '/'.$iso_code.'/'.Tools::nom_web($page);
		}
		else {
			return '/'.$iso_code.'/'.Tools::nom_web($page);
		}
		
	}
	
	public static function getPageByRewriteName($nom = ''){
		$db = MySQL::getInstance();
		$sql = "SELECT page FROM url
			INNER JOIN url_lang ON(url.id_url = url_lang.id_url)
			WHERE url_lang.url='$nom' LIMIT 1";
		$result = $db->query($sql);	
		$row = $db->fetch_assoc($result);
		return $row['page'];
	}
	
	public static function getPageBaniere($nom = ''){
		$db = MySQL::getInstance();
		$sql = "SELECT baniere FROM url
			INNER JOIN url_lang ON(url.id_url = url_lang.id_url)
			WHERE url_lang.url='$nom' LIMIT 1";
		$result = $db->query($sql);	
		$row = $db->fetch_assoc($result);
		return $row['baniere'];
	}
	
	public static function getPageByID($id){
		$db = MySQL::getInstance();
		$sql = "SELECT page FROM url
			INNER JOIN url_lang ON(url.id_url = url_lang.id_url)
			WHERE url.id_url='$id' LIMIT 1";
		$result = $db->query($sql);	
		$row = $db->fetch_assoc($result);
		return $row['page'];
	}
	
	public function setURL($updates, $nom, $lang){
		if(strlen($nom)==0) {
			$sql = 'INSERT INTO url SET url_lang = "'.addslashes($updates['url_lang']).'",  url_nom = "'.addslashes($updates['url_nom']).'", ';
		}
		else $sql = 'UPDATE url SET ';
	
		$sql .= ' url_url = "'.addslashes($updates['url_url']).'"';
		if($nom != '' AND $lang != '')$sql .= ' WHERE url_nom = "'.$nom.'" AND url_lang = "'.$lang.'"';
		$res=$this->base->query($sql);
	}
	
	public function delURL($nom){
		$sql = 'DELETE FROM url WHERE url_nom = "'.$nom.'"';
		$res=$this->base->query($sql);
	}

}
?>