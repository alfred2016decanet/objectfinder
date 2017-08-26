<?php //utf8 é//
/*
* Gestion des habillages
*/
class Habillage extends Entite{
	var $dbtable='habillage';

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
		$requete->join='';
		
		$tab_wheres= array();
		
		//FROM//
		$requete->from = 'FROM habillage';
		
		//JOIN//
		$requete->join.='';
		
		//WHERE//
		if($this->id!='')$tab_wheres[] = "habillage.habillage_id = '".$this->id."'";
				
		//PARAMS//
		if($this->mode!='admin')$tab_wheres[]="habillage.habillage_date_debut<='".date('Y-m-d H:i:s')."' AND habillage.habillage_date_fin>='".date('Y-m-d H:i:s')."'";
		
		if(!empty($this->where))$tab_wheres[]=$this->where;
		
		if(!empty($tab_wheres)){
			//A AMELIORER (AND/OR) ,//
			$requete->where.='WHERE '.implode(' AND ', $tab_wheres);
		}
		
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
		
		$select = 'SELECT DISTINCT habillage.habillage_id AS id, habillage.habillage_fichier AS fichier, habillage.habillage_fichieren AS fichieren,
		habillage.habillage_date_debut AS date_debut, habillage.habillage_date_fin AS date_fin, habillage.habillage_couleur AS couleur, habillage.habillage_fixe AS fixe';

		$groupby='';

		if($this->tri!='')$orderby = " ORDER BY ".$this->tri." ".$this->sens;
		else $orderby = ' ORDER BY habillage_id ASC ';

		if($this->limit!='')$limit = "LIMIT ".$this->limit;

		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
		// echo htmlentities($sql);
		$this->liste=$this->base->query_array($sql);
		
		if($this->liste){
			foreach($this->liste as &$habillage){
				if(!empty($habillage['fichier']))$habillage['fichier_type']=Tools::getFileExtension($habillage['fichier']);
			}
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
		
		$select = "SELECT (COUNT(DISTINCT habillage.habillage_id)) AS nbre";
		
		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
		
		$result=$this->base->query($sql);
		
		$row=$this->base->fetch_assoc($result);
		
		return $row['nbre'];
	}
	
	
	/***************GESTION****************/
	public function Create(){	
		$sql="INSERT INTO habillage SET habillage_fichier=''";
		// echo "$sql<br />";
		$res=$this->base->query($sql);
		if(!is_dir(ROOT.'/data/img/habillages'))mkdir(ROOT.'/data/img/habillages/',0777);
		return $this->base->derniere_entree();
	}
	
	
}
?>