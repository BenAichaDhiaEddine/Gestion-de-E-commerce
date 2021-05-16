<?php

class functions
{
	public function cnx()
	{
		global $link;
		if (!$link) {
			$link = mysqli_connect('localhost', 'root', '', 'demo');
			if (mysqli_connect_errno()) {
				printf("Échec de la connexion : %s\r", mysqli_connect_error());
				exit();
			}
		}
		return $link;
	}
	//----------------- update objet -----------------------------------------------
	public function update($sql)
	{
		if (mysqli_query($this->cnx(), $sql)) {
			return true;
		}
	}
	//----------------- Selectione list selon conditions ---------------------------------------
	public function get_list($sql)
	{
		$tab = [];
		$req = mysqli_query($this->cnx(), $sql);
		while ($res = mysqli_fetch_array($req)) {
			$tab[] = $res;
		}
		return $tab;
	}
	//----------------- Selectione objet par id -----------------------------------------------
	public function get_one($sql)
	{
		$req = mysqli_query($this->cnx(), $sql);
		$res = mysqli_fetch_assoc($req);
		if ($req) {
			return $res;
		} else {
			return false;
		}
	}
	//----------------- Calculer nombre des objets ---------------------------------------------
	public function get_count($sql)
	{
		$req = mysqli_query($this->cnx(), $sql);
		$nb  = mysqli_num_rows($req);
		return $nb;
	}
	//----------------- Supprimer une objet selon conditions  ---------------------------------
	public function all_in_one($sql)
	{
		$req = mysqli_query($this->cnx(), $sql);
		if ($req) {
			return true;
		} else {
			return false;
		}
	}
	//----------------- Erreur ---------------------------------------------------------------
	public function Erreur()
	{
		$req = mysqli_error($this->cnx());
		if ($req) {
			return true;
		} else {
			return false;
		}
	}
	//----------------- Pour obtenir key de base 64 ---------------------------------------
	var $key;
	public function keyED($txt)
	{
		$encrypt_key = md5($this->key);
		$ctr = 0;
		$tmp = "";
		for ($i = 0; $i < strlen($txt); $i++) {
			if ($ctr == strlen($encrypt_key))
				$ctr = 0;
			$tmp .= substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1);
			$ctr++;
		}
		return $tmp;
	}
	//----------------- Encrypter l'id en base 64 ---------------------------------------
	public function devit_encrypt($txt)
	{
		srand((float)microtime() * 1000000);
		$encrypt_key = md5(rand(0, 32000));
		$ctr = 0;
		$tmp = "";
		for ($i = 0; $i < strlen($txt); $i++) {
			if ($ctr == strlen($encrypt_key)) $ctr = 0;
			$tmp .= substr($encrypt_key, $ctr, 1) .
				(substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1));
			$ctr++;
		}
		return base64_encode($this->keyED($tmp));
	}
	//----------------- Decrypter l'id en base 64 ---------------------------------------
	public function devit_decrypt($txt)
	{
		$txt = $this->keyED(base64_decode($txt));
		$tmp = "";
		for ($i = 0; $i < strlen($txt); $i++) {
			$md5 = substr($txt, $i, 1);
			$i++;
			$tmp .= (substr($txt, $i, 1) ^ $md5);
		}
		return $tmp;
	}
	//--------------- test si login in pour 10sec ---------------------------------------
	public function isLoginSessionExpired()
	{
		$login_session_duration = time(); // 20 sec // 60*60*24*7 --> 7jours
		if (isset($_SESSION['loggedin_time']) and isset($_SESSION["id_droppex"])) {
			if (((time() - $_SESSION['loggedin_time']) > $login_session_duration)) {
				return true;
			}
		}
		return false;
	}
}
