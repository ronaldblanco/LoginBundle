<?php
    
namespace Acme\Bundle\LoginBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

use Acme\Bundle\LoginBundle\Lib\ldap_aut;


class Ldaplogin extends UserInterface
{
	
	protected $mildapserver='ds.etecsa.cu';
	protected $bdn = "ou=people, DC=etecsa, DC=cu";
	protected $role = 'ROLE_USER';
	protected $info = NULL;
	protected $mipass = NULL;
	
	public function getinfo()
	{
		return $this->info;
	}
		
	public function getldapserver()
	{
		return $this->mildapserver;
	}
	
	public function getbdn()
	{
		return $this->bdn;
	}
	
	public function getldap_aut()
	{
		return new ldap_aut($this->getldapserver(),389);
	}
	
	public function getldapsearch(UserInterface $user)
	{
		$mildap = $this->getldap_aut();
		$mildap->setbasedn($this->getbdn());
		if($mildap->ldapconnect())$info = $mildap->ldapsearch($user->getUsername());
		if (is_array($info) && $info[0]["uid"][0] == $user->getUsername()){
			if($mildap->autenticar($info[0]["dn"], $user->getPassword())){
				$this->info = $info; 
				$this->mipass = $user->getPassword();
				return TRUE;
			}
			
		} 
		else return FALSE;
		$mildap->close();
	}
	
	function __construct(UserInterface $user){
		$this->getldapsearch($user);
	}
	
	//##################
	//userinterface
		public function getUsername()
		{
			$info = $this->getinfo();
			if ($info) return $info[0]["uid"][0];
			else return FALSE;
		}
		
		public function getPassword()
		{
			if ($this->mipass) return $this->mipass;
			else return FALSE;
		}
		
		public function getSalt()
		{
			return FALSE;
		}
		
		public function getRoles()
		{
			return array('ROLE_USER');
		}
		
		public function eraseCredentials()
		{
			return FALSE;
		}
		
		public function equals(UserInterface $user)
		{
			return TRUE;
			/*$info = $this->getinfo();
			if ($info) {
				$mildap = $this->getldap_aut();
				$mildap->setbasedn($this->getbdn());
				$mildap->ldapconnect();
				if($mildap->autenticar($info[0]["dn"], $user->getPassword())) return TRUE;
				else return FALSE;
			}*/
		}
		//fin userinterface
		//############################
}
	