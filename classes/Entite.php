<?php

//utf8 é//

class Entite {

    public $base;
    public $tri;
    public $sens;
    public $mode;
    public $dbtable;
    public $cur_total;
    public $have_table_lang = 0;
    public $default_langid = null;
    public $lang_fields = array();
    private $id;
    public $selectfield = '*'; 
    private $primary_key;
    private $join = '';
    //langue : 'fr' par défaut//
    public $langue = 'fr';
    public $liste;

    public function __set($key, $val) {
        $this->{$key} = $val;
    }

    public function __get($key) {
        return $this->{$key};
    }

    /**
      mode="" ou "admin"
     * */
    function setMode($mode) {
        $this->mode = $mode;
    }

    /**
      LANGUE
     * */
    function setLangue($langue) {
        $this->langue = Tools::escape($langue);
    }

    /**
      ORDER BY
     * */
    function setTri($tri) {
        $this->tri = Tools::escape($tri);
    }

    public function setId($id){
            $this->id=$id;
    }
    
    public function setFields($fields = '*'){
		$this->selectfield = $fields;
	}
    
    function setSens($sens) {
        $this->sens = $sens;
    }

    /*
     */

    function setRecherche($rech) {
        $this->recherche = Tools::escape($rech);
    }

    /*
     */

    public function setTypeRecherche($rech) {
        $this->type_recherche = Tools::escape($rech);
    }

    /** WHERE * */
    function setWhere($where) {
        $this->where = $where;
    }

    /** JOIN * */
    function setJoin($join) {
        $this->join = $join;
    }

    /* function setSens($sens){
      $this->sens = mysql_escape_string($sens);
      } */

    /**
      GROUP BY SQL
     * */
    function setGroupBy($groupby) {
        $this->groupby = Tools::escape($groupby);
    }

    /**
      LIMIT SQL
     * */
    function setLimit($limit) {
        $this->limit = Tools::escape($limit);
    }

    public function getId() {
        return $this->id;
    }

    /**
      retourne les différents statuts possibles pour les contenus du site
     * */
    public static function getStatuts() {
        $tab = array(
            '0' => 'hors ligne',
            '1' => 'actif',
            '2' => 'à valider'
        );

        return $tab;
    }

    /**
     * Mise à jour par insertion générique sur la table nom_lang
     * @param type $updates
     * @param type $table
     */
    public function UpdateLang($updates, $table = null) {

        $SETS = array();
        foreach ($updates as $champ => $value) {
            $SETS[] = "$champ='" . addslashes($value) . "'";
        }
        $SET = implode(', ', $SETS);

        $sql = "INSERT INTO `" . ($table ? $table : $this->dbtable) . "_lang` SET $SET";
        //echo $sql; die();
        $result = $this->base->query($sql);
    }

    /**
     * suppression générique sur la table nom_lang
     * @param type $where
     * @param type $table
     */
    public function DeleteLang($where, $table = null) {
        $WHERES = array();
        foreach ($where as $champ => $value) {
            $WHERES[] = "$champ='" . addslashes($value) . "'";
        }
        $WHERE = 'WHERE ' . implode(' AND ', $WHERES);
        $sql = "DELETE FROM `" . ($table ? $table : $this->dbtable) . "_lang` $WHERE";
        $result = $this->base->query($sql);
    }

    /**
     * Mise à jour générique des tables
     * @param type $updates
     * @param type $where
     * @param type $table
     */
    public function Update($updates, $where, $table = null, $fieldprefix = '') {
        if (!empty($where)) {
            $SETS = array();

            foreach ($updates as $champ => $value) {
                $SETS[] = $fieldprefix . $champ . "='" . addslashes($value) . "'";
            }

            $SET = implode(', ', $SETS);

            $WHERES = array();

            foreach ($where as $champ => $value) {

                $WHERES[] = $fieldprefix . $champ . "='" . addslashes($value) . "'";
            }

            $WHERE = 'WHERE ' . implode(' AND ', $WHERES);

            $sql = "UPDATE `" . ($table ? $table : $this->dbtable) . "` SET $SET $WHERE";
//            print_r($sql); die();
            return $this->base->query($sql);
        }
    }

    /**
     * suppression générique des tables
     * @param type $where
     * @param type $table
     */
    public function delete($where, $table = null) {
        $WHERES = array();
        foreach ($where as $champ => $value) {
            $WHERES[] = "$champ='" . addslashes($value) . "'";
        }
        $WHERE = 'WHERE ' . implode(' AND ', $WHERES);

        $sql = "DELETE FROM `" . ($table ? $table : $this->dbtable) . "` $WHERE";
//        die(var_dump($sql));
        return $this->base->query($sql);
    }

    /**
     * suppression par champ drapeau 'deleted'
     * @param type $where
     * @param type $table
     */
    public function flagDelete($where, $table = null) {
        $WHERES = array();
        $table = $table ? $table : $this->dbtable;
        if (!MySQL::is_row_in_table("deleted", $table) and ! MySQL::is_row_in_table($table . "_deleted", $table)) {
            return null;
        }

        foreach ($where as $champ => $value) {
            $WHERES[] = "$champ='" . addslashes($value) . "'";
        }
        $WHERE = 'WHERE ' . implode(' AND ', $WHERES);

        // $sql = "DELETE FROM ".($table?$table:$this->dbtable)." $WHERE";
        if (MySQL::is_row_in_table($table . "_deleted", $table))
            $sql = "UPDATE `" . ($table ? $table : $this->dbtable) . "` SET " . $table . "_deleted = 1 $WHERE";
        else
            $sql = "UPDATE `" . ($table ? $table : $this->dbtable) . "` SET `deleted` = 1 $WHERE";

        return $this->base->query($sql);
    }

    public function has_content($where, $table, $full_where = "") {
        $WHERES = array();
        foreach ($where as $champ => $value) {
            $WHERES[] = "$champ='" . addslashes($value) . "'";
        }
        // $WHERES[] = "deleted = 0";
        // $WHERES[] = $full_where;
        $WHERE = 'WHERE ' . implode(' AND ', $WHERES);

        $sql = "SELECT COUNT(id) AS nbre FROM " . $table . " " . $WHERE . $full_where;
        $result = $this->base->query($sql);
        $row = $this->base->fetch_assoc($result);
        return (int) $row['nbre'];
    }

//    public function getTotal() {
//        //die('bonjour');
//        $sql = "SELECT FOUND_ROWS() AS nbre";
//        $result = $this->base->query($sql);
//        $row = $this->base->fetch_assoc($result);
//        return (int) $row['nbre'];
//    }

    public function InsertData($insert, $table = null, $fieldprefix = '') {
        $SETS = array();
        foreach ($insert as $champ => $value) {
            $SETS[] = $fieldprefix . $champ . "='" . addslashes($value) . "'";
        }
        $SET = implode(', ', $SETS);
        $sql = "INSERT INTO `" . ($table ? $table : $this->dbtable) . "` SET $SET";
//      var_dump($sql); die();
        if ($this->base->query($sql))
            return $this->base->derniere_entree();
        return 0;
    }

    public function toggleActive($id, $cle = 'id', $champ='active') {
        $sql = "UPDATE {$this->dbtable} SET $champ=IF($champ=1, 0, 1) WHERE $cle=" . intval($id);
        $res = $this->base->query($sql);
        if ($res)
            return true;
        return false;
    }

    public function regenerateFields($cle) {
        if ($this->have_table_lang) {
            foreach ($this->liste as &$value) {
                $query = 'SELECT l.id_lang, ' . implode(', ', $this->lang_fields) . ' FROM ' . $this->dbtable . '_lang l 
					WHERE l.' . $cle . '="' . $value[$cle] . '"' . ($this->default_langid ? ' AND l.id_lang=' . $this->default_langid : '');
                $langfields = $this->base->query_array($query);
                if ($langfields) {
                    if ($this->default_langid) {
                        $value['id_lang'] = $this->default_langid;
                        foreach ($this->lang_fields as $field)
                            $value[$field] = $langfields[0][$field];
                    } else {
                        foreach ($langfields as $langfield) {
                            foreach ($this->lang_fields as $field)
                                $value[$field][$langfield['id_lang']] = $langfield[$field];
                        }
                    }
                }
            }
        }
    }

    public function initRequete(){
		$requete = new stdClass();
		$requete->join = $this->join;
		$tab_wheres= array();		
		$requete->from = 'FROM '.$this->dbtable.' AS t';
		if ($this->id != '')
            $tab_wheres[] = "t.{$this->primary_key} = '".$this->id."'";			
		if (!empty($this->where))
			$tab_wheres[] = $this->where;
		if (!empty($tab_wheres))
			$requete->where .= 'WHERE '.implode(' AND ', $tab_wheres);		
		return $requete;
	}
    
    public function getTotal(){
		$requete = $this->initRequete();
		$from = $requete->from;
		$join = $requete->join;
		$where = $requete->where;
		$select = "SELECT (COUNT(DISTINCT t.{$this->primary_key})) AS nbre";
		$sql = "$select $from $join $where $groupby $orderby $offset;";
//                die(var_dump($where));
		$result = $this->base->query($sql);	
		$row = $this->base->fetch_assoc($result);
		return $row['nbre'];
	}
    
    public function Recherche()
    {
		$requete = $this->initRequete();	
		$from = $requete->from;
		$join = $requete->join;
		$where = $requete->where;
		$limit = '';
		$offset = '';
		$order_by = '';
		$select = 'SELECT DISTINCT '.$this->selectfield;
		$groupby = '';
		if ($this->tri != '')
			$orderby = " ORDER BY ".$this->tri." ".$this->sens;
		
		if ($this->limit != '')
			$limit = "LIMIT ".$this->limit;
		$sql = "$select $from $join $where $groupby $orderby $limit $offset;";
//                var_dump($this->dbtable);
//                if($this->dbtable == 'point_livraison')
//                {
//                    var_dump($sql); die('bonjour');
//                }
		//echo htmlentities($sql); die();
		$this->liste = $this->base->query_array($sql);
		
		if ($this->liste) {
			//SI CIBLÉ PAR ID, ON A FORCEMENT QU'UNE ENTREE -> RETURN LIGNE SEULE//
			if (count($this->liste) == 1 && ($this->id != '')) {
				return $this->liste[0];
			} else {
				return $this->liste;
			}
		}      
    }
}

?>