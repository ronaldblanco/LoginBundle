<?php

/**
 * Clase para autenticar con un servidor ldap
 * Autor: Ronald Blanco Carrazana
 */
 
namespace Acme\Bundle\LoginBundle\Lib;

class ldap_aut {
	
	var $server;
	var $port;
	var $logindn;
	var $password;
	var $connect=NULL;
	var $bind =NULL;
	var $search = NULL;
	var $bdn = "ou=people, DC=etecsa, DC=cu";
	var $aut=NULL;
	var $error = NULL;
	var $info = NULL;
	
	function __construct($aserver='localhost', $aport=389, $alogindn='', $apassword='') {
		$this->server = $aserver;
		$this->port = $aport;
		$this->logindn = $alogindn;
		$this->password = $apassword;
		
	}
	
	public function setbasedn($abasedn="ou=people, DC=etecsa, DC=cu")
	{
		$this->bdn = $abasedn;
	}
	
	public function ldapconnect()
	{
		$this->connect = ldap_connect($this->server, $this->port);
		if ($this->connect) {
			ldap_set_option($this->connect, LDAP_OPT_PROTOCOL_VERSION,3);
			ldap_set_option($this->connect, LDAP_OPT_REFERRALS,0);
			return TRUE;
		} else {
			$this->error ='No se pudo conectar al servidor!';
			return FALSE;
		}
	}
	
	public function ldapsearch($alogin = null, $logeo = FALSE)
	{
		if ($alogin) {
			if (!$logeo) $this->bind = ldap_bind($this->connect,"","");
			if ($logeo) $this->bind = ldap_bind($this->connect, $this->logindn, $this->password);
			if ($this->bind) {
				$this->search = ldap_search($this->connect, $this->bdn, "(& (objectclass=person)(uid=".$alogin."))");
				if ($this->search) {
					$this->info = ldap_get_entries($this->connect, $this->search);
				} else {
					$this->error ='Hubo error en la busqueda dentro del ldap!';
				}
				
			} else {
				$this->error ='No se pudo establecer conexción con el servidor ldap!';
			}
			
		} else {
			$this->error ='No se ha declarado un usuario válido para la busqueda!';
		}
		if ($this->info) {
			return $this->info;
		} else {
			return $this->error;
		}
	}
	
	public function autenticar($alogindn='', $apassword='')
	{
			if(@ldap_bind($this->connect, $alogindn, $apassword)){
				$this->aut=TRUE;
				
			}else{
				$this->aut=FALSE;
					
			}
		return $this->aut;
	}
	
	public function get_last_aut()
	{
		if ($this->aut) return $this->aut;
		else return NULL;
	}
	
	public function get_last_error()
	{
		return $this->error;
	}
	
	public function get_last_search()
	{
		return $this->info;
	}
	
	public function close()
	{
		ldap_close($this->connect);
	}
}


/* End of file image_moo.php */
/* Location: .system/application/libraries/image_moo.php */