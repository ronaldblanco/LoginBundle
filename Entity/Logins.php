<?php

namespace Acme\Bundle\LoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
// DON'T forget this use statement!!!
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
//use Symfony\Component\Validator\Constraints\NotBlank;
//use Symfony\Component\Validator\Constraints\NotNull;
//use Symfony\Component\Validator\Constraints\True;
//use Symfony\Component\Validator\Constraints\ip;
//use Symfony\Component\Validator\Constraints\Choice;


/**
 * Acme\Bundle\LoginBundle\Entity\Logins
 * @UniqueEntity("login")
 * @ORM\Entity(repositoryclass = "Acme\Bundle\LoginBundle\Entity\Loginsrepository")
 */
class Logins
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $login
	 * @Assert\NotBlank()
	 * @Assert\NotNull()
     */
    private $login;

    /**
     * @var string $descripcion
     */
    private $descripcion;

    /**
     * @var boolean $act
	 * Assert\True()
     */
    private $act = TRUE;

    /**
     * @var boolean $adm
	 * 
     */
    private $adm = FALSE;

    /**
     * @var integer $loock
	 * @Assert\NotBlank()
	 * @Assert\NotNull()
     */
    private $loock = 1;

    /**
     * @var string $iphost
	 * @Assert\NotBlank()
	 * @Assert\NotNull()
     */
    private $iphost = '*';

    /**
     * @var string $theme
	 * Assert\Choice("yea","theme")
     */
    private $theme;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set act
     *
     * @param boolean $act
     */
    public function setAct($act)
    {
        $this->act = $act;
    }

    /**
     * Get act
     *
     * @return boolean 
     */
    public function getAct()
    {
        return $this->act;
    }

    /**
     * Set adm
     *
     * @param boolean $adm
     */
    public function setAdm($adm)
    {
        $this->adm = $adm;
    }

    /**
     * Get adm
     *
     * @return boolean 
     */
    public function getAdm()
    {
        return $this->adm;
    }

    /**
     * Set loock
     *
     * @param integer $loock
     */
    public function setLoock($loock)
    {
        $this->loock = $loock;
    }

    /**
     * Get loock
     *
     * @return integer 
     */
    public function getLoock()
    {
        return $this->loock;
    }

    /**
     * Set iphost
     *
     * @param string $iphost
     */
    public function setIphost($iphost)
    {
        $this->iphost = $iphost;
    }

    /**
     * Get iphost
     *
     * @return string 
     */
    public function getIphost()
    {
        return $this->iphost;
    }

    /**
     * Set theme
     *
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }
	
	
	
}