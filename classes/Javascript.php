<?php
class Javascript{
	var $fichiers;
	var $scripts;
	
	static $instance;
	
	function __construct($admin=false){
		self::$instance=$this;
		
		$this->scripts=array();
	}
	
	// La méthode singleton
    public static function getInstance() {
        if (!isset(self::$instance)) {
           //ERREUR : //
		   //self::$instance = new MysqlConnect("site");
        }

        return self::$instance;
    }
	
	function addFichiers($fic){
		if(!empty($fic)){
			if(is_array($fic)){
				foreach($fic as $f){$this->fichiers[]=$f;}
			}else{
				$this->fichiers[]=$fic;
			}
		}
	}
	
	/*
	* renvoi des fichiers dans la pile
	*/
	function getFichiers(){
		return $this->fichiers;
	}
	
	function getUnify() {
		global $_CONFIG;
		$js_ctn = '';
		foreach($this->fichiers as $f) {
			if($_CONFIG['usr']['minifyjs']==1)
				$js_ctn.=JSMin::minify(file_get_contents(ROOT.$f))."\n";
			else
				$js_ctn.=file_get_contents(ROOT.$f);
		}
		if(!is_dir(ROOT.'/data/cache'))mkdir(ROOT.'/data/cache',0777);
		if(!is_dir(ROOT.'/data/cache/js'))mkdir(ROOT.'/data/cache/js/',0777);
		if(!file_exists(ROOT.'data/cache/js/'.md5($js_ctn).'.js')) {
			$fp = fopen(ROOT.'data/cache/js/'.md5($js_ctn).'.js', 'w');
			fwrite($fp, $js_ctn);
			fclose($fp);
		}
		return array('data/cache/js/'.md5($js_ctn).'.js');
	}
	
	/*
	* renvoi des fichiers "internes "dans la pile
	*/
	function getFichiersInternes(){
		$return=array();
		foreach($this->fichiers as $js){
			if(strpos($js, 'http://')===false)$return[]=$js;
		}
		return $return;
	}
	
	/*
	* renvoi des fichiers "externes "dans la pile
	*/
	function getFichiersExternes(){
		$return=array();
		foreach($this->fichiers as $js){
			if(strpos($js, 'http://')!==false)$return[]=$js;
		}
		return $return;
	}
	
	function addScript($script){
		$this->scripts[]="$script";
	}
	
	function getScripts(){
		if($this->scripts)return implode(";\r\n", $this->scripts);
		else return null;
	}
}
?>