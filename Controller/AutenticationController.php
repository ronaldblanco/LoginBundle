<?php

namespace Acme\Bundle\LoginBundle\Controller;

use Acme\Bundle\LoginBundle\Controller\DefaultMainController;

use Acme\Bundle\LoginBundle\Lib\ldap_aut;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
//entidad de usuarios de acceso
use Acme\LoginBundle\Entity\Logins;

//use Symfony\Component\Serializer\Encoder\JsonEncoder;

//###############################

//###############################

class AutenticationController extends DefaultMainController
{
    
    public function indexAction($data = array('title'=> 'Autenticacion'))
    {
    	return $this->render('AcmeLoginBundle:Autentication:index.html.twig', $data);
    }
	//####################################################################################
	public function mycheckAction($data = array('title'=> 'Autenticacion'))
	{
		//session
		$session = $this->getRequest()->getSession();
		
		$local = FALSE;
		$ldapup = FALSE;
		$aut = FALSE;
		$mildapserver='ds.etecsa.cu';
		$bdn = "ou=people, DC=etecsa, DC=cu";
		$role = 'ROLE_USER';
		$maxloock = 4;
		$loock = 1;
		$idlogin = NULL;
		$clientip = $this->container->get('request')->getClientIp();
		
		//Tomando datos del formulario
		$request = Request::createFromGlobals();
		$user=$request->request->get('_username', 'Ronald');
		$pass=$request->request->get('_password', 'ronaldpass');
		
		//iniciando usuario que ya se encuentra en el sistema
		if ($session->get('login') && $session->get('login') == $user && $this->acceso()){
			$this->get('session')->setFlash('info', 'El usuario '.$user.' ya se encuentra autenticado en la aplicación!');
			return $this->redirect($this->generateUrl('myloginok'));
		}
		
		//***************************************************************************
		//Tomando datos de tabla local (acceso local)
		$em = $this->getDoctrine()->getEntityManager();
		//$entities = $em->getRepository('AcmeRonaldBundle:Logins')->findAll();
		$entity = $em->getRepository('AcmeRonaldBundle:Logins')->findOneBylogin($user);
		//var_dump($entities);die();
        //foreach ($entities as $entity) {
        	//var_dump($entity->getLogin());die();
        	if ($entity->getLogin() == $user && $entity->getAct() == TRUE && $entity->getLoock() < $maxloock && ($entity->getIphost() == $clientip || $entity->getIphost() == '*' || ($clientip == '::1' && $entity->getIphost() == 'localhost'))) {
        		$local = TRUE;
				$loock = $entity->getLoock();
				$idlogin = $entity->getId();
				//var_dump($loock);
				if ($entity->getAdm() == TRUE) $role = 'ROLE_ADMIN';
			} else {$this->get('session')->setFlash('error', 'Su usuario no tiene acceso local o este está desactivado o bloqueado!');}
       // }
		//***************************************************************************
		//Buscando en ldap
		if ($local == TRUE) {
			
			$ldap_aut = new ldap_aut($mildapserver,389);
			$ldap_aut->setbasedn($bdn);
			if($ldap_aut->ldapconnect())$info = $ldap_aut->ldapsearch($user);
 			if (is_array($info) && $info[0]["uid"][0] == $user) {
			 	$ldapup = TRUE;
			 } else {
		 		$this->get('session')->setFlash('error', 'El usuario no se encontró en el ldap espesificado aunque tiene acceso local!');
		 		$ldap_aut->close();
		 	}
		}
		//***************************************************************************	
		//Autenticando contra ldap
		if ($local == TRUE && $ldapup == TRUE) {
			if($ldap_aut->autenticar($info[0]["dn"], $pass)){
				$aut=TRUE;
				//reiniciar el loock del usuario
				$entity = $em->getRepository('AcmeLoginBundle:Logins')->find($idlogin);
				$entity->setLoock(1);
				$em->persist($entity);
            	$em->flush();
 				
				$mitoken = serialize(array(md5('id')=> $this->miencrypt(session_id().sha1($user).md5($clientip)), md5('idx')=> md5(session_id()).md5(date('l jS \of F Y h A')), sha1('loginx') => sha1($user).md5($clientip), md5('rolex') => $this->miencrypt(md5($role).sha1($pass)), md5('pass') => $this->miencrypt(sha1($pass)), 'ip'=> md5($clientip)));
				$session->set('token', $mitoken);
				$session->set('login', $user);
				$this->get('session')->setFlash('salida', 'Autenticacion correcta!');
				$this->get('session')->setFlash('error', NULL);
				return $this->redirect($this->generateUrl('myloginok'));
				
			}else{
				
				$this->get('session')->setFlash('error', 'El usuario tiene acceso local y se encuentra en el servidor ldap especificado pero no fué posible autenticar! Revise la contraseña!');
				
			}
			$ldap_aut->close();
		}
		//************************************************************************************
		//Si falla la autenticación
		if (($local == FALSE || $ldapup == FALSE || $aut == FALSE) && $idlogin){
			$entity = $em->getRepository('AcmeLoginBundle:Logins')->find($idlogin);
        	$entity->setLoock($loock + 1);
			$em->persist($entity);
            $em->flush();
		}
		
		return $this->redirect($this->generateUrl('mylogin'));
	}
	//####################################################################################
	public function loginokAction($data = array('title'=> 'Autenticacion'))
	{
		if ($this->acceso()){		
			$session = $this->getRequest()->getSession();
			return $this->render('AcmeLoginBundle:Autentication:loginok.html.twig', $data);
		}else return $this->render('AcmeLoginBundle:Autentication:error.html.twig', $data);
	}
	//#####################################################################################
	public function mygooutAction()
	{
		$session = $this->getRequest()->getSession();
		$session->set('login', NULL);
		$session->set('token', NULL);
		if ($session->get('savehost')) $session->set('savehost', NULL);
		if ($session->get('savepass')) $session->set('savepass', NULL);
		return $this->redirect($this->generateUrl('mylogin'));
	}

	//######################################################################################
	//######################################################################################
	
	
	
}
