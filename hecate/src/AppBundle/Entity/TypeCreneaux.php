<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * TypeCreneaux
 *
 * @ORM\Table(name="type_creneaux")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeCreneauxRepository")
 */
class TypeCreneaux
{
    public function __construct()
    {
        $this->creneaux = new ArrayCollection();
    }
    public function __tostring()
    {
        return $this->getName();
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Creneaux", mappedBy="type")
     */
     private $creneaux;
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
     * Set name
     *
     * @param string $name
     *
     * @return TypeCreneaux
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
