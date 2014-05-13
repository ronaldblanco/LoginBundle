<?php

namespace Acme\Bundle\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultMainController extends Controller
{
	//variables
    protected $mikey = "*6f5fa1734d5859aceb6c76beecad8add4c8265fc*";
	
	//######################################################################################
	public function getkey()
	{
		return $this->mikey;
	}
    
	//######################################################################################
	public function miencrypt($string = '', $key = NULL)
	{
		if (!$key) $key = $this->getkey();
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
	}
	public function midecrypt($codestring = '', $key = NULL)
	{
		if (!$key) $key = $this->getkey();
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($codestring), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	}
	
	//######################################################################################
	//######################################################################################
	public function sessionok()
	{
		$session = $this->getRequest()->getSession();
		if ($session->get('token') && $session->get('login') && is_array(unserialize($session->get('token')))) return TRUE;
		else return FALSE;
	}
	public function acceso()
	{
		if ($this->sessionok()) {
			$session = $this->getRequest()->getSession();
			$mitoken = unserialize($session->get('token'));
			if (md5($this->container->get('request')->getClientIp()) == $mitoken['ip'] && sha1($session->get('login')).$mitoken['ip'] == $mitoken[sha1('loginx')] && $this->midecrypt($mitoken[md5('id')]) == session_id().$mitoken[sha1('loginx')] && md5(session_id()).md5(date('l jS \of F Y h A')) == $mitoken[md5('idx')]) return true;
			else $session->set('login', NULL); $session->set('token', NULL); return FALSE; if ($session->get('savehost')) $session->set('savehost', NULL); if ($session->get('savepass')) $session->set('savepass', NULL);
		} else return FALSE ;
	}
	public function admacceso()
	{
		$session = $this->getRequest()->getSession();
		$mitoken = unserialize($session->get('token'));
		if ($this->acceso() && $this->midecrypt($mitoken[md5('rolex')]) == md5('ROLE_ADMIN').$this->midecrypt($mitoken[md5('pass')])) return true;
		else {
			if (!$this->acceso()) $session->set('login', NULL); $session->set('token', NULL); if ($session->get('savehost')) $session->set('savehost', NULL); if ($session->get('savepass')) $session->set('savepass', NULL);
			return FALSE;
		}
	}
	//########################################################################################
}
