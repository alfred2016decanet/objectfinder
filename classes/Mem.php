<?php
	class Mem {
		private $memcache;
		var $token_session;
		public $donnees_session = array();
		
		public function __construct($token_session)
		{
			global $_CONFIG;
			$this->memcache = new Memcache;
			
			if(!is_array($_CONFIG['usr']['memcache_servers']))
				$_CONFIG['usr']['memcache_servers'] = json_decode($_CONFIG['usr']['memcache_servers']);
			if(count($_CONFIG['usr']['memcache_servers'])>0) {
			foreach($_CONFIG['usr']['memcache_servers'] as $s) {
				if(strlen($s->ip)>5 && intval($s->port)>0)
				$this->memcache->addServer($s->ip, $s->port);
				}
			}
			$this->token_session = $token_session;
	
			$r = $this->memcache->get($this->token_session);
			if ( $r !== false )
			{
				$this->donnees_session = $r;
			}
		}
	
		public function lire($cle)
		{
			if(is_array($cle)) {
				$res = array();
				foreach($cle as $c) {
					if(isset($this->donnees_session[$c]))
					{
						$res[$c]=$this->donnees_session[$c];
					}
					else
					{
						$res[$c]=null;
					}
				}
				return $res;
			} else {
				if(isset($this->donnees_session[$cle]))
				{
					return $this->donnees_session[$cle];
				}
				else
				{
					return null;
				}
			}
		}
	
		public function ecrire($cle, $valeur)
		{
			$this->donnees_session[$cle] = $valeur;
		}
		
		public function supprime($cle) {
			$this->donnees_session[$cle]=null;
			unset($this->donnees_session[$cle]);
		}
		
		public function deconnecter()
		{
			$this->memcache->delete($this->token_session);
			$this->memcache->close();
		}
	
		public function __destruct()
		{
			
			$this->memcache->set($this->token_session, $this->donnees_session);
			$this->memcache->close();
		}
	}
?>