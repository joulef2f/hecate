<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Creneaux
 *
 * @ORM\Table(name="creneaux")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CreneauxRepository")
 */
class Creneaux
{
    public function __construct()
    {

        $this->users = new ArrayCollection();
    }
    public function addUser(User $user)
    {
        $user->addCreneaux($this);
        $this->users[] = $user;
    }
    public function removeUser(User $user)
    {
        $this->user->removeElement($user);
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOf", type="datetime")
     */
    private $dateOf;

    /**
     * @ORM\ManyToOne(targetEntity="TypeCreneaux", inversedBy="creneaux")
     */
    private $type;
    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="creneaux", cascade={"persist"})
     */
    private $users;
     /**
      * @ORM\ManyToMany(targetEntity="Message", inversedBy="creneaux")
      */
    private $messages;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateOf
     *
     * @param \DateTime $dateOf
     *
     * @return Creneaux
     */
    public function setDateOf($dateOf)
    {
        $this->dateOf = $dateOf;

        return $this;
    }

    /**
     * Get dateOf
     *
     * @return \DateTime
     */
    public function getDateOf()
    {
        return $this->dateOf;
    }

    /**
     * Set the value of Id
     *
     * @param int id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Type
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of Type
     *
     * @param mixed type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of Users
     *
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set the value of Users
     *
     * @param mixed users
     *
     * @return self
     */
    public function setUsers($users)
    {
        $this->users = $users;

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

}
