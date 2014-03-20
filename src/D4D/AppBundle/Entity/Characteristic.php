<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Characteristic
 */
class Characteristic
{
    /**
     * @var integer
     */
    private $characteristicid;

    /**
     * @var string
     */
    private $characteristicname;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get characteristicid
     *
     * @return integer 
     */
    public function getCharacteristicid()
    {
        return $this->characteristicid;
    }

    /**
     * Set characteristicname
     *
     * @param string $characteristicname
     * @return Characteristic
     */
    public function setCharacteristicname($characteristicname)
    {
        $this->characteristicname = $characteristicname;

        return $this;
    }

    /**
     * Get characteristicname
     *
     * @return string 
     */
    public function getCharacteristicname()
    {
        return $this->characteristicname;
    }

    /**
     * Add userid
     *
     * @param \D4D\AppBundle\Entity\Users $userid
     * @return Characteristic
     */
    public function addUserid(\D4D\AppBundle\Entity\Users $userid)
    {
        $this->userid[] = $userid;

        return $this;
    }

    /**
     * Remove userid
     *
     * @param \D4D\AppBundle\Entity\Users $userid
     */
    public function removeUserid(\D4D\AppBundle\Entity\Users $userid)
    {
        $this->userid->removeElement($userid);
    }

    /**
     * Get userid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserid()
    {
        return $this->userid;
    }
}
