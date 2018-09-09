<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Profil", inversedBy="users")
     */
    private $profile;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="author")
     */
    private $messages;
    /**
     * @ORM\ManyToMany(targetEntity="Creneaux", inversedBy="users", cascade={"persist"})
     */
    private $creneaux;
    /**
     * @ORM\Column(name="crenTake", type="integer", nullable=true)
     */
     private $crenTake;
     /**
      * @ORM\Column(name="atCount", type="boolean")
      */
      private $atCount;

    public function __construct()
    {
        parent::__construct();

        $this->messages = new ArrayCollection();
        $this->creneaux = new ArrayCollection();
        // your own logic
    }
    public function addCreneaux(Creneaux $creneaux)
    {

        $this->creneaux[] = $creneaux;
    }
    public function removeCreneaux(Creneaux $creneaux)
    {

        $this->creneaux->removeElement($creneaux);
    }

    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Profile
     *
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set the value of Profile
     *
     * @param mixed profile
     *
     * @return self
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get the value of Messages
     *
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set the value of Messages
     *
     * @param mixed messages
     *
     * @return self
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get the value of Creneaux
     *
     * @return mixed
     */
    public function getCreneaux()
    {
        return $this->creneaux;
    }

    /**
     * Set the value of Creneaux
     *
     * @param mixed creneaux
     *
     * @return self
     */
    public function setCreneaux($creneaux)
    {
        $this->creneaux = $creneaux;

        return $this;
    }


    /**
     * Get the value of Cren Take
     *
     * @return mixed
     */
    public function getCrenTake()
    {
        return $this->crenTake;
    }

    /**
     * Set the value of Cren Take
     *
     * @param mixed crenTake
     *
     * @return self
     */
    public function setCrenTake($crenTake)
    {
        $this->crenTake = $crenTake;

        return $this;
    }

    /**
     * Get the value of At Count
     *
     * @return mixed
     */
    public function getAtCount()
    {
        return $this->atCount;
    }

    /**
     * Set the value of At Count
     *
     * @param mixed atCount
     *
     * @return self
     */
    public function setAtCount($atCount)
    {
        $this->atCount = $atCount;

        return $this;
    }


}
