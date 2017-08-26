<?php
	class Session {		
		public function __construct()
		{
				session_start();
		}

		public function lire($cle)
		{
			if(isset($_SESSION[$cle]))
			{
				return $_SESSION[$cle];
			}
			else
			{
				return null;
			}
		}

		public function ecrire($cle, $valeur)
		{
				$_SESSION[$cle] = $valeur;
		}

		public function sessionKeyExist($cle){
			if(isset($_SESSION[$cle]))
				return TRUE;
			return FALSE;
		}

		public function deconnecter()
		{
			unset($_SESSION);
			session_destroy();
		}
	}
?>