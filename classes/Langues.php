<?php //utf8 é//
/*
* Gestion des Catégories
*/
class Langues extends Entite{
	var $dbtable='lang';
	public function __construct($id_lang = null){
		$this->base = MySQL::getInstance();
		if($id_lang)
			$this->setLangue ($id_lang);
	}	
	public function setId($id){
		$this->id=intval($id);
	}		
	/*
	* Initialise la requête SQL suivant las paramètres indiqués (id, cible, ...)
	* Appellé par Recherche() et getTotal()
	*
	* @return object (from, join, where)
	*/
	public function initRequete(){
		$requete = new stdClass();
		$requete->join = '';
		$tab_wheres= array();		
		//FROM//
		$requete->from = 'FROM '.$this->dbtable.' AS l';		
		//JOIN//
		//WHERE//
		if($this->id!='')$tab_wheres[] = "l.id_lang = ".$this->id;			
		if(!empty($this->where))$tab_wheres[]=$this->where;	
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
		$select = 'SELECT l.*';
		$groupby='';
		if($this->tri!='')$orderby = " ORDER BY ".$this->tri." ".$this->sens;
		else $orderby = ' ORDER BY l.id_lang ASC ';
		if($this->limit!='')$limit = "LIMIT ".$this->limit;
		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
		//echo htmlentities($sql); die();
		$this->liste=$this->base->query_array($sql);
		
		if($this->liste)
		{
			foreach ($this->liste as &$value) {
				if(file_exists(ROOT.'/data/img/l/'.$value['id_lang'].'.jpg'))
					$value['drapeau'] = '/data/img/l/'.$value['id_lang'].'.jpg';
				else
					$value['drapeau'] = '/data/img/l/none.jpg';
			}
			//SI CIBLÉ PAR ID, ON A FORCEMENT QU'UNE ENTREE -> RETURN LIGNE SEULE//
			if(count($this->liste)==1 && ($this->id!='')){
				return $this->liste[0];
			}else{
				return $this->liste;
			}
		}
	}
	
	public static function getIdLang($iso_code)
	{
		$db = MySQL::getInstance();
		$result = $db->query('
			SELECT `id_lang`
			FROM `lang`
			WHERE `iso_code` = "'.$iso_code.'"
			LIMIT 1');
		$row = $db->fetch_assoc($result);
		return $row['id_lang'];
		
	}
	
	public static function getIsoCode($id_lang)
	{
		$db = MySQL::getInstance();
		$result = $db->query('
			SELECT `iso_code`
			FROM `lang`
			WHERE `id_lang` = "'.$id_lang.'"
			LIMIT 1');
		$row = $db->fetch_assoc($result);
		return $row['iso_code'];
		
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
		$select = "SELECT (COUNT(DISTINCT l.id_lang)) AS nbre";
		$sql = "$select $from $join $where $groupby $orderby $offset;";
		$result=$this->base->query($sql);	
		$row=$this->base->fetch_assoc($result);
		return $row['nbre'];
	}
	
	/***************GESTION****************/
	public function Create(){	
		$sql = "INSERT INTO {$this->dbtable} (name) VALUES('new lang')";
        $res = $this->base->query($sql);
		$id = $this->base->derniere_entree();	
		return $id;
	}   
	
	public static function getLangues($active=null)
	{
		$lang = new Langues();
		if($active)
			$lang->setWhere('l.active='.$active);
		return $lang->Recherche();
	}
}
?>