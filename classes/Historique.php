<?php //utf8 é//
/*
* Gestion des habillages
*/
class Historique extends Entite{
	var $dbtable='historique';
    
	public function __construct(){
		$this->base = MySQL::getInstance();
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
		
		$requete->join = 'LEFT JOIN  `administrateur` ON (`administrateur`.`id` = `historique`.`id_user`)';
		$tab_wheres= array();		
		//FROM//
		$requete->from = 'FROM '.$this->dbtable;		
		//JOIN//
		$requete->join.='';		
		//WHERE//
		if($this->id!='')$tab_wheres[] = "{$this->dbtable}.id = ".$this->id;			
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
		$requete = $this->initRequete();
		
		$from = $requete->from;
		$join = $requete->join;
		$where = $requete->where;
		$limit = '';
		$offset = '';
		$order_by = '';	
		$select = 'SELECT `historique`.*, `administrateur`.`nom` as admin_nom , `administrateur`.`prenom` as admin_prenom ';

		$groupby = '';

		if($this->tri != '')
            $orderby = " ORDER BY ".$this->tri." ".$this->sens;
		else $orderby = ' ORDER BY id DESC ';

		if($this->limit != '')
            $limit = "LIMIT ".$this->limit;

		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
		// echo htmlentities($sql);
		$this->liste = $this->base->query_array($sql);
		
		if($this->liste){	
			//SI CIBLÉ PAR ID, ON A FORCEMENT QU'UNE ENTREE -> RETURN LIGNE SEULE//
			if(count($this->liste)==1 && ($this->id != ''))
				return $this->liste[0];
			else
				return $this->liste;
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
		
		$select = "SELECT (COUNT(DISTINCT {$this->dbtable}.id)) AS nbre";
		
		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
		
		$result=$this->base->query($sql);
		
		$row=$this->base->fetch_assoc($result);
		
		return $row['nbre'];
	}
}
?>