<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Param
 *
 * @ORM\Table(name="param")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParamRepository")
 */
class Param
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="name", type="string")
     */
     private $name;
     /**
      * @ORM\Column(name="valParam" , type="integer")
      */
     private $valParam;

    /**
     * Get the value of Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Get the value of Name
     *
     * @return int
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param int name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Val Param
     *
     * @return mixed
     */
    public function getValParam()
    {
        return $this->valParam;
    }

    /**
     * Set the value of Val Param
     *
     * @param mixed valParam
     *
     * @return self
     */
    public function setValParam($valParam)
    {
        $this->valParam = $valParam;

        return $this;
    }

}
