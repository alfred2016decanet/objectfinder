<?php
class Css{
	var $fichiers;
	
	static $instance;
	
	function __construct($admin=false){
		self::$instance=$this;
	}
	
	// La méthode singleton
    public static function getInstance(){
        if (!isset(self::$instance)) {
           //ERREUR : //
		   // self::$instance = new MysqlConnect("site");
        }

        return self::$instance;
    }
	
	function addFichiers($fic, $media='screen'){
		if(!empty($fic)){
			if(is_array($fic)){
				foreach($fic as $f){
					$this->fichiers[]=array('fichier'=>$f, 'media'=>$media);
				}
			}else{
				$this->fichiers[]=array('fichier'=>$fic, 'media'=>$media);
			}
		}
	}
	
	function getFichiers(){
		return $this->fichiers;
	}
	
	function getUnify() {
		global $_CONFIG;
		$css_ctn = '';
		foreach($this->fichiers as $f) {
			$css_ctn.=file_get_contents(ROOT.$f['fichier']);
		}
		if($_CONFIG['usr']['minifycss']==1)
			$css_ctn = $this->minify($css_ctn);
		
		if(!is_dir(ROOT.'/data/cache'))mkdir(ROOT.'/data/cache',0777);
		if(!is_dir(ROOT.'/data/cache/css'))mkdir(ROOT.'/data/cache/css/',0777);
		if(!file_exists(ROOT.'data/cache/css/'.md5($css_ctn).'.css')) {
			$fp = fopen(ROOT.'data/cache/css/'.md5($css_ctn).'.css', 'w');
			fwrite($fp, $css_ctn);
			fclose($fp);
		}
		return array(array('fichier'=>'data/cache/css/'.md5($css_ctn).'.css', 'media'=>'screen'));
	}
	
	public static function minify( $css ){
		/* remove comments */
		$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
		/* remove tabs, spaces, newlines, etc. */
		$css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
		return $css;
	}
}
?>