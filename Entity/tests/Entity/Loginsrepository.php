<?php

namespace Acme\Bundle\LoginBundle\Entity;

use Doctrine\ORM\EntityRepository;

//Para progamar mis propias busquedas
class Loginsrepository extends EntityRepository
{
	public function findOneBylogin($login)
	{
		return $this->getEntityManager()->createquery('SELECT p FROM Acme\Bundle\LoginBundle\Entity\Logins p WHERE p.login = '.$login)->getResult();
	}
	
}